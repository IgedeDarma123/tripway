<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family: DejaVu Sans, sans-serif; font-size:12px; color:#1e293b; }
    .ticket { background:white; max-width:580px; margin:0 auto; }

    .header { background:#1B3A4B; color:white; padding:24px 28px; }
    .header-top { display:table; width:100%; margin-bottom:14px; }
    .brand { display:table-cell; font-size:20px; font-weight:900; }
    .brand-sub { font-size:10px; font-weight:400; opacity:0.75; }
    .badge { display:table-cell; text-align:right; vertical-align:middle; }
    .badge span { background:rgba(255,255,255,0.2); color:white; padding:4px 12px; border-radius:20px; font-size:10px; font-weight:700; }
    .tour-title { font-size:16px; font-weight:800; margin-bottom:3px; }
    .tour-meta { font-size:10px; opacity:0.8; }

    .divider { border:none; border-top:2px dashed #e2e8f0; margin:0; }

    .body { padding:20px 28px; }
    .section-title { font-size:10px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:8px; margin-top:14px; }

    table.info { width:100%; border-collapse:collapse; margin-bottom:4px; }
    table.info td { padding:4px 0; font-size:11px; }
    table.info td.lbl { color:#64748b; width:140px; }
    table.info td.val { font-weight:700; color:#1e293b; }

    .total-box { background:#f0f9ff; border:1px solid #bfdbfe; border-radius:8px; padding:12px 16px; margin-top:16px; margin-bottom:16px; }
    .total-box table { width:100%; }
    .total-box td.tl { font-size:12px; color:#1d4ed8; font-weight:700; }
    .total-box td.tv { text-align:right; font-size:20px; font-weight:900; color:#1B3A4B; }

    .notice { background:#f0fdf4; border:1px solid #bbf7d0; border-radius:8px; padding:12px 14px; margin-bottom:16px; font-size:11px; color:#15803d; line-height:1.8; }

    .footer { background:#f8fafc; border-top:1px solid #e2e8f0; padding:12px 28px; }
    .footer table { width:100%; }
    .footer td.fl { font-size:10px; color:#94a3b8; }
    .footer td.fr { text-align:right; }
    .booking-id { font-size:13px; font-weight:900; color:#1B3A4B; }
    .confirmed-at { font-size:10px; color:#64748b; }
</style>
</head>
<body>
<div class="ticket">

    <div class="header">
        <div class="header-top">
            <div class="brand">
                TripWay
                <div class="brand-sub">E-Ticket Booking</div>
            </div>
            <div class="badge"><span>DIKONFIRMASI</span></div>
        </div>
        <div class="tour-title"><?php echo e($booking->tour->title); ?></div>
        <div class="tour-meta"><?php echo e($booking->tour->destination->name); ?> &nbsp;·&nbsp; <?php echo e($booking->tour->duration); ?> <?php echo e($booking->tour->duration_type == 'hours' ? 'jam' : 'hari'); ?></div>
    </div>

    <div class="divider"></div>

    <div class="body">

        <div class="section-title">Detail Pemesan</div>
        <table class="info">
            <tr><td class="lbl">Booking ID</td><td class="val">#<?php echo e($booking->id); ?></td></tr>
            <tr><td class="lbl">Nama</td><td class="val"><?php echo e($booking->contact_name); ?></td></tr>
            <tr><td class="lbl">Email</td><td class="val"><?php echo e($booking->contact_email); ?></td></tr>
            <tr><td class="lbl">No. HP</td><td class="val"><?php echo e($booking->contact_phone); ?></td></tr>
        </table>

        <div class="section-title">Detail Paket</div>
        <table class="info">
            <tr><td class="lbl">Paket</td><td class="val"><?php echo e($booking->package->name ?? '-'); ?></td></tr>
            <tr><td class="lbl">Tipe Perjalanan</td><td class="val"><?php echo e(ucfirst($booking->travel_type)); ?></td></tr>
            <?php if($booking->travel_type === 'private' && $booking->groupOption): ?>
            <tr><td class="lbl">Pilihan Grup</td><td class="val"><?php echo e($booking->groupOption->label); ?></td></tr>
            <?php endif; ?>
            <tr><td class="lbl">Tanggal Tour</td><td class="val"><?php echo e($booking->travel_date->format('d M Y')); ?></td></tr>
            <tr><td class="lbl">Jumlah Peserta</td><td class="val"><?php echo e($booking->num_persons); ?> orang</td></tr>
        </table>

        <div class="total-box">
            <table><tr>
                <td class="tl">Total Pembayaran</td>
                <td class="tv">Rp <?php echo e(number_format($booking->total_price, 0, ',', '.')); ?></td>
            </tr></table>
        </div>

        <div class="notice">
            <strong>Yang perlu Anda siapkan:</strong><br>
            - Tunjukkan e-ticket ini kepada pemandu wisata<br>
            - Hadir 15 menit sebelum waktu keberangkatan<br>
            - Bawa perlengkapan sesuai jenis aktivitas tour
        </div>

    </div>

    <div class="footer">
        <table><tr>
            <td class="fl">TripWay &nbsp;·&nbsp; support@tripway.id<br>© <?php echo e(date('Y')); ?> TripWay. All rights reserved.</td>
            <td class="fr">
                <div class="booking-id">#<?php echo e(str_pad($booking->id, 6, '0', STR_PAD_LEFT)); ?></div>
                <div class="confirmed-at"><?php echo e($booking->payment_confirmed_at ? \Carbon\Carbon::parse($booking->payment_confirmed_at)->format('d M Y H:i') : now()->format('d M Y H:i')); ?></div>
            </td>
        </tr></table>
    </div>

</div>
</body>
</html>
<?php /**PATH D:\tripway\tripway\resources\views/pdf/booking-ticket.blade.php ENDPATH**/ ?>