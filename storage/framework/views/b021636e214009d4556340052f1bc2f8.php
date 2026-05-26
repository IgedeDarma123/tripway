<?php $__env->startSection('title', 'Pembayaran - TripWay'); ?>

<?php $__env->startSection('styles'); ?>
<?php
$paymentMethods = \App\Models\PaymentSetting::getActiveMethods();

// Icon menggunakan base64 SVG inline atau URL CDN yang pasti load
$bankIcons = [
    'bca'     => 'https://www.bca.co.id/~/media/Feature/Logo/logo-bca.png',
    'bni'     => 'https://www.bni.co.id/Portals/1/BNI/images/logo-bni.png',
    'bri'     => 'https://bri.co.id/documents/20123/0/logo-bri.png',
    'mandiri' => 'https://www.bankmandiri.co.id/documents/20143/0/logo-mandiri.png',
    'gopay'   => 'https://www.gojek.com/images/gopay-logo.png',
    'ovo'     => 'https://www.ovo.id/assets/images/logo-ovo.png',
    'dana'    => 'https://www.dana.id/assets/images/logo-dana.png',
    'qris'    => 'https://www.aspi.or.id/uploads/images/qris-logo.png',
];

// Warna brand setiap metode
$brandColors = [
    'bca'     => '#005BAA',
    'bni'     => '#F15A22',
    'bri'     => '#003D7C',
    'mandiri' => '#003087',
    'gopay'   => '#00AED6',
    'ovo'     => '#4C3494',
    'dana'    => '#118EEA',
    'qris'    => '#E31E24',
];

// Inisial fallback jika logo gagal load
$bankInitials = [
    'bca' => 'BCA', 'bni' => 'BNI', 'bri' => 'BRI', 'mandiri' => 'MDR',
    'gopay' => 'GP', 'ovo' => 'OVO', 'dana' => 'DANA', 'qris' => 'QR',
];

