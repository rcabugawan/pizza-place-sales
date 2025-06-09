<?php

use App\Http\Controllers\IngredientController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PizzaTypeController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::apiResource('orders', OrderController::class)->only([
        'index', 'show'
    ]);

    Route::apiResource('pizza_types', PizzaTypeController::class)->only([
        'index', 'show'
    ]);

    Route::apiResource('ingredients', IngredientController::class)->only([
        'index', 'show'
    ]);
});