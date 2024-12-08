<?php

namespace App\Enums\Order;

use Filament\Support\Contracts\HasLabel;

enum Status: int implements HasLabel
{
    /** 入金待ち */
    case PAYMENT_WAITING = 0;

    /** 発送待ち */
    case DELIVERY_PENDING = 1;

    /** 発送済み */
    case DELIVERED = 2;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PAYMENT_WAITING => '入金待ち',
            self::DELIVERY_PENDING => '発送待ち',
            self::DELIVERED => '発送済み',
        };
    }
}
