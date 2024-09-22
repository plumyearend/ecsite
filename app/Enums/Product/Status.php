<?php

namespace App\Enums\Product;

use Filament\Support\Contracts\HasLabel;

enum Status: int implements HasLabel
{
    /** 販売しない */
    case PRIVATE = 0;

    /** 販売中 */
    case PUBLISHED = 1;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PRIVATE => '販売しない',
            self::PUBLISHED => '販売中',
        };
    }
}
