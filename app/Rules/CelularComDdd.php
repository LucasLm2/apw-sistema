<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CelularComDdd implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $result = preg_match('/^\(\d{2}\)\s?\d{4,5}-\d{4}$/', $value) > 0;

        if(!$result) {
            $fail('O campo :attribute não é um celular com DDD válido.');
        }
    }
}
