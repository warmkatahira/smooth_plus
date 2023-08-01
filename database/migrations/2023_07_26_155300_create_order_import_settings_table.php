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
        Schema::create('order_import_settings', function (Blueprint $table) {
            $table->increments('order_import_setting_id');
            $table->string('order_import_setting_name', 20);
            $table->unsignedInteger('shop_id');
            $table->string('data_extension', 10);
            $table->unsignedInteger('register_user_no');
            // ここから受注データの設定
            $table->string('order_no');
            $table->string('order_date')->nullable();
            $table->string('order_time')->nullable();
            $table->string('buyer_name')->nullable();
            $table->string('buyer_zip_code')->nullable();
            $table->string('buyer_address')->nullable();
            $table->string('buyer_tel')->nullable();
            $table->string('ship_name');
            $table->string('ship_zip_code');
            $table->string('ship_address');
            $table->string('ship_tel');
            $table->string('desired_delivery_date')->nullable();
            $table->string('desired_delivery_time')->nullable();
            $table->string('shipping_method')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('shipping_fee')->nullable();
            $table->string('other_fee')->nullable();
            $table->string('sales_tax')->nullable();
            $table->string('point_discount')->nullable();
            $table->string('coupon_discount')->nullable();
            $table->string('other_discount')->nullable();
            $table->string('total_amount')->nullable();
            $table->string('billing_amount')->nullable();
            $table->string('buyer_memo')->nullable();
            $table->string('order_item_code');
            $table->string('order_item_name')->nullable();
            $table->string('unit_price')->nullable();
            $table->string('order_quantity');
            $table->timestamps();
            // 外部キー制約
            $table->foreign('shop_id')->references('shop_id')->on('shops')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_import_settings');
    }
};
