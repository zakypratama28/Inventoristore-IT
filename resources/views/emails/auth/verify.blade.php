<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; }
        .container { width: 100%; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 10px; }
        .header { text-align: center; padding-bottom: 20px; border-bottom: 2px solid #0d6efd; }
        .content { padding: 20px 0; text-align: center; }
        .code { font-size: 32px; font-weight: bold; letter-spacing: 5px; color: #0d6efd; background: #f8f9fa; padding: 15px; border-radius: 8px; display: inline-block; margin: 20px 0; border: 1px dashed #0d6efd; }
        .footer { text-align: center; font-size: 12px; color: #777; padding-top: 20px; border-top: 1px solid #eee; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="color: #0d6efd; margin: 0;">Verifikasi Email Anda</h1>
        </div>
        <div class="content">
            <p>Halo <strong>{{ $user->name }}</strong>,</p>
            <p>Terima kasih telah bergabung dengan IGGStore. Silakan gunakan kode verifikasi di bawah ini untuk menyelesaikan proses pendaftaran Anda:</p>
            
            <div class="code">{{ $user->verification_code }}</div>

            <p>Kode ini berlaku untuk sementara. Jika Anda tidak merasa melakukan pendaftaran, silakan abaikan email ini.</p>
        </div>
        <div class="footer">
            <p>&copy; IGGStore. Semua Hak Dilindungi.</p>
        </div>
    </div>
</body>
</html>
