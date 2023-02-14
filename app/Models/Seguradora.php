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
        'nome',
        'cnpj',
        'inscricao_estadual',
        'site',
        'endereco_id'
    ];

    public static function findWithEndereco($id): ?Seguradora
    {
        return Seguradora::select(
                'seguradoras.id',
                'seguradoras.nome',
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
        $nome = DB::transaction(function () use($dados) {
            
            $enderecoId = null;
            if($dados->cep != '') {
                $dadosEndereco = Seguradora::formataDadosEndereco($dados);
                $enderecoId = Endereco::createAndReturnId($dadosEndereco);
            }

            $seguradora = Seguradora::create([
                'nome' => $dados->nome,
                'cnpj' => ManipulacaoString::limpaString($dados->cnpj),
                'inscricao_estadual' => $dados->inscricao_estadual,
                'site' => $dados->site,
                'endereco_id' => $enderecoId
            ]);

            if(isset($dados->telefones) && count($dados->telefones) > 0) {
                Telefone::massInsert($dados->telefones, 'seguradoras', $seguradora->id);
            }

            if(isset($dados->emails) && count($dados->emails) > 0) {
                Email::massInsert($dados->emails, 'seguradoras', $seguradora->id);
            }
            
            return $seguradora->nome;

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

    public static function updateAndReturnName(Seguradora $seguradora, object $dados): string
    {
        $nome = DB::transaction(function () use($dados, $seguradora) {
            
            $seguradora->nome = $dados->nome;
            $seguradora->cnpj = ManipulacaoString::limpaString($dados->cnpj);
            $seguradora->inscricao_estadual = $dados->inscricao_estadual;
            $seguradora->site = $dados->site;

            Telefone::massDelete('seguradoras', $seguradora->id);
            if(isset($dados->telefones) && count($dados->telefones) > 0) {
                Telefone::massInsert($dados->telefones, 'seguradoras', $seguradora->id);
            }

            Email::massDelete('seguradoras', $seguradora->id);
            if(isset($dados->emails) && count($dados->emails) > 0) {
                Email::massInsert($dados->emails, 'seguradoras', $seguradora->id);
            }
    
            if($dados->cep == null) {
                $seguradora->endereco_id = null;
                $seguradora->save();

                return $seguradora->nome;
            }

            if($seguradora->endereco_id == null) {
                $idEndereco = Endereco::createAndReturnId($dados);
                $seguradora->endereco_id = $idEndereco;
    
                $seguradora->save();

                return $seguradora->nome;
            }
        
            Endereco::edit($dados, $seguradora->endereco_id);
    
            $seguradora->save();

            return $seguradora->nome;
        }, 5);

        return $nome;
    }
}
