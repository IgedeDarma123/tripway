<?php $__env->startSection('title', 'Booking'); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .badge-warning  { background:#fff3e0; color:#f57c00; }
    .badge-secondary { background:#f1f5f9; color:#64748b; }
    .badge-info     { background:#e3f2fd; color:#1976d2; }
    .btn-info       { background:#0ea5e9; color:white; }
    .btn-info:hover { background:#0284c7; }
    .btn-success    { background:#22c55e; color:white; }
    .btn-success:hover { background:#16a34a; }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <h1>Kelola Booking</h1>
        <span style="font-size:13px; color:#64748b;">Total: <?php echo e($bookings->total()); ?> booking</span>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> <?php echo e(session('error')); ?></div>
    <?php endif; ?>

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
                        <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td style="font-weight:700; color:#1B3A4B;">#<?php echo e($booking->id); ?></td>
                            <td>
                                <div style="font-weight:600; font-size:13px;"><?php echo e(Str::limit($booking->tour->title, 28)); ?></div>
                                <?php if($booking->package): ?>
                                <div style="font-size:11px; color:#1B3A4B; font-weight:600; margin-top:2px;">
                                    <i class="fas fa-box-open" style="margin-right:3px;"></i><?php echo e($booking->package->name); ?>

                                </div>
                                <?php endif; ?>
                                <div style="font-size:11px; color:#94a3b8; margin-top:2px;">
                                    <i class="fas fa-users" style="margin-right:3px;"></i><?php echo e($booking->num_persons); ?> orang
                                    &nbsp;·&nbsp;
                                    <?php echo e(ucfirst($booking->travel_type ?? '-')); ?>

                                </div>
                            </td>
                            <td>
                                <div style="font-size:13px; font-weight:600;"><?php echo e($booking->user->name); ?></div>
                                <div style="font-size:11px; color:#94a3b8;"><?php echo e($booking->contact_phone); ?></div>
                            </td>
                            <td style="font-size:13px;"><?php echo e($booking->travel_date->format('d M Y')); ?></td>
                            <td style="font-weight:700; font-size:13px;">Rp <?php echo e(number_format($booking->total_price, 0, ',', '.')); ?></td>
                            <td>
                                <?php if($booking->payment_status === 'pending_verification'): ?>
                                    <span class="badge badge-warning">
                                        <i class="fas fa-clock" style="margin-right:4px;"></i>Menunggu
                                    </span>
                                <?php elseif($booking->payment_status === 'settlement'): ?>
                                    <span class="badge badge-confirmed">
                                        <i class="fas fa-check" style="margin-right:4px;"></i>Lunas
                                    </span>
                                <?php elseif($booking->payment_status === 'deny'): ?>
                                    <span class="badge badge-cancelled">
                                        <i class="fas fa-times" style="margin-right:4px;"></i>Ditolak
                                    </span>
                                <?php elseif($booking->payment_proof): ?>
                                    <span class="badge badge-info">
                                        <i class="fas fa-image" style="margin-right:4px;"></i>Ada Bukti
                                    </span>
                                <?php else: ?>
                                    <span class="badge badge-secondary">
                                        <i class="fas fa-minus" style="margin-right:4px;"></i>Belum Upload
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge badge-<?php echo e($booking->status); ?>"><?php echo e(ucfirst($booking->status)); ?></span>
                            </td>
                            <td>
                                <div style="display:flex; gap:4px; flex-wrap:wrap; align-items:center;">

                                    
                                    <a href="<?php echo e(route('admin.bookings.show', $booking)); ?>"
                                        class="btn btn-sm btn-secondary btn-icon" title="Lihat Detail"
                                        style="padding:4px 8px; font-size:12px;">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <?php if($booking->payment_proof && !in_array($booking->status, ['confirmed','completed'])): ?>
                                        
                                        <a href="<?php echo e(route('admin.bookings.proof', $booking)); ?>"
                                            class="btn btn-sm btn-info btn-icon" title="Lihat Bukti Transfer"
                                            style="padding:4px 8px; font-size:12px;">
                                            <i class="fas fa-image"></i>
                                        </a>

                                        
                                        <form action="<?php echo e(route('admin.bookings.confirm-payment', $booking)); ?>" method="POST" id="confirm-<?php echo e($booking->id); ?>">
                                            <?php echo csrf_field(); ?>
                                            <button type="button"
                                                class="btn btn-sm btn-success btn-icon" title="Konfirmasi Pembayaran"
                                                style="padding:4px 8px; font-size:12px;"
                                                onclick="confirmAdminDelete('confirm-<?php echo e($booking->id); ?>', 'Konfirmasi pembayaran Booking #<?php echo e($booking->id); ?>?')">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>

                                        
                                        <form action="<?php echo e(route('admin.bookings.reject-payment', $booking)); ?>" method="POST" id="reject-<?php echo e($booking->id); ?>">
                                            <?php echo csrf_field(); ?>
                                            <button type="button"
                                                class="btn btn-sm btn-danger btn-icon" title="Tolak Bukti"
                                                style="padding:4px 8px; font-size:12px;"
                                                onclick="confirmAdminDelete('reject-<?php echo e($booking->id); ?>', 'Tolak bukti pembayaran Booking #<?php echo e($booking->id); ?>?')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>

                                    
                                    <form action="<?php echo e(route('admin.bookings.destroy', $booking)); ?>" method="POST" id="del-booking-<?php echo e($booking->id); ?>">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="button"
                                            class="btn btn-sm btn-danger btn-icon" title="Hapus Booking"
                                            style="padding:4px 8px; font-size:12px;"
                                            onclick="confirmAdminDelete('del-booking-<?php echo e($booking->id); ?>', 'Booking #<?php echo e($booking->id); ?> - <?php echo e(addslashes(Str::limit($booking->tour->title, 25))); ?>')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" style="text-align:center; color:var(--text-light); padding:40px;">
                                <i class="fas fa-calendar-times" style="font-size:32px; margin-bottom:10px; display:block; opacity:0.3;"></i>
                                Belum ada booking.
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div style="margin-top:16px;">
                <?php echo e($bookings->links('vendor.pagination.admin')); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\tripway\tripway\resources\views/admin/bookings/index.blade.php ENDPATH**/ ?>