@extends('layouts.app')

@section('content')
<div class="container bg-white p-5 rounded shadow-sm">
    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
        <h2 class="h4 fw-bold h2-title-pages">{{ __('Tipo de serviços inativos') }}</h2>
        <div>
            <a href="{{ route('cadastro.tipo-servico.index') }}" class="btn btn-new">
                <i class="fa-solid fa-arrow-left"></i> {{ __('Return') }}
            </a>
        </div>
    </div>

    <table class="table table-lg table-striped table-hover datatable py-4">
        <thead>
            <tr>
                <th class="col-3">{{ __('Name') }}</th>
                <th class="col-8">{{ __('Description') }}</th>
                @can('tipo-servico-inativar')
                    <th class="col-1 text-center" data-orderable="false">{{ __('Ativar') }}</th>
                @endcan
                @can('tipo-servico-deletar')
                    <th class="col-1 text-center" data-orderable="false">{{ __('Delete') }}</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @foreach ($tipoServicos as $tipoServicos)
                <tr>
                    <td>{{ $tipoServicos->nome }}</td>
                    <td>{{ $tipoServicos->descricao }}</td>
                    @can('tipo-servico-inativar')
                        <td class="text-center">
                            <a
                                class="btn btn-edit"
                                href="{{ route('cadastro.tipo-servico.inativar-ativar', $tipoServicos->id) }}"
                                onclick="event.preventDefault();
                                    ativar('tipo-servico-{{ $tipoServicos->id }}-form-inativar-ativar');"
                            >
                                <i class="fa-solid fa-check-to-slot"></i>
                            </a>
                            <form
                                id="tipo-servico-{{ $tipoServicos->id }}-form-inativar-ativar"
                                action="{{ route('cadastro.tipo-servico.inativar-ativar', $tipoServicos->id) }}"
                                method="POST"
                                class="d-none"
                            >
                                @csrf
                                @method('PUT');
                            </form>
                        </td>
                    @endcan
                    @can('tipo-servico-deletar')
                        <td class="text-center">
                            <a
                                class="btn btn-inactive"
                                href="{{ route('cadastro.tipo-servico.destroy', $tipoServicos->id) }}"
                                onclick="event.preventDefault();
                                    excluir('tipo-servico-{{ $tipoServicos->id }}-form');"
                            >
                                <i class="fa-solid fa-trash"></i>
                            </a>
                            <form
                                id="tipo-servico-{{ $tipoServicos->id }}-form"
                                action="{{ route('cadastro.tipo-servico.destroy', $tipoServicos->id) }}"
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
