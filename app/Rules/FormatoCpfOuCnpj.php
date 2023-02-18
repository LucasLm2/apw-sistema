<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class FormatoCpfOuCnpj implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $cpf = preg_match('/^\d{3}\.\d{3}\.\d{3}-\d{2}$/', $value) > 0;
        $cnpj = preg_match('/^\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}$/', $value) > 0;
        $result = $cpf  || $cnpj;

        if(!$result) {
            $fail('O campo :attribute não possui o formato válido de CPF ou CNPJ.');
        }
    }
}
