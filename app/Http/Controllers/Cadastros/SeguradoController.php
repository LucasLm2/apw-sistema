<?php

namespace App\Http\Controllers\Cadastros;

use App\Http\Controllers\Controller;
use App\Models\Segurado;
use App\Http\Requests\StoreReguladoraRequest;
use App\Http\Requests\UpdateReguladoraRequest;
use App\Models\Email;
use App\Models\Endereco\Estado;
use App\Models\Telefone;
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
        $segurados = Cache::rememberForever('segurados', function () {
            return Segurado::select(['id', 'nome', 'cnpj'])->where('ativo', '=', true)->get();
        });

        return view('cadastros.segurado.index')
            ->with('segurados', $segurados);
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

        return view('cadastros.segurado.create-edit')
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
        Cache::forget('segurados');

        $nome = Segurado::createAndReturnName((object)$request->all());

        return to_route('cadastro.segurado.index')
            ->with('success', "Segurado '{$nome}' adicionado com sucesso.");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $segurado
     * @return \Illuminate\Http\Response
     */
    public function edit(int $segurado)
    {
        $segurado = Segurado::findWithEndereco($segurado);
        $telefones = Telefone::allWithReference('segurados', $segurado->id);
        $emails = Email::allWithReference('segurados', $segurado->id);
        
        $estados = Cache::rememberForever('estados', function () {
            return Estado::select(['uf', 'nome'])->orderBy('nome')->get();
        });

        return view('cadastros.segurado.create-edit')
            ->with('segurado', $segurado)
            ->with('estados', $estados)
            ->with('telefones', $telefones)
            ->with('emails',  $emails);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateReguladoraRequest  $request
     * @param  \App\Models\Segurado  $segurado
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReguladoraRequest $request, Segurado $segurado)
    {
        Cache::forget('segurados');

        $nome = Segurado::updateAndReturnName($segurado, (object)$request->all());

        return to_route('cadastro.segurado.index')
            ->with('success', "Segurado '{$nome}' atualizado com sucesso.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Segurado  $segurado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Segurado $segurado)
    {
        Cache::forget('segurados-inativas');

        $segurado->delete();
        
        return to_route('cadastro.segurado.inativos')
            ->with('success', "Segurado '{$segurado->nome}' excluido com sucesso.");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function inativos()
    {
        $reguladorasInativas = Cache::rememberForever('segurados-inativas', function () {
            return Segurado::select(['id', 'nome', 'cnpj'])->where('ativo', '=', false)->get();
        });

        return view('cadastros.segurado.inativos')
            ->with('segurados', $reguladorasInativas);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Segurado  $segurado
     * @return \Illuminate\Http\Response
     */
    public function inativarAtivar(Segurado $segurado)
    {
        Cache::forget('segurados');
        Cache::forget('segurados-inativas');

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
