<?php

namespace App\Enums\Payment;

use Filament\Support\Contracts\HasLabel;

enum Status: int implements HasLabel
{
    /** 支払い前 */
    case BEFORE_PAYMENT = 0;

    /** 支払い中 */
    case IN_PAYMENT = 1;

    /** 支払い完了 */
    case PAY_COMPLETION = 2;

    /** 支払い失敗 */
    case PAYMENT_FAILURE = 3;

    /** 返金された */
    case REFUNDED = 4;

    /** キャンセル */
    case CANCEL = 5;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::BEFORE_PAYMENT => '支払い前',
            self::IN_PAYMENT => '支払い中',
            self::PAY_COMPLETION => '支払い完了',
            self::PAYMENT_FAILURE => '支払い失敗',
            self::REFUNDED => '返金された',
            self::CANCEL => 'キャンセル',
        };
    }
}
