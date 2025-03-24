<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'booking_id' => $this->booking_id,
            'transaction_id' => $this->transaction_id,
            'transaction_status' => $this->transaction_status,
            'payment_token' => $this->payment_token,
            'payment_type' => $this->payment_type,
            'gross_amount' => $this->gross_amount,
            'payment_date' => $this->payment_date,
            'created_at' => $this->created_at,
            'deleted_at' => $this->deleted_at
        ];
    }
}
