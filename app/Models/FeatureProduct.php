<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class FeatureProduct extends Pivot
{
    protected $guarded = [
        'id',
    ];

    public function feature()
    {
        return $this->belongsTo(Feature::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
