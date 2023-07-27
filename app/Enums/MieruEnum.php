<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class MieruEnum extends Enum
{
    const CP_1ST = 'cp_1st';
    const CP_LC = 'cp_lc';

    const CUSTOMER_CODE_LIST = [
        "2" => self::CP_1ST,
        "3" => self::CP_LC,
    ];

    // 倉庫IDからcustomer_codeを取得
    public static function getCustomerCode($base_id)
    {
        if(array_key_exists($base_id, self::CUSTOMER_CODE_LIST)) {
            $value = self::CUSTOMER_CODE_LIST[$base_id];
            return $value;
        }else{
            // キーが存在しない場合の処理
            return null;
        }
    }
}
