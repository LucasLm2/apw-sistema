@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>{{ __('Clientes Inativos') }}</div>
                <div>
                    <a href="{{ route('cadastro.cliente.index') }}" class="btn btn-primary">
                        {{ __('Return') }}
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-sm table-striped table-hover">
                <thead>
                    <tr>
                        <th class="col-3">{{ __('Name') }}</th>
                        <th class="col-8">{{ __('CNPJ') }}</th>
                        <th class="col-1 text-center">{{ __('Ativar') }}</th>
                        <th class="col-1 text-center">{{ __('Delete') }}</th>
                    </tr>
                </thead>
                <tbody>        
                    @forelse ($clientes as $cliente) 
                        <tr>
                            <td>{{ $cliente->nome }}</td>
                            <td class="label-cnpj" data-inputmask="'mask': '99.999.999/9999-99'">{{ $cliente->cnpj }}</td>
                            <td class="text-center">
                                <a 
                                    class="text-success"
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
                            <td class="text-center">
                                <a 
                                    class="text-danger"
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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Nenhum registro encontrado!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script type="module">
        Inputmask().mask(document.querySelectorAll(".label-cnpj"));
    </script>
@endsection