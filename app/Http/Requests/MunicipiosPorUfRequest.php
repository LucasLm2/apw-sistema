<?php

namespace App\Http\Requests;

use App\Rules\Uf;
use Illuminate\Foundation\Http\FormRequest;

class MunicipiosPorUfRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     *
     */
    protected function prepareForValidation(): void
    {
        $parametros = $this->route()->parameters();
        $parametros['uf'] = strtoupper($parametros['uf']);
        $this->merge($parametros);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'uf' => [
                'required',
                new Uf(),
            ]
        ];
    }
}