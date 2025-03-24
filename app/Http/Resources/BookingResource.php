<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'qty' => $this->qty,
            'schedule_id' => $this->schedule_id,
            'total_price' => $this->total_price,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'deleted_at' => $this->deleted_at?->format('Y-m-d H:i:s'),
            'schedule' => new ScheduleResource($this->whenLoaded('schedule')),
            'passenger' => new PassengerResource($this->whenLoaded('passenger')),
            'transaction' => new TransactionResource($this->whenLoaded('transaction')),
        ];
    }
}
