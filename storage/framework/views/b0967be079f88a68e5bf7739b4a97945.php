<?php $__env->startSection('title', 'Kelola Paket'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <h1><i class="fas fa-box-open" style="color:#1B3A4B;"></i> Kelola Jenis Paket</h1>
</div>

<?php if(session('success')): ?>
    <div class="alert alert-success"><i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?></div>
<?php endif; ?>

<?php if($errors->any()): ?>
    <div class="alert alert-danger" style="background:#fee2e2; color:#991b1b; padding:12px 16px; border-radius:8px; margin-bottom:16px; border:1px solid #fecaca;">
        <strong><i class="fas fa-exclamation-circle"></i> Terjadi kesalahan:</strong>
        <ul style="margin:8px 0 0 18px;">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>

<!-- Filter Destinasi -->
<div class="card" style="margin-bottom:24px;">
    <div class="card-body" style="padding:16px 24px;">
        <form method="GET" action="<?php echo e(route('admin.packages.index')); ?>" style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
            <label style="font-size:13px; font-weight:600; color:var(--text-dark);">Filter Destinasi:</label>
            <select name="destination_id" onchange="this.form.submit()"
                style="padding:8px 16px; border:1px solid var(--border); border-radius:var(--radius-sm); font-size:14px; min-width:220px;">
                <option value="">Semua Destinasi</option>
                <?php $__currentLoopData = $destinations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($dest->id); ?>" <?php echo e(request('destination_id') == $dest->id ? 'selected' : ''); ?>>
                        <?php echo e($dest->name); ?> (<?php echo e($dest->tours_count); ?> tour)
                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php if(request('destination_id')): ?>
                <a href="<?php echo e(route('admin.packages.index')); ?>" style="font-size:13px; color:var(--text-light);">
                    <i class="fas fa-times"></i> Reset
                </a>
            <?php endif; ?>
        </form>
    </div>
</div>

<?php $__empty_1 = true; $__currentLoopData = $toursByDestination; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $destName => $tours): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<div class="card" style="margin-bottom:24px;">
    <div class="card-header" style="background:#f8fafc; border-bottom:2px solid #1B3A4B;">
        <h2 style="font-size:16px; font-weight:700; color:#1B3A4B; margin:0;">
            <i class="fas fa-map-marker-alt" style="margin-right:8px;"></i><?php echo e($destName); ?>

        </h2>
        <span style="font-size:13px; color:var(--text-light);"><?php echo e($tours->count()); ?> tour</span>
    </div>
    <div class="card-body" style="padding:0;">
        <?php $__currentLoopData = $tours; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tour): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div style="border-bottom:1px solid var(--border);">
            <div style="display:flex; justify-content:space-between; align-items:center; padding:16px 24px; background:white; cursor:pointer;"
                onclick="toggleTour(<?php echo e($tour->id); ?>)">
                <div style="display:flex; align-items:center; gap:12px;">
                    <i class="fas fa-chevron-right" id="icon-<?php echo e($tour->id); ?>"
                        style="color:#1B3A4B; font-size:12px; transition:transform 0.2s;"></i>
                    <div>
                        <strong style="font-size:14px;"><?php echo e($tour->title); ?></strong>
                        <div style="font-size:12px; color:var(--text-light); margin-top:2px;">
                            <i class="fas fa-tags"></i> <?php echo e($tour->category->name); ?>

                            &nbsp;·&nbsp;
                            <i class="fas fa-box"></i> <?php echo e($tour->packages->count()); ?> paket
                        </div>
                    </div>
                </div>
                <div style="display:flex; align-items:center; gap:8px;">
                    <span class="badge <?php echo e($tour->packages->count() > 0 ? 'badge-active' : 'badge-inactive'); ?>">
                        <?php echo e($tour->packages->count() > 0 ? $tour->packages->count().' Paket' : 'Belum ada paket'); ?>

                    </span>
                    <a href="<?php echo e(route('admin.tours.edit', $tour)); ?>" class="btn btn-sm btn-secondary"
                        style="font-size:12px;" onclick="event.stopPropagation()">
                        <i class="fas fa-edit"></i> Edit Tour
                    </a>
                </div>
            </div>

            <div id="tour-<?php echo e($tour->id); ?>" style="display:none; background:#f8fafc; padding:20px 24px;">

                <?php if($tour->packages->count() > 0): ?>
                <?php $__currentLoopData = $tour->packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pkg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div style="background:white; border:1px solid #e2e8f0; border-radius:8px; margin-bottom:16px; overflow:hidden;">

                    
                    <div style="display:flex; align-items:center; padding:12px 16px; background:#f1f5f9; gap:12px;">
                        <div style="flex:1; min-width:0; overflow:hidden;">
                            <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                                <strong style="font-size:14px; white-space:nowrap;"><?php echo e($pkg->name); ?></strong>
                                <?php $typeLabels = ['private'=>'Private','sharing'=>'Sharing','both'=>'Private & Sharing']; ?>
                                <span style="white-space:nowrap; padding:2px 8px; border-radius:12px; font-size:11px; font-weight:600;
                                    background:<?php echo e($pkg->travel_type==='private'?'#dbeafe':($pkg->travel_type==='sharing'?'#dcfce7':'#fef9c3')); ?>;
                                    color:<?php echo e($pkg->travel_type==='private'?'#1d4ed8':($pkg->travel_type==='sharing'?'#15803d':'#854d0e')); ?>;">
                                    <?php echo e($typeLabels[$pkg->travel_type ?? 'both'] ?? 'both'); ?>

                                </span>
                                <span style="white-space:nowrap; font-size:12px; color:#6b7280;">Rp<?php echo e(number_format($pkg->price, 0, ',', '.')); ?></span>
                            </div>
                        </div>
                        <div style="display:flex; gap:6px; flex-shrink:0; margin-left:auto;">
                            <button onclick="toggleEditPaket('<?php echo e($pkg->id); ?>')" class="btn btn-sm btn-secondary" style="font-size:12px; white-space:nowrap;">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <form action="<?php echo e(route('admin.tours.packages.destroy', [$tour, $pkg])); ?>" method="POST" onsubmit="return confirm('Hapus paket ini?')" style="margin:0;">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-danger" style="font-size:12px;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    
                    <div id="edit-paket-<?php echo e($pkg->id); ?>" style="display:none; border-top:3px solid #1B3A4B;">
                        <div style="padding:20px 24px; background:#fafafa;">
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                                <h4 style="font-size:14px; font-weight:700; color:#1B3A4B; margin:0;">
                                    <i class="fas fa-edit"></i> Edit Paket — <?php echo e($pkg->name); ?>

                                </h4>
                                <button type="button" onclick="toggleEditPaket('<?php echo e($pkg->id); ?>')" style="background:none; border:none; color:#6b7280; cursor:pointer; font-size:18px; line-height:1;">&times;</button>
                            </div>
                        <form action="<?php echo e(route('admin.tours.packages.update', [$tour, $pkg])); ?>" method="POST" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" name="name" value="<?php echo e($pkg->name); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <input type="text" name="description" value="<?php echo e($pkg->description); ?>">
                                </div>
                            </div>
                            <div class="form-row" style="grid-template-columns:1fr 1fr 1fr;">
                                <div class="form-group">
                                    <label>Harga Private (Rp)</label>
                                    <input type="number" name="price" value="<?php echo e($pkg->price); ?>" required>
                                    <small style="color:#6b7280; font-size:11px;">Harga dasar / referensi</small>
                                </div>
                                <div class="form-group">
                                    <label>Harga Sharing/Orang (Rp)</label>
                                    <input type="number" name="sharing_price" value="<?php echo e($pkg->sharing_price); ?>" placeholder="Kosong = ikuti harga paket">
                                    <small style="color:#6b7280; font-size:11px;">Harga per orang untuk sharing</small>
                                </div>
                                <div class="form-group">
                                    <label>Harga Asli / Coret (Rp)</label>
                                    <input type="number" name="original_price" value="<?php echo e($pkg->original_price); ?>">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Maks Orang</label>
                                    <input type="number" name="max_people" value="<?php echo e($pkg->max_people); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Tipe Travel *</label>
                                    <select name="travel_type" required style="width:100%; padding:8px 12px; border:1px solid var(--border); border-radius:6px; font-size:13px;">
                                        <option value="private" <?php echo e(($pkg->travel_type ?? '') === 'private' ? 'selected' : ''); ?>>Private</option>
                                        <option value="sharing" <?php echo e(($pkg->travel_type ?? '') === 'sharing' ? 'selected' : ''); ?>>Sharing</option>
                                        <option value="both" <?php echo e(($pkg->travel_type ?? 'both') === 'both' ? 'selected' : ''); ?>>Private & Sharing</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Urutan Tampil</label>
                                    <input type="number" name="sort_order" value="<?php echo e($pkg->sort_order); ?>">
                                </div>
                                <div class="form-group" style="display:flex; align-items:center; padding-top:24px;">
                                    <label class="form-check">
                                        <input type="checkbox" name="is_active" value="1" <?php echo e($pkg->is_active ? 'checked' : ''); ?>> Aktif
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>What's Included</label>
                                <textarea name="included" style="width:100%; padding:8px 12px; border:1px solid var(--border); border-radius:6px; font-size:13px; resize:vertical; min-height:70px;"><?php echo e($pkg->included); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>What's Excluded</label>
                                <textarea name="excluded" style="width:100%; padding:8px 12px; border:1px solid var(--border); border-radius:6px; font-size:13px; resize:vertical; min-height:70px;"><?php echo e($pkg->excluded); ?></textarea>
                            </div>

                            
                            <div class="form-group" style="margin-top:8px;">
                                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                                    <label style="margin:0;"><i class="fas fa-route"></i> Jadwal Perjalanan (Itinerary)</label>
                                    <button type="button" onclick="addItineraryRow('itin-<?php echo e($pkg->id); ?>')" class="btn btn-sm btn-primary" style="font-size:12px;">
                                        <i class="fas fa-plus"></i> Tambah Item
                                    </button>
                                </div>
                                <div id="itin-<?php echo e($pkg->id); ?>" style="display:flex; flex-direction:column; gap:10px; padding:12px; background:#f8fafc; border:1px solid var(--border); border-radius:8px;">
                                    <?php $pkgItems = $pkg->itinerary_items['items'] ?? []; ?>
                                    <?php if(count($pkgItems) > 0): ?>
                                        <?php $__currentLoopData = $pkgItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="itin-row" style="background:white; border:1px solid #e2e8f0; border-radius:8px; padding:12px;">
                                            <div style="display:flex; gap:8px; align-items:center; margin-bottom:8px;">
                                                <select name="itinerary_time[]" style="flex:1; padding:8px 12px; border:1px solid var(--border); border-radius:6px; font-size:13px;">
                                                    <?php for($h=6;$h<=20;$h++): ?>
                                                        <?php $__currentLoopData = ['00','30']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php $t = sprintf('%02d:%s',$h,$m); ?>
                                                            <option value="<?php echo e($t); ?>" <?php echo e(($item['time']??'') === $t ? 'selected':''); ?>><?php echo e($t); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endfor; ?>
                                                </select>
                                                <button type="button" onclick="this.closest('.itin-row').remove()" style="background:#fee2e2; border:none; color:#dc2626; width:28px; height:28px; border-radius:6px; cursor:pointer;">×</button>
                                            </div>
                                            <textarea name="itinerary_desc[]" placeholder="Deskripsi kegiatan..." style="width:100%; padding:8px 12px; border:1px solid var(--border); border-radius:6px; font-size:13px; resize:vertical; min-height:60px; margin-bottom:8px;"><?php echo e($item['desc'] ?? ''); ?></textarea>
                                            <div style="display:flex; gap:12px; align-items:start;">
                                                <div style="flex:1;">
                                                    <label style="font-size:12px; font-weight:600; color:#6b7280; display:block; margin-bottom:4px;"><i class="fas fa-camera"></i> Foto Lokasi</label>
                                                    <input type="file" name="itinerary_photo[]" accept="image/*" style="font-size:12px; width:100%;">
                                                    <input type="hidden" name="itinerary_photo_existing[]" value="<?php echo e($item['photo'] ?? ''); ?>">
                                                </div>
                                                <?php if(!empty($item['photo'])): ?>
                                                <img src="<?php echo e($item['photo']); ?>" style="width:80px; height:60px; object-fit:cover; border-radius:6px; border:1px solid #e2e8f0; flex-shrink:0;">
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <p style="margin:0; color:#94a3b8; font-size:13px;">Belum ada itinerary. Klik "Tambah Item".</p>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div style="display:flex; gap:8px; margin-top:8px;">
                                <button type="submit" class="btn btn-primary" style="font-size:13px;"><i class="fas fa-save"></i> Update Paket</button>
                                <button type="button" onclick="toggleEditPaket('<?php echo e($pkg->id); ?>')" class="btn btn-secondary" style="font-size:13px;">Batal</button>
                            </div>
                        </form>
                        </div>
                    </div>

                    
                    <?php if(in_array($pkg->travel_type ?? 'both', ['private','both'])): ?>
                    <div style="padding:16px; border-top:1px solid #e2e8f0;">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                            <strong style="font-size:13px; color:#1d4ed8;"><i class="fas fa-users"></i> Pilihan Grup (Private)</strong>
                            <button onclick="toggleForm('form-group-<?php echo e($pkg->id); ?>')" class="btn btn-sm" style="font-size:12px; background:#dbeafe; color:#1d4ed8; border:none;">
                                <i class="fas fa-plus"></i> Tambah Grup
                            </button>
                        </div>

                        
                        <div id="form-group-<?php echo e($pkg->id); ?>" style="display:none; background:#eff6ff; border-radius:8px; padding:12px; margin-bottom:10px;">
                            <form action="<?php echo e(route('admin.packages.groups.store', $pkg)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label style="font-size:12px;">Jumlah Orang *</label>
                                        <input type="number" name="group_size" min="1" required placeholder="cth: 6">
                                    </div>
                                    <div class="form-group">
                                        <label style="font-size:12px;">Label *</label>
                                        <input type="text" name="label" required placeholder="cth: Paket 6 Orang">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label style="font-size:12px;">Harga Total Grup (Rp) *</label>
                                        <input type="number" name="price" min="0" required>
                                    </div>
                                    <div class="form-group">
                                        <label style="font-size:12px;">Harga Asli (Rp)</label>
                                        <input type="number" name="original_price" min="0">
                                    </div>
                                </div>
                                <div style="display:flex; gap:8px;">
                                    <button type="submit" class="btn btn-primary" style="font-size:12px;"><i class="fas fa-save"></i> Simpan</button>
                                    <button type="button" onclick="toggleForm('form-group-<?php echo e($pkg->id); ?>')" class="btn btn-secondary" style="font-size:12px;">Batal</button>
                                </div>
                            </form>
                        </div>

                        
                        <?php if($pkg->groups->count() > 0): ?>
                        <div style="display:flex; flex-direction:column; gap:8px;">
                            <?php $__currentLoopData = $pkg->groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; overflow:hidden;">
                                
                                <div style="display:flex; align-items:center; padding:10px 14px; gap:12px;">
                                    <div style="flex:1; min-width:0;">
                                        <span style="font-weight:600; font-size:13px;"><?php echo e($group->label); ?></span>
                                        <span style="margin-left:10px; font-size:12px; color:#6b7280;"><?php echo e($group->group_size); ?> orang</span>
                                        <span style="margin-left:10px; font-weight:700; font-size:13px; color:#1B3A4B;">Rp<?php echo e(number_format($group->price, 0, ',', '.')); ?></span>
                                        <span style="margin-left:6px; font-size:11px; color:#9ca3af;">(Rp<?php echo e(number_format($group->price / $group->group_size, 0, ',', '.')); ?>/org)</span>
                                    </div>
                                    <div style="display:flex; gap:6px; flex-shrink:0;">
                                        <button onclick="toggleForm('edit-group-<?php echo e($group->id); ?>')" class="btn btn-sm btn-secondary" style="font-size:12px;">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="<?php echo e(route('admin.packages.groups.destroy', [$pkg, $group])); ?>" method="POST" onsubmit="return confirm('Hapus grup ini?')" style="margin:0;">
                                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-danger" style="font-size:12px;">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                
                                <div id="edit-group-<?php echo e($group->id); ?>" style="display:none; border-top:3px solid #1d4ed8;">
                                    <div style="padding:16px 20px; background:#fafafa;">
                                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px;">
                                            <p style="font-size:13px; font-weight:700; color:#1d4ed8; margin:0;">
                                                <i class="fas fa-edit"></i> Edit Grup &mdash; <?php echo e($group->label); ?>

                                            </p>
                                            <button type="button" onclick="toggleForm('edit-group-<?php echo e($group->id); ?>')" style="background:none; border:none; color:#6b7280; cursor:pointer; font-size:18px; line-height:1;">&times;</button>
                                        </div>
                                        <form action="<?php echo e(route('admin.packages.groups.update', [$pkg, $group])); ?>" method="POST">
                                            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                                            <div class="form-row" style="grid-template-columns:1fr 1fr 1fr 1fr; gap:16px; margin-bottom:16px;">
                                                <div class="form-group" style="margin-bottom:0;">
                                                    <label>Label *</label>
                                                    <input type="text" name="label" value="<?php echo e($group->label); ?>" required>
                                                </div>
                                                <div class="form-group" style="margin-bottom:0;">
                                                    <label>Jumlah Orang *</label>
                                                    <input type="number" name="group_size" value="<?php echo e($group->group_size); ?>" min="1" required>
                                                </div>
                                                <div class="form-group" style="margin-bottom:0;">
                                                    <label>Harga Grup (Rp) *</label>
                                                    <input type="number" name="price" value="<?php echo e($group->price); ?>" min="0" required>
                                                </div>
                                                <div class="form-group" style="margin-bottom:0;">
                                                    <label>Harga Asli (Rp)</label>
                                                    <input type="number" name="original_price" value="<?php echo e($group->original_price); ?>" min="0">
                                                </div>
                                            </div>
                                            <div style="display:flex; gap:8px;">
                                                <button type="submit" class="btn btn-primary" style="font-size:13px;"><i class="fas fa-save"></i> Simpan</button>
                                                <button type="button" onclick="toggleForm('edit-group-<?php echo e($group->id); ?>')" class="btn btn-secondary" style="font-size:13px;">Batal</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <?php else: ?>
                        <p style="font-size:12px; color:#94a3b8; margin:0;">Belum ada pilihan grup.</p>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    
                    <?php if(in_array($pkg->travel_type ?? 'both', ['sharing','both'])): ?>
                    <div style="padding:16px; border-top:1px solid #e2e8f0;">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                            <strong style="font-size:13px; color:#15803d;"><i class="fas fa-plus-circle"></i> Add-on (Sharing)</strong>
                            <button onclick="toggleForm('form-addon-<?php echo e($pkg->id); ?>')" class="btn btn-sm" style="font-size:12px; background:#dcfce7; color:#15803d; border:none;">
                                <i class="fas fa-plus"></i> Tambah Add-on
                            </button>
                        </div>

                        
                        <div id="form-addon-<?php echo e($pkg->id); ?>" style="display:none; background:#f0fdf4; border-radius:8px; padding:12px; margin-bottom:10px;">
                            <form action="<?php echo e(route('admin.packages.addons.store', $pkg)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label style="font-size:12px;">Nama Add-on *</label>
                                        <input type="text" name="name" required placeholder="cth: Sewa Snorkel">
                                    </div>
                                    <div class="form-group">
                                        <label style="font-size:12px;">Harga per Orang (Rp) *</label>
                                        <input type="number" name="price" min="0" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label style="font-size:12px;">Deskripsi</label>
                                    <input type="text" name="description" placeholder="Keterangan singkat">
                                </div>
                                <div style="display:flex; gap:8px;">
                                    <button type="submit" class="btn btn-primary" style="font-size:12px;"><i class="fas fa-save"></i> Simpan</button>
                                    <button type="button" onclick="toggleForm('form-addon-<?php echo e($pkg->id); ?>')" class="btn btn-secondary" style="font-size:12px;">Batal</button>
                                </div>
                            </form>
                        </div>

                        
                        <?php if($pkg->addons->count() > 0): ?>
                        <div style="display:flex; flex-direction:column; gap:8px;">
                            <?php $__currentLoopData = $pkg->addons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; overflow:hidden;">
                                <div style="display:flex; align-items:center; padding:10px 14px; gap:12px;">
                                    <div style="flex:1; min-width:0;">
                                        <span style="font-weight:600; font-size:13px;"><?php echo e($addon->name); ?></span>
                                        <?php if($addon->description): ?>
                                        <span style="margin-left:8px; font-size:12px; color:#9ca3af;"><?php echo e($addon->description); ?></span>
                                        <?php endif; ?>
                                        <span style="margin-left:10px; font-weight:700; font-size:13px; color:#15803d;">+Rp<?php echo e(number_format($addon->price, 0, ',', '.')); ?>/org</span>
                                    </div>
                                    <div style="display:flex; gap:6px; flex-shrink:0;">
                                        <button onclick="toggleForm('edit-addon-<?php echo e($addon->id); ?>')" class="btn btn-sm btn-secondary" style="font-size:12px;">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="<?php echo e(route('admin.packages.addons.destroy', [$pkg, $addon])); ?>" method="POST" onsubmit="return confirm('Hapus add-on ini?')" style="margin:0;">
                                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-danger" style="font-size:12px;">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div id="edit-addon-<?php echo e($addon->id); ?>" style="display:none; border-top:3px solid #15803d;">
                                    <div style="padding:16px 20px; background:#fafafa;">
                                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px;">
                                            <p style="font-size:13px; font-weight:700; color:#15803d; margin:0;">
                                                <i class="fas fa-edit"></i> Edit Add-on &mdash; <?php echo e($addon->name); ?>

                                            </p>
                                            <button type="button" onclick="toggleForm('edit-addon-<?php echo e($addon->id); ?>')" style="background:none; border:none; color:#6b7280; cursor:pointer; font-size:18px; line-height:1;">&times;</button>
                                        </div>
                                        <form action="<?php echo e(route('admin.packages.addons.update', [$pkg, $addon])); ?>" method="POST">
                                            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                                            <div class="form-row" style="grid-template-columns:1fr 1fr 1fr; gap:16px; margin-bottom:16px;">
                                                <div class="form-group" style="margin-bottom:0;">
                                                    <label>Nama Add-on *</label>
                                                    <input type="text" name="name" value="<?php echo e($addon->name); ?>" required>
                                                </div>
                                                <div class="form-group" style="margin-bottom:0;">
                                                    <label>Deskripsi</label>
                                                    <input type="text" name="description" value="<?php echo e($addon->description); ?>">
                                                </div>
                                                <div class="form-group" style="margin-bottom:0;">
                                                    <label>Harga per Orang (Rp) *</label>
                                                    <input type="number" name="price" value="<?php echo e($addon->price); ?>" min="0" required>
                                                </div>
                                            </div>
                                            <div style="display:flex; gap:8px;">
                                                <button type="submit" class="btn btn-primary" style="font-size:13px;"><i class="fas fa-save"></i> Simpan</button>
                                                <button type="button" onclick="toggleForm('edit-addon-<?php echo e($addon->id); ?>')" class="btn btn-secondary" style="font-size:13px;">Batal</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <?php else: ?>
                        <p style="font-size:12px; color:#94a3b8; margin:0;">Belum ada add-on.</p>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                <p style="color:#6b7280; font-size:13px; margin-bottom:16px;">Belum ada paket untuk tour ini.</p>
                <?php endif; ?>

                
                <button onclick="toggleForm('tambah-paket-<?php echo e($tour->id); ?>')" class="btn btn-primary" style="font-size:13px; margin-bottom:12px;">
                    <i class="fas fa-plus"></i> Tambah Paket
                </button>
                <div id="tambah-paket-<?php echo e($tour->id); ?>" style="display:none; background:white; border:1px solid #e2e8f0; border-radius:8px; padding:20px;">
                    <h4 style="font-size:14px; font-weight:600; margin-bottom:16px; color:#1B3A4B;">
                        <i class="fas fa-plus-circle"></i> Tambah Paket — <?php echo e($tour->title); ?>

                    </h4>
                    <form action="<?php echo e(route('admin.tours.packages.store', $tour)); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Nama Paket *</label>
                                <input type="text" name="name" required placeholder="cth: Snorkeling Nusa Penida">
                            </div>
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <input type="text" name="description" placeholder="Keterangan singkat">
                            </div>
                        </div>
                        <div class="form-row" style="grid-template-columns:1fr 1fr 1fr;">
                            <div class="form-group">
                                <label>Harga Private (Rp) *</label>
                                <input type="number" name="price" required min="0">
                                <small style="color:#6b7280; font-size:11px;">Harga dasar / referensi</small>
                            </div>
                            <div class="form-group">
                                <label>Harga Sharing/Orang (Rp)</label>
                                <input type="number" name="sharing_price" min="0" placeholder="Kosong = ikuti harga paket">
                                <small style="color:#6b7280; font-size:11px;">Harga per orang untuk sharing</small>
                            </div>
                            <div class="form-group">
                                <label>Harga Asli / Coret (Rp)</label>
                                <input type="number" name="original_price" min="0">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Maks Orang *</label>
                                <input type="number" name="max_people" required min="1" value="10">
                            </div>
                            <div class="form-group">
                                <label>Tipe Travel *</label>
                                <select name="travel_type" required style="width:100%; padding:8px 12px; border:1px solid var(--border); border-radius:6px; font-size:13px;">
                                    <option value="both">Private & Sharing</option>
                                    <option value="private">Private Only</option>
                                    <option value="sharing">Sharing Only</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Urutan Tampil</label>
                                <input type="number" name="sort_order" value="0" min="0">
                            </div>
                            <div class="form-group" style="display:flex; align-items:center; padding-top:24px;">
                                <label class="form-check">
                                    <input type="checkbox" name="is_active" value="1" checked> Aktif
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>What's Included</label>
                            <textarea name="included" style="width:100%; padding:8px 12px; border:1px solid var(--border); border-radius:6px; font-size:13px; resize:vertical; min-height:70px;"></textarea>
                        </div>
                        <div class="form-group">
                            <label>What's Excluded</label>
                            <textarea name="excluded" style="width:100%; padding:8px 12px; border:1px solid var(--border); border-radius:6px; font-size:13px; resize:vertical; min-height:70px;"></textarea>
                        </div>

                        
                        <div class="form-group" style="margin-top:8px;">
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                                <label style="margin:0;"><i class="fas fa-route"></i> Jadwal Perjalanan (Itinerary)</label>
                                <button type="button" onclick="addItineraryRow('itin-new-<?php echo e($tour->id); ?>')" class="btn btn-sm btn-primary" style="font-size:12px;">
                                    <i class="fas fa-plus"></i> Tambah Item
                                </button>
                            </div>
                            <div id="itin-new-<?php echo e($tour->id); ?>" style="display:flex; flex-direction:column; gap:10px; padding:12px; background:#f8fafc; border:1px solid var(--border); border-radius:8px;">
                                <p style="margin:0; color:#94a3b8; font-size:13px;">Belum ada itinerary. Klik "Tambah Item".</p>
                            </div>
                        </div>

                        <div style="display:flex; gap:8px;">
                            <button type="submit" class="btn btn-primary" style="font-size:13px;"><i class="fas fa-save"></i> Simpan Paket</button>
                            <button type="button" onclick="toggleForm('tambah-paket-<?php echo e($tour->id); ?>')" class="btn btn-secondary" style="font-size:13px;">Batal</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
