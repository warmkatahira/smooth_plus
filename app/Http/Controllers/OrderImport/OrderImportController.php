<?php

namespace App\Http\Controllers\OrderImport;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// モデル
use App\Models\OrderImportSetting;
// リクエスト
use App\Http\Requests\OrderImport\OrderImportRequest;
// サービス
use App\Services\OrderImport\OrderImportService;
// その他
use Carbon\CarbonImmutable;

class OrderImportController extends Controller
{
    public function index()
    {
        // 受注インポート設定を全て取得
        $order_import_settings = OrderImportSetting::getAll()->get();
        return view('order_import.index')->with([
            'order_import_settings' => $order_import_settings,
        ]);
    }

    public function import(OrderImportRequest $request)
    {
        // 現在の日時を取得
        $nowDate = CarbonImmutable::now();
        // インスタンス化
        $OrderImportService = new OrderImportService;
        // 受注インポート設定を取得
        $order_import_setting = OrderImportSetting::getSpecify($request->order_import_setting_id)->first();
        // 受注データをストレージに保存し、フルパスを取得
        $path = $OrderImportService->importOrderData($request->file('order_data'), 'import_order_data.csv');
        // 追加する受注データを配列に格納（同時にバリデーションも実施）
        $result = $OrderImportService->setArrayOrderData($order_import_setting, $path, $nowDate);
        // バリデーションエラー配列の中にnull以外があれば、エラー情報を出力
        if(count(array_filter($result['validation_error'])) != 0){
            // セッションにエラー情報を格納
            session(['import_error' => array(['エラー情報' => $result['validation_error'], 'インポート日時' => $nowDate])]);
            throw new \Exception("受注データが正しくない為、インポートできませんでした。");
        }
        // order_importsテーブルへ追加
        $OrderImportService->insertTableOrderData($result['insert_data']);
        dd($result);
    }
}
