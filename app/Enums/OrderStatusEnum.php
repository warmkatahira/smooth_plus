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

    const KAKUNIN_MACHI_JP  = '確認待ち';
    const HIKIATE_MACHI_JP  = '引当待ち';
    const HATCHU_ZUMI_JP    = '発注済み';
    const SHUKKA_MACHI_JP   = '出荷待ち';
    const SAGYO_CHU_JP      = '作業中';
    const SHUKKA_ZUMI_JP    = '出荷済み';

    // 受注管理画面の上部に表示するステータス情報を定義
    const ORDER_MGT_INFO = [
        self::KAKUNIN_MACHI => self::KAKUNIN_MACHI_JP,
        self::HIKIATE_MACHI => self::HIKIATE_MACHI_JP,
        self::HATCHU_ZUMI => self::HATCHU_ZUMI_JP,
        self::SHUKKA_MACHI => self::SHUKKA_MACHI_JP,
    ];

    // order_status_idと日本語を関連付けた配列を定義
    const ORDER_STATUS_ID_JP_LIST = [
        self::KAKUNIN_MACHI => self::KAKUNIN_MACHI_JP,
        self::HIKIATE_MACHI => self::HIKIATE_MACHI_JP,
        self::HATCHU_ZUMI => self::HATCHU_ZUMI_JP,
        self::SHUKKA_MACHI => self::SHUKKA_MACHI_JP,
        self::SAGYO_CHU => self::SAGYO_CHU_JP,
        self::SHUKKA_ZUMI => self::SHUKKA_ZUMI_JP,
    ];

    // order_status_idから日本語を取得
    public static function getOrderStatusJP($order_status_id)
    {
        if(array_key_exists($order_status_id, self::ORDER_STATUS_ID_JP_LIST)) {
            return self::ORDER_STATUS_ID_JP_LIST[$order_status_id];
        }else{
            // キーが存在しない場合の処理
            return null;
        }
    }
}
