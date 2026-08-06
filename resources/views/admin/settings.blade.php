@extends('layouts.admin')

@section('title', 'Pengaturan Website')

@section('content')
    <div class="page-header">
        <h1>Pengaturan Website</h1>
    </div>

    <div class="card" style="max-width: 640px;">
        <div class="card-header">
            <h2>Kontak WhatsApp</h2>
        </div>
        <div class="card-body">
            <p style="font-size:13px; color:var(--text-medium); margin-bottom:20px;">
                Nomor WhatsApp ini digunakan untuk tombol <strong>Chat Admin via WhatsApp</strong> di halaman upload bukti pembayaran.
            </p>

            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Nomor WhatsApp Admin *</label>
                    <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $whatsappNumber) }}"
                        placeholder="628xxxxxxxxxx" maxlength="20" required>
                    <small style="color: var(--text-light);">
                        Gunakan format internasional tanpa tanda + , spasi, atau strip. Contoh: 628983317309
                    </small>
                    @error('whatsapp_number')
                    <small style="color:#dc2626; display:block; margin-top:4px;">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
