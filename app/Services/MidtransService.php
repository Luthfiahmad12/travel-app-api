<?php

namespace App\Services;

class MidtransService
{
    public function __construct()
    {
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
    }

    public function createToken(array $data)
    {
        $params = [
            'transaction_details' => [
                'order_id' => rand(),
                'gross_amount' => $data['amount'],
            ],
            'customer_details' => [
                'first_name' => $data['name'],
                'last_name' => '',
                'email' => $data['email'],
                'phone' => $data['phone_number'],
            ],
            'items_details' => [
                'id' => 'code-' . rand(),
                'price' => $data['price'],
                'quantity' => $data['qty'],
                'name' => $data['schedule_name']
            ]
        ];

        return  \Midtrans\Snap::getSnapToken($params);
    }
}
