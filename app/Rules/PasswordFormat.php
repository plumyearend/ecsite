<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * パスワードの形式チェック
 */
class PasswordFormat implements ValidationRule
{
    private const PASSWORD_REGEX = '/^[a-zA-Z0-9#@\-_!?]{8,20}$/';

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match(self::PASSWORD_REGEX, $value)) {
            $fail('validation.password_format')->translate();
        }
    }
}
