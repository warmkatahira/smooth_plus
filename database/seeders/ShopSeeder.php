<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Shop;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Shop::create([
            'mall_id' => 1,
            'shop_name' => 'XXX Yahoo店',
            'shop_zip_code' => '340-0822',
            'shop_address_1' => '埼玉県八潮市大瀬',
            'shop_address_2' => '921-2',
            'shop_tel' => '048-111-1111',
            'shipping_label_1' => '雑貨',
        ]);
    }
}
