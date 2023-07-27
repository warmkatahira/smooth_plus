<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class NifudaNoteChangeEnum extends Enum
{
    const ORDER_NO = 'order_no';
    const ORDER_CONTROL_ID = 'order_control_id';


    // 変換可能な項目を定義
    const CHANGE_LIST = [
        self::ORDER_NO => self::ORDER_NO,   // 受注番号
        self::ORDER_CONTROL_ID => self::ORDER_CONTROL_ID,   // 受注管理ID
    ];

    // 変換可能な項目であるか確認
    public static function exists_change_list($value, $order): string
    {
        // 定義されている項目であれば、受注データの値を返す
        if(array_key_exists($value, self::CHANGE_LIST)){
            // 存在している場合は、trueを返す
            return $order->$value;
        }
        // 存在していない場合は、マスタに設定してある値を返す(nullがエラーになるので、''を返す)
        return is_null($value) ? '' : $value;
    }
}
