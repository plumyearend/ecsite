<?php

namespace App\Http\Requests\SignUp;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => [
                'bail',
                'required',
                'max:255',
                app()->environment('local')
                    ? 'email:dns,strict,spoof'
                    : 'email',
                'unique:users',
            ],
            'accepts' => ['bail', 'required'],
        ];
    }
}
