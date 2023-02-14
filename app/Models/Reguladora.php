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
        'cnpj',
        'inscricao_estadual',
        'site',
        'endereco_id'
    ];

    public static function findWithEndereco($id): Reguladora|null
    {
        return Reguladora::select(
                'reguladoras.id',
                'reguladoras.nome',
                'reguladoras.cnpj',
                'reguladoras.inscricao_estadual',
                'reguladoras.site',
                'enderecos.id as endereco_id', 
                'enderecos.cep', 
                'enderecos.numero',
                'enderecos.complemento',
                'ruas.nome as rua', 
                'bairros.nome as bairro', 
                'municipios.cod_ibge as municipio',
                'estados.uf as estado'
            )->leftJoin('enderecos', 'enderecos.id', '=', 'reguladoras.endereco_id')
            ->leftJoin('ruas', 'ruas.id', '=', 'enderecos.rua_id')
            ->leftJoin('bairros', 'bairros.id', '=', 'enderecos.bairro_id')
            ->leftJoin('municipios', 'municipios.cod_ibge', '=', 'enderecos.municipio_cod_ibge')
            ->leftJoin('estados', 'estados.cod_ibge', '=', 'municipios.estado_cod_ibge')
            ->where('reguladoras.id', $id)
            ->first();
    }

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
