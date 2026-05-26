<?php $__env->startSection('title', 'Detail Pesanan - TripWay'); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .order-page {
        background: #f1f5f9;
        min-height: calc(100vh - 64px);
        padding: 32px 24px 60px;
    }

    /* Stepper */
    .stepper-wrap {
        max-width: 960px; margin: 0 auto 28px;
        display: flex; align-items: center;
    }
    .step { display: flex; flex-direction: column; align-items: center; gap: 5px; }
    .step-circle {
        width: 34px; height: 34px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; font-size: 13px; transition: all 0.3s;
    }
    .step-circle.done  { background: #1B3A4B; color: white; }
    .step-circle.active { background: #1B3A4B; color: white; box-shadow: 0 0 0 4px rgba(27,58,75,0.15); }
    .step-circle.inactive { background: #e2e8f0; color: #94a3b8; }
    .step-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em; white-space: nowrap; }
    .step-label.active { color: #1B3A4B; }
    .step-label.inactive { color: #94a3b8; }
    .step-line { flex: 1; height: 2px; margin: 0 10px; margin-bottom: 20px; max-width: 100px; }
    .step-line.done { background: #1B3A4B; }
    .step-line.inactive { background: #e2e8f0; }

    /* Layout */
    .order-layout {
        max-width: 960px; margin: 0 auto;
        display: grid; grid-template-columns: 1fr 360px;
        gap: 20px; align-items: start;
    }

    /* Card */
    .ocard {
        background: white; border-radius: 14px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 6px rgba(0,0,0,0.05);
        margin-bottom: 16px; overflow: hidden;
    }
    .ocard-head {
        padding: 16px 20px; border-bottom: 1px solid #f1f5f9;
        display: flex; align-items: center; gap: 10px;
    }
    .ocard-head .ico {
        width: 30px; height: 30px; border-radius: 8px;
        background: #f0f9ff; color: #1B3A4B;
        display: flex; align-items: center; justify-content: center; font-size: 13px;
    }
    .ocard-head h3 { font-size: 13px; font-weight: 800; color: #1e293b; margin: 0; text-transform: uppercase; letter-spacing: 0.04em; }
    .ocard-body { padding: 0 20px; }

    /* Info row */
    .irow {
        display: flex; justify-content: space-between; align-items: center;
        padding: 13px 0; border-bottom: 1px solid #f8fafc;
    }
    .irow:last-child { border-bottom: none; }
    .irow .lbl { font-size: 13px; color: #64748b; display: flex; align-items: center; gap: 8px; }
    .irow .val { font-size: 13px; font-weight: 700; color: #1e293b; text-align: right; max-width: 55%; }

    /* Badge */
    .badge { padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; }
    .badge-private { background: #dbeafe; color: #1d4ed8; }
    .badge-sharing { background: #dcfce7; color: #15803d; }

    /* Promo section */
    .promo-item {
        display: flex; justify-content: space-between; align-items: center;
        padding: 14px 20px; border-bottom: 1px solid #f1f5f9;
    }
    .promo-item:last-child { border-bottom: none; }
    .promo-left { display: flex; align-items: center; gap: 12px; }
    .promo-icon { width: 36px; height: 36px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 16px; }
    .promo-title { font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 2px; }
    .promo-sub { font-size: 11px; color: #94a3b8; }
    .promo-right { font-size: 12px; font-weight: 700; color: #94a3b8; }

    /* Notice */
    .notice {
        display: flex; align-items: flex-start; gap: 10px;
        padding: 12px 16px; border-radius: 10px; font-size: 12px; line-height: 1.6;
        margin-bottom: 12px;
    }
    .notice.green { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
    .notice.blue  { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
    .notice.gray  { background: #f8fafc; color: #64748b; border: 1px solid #e2e8f0; }

    /* Sidebar */
    .sidebar-card {
        background: white; border-radius: 14px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 6px rgba(0,0,0,0.05);
        overflow: hidden; position: sticky; top: 20px;
    }
    .sidebar-tour {
        display: flex; gap: 12px; padding: 16px 20px;
        border-bottom: 1px solid #f1f5f9;
    }
    .sidebar-tour img { width: 72px; height: 60px; object-fit: cover; border-radius: 8px; flex-shrink: 0; }
    .sidebar-tour .tour-name { font-size: 13px; font-weight: 700; color: #1e293b; line-height: 1.4; margin-bottom: 4px; }
    .sidebar-tour .tour-meta { font-size: 11px; color: #64748b; }
    .sidebar-body { padding: 16px 20px; }
    .price-row { display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 8px; }
    .price-row .lbl { color: #64748b; }
    .price-row .val { font-weight: 600; color: #1e293b; }
    .price-divider { border: none; border-top: 1px solid #e2e8f0; margin: 12px 0; }
    .price-total { display: flex; justify-content: space-between; align-items: center; }
    .price-total .lbl { font-size: 14px; font-weight: 800; color: #1e293b; }
    .price-total .val { font-size: 22px; font-weight: 900; color: #1B3A4B; }

    .btn-pay {
        display: block; width: 100%;
        background: linear-gradient(135deg, #1B3A4B, #14505F);
        color: white; padding: 15px; border-radius: 12px;
        font-size: 15px; font-weight: 800; text-align: center;
        text-decoration: none; margin-top: 16px;
        transition: all 0.2s; box-shadow: 0 4px 16px rgba(27,58,75,0.3);
        border: none; cursor: pointer;
    }
    .btn-pay:hover { opacity: 0.9; transform: translateY(-2px); }
    .btn-back {
        display: block; width: 100%; background: white; color: #64748b;
        padding: 11px; border-radius: 12px; font-size: 13px; font-weight: 600;
        text-align: center; text-decoration: none; margin-top: 10px;
        border: 1px solid #e2e8f0; transition: all 0.2s;
    }
    .btn-back:hover { border-color: #1B3A4B; color: #1B3A4B; }

    .terms-text {
        font-size: 11px; color: #94a3b8; text-align: center;
        margin-top: 12px; line-height: 1.6;
    }
    .terms-text a { color: #1B3A4B; text-decoration: underline; }

    @media (max-width: 768px) {
        .order-layout { grid-template-columns: 1fr; }
        .sidebar-card { position: static; }
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="order-page">

    
    <div class="stepper-wrap">
        <div class="step">
            <div class="step-circle done"><i class="fas fa-check" style="font-size:11px;"></i></div>
            <span class="step-label active">Pilih Paket</span>
        </div>
        <div class="step-line done"></div>
        <div class="step">
            <div class="step-circle active">2</div>
            <span class="step-label active">Detail Pesanan</span>
        </div>
        <div class="step-line inactive"></div>
        <div class="step">
            <div class="step-circle inactive">3</div>
            <span class="step-label inactive">Pembayaran</span>
        </div>
    </div>

    <div class="order-layout">

        
        <div>

            
            <div class="ocard">
                <div class="ocard-head">
                    <div class="ico"><i class="fas fa-map-marked-alt"></i></div>
                    <h3>Informasi Tour</h3>
                </div>
                <div style="display:flex;">
                    <img src="<?php echo e($booking->tour->image ?? 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=400'); ?>"
                        style="width:130px; height:110px; object-fit:cover; flex-shrink:0;">
                    <div style="padding:14px 18px; flex:1;">
                        <div style="font-size:10px; font-weight:700; color:#1B3A4B; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:4px;">
                            <?php echo e($booking->tour->category->name); ?> · <?php echo e($booking->tour->destination->name); ?>

                        </div>
                        <div style="font-size:15px; font-weight:800; color:#1e293b; line-height:1.3; margin-bottom:8px;">
                            <?php echo e($booking->tour->title); ?>

                        </div>
                        <div style="display:flex; gap:12px; font-size:11px; color:#64748b; flex-wrap:wrap;">
                            <span><i class="far fa-clock" style="margin-right:3px;"></i><?php echo e($booking->tour->duration); ?> <?php echo e($booking->tour->duration_type == 'hours' ? 'jam' : 'hari'); ?></span>
                            <span><i class="fas fa-map-marker-alt" style="margin-right:3px;"></i><?php echo e($booking->tour->destination->name); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="ocard">
                <div class="ocard-head">
                    <div class="ico"><i class="fas fa-box-open"></i></div>
                    <h3>Detail Paket</h3>
                </div>
                <div class="ocard-body">
                    <div class="irow">
                        <span class="lbl"><i class="fas fa-tag" style="color:#1B3A4B;"></i> Nama Paket</span>
                        <span class="val"><?php echo e($booking->package->name ?? '-'); ?></span>
                    </div>
                    <div class="irow">
                        <span class="lbl"><i class="fas fa-route" style="color:#1B3A4B;"></i> Tipe Perjalanan</span>
                        <span class="val">
                            <?php if($booking->travel_type === 'private'): ?>
                                <span class="badge badge-private">Private</span>
                            <?php else: ?>
                                <span class="badge badge-sharing">Sharing</span>
                            <?php endif; ?>
                        </span>
                    </div>
                    <?php if($booking->travel_type === 'private' && $booking->groupOption): ?>
                    <div class="irow">
                        <span class="lbl"><i class="fas fa-users" style="color:#1B3A4B;"></i> Pilihan Grup</span>
                        <span class="val"><?php echo e($booking->groupOption->label); ?></span>
                    </div>
                    <?php endif; ?>
                    <div class="irow">
                        <span class="lbl"><i class="far fa-calendar" style="color:#1B3A4B;"></i> Tanggal</span>
                        <span class="val"><?php echo e($booking->travel_date->format('d M Y')); ?></span>
                    </div>
                    <div class="irow">
                        <span class="lbl"><i class="fas fa-users" style="color:#1B3A4B;"></i> Jumlah Peserta</span>
                        <span class="val"><?php echo e($booking->num_persons); ?> orang</span>
                    </div>
                </div>
            </div>

            
            <div class="ocard">
                <div class="ocard-head">
                    <div class="ico"><i class="fas fa-user"></i></div>
                    <h3>Data Pemesan</h3>
                </div>
                <div class="ocard-body">
                    <div class="irow">
                        <span class="lbl"><i class="fas fa-user" style="color:#1B3A4B;"></i> Nama Lengkap</span>
                        <span class="val"><?php echo e($booking->contact_name); ?></span>
                    </div>
                    <div class="irow">
                        <span class="lbl"><i class="fas fa-envelope" style="color:#1B3A4B;"></i> Email</span>
                        <span class="val"><?php echo e($booking->contact_email); ?></span>
                    </div>
                    <div class="irow">
                        <span class="lbl"><i class="fas fa-phone" style="color:#1B3A4B;"></i> No. HP / WhatsApp</span>
                        <span class="val"><?php echo e($booking->contact_phone); ?></span>
                    </div>
                </div>
            </div>

            
            <div class="ocard">
                <div class="ocard-head">
                    <div class="ico"><i class="fas fa-percent"></i></div>
                    <h3>Diskon & Promo</h3>
                </div>
                <div class="promo-item">
                    <div class="promo-left">
                        <div class="promo-icon" style="background:#fef9c3;">🎟️</div>
                        <div>
                            <div class="promo-title">Kode Promo</div>
                            <div class="promo-sub">Tidak tersedia untuk booking ini</div>
                        </div>
                    </div>
                    <span class="promo-right">Tidak tersedia</span>
                </div>
                <div class="promo-item">
                    <div class="promo-left">
                        <div class="promo-icon" style="background:#f0fdf4;">💳</div>
                        <div>
                            <div class="promo-title">Diskon Pembayaran</div>
                            <div class="promo-sub">Tersedia saat memilih metode pembayaran</div>
                        </div>
                    </div>
                    <span class="promo-right">Lihat di langkah berikutnya</span>
                </div>
            </div>

            
            <div class="notice green">
                <i class="fas fa-check-circle" style="margin-top:1px; flex-shrink:0;"></i>
                <span><strong>Pembatalan gratis</strong> hingga 24 jam sebelum keberangkatan. Setelah itu, biaya pembatalan berlaku.</span>
            </div>
            <div class="notice blue">
                <i class="fas fa-info-circle" style="margin-top:1px; flex-shrink:0;"></i>
                <span>Setelah data dikirim, <strong>informasi tidak dapat diubah</strong>. Periksa kembali sebelum melanjutkan.</span>
            </div>
            <div class="notice gray">
                <i class="fas fa-credit-card" style="margin-top:1px; flex-shrink:0;"></i>
                <span>Pesanan Anda akan dikonfirmasi setelah pembayaran selesai. Anda dapat memilih metode pembayaran di langkah berikutnya.</span>
            </div>

        </div>

        
        <div>
            <div class="sidebar-card">

                
                <div class="sidebar-tour">
                    <img src="<?php echo e($booking->tour->image ?? 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=200'); ?>"
                        alt="<?php echo e($booking->tour->title); ?>">
                    <div>
                        <div class="tour-name"><?php echo e($booking->tour->title); ?></div>
                        <div class="tour-meta">
                            <i class="far fa-calendar" style="margin-right:3px;"></i><?php echo e($booking->travel_date->format('d M Y')); ?><br>
                            <i class="fas fa-users" style="margin-right:3px;"></i><?php echo e($booking->num_persons); ?> orang
                        </div>
                    </div>
                </div>

                
                <div class="sidebar-body">
                    <p style="font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.05em; margin:0 0 12px;">Ringkasan Harga</p>

                    <div class="price-row">
                        <span class="lbl"><?php echo e($booking->package->name ?? 'Paket'); ?></span>
                        <span class="val">Rp <?php echo e(number_format($booking->total_price - $booking->addon_price, 0, ',', '.')); ?></span>
                    </div>
                    <div class="price-row">
                        <span class="lbl"><?php echo e($booking->num_persons); ?> peserta</span>
                        <span class="val">×<?php echo e($booking->num_persons); ?></span>
                    </div>
                    <?php if($booking->addon_price > 0): ?>
                    <div class="price-row">
                        <span class="lbl">Add-on</span>
                        <span class="val">Rp <?php echo e(number_format($booking->addon_price, 0, ',', '.')); ?></span>
                    </div>
                    <?php endif; ?>
                    <div class="price-row">
                        <span class="lbl">Diskon</span>
                        <span class="val" style="color:#15803d;">-</span>
                    </div>

                    <hr class="price-divider">

                    <div class="price-total">
                        <span class="lbl">Total</span>
                        <span class="val">Rp <?php echo e(number_format($booking->total_price, 0, ',', '.')); ?></span>
                    </div>

                    <a href="<?php echo e(route('payment.show', $booking)); ?>" class="btn-pay">
                        <i class="fas fa-credit-card" style="margin-right:8px;"></i>Lanjut ke Pembayaran
                    </a>
                    <a href="<?php echo e(route('tours.show', $booking->tour->slug)); ?>" class="btn-back">
                        <i class="fas fa-arrow-left" style="margin-right:6px;"></i>Kembali ke Tour
                    </a>

                    <p class="terms-text">
                        Dengan melanjutkan, Anda menyetujui
                        <a href="#">Syarat & Ketentuan</a> dan
                        <a href="#">Kebijakan Privasi</a> TripWay.
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.tripway', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\tripway\tripway\resources\views/payments/order-detail.blade.php ENDPATH**/ ?>