<?php

namespace App\Models\Endereco;

use App\Helpers\ManipulacaoString;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    use HasFactory;

    protected $table = 'enderecos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cep',
        'municipio_cod_ibge',
        'bairro_id',
        'rua_id',
        'numero',
        'complemento',
        'latitude',
        'longitude'
    ];


    public static function createAndReturnId(object $dados): int
    {
        $bairroId = Endereco::retornaIdBairro($dados->bairro, $dados->municipio);

        return Endereco::create([
            'cep' => ManipulacaoString::limpaString($dados->cep),
            'municipio_cod_ibge' => $dados->municipio,
            'bairro_id' => $bairroId,
            'rua_id' => Endereco::retornaIdRua($dados->rua, $bairroId),
            'numero' => $dados->numero,
            'complemento' => $dados->complemento,
            'latitude' => null,
            'longitude' => null
        ])->id;
    }

    public static function edit(object $dados, int $enderecoId) 
    {
        $endereco = Endereco::find($enderecoId);
        $endereco->cep = ManipulacaoString::limpaString($dados->cep);
        $endereco->municipio_cod_ibge = $dados->municipio;
        $endereco->bairro_id = Endereco::retornaIdBairro($dados->bairro, $dados->municipio);
        $endereco->rua_id = Endereco::retornaIdRua($dados->rua, $endereco->bairro_id);
        $endereco->numero = $dados->numero;
        $endereco->complemento = $dados->complemento;
        $endereco->save();
    }

    private static function retornaIdBairro(string $bairro, string $municipio): ?int
    {
        $bairroId = null;
        if($bairro != '') {
            $bairroId = Bairro::createAndReturnId($bairro, $municipio);
        }

        return $bairroId;
    }

    private static function retornaIdRua(string $rua, int $bairroId): ?int
    {
        $ruaId = null;
        if($rua != '' && $bairroId != null) {
            $ruaId = Rua::createAndReturnId($rua, $bairroId);
        }

        return $ruaId;
    }
}
