<?php

namespace App\Http\Controllers\OrderMgt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// モデル
use App\Models\Shop;
use App\Models\Order;
// サービス
use App\Services\OrderMgt\OrderMgtService;
use App\Services\OrderSearch\OrderSearchService;
// 列挙
use App\Enums\OrderStatusEnum;

class OrderMgtController extends Controller
{
    public function index(Request $request)
    {
        // 現在のURLを取得
        session(['back_url_1' => url()->full()]);
        // インスタンス化
        $OrderMgtService = new OrderMgtService;
        $OrderSearchService = new OrderSearchService;
        // セッションを削除
        $OrderSearchService->deleteSession();
        // 初期表示条件をセッションに格納
        $OrderMgtService->setDefaultCondition($request);
        // 検索結果の受注データを取得
        $orders = $OrderSearchService->getSearchOrder($request);
        // 画面上部に表示するステータス情報を定義
        $order_statuses_info = OrderStatusEnum::ORDER_MGT_INFO;
        return view('order_mgt.index')->with([
            'orders' => $orders,
            'order_statuses_info' => $order_statuses_info,
        ]);
    }
}
