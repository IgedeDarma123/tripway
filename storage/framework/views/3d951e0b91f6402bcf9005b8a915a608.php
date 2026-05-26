

<?php $__env->startSection('title', 'Kelola Tour'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <h1>Kelola Tour</h1>
        <a href="<?php echo e(route('admin.tours.create')); ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Tour
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Gambar</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Destinasi</th>
                            <th>Harga</th>
                            <th>Rating</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $tours; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tour): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($tour->id); ?></td>
                            <td>
                                <img src="<?php echo e($tour->image ?? 'https://via.placeholder.com/60'); ?>" alt="" style="width: 60px; height: 40px; object-fit: cover; border-radius: 6px;">
                            </td>
                            <td>
                                <strong><?php echo e(Str::limit($tour->title, 40)); ?></strong>
                                <?php if($tour->is_featured): ?>
                                    <span class="badge badge-featured" style="margin-left: 6px;">Featured</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($tour->category->name); ?></td>
                            <td><?php echo e($tour->destination->name); ?></td>
                            <td>Rp <?php echo e(number_format($tour->price, 0, ',', '.')); ?></td>
                            <td>
                                <i class="fas fa-star" style="color: #ffc107;"></i> <?php echo e($tour->rating); ?>

                                <small style="color: var(--text-light);">(<?php echo e($tour->review_count); ?>)</small>
                            </td>
                            <td>
                                <?php if($tour->is_active): ?>
                                    <span class="badge badge-active">Aktif</span>
                                <?php else: ?>
                                    <span class="badge badge-inactive">Nonaktif</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($tour->is_active): ?>
                                    <form action="<?php echo e(route('admin.tours.toggle-active', $tour)); ?>" method="POST" onsubmit="return confirm('Nonaktifkan tour ini?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger" style="font-size:12px; padding:4px 8px;">
                                            <i class="fas fa-eye-slash"></i> Nonaktifkan
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <form action="<?php echo e(route('admin.tours.toggle-active', $tour)); ?>" method="POST" onsubmit="return confirm('Publis tour ini?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <button type="submit" class="btn btn-sm btn-success" style="font-size:12px; padding:4px 8px;">
                                            <i class="fas fa-bullhorn"></i> Publis
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </td>

                            <td>
                                <div style="display: flex; gap: 6px;">
                                    <a href="<?php echo e(route('admin.tours.edit', $tour)); ?>" class="btn btn-sm btn-secondary btn-icon" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="<?php echo e(route('admin.tours.destroy', $tour)); ?>" method="POST" id="del-tour-<?php echo e($tour->id); ?>">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="button" class="btn btn-sm btn-danger btn-icon" title="Hapus" onclick="confirmAdminDelete('del-tour-<?php echo e($tour->id); ?>', '<?php echo e(addslashes($tour->title)); ?>')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="9" style="text-align: center; color: var(--text-light);">Belum ada tour.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

                <?php echo e($tours->links('vendor.pagination.admin')); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\tripway\tripway\resources\views/admin/tours/index.blade.php ENDPATH**/ ?>