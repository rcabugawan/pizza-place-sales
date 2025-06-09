<?php

namespace App\Http\Controllers;

use App\Http\Resources\PizzaTypeResource;
use App\Models\PizzaType;
use App\Services\PizzaTypeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PizzaTypeController extends Controller
{
    public function __construct(protected PizzaTypeService $service){}
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', 10);
        $sortBy = $request->input('sortBy', 'id');
        $sortOrder = $request->input('sortOrder', 'asc');

        $results = $this->service->browse($page, $perPage, $sortBy, $sortOrder);

        return new JsonResponse([
            'data' => PizzaTypeResource::collection($results->items()),
            'meta' => [
                'perPage' => $results->perPage(),
                'currentPage' => $results->currentPage(),
                'total' => $results->total(),
            ]
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(PizzaType $pizza_type): JsonResponse
    {
        return new JsonResponse(
            new PizzaTypeResource($this->service->read($pizza_type))
        );
    }
}
