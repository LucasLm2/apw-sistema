<?php

namespace App\Http\Controllers\Cadastros;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Models\Email;
use App\Models\Endereco\Estado;
use App\Models\Telefone;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;

class ClienteController extends Controller
{
    function __construct()
    {
        $this->middleware(
            'permission:cliente-listar|cliente-cadastrar|cliente-editar|cliente-inativar|cliente-deletar', 
            ['only' => ['index','store']]
        );
        $this->middleware('permission:cliente-cadastrar', ['only' => ['create','store']]);
        $this->middleware('permission:cliente-editar', ['only' => ['edit','update']]);
        $this->middleware('permission:cliente-inativar', ['only' => ['inativos','inativarAtivar']]);
        $this->middleware('permission:cliente-deletar', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $clientes = Cache::rememberForever('clientes', function () {
            return Cliente::select(['id', 'razao_social', 'nome_fantasia', 'cpf_cnpj'])->where('ativo', '=', true)->get();
        });

        return view('cadastros.cliente.index')
            ->with('clientes', $clientes);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $estados = Cache::rememberForever('estados', function () {
            return Estado::select(['uf', 'nome'])->orderBy('nome')->get();
        });

        return view('cadastros.cliente.create-edit')
            ->with('estados', $estados);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClienteRequest $request): RedirectResponse
    {
        Cache::forget('clientes');

        $razaoSocial = Cliente::createAndReturnName((object)$request->all());

        return to_route('cadastro.cliente.index')
            ->with('success', "Cliente '{$razaoSocial}' adicionado com sucesso.");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $cliente): View
    {
        $cliente = Cliente::findWithEndereco($cliente);
        $telefones = Telefone::allWithReference('clientes', $cliente->id);
        $emails = Email::allWithReference('clientes', $cliente->id);
        
        $estados = Cache::rememberForever('estados', function () {
            return Estado::select(['uf', 'nome'])->orderBy('nome')->get();
        });

        return view('cadastros.cliente.create-edit')
            ->with('cliente', $cliente)
            ->with('estados', $estados)
            ->with('telefones', $telefones)
            ->with('emails',  $emails);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClienteRequest $request, Cliente $cliente): RedirectResponse
    {
        Cache::forget('clientes');

        $razaoSocial = Cliente::updateAndReturnName($cliente, (object)$request->all());

        return to_route('cadastro.cliente.index')
            ->with('success', "Cliente '{$razaoSocial}' atualizado com sucesso.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente): RedirectResponse
    {
        Cache::forget('clientes-inativas');

        $cliente->delete();
        
        return to_route('cadastro.cliente.inativos')
            ->with('success', "Cliente '{$cliente->razao_social}' excluido com sucesso.");
    }
    
    /**
     * Display a listing of the resource.
     */
    public function inativos(): View
    {
        $reguladorasInativas = Cache::rememberForever('clientes-inativas', function () {
            return Cliente::select(['id', 'razao_social', 'nome_fantasia', 'cpf_cnpj'])->where('ativo', '=', false)->get();
        });

        return view('cadastros.cliente.inativos')
            ->with('clientes', $reguladorasInativas);
    }

    /**
     * Update the specified resource in storage.
     */
    public function inativarAtivar(Cliente $cliente): RedirectResponse
    {
        Cache::forget('clientes');
        Cache::forget('clientes-inativas');

        if($cliente->ativo) {
            $cliente->ativo = false;

            $messagem = "Cliente '{$cliente->razao_social}' inativado com sucesso.";
        } else {
            $cliente->ativo = true;

            $messagem = "Cliente '{$cliente->razao_social}' ativado com sucesso.";
        }
        
        $cliente->save();
        
        return to_route('cadastro.cliente.index')
            ->with('success', $messagem);
    }
}
