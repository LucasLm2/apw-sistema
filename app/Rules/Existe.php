<?php

namespace App\Rules;

use App\Helpers\ManipulacaoString;
use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Database\Eloquent\Model;

class Existe implements InvokableRule
{
    function __construct(private Model $class)
    {}

    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        if($attribute == 'cnpj') {
            $value = ManipulacaoString::limpaString($value);
        }

        if($this->class::where($attribute, '=', $value)->exists()) {
            $fail('Este :attribute já esta cadastrado. Verifique se não esta inativado.');
        }
    }
}
