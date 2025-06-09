<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(protected OrderService $service){}
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', 20);
        $sortBy = $request->input('sortBy', 'id');
        $sortOrder = $request->input('sortOrder', 'asc');

        return new JsonResponse(
            OrderResource::collection($this->service->browse($page, $perPage, $sortBy, $sortOrder))
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order): JsonResponse
    {
        return new JsonResponse(
            new OrderResource($this->service->read($order))
        );
    }
}
