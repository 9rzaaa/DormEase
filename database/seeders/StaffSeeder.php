<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Staff;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        Staff::create([
            'staff_code'     => 'STF001',
            'first_name'     => 'Admin',
            'last_name'      => 'User',
            'email'          => 'admin@dormease.com',
            'password_hash'  => bcrypt('password123'),
            'role'           => 'admin',
            'is_active'      => true,
        ]);
    }
}