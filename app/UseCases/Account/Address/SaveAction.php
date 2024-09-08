<?php

namespace App\UseCases\Account\Address;

use App\Models\Address;
use Illuminate\Support\Facades\Auth;

class SaveAction
{
    public function __invoke(array $data): ?Address
    {
        $user = Auth::guard('web')->user();
        $existsUser = Address::query()
            ->where('user_id', $user->id)
            ->exists();

        // TODO: 編集実装時にupdateOrCreateへ変更
        $address = Address::create([
            'user_id' => Auth::guard('web')->user()->id,
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'postcode' => $data['postcode'],
            'prefecture_id' => $data['prefecture_id'],
            'address1' => $data['address1'],
            'address2' => $data['address2'],
            'address3' => $data['address3'],
            'tel' => $data['tel'],
            'is_default_adress' => $existsUser ? $data['is_default_adress'] : true,
        ]);

        return $address;
    }
}
