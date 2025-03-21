<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends JsonResource
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
            'travel_name' => $this->travel_name,
            'departure_time' => $this->departure_time,
            'quota' => $this->quota,
            'price' => $this->price,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
