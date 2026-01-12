<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; }
        .container { width: 100%; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 10px; }
        .header { text-align: center; padding-bottom: 20px; border-bottom: 2px solid #0d6efd; }
        .content { padding: 20px 0; }
        .footer { text-align: center; font-size: 12px; color: #777; padding-top: 20px; border-top: 1px solid #eee; }
        .status-badge { display: inline-block; padding: 5px 15px; border-radius: 20px; background: #0d6efd; color: #fff; font-weight: bold; text-transform: uppercase; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="color: #0d6efd; margin: 0;">Status Pesanan Diperbarui</h1>
        </div>
        <div class="content">
            <p>Halo <strong>{{ $order->user->name }}</strong>,</p>
            <p>Status pesanan Anda <strong>#{{ $order->code }}</strong> telah berubah menjadi:</p>
            
            <div style="text-align: center; margin: 30px 0;">
                <span class="status-badge">{{ $order->status }}</span>
            </div>

            <p>Kami akan memberitahu Anda kembali jika ada pembaruan lebih lanjut.</p>
            
            <div style="text-align: center; margin-top: 20px;">
                <a href="{{ route('orders.show', $order->id) }}" style="background: #0d6efd; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;">Lihat Detail Pesanan</a>
            </div>
        </div>
        <div class="footer">
            <p>&copy; IGGStore. Semua Hak Dilindungi.</p>
        </div>
    </div>
</body>
</html>
