@extends('layouts.admin')

@section('title', 'Kelola Paket')

@section('content')
<div class="page-header">
    <h1><i class="fas fa-box-open" style="color:#1B3A4B;"></i> Kelola Jenis Paket</h1>
</div>

@if(session('success'))
    <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="alert alert-danger" style="background:#fee2e2; color:#991b1b; padding:12px 16px; border-radius:8px; margin-bottom:16px; border:1px solid #fecaca;">
        <strong><i class="fas fa-exclamation-circle"></i> Terjadi kesalahan:</strong>
        <ul style="margin:8px 0 0 18px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Filter Destinasi -->
<div class="card" style="margin-bottom:24px;">
    <div class="card-body" style="padding:16px 24px;">
        <form method="GET" action="{{ route('admin.packages.index') }}" style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
            <label style="font-size:13px; font-weight:600; color:var(--text-dark);">Filter Destinasi:</label>
            <select name="destination_id" onchange="this.form.submit()"
                style="padding:8px 16px; border:1px solid var(--border); border-radius:var(--radius-sm); font-size:14px; min-width:220px;">
                <option value="">Semua Destinasi</option>
                @foreach($destinations as $dest)
                    <option value="{{ $dest->id }}" {{ request('destination_id') == $dest->id ? 'selected' : '' }}>
                        {{ $dest->name }} ({{ $dest->tours_count }} tour)
                    </option>
                @endforeach
            </select>
            @if(request('destination_id'))
                <a href="{{ route('admin.packages.index') }}" style="font-size:13px; color:var(--text-light);">
                    <i class="fas fa-times"></i> Reset
                </a>
            @endif
        </form>
    </div>
</div>

