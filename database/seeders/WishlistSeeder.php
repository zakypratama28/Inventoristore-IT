<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Wishlist;

class WishlistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get user 'jack' or any customer user
        $user = User::where('role', 'customer')->first();
        
        if (!$user) {
            $this->command->info('No customer user found.');
            return;
        }

        // Get first 5 products
        $products = Product::limit(5)->get();

        if ($products->isEmpty()) {
            $this->command->info('No products found.');
            return;
        }

        // Create wishlist entries
        foreach ($products as $product) {
            Wishlist::firstOrCreate([
                'user_id' => $user->id,
                'product_id' => $product->id
            ]);
        }

        $this->command->info("✅ Created {$products->count()} wishlist items for user: {$user->email}");
    }
}
