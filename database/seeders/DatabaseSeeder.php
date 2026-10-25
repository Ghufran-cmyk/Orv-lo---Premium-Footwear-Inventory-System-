<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // 1. Akun Dummy (Admin, Staff, Customer)
        DB::table('users')->insert([
            [
                'name' => 'Admin Orvélo',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Staff Orvélo',
                'email' => 'staff@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'staff',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'customer',
                'email' => 'customer@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'customer',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        // 2. Kategori Sepatu Orvélo
        DB::table('categories')->insert([
            ['name' => 'Sport Shoes', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Casual Shoes', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Formal Shoes', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Outdoor Shoes', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}