@forelse($toursByDestination as $destName => $tours)
<div class="card" style="margin-bottom:24px;">
    <div class="card-header" style="background:#f8fafc; border-bottom:2px solid #1B3A4B;">
        <h2 style="font-size:16px; font-weight:700; color:#1B3A4B; margin:0;">
            <i class="fas fa-map-marker-alt" style="margin-right:8px;"></i>{{ $destName }}
        </h2>
        <span style="font-size:13px; color:var(--text-light);">{{ $tours->count() }} tour</span>
    </div>
    <div class="card-body" style="padding:0;">
        @foreach($tours as $tour)
        <div style="border-bottom:1px solid var(--border);">
            <div style="display:flex; justify-content:space-between; align-items:center; padding:16px 24px; background:white; cursor:pointer;"
                onclick="toggleTour({{ $tour->id }})">
                <div style="display:flex; align-items:center; gap:12px;">
                    <i class="fas fa-chevron-right" id="icon-{{ $tour->id }}"
                        style="color:#1B3A4B; font-size:12px; transition:transform 0.2s;"></i>
                    <div>
                        <strong style="font-size:14px;">{{ $tour->title }}</strong>
                        <div style="font-size:12px; color:var(--text-light); margin-top:2px;">
                            <i class="fas fa-tags"></i> {{ $tour->category->name }}
                            &nbsp;·&nbsp;
                            <i class="fas fa-box"></i> {{ $tour->packages->count() }} paket
                        </div>
                    </div>
                </div>
                <div style="display:flex; align-items:center; gap:8px;">
                    <span class="badge {{ $tour->packages->count() > 0 ? 'badge-active' : 'badge-inactive' }}">
                        {{ $tour->packages->count() > 0 ? $tour->packages->count().' Paket' : 'Belum ada paket' }}
                    </span>
                    <a href="{{ route('admin.tours.edit', $tour) }}" class="btn btn-sm btn-secondary"
                        style="font-size:12px;" onclick="event.stopPropagation()">
                        <i class="fas fa-edit"></i> Edit Tour
                    </a>
                </div>
            </div>

            <div id="tour-{{ $tour->id }}" style="display:none; background:#f8fafc; padding:20px 24px;">

                @if($tour->packages->count() > 0)
                @foreach($tour->packages as $pkg)
                <div style="background:white; border:1px solid #e2e8f0; border-radius:8px; margin-bottom:16px; overflow:hidden;">

                    {{-- Header Paket --}}
                    <div style="display:flex; align-items:center; padding:12px 16px; background:#f1f5f9; gap:12px;">
                        <div style="flex:1; min-width:0; overflow:hidden;">
                            <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                                <strong style="font-size:14px; white-space:nowrap;">{{ $pkg->name }}</strong>
                                @php $typeLabels = ['private'=>'Private','sharing'=>'Sharing','both'=>'Private & Sharing']; @endphp
                                <span style="white-space:nowrap; padding:2px 8px; border-radius:12px; font-size:11px; font-weight:600;
                                    background:{{ $pkg->travel_type==='private'?'#dbeafe':($pkg->travel_type==='sharing'?'#dcfce7':'#fef9c3') }};
                                    color:{{ $pkg->travel_type==='private'?'#1d4ed8':($pkg->travel_type==='sharing'?'#15803d':'#854d0e') }};">
                                    {{ $typeLabels[$pkg->travel_type ?? 'both'] ?? 'both' }}
                                </span>
                                <span style="white-space:nowrap; font-size:12px; color:#6b7280;">Rp{{ number_format($pkg->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div style="display:flex; gap:6px; flex-shrink:0; margin-left:auto;">
                            <button onclick="toggleEditPaket('{{ $pkg->id }}')" class="btn btn-sm btn-secondary" style="font-size:12px; white-space:nowrap;">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <form action="{{ route('admin.tours.packages.destroy', [$tour, $pkg]) }}" method="POST" onsubmit="return confirm('Hapus paket ini?')" style="margin:0;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" style="font-size:12px;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Form Edit Paket --}}
                    <div id="edit-paket-{{ $pkg->id }}" style="display:none; border-top:3px solid #1B3A4B;">
                        <div style="padding:20px 24px; background:#fafafa;">
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                                <h4 style="font-size:14px; font-weight:700; color:#1B3A4B; margin:0;">
                                    <i class="fas fa-edit"></i> Edit Paket — {{ $pkg->name }}
                                </h4>
                                <button type="button" onclick="toggleEditPaket('{{ $pkg->id }}')" style="background:none; border:none; color:#6b7280; cursor:pointer; font-size:18px; line-height:1;">&times;</button>
                            </div>
                        <form action="{{ route('admin.tours.packages.update', [$tour, $pkg]) }}" method="POST" enctype="multipart/form-data">
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
                                    <label>Maks Orang</label>
                                    <input type="number" name="max_people" value="{{ $pkg->max_people }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Tipe Travel *</label>
                                    <select name="travel_type" required style="width:100%; padding:8px 12px; border:1px solid var(--border); border-radius:6px; font-size:13px;">
                                        <option value="private" {{ ($pkg->travel_type ?? '') === 'private' ? 'selected' : '' }}>Private</option>
                                        <option value="sharing" {{ ($pkg->travel_type ?? '') === 'sharing' ? 'selected' : '' }}>Sharing</option>
                                        <option value="both" {{ ($pkg->travel_type ?? 'both') === 'both' ? 'selected' : '' }}>Private & Sharing</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group" style="display:flex; align-items:center; padding-top:24px;">
                                    <label class="form-check">
                                        <input type="checkbox" name="is_active" value="1" {{ $pkg->is_active ? 'checked' : '' }}> Aktif
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>What's Included</label>
                                <textarea name="included" class="list-editor-source" style="display:none;">{{ $pkg->included }}</textarea>
                                <div class="list-editor">
                                    <div class="list-editor-rows"></div>
                                    <button type="button" class="list-editor-add" style="margin-top:2px; background:#e2e8f0; border:none; border-radius:6px; padding:6px 12px; color:#475569; font-size:12px; font-weight:600; cursor:pointer;"><i class="fas fa-plus" style="margin-right:4px;"></i>Tambah Item</button>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>What's Excluded</label>
                                <textarea name="excluded" class="list-editor-source" style="display:none;">{{ $pkg->excluded }}</textarea>
                                <div class="list-editor">
                                    <div class="list-editor-rows"></div>
                                    <button type="button" class="list-editor-add" style="margin-top:2px; background:#e2e8f0; border:none; border-radius:6px; padding:6px 12px; color:#475569; font-size:12px; font-weight:600; cursor:pointer;"><i class="fas fa-plus" style="margin-right:4px;"></i>Tambah Item</button>
                                </div>
                            </div>

                            {{-- Itinerary --}}
                            <div class="form-group" style="margin-top:8px;">
                                <label style="margin:0; margin-bottom:8px; display:block;"><i class="fas fa-route"></i> Jadwal Perjalanan (Itinerary)</label>
                                <div id="itin-{{ $pkg->id }}" style="display:flex; flex-direction:column; gap:10px; padding:12px; background:#f8fafc; border:1px solid var(--border); border-radius:8px;">
                                    @php $pkgItems = $pkg->itinerary_items['items'] ?? []; @endphp
                                    @if(count($pkgItems) > 0)
                                        @foreach($pkgItems as $item)
                                        <div class="itin-row" style="background:white; border:1px solid #e2e8f0; border-radius:8px; padding:12px; position:relative;">
                                            <div class="itin-number" style="position:absolute; top:-8px; left:-8px; background:linear-gradient(135deg,#3b82f6,#2563eb); color:white; width:24px; height:24px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:700; box-shadow:0 2px 4px rgba(59,130,246,0.3);">{{ $loop->iteration }}</div>
                                            <div style="display:flex; gap:8px; align-items:center; margin-bottom:8px;">
                                                <input type="time" name="itinerary_time[{{ $loop->index }}]" value="{{ $item['time'] ?? '' }}" min="00:00" max="23:59" step="60" style="flex:1; padding:8px 12px; border:1px solid var(--border); border-radius:6px; font-size:13px;">
                                                <button type="button" onclick="removeItineraryRow(this)" style="background:#fee2e2; border:none; color:#dc2626; width:28px; height:28px; border-radius:6px; cursor:pointer;">×</button>
                                            </div>
                                            <textarea name="itinerary_desc[{{ $loop->index }}]" placeholder="Deskripsi kegiatan..." style="width:100%; padding:8px 12px; border:1px solid var(--border); border-radius:6px; font-size:13px; resize:vertical; min-height:60px; margin-bottom:8px;">{{ $item['desc'] ?? '' }}</textarea>
                                            <div style="display:flex; gap:12px; align-items:start;">
                                                <div style="flex:1;">
                                                    <label style="font-size:12px; font-weight:600; color:#6b7280; display:block; margin-bottom:4px;"><i class="fas fa-camera"></i> Foto Lokasi</label>
                                                    <input type="file" name="itinerary_photo[{{ $loop->index }}]" accept="image/*" style="font-size:12px; width:100%;">
                                                    <input type="hidden" name="itinerary_photo_existing[{{ $loop->index }}]" value="{{ $item['photo'] ?? '' }}">
                                                </div>
                                                @if(!empty($item['photo']))
                                                <img src="{{ $item['photo'] }}" style="width:80px; height:60px; object-fit:cover; border-radius:6px; border:1px solid #e2e8f0; flex-shrink:0;">
                                                @endif
                                            </div>
                                        </div>
                                        @endforeach
                                    @else
                                        <p style="margin:0; color:#94a3b8; font-size:13px;">Belum ada itinerary. Klik "Tambah Item".</p>
                                    @endif
                                </div>
                                <button type="button" onclick="addItineraryRow('itin-{{ $pkg->id }}')" class="btn btn-sm btn-primary" style="font-size:12px; margin-top:8px; float:right;">
                                    <i class="fas fa-plus"></i> Tambah Item
                                </button>
                            </div>

                            <div style="display:flex; gap:8px; margin-top:8px;">
                                <button type="submit" class="btn btn-primary" style="font-size:13px;"><i class="fas fa-save"></i> Update Paket</button>
                                <button type="button" onclick="toggleEditPaket('{{ $pkg->id }}')" class="btn btn-secondary" style="font-size:13px;">Batal</button>
                            </div>
                        </form>
                        </div>
                    </div>

                    {{-- Section Pilihan Grup (Private) --}}
                    @if(in_array($pkg->travel_type ?? 'both', ['private','both']))
                    <div style="padding:16px; border-top:1px solid #e2e8f0;">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                            <strong style="font-size:13px; color:#1d4ed8;"><i class="fas fa-users"></i> Pilihan Grup (Private)</strong>
                            <button onclick="toggleForm('form-group-{{ $pkg->id }}')" class="btn btn-sm" style="font-size:12px; background:#dbeafe; color:#1d4ed8; border:none;">
                                <i class="fas fa-plus"></i> Tambah Grup
                            </button>
                        </div>

                        {{-- Form Tambah Grup --}}
                        <div id="form-group-{{ $pkg->id }}" style="display:none; background:#eff6ff; border-radius:8px; padding:12px; margin-bottom:10px;">
                            <form action="{{ route('admin.packages.groups.store', $pkg) }}" method="POST">
                                @csrf
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
                                        <label style="font-size:12px;">Harga/Orang (Rp) *</label>
                                        <input type="number" name="price" min="0" required>
                                    </div>
                                    <div class="form-group">
                                        <label style="font-size:12px;">Harga Asli (Rp)</label>
                                        <input type="number" name="original_price" min="0">
                                    </div>
                                </div>
                                <div style="display:flex; gap:8px;">
                                    <button type="submit" class="btn btn-primary" style="font-size:12px;"><i class="fas fa-save"></i> Simpan</button>
                                    <button type="button" onclick="toggleForm('form-group-{{ $pkg->id }}')" class="btn btn-secondary" style="font-size:12px;">Batal</button>
                                </div>
                            </form>
                        </div>

                        {{-- Daftar Grup --}}
                        @if($pkg->groups->count() > 0)
                        <div style="display:flex; flex-direction:column; gap:8px;">
                            @foreach($pkg->groups as $group)
                            <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; overflow:hidden;">
                                {{-- Baris info grup --}}
                                <div style="display:flex; align-items:center; padding:10px 14px; gap:12px;">
                                    <div style="flex:1; min-width:0;">
                                        <span style="font-weight:600; font-size:13px;">{{ $group->label }}</span>
                                        <span style="margin-left:10px; font-size:12px; color:#6b7280;">{{ $group->group_size }} orang</span>
                                        <span style="margin-left:10px; font-weight:700; font-size:13px; color:#1B3A4B;">Rp{{ number_format($group->price, 0, ',', '.') }}/orang</span>
                                    </div>
                                    <div style="display:flex; gap:6px; flex-shrink:0;">
                                        <button onclick="toggleForm('edit-group-{{ $group->id }}')" class="btn btn-sm btn-secondary" style="font-size:12px;">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('admin.packages.groups.destroy', [$pkg, $group]) }}" method="POST" onsubmit="return confirm('Hapus grup ini?')" style="margin:0;">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" style="font-size:12px;">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                {{-- Form Edit Grup --}}
                                <div id="edit-group-{{ $group->id }}" style="display:none; border-top:3px solid #1d4ed8;">
                                    <div style="padding:16px 20px; background:#fafafa;">
                                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px;">
                                            <p style="font-size:13px; font-weight:700; color:#1d4ed8; margin:0;">
                                                <i class="fas fa-edit"></i> Edit Grup &mdash; {{ $group->label }}
                                            </p>
                                            <button type="button" onclick="toggleForm('edit-group-{{ $group->id }}')" style="background:none; border:none; color:#6b7280; cursor:pointer; font-size:18px; line-height:1;">&times;</button>
                                        </div>
                                        <form action="{{ route('admin.packages.groups.update', [$pkg, $group]) }}" method="POST">
                                            @csrf @method('PUT')
                                            <div class="form-row" style="grid-template-columns:1fr 1fr 1fr 1fr; gap:16px; margin-bottom:16px;">
                                                <div class="form-group" style="margin-bottom:0;">
                                                    <label>Label *</label>
                                                    <input type="text" name="label" value="{{ $group->label }}" required>
                                                </div>
                                                <div class="form-group" style="margin-bottom:0;">
                                                    <label>Jumlah Orang *</label>
                                                    <input type="number" name="group_size" value="{{ $group->group_size }}" min="1" required>
                                                </div>
                                                <div class="form-group" style="margin-bottom:0;">
                                                    <label>Harga/Orang (Rp) *</label>
                                                    <input type="number" name="price" value="{{ $group->price }}" min="0" required>
                                                </div>
                                                <div class="form-group" style="margin-bottom:0;">
                                                    <label>Harga Asli (Rp)</label>
                                                    <input type="number" name="original_price" value="{{ $group->original_price }}" min="0">
                                                </div>
                                            </div>
                                            <div style="display:flex; gap:8px;">
                                                <button type="submit" class="btn btn-primary" style="font-size:13px;"><i class="fas fa-save"></i> Simpan</button>
                                                <button type="button" onclick="toggleForm('edit-group-{{ $group->id }}')" class="btn btn-secondary" style="font-size:13px;">Batal</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p style="font-size:12px; color:#94a3b8; margin:0;">Belum ada pilihan grup.</p>
                        @endif
                    </div>
                    @endif

                    {{-- Section Sharing --}}
                    @if(in_array($pkg->travel_type ?? 'both', ['sharing','both']))
                    <div style="padding:16px; border-top:1px solid #e2e8f0;">
                        <strong style="font-size:13px; color:#30525c;"><i class="fas fa-users"></i> Sharing</strong>
                        <form action="{{ route('admin.packages.sharing.update', $pkg) }}" method="POST" style="display:flex; gap:10px; align-items:flex-end; margin-top:10px;">
                            @csrf @method('PUT')
                            <div class="form-group" style="flex:1; margin-bottom:0;">
                                <label style="font-size:12px;">Harga Sharing/Orang (Rp)</label>
                                <input type="number" name="sharing_price" value="{{ $pkg->sharing_price }}" min="0" placeholder="Kosong = ikuti harga paket">
                            </div>
                            <button type="submit" class="btn btn-primary" style="font-size:12px; white-space:nowrap;"><i class="fas fa-save"></i> Simpan</button>
                        </form>
                    </div>
                    @endif

                    {{-- Section Add-on (Sharing) --}}
                    @if(in_array($pkg->travel_type ?? 'both', ['sharing','both']))
                    <div style="padding:16px; border-top:1px solid #e2e8f0;">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                            <strong style="font-size:13px; color:#15803d;"><i class="fas fa-plus-circle"></i> Add-on (Sharing)</strong>
                            <button onclick="toggleForm('form-addon-{{ $pkg->id }}')" class="btn btn-sm" style="font-size:12px; background:#dcfce7; color:#15803d; border:none;">
                                <i class="fas fa-plus"></i> Tambah Add-on
                            </button>
                        </div>

                        {{-- Form Tambah Add-on --}}
                        <div id="form-addon-{{ $pkg->id }}" style="display:none; background:#f0fdf4; border-radius:8px; padding:12px; margin-bottom:10px;">
                            <form action="{{ route('admin.packages.addons.store', $pkg) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label style="font-size:12px;">Nama Add-on *</label>
                                    <input type="text" name="name" required placeholder="cth: Sewa Snorkel">
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label style="font-size:12px;">Harga (Rp) *</label>
                                        <input type="number" name="price" min="0" required placeholder="cth: 50000">
                                    </div>
                                    <div class="form-group">
                                        <label style="font-size:12px;">Deskripsi</label>
                                        <input type="text" name="description" placeholder="Keterangan singkat">
                                    </div>
                                </div>
                                <div style="display:flex; gap:8px;">
                                    <button type="submit" class="btn btn-primary" style="font-size:12px;"><i class="fas fa-save"></i> Simpan</button>
                                    <button type="button" onclick="toggleForm('form-addon-{{ $pkg->id }}')" class="btn btn-secondary" style="font-size:12px;">Batal</button>
                                </div>
                            </form>
                        </div>

                        {{-- Daftar Add-on --}}
                        @if($pkg->addons->count() > 0)
                        <div style="display:flex; flex-direction:column; gap:8px;">
                            @foreach($pkg->addons as $addon)
                            <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; overflow:hidden;">
                                <div style="display:flex; align-items:center; padding:10px 14px; gap:12px;">
                                    <div style="flex:1; min-width:0;">
                                        <span style="font-weight:600; font-size:13px;">{{ $addon->name }}</span>
                                        @if($addon->description)
                                        <span style="margin-left:8px; font-size:12px; color:#9ca3af;">{{ $addon->description }}</span>
                                        @endif
                                        <span style="margin-left:10px; font-weight:700; font-size:13px; color:#15803d;">Rp{{ number_format($addon->price, 0, ',', '.') }}</span>
                                    </div>
                                    <div style="display:flex; gap:6px; flex-shrink:0;">
                                        <button onclick="toggleForm('edit-addon-{{ $addon->id }}')" class="btn btn-sm btn-secondary" style="font-size:12px;">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('admin.packages.addons.destroy', [$pkg, $addon]) }}" method="POST" onsubmit="return confirm('Hapus add-on ini?')" style="margin:0;">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" style="font-size:12px;">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div id="edit-addon-{{ $addon->id }}" style="display:none; border-top:3px solid #15803d;">
                                    <div style="padding:16px 20px; background:#fafafa;">
                                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px;">
                                            <p style="font-size:13px; font-weight:700; color:#15803d; margin:0;">
                                                <i class="fas fa-edit"></i> Edit Add-on &mdash; {{ $addon->name }}
                                            </p>
                                            <button type="button" onclick="toggleForm('edit-addon-{{ $addon->id }}')" style="background:none; border:none; color:#6b7280; cursor:pointer; font-size:18px; line-height:1;">&times;</button>
                                        </div>
                                        <form action="{{ route('admin.packages.addons.update', [$pkg, $addon]) }}" method="POST">
                                            @csrf @method('PUT')
                                            <div class="form-row" style="grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">
                                                <div class="form-group" style="margin-bottom:0;">
                                                    <label>Nama Add-on *</label>
                                                    <input type="text" name="name" value="{{ $addon->name }}" required>
                                                </div>
                                                <div class="form-group" style="margin-bottom:0;">
                                                    <label>Deskripsi</label>
                                                    <input type="text" name="description" value="{{ $addon->description }}">
                                                </div>
                                            </div>
                                            <div class="form-group" style="margin-bottom:16px;">
                                                <label>Harga (Rp)</label>
                                                <input type="number" name="price" min="0" value="{{ $addon->price }}" required>
                                            </div>
                                            <div style="display:flex; gap:8px;">
                                                <button type="submit" class="btn btn-primary" style="font-size:13px;"><i class="fas fa-save"></i> Simpan</button>
                                                <button type="button" onclick="toggleForm('edit-addon-{{ $addon->id }}')" class="btn btn-secondary" style="font-size:13px;">Batal</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p style="font-size:12px; color:#94a3b8; margin:0;">Belum ada add-on.</p>
                        @endif
                    </div>
                    @endif

                </div>
                @endforeach
                @else
                <p style="color:#6b7280; font-size:13px; margin-bottom:16px;">Belum ada paket untuk tour ini.</p>
                @endif

                {{-- Form Tambah Paket --}}
                <button onclick="toggleForm('tambah-paket-{{ $tour->id }}')" class="btn btn-primary" style="font-size:13px; margin-bottom:12px;">
                    <i class="fas fa-plus"></i> Tambah Paket
                </button>
                <div id="tambah-paket-{{ $tour->id }}" style="display:none; background:white; border:1px solid #e2e8f0; border-radius:8px; padding:20px;">
                    <h4 style="font-size:14px; font-weight:600; margin-bottom:16px; color:#1B3A4B;">
                        <i class="fas fa-plus-circle"></i> Tambah Paket — {{ $tour->title }}
                    </h4>
                    <form action="{{ route('admin.tours.packages.store', $tour) }}" method="POST" enctype="multipart/form-data">
                        @csrf
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
                            <div class="form-group" style="display:flex; align-items:center; padding-top:24px;">
                                <label class="form-check">
                                    <input type="checkbox" name="is_active" value="1" checked> Aktif
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>What's Included</label>
                            <textarea name="included" class="list-editor-source" style="display:none;"></textarea>
                            <div class="list-editor">
                                <div class="list-editor-rows"></div>
                                <button type="button" class="list-editor-add" style="margin-top:2px; background:#e2e8f0; border:none; border-radius:6px; padding:6px 12px; color:#475569; font-size:12px; font-weight:600; cursor:pointer;"><i class="fas fa-plus" style="margin-right:4px;"></i>Tambah Item</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>What's Excluded</label>
                            <textarea name="excluded" class="list-editor-source" style="display:none;"></textarea>
                            <div class="list-editor">
                                <div class="list-editor-rows"></div>
                                <button type="button" class="list-editor-add" style="margin-top:2px; background:#e2e8f0; border:none; border-radius:6px; padding:6px 12px; color:#475569; font-size:12px; font-weight:600; cursor:pointer;"><i class="fas fa-plus" style="margin-right:4px;"></i>Tambah Item</button>
                            </div>
                        </div>

                        {{-- Itinerary --}}
                        <div class="form-group" style="margin-top:8px;">
                            <label style="margin:0; margin-bottom:8px; display:block;"><i class="fas fa-route"></i> Jadwal Perjalanan (Itinerary)</label>
                            <div id="itin-new-{{ $tour->id }}" style="display:flex; flex-direction:column; gap:10px; padding:12px; background:#f8fafc; border:1px solid var(--border); border-radius:8px;">
                                <p style="margin:0; color:#94a3b8; font-size:13px;">Belum ada itinerary. Klik "Tambah Item".</p>
                            </div>
                            <button type="button" onclick="addItineraryRow('itin-new-{{ $tour->id }}')" class="btn btn-sm btn-primary" style="font-size:12px; margin-top:8px; float:right;">
                                <i class="fas fa-plus"></i> Tambah Item
                            </button>
                        </div>

                        <div style="display:flex; gap:8px;">
                            <button type="submit" class="btn btn-primary" style="font-size:13px;"><i class="fas fa-save"></i> Simpan Paket</button>
                            <button type="button" onclick="toggleForm('tambah-paket-{{ $tour->id }}')" class="btn btn-secondary" style="font-size:13px;">Batal</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        @endforeach
    </div>
