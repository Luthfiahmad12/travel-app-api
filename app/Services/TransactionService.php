<?php

namespace App\Services;

use App\Models\Booking;
use App\Repositories\TransactionRepository;

class TransactionService
{
    public function __construct(
        protected TransactionRepository $transactionRepository,
        protected MidtransService $midtransService
    ) {
        //
    }

    public function create(?Booking $booking)
    {
        $transaction_id = 'TRX-' . uniqid();
        $payment_token = $this->midtransService->createSnapToken($booking);

        return $this->transactionRepository->create([
            'booking_id' => $booking->id,
            'transaction_id' => $transaction_id,
            'payment_token' => $payment_token,
            'gross_amount' => $booking->total_price,
        ]);
    }

    public function midtransCallback()
    {
        if ($this->midtransService->isSignatureKeyVerified()) {
            $transaction = $this->midtransService->getTransaction();

            if ($this->midtransService->getStatus() == 'success') {
                $transaction->update([
                    'payment_status' => 'paid',
                    'payment_date' => now()
                ]);

                $booking = $transaction->booking()->first();
                $booking->update([
                    'status' => 'paid',
                ]);
            }
            if ($this->midtransService->getStatus() == 'pending') {
                // lakukan sesuatu jika pembayaran masih pending, seperti mengirim notifikasi ke customer
                // bahwa pembayaran masih pending dan harap selesai pembayarannya
            }

            if ($this->midtransService->getStatus() == 'expire') {
                $transaction->update([
                    'payment_status' => 'expired'
                ]);
            }

            if ($this->midtransService->getStatus() == 'cancel') {
                // lakukan sesuatu jika pembayaran dibatalkan
                $transaction->update([
                    'payment_status' => 'cancel'
                ]);
            }

            if ($this->midtransService->getStatus() == 'failed') {
                // lakukan sesuatu jika pembayaran gagal
                $transaction->update([
                    'payment_status' => 'failed'
                ]);
            }
            return SuccessResponse('Pembayaran berhasil di proses', 201);
        } else {
            return ErrorResponse('Unauthorized', 401);
        }
    }
}
