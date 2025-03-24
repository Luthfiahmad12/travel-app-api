<?php

namespace App\Repositories\Interfaces;

interface TransactionRepositoryInterface
{
    public function create(array $data);
    public function findByOrderId($orderId);
    public function updatePaymentStatus($orderId, array $data);
}
