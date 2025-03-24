<?php

namespace App\Repositories;

use App\Models\Passenger;

class PassengerRepository
{
    public function getBookings($passengerId)
    {
        return Passenger::findOrFail($passengerId)->bookings;
    }
}
