<?php

namespace App\Http\Controllers\OrderMgt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// モデル
use App\Models\Shop;
use App\Models\Order;
// サービス
use App\Services\Order\OrderMgtService;
use App\Services\Order\OrderSearchService;
// 列挙
use App\Enums\OrderStatusEnum;

class OrderMgtController extends Controller
{
    public function index(Request $request)
    {
        /* // インスタンス化
        $OrderMgtService = new OrderMgtService;
        $OrderSearchService = new OrderSearchService;
        // セッションを削除
        $OrderSearchService->deleteSession();
        // 初期表示条件をセッションに格納
        $OrderMgtService->setDefaultCondition($request->order_status_id);
        // 検索結果の受注データを取得
        $orders = $OrderSearchService->getOrderSearchResult();
        // 現在のURLを取得
        $OrderSearchService->getBackUrl();
        // ステータスが「作業中」の受注が存在する有効な出荷グループを取得
        $shipping_groups = $ShippingGroup->getAvailableShippingGroup();
        // 受注管理画面の上部に表示するステータスを取得
        $order_statuses = $OrderStatus->getHeaderDisp(OrderStatusEnum::KAKUNIN_MACHI, OrderStatusEnum::SHUKKA_MACHI);
        // 出荷モデルを全て取得
        $shipping_models = ShippingModel::getAll()->get();
        // ショップ情報を全て取得
        $shops = Shop::getAll()->get();
        // 倉庫情報を全て取得
        $bases = Base::getAll()->get();
        // 運送会社を全て取得
        $delivery_companies = DeliveryCompany::getAll()->get(); */
        $orders = Order::getAll()->get();
        return view('order_mgt.index')->with([
            'orders' => $orders,
        ]);
    }

    public function search(Request $request)
    {
        // インスタンス化
        $OrderMgtService = new OrderMgtService;
        $OrderSearchService = new OrderSearchService;
        $OrderStatus = new OrderStatus;
        $ShippingGroup = new ShippingGroup;
        // 検索条件をセッションに格納
        $OrderSearchService->setSearchCondition($request);
        // 検索結果の受注データを取得
        $orders = $OrderSearchService->getOrderSearchResult();
        // 現在のURLを取得
        $OrderSearchService->getBackUrl();
        // ステータスが「作業中」の受注が存在する有効な出荷グループを取得
        $shipping_groups = $ShippingGroup->getAvailableShippingGroup();
        // 受注管理画面の上部に表示するステータスを取得
        $order_statuses = $OrderStatus->getHeaderDisp(OrderStatusEnum::KAKUNIN_MACHI, OrderStatusEnum::SHUKKA_MACHI);
        // 出荷モデルを全て取得
        $shipping_models = ShippingModel::getAll()->get();
        // ショップ情報を全て取得
        $shops = Shop::getAll()->get();
        // 倉庫情報を全て取得
        $bases = Base::getAll()->get();
        // 運送会社を全て取得
        $delivery_companies = DeliveryCompany::getAll()->get();
        return view('order_mgt.index')->with([
            'orders' => $orders,
            'shipping_groups' => $shipping_groups,
            'order_statuses' => $order_statuses,
            'shipping_models' => $shipping_models,
            'bases' => $bases,
            'shops' => $shops,
            'delivery_companies' => $delivery_companies,
        ]);
    }

    public function shipping_model_select_base(Request $request)
    {
        // 出荷モデルで使用する倉庫のプルダウンを変更
        session(['shipping_model_select_base_id' => $request->shipping_model_select_base]);
        return redirect()->route('order_mgt.search');
    }
}
