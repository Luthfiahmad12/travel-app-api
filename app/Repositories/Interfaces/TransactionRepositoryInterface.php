<?php

namespace App\Repositories\Interfaces;

use App\Models\Transaction;

interface TransactionRepositoryInterface
{
    public function create(array $data);
    public function findById($id);
    public function updatePaymentStatus(?Transaction $transaction, array $data);
}
