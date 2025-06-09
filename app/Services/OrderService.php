<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;

class OrderService
{
    public function browse($page, $perPage, $sortBy, $sortOrder): LengthAwarePaginator
    {
        $query = Order::query()->withCount('order_details');

        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    public function read(Order $order): Order
    {
        return $order->load('order_details.pizza.pizza_type');
    }
}