<?php

namespace App\Traits;

trait EnumList
{
    public static function list(): array
    {
        $list = [];
        foreach (self::cases() as $enum) {
            $list[$enum->value] = $enum->label();
        }

        return $list;
    }
}
