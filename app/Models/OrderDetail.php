<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    // 主キーカラムを変更
    protected $primaryKey = 'order_detail_id';
    // 操作可能なカラムを定義
    protected $fillable = [
        'order_control_id',
        'is_item_allocated',
        'is_stock_allocated',
        'order_item_code',
        'order_item_name',
        'order_item_option_1',
        'order_item_option_2',
        'order_item_option_3',
        'unit_price',
        'order_quantity',
        'unallocated_quantity',
        'is_order_macro_add',
    ];
    // ordersテーブルとのリレーション
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_control_id', 'order_control_id');
    }
}
