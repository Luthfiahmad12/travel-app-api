<?php

namespace App\Repositories;

use App\Models\Transaction;
use App\Repositories\Interfaces\TransactionRepositoryInterface;

class TransactionRepository implements TransactionRepositoryInterface
{
    public function create(array $data)
    {
        return Transaction::create($data);
    }

    public function findById($id)
    {
        return Transaction::findOrFail($id);
    }

    public function updatePaymentStatus(?Transaction $transaction, array $data)
    {
        return $transaction->update([
            'transaction_status' => $data['transaction_status'],
        ]);
    }
}
