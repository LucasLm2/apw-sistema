<?php

namespace App\Models;

use App\Helpers\ManipulacaoString;
use App\Models\Endereco\Endereco;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cliente extends Model
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

    public static function findWithEndereco($id): ?Cliente
    {
        return Cliente::select(
                'clientes.id',
                'clientes.razao_social',
                'clientes.nome_fantasia',
                'clientes.cnpj',
                'clientes.inscricao_estadual',
                'clientes.site',
                'enderecos.id as endereco_id', 
                'enderecos.cep', 
                'enderecos.numero',
                'enderecos.complemento',
                'ruas.nome as rua', 
                'bairros.nome as bairro', 
                'municipios.cod_ibge as municipio',
                'estados.uf as estado'
            )->leftJoin('enderecos', 'enderecos.id', '=', 'clientes.endereco_id')
            ->leftJoin('ruas', 'ruas.id', '=', 'enderecos.rua_id')
            ->leftJoin('bairros', 'bairros.id', '=', 'enderecos.bairro_id')
            ->leftJoin('municipios', 'municipios.cod_ibge', '=', 'enderecos.municipio_cod_ibge')
            ->leftJoin('estados', 'estados.cod_ibge', '=', 'municipios.estado_cod_ibge')
            ->where('clientes.id', $id)
            ->first();
    }

    public static function createAndReturnName(object $dados): string
    {
        $razaoSocial = DB::transaction(function () use($dados) {
            
            $enderecoId = null;
            if($dados->cep != '') {
                $dadosEndereco = Cliente::formataDadosEndereco($dados);
                $enderecoId = Endereco::createAndReturnId($dadosEndereco);
            }

            $cliente = Cliente::create([
                'razao_social' => $dados->razao_social,
                'nome_fantasia' => $dados->nome_fantasia,
                'cnpj' => ManipulacaoString::limpaString($dados->cnpj),
                'inscricao_estadual' => $dados->inscricao_estadual,
                'site' => $dados->site,
                'endereco_id' => $enderecoId
            ]);

            if(isset($dados->telefones) && count($dados->telefones) > 0) {
                Telefone::massInsert($dados->telefones, $dados->telefones_contatos, 'clientes', $cliente->id);
            }

            if(isset($dados->emails) && count($dados->emails) > 0) {
                Email::massInsert($dados->emails, $dados->emails_contatos, 'clientes', $cliente->id);
            }
            
            return $cliente->razao_social;

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

    public static function updateAndReturnName(Cliente $cliente, object $dados): string
    {
        $razaoSocial = DB::transaction(function () use($dados, $cliente) {
            
            $cliente->razao_social = $dados->razao_social;
            $cliente->nome_fantasia = $dados->nome_fantasia;
            $cliente->cnpj = ManipulacaoString::limpaString($dados->cnpj);
            $cliente->inscricao_estadual = $dados->inscricao_estadual;
            $cliente->site = $dados->site;

            Telefone::massDelete('clientes', $cliente->id);
            if(isset($dados->telefones) && count($dados->telefones) > 0) {
                Telefone::massInsert($dados->telefones, $dados->telefones_contatos, 'clientes', $cliente->id);
            }

            Email::massDelete('clientes', $cliente->id);
            if(isset($dados->emails) && count($dados->emails) > 0) {
                Email::massInsert($dados->emails, $dados->emails_contatos, 'clientes', $cliente->id);
            }
    
            if($dados->cep == null) {
                $cliente->endereco_id = null;
                $cliente->save();

                return $cliente->razao_social;
            }

            if($cliente->endereco_id == null) {
                $idEndereco = Endereco::createAndReturnId($dados);
                $cliente->endereco_id = $idEndereco;
    
                $cliente->save();

                return $cliente->razao_social;
            }
        
            Endereco::edit($dados, $cliente->endereco_id);
    
            $cliente->save();

            return $cliente->razao_social;
        }, 5);

        return $razaoSocial;
    }
}
