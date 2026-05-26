@extends('layouts.admin')

@section('title', 'Booking')

@section('styles')
<style>
    .badge-warning  { background:#fff3e0; color:#f57c00; }
    .badge-secondary { background:#f1f5f9; color:#64748b; }
    .badge-info     { background:#e3f2fd; color:#1976d2; }
    .btn-info       { background:#0ea5e9; color:white; }
    .btn-info:hover { background:#0284c7; }
    .btn-success    { background:#22c55e; color:white; }
    .btn-success:hover { background:#16a34a; }
</style>
@endsection

@section('content')
    <div class="page-header">
        <h1>Kelola Booking</h1>
        <span style="font-size:13px; color:#64748b;">Total: {{ $bookings->total() }} booking</span>
    </div>

    @if(session('success'))
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tour & Paket</th>
                            <th>Pemesan</th>
                            <th>Tanggal Tour</th>
                            <th>Total</th>
                            <th>Bukti Bayar</th>
                            <th>Status</th>
                            <th style="min-width:140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                        <tr>
                            <td style="font-weight:700; color:#1B3A4B;">#{{ $booking->id }}</td>
                            <td>
                                <div style="font-weight:600; font-size:13px;">{{ Str::limit($booking->tour->title, 28) }}</div>
                                @if($booking->package)
                                <div style="font-size:11px; color:#1B3A4B; font-weight:600; margin-top:2px;">
                                    <i class="fas fa-box-open" style="margin-right:3px;"></i>{{ $booking->package->name }}
                                </div>
                                @endif
                                <div style="font-size:11px; color:#94a3b8; margin-top:2px;">
                                    <i class="fas fa-users" style="margin-right:3px;"></i>{{ $booking->num_persons }} orang
                                    &nbsp;·&nbsp;
                                    {{ ucfirst($booking->travel_type ?? '-') }}
                                </div>
                            </td>
                            <td>
                                <div style="font-size:13px; font-weight:600;">{{ $booking->user->name }}</div>
                                <div style="font-size:11px; color:#94a3b8;">{{ $booking->contact_phone }}</div>
                            </td>
                            <td style="font-size:13px;">{{ $booking->travel_date->format('d M Y') }}</td>
                            <td style="font-weight:700; font-size:13px;">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                            <td>
                                @if($booking->payment_status === 'pending_verification')
                                    <span class="badge badge-warning">
                                        <i class="fas fa-clock" style="margin-right:4px;"></i>Menunggu
                                    </span>
                                @elseif($booking->payment_status === 'settlement')
                                    <span class="badge badge-confirmed">
                                        <i class="fas fa-check" style="margin-right:4px;"></i>Lunas
                                    </span>
                                @elseif($booking->payment_status === 'deny')
                                    <span class="badge badge-cancelled">
                                        <i class="fas fa-times" style="margin-right:4px;"></i>Ditolak
                                    </span>
                                @elseif($booking->payment_proof)
                                    <span class="badge badge-info">
                                        <i class="fas fa-image" style="margin-right:4px;"></i>Ada Bukti
                                    </span>
                                @else
                                    <span class="badge badge-secondary">
                                        <i class="fas fa-minus" style="margin-right:4px;"></i>Belum Upload
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span>
                            </td>
                            <td>
                                <div style="display:flex; gap:4px; flex-wrap:wrap; align-items:center;">

                                    {{-- Lihat Detail --}}
                                    <a href="{{ route('admin.bookings.show', $booking) }}"
                                        class="btn btn-sm btn-secondary btn-icon" title="Lihat Detail"
                                        style="padding:4px 8px; font-size:12px;">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    @if($booking->payment_proof && !in_array($booking->status, ['confirmed','completed']))
                                        {{-- Lihat Bukti --}}
                                        <a href="{{ route('admin.bookings.proof', $booking) }}"
                                            class="btn btn-sm btn-info btn-icon" title="Lihat Bukti Transfer"
                                            style="padding:4px 8px; font-size:12px;">
                                            <i class="fas fa-image"></i>
                                        </a>

                                        {{-- Konfirmasi --}}
                                        <form action="{{ route('admin.bookings.confirm-payment', $booking) }}" method="POST" id="confirm-{{ $booking->id }}">
                                            @csrf
                                            <button type="button"
                                                class="btn btn-sm btn-success btn-icon" title="Konfirmasi Pembayaran"
                                                style="padding:4px 8px; font-size:12px;"
                                                onclick="confirmAdminDelete('confirm-{{ $booking->id }}', 'Konfirmasi pembayaran Booking #{{ $booking->id }}?')">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>

                                        {{-- Tolak --}}
                                        <form action="{{ route('admin.bookings.reject-payment', $booking) }}" method="POST" id="reject-{{ $booking->id }}">
                                            @csrf
                                            <button type="button"
                                                class="btn btn-sm btn-danger btn-icon" title="Tolak Bukti"
                                                style="padding:4px 8px; font-size:12px;"
                                                onclick="confirmAdminDelete('reject-{{ $booking->id }}', 'Tolak bukti pembayaran Booking #{{ $booking->id }}?')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Hapus --}}
                                    <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" id="del-booking-{{ $booking->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            class="btn btn-sm btn-danger btn-icon" title="Hapus Booking"
                                            style="padding:4px 8px; font-size:12px;"
                                            onclick="confirmAdminDelete('del-booking-{{ $booking->id }}', 'Booking #{{ $booking->id }} - {{ addslashes(Str::limit($booking->tour->title, 25)) }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" style="text-align:center; color:var(--text-light); padding:40px;">
                                <i class="fas fa-calendar-times" style="font-size:32px; margin-bottom:10px; display:block; opacity:0.3;"></i>
                                Belum ada booking.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div style="margin-top:16px;">
                {{ $bookings->links('vendor.pagination.admin') }}
            </div>
        </div>
    </div>
@endsection
