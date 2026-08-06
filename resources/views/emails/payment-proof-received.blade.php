<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Bukti Pembayaran Diterima - TripWay</title>
</head>
<body style="margin:0; padding:0; background:#f1f5f9; font-family:'Segoe UI',Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 20px;">
<tr><td align="center">
<table width="600" cellpadding="0" cellspacing="0" style="max-width:600px; width:100%;">

    {{-- Header --}}
    <tr><td style="background:linear-gradient(135deg,#1B3A4B 0%,#14505F 100%); border-radius:16px 16px 0 0; padding:32px 40px; text-align:center;">
        <div style="font-size:28px; font-weight:900; color:white; letter-spacing:-0.5px;">✈️ TripWay</div>
        <div style="font-size:13px; color:rgba(255,255,255,0.7); margin-top:4px;">Platform Wisata Terpercaya</div>
    </td></tr>

    {{-- Status Banner --}}
    <tr><td style="background:#f59e0b; padding:16px 40px; text-align:center;">
        <div style="font-size:15px; font-weight:800; color:white;">📩 Bukti Pembayaran Diterima!</div>
        <div style="font-size:12px; color:rgba(255,255,255,0.9); margin-top:6px;">Terima kasih, bukti transfer Anda sudah kami terima</div>
    </td></tr>

    {{-- Body --}}
    <tr><td style="background:white; padding:32px 40px;">

        {{-- Greeting --}}
        <p style="font-size:16px; color:#1e293b; margin:0 0 6px;">Halo, <strong>{{ $booking->contact_name }}</strong> 👋</p>
        <p style="font-size:14px; color:#64748b; margin:0 0 28px; line-height:1.6;">Kami telah menerima bukti pembayaran Anda. Tim kami akan segera memverifikasi pembayaran dalam maksimal <strong>1x24 jam</strong>. Anda akan menerima email lagi setelah pembayaran dikonfirmasi.</p>

        {{-- Tour Card --}}
        <table width="100%" cellpadding="0" cellspacing="0" style="background:linear-gradient(135deg,#1B3A4B,#14505F); border-radius:12px; margin-bottom:24px; overflow:hidden;">
            <tr><td style="padding:20px 24px;">
                <div style="font-size:11px; font-weight:700; color:rgba(255,255,255,0.6); text-transform:uppercase; letter-spacing:0.08em; margin-bottom:6px;">🗺️ Tour</div>
                <div style="font-size:17px; font-weight:800; color:white; line-height:1.3; margin-bottom:8px;">{{ $booking->tour->title }}</div>
                <div style="font-size:12px; color:rgba(255,255,255,0.75);">
                    📍 {{ $booking->tour->destination->name }}
                    &nbsp;&nbsp;·&nbsp;&nbsp;
                    ⏱️ {{ $booking->tour->duration }} {{ $booking->tour->duration_type == 'hours' ? 'jam' : 'hari' }}
                </div>
            </td></tr>
        </table>

        {{-- Detail Grid --}}
        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
            <tr>
                {{-- Kiri --}}
                <td width="48%" valign="top" style="background:#f8fafc; border-radius:10px; padding:16px 18px; border:1px solid #e2e8f0;">
                    <div style="font-size:10px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.06em; margin-bottom:12px;">📋 Detail Booking</div>
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="font-size:12px; color:#64748b; padding:4px 0;">Booking ID</td>
                            <td style="font-size:12px; font-weight:800; color:#1B3A4B; text-align:right;">#{{ $booking->id }}</td>
                        </tr>
                        <tr>
                            <td style="font-size:12px; color:#64748b; padding:4px 0;">Paket</td>
                            <td style="font-size:12px; font-weight:700; color:#1e293b; text-align:right;">{{ $booking->package->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="font-size:12px; color:#64748b; padding:4px 0;">Tipe</td>
                            <td style="font-size:12px; font-weight:700; color:#1e293b; text-align:right;">
                                @if($booking->travel_type === 'private')
                                    <span style="background:#dbeafe; color:#1d4ed8; padding:2px 8px; border-radius:10px; font-size:11px;">Private</span>
                                @else
                                    <span style="background:#dcfce7; color:#15803d; padding:2px 8px; border-radius:10px; font-size:11px;">Sharing</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </td>
                <td width="4%"></td>
                {{-- Kanan --}}
                <td width="48%" valign="top" style="background:#f8fafc; border-radius:10px; padding:16px 18px; border:1px solid #e2e8f0;">
                    <div style="font-size:10px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.06em; margin-bottom:12px;">📅 Jadwal & Peserta</div>
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="font-size:12px; color:#64748b; padding:4px 0;">Tanggal</td>
                            <td style="font-size:12px; font-weight:700; color:#1e293b; text-align:right;">{{ $booking->travel_date->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <td style="font-size:12px; color:#64748b; padding:4px 0;">Peserta</td>
                            <td style="font-size:12px; font-weight:700; color:#1e293b; text-align:right;">{{ $booking->num_persons }} orang</td>
                        </tr>
                        <tr>
                            <td style="font-size:12px; color:#64748b; padding:4px 0;">Kontak</td>
                            <td style="font-size:12px; font-weight:700; color:#1e293b; text-align:right;">{{ $booking->contact_phone }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        {{-- Total --}}
        <table width="100%" cellpadding="0" cellspacing="0" style="background:linear-gradient(135deg,#f0f9ff,#e0f2fe); border:1px solid #bfdbfe; border-radius:12px; margin-bottom:24px;">
            <tr><td style="padding:16px 20px;">
                <table width="100%">
                    <tr>
                        <td style="font-size:13px; color:#1d4ed8; font-weight:700;">💰 Total Pembayaran</td>
                        <td style="text-align:right; font-size:24px; font-weight:900; color:#1B3A4B;">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="font-size:11px; color:#64748b; padding-top:4px;">⏳ Menunggu verifikasi admin</td>
                    </tr>
                </table>
            </td></tr>
        </table>

        {{-- Notice --}}
        <table width="100%" cellpadding="0" cellspacing="0" style="background:#fff7ed; border:1px solid #fed7aa; border-radius:12px; margin-bottom:28px;">
            <tr><td style="padding:16px 20px;">
                <div style="font-size:12px; font-weight:800; color:#9a3412; margin-bottom:8px;">⏳ Status Pembayaran Anda:</div>
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr><td style="padding:4px 0; font-size:12px; color:#7c2d12;">✅ &nbsp;Bukti transfer diterima</td></tr>
                    <tr><td style="padding:4px 0; font-size:12px; color:#7c2d12;">🔍 &nbsp;Sedang diverifikasi oleh admin (maks. 1x24 jam)</td></tr>
                    <tr><td style="padding:4px 0; font-size:12px; color:#7c2d12;">📩 &nbsp;Anda akan mendapat email konfirmasi + tiket setelah disetujui</td></tr>
                </table>
            </td></tr>
        </table>

        {{-- CTA --}}
        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:20px;">
            <tr><td align="center">
                <a href="{{ route('payment.order-detail', $booking) }}"
                    style="display:inline-block; background:linear-gradient(135deg,#1B3A4B,#14505F); color:white; padding:14px 40px; border-radius:12px; font-size:14px; font-weight:800; text-decoration:none; box-shadow:0 4px 14px rgba(27,58,75,0.3);">
                    📋 Lihat Status Pesanan
                </a>
            </td></tr>
        </table>

        <p style="font-size:12px; color:#94a3b8; text-align:center; margin:0;">Pertanyaan? Hubungi kami di <a href="mailto:support@tripway.id" style="color:#1B3A4B;">support@tripway.id</a></p>

    </td></tr>

    {{-- Footer --}}
    <tr><td style="background:#1e293b; border-radius:0 0 16px 16px; padding:20px 40px; text-align:center;">
        <div style="font-size:16px; font-weight:900; color:white; margin-bottom:6px;">✈️ TripWay</div>
        <div style="font-size:11px; color:#94a3b8; margin-bottom:8px;">Platform Wisata Terpercaya Indonesia</div>
        <div style="font-size:10px; color:#64748b;">© {{ date('Y') }} TripWay. All rights reserved.</div>
    </td></tr>

</table>
</td></tr>
</table>
</body>
</html>
