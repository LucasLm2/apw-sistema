<?php

namespace App\Http\Controllers\Cadastros;

use App\Http\Controllers\Controller;
use App\Models\Reguladora;
use App\Http\Requests\StoreReguladoraRequest;
use App\Http\Requests\UpdateReguladoraRequest;
use App\Models\Email;
use App\Models\Endereco\Estado;
use App\Models\Telefone;
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
            return Reguladora::select(['id', 'nome', 'cnpj'])->where('ativo', '=', true)->get();
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
        Cache::forget('reguladoras');

        $nome = Reguladora::createAndReturnName((object)$request->all());

        return to_route('cadastro.reguladora.index')
            ->with('success', "Reguladora '{$nome}' adicionada com sucesso.");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $reguladora
     * @return \Illuminate\Http\Response
     */
    public function edit(int $reguladora)
    {
        $reguladora = Reguladora::findWithEndereco($reguladora);
        $telefones = Telefone::allWithReference('reguladoras', $reguladora->id);
        $emails = Email::allWithReference('reguladoras', $reguladora->id);
        
        $estados = Cache::rememberForever('estados', function () {
            return Estado::select(['uf', 'nome'])->orderBy('nome')->get();
        });

        return view('cadastros.reguladora.create-edit')
            ->with('reguladora', $reguladora)
            ->with('estados', $estados)
            ->with('telefones', $telefones)
            ->with('emails',  $emails);
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
        Cache::forget('reguladoras');

        $nome = Reguladora::updateAndReturnName($reguladora, (object)$request->all());

        return to_route('cadastro.reguladora.index')
            ->with('success', "Reguladora '{$nome}' atualizada com sucesso.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reguladora  $reguladora
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reguladora $reguladora)
    {
        Cache::forget('reguladoras-inativas');

        $reguladora->delete();
        
        return to_route('cadastro.reguladora.inativos')
            ->with('success', "Reguladora '{$reguladora->nome}' excluida com sucesso.");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function inativos()
    {
        $reguladorasInativas = Cache::rememberForever('reguladoras-inativas', function () {
            return Reguladora::select(['id', 'nome', 'cnpj'])->where('ativo', '=', false)->get();
        });

        return view('cadastros.reguladora.inativos')
            ->with('reguladoras', $reguladorasInativas);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reguladora  $reguladora
     * @return \Illuminate\Http\Response
     */
    public function inativarAtivar(Reguladora $reguladora)
    {
        Cache::forget('reguladoras');
        Cache::forget('reguladoras-inativas');

        if($reguladora->ativo) {
            $reguladora->ativo = false;

            $messagem = "Reguladora '{$reguladora->nome}' inativada com sucesso.";
        } else {
            $reguladora->ativo = true;

            $messagem = "Reguladora '{$reguladora->nome}' ativada com sucesso.";
        }
        
        $reguladora->save();
        
        return to_route('cadastro.reguladora.index')
            ->with('success', $messagem);
    }
}
