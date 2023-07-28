<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OrderImportSetting;

class OrderImportSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrderImportSetting::create([
            'order_import_setting_name' => '受注データ(通常)',
            'shop_id' => 1,
            'data_extension' => 'CSV',
            'register_user_no' => 1,
            'order_no' => 2,
            'ship_name' => 12,
            'ship_zip_code' => 17,
            'ship_address' => 16,
            'ship_tel' => 15,
            'shipping_method' => 4,
            'billing_amount' => 19,
            'order_item_code' => 11,
            'order_item_name' => 8,
            'order_quantity' => 9,
        ]);
        OrderImportSetting::create([
            'order_import_setting_name' => '受注データ(配送先名結合)',
            'shop_id' => 1,
            'data_extension' => 'CSV',
            'register_user_no' => 1,
            'order_no' => 2,
            'ship_name' => "12,13",
            'ship_zip_code' => 17,
            'ship_address' => 16,
            'ship_tel' => 15,
            'shipping_method' => 4,
            'billing_amount' => 19,
            'order_item_code' => 11,
            'order_item_name' => 8,
            'order_quantity' => 9,
        ]);
    }
}
