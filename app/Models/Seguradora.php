<?php

namespace App\Models;

use App\Helpers\ManipulacaoString;
use App\Models\Endereco\Endereco;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Seguradora extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'razao_social', 
        'nome_fantasia',
        'cnpj',
        'inscricao_estadual',
        'site',
        'endereco_id'
    ];

    public static function findWithEndereco($id): ?Seguradora
    {
        return Seguradora::select(
                'seguradoras.id',
                'seguradoras.razao_social',
                'seguradoras.nome_fantasia',
                'seguradoras.cnpj',
                'seguradoras.inscricao_estadual',
                'seguradoras.site',
                'enderecos.id as endereco_id', 
                'enderecos.cep', 
                'enderecos.numero',
                'enderecos.complemento',
                'ruas.nome as rua', 
                'bairros.nome as bairro', 
                'municipios.cod_ibge as municipio',
                'estados.uf as estado'
            )->leftJoin('enderecos', 'enderecos.id', '=', 'seguradoras.endereco_id')
            ->leftJoin('ruas', 'ruas.id', '=', 'enderecos.rua_id')
            ->leftJoin('bairros', 'bairros.id', '=', 'enderecos.bairro_id')
            ->leftJoin('municipios', 'municipios.cod_ibge', '=', 'enderecos.municipio_cod_ibge')
            ->leftJoin('estados', 'estados.cod_ibge', '=', 'municipios.estado_cod_ibge')
            ->where('seguradoras.id', $id)
            ->first();
    }

    public static function createAndReturnName(object $dados): string
    {
        $razaoSocial = DB::transaction(function () use($dados) {
            
            $enderecoId = null;
            if($dados->cep != '') {
                $dadosEndereco = Seguradora::formataDadosEndereco($dados);
                $enderecoId = Endereco::createAndReturnId($dadosEndereco);
            }

            $seguradora = Seguradora::create([
                'razao_social' => $dados->razao_social,
                'nome_fantasia' => $dados->nome_fantasia,
                'cnpj' => ManipulacaoString::limpaString($dados->cnpj),
                'inscricao_estadual' => $dados->inscricao_estadual,
                'site' => $dados->site,
                'endereco_id' => $enderecoId
            ]);

            if(isset($dados->telefones) && count($dados->telefones) > 0) {
                Telefone::massInsert($dados->telefones, $dados->telefones_contatos, 'seguradoras', $seguradora->id);
            }

            if(isset($dados->emails) && count($dados->emails) > 0) {
                Email::massInsert($dados->emails, $dados->emails_contatos, 'seguradoras', $seguradora->id);
            }
            
            return $seguradora->razao_social;

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

    public static function updateAndReturnName(Seguradora $seguradora, object $dados): string
    {
        $razaoSocial = DB::transaction(function () use($dados, $seguradora) {
            
            $seguradora->razao_social = $dados->razao_social;
            $seguradora->nome_fantasia = $dados->nome_fantasia;
            $seguradora->cnpj = ManipulacaoString::limpaString($dados->cnpj);
            $seguradora->inscricao_estadual = $dados->inscricao_estadual;
            $seguradora->site = $dados->site;

            Telefone::massDelete('seguradoras', $seguradora->id);
            if(isset($dados->telefones) && count($dados->telefones) > 0) {
                Telefone::massInsert($dados->telefones, $dados->telefones_contatos, 'seguradoras', $seguradora->id);
            }

            Email::massDelete('seguradoras', $seguradora->id);
            if(isset($dados->emails) && count($dados->emails) > 0) {
                Email::massInsert($dados->emails, $dados->emails_contatos, 'seguradoras', $seguradora->id);
            }
    
            if($dados->cep == null) {
                $seguradora->endereco_id = null;
                $seguradora->save();

                return $seguradora->razao_social;
            }

            if($seguradora->endereco_id == null) {
                $idEndereco = Endereco::createAndReturnId($dados);
                $seguradora->endereco_id = $idEndereco;
    
                $seguradora->save();

                return $seguradora->razao_social;
            }
        
            Endereco::edit($dados, $seguradora->endereco_id);
    
            $seguradora->save();

            return $seguradora->razao_social;
        }, 5);

        return $razaoSocial;
    }
}
