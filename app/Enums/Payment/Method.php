<?php

namespace App\Enums\Payment;

use Filament\Support\Contracts\HasLabel;

enum Method: int implements HasLabel
{
    /** クレジットカード */
    case CREDIT_CARD = 0;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::CREDIT_CARD => 'クレジットカード',
        };
    }
}
