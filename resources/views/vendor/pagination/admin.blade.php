@if ($paginator->hasPages())
<div style="display:flex; justify-content:space-between; align-items:center; margin-top:16px; flex-wrap:wrap; gap:10px;">

    {{-- Info --}}
    <div style="font-size:13px; color:#64748b;">
        Menampilkan <strong>{{ $paginator->firstItem() }}</strong> - <strong>{{ $paginator->lastItem() }}</strong>
        dari <strong>{{ $paginator->total() }}</strong> data
    </div>

    {{-- Tombol --}}
    <div style="display:flex; gap:4px; align-items:center;">

        {{-- Previous --}}
        @if($paginator->onFirstPage())
            <span style="padding:6px 12px; border-radius:8px; border:1px solid #e2e8f0; background:#f8fafc; color:#cbd5e1; font-size:13px; cursor:not-allowed;">
                <i class="fas fa-chevron-left"></i>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" style="padding:6px 12px; border-radius:8px; border:1px solid #e2e8f0; background:white; color:#1B3A4B; font-size:13px; text-decoration:none; transition:all 0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='white'">
                <i class="fas fa-chevron-left"></i>
            </a>
        @endif

        {{-- Page Numbers --}}
        @foreach($elements as $element)
            @if(is_string($element))
                <span style="padding:6px 10px; font-size:13px; color:#94a3b8;">...</span>
            @endif
            @if(is_array($element))
                @foreach($element as $page => $url)
                    @if($page == $paginator->currentPage())
                        <span style="padding:6px 12px; border-radius:8px; background:#1B3A4B; color:white; font-size:13px; font-weight:700;">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" style="padding:6px 12px; border-radius:8px; border:1px solid #e2e8f0; background:white; color:#475569; font-size:13px; text-decoration:none; transition:all 0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='white'">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" style="padding:6px 12px; border-radius:8px; border:1px solid #e2e8f0; background:white; color:#1B3A4B; font-size:13px; text-decoration:none; transition:all 0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='white'">
                <i class="fas fa-chevron-right"></i>
            </a>
        @else
            <span style="padding:6px 12px; border-radius:8px; border:1px solid #e2e8f0; background:#f8fafc; color:#cbd5e1; font-size:13px; cursor:not-allowed;">
                <i class="fas fa-chevron-right"></i>
            </span>
        @endif

    </div>
</div>
@endif
