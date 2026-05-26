<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pesanan TripWay</title>
</head>
<body style="margin:0; padding:0; background:#f1f5f9; font-family:'Segoe UI',Arial,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#f1f5f9; padding:40px 20px;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px; width:100%;">

                {{-- Header --}}
                <tr>
                    <td style="background:linear-gradient(135deg,#1B3A4B,#14505F); border-radius:16px 16px 0 0; padding:32px 40px; text-align:center;">
                        <div style="font-size:28px; font-weight:900; color:white; letter-spacing:-0.5px;">✈️ TripWay</div>
                        <div style="font-size:13px; color:rgba(255,255,255,0.75); margin-top:4px;">Petualangan Tak Terlupakan</div>
                    </td>
                </tr>

                {{-- Status Banner --}}
                <tr>
                    <td style="background:#22c55e; padding:16px 40px; text-align:center;">
                        <div style="font-size:15px; font-weight:700; color:white;">
                            ✅ Pesanan Anda Berhasil Dibuat!
                        </div>
                        <div style="font-size:12px; color:rgba(255,255,255,0.85); margin-top:4px;">
                            Selesaikan pembayaran untuk konfirmasi booking
                        </div>
                    </td>
                </tr>

                {{-- Body --}}
                <tr>
                    <td style="background:white; padding:32px 40px;">

                        <p style="font-size:15px; color:#1e293b; margin:0 0 24px;">
                            Halo <strong>{{ $booking->contact_name }}</strong>, 👋<br>
                            Terima kasih telah memesan melalui TripWay. Berikut detail pesanan Anda:
                        </p>

                        {{-- Tour Card --}}
                        <table width="100%" cellpadding="0" cellspacing="0" style="background:#f8fafc; border-radius:12px; border:1px solid #e2e8f0; margin-bottom:24px; overflow:hidden;">
                            <tr>
                                <td style="padding:16px 20px;">
                                    <div style="font-size:11px; font-weight:700; color:#1B3A4B; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:4px;">
                                        {{ $booking->tour->category->name }} · {{ $booking->tour->destination->name }}
                                    </div>
                                    <div style="font-size:18px; font-weight:800; color:#1e293b; margin-bottom:8px;">
                                        {{ $booking->tour->title }}
                                    </div>
                                    <div style="font-size:12px; color:#64748b;">
                                        🕐 {{ $booking->tour->duration }} {{ $booking->tour->duration_type == 'hours' ? 'jam' : 'hari' }}
                                        &nbsp;&nbsp;📍 {{ $booking->tour->destination->name }}
                                    </div>
                                </td>
                            </tr>
                        </table>

                        {{-- Detail Table --}}
                        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
                            <tr>
                                <td colspan="2" style="font-size:12px; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.05em; padding-bottom:12px; border-bottom:2px solid #e2e8f0;">
                                    Detail Pesanan
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:10px 0; font-size:13px; color:#64748b; border-bottom:1px solid #f1f5f9; width:45%;">Paket</td>
                                <td style="padding:10px 0; font-size:13px; font-weight:700; color:#1e293b; border-bottom:1px solid #f1f5f9; text-align:right;">{{ $booking->package->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td style="padding:10px 0; font-size:13px; color:#64748b; border-bottom:1px solid #f1f5f9;">Tipe Perjalanan</td>
                                <td style="padding:10px 0; font-size:13px; font-weight:700; color:#1e293b; border-bottom:1px solid #f1f5f9; text-align:right;">{{ ucfirst($booking->travel_type) }}</td>
                            </tr>
                            <tr>
                                <td style="padding:10px 0; font-size:13px; color:#64748b; border-bottom:1px solid #f1f5f9;">Tanggal</td>
                                <td style="padding:10px 0; font-size:13px; font-weight:700; color:#1e293b; border-bottom:1px solid #f1f5f9; text-align:right;">{{ $booking->travel_date->format('d M Y') }}</td>
                            </tr>
                            <tr>
                                <td style="padding:10px 0; font-size:13px; color:#64748b; border-bottom:1px solid #f1f5f9;">Jumlah Peserta</td>
                                <td style="padding:10px 0; font-size:13px; font-weight:700; color:#1e293b; border-bottom:1px solid #f1f5f9; text-align:right;">{{ $booking->num_persons }} orang</td>
                            </tr>
                            <tr>
                                <td style="padding:10px 0; font-size:13px; color:#64748b;">Nama Pemesan</td>
                                <td style="padding:10px 0; font-size:13px; font-weight:700; color:#1e293b; text-align:right;">{{ $booking->contact_name }}</td>
                            </tr>
                        </table>

                        {{-- Total --}}
                        <table width="100%" cellpadding="0" cellspacing="0" style="background:#1B3A4B; border-radius:12px; margin-bottom:28px;">
                            <tr>
                                <td style="padding:16px 20px; font-size:14px; font-weight:700; color:rgba(255,255,255,0.8);">Total Pembayaran</td>
                                <td style="padding:16px 20px; font-size:22px; font-weight:900; color:white; text-align:right;">
                                    Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                </td>
                            </tr>
                        </table>

                        {{-- CTA Button --}}
                        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:28px;">
                            <tr>
                                <td align="center">
                                    <a href="{{ route('payment.order-detail', $booking) }}"
                                        style="display:inline-block; background:linear-gradient(135deg,#1B3A4B,#14505F); color:white; padding:14px 40px; border-radius:12px; font-size:15px; font-weight:800; text-decoration:none; box-shadow:0 4px 16px rgba(27,58,75,0.3);">
                                        💳 Selesaikan Pembayaran
                                    </a>
                                </td>
                            </tr>
                        </table>

                        {{-- Notice --}}
                        <table width="100%" cellpadding="0" cellspacing="0" style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:10px; margin-bottom:16px;">
                            <tr>
                                <td style="padding:12px 16px; font-size:12px; color:#15803d; line-height:1.6;">
                                    ✅ <strong>Pembatalan gratis</strong> hingga 24 jam sebelum keberangkatan.
                                </td>
                            </tr>
                        </table>
                        <table width="100%" cellpadding="0" cellspacing="0" style="background:#eff6ff; border:1px solid #bfdbfe; border-radius:10px;">
                            <tr>
                                <td style="padding:12px 16px; font-size:12px; color:#1d4ed8; line-height:1.6;">
                                    ℹ️ Pesanan akan dikonfirmasi setelah pembayaran selesai. Jika ada pertanyaan, hubungi kami di <strong>support@tripway.id</strong>
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>

                {{-- Footer --}}
                <tr>
                    <td style="background:#f8fafc; border-radius:0 0 16px 16px; padding:24px 40px; text-align:center; border-top:1px solid #e2e8f0;">
                        <div style="font-size:13px; font-weight:700; color:#1B3A4B; margin-bottom:4px;">TripWay</div>
                        <div style="font-size:11px; color:#94a3b8; line-height:1.6;">
                            Email ini dikirim otomatis, mohon tidak membalas email ini.<br>
                            © {{ date('Y') }} TripWay. All rights reserved.
                        </div>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>

</body>
</html>
