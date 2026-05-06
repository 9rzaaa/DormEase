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

        Staff::create([
            'staff_code'     => 'STF002',
            'first_name'     => 'Front',
            'last_name'      => 'Desk',
            'email'          => 'frontdesk@dormease.com',
            'password_hash'  => bcrypt('password123'),
            'role'           => 'frontdesk',
            'is_active'      => true,
        ]);
    }
}