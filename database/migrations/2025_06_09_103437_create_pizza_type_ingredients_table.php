<?php

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
        Schema::create('pizza_type_ingredients', function (Blueprint $table) {
            $table->string('pizza_type_id');
            $table->unsignedBigInteger('ingredient_id');

            $table->foreign('ingredient_id')
                ->references('id')
                ->on('ingredients')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('pizza_type_id')
                ->references('pizza_type_id')
                ->on('pizza_types')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pizza_type_ingredients');
    }
};
