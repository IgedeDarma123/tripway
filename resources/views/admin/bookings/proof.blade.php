@extends('layouts.admin')

@section('title', 'Bukti Pembayaran - Booking #' . $booking->id)

@section('content')
    <div class="page-header">
        <h1>Bukti Pembayaran</h1>
        <p>Booking #{{ $booking->id }} - {{ $booking->tour->title }}</p>
    </div>

    <div class="card">
        <div class="card-body">
            <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
                <h3 style="margin-bottom: 16px;">Detail Booking</h3>
                <table style="width: 100%;">
                    <tr>
                        <td style="padding: 8px 0; color: var(--text-light); width: 140px;">Tour</td>
                        <td style="padding: 8px 0; font-weight: 600;">{{ $booking->tour->title }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: var(--text-light);">Pemesan</td>
                        <td style="padding: 8px 0;">{{ $booking->user->name }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: var(--text-light);">Tanggal</td>
                        <td style="padding: 8px 0;">{{ $booking->travel_date->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: var(--text-light);">Total</td>
                        <td style="padding: 8px 0; font-weight: 700; font-size: 18px;">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: var(--text-light);">Status</td>
                        <td style="padding: 8px 0;">
                            <span class="badge badge-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span>
                        </td>
                    </tr>
                </table>
            </div>

            <div style="text-align: center; margin-bottom: 20px;">
                @php
                    $proofUrl = $booking->payment_proof;
                    // Jika disimpan sebagai path relatif (payment_proofs/xxx.jpg), tambah /storage/
                    if ($proofUrl && !str_starts_with($proofUrl, 'http') && !str_starts_with($proofUrl, '/storage')) {
                        $proofUrl = '/storage/' . $proofUrl;
                    }
                @endphp
                <img src="{{ $proofUrl }}" alt="Bukti Pembayaran"
                    style="max-width: 100%; max-height: 70vh; border-radius: 8px; border: 1px solid var(--border);"
                    onerror="this.style.display='none'; document.getElementById('img-error').style.display='block';">
                <div id="img-error" style="display:none; padding:20px; background:#fef2f2; border-radius:8px; color:#dc2626; font-size:13px;">
                    <i class="fas fa-exclamation-circle"></i> Gambar tidak dapat dimuat. Path: {{ $booking->payment_proof }}
                </div>
            </div>

            <div style="display: flex; gap: 12px; justify-content: center;">
                @if($booking->status != 'confirmed' && $booking->status != 'completed')
                    <form action="{{ route('admin.bookings.confirm-payment', $booking) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success btn-lg" onclick="return confirm('Konfirmasi pembayaran ini? Email akan dikirim ke user.')">
                            <i class="fas fa-check"></i> Konfirmasi Pembayaran
                        </button>
                    </form>
                    <form action="{{ route('admin.bookings.reject-payment', $booking) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-lg" onclick="return confirm('Tolak bukti ini? User akan diminta upload ulang.')">
                            <i class="fas fa-times"></i> Tolak Bukti
                        </button>
                    </form>
                @endif
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary btn-lg">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
@endsection
