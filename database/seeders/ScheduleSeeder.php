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

        $schedules = [];
        $times = ['08:00:00', '10:00:00', '14:00:00', '16:00:00'];
        $price = [80000, 120000, 150000, 175000];
        for ($i = 1; $i < 11; $i++) {
            $schedules[] = [
                'travel_name' => "Travel $i", // Nama travel berbeda berdasarkan iterasi
                'departure_time' => now()->addDays($i)->format('Y-m-d') . ' ' . $times[$i % count($times)],
                'quota' => 10, // Kuota penumpang diacak antara 15 hingga 30
                'price' => $price[rand(0, 3)],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Schedule::insert($schedules);
    }
}
