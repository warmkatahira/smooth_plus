<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ShippingMethodEnum extends Enum
{
    const SAGAWA_TAKUHAI    = 1;    // 佐川急便（宅配便）
    const YAMATO_TAKKYU     = 2;    // ヤマト運輸（宅急便）
    const YAMATO_NEKO       = 3;    // ヤマト運輸（ネコポス）
    const YAMATO_COMPACT    = 4;    // ヤマト運輸（コンパクト）
    const JP_YUPACK         = 5;    // 日本郵便（ゆうパック）
    const JP_PACKET         = 6;    // 日本郵便（ゆうパケット）
}
