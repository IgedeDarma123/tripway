@extends('layouts.tripway')

@section('title', $tour->title . ' - TripWay')

@section('styles')
<style>
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

    #detail-itinerary-items .it-item { 
        display: flex; 
        gap: 10px; 
        margin-bottom: 8px;
        padding-bottom: 8px;
        border-bottom: 1px solid var(--border);
        align-items: flex-start;
    }
    #detail-itinerary-items .it-item:last-child { border-bottom: none; margin-bottom: 0; }

    #itinerary-modal-body .it-item {
        display: flex;
        gap: 10px;
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 1px solid #e2e8f0;
        align-items: flex-start;
    }
    #itinerary-modal-body .it-item:last-child { border-bottom: none; margin-bottom: 0; }

    .related-tours {
        margin-top: 48px;
        padding-top: 48px;
        border-top: 1px solid var(--border);
    }
    .related-tours h2 { font-size: 22px; font-weight: 700; margin-bottom: 24px; }

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
        .booking-card { position: static; }
    }
    @media (max-width: 768px) {
        html, body { overflow-x: hidden; }
        .tour-gallery-grid { height: 300px !important; grid-template-columns: 1fr !important; grid-template-rows: 1fr !important; }
        .gallery-main { grid-row: auto !important; }
        .gallery-side { display: none; }
        .tour-page { padding-left: 16px !important; padding-right: 16px !important; }
        .tour-header h1 { font-size: 22px !important; line-height: 1.35 !important; overflow-wrap: anywhere; }
        .tour-title-row {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 10px !important;
        }
        .tour-price-block {
            width: 100% !important;
            text-align: left !important;
            flex-shrink: 1 !important;
        }
        .tour-price-block > div:first-child {
            justify-content: flex-start !important;
            flex-wrap: wrap;
        }
        .tour-header .meta {
            flex-wrap: wrap;
            gap: 8px 16px;
        }
        .tour-booking-anchor > div:first-child {
            flex-direction: column !important;
            align-items: stretch !important;
        }
        #panel-detail-paket {
            position: fixed !important;
            inset: 0 !important;
            z-index: 9998;
            display: none !important;
            flex: none !important;
            width: 100% !important;
            margin: 0 !important;
            padding: 16px !important;
            background: rgba(15, 23, 42, 0.55);
            overflow-y: auto !important;
        }
        #panel-detail-paket.mobile-open {
            display: flex !important;
            align-items: center;
            justify-content: center;
        }
        #panel-detail-paket > div {
            width: 100%;
            max-height: 85vh;
            overflow-y: auto !important;
            border-radius: 16px !important;
        }
        .review-layout { flex-direction: column !important; gap: 24px !important; }
        .review-summary { width: 100% !important; }
    }
</style>
@endsection

