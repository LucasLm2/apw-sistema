<?php

namespace App\Http\Requests;

use App\Models\Cliente;
use App\Rules\Existe;
use Illuminate\Foundation\Http\FormRequest;

class StoreClienteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'razao_social' => [
                'required',
                'string',
                'max:255'
            ],
            'nome_fantasia' => [
                'string',
                'max:255'
            ],
            'cnpj' => [
                'required',
                'string',
                'formato_cnpj',
                'cnpj',
                new Existe(new Cliente())
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
                'formato_cep'
            ],
            'estado' => [
                'nullable', 
                'string', 
                'max:2',
                'uf',
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
                'celular_com_ddd'
            ],
            'emails.*' => [
                'nullable',
                'string',
                'email'
            ]
        ];
    }
}