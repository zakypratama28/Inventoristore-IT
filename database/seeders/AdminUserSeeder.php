<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin IGGStore',
            'email' => 'admin@iggstore.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create test customer
        User::create([
            'name' => 'Customer Test',
            'email' => 'customer@test.com',
            'password' => Hash::make('customer123'),
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        echo "✅ Admin user created:\n";
        echo "   Email: admin@iggstore.com\n";
        echo "   Password: admin123\n\n";
        echo "✅ Test customer created:\n";
        echo "   Email: customer@test.com\n";
        echo "   Password: customer123\n";
    }
}
