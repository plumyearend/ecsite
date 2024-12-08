<?php

namespace App\Http\Requests\Checkout;

use App\Rules\PostcodeFormat;
use App\Rules\TelFormat;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'stripe_intent_id' => ['bail', 'required', 'string', 'max:100'],
            'stripe_method_id' => ['bail', 'required', 'string', 'max:100'],
        ];
    }
}
