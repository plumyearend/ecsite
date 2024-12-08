<?php

namespace App\Models;

use App\Enums\Payment\Method;
use App\Enums\Payment\Status;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $guarded = [
        'id',
    ];

    protected function casts(): array
    {
        return [
            'status' => Status::class,
            'method' => Method::class,
        ];
    }
}
