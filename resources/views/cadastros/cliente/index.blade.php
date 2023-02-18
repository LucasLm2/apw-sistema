@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>{{ __('Clientes') }}</div>
                <div>
                    <a href="{{ route('cadastro.cliente.create') }}" class="btn btn-primary">
                        {{ __('New') }}
                    </a>
                    <a href="{{ route('cadastro.cliente.inativos') }}" class="btn btn-secondary">
                        {{ __('Inativos') }}
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <table id="table" class="table table-sm table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th class="col-5">{{ __('Razão Social') }}</th>
                        <th class="col-2">{{ __('CPF/CNPJ') }}</th>
                        <th class="col-4">{{ __('Nome Fantasia') }}</th>
                        <th class="col-1 text-center" data-orderable="false">{{ __('Edit') }}</th>
                        <th class="col-1 text-center" data-orderable="false">{{ __('Inativar') }}</th>
                    </tr>
                </thead>
                <tbody>     
                    @foreach ($clientes as $cliente) 
                        <tr>
                            <td>{{ $cliente->razao_social }}</td>
                            <td class="cpf-cnpj-mask">{{ $cliente->cpf_cnpj }}</td>
                            <td>{{ $cliente->nome_fantasia }}</td>
                            <td class="text-center">
                                <a 
                                    class="text-success"
                                    href="{{ route('cadastro.cliente.edit', $cliente->id) }}"
                                >
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <a 
                                    class="text-danger"
                                    href="{{ route('cadastro.cliente.inativar-ativar', $cliente->id) }}"
                                    onclick="event.preventDefault();
                                        inativar('cliente-{{ $cliente->id }}-form-inativar-ativar');"
                                >
                                    <i class="fa-solid fa-delete-left"></i>
                                </a>
                                <form 
                                    id="cliente-{{ $cliente->id }}-form-inativar-ativar" 
                                    action="{{ route('cadastro.cliente.inativar-ativar', $cliente->id) }}" 
                                    method="POST" 
                                    class="d-none"
                                >
                                    @csrf
                                    @method('PUT');
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script type="module">
        mascaraCpfCnpj('.cpf-cnpj-mask');
    </script>
@endsection