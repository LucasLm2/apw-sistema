<?php

namespace App\Http\Controllers\Cadastros;

use App\Http\Controllers\Controller;
use App\Models\TipoServico;
use App\Http\Requests\StoreTipoServicoRequest;
use App\Http\Requests\UpdateTipoServicoRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;

class TipoServicoController extends Controller
{
    function __construct()
    {
        $this->middleware(
            'permission:tipo-servico-listar|tipo-servico-cadastrar|tipo-servico-editar|tipo-servico-inativar|tipo-servico-deletar', 
            ['only' => ['index','store']]
        );
        $this->middleware('permission:tipo-servico-cadastrar', ['only' => ['create','store']]);
        $this->middleware('permission:tipo-servico-editar', ['only' => ['edit','update']]);
        $this->middleware('permission:tipo-servico-inativar', ['only' => ['inativos','inativarAtivar']]);
        $this->middleware('permission:tipo-servico-deletar', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View 
    {
        $tipoServicos = Cache::rememberForever('tipo-servicos', function () {
            return TipoServico::select(['id', 'nome', 'descricao'])->where('ativo', '=', true)->get();
        });

        return view('cadastros.tipo-servico.index')
            ->with('tipoServicos', $tipoServicos);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('cadastros.tipo-servico.create-edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTipoServicoRequest $request): RedirectResponse
    {
        Cache::forget('tipo-servicos');
        
        $nome = TipoServico::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
        ])->nome;

        return to_route('cadastro.tipo-servico.index')
            ->with('success', "Tipo de servico '{$nome}' adicionado com sucesso.");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TipoServico $tipoServico): View
    {
        return view('cadastros.tipo-servico.create-edit')
            ->with('tipoServico', $tipoServico);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTipoServicoRequest $request, TipoServico $tipoServico): RedirectResponse
    {
        Cache::forget('tipo-servicos');

        $tipoServico->nome = $request->nome;
        $tipoServico->descricao = $request->descricao;
        $tipoServico->save();

        return to_route('cadastro.tipo-servico.index')
            ->with('success', "Tipo de servico '{$tipoServico->nome}' atualizado com sucesso.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoServico $tipoServico): RedirectResponse
    {
        Cache::forget('tipo-servicos-inativos');

        $tipoServico->delete();

        return to_route('cadastro.tipo-servico.inativos')
            ->with('success', "Tipo de servico '{$tipoServico->nome}' excluido com sucesso.");
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function inativos(): View
    {
        $tipoServicos = Cache::rememberForever('tipo-servicos-inativos', function () {
            return TipoServico::select(['id', 'nome', 'descricao'])->where('ativo', '=', false)->get();
        });

        return view('cadastros.tipo-servico.inativos')
            ->with('tipoServicos', $tipoServicos);
    }

    /**
     * Update the specified resource in storage.
     */
    public function inativarAtivar(TipoServico $tipoServico): RedirectResponse
    {
        Cache::forget('tipo-servicos');
        Cache::forget('tipo-servicos-inativos');

        if($tipoServico->ativo) {
            $tipoServico->ativo = false;

            $messagem = "Tipo de serviço '{$tipoServico->nome}' inativado com sucesso.";
        } else {
            $tipoServico->ativo = true;

            $messagem = "Tipo de serviço '{$tipoServico->nome}' ativado com sucesso.";
        }
        
        $tipoServico->save();
        
        return to_route('cadastro.tipo-servico.index')
            ->with('success', $messagem);
    }
}
