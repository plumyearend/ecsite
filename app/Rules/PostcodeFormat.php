<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * 郵便番号の形式チェック
 */
class PostcodeFormat implements ValidationRule
{
    private const POSTCODE_REGEX = '/^\d{7}$/';

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match(self::POSTCODE_REGEX, $value)) {
            $fail('validation.postcode_format')->translate();
        }
    }
}
