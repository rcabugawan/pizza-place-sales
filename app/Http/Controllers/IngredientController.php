<?php

namespace App\Http\Controllers;

use App\Http\Resources\IngredientResource;
use App\Models\Ingredient;
use App\Services\IngredientService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    public function __construct(protected IngredientService $service){}
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
            IngredientResource::collection($this->service->browse($page, $perPage, $sortBy, $sortOrder))
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Ingredient $ingredient): JsonResponse
    {
        return new JsonResponse(
            new IngredientResource($this->service->read($ingredient))
        );
    }
}
