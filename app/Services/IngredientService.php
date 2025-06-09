<?php

namespace App\Services;

use App\Models\Ingredient;
use Illuminate\Pagination\LengthAwarePaginator;

class IngredientService
{
    public function browse($page, $perPage, $sortBy, $sortOrder): LengthAwarePaginator
    {
        $query = Ingredient::query();

        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    public function read(Ingredient $order): Ingredient
    {
        return $order->load('pizza_types');
    }
}