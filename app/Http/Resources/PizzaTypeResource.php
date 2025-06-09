<?php

namespace App\Http\Resources;

use App\Enums\PizzaTypeCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PizzaTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'pizza_type_id' => $this->pizza_type_id,
            'name' => $this->name,
            'category' => PizzaTypeCategory::from($this->category)->label(),
            'pizzas' => PizzaResource::collection($this->whenLoaded('pizzas')),
            'ingredients' => IngredientResource::collection($this->whenLoaded('ingredients')),
        ];
    }
}
