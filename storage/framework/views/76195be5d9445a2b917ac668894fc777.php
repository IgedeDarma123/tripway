

<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <h1>Dashboard Admin</h1>
    </div>

    <?php if(session('success')): ?>
    <div style="padding:12px 16px; background:#f0fdf4; border:1px solid #bbf7d0; border-radius:10px; color:#166534; font-size:13px; font-weight:600; margin-bottom:20px;">
        <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

    </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
    <div style="padding:12px 16px; background:#fef2f2; border:1px solid #fecaca; border-radius:10px; color:#991b1b; font-size:13px; font-weight:600; margin-bottom:20px;">
        <i class="fas fa-times-circle"></i> <?php echo e(session('error')); ?>

    </div>
    <?php endif; ?>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="icon blue"><i class="fas fa-map-marked-alt"></i></div>
            <div class="label">Total Tour</div>
            <div class="value"><?php echo e($stats['total_tours']); ?></div>
        </div>
        <div class="stat-card">
            <div class="icon orange"><i class="fas fa-calendar-check"></i></div>
            <div class="label">Total Booking</div>
            <div class="value"><?php echo e($stats['total_bookings']); ?></div>
        </div>
        <div class="stat-card">
            <div class="icon green"><i class="fas fa-users"></i></div>
            <div class="label">Total User</div>
            <div class="value"><?php echo e($stats['total_users']); ?></div>
        </div>
        <div class="stat-card">
            <div class="icon red"><i class="fas fa-star"></i></div>
            <div class="label">Total Review</div>
            <div class="value"><?php echo e($stats['total_reviews']); ?></div>
        </div>
        <div class="stat-card">
            <div class="icon orange"><i class="fas fa-clock"></i></div>
            <div class="label">Booking Pending</div>
            <div class="value"><?php echo e($stats['pending_bookings']); ?></div>
        </div>
        <div class="stat-card">
            <div class="icon green"><i class="fas fa-money-bill-wave"></i></div>
            <div class="label">Total Revenue (Confirmed)</div>
            <div class="value">Rp <?php echo e(number_format($stats['total_revenue'], 0, ',', '.')); ?></div>
        </div>
    </div>

    <div class="two-columns">
        <div class="card">
            <div class="card-header">
                <h2>Booking Terbaru</h2>
                <a href="<?php echo e(route('admin.bookings.index')); ?>" class="btn btn-sm btn-secondary">Lihat Semua</a>
            </div>
            <div class="card-body">
                <?php if($recent_bookings->count() > 0): ?>
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
                                <?php $__currentLoopData = $recent_bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>#<?php echo e($booking->id); ?></td>
                                    <td><?php echo e($booking->tour->title); ?></td>
                                    <td><?php echo e($booking->user->name); ?></td>
                                    <td>
                                        <span class="badge badge-<?php echo e($booking->status); ?>"><?php echo e(ucfirst($booking->status)); ?></span>
                                    </td>
                                    <td>Rp <?php echo e(number_format($booking->total_price, 0, ',', '.')); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p style="color: var(--text-light); text-align: center;">Belum ada booking.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2>Review Terbaru</h2>
                <a href="<?php echo e(route('admin.reviews.index')); ?>" class="btn btn-sm btn-secondary">Lihat Semua</a>
            </div>
            <div class="card-body">
                <?php if($recent_reviews->count() > 0): ?>
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
                                <?php $__currentLoopData = $recent_reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e(Str::limit($review->tour->title, 30)); ?></td>
                                    <td><?php echo e($review->user_name); ?></td>
                                    <td><?php echo e($review->rating); ?>/5</td>
                                    <td>
                                        <?php if($review->is_fake): ?>
                                            <span class="badge badge-fake">Fake</span>
                                        <?php else: ?>
                                            <span class="badge badge-active">Real</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p style="color: var(--text-light); text-align: center;">Belum ada review.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\tripway\tripway\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>