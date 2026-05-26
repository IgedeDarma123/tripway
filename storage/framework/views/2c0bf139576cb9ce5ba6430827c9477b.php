

<?php $__env->startSection('title', 'Kategori'); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <h1>Kelola Kategori</h1>
    </div>

    <div class="two-columns">
        <div class="card">
            <div class="card-header">
                <h2>Daftar Kategori</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Slug</th>
                                <th>Icon</th>
                                <th>Urutan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><strong><?php echo e($cat->name); ?></strong></td>
                                <td><?php echo e($cat->slug); ?></td>
                                <td><i class="fas <?php echo e($cat->icon); ?>"></i> <?php echo e($cat->icon); ?></td>
                                <td><?php echo e($cat->sort_order); ?></td>
                                <td>
                                    <div style="display: flex; gap: 6px;">
                                        <button type="button" class="btn btn-sm btn-secondary btn-icon" onclick="editCategory(<?php echo e($cat->id); ?>, '<?php echo e($cat->name); ?>', '<?php echo e($cat->slug); ?>', '<?php echo e($cat->icon); ?>', '<?php echo e($cat->image); ?>', '<?php echo e($cat->description); ?>', <?php echo e($cat->sort_order); ?>)" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="<?php echo e(route('admin.categories.destroy', $cat)); ?>" method="POST" id="del-cat-<?php echo e($cat->id); ?>">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="button" class="btn btn-sm btn-danger btn-icon" title="Hapus" onclick="confirmAdminDelete('del-cat-<?php echo e($cat->id); ?>', '<?php echo e(addslashes($cat->name)); ?>')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" style="text-align: center; color: var(--text-light);">Belum ada kategori.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <?php echo e($categories->links('vendor.pagination.admin')); ?>

            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2 id="form-title">Tambah Kategori</h2>
            </div>
            <div class="card-body">
                <form id="category-form" action="<?php echo e(route('admin.categories.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label>Nama *</label>
                        <input type="text" name="name" id="cat-name" required>
                    </div>
                    <div class="form-group">
                        <label>Slug (opsional)</label>
                        <input type="text" name="slug" id="cat-slug">
                    </div>
                    <div class="form-group">
                        <label>Icon Class (FontAwesome)</label>
                        <input type="text" name="icon" id="cat-icon" placeholder="fa-hiking">
                    </div>
                    <div class="form-group">
                        <label>URL Gambar</label>
                        <input type="text" name="image" id="cat-image" placeholder="https://...">
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="description" id="cat-description" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Urutan</label>
                        <input type="number" name="sort_order" id="cat-sort" value="0" min="0">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" id="cat-submit">
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
        function editCategory(id, name, slug, icon, image, description, sortOrder) {
            document.getElementById('form-title').textContent = 'Edit Kategori';
            document.getElementById('category-form').action = '/admin/categories/' + id;
            
            let methodInput = document.getElementById('cat-method');
            if (!methodInput) {
                methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.id = 'cat-method';
                document.getElementById('category-form').appendChild(methodInput);
            }
            methodInput.value = 'PUT';

            document.getElementById('cat-name').value = name;
            document.getElementById('cat-slug').value = slug;
            document.getElementById('cat-icon').value = icon || '';
            document.getElementById('cat-image').value = image || '';
            document.getElementById('cat-description').value = description || '';
            document.getElementById('cat-sort').value = sortOrder;
            document.getElementById('cat-submit').innerHTML = '<i class="fas fa-save"></i> Update';
        }

        function resetForm() {
            document.getElementById('form-title').textContent = 'Tambah Kategori';
            document.getElementById('category-form').action = '<?php echo e(route('admin.categories.store')); ?>';
            document.getElementById('cat-name').value = '';
            document.getElementById('cat-slug').value = '';
            document.getElementById('cat-icon').value = '';
            document.getElementById('cat-image').value = '';
            document.getElementById('cat-description').value = '';
            document.getElementById('cat-sort').value = '0';
            document.getElementById('cat-submit').innerHTML = '<i class="fas fa-save"></i> Simpan';
            const methodInput = document.getElementById('cat-method');
            if (methodInput) methodInput.remove();
        }
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\tripway\tripway\resources\views/admin/categories/index.blade.php ENDPATH**/ ?>