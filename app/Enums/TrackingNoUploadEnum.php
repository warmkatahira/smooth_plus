<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class TrackingNoUploadEnum extends Enum
{
    // 佐川急便の出荷実績データのヘッダーを定義
    const SAGAWA_HEADER = [
        '顧客管理番号',
        '問い合せNo',
    ];
    // 佐川急便の出荷実績データの反映に必要な列位置を定義
    const SAGAWA_ORDER_CONTROL_ID = '顧客管理番号';
    const SAGAWA_TRACKING_NO = '問い合せNo';

    // ヤマト運輸の出荷実績データのヘッダーを定義
    const YAMATO_HEADER = [
        'お客様管理番号',
        '送り状種類',
        'クール区分',
        '伝票番号',
    ];
    // ヤマト運輸の出荷実績データの反映に必要な列位置を定義
    const YAMATO_ORDER_CONTROL_ID = 'お客様管理番号';
    const YAMATO_TRACKING_NO = '伝票番号';
}
