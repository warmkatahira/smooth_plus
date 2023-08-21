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
        Schema::create('shops', function (Blueprint $table) {
            $table->increments('shop_id');
            $table->unsignedInteger('mall_id');
            $table->string('shop_name', 50);
            $table->string('shop_zip_code', 8);
            $table->string('shop_address_1');
            $table->string('shop_address_2')->nullable();
            $table->string('shop_tel', 13);
            $table->string('shop_fax', 13)->nullable();
            $table->string('shop_email')->nullable();
            $table->string('shipping_label_1', 20);
            $table->string('shipping_label_2', 20)->nullable();
            $table->string('shipping_label_3', 20)->nullable();
            $table->string('shipping_label_4', 20)->nullable();
            $table->string('shipping_label_5', 20)->nullable();
            $table->timestamps();
            // 外部キー制約
            $table->foreign('mall_id')->references('mall_id')->on('malls')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shops');
    }
};
