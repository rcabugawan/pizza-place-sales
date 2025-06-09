<?php

namespace App\Services;

use App\Models\PizzaType;
use Illuminate\Pagination\LengthAwarePaginator;

class PizzaTypeService
{
    public function browse($page, $perPage, $sortBy, $sortOrder): LengthAwarePaginator
    {
        $query = PizzaType::query()->with('ingredients');

        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    public function read(PizzaType $order): PizzaType
    {
        return $order->load([
            'pizzas' => function($query) {
                $query->orderBy('price', 'asc');
            },
            'ingredients'
        ]);
    }
}