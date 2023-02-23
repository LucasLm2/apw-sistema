<?php

namespace App\Http\Controllers\Cadastros;

use App\Http\Controllers\Controller;
use App\Models\TipoDespesa;
use App\Http\Requests\StoreTipoDespesaRequest;
use App\Http\Requests\UpdateTipoDespesaRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;

class TipoDespesaController extends Controller
{
    function __construct()
    {
        $this->middleware(
            'permission:tipo-despesa-listar|tipo-despesa-cadastrar|tipo-despesa-editar|tipo-despesa-inativar|tipo-despesa-deletar', 
            ['only' => ['index','store']]
        );
        $this->middleware('permission:tipo-despesa-cadastrar', ['only' => ['create','store']]);
        $this->middleware('permission:tipo-despesa-editar', ['only' => ['edit','update']]);
        $this->middleware('permission:tipo-despesa-inativar', ['only' => ['inativos','inativarAtivar']]);
        $this->middleware('permission:tipo-despesa-deletar', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $tipoDespesas = Cache::rememberForever('tipo-despesas', function () {
            return TipoDespesa::select(['id', 'nome', 'descricao'])->where('ativo', '=', true)->get();
        });

        return view('cadastros.tipo-despesa.index')
            ->with('tipoDespesas', $tipoDespesas);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('cadastros.tipo-despesa.create-edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTipoDespesaRequest $request): RedirectResponse
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
     */
    public function edit(TipoDespesa $tipoDespesa): View
    {
        return view('cadastros.tipo-despesa.create-edit')
            ->with('tipoDespesa', $tipoDespesa);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTipoDespesaRequest $request, TipoDespesa $tipoDespesa): RedirectResponse
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
     */
    public function destroy(TipoDespesa $tipoDespesa): RedirectResponse
    {
        Cache::forget('tipo-despesas-inativas');
        
        $tipoDespesa->delete();
        
        return to_route('cadastro.tipo-despesa.inativos')
            ->with('success', "Tipo de despesa '{$tipoDespesa->nome}' excluida com sucesso.");
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function inativos(): View
    {
        $tipoDespesas = Cache::rememberForever('tipo-despesas-inativas', function () {
            return TipoDespesa::select(['id', 'nome', 'descricao'])->where('ativo', '=', false)->get();
        });

        return view('cadastros.tipo-despesa.inativos')
            ->with('tipoDespesas', $tipoDespesas);
    }

    /**
     * Update the specified resource in storage.
     */
    public function inativarAtivar(TipoDespesa $tipoDespesa): RedirectResponse
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