</div>
@empty
<div class="card">
    <div class="card-body" style="text-align:center; padding:48px;">
        <i class="fas fa-box-open" style="font-size:48px; color:var(--border); margin-bottom:16px;"></i>
        <p style="color:var(--text-light);">Tidak ada tour ditemukan.</p>
    </div>
</div>
@endforelse

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
    const placeholder = container.querySelector('p');
    if (placeholder) placeholder.remove();

    const rows = container.querySelectorAll('.itin-row');
    let maxIdx = -1;
    rows.forEach(row => {
        const timeInput = row.querySelector('input[name^="itinerary_time["]');
        if (timeInput) {
            const match = timeInput.name.match(/\[(\d+)\]/);
            if (match) maxIdx = Math.max(maxIdx, parseInt(match[1]));
        }
    });
    const idx = maxIdx + 1;

    const num = rows.length + 1;

    const div = document.createElement('div');
    div.className = 'itin-row';
    div.style.cssText = 'background:white; border:1px solid #e2e8f0; border-radius:8px; padding:12px; position:relative;';
    div.innerHTML = `
        <div class="itin-number" style="position:absolute; top:-8px; left:-8px; background:linear-gradient(135deg,#3b82f6,#2563eb); color:white; width:24px; height:24px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:700; box-shadow:0 2px 4px rgba(59,130,246,0.3);">${num}</div>
        <div style="display:flex; gap:8px; align-items:center; margin-bottom:8px;">
            <input type="time" name="itinerary_time[${idx}]" min="00:00" max="23:59" step="60" style="flex:1; padding:8px 12px; border:1px solid var(--border); border-radius:6px; font-size:13px;">
            <button type="button" onclick="removeItineraryRow(this)" style="background:#fee2e2; border:none; color:#dc2626; width:28px; height:28px; border-radius:6px; cursor:pointer; font-size:14px;">×</button>
        </div>
        <textarea name="itinerary_desc[${idx}]" placeholder="Deskripsi kegiatan..." style="width:100%; padding:8px 12px; border:1px solid var(--border); border-radius:6px; font-size:13px; resize:vertical; min-height:60px; margin-bottom:8px;"></textarea>
        <div style="flex:1;">
            <label style="font-size:12px; font-weight:600; color:#6b7280; display:block; margin-bottom:4px;"><i class="fas fa-camera"></i> Foto Lokasi</label>
            <input type="file" name="itinerary_photo[${idx}]" accept="image/*" style="font-size:12px; width:100%;">
            <input type="hidden" name="itinerary_photo_existing[${idx}]" value="">
        </div>`;
    container.appendChild(div);
}

