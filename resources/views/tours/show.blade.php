@extends('layouts.tripway')

@section('title', $tour->title . ' - TripWay')

@section('styles')
<style>
    .tour-detail {
        @apply grid grid-cols-1 lg:grid-cols-[1fr_440px] gap-8 lg:gap-8 py-8 max-w-6xl mx-auto px-6;
        align-items: start;
    }
    .tour-detail > div:nth-child(2) {
        @apply sticky top-20 self-start max-h-[calc(100vh-5rem)] overflow-visible z-10 min-w-[440px];
    }
    @media (max-width: 1023px) {
        .tour-detail { grid-template-columns: 1fr; }
    }

    .tour-gallery {
        border-radius: var(--radius);
        overflow: hidden;
        height: 420px;
        margin-bottom: 24px;
    }
    .tour-gallery img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .tour-header { margin-bottom: 24px; }
    .tour-header .category {
        font-size: 13px;
        color: var(--primary);
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 8px;
    }
    .tour-header h1 {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 12px;
        line-height: 1.3;
    }
    .tour-header .meta {
        display: flex;
        gap: 20px;
        font-size: 14px;
        color: var(--text-light);
    }
    .tour-header .meta i { margin-right: 4px; }

    .tour-rating-big {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 16px;
    }
    .tour-rating-big .stars { color: #ffc107; font-size: 16px; }
    .tour-rating-big .score { font-size: 18px; font-weight: 700; }
    .tour-rating-big .reviews { color: var(--text-light); font-size: 14px; }

    .info-section { margin-bottom: 32px; }
    .info-section h2 { font-size: 20px; font-weight: 700; margin-bottom: 16px; }
    .info-section p { font-size: 15px; color: var(--text-medium); line-height: 1.8; }

    .highlights-list { list-style: none; }
    .highlights-list li {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 12px;
        font-size: 15px;
        color: var(--text-medium);
    }
    .highlights-list li i { color: var(--secondary); margin-top: 3px; }

    .booking-card {
        background: white;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 24px;
        position: sticky;
        top: 140px;
    }

    /* Panel itinerary (render via JS) */
    #detail-itinerary-items .it-item { 
        display: flex; 
        gap: 16px; 
        margin-bottom: 12px;
        padding-bottom: 12px;
        border-bottom: 1px solid var(--border);
        align-items: flex-start;
    }
    #detail-itinerary-items .it-item:last-child { border-bottom: none; margin-bottom: 0; }

    .related-tours {
        margin-top: 48px;
        padding-top: 48px;
        border-top: 1px solid var(--border);
    }
    .related-tours h2 { font-size: 22px; font-weight: 700; margin-bottom: 24px; }
    .related-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }

    .tour-card {
        background: white;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
        transition: all 0.2s;
    }
    .tour-card:hover { box-shadow: var(--shadow-lg); transform: translateY(-4px); }

    .tour-image { position: relative; height: 180px; overflow: hidden; }
    .tour-image img { width: 100%; height: 100%; object-fit: cover; }
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
    .tour-footer {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        border-top: 1px solid var(--border);
        padding-top: 12px;
    }
    .tour-price-label { font-size: 12px; color: var(--text-light); }
    .tour-price { font-size: 18px; font-weight: 700; color: var(--text-dark); }

    @media (max-width: 1024px) {
        .related-grid { grid-template-columns: repeat(2, 1fr); }
        .booking-card { position: static; }
    }
    @media (max-width: 1023px) {
        .tour-layout-grid { grid-template-columns: 1fr !important; }
    }
    @media (max-width: 768px) {
        html, body { overflow-x: hidden; }
        .related-grid { grid-template-columns: 1fr; }
        .tour-gallery { height: 260px !important; }
        .tour-gallery-carousel { height: 260px !important; }
        .tour-page { padding-left: 16px !important; padding-right: 16px !important; }
    }
</style>
@endsection

