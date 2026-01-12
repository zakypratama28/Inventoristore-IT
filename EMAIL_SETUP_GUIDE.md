# Fix Email Configuration untuk Development

## Masalah
Error: `Mail Error: Connection could not be established with host mailhog`

Ini terjadi karena aplikasi mencoba mengirim email (untuk email verification atau password reset) tapi mailhog tidak tersedia di localhost Anda.

## Solusi Cepat (Untuk Development)

### Pilihan 1: Gunakan Log Driver (Recommended untuk Testing)

Edit file `.env` Anda dan ubah bagian MAIL menjadi:

```env
MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@iggstore.local"
MAIL_FROM_NAME="${APP_NAME}"
```

Dengan konfigurasi ini, **email tidak benar-benar dikirim**, tapi ditulis ke file `storage/logs/laravel.log`. Anda bisa buka file tersebut untuk melihat isi email yang akan dikirim (termasuk verification code atau reset password link).

### Pilihan 2: Disable Email Verification (Quick Fix)

Jika Anda tidak butuh email verification untuk testing, Anda bisa skip verification dengan:

1. Edit file `c:\wamp64\www\afl1-wdev\routes\web.php`
2. Ubah middleware `['auth', 'verified']` menjadi `['auth']` untuk routes yang tidak memerlukan verifikasi

**ATAU**

Setelah register, langsung set `email_verified_at` di database:

```sql
UPDATE users SET email_verified_at = NOW() WHERE email IS NOT NULL;
```

### Pilihan 3: Gunakan Mailtrap.io (Untuk Testing Email Real)

Jika Anda ingin test email secara real tanpa mengirim ke email asli:

1. Daftar gratis di https://mailtrap.io
2. Buat inbox baru
3. Copy credentials SMTP
4. Update `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@iggstore.local"
MAIL_FROM_NAME="${APP_NAME}"
```

## Setelah Update .env

Jalankan:

```bash
php artisan config:cache
```

Atau untuk clear semua cache:

```bash
php artisan config:clear
php artisan cache:clear
```

## Untuk Melihat Email di Log

Jika menggunakan log driver, buka file:
```
c:\wamp64\www\afl1-wdev\storage\logs\laravel.log
```

Scroll ke bawah untuk melihat email terbaru. Anda akan menemukan:
- Subject email
- Body/content email
- Verification code (untuk email verification)
- Password reset link (untuk forgot password)

## Testing Email Verification

1. Register user baru
2. Buka `storage/logs/laravel.log`
3. Cari email terbaru (paling bawah file)
4. Copy 6-digit verification code
5. Masukkan di halaman verification

## Testing Password Reset

1. Klik "Forgot Password"
2. Masukkan email
3. Buka `storage/logs/laravel.log`
4. Cari reset password link
5. Copy URL dan paste di browser

---

**Recommended:** Gunakan **MAIL_MAILER=log** untuk development agar tidak perlu setup SMTP.
