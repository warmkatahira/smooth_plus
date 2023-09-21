<?php

namespace App\Services\OrderMgt;

// 列挙
use App\Enums\OrderStatusEnum;

class OrderMgtService
{
    // 初期表示条件をセッションに格納
    public function setDefaultCondition($request)
    {
        // nullなら検索が実行されていないので、初期条件をセット
        if(is_null($request->search_enter)){
            session(['order_status_id' => isset($request->order_status_id) ? $request->order_status_id : OrderStatusEnum::KAKUNIN_MACHI]);
        }
        // パラメータが無ければ「確認待ち」をセット
        session(['order_status_id' => isset($request->order_status_id) ? $request->order_status_id : OrderStatusEnum::KAKUNIN_MACHI]);
        return;
    }
}