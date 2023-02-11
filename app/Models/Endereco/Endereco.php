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
        $bairroId = null;
        if($dados->bairro != '') {
            $bairroId = Bairro::createAndReturnId($dados->bairro, $dados->municipio);
        }

        $ruaId = null;
        if($dados->rua != '' && $bairroId != null) {
            $ruaId = Rua::createAndReturnId($dados->rua, $bairroId);
        }

        return Endereco::create([
            'cep' => ManipulacaoString::limpaString($dados->cep),
            'municipio_cod_ibge' => $dados->municipio,
            'bairro_id' => $bairroId,
            'rua_id' => $ruaId,
            'numero' => $dados->numero,
            'complemento' => $dados->complemento,
            'latitude' => null,
            'longitude' => null
        ])->id;
    }
}
