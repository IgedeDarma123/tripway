@extends('layouts.admin')

@section('title', 'Tambah Tour')

@section('content')
    <div class="page-header">
        <h1>Tambah Tour Baru</h1>
        <a href="{{ route('admin.tours.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.tours.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-row">
                    <div class="form-group">
                        <label>Judul Tour *</label>
                        <input type="text" name="title" value="{{ old('title') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Slug (opsional)</label>
                        <input type="text" name="slug" value="{{ old('slug') }}" placeholder="auto-generate">
                    </div>
                </div>

                <div class="form-group">
                    <label>Deskripsi *</label>
                    <textarea name="description" required>{{ old('description') }}</textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Kategori *</label>
                        <select name="category_id" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Destinasi *</label>
                        <select name="destination_id" required>
                            <option value="">Pilih Destinasi</option>
                            @foreach($destinations as $dest)
                                <option value="{{ $dest->id }}" {{ old('destination_id') == $dest->id ? 'selected' : '' }}>{{ $dest->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Durasi *</label>
                        <input type="text" name="duration" value="{{ old('duration') }}" placeholder="5" required>
                    </div>
                    <div class="form-group">
                        <label>Tipe Durasi *</label>
                        <select name="duration_type" required>
                            <option value="hours" {{ old('duration_type') == 'hours' ? 'selected' : '' }}>Jam</option>
                            <option value="days" {{ old('duration_type') == 'days' ? 'selected' : '' }}>Hari</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Harga (Rp) *</label>
                        <input type="number" name="price" value="{{ old('price') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Harga Asli (Rp) (opsional)</label>
                        <input type="number" name="original_price" value="{{ old('original_price') }}">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Min Peserta</label>
                        <input type="number" name="min_people" value="{{ old('min_people', 1) }}" min="1">
                    </div>
                    <div class="form-group">
                        <label>Max Peserta</label>
                        <input type="number" name="max_people" value="{{ old('max_people', 10) }}" min="1">
                    </div>
                </div>

                <div class="form-group">
                    <label>Gambar Utama (Cover)</label>
                    <input type="file" name="image_file" accept="image/*">
                    <small style="color: var(--text-light);">Atau masukkan URL gambar:</small>
                    <input type="text" name="image" value="{{ old('image') }}" placeholder="https://..." style="margin-top: 6px;">
                </div>

                <div class="form-group">
                    <label>Galeri (Foto & Video) - bisa lebih dari satu</label>
                    <input type="file" name="gallery_files[]" id="gallery-input" accept="image/*,video/*" multiple onchange="previewGallery()">
                    <small style="color: var(--text-light); display:block; margin-top:4px;">
                        Tahan tombol <b>Ctrl</b> (Windows) atau <b>Command</b> (Mac) saat memilih untuk upload lebih dari satu file sekaligus.<br>
                        Foto: jpg/png/webp. Video: mp4/mov/webm
                    </small>
                    <div id="gallery-preview" style="display:flex; flex-wrap:wrap; gap:10px; margin-top:12px;"></div>
                </div>

                <script>
                function previewGallery() {
                    const preview = document.getElementById('gallery-preview');
                    const fileInput = document.getElementById('gallery-input');
                    preview.innerHTML = ''; // clear old previews
                    
                    if (fileInput.files) {
                        Array.from(fileInput.files).forEach(file => {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                const isVideo = file.type.startsWith('video/');
                                const el = isVideo 
                                    ? `<video src="${e.target.result}" style="width:120px; height:80px; object-fit:cover; border-radius:8px; border:1px solid var(--border);"></video>`
                                    : `<img src="${e.target.result}" style="width:120px; height:80px; object-fit:cover; border-radius:8px; border:1px solid var(--border);">`;
                                preview.innerHTML += el;
                            }
                            reader.readAsDataURL(file);
                        });
                    }
                }
                </script>


                <div class="form-group">
                    <label>Highlight (satu per baris)</label>
                    <textarea name="highlights" rows="4" placeholder="Rafting di sungai sepanjang 12 km&#10;Pemandangan hutan tropis">{{ old('highlights') }}</textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-check">
                            <input type="hidden" name="is_featured" value="0">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                            Tampilkan di Featured
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="form-check">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            Aktif
                        </label>
                    </div>
                </div>

                <div class="form-group" style="margin-top: 24px;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Tour
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

