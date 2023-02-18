<?php

namespace App\Http\Requests;

use App\Rules\CelularComDdd;
use App\Rules\Cnpj;
use App\Rules\FormatoCep;
use App\Rules\FormatoCnpj;
use App\Rules\Uf;
use Illuminate\Foundation\Http\FormRequest;

class UpdateReguladoraRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'razao_social' => [
                'required',
                'string',
                'max:255'
            ],
            'nome_fantasia' => [
                'nullable',
                'string',
                'max:255'
            ],
            'cnpj' => [
                'required',
                'string',
                new FormatoCnpj(),
                new Cnpj(),
            ],
            'inscricao_estadual' => [
                'nullable',
                'string',
                'max:255'
            ],
            'site' => [
                'nullable', 
                'string',
                'max:255'
            ],
            'cep' => [
                'nullable', 
                'string', 
                'max:10',
                new FormatoCep()
            ],
            'estado' => [
                'nullable', 
                'string', 
                'max:2',
                new Uf(),
            ],
            'municipio' => [
                'nullable', 
                'string', 
                'max:75',
            ],
            'bairro' => [
                'nullable', 
                'string', 
                'max:120',
            ],
            'rua' => [
                'nullable', 
                'string', 
                'max:120',
            ],
            'numero' => [
                'nullable', 
                'string',
                'max:7'
            ],
            'complemento' => [
                'nullable', 
                'string',
                'max:255'
            ],
            'telefones.*' => [
                'nullable',
                'string',
                new CelularComDdd()
            ],
            'emails.*' => [
                'nullable',
                'string',
                'email'
            ]
        ];
    }
}
