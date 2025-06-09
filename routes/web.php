<?php

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('login');
})->name('home');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
    Route::inertia('orders', 'Orders');
    Route::inertia('pizza-types', 'PizzaTypes');
    Route::inertia('ingredients', 'Ingredients');

    Route::get('/orders/{id}', function (Request $request, string $id) {
        return inertia('Order', ['id' => $id]);
    })->name('order');

    Route::get('/pizza-types/{id}', function (Request $request, string $id) {
        return inertia('PizzaType', ['id' => $id]);
    })->name('pizza-type');

    Route::get('/ingredients/{id}', function (Request $request, string $id) {
        return inertia('Ingredient', ['id' => $id]);
    })->name('ingredient');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
