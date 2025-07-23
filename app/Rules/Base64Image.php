<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class Base64Image implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        if (!Str::startsWith($value, ['data:image/png;base64', 'data:image/jpeg;base64'])) {
            $fail(':attribute must be a base64 image (png or jpeg) starting with the corresponding data: prefix');
        }
    }
}