<div class="card">
    <div class="card-body" style="text-align:center; padding:48px;">
        <i class="fas fa-box-open" style="font-size:48px; color:var(--border); margin-bottom:16px;"></i>
        <p style="color:var(--text-light);">Tidak ada tour ditemukan.</p>
    </div>
</div>
<?php endif; ?>

<script>
function toggleTour(id) {
    const panel = document.getElementById('tour-' + id);
    const icon = document.getElementById('icon-' + id);
    const isOpen = panel.style.display !== 'none';
    panel.style.display = isOpen ? 'none' : 'block';
    icon.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(90deg)';
}
function toggleEditPaket(id) {
    const el = document.getElementById('edit-paket-' + id);
    el.style.display = el.style.display === 'none' ? 'block' : 'none';
}
function toggleForm(id) {
    const el = document.getElementById(id);
    el.style.display = el.style.display === 'none' ? 'block' : 'none';
}

function addItineraryRow(containerId) {
    const container = document.getElementById(containerId);
    if (!container) return;
    // hapus placeholder jika ada
    const placeholder = container.querySelector('p');
    if (placeholder) placeholder.remove();

    const times = [];
    for (let h = 6; h <= 20; h++) {
        for (const m of ['00','30']) {
            times.push(`${String(h).padStart(2,'0')}:${m}`);
        }
    }
    const options = times.map(t => `<option value="${t}">${t}</option>`).join('');

    const div = document.createElement('div');
    div.className = 'itin-row';
    div.style.cssText = 'background:white; border:1px solid #e2e8f0; border-radius:8px; padding:12px;';
    div.innerHTML = `
        <div style="display:flex; gap:8px; align-items:center; margin-bottom:8px;">
            <select name="itinerary_time[]" style="flex:1; padding:8px 12px; border:1px solid var(--border); border-radius:6px; font-size:13px;">${options}</select>
            <button type="button" onclick="this.closest('.itin-row').remove()" style="background:#fee2e2; border:none; color:#dc2626; width:28px; height:28px; border-radius:6px; cursor:pointer; font-size:14px;">×</button>
        </div>
        <textarea name="itinerary_desc[]" placeholder="Deskripsi kegiatan..." style="width:100%; padding:8px 12px; border:1px solid var(--border); border-radius:6px; font-size:13px; resize:vertical; min-height:60px; margin-bottom:8px;"></textarea>
        <div style="flex:1;">
            <label style="font-size:12px; font-weight:600; color:#6b7280; display:block; margin-bottom:4px;"><i class="fas fa-camera"></i> Foto Lokasi</label>
            <input type="file" name="itinerary_photo[]" accept="image/*" style="font-size:12px; width:100%;">
            <input type="hidden" name="itinerary_photo_existing[]" value="">
        </div>`;
    container.appendChild(div);
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\tripway\tripway\resources\views/admin/packages/index.blade.php ENDPATH**/ ?>