<?php

namespace App\Http\Controllers\Cadastros;

use App\Http\Controllers\Controller;
use App\Models\TipoServico;
use App\Http\Requests\StoreTipoServicoRequest;
use App\Http\Requests\UpdateTipoServicoRequest;
use Illuminate\Support\Facades\Cache;

class TipoServicoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipoServicos = Cache::rememberForever('tipo-servicos', function () {
            return TipoServico::select(['id', 'nome', 'descricao'])->where('ativo', '=', true)->get();
        });

        return view('cadastros.tipo-servico.index')
            ->with('tipoServicos', $tipoServicos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cadastros.tipo-servico.create-edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFornecedorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTipoServicoRequest $request)
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
     *
     * @param  \App\Models\TipoServico  $tipoServico
     * @return \Illuminate\Http\Response
     */
    public function edit(TipoServico $tipoServico)
    {
        return view('cadastros.tipo-servico.create-edit')
            ->with('tipoServico', $tipoServico);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTipoServicoRequest  $request
     * @param  \App\Models\TipoServico  $tipoServico
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTipoServicoRequest $request, TipoServico $tipoServico)
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
     *
     * @param  \App\Models\TipoServico  $tipoServico
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoServico $tipoServico)
    {
        Cache::forget('tipo-servicos-inativos');

        $tipoServico->delete();

        return to_route('cadastro.tipo-servico.index')
            ->with('success', "Tipo de servico '{$tipoServico->nome}' excluido com sucesso.");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function inativos()
    {
        $tipoServicos = Cache::rememberForever('tipo-servicos-inativos', function () {
            return TipoServico::select(['id', 'nome', 'descricao'])->where('ativo', '=', false)->get();
        });

        return view('cadastros.tipo-servico.inativos')
            ->with('tipoServicos', $tipoServicos);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TipoServico  $reguladora
     * @return \Illuminate\Http\Response
     */
    public function inativarAtivar(TipoServico $tipoServico)
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
