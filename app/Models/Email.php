<?php

namespace App\Models;

use App\Helpers\ManipulacaoString;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory;

    public static function massInsert(array $dados, string $tabelaReferencia, int $referenciaId): void
    {
        $emails = [];
        foreach ($dados as $email) {
            if(empty($email))
                continue;

            $emails[] = [
                'email' => ManipulacaoString::limpaString($email), 
                'tabela_referencia' => $tabelaReferencia, 
                'referencia_id' => $referenciaId
            ];
        }

        Email::insert($emails);
    }

    public static function allWithReference(string $tabelaReferencia, int $referenciaId): ?Collection
    {
        return Email::select('email')
                ->where('tabela_referencia', '=', $tabelaReferencia)
                ->where('referencia_id', '=', $referenciaId)
                ->get();
    }

    public static function massDelete(string $tabelaReferencia, int $referenciaId): void
    {
        Email::where('tabela_referencia', '=', $tabelaReferencia)
            ->where('referencia_id', '=', $referenciaId)
            ->delete();
    }
}
