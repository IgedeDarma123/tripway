<!DOCTYPE html>
<html lang="id">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"></head>
<body style="margin:0;padding:0;background:#f1f5f9;font-family:'Segoe UI',Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 20px;">
<tr><td align="center">
<table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;">

    <tr><td style="background:linear-gradient(135deg,#1B3A4B,#14505F);border-radius:16px 16px 0 0;padding:28px 40px;text-align:center;">
        <div style="font-size:26px;font-weight:900;color:white;">✈️ TripWay Admin</div>
        <div style="font-size:13px;color:rgba(255,255,255,0.75);margin-top:4px;">Notifikasi Sistem</div>
    </td></tr>

    <tr><td style="background:#f59e0b;padding:14px 40px;text-align:center;">
        <div style="font-size:15px;font-weight:700;color:white;">🔔 Bukti Transfer Baru Masuk!</div>
    </td></tr>

    <tr><td style="background:white;padding:28px 40px;">
        <p style="font-size:15px;color:#1e293b;margin:0 0 20px;">Ada bukti transfer baru yang perlu diverifikasi:</p>

        <table width="100%" cellpadding="0" cellspacing="0" style="background:#f8fafc;border-radius:12px;border:1px solid #e2e8f0;margin-bottom:20px;">
            <tr><td style="padding:16px 20px;">
                <div style="font-size:16px;font-weight:800;color:#1e293b;margin-bottom:8px;">{{ $booking->tour->title }}</div>
                <table width="100%">
                    <tr><td style="padding:6px 0;font-size:13px;color:#64748b;">Booking ID</td><td style="text-align:right;font-weight:700;color:#1e293b;">#{{ $booking->id }}</td></tr>
                    <tr><td style="padding:6px 0;font-size:13px;color:#64748b;">Pemesan</td><td style="text-align:right;font-weight:700;color:#1e293b;">{{ $booking->contact_name }}</td></tr>
                    <tr><td style="padding:6px 0;font-size:13px;color:#64748b;">Email</td><td style="text-align:right;font-weight:700;color:#1e293b;">{{ $booking->contact_email }}</td></tr>
                    <tr><td style="padding:6px 0;font-size:13px;color:#64748b;">Tanggal Tour</td><td style="text-align:right;font-weight:700;color:#1e293b;">{{ $booking->travel_date->format('d M Y') }}</td></tr>
                    <tr><td style="padding:6px 0;font-size:13px;color:#64748b;border-top:1px solid #e2e8f0;padding-top:12px;">Total</td><td style="text-align:right;font-size:18px;font-weight:900;color:#1B3A4B;border-top:1px solid #e2e8f0;padding-top:12px;">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td></tr>
                </table>
            </td></tr>
        </table>

        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:20px;">
            <tr><td align="center">
                <a href="{{ route('admin.bookings.show', $booking) }}"
                    style="display:inline-block;background:linear-gradient(135deg,#1B3A4B,#14505F);color:white;padding:14px 36px;border-radius:12px;font-size:14px;font-weight:800;text-decoration:none;">
                    🔍 Lihat & Verifikasi Bukti
                </a>
            </td></tr>
        </table>

        <p style="font-size:12px;color:#94a3b8;text-align:center;margin:0;">TripWay Admin Panel · {{ now()->format('d M Y H:i') }}</p>
    </td></tr>

    <tr><td style="background:#f8fafc;border-radius:0 0 16px 16px;padding:16px 40px;text-align:center;border-top:1px solid #e2e8f0;">
        <div style="font-size:11px;color:#94a3b8;">© {{ date('Y') }} TripWay. All rights reserved.</div>
    </td></tr>

</table>
</td></tr>
</table>
</body>
</html>
