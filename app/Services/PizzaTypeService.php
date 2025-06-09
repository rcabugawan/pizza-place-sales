<?php

namespace App\Services;

use App\Models\PizzaType;
use Illuminate\Pagination\LengthAwarePaginator;

class PizzaTypeService
{
    public function browse($page, $perPage, $sortBy, $sortOrder, $search): LengthAwarePaginator
    {
        $query = PizzaType::query()->with('ingredients');

        if($search) {
            $query->where('pizza_type_id', 'like', "%".$search."%")
            ->orWhere('name', 'like', "%".$search."%");
        }

        if($sortBy === 'id') {
            $query->orderBy('pizza_type_id', $sortOrder);
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }

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