@extends('layouts.admin')

@section('title', 'Mail Debug')

@section('content')
    <div class="page-header">
        <h1>Mail Debug</h1>
    </div>

    <div class="card" style="max-width: 960px;">
        <div class="card-header">
            <h2>Log Email (laravel.log)</h2>
        </div>
        <div class="card-body">
            @if(count($lines) > 0)
                <div style="background:#0f172a; color:#e2e8f0; border-radius:10px; padding:16px; font-family:Consolas,Menlo,monospace; font-size:12px; line-height:1.6; max-height:500px; overflow:auto; white-space:pre-wrap; word-break:break-all;">
                    @foreach($lines as $line)
                        <div style="margin-bottom:8px;">{{ $line }}</div>
                    @endforeach
                </div>
            @else
                <p style="font-size:13px; color:var(--text-medium);">Belum ada error email yang tercatat di log.</p>
            @endif

            <p style="font-size:12px; color:var(--text-light); margin-top:16px;">
                Tips: buat dulu booking di website publik (atau konfirmasi pembayaran di admin) untuk memicu pengiriman email, lalu refresh halaman ini untuk melihat error aslinya.
            </p>
            <a href="{{ route('admin.settings.mail-debug') }}" class="btn btn-primary">Refresh</a>
        </div>
    </div>
@endsection
