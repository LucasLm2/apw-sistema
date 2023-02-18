<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class FormatoCpf implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $result = preg_match('/^\d{3}\.\d{3}\.\d{3}-\d{2}$/', $value) > 0;
        
        if(!$result) {
            $fail('O campo :attribute não possui o formato válido de CPF.');
        }
    }
}
