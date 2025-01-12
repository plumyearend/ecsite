<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $guarded = [
        'id',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function featureProducts()
    {
        return $this->hasMany(FeatureProduct::class);
    }
}
