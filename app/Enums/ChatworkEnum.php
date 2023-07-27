<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ChatworkEnum extends Enum
{
    const ACCESS_TOKEN  = '00e3e3cd814793bb6ff7115af3ae506e';
    const ACCOUNT_ID    = '3281641';
    const URL           = 'https://api.chatwork.com/v2/rooms/323436129/messages';
    const START_MESSAGE = "smoothからの自動送信メッセージ\n";
    const SHIPPING_WORK_START_TITLE = '【出荷作業開始通知】';
    const SHIPPING_WORK_END_TITLE = '【出荷作業完了通知】';
    const NYUKO_SCHEDULE_ADD_TITLE = '【入庫予定追加通知】';
}
