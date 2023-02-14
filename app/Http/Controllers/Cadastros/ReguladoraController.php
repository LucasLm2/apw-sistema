<?php

namespace App\Http\Controllers\Cadastros;

use App\Helpers\ManipulacaoString;
use App\Http\Controllers\Controller;
use App\Models\Reguladora;
use App\Http\Requests\StoreReguladoraRequest;
use App\Http\Requests\UpdateReguladoraRequest;
use App\Models\Endereco\Bairro;
use App\Models\Endereco\Endereco;
use App\Models\Endereco\Estado;
use App\Models\Endereco\Rua;
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
        Cache::forget('reguladoras');

        $reguladora->nome = $request->nome;
        $reguladora->cnpj = ManipulacaoString::limpaString($request->cnpj);
        $reguladora->inscricao_estadual = $request->inscricao_estadual;
        $reguladora->site = $request->site;

        if($request->cep == null) {
            $reguladora->endereco_id = null;
            $reguladora->save();

            return to_route('cadastro.reguladora.index')
                ->with('success', "Reguladora '{$reguladora->nome}' atualizada com sucesso.");
        }

        if($reguladora->endereco_id == null) {
            $idEndereco = Endereco::createAndReturnId((object) $request->all());
            $reguladora->endereco_id = $idEndereco;

            $reguladora->save();

            return to_route('cadastro.reguladora.index')
                ->with('success', "Reguladora '{$reguladora->nome}' atualizada com sucesso.");
        }
        
        $bairroId = null;
        if($request->bairro != '') {
            $bairroId = Bairro::createAndReturnId($request->bairro, $request->municipio);
        }

        $ruaId = null;
        if($request->rua != '' && $bairroId != null) {
            $ruaId = Rua::createAndReturnId($request->rua, $bairroId);
        }

        $endereco = Endereco::find($reguladora->endereco_id);
        $endereco->cep = ManipulacaoString::limpaString($request->cep);
        $endereco->municipio_cod_ibge = $request->municipio;
        $endereco->bairro_id = $bairroId;
        $endereco->rua_id = $ruaId;
        $endereco->numero = $request->numero;
        $endereco->complemento = $request->complemento;
        $endereco->save();

        $reguladora->save();

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
        Cache::forget('reguladoras');

        $reguladora->delete();
        
        return to_route('cadastro.reguladora.index')
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
