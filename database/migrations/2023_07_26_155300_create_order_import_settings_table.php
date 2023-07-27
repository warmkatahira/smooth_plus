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
            $table->unsignedInteger('order_no');
            $table->unsignedInteger('order_date')->nullable();
            $table->unsignedInteger('order_time')->nullable();
            $table->unsignedInteger('buyer_name')->nullable();
            $table->unsignedInteger('buyer_zip_code')->nullable();
            $table->unsignedInteger('buyer_address')->nullable();
            $table->unsignedInteger('buyer_tel')->nullable();
            $table->unsignedInteger('ship_name');
            $table->unsignedInteger('ship_zip_code');
            $table->unsignedInteger('ship_address');
            $table->unsignedInteger('ship_tel');
            $table->unsignedInteger('desired_delivery_date')->nullable();
            $table->unsignedInteger('desired_delivery_time')->nullable();
            $table->unsignedInteger('shipping_method')->nullable();
            $table->unsignedInteger('payment_method')->nullable();
            $table->unsignedInteger('shipping_fee')->nullable();
            $table->unsignedInteger('other_fee')->nullable();
            $table->unsignedInteger('sales_tax')->nullable();
            $table->unsignedInteger('point_discount')->nullable();
            $table->unsignedInteger('coupon_discount')->nullable();
            $table->unsignedInteger('other_discount')->nullable();
            $table->unsignedInteger('total_amount')->nullable();
            $table->unsignedInteger('billing_amount')->nullable();
            $table->unsignedInteger('buyer_memo')->nullable();
            $table->unsignedInteger('order_item_code');
            $table->unsignedInteger('order_item_name')->nullable();
            $table->unsignedInteger('unit_price')->nullable();
            $table->unsignedInteger('order_quantity');
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
