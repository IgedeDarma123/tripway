@extends('layouts.tripway')

@section('title', 'Upload Bukti Pembayaran - TripWay')

@section('styles')
<style>
    .upload-page { background:#f1f5f9; min-height:calc(100vh - 64px); padding:32px 24px 60px; }

    .stepper-wrap { max-width:600px; margin:0 auto 28px; display:flex; align-items:center; }
    .step { display:flex; flex-direction:column; align-items:center; gap:5px; }
    .step-circle { width:34px; height:34px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:800; font-size:13px; }
    .step-circle.done   { background:#1B3A4B; color:white; }
    .step-circle.active { background:#1B3A4B; color:white; box-shadow:0 0 0 4px rgba(27,58,75,0.15); }
    .step-circle.inactive { background:#e2e8f0; color:#94a3b8; }
    .step-label { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.04em; white-space:nowrap; }
    .step-label.active { color:#1B3A4B; }
    .step-label.inactive { color:#94a3b8; }
    .step-line { flex:1; height:2px; margin:0 10px; margin-bottom:20px; max-width:80px; }
    .step-line.done { background:#1B3A4B; }
    .step-line.inactive { background:#e2e8f0; }

    .ucard { background:white; border-radius:14px; border:1px solid #e2e8f0; box-shadow:0 1px 6px rgba(0,0,0,0.05); max-width:600px; margin:0 auto; overflow:hidden; }
    .ucard-head { background:linear-gradient(135deg,#1B3A4B,#14505F); color:white; padding:24px; text-align:center; }
    .ucard-head h2 { font-size:20px; font-weight:800; margin:0; }
    .ucard-head p { font-size:13px; opacity:0.85; margin:6px 0 0; }
    .ucard-body { padding:24px; }

    .order-info { background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:16px; margin-bottom:20px; }
    .order-info .title { font-weight:700; font-size:15px; margin-bottom:4px; color:#1e293b; }
    .order-info .detail { font-size:13px; color:#64748b; }
    .order-info .total { display:flex; justify-content:space-between; font-size:17px; font-weight:800; padding-top:12px; border-top:1px solid #e2e8f0; margin-top:12px; color:#1B3A4B; }

    .status-box { display:flex; align-items:center; gap:12px; padding:14px 16px; border-radius:10px; margin-bottom:20px; }
    .status-box.waiting { background:#fffbeb; border:1px solid #fde68a; color:#92400e; }
    .status-box.rejected { background:#fef2f2; border:1px solid #fecaca; color:#991b1b; }
    .status-box.confirmed { background:#f0fdf4; border:1px solid #bbf7d0; color:#166534; }

    .upload-area { border:2px dashed #cbd5e1; border-radius:12px; padding:36px 20px; text-align:center; cursor:pointer; transition:all 0.2s; margin-bottom:20px; }
    .upload-area:hover { border-color:#1B3A4B; background:rgba(27,58,75,0.04); }
    .upload-area.has-file { border-color:#1B3A4B; background:rgba(27,58,75,0.04); }
    .upload-area i { font-size:44px; color:#cbd5e1; margin-bottom:10px; display:block; }
    .upload-area.has-file i { color:#1B3A4B; }
    .upload-area p { font-size:13px; color:#64748b; margin:0; }
    .upload-area .file-name { font-weight:700; color:#1B3A4B; }
    .upload-area input[type="file"] { display:none; }
    .preview-image { max-width:100%; max-height:280px; border-radius:10px; margin-bottom:10px; display:none; }
    .upload-area.has-file .preview-image { display:block; }

    .instructions { background:#eff6ff; border:1px solid #bfdbfe; border-radius:10px; padding:14px 16px; margin-bottom:20px; }
    .instructions h4 { font-size:13px; font-weight:700; color:#1e293b; margin:0 0 8px; }
    .instructions ul { font-size:12px; color:#475569; padding-left:18px; margin:0; }
    .instructions li { margin-bottom:3px; }

    .submit-btn { width:100%; background:linear-gradient(135deg,#1B3A4B,#14505F); color:white; border:none; border-radius:12px; padding:14px; font-size:15px; font-weight:800; cursor:pointer; transition:all 0.2s; }
    .submit-btn:hover { opacity:0.9; }
    .submit-btn:disabled { background:#cbd5e1; cursor:not-allowed; }
    .back-link { display:block; text-align:center; margin-top:14px; color:#64748b; font-size:13px; text-decoration:none; }
    .back-link:hover { color:#1B3A4B; }
    .alert { padding:12px 16px; border-radius:10px; margin-bottom:16px; font-size:13px; }
    .alert-success { background:#f0fdf4; color:#166534; border:1px solid #bbf7d0; }
    .alert-error { background:#fef2f2; color:#991b1b; border:1px solid #fecaca; }
</style>
@endsection

@section('content')
<div class="upload-page">

    {{-- Stepper --}}
    <div class="stepper-wrap">
        <div class="step">
            <div class="step-circle done"><i class="fas fa-check" style="font-size:11px;"></i></div>
            <span class="step-label active">Pilih Paket</span>
        </div>
        <div class="step-line done"></div>
        <div class="step">
            <div class="step-circle done"><i class="fas fa-check" style="font-size:11px;"></i></div>
            <span class="step-label active">Detail Pesanan</span>
        </div>
        <div class="step-line done"></div>
        <div class="step">
            <div class="step-circle done"><i class="fas fa-check" style="font-size:11px;"></i></div>
            <span class="step-label active">Pilih Bayar</span>
        </div>
        <div class="step-line done"></div>
        <div class="step">
            <div class="step-circle active">4</div>
            <span class="step-label active">Upload Bukti</span>
        </div>
    </div>

    <div class="ucard">
        <div class="ucard-head">
            <h2><i class="fas fa-cloud-upload-alt" style="margin-right:8px;"></i>Upload Bukti Pembayaran</h2>
            <p>Silakan upload screenshot/foto bukti transfer Anda</p>
        </div>

        <div class="ucard-body">

            @if(session('success'))
            <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
            @endif
            @if(session('error'))
            <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
            @endif

            {{-- Info Pesanan --}}
            <div class="order-info">
                <div class="title">{{ $booking->tour->title }}</div>
                <div class="detail">
                    <i class="far fa-calendar" style="margin-right:4px;"></i>{{ $booking->travel_date->format('d M Y') }}
                    &nbsp;·&nbsp;
                    <i class="fas fa-users" style="margin-right:4px;"></i>{{ $booking->num_persons }} orang
                    @if($booking->payment_type)
                    &nbsp;·&nbsp;
                    <i class="fas fa-credit-card" style="margin-right:4px;"></i>{{ strtoupper($booking->payment_type) }}
                    @endif
                </div>
                <div class="total">
                    <span>Total Pembayaran</span>
                    <span>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                </div>
            </div>

            {{-- Status Box --}}
            @if($booking->payment_status === 'pending_verification')
            <div class="status-box waiting">
                <i class="fas fa-clock" style="font-size:22px; flex-shrink:0;"></i>
                <div>
                    <div style="font-weight:700; font-size:14px;">Menunggu Verifikasi Admin</div>
                    <div style="font-size:12px; margin-top:2px;">Bukti pembayaran sudah diterima. Admin akan memverifikasi dalam 1×24 jam.</div>
                </div>
            </div>
            @elseif($booking->payment_status === 'deny')
            <div class="status-box rejected">
                <i class="fas fa-times-circle" style="font-size:22px; flex-shrink:0;"></i>
                <div>
                    <div style="font-weight:700; font-size:14px;">Bukti Pembayaran Ditolak</div>
                    <div style="font-size:12px; margin-top:2px;">Bukti transfer Anda ditolak oleh admin. Silakan upload ulang bukti yang valid.</div>
                </div>
            </div>
            @elseif($booking->payment_status === 'settlement')
            <div class="status-box confirmed">
                <i class="fas fa-check-circle" style="font-size:22px; flex-shrink:0;"></i>
                <div>
                    <div style="font-weight:700; font-size:14px;">Pembayaran Dikonfirmasi!</div>
                    <div style="font-size:12px; margin-top:2px;">
                        Dikonfirmasi pada {{ $booking->payment_confirmed_at ? $booking->payment_confirmed_at->format('d M Y H:i') : '-' }}
                    </div>
                </div>
            </div>
            @endif

            {{-- Form Upload (sembunyikan jika sudah confirmed atau sedang pending_verification) --}}
            @if($booking->payment_status !== 'settlement' && $booking->payment_status !== 'pending_verification')
            <div class="instructions">
                <h4><i class="fas fa-info-circle"></i> Cara Upload:</h4>
                <ul>
                    <li>Lakukan transfer ke rekening yang tertera di halaman pembayaran</li>
                    <li>Screenshot atau foto bukti transfer yang jelas</li>
                    <li>Klik area upload di bawah dan pilih gambar</li>
                    <li>Pastikan nominal, tanggal, dan nama tujuan terlihat jelas</li>
                </ul>
            </div>

            <form action="{{ route('payment.upload', $booking) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label class="upload-area" id="upload-area" for="payment_proof">
                    <img src="" alt="Preview" class="preview-image" id="preview-image">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <p id="upload-text">
                        Klik untuk upload bukti pembayaran<br>
                        <small style="color:#94a3b8;">(JPG, PNG, maks 2MB)</small>
                    </p>
                    <input type="file" name="payment_proof" id="payment_proof" accept="image/*" required>
                </label>

                @error('payment_proof')
                <p style="color:#dc2626; font-size:12px; margin:-12px 0 12px;">{{ $message }}</p>
                @enderror

                <button type="submit" class="submit-btn" id="submit-btn" disabled>
                    <i class="fas fa-paper-plane" style="margin-right:8px;"></i>Kirim Bukti Pembayaran
                </button>
            </form>
            @endif

            <a href="{{ route('bookings.index') }}" class="back-link">
                <i class="fas fa-arrow-left" style="margin-right:4px;"></i>Kembali ke Pesanan Saya
            </a>
        </div>
    </div>
</div>

<script>
    const uploadArea = document.getElementById('upload-area');
    const fileInput  = document.getElementById('payment_proof');
    const preview    = document.getElementById('preview-image');
    const uploadText = document.getElementById('upload-text');
    const submitBtn  = document.getElementById('submit-btn');

    function handleFile(file) {
        if (!file) return;
        if (!['image/jpeg', 'image/png', 'image/jpg'].includes(file.type)) {
            alert('Hanya file JPG dan PNG yang diizinkan!');
            fileInput.value = '';
            return;
        }
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file maksimal 2MB!');
            fileInput.value = '';
            return;
        }
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            uploadArea.classList.add('has-file');
            uploadText.innerHTML = '<span class="file-name">' + file.name + '</span><br><small style="color:#64748b;">Klik untuk ganti gambar</small>';
            if (submitBtn) { submitBtn.disabled = false; }
        };
        reader.readAsDataURL(file);
    }

    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            handleFile(e.target.files[0]);
        });
    }

    if (uploadArea) {
        uploadArea.addEventListener('dragover', e => { e.preventDefault(); uploadArea.style.borderColor = '#1B3A4B'; });
        uploadArea.addEventListener('dragleave', e => { e.preventDefault(); uploadArea.style.borderColor = ''; });
        uploadArea.addEventListener('drop', e => {
            e.preventDefault();
            uploadArea.style.borderColor = '';
            const dt = e.dataTransfer;
            if (dt.files.length > 0) {
                // Assign ke input file via DataTransfer
                try {
                    fileInput.files = dt.files;
                } catch(err) {}
                handleFile(dt.files[0]);
            }
        });
    }
</script>
@endsection
