<?php

namespace App\Http\Controllers\Cadastros;

use App\Http\Controllers\Controller;
use App\Models\TipoDespesa;
use App\Http\Requests\StoreTipoDespesaRequest;
use App\Http\Requests\UpdateTipoDespesaRequest;
use Illuminate\Support\Facades\Cache;

class TipoDespesaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipoDespesas = Cache::rememberForever('tipo-despesas', function () {
            return TipoDespesa::select(['id', 'nome', 'descricao'])->where('ativo', '=', true)->get();
        });

        return view('cadastros.tipo-despesa.index')
            ->with('tipoDespesas', $tipoDespesas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cadastros.tipo-despesa.create-edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFornecedorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTipoDespesaRequest $request)
    {
        Cache::forget('tipo-despesas');

        $nome = TipoDespesa::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
        ])->nome;

        return to_route('cadastro.tipo-despesa.index')
            ->with('success', "Tipo de despesa '{$nome}' adicionada com sucesso.");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TipoDespesa  $tipoDespesa
     * @return \Illuminate\Http\Response
     */
    public function edit(TipoDespesa $tipoDespesa)
    {
        return view('cadastros.tipo-despesa.create-edit')
            ->with('tipoDespesa', $tipoDespesa);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTipoDespesaRequest  $request
     * @param  \App\Models\TipoDespesa  $tipoDespesa
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTipoDespesaRequest $request, TipoDespesa $tipoDespesa)
    {
        Cache::forget('tipo-despesas');
        
        $tipoDespesa->nome = $request->nome;
        $tipoDespesa->descricao = $request->descricao;
        $tipoDespesa->save();

        return to_route('cadastro.tipo-despesa.index')
            ->with('success', "Tipo de despesa '{$tipoDespesa->nome}' atualizada com sucesso.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TipoDespesa  $tipoDespesa
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoDespesa $tipoDespesa)
    {
        Cache::forget('tipo-despesas-inativas');
        
        $tipoDespesa->delete();
        
        return to_route('cadastro.tipo-despesa.inativos')
            ->with('success', "Tipo de despesa '{$tipoDespesa->nome}' excluida com sucesso.");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function inativos()
    {
        $tipoDespesas = Cache::rememberForever('tipo-despesas-inativas', function () {
            return TipoDespesa::select(['id', 'nome', 'descricao'])->where('ativo', '=', false)->get();
        });

        return view('cadastros.tipo-despesa.inativos')
            ->with('tipoDespesas', $tipoDespesas);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TipoDespesa  $reguladora
     * @return \Illuminate\Http\Response
     */
    public function inativarAtivar(TipoDespesa $tipoDespesa)
    {
        Cache::forget('tipo-despesas');
        Cache::forget('tipo-despesas-inativas');

        if($tipoDespesa->ativo) {
            $tipoDespesa->ativo = false;

            $messagem = "Tipo de despesa '{$tipoDespesa->nome}' inativada com sucesso.";
        } else {
            $tipoDespesa->ativo = true;

            $messagem = "Tipo de despesa '{$tipoDespesa->nome}' ativada com sucesso.";
        }
        
        $tipoDespesa->save();
        
        return to_route('cadastro.tipo-despesa.index')
            ->with('success', $messagem);
    }
}
