<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderImport extends Model
{
    use HasFactory;
    // 主キーカラムを変更
    protected $primaryKey = 'order_import_id';
    // 操作可能なカラムを定義
    protected $fillable = [
        'order_control_id',
        'order_import_method',
        'order_import_date',
        'order_import_time',
        'order_status_id',
        'shop_id',
        'shipping_method_id',
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
    // ordersテーブルに追加する情報を取得
    public static function orderInsertTargetListForOrder($query)
    {
        return $query->select([
            'order_control_id',
            'order_import_method',
            'order_import_date',
            'order_import_time',
            'order_status_id',
            'shop_id',
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
            'shipping_method_id',
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
        ]);
    }
    // order_detailsテーブルに追加する情報を取得
    public static function orderInsertTargetListForOrderDetail($query)
    {
        return $query->select([
            'order_control_id',
            'order_item_code',
            'order_item_name',
            'unit_price',
            'order_quantity',
        ]);
    }
}
