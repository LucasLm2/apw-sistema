<?php

namespace App\Models;

use App\Helpers\ManipulacaoString;
use App\Models\Endereco\Endereco;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Segurado extends Model
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

    public static function findWithEndereco($id): ?Segurado
    {
        return Segurado::select(
                'segurados.id',
                'segurados.nome',
                'segurados.cnpj',
                'segurados.inscricao_estadual',
                'segurados.site',
                'enderecos.id as endereco_id', 
                'enderecos.cep', 
                'enderecos.numero',
                'enderecos.complemento',
                'ruas.nome as rua', 
                'bairros.nome as bairro', 
                'municipios.cod_ibge as municipio',
                'estados.uf as estado'
            )->leftJoin('enderecos', 'enderecos.id', '=', 'segurados.endereco_id')
            ->leftJoin('ruas', 'ruas.id', '=', 'enderecos.rua_id')
            ->leftJoin('bairros', 'bairros.id', '=', 'enderecos.bairro_id')
            ->leftJoin('municipios', 'municipios.cod_ibge', '=', 'enderecos.municipio_cod_ibge')
            ->leftJoin('estados', 'estados.cod_ibge', '=', 'municipios.estado_cod_ibge')
            ->where('segurados.id', $id)
            ->first();
    }

    public static function createAndReturnName(object $dados): string
    {
        $nome = DB::transaction(function () use($dados) {
            
            $enderecoId = null;
            if($dados->cep != '') {
                $dadosEndereco = Segurado::formataDadosEndereco($dados);
                $enderecoId = Endereco::createAndReturnId($dadosEndereco);
            }

            $segurado = Segurado::create([
                'nome' => $dados->nome,
                'cnpj' => ManipulacaoString::limpaString($dados->cnpj),
                'inscricao_estadual' => $dados->inscricao_estadual,
                'site' => $dados->site,
                'endereco_id' => $enderecoId
            ]);

            if(isset($dados->telefones) && count($dados->telefones) > 0) {
                Telefone::massInsert($dados->telefones, 'segurados', $segurado->id);
            }

            if(isset($dados->emails) && count($dados->emails) > 0) {
                Email::massInsert($dados->emails, 'segurados', $segurado->id);
            }
            
            return $segurado->nome;

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

    public static function updateAndReturnName(Segurado $segurado, object $dados): string
    {
        $nome = DB::transaction(function () use($dados, $segurado) {
            
            $segurado->nome = $dados->nome;
            $segurado->cnpj = ManipulacaoString::limpaString($dados->cnpj);
            $segurado->inscricao_estadual = $dados->inscricao_estadual;
            $segurado->site = $dados->site;

            Telefone::massDelete('segurados', $segurado->id);
            if(isset($dados->telefones) && count($dados->telefones) > 0) {
                Telefone::massInsert($dados->telefones, 'segurados', $segurado->id);
            }

            Email::massDelete('segurados', $segurado->id);
            if(isset($dados->emails) && count($dados->emails) > 0) {
                Email::massInsert($dados->emails, 'segurados', $segurado->id);
            }
    
            if($dados->cep == null) {
                $segurado->endereco_id = null;
                $segurado->save();

                return $segurado->nome;
            }

            if($segurado->endereco_id == null) {
                $idEndereco = Endereco::createAndReturnId($dados);
                $segurado->endereco_id = $idEndereco;
    
                $segurado->save();

                return $segurado->nome;
            }
        
            Endereco::edit($dados, $segurado->endereco_id);
    
            $segurado->save();

            return $segurado->nome;
        }, 5);

        return $nome;
    }
}
