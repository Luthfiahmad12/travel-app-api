<?php

namespace App\Repositories\Interfaces;

use App\Models\Schedule;

interface PassengerRepositoryInterface
{
    public function register(array $data);
    public function getAlTravelSchedule(?Schedule $schedule);
}
