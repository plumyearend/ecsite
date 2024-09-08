<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * 電話番号の形式チェック
 */
class TelFormat implements ValidationRule
{
    private const TEL_REGEX = '/^0[0-9]{9,10}$/';

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match(self::TEL_REGEX, $value)) {
            $fail('validation.tel_format')->translate();
        }
    }
}
