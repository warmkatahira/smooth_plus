<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;
    // 主キーカラムを変更
    protected $primaryKey = 'shop_id';
    // 操作可能なカラムを定義
    protected $fillable = [
        'mall_id',
        'shop_name',
        'shop_zip_code',
        'shop_address_1',
        'shop_address_2',
        'shop_tel',
        'shop_fax',
        'shop_email',
        'shipping_label_1',
        'shipping_label_2',
        'shipping_label_3',
        'shipping_label_4',
        'shipping_label_5',
    ];
}
