<!DOCTYPE html>
<html lang="id">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"></head>
<body style="margin:0;padding:0;background:#f1f5f9;font-family:'Segoe UI',Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 20px;">
<tr><td align="center">
<table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;">

    <tr><td style="background:linear-gradient(135deg,#1B3A4B,#14505F);border-radius:16px 16px 0 0;padding:28px 40px;text-align:center;">
        <div style="font-size:26px;font-weight:900;color:white;">✈️ TripWay</div>
    </td></tr>

    <tr><td style="background:#ef4444;padding:14px 40px;text-align:center;">
        <div style="font-size:15px;font-weight:700;color:white;">❌ Pembayaran Tidak Dapat Diverifikasi</div>
    </td></tr>

    <tr><td style="background:white;padding:28px 40px;">
        <p style="font-size:15px;color:#1e293b;margin:0 0 20px;">Halo <strong>{{ $booking->contact_name }}</strong>,<br>
        Mohon maaf, bukti pembayaran Anda tidak dapat diverifikasi.</p>

        <table width="100%" cellpadding="0" cellspacing="0" style="background:#f8fafc;border-radius:12px;border:1px solid #e2e8f0;margin-bottom:20px;">
            <tr><td style="padding:16px 20px;">
                <div style="font-size:16px;font-weight:800;color:#1e293b;margin-bottom:8px;">{{ $booking->tour->title }}</div>
                <table width="100%">
                    <tr><td style="padding:6px 0;font-size:13px;color:#64748b;">Booking ID</td><td style="text-align:right;font-weight:700;color:#1e293b;">#{{ $booking->id }}</td></tr>
                    <tr><td style="padding:6px 0;font-size:13px;color:#64748b;">Tanggal Tour</td><td style="text-align:right;font-weight:700;color:#1e293b;">{{ $booking->travel_date->format('d M Y') }}</td></tr>
                    <tr><td style="padding:6px 0;font-size:13px;color:#64748b;">Total</td><td style="text-align:right;font-weight:700;color:#1e293b;">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td></tr>
                </table>
            </td></tr>
        </table>

        <table width="100%" cellpadding="0" cellspacing="0" style="background:#fef2f2;border:1px solid #fecaca;border-radius:10px;margin-bottom:20px;">
            <tr><td style="padding:14px 16px;font-size:13px;color:#dc2626;line-height:1.6;">
                ⚠️ <strong>Kemungkinan penyebab:</strong><br>
                • Bukti transfer tidak jelas/buram<br>
                • Nominal transfer tidak sesuai<br>
                • Rekening tujuan tidak sesuai
            </td></tr>
        </table>

        <p style="font-size:13px;color:#475569;margin:0 0 20px;">Silakan upload ulang bukti transfer yang valid. Pastikan gambar jelas, nominal sesuai, dan rekening tujuan benar.</p>

        <table width="100%" cellpadding="0" cellspacing="0">
            <tr><td align="center">
                <a href="{{ route('payment.upload.show', $booking) }}"
                    style="display:inline-block;background:linear-gradient(135deg,#1B3A4B,#14505F);color:white;padding:14px 36px;border-radius:12px;font-size:14px;font-weight:800;text-decoration:none;">
                    📤 Upload Ulang Bukti
                </a>
            </td></tr>
        </table>
    </td></tr>

    <tr><td style="background:#f8fafc;border-radius:0 0 16px 16px;padding:16px 40px;text-align:center;border-top:1px solid #e2e8f0;">
        <div style="font-size:11px;color:#94a3b8;">Pertanyaan? support@tripway.id · © {{ date('Y') }} TripWay</div>
    </td></tr>

</table>
</td></tr>
</table>
</body>
</html>
