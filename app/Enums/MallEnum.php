<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class MallEnum extends Enum
{
    const YAHOO     = 1;    // ヤフー
    const RAKUTEN   = 2;    // 楽天
    const AMAZON    = 3;    // アマゾン
    const QOO10     = 4;    // Qoo10
    const AUPAY     = 5;    // au pay
}
