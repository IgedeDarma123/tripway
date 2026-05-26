@extends('layouts.admin')

@section('title', 'Edit Tour')

@section('content')
    <div class="page-header">
        <h1>Edit Tour</h1>
        <a href="{{ route('admin.tours.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger" style="background: #fee2e2; color: #991b1b; padding: 12px 16px; border-radius: var(--radius-sm); margin-bottom: 20px; border: 1px solid #fecaca;">
                    <strong>Terjadi kesalahan:</strong>
                    <ul style="margin: 8px 0 0 18px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.tours.update', $tour) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-row">
                    <div class="form-group">
                        <label>Judul Tour *</label>
                        <input type="text" name="title" value="{{ old('title', $tour->title) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Slug (opsional)</label>
                        <input type="text" name="slug" value="{{ old('slug', $tour->slug) }}" placeholder="auto-generate">
                    </div>
                </div>

                <div class="form-group">
                    <label>Deskripsi *</label>
                    <textarea name="description" required>{{ old('description', $tour->description) }}</textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Kategori *</label>
                        <select name="category_id" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $tour->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Destinasi *</label>
                        <select name="destination_id" required>
                            <option value="">Pilih Destinasi</option>
                            @foreach($destinations as $dest)
                                <option value="{{ $dest->id }}" {{ old('destination_id', $tour->destination_id) == $dest->id ? 'selected' : '' }}>{{ $dest->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Durasi *</label>
                        <input type="text" name="duration" value="{{ old('duration', $tour->duration) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Tipe Durasi *</label>
                        <select name="duration_type" required>
                            <option value="hours" {{ old('duration_type', $tour->duration_type) == 'hours' ? 'selected' : '' }}>Jam</option>
                            <option value="days" {{ old('duration_type', $tour->duration_type) == 'days' ? 'selected' : '' }}>Hari</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Harga (Rp) *</label>
                        <input type="number" name="price" value="{{ old('price', $tour->price) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Harga Asli (Rp) (opsional)</label>
                        <input type="number" name="original_price" value="{{ old('original_price', $tour->original_price) }}">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Min Peserta</label>
                        <input type="number" name="min_people" value="{{ old('min_people', $tour->min_people) }}" min="1">
                    </div>
                    <div class="form-group">
                        <label>Max Peserta</label>
                        <input type="number" name="max_people" value="{{ old('max_people', $tour->max_people) }}" min="1">
                    </div>
                </div>

                <div class="form-group">
                    <label>Gambar Utama (Cover)</label>
                    @if($tour->image)
                        <div style="margin-bottom: 10px;">
                            <img src="{{ $tour->image }}" alt="Current" style="max-width: 200px; max-height: 120px; border-radius: var(--radius-sm); border: 1px solid var(--border);">
                        </div>
                    @endif
                    <input type="file" name="image_file" accept="image/*">
                    <small style="color: var(--text-light);">Atau masukkan URL gambar:</small>
                    <input type="text" name="image" value="{{ old('image', $tour->image) }}" placeholder="https://..." style="margin-top: 6px;">
                </div>

                <div class="form-group">
                    <label>Galeri (Foto & Video) - Tambah foto/video baru</label>
                    <input type="file" name="gallery_files[]" id="gallery-input" accept="image/*,video/*" multiple onchange="previewGallery()">
                    <small style="color: var(--text-light); display:block; margin-top:4px;">
                        Tahan tombol <b>Ctrl</b> (Windows) atau <b>Command</b> (Mac) saat memilih untuk upload lebih dari satu file sekaligus.<br>
                        Foto: jpg/png/webp. Video: mp4/mov/webm. File yang diupload di sini akan ditambahkan ke galeri yang sudah ada.
                    </small>

                    <!-- Tempat Preview untuk file BARU yang akan diupload -->
                    <div id="gallery-preview" style="display:flex; flex-wrap:wrap; gap:10px; margin-top:12px;"></div>

                    @if(!empty($tour->gallery) && is_array($tour->gallery) && count($tour->gallery) > 0)
                        <hr style="margin: 16px 0; border-top: 1px solid var(--border);">
                        <label style="font-size:13px; font-weight:600; color:var(--text-medium);">Galeri Saat Ini:</label>
                        <div style="display:flex; flex-wrap:wrap; gap:10px; margin-top:8px;">
                            @foreach($tour->gallery as $g)
                                @php $isVideo = preg_match('/\.(mp4|mov|webm)$/i', $g); @endphp
                                @if($isVideo)
                                    <video src="{{ $g }}" controls style="width:160px; height:90px; border:1px solid var(--border); border-radius:8px; object-fit:cover; background:#000;"></video>
                                @else
                                    <img src="{{ $g }}" alt="gallery" style="width:160px; height:90px; object-fit:cover; border:1px solid var(--border); border-radius:8px;">
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>

                <script>
                function previewGallery() {
                    const preview = document.getElementById('gallery-preview');
                    const fileInput = document.getElementById('gallery-input');
                    preview.innerHTML = ''; // clear old previews
                    
                    if (fileInput.files && fileInput.files.length > 0) {
                        preview.innerHTML = '<div style="width:100%; font-size:13px; font-weight:600; color:var(--primary); margin-bottom:4px;">Akan ditambahkan (' + fileInput.files.length + ' file):</div>';
                        Array.from(fileInput.files).forEach(file => {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                const isVideo = file.type.startsWith('video/');
                                const el = isVideo 
                                    ? `<video src="${e.target.result}" style="width:120px; height:80px; object-fit:cover; border-radius:8px; border:2px solid var(--primary);"></video>`
                                    : `<img src="${e.target.result}" style="width:120px; height:80px; object-fit:cover; border-radius:8px; border:2px solid var(--primary);">`;
                                preview.innerHTML += el;
                            }
                            reader.readAsDataURL(file);
                        });
                    }
                }
                </script>


                <div class="form-group">
                    <label>Highlight (satu per baris)</label>
                    <textarea name="highlights" rows="4">{{ old('highlights', $tour->highlights) }}</textarea>
                </div>

                <div class="form-group">
                    <label>Jadwal Perjalanan (Itinerary)</label>
                    <div style="background:#fffbeb; border:1px solid #fbbf24; color:#92400e; border-radius:8px; padding:12px 16px; font-size:13px;">
                        <i class="fas fa-info-circle"></i> Itinerary dikelola per paket di halaman <a href="{{ route('admin.packages.index') }}" style="font-weight:700; color:#92400e; text-decoration:underline;">Kelola Paket</a>.
                    </div>
                    <input type="hidden" name="itinerary" value="{{ $tour->itinerary }}">
                </div>

                <div class="form-group">
                    <label>Termasuk (satu per baris)</label>
                    <textarea name="inclusions" rows="4">{{ old('inclusions', $tour->inclusions) }}</textarea>
                </div>

                <div class="form-group">
                    <label>Tidak Termasuk (satu per baris)</label>
                    <textarea name="exclusions" rows="4">{{ old('exclusions', $tour->exclusions) }}</textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-check">
                            <input type="hidden" name="is_featured" value="0">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $tour->is_featured) ? 'checked' : '' }}>
                            Tampilkan di Featured
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="form-check">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $tour->is_active) ? 'checked' : '' }}>
                            Aktif
                        </label>
                    </div>
                </div>

                <div class="form-group" style="margin-top: 24px;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Tour
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Kelola Jenis Paket -->
    <div class="card" style="margin-top: 24px;">
        <div class="card-body">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                <h2 style="font-size:18px; font-weight:700; margin:0;"><i class="fas fa-box-open" style="color:#1B3A4B;"></i> Jenis Paket</h2>
                <button onclick="document.getElementById('form-tambah-paket').style.display = document.getElementById('form-tambah-paket').style.display === 'none' ? 'block' : 'none'" class="btn btn-primary" style="font-size:13px;">
                    <i class="fas fa-plus"></i> Tambah Paket
                </button>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <!-- Form Tambah Paket -->
            <div id="form-tambah-paket" style="display:none; background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:20px; margin-bottom:20px;">
                <h3 style="font-size:15px; font-weight:600; margin-bottom:16px;">Tambah Paket Baru</h3>
                <form action="{{ route('admin.tours.packages.store', $tour) }}" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="form-group">
                            <label>Nama Paket *</label>
                            <input type="text" name="name" required placeholder="cth: Sanur Harbor, Hotel Pickup">
                        </div>
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <input type="text" name="description" placeholder="Keterangan singkat">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Harga (Rp) *</label>
                            <input type="number" name="price" required min="0">
                        </div>
                        <div class="form-group">
                            <label>Harga Asli / Coret (Rp)</label>
                            <input type="number" name="original_price" min="0" placeholder="Kosongkan jika tidak ada diskon">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Maks Orang *</label>
                            <input type="number" name="max_people" required min="1" value="10">
                        </div>
                        <div class="form-group">
                            <label>Urutan Tampil</label>
                            <input type="number" name="sort_order" value="0" min="0">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-check">
                            <input type="checkbox" name="is_active" value="1" checked> Aktif
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Paket</button>
                </form>
            </div>

            <!-- Tabel Paket -->
            @if($packages->count() > 0)
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Harga Asli</th>
                        <th>Diskon</th>
                        <th>Maks Orang</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($packages as $pkg)
                    <tr>
                        <td>
                            <strong>{{ $pkg->name }}</strong>
                            @if($pkg->description)
                            <br><small style="color:#6b7280;">{{ $pkg->description }}</small>
                            @endif
                        </td>
                        <td>Rp{{ number_format($pkg->price, 0, ',', '.') }}</td>
                        <td>{{ $pkg->original_price ? 'Rp'.number_format($pkg->original_price, 0, ',', '.') : '-' }}</td>
                        <td>{{ $pkg->discountPercentage() > 0 ? $pkg->discountPercentage().'%' : '-' }}</td>
                        <td>{{ $pkg->max_people }} orang</td>
                        <td>
                            <span class="badge {{ $pkg->is_active ? 'badge-active' : 'badge-inactive' }}">
                                {{ $pkg->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td>
                            <div style="display:flex; gap:4px;">
                                <button onclick="toggleEditPaket({{ $pkg->id }})" class="btn btn-sm btn-secondary" style="padding:4px 8px; font-size:12px;">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.tours.packages.destroy', [$tour, $pkg]) }}" method="POST" onsubmit="return confirm('Hapus paket ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" style="padding:4px 8px; font-size:12px;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                            <!-- Form Edit Inline -->
                            <div id="edit-paket-{{ $pkg->id }}" style="display:none; margin-top:12px; background:#f1f5f9; border-radius:8px; padding:16px;">
                                <form action="{{ route('admin.tours.packages.update', [$tour, $pkg]) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label>Nama</label>
                                            <input type="text" name="name" value="{{ $pkg->name }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Deskripsi</label>
                                            <input type="text" name="description" value="{{ $pkg->description }}">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label>Harga</label>
                                            <input type="number" name="price" value="{{ $pkg->price }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Harga Asli</label>
                                            <input type="number" name="original_price" value="{{ $pkg->original_price }}">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label>Maks Orang</label>
                                            <input type="number" name="max_people" value="{{ $pkg->max_people }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Urutan</label>
                                            <input type="number" name="sort_order" value="{{ $pkg->sort_order }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-check">
                                            <input type="checkbox" name="is_active" value="1" {{ $pkg->is_active ? 'checked' : '' }}> Aktif
                                        </label>
                                    </div>
                                    <button type="submit" class="btn btn-primary" style="font-size:13px;"><i class="fas fa-save"></i> Update</button>
                                    <button type="button" onclick="toggleEditPaket({{ $pkg->id }})" class="btn btn-secondary" style="font-size:13px;">Batal</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p style="color:#6b7280; text-align:center; padding:24px 0;">Belum ada paket. Klik "Tambah Paket" untuk menambahkan.</p>
            @endif
        </div>
    </div>

<script>
function toggleEditPaket(id) {
    const el = document.getElementById('edit-paket-' + id);
    el.style.display = el.style.display === 'none' ? 'block' : 'none';
}

    @php
        $itemsData = $tour->itinerary_items ?? [];
        $items = is_array($itemsData) && array_key_exists('items', $itemsData) ? $itemsData['items'] : $itemsData;
        $itemCount = count($items);
    @endphp
    let itemCount = {{ $itemCount }};

function addItineraryItem() {
    const list = document.getElementById('itinerary-list');
    const emptyMsg = document.getElementById('empty-msg');
    if (emptyMsg) emptyMsg.remove();

    const idx = itemCount++;
    const num = list.querySelectorAll('.itinerary-item-row').length + 1;

    const div = document.createElement('div');
    div.className = 'itinerary-item-row';
    div.style.cssText = 'background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:16px; position:relative;';
    div.innerHTML = `
        <div style="display:flex; align-items:center; gap:8px; margin-bottom:12px;">
            <div style="width:28px; height:28px; background:#1B3A4B; color:white; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700;">${num}</div>
<select name="itinerary_time[]" style="flex:1; padding:8px 12px; border:1px solid #d1d5db; border-radius:6px; font-size:13px;">
                @php
                    $defaultTime = '06:00';
                @endphp
                @for($h=6;$h<=20;$h++)
                    @foreach(['00','30'] as $m)
                        @php $t = sprintf('%02d:%s', $h, $m); @endphp
                        <option value="{{ $t }}" {{ $defaultTime === $t ? 'selected' : '' }}>{{ $t }}</option>
                    @endforeach
                @endfor
            </select>
            <button type="button" onclick="removeItem(this)" style="background:#fee2e2; border:none; color:#dc2626; width:28px; height:28px; border-radius:6px; cursor:pointer; font-size:14px;">×</button>
        </div>
        <textarea name="itinerary_desc[]" placeholder="Deskripsi kegiatan..."
            style="width:100%; padding:8px 12px; border:1px solid #d1d5db; border-radius:6px; font-size:13px; resize:vertical; min-height:60px; margin-bottom:12px;"></textarea>
        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:12px; margin-bottom:12px;">
            <div>
                <label style="font-size:12px; font-weight:600; color:#6b7280; display:block; margin-bottom:6px;">What's Included</label>
                <textarea name="itinerary_included[]" placeholder="Termasuk..." style="width:100%; padding:8px 12px; border:1px solid #d1d5db; border-radius:6px; font-size:13px; resize:vertical; min-height:80px;"></textarea>
            </div>
            <div>
                <label style="font-size:12px; font-weight:600; color:#6b7280; display:block; margin-bottom:6px;">What's Excluded</label>
                <textarea name="itinerary_excluded[]" placeholder="Tidak termasuk..." style="width:100%; padding:8px 12px; border:1px solid #d1d5db; border-radius:6px; font-size:13px; resize:vertical; min-height:80px;"></textarea>
            </div>
        </div>
        <div style="display:flex; align-items:center; gap:12px;">
            <div style="flex:1;">
                <label style="font-size:12px; font-weight:600; color:#6b7280; display:block; margin-bottom:6px;"><i class="fas fa-camera"></i> Foto Lokasi</label>
                <input type="file" name="itinerary_photo[${idx}]" accept="image/*" onchange="previewPhoto(this)" style="font-size:12px; width:100%;">
                <input type="hidden" name="itinerary_photo_existing[${idx}]" value="">
            </div>
            <div style="width:100px; height:70px; background:#f1f5f9; border:2px dashed #cbd5e1; border-radius:8px; display:flex; align-items:center; justify-content:center; overflow:hidden; flex-shrink:0;">
                <img class="photo-preview" style="display:none; width:100%; height:100%; object-fit:cover;">
                <i class="fas fa-image" style="color:#94a3b8; font-size:22px;"></i>
            </div>
        </div>
    `;
    list.appendChild(div);
    renumberItems();
}

function removeItem(btn) {
    btn.closest('.itinerary-item-row').remove();
    renumberItems();
    const list = document.getElementById('itinerary-list');
    if (list.querySelectorAll('.itinerary-item-row').length === 0) {
        list.innerHTML = '<p id="empty-msg" style="text-align:center; color:#94a3b8; font-size:13px; padding:16px 0;">Belum ada item. Klik "Tambah Item" untuk mulai.</p>';
    }
}

function renumberItems() {
    document.querySelectorAll('.itinerary-item-row').forEach((row, i) => {
        const badge = row.querySelector('div[style*="border-radius:50%"]');
        if (badge) badge.textContent = i + 1;
    });
}

function previewPhoto(input) {
    const row = input.closest('.itinerary-item-row');
    const preview = row.querySelector('.photo-preview');
    const icon = row.querySelector('.fa-image');
    if (input.files && input.files[0] && preview) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.style.display = 'block';
            if (icon) icon.style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function clearPhoto(btn) {
    const wrapper = btn.closest('div[style*="position:relative"]');
    const hiddenInput = wrapper.closest('div[style*="display:flex"]').querySelector('input[type=hidden]');
    if (hiddenInput) hiddenInput.value = '';
    wrapper.innerHTML = '<div style="width:80px; height:60px; background:#f1f5f9; border:2px dashed #cbd5e1; border-radius:6px; display:flex; align-items:center; justify-content:center;"><i class="fas fa-image" style="color:#94a3b8; font-size:20px;"></i></div>';
}
</script>
@endsection

