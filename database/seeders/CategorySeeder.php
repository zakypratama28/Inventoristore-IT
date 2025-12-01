<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Elektronik'],
            ['name' => 'Aksesoris Komputer'],
            ['name' => 'Perlengkapan Kantor'],
        ];

        foreach ($categories as $data) {
            Category::firstOrCreate(['name' => $data['name']], $data);
        }
    }
}
