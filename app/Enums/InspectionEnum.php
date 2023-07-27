<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class InspectionEnum extends Enum
{
    const JAN_LENGTH = 13;
    const JAN_START_POSITION = 1;
    const S_POWER_CODE_LENGTH = 3;
    const EXP_LENGTH = 4;
    const EXP_THRESHOLD = 4;
}
