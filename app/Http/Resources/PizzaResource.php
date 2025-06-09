<?php

namespace App\Http\Resources;

use App\Enums\PizzaSize;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Number;

class PizzaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'pizza_id' => $this->pizza_id,
            'pizza_type' => new PizzaTypeResource($this->whenLoaded('pizza_type')),
            'size' => PizzaSize::from($this->size)->label(),
            'price' => Number::currency($this->price)
        ];
    }
}
