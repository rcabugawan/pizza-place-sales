<?php

namespace Database\Seeders;

use App\Enums\PizzaSize;
use App\Enums\PizzaTypeCategory;
use App\Models\Ingredient;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Pizza;
use App\Models\PizzaType;
use Illuminate\Database\Seeder;

class PizzaSeeder extends Seeder
{
    public function run(): void
    {
        $this->pizzaTypesSeeder();
        $this->pizzaSeeder();
        $this->orderSeeder();
        $this->orderDetailsSeeder();
    }

    protected function pizzaTypesSeeder(): void
    {
        $types = $this->getCsvData('pizza_types.csv');
        foreach ($types as $type) {
            [$id, $name, $category, $ingredients] = $type;

            $pizza_type = PizzaType::query()->create([
                'pizza_type_id' => $id,
                'name' => $name,
                'category' => PizzaTypeCategory::{strtoupper($category)}->value
            ]);

            $ingredients = array_map('trim', explode(',', $ingredients));

            $ingredient_ids = [];
            foreach ($ingredients as $ingredient) {
                $ingredient_ids[] = Ingredient::query()->firstOrCreate(['label' => $ingredient])->getKey();
            }

            $pizza_type->ingredients()->attach($ingredient_ids);
        }
    }

    protected function pizzaSeeder(): void
    {
        $pizzas = $this->getCsvData('pizzas.csv');
        foreach ($pizzas as $pizza) {
            [$id, $type_id, $size, $price] = $pizza;

            Pizza::query()->create([
                'pizza_id' => $id,
                'pizza_type_id' => $type_id,
                'size' => PizzaSize::from($size)->value,
                'price' => $price
            ]);
        }
    }

    protected function orderSeeder(): void
    {
        $orders = $this->getCsvData('orders.csv');
        foreach ($orders as $order) {
            [$id, $date, $time] = $order;

            Order::query()->create([
                'order_id' => $id,
                'date' => $date,
                'time' => $time
            ]);
        }
    }

    protected function orderDetailsSeeder(): void
    {
        $order_details = $this->getCsvData('order_details.csv');
        foreach ($order_details as $order_detail) {
            [$id, $order_id, $pizza_id, $quantity] = $order_detail;

            OrderDetail::query()->create([
                'order_detail_id' => $id,
                'order_id' => $order_id,
                'pizza_id' => $pizza_id,
                'quantity' => $quantity
            ]);
        }
    }

    protected function getCsvData(string $file_name): array
    {
        $csv = [];
        $fh = fopen(database_path('data/' . $file_name), 'r');

        while (($data = fgetcsv($fh)) !== false) {
            $csv[] = $data;
        }
        fclose($fh);
        array_shift($csv); //remove headers
        return $csv;
    }
}