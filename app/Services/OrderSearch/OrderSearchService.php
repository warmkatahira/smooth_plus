<?php

namespace App\Services\OrderSearch;

// モデル
use App\Models\Base;
use App\Models\DeliveryCompany;
use App\Models\Order;
// その他
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
// 列挙
use App\Enums\OrderStatusEnum;

class OrderSearchService
{
    // セッションを削除
    public function deleteSession()
    {
        // セッションを削除
        session()->forget([
            'search_order_no',
            'search_order_control_id',
        ]);
        return;
    }

    // 検索条件をセッションにを格納
    public function setSearchCondition($request)
    {
        // trueなら検索が実行されているので、検索条件をセット
        if($request->search_enter){
            // 検索条件をセッションにを格納
            session(['search_order_no' => $request->search_order_no]);
            session(['search_order_control_id' => $request->search_order_control_id]);
        }
        return;
    }

    // 検索結果の受注データを取得
    public function getSearchOrder()
    {
        // インスタンス化
        $Order = new Order;
        // ステータスを指定して受注データを取得
        $orders = $Order->where('order_status_id', session('order_status_id'));
        // 受注番号の条件がある場合
        if (session('search_order_no') != null) {
            $orders->where('order_no', 'LIKE', '%'.session('search_order_no').'%');
        }
        // 受注管理IDの条件がある場合
        if (session('search_order_control_id') != null) {
            $orders->where('order_control_id', 'LIKE', '%'.session('search_order_control_id').'%');
        }
        // ページネーションを指定
        return $orders->orderBy('shipping_date', 'asc')->paginate(50);
    }

    public function getBackUrl()
    {
        // 現在のURLを取得
        session(['back_url_1' => url()->full()]);
        return;
    }
}