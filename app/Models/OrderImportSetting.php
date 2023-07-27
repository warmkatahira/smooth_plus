<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderImportSetting extends Model
{
    use HasFactory;
    // 主キーカラムを変更
    protected $primaryKey = 'order_import_setting_id';
    // 操作可能なカラムを定義
    protected $fillable = [
        'order_import_setting_name',
        'shop_id',
        'data_extension',
        'register_user_no',
        'order_no',
        'order_date',
        'order_time',
        'buyer_name',
        'buyer_zip_code',
        'buyer_address',
        'buyer_tel',
        'ship_name',
        'ship_zip_code',
        'ship_address',
        'ship_tel',
        'desired_delivery_date',
        'desired_delivery_time',
        'shipping_method',
        'payment_method',
        'shipping_fee',
        'other_fee',
        'sales_tax',
        'point_discount',
        'coupon_discount',
        'other_discount',
        'total_amount',
        'billing_amount',
        'buyer_memo',
        'order_item_code',
        'order_item_name',
        'unit_price',
        'order_quantity',
    ];
    // 
    public static function getSettingParameter()
    {
        return [
            'order_no',
            'order_date',
            'order_time',
            'buyer_name',
            'buyer_zip_code',
            'buyer_address',
            'buyer_tel',
            'ship_name',
            'ship_zip_code',
            'ship_address',
            'ship_tel',
            'desired_delivery_date',
            'desired_delivery_time',
            'shipping_method',
            'payment_method',
            'shipping_fee',
            'other_fee',
            'sales_tax',
            'point_discount',
            'coupon_discount',
            'other_discount',
            'total_amount',
            'billing_amount',
            'buyer_memo',
            'order_item_code',
            'order_item_name',
            'unit_price',
            'order_quantity',
        ];
    }
    // 全て取得
    public static function getAll()
    {
        return self::orderBy('order_import_setting_id', 'asc');
    }
    // 指定したレコードを取得
    public static function getSpecify($order_import_setting_id)
    {
        return self::where('order_import_setting_id', $order_import_setting_id);
    }
    // shopsテーブルとのリレーション
    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id', 'shop_id');
    }
    // usersテーブルとのリレーション
    public function user()
    {
        return $this->belongsTo(User::class, 'register_user_no', 'user_no');
    }
}
