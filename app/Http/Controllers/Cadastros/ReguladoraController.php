<?php

namespace App\Http\Controllers\Cadastros;

use App\Helpers\ManipulacaoString;
use App\Http\Controllers\Controller;
use App\Models\Reguladora;
use App\Http\Requests\StoreReguladoraRequest;
use App\Http\Requests\UpdateReguladoraRequest;
use App\Models\Endereco\Estado;
use Illuminate\Support\Facades\Cache;

class ReguladoraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reguladoras = Cache::rememberForever('reguladoras', function () {
            return Reguladora::all(['id', 'nome', 'cnpj']);
        });

        return view('cadastros.reguladora.index')
            ->with('reguladoras', $reguladoras);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $estados = Cache::rememberForever('estados', function () {
            return Estado::select(['uf', 'nome'])->orderBy('nome')->get();
        });

        return view('cadastros.reguladora.create-edit')
            ->with('estados', $estados);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFornecedorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReguladoraRequest $request)
    {
        $nome = Reguladora::createAndReturnName((object)$request->all());

        Cache::forget('reguladoras');

        return to_route('cadastro.reguladora.index')
            ->with('success', "Reguladora '{$nome}' adicionada com sucesso.");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reguladora  $reguladora
     * @return \Illuminate\Http\Response
     */
    public function edit(Reguladora $reguladora)
    {
        $estados = Cache::rememberForever('estados', function () {
            return Estado::select(['uf', 'nome'])->orderBy('nome')->get();
        });

        return view('cadastros.reguladora.create-edit')
            ->with('reguladora', $reguladora)
            ->with('estados', $estados);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateReguladoraRequest  $request
     * @param  \App\Models\Reguladora  $reguladora
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReguladoraRequest $request, Reguladora $reguladora)
    {
        $reguladora->nome = $request->nome;
        $reguladora->cnpj = ManipulacaoString::limpaString($request->cnpj);
        $reguladora->save();

        Cache::forget('reguladoras');

        return to_route('cadastro.reguladora.index')
            ->with('success', "Reguladora '{$reguladora->nome}' atualizada com sucesso.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reguladora  $reguladora
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reguladora $reguladora)
    {
        $reguladora->delete();

        Cache::forget('reguladoras');
        
        return to_route('cadastro.reguladora.index')
            ->with('success', "Reguladora '{$reguladora->nome}' excluida com sucesso.");
    }
}
