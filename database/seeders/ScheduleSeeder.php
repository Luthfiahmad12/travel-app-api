<?php

namespace Database\Seeders;

use App\Models\Schedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schedule::insert([
            [
                'travel_name' => 'Travel A',
                'departure_time' => '2025-04-01 08:00:00',
                'quota' => 10,
                'price' => 75000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'travel_name' => 'Travel B',
                'departure_time' => '2025-04-02 09:30:00',
                'quota' => 15,
                'price' => 85000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'travel_name' => 'Travel C',
                'departure_time' => '2025-04-03 14:00:00',
                'quota' => 20,
                'price' => 95000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
