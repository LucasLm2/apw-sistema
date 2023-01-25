<?php

namespace App\Models\Endereco;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rua extends Model
{
    use HasFactory;

    protected $table = 'ruas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome',
        'bairro_id',
    ];

    public static function getIdByNome(string $nome): int|null
    {
        return Rua::select('id')->where('nome', '=', $nome)->first()?->id;
    }

    public static function createAndReturnId(string $nome, string $bairroId): int 
    {
        return Rua::firstOrCreate([
            'nome' => $nome,
            'bairro_id' => $bairroId
        ])->id;
    }
}
