<?php declare(strict_types=1);

namespace App\Enums\OrderMacro;

use BenSampo\Enum\Enum;
use App\Models\ShippingMethod;

final class OrderMacroActionEnum extends Enum
{
    const KAKUNIN_MACHI_CHANGE = 'KAKUNIN_MACHI_CHANGE';
    const SHIPPING_FEE_ADDITION = 'SHIPPING_FEE_ADDITION';
    const SHIPPING_METHOD_CHANGE = 'SHIPPING_METHOD_CHANGE';
    const SHOP_MEMO_SET = 'SHOP_MEMO_SET';
    const WORK_MEMO_SET = 'WORK_MEMO_SET';
    const ITEM_RECORD_ADDITION = 'ITEM_RECORD_ADDITION';

    const KAKUNIN_MACHI_CHANGE_JP = '確認待ちに変更する';
    const SHIPPING_FEE_ADDITION_JP = '送料を加算する';
    const SHIPPING_METHOD_CHANGE_JP = '配送方法を変更する';
    const SHOP_MEMO_SET_JP = 'ショップメモを設定する';
    const WORK_MEMO_SET_JP = '作業指示を設定する';
    const ITEM_RECORD_ADDITION_JP = '商品行を追加する';

    // マクロ動作のプルダウン用
    const ACTION_LIST = [
        self::KAKUNIN_MACHI_CHANGE => self::KAKUNIN_MACHI_CHANGE_JP,
        self::SHIPPING_FEE_ADDITION => self::SHIPPING_FEE_ADDITION_JP,
        self::SHIPPING_METHOD_CHANGE => self::SHIPPING_METHOD_CHANGE_JP,
        self::SHOP_MEMO_SET => self::SHOP_MEMO_SET_JP,
        self::WORK_MEMO_SET => self::WORK_MEMO_SET_JP,
        self::ITEM_RECORD_ADDITION => self::ITEM_RECORD_ADDITION_JP,
    ];

    // マクロ動作値が必要な動作を定義
    const ACTION_VALUE_REQUIRED_LIST = [
        self::SHIPPING_FEE_ADDITION => self::SHIPPING_FEE_ADDITION,
        self::SHIPPING_METHOD_CHANGE => self::SHIPPING_METHOD_CHANGE,
        self::SHOP_MEMO_SET => self::SHOP_MEMO_SET,
        self::WORK_MEMO_SET => self::WORK_MEMO_SET,
        self::ITEM_RECORD_ADDITION => self::ITEM_RECORD_ADDITION,
    ];

    // 定義されているマクロ動作であるか判定
    public static function action_exist_check($key): bool
    {
        // 判定結果を格納する変数をセット（0は不要、1は必要）
        $result = false;
        // 配列にキーが存在していれば、存在している
        if(array_key_exists($key, self::ACTION_LIST)){
            $result = true;
        }
        return $result;
    }

    // マクロ動作値が必要か判定
    public static function action_value_required_check($key): bool
    {
        // 判定結果を格納する変数をセット（0は不要、1は必要）
        $result = false;
        // 配列にキーが存在していれば、動作値が必要な動作
        if(array_key_exists($key, self::ACTION_VALUE_REQUIRED_LIST)){
            $result = true;
        }
        return $result;
    }

    // マクロ動作値下部に表示する内容を取得(動作値が必要な場合のみ)
    public static function action_value_disp_text($key): string
    {
        if($key == self::SHIPPING_FEE_ADDITION){
            return "加算したい金額を入力して下さい。";
        }
        if($key == self::SHIPPING_METHOD_CHANGE){
            return self::shipping_method_disp_text();
        }
        if($key == self::SHOP_MEMO_SET){
            return "";
        }
        if($key == self::WORK_MEMO_SET){
            return "";
        }
        if($key == self::ITEM_RECORD_ADDITION){
            return "商品コード:商品名:商品オプション1:商品オプション2:商品オプション3:単価:購入数の形式で入力して下さい。<br>".
                   "それぞれの項目を半角コロン（:）で連結して下さい。<br>".
                   "※商品オプションは必須ではありません。";
        }
    }

    // 配送方法を変更するの説明を作成
    public static function shipping_method_disp_text()
    {
        $text = '以下の数値で設定して下さい。<br>';
        foreach(ShippingMethod::all() as $shipping_method){
            $text = $text .'<br>'. $shipping_method->shipping_method_id .' => '. $shipping_method->shipping_method .'('.$shipping_method->delivery_company->delivery_company.')';
        }
        return $text;
    }

}
