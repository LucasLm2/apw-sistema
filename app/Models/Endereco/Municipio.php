<?php

namespace App\Models\Endereco;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    use HasFactory;

    protected $table = 'municipios';
    protected $primaryKey = 'cod_ibge';
    public $incrementing = false;

    public static function getIdByNome(string $nome): ?int
    {
        return Municipio::select('cod_ibge')->where('nome', '=', $nome)->first()?->id;
    }

    public static function findByEstado(string $estado): ?Collection
    {
        return Municipio::select('municipios.cod_ibge', 'municipios.nome')
            ->join('estados', 'estados.cod_ibge', '=', 'municipios.estado_cod_ibge')
            ->where('estados.uf', '=', $estado)
            ->orderBy('municipios.nome', 'asc')
            ->get();
    }
}
