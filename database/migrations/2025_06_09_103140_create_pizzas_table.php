<?php

use App\Enums\PizzaSize;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pizzas', function (Blueprint $table) {
            $table->string('pizza_id')->unique()->primary();
            $table->string('pizza_type_id');
            $table->char('size', 3)->default(PizzaSize::MEDIUM->value);
            $table->decimal('price');

            $table->foreign('pizza_type_id')
                ->references('pizza_type_id')
                ->on('pizza_types')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pizzas');
    }
};
