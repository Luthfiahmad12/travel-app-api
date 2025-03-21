<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'travel_name',
        'departure_time',
        'quota',
        'price',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
