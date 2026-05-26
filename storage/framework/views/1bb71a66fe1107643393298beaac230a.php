

<?php $__env->startSection('title', 'Detail Booking #' . $booking->id); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <h1>Detail Booking #<?php echo e($booking->id); ?></h1>
        <a href="<?php echo e(route('admin.bookings.index')); ?>" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <div style="display: grid; grid-template-columns: 1fr 340px; gap: 24px;">
        <!-- Main Content -->
        <div>
            <!-- Tour Info -->
            <div class="card">
                <div class="card-header">
                    <h3>Informasi Tour</h3>
                </div>
                <div class="card-body">
                    <img src="<?php echo e($booking->tour->image ?? 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=800'); ?>" alt="<?php echo e($booking->tour->title); ?>" style="width: 100%; height: 280px; object-fit: cover; border-radius: 8px; margin-bottom: 16px;">
                    <h2 style="font-size: 22px; margin-bottom: 12px;"><?php echo e($booking->tour->title); ?></h2>
                    <div style="display: flex; gap: 20px; flex-wrap: wrap; margin-bottom: 16px;">
                        <span style="color: var(--text-light);"><i class="fas fa-tag"></i> <?php echo e($booking->tour->category->name ?? 'Tour'); ?></span>
                        <span style="color: var(--text-light);"><i class="fas fa-map-marker-alt"></i> <?php echo e($booking->tour->destination->name ?? 'Bali'); ?></span>
                        <span style="color: var(--text-light);"><i class="fas fa-clock"></i> <?php echo e($booking->tour->duration); ?> <?php echo e($booking->tour->duration_type); ?></span>
                    </div>
                    <p style="color: var(--text-medium); line-height: 1.7;"><?php echo e($booking->tour->description); ?></p>
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
                            <p style="font-weight: 600;"><?php echo e($booking->contact_name ?? $booking->user->name); ?></p>
                        </div>
                        <div>
                            <label style="color: var(--text-light); font-size: 12px;">Email</label>
                            <p style="font-weight: 600;"><?php echo e($booking->contact_email ?? $booking->user->email); ?></p>
                        </div>
                        <div>
                            <label style="color: var(--text-light); font-size: 12px;">Telepon</label>
                            <p style="font-weight: 600;"><?php echo e($booking->contact_phone ?? '-'); ?></p>
                        </div>
                        <div>
                            <label style="color: var(--text-light); font-size: 12px;">Pemesan</label>
                            <p style="font-weight: 600;"><?php echo e($booking->user->name); ?></p>
                        </div>
                    </div>
                    <?php if($booking->special_requests): ?>
                        <div style="margin-top: 16px;">
                            <label style="color: var(--text-light); font-size: 12px;">Permintaan Khusus</label>
                            <p style="background: #f8f9fa; padding: 12px; border-radius: 6px; margin-top: 4px;"><?php echo e($booking->special_requests); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Payment Proof -->
            <?php if($booking->payment_proof): ?>
            <div class="card" style="margin-top: 20px;">
                <div class="card-header">
                    <h3>Bukti Pembayaran</h3>
                </div>
                <div class="card-body">
                    <div style="text-align: center;">
                        <img src="<?php echo e($booking->payment_proof); ?>" alt="Bukti Pembayaran" style="max-width: 100%; max-height: 400px; border-radius: 8px; border: 1px solid var(--border);">
                        <div style="margin-top: 12px;">
                            <a href="<?php echo e(route('admin.bookings.proof', $booking)); ?>" class="btn btn-info" target="_blank">
                                <i class="fas fa-expand"></i> Lihat Full Size
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
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
                                <td style="text-align: right; font-weight: 600;">#<?php echo e($booking->id); ?></td>
                            </tr>
                            <tr>
                                <td style="padding: 6px 0; color: var(--text-light);">Tanggal Booking</td>
                                <td style="text-align: right;"><?php echo e($booking->created_at->format('d M Y, H:i')); ?></td>
                            </tr>
                            <tr>
                                <td style="padding: 6px 0; color: var(--text-light);">Tanggal Tour</td>
                                <td style="text-align: right;"><?php echo e($booking->travel_date->format('d M Y')); ?></td>
                            </tr>
                            <tr>
                                <td style="padding: 6px 0; color: var(--text-light);">Dewasa</td>
                                <td style="text-align: right;"><?php echo e($booking->adults); ?> orang</td>
                            </tr>
                            <tr>
                                <td style="padding: 6px 0; color: var(--text-light);">Anak</td>
                                <td style="text-align: right;"><?php echo e($booking->children); ?> orang</td>
                            </tr>
                            <tr>
                                <td style="padding: 6px 0; color: var(--text-light);">Total</td>
                                <td style="text-align: right; font-size: 20px; font-weight: 700;">Rp <?php echo e(number_format($booking->total_price, 0, ',', '.')); ?></td>
                            </tr>
                        </table>
                    </div>

                    <div style="margin-top: 16px;">
                        <label style="font-size: 12px; color: var(--text-light);">Status Booking</label>
                        <div style="margin-top: 4px;">
                            <span class="badge badge-<?php echo e($booking->status); ?>" style="font-size: 14px; padding: 6px 12px;"><?php echo e(ucfirst($booking->status)); ?></span>
                        </div>
                    </div>

                    <div style="margin-top: 12px;">
                        <label style="font-size: 12px; color: var(--text-light);">Status Pembayaran</label>
                        <div style="margin-top: 4px;">
                            <?php if($booking->payment_proof): ?>
                                <span class="badge badge-success"><i class="fas fa-check"></i> Bukti Uploaded</span>
                            <?php else: ?>
                                <span class="badge badge-warning">Menunggu Pembayaran</span>
                            <?php endif; ?>
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
                        <form action="<?php echo e(route('admin.bookings.update-status', $booking)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <label style="font-size: 12px; color: var(--text-light);">Ubah Status</label>
                            <div style="display: flex; gap: 6px;">
                                <select name="status" class="form-control" style="flex: 1;">
                                    <option value="pending" <?php echo e($booking->status == 'pending' ? 'selected' : ''); ?>>Pending</option>
                                    <option value="confirmed" <?php echo e($booking->status == 'confirmed' ? 'selected' : ''); ?>>Confirmed</option>
                                    <option value="cancelled" <?php echo e($booking->status == 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                                    <option value="completed" <?php echo e($booking->status == 'completed' ? 'selected' : ''); ?>>Completed</option>
                                </select>
                                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                            </div>
                        </form>

                        <!-- Confirm Payment -->
                        <?php if($booking->payment_proof && $booking->status != 'confirmed' && $booking->status != 'completed'): ?>
                            <form action="<?php echo e(route('admin.bookings.confirm-payment', $booking)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-success btn-full" onclick="return confirm('Konfirmasi pembayaran ini? Email akan dikirim ke user.')">
                                    <i class="fas fa-check-circle"></i> ✅ Konfirmasi Pembayaran
                                </button>
                            </form>
                            <form action="<?php echo e(route('admin.bookings.reject-payment', $booking)); ?>" method="POST" style="margin-top:8px;">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-danger btn-full" onclick="return confirm('Tolak pembayaran ini? Booking akan dibatalkan & email dikirim ke user.')">
                                    <i class="fas fa-times-circle"></i> ❌ Tolak Pembayaran
                                </button>
                            </form>
                        <?php endif; ?>

                        <!-- Delete -->
                        <form action="<?php echo e(route('admin.bookings.destroy', $booking)); ?>" method="POST" onsubmit="return confirm('Yakin ingin menghapus booking ini?');">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\tripway\tripway\resources\views/admin/bookings/show.blade.php ENDPATH**/ ?>