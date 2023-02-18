<?php

namespace App\Http\Controllers\Cadastros;

use App\Http\Controllers\Controller;
use App\Models\Reguladora;
use App\Http\Requests\StoreReguladoraRequest;
use App\Http\Requests\UpdateReguladoraRequest;
use App\Models\Email;
use App\Models\Endereco\Estado;
use App\Models\Telefone;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;

class ReguladoraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $reguladoras = Cache::rememberForever('reguladoras', function () {
            return Reguladora::select(['id', 'razao_social', 'nome_fantasia', 'cnpj'])->where('ativo', '=', true)->get();
        });

        return view('cadastros.reguladora.index')
            ->with('reguladoras', $reguladoras);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $estados = Cache::rememberForever('estados', function () {
            return Estado::select(['uf', 'nome'])->orderBy('nome')->get();
        });

        return view('cadastros.reguladora.create-edit')
            ->with('estados', $estados);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReguladoraRequest $request): RedirectResponse
    {
        Cache::forget('reguladoras');

        $razaoSocial = Reguladora::createAndReturnName((object)$request->all());

        return to_route('cadastro.reguladora.index')
            ->with('success', "Reguladora '{$razaoSocial}' adicionada com sucesso.");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $reguladora): View
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
     */
    public function update(UpdateReguladoraRequest $request, Reguladora $reguladora): RedirectResponse
    {
        Cache::forget('reguladoras');

        $razaoSocial = Reguladora::updateAndReturnName($reguladora, (object)$request->all());

        return to_route('cadastro.reguladora.index')
            ->with('success', "Reguladora '{$razaoSocial}' atualizada com sucesso.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reguladora $reguladora): RedirectResponse
    {
        Cache::forget('reguladoras-inativas');

        $reguladora->delete();
        
        return to_route('cadastro.reguladora.inativos')
            ->with('success', "Reguladora '{$reguladora->razao_social}' excluida com sucesso.");
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function inativos(): View
    {
        $reguladorasInativas = Cache::rememberForever('reguladoras-inativas', function () {
            return Reguladora::select(['id', 'razao_social', 'nome_fantasia', 'cnpj'])->where('ativo', '=', false)->get();
        });

        return view('cadastros.reguladora.inativos')
            ->with('reguladoras', $reguladorasInativas);
    }

    /**
     * Update the specified resource in storage.
     */
    public function inativarAtivar(Reguladora $reguladora): RedirectResponse
    {
        Cache::forget('reguladoras');
        Cache::forget('reguladoras-inativas');

        if($reguladora->ativo) {
            $reguladora->ativo = false;

            $messagem = "Reguladora '{$reguladora->razao_social}' inativada com sucesso.";
        } else {
            $reguladora->ativo = true;

            $messagem = "Reguladora '{$reguladora->razao_social}' ativada com sucesso.";
        }
        
        $reguladora->save();
        
        return to_route('cadastro.reguladora.index')
            ->with('success', $messagem);
    }
}
