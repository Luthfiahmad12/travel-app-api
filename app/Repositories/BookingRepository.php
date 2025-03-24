<?php

namespace App\Repositories;

use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class BookingRepository
{
    public function getData()
    {
        return Booking::all();
    }

    public function create(array $data)
    {
        return Booking::create($data);
    }

    public function findById($id)
    {
        return Booking::findOrFail($id);
    }

    public function delete(?Booking $booking): bool
    {
        return $booking->delete();
    }

    public function getDataByPassenger($passengerId)
    {
        return Booking::where('passenger_id', $passengerId)
            ->get();
    }
}
