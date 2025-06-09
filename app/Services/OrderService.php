<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;

class OrderService
{
    public function browse($page, $perPage, $sortBy, $sortOrder, $search): LengthAwarePaginator
    {
        $query = Order::query()->withCount('order_details');

        if($search) {
            $query->where('order_id', $search);
        }

        if($sortBy === 'item_count') {
            $query->orderBy('order_details_count', $sortOrder);
        } else if($sortBy === 'id') {
            $query->orderBy('order_id', $sortOrder);
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }

        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    public function read(Order $order): Order
    {
        return $order->load('order_details.pizza.pizza_type');
    }
}