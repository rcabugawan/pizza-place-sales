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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id('order_detail_id');
            $table->unsignedBigInteger('order_id');
            $table->string('pizza_id');
            $table->integer('quantity');

            $table->foreign('order_id')
                ->references('order_id')
                ->on('orders')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('pizza_id')
                ->references('pizza_id')
                ->on('pizzas')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
