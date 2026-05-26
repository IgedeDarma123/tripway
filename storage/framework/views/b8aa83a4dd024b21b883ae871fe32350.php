<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Booking Dikonfirmasi - TripWay</title>
</head>
<body style="margin:0; padding:0; background:#f1f5f9; font-family:'Segoe UI',Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 20px;">
<tr><td align="center">
<table width="600" cellpadding="0" cellspacing="0" style="max-width:600px; width:100%;">

    
    <tr><td style="background:linear-gradient(135deg,#1B3A4B 0%,#14505F 100%); border-radius:16px 16px 0 0; padding:32px 40px; text-align:center;">
        <div style="font-size:28px; font-weight:900; color:white; letter-spacing:-0.5px;">✈️ TripWay</div>
        <div style="font-size:13px; color:rgba(255,255,255,0.7); margin-top:4px;">Platform Wisata Terpercaya</div>
    </td></tr>

    
    <tr><td style="background:#22c55e; padding:16px 40px; text-align:center;">
        <div style="display:inline-block; background:rgba(255,255,255,0.2); border-radius:30px; padding:6px 20px;">
            <span style="font-size:18px;">✅</span>
            <span style="font-size:15px; font-weight:800; color:white; margin-left:6px;">Pembayaran Dikonfirmasi!</span>
        </div>
        <div style="font-size:12px; color:rgba(255,255,255,0.9); margin-top:6px;">Booking Anda telah resmi dikonfirmasi oleh admin</div>
    </td></tr>

    
    <tr><td style="background:white; padding:32px 40px;">

        
        <p style="font-size:16px; color:#1e293b; margin:0 0 6px;">Halo, <strong><?php echo e($booking->contact_name); ?></strong> 👋</p>
        <p style="font-size:14px; color:#64748b; margin:0 0 28px; line-height:1.6;">Selamat! Pembayaran Anda telah berhasil diverifikasi. Berikut adalah detail booking Anda.</p>

        
        <table width="100%" cellpadding="0" cellspacing="0" style="background:linear-gradient(135deg,#1B3A4B,#14505F); border-radius:12px; margin-bottom:24px; overflow:hidden;">
            <tr><td style="padding:20px 24px;">
                <div style="font-size:11px; font-weight:700; color:rgba(255,255,255,0.6); text-transform:uppercase; letter-spacing:0.08em; margin-bottom:6px;">🗺️ Tour</div>
                <div style="font-size:17px; font-weight:800; color:white; line-height:1.3; margin-bottom:8px;"><?php echo e($booking->tour->title); ?></div>
                <div style="font-size:12px; color:rgba(255,255,255,0.75);">
                    📍 <?php echo e($booking->tour->destination->name); ?>

                    &nbsp;&nbsp;·&nbsp;&nbsp;
                    ⏱️ <?php echo e($booking->tour->duration); ?> <?php echo e($booking->tour->duration_type == 'hours' ? 'jam' : 'hari'); ?>

                </div>
            </td></tr>
        </table>

        
        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
            <tr>
                
                <td width="48%" valign="top" style="background:#f8fafc; border-radius:10px; padding:16px 18px; border:1px solid #e2e8f0;">
                    <div style="font-size:10px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.06em; margin-bottom:12px;">📋 Detail Booking</div>
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="font-size:12px; color:#64748b; padding:4px 0;">Booking ID</td>
                            <td style="font-size:12px; font-weight:800; color:#1B3A4B; text-align:right;">#<?php echo e($booking->id); ?></td>
                        </tr>
                        <tr>
                            <td style="font-size:12px; color:#64748b; padding:4px 0;">Paket</td>
                            <td style="font-size:12px; font-weight:700; color:#1e293b; text-align:right;"><?php echo e($booking->package->name ?? '-'); ?></td>
                        </tr>
                        <tr>
                            <td style="font-size:12px; color:#64748b; padding:4px 0;">Tipe</td>
                            <td style="font-size:12px; font-weight:700; color:#1e293b; text-align:right;">
                                <?php if($booking->travel_type === 'private'): ?>
                                    <span style="background:#dbeafe; color:#1d4ed8; padding:2px 8px; border-radius:10px; font-size:11px;">Private</span>
                                <?php else: ?>
                                    <span style="background:#dcfce7; color:#15803d; padding:2px 8px; border-radius:10px; font-size:11px;">Sharing</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>
                </td>
                <td width="4%"></td>
                
                <td width="48%" valign="top" style="background:#f8fafc; border-radius:10px; padding:16px 18px; border:1px solid #e2e8f0;">
                    <div style="font-size:10px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.06em; margin-bottom:12px;">📅 Jadwal & Peserta</div>
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="font-size:12px; color:#64748b; padding:4px 0;">Tanggal</td>
                            <td style="font-size:12px; font-weight:700; color:#1e293b; text-align:right;"><?php echo e($booking->travel_date->format('d M Y')); ?></td>
                        </tr>
                        <tr>
                            <td style="font-size:12px; color:#64748b; padding:4px 0;">Peserta</td>
                            <td style="font-size:12px; font-weight:700; color:#1e293b; text-align:right;"><?php echo e($booking->num_persons); ?> orang</td>
                        </tr>
                        <tr>
                            <td style="font-size:12px; color:#64748b; padding:4px 0;">Kontak</td>
                            <td style="font-size:12px; font-weight:700; color:#1e293b; text-align:right;"><?php echo e($booking->contact_phone); ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        
        <table width="100%" cellpadding="0" cellspacing="0" style="background:linear-gradient(135deg,#f0f9ff,#e0f2fe); border:1px solid #bfdbfe; border-radius:12px; margin-bottom:24px;">
            <tr><td style="padding:16px 20px;">
                <table width="100%">
                    <tr>
                        <td style="font-size:13px; color:#1d4ed8; font-weight:700;">💰 Total Pembayaran</td>
                        <td style="text-align:right; font-size:24px; font-weight:900; color:#1B3A4B;">Rp <?php echo e(number_format($booking->total_price, 0, ',', '.')); ?></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="font-size:11px; color:#64748b; padding-top:4px;">✅ Lunas · Dikonfirmasi <?php echo e($booking->payment_confirmed_at ? \Carbon\Carbon::parse($booking->payment_confirmed_at)->format('d M Y H:i') : now()->format('d M Y H:i')); ?></td>
                    </tr>
                </table>
            </td></tr>
        </table>

        
        <table width="100%" cellpadding="0" cellspacing="0" style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:12px; margin-bottom:28px;">
            <tr><td style="padding:16px 20px;">
                <div style="font-size:12px; font-weight:800; color:#15803d; margin-bottom:10px;">📋 Yang perlu Anda siapkan:</div>
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr><td style="padding:3px 0; font-size:12px; color:#166534;">✔️ &nbsp;Tunjukkan e-ticket ini kepada pemandu wisata</td></tr>
                    <tr><td style="padding:3px 0; font-size:12px; color:#166534;">✔️ &nbsp;Hadir 15 menit sebelum waktu keberangkatan</td></tr>
                    <tr><td style="padding:3px 0; font-size:12px; color:#166534;">✔️ &nbsp;Bawa perlengkapan sesuai jenis aktivitas tour</td></tr>
                    <tr><td style="padding:3px 0; font-size:12px; color:#166534;">✔️ &nbsp;Simpan nomor kontak pemandu yang akan dikirim terpisah</td></tr>
                </table>
            </td></tr>
        </table>

        
        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:20px;">
            <tr><td align="center" style="padding-bottom:10px;">
                <a href="<?php echo e(route('bookings.ticket', $booking)); ?>"
                    style="display:inline-block; background:linear-gradient(135deg,#1B3A4B,#14505F); color:white; padding:14px 40px; border-radius:12px; font-size:14px; font-weight:800; text-decoration:none; box-shadow:0 4px 14px rgba(27,58,75,0.3);">
                    📄 Download Tiket PDF
                </a>
            </td></tr>
            <tr><td align="center">
                <a href="<?php echo e(route('bookings.index')); ?>"
                    style="display:inline-block; background:white; color:#1B3A4B; padding:12px 40px; border-radius:12px; font-size:13px; font-weight:700; text-decoration:none; border:2px solid #e2e8f0;">
                    📋 Lihat Semua Pesanan
                </a>
            </td></tr>
        </table>

        <p style="font-size:12px; color:#94a3b8; text-align:center; margin:0;">Pertanyaan? Hubungi kami di <a href="mailto:support@tripway.id" style="color:#1B3A4B;">support@tripway.id</a></p>

    </td></tr>

    
    <tr><td style="background:#1e293b; border-radius:0 0 16px 16px; padding:20px 40px; text-align:center;">
        <div style="font-size:16px; font-weight:900; color:white; margin-bottom:6px;">✈️ TripWay</div>
        <div style="font-size:11px; color:#94a3b8; margin-bottom:8px;">Platform Wisata Terpercaya Indonesia</div>
        <div style="font-size:10px; color:#64748b;">© <?php echo e(date('Y')); ?> TripWay. All rights reserved.</div>
    </td></tr>

</table>
</td></tr>
</table>
</body>
</html>
<?php /**PATH D:\tripway\tripway\resources\views/emails/booking-confirmed.blade.php ENDPATH**/ ?>