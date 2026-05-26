@extends('layouts.tripway')

@section('title', 'Dashboard - TripWay')

@section('styles')
<style>
    .dashboard {
        padding: 40px 0;
    }
    .dashboard-header {
        margin-bottom: 32px;
    }
    .dashboard-header h1 {
        font-size: 28px;
        font-weight: 700;
    }
    .dashboard-header p {
        color: var(--text-light);
    }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 40px;
    }
    .stat-card {
        background: white;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 24px;
        text-align: center;
    }
    .stat-card i {
        font-size: 32px;
        color: var(--primary);
        margin-bottom: 12px;
    }
    .stat-card .number {
        font-size: 32px;
        font-weight: 700;
        color: var(--text-dark);
    }
    .stat-card .label {
        font-size: 14px;
        color: var(--text-light);
        margin-top: 4px;
    }
    .recent-bookings {
        background: white;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 32px;
        margin-top: 40px;
    }
    .recent-bookings h2 {
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .recent-bookings h2 a {
        font-size: 14px;
        font-weight: 500;
        color: var(--primary);
    }
    .booking-card-large {
        display: grid;
        grid-template-columns: 200px 1fr auto;
        gap: 24px;
        padding: 20px;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        margin-bottom: 16px;
        align-items: center;
        background: var(--bg-light);
    }
    .booking-card-large:last-child {
        margin-bottom: 0;
    }
    .booking-card-large img {
        width: 200px;
        height: 140px;
        object-fit: cover;
        border-radius: var(--radius);
    }
    .booking-details h3 {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 8px;
        color: var(--text-dark);
    }
    .booking-meta {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        margin-bottom: 12px;
    }
    .booking-meta span {
        font-size: 14px;
        color: var(--text-medium);
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .booking-meta i {
        color: var(--primary);
    }
    .booking-description {
        font-size: 13px;
        color: var(--text-light);
        line-height: 1.6;
    }
    .booking-info-right {
        text-align: right;
        min-width: 140px;
    }
    .booking-price {
        font-size: 22px;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 8px;
    }
    .booking-status {
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
    .empty-dashboard {
        text-align: center;
        padding: 60px 40px;
        color: var(--text-light);
    }
    .empty-dashboard i {
        font-size: 48px;
        margin-bottom: 16px;
        color: var(--border);
    }
    .empty-dashboard p {
        font-size: 16px;
        margin-bottom: 24px;
    }
    @media (max-width: 768px) {
        .stats-grid { grid-template-columns: 1fr; }
        .booking-card-large {
            grid-template-columns: 1fr;
            gap: 16px;
        }
        .booking-card-large img {
            width: 100%;
            height: 200px;
        }
        .booking-info-right {
            text-align: left;
        }
        .booking-meta {
            flex-direction: column;
            gap: 8px;
        }
    }
</style>
@endsection

@section('content')
    <div class="container">
        <div class="dashboard">
            <div class="dashboard-header">
                <h1>Selamat Datang, {{ Auth::user()->name }}!</h1>
                <p>Kelola aktivitas dan booking perjalanan Anda</p>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <i class="fas fa-calendar-check"></i>
                    <div class="number">{{ $bookings->count() }}</div>
                    <div class="label">Total Booking</div>
                </div>
                <div class="stat-card">
                    <i class="fas fa-hourglass-half"></i>
                    <div class="number">{{ $bookings->where('status', 'pending')->count() }}</div>
                    <div class="label">Menunggu Konfirmasi</div>
                </div>
                <div class="stat-card">
                    <i class="fas fa-check-circle"></i>
                    <div class="number">{{ $bookings->where('status', 'confirmed')->count() + $bookings->where('status', 'completed')->count() }}</div>
                    <div class="label">Selesai</div>
                </div>
            </div>

            <div class="recent-bookings">
                <h2>
                    Booking Terbaru
                    <a href="{{ route('bookings.index') }}">Lihat Semua <i class="fas fa-arrow-right"></i></a>
                </h2>
                @if($bookings->count() > 0)
                    @foreach($bookings as $booking)
                    <div class="booking-card-large">
                        <img src="{{ $booking->tour->image ?? 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=400' }}" alt="{{ $booking->tour->title }}">
                        <div class="booking-details">
                            <h3>{{ $booking->tour->title }}</h3>
                            <div class="booking-meta">
                                <span><i class="fas fa-calendar"></i> {{ $booking->travel_date->format('d M Y') }}</span>
                                <span><i class="fas fa-users"></i> {{ $booking->adults + $booking->children }} orang</span>
                                <span><i class="fas fa-map-marker-alt"></i> {{ $booking->tour->destination->name ?? 'Bali' }}</span>
                            </div>
                            <p class="booking-description">{{ $booking->tour->description ?? 'Nikmati pengalaman tak terlupakan bersama kami.' }}</p>
                        </div>
                        <div class="booking-info-right">
                            <div class="booking-price">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
                            <span class="booking-status status-{{ $booking->status }}">{{ $booking->status }}</span>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="empty-dashboard">
                        <i class="fas fa-suitcase-rolling"></i>
                        <p>Anda belum memiliki booking apapun.</p>
                        <a href="{{ route('tours.index') }}" class="btn btn-primary">Jelajahi Tour</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
