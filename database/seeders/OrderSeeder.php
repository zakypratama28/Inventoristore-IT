<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class OrderSeeder extends Seeder
{
    public function run()
    {
        // 1. Create Dummy Customers if they don't exist
        $customers = [];
        for ($i = 1; $i <= 5; $i++) {
            $email = "customer{$i}@example.com";
            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => "Customer {$i}",
                    'password' => Hash::make('password'),
                    'role' => 'customer'
                ]
            );
            $customers[] = $user;
        }

        // 2. Get Products
        $products = Product::all();
        if ($products->isEmpty()) {
            $this->command->info('No products found. Please seed products first.');
            return;
        }

        // 3. Create Orders (distributed over last 6 months)
        $statuses = ['paid', 'pending', 'shipped', 'completed'];

        // Make around 30 orders
        for ($i = 0; $i < 30; $i++) {
            $customer = $customers[array_rand($customers)];
            $date = Carbon::now()->subDays(rand(0, 180)); // Random date in last 6 months

            // Add Items
            $total = 0;
            $orderItems = [];
            $itemCount = rand(1, 4);

            // Create Order first (we need ID for items, but items determine total)
            // We can update total later.
            
            $order = Order::create([
                'user_id' => $customer->id,
                'code' => 'ORD-' . strtoupper(uniqid()),
                'status' => $statuses[array_rand($statuses)],
                'subtotal' => 0, 
                'total' => 0,
                'created_at' => $date,
                'updated_at' => $date,
                'shipping_address' => 'Jl. Dummy No. ' . rand(1, 100) . ', Jakarta',
                'payment_method' => 'bank_transfer',
            ]);

            for ($j = 0; $j < $itemCount; $j++) {
                $product = $products->random();
                $qty = rand(1, 3);
                $price = $product->price;
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'unit_price' => $price,
                    'product_name' => $product->name,
                    'subtotal' => $price * $qty,
                ]);

                $total += ($price * $qty);
            }

            // Update Order Total and Subtotal
            $order->update([
                'subtotal' => $total,
                'total' => $total, // Assuming 0 shipping cost for simplicity
            ]);
        }

        $this->command->info('Orders seeded successfully!');
    }
}
