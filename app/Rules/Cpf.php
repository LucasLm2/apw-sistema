<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Cpf implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(!$this->calcCpf($value)) {
            $fail('O campo :attribute não é um CPF válido.');
        }
    }

    private function calcCpf(mixed $value): bool
    {
        $c = preg_replace('/\D/', '', $value);

        if (strlen($c) != 11 || preg_match("/^{$c[0]}{11}$/", $c)) {
            return false;
        }

        for ($s = 10, $n = 0, $i = 0; $s >= 2; $n += $c[$i++] * $s--);
            if ($c[9] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
                return false;
            }

        for ($s = 11, $n = 0, $i = 0; $s >= 2; $n += $c[$i++] * $s--);
            if ($c[10] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
                return false;
            }

        return true;
    }
}
