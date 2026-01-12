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
        .order-summary { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .order-summary th, .order-summary td { padding: 10px; text-align: left; border-bottom: 1px solid #eee; }
        .total { font-weight: bold; font-size: 18px; color: #0d6efd; }
        .status-badge { display: inline-block; padding: 5px 15px; border-radius: 20px; background: #0d6efd; color: #fff; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="color: #0d6efd; margin: 0;">Terima Kasih Atas Pesanan Anda!</h1>
        </div>
        <div class="content">
            <p>Halo <strong>{{ $order->user->name }}</strong>,</p>
            <p>Pesanan Anda <strong>#{{ $order->code }}</strong> telah kami terima dan sedang dalam proses.</p>
            
            <h3>Ringkasan Pesanan:</h3>
            <table class="order-summary">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th style="text-align: right;">Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product->name }} (x{{ $item->quantity }})</td>
                        <td style="text-align: right;">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td class="total">Total</td>
                        <td class="total" style="text-align: right;">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>

            <h3>Informasi Pengiriman:</h3>
            <p>
                <strong>{{ $order->shipping_name }}</strong><br>
                {{ $order->shipping_phone }}<br>
                {{ $order->shipping_address }}, {{ $order->shipping_city }}<br>
                {{ $order->shipping_province }}, {{ $order->shipping_postal_code }}
            </p>
        </div>
        <div class="footer">
            <p>&copy; IGGStore. Semua Hak Dilindungi.</p>
        </div>
    </div>
</body>
</html>
