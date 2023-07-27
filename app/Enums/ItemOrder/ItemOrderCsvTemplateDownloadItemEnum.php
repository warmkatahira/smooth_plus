<?php declare(strict_types=1);

namespace App\Enums\ItemOrder;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ItemOrderCsvTemplateDownloadItemEnum extends Enum
{
    const ITEM_CODE         = 'item_code';
    const ITEM_JAN_CODE     = 'item_jan_code';
    const ITEM_NAME_1       = 'item_name_1';
    const ITEM_NAME_2       = 'item_name_2';
    const ITEM_CATEGORY     = 'item_category_1';
    const BASE_NAME         = 'base_name';
    const ORDER_QUANTITY    = 'order_quantity';

    // 日本語名を定義した配列
    const DOWNLOAD_ITEM_VALUE_LIST = [
        self::ITEM_CODE => '商品コード',
        self::ITEM_JAN_CODE => 'JANコード',
        self::ITEM_NAME_1 => '商品名1',
        self::ITEM_NAME_2 => '商品名2',
        self::ITEM_CATEGORY => '商品カテゴリ1',
        self::BASE_NAME => '保管倉庫',
        self::ORDER_QUANTITY => '購入数',
    ];

    // 定義されているダウンロード項目値であるか判定
    public static function download_item_value_exist_check($key): bool
    {
        // 判定結果を格納する変数をセット（0は不要、1は必要）
        $result = false;
        // 配列にキーが存在していれば、存在している
        if(array_key_exists($key, self::DOWNLOAD_ITEM_VALUE_LIST)){
            $result = true;
        }
        return $result;
    }
}