@section('content')
<div class="tour-page" style="max-width:1400px; margin:0 auto; padding:32px 48px; box-sizing:border-box; width:100%;">

    {{-- Layout: 2 kolom atas (kiri: info, kanan: booking+rincian) --}}
    <div class="tour-layout-grid" style="display:grid; grid-template-columns:420px 1fr; gap:32px; align-items:start; width:100%; box-sizing:border-box;">

        {{-- Kolom Kiri: Info Tour --}}
        <div style="min-width:0;">
                <div class="tour-gallery-carousel" style="position:relative; border-radius:var(--radius); overflow:hidden; height:420px; background:#1B3A4B; margin-bottom: 24px; box-shadow: var(--shadow-md);">
                    @php
                        $mediaList = [];
                        if($tour->image) {
                            $mediaList[] = ['type' => 'image', 'url' => $tour->image];
                        }
                        if(!empty($tour->gallery) && is_array($tour->gallery)) {
                            foreach($tour->gallery as $g) {
                                $isVideo = preg_match('/\.(mp4|mov|webm)$/i', $g);
                                $mediaList[] = ['type' => $isVideo ? 'video' : 'image', 'url' => $g];
                            }
                        }
                        if(count($mediaList) == 0) {
                            $mediaList[] = ['type' => 'image', 'url' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=1200'];
                        }
                    @endphp

                    @foreach($mediaList as $index => $media)
                        <div class="carousel-slide" data-index="{{ $index }}" style="display: {{ $index == 0 ? 'block' : 'none' }}; width:100%; height:100%; transition: opacity 0.3s ease;">
                            @if($media['type'] == 'video')
                                <video src="{{ $media['url'] }}" controls style="width:100%; height:100%; object-fit:contain; background:#000;"></video>
                            @else
                                <img src="{{ $media['url'] }}" alt="{{ $tour->title }}" style="width:100%; height:100%; object-fit:cover;">
                            @endif
                        </div>
                    @endforeach

                    @if(count($mediaList) > 1)
                        <button onclick="prevSlide()" style="position:absolute; top:50%; left:16px; transform:translateY(-50%); background:rgba(0,0,0,0.5); color:white; border:none; width:40px; height:40px; border-radius:50%; cursor:pointer; display:flex; align-items:center; justify-content:center; z-index:10; backdrop-filter:blur(4px); transition: background 0.2s;">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button onclick="nextSlide()" style="position:absolute; top:50%; right:16px; transform:translateY(-50%); background:rgba(0,0,0,0.5); color:white; border:none; width:40px; height:40px; border-radius:50%; cursor:pointer; display:flex; align-items:center; justify-content:center; z-index:10; backdrop-filter:blur(4px); transition: background 0.2s;">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                        <div style="position:absolute; bottom:16px; left:50%; transform:translateX(-50%); display:flex; gap:8px; z-index:10; background:rgba(0,0,0,0.3); padding:8px 12px; border-radius:20px; backdrop-filter:blur(4px);">
                            @foreach($mediaList as $index => $media)
                                <div class="carousel-dot" onclick="goToSlide({{ $index }})" data-index="{{ $index }}" style="width:8px; height:8px; border-radius:50%; background:{{ $index == 0 ? '#fff' : 'rgba(255,255,255,0.4)' }}; cursor:pointer; transition:all 0.3s ease; transform: {{ $index == 0 ? 'scale(1.2)' : 'scale(1)' }};"></div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <script>
                    let currentSlide = 0;
                    const slides = document.querySelectorAll('.carousel-slide');
                    const dots = document.querySelectorAll('.carousel-dot');

                    function showSlide(index) {
                        if(slides.length === 0) return;
                        
                        slides.forEach(slide => {
                            const video = slide.querySelector('video');
                            if(video) video.pause();
                        });

                        if(index >= slides.length) currentSlide = 0;
                        else if(index < 0) currentSlide = slides.length - 1;
                        else currentSlide = index;

                        slides.forEach((slide, i) => {
                            slide.style.display = i === currentSlide ? 'block' : 'none';
                        });
                        dots.forEach((dot, i) => {
                            dot.style.background = i === currentSlide ? '#fff' : 'rgba(255,255,255,0.4)';
                            dot.style.transform = i === currentSlide ? 'scale(1.2)' : 'scale(1)';
                        });
                    }

                    function nextSlide() { showSlide(currentSlide + 1); }
                    function prevSlide() { showSlide(currentSlide - 1); }
                    function goToSlide(index) { showSlide(index); }
                </script>

                 <div class="tour-header">
                     <div class="category">{{ $tour->category->name }} &middot; {{ $tour->destination->name }}</div>
                     <h1 style="font-size:28px; font-weight:700; margin-bottom:12px; line-height:1.3;">{{ $tour->title }}</h1>
                     @if($tour->price)
                     <div class="tour-price" style="font-size:18px; font-weight:700; color:#1B3A4B; margin:8px 0;">
                         Harga Tour: Rp {{ number_format($tour->price, 0, ',', '.') }}
                         @if($tour->original_price && $tour->original_price > $tour->price)
                             <span style="font-size:14px; color:#9ca3af; text-decoration:line-through; margin-left:8px; font-weight:400;">Rp {{ number_format($tour->original_price, 0, ',', '.') }}</span>
                         @endif
                     </div>
                     @endif
                     <div class="meta">
                         <span><i class="far fa-clock"></i> {{ $tour->duration }} {{ $tour->duration_type == 'hours' ? 'jam' : 'hari' }}</span>
                         <span><i class="fas fa-users"></i> Max {{ $tour->max_people }} orang</span>
                         <span><i class="fas fa-map-marker-alt"></i> {{ $tour->destination->name }}</span>
                     </div>
                 </div>

                @if($tour->rating > 0)
                <div class="tour-rating-big">
                    <span class="stars">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star" style="{{ $i > round($tour->rating) ? 'opacity:0.3' : '' }}"></i>
                        @endfor
                    </span>
                    <span class="score">{{ $tour->rating }}</span>
                    <span class="reviews">({{ $tour->review_count }} ulasan)</span>
                </div>
                @endif

                <div class="info-section">
                    <h2>Tentang Aktivitas Ini</h2>
                    <p>{{ $tour->description }}</p>
                </div>

                @if($tour->highlights)
                <div class="info-section">
                    <h2>Highlight</h2>
                    <ul class="highlights-list">
                        @foreach(explode("\n", $tour->highlights) as $highlight)
                            @if(trim($highlight))
                            <li><i class="fas fa-check-circle"></i> {{ trim($highlight) }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>

        {{-- Kolom Kanan: Booking + Rincian Paket --}}
        <div style="min-width:0;">
            <div style="display:flex; gap:20px; align-items:stretch; width:100%;">
                <!-- Panel Booking -->
                <div style="flex:1; min-width:0; overflow:hidden;">
                    @include('tours.booking-pilihan-paket-green')
                </div>

                <!-- Panel Detail Paket -->
                <div id="panel-detail-paket" style="flex:1; min-width:0; overflow:hidden; display:none; align-self:stretch;">
                    <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden" style="height:100%;">
                        <div class="p-5 border-b border-slate-100 bg-gradient-to-br from-slate-50 to-slate-100">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-xs text-gray-500 uppercase tracking-wide font-semibold mb-1">Rincian Paket</p>
                                    <h3 id="detail-nama" class="text-lg font-black text-[#1B3A4B]"></h3>
                                </div>
                                <button onclick="document.getElementById('panel-detail-paket').style.display='none'" class="text-gray-400 hover:text-gray-600 text-lg">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="mt-3 flex items-end gap-2">
                                <span id="detail-harga" class="text-2xl font-black text-[#1B3A4B]"></span>
                                <span id="detail-harga-asli" class="text-sm text-gray-400 line-through"></span>
                                <span id="detail-diskon" class="text-xs font-bold bg-[#1B3A4B] text-white px-2 py-0.5 rounded-full"></span>
                            </div>
                        </div>

                        <div class="p-5 space-y-5 overflow-y-auto">
                            <!-- Info Paket -->
                            <div class="grid grid-cols-2 gap-3">
                                <div class="bg-slate-50 rounded-xl p-3 text-center">
                                    <i class="fas fa-users text-[#1B3A4B] mb-1"></i>
                                    <p class="text-xs text-gray-500">Maks Peserta</p>
                                    <p id="detail-max" class="font-bold text-sm text-gray-800"></p>
                                </div>
                                <div class="bg-slate-50 rounded-xl p-3 text-center">
                                    <i class="fas fa-clock text-[#1B3A4B] mb-1"></i>
                                    <p class="text-xs text-gray-500">Durasi</p>
                                    <p class="font-bold text-sm text-gray-800">{{ $tour->duration }} {{ $tour->duration_type == 'hours' ? 'jam' : 'hari' }}</p>
                                </div>
                            </div>

                            <!-- Deskripsi Paket -->
                            <div id="detail-desc-wrap">
                                <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Deskripsi</p>
                                <p id="detail-desc" class="text-sm text-gray-600 leading-relaxed"></p>
                            </div>

                            <!-- Itinerary Paket (render via JS) - TAMPIL PERTAMA -->
                            <div id="detail-itinerary-container">
                                <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Jadwal Perjalanan</p>
                                <div class="relative">
                                    <div class="absolute left-[14px] top-0 bottom-0 w-0.5 bg-slate-200"></div>
                                    <div class="space-y-3">
                                        <div class="space-y-3" id="detail-itinerary-items"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Termasuk (Tour Level) -->
                            @if($tour->inclusions)
                            <div id="tour-inclusions">
                                <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Sudah Termasuk</p>
                                <ul class="space-y-1.5">
                                    @foreach(explode("\n", $tour->inclusions) as $item)
                                        @if(trim($item))
                                        <li class="flex items-start gap-2 text-sm text-gray-600">
                                            <i class="fas fa-check-circle text-[#1B3A4B] mt-0.5 shrink-0"></i>
                                            {{ trim($item) }}
                                        </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            <!-- Termasuk (Package Level) -->
                            <div id="package-included" style="display:none;">
                                <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Sudah Termasuk (Paket)</p>
                                <ul class="space-y-1.5" id="package-included-list"></ul>
                            </div>

                            <!-- Tidak Termasuk (Tour Level) -->
                            @if($tour->exclusions)
                            <div id="tour-exclusions">
                                <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Tidak Termasuk</p>
                                <ul class="space-y-1.5">
                                    @foreach(explode("\n", $tour->exclusions) as $item)
                                        @if(trim($item))
                                        <li class="flex items-start gap-2 text-sm text-gray-600">
                                            <i class="fas fa-times-circle text-red-400 mt-0.5 shrink-0"></i>
                                            {{ trim($item) }}
                                        </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            <!-- Tidak Termasuk (Package Level) -->
                            <div id="package-excluded" style="display:none;">
                                <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5">Tidak Termasuk (Paket)</p>
                                <ul class="space-y-1.5" id="package-excluded-list"></ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Ulasan --}}
    @if($reviews->count() > 0 || $tour->rating > 0)
    @php
        $ratingCounts = [5,4,3,2,1];
        $ratings = [];
        foreach ($ratingCounts as $r) {
            $count = $reviewStats[$r] ?? 0;
            $pct = $totalReviews > 0 ? round($count / $totalReviews * 100) : 0;
            $ratings[$r] = ['count' => $count, 'pct' => $pct];
        }
        $sortOptions = [
            'terbaru' => 'Terbaru',
            'terlama' => 'Terlama',
            'rating_tertinggi' => 'Rating Tertinggi',
            'rating_terendah' => 'Rating Terendah',
        ];
        $ratingTabs = [
            '' => 'Semua',
            '5' => '5 ',
            '4' => '4 ',
            '3' => '3 ',
            '2' => '2 ',
            '1' => '1 ',
        ];
    @endphp
    <div style="margin-top:48px; padding-top:32px; border-top:1px solid #e2e8f0;">
        <h2 style="font-size:20px; font-weight:700; color:#1B3A4B; margin-bottom:24px;">Ulasan</h2>
        <div class="review-layout" style="display:flex; gap:40px; align-items:flex-start;">
            <div class="review-summary" style="width:35%; flex-shrink:0;">
                <div style="padding:24px; background:#f8fafc; border-radius:12px;">
                    <div style="text-align:center;">
                        <div style="font-size:44px; font-weight:800; color:#1B3A4B; line-height:1;">{{ number_format($tour->rating, 1) }}</div>
                        <div style="color:#ffc107; font-size:16px; margin:6px 0;">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star" style="{{ $i > round($tour->rating) ? 'opacity:0.2' : '' }}"></i>
                            @endfor
                        </div>
                        <div style="font-size:14px; color:#64748b;">{{ $totalReviews }} ulasan</div>
                    </div>
                    <div style="margin-top:20px;">
                        @foreach($ratingCounts as $r)
                        <div style="display:flex; align-items:center; gap:8px; margin-bottom:6px;">
                            <span style="font-size:13px; color:#475569; min-width:36px; white-space:nowrap;">{{ $r }} <i class="fas fa-star" style="color:#ffc107; font-size:10px;"></i></span>
                            <div style="flex:1; height:8px; background:#e2e8f0; border-radius:4px; overflow:hidden;">
                                <div style="height:100%; width:{{ $ratings[$r]['pct'] }}%; background:#ffc107; border-radius:4px; transition:width 0.3s;"></div>
                            </div>
                            <span style="font-size:12px; color:#64748b; min-width:30px; text-align:right;">{{ $ratings[$r]['pct'] }}%</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="review-list" style="flex:1; min-width:0;">
                <div style="display:flex; gap:8px; margin-bottom:16px; flex-wrap:wrap;">
                    @foreach($ratingTabs as $key => $label)
                    <a href="{{ request()->fullUrlWithQuery(['rating' => $key ?: null, 'page' => null]) }}" style="padding:6px 14px; font-size:13px; border-radius:20px; text-decoration:none; transition:all 0.2s; font-weight:{{ $ratingFilter == $key ? '600' : '400' }}; background:{{ $ratingFilter == $key ? '#1B3A4B' : '#f1f5f9' }}; color:{{ $ratingFilter == $key ? '#fff' : '#475569' }};">
                        {{ $label }}@if($key)<i class="fas fa-star" style="font-size:10px;"></i>@endif
                    </a>
                    @endforeach
                </div>
                <div style="display:flex; align-items:center; gap:12px; margin-bottom:20px; flex-wrap:wrap;">
                    <span style="font-size:14px; color:#475569; font-weight:500;">Urutkan:</span>
                    <div style="display:flex; gap:6px; flex-wrap:wrap;">
                        @foreach($sortOptions as $key => $label)
                        <a href="{{ request()->fullUrlWithQuery(['sort' => $key]) }}" style="padding:6px 14px; font-size:13px; border-radius:20px; text-decoration:none; transition:all 0.2s; font-weight:{{ $sort === $key ? '600' : '400' }}; background:{{ $sort === $key ? '#1B3A4B' : '#f1f5f9' }}; color:{{ $sort === $key ? '#fff' : '#475569' }};">
                            {{ $label }}
                        </a>
                        @endforeach
                    </div>
                </div>

                @forelse($reviews as $review)
                <div style="padding:20px 0; border-bottom:1px solid #e2e8f0;">
                    <div style="display:flex; gap:12px;">
                        <div style="width:40px; height:40px; border-radius:50%; background:#1B3A4B; display:flex; align-items:center; justify-content:center; color:white; font-weight:700; font-size:16px; flex-shrink:0;">
                            {{ strtoupper(substr($review->user_name, 0, 1)) }}
                        </div>
                        <div style="flex:1; min-width:0;">
                            <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
                                <span style="font-weight:600; font-size:14px; color:#1e293b;">{{ $review->user_name }}</span>
                                <span style="color:#ffc107; font-size:12px;">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star" style="{{ $i > $review->rating ? 'opacity:0.2' : '' }}"></i>
                                    @endfor
                                </span>
                                <span style="font-size:12px; color:#94a3b8;">
                                    {{ $review->reviewed_at ? $review->reviewed_at->format('d M Y') : $review->created_at->format('d M Y') }}
                                </span>
                            </div>
                            <p style="margin:8px 0 0; font-size:14px; color:#475569; line-height:1.6;">{{ $review->comment }}</p>
                            @if($review->photos && count($review->photos) > 0)
                            <div style="display:flex; gap:8px; margin-top:12px; flex-wrap:wrap;">
                                @foreach($review->photos as $photo)
                                <a href="{{ Storage::url($photo) }}" target="_blank">
                                    <img src="{{ Storage::url($photo) }}" alt="Foto review" style="width:80px; height:80px; object-fit:cover; border-radius:8px; border:1px solid #e2e8f0;">
                                </a>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <p style="text-align:center; color:#94a3b8; padding:40px 0;">Belum ada ulasan.</p>
                @endforelse

                <div style="margin-top:24px;">
                    {{ $reviews->appends(['rating' => $ratingFilter, 'sort' => $sort])->links('vendor.pagination.admin') }}
                </div>
            </div>
        </div>
        <style>
            @media (max-width: 768px) {
                .review-layout { flex-direction: column !important; gap: 24px !important; }
                .review-summary { width: 100% !important; }
            }
        </style>
    </div>
    @endif

    {{-- Tour Serupa: di bawah, berjejer horizontal --}}
    @if($relatedTours->count() > 0)
    <div style="margin-top:48px; padding-top:32px; border-top:1px solid #e2e8f0;">
        <h2 style="font-size:20px; font-weight:700; color:#1B3A4B; margin-bottom:20px;">Tour Serupa</h2>
        <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(280px, 1fr)); gap:20px;">
            @foreach($relatedTours as $rt)
            <a href="{{ route('tours.show', $rt->slug) }}" style="display:block; background:white; border:1px solid #e2e8f0; border-radius:14px; overflow:hidden; text-decoration:none; box-shadow:0 2px 8px rgba(0,0,0,0.06); transition:all 0.2s;" onmouseover="this.style.boxShadow='0 8px 24px rgba(27,58,75,0.15)'; this.style.transform='translateY(-3px)'" onmouseout="this.style.boxShadow='0 2px 8px rgba(0,0,0,0.06)'; this.style.transform='translateY(0)'">
                <div style="position:relative; height:220px; overflow:hidden;">
                    <img src="{{ $rt->image ?? 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=400' }}" alt="{{ $rt->title }}" style="width:100%; height:100%; object-fit:cover; display:block;">
                    <div style="position:absolute; top:10px; left:10px; background:rgba(27,58,75,0.85); color:white; font-size:10px; font-weight:700; padding:4px 10px; border-radius:20px; text-transform:uppercase;">{{ $rt->category->name }}</div>
                </div>
                <div style="padding:14px 16px;">
                    <div style="font-size:14px; font-weight:700; color:#1e293b; line-height:1.4; margin-bottom:10px;">{{ $rt->title }}</div>
                    <div style="display:flex; align-items:center; justify-content:space-between;">
                        <div style="font-size:12px; color:#64748b;"><i class="far fa-clock" style="margin-right:4px;"></i>{{ $rt->duration }} {{ $rt->duration_type == 'hours' ? 'jam' : 'hari' }}</div>
                        <div style="text-align:right;">
                            <div style="font-size:10px; color:#94a3b8;">Mulai dari</div>
                            <div style="font-size:15px; font-weight:800; color:#1B3A4B;">Rp {{ number_format($rt->price, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

</div>

<script>
    const tourPackages = @json($tour->activePackages);

    // Hapus hanya untuk preview UI di halaman ini (tidak menyimpan ke DB)
    function removeItineraryItem(btn) {
        try {
            if (!btn) return;
            const row = btn.closest('.it-item');
            if (row) {
                row.remove();
                return;
            }

            // fallback: kalau struktur DOM berubah, coba cari item terdekat secara manual
            const container = document.getElementById('detail-itinerary-items');
            if (!container) return;
            const all = Array.from(container.querySelectorAll('.it-item'));

            // hapus node yang posisinya paling dekat dengan tombol
            let closest = null;
            let best = Infinity;
            const bRect = btn.getBoundingClientRect();
            all.forEach((el) => {
                const r = el.getBoundingClientRect();
                const dx = Math.abs((r.left + r.width/2) - (bRect.left + bRect.width/2));
                const dy = Math.abs((r.top + r.height/2) - (bRect.top + bRect.height/2));
                const dist = dx + dy;
                if (dist < best) { best = dist; closest = el; }
            });

            if (closest) closest.remove();
        } catch (e) {
            console.error('removeItineraryItem failed', e);
        }
    }



function renderItinerary(items) {
        const container = document.getElementById('detail-itinerary-items');
        if (!container) return;

        // hard reset
        container.innerHTML = '';

        // Deduplicate items (in case of data duplication)
        const uniq = new Map();
        if (Array.isArray(items)) {
            items.forEach((it) => {
                const key = `${it?.time ?? ''}__${it?.desc ?? ''}__${it?.photo ?? ''}`;
                if (!uniq.has(key)) uniq.set(key, it);
            });
        }
        items = uniq.size ? Array.from(uniq.values()) : items;
        items = uniq.size ? Array.from(uniq.values()) : items;

        // Hilangkan item “yang terlalu banyak” dengan cara batasi render.
        // Ini khusus untuk itinerary paket supaya tampilan tidak membengkak jika data tersimpan dobel.
        const MAX_ITINERARY_ITEMS = 6;
        if (items.length > MAX_ITINERARY_ITEMS) {
            items = items.slice(0, MAX_ITINERARY_ITEMS);
        }



        if (!items || items.length === 0) {

            container.innerHTML = `
                <div class="it-item">
                    <div class="w-9 h-9 rounded-full bg-[#1B3A4B] text-white flex items-center justify-center text-xs font-bold shrink-0 z-10">-</div>
                    <div class="flex-1 pb-1">
                        <p class="text-xs font-bold text-[#1B3A4B] mb-0.5">Belum ada itinerary</p>
                        <p class="text-sm text-gray-600">Pilih paket yang memiliki itinerary.</p>
                    </div>
                </div>
            `;
            return;

        }

        items.forEach((it, idx) => {
            const time = it?.time ?? '';
            const desc = it?.desc ?? '';
            const photo = it?.photo ?? '';

            const photoHtml = photo ? `
                <img src="${photo}" alt="${time}" style="width:100%; max-height:140px; object-fit:cover; border-radius:10px; border:1px solid #e2e8f0;">
            ` : '';

            container.insertAdjacentHTML('beforeend', `
<div class="it-item">
                    <div class="w-9 h-9 rounded-full bg-[#1B3A4B] text-white flex items-center justify-center text-xs font-bold shrink-0 z-10">${idx + 1}</div>
                    <div class="flex-1 pb-1">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-xs font-bold text-[#1B3A4B] mb-0.5">${time}</p>
                                <p class="text-sm text-gray-600 mb-2">${desc}</p>
                            </div>
                        </div>
                        ${photoHtml}
                    </div>
                </div>
            `);
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        const hasPackageItinerary = Array.isArray(tourPackages) && tourPackages.some(p => {
            const items = p?.itinerary_items;
            const arr = Array.isArray(items) ? items : (items?.items || []);
            return arr.length > 0;
        });
        if (!hasPackageItinerary) {
            const defaultRaw = @json($tour->itinerary_items ?? []);
            const defaultItems = Array.isArray(defaultRaw) ? defaultRaw : (defaultRaw?.items ?? []);
            renderItinerary(defaultItems);
        }

        document.querySelectorAll('.pilihan-paket-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const id = parseInt(this.dataset.packageId);
                const pkg = tourPackages.find(p => p.id === id);
                if (!pkg) return;
                renderItinerary([]);

                document.getElementById('detail-nama').textContent = pkg.name;
                document.getElementById('detail-harga').textContent = 'Rp ' + parseInt(pkg.price).toLocaleString('id-ID');
                document.getElementById('detail-max').textContent = pkg.max_people + ' orang';

                const hargaAsliEl = document.getElementById('detail-harga-asli');
                const diskonEl = document.getElementById('detail-diskon');
                if (pkg.original_price && pkg.original_price > pkg.price) {
                    const pct = Math.round((pkg.original_price - pkg.price) / pkg.original_price * 100);
                    hargaAsliEl.textContent = 'Rp ' + parseInt(pkg.original_price).toLocaleString('id-ID');
                    diskonEl.textContent = '-' + pct + '%';
                    hargaAsliEl.classList.remove('hidden');
                    diskonEl.classList.remove('hidden');
                } else {
                    hargaAsliEl.textContent = '';
                    diskonEl.textContent = '';
                }

                const descWrap = document.getElementById('detail-desc-wrap');
                const descEl = document.getElementById('detail-desc');
                if (pkg.description) {
                    descEl.textContent = pkg.description;
                    descWrap.classList.remove('hidden');
                } else {
                    descWrap.classList.add('hidden');
                }

                const tourInclusions = document.getElementById('tour-inclusions');
                const tourExclusions = document.getElementById('tour-exclusions');
                const packageIncluded = document.getElementById('package-included');
                const packageExcluded = document.getElementById('package-excluded');
                const packageIncludedList = document.getElementById('package-included-list');
                const packageExcludedList = document.getElementById('package-excluded-list');

                if (tourInclusions) tourInclusions.style.display = 'block';
                if (tourExclusions) tourExclusions.style.display = 'block';
                if (packageIncluded) packageIncluded.style.display = 'none';
                if (packageExcluded) packageExcluded.style.display = 'none';

                if (packageIncludedList) packageIncludedList.innerHTML = '';
                if (packageExcludedList) packageExcludedList.innerHTML = '';

                if (pkg.included) {
                    if (tourInclusions) tourInclusions.style.display = 'none';
                    if (packageIncluded) packageIncluded.style.display = 'block';
                    const lines = (pkg.included || '').split('\n').filter(line => line.trim());
                    lines.forEach(line => {
                        packageIncludedList.insertAdjacentHTML('beforeend',
                            `<li class="flex items-start gap-2 text-sm text-gray-600"><i class="fas fa-check-circle text-[#1B3A4B] mt-0.5 shrink-0"></i> ${line.trim()}</li>`
                        );
                    });
                }

                if (pkg.excluded) {
                    if (tourExclusions) tourExclusions.style.display = 'none';
                    if (packageExcluded) packageExcluded.style.display = 'block';
                    const lines = (pkg.excluded || '').split('\n').filter(line => line.trim());
                    lines.forEach(line => {
                        packageExcludedList.insertAdjacentHTML('beforeend',
                            `<li class="flex items-start gap-2 text-sm text-gray-600"><i class="fas fa-times-circle text-red-400 mt-0.5 shrink-0"></i> ${line.trim()}</li>`
                        );
                    });
                }

                const pkgItems = pkg?.itinerary_items ? (Array.isArray(pkg.itinerary_items) ? pkg.itinerary_items : (pkg.itinerary_items.items || [])) : [];
                renderItinerary(pkgItems);

                document.getElementById('panel-detail-paket').style.display = 'block';
            });
        });
    }); 
</script>
@endsection

