<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Tour;
use App\Models\TourPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\BookingConfirmation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $bookings = Booking::with('tour')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('bookings.index', compact('bookings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tour_id'          => 'required|exists:tours,id',
            'package_id'       => 'required|exists:tour_packages,id',
            'travel_type'      => 'required|in:private,sharing',
            'group_option_id'  => 'nullable|exists:tour_package_groups,id',
            'num_persons'      => 'nullable|integer|min:1',
            'addon_ids'        => 'nullable|array',
            'addon_ids.*'      => 'exists:tour_package_addons,id',
            'travel_date'      => 'required|date|after_or_equal:today',
            'contact_name'     => 'required|string|max:255',
            'contact_email'    => 'required|email|max:255',
            'contact_phone'    => ['required', 'regex:/^[0-9+\-\s()]{7,20}$/'],
            'special_requests' => 'nullable|string',
        ], [
            'tour_id.required'         => 'Tour tidak valid.',
            'package_id.required'      => 'Pilih jenis paket terlebih dahulu.',
            'travel_type.required'     => 'Pilih tipe perjalanan (Private/Sharing).',
            'group_option_id.required' => 'Pilih pilihan grup untuk perjalanan private.',
            'travel_date.required'     => 'Tanggal partisipasi wajib diisi.',
            'travel_date.after_or_equal' => 'Tanggal tidak boleh sebelum hari ini.',
            'contact_name.required'    => 'Nama lengkap wajib diisi.',
            'contact_email.required'   => 'Email wajib diisi.',
            'contact_email.email'      => 'Format email tidak valid.',
            'contact_phone.required'   => 'Nomor HP wajib diisi.',
            'contact_phone.regex'      => 'Nomor HP hanya boleh berisi angka, +, -, spasi, dan tanda kurung.',
        ]);

        $package = TourPackage::findOrFail($validated['package_id']);
        $travelType = $validated['travel_type'];
        $totalPrice = 0;
        $groupOptionId = null;
        $numPersons = 1;
        $addonIds = [];
        $addonPrice = 0;

        if ($travelType === 'private') {
            $group = $package->groups()->findOrFail($validated['group_option_id']);
            $groupOptionId = $group->id;
            $numPersons = $group->group_size;
            $totalPrice = $group->price;
        } else {
            $numPersons = max(1, (int) ($validated['num_persons'] ?? 1));
            $sharingPrice = $package->sharing_price > 0 ? $package->sharing_price : $package->price;
            $totalPrice = $sharingPrice * $numPersons;

            if (!empty($validated['addon_ids'])) {
                $addons = $package->addons()->whereIn('id', $validated['addon_ids'])->get();
                $addonIds = $addons->pluck('id')->toArray();
                $addonPrice = $addons->sum('price') * $numPersons;
                $totalPrice += $addonPrice;
            }
        }

        $booking = Booking::create([
            'user_id'          => Auth::id(),
            'tour_id'          => $validated['tour_id'],
            'package_id'       => $package->id,
            'package_type'     => $travelType,
            'travel_type'      => $travelType,
            'group_option_id'  => $groupOptionId,
            'num_persons'      => $numPersons,
            'addon_ids'        => $addonIds ?: null,
            'addon_price'      => $addonPrice,
            'quantity'         => $numPersons,
            'travel_date'      => $validated['travel_date'],
            'adults'           => $numPersons,
            'children'         => 0,
            'total_price'      => $totalPrice,
            'status'           => 'pending',
            'payment_status'   => 'pending',
            'contact_name'     => $validated['contact_name'],
            'contact_email'    => $validated['contact_email'],
            'contact_phone'    => $validated['contact_phone'],
            'special_requests' => $validated['special_requests'] ?? null,
        ]);

        if (config('midtrans.mock_enabled', true)) {
            app(\App\Services\MockPaymentService::class)->createSnapToken($booking);
        } else {
            app(\App\Services\MidtransService::class)->createSnapToken($booking);
        }

        // Kirim email konfirmasi
        try {
            Mail::to($booking->contact_email)->send(new BookingConfirmation($booking));
        } catch (\Exception $e) {
            // Email gagal tidak menghentikan proses booking
        }

        return redirect()->route('payment.order-detail', $booking)->with('success', 'Booking dibuat! Cek email Anda untuk detail pesanan.');
    }

    public function showOrderDetail(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) abort(403);
        $booking->load(['tour.category', 'tour.destination', 'package', 'groupOption']);
        return view('payments.order-detail', compact('booking'));
    }

    public function showPayment(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        if (!$booking->snap_token) {
            return redirect()->route('bookings.index')->with('error', 'Token pembayaran tidak valid.');
        }

        return view('payments.show', compact('booking'));
    }

    public function handleCallback(Request $request)
    {
        // Midtrans notification handler
        \App\Services\MidtransService::init();

        $notif = json_decode($request->getContent(), true);

        $orderId = $notif['order_id'];
        $booking = Booking::where('order_id', $orderId)->first();

        if ($booking) {
            $status = $notif['transaction_status'];
            $paymentType = $notif['payment_type'];
            $pdfUrl = $notif['pdf_url'] ?? null;

            $booking->update([
                'payment_status' => $status,
                'payment_type' => $paymentType,
                'pdf_url' => $pdfUrl,
            ]);

            if ($status == 'capture' || $status == 'settlement') {
                $booking->update(['status' => 'confirmed']);
            } elseif ($status == 'expire') {
                $booking->update(['status' => 'cancelled']);
            }
        }

        http_response_code(200);
        echo "OK"; // required response
    }

    public function downloadTicket(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) abort(403);
        if ($booking->status !== 'confirmed') {
            return redirect()->route('bookings.index')->with('error', 'Tiket hanya tersedia untuk booking yang sudah dikonfirmasi.');
        }
        $booking->load(['tour.destination', 'package', 'groupOption']);
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.booking-ticket', compact('booking'));
        $pdf->setPaper('A5', 'portrait');
        return $pdf->download('tiket-booking-' . $booking->id . '.pdf');
    }

