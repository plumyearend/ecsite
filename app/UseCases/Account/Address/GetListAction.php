<?php

namespace App\UseCases\Account\Address;

use App\Models\Address;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class GetListAction
{
    public function __invoke(): Collection
    {
        $user = Auth::guard('web')->user();
        $addresses = Address::query()
            ->select([
                'id',
                'first_name',
                'last_name',
                'postcode',
                'prefecture_id',
                'address1',
                'address2',
                'address3',
                'tel',
                'is_default_address',
            ])
            ->where('user_id', $user->id)
            ->orderBy('id')
            ->get();

        return $addresses;
    }
}
