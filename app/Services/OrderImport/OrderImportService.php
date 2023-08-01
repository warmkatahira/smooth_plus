<?php

namespace App\Services\OrderImport;

// モデル
use App\Models\OrderImportSetting;
use App\Models\OrderImport;
use App\Models\Order;
use App\Models\OrderDetail;
// 列挙
use App\Enums\OrderStatusEnum;
// その他
use Carbon\CarbonImmutable;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class OrderImportService
{
    // 受注データをストレージに保存し、フルパスを取得
    public function importOrderData($file, $import_file_name)
    {
        // 保存先のストレージ階層を取得
        $spath = storage_path('app/');
        // ストレージにデータを保存し、フルパスを返す
        return $spath.$file->storeAs('public/import/order', $import_file_name);
    }

    // 受注インポート設定のカラム位置が受注データに存在しているかチェック
    public function checkOrderDataColumn($order_import_setting, $path)
    {
        // 受注データの情報を取得
        $all_line = (new FastExcel)->import($path);
        // UTF-8形式に変換した1行分のデータを取得
        $line = mb_convert_encoding($all_line[0], 'UTF-8', 'ASCII, JIS, UTF-8, SJIS-win');
        // 配列のキーを列位置に変更し、ダミー要素を先頭に追加
        $line = array_values($line);
        array_unshift($line, null);
        // インデックスを1から始めるため、ダミー要素を削除
        unset($line[0]);
        // 受注インポートに必要な項目のみを取得
        $setting_parameters = $order_import_setting->first(OrderImportSetting::getSettingParameter())->toArray();
        // 値がnullの要素を削除
        $setting_parameters = array_filter($setting_parameters, function ($value) {
            return !is_null($value);
        });
        // 設定値の分だけループ
        foreach($setting_parameters as $key => $value){
            // キーが存在しなかったらtrueを返す
            if(!isset($line[$value])){
                return true;
            }
        }
        return;
    }

    // 
    public function setArrayOrderData($order_import_setting, $path, $nowDate)
    {
        // 受注データの情報を取得
        $all_line = (new FastExcel)->import($path);
        // 配列をセット
        $insert_data = [];
        $validation_error = [];
        // バリデーションエラー出力ファイルのヘッダーを定義
        $validation_error_header = array('エラー行数', 'エラー内容');
        // 取得したレコードの分だけループ
        foreach($all_line as $line_no => $line){
            // テーブルに追加する配列をセット
            $param = array_fill_keys(OrderImportSetting::getSettingParameter(), null);
            // UTF-8形式に変換した1行分のデータを取得
            $line = mb_convert_encoding($line, 'UTF-8', 'ASCII, JIS, UTF-8, SJIS-win');
            // 配列のキーを列位置に変更し、ダミー要素を先頭に追加
            $line = array_values($line);
            array_unshift($line, null);
            // インデックスを1から始めるため、ダミー要素を削除
            unset($line[0]);
            // 受注インポートに必要な項目のみを取得
            $setting_parameters = OrderImportSetting::where('order_import_setting_id', $order_import_setting->order_import_setting_id)->first(OrderImportSetting::getSettingParameter())->toArray();
            // 値がnullの要素を削除
            $setting_parameters = array_filter($setting_parameters, function($value) { return $value !== null; });
            // 設定値の分だけループし、列位置を使用して受注データの情報を配列にセット
            foreach($setting_parameters as $field_name => $parameter){
                // カンマでスプリット
                $parameter_arr = explode(",", $parameter);
                // 値を格納する配列をセット
                $value = null;
                // 設定値の文だけループ
                foreach($parameter_arr as $key => $item){
                    // 値を結合して変数へセットしていく
                    $value .= $line[$item];
                }
                // 日付と時間のデータ型については、フォーマット変換をかける
                try {
                    // 日付カラムのフォーマット変換をかける
                    if($field_name == 'order_date' || $field_name == 'desired_delivery_date'){
                        $value = CarbonImmutable::parse($value)->format('Y-m-d');
                    }
                    // 時間カラムのフォーマット変換をかける
                    if($field_name == 'order_time'){
                        $value = CarbonImmutable::parse($value)->format('H:i:s');
                    }
                } catch (\Exception $e) {
                    $validation_error[] = array_combine($validation_error_header, [$line_no + 2 . '行目', $parameter . '列目のデータが日付/時間ではありません。']);
                    return compact('validation_error');
                }
                // フィールド名の配列に値をセット
                $param[$field_name] = $value;
                // 購入数の場合、未引当数にも同じ値を入れる
                if($field_name == 'order_quantity'){
                    $param['unallocated_quantity'] = $value;
                }
            }
            // 受注データを参照しない値を配列にセット
            $param['shop_id'] = $order_import_setting->shop_id;
            $param['order_import_method'] = 'import';
            $param['order_import_date'] = $nowDate->toDateString();
            $param['order_import_time'] = $nowDate->toTimeString();
            $param['order_status_id'] = OrderStatusEnum::KAKUNIN_MACHI;
            $param['shipping_method_id'] = 1;
            // 値がnullの要素を削除
            $param = array_filter($param, function($value) { return $value !== null; });
            // バリデーション処理
            $message = $this->validationOrderData($param, $line_no + 2);
            // エラーメッセージがあればバリデーションエラーを配列に格納
            if(!is_null($message)){
                $validation_error[] = array_combine($validation_error_header, $message);
            }
            // 追加用の配列に整理した情報を格納
            $insert_data[] = $param;
        }
        return compact('insert_data', 'validation_error');
    }

    public function validationOrderData($param, $line_no)
    {
        // バリデーションルールを定義
        $rules = [
            'order_no' => 'required|max:50',
            'order_date' => 'nullable|date',
            'order_time' => 'nullable|date_format:H:i:s',
            'buyer_name' => 'nullable|max:50',
            'buyer_zip_code' => 'nullable|max:10',
            'buyer_address' => 'nullable|max:255',
            'buyer_tel' => 'nullable|max:13',
            'ship_name' => 'required|max:50',
            'ship_zip_code' => 'required|max:10',
            'ship_address' => 'required|max:255',
            'ship_tel' => 'required|max:13',
            'desired_delivery_date' => 'nullable|date',
            'desired_delivery_time' => 'nullable|max:20',
            'shipping_method' => 'nullable|max:20',
            'payment_method' => 'nullable|max:20',
            'shipping_fee' => 'nullable|integer',
            'other_fee' => 'nullable|integer',
            'sales_tax' => 'nullable|integer',
            'point_discount' => 'nullable|integer',
            'coupon_discount' => 'nullable|integer',
            'other_discount' => 'nullable|integer',
            'total_amount' => 'nullable|integer',
            'billing_amount' => 'nullable|integer',
            'buyer_memo' => 'nullable|max:500',
            'order_item_code' => 'required|max:50',
            'order_item_name' => 'nullable|max:255',
            'unit_price' => 'nullable|integer',
            'order_quantity' => 'required|integer|min:1',
        ];
        // バリデーションエラーメッセージを定義
        $messages = [
            'required' => ':attributeは必須です',
            'max' => ':attributeは:max文字以内にして下さい',
            'min' => ':attributeは:min以上にして下さい',
            'date' => ':attributeが日付ではありません',
            'integer' => ':attributeが数値ではありません',
        ];
        // バリデーションエラー項目を定義
        $attributes = [
            'order_no' => '受注番号',
            'order_date' => '注文日',
            'order_time' => '注文時間',
            'buyer_name' => '購入者名',
            'buyer_zip_code' => '購入者郵便番号',
            'buyer_address' => '購入者住所',
            'buyer_tel' => '購入者電話番号',
            'ship_name' => '配送先名',
            'ship_zip_code' => '配送先郵便番号',
            'ship_address' => '配送先住所',
            'ship_tel' => '配送先電話番号',
            'desired_delivery_date' => '配送希望日',
            'desired_delivery_time' => '配送希望時間',
            'shipping_method' => '配送方法',
            'payment_method' => '支払方法',
            'shipping_fee' => '送料',
            'other_fee' => 'その他費用',
            'sales_tax' => '消費税',
            'point_discount' => 'ポイント値引き',
            'coupon_discount' => 'クーポン値引き',
            'other_discount' => 'その他値引き',
            'total_amount' => '合計金額',
            'billing_amount' => '請求金額',
            'buyer_memo' => '購入者メモ',
            'order_item_code' => '商品コード',
            'order_item_name' => '商品名',
            'unit_price' => '単価',
            'order_quantity' => '購入数',
        ];
        // バリデーション実施
        $validator = Validator::make($param, $rules, $messages, $attributes);
        // バリデーションエラーメッセージを格納する変数をセット
        $message = '';
        // バリデーションエラーの分だけループ
        foreach($validator->errors()->toArray() as $errors){
            // メッセージを格納
            $message = empty($message) ? array_shift($errors) : $message . ' / ' . array_shift($errors);
        }
        return empty($message) ? null : array($line_no.'行目', $message);
    }

    public function insertTableOrderData($order)
    {
        // テーブルをロック
        OrderImport::select()->lockForUpdate()->get();
        // 追加先のテーブルをクリア
        OrderImport::query()->delete();
        // 追加用の配列に入っている情報をテーブルに追加
        OrderImport::insert($order);
        return;
    }

    public function updateOrderUnit($nowDate)
    {
        // 受注管理IDの先頭9桁(先頭固定のSを含む)に使用する文字列をランダムで生成し、既に使用されていないか確認する
        // 未使用の文字列になるまでループ処理
        $check = false;
        while($check == false){
            // 文字列を生成
            $order_control_id_head = 'S'.Str::random(8);
            // LIKE検索で生成した文字列をordersテーブルでカウント
            $count = Order::where('order_control_id', 'LIKE', '%'.$order_control_id_head.'%')->count();
            // countが0であれば存在していないので、trueをセット
            if($count == 0){
                $check = true;
            }
        }
        // 重複を取り除いた受注番号を取得
        $order_no_uniques = OrderImport::groupBy('order_no')->get(['order_no']);
        // 受注管理IDの連番で使用する変数をセット
        $count = 0;
        // 受注番号分だけループ
        foreach($order_no_uniques as $order_no_unique){
            // インポートした受注の中で、受注ステータスを「確認待ち」に変更する条件のものがあるか
            $order_status_id = $this->updateOrderStatusIdForKAKUNIN_MACHI($order_no_unique->order_no);
            // 受注管理IDを採番
            $count++;
            $order_control_id = $order_control_id_head . sprintf('%04d', $count);
            // 受注管理ID・受注ステータスIDを更新
            OrderImport::where('order_no', $order_no_unique->order_no)->update([
                'order_control_id' => $order_control_id,
                'order_status_id' => $order_status_id,
            ]);
        }
        return;
    }

    // インポートした受注の中で、受注ステータスを「確認待ち」に変更する条件のものがあるか
    public function updateOrderStatusIdForKAKUNIN_MACHI($order_no)
    {
        // 受注データを取得
        $order = OrderImport::where('order_no', $order_no)->first();
        // 以下の条件に該当すれば、受注ステータスを「確認待ち」に変更
        // 条件1:配送先住所から都道府県が取得できていない
        preg_match_all('/東京都|北海道|(?:京都|大阪)府|.{6,9}県/', $order->ship_address, $maches);
        if (!isset($maches[0][0])) {
            $order_status_id = OrderStatusEnum::KAKUNIN_MACHI;
        }
        // 条件2:購入者メモがNot Nullである
        if (!is_null($order->buyer_memo)) {
            $order_status_id = OrderStatusEnum::KAKUNIN_MACHI;
        }
        return isset($order_status_id) ? $order_status_id : OrderStatusEnum::HIKIATE_MACHI;
    }

    public function insertOrderTable()
    {
        // ordersテーブルに追加する情報を取得
        $insert_order = OrderImport::orderInsertTargetListForOrder(OrderImport::query())->get();
        // 重複を取り除いた結果を取得
        $insert_order_unique = collect($insert_order)->unique()->toArray();
        // ordersテーブルに追加
        Order::upsert($insert_order_unique, 'order_id');
        // order_detailsテーブルに追加する情報を取得
        $insert_order_detail = OrderImport::orderInsertTargetListForOrderDetail(OrderImport::query())->get()->toArray();
        // order_detailsテーブルに追加
        OrderDetail::upsert($insert_order_detail, 'order_detail_id');
        return;
    }
}