@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="page-header">
        <h1>Dashboard Admin</h1>
    </div>

    @if(session('success'))
    <div style="padding:12px 16px; background:#f0fdf4; border:1px solid #bbf7d0; border-radius:10px; color:#166534; font-size:13px; font-weight:600; margin-bottom:20px;">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div style="padding:12px 16px; background:#fef2f2; border:1px solid #fecaca; border-radius:10px; color:#991b1b; font-size:13px; font-weight:600; margin-bottom:20px;">
        <i class="fas fa-times-circle"></i> {{ session('error') }}
    </div>
    @endif

    <div class="stats-grid">
        <div class="stat-card">
            <div class="icon blue"><i class="fas fa-map-marked-alt"></i></div>
            <div class="label">Total Tour</div>
            <div class="value">{{ $stats['total_tours'] }}</div>
        </div>
        <div class="stat-card">
            <div class="icon orange"><i class="fas fa-calendar-check"></i></div>
            <div class="label">Total Booking</div>
            <div class="value">{{ $stats['total_bookings'] }}</div>
        </div>
        <div class="stat-card">
            <div class="icon green"><i class="fas fa-users"></i></div>
            <div class="label">Total User</div>
            <div class="value">{{ $stats['total_users'] }}</div>
        </div>
        <div class="stat-card">
            <div class="icon red"><i class="fas fa-star"></i></div>
            <div class="label">Total Review</div>
            <div class="value">{{ $stats['total_reviews'] }}</div>
        </div>
        <div class="stat-card">
            <div class="icon orange"><i class="fas fa-clock"></i></div>
            <div class="label">Booking Pending</div>
            <div class="value">{{ $stats['pending_bookings'] }}</div>
        </div>
        <div class="stat-card">
            <div class="icon green"><i class="fas fa-money-bill-wave"></i></div>
            <div class="label">Total Revenue (Confirmed)</div>
            <div class="value">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</div>
        </div>
    </div>

    <div class="two-columns">
        <div class="card">
            <div class="card-header">
                <h2>Booking Terbaru</h2>
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-secondary">Lihat Semua</a>
            </div>
            <div class="card-body">
                @if($recent_bookings->count() > 0)
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tour</th>
                                    <th>User</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recent_bookings as $booking)
                                <tr>
                                    <td>#{{ $booking->id }}</td>
                                    <td>{{ $booking->tour->title }}</td>
                                    <td>{{ $booking->user->name }}</td>
                                    <td>
                                        <span class="badge badge-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span>
                                    </td>
                                    <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p style="color: var(--text-light); text-align: center;">Belum ada booking.</p>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2>Review Terbaru</h2>
                <a href="{{ route('admin.reviews.index') }}" class="btn btn-sm btn-secondary">Lihat Semua</a>
            </div>
            <div class="card-body">
                @if($recent_reviews->count() > 0)
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Tour</th>
                                    <th>Nama</th>
                                    <th>Rating</th>
                                    <th>Tipe</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recent_reviews as $review)
                                <tr>
                                    <td>{{ Str::limit($review->tour->title, 30) }}</td>
                                    <td>{{ $review->user_name }}</td>
                                    <td>{{ $review->rating }}/5</td>
                                    <td>
                                        @if($review->is_fake)
                                            <span class="badge badge-fake">Fake</span>
                                        @else
                                            <span class="badge badge-active">Real</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p style="color: var(--text-light); text-align: center;">Belum ada review.</p>
                @endif
            </div>
        </div>
    </div>
@endsection

