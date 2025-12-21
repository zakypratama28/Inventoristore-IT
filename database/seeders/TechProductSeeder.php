<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Product;

class TechProductSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        // 1. Bersihkan Data Lama
        Product::truncate();
        Category::truncate();
        
        // Optional: Bersihkan Order Items jika ingin benar-benar fresh
        // DB::table('order_items')->truncate();
        // DB::table('orders')->truncate();

        Schema::enableForeignKeyConstraints();

        // 2. Buat Kategori Baru
        $categories = [
            'Laptop Gaming' => 'Laptop spesifikasi tinggi untuk gaming dan editing',
            'Smartphone & Tablet' => 'Gadget terbaru dari berbagai brand',
            'Gaming Gear' => 'Mouse, Keyboard, Headset, dan Controller',
            'Aksesoris Komputer' => 'Kabel, Adapter, Hub, dan perlengkapan lainnya',
            'Komponen PC' => 'SSD, RAM, VGA, dan Hardware',
        ];

        $catIds = [];
        foreach ($categories as $name => $desc) {
            $cat = Category::create([
                'name' => $name,
            ]);
            $catIds[$name] = $cat->id;
        }

        // 3. Data Produk Realistis (Using Unsplash Source for Demo)
        $products = [
            // LAPTOP GAMING
            [
                'name' => 'ASUS ROG Zephyrus G14',
                'category' => 'Laptop Gaming',
                'price' => 24500000,
                'stock' => 15,
                'description' => 'Laptop gaming ultra-compact dengan prosesor AMD Ryzen 9 dan GPU NVIDIA GeForce RTX 4060. Layar ROG Nebula Display OLED 120Hz yang memukau.',
                'image_path' => 'https://images.unsplash.com/photo-1667571348873-10e95c1a8d0b?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'Lenovo Legion Pro 5i',
                'category' => 'Laptop Gaming',
                'price' => 21000000,
                'stock' => 10,
                'description' => 'Performa buas dengan Intel Core i7 Gen 13 dan RTX 4070. Sistem pendingin ColdFront 5.0 menjamin performa stabil saat gaming berat.',
                'image_path' => 'https://images.unsplash.com/photo-1593640408182-31c70c8268f5?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'Acer Nitro V 15',
                'category' => 'Laptop Gaming',
                'price' => 12500000,
                'stock' => 25,
                'description' => 'Laptop gaming entry-level terbaik. Intel Core i5 Gen 13, RTX 4050, RAM 8GB DDR5 (Upgradeable). Cocok untuk pelajar dan gamer pemula.',
                'image_path' => 'https://images.unsplash.com/photo-1603302576837-37561b2e2302?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'MSI Katana 15',
                'category' => 'Laptop Gaming',
                'price' => 18999000,
                'stock' => 8,
                'description' => 'Desain tajam dengan performa i7-13620H dan RTX 4060. Keyboard 4-Zone RGB yang stylish.',
                'image_path' => 'https://images.unsplash.com/photo-1613271578351-71fb35565551?auto=format&fit=crop&q=80&w=800',
            ],

            // SMARTPHONE & TABLET
            [
                'name' => 'Samsung Galaxy S24 Ultra',
                'category' => 'Smartphone & Tablet',
                'price' => 21999000,
                'stock' => 20,
                'description' => 'Smartphone Android terbaik dengan Galaxy AI. Kamera 200MP, Titanium Frame, dan Snapdragon 8 Gen 3 for Galaxy.',
                'image_path' => 'https://images.unsplash.com/photo-1610945415295-d9bbf067e59c?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'iPhone 15 Pro Max 256GB',
                'category' => 'Smartphone & Tablet',
                'price' => 23999000,
                'stock' => 12,
                'description' => 'Material Titanium, Chip A17 Pro, dan Action Button baru. Kemampuan kamera setara profesional.',
                'image_path' => 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'iPad Air 5 M1 64GB',
                'category' => 'Smartphone & Tablet',
                'price' => 9499000,
                'stock' => 18,
                'description' => 'Tablet powerful dengan chip Apple M1. Layar Liquid Retina 10.9 inci, cocok untuk desain dan multitasking.',
                'image_path' => 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'Xiaomi Pad 6',
                'category' => 'Smartphone & Tablet',
                'price' => 4999000,
                'stock' => 30,
                'description' => 'Tablet value-for-money terbaik. Snapdragon 870, Layar 144Hz WQHD+, Quad Speakers Dolby Atmos.',
                'image_path' => 'https://images.unsplash.com/photo-1561154464-82e9adf32764?auto=format&fit=crop&q=80&w=800',
            ],

            // GAMING GEAR
            [
                'name' => 'Logitech G Pro X Superlight 2',
                'category' => 'Gaming Gear',
                'price' => 2399000,
                'stock' => 45,
                'description' => 'Mouse gaming wireless teringan dan tercepat. Sensor HERO 2, Switch Lightforce Hybrid, battery life 95 jam.',
                'image_path' => 'https://images.unsplash.com/photo-1615663245857-acda5b2b1518?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'Razer BlackWidow V4 Pro',
                'category' => 'Gaming Gear',
                'price' => 3800000,
                'stock' => 10,
                'description' => 'Keyboard mekanikal premium dengan Command Dial, tombol makro dedicated, dan underglow RGB yang immersive.',
                'image_path' => 'https://images.unsplash.com/photo-1595225476474-87563907a212?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'HyperX Cloud III Wireless',
                'category' => 'Gaming Gear',
                'price' => 2400000,
                'stock' => 22,
                'description' => 'Headset gaming legendaris kini wireless. Kenyamanan super, driver 53mm angled, baterai hingga 120 jam.',
                'image_path' => 'https://images.unsplash.com/photo-1599669454699-248893623440?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'SteelSeries Apex Pro TKL',
                'category' => 'Gaming Gear',
                'price' => 3200000,
                'stock' => 15,
                'description' => 'Keyboard e-sports tercepat duni. Switch OmniPoint 2.0 yang bisa diatur aktuasi-nya dari 0.2mm hingga 3.8mm.',
                'image_path' => 'https://images.unsplash.com/photo-1587829741301-30c00609557f?auto=format&fit=crop&q=80&w=800',
            ],

            // PERIPHERALS & AKSESORIS
            [
                'name' => 'Samsung T7 Shield 1TB SSD',
                'category' => 'Aksesoris Komputer',
                'price' => 1650000,
                'stock' => 40,
                'description' => 'SSD Eksternal rugged tahan banting dan air (IP65). Kecepatan transfer hingga 1050MB/s.',
                'image_path' => 'https://images.unsplash.com/photo-1628557044797-f21a17b96e9f?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'Baseus Gan5 Pro Charger 65W',
                'category' => 'Aksesoris Komputer',
                'price' => 350000,
                'stock' => 100,
                'description' => 'Charger GaN ultra-compact 65W. Bisa charge laptop, tablet, dan HP sekaligus. Dual Type-C + USB A.',
                'image_path' => 'https://images.unsplash.com/photo-1583863788755-6369f64933d4?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'Logitech MX Master 3S',
                'category' => 'Aksesoris Komputer',
                'price' => 1600000,
                'stock' => 25,
                'description' => 'Mouse produktivitas terbaik. Klik sunyi (Quiet Click), Scroll MagSpeed 1000 baris/detik, Sensor 8000 DPI track-on-glass.',
                'image_path' => 'https://images.unsplash.com/photo-1605773527857-3171110e588f?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'Keychron Q1 Pro Wireless',
                'category' => 'Aksesoris Komputer',
                'price' => 2900000,
                'stock' => 8,
                'description' => 'Keyboard mekanikal custom full aluminium. Koneksi wireless/wired, QMK/VIA support, gasket mount.',
                'image_path' => 'https://images.unsplash.com/photo-1595225476474-87563907a212?auto=format&fit=crop&q=80&w=800',
            ],

             // KOMPONEN PC
             [
                'name' => 'NVIDIA GeForce RTX 4070 Super',
                'category' => 'Komponen PC',
                'price' => 10500000,
                'stock' => 5,
                'description' => 'Kartu grafis terbaik untuk gaming 1440p. DLSS 3.5, Ray Tracing, 12GB GDDR6X.',
                'image_path' => 'https://images.unsplash.com/photo-1591488320449-011701bb6704?auto=format&fit=crop&q=80&w=800',
            ],
             [
                'name' => 'Processor Intel Core i5-14600K',
                'category' => 'Komponen PC',
                'price' => 5200000,
                'stock' => 10,
                'description' => 'Prosesor gaming mid-range terbaik. 14 Core (6P + 8E), Turbo up to 5.3GHz.',
                'image_path' => 'https://images.unsplash.com/photo-1694503463953-b4528f804683?auto=format&fit=crop&q=80&w=800',
            ],
        ];

        foreach ($products as $p) {
            Product::create([
                'name' => $p['name'],
                'description' => $p['description'],
                'price' => $p['price'],
                'stock' => $p['stock'],
                'category_id' => $catIds[$p['category']],
                'image_path' => $p['image_path'], // Note: Images won't exist physically, view needs fallback
            ]);
        }
    }
}
