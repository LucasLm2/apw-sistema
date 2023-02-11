<?php

namespace App\Models;

use App\Helpers\ManipulacaoString;
use App\Models\Endereco\Endereco;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Reguladora extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'cnpj'
    ];

    public static function createAndReturnName(object $dados): string
    {
        $nome = DB::transaction(function () use($dados) {
            
            $enderecoId = null;
            if($dados->cep != '') {
                $dadosEndereco = Reguladora::formataDadosEndereco($dados);
                $enderecoId = Endereco::createAndReturnId($dadosEndereco);
            }
            
            return Reguladora::create([
                'nome' => $dados->nome,
                'cnpj' => ManipulacaoString::limpaString($dados->cnpj),
                'inscricao_estadual' => $dados->inscricao_estadual,
                'site' => $dados->site,
                'endereco_id' => $enderecoId
            ])->nome;

        }, 5);

        return $nome;
    }

    public static function formataDadosEndereco(object $dados): object
    {
        return (object) [
            'cep' => $dados->cep,
            'municipio' => $dados->municipio,
            'bairro' => $dados->bairro,
            'rua' => $dados->rua,
            'numero' => $dados->numero,
            'complemento' => $dados->complemento
        ];
    }
}
