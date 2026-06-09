<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = [
            ['room_number' => '203', 'floor' => 2, 'capacity' => 3, 'stay_type' => 'Shared Room'],
            ['room_number' => '204', 'floor' => 2, 'capacity' => 1, 'stay_type' => 'Solo Room'],
            ['room_number' => '206', 'floor' => 2, 'capacity' => 3, 'stay_type' => 'Shared Room'],
            ['room_number' => '301', 'floor' => 3, 'capacity' => 2, 'stay_type' => 'Shared Room'],
            ['room_number' => '302', 'floor' => 3, 'capacity' => 1, 'stay_type' => 'Solo Room'],
            ['room_number' => '303', 'floor' => 3, 'capacity' => 3, 'stay_type' => 'Shared Room'],
            ['room_number' => '304', 'floor' => 3, 'capacity' => 3, 'stay_type' => 'Shared Room'],
            ['room_number' => '305', 'floor' => 3, 'capacity' => 2, 'stay_type' => 'Shared Room'],
            ['room_number' => '306', 'floor' => 3, 'capacity' => 3, 'stay_type' => 'Shared Room'],
            ['room_number' => '307', 'floor' => 3, 'capacity' => 1, 'stay_type' => 'Solo Room'],
            ['room_number' => '401', 'floor' => 4, 'capacity' => 2, 'stay_type' => 'Shared Room'],
            ['room_number' => '402', 'floor' => 4, 'capacity' => 1, 'stay_type' => 'Solo Room'],
            ['room_number' => '403', 'floor' => 4, 'capacity' => 3, 'stay_type' => 'Shared Room'],
            ['room_number' => '404', 'floor' => 4, 'capacity' => 3, 'stay_type' => 'Shared Room'],
            ['room_number' => '405', 'floor' => 4, 'capacity' => 3, 'stay_type' => 'Shared Room'],
            ['room_number' => '406', 'floor' => 4, 'capacity' => 3, 'stay_type' => 'Shared Room'],
            ['room_number' => '407', 'floor' => 4, 'capacity' => 1, 'stay_type' => 'Solo Room'],
            ['room_number' => '501', 'floor' => 5, 'capacity' => 1, 'stay_type' => 'Solo Room'],
            ['room_number' => '502', 'floor' => 5, 'capacity' => 1, 'stay_type' => 'Solo Room'],
            ['room_number' => '503', 'floor' => 5, 'capacity' => 3, 'stay_type' => 'Shared Room'],
            ['room_number' => '504', 'floor' => 5, 'capacity' => 3, 'stay_type' => 'Shared Room'],
            ['room_number' => '506', 'floor' => 5, 'capacity' => 3, 'stay_type' => 'Shared Room'],
            ['room_number' => '507', 'floor' => 5, 'capacity' => 1, 'stay_type' => 'Solo Room'],
        ];

        foreach ($rooms as $room) {
            DB::table('rooms')->insertOrIgnore(array_merge($room, [
                'is_active'  => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}