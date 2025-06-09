<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Number;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->order_id,
            'date' => $this->date->format('Y-m-d'),
            'time' => $this->time,
            'item_count' => $this->order_details_count,
            'order_details' => OrderDetailResource::collection($this->whenLoaded('order_details')),
            'total_price' => $this->whenLoaded('order_details',function ($order_details){
                $sum = $order_details->reduce(function (?int $carry, $item) {
                    return $carry + ($item->pizza->price * $item->quantity);
                });
                return Number::currency($sum);
            })
        ];
    }
}
