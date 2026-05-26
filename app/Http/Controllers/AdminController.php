<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Category;
use App\Models\Destination;
use App\Models\PaymentSetting;
use App\Models\Review;
use App\Models\Tour;
use App\Models\TourPackage;
use App\Models\TourPackageGroup;
use App\Models\TourPackageAddon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    // Dashboard
    public function dashboard()
    {
        $stats = [
            'total_tours' => Tour::count(),
            'total_bookings' => Booking::count(),
            'total_users' => User::count(),
            'total_reviews' => Review::count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'total_revenue' => Booking::where('status', 'confirmed')->sum('total_price'),
        ];

        $recent_bookings = Booking::with('tour', 'user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $recent_reviews = Review::with('tour')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_bookings', 'recent_reviews'));
    }

    // Tours
    public function toursIndex()
    {
        $tours = Tour::with(['category', 'destination'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('admin.tours.index', compact('tours'));
    }

    public function toursCreate()
    {
        $categories = Category::orderBy('sort_order')->get();
        $destinations = Destination::orderBy('name')->get();
        return view('admin.tours.create', compact('categories', 'destinations'));
    }

    public function toursStore(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:tours',
            'description' => 'required|string',
            'highlights' => 'nullable|string',
            'itinerary' => 'nullable|string',
            'inclusions' => 'nullable|string',
            'exclusions' => 'nullable|string',
            'duration' => 'required|string|max:50',
            'duration_type' => 'required|in:hours,days',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'image' => 'nullable|string|max:500',
            'image_file' => 'nullable|image|max:5120',

            // Multi media untuk gallery (foto & video)
            'gallery_files' => 'nullable|array',
            'gallery_files.*' => 'nullable|mimes:jpg,jpeg,png,webp,mp4,mov,webm|max:102400',
            'category_id' => 'required|exists:categories,id',
            'destination_id' => 'required|exists:destinations,id',
            'max_people' => 'required|integer|min:1',
            'min_people' => 'required|integer|min:1',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        // Handle file upload (cover)
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('tours', 'public');
            $validated['image'] = Storage::url($path);
        }

        // Handle gallery upload (foto/video)
        $galleryUrls = [];
        if ($request->filled('gallery') && is_array($request->input('gallery'))) {
            $galleryUrls = $request->input('gallery');
        }
        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $file) {
                if (!$file) continue;
                $path = $file->store('tours/gallery', 'public');
                $galleryUrls[] = Storage::url($path);
            }
        }
        if (count($galleryUrls)) {
            $validated['gallery'] = $galleryUrls;
        }


        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']);
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');

        Tour::create($validated);

        return redirect()->route('admin.tours.index')->with('success', 'Tour berhasil ditambahkan!');
    }

    public function toursEdit(Tour $tour)
    {
        $categories = Category::orderBy('sort_order')->get();
        $destinations = Destination::orderBy('name')->get();
        $packages = $tour->packages;
        return view('admin.tours.edit', compact('tour', 'categories', 'destinations', 'packages'));
    }

    public function toursUpdate(Request $request, Tour $tour)

    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:tours,slug,' . $tour->id,
            'description' => 'required|string',
            'highlights' => 'nullable|string',
            'itinerary' => 'nullable|string',
            'included' => 'nullable|string',
            'excluded' => 'nullable|string',
            'duration' => 'required|string|max:50',
            'duration_type' => 'required|in:hours,days',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'image' => 'nullable|string|max:500',
            'image_file' => 'nullable|image|max:5120',
            'gallery_files' => 'nullable|array',
            'gallery_files.*' => 'nullable|mimes:jpg,jpeg,png,webp,mp4,mov,webm|max:102400',
            'category_id' => 'required|exists:categories,id',
            'destination_id' => 'required|exists:destinations,id',
            'max_people' => 'required|integer|min:1',
            'min_people' => 'required|integer|min:1',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'itinerary_time.*' => 'nullable|string|max:100',
            'itinerary_desc.*' => 'nullable|string',
            'itinerary_photo.*' => 'nullable|image|max:3072',
        ]);

        // Handle file upload (cover)
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('tours', 'public');
            $validated['image'] = Storage::url($path);
        }

        // Handle gallery upload (foto/video)
        $galleryUrls = $tour->gallery ?? [];
        if (!is_array($galleryUrls)) {
            $galleryUrls = [];
        }
        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $file) {
                if (!$file) continue;
                $path = $file->store('tours/gallery', 'public');
                $galleryUrls[] = Storage::url($path);
            }
        }
        $validated['gallery'] = count($galleryUrls) ? $galleryUrls : null;


        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']);
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');

        // Build itinerary_items JSON
        $times = $request->input('itinerary_time', []);
        $descs = $request->input('itinerary_desc', []);
        $existingPhotos = $request->input('itinerary_photo_existing', []);
        $items = [];
        foreach ($times as $i => $time) {
            if (!trim($time) && !trim($descs[$i] ?? '')) continue;
            $photoUrl = $existingPhotos[$i] ?? null;
            if ($request->hasFile("itinerary_photo.$i")) {
                $path = $request->file("itinerary_photo.$i")->store('itinerary', 'public');
                $photoUrl = Storage::url($path);
            }
            $items[] = [
                'time' => trim($time),
                'desc' => trim($descs[$i] ?? ''),
                'photo' => $photoUrl,
            ];
        }

        // Itinerary items hanya berisi daftar item perjalanan
        $validated['itinerary_items'] = ['items' => $items];


        $tour->update($validated);

        return redirect()->route('admin.tours.edit', $tour)->with('success', 'Tour berhasil diperbarui!');
    }

    public function toursDestroy(Tour $tour)
    {
        $tour->delete();
        return redirect()->route('admin.tours.index')->with('success', 'Tour berhasil dihapus!');
    }

    public function toursToggleActive(Request $request, Tour $tour)
    {
        $tour->update([
            'is_active' => !$tour->is_active,
        ]);

        return redirect()->route('admin.tours.index')->with('success', 'Status tour diperbarui!');
    }


    // Tour Packages CRUD
    public function packagesIndex(Request $request)
    {
        $destinations = Destination::withCount('tours')->orderBy('name')->get();

        $query = Tour::with(['category', 'destination', 'packages.groups', 'packages.addons'])
            ->where('is_active', true)
            ->orderBy('destination_id');

        if ($request->filled('destination_id')) {
            $query->where('destination_id', $request->destination_id);
        }

        $tours = $query->get();
        $toursByDestination = $tours->groupBy(fn($t) => $t->destination->name);

        return view('admin.packages.index', compact('toursByDestination', 'destinations'));
    }

    public function packagesStore(Request $request, Tour $tour)
    {
        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'price'             => 'required|numeric|min:0',
            'original_price'    => 'nullable|numeric|min:0',
            'max_people'        => 'required|integer|min:1',
            'description'       => 'nullable|string|max:500',
            'sort_order'        => 'integer|min:0',
            'is_active'         => 'boolean',
            'travel_type'       => 'required|in:private,sharing,both',
            'sharing_price'     => 'nullable|numeric|min:0',
            'itinerary_time'    => 'nullable|array',
            'itinerary_time.*'  => 'nullable|string|max:100',
            'itinerary_desc'    => 'nullable|array',
            'itinerary_desc.*'  => 'nullable|string|max:500',
            'included'          => 'nullable|string|max:2000',
            'excluded'          => 'nullable|string|max:2000',
            'itinerary_photo'   => 'nullable|array',
            'itinerary_photo.*' => 'nullable|image|max:3072',
            'itinerary_photo_existing' => 'nullable|array',
        ]);

        $validated['tour_id'] = $tour->id;
        $validated['is_active'] = $request->boolean('is_active');

        // Build itinerary_items JSON for this package
        $times = $request->input('itinerary_time', []);
        $descs = $request->input('itinerary_desc', []);
        $existingPhotos = $request->input('itinerary_photo_existing', []);

        $items = [];
        foreach ($times as $i => $time) {
            if (!trim($time) && !trim($descs[$i] ?? '')) continue;


            $photoUrl = $existingPhotos[$i] ?? null;
            if ($request->hasFile("itinerary_photo.$i")) {
                $path = $request->file("itinerary_photo.$i")->store('itinerary', 'public');
                $photoUrl = '/storage/' . $path;
            }

            $items[] = [
                'time' => trim($time),
                'desc' => trim($descs[$i] ?? ''),
                'photo' => $photoUrl,
            ];
        }

        // Itinerary items hanya berisi daftar item perjalanan
        $validated['itinerary_items'] = ['items' => $items];

        TourPackage::create($validated);

        return redirect()->route('admin.packages.index')->with('success', 'Paket berhasil ditambahkan!');
    }


    public function packagesUpdate(Request $request, Tour $tour, TourPackage $package)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'price'          => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'max_people'     => 'required|integer|min:1',
            'description'    => 'nullable|string|max:500',
            'sort_order'     => 'nullable|integer|min:0',
            'is_active'      => 'nullable|boolean',
            'travel_type'    => 'required|in:private,sharing,both',
            'sharing_price'  => 'nullable|numeric|min:0',
            'itinerary_time' => 'nullable|array',
            'itinerary_time.*' => 'nullable|string|max:100',
            'itinerary_desc' => 'nullable|array',
            'itinerary_desc.*' => 'nullable|string|max:500',
            'included'       => 'nullable|string|max:2000',
            'excluded'       => 'nullable|string|max:2000',
            'itinerary_photo' => 'nullable|array',
            'itinerary_photo.*' => 'nullable|image|max:3072',
            'itinerary_photo_existing' => 'nullable|array',
        ]);

        $validated['is_active'] = $request->boolean('is_active', false);

        // Build itinerary_items JSON for this package
        $times = $request->input('itinerary_time', []);
        $descs = $request->input('itinerary_desc', []);
        $existingPhotos = $request->input('itinerary_photo_existing', []);


        $items = [];
        foreach ($times as $i => $time) {
            if (!trim($time) && !trim($descs[$i] ?? '')) continue;

            $photoUrl = $existingPhotos[$i] ?? null;
            if ($request->hasFile("itinerary_photo.$i")) {
                $path = $request->file("itinerary_photo.$i")->store('itinerary', 'public');
                $photoUrl = '/storage/' . $path;
            }

            $items[] = [
                'time' => trim($time),
                'desc' => trim($descs[$i] ?? ''),
                'photo' => $photoUrl,
            ];
        }

        // Itinerary items hanya berisi daftar item perjalanan
        $validated['itinerary_items'] = ['items' => $items];


        $package->update($validated);

        return redirect()->route('admin.packages.index')->with('success', 'Paket berhasil diperbarui!');
    }


    public function packagesDestroy(Tour $tour, TourPackage $package)
    {
        $package->delete();
        return redirect()->route('admin.packages.index')->with('success', 'Paket berhasil dihapus!');
    }

    // Package Groups (Private)
    public function groupsStore(Request $request, TourPackage $package)
    {
        $request->validate([
            'group_size'     => 'required|integer|min:1',
            'label'          => 'required|string|max:255',
            'price'          => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'sort_order'     => 'nullable|integer|min:0',
        ]);

        $package->groups()->create([
            'group_size'     => $request->group_size,
            'label'          => $request->label,
            'price'          => $request->price,
            'original_price' => $request->original_price,
            'sort_order'     => $request->sort_order ?? 0,
            'is_active'      => true,
        ]);

        return back()->with('success', 'Pilihan grup berhasil ditambahkan!');
    }

    public function groupsDestroy(TourPackage $package, TourPackageGroup $group)
    {
        $group->delete();
        return back()->with('success', 'Pilihan grup berhasil dihapus!');
    }

    public function groupsUpdate(Request $request, TourPackage $package, TourPackageGroup $group)
    {
        $request->validate([
            'group_size'     => 'required|integer|min:1',
            'label'          => 'required|string|max:255',
            'price'          => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
        ]);

        $group->update([
            'group_size'     => $request->group_size,
            'label'          => $request->label,
            'price'          => $request->price,
            'original_price' => $request->original_price,
        ]);

        return back()->with('success', 'Pilihan grup berhasil diperbarui!');
    }

    // Package Addons (Sharing)
    public function addonsStore(Request $request, TourPackage $package)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'price'       => 'required|numeric|min:0',
            'sort_order'  => 'nullable|integer|min:0',
        ]);

        $package->addons()->create([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'sort_order'  => $request->sort_order ?? 0,
            'is_active'   => true,
        ]);

        return back()->with('success', 'Add-on berhasil ditambahkan!');
    }

    public function addonsDestroy(TourPackage $package, TourPackageAddon $addon)
    {
        $addon->delete();
        return back()->with('success', 'Add-on berhasil dihapus!');
    }

    public function addonsUpdate(Request $request, TourPackage $package, TourPackageAddon $addon)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'price'       => 'required|numeric|min:0',
        ]);

        $addon->update([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
        ]);

        return back()->with('success', 'Add-on berhasil diperbarui!');
    }

    // Categories
    public function categoriesIndex()
    {
        $categories = Category::orderBy('sort_order')->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    public function categoriesStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories',
            'icon' => 'nullable|string|max:100',
            'image' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'sort_order' => 'integer|min:0',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);

        Category::create($validated);
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function categoriesUpdate(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
            'icon' => 'nullable|string|max:100',
            'image' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'sort_order' => 'integer|min:0',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);

        $category->update($validated);
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function categoriesDestroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus!');
    }

    // Destinations
    public function destinationsIndex()
    {
        $destinations = Destination::orderBy('name')->paginate(15);
        return view('admin.destinations.index', compact('destinations'));
    }

    public function destinationsStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:destinations',
            'image' => 'nullable|string|max:500',
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);

        Destination::create($validated);
        return redirect()->route('admin.destinations.index')->with('success', 'Destinasi berhasil ditambahkan!');
    }

    public function destinationsUpdate(Request $request, Destination $destination)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:destinations,slug,' . $destination->id,
            'image' => 'nullable|string|max:500',
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);

        $destination->update($validated);
        return redirect()->route('admin.destinations.index')->with('success', 'Destinasi berhasil diperbarui!');
    }

    public function destinationsDestroy(Destination $destination)
    {
        $destination->delete();
        return redirect()->route('admin.destinations.index')->with('success', 'Destinasi berhasil dihapus!');
    }

    // Bookings
