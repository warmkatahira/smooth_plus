<?php

namespace App\Services\OrderImport;

// モデル
use App\Models\OrderImportSetting;
use App\Models\OrderImport;
// 列挙
use App\Enums\OrderStatusEnum;
// その他
use Carbon\CarbonImmutable;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Facades\Validator;

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
            // UTF-8形式に変換した1行分のデータを取得
            $line = mb_convert_encoding($line, 'UTF-8', 'ASCII, JIS, UTF-8, SJIS-win');
            // 配列のキーを列位置に変更し、ダミー要素を先頭に追加
            $line = array_values($line);
            array_unshift($line, null);
            // インデックスを1から始めるため、ダミー要素を削除
            unset($line[0]);
            // データを格納する配列をセット
            $param = [];
            // 受注インポートに必要な項目のみを取得
            $setting_parameters = $order_import_setting->first(OrderImportSetting::getSettingParameter())->toArray();
            // 値がnullの要素を削除
            $setting_parameters = array_filter($setting_parameters, function ($value) {
                return !is_null($value);
            });
            // 設定値の分だけループし、列位置を使用して受注データの情報を配列にセット
            foreach($setting_parameters as $key => $value){
                $param[$key] = $line[$value];
            }
            // 受注データを参照しない値を配列にセット
            $param['shop_id'] = $order_import_setting->shop_id;
            $param['order_import_method'] = 'import';
            $param['order_import_date'] = $nowDate->toDateString();
            $param['order_import_time'] = $nowDate->toTimeString();
            $param['order_status_id'] = OrderStatusEnum::KAKUNIN_MACHI;
            $param['shipping_method_id'] = 1;
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
            'order_time' => 'nullable',
            'buyer_name' => 'nullable|max:50',
            'buyer_zip_code' => 'nullable|max:8',
            'buyer_address' => 'nullable|max:255',
            'buyer_tel' => 'nullable|max:13',
            'ship_name' => 'required|max:50',
            'ship_zip_code' => 'required|max:8',
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

    // order_item_codeを更新
    public function updateOrderItemCode()
    {
        // qoo10_order_importsテーブルのレコード分だけループ処理
        foreach(Qoo10OrderImport::all() as $order){
            // 「【」= 含まないかつ、オプションコードがnull以外かつオプション情報に「箱」が無い場合、オプションコード（=JANコード）が商品コードとなる
            if(strpos($order->option_info, '【') === false && !is_null($order->option_code) && substr_count($order->option_info, '箱') == 0){
                $order->update([
                    'order_item_code' => $order->option_code,
                ]);
                // 次に進む
                continue;
            }
            /* // オプションコードがnullかつオプション情報がnullの場合、ItemIdが商品コードとなる（ネイル対策）
            if(is_null($order_detail->option_code) && is_null($order_detail->item_option_name)){
                $order_detail->update([
                    'order_item_code' => $order_detail->item_id,
                ]);
                // 次に進む
                continue;
            } */
            // スラッシュをカウント
            $count = substr_count($order->option_info, '/');
            // スラッシュが含まれている場合
            if($count > 0){
                // スラッシュでスプリット
                $option_info_arr = explode('/', $order->option_info);
                // オプション情報に「カラー」が含まれていなければ、オプション情報値の墨括弧内1つで商品コードが完結している
                // 例）オプション情報=「度数(PWR)/右4箱;度数(PWR)/左4箱」
                /* if(strpos($order->option_info, 'カラー') === false){
                    for($i = 0;$i < count($option_info_arr);$i++){
                        // オプション情報に「ノベルティ」が含まれていたら、次に進む
                        if(strpos($option_info_arr[$i], 'ノベルティ') !== false){
                            continue;
                        }
                        // 商品コードを取得
                        $item_code = $this->getBetweenWord($option_info_arr[$i], '【', '】');
                        // オプション情報を取得
                        $option_info = $option_info_arr[$i];
                        // オプション情報に「度数」が含まれていない場合
                        if(strpos($option_info, '度数') === false){
                            // セット売りではないので、「1」固定とする
                            $quantity = 1;
                        }
                        // オプション情報に「度数」が含まれている場合
                        if(strpos($option_info, '度数') !== false){
                            // 不要な文字列を取り除いて、箱数を取得(この後、購入数にかける)
                            $option_info = str_replace(array("度数(PWR)/右", "度数(PWR)/左"), "", $option_info);
                            $quantity = str_replace("箱", "", $option_info);
                        }
                        // レコードを複製
                        $clone = $order->replicate();
                        // 複製したレコードに商品情報をセット、購入数に箱数をかける
                        $clone->order_item_code = $item_code;
                        $clone->option_info = $option_info;
                        $clone->quantity = $clone->quantity * $quantity;
                        // 複製したレコードを保存
                        $clone->save();
                    }
                    // clone元のレコードを削除して次に進む
                    $order->delete();
                    continue;
                } */
                // オプション情報が以下の場合、オプション情報の墨括弧内を2つ繋げて1つの商品コードとなる
                // 「カラー」= 含む、「【」= 含む 
                // 例）オプション情報=「カラー:エアリーブラウン【clos1d-aibr】 / 度数(PWR):-0.00【-000】」
                if(strpos($order->option_info, 'カラー') !== false && strpos($order->option_info, '【') !== false){
                    for($i = 0;$i < count($option_info_arr);$i++){
                        // 1つ目の墨括弧の中身を取得
                        $item_code_1 = $this->getBetweenWord($option_info_arr[$i], '【', '】');
                        // 2つ目の墨括弧の中身を取得
                        $i++;
                        $item_code_2 = $this->getBetweenWord($option_info_arr[$i], '【', '】');
                        // レコードを複製
                        $clone = $order->replicate();
                        // 複製したレコードに商品情報をセット
                        $clone->order_item_code = $item_code_1.$item_code_2;
                        // 複製したレコードを保存
                        $clone->save();
                    }
                    // clone元のレコードを削除して次に進む
                    $order->delete();
                    continue;
                }
            }
        }
        return;
    }

    // 指定した文字と文字の間を抽出
    public function getBetweenWord($word, $start, $end)
    {
        return mb_substr($word, ($i_tg = (mb_strpos($word, $start) + 1)), (mb_strpos($word, $end)) - $i_tg);
    }

    // order_importsテーブルへ追加
    public function insertOrderImport($nowDate)
    {
        // 追加内容を格納する配列をセット
        $insert_data = [];
        // qoo10_order_importsテーブルのレコード分だけループ処理
        foreach(Qoo10OrderImport::all() as $order){
            // 注文日時をインスタンス化
            $order_time = new CarbonImmutable($order->order_time);
            // 追加する内容を配列へ格納
            $param = [
                'order_no' => $order->order_no,
                'order_date' => $order_time->toDateString(),
                'order_time' => $order_time->toTimeString(),
                'buyer_name' => $order->buyer_name,
                'ship_name' => $order->ship_name,
                'ship_zip_code' => $order->ship_zip_code,
                'ship_address' => $order->ship_address,
                'ship_tel' => $order->ship_tel,
                'desired_delivery_date' => $order->desired_delivery_date,
                'shipping_method_memo' => $order->shipping_method_memo,
                'other_discount' => $order->other_discount,
                'billing_amount' => $order->billing_amount,
                'last_update_user_no' => $order->last_update_user_no,
                'order_item_code' => $order->order_item_code,
                'order_item_name' => $order->item_name,
                'order_item_option_1' => $order->option_info,
                'order_item_option_2' => $order->option_code,
                'unit_price' => $order->unit_price,
                'order_quantity' => $order->quantity,
                'unallocated_quantity' => $order->quantity,
                'estimated_shipping_date' => $order->estimated_shipping_date,
                // 固定値
                'shop_id' => 2,
                'order_import_method' => 'CSV',
                'order_import_date' => $nowDate->toDateString(),
                'order_import_time' => $nowDate->toTimeString(),
                'order_status_id' => OrderStatusEnum::KAKUNIN_MACHI,
                'shipping_method_id' => 1,
                // ユーザー情報
                'last_update_user_no' => Auth::user()->user_no
            ];
            $insert_data[] = $param;
        }
        // 追加
        OrderImport::upsert($insert_data, 'order_import_id');
        return;
    }
}