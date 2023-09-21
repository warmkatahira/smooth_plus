<?php

namespace App\Lib;

use App\Models\Order;

class OrderCountByOrderStatusFunc
{
    // ステータスを指定して件数を取得
    public static function count($order_status_id)
    {
        return Order::where('order_status_id', $order_status_id)->count();
    }
}