public function bookingsIndex()
    {
        $bookings = Booking::with(['tour', 'user', 'package'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('admin.bookings.index', compact('bookings'));
    }

    public function bookingsShow(Booking $booking)
    {
        $booking->load(['tour', 'user', 'tour.category', 'tour.destination']);
        return view('admin.bookings.show', compact('booking'));
    }

    public function bookingsUpdateStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed',
        ]);

        $booking->update($validated);
        return redirect()->route('admin.bookings.index')->with('success', 'Status booking diperbarui!');
    }

public function bookingsDestroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('admin.bookings.index')->with('success', 'Booking berhasil dihapus!');
    }

    public function bookingsConfirmPayment(Booking $booking)
    {
        if (!$booking->payment_proof) {
            return redirect()->route('admin.bookings.index')->with('error', 'Tidak ada bukti pembayaran untuk booking ini.');
        }

        $booking->update([
            'status'               => 'confirmed',
            'payment_status'       => 'settlement',
            'payment_confirmed_at' => now(),
        ]);

        $emailSent = false;
        try {
            \Illuminate\Support\Facades\Mail::to($booking->contact_email)
                ->send(new \App\Mail\BookingConfirmed($booking));
            $emailSent = true;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Email konfirmasi gagal: ' . $e->getMessage());
        }

        $msg = 'Pembayaran booking #' . $booking->id . ' dikonfirmasi!';
        if ($emailSent) {
            $msg .= ' Email terkirim ke ' . $booking->contact_email;
        } else {
            $msg .= ' (Email gagal terkirim, cek konfigurasi mail)';
        }

        return redirect()->route('admin.bookings.index')->with('success', $msg);
    }

    // View Payment Proof
    public function bookingsViewProof(Booking $booking)
    {
        if (!$booking->payment_proof) {
            return redirect()->route('admin.bookings.index')->with('error', 'Tidak ada bukti pembayaran.');
        }

        return view('admin.bookings.proof', compact('booking'));
    }

    // Reviews
    public function reviewsIndex()
    {
        $reviews = Review::with('tour')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        $tours = Tour::orderBy('title')->get();
        return view('admin.reviews.index', compact('reviews', 'tours'));
    }

    public function reviewsStore(Request $request)
    {
        $validated = $request->validate([
            'tour_id' => 'required|exists:tours,id',
            'user_name' => 'required|string|max:255',
            'user_email' => 'nullable|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
            'reviewed_at' => 'nullable|date',
        ]);

        $validated['is_fake'] = true;
        $validated['reviewed_at'] = $validated['reviewed_at'] ?? now();

        Review::create($validated);

        // Recalculate tour rating
        $tour = Tour::find($validated['tour_id']);
        $tour->recalculateRating();

        return redirect()->route('admin.reviews.index')->with('success', 'Review berhasil ditambahkan!');
    }

    public function reviewsDestroy(Review $review)
    {
        $tour = $review->tour;
        $review->delete();
        $tour->recalculateRating();

        return redirect()->route('admin.reviews.index')->with('success', 'Review berhasil dihapus!');
    }

    // Fake Review Generator
    public function reviewsGenerateFake(Request $request)
    {
        $validated = $request->validate([
            'tour_id' => 'required|exists:tours,id',
            'count' => 'required|integer|min:1|max:50',
        ]);

        $tour = Tour::find($validated['tour_id']);
        $count = $validated['count'];

        $fakeNames = [
            'Budi Santoso', 'Ani Wijaya', 'Dewi Kusuma', 'Agus Pratama', 'Siti Rahayu',
            'Rudi Hartono', 'Maya Sari', 'Indra Gunawan', 'Rina Susanti', 'Eko Saputra',
            'Lina Tan', 'Fajar Nugroho', 'Yuni Astuti', 'Bayu Aditya', 'Nina Permata',
            'Adi Wibowo', 'Sari Melati', 'Hendra Setiawan', 'Diana Putri', 'Yoga Prasetya',
            'Rina Marlina', 'Doni Kurniawan', 'Mira Andini', 'Tono Sutrisno', 'Wulan Sari',
            'Irfan Hakim', 'Nadia Zahra', 'Reza Fahlevi', 'Amelia Rose', 'Kevin Tanjung',
            'Putri Ayu', 'Rizky Ramadhan', 'Sarah Amelia', 'Dimas Aditya', 'Citra Lestari',
            'Ahmad Fauzi', 'Jessica Tan', 'Andre Wijaya', 'Luna Maya', 'Fadli Rahman',
            'Melati Puspita', 'Gilang Ramadhan', 'Dina Amalia', 'Raka Pratama', 'Sasha Putri',
        ];

        $fakeComments = [
            'Pengalaman yang sangat menyenangkan! Guide sangat ramah dan profesional.',
            'Worth it banget dengan harga segini. Pemandangannya luar biasa indah.',
            'Aktivitas yang seru untuk keluarga. Anak-anak sangat menikmatinya.',
            'Pelayanan sangat memuaskan. Makanannya juga enak dan banyak.',
            'Recommended banget! Sudah 2x ikut tour ini dan tetap menyenangkan.',
            'Pemandu wisatanya sangat berpengalaman dan tahu banyak tentang sejarah.',
            'Transportasi nyaman, jadwal tepat waktu, tidak ada yang bisa dikeluhkan.',
            'Spot foto yang didatangi sangat Instagramable. Puas banget!',
            'Pengalaman yang tidak akan terlupakan. Terima kasih TripWay!',
            'Harga terjangkau dengan kualitas premium. Sangat direkomendasikan.',
            'Tour yang sangat terorganisir dengan baik. Semuanya lancar.',
            'Pemandangan sunset-nya sangat memukau. Romantis untuk pasangan.',
            'Aktivitas outdoor yang menyenangkan. Cocok untuk melepas penat.',
            'Staff sangat helpful dan perhatian. Membuat perjalanan nyaman.',
            'Makanan lokal yang disajikan sangat autentik dan lezat.',
            'Peralatan yang disediakan lengkap dan berkualitas baik.',
            'Pemandu lokalnya sangat friendly dan banyak cerita menarik.',
            'Tempat yang didatangi bersih dan terawat dengan baik.',
            'Pengalaman budaya yang sangat berkesan. Banyak ilmu baru.',
            'Perjalanan yang aman dan nyaman. Driver sangat berhati-hati.',
        ];

        $generated = 0;
        for ($i = 0; $i < $count; $i++) {
            $daysAgo = rand(1, 180);
            $reviewedAt = now()->subDays($daysAgo)->subHours(rand(0, 23));

            Review::create([
                'tour_id' => $tour->id,
                'user_name' => $fakeNames[array_rand($fakeNames)],
                'user_email' => strtolower(Str::slug($fakeNames[array_rand($fakeNames)], '.')) . '@email.com',
                'rating' => rand(4, 5),
                'comment' => $fakeComments[array_rand($fakeComments)],
                'is_fake' => true,
                'reviewed_at' => $reviewedAt,
                'created_at' => $reviewedAt,
                'updated_at' => $reviewedAt,
            ]);
            $generated++;
        }

        $tour->recalculateRating();

return redirect()->route('admin.reviews.index')
            ->with('success', "Berhasil generate {$generated} fake review untuk tour {$tour->title}!");
    }

    // Payment Settings
    public function paymentsIndex()
    {
        $payments = PaymentSetting::orderBy('sort_order')->get();
        return view('admin.payments.index', compact('payments'));
    }

    public function paymentsStore(Request $request)
    {
        $validated = $request->validate([
            'method' => 'required|string|max:50|unique:payment_settings',
            'name' => 'required|string|max:255',
            'account_number' => 'nullable|string|max:50',
            'account_name' => 'nullable|string|max:255',
            'image' => 'nullable|string|max:500',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        PaymentSetting::create($validated);
        return redirect()->route('admin.payments.index')->with('success', 'Metode pembayaran berhasil ditambahkan!');
    }

    public function paymentsUpdate(Request $request, PaymentSetting $payment)
    {
        $validated = $request->validate([
            'method' => 'required|string|max:50|unique:payment_settings,method,' . $payment->id,
            'name' => 'required|string|max:255',
            'account_number' => 'nullable|string|max:50',
            'account_name' => 'nullable|string|max:255',
            'image' => 'nullable|string|max:500',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $payment->update($validated);
        return redirect()->route('admin.payments.index')->with('success', 'Metode pembayaran berhasil diperbarui!');
    }

    public function paymentsDestroy(PaymentSetting $payment)
    {
        $payment->delete();
        return redirect()->route('admin.payments.index')->with('success', 'Metode pembayaran berhasil dihapus!');
    }

    public function paymentsToggle(PaymentSetting $payment)
    {
        $payment->update(['is_active' => !$payment->is_active]);
        return redirect()->route('admin.payments.index')->with('success', 'Status metode pembayaran diperbarui!');
    }

    public function testEmail(Request $request)
    {
        $request->validate(['test_email' => 'required|email']);

        try {
            \Illuminate\Support\Facades\Mail::raw(
                'Halo! Ini adalah email test dari TripWay. Konfigurasi email kamu berhasil! 🎉',
                function ($m) use ($request) {
                    $m->to($request->test_email)
                      ->subject('✅ Test Email TripWay - Berhasil!');
                }
            );
            return redirect()->route('admin.dashboard')->with('success', '✅ Email test berhasil dikirim ke ' . $request->test_email . '! Cek inbox kamu.');
        } catch (\Exception $e) {
            return redirect()->route('admin.dashboard')->with('error', '❌ Email gagal: ' . $e->getMessage());
        }
    }
}
