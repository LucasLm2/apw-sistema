<?php

namespace App\Models;

use App\Helpers\ManipulacaoString;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email', 
        'tabela_referencia',
        'referencia_id',
        'nome_contato'
    ];

    public static function massInsert(array $dados, array $dadosContato, string $tabelaReferencia, int $referenciaId): void
    {
        $emails = [];
        foreach ($dados as $index => $email) {
            if(empty($email))
                continue;

            $emails[] = [
                'email' => ManipulacaoString::limpaString($email), 
                'tabela_referencia' => $tabelaReferencia, 
                'referencia_id' => $referenciaId, 
                'nome_contato' => $dadosContato[$index]
            ];
        }

        Email::insert($emails);
    }

    public static function allWithReference(string $tabelaReferencia, int $referenciaId): ?Collection
    {
        return Email::select('email', 'nome_contato')
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
