<?php

namespace App\Models;

use App\Enums\Product\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    protected function casts(): array
    {
        return [
            'status' => Status::class,
        ];
    }

    public function productImages(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function mainProductImage()
    {
        return $this->hasOne(ProductImage::class)->orderBy('sort');
    }
}
