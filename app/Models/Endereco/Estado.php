<?php

namespace App\Models\Endereco;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    use HasFactory;

    protected $table = 'estados';
    protected $primaryKey = 'cod_ibge';
    public $incrementing = false;

    public static function getIdByUf(string $uf): ?int
    {
        return Estado::select('cod_ibge')
            ->where('uf', $uf)
            ->first()->cod_ibge;
    }
}
