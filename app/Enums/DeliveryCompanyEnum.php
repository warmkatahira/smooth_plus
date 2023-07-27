<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class DeliveryCompanyEnum extends Enum
{
    const SAGAWA    = 1;    // 佐川急便
    const YAMATO    = 2;    // ヤマト運輸
    const JP        = 3;    // 日本郵便
}
