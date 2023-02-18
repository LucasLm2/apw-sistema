<?php

namespace App\Rules;

use App\Helpers\ManipulacaoString;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Eloquent\Model;

class Existe implements ValidationRule
{

    function __construct(private Model $class)
    {}
    
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if($attribute == 'cpf_cnpj') {
            $value = ManipulacaoString::limpaString($value);
        }

        if($this->class::where($attribute, '=', $value)->exists()) {
            $fail('Este CPF ou CNPJ já esta cadastrado. Verifique se não esta inativado.');
        }
    }
}
