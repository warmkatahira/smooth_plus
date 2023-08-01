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
            $table->increments('order_detail_id');
            $table->string('order_control_id', 16);
            $table->boolean('is_item_allocated')->default(0);
            $table->boolean('is_stock_allocated')->default(0);
            $table->string('order_item_code', 50);
            $table->string('order_item_name');
            $table->unsignedInteger('unit_price')->nullable();
            $table->unsignedInteger('order_quantity');
            $table->unsignedInteger('unallocated_quantity');
            $table->boolean('is_order_macro_add')->default(0);
            $table->timestamps();
            // 外部キー
            $table->foreign('order_control_id')->references('order_control_id')->on('orders')->cascadeOnUpdate()->cascadeOnDelete();
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
