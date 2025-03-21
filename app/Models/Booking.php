<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'schedule_id',
        'passenger_id',
        'seat_number',
        'total_price',
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function passenger()
    {
        return $this->belongsTo(Passenger::class);
    }
}