public function destroy(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        $booking->delete();

        return redirect()->route('bookings.index')->with('success', 'Booking berhasil dibatalkan.');
    }

/**
     * Process Mock Payment (for testing without real Midtrans API)
     */
    public function processMockPayment(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) abort(403);

        $booking->update([
            'payment_type' => $request->input('payment_method', 'transfer'),
        ]);

        return redirect()->route('payment.upload.show', $booking)
            ->with('success', 'Metode pembayaran dipilih. Silakan upload bukti transfer Anda.');
    }

    /**
     * Show upload payment proof page
     */
    public function showUploadProof(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        if ($booking->payment_status === 'settlement') {
            return redirect()->route('bookings.index')->with('info', 'Pembayaran sudah dikonfirmasi.');
        }

        return view('payments.upload', compact('booking'));
    }

    /**
     * Handle payment proof upload
     */
    public function uploadPaymentProof(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        // Hanya boleh upload jika status pending atau ditolak (payment_status = deny)
        if (in_array($booking->payment_status, ['settlement', 'paid', 'pending_verification'])) {
            return redirect()->route('payment.upload.show', $booking)
                ->with('error', 'Bukti pembayaran sudah diupload dan sedang diverifikasi.');
        }

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $path = $request->file('payment_proof')->store('payment_proofs', 'public');

        $booking->update([
            'payment_proof'  => '/storage/' . $path,
            'payment_status' => 'pending_verification',
            'status'         => 'pending',
        ]);

        // Kirim notifikasi ke admin
        try {
            $adminEmail = config('mail.from.address', env('MAIL_FROM_ADDRESS'));
            Mail::to($adminEmail)->send(new \App\Mail\PaymentProofUploaded($booking));
        } catch (\Exception $e) {}

        return redirect()->route('payment.upload.show', $booking)
            ->with('success', 'Bukti pembayaran berhasil diupload! Admin akan memverifikasi dalam 1x24 jam.');
    }

    public function bookingsConfirmPayment(Booking $booking)
    {
        if (!$booking->payment_proof) {
            return redirect()->route('admin.bookings.index')->with('error', 'Tidak ada bukti pembayaran.');
        }

        $booking->update([
            'status'                => 'confirmed',
            'payment_status'        => 'settlement',
            'payment_confirmed_at'  => now(),
        ]);

        try {
            Mail::to($booking->contact_email)->send(new \App\Mail\BookingConfirmed($booking));
        } catch (\Exception $e) {}

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Pembayaran dikonfirmasi & email terkirim ke ' . $booking->contact_email);
    }

    public function bookingsRejectPayment(Booking $booking)
    {
        $booking->update([
            'status'         => 'pending',
            'payment_status' => 'deny',
            'payment_proof'  => null,
        ]);

        try {
            Mail::to($booking->contact_email)->send(new \App\Mail\BookingRejected($booking));
        } catch (\Exception $e) {}

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Bukti ditolak & email terkirim ke ' . $booking->contact_email . '. User dapat re-upload.');
    }

    public function bookingsViewProof(Booking $booking)
    {
        if (!$booking->payment_proof) {
            return redirect()->route('admin.bookings.index')->with('error', 'Tidak ada bukti pembayaran.');
        }
        return view('admin.bookings.proof', compact('booking'));
    }
}

