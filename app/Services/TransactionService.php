<?php

namespace App\Services;

use App\Models\Booking;
use App\Repositories\TransactionRepository;

class TransactionService
{
    public function __construct(protected TransactionRepository $transactionRepository)
    {
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
    }

    public function create(?Booking $booking)
    {
        $transaction_id = 'TRX-' . uniqid();
        $payment_token = $this->createToken($booking);

        return $this->transactionRepository->create([
            'booking_id' => $booking->id,
            'transaction_id' => $transaction_id,
            'payment_token' => $payment_token,
            'gross_amount' => $booking->total_price,
        ]);
    }

    protected function createToken(?Booking $booking)
    {
        $params = [
            'transaction_details' => [
                'order_id' => rand(),
                'gross_amount' => $booking->total_price,
            ],
            'customer_details' => [
                'first_name' => $booking->passenger->name,
                'last_name' => '',
                'email' => $booking->passenger->email,
                'phone' => $booking->passenger->phone_number,
            ],
            'items_details' => [
                'id' => 'code-' . rand(),
                'price' => $booking->schedule->price,
                'quantity' => $booking->qty,
                'name' => $booking->schedule->travel_name
            ]
        ];

        return  \Midtrans\Snap::getSnapToken($params);
    }
}
