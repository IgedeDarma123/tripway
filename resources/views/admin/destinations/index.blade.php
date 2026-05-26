@extends('layouts.admin')

@section('title', 'Destinasi')

@section('content')
    <div class="page-header">
        <h1>Kelola Destinasi</h1>
    </div>

    <div class="two-columns">
        <div class="card">
            <div class="card-header">
                <h2>Daftar Destinasi</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Slug</th>
                                <th>Tour Count</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($destinations as $dest)
                            <tr>
                                <td><strong>{{ $dest->name }}</strong></td>
                                <td>{{ $dest->slug }}</td>
                                <td>{{ $dest->tour_count }}</td>
                                <td>
                                    <div style="display: flex; gap: 6px;">
                                        <button type="button" class="btn btn-sm btn-secondary btn-icon" onclick="editDestination({{ $dest->id }}, '{{ $dest->name }}', '{{ $dest->slug }}', '{{ $dest->image }}', '{{ $dest->description }}')" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('admin.destinations.destroy', $dest) }}" method="POST" id="del-dest-{{ $dest->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger btn-icon" title="Hapus" onclick="confirmAdminDelete('del-dest-{{ $dest->id }}', '{{ addslashes($dest->name) }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" style="text-align: center; color: var(--text-light);">Belum ada destinasi.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $destinations->links('vendor.pagination.admin') }}
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2 id="form-title">Tambah Destinasi</h2>
            </div>
            <div class="card-body">
                <form id="destination-form" action="{{ route('admin.destinations.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Nama *</label>
                        <input type="text" name="name" id="dest-name" required>
                    </div>
                    <div class="form-group">
                        <label>Slug (opsional)</label>
                        <input type="text" name="slug" id="dest-slug">
                    </div>
                    <div class="form-group">
                        <label>URL Gambar</label>
                        <input type="text" name="image" id="dest-image" placeholder="https://...">
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Latitude</label>
                            <input type="text" name="latitude" id="dest-lat" placeholder="e.g. -8.515078">
                        </div>
                        <div class="form-group">
                            <label>Longitude</label>
                            <input type="text" name="longitude" id="dest-lng" placeholder="e.g. 115.263093">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="description" id="dest-description" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" id="dest-submit">
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
        function editDestination(id, name, slug, image, description) {
            document.getElementById('form-title').textContent = 'Edit Destinasi';
            document.getElementById('destination-form').action = '/admin/destinations/' + id;
            
            let methodInput = document.getElementById('dest-method');
            if (!methodInput) {
                methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.id = 'dest-method';
                document.getElementById('destination-form').appendChild(methodInput);
            }
            methodInput.value = 'PUT';

            document.getElementById('dest-name').value = name;
            document.getElementById('dest-slug').value = slug;
            document.getElementById('dest-image').value = image || '';
            document.getElementById('dest-description').value = description || '';
            document.getElementById('dest-submit').innerHTML = '<i class="fas fa-save"></i> Update';
        }

        function resetForm() {
            document.getElementById('form-title').textContent = 'Tambah Destinasi';
            document.getElementById('destination-form').action = '{{ route('admin.destinations.store') }}';
            document.getElementById('dest-name').value = '';
            document.getElementById('dest-slug').value = '';
            document.getElementById('dest-image').value = '';
            document.getElementById('dest-description').value = '';
            document.getElementById('dest-submit').innerHTML = '<i class="fas fa-save"></i> Simpan';
            const methodInput = document.getElementById('dest-method');
            if (methodInput) methodInput.remove();
        }
    </script>
@endsection

