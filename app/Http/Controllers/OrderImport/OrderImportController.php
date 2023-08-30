<?php

namespace App\Http\Controllers\OrderImport;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// モデル
use App\Models\OrderImportSetting;
use App\Models\OrderImport;
// リクエスト
use App\Http\Requests\OrderImport\OrderImportRequest;
// サービス
use App\Services\OrderImport\OrderImportService;
use App\Services\OrderImport\ErrorDownloadService;
// その他
use Carbon\CarbonImmutable;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Facades\DB;

class OrderImportController extends Controller
{
    // 受注インポート画面表示
    public function index()
    {
        // 受注インポート設定を全て取得
        $order_import_settings = OrderImportSetting::getAll()->get();
        return view('order_import.index')->with([
            'order_import_settings' => $order_import_settings,
        ]);
    }

    // 受注データインポート
    public function import(OrderImportRequest $request)
    {
        // セッションを削除
        session()->forget(['order_import_error']);
        // インスタンス化
        $OrderImportService = new OrderImportService;
        try {
            $order_no_num = DB::transaction(function () use ($request, $OrderImportService) {
                // 現在の日時を取得
                $nowDate = CarbonImmutable::now();
                // 受注インポート設定を取得
                $order_import_setting = OrderImportSetting::getSpecify($request->order_import_setting_id)->first();
                // 受注データをストレージに保存し、フルパスを取得
                $path = $OrderImportService->importOrderData($request->file('order_data'), 'import_order_data.csv');
                // 受注インポート設定のカラム位置が受注データに存在しているかチェック
                $error = $OrderImportService->checkOrderDataColumn($order_import_setting, $path);
                // trueであれば、エラーを返す
                if($error){
                    throw new \Exception("受注データの列数不正により、インポートできませんでした。");
                }
                // 追加する受注データを配列に格納（同時にバリデーションも実施）
                $result = $OrderImportService->setArrayOrderData($order_import_setting, $path, $nowDate);
                // バリデーションエラー配列の中にnull以外があれば、エラー情報を出力
                if(count(array_filter($result['validation_error'])) != 0){
                    // セッションにエラー情報を格納
                    session(['order_import_error' => array(['エラー情報' => $result['validation_error'], 'インポート日時' => $nowDate])]);
                    throw new \Exception("受注データが正しくない為、インポートできませんでした。");
                }
                // order_importsテーブルへ追加
                $OrderImportService->insertTableOrderData($result['insert_data']);
                // インポート済みの受注があれば削除する
                $order_no_num = $OrderImportService->deleteImportedOrderData($nowDate);
                // 処理後の受注番号数が0であればインポートできる受注がないので、エラー情報を出力
                if($order_no_num['after_order_no_num'] == 0){
                    throw new \Exception("インポートできる受注がありませんでした。");
                }
                // 受注データ毎の処理
                $OrderImportService->procByOrder($nowDate);
                // ordersとorder_detailsテーブルに追加
                $OrderImportService->insertOrderTable();
                return $order_no_num;
            });
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'alert_type' => 'error',
                'alert_message' => $e->getMessage(),
            ]);
        }
        // 受注マクロ適用処理

        // 引当処理
        
        // 処理完了後に表示するメッセージを作成
        $alert = $OrderImportService->createDispMessage($order_no_num);
        return redirect()->back()->with([
            'alert_type' => $alert['type'],
            'alert_message' => $alert['message'],
        ]);
    }

    // 受注インポートエラーダウンロード
    public function import_error_download()
    {
        // インスタンス化
        $ErrorDownloadService = new ErrorDownloadService;
        // ダウンロードする情報を取得
        $response = $ErrorDownloadService->getDownloadItem();
        // ダウンロード処理
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename=受注インポートエラー_' . CarbonImmutable::now()->isoFormat('Y年MM月DD日HH時mm分ss秒') . '.csv');
        return $response;
    }
}
