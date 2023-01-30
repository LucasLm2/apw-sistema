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
        $tipoServicos = Cache::rememberForever('tipoServicos', function () {
            return TipoServico::all(['id', 'nome', 'descricao']);
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
        $nome = TipoServico::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
        ])->nome;

        Cache::forget('tipoServicos');

        return to_route('cadastro.tipo-servico.index')
            ->with('sucesso', "Tipo de servico '{$nome}' adicionada com sucesso.");
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
        $tipoServico->nome = $request->nome;
        $tipoServico->descricao = $request->descricao;
        $tipoServico->save();

        Cache::forget('tipoServicos');

        return to_route('cadastro.tipo-servico.index')
            ->with('sucesso', "Tipo de servico '{$tipoServico->nome}' atualizada com sucesso.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TipoServico  $tipoServico
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoServico $tipoServico)
    {
        $tipoServico->delete();

        Cache::forget('tipoServicos');

        return to_route('cadastro.tipo-servico.index')
            ->with('sucesso', "Tipo de servico '{$tipoServico->nome}' deletada com sucesso.");
    }
}
