<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Transaction;

class MidtransService
{
    protected string $serverKey;
    protected string $isProduction;
    protected string $isSanitized;
    protected string $is3ds;

    public function __construct()
    {
        // Konfigurasi server key, environment, dan lainnya
        $this->serverKey = config('midtrans.server_key');
        $this->isProduction = config('midtrans.is_production');
        $this->isSanitized = config('midtrans.is_sanitized');
        $this->is3ds = config('midtrans.is_3ds');

        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds');
    }

    /**
     * Membuat snap token untuk transaksi berdasarkan data booking.
     *
     * @param Booking $booking Objek booking yang berisi informasi transaksi.
     *
     * @return string Snap token yang dapat digunakan di front-end untuk proses pembayaran.
     * @throws Exception Jika terjadi kesalahan saat menghasilkan snap token.
     */
    public function createSnapToken(?Booking $booking)
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
            'items_details' => $this->mapItemsToDetails($booking),
        ];

        return \Midtrans\Snap::getSnapToken($params);
    }

    /**
     * Memvalidasi apakah signature key yang diterima dari Midtrans sesuai dengan signature key yang dihitung di server.
     *
     * @return bool Status apakah signature key valid atau tidak.
     */
    public function isSignatureKeyVerified(): bool
    {
        $notification = new \Midtrans\Notification();

        // Membuat signature key lokal dari data notifikasi
        $localSignatureKey = hash(
            'sha512',
            $notification->order_id . $notification->status_code .
                $notification->gross_amount . $this->serverKey
        );

        // Memeriksa apakah signature key valid
        return $localSignatureKey === $notification->signature_key;
    }

    /**
     * Mendapatkan data transaction berdasarkan transaction_id yang ada di notifikasi Midtrans.
     *
     * @return Transaction Objek transaction yang sesuai dengan transaction_id yang diterima.
     */
    public function getTransaction(): Transaction
    {
        $notification = new \Midtrans\Notification();

        // Mengambil data transaction dari database berdasarkan transaction_id
        return Transaction::where('transaction_id', $notification->order_id)->first();
    }

    /**
     * Mendapatkan status transaksi berdasarkan status yang diterima dari notifikasi Midtrans.
     *
     * @return string Status transaksi ('success', 'pending', 'expire', 'cancel', 'failed').
     */
    public function getStatus(): string
    {
        $notification = new \Midtrans\Notification();
        $transactionStatus = $notification->transaction_status;
        $fraudStatus = $notification->fraud_status;

        return match ($transactionStatus) {
            'capture' => ($fraudStatus == 'accept') ? 'success' : 'pending',
            'settlement' => 'success',
            'deny' => 'failed',
            'cancel' => 'cancel',
            'expire' => 'expire',
            'pending' => 'pending',
            default => 'unknown',
        };
    }

    /**
     * Memetakan item dalam transaction menjadi format yang dibutuhkan oleh Midtrans.
     *
     * @param transaction $transaction Objek transaction yang berisi daftar item.
     * @return array Daftar item yang dipetakan dalam format yang sesuai.
     */
    protected function mapItemsToDetails(Booking $booking): array
    {
        return $booking->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'price' => $item->schedule->price,
                'quantity' => $item->qty,
                'name' => $item->schedule?->travel_name
            ];
        })->toArray();
    }
}
