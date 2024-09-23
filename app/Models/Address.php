<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $guarded = [
        'id',
    ];

    protected function casts(): array
    {
        return [
            'is_default_address' => 'boolean',
        ];
    }

    protected function postcodeHyphen(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                $postcode = $attributes['postcode'];

                return substr($postcode, 0, 3).'-'.substr($postcode, 3);
            },
        );
    }
}
