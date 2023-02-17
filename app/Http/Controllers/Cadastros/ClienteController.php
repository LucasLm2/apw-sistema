<?php

namespace App\Http\Controllers\Cadastros;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Models\Email;
use App\Models\Endereco\Estado;
use App\Models\Telefone;
use Illuminate\Support\Facades\Cache;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = Cache::rememberForever('clientes', function () {
            return Cliente::select(['id', 'nome', 'cnpj'])->where('ativo', '=', true)->get();
        });

        return view('cadastros.cliente.index')
            ->with('clientes', $clientes);
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

        return view('cadastros.cliente.create-edit')
            ->with('estados', $estados);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFornecedorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClienteRequest $request)
    {
        Cache::forget('clientes');

        $nome = Cliente::createAndReturnName((object)$request->all());

        return to_route('cadastro.cliente.index')
            ->with('success', "Cliente '{$nome}' adicionado com sucesso.");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit(int $cliente)
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
     *
     * @param  \App\Http\Requests\UpdateClienteRequest  $request
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClienteRequest $request, Cliente $cliente)
    {
        Cache::forget('clientes');

        $nome = Cliente::updateAndReturnName($cliente, (object)$request->all());

        return to_route('cadastro.cliente.index')
            ->with('success', "Cliente '{$nome}' atualizado com sucesso.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cliente $cliente)
    {
        Cache::forget('clientes-inativas');

        $cliente->delete();
        
        return to_route('cadastro.cliente.inativos')
            ->with('success', "Cliente '{$cliente->nome}' excluido com sucesso.");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function inativos()
    {
        $reguladorasInativas = Cache::rememberForever('clientes-inativas', function () {
            return Cliente::select(['id', 'nome', 'cnpj'])->where('ativo', '=', false)->get();
        });

        return view('cadastros.cliente.inativos')
            ->with('clientes', $reguladorasInativas);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function inativarAtivar(Cliente $cliente)
    {
        Cache::forget('clientes');
        Cache::forget('clientes-inativas');

        if($cliente->ativo) {
            $cliente->ativo = false;

            $messagem = "Cliente '{$cliente->nome}' inativado com sucesso.";
        } else {
            $cliente->ativo = true;

            $messagem = "Cliente '{$cliente->nome}' ativado com sucesso.";
        }
        
        $cliente->save();
        
        return to_route('cadastro.cliente.index')
            ->with('success', $messagem);
    }
}
