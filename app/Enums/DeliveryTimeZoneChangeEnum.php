<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class DeliveryTimeZoneChangeEnum extends Enum
{
    const ZONE_AM = 'AM';
    const ZONE_1214 = '1214';
    const ZONE_1416 = '1416';
    const ZONE_1618 = '1618';
    const ZONE_1820 = '1820';
    const ZONE_1921 = '1921';

    // プルダウン用
    const PULLDOWN_LIST = [
        self::ZONE_AM => '午前中',
        self::ZONE_1214 => '12時 - 14時',
        self::ZONE_1416 => '14時 - 16時',
        self::ZONE_1618 => '16時 - 18時',
        self::ZONE_1820 => '18時 - 20時',
        self::ZONE_1921 => '19時 - 21時',
    ];

    // 佐川急便の時間帯コード取得用
    const SAGAWA_TIME_ZONE_LIST = [
        self::ZONE_AM => '01',
        self::ZONE_1214 => '12',
        self::ZONE_1416 => '14',
        self::ZONE_1618 => '16',
        self::ZONE_1820 => '18',
        self::ZONE_1921 => '19',
    ];

    // ヤマト運輸の時間帯コード取得用
    const YAMATO_TIME_ZONE_LIST = [
        self::ZONE_AM => '0812',
        self::ZONE_1214 => '1214',
        self::ZONE_1416 => '1416',
        self::ZONE_1618 => '1618',
        self::ZONE_1820 => '1820',
        self::ZONE_1921 => '1921',
    ];

    // DBの設定値から文字列を取得
    public static function text_get($key): string
    {
        // nullの場合は空欄を返す
        if(is_null($key)){
            return '';
        }
        return self::PULLDOWN_LIST[$key];
    }

    // DBの設定値から佐川急便の時間帯コードを取得
    public static function sagawa_time_zone_get($key): string
    {
        // nullの場合は空欄を返す
        if(is_null($key)){
            return '';
        }
        return self::SAGAWA_TIME_ZONE_LIST[$key];
    }

    // DBの設定値からヤマト運輸の時間帯コードを取得
    public static function yamato_time_zone_get($key): string
    {
        // nullの場合は空欄を返す
        if(is_null($key)){
            return '';
        }
        return self::YAMATO_TIME_ZONE_LIST[$key];
    }
}
