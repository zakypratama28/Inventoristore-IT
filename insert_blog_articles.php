// Run this in: php artisan tinker

$admin = \App\Models\User::where('role', 'admin')->first() ?? \App\Models\User::first();

// Article 1: ASUS TUF Gaming
\App\Models\BlogPost::create([
    'user_id' => $admin->id,
    'title' => 'Review ASUS TUF Gaming A15 2024: Laptop Gaming Terbaik Harga Terjangkau',
    'slug' => 'review-asus-tuf-gaming-a15-2024',
    'excerpt' => 'ASUS TUF Gaming A15 2024 hadir dengan AMD Ryzen 7000 series dan RTX 4060, menawarkan performa maksimal untuk gaming dengan harga di bawah 20 juta',
    'content' => '<h2>Spesifikasi Unggulan</h2><p>ASUS TUF Gaming A15 2024 ditenagai <strong>AMD Ryzen 7 7735HS</strong> dan <strong>NVIDIA RTX 4060 8GB</strong>. Mampu menjalankan game AAA dengan setting ultra 1080p @ 60+ FPS.</p><h3>Performa Gaming</h3><ul><li>Cyberpunk 2077: 70-80 FPS (Ultra)</li><li>Call of Duty: 140+ FPS (High)</li><li>Elden Ring: 120+ FPS (Max)</li></ul><h3>Build Quality</h3><p>Sertifikasi <strong>MIL-STD-810H</strong> - tahan benturan dan suhu ekstrem. Bobot 2.3kg dengan cooling <strong>Arc Flow Fans</strong> generasi baru.</p><p><strong>Harga: Rp 16.999.000</strong></p><p><strong>Rating: 4.5/5</strong> - Best value laptop gaming!</p>',
    'category' => 'Gaming',
    'status' => 'published',
    'published_at' => now()->subDays(3),
    'views' => rand(200, 500)
]);

// Article 2: Samsung S24 Ultra
\App\Models\BlogPost::create([
    'user_id' => $admin->id,
    'title' => 'Samsung Galaxy S24 Ultra: Smartphone Gaming Flagship Terbaik 2024',
    'slug' => 'samsung-s24-ultra-gaming-review',
    'excerpt' => 'Review lengkap S24 Ultra untuk mobile gaming. Snapdragon 8 Gen 3 for Galaxy, layar 120Hz, dan thermal management terbaik di kelasnya',
    'content' => '<h2>Performa Gaming Monster</h2><p><strong>Snapdragon 8 Gen 3 for Galaxy</strong> - overclock khusus dengan clock 3.39GHz. Benchmark AnTuTu: 1.850.000+</p><h3>Gaming Real-World</h3><ul><li>Genshin Impact (Max 60fps): Locked 60 FPS, suhu 38-40°C</li><li>PUBG Mobile (90fps Ultra): Consistent 90 FPS</li><li>Mobile Legends (120fps): Locked 120 FPS</li></ul><h3>Display Gaming</h3><p>6.8" QHD+ Dynamic AMOLED 2X dengan:<ul><li>Refresh Rate: Adaptive 1-120Hz</li><li>Touch Sampling: 240Hz</li><li>Brightness: 2,600 nits peak</li></ul></p><h3>Battery Life</h3><p>5,000 mAh dengan optimasi AI:<ul><li>Genshin Impact: 7-8 jam</li><li>PUBG Mobile: 9-10 jam</li><li>Fast Charging: 45W (0-50% = 20 menit)</li></ul></p><p><strong>Harga: Mulai Rp 19.999.000</strong></p><p><strong>Rating: 5/5</strong> - Ultimate gaming smartphone!</p>',
    'category' => 'Smartphone',
    'status' => 'published',
    'published_at' => now()->subDays(2),
    'views' => rand(300, 700)
]);

// Article 3: Top 5 Mouse Gaming
\App\Models\BlogPost::create([
    'user_id' => $admin->id,
    'title' => '5 Mouse Gaming Terbaik 2024: Logitech, Razer, dan Budget Options',
    'slug' => 'top-5-mouse-gaming-2024',
    'excerpt' => 'Rekomendasi mouse gaming terbaik untuk semua budget. Dari Logitech G Pro X Superlight 2 hingga opsi budget-friendly yang tidak kalah performa',
    'content' => '<h2>Top 5 Mouse Gaming 2024</h2><h3>1. Logitech G Pro X Superlight 2</h3><p><strong>Best for Esports</strong><ul><li>Sensor: HERO 2 (32,000 DPI)</li><li>Weight: 60 grams</li><li>Battery: 95 jam</li><li>Harga: Rp 2.799.000</li></ul>Lightweight champion dengan tracking accuracy terbaik. Favorit pro players!</p><h3>2. Razer Viper V3 Pro</h3><p><strong>Best All-Rounder</strong><ul><li>Sensor: Focus Pro 30K</li><li>Weight: 54 grams (paling ringan!)</li><li>Battery: 90 jam</li><li>Harga: Rp 2.499.000</li></ul>Ultimate evolution dari Viper lineage dengan optical switches gen-3.</p><h3>3. Logitech G502 X Plus</h3><p><strong>Best for MOBA/MMO</strong><ul><li>13 programmable buttons</li><li>Weight: 106g (balanced)</li><li>Battery: 120 jam</li><li>Harga: Rp 2.199.000</li></ul>Jack-of-all-trades dengan DPI-shift button dan wireless charging.</p><h3>4. Pulsar X2V2</h3><p><strong>Best Budget Option</strong><ul><li>Sensor: PAW3395 (top-tier!)</li><li>Weight: 55 grams</li><li>Dual connectivity (2.4GHz + Bluetooth)</li><li>Harga: Rp 1.699.000</li></ul>Dark horse dengan flagship performance di harga budget!</p><h3>5. Lamzu Atlantis Mini</h3><p><strong>Best for Small Hands</strong><ul><li>Weight: 49 grams (ultra-light!)</li><li>Size: 114mm x 60mm</li><li>Harga: Rp 1.899.000</li></ul>Specialist mouse untuk small hands / fingertip grip enthusiasts.</p><h3>Kesimpulan</h3><p><strong>Budget unlimited:</strong> Logitech G Pro X SL2<br><strong>Best value:</strong> Pulsar X2V2<br><strong>MOBA/MMO:</strong> G502 X Plus</p>',
    'category' => 'Review',
    'status' => 'published',
    'published_at' => now()->subDays(1),
    'views' => rand(150, 400)
]);

echo "✅ 3 Artikel berhasil dibuat!\n";
echo "Visit: /blog untuk lihat hasilnya\n";

exit
