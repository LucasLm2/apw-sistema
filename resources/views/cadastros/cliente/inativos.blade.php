@extends('layouts.app')

@section('content')
<div class="container bg-white p-5 rounded shadow-sm">
    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
        <h2 class="h4 fw-bold h2-title-pages">{{ __('Clientes Inativos') }}</h2>
        <div>
            <a href="{{ route('cadastro.cliente.index') }}" class="btn btn-new">
                <i class="fa-solid fa-arrow-left"></i> {{ __('Return') }}
            </a>
        </div>
    </div>

    <table class="table table-lg table-striped table-hover datatable py-4">
        <thead>
            <tr>
                <th class="col-5">{{ __('Razão Social') }}</th>
                <th class="col-2">{{ __('CPF/CNPJ') }}</th>
                <th class="col-4">{{ __('Nome Fantasia') }}</th>
                @can('cliente-inativar')
                    <th class="col-1 text-center" data-orderable="false">{{ __('Ativar') }}</th>
                @endcan
                @can('cliente-deletar')
                    <th class="col-1 text-center" data-orderable="false">{{ __('Delete') }}</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @foreach ($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->razao_social }}</td>
                    <td class="cpf-cnpj-mask">{{ $cliente->cpf_cnpj }}</td>
                    <td>{{ $cliente->nome_fantasia }}</td>
                    @can('cliente-inativar')
                        <td class="text-center">
                            <a
                                class="btn btn-edit"
                                href="{{ route('cadastro.cliente.inativar-ativar', $cliente->id) }}"
                                onclick="event.preventDefault();
                                    ativar('cliente-{{ $cliente->id }}-form-inativar-ativar');"
                            >
                                <i class="fa-solid fa-check-to-slot"></i>
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
                    @endcan
                    @can('cliente-deletar')
                        <td class="text-center">
                            <a
                                class="btn btn-inactive"
                                href="{{ route('cadastro.cliente.destroy', $cliente->id) }}"
                                onclick="event.preventDefault();
                                    excluir('cliente-{{ $cliente->id }}-form');"
                            >
                                <i class="fa-solid fa-trash"></i>
                            </a>
                            <form
                                id="cliente-{{ $cliente->id }}-form"
                                action="{{ route('cadastro.cliente.destroy', $cliente->id) }}"
                                method="POST"
                                class="d-none"
                            >
                                @csrf
                                @method('DELETE');
                            </form>
                        </td>
                    @endcan
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
    <script type="module">
        mascaraCpfCnpj('.cpf-cnpj-mask');
    </script>
@endsection
