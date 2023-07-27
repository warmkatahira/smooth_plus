<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Mall;

class MallSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Mall::create([
            'mall_name' => 'Yahoo',
            'mall_image_path' => 'image/mall/yahoo.svg',
        ]);
        Mall::create([
            'mall_name' => '楽天',
            'mall_image_path' => 'image/mall/rakuten.svg',
        ]);
    }
}
