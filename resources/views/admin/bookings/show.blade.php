@extends('layouts.admin')

@section('title', 'Detail Booking #' . $booking->id)

@section('content')
    <div class="page-header">
        <h1>Detail Booking #{{ $booking->id }}</h1>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div style="display: grid; grid-template-columns: 1fr 340px; gap: 24px;">
        <!-- Main Content -->
        <div>
            <!-- Tour Info -->
            <div class="card">
                <div class="card-header">
                    <h3>Informasi Tour</h3>
                </div>
                <div class="card-body">
                    <img src="{{ $booking->tour->image ?? 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=800' }}" alt="{{ $booking->tour->title }}" style="width: 100%; height: 280px; object-fit: cover; border-radius: 8px; margin-bottom: 16px;">
                    <h2 style="font-size: 22px; margin-bottom: 12px;">{{ $booking->tour->title }}</h2>
                    <div style="display: flex; gap: 20px; flex-wrap: wrap; margin-bottom: 16px;">
                        <span style="color: var(--text-light);"><i class="fas fa-tag"></i> {{ $booking->tour->category->name ?? 'Tour' }}</span>
                        <span style="color: var(--text-light);"><i class="fas fa-map-marker-alt"></i> {{ $booking->tour->destination->name ?? 'Bali' }}</span>
                        <span style="color: var(--text-light);"><i class="fas fa-clock"></i> {{ $booking->tour->duration }} {{ $booking->tour->duration_type }}</span>
                    </div>
                    <p style="color: var(--text-medium); line-height: 1.7;">{{ $booking->tour->description }}</p>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="card" style="margin-top: 20px;">
                <div class="card-header">
                    <h3>Informasi Kontak</h3>
                </div>
                <div class="card-body">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div>
                            <label style="color: var(--text-light); font-size: 12px;">Nama Kontak</label>
                            <p style="font-weight: 600;">{{ $booking->contact_name ?? $booking->user->name }}</p>
                        </div>
                        <div>
                            <label style="color: var(--text-light); font-size: 12px;">Email</label>
                            <p style="font-weight: 600;">{{ $booking->contact_email ?? $booking->user->email }}</p>
                        </div>
                        <div>
                            <label style="color: var(--text-light); font-size: 12px;">Telepon</label>
                            <p style="font-weight: 600;">{{ $booking->contact_phone ?? '-' }}</p>
                        </div>
                        <div>
                            <label style="color: var(--text-light); font-size: 12px;">Pemesan</label>
                            <p style="font-weight: 600;">{{ $booking->user->name }}</p>
                        </div>
                    </div>
                    @if($booking->special_requests)
                        <div style="margin-top: 16px;">
                            <label style="color: var(--text-light); font-size: 12px;">Permintaan Khusus</label>
                            <p style="background: #f8f9fa; padding: 12px; border-radius: 6px; margin-top: 4px;">{{ $booking->special_requests }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Payment Proof -->
            @if($booking->payment_proof)
            <div class="card" style="margin-top: 20px;">
                <div class="card-header">
                    <h3>Bukti Pembayaran</h3>
                </div>
                <div class="card-body">
                    <div style="text-align: center;">
                        <img src="{{ $booking->payment_proof }}" alt="Bukti Pembayaran" style="max-width: 100%; max-height: 400px; border-radius: 8px; border: 1px solid var(--border);">
                        <div style="margin-top: 12px;">
                            <a href="{{ route('admin.bookings.proof', $booking) }}" class="btn btn-info" target="_blank">
                                <i class="fas fa-expand"></i> Lihat Full Size
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div>
            <!-- Booking Summary -->
            <div class="card">
                <div class="card-header">
                    <h3>Ringkasan Booking</h3>
                </div>
                <div class="card-body">
                    <div style="background: #f8f9fa; padding: 16px; border-radius: 8px;">
                        <table style="width: 100%;">
                            <tr>
                                <td style="padding: 6px 0; color: var(--text-light);">ID Booking</td>
                                <td style="text-align: right; font-weight: 600;">#{{ $booking->id }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 6px 0; color: var(--text-light);">Tanggal Booking</td>
                                <td style="text-align: right;">{{ $booking->created_at->format('d M Y, H:i') }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 6px 0; color: var(--text-light);">Tanggal Tour</td>
                                <td style="text-align: right;">{{ $booking->travel_date->format('d M Y') }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 6px 0; color: var(--text-light);">Dewasa</td>
                                <td style="text-align: right;">{{ $booking->adults }} orang</td>
                            </tr>
                            <tr>
                                <td style="padding: 6px 0; color: var(--text-light);">Anak</td>
                                <td style="text-align: right;">{{ $booking->children }} orang</td>
                            </tr>
                            <tr>
                                <td style="padding: 6px 0; color: var(--text-light);">Total</td>
                                <td style="text-align: right; font-size: 20px; font-weight: 700;">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                            </tr>
                        </table>
                    </div>

                    <div style="margin-top: 16px;">
                        <label style="font-size: 12px; color: var(--text-light);">Status Booking</label>
                        <div style="margin-top: 4px;">
                            <span class="badge badge-{{ $booking->status }}" style="font-size: 14px; padding: 6px 12px;">{{ ucfirst($booking->status) }}</span>
                        </div>
                    </div>

                    <div style="margin-top: 12px;">
                        <label style="font-size: 12px; color: var(--text-light);">Status Pembayaran</label>
                        <div style="margin-top: 4px;">
                            @if($booking->payment_proof)
                                <span class="badge badge-success"><i class="fas fa-check"></i> Bukti Uploaded</span>
                            @else
                                <span class="badge badge-warning">Menunggu Pembayaran</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Admin Actions -->
            <div class="card" style="margin-top: 20px;">
                <div class="card-header">
                    <h3>Aksi Admin</h3>
                </div>
                <div class="card-body">
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <!-- Update Status -->
                        <form action="{{ route('admin.bookings.update-status', $booking) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <label style="font-size: 12px; color: var(--text-light);">Ubah Status</label>
                            <div style="display: flex; gap: 6px;">
                                <select name="status" class="form-control" style="flex: 1;">
                                    <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                            </div>
                        </form>

                        <!-- Confirm Payment -->
                        @if($booking->payment_proof && $booking->status != 'confirmed' && $booking->status != 'completed')
                            <form action="{{ route('admin.bookings.confirm-payment', $booking) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-full" onclick="return confirm('Konfirmasi pembayaran ini? Email akan dikirim ke user.')">
                                    <i class="fas fa-check-circle"></i> ✅ Konfirmasi Pembayaran
                                </button>
                            </form>
                            <form action="{{ route('admin.bookings.reject-payment', $booking) }}" method="POST" style="margin-top:8px;">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-full" onclick="return confirm('Tolak pembayaran ini? Booking akan dibatalkan & email dikirim ke user.')">
                                    <i class="fas fa-times-circle"></i> ❌ Tolak Pembayaran
                                </button>
                            </form>
                        @endif

                        <!-- Delete -->
                        <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus booking ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-full">
                                <i class="fas fa-trash"></i> Hapus Booking
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }
        .page-header h1 {
            font-size: 24px;
            font-weight: 700;
        }
        .card {
            background: white;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
        }
        .card-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            background: #f8f9fa;
        }
        .card-header h3 {
            font-size: 16px;
            font-weight: 600;
            margin: 0;
        }
        .card-body {
            padding: 20px;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 16px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            gap: 6px;
        }
        .btn-sm { padding: 8px 12px; font-size: 13px; }
        .btn-full { width: 100%; }
        .btn-primary { background: var(--primary); color: white; }
        .btn-secondary { background: #6c757d; color: white; }
        .btn-success { background: #28a745; color: white; }
        .btn-danger { background: #dc3545; color: white; }
        .btn-info { background: #17a2b8; color: white; }
        .form-control {
            padding: 8px 12px;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 14px;
        }
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge-success { background: #d4edda; color: #155724; }
        .badge-warning { background: #fff3cd; color: #856404; }
        .badge-pending { background: #fff3cd; color: #856404; }
        .badge-confirmed { background: #d4edda; color: #155724; }
        .badge-completed { background: #cce5ff; color: #004085; }
        .badge-cancelled { background: #f8d7da; color: #721c24; }
        .alert-success {
            background: #d4edda;
            color: #155724;
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
    </style>
@endsection
