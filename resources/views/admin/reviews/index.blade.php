@extends('layouts.admin')

@section('title', 'Review & Fake Review')

@section('content')
    <div class="page-header">
        <h1>Kelola Review & Fake Review</h1>
    </div>

    <div class="two-columns">
        <div class="card">
            <div class="card-header">
                <h2>Tambah Review Manual</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.reviews.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Tour *</label>
                        <select name="tour_id" required>
                            <option value="">Pilih Tour</option>
                            @foreach($tours as $t)
                                <option value="{{ $t->id }}">{{ $t->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nama User *</label>
                        <input type="text" name="user_name" required placeholder="Nama pengulas">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="user_email" placeholder="email@example.com">
                    </div>
                    <div class="form-group">
                        <label>Rating *</label>
                        <select name="rating" required>
                            <option value="5">5 - Sangat Bagus</option>
                            <option value="4">4 - Bagus</option>
                            <option value="3">3 - Cukup</option>
                            <option value="2">2 - Kurang</option>
                            <option value="1">1 - Sangat Buruk</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Komentar *</label>
                        <textarea name="comment" rows="4" required placeholder="Tulis komentar review..."></textarea>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Review</label>
                        <input type="date" name="reviewed_at" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="form-group">
                        <label>Foto (opsional)</label>
                        <input type="file" name="photos[]" multiple accept="image/jpeg,image/png,image/jpg,image/webp">
                        <small style="color: var(--text-light);">Format: JPG, PNG, WebP. Maks 5MB per foto.</small>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Review
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2>Generate Fake Review Otomatis</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.reviews.generate-fake') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Pilih Tour *</label>
                        <select name="tour_id" required>
                            <option value="">Pilih Tour</option>
                            @foreach($tours as $t)
                                <option value="{{ $t->id }}">{{ $t->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Jumlah Fake Review *</label>
                        <input type="number" name="count" required min="1" max="50" value="5">
                        <small style="color: var(--text-light);">Maksimal 50 review per generate. Rating otomatis 4-5 bintang.</small>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-magic"></i> Generate Fake Review
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card" style="margin-top: 24px;">
        <div class="card-header">
            <h2>Daftar Review</h2>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tour</th>
                            <th>Nama</th>
                            <th>Rating</th>
                            <th>Komentar</th>
                            <th>Foto</th>
                            <th>Tanggal</th>
                            <th>Tipe</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reviews as $review)
                        <tr>
                             <td>#{{ $review->id }}</td>
                             <td>{{ Str::limit($review->tour->title, 25) }}</td>
                             <td>{{ $review->user_name }}</td>
                             <td>
                                 <span style="color: #ffc107;">
                                     @for($i = 1; $i <= 5; $i++)
                                         <i class="fas fa-star{{ $i > $review->rating ? '-half-alt' : '' }}" style="opacity: {{ $i > $review->rating ? '0.3' : '1' }};"></i>
                                     @endfor
                                 </span>
                                 {{ $review->rating }}
                             </td>
                             <td>{{ Str::limit($review->comment, 50) }}</td>
                             <td>
                                 @if($review->photos && count($review->photos) > 0)
                                     <div style="display: flex; gap: 4px; flex-wrap: wrap;">
                                         @foreach(array_slice($review->photos, 0, 3) as $photo)
                                             <a href="{{ Storage::url($photo) }}" target="_blank" title="Lihat foto">
                                                 <img src="{{ Storage::url($photo) }}" alt="Review foto" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px; border: 1px solid var(--border);">
                                             </a>
                                         @endforeach
                                         @if(count($review->photos) > 3)
                                             <span style="font-size: 11px; color: var(--text-light); align-self: center;">+{{ count($review->photos) - 3 }}</span>
                                         @endif
                                     </div>
                                 @else
                                     <span style="color: var(--text-light); font-size: 12px;">-</span>
                                 @endif
                             </td>
                             <td>{{ $review->reviewed_at ? $review->reviewed_at->format('d M Y') : '-' }}</td>
                             <td>
                                 @if($review->is_fake)
                                     <span class="badge badge-fake">Fake</span>
                                 @else
                                     <span class="badge badge-active">Real</span>
                                 @endif
                             </td>
                             <td>
                                 <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" id="del-review-{{ $review->id }}">
                                     @csrf
                                     @method('DELETE')
                                     <button type="button" class="btn btn-sm btn-danger btn-icon" title="Hapus" onclick="confirmAdminDelete('del-review-{{ $review->id }}', '{{ addslashes($review->user_name) }} - {{ addslashes(Str::limit($review->comment, 30)) }}')">
                                         <i class="fas fa-trash"></i>
                                     </button>
                                 </form>
                             </td>
                         </tr>
                        @empty
                        <tr>
                            <td colspan="9" style="text-align: center; color: var(--text-light);">Belum ada review.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $reviews->links('vendor.pagination.admin') }}
        </div>
    </div>
@endsection

