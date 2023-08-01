<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\OrderStatusEnum;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;
    // 主キーカラムを変更
    protected $primaryKey = 'order_id';
    // 操作可能なカラムを定義
    protected $fillable = [
        'order_control_id',
        'order_import_method',
        'order_import_date',
        'order_import_time',
        'order_status_id',
        'is_confirmed',
        'is_allocated',
        'estimated_shipping_date',
        'is_shipping_inspection_complete',
        'shipping_inspection_date',
        'tracking_no',
        'shipping_date',
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
        'shipping_method_memo',
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
        'shop_memo',
        'work_memo',
        'last_update_user_no',
        'shipping_group_id',
        'delivery_time_zone',
    ];
    // 全てを取得
    public static function getAll()
    {
        return self::orderBy('order_id', 'asc');
    }
    // shopsテーブルとのリレーション
    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id', 'shop_id');
    }
}
