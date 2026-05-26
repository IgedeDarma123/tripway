@extends('layouts.tripway')

@section('title', 'Tour & Aktivitas Bali - TripWay')

@section('styles')
<style>
.tours-hero {
    padding: 40px 0;
    border-bottom: 1px solid var(--border);
}
.tours-hero h1 {

        font-size: 32px;
        font-weight: 700;
        margin-bottom: 8px;
    }
    .tours-hero p {
        color: var(--text-light);
        font-size: 16px;
    }
    .filter-bar {
        background: white;
        border-bottom: 1px solid var(--border);
        padding: 16px 0;
        position: sticky;
        top: 64px;
        z-index: 100;
    }
    .filter-inner {
        display: flex;
        gap: 12px;
        align-items: center;
        flex-wrap: wrap;
    }
    .filter-select {
        padding: 8px 16px;
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        font-size: 14px;
        background: white;
        cursor: pointer;
        min-width: 160px;
    }
    .tours-layout {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 32px;
        padding: 32px 0;
    }
    .sidebar {
        position: sticky;
        top: 140px;
        height: fit-content;
    }
    .sidebar-section {
        background: white;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 20px;
        margin-bottom: 16px;
    }
    .sidebar-section h4 {
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 12px;
    }
    .sidebar-list {
        list-style: none;
    }
    .sidebar-list li {
        margin-bottom: 8px;
    }
    .sidebar-list a {
        font-size: 14px;
        color: var(--text-medium);
        display: flex;
        justify-content: space-between;
    }
    .sidebar-list a:hover { color: var(--primary); }
    .sidebar-list .count {
        color: var(--text-light);
        font-size: 13px;
    }
    .tours-grid-page {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }
    .tour-card {
        background: white;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
        transition: all 0.2s;
    }
    .tour-card:hover {
        box-shadow: var(--shadow-lg);
        transform: translateY(-4px);
    }
    .tour-image {
        position: relative;
        height: 180px;
        overflow: hidden;
    }
    .tour-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .tour-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        background: var(--primary);
        color: white;
        font-size: 11px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 4px;
    }
    .tour-body { padding: 16px; }
    .tour-category {
        font-size: 12px;
        color: var(--primary);
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 6px;
    }
    .tour-title {
        font-size: 15px;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 8px;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .tour-meta {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 12px;
        font-size: 13px;
        color: var(--text-light);
    }
    .tour-rating {
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .tour-rating i { color: #ffc107; font-size: 12px; }
    .tour-rating span { color: var(--text-dark); font-weight: 600; }
    .tour-footer {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        border-top: 1px solid var(--border);
        padding-top: 12px;
    }
    .tour-price-label {
        font-size: 12px;
        color: var(--text-light);
    }
    .tour-price {
        font-size: 18px;
        font-weight: 700;
        color: var(--text-dark);
    }
    .tour-price span {
        font-size: 13px;
        color: var(--text-light);
        font-weight: 400;
    }
    .pagination {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-top: 40px;
    }
    .pagination a, .pagination span {
        padding: 8px 16px;
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        font-size: 14px;
        color: var(--text-medium);
    }
    .pagination .active {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }
    @media (max-width: 1024px) {
        .tours-layout { grid-template-columns: 1fr; }
        .sidebar { display: none; }
        .tours-grid-page { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 480px) {
        .tours-grid-page { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
    <div class="tours-hero">
        <div class="container">
            <h1>Tour & Aktivitas di Bali</h1>
            <p>
                @if(request('search'))
                    Hasil pencarian "<strong>{{ request('search') }}</strong>" — {{ $tours->total() }} tour ditemukan
                @else
                    Temukan {{ $tours->total() }} pengalaman seru yang menanti Anda
                @endif
            </p>
        </div>
    </div>

    <div class="filter-bar">
        <div class="container">
            <form class="filter-inner" method="GET" action="{{ route('tours.index') }}">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari tour, destinasi, kategori..."
                    style="padding: 8px 16px; border: 1px solid var(--border); border-radius: var(--radius-sm); font-size: 14px; min-width: 240px; outline: none; font-family: inherit;"
                    onkeydown="if(event.key==='Enter')this.form.submit()">
                <select name="destination" class="filter-select" onchange="this.form.submit()">
                    <option value="">Semua Destinasi</option>
                    @foreach($destinations as $d)
                        <option value="{{ $d->slug }}" {{ request('destination') == $d->slug ? 'selected' : '' }}>{{ $d->name }}</option>
                    @endforeach
                </select>
                <select name="category" class="filter-select" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $c)
                        <option value="{{ $c->slug }}" {{ request('category') == $c->slug ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
                <select name="sort" class="filter-select" onchange="this.form.submit()">
                    <option value="">Urutkan</option>
                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Paling Populer</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga Terendah</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                    <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
                </select>
                <button type="submit" style="padding: 8px 20px; background: var(--primary); color: white; border: none; border-radius: var(--radius-sm); font-size: 14px; font-weight: 600; cursor: pointer;">
                    <i class="fas fa-search"></i> Cari
                </button>
                @if(request()->hasAny(['search','destination','category','sort']))
                <a href="{{ route('tours.index') }}" style="font-size: 13px; color: var(--text-light); display:flex; align-items:center; gap:4px;">
                    <i class="fas fa-times"></i> Reset
                </a>
                @endif
            </form>
        </div>
    </div>

    <div class="container">
        <div class="tours-layout">
            <aside class="sidebar">
                <div class="sidebar-section">
                    <h4>Kategori</h4>
                    <ul class="sidebar-list">
                        @foreach($categories as $c)
                        <li>
                            <a href="{{ route('tours.index', ['category' => $c->slug]) }}">
                                {{ $c->name }}
                                <span class="count">{{ $c->tours->count() }}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="sidebar-section">
                    <h4>Destinasi</h4>
                    <ul class="sidebar-list">
                        @foreach($destinations as $d)
                        <li>
                            <a href="{{ route('tours.index', ['destination' => $d->slug]) }}">
                                {{ $d->name }}
                                <span class="count">{{ $d->tours->count() }}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </aside>

            <div>
                <div class="tours-grid-page">
                    @forelse($tours as $tour)
                    <a href="{{ route('tours.show', $tour->slug) }}" class="tour-card">
                        <div class="tour-image">
                            <img src="{{ $tour->image ?? 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=400' }}" alt="{{ $tour->title }}">
                            @if($tour->discountPercentage() > 0)
                                <span class="tour-badge">Hemat {{ $tour->discountPercentage() }}%</span>
                            @endif
                        </div>
                        <div class="tour-body">
                            <div class="tour-category">{{ $tour->category->name }}</div>
                            <h3 class="tour-title">{{ $tour->title }}</h3>
                            <div class="tour-meta">
                                <span><i class="far fa-clock"></i> {{ $tour->duration }} {{ $tour->duration_type == 'hours' ? 'jam' : 'hari' }}</span>
                                @if($tour->rating > 0)
                                <div class="tour-rating">
                                    <i class="fas fa-star"></i>
                                    <span>{{ $tour->rating }}</span>
                                    <span style="color:var(--text-light);font-weight:400;">({{ $tour->review_count }})</span>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="tour-footer">
                            <div>
                                <div class="tour-price-label">Mulai dari</div>
                                <div class="tour-price">Rp {{ number_format($tour->lowestPrice(), 0, ',', '.') }} <span>/ orang</span></div>
                            </div>
                        </div>
                </a>
                    @empty
                    <div style="grid-column: 1 / -1; text-align: center; padding: 60px 0;">
                        <i class="fas fa-search" style="font-size: 48px; color: var(--border); margin-bottom: 16px;"></i>
                        <h3 style="font-size: 18px; color: var(--text-medium); margin-bottom: 8px;">Tidak ada tour ditemukan</h3>
                        <p style="color: var(--text-light);">Coba ubah filter atau kata kunci pencarian Anda</p>
                    </div>
                    @endforelse
                </div>

                <div class="pagination">
                    {{ $tours->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
