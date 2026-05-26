# Midtrans API Keys Setup

## Cara Mendapatkan API Keys

1. Login ke **Midtrans Dashboard** (https://dashboard.midtrans.com)
2. Klik **Settings** > **Access Keys**
3. Anda akan melihat:
    - **Server Key**
    - **Client Key**

## Tambahkan ke .env file

Buka file `.env` dan tambahkan:

```env
# Midtrans Configuration
MIDTRANS_SERVER_KEY=SB-Mid-server-xxxxx-xxxxx-xxxxx
MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxxx-xxxxx-xxxxx
MIDTRANS_IS_PRODUCTION=false
```

Ganti `SB-Mid-server-xxxxx` dan `SB-Mid-client-xxxxx` dengan keys dari dashboard Anda.

## Setelah添加keys

Jalankan perintah ini di terminal:

```bash
php artisan config:clear
```

Lalu coba booking lagi.

## Testing

Untuk testing, Anda bisa gunakan kartu tes Midtrans:

- Nomor Kartu: 4811 1111 1111 1114
- CVV: 123
- Expiry: 12/25
- OTP: 112233
