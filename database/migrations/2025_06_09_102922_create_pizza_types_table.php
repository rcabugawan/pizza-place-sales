<?php

use App\Enums\PizzaTypeCategory;
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
        Schema::create('pizza_types', function (Blueprint $table) {
            $table->string('pizza_type_id')->unique()->primary();
            $table->string('name');
            $table->tinyInteger('category')->default(PizzaTypeCategory::CLASSIC->value);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pizza_types');
    }
};
