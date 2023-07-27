<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class AnnouncementEnum extends Enum
{
    const NOTICE = 'お知らせ';
    const IMPORTANT = '重要';
    const MAINTENANCE = 'メンテナンス';

    const CATEGORY_LIST = [
        self::NOTICE,
        self::IMPORTANT,
        self::MAINTENANCE,
    ];

    // カテゴリに対応する色を取得
    public static function getColor($category)
    {
        switch($category) {
            case self::NOTICE:
                return 'bg-blue-200';
            case self::IMPORTANT:
                return 'bg-red-500 text-white';
            case self::MAINTENANCE:
                return 'bg-teal-200';
        }
    }
}
