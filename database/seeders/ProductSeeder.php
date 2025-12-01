<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Pastikan kategori sudah ada
        $categories = Category::pluck('id', 'name');

        $products = [
            // Elektronik
            [
                'name' => 'Gaming Laptop 15 inch',
                'description' => 'Laptop gaming dengan GPU dedicated dan layar 144Hz.',
                'price' => 16500000,
                'category_name' => 'Elektronik',
            ],
            [
                'name' => 'Monitor 27 inch IPS',
                'description' => 'Monitor kerja dengan panel IPS dan warna akurat.',
                'price' => 2800000,
                'category_name' => 'Elektronik',
            ],
            [
                'name' => 'Smartphone 5G',
                'description' => 'Smartphone 5G dengan baterai 5000mAh.',
                'price' => 4500000,
                'category_name' => 'Elektronik',
            ],
            [
                'name' => 'Tablet 10 inch',
                'description' => 'Tablet untuk konsumsi multimedia dan belajar online.',
                'price' => 3200000,
                'category_name' => 'Elektronik',
            ],

            // Aksesoris Komputer
            [
                'name' => 'Mechanical Keyboard TKL',
                'description' => 'Keyboard mekanik tenkeyless dengan switch tactile.',
                'price' => 850000,
                'category_name' => 'Aksesoris Komputer',
            ],
            [
                'name' => 'Wireless Mouse Ergonomis',
                'description' => 'Mouse nirkabel dengan desain nyaman untuk penggunaan harian.',
                'price' => 190000,
                'category_name' => 'Aksesoris Komputer',
            ],
            [
                'name' => 'Gaming Headset',
                'description' => 'Headset gaming dengan mic noise cancelling.',
                'price' => 450000,
                'category_name' => 'Aksesoris Komputer',
            ],
            [
                'name' => 'USB-C Hub 7 Port',
                'description' => 'Hub USB-C dengan HDMI, USB 3.0 dan card reader.',
                'price' => 410000,
                'category_name' => 'Aksesoris Komputer',
            ],
            [
                'name' => 'External SSD 512GB',
                'description' => 'SSD eksternal untuk backup file penting.',
                'price' => 1350000,
                'category_name' => 'Aksesoris Komputer',
            ],
            [
                'name' => 'Laptop Cooling Pad',
                'description' => 'Cooling pad dengan 2 kipas besar dan LED.',
                'price' => 220000,
                'category_name' => 'Aksesoris Komputer',
            ],

            // Perlengkapan Kantor
            [
                'name' => 'Kursi Kantor Ergonomis',
                'description' => 'Kursi kantor dengan sandaran punggung tinggi.',
                'price' => 1550000,
                'category_name' => 'Perlengkapan Kantor',
            ],
            [
                'name' => 'Meja Kerja Minimalis',
                'description' => 'Meja kerja kayu dengan desain sederhana.',
                'price' => 900000,
                'category_name' => 'Perlengkapan Kantor',
            ],
            [
                'name' => 'Printer Inkjet',
                'description' => 'Printer inkjet warna untuk kebutuhan kantor kecil.',
                'price' => 1200000,
                'category_name' => 'Perlengkapan Kantor',
            ],
            [
                'name' => 'Rak Dokumen 3 Susun',
                'description' => 'Rak plastik untuk menyimpan dokumen di meja kerja.',
                'price' => 120000,
                'category_name' => 'Perlengkapan Kantor',
            ],
            [
                'name' => 'Lampu Meja LED',
                'description' => 'Lampu meja dengan pengaturan tingkat kecerahan.',
                'price' => 185000,
                'category_name' => 'Perlengkapan Kantor',
            ],

            // Tambahan (supaya total >= 30)
            [
                'name' => 'Bluetooth Speaker Kantor',
                'description' => 'Speaker Bluetooth untuk ruang kerja kecil.',
                'price' => 350000,
                'category_name' => 'Perlengkapan Kantor',
            ],
            [
                'name' => 'Webcam Full HD',
                'description' => 'Webcam 1080p untuk meeting online.',
                'price' => 420000,
                'category_name' => 'Aksesoris Komputer',
            ],
            [
                'name' => 'Power Bank 20000mAh',
                'description' => 'Power bank kapasitas besar untuk perangkat mobile.',
                'price' => 260000,
                'category_name' => 'Elektronik',
            ],
            [
                'name' => 'Router WiFi Dual Band',
                'description' => 'Router dengan dukungan 2.4GHz dan 5GHz.',
                'price' => 580000,
                'category_name' => 'Elektronik',
            ],
            [
                'name' => 'Flashdisk 64GB',
                'description' => 'Flashdisk USB 3.0 untuk transfer cepat.',
                'price' => 120000,
                'category_name' => 'Aksesoris Komputer',
            ],
            [
                'name' => 'Kabel HDMI 2m',
                'description' => 'Kabel HDMI mendukung resolusi 4K.',
                'price' => 65000,
                'category_name' => 'Aksesoris Komputer',
            ],
            [
                'name' => 'Stabilo Warna 6 pcs',
                'description' => 'Set stabilo untuk menandai dokumen.',
                'price' => 45000,
                'category_name' => 'Perlengkapan Kantor',
            ],
            [
                'name' => 'Binder A4',
                'description' => 'Binder untuk menyimpan kertas A4.',
                'price' => 35000,
                'category_name' => 'Perlengkapan Kantor',
            ],
            [
                'name' => 'Kalkulator Meja',
                'description' => 'Kalkulator besar untuk meja kasir atau kantor.',
                'price' => 80000,
                'category_name' => 'Perlengkapan Kantor',
            ],
            [
                'name' => 'Stand Laptop Aluminium',
                'description' => 'Stand untuk menaikkan posisi laptop.',
                'price' => 275000,
                'category_name' => 'Aksesoris Komputer',
            ],
            [
                'name' => 'Mouse Pad Besar',
                'description' => 'Mouse pad ukuran besar untuk setup kerja.',
                'price' => 90000,
                'category_name' => 'Aksesoris Komputer',
            ],
            [
                'name' => 'Headset Call Center',
                'description' => 'Headset ringan untuk keperluan call center.',
                'price' => 310000,
                'category_name' => 'Perlengkapan Kantor',
            ],
            [
                'name' => 'Kamera CCTV Indoor',
                'description' => 'Kamera CCTV untuk pemantauan ruangan.',
                'price' => 675000,
                'category_name' => 'Elektronik',
            ],
            [
                'name' => 'Extention Cord 4 Stopkontak',
                'description' => 'Kabel roll dengan 4 stopkontak dan saklar.',
                'price' => 95000,
                'category_name' => 'Elektronik',
            ],
        ];

        foreach ($products as $data) {
            $categoryId = $categories[$data['category_name']] ?? null;

            Product::updateOrCreate(
                ['name' => $data['name']],
                [
                    'description' => $data['description'],
                    'price'       => $data['price'],
                    'category_id' => $categoryId,
                ]
            );
        }
    }
}
