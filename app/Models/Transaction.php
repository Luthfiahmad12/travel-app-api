<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'transaction_id',
        'payment_token',
        'payment_type',
        'amount',
        'transaction_status', // paid, pending, failed.
        'payment_date'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
