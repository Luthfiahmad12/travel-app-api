<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use HasFactory, SoftDeletes;

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
