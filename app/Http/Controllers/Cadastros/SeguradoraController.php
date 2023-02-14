<?php

namespace App\Http\Controllers\Cadastros;

use App\Http\Controllers\Controller;
use App\Models\Seguradora;
use App\Http\Requests\StoreSeguradoraRequest;
use App\Http\Requests\UpdateSeguradoraRequest;
use Illuminate\Support\Facades\Cache;

class SeguradoraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cadastros.seguradora.index');
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
    public function store(StoreSeguradoraRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Seguradora  $seguradora
     * @return \Illuminate\Http\Response
     */
    public function show(Seguradora $seguradora)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Seguradora  $seguradora
     * @return \Illuminate\Http\Response
     */
    public function edit(Seguradora $seguradora)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSeguradoraRequest  $request
     * @param  \App\Models\Seguradora  $seguradora
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSeguradoraRequest $request, Seguradora $seguradora)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Seguradora  $seguradora
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seguradora $seguradora)
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
        $seguradoras = Cache::rememberForever('seguradoras-inativas', function () {
            return Seguradora::select(['id', 'nome', 'cnpj'])->where('ativo', '=', false)->get();
        });

        return view('cadastros.seguradora.inativos')
            ->with('seguradoras', $seguradoras);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Seguradora  $reguladora
     * @return \Illuminate\Http\Response
     */
    public function inativarAtivar(Seguradora $seguradora)
    {
        Cache::forget('seguradoras');
        Cache::forget('seguradoras-inativas');

        if($seguradora->ativo) {
            $seguradora->ativo = false;

            $messagem = "Seguradora '{$seguradora->nome}' inativada com sucesso.";
        } else {
            $seguradora->ativo = true;

            $messagem = "Seguradora '{$seguradora->nome}' ativada com sucesso.";
        }
        
        $seguradora->save();
        
        return to_route('cadastro.seguradora.index')
            ->with('success', $messagem);
    }
}
