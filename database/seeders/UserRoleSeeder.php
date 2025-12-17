<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name'     => 'Admin System',
                'password' => Hash::make('password'),
                'role'     => 'admin',
            ]
        );

        // Staff
        User::updateOrCreate(
            ['email' => 'staff@example.com'],
            [
                'name'     => 'Staff Member',
                'password' => Hash::make('password'),
                'role'     => 'staff',
            ]
        );

        // Customer
        User::updateOrCreate(
            ['email' => 'customer@example.com'],
            [
                'name'     => 'John Doe',
                'password' => Hash::make('password'),
                'role'     => 'customer',
            ]
        );
    }
}
