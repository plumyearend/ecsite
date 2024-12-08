<?php

namespace App\Models;

use App\Enums\Product\Status;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $guarded = [
        'id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class)->where('status', Status::PUBLISHED);
    }
}
