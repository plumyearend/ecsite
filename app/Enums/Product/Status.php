<?php

namespace App\Enums\Product;

use App\Interfaces\HasLabel;
use App\Traits\EnumList;

enum Status: int implements HasLabel
{
    use EnumList;

    /** 販売しない */
    case PRIVATE = 0;

    /** 販売中 */
    case PUBLISHED = 1;

    public function label(): string
    {
        return match ($this) {
            self::PRIVATE => '販売しない',
            self::PUBLISHED => '販売中',
        };
    }
}
