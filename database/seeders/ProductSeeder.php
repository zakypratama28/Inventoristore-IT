<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'name' => 'Mechanical Keyboard',
                'description' => 'Keyboard mekanik dengan switch tactile untuk pengalaman mengetik lebih nyaman.',
                'price' => 750000,
            ],
            [
                'name' => 'Wireless Mouse',
                'description' => 'Mouse nirkabel dengan sensor optik 1600 DPI dan desain ergonomis.',
                'price' => 150000,
            ],
            [
                'name' => 'Gaming Laptop',
                'description' => 'Laptop gaming dengan prosesor i7 dan GTX series untuk kebutuhan berat.',
                'price' => 15000000,
            ],
            [
                'name' => 'USB-C Hub',
                'description' => 'Hub USB-C dengan 4 port USB 3.0, HDMI, dan slot SD card.',
                'price' => 350000,
            ],
            [
                'name' => 'External SSD 1TB',
                'description' => 'SSD eksternal 1TB dengan kecepatan transfer tinggi dan desain compact.',
                'price' => 2000000,
            ],
            [
                'name' => '27-inch Monitor',
                'description' => 'Monitor 27 inci Full HD dengan bezel tipis dan refresh rate 75Hz.',
                'price' => 2300000,
            ],
            [
                'name' => 'Webcam HD',
                'description' => 'Webcam 1080p untuk keperluan meeting online dan live streaming.',
                'price' => 400000,
            ],
            [
                'name' => 'Bluetooth Speaker',
                'description' => 'Speaker Bluetooth portabel dengan baterai tahan hingga 10 jam.',
                'price' => 300000,
            ],
            [
                'name' => 'Office Chair',
                'description' => 'Kursi kantor ergonomis dengan sandaran punggung tinggi dan armrest.',
                'price' => 1200000,
            ],
            [
                'name' => 'Standing Desk',
                'description' => 'Meja kerja yang dapat diatur tinggi rendahnya untuk kerja lebih nyaman.',
                'price' => 2500000,
            ],
            [
                'name' => 'Graphics Tablet',
                'description' => 'Tablet gambar dengan pen pressure 4096 level untuk desain digital.',
                'price' => 950000,
            ],
            [
                'name' => 'Laser Printer',
                'description' => 'Printer laser monokrom dengan konektivitas USB dan WiFi.',
                'price' => 1800000,
            ],
            [
                'name' => 'WiFi Router',
                'description' => 'Router dual-band dengan jangkauan luas untuk rumah dan kantor kecil.',
                'price' => 600000,
            ],
            [
                'name' => 'Noise Cancelling Headphones',
                'description' => 'Headphone over-ear dengan fitur active noise cancelling.',
                'price' => 1300000,
            ],
            [
                'name' => 'USB Microphone',
                'description' => 'Mikrofon USB untuk podcast dan voice recording berkualitas tinggi.',
                'price' => 700000,
            ],
            [
                'name' => 'Smartphone Stand',
                'description' => 'Stand HP aluminium yang kokoh untuk meja kerja.',
                'price' => 80000,
            ],
            [
                'name' => 'Laptop Cooling Pad',
                'description' => 'Cooling pad dengan dua kipas besar untuk menurunkan suhu laptop.',
                'price' => 200000,
            ],
            [
                'name' => 'HDMI Cable 2m',
                'description' => 'Kabel HDMI panjang 2 meter mendukung resolusi 4K.',
                'price' => 50000,
            ],
            [
                'name' => 'Portable Power Bank',
                'description' => 'Power bank 20.000 mAh dengan dua port USB.',
                'price' => 250000,
            ],
            [
                'name' => 'LED Desk Lamp',
                'description' => 'Lampu meja LED dengan 3 mode cahaya dan pengatur brightness.',
                'price' => 170000,
            ],
        ];

        foreach ($products as $data) {
            Product::create($data);
        }
    }
}
