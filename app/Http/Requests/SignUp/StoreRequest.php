<?php

namespace App\Http\Requests\SignUp;

use App\Rules\PasswordFormat;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['bail', 'required', 'string', 'max:100'],
            'password' => ['bail', 'required', 'max:255', new PasswordFormat, 'confirmed'],
        ];
    }
}
