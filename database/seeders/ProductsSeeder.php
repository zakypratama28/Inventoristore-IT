<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
        // Create Categories (only name field available)
        $categoryNames = [
            'Laptop Gaming',
            'Gaming Gear',
            'Smartphone & Tablet',
            'Aksesoris Komputer',
            'Komponen PC',
        ];

        foreach ($categoryNames as $name) {
            Category::create(['name' => $name]);
        }

        // Create Products (using available fields)
        $products = [
            // Laptop Gaming
            ['name' => 'ASUS ROG Strix G15', 'description' => 'Laptop gaming AMD Ryzen 9, RTX 3070, 16GB RAM, 1TB SSD', 'price' => 25000000, 'stock' => 15, 'category_id' => 1],
            ['name' => 'MSI GE76 Raider', 'description' => 'Laptop gaming Intel i9, RTX 3080, 32GB RAM, 2TB SSD', 'price' => 45000000, 'stock' => 8, 'category_id' => 1],
            
            // Gaming Gear
            ['name' => 'Logitech G Pro X Superlight', 'description' => 'Mouse gaming wireless 63g, HERO 25K sensor', 'price' => 1850000, 'stock' => 30, 'category_id' => 2],
            ['name' => 'SteelSeries Apex Pro TKL', 'description' => 'Keyboard mechanical adjustable actuation', 'price' => 2500000, 'stock' => 20, 'category_id' => 2],
            ['name' => 'HyperX Cloud Alpha Wireless', 'description' => 'Gaming headset wireless 300 jam battery', 'price' => 2200000, 'stock' => 25, 'category_id' => 2],
            
            // Smartphone
            ['name' => 'iPhone 15 Pro Max', 'description' => 'iPhone 15 Pro Max 256GB Titanium A17 Pro', 'price' => 21000000, 'stock' => 12, 'category_id' => 3],
            ['name' => 'Samsung Galaxy S24 Ultra', 'description' => 'Galaxy S24 Ultra 512GB Snapdragon 8 Gen 3', 'price' => 18500000, 'stock' => 18, 'category_id' => 3],
            
            // Aksesoris
            ['name' => 'Samsung 970 EVO Plus 1TB', 'description' => 'SSD NVMe M.2 1TB 3500MB/s read speed', 'price' => 1500000, 'stock' => 40, 'category_id' => 4],
            ['name' => 'Corsair Vengeance RGB 32GB', 'description' => 'RAM DDR4 32GB 3200MHz RGB', 'price' => 2000000, 'stock' => 35, 'category_id' => 4],
            
            // Komponen PC
            ['name' => 'NVIDIA RTX 4090', 'description' => 'GPU RTX 4090 24GB GDDR6X 16384 CUDA cores', 'price' => 35000000, 'stock' => 5, 'category_id' => 5],
            ['name' => 'AMD Ryzen 9 7950X', 'description' => 'CPU 16-core 32-thread 5.7GHz boost', 'price' => 8500000, 'stock' => 15, 'category_id' => 5],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        echo "✅ 5 Categories created\n";
        echo "✅ 11 Products created\n";
    }
}
