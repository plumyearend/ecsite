<?php

namespace App\Http\Requests\Login;

use App\Rules\PasswordFormat;
use Illuminate\Foundation\Http\FormRequest;

class AuthenticateRequest extends FormRequest
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
            ],
            'password' => ['bail', 'required', 'max:255', new PasswordFormat],
        ];
    }
}
