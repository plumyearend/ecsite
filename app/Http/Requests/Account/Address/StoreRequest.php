<?php

namespace App\Http\Requests\Account\Address;

use App\Rules\PostcodeFormat;
use App\Rules\TelFormat;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'last_name' => ['bail', 'required', 'string', 'max:100'],
            'first_name' => ['bail', 'required', 'string', 'max:100'],
            'postcode' => ['bail', 'required', new PostcodeFormat],
            'prefecture_id' => ['bail', 'required', 'exists:prefectures,id'],
            'address1' => ['bail', 'required', 'string', 'max:100'],
            'address2' => ['bail', 'nullable', 'string', 'max:100'],
            'address3' => ['bail', 'nullable', 'string', 'max:100'],
            'tel' => ['bail', 'required', new TelFormat],
            'is_default_adress' => ['bail', 'nullable', 'in:0,1'],
        ];
    }
}
