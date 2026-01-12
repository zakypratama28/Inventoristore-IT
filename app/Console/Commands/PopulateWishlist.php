<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Product;
use App\Models\Wishlist;

class PopulateWishlist extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wishlist:populate {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate wishlist with sample products for a user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        // Get user
        if ($email) {
            $user = User::where('email', $email)->first();
        } else {
            $user = User::where('role', 'customer')->latest()->first();
        }

        if (!$user) {
            $this->error('❌ User not found!');
            return 1;
        }

        // Get products
        $products = Product::limit(5)->get();

        if ($products->isEmpty()) {
            $this->error('❌ No products found in database');
            return 1;
        }

        $this->info("Adding {$products->count()} products to wishlist for: {$user->email}");

        $count = 0;
        foreach ($products as $product) {
            $wishlist = Wishlist::firstOrCreate([
                'user_id' => $user->id,
                'product_id' => $product->id
            ]);

            if ($wishlist->wasRecentlyCreated) {
                $count++;
                $this->info("  ✓ Added:  {$product->name}");
            } else {
                $this->line("  - Already in wishlist: {$product->name}");
            }
        }

        $this->info("\n✅ Successfully added {$count} new products to wishlist!");
        return 0;
    }
}
