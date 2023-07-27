<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class OrderStatusEnum extends Enum
{
    const KAKUNIN_MACHI     = 1;    // 確認待ち
    const HIKIATE_MACHI     = 2;    // 引当待ち
    const HATCHU_ZUMI       = 3;    // 発注済み
    const SHUKKA_MACHI      = 4;    // 出荷待ち
    const SAGYO_CHU         = 5;    // 作業中
    const SHUKKA_ZUMI       = 6;    // 出荷済み
}
