<?php

namespace App\Models;

use App\Helpers\ManipulacaoString;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Telefone extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'numero', 
        'tabela_referencia',
        'referencia_id',
        'nome_contato'
    ];

    public static function massInsert(array $dadosTelefone, array $dadosContato, string $tabelaReferencia, int $referenciaId): void
    {
        $telefones = [];
        foreach ($dadosTelefone as $index => $telefone) {
            if(empty($telefone))
                continue;

            $telefones[] = [
                'numero' => ManipulacaoString::limpaString($telefone), 
                'tabela_referencia' => $tabelaReferencia, 
                'referencia_id' => $referenciaId, 
                'nome_contato' => $dadosContato[$index]
            ];
        }

        Telefone::insert($telefones);
    }

    public static function allWithReference(string $tabelaReferencia, int $referenciaId): ?Collection
    {
        return Telefone::select('numero', 'nome_contato')
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
