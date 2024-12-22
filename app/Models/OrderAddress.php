<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model
{
    protected $guarded = [
        'id',
    ];

    public function prefecture()
    {
        return $this->belongsTo(Prefecture::class);
    }
}