$qrisData = $paymentMethods->where('method','qris')->first();
$wallets  = $paymentMethods->whereIn('method', ['gopay','ovo','dana']);
$banks    = $paymentMethods->whereIn('method', ['bca','bni','bri','mandiri']);
?>
<style>
    .pay-page { background:#f1f5f9; min-height:calc(100vh - 64px); padding:32px 24px 60px; }

    /* Stepper */
    .stepper-wrap { max-width:960px; margin:0 auto 28px; display:flex; align-items:center; }
    .step { display:flex; flex-direction:column; align-items:center; gap:5px; }
    .step-circle { width:34px; height:34px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:800; font-size:13px; }
    .step-circle.done   { background:#1B3A4B; color:white; }
    .step-circle.active { background:#1B3A4B; color:white; box-shadow:0 0 0 4px rgba(27,58,75,0.15); }
    .step-circle.inactive { background:#e2e8f0; color:#94a3b8; }
    .step-label { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.04em; white-space:nowrap; }
    .step-label.active { color:#1B3A4B; }
    .step-label.inactive { color:#94a3b8; }
    .step-line { flex:1; height:2px; margin:0 10px; margin-bottom:20px; max-width:100px; }
    .step-line.done { background:#1B3A4B; }
    .step-line.inactive { background:#e2e8f0; }

    /* Layout */
    .pay-layout { max-width:960px; margin:0 auto; display:grid; grid-template-columns:1fr 340px; gap:20px; align-items:start; }

    /* Card */
    .pcard { background:white; border-radius:14px; border:1px solid #e2e8f0; box-shadow:0 1px 6px rgba(0,0,0,0.05); margin-bottom:16px; overflow:hidden; }
    .pcard-head { padding:14px 20px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; gap:10px; }
    .pcard-head .ico { width:30px; height:30px; border-radius:8px; background:#f0f9ff; color:#1B3A4B; display:flex; align-items:center; justify-content:center; font-size:13px; }
    .pcard-head h3 { font-size:13px; font-weight:800; color:#1e293b; margin:0; text-transform:uppercase; letter-spacing:0.04em; }

    /* Screen */
    .screen { display:none; }
    .screen.active { display:block; }

    /* Method group label */
    .method-section-label { font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.05em; padding:14px 20px 6px; }

    /* Method accordion item */
    .method-item {
        border-bottom: 1px solid #f1f5f9;
        transition: all 0.2s;
    }
    .method-item:last-child { border-bottom: none; }
    .method-item-header {
        display:flex; align-items:center; gap:14px;
        padding:14px 20px; cursor:pointer;
        transition:background 0.15s;
    }
    .method-item-header:hover { background:#f8fafc; }
    .method-item.active .method-item-header { background:#f0f9ff; }

    /* Icon bank - kotak dengan warna brand */
    .bank-icon-box {
        width:48px; height:32px; border-radius:6px;
        display:flex; align-items:center; justify-content:center;
        font-size:10px; font-weight:900; color:white;
        flex-shrink:0; overflow:hidden;
    }
    .bank-icon-box img { width:100%; height:100%; object-fit:contain; padding:4px; }

    .method-item-info { flex:1; }
    .method-item-name { font-size:14px; font-weight:700; color:#1e293b; }
    .method-item-sub  { font-size:11px; color:#94a3b8; margin-top:1px; }
    .method-radio {
        width:20px; height:20px; border-radius:50%;
        border:2px solid #cbd5e1; flex-shrink:0;
        display:flex; align-items:center; justify-content:center;
        transition:all 0.2s;
    }
    .method-item.active .method-radio { border-color:#1B3A4B; background:#1B3A4B; }
    .method-item.active .method-radio::after { content:''; width:7px; height:7px; border-radius:50%; background:white; display:block; }

    /* Accordion body */
    .method-item-body { display:none; padding:0 20px 16px; background:#f8fafc; border-top:1px solid #f1f5f9; }
    .method-item.active .method-item-body { display:block; }

    /* VA / Nomor box */
    .number-box {
        background:white; border:1px solid #e2e8f0; border-radius:10px;
        padding:14px 16px; margin-top:12px;
    }
    .number-label { font-size:11px; color:#94a3b8; font-weight:600; text-transform:uppercase; letter-spacing:0.04em; margin-bottom:6px; }
    .number-value { font-size:22px; font-weight:900; color:#1B3A4B; letter-spacing:2px; }
    .number-name  { font-size:12px; color:#64748b; margin-top:3px; }
    .copy-btn {
        display:inline-flex; align-items:center; gap:5px;
        background:#1B3A4B; color:white; border:none;
        padding:5px 14px; border-radius:7px; font-size:11px; font-weight:700;
        cursor:pointer; margin-top:8px; transition:all 0.2s;
    }
    .copy-btn:hover { opacity:0.85; }

    /* QR box */
    .qr-box { text-align:center; padding:16px 0; }
    .qr-img { display:inline-block; padding:12px; background:white; border:1px solid #e2e8f0; border-radius:12px; }

    /* Instruksi */
    .steps { margin-top:14px; display:flex; flex-direction:column; gap:8px; }
    .step-item { display:flex; gap:10px; align-items:flex-start; font-size:12px; color:#475569; }
    .step-num { width:20px; height:20px; border-radius:50%; background:#1B3A4B; color:white; font-size:10px; font-weight:800; display:flex; align-items:center; justify-content:center; flex-shrink:0; margin-top:1px; }

    /* Sidebar */
    .sidebar-card { background:white; border-radius:14px; border:1px solid #e2e8f0; box-shadow:0 1px 6px rgba(0,0,0,0.05); overflow:hidden; position:sticky; top:20px; }
    .sidebar-tour { display:flex; gap:12px; padding:16px 20px; border-bottom:1px solid #f1f5f9; }
    .sidebar-tour img { width:68px; height:56px; object-fit:cover; border-radius:8px; flex-shrink:0; }
    .sidebar-tour .tname { font-size:13px; font-weight:700; color:#1e293b; line-height:1.4; margin-bottom:3px; }
    .sidebar-tour .tmeta { font-size:11px; color:#64748b; }
    .sidebar-body { padding:16px 20px; }
    .price-row { display:flex; justify-content:space-between; font-size:13px; margin-bottom:8px; }
    .price-row .l { color:#64748b; }
    .price-row .v { font-weight:600; color:#1e293b; }
    .price-divider { border:none; border-top:1px solid #e2e8f0; margin:12px 0; }
    .price-total { display:flex; justify-content:space-between; align-items:center; }
    .price-total .l { font-size:14px; font-weight:800; color:#1e293b; }
    .price-total .v { font-size:22px; font-weight:900; color:#1B3A4B; }

    .btn-primary { display:block; width:100%; background:linear-gradient(135deg,#1B3A4B,#14505F); color:white; padding:14px; border-radius:12px; font-size:14px; font-weight:800; text-align:center; text-decoration:none; margin-top:16px; transition:all 0.2s; box-shadow:0 4px 16px rgba(27,58,75,0.3); border:none; cursor:pointer; }
    .btn-primary:hover { opacity:0.9; transform:translateY(-1px); }
    .btn-secondary { display:block; width:100%; background:white; color:#64748b; padding:11px; border-radius:12px; font-size:13px; font-weight:600; text-align:center; text-decoration:none; margin-top:10px; border:1px solid #e2e8f0; transition:all 0.2s; cursor:pointer; }
    .btn-secondary:hover { border-color:#1B3A4B; color:#1B3A4B; }

    .notice { display:flex; align-items:flex-start; gap:8px; padding:10px 14px; border-radius:10px; font-size:12px; line-height:1.6; margin-top:12px; }
    .notice.green { background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0; }
    .notice.blue  { background:#eff6ff; color:#1d4ed8; border:1px solid #bfdbfe; }

    @media(max-width:768px) { .pay-layout { grid-template-columns:1fr; } .sidebar-card { position:static; } }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="pay-page">

    
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
            <div class="step-circle active">3</div>
            <span class="step-label active">Pembayaran</span>
        </div>
    </div>

    <div class="pay-layout">

        
        <div>

            
            <div class="screen active" id="screen-1">
                <div class="pcard">
                    <div class="pcard-head">
                        <div class="ico"><i class="fas fa-credit-card"></i></div>
                        <h3>Pilih Metode Pembayaran</h3>
                    </div>

                    
                    <?php if($qrisData): ?>
                    <div class="method-section-label">QRIS</div>
                    <div class="method-item" id="item-qris">
                        <div class="method-item-header" onclick="toggleMethod('qris','<?php echo e($qrisData->name); ?>','<?php echo e($qrisData->account_number); ?>','<?php echo e($qrisData->account_name); ?>')">
                            <div class="bank-icon-box" style="background:<?php echo e($brandColors['qris']); ?>;">
                                <span style="font-size:9px; font-weight:900; color:white;">QRIS</span>
                            </div>
                            <div class="method-item-info">
                                <div class="method-item-name">QRIS</div>
                                <div class="method-item-sub">Bayar dengan scan QR — semua bank & e-wallet</div>
                            </div>
                            <div class="method-radio"></div>
                        </div>
                        <div class="method-item-body">
                            <div class="qr-box">
                                <div class="qr-img">
                                    
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=TRIPWAY-BOOKING-<?php echo e($booking->id); ?>-RP<?php echo e($booking->total_price); ?>"
                                        width="180" height="180" alt="QR Code">
                                </div>
                                <p style="font-size:12px; color:#64748b; margin:10px 0 0;">Scan menggunakan aplikasi bank atau e-wallet apapun</p>
                                <p style="font-size:14px; font-weight:800; color:#1B3A4B; margin:4px 0 0;">Rp <?php echo e(number_format($booking->total_price, 0, ',', '.')); ?></p>
                            </div>
                            <div class="steps">
                                <div class="step-item"><div class="step-num">1</div><span>Buka aplikasi bank atau e-wallet (GoPay, OVO, Dana, BCA, dll)</span></div>
                                <div class="step-item"><div class="step-num">2</div><span>Pilih menu <strong>Scan QR / QRIS</strong></span></div>
                                <div class="step-item"><div class="step-num">3</div><span>Scan QR code di atas dan masukkan nominal <strong>Rp <?php echo e(number_format($booking->total_price, 0, ',', '.')); ?></strong></span></div>
                                <div class="step-item"><div class="step-num">4</div><span>Konfirmasi pembayaran di aplikasi Anda</span></div>
                                <div class="step-item"><div class="step-num">5</div><span>Klik <strong>Konfirmasi Bayar</strong> setelah selesai</span></div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    
                    <?php if($wallets->count()): ?>
                    <div class="method-section-label">Dompet Digital</div>
                    <?php $__currentLoopData = $wallets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="method-item" id="item-<?php echo e($pm->method); ?>">
                        <div class="method-item-header" onclick="toggleMethod('<?php echo e($pm->method); ?>','<?php echo e($pm->name); ?>','<?php echo e($pm->account_number); ?>','<?php echo e($pm->account_name); ?>')">
                            <div class="bank-icon-box" style="background:<?php echo e($brandColors[$pm->method] ?? '#64748b'); ?>;">
                                <span style="font-size:9px; font-weight:900; color:white;"><?php echo e($bankInitials[$pm->method] ?? strtoupper(substr($pm->method,0,3))); ?></span>
                            </div>
                            <div class="method-item-info">
                                <div class="method-item-name"><?php echo e($pm->name); ?></div>
                                <div class="method-item-sub">Transfer ke nomor <?php echo e($pm->name); ?> tujuan</div>
                            </div>
                            <div class="method-radio"></div>
                        </div>
                        <div class="method-item-body">
                            <div class="number-box">
                                <div class="number-label">Nomor <?php echo e($pm->name); ?> Tujuan</div>
                                <div class="number-value"><?php echo e($pm->account_number); ?></div>
                                <div class="number-name">a.n. <?php echo e($pm->account_name); ?></div>
                                <button class="copy-btn" onclick="copyText('<?php echo e($pm->account_number); ?>', this)">
                                    <i class="fas fa-copy"></i> Salin Nomor
                                </button>
                            </div>
                            <div class="steps" style="margin-top:12px;">
                                <div class="step-item"><div class="step-num">1</div><span>Buka aplikasi <strong><?php echo e($pm->name); ?></strong> di HP Anda</span></div>
                                <div class="step-item"><div class="step-num">2</div><span>Pilih menu <strong>Transfer / Kirim Uang</strong></span></div>
                                <div class="step-item"><div class="step-num">3</div><span>Masukkan nomor <strong><?php echo e($pm->account_number); ?></strong></span></div>
                                <div class="step-item"><div class="step-num">4</div><span>Masukkan nominal <strong>Rp <?php echo e(number_format($booking->total_price, 0, ',', '.')); ?></strong> dan konfirmasi</span></div>
                                <div class="step-item"><div class="step-num">5</div><span>Klik <strong>Konfirmasi Bayar</strong> di bawah setelah transfer selesai</span></div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>

                    
                    <?php if($banks->count()): ?>
                    <div class="method-section-label">Transfer Bank</div>
                    <?php $__currentLoopData = $banks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="method-item" id="item-<?php echo e($pm->method); ?>">
                        <div class="method-item-header" onclick="toggleMethod('<?php echo e($pm->method); ?>','<?php echo e($pm->name); ?>','<?php echo e($pm->account_number); ?>','<?php echo e($pm->account_name); ?>')">
                            <div class="bank-icon-box" style="background:<?php echo e($brandColors[$pm->method] ?? '#64748b'); ?>;">
                                <span style="font-size:9px; font-weight:900; color:white;"><?php echo e($bankInitials[$pm->method] ?? strtoupper(substr($pm->method,0,3))); ?></span>
                            </div>
                            <div class="method-item-info">
                                <div class="method-item-name"><?php echo e($pm->name); ?></div>
                                <div class="method-item-sub">No. Rekening: <?php echo e($pm->account_number); ?></div>
                            </div>
                            <div class="method-radio"></div>
                        </div>
                        <div class="method-item-body">
                            <div class="number-box">
                                <div class="number-label">Nomor Rekening / Virtual Account</div>
                                <div class="number-value"><?php echo e($pm->account_number); ?></div>
                                <div class="number-name">a.n. <?php echo e($pm->account_name); ?></div>
                                <button class="copy-btn" onclick="copyText('<?php echo e($pm->account_number); ?>', this)">
                                    <i class="fas fa-copy"></i> Salin Nomor
                                </button>
                            </div>
                            <div class="steps" style="margin-top:12px;">
                                <div class="step-item"><div class="step-num">1</div><span>Buka aplikasi mobile banking atau ATM <strong><?php echo e($pm->name); ?></strong></span></div>
                                <div class="step-item"><div class="step-num">2</div><span>Pilih menu <strong>Transfer</strong></span></div>
                                <div class="step-item"><div class="step-num">3</div><span>Masukkan nomor rekening <strong><?php echo e($pm->account_number); ?></strong></span></div>
                                <div class="step-item"><div class="step-num">4</div><span>Masukkan nominal <strong>Rp <?php echo e(number_format($booking->total_price, 0, ',', '.')); ?></strong> dan konfirmasi</span></div>
                                <div class="step-item"><div class="step-num">5</div><span>Klik <strong>Konfirmasi Bayar</strong> di bawah setelah transfer selesai</span></div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>

                <div class="notice blue">
                    <i class="fas fa-info-circle" style="flex-shrink:0; margin-top:1px;"></i>
                    <span>Pilih metode pembayaran, lakukan transfer, lalu klik <strong>Konfirmasi Bayar</strong> di sidebar.</span>
                </div>
            </div>

        </div>

        
        <div>
            <div class="sidebar-card">
                <div class="sidebar-tour">
                    <img src="<?php echo e($booking->tour->image ?? 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=200'); ?>" alt="<?php echo e($booking->tour->title); ?>">
                    <div>
                        <div class="tname"><?php echo e($booking->tour->title); ?></div>
                        <div class="tmeta">
                            <i class="far fa-calendar" style="margin-right:3px;"></i><?php echo e($booking->travel_date->format('d M Y')); ?><br>
                            <i class="fas fa-users" style="margin-right:3px;"></i><?php echo e($booking->num_persons); ?> orang
                        </div>
                    </div>
                </div>
                <div class="sidebar-body">
                    <p style="font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.05em; margin:0 0 12px;">Ringkasan Harga</p>
                    <div class="price-row">
                        <span class="l"><?php echo e($booking->package->name ?? 'Paket'); ?></span>
                        <span class="v">Rp <?php echo e(number_format($booking->total_price - $booking->addon_price, 0, ',', '.')); ?></span>
                    </div>
                    <div class="price-row">
                        <span class="l">Peserta</span>
                        <span class="v"><?php echo e($booking->num_persons); ?> orang</span>
                    </div>
                    <?php if($booking->addon_price > 0): ?>
                    <div class="price-row">
                        <span class="l">Add-on</span>
                        <span class="v">Rp <?php echo e(number_format($booking->addon_price, 0, ',', '.')); ?></span>
                    </div>
                    <?php endif; ?>
                    <hr class="price-divider">
                    <div class="price-total">
                        <span class="l">Total</span>
                        <span class="v">Rp <?php echo e(number_format($booking->total_price, 0, ',', '.')); ?></span>
                    </div>

                    
                    <div id="selected-box" style="display:none; margin-top:14px; padding:12px; background:#f0f9ff; border-radius:10px; border:1px solid #bfdbfe;">
                        <p style="font-size:11px; color:#64748b; margin:0 0 6px; font-weight:600; text-transform:uppercase;">Metode Terpilih</p>
                        <div style="display:flex; align-items:center; gap:8px;">
                            <div id="selected-icon" class="bank-icon-box" style="width:36px; height:24px;"></div>
                            <span id="selected-name" style="font-size:13px; font-weight:700; color:#1e293b;"></span>
                        </div>
                    </div>

                    <form action="<?php echo e(route('payment.process-mock', $booking)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="payment_method" id="final-method" value="">
                        <input type="hidden" name="payment_type" id="final-type" value="">
                        <button type="submit" id="btn-konfirmasi" class="btn-primary" style="margin-top:16px;" onclick="return validateMethod()">
                            <i class="fas fa-check-circle" style="margin-right:8px;"></i>Konfirmasi Bayar
                        </button>
                    </form>

                    <a href="<?php echo e(route('payment.order-detail', $booking)); ?>" class="btn-secondary">
                        <i class="fas fa-arrow-left" style="margin-right:6px;"></i>Kembali
                    </a>

                    <div class="notice green" style="margin-top:12px;">
                        <i class="fas fa-shield-alt" style="flex-shrink:0;"></i>
                        <span>Pembayaran aman & terenkripsi</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    let currentMethod = '';
    const brandColors = <?php echo json_encode($brandColors, 15, 512) ?>;
    const bankInitials = <?php echo json_encode($bankInitials, 15, 512) ?>;

    function toggleMethod(method, name, account, accountName) {
        const item = document.getElementById('item-' + method);
        const isActive = item.classList.contains('active');

        // Tutup semua
        document.querySelectorAll('.method-item').forEach(i => i.classList.remove('active'));

        // Buka yang diklik (toggle)
        if (!isActive) {
            item.classList.add('active');
            currentMethod = method;

            // Update hidden inputs
            document.getElementById('final-method').value = method;
            document.getElementById('final-type').value = ['gopay','ovo','dana'].includes(method) ? method : (method === 'qris' ? 'qris' : 'bank_transfer');

            // Update sidebar
            document.getElementById('selected-box').style.display = 'block';
            const iconEl = document.getElementById('selected-icon');
            iconEl.style.background = brandColors[method] || '#64748b';
            iconEl.innerHTML = `<span style="font-size:8px; font-weight:900; color:white;">${bankInitials[method] || method.toUpperCase()}</span>`;
            document.getElementById('selected-name').textContent = name;
        } else {
            currentMethod = '';
            document.getElementById('selected-box').style.display = 'none';
            document.getElementById('final-method').value = '';
        }
    }

    function validateMethod() {
        if (!currentMethod) {
            alert('Pilih metode pembayaran terlebih dahulu!');
            return false;
        }
        return true;
    }

    function copyText(text, btn) {
        navigator.clipboard.writeText(text).then(() => {
            btn.innerHTML = '<i class="fas fa-check"></i> Tersalin!';
            setTimeout(() => { btn.innerHTML = '<i class="fas fa-copy"></i> Salin Nomor'; }, 2000);
        });
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.tripway', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\tripway\tripway\resources\views/payments/show.blade.php ENDPATH**/ ?>