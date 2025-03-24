<?php

namespace App\Repositories\Interfaces;

use App\Models\Booking;

interface BookingRepositoryInterface
{
    public function create(array $data);
    public function findById($id);
    public function updateStatus(?Booking $booking, $status);
}
