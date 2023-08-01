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
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('order_id');
            $table->string('order_control_id', 16)->unique();
            $table->string('order_import_method', 10);
            $table->date('order_import_date');
            $table->time('order_import_time');
            $table->unsignedInteger('order_status_id');
            $table->boolean('is_confirmed')->default(0);
            $table->boolean('is_allocated')->default(0);
            $table->date('estimated_shipping_date')->nullable();
            $table->boolean('is_shipping_inspection_complete')->default(0);
            $table->timestamp('shipping_inspection_date')->nullable();
            $table->string('tracking_no')->nullable();
            $table->date('shipping_date')->nullable();
            $table->unsignedInteger('shop_id');
            $table->string('order_no', 50);
            $table->date('order_date')->nullable();
            $table->time('order_time')->nullable();
            $table->string('buyer_name', 50)->nullable();
            $table->string('buyer_zip_code', 10)->nullable();
            $table->string('buyer_address')->nullable();
            $table->string('buyer_tel', 13)->nullable();
            $table->string('buyer_email')->nullable();
            $table->string('ship_name', 50);
            $table->string('ship_zip_code', 10);
            $table->string('ship_address');
            $table->string('ship_tel', 13);
            $table->date('desired_delivery_date')->nullable();
            $table->string('desired_delivery_time', 20)->nullable();
            $table->string('shipping_method_memo', 20)->nullable();
            $table->unsignedInteger('shipping_method_id');
            $table->string('payment_method', 20)->nullable();
            $table->integer('shipping_fee')->nullable();
            $table->integer('other_fee')->nullable();
            $table->integer('sales_tax')->nullable();
            $table->integer('point_discount')->nullable();
            $table->integer('coupon_discount')->nullable();
            $table->integer('other_discount')->nullable();
            $table->integer('total_amount')->nullable();
            $table->integer('billing_amount')->nullable();
            $table->text('buyer_memo')->nullable();
            $table->text('shop_memo')->nullable();
            $table->text('work_memo')->nullable();
            $table->unsignedInteger('last_update_user_no')->nullable();
            $table->unsignedInteger('shipping_group_id')->nullable();
            $table->string('delivery_time_zone')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
