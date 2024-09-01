<?php

namespace App\Http\Requests\SignUp;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['bail', 'required', 'max:255', 'email:dns,strict,spoof', 'unique:users'],
            'accepts' => ['bail', 'required'],
        ];
    }
}
