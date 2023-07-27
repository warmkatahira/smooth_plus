<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class Qoo10ShippingResultEnum extends Enum
{
    // 「配送会社」で使用する値を定義
    const SHIPPING_METHOD_SAGAWA_ID = 1;
    const SHIPPING_METHOD_NEKOPOS_ID = 3;
    const SHIPPING_METHOD_SAGAWA_JP = '佐川急便';
    const SHIPPING_METHOD_NEKOPOS_JP = 'ネコポス';
    // 「配送会社」で使用する値の配列
    const SHIPPING_METHOD_LIST = [
        self::SHIPPING_METHOD_SAGAWA_ID => self::SHIPPING_METHOD_SAGAWA_JP,
        self::SHIPPING_METHOD_NEKOPOS_ID => self::SHIPPING_METHOD_NEKOPOS_JP,
    ];
    // 
    public static function id_jp_change($id): string
    {
        // 定義されている項目であれば、値を返す
        if(array_key_exists($id, self::SHIPPING_METHOD_LIST)){
            return self::SHIPPING_METHOD_LIST[$id];
        }
        // 存在していない場合は、空を返す
        return '';
    }
}
