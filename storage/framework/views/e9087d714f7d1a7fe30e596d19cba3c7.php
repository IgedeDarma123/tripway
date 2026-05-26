

<?php $__env->startSection('title', 'Pengaturan Pembayaran'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <h1>Pengaturan Pembayaran</h1>
    </div>

    <div class="two-columns">
        <div class="card">
            <div class="card-header">
                <h2>Daftar Metode Pembayaran</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Method</th>
                                <th>Nama</th>
                                <th>No. Rekening</th>
                                <th>Atas Nama</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><code><?php echo e($pm->method); ?></code></td>
                                <td><strong><?php echo e($pm->name); ?></strong></td>
                                <td><?php echo e($pm->account_number ?? '-'); ?></td>
                                <td><?php echo e($pm->account_name ?? '-'); ?></td>
                                <td>
                                    <?php if($pm->is_active): ?>
                                        <span class="badge badge-active">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge badge-inactive">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div style="display: flex; gap: 6px;">
                                        <button type="button" class="btn btn-sm btn-secondary btn-icon" onclick="editPayment(<?php echo e($pm->id); ?>, '<?php echo e($pm->method); ?>', '<?php echo e(addslashes($pm->name)); ?>', '<?php echo e($pm->account_number ?? ''); ?>', '<?php echo e(addslashes($pm->account_name ?? '')); ?>', '<?php echo e($pm->image ?? ''); ?>', <?php echo e($pm->is_active ? 'true' : 'false'); ?>, <?php echo e($pm->sort_order); ?>)" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="<?php echo e(route('admin.payments.toggle', $pm)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PATCH'); ?>
                                            <button type="submit" class="btn btn-sm btn-<?php echo e($pm->is_active ? 'danger' : 'primary'); ?> btn-icon" title="<?php echo e($pm->is_active ? 'Nonaktifkan' : 'Aktifkan'); ?>">
                                                <i class="fas fa-<?php echo e($pm->is_active ? 'toggle-on' : 'toggle-off'); ?>"></i>
                                            </button>
                                        </form>
                                        <form action="<?php echo e(route('admin.payments.destroy', $pm)); ?>" method="POST" id="del-pm-<?php echo e($pm->id); ?>">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="button" class="btn btn-sm btn-danger btn-icon" title="Hapus" onclick="confirmAdminDelete('del-pm-<?php echo e($pm->id); ?>', '<?php echo e(addslashes($pm->name)); ?>')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" style="text-align: center; color: var(--text-light);">Belum ada metode pembayaran.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2 id="form-title">Tambah Metode Pembayaran</h2>
            </div>
            <div class="card-body">
                <form id="payment-form" action="<?php echo e(route('admin.payments.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label>Method Code *</label>
                        <input type="text" name="method" id="pm-method" placeholder="qris, bca, bni, mandiri, bri, gopay, ovo, dana" required>
                        <small style="color: var(--text-light);">Kode unik untuk metode (huruf kecil)</small>
                    </div>
                    <div class="form-group">
                        <label>Nama Tampilan *</label>
                        <input type="text" name="name" id="pm-name" placeholder="QRIS, BCA VA, GoPay" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Nomor Rekening</label>
                            <input type="text" name="account_number" id="pm-account-number" placeholder="7799 1234 5678">
                        </div>
                        <div class="form-group">
                            <label>Atas Nama</label>
                            <input type="text" name="account_name" id="pm-account-name" placeholder="TripWay Tour">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>URL Gambar / Icon</label>
                        <input type="text" name="image" id="pm-image" placeholder="https://... (URL gambar/logo)">
                    </div>
                    <div class="form-group">
                        <label>Urutan</label>
                        <input type="number" name="sort_order" id="pm-sort-order" value="0" min="0">
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" name="is_active" id="pm-is-active" value="1" checked>
                            <label for="pm-is-active">Aktif</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" id="pm-submit">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="resetForm()" style="margin-left: 8px;">
                            Reset
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function editPayment(id, method, name, accountNumber, accountName, image, isActive, sortOrder) {
            document.getElementById('form-title').textContent = 'Edit Metode Pembayaran';
            document.getElementById('payment-form').action = '/admin/payments/' + id;
            
            let methodInput = document.getElementById('pm-method-input');
            if (!methodInput) {
                methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.id = 'pm-method-input';
                document.getElementById('payment-form').appendChild(methodInput);
            }
            methodInput.value = 'PUT';

            document.getElementById('pm-method').value = method;
            document.getElementById('pm-method').readOnly = true;
            document.getElementById('pm-name').value = name;
            document.getElementById('pm-account-number').value = accountNumber || '';
            document.getElementById('pm-account-name').value = accountName || '';
            document.getElementById('pm-image').value = image || '';
            document.getElementById('pm-sort-order').value = sortOrder;
            document.getElementById('pm-is-active').checked = isActive;
            document.getElementById('pm-submit').innerHTML = '<i class="fas fa-save"></i> Update';
        }

        function resetForm() {
            document.getElementById('form-title').textContent = 'Tambah Metode Pembayaran';
            document.getElementById('payment-form').action = '<?php echo e(route('admin.payments.store')); ?>';
            document.getElementById('pm-method').value = '';
            document.getElementById('pm-method').readOnly = false;
            document.getElementById('pm-name').value = '';
            document.getElementById('pm-account-number').value = '';
            document.getElementById('pm-account-name').value = '';
            document.getElementById('pm-image').value = '';
            document.getElementById('pm-sort-order').value = '0';
            document.getElementById('pm-is-active').checked = true;
            document.getElementById('pm-submit').innerHTML = '<i class="fas fa-save"></i> Simpan';
            const methodInput = document.getElementById('pm-method-input');
            if (methodInput) methodInput.remove();
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\tripway\tripway\resources\views/admin/payments/index.blade.php ENDPATH**/ ?>