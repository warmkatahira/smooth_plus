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
        Schema::create('system_settings', function (Blueprint $table) {
            $table->string('stock_allocated_use_column_1', 100)->default('order_no');
            $table->string('stock_allocated_use_column_2', 100)->nullable();
            $table->string('stock_allocated_use_column_3', 100)->nullable();
            $table->unsignedInteger('rito_shipping_method_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_settings');
    }
};
