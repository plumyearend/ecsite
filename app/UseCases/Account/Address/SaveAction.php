<?php

namespace App\UseCases\Account\Address;

use App\Models\Address;
use Illuminate\Support\Facades\Auth;

class SaveAction
{
    public function __invoke(array $data, Address $address = null): ?Address
    {
        $user = Auth::guard('web')->user();
        $existsDefaultAddress = Address::query()
            ->where('user_id', $user->id)
            ->where('is_default_address', true)
            ->exists();

        $insertData = [
            'user_id' => Auth::guard('web')->user()->id,
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'postcode' => $data['postcode'],
            'prefecture_id' => $data['prefecture_id'],
            'address1' => $data['address1'],
            'address2' => $data['address2'],
            'address3' => $data['address3'] ?? null,
            'tel' => $data['tel'],
            'is_default_address' => $data['is_default_address'] ?? false,
        ];
        if ($existsDefaultAddress) {
            $insertData['is_default_address'] = true;
        }
        $updateAddress = Address::updateOrCreate(['id' => $address ? $address->id : null], $insertData);

        if (isset($data['is_default_address']) && $data['is_default_address']) {
            Address::query()
                ->whereNot('id', $updateAddress->id)
                ->where('user_id', $user->id)
                ->where('is_default_address', true)
                ->update([
                    'is_default_address' => false,
                ]);
        }

        return $updateAddress;
    }
}
