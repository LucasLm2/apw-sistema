<?php

namespace App\Models;

use App\Helpers\ManipulacaoString;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Telefone extends Model
{
    use HasFactory;

    public static function massInsert(array $dados, string $tabelaReferencia, int $referenciaId): void
    {
        $telefones = [];
        foreach ($dados as $telefone) {
            if(empty($telefone))
                continue;

            $telefones[] = [
                'numero' => ManipulacaoString::limpaString($telefone), 
                'tabela_referencia' => $tabelaReferencia, 
                'referencia_id' => $referenciaId
            ];
        }

        Telefone::insert($telefones);
    }

    public static function allWithReference(string $tabelaReferencia, int $referenciaId): ?Collection
    {
        return Telefone::select('numero')
                ->where('tabela_referencia', '=', $tabelaReferencia)
                ->where('referencia_id', '=', $referenciaId)
                ->get();
    }

    public static function massDelete(string $tabelaReferencia, int $referenciaId): void
    {
        Telefone::where('tabela_referencia', '=', $tabelaReferencia)
            ->where('referencia_id', '=', $referenciaId)
            ->delete();
    }
}