@section('content')
<div id="tour-top" class="tour-page" style="max-width:1400px; margin:0 auto; padding:32px 48px; box-sizing:border-box; width:100%;">

    {{-- Gallery: 5-panel layout (1 big left + 2x2 grid right) --}}
    @php
        $mediaList = [];
        if($tour->image) {
            $mediaList[] = ['type' => 'image', 'url' => $tour->image];
        }
        if(!empty($tour->gallery) && is_array($tour->gallery)) {
            foreach($tour->gallery as $g) {
                if(count($mediaList) >= 5) break;
                $isVideo = preg_match('/\.(mp4|mov|webm)$/i', $g);
                $mediaList[] = ['type' => $isVideo ? 'video' : 'image', 'url' => $g];
            }
        }
        if(count($mediaList) == 0) {
            $mediaList[] = ['type' => 'image', 'url' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=1200'];
        }
        $mainMedia = $mediaList[0];
        $sideMedia1 = $mediaList[1] ?? null;
        $sideMedia2 = $mediaList[2] ?? null;
        $sideMedia3 = $mediaList[3] ?? null;
        $sideMedia4 = $mediaList[4] ?? null;
    @endphp

    <div class="tour-gallery-grid" style="display:grid; grid-template-columns:2.8fr 1.2fr 1.2fr; grid-template-rows:1fr 1fr; gap:6px; height:350px; border-radius:16px; overflow:hidden; margin-bottom:40px; box-shadow:var(--shadow-md); max-width:1024px; margin-left:auto; margin-right:auto;">
        {{-- Main Image --}}
        <div class="gallery-main" style="grid-column:1; grid-row:1/3; position:relative; background:#1B3A4B; overflow:hidden;">
            @if($mainMedia['type'] == 'video')
                <video src="{{ $mainMedia['url'] }}" controls style="width:100%; height:100%; object-fit:contain; background:#000;"></video>
            @else
                <img src="{{ $mainMedia['url'] }}" alt="{{ $tour->title }}" style="width:100%; height:100%; object-fit:cover; cursor:pointer;" onclick="openGalleryModal(0)">
            @endif
            <div style="position:absolute; bottom:12px; left:12px; background:rgba(0,0,0,0.5); color:white; font-size:12px; font-weight:600; padding:4px 10px; border-radius:8px; backdrop-filter:blur(4px);">
                <i class="fas fa-camera" style="margin-right:4px;"></i> {{ count($mediaList) }} <span>{{ __("foto") }}</span>
            </div>
        </div>

        {{-- Side Image 1 (top-left) --}}
        <div class="gallery-side" style="grid-column:2; grid-row:1; background:#1B3A4B; overflow:hidden; position:relative;">
            @if($sideMedia1)
                @if($sideMedia1['type'] == 'video')
                    <video src="{{ $sideMedia1['url'] }}" controls style="width:100%; height:100%; object-fit:cover;"></video>
                @else
                    <img src="{{ $sideMedia1['url'] }}" alt="{{ $tour->title }}" style="width:100%; height:100%; object-fit:cover; cursor:pointer;" onclick="openGalleryModal(1)">
                @endif
            @else
                <div style="width:100%; height:100%; background:linear-gradient(135deg,#1B3A4B,#14505F); display:flex; align-items:center; justify-content:center;">
                    <i class="fas fa-image" style="color:rgba(255,255,255,0.2); font-size:32px;"></i>
                </div>
            @endif
        </div>

        {{-- Side Image 2 (top-right) --}}
        <div class="gallery-side" style="grid-column:3; grid-row:1; background:#1B3A4B; overflow:hidden; position:relative;">
            @if($sideMedia2)
                @if($sideMedia2['type'] == 'video')
                    <video src="{{ $sideMedia2['url'] }}" controls style="width:100%; height:100%; object-fit:cover;"></video>
                @else
                    <img src="{{ $sideMedia2['url'] }}" alt="{{ $tour->title }}" style="width:100%; height:100%; object-fit:cover; cursor:pointer;" onclick="openGalleryModal(2)">
                @endif
            @else
                <div style="width:100%; height:100%; background:linear-gradient(135deg,#1B3A4B,#14505F); display:flex; align-items:center; justify-content:center;">
                    <i class="fas fa-image" style="color:rgba(255,255,255,0.2); font-size:32px;"></i>
                </div>
            @endif
        </div>

        {{-- Side Image 3 (bottom-left) --}}
        <div class="gallery-side" style="grid-column:2; grid-row:2; background:#1B3A4B; overflow:hidden; position:relative;">
            @if($sideMedia3)
                @if($sideMedia3['type'] == 'video')
                    <video src="{{ $sideMedia3['url'] }}" controls style="width:100%; height:100%; object-fit:cover;"></video>
                @else
                    <img src="{{ $sideMedia3['url'] }}" alt="{{ $tour->title }}" style="width:100%; height:100%; object-fit:cover; cursor:pointer;" onclick="openGalleryModal(3)">
                @endif
            @else
                <div style="width:100%; height:100%; background:linear-gradient(135deg,#1B3A4B,#14505F); display:flex; align-items:center; justify-content:center;">
                    <i class="fas fa-image" style="color:rgba(255,255,255,0.2); font-size:32px;"></i>
                </div>
            @endif
        </div>

        {{-- Side Image 4 (bottom-right) --}}
        <div class="gallery-side" style="grid-column:3; grid-row:2; background:#1B3A4B; overflow:hidden; position:relative;">
            @if($sideMedia4)
                @if($sideMedia4['type'] == 'video')
                    <video src="{{ $sideMedia4['url'] }}" controls style="width:100%; height:100%; object-fit:cover;"></video>
                @else
                    <img src="{{ $sideMedia4['url'] }}" alt="{{ $tour->title }}" style="width:100%; height:100%; object-fit:cover; cursor:pointer;" onclick="openGalleryModal(4)">
                @endif
            @else
                <div style="width:100%; height:100%; background:linear-gradient(135deg,#1B3A4B,#14505F); display:flex; align-items:center; justify-content:center;">
                    <i class="fas fa-image" style="color:rgba(255,255,255,0.2); font-size:32px;"></i>
                </div>
            @endif
        </div>
    </div>

    {{-- Gallery Lightbox Modal --}}
    <div id="gallery-modal" style="display:none; position:fixed; inset:0; z-index:9999; background:rgba(0,0,0,0.9); backdrop-filter:blur(8px);" onclick="closeGalleryModal(event)">
        <button onclick="closeGalleryModal(event)" style="position:absolute; top:16px; right:16px; background:rgba(255,255,255,0.15); color:white; border:none; width:40px; height:40px; border-radius:50%; cursor:pointer; font-size:18px; z-index:10; display:flex; align-items:center; justify-content:center; transition:background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.3)'" onmouseout="this.style.background='rgba(255,255,255,0.15)'">
            <i class="fas fa-times"></i>
        </button>
        <button onclick="prevGallerySlide(event)" style="position:absolute; top:50%; left:16px; transform:translateY(-50%); background:rgba(255,255,255,0.15); color:white; border:none; width:44px; height:44px; border-radius:50%; cursor:pointer; font-size:16px; z-index:10; display:flex; align-items:center; justify-content:center; transition:background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.3)'" onmouseout="this.style.background='rgba(255,255,255,0.15)'">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button onclick="nextGallerySlide(event)" style="position:absolute; top:50%; right:16px; transform:translateY(-50%); background:rgba(255,255,255,0.15); color:white; border:none; width:44px; height:44px; border-radius:50%; cursor:pointer; font-size:16px; z-index:10; display:flex; align-items:center; justify-content:center; transition:background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.3)'" onmouseout="this.style.background='rgba(255,255,255,0.15)'">
            <i class="fas fa-chevron-right"></i>
        </button>
        <div id="gallery-modal-content" style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; padding:60px 60px 80px;">
        </div>
        <div id="gallery-modal-dots" style="position:absolute; bottom:20px; left:50%; transform:translateX(-50%); display:flex; gap:6px; z-index:10;">
        </div>
    </div>

    <script>
        const allMedia = @json($mediaList);
        let galleryIndex = 0;

        function openGalleryModal(index) {
            galleryIndex = index;
            const modal = document.getElementById('gallery-modal');
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';
            renderGalleryModal();
        }

        function closeGalleryModal(e) {
            if (e) e.stopPropagation();
            const modal = document.getElementById('gallery-modal');
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }

        function prevGallerySlide(e) {
            if (e) e.stopPropagation();
            galleryIndex = (galleryIndex - 1 + allMedia.length) % allMedia.length;
            renderGalleryModal();
        }

        function nextGallerySlide(e) {
            if (e) e.stopPropagation();
            galleryIndex = (galleryIndex + 1) % allMedia.length;
            renderGalleryModal();
        }

        function renderGalleryModal() {
            const content = document.getElementById('gallery-modal-content');
            const dotsContainer = document.getElementById('gallery-modal-dots');
            const media = allMedia[galleryIndex];

            if (media.type === 'video') {
                content.innerHTML = '<video src="' + media.url + '" controls style="max-width:90%; max-height:85vh; object-fit:contain; border-radius:8px;"></video>';
            } else {
                content.innerHTML = '<img src="' + media.url + '" alt="Gallery" style="max-width:90%; max-height:85vh; object-fit:contain; border-radius:8px;">';
            }

            let dotsHtml = '';
            allMedia.forEach((m, i) => {
                dotsHtml += '<div onclick="galleryIndex=' + i + '; renderGalleryModal();" style="width:8px; height:8px; border-radius:50%; cursor:pointer; transition:all 0.2s; background:' + (i === galleryIndex ? '#fff' : 'rgba(255,255,255,0.4)') + '; transform:' + (i === galleryIndex ? 'scale(1.3)' : 'scale(1)') + ';"></div>';
            });
            dotsContainer.innerHTML = dotsHtml;
        }
    </script>

    {{-- Tour Info --}}
    <div style="max-width:1024px; margin:0 auto 48px;">
        <div class="tour-header">
            <div class="category">{{ $tour->category->name }} &middot; {{ $tour->destination->name }}</div>
            <div class="tour-title-row" style="display:flex; justify-content:space-between; align-items:flex-start; gap:16px; margin-bottom:12px;">
                <h1 style="font-size:28px; font-weight:700; line-height:1.3; margin:0; flex:1; min-width:0;">{{ $tour->title }}</h1>
                @if($tour->price)
                <div class="tour-price-block" style="text-align:right; flex-shrink:0;">
                    <div style="display:flex; align-items:baseline; gap:6px; justify-content:flex-end;">
                        <span style="font-size:11px; color:#94a3b8; font-weight:400;">{{ __("Mulai dari") }}</span>
                        <span style="font-size:20px; font-weight:900; color:#1B3A4B; line-height:1.2;">Rp{{ number_format($tour->price, 0, ',', '.') }}</span>
                    </div>
                    <div style="font-size:11px; color:#64748b; margin-bottom:6px;">{{ __("per orang") }}</div>
                    @if($tour->original_price && $tour->original_price > $tour->price)
                        <div style="font-size:13px; color:#9ca3af; text-decoration:line-through; font-weight:400;">Rp{{ number_format($tour->original_price, 0, ',', '.') }}</div>
                    @endif
                    <div onclick="document.querySelector('.tour-booking-anchor')?.scrollIntoView({behavior:'smooth',block:'center'})" style="display:inline-block; margin-top:6px; padding:6px 14px; background:#1B3A4B; color:white; font-size:12px; font-weight:700; border-radius:8px; cursor:pointer; transition:background 0.2s;" onmouseover="this.style.background='#14505F'" onmouseout="this.style.background='#1B3A4B'">
                        <span>{{ __("Pilih Paket") }}</span> <i class="fas fa-arrow-down" style="margin-left:4px; font-size:10px;"></i>
                    </div>
                </div>
                @endif
            </div>
            <div class="meta">
                <span><i class="far fa-clock"></i> {{ $tour->duration }} @if($tour->duration_type == 'hours')<span>{{ __("jam") }}</span>@else<span>{{ __("hari") }}</span>@endif</span>
                <span><i class="fas fa-users"></i> <span>{{ __("Max") }}</span> {{ $tour->max_people }} <span>{{ __("orang") }}</span></span>
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
            <span class="reviews">({{ $tour->review_count }} <span>{{ __("ulasan") }}</span>)</span>
        </div>
        @endif

        <div class="info-section">
            <h2>{{ __("Tentang Aktivitas Ini") }}</h2>
            <p>{{ $tour->description }}</p>
        </div>

        @if($tour->highlights)
        <div class="info-section">
            <h2>{{ __("Highlight") }}</h2>
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

    {{-- Booking Panel: 2 kolom (booking + rincian) --}}
    <div class="tour-booking-anchor" style="max-width:1024px; margin:0 auto 48px;">
        <div style="display:flex; gap:20px; align-items:start;">
            <!-- Panel Booking -->
            <div style="flex:2.4; min-width:0; overflow:hidden;">
                @include('tours.booking-pilihan-paket-green')
            </div>

            <!-- Panel Detail Paket -->
            <div id="panel-detail-paket" onclick="if(event.target===this)closeDetailPaket()" style="flex:1; min-width:0; overflow:hidden; display:none;">
                <div class="rounded-xl shadow-lg border border-slate-200 overflow-hidden" style="background:#f1f5f9;">
                    <div class="px-4 py-3 border-b border-slate-100 bg-gradient-to-br from-slate-50 to-slate-100">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-[10px] text-gray-500 uppercase tracking-wide font-semibold mb-0.5">{{ __("Rincian Paket") }}</p>
                                <h3 id="detail-nama" class="text-sm font-black text-[#1B3A4B]"></h3>
                            </div>
                            <button onclick="closeDetailPaket()" class="text-gray-400 hover:text-gray-600 text-sm">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <div class="px-4 py-3 space-y-3 overflow-y-auto">
                        <div class="grid grid-cols-2 gap-2">
                            <div class="bg-slate-50 rounded-lg p-2 text-center">
                                <i class="fas fa-users text-[#1B3A4B] mb-0.5 text-xs"></i>
                                <p class="text-[10px] text-gray-500">{{ __("Maks Peserta") }}</p>
                                <p id="detail-max" class="font-bold text-xs text-gray-800"></p>
                            </div>
                            <div class="bg-slate-50 rounded-lg p-2 text-center">
                                <i class="fas fa-clock text-[#1B3A4B] mb-0.5 text-xs"></i>
                                <p class="text-[10px] text-gray-500">{{ __("Durasi") }}</p>
                                <p id="detail-durasi" class="font-bold text-xs text-gray-800">{{ $tour->duration }} @if($tour->duration_type == 'hours')<span>{{ __("jam") }}</span>@else<span>{{ __("hari") }}</span>@endif</p>
                            </div>
                        </div>

                        <div id="detail-desc-wrap">
                            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wide mb-1">{{ __("Deskripsi") }}</p>
                            <p id="detail-desc" class="text-xs text-gray-600 leading-relaxed"></p>
                        </div>

                        <div id="detail-itinerary-container">
                            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wide mb-1.5">{{ __("Jadwal Perjalanan") }}</p>
                            <div class="relative">
                                <div class="absolute left-[14px] top-0 bottom-0 w-0.5 bg-slate-200"></div>
                                <div class="space-y-2">
                                    <div class="space-y-2" id="detail-itinerary-items"></div>
                                </div>
                            </div>
                        </div>

                        @if($tour->inclusions)
                        <div id="tour-inclusions">
                            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wide mb-1">{{ __("Sudah Termasuk") }}</p>
                            <ul class="space-y-1">
                                @foreach(explode("\n", $tour->inclusions) as $item)
                                    @if(trim($item))
                                    <li class="flex items-start gap-1.5 text-xs text-gray-600">
                                        <i class="fas fa-check-circle text-[#1B3A4B] mt-0.5 shrink-0 text-[10px]"></i>
                                        {{ trim($item) }}
                                    </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <div id="package-included" style="display:none;">
                            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wide mb-1">{{ __("Sudah Termasuk (Paket)") }}</p>
                            <ul class="space-y-1" id="package-included-list"></ul>
                        </div>

                        @if($tour->exclusions)
                        <div id="tour-exclusions">
                            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wide mb-1">{{ __("Tidak Termasuk") }}</p>
                            <ul class="space-y-1">
                                @foreach(explode("\n", $tour->exclusions) as $item)
                                    @if(trim($item))
                                    <li class="flex items-start gap-1.5 text-xs text-gray-600">
                                        <i class="fas fa-times-circle text-red-400 mt-0.5 shrink-0 text-[10px]"></i>
                                        {{ trim($item) }}
                                    </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <div id="package-excluded" style="display:none;">
                            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wide mb-1">{{ __("Tidak Termasuk (Paket)") }}</p>
                            <ul class="space-y-1" id="package-excluded-list"></ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <button type="button" id="mobile-detail-trigger" onclick="openDetailPaketMobile()" style="display:none; width:100%; margin-top:12px; align-items:center; justify-content:space-between; gap:12px; padding:12px 14px; background:#fff; border:1px solid #e2e8f0; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,0.06); font-size:13px; font-weight:700; color:#1B3A4B; cursor:pointer;">
            <span style="display:flex; align-items:center; gap:8px; min-width:0;">
                <i class="fas fa-info-circle"></i>
                <span style="overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ __("Rincian:") }} <span id="mobile-detail-name"></span></span>
            </span>
            <span style="display:flex; align-items:center; gap:6px; color:#64748b; font-size:12px; font-weight:600; flex-shrink:0;">
                Lihat <i class="fas fa-chevron-right" style="font-size:10px;"></i>
            </span>
        </button>
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
            'terbaru' => __('Terbaru'),
            'terlama' => __('Terlama'),
            'rating_tertinggi' => __('Rating Tertinggi'),
            'rating_terendah' => __('Rating Terendah'),
        ];
        $sortI18n = [
            'terbaru' => 'show.rating.newest',
            'terlama' => 'show.rating.oldest',
            'rating_tertinggi' => 'show.rating.highest',
            'rating_terendah' => 'show.rating.lowest',
        ];
        $ratingTabs = [
            '' => __('Semua'),
            '5' => '5 ',
            '4' => '4 ',
            '3' => '3 ',
            '2' => '2 ',
            '1' => '1 ',
        ];
    @endphp
    <div style="margin-top:48px; padding-top:32px; border-top:1px solid #e2e8f0;">
        <h2 style="font-size:20px; font-weight:700; color:#1B3A4B; margin-bottom:24px;">{{ __("Ulasan") }}</h2>
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
                        <div style="font-size:14px; color:#64748b;">{{ $totalReviews }} <span>{{ __("ulasan") }}</span></div>
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
                        @if($key === '')<span>{{ __("Semua") }}</span>@else{{ $label }}@endif @if($key)<i class="fas fa-star" style="font-size:10px;"></i>@endif
                    </a>
                    @endforeach
                </div>
                <div style="display:flex; align-items:center; gap:12px; margin-bottom:20px; flex-wrap:wrap;">
                    <span style="font-size:14px; color:#475569; font-weight:500;">{{ __("Urutkan:") }}</span>
                    <div style="display:flex; gap:6px; flex-wrap:wrap;">
                        @foreach($sortOptions as $key => $label)
                        <a href="{{ request()->fullUrlWithQuery(['sort' => $key]) }}" style="padding:6px 14px; font-size:13px; border-radius:20px; text-decoration:none; transition:all 0.2s; font-weight:{{ $sort === $key ? '600' : '400' }}; background:{{ $sort === $key ? '#1B3A4B' : '#f1f5f9' }}; color:{{ $sort === $key ? '#fff' : '#475569' }};">
                            <span>{{ $label }}</span>
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
                <p style="text-align:center; color:#94a3b8; padding:40px 0;">{{ __("Belum ada ulasan.") }}</p>
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
        <h2 style="font-size:20px; font-weight:700; color:#1B3A4B; margin-bottom:20px;">{{ __("Tour Serupa") }}</h2>
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
                        <div style="font-size:12px; color:#64748b;"><i class="far fa-clock" style="margin-right:4px;"></i>{{ $rt->duration }} @if($rt->duration_type == 'hours')<span>{{ __("jam") }}</span>@else<span>{{ __("hari") }}</span>@endif</div>
                        <div style="text-align:right;">
                            <div style="font-size:10px; color:#94a3b8;">{{ __("Mulai dari") }}</div>
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

