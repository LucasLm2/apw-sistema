<?php

namespace App\Models\Endereco;

use App\Helpers\Helper;
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
        'regiao_cod_ibge',
        'estado_cod_ibge',
        'municipio_cod_ibge',
        'bairro_id',
        'rua_id',
        'numero',
        'complemento',
        'latitude',
        'longitude'
    ];

    public static function find($id): Endereco|null
    {
        return Endereco::select(
                'enderecos.cep', 
                'enderecos.numero',
                'enderecos.complemento',
                'ruas.nome as logradouro', 
                'bairros.nome as bairro', 
                'municipios.nome as municipio',
                'estados.uf as uf_sigla', 
                'estados.nome as uf_nome'
            )->Join('ruas', 'ruas.id', '=', 'enderecos.rua_id')
            ->Join('bairros', 'bairros.id', '=', 'enderecos.bairro_id')
            ->join('municipios', 'municipios.cod_ibge', '=', 'enderecos.municipio_cod_ibge')
            ->join('estados', 'estados.cod_ibge', '=', 'enderecos.estado_cod_ibge')
            ->where('enderecos.id', $id)
            ->first();
    }

    public static function createAndReturnId(array $infEndereco): int 
    {
        return Endereco::create($infEndereco)->id;
    }
}
