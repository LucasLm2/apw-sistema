<?php

namespace App\Models\Endereco;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bairro extends Model
{
    use HasFactory;

    protected $table = 'bairros';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome',
        'municipio_cod_ibge',
    ];

    public static function getIdByNome(string $nome): ?int
    {
        return Bairro::select('id')->where('nome', '=', $nome)->first()?->id;
    }

    public static function createAndReturnId(string $nome, string $municipioCodIbge): int 
    {
        return Bairro::firstOrCreate([
            'nome' => $nome,
            'municipio_cod_ibge' => $municipioCodIbge
        ])->id;
    }
}
