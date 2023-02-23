<?php

namespace App\Http\Controllers\Cadastros;

use App\Http\Controllers\Controller;
use App\Models\Seguradora;
use App\Http\Requests\StoreSeguradoraRequest;
use App\Http\Requests\UpdateSeguradoraRequest;
use App\Models\Email;
use App\Models\Endereco\Estado;
use App\Models\Telefone;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;

class SeguradoraController extends Controller
{
    function __construct()
    {
        $this->middleware(
            'permission:seguradora-listar|seguradora-cadastrar|seguradora-editar|seguradora-inativar|seguradora-deletar', 
            ['only' => ['index','store']]
        );
        $this->middleware('permission:seguradora-cadastrar', ['only' => ['create','store']]);
        $this->middleware('permission:seguradora-editar', ['only' => ['edit','update']]);
        $this->middleware('permission:seguradora-inativar', ['only' => ['inativos','inativarAtivar']]);
        $this->middleware('permission:seguradora-deletar', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $seguradoras = Cache::rememberForever('seguradoras', function () {
            return Seguradora::select(['id', 'razao_social', 'nome_fantasia', 'cnpj'])->where('ativo', '=', true)->get();
        });

        return view('cadastros.seguradora.index')
            ->with('seguradoras', $seguradoras);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $estados = Cache::rememberForever('estados', function () {
            return Estado::select(['uf', 'nome'])->orderBy('nome')->get();
        });

        return view('cadastros.seguradora.create-edit')
            ->with('estados', $estados);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSeguradoraRequest $request): RedirectResponse
    {
        Cache::forget('seguradoras');

        $razaoSocial = Seguradora::createAndReturnName((object)$request->all());

        return to_route('cadastro.seguradora.index')
            ->with('success', "Seguradora '{$razaoSocial}' adicionada com sucesso.");
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $seguradora): View
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
     */
    public function update(UpdateSeguradoraRequest $request, Seguradora $seguradora): RedirectResponse
    {
        Cache::forget('seguradoras');

        $razaoSocial = Seguradora::updateAndReturnName($seguradora, (object)$request->all());

        return to_route('cadastro.seguradora.index')
            ->with('success', "Seguradora '{$razaoSocial}' atualizada com sucesso.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Seguradora $seguradora): RedirectResponse
    {
        Cache::forget('seguradoras-inativas');

        $seguradora->delete();
        
        return to_route('cadastro.seguradora.inativos')
            ->with('success', "Seguradora '{$seguradora->razao_social}' excluida com sucesso.");
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function inativos(): View
    {
        $reguladorasInativas = Cache::rememberForever('seguradoras-inativas', function () {
            return Seguradora::select(['id', 'razao_social', 'nome_fantasia', 'cnpj'])->where('ativo', '=', false)->get();
        });

        return view('cadastros.seguradora.inativos')
            ->with('seguradoras', $reguladorasInativas);
    }

    /**
     * Update the specified resource in storage.
     */
    public function inativarAtivar(Seguradora $seguradora): RedirectResponse
    {
        Cache::forget('seguradoras');
        Cache::forget('seguradoras-inativas');

        if($seguradora->ativo) {
            $seguradora->ativo = false;

            $messagem = "Seguradora '{$seguradora->razao_social}' inativada com sucesso.";
        } else {
            $seguradora->ativo = true;

            $messagem = "Seguradora '{$seguradora->razao_social}' ativada com sucesso.";
        }
        
        $seguradora->save();
        
        return to_route('cadastro.seguradora.index')
            ->with('success', $messagem);
    }
}
