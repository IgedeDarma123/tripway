@extends('layouts.admin')

@section('title', 'Kelola Tour')

@section('content')
    <div class="page-header">
        <h1>Kelola Tour</h1>
        <a href="{{ route('admin.tours.create') }}" class="btn btn-primary">
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
                        @forelse($tours as $tour)
                        <tr>
                            <td>{{ $tour->id }}</td>
                            <td>
                                <img src="{{ $tour->image ?? 'https://via.placeholder.com/60' }}" alt="" style="width: 60px; height: 40px; object-fit: cover; border-radius: 6px;">
                            </td>
                            <td>
                                <strong>{{ Str::limit($tour->title, 40) }}</strong>
                                @if($tour->is_featured)
                                    <span class="badge badge-featured" style="margin-left: 6px;">Featured</span>
                                @endif
                            </td>
                            <td>{{ $tour->category->name }}</td>
                            <td>{{ $tour->destination->name }}</td>
                            <td>Rp {{ number_format($tour->price, 0, ',', '.') }}</td>
                            <td>
                                <i class="fas fa-star" style="color: #ffc107;"></i> {{ $tour->rating }}
                                <small style="color: var(--text-light);">({{ $tour->review_count }})</small>
                            </td>
                            <td>
                                @if($tour->is_active)
                                    <span class="badge badge-active">Aktif</span>
                                @else
                                    <span class="badge badge-inactive">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                @if($tour->is_active)
                                    <form action="{{ route('admin.tours.toggle-active', $tour) }}" method="POST" onsubmit="return confirm('Nonaktifkan tour ini?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-danger" style="font-size:12px; padding:4px 8px;">
                                            <i class="fas fa-eye-slash"></i> Nonaktifkan
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.tours.toggle-active', $tour) }}" method="POST" onsubmit="return confirm('Publis tour ini?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-success" style="font-size:12px; padding:4px 8px;">
                                            <i class="fas fa-bullhorn"></i> Publis
                                        </button>
                                    </form>
                                @endif
                            </td>

                            <td>
                                <div style="display: flex; gap: 6px;">
                                    <a href="{{ route('admin.tours.edit', $tour) }}" class="btn btn-sm btn-secondary btn-icon" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.tours.destroy', $tour) }}" method="POST" id="del-tour-{{ $tour->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger btn-icon" title="Hapus" onclick="confirmAdminDelete('del-tour-{{ $tour->id }}', '{{ addslashes($tour->title) }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" style="text-align: center; color: var(--text-light);">Belum ada tour.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

                {{ $tours->links('vendor.pagination.admin') }}
        </div>
    </div>
@endsection

