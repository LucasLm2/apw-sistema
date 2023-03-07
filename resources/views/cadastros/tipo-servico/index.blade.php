@extends('layouts.app')

@section('content')
<div class="container p-3">
    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
        <h2 class="h3 fw-bold h2-title-pages"><i class="fa-solid fa-file-invoice-dollar"></i> {{ __('Tipo de serviços') }}</h2>
        <div>
            @can('tipo-servico-cadastrar')
                <a href="{{ route('cadastro.tipo-servico.create') }}" class="btn btn-new">
                    <i class="fa-solid fa-plus"></i> {{ __('New') }}
                </a>
            @endcan
            @can('tipo-servico-inativar')
                <a href="{{ route('cadastro.tipo-servico.inativos') }}" class="btn btn-deactive">
                    <i class="fa-solid fa-arrow-down"></i> {{ __('Inativos') }}
                </a>
            @endcan
        </div>
    </div>

    <table class="table table-lg table-striped table-hover datatable py-4">
        <thead>
            <tr>
                <th class="col-3">{{ __('Name') }}</th>
                <th class="col-8">{{ __('Description') }}</th>
                @can('tipo-servico-editar')
                    <th class="col-1 text-center" data-orderable="false">{{ __('Edit') }}</th>
                @endcan
                @can('tipo-servico-inativar')
                    <th class="col-1 text-center" data-orderable="false">{{ __('Inativar') }}</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @foreach ($tipoServicos as $tipoServicos)
                <tr>
                    <td>{{ $tipoServicos->nome }}</td>
                    <td>{{ $tipoServicos->descricao }}</td>
                    @can('tipo-servico-editar')
                        <td class="text-center">
                            <a
                                class="btn btn-edit"
                                href="{{ route('cadastro.tipo-servico.edit', $tipoServicos->id) }}"
                            >
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        </td>
                    @endcan
                    @can('tipo-servico-inativar')
                        <td class="text-center">
                            <a
                                class="btn btn-inactive"
                                href="{{ route('cadastro.tipo-servico.inativar-ativar', $tipoServicos->id) }}"
                                onclick="event.preventDefault();
                                    inativar('tipo-servico-{{ $tipoServicos->id }}-form-inativar-ativar');"
                            >
                                <i class="fa-solid fa-xmark"></i>
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
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
