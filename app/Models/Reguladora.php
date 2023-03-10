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
     * @var array
     */
    protected $fillable = [
        'razao_social', 
        'nome_fantasia',
        'cnpj',
        'inscricao_estadual',
        'site',
        'endereco_id'
    ];

    public static function findWithEndereco($id): ?Reguladora
    {
        return Reguladora::select(
                'reguladoras.id',
                'reguladoras.razao_social',
                'reguladoras.nome_fantasia',
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
        $razaoSocial = DB::transaction(function () use($dados) {
            
            $enderecoId = null;
            if($dados->cep != '') {
                $dadosEndereco = Reguladora::formataDadosEndereco($dados);
                $enderecoId = Endereco::createAndReturnId($dadosEndereco);
            }

            $reguladora = Reguladora::create([
                'razao_social' => $dados->razao_social,
                'nome_fantasia' => $dados->nome_fantasia,
                'cnpj' => ManipulacaoString::limpaString($dados->cnpj),
                'inscricao_estadual' => $dados->inscricao_estadual,
                'site' => $dados->site,
                'endereco_id' => $enderecoId
            ]);

            if(isset($dados->telefones) && count($dados->telefones) > 0) {
                Telefone::massInsert($dados->telefones, $dados->telefones_contatos, 'reguladoras', $reguladora->id);
            }

            if(isset($dados->emails) && count($dados->emails) > 0) {
                Email::massInsert($dados->emails, $dados->emails_contatos, 'reguladoras', $reguladora->id);
            }
            
            return $reguladora->razao_social;

        }, 5);

        return $razaoSocial;
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

    public static function updateAndReturnName(Reguladora $reguladora, object $dados): string
    {
        $razaoSocial = DB::transaction(function () use($dados, $reguladora) {
            
            $reguladora->razao_social = $dados->razao_social;
            $reguladora->nome_fantasia = $dados->nome_fantasia;
            $reguladora->cnpj = ManipulacaoString::limpaString($dados->cnpj);
            $reguladora->inscricao_estadual = $dados->inscricao_estadual;
            $reguladora->site = $dados->site;

            Telefone::massDelete('reguladoras', $reguladora->id);
            if(isset($dados->telefones) && count($dados->telefones) > 0) {
                Telefone::massInsert($dados->telefones, $dados->telefones_contatos, 'reguladoras', $reguladora->id);
            }

            Email::massDelete('reguladoras', $reguladora->id);
            if(isset($dados->emails) && count($dados->emails) > 0) {
                Email::massInsert($dados->emails, $dados->emails_contatos, 'reguladoras', $reguladora->id);
            }
    
            if($dados->cep == null) {
                $reguladora->endereco_id = null;
                $reguladora->save();

                return $reguladora->razao_social;
            }

            if($reguladora->endereco_id == null) {
                $idEndereco = Endereco::createAndReturnId($dados);
                $reguladora->endereco_id = $idEndereco;
    
                $reguladora->save();

                return $reguladora->razao_social;
            }
        
            Endereco::edit($dados, $reguladora->endereco_id);
    
            $reguladora->save();

            return $reguladora->razao_social;
        }, 5);

        return $razaoSocial;
    }
}