function removeItineraryRow(btn) {
    const row = btn.closest('.itin-row');
    const container = row.parentElement;
    row.remove();
    renumberItinerary(container);
}

function renumberItinerary(container) {
    const rows = container.querySelectorAll('.itin-row');
    rows.forEach((row, i) => {
        const badge = row.querySelector('.itin-number');
        if (badge) badge.textContent = i + 1;

        const timeInput = row.querySelector('input[name^="itinerary_time"]');
        if (timeInput) timeInput.name = 'itinerary_time[' + i + ']';

        const descInput = row.querySelector('textarea[name^="itinerary_desc"]');
        if (descInput) descInput.name = 'itinerary_desc[' + i + ']';

        const photoInput = row.querySelector('input[name^="itinerary_photo["]');
        if (photoInput) photoInput.name = 'itinerary_photo[' + i + ']';

        const existingInput = row.querySelector('input[name^="itinerary_photo_existing"]');
        if (existingInput) existingInput.name = 'itinerary_photo_existing[' + i + ']';
    });
}

// Editor daftar bernomor untuk "What's Included" / "What's Excluded"
function escapeListHtml(s) {
    return s.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

function syncListSource(editor) {
    const source = editor.closest('.form-group').querySelector('textarea.list-editor-source');
    if (!source) return;
    const values = Array.from(editor.querySelectorAll('.list-editor-input')).map(inp => inp.value.trim()).filter(Boolean);
    source.value = values.join('\n');
}

function renumberList(editor) {
    const rows = editor.querySelectorAll('.list-editor-row');
    rows.forEach((row, i) => {
        const num = row.querySelector('.list-editor-num');
        if (num) num.textContent = i + 1;
    });
}

function addListRow(editor, value) {
    const rowsEl = editor.querySelector('.list-editor-rows');
    if (!rowsEl) return;
    const row = document.createElement('div');
    row.className = 'list-editor-row';
    row.style.cssText = 'display:flex; gap:6px; align-items:center; margin-bottom:6px;';
    row.innerHTML = `
        <span class="list-editor-num" style="width:22px; height:22px; background:#30525c; color:white; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:700; flex-shrink:0;"></span>
        <input type="text" class="list-editor-input" value="${escapeListHtml(value)}" placeholder="Tulis item..." style="flex:1; padding:7px 10px; border:1px solid var(--border); border-radius:6px; font-size:13px;">
        <button type="button" class="list-editor-remove" style="background:#fee2e2; border:none; color:#dc2626; width:26px; height:26px; border-radius:6px; cursor:pointer; font-size:13px;">×</button>`;
    row.querySelector('.list-editor-input').addEventListener('input', () => syncListSource(editor));
    row.querySelector('.list-editor-input').addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            addListRow(editor, '');
            rowsEl.lastElementChild.querySelector('.list-editor-input').focus();
        }
    });
    row.querySelector('.list-editor-remove').addEventListener('click', () => {
        row.remove();
        renumberList(editor);
        syncListSource(editor);
    });
    rowsEl.appendChild(row);
    renumberList(editor);
    syncListSource(editor);
}

function initListEditor(editor) {
    const rowsEl = editor.querySelector('.list-editor-rows');
    const source = editor.closest('.form-group').querySelector('textarea.list-editor-source');
    if (!rowsEl || !source) return;
    rowsEl.innerHTML = '';
    (source.value || '').split('\n').map(s => s.trim()).filter(Boolean).forEach(text => addListRow(editor, text));
    if (rowsEl.children.length === 0) addListRow(editor, '');
}

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.list-editor').forEach(editor => {
        const addBtn = editor.querySelector('.list-editor-add');
        if (addBtn) addBtn.addEventListener('click', () => addListRow(editor, ''));
        initListEditor(editor);
    });
});
</script>
@endsection
