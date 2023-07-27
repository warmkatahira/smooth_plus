<?php declare(strict_types=1);

namespace App\Enums\OrderMacro;

use BenSampo\Enum\Enum;

final class OrderMacroConditionsEnum extends Enum
{
    // +-+-+-+-+-+-+-+-+-+-+-+-   条件適用方法   +-+-+-+-+-+-+-+-+-+-+-+-
    const ALL_CONDITIONS = '全ての条件を満たすとき';
    const ANY_CONDITIONS = 'いずれかの条件を満たすとき';

    // 条件適用方法のプルダウン用
    const CONDITIONS_APPLY_METHOD_LIST = [
        'ALL' => self::ALL_CONDITIONS,
        'ANY' => self::ANY_CONDITIONS,
    ];

    // 定義されている条件適用方法であるか判定
    public static function conditions_apply_method_exist_check($key): bool
    {
        // 判定結果を格納する変数をセット（0は不要、1は必要）
        $result = false;
        // 配列にキーが存在していれば、存在している
        if(array_key_exists($key, self::CONDITIONS_APPLY_METHOD_LIST)){
            $result = true;
        }
        return $result;
    }

    // +-+-+-+-+-+-+-+-+-+-+-+-   条件項目   +-+-+-+-+-+-+-+-+-+-+-+-
    const BUYER_NAME = '購入者名';
    const BUYER_ADDRESS = '購入者住所';
    const SHIP_NAME = '配送先名';
    const SHIP_ADDRESS = '配送先住所';
    const TOTAL_AMOUNT = '合計金額';
    const BILLING_AMOUNT = '請求金額';
    const SHIPPING_METHOD_ID = '配送方法';
    const TOTAL_ORDER_QUANTITY = '合計購入数';
    const ORDER_ITME_CODE = '商品コード';
    const ORDER_ITME_NAME = '商品名';

    // 条件項目のプルダウン用
    const CONDITIONS_ITEM_LIST = [
        'buyer_name' => self::BUYER_NAME,
        'buyer_address' => self::BUYER_ADDRESS,
        'ship_name' => self::SHIP_NAME,
        'ship_address' => self::SHIP_ADDRESS,
        'total_amount' => self::TOTAL_AMOUNT,
        'billing_amount' => self::BILLING_AMOUNT,
        'shipping_method_id' => self::SHIPPING_METHOD_ID,
        'total_order_quantity' => self::TOTAL_ORDER_QUANTITY,
        'order_item_code' => self::ORDER_ITME_CODE,
        'order_item_name' => self::ORDER_ITME_NAME,
    ];

    // 条件項目が存在しているテーブルを定義
    const CONDITIONS_ITEM_EXIST_TABLE_LIST = [
        // orders
        'buyer_name' => 'orders.',
        'buyer_address' => 'orders.',
        'ship_name' => 'orders.',
        'ship_address' => 'orders.',
        'total_amount' => 'orders.',
        'billing_amount' => 'orders.',
        'shipping_method_id' => 'orders.',
        // order_details
        'order_item_code' => 'order_details.',
        'order_item_name' => 'order_details.',
        // クエリ集計なので、テーブルなし
        'total_order_quantity' => '',
    ];

    // 定義されている条件項目であるか判定
    public static function item_exist_check($key): bool
    {
        // 判定結果を格納する変数をセット（0は不要、1は必要）
        $result = false;
        // 配列にキーが存在していれば、存在している
        if(array_key_exists($key, self::CONDITIONS_ITEM_LIST)){
            $result = true;
        }
        return $result;
    }

    // 条件項目が存在しているテーブルを取得
    public static function item_exist_table_get($key): string
    {
        return self::CONDITIONS_ITEM_EXIST_TABLE_LIST[$key];
    }

    // +-+-+-+-+-+-+-+-+-+-+-+-   条件演算子   +-+-+-+-+-+-+-+-+-+-+-+-
    const INCLUDE = 'を含む';
    const SAME = 'と同じ';
    const MORE = '以上の';
    const LESS = '以下の';

    // 条件演算子のプルダウン用
    const CONDITIONS_OPERATOR_LIST = [
        'LIKE' => self::INCLUDE,
        '=' => self::SAME,
        '>=' => self::MORE,
        '<=' => self::LESS,
    ];

    // 定義されている条件演算子であるか判定
    public static function operator_exist_check($key): bool
    {
        // 判定結果を格納する変数をセット（0は不要、1は必要）
        $result = false;
        // 配列にキーが存在していれば、存在している
        if(array_key_exists($key, self::CONDITIONS_OPERATOR_LIST)){
            $result = true;
        }
        return $result;
    }

}