<!-- Modal Lihat Semua Jadwal -->
<div id="itinerary-modal" onclick="if(event.target===this)closeItineraryModal()" style="display:none; position:fixed; inset:0; z-index:9999; background:rgba(15,23,42,0.55); align-items:center; justify-content:center; padding:16px;">
    <div style="background:#fff; width:100%; max-width:700px; max-height:85vh; border-radius:16px; overflow:hidden; display:flex; flex-direction:column; box-shadow:0 20px 50px rgba(0,0,0,0.3);">
        <div style="display:flex; justify-content:space-between; align-items:center; padding:14px 16px; border-bottom:1px solid #e2e8f0; background:#f8fafc;">
            <strong id="itinerary-modal-title" style="font-size:13px; color:#1B3A4B;">{{ __("Jadwal Perjalanan") }}</strong>
            <button type="button" onclick="closeItineraryModal()" style="background:none; border:none; color:#64748b; font-size:16px; cursor:pointer;" aria-label="{{ __("Tutup") }}"><i class="fas fa-times"></i></button>
        </div>
        <div id="itinerary-modal-body" style="padding:16px; overflow-y:auto;"></div>
    </div>
</div>

<script>
    if ('scrollRestoration' in history) {
        history.scrollRestoration = 'manual';
    }
    window.scrollTo(0, 0);

    function isMobileView() {
        return window.matchMedia('(max-width: 768px)').matches;
    }

    function openDetailPaketMobile() {
        const panel = document.getElementById('panel-detail-paket');
        if (!panel) return;
        panel.style.display = 'flex';
        panel.classList.add('mobile-open');
        document.body.style.overflow = 'hidden';
    }

    function closeDetailPaket() {
        var panel = document.getElementById('panel-detail-paket');
        if (!panel) return;
        panel.style.display = 'none';
        panel.classList.remove('mobile-open');
        document.body.style.overflow = '';
        if (isMobileView()) return;
        var top = document.getElementById('tour-top');
        if (top) {
            top.scrollIntoView();
            window.scrollBy(0, -80);
        }
    }

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





        if (!items || items.length === 0) {

            container.innerHTML = `
                <div class="it-item">
                    <div class="w-7 h-7 rounded-full bg-[#1B3A4B] text-white flex items-center justify-center text-[10px] font-bold shrink-0 z-10">-</div>
                    <div class="flex-1 pb-0.5">
                        <p class="text-[10px] font-bold text-[#1B3A4B] mb-0.5">{{ __("Belum ada itinerary") }}</p>
                        <p class="text-xs text-gray-600">{{ __("Pilih paket yang memiliki itinerary.") }}</p>
                    </div>
                </div>
            `;
            return;

        }

        const INITIAL_SHOW = 3;
        const hasMore = items.length > INITIAL_SHOW;

        items.forEach((it, idx) => {
            const time = it?.time ?? '';
            const desc = it?.desc ?? '';
            const photo = it?.photo ?? '';

            const photoHtml = photo ? `
                <img src="${photo}" alt="${time}" style="width:100%; max-height:140px; object-fit:cover; border-radius:10px; border:1px solid #e2e8f0;">
            ` : '';

            const hidden = (hasMore && idx >= INITIAL_SHOW) ? ' style="display:none;"' : '';

            container.insertAdjacentHTML('beforeend', `
<div class="it-item" data-itin-idx="${idx}"${hidden}>
                    <div class="w-7 h-7 rounded-full bg-[#1B3A4B] text-white flex items-center justify-center text-[10px] font-bold shrink-0 z-10">${idx + 1}</div>
                    <div class="flex-1 pb-0.5">
                        <div class="flex items-start justify-between gap-2">
                            <div>
                                <p class="text-[10px] font-bold text-[#1B3A4B] mb-0.5">${time}</p>
                                <p class="text-xs text-gray-600 mb-1">${desc}</p>
                            </div>
                        </div>
                        ${photoHtml}
                    </div>
                </div>
            `);
        });

        if (hasMore) {
            const remaining = items.length - INITIAL_SHOW;
            container.insertAdjacentHTML('beforeend', `
                <div style="text-align:center; padding:8px 0 0;">
                    <button type="button" onclick="openItineraryModal()" style="background:none; border:1px solid #1B3A4B; color:#1B3A4B; padding:6px 18px; border-radius:20px; font-size:12px; font-weight:600; cursor:pointer;">
                        {{ __("Lihat Semua") }} (${items.length} {{ __("jadwal") }}) <i class="fas fa-expand" style="margin-left:4px; font-size:10px;"></i>
                    </button>
                </div>
            `);
        }
    }

    function openItineraryModal() {
        const source = document.getElementById('detail-itinerary-items');
        const body = document.getElementById('itinerary-modal-body');
        const title = document.getElementById('itinerary-modal-title');
        const modal = document.getElementById('itinerary-modal');
        if (!source || !body || !modal) return;

        const nodes = source.querySelectorAll('.it-item[data-itin-idx]');
        const count = nodes.length;
        if (count === 0) return;

        const nama = (document.getElementById('detail-nama')?.textContent || '').trim();
        const peserta = (document.getElementById('detail-max')?.textContent || '').trim();
        const durasi = (document.getElementById('detail-durasi')?.textContent || '').trim();

        let summary = '';
        if (nama) summary += '<div class="text-sm font-black" style="color:#1B3A4B;">' + nama + '</div>';
        if (peserta || durasi) {
            summary += '<div class="grid grid-cols-2 gap-2" style="margin-top:10px;">';
            if (peserta) {
                summary += '<div class="bg-slate-50 rounded-lg p-2 text-center"><i class="fas fa-users" style="color:#1B3A4B; margin-bottom:2px; font-size:12px;"></i><p class="text-[10px] text-gray-500">{{ __("Maks Peserta") }}</p><p class="font-bold text-xs text-gray-800">' + peserta + '</p></div>';
            } else {
                summary += '<div></div>';
            }
            summary += '<div class="bg-slate-50 rounded-lg p-2 text-center"><i class="fas fa-clock" style="color:#1B3A4B; margin-bottom:2px; font-size:12px;"></i><p class="text-[10px] text-gray-500">{{ __("Durasi") }}</p><p class="font-bold text-xs text-gray-800">' + (durasi || '-') + '</p></div>';
            summary += '</div>';
        }

        body.innerHTML = '';
        const summaryWrap = document.createElement('div');
        summaryWrap.style.marginBottom = '16px';
        summaryWrap.style.paddingBottom = '12px';
        summaryWrap.style.borderBottom = '1px solid #e2e8f0';
        summaryWrap.innerHTML = summary;
        if (summary) body.appendChild(summaryWrap);

        const listWrap = document.createElement('div');
        listWrap.style.position = 'relative';

        const routeLine = document.createElement('div');
        routeLine.style.position = 'absolute';
        routeLine.style.left = '14px';
        routeLine.style.top = '0';
        routeLine.style.bottom = '0';
        routeLine.style.borderLeft = '2px dashed #94a3b8';
        listWrap.appendChild(routeLine);

        nodes.forEach((node) => {
            const clone = node.cloneNode(true);
            clone.style.display = '';
            clone.style.position = 'relative';
            listWrap.appendChild(clone);
        });
        body.appendChild(listWrap);

        body.querySelectorAll('.it-item img').forEach((img) => {
            img.style.aspectRatio = '1 / 1';
            img.style.maxWidth = '320px';
            img.style.maxHeight = 'none';
            img.style.margin = '0 auto';
            img.style.display = 'block';
            img.style.objectFit = 'cover';
        });

        function listSectionHtml(label, sourceEl) {
            if (!sourceEl || sourceEl.style.display === 'none') return '';
            const list = sourceEl.querySelector('ul');
            if (!list || list.children.length === 0) return '';
            const items = Array.from(list.children).map(li => li.outerHTML).join('');
            return '<div style="margin-top:16px;"><p class="text-[10px] font-bold text-gray-500 uppercase tracking-wide mb-1">' + label + '</p><ul class="space-y-1">' + items + '</ul></div>';
        }

        const pkgIncluded = document.getElementById('package-included');
        const tourInclusions = document.getElementById('tour-inclusions');
        const pkgExcluded = document.getElementById('package-excluded');
        const tourExclusions = document.getElementById('tour-exclusions');

        const incSource = (pkgIncluded && pkgIncluded.style.display !== 'none') ? pkgIncluded : tourInclusions;
        const excSource = (pkgExcluded && pkgExcluded.style.display !== 'none') ? pkgExcluded : tourExclusions;

        const listsWrap = document.createElement('div');
        listsWrap.innerHTML = listSectionHtml('{{ __("Sudah Termasuk") }}', incSource) + listSectionHtml('{{ __("Tidak Termasuk") }}', excSource);
        if (listsWrap.children.length) body.appendChild(listsWrap);

        if (title) title.textContent = '{{ __("Jadwal Perjalanan") }} (' + count + ')';
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeItineraryModal() {
        const modal = document.getElementById('itinerary-modal');
        if (!modal) return;
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeItineraryModal();
            if (isMobileView()) closeDetailPaket();
        }
    });

    window.addEventListener('resize', function () {
        const panel = document.getElementById('panel-detail-paket');
        const trigger = document.getElementById('mobile-detail-trigger');
        const name = document.getElementById('detail-nama');
        if (!panel || !trigger || !name) return;
        const hasSelection = name.textContent.trim() !== '';
        if (isMobileView()) {
            if (hasSelection && !panel.classList.contains('mobile-open')) {
                panel.style.display = 'none';
                trigger.style.display = 'flex';
            }
        } else {
            trigger.style.display = 'none';
            panel.classList.remove('mobile-open');
            document.body.style.overflow = '';
            if (hasSelection) panel.style.display = 'block';
        }
    });

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
                document.getElementById('detail-max').textContent = pkg.max_people + ' orang';

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

                const detailPanel = document.getElementById('panel-detail-paket');
                const mobileTrigger = document.getElementById('mobile-detail-trigger');
                const mobileName = document.getElementById('mobile-detail-name');
                if (isMobileView()) {
                    detailPanel.style.display = 'none';
                    detailPanel.classList.remove('mobile-open');
                    if (mobileName) mobileName.textContent = pkg.name;
                    if (mobileTrigger) mobileTrigger.style.display = 'flex';
                } else {
                    detailPanel.style.display = 'block';
                    if (mobileTrigger) mobileTrigger.style.display = 'none';
                }
            });
        });
    }); 
</script>
@endsection

