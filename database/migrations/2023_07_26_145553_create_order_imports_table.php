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
        Schema::create('order_imports', function (Blueprint $table) {
            $table->increments('order_import_id');
            $table->string('order_control_id', 16)->nullable();
            $table->string('order_import_method', 10);
            $table->date('order_import_date');
            $table->time('order_import_time');
            $table->unsignedInteger('order_status_id');
            $table->unsignedInteger('shop_id');
            $table->unsignedInteger('shipping_method_id')->nullable();
            // ここから受注データの項目
            $table->string('order_no', 50);
            $table->date('order_date')->nullable();
            $table->time('order_time')->nullable();
            $table->string('buyer_name', 50)->nullable();
            $table->string('buyer_zip_code', 8)->nullable();
            $table->string('buyer_address')->nullable();
            $table->string('buyer_tel', 13)->nullable();
            $table->string('ship_name', 50);
            $table->string('ship_zip_code', 8);
            $table->string('ship_address');
            $table->string('ship_tel', 13);
            $table->date('desired_delivery_date')->nullable();
            $table->string('desired_delivery_time', 20)->nullable();
            $table->string('shipping_method', 20)->nullable();
            $table->string('payment_method', 20)->nullable();
            $table->integer('shipping_fee')->default(0);
            $table->integer('other_fee')->default(0);
            $table->integer('sales_tax')->default(0);
            $table->integer('point_discount')->default(0);
            $table->integer('coupon_discount')->default(0);
            $table->integer('other_discount')->default(0);
            $table->integer('total_amount')->default(0);
            $table->integer('billing_amount')->default(0);
            $table->text('buyer_memo')->nullable();
            $table->string('order_item_code', 50);
            $table->string('order_item_name')->nullable();
            $table->unsignedInteger('unit_price')->nullable();
            $table->unsignedInteger('order_quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_imports');
    }
};
