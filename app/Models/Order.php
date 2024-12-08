<?php

namespace App\Models;

use App\Enums\Order\Status;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [
        'id',
    ];

    protected function casts(): array
    {
        return [
            'status' => Status::class,
        ];
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function orderAddress()
    {
        return $this->hasOne(OrderAddress::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public static function encodeId(int $id): string
    {
        return base64_encode((string) $id . env('ORDER_ID_SALT'));
    }

    public static function decodeId(string $encodedId): int
    {
        $decodedStr = base64_decode($encodedId);
        if (!str_contains($decodedStr, env('ORDER_ID_SALT'))) {
            return 0;
        }

        return (int) str_replace(env('ORDER_ID_SALT'), '', $decodedStr);
    }
}
