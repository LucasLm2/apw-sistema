<?php

namespace App\Http\Controllers\Cadastros;

use App\Http\Controllers\Controller;
use App\Models\Seguradora;
use App\Http\Requests\StoreSeguradoraRequest;
use App\Http\Requests\UpdateSeguradoraRequest;
use App\Models\Email;
use App\Models\Endereco\Estado;
use App\Models\Telefone;
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
        $seguradoras = Cache::rememberForever('seguradoras', function () {
            return Seguradora::select(['id', 'nome', 'cnpj'])->where('ativo', '=', true)->get();
        });

        return view('cadastros.seguradora.index')
            ->with('seguradoras', $seguradoras);
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

        return view('cadastros.seguradora.create-edit')
            ->with('estados', $estados);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFornecedorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSeguradoraRequest $request)
    {
        Cache::forget('seguradoras');

        $nome = Seguradora::createAndReturnName((object)$request->all());

        return to_route('cadastro.seguradora.index')
            ->with('success', "Seguradora '{$nome}' adicionada com sucesso.");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $seguradora
     * @return \Illuminate\Http\Response
     */
    public function edit(int $seguradora)
    {
        $seguradora = Seguradora::findWithEndereco($seguradora);
        $telefones = Telefone::allWithReference('seguradoras', $seguradora->id);
        $emails = Email::allWithReference('seguradoras', $seguradora->id);
        
        $estados = Cache::rememberForever('estados', function () {
            return Estado::select(['uf', 'nome'])->orderBy('nome')->get();
        });

        return view('cadastros.seguradora.create-edit')
            ->with('seguradora', $seguradora)
            ->with('estados', $estados)
            ->with('telefones', $telefones)
            ->with('emails',  $emails);
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
        Cache::forget('seguradoras');

        $nome = Seguradora::updateAndReturnName($seguradora, (object)$request->all());

        return to_route('cadastro.seguradora.index')
            ->with('success', "Seguradora '{$nome}' atualizada com sucesso.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Seguradora  $seguradora
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seguradora $seguradora)
    {
        Cache::forget('seguradoras-inativas');

        $seguradora->delete();
        
        return to_route('cadastro.seguradora.inativos')
            ->with('success', "Seguradora '{$seguradora->nome}' excluida com sucesso.");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function inativos()
    {
        $reguladorasInativas = Cache::rememberForever('seguradoras-inativas', function () {
            return Seguradora::select(['id', 'nome', 'cnpj'])->where('ativo', '=', false)->get();
        });

        return view('cadastros.seguradora.inativos')
            ->with('seguradoras', $reguladorasInativas);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Seguradora  $seguradora
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
