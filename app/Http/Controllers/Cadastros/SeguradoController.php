<?php

namespace App\Http\Controllers\Cadastros;

use App\Http\Controllers\Controller;
use App\Models\Segurado;
use App\Http\Requests\StoreSeguradoRequest;
use App\Http\Requests\UpdateSeguradoRequest;
use Illuminate\Support\Facades\Cache;

class SeguradoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cadastros.segurado.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFornecedorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSeguradoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Segurado  $segurado
     * @return \Illuminate\Http\Response
     */
    public function show(Segurado $segurado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Segurado  $segurado
     * @return \Illuminate\Http\Response
     */
    public function edit(Segurado $segurado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSeguradoRequest  $request
     * @param  \App\Models\Segurado  $segurado
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSeguradoRequest $request, Segurado $segurado)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Segurado  $segurado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Segurado $segurado)
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function inativos()
    {
        $segurados = Cache::rememberForever('segurados-inativos', function () {
            return Segurado::select(['id', 'nome', 'cnpj'])->where('ativo', '=', false)->get();
        });

        return view('cadastros.segurado.inativos')
            ->with('segurados', $segurados);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Segurado  $reguladora
     * @return \Illuminate\Http\Response
     */
    public function inativarAtivar(Segurado $segurado)
    {
        Cache::forget('segurados');
        Cache::forget('segurados-inativos');

        if($segurado->ativo) {
            $segurado->ativo = false;

            $messagem = "Segurado '{$segurado->nome}' inativado com sucesso.";
        } else {
            $segurado->ativo = true;

            $messagem = "Segurado '{$segurado->nome}' ativado com sucesso.";
        }
        
        $segurado->save();
        
        return to_route('cadastro.segurado.index')
            ->with('success', $messagem);
    }
}
