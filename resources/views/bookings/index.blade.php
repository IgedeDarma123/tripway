@extends('layouts.tripway')

@section('title', 'Pesanan Saya - TripWay')

@section('styles')
<style>
    .bookings-page {
        padding: 40px 0;
        max-width: 900px;
        margin: 0 auto;
    }
    .bookings-page h1 {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 8px;
    }
    .bookings-page > p {
        color: var(--text-light);
        margin-bottom: 32px;
    }
    .booking-card {
        background: white;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 24px;
        margin-bottom: 16px;
        display: grid;
        grid-template-columns: 120px 1fr auto;
        gap: 20px;
        align-items: center;
    }
    .booking-card img {
        width: 120px;
        height: 90px;
        object-fit: cover;
        border-radius: var(--radius-sm);
    }
    .booking-info h3 {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 6px;
        color: var(--text-dark);
    }
    .booking-info .meta {
        font-size: 13px;
        color: var(--text-light);
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
    }
    .booking-info .meta i { margin-right: 4px; }
    .booking-status {
        text-align: right;
    }
    .status-badge {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
    }
    .status-pending { background: #fff3cd; color: #856404; }
    .status-confirmed { background: #d4edda; color: #155724; }
    .status-completed { background: #cce5ff; color: #004085; }
    .status-cancelled { background: #f8d7da; color: #721c24; }
    .booking-status .price {
        font-size: 18px;
        font-weight: 700;
        margin-top: 8px;
    }
    .booking-actions {
        margin-top: 12px;
    }
    .booking-actions button {
        background: none;
        border: none;
        color: #dc3545;
        font-size: 13px;
        cursor: pointer;
        padding: 0;
    }
    .booking-actions button:hover { text-decoration: underline; }
    .empty-state {
        text-align: center;
        padding: 80px 20px;
    }
    .empty-state i {
        font-size: 64px;
        color: var(--border);
        margin-bottom: 20px;
    }
    .empty-state h3 {
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 8px;
    }
    .empty-state p {
        color: var(--text-light);
        margin-bottom: 24px;
    }
    @media (max-width: 640px) {
        .booking-card {
            grid-template-columns: 1fr;
        }
        .booking-card img { width: 100%; height: 180px; }
        .booking-status { text-align: left; }
    }
</style>
@endsection

@section('content')
    <div class="container">
        <div class="bookings-page">
            <h1>Pesanan Saya</h1>
            <p>Kelola dan lihat semua booking aktivitas Anda</p>

            @if(session('success'))
                <div style="background: #d4edda; color: #155724; padding: 12px 16px; border-radius: var(--radius-sm); margin-bottom: 20px; font-size: 14px;">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if($bookings->count() > 0)
                @foreach($bookings as $booking)
                <div class="booking-card">
                    <img src="{{ $booking->tour->image ?? 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=300' }}" alt="{{ $booking->tour->title }}">
                    <div class="booking-info">
                        <h3>{{ $booking->tour->title }}</h3>
                        <div class="meta">
                            <span><i class="far fa-calendar"></i> {{ $booking->travel_date->format('d M Y') }}</span>
                            <span><i class="fas fa-users"></i> {{ $booking->adults + $booking->children }} orang</span>
                            <span><i class="fas fa-map-marker-alt"></i> {{ $booking->tour->destination->name }}</span>
                        </div>
                        <div class="booking-actions">
                            @if($booking->status != 'completed' && $booking->status != 'cancelled')
                            <form action="{{ route('bookings.destroy', $booking) }}" method="POST" id="delete-form-{{ $booking->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete({{ $booking->id }}, '{{ addslashes($booking->tour->title) }}')">
                                    <i class="fas fa-times"></i> Batalkan Pesanan
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                        <div class="booking-status">
                        <span class="status-badge status-{{ $booking->status }}">{{ $booking->status }}</span>
                        @if($booking->payment_proof)
                            <div style="margin-top: 8px; font-size: 11px; color: #155724;">
                                <i class="fas fa-check"></i> Bukti uploaded
                            </div>
                        @endif
                        <div class="price">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
                        @if($booking->status === 'confirmed')
                            <a href="{{ route('bookings.ticket', $booking) }}" style="display:block; margin-top:8px; background:#1B3A4B; color:white; padding:6px 12px; border-radius:6px; font-size:12px; text-decoration:none; text-align:center;">
                                <i class="fas fa-file-pdf"></i> Download Tiket
                            </a>
                        @elseif(in_array($booking->status, ['pending']) && !$booking->payment_proof)
                            <a href="{{ route('payment.upload.show', $booking) }}" class="btn btn-sm" style="margin-top: 8px; background: var(--primary); color: white; padding: 6px 12px; border-radius: 4px; font-size: 12px;">
                                <i class="fas fa-upload"></i> Upload Bukti
                            </a>
                        @elseif($booking->payment_status === 'pending_verification')
                            <div style="margin-top:8px; font-size:11px; color:#92400e; background:#fffbeb; padding:5px 10px; border-radius:6px;">
                                <i class="fas fa-clock"></i> Menunggu verifikasi
                            </div>
                        @endif
                    </div>
                </div>
                @endforeach
            @else
                <div class="empty-state">
                    <i class="fas fa-calendar-times"></i>
                    <h3>Belum Ada Pesanan</h3>
                    <p>Anda belum membuat booking apapun. Jelajahi aktivitas seru di Bali dan pesan sekarang!</p>
                    <a href="{{ route('tours.index') }}" class="btn btn-primary">Jelajahi Tour</a>
                </div>
            @endif
        </div>
    </div>

{{-- Modal Konfirmasi Hapus --}}
<div id="delete-modal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:16px; padding:32px; max-width:400px; width:90%; text-align:center; box-shadow:0 20px 60px rgba(0,0,0,0.3);">
        <div style="width:60px; height:60px; background:#fef2f2; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
            <i class="fas fa-exclamation-triangle" style="font-size:24px; color:#dc2626;"></i>
        </div>
        <h3 style="font-size:18px; font-weight:800; color:#1e293b; margin:0 0 8px;">Batalkan Pesanan?</h3>
        <p style="font-size:13px; color:#64748b; margin:0 0 6px;">Anda akan membatalkan pesanan:</p>
        <p id="modal-tour-name" style="font-size:14px; font-weight:700; color:#1B3A4B; margin:0 0 20px;"></p>
        <p style="font-size:12px; color:#ef4444; margin:0 0 24px;">Tindakan ini tidak dapat dibatalkan.</p>
        <div style="display:flex; gap:10px; justify-content:center;">
            <button onclick="closeModal()" style="flex:1; padding:11px; border-radius:10px; border:1px solid #e2e8f0; background:white; color:#64748b; font-size:14px; font-weight:600; cursor:pointer;">
                Tidak, Kembali
            </button>
            <button onclick="submitDelete()" style="flex:1; padding:11px; border-radius:10px; border:none; background:#dc2626; color:white; font-size:14px; font-weight:700; cursor:pointer;">
                Ya, Batalkan
            </button>
        </div>
    </div>
</div>

<script>
    let deleteFormId = null;

    function confirmDelete(id, tourName) {
        deleteFormId = id;
        document.getElementById('modal-tour-name').textContent = tourName;
        const modal = document.getElementById('delete-modal');
        modal.style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('delete-modal').style.display = 'none';
        deleteFormId = null;
    }

    function submitDelete() {
        if (deleteFormId) {
            document.getElementById('delete-form-' + deleteFormId).submit();
        }
    }

    // Tutup modal jika klik di luar
    document.getElementById('delete-modal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });
</script>
@endsection
