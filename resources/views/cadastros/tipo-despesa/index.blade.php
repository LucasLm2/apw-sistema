@extends('layouts.app')

@section('content')
<div class="container bg-white p-5 rounded shadow-sm">
    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
        <h2 class="h3 fw-bold h2-title-pages"><i class="fa-solid fa-file-invoice-dollar"></i> {{ __('Tipo de despesas') }}</h2>
        <div>
            @can('tipo-despesa-cadastrar')
                <a href="{{ route('cadastro.tipo-despesa.create') }}" class="btn link-primary btn-new me-2">
                    <i class="fa-solid fa-plus"></i> {{ __('New') }}
                </a>
            @endcan
            @can('tipo-despesa-inativar')
                <a href="{{ route('cadastro.tipo-despesa.inativos') }}" class="btn btn-deactive">
                    <i class="fa-solid fa-arrow-down"></i> {{ __('Inativos') }}
                </a>
            @endcan
        </div>
    </div>

    <table class="table table-lg table-striped table-hover datatable py-4">
        <thead>
            <tr>
                <th class="col-2">{{ __('Name') }}</th>
                <th class="col-8">{{ __('Description') }}</th>
                @can('tipo-despesa-editar')
                    <th class="col-1 text-center" data-orderable="false">{{ __('Edit') }}</th>
                @endcan
                @can('tipo-despesa-inativar')
                    <th class="col-1 text-center" data-orderable="false">{{ __('Inativar') }}</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @foreach ($tipoDespesas as $tipoDespesas)
                <tr>
                    <td>{{ $tipoDespesas->nome }}</td>
                    <td>{{ $tipoDespesas->descricao }}</td>
                    @can('tipo-despesa-editar')
                        <td class="text-center">
                            <a
                                class="btn btn-edit"
                                href="{{ route('cadastro.tipo-despesa.edit', $tipoDespesas->id) }}"
                            >
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        </td>
                    @endcan
                    @can('tipo-despesa-inativar')
                        <td class="text-center">
                            <a
                                class="btn btn-inactive"
                                href="{{ route('cadastro.tipo-despesa.inativar-ativar', $tipoDespesas->id) }}"
                                onclick="event.preventDefault();
                                    inativar('tipo-despesa-{{ $tipoDespesas->id }}-form-inativar-ativar');"
                            >
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                            <form
                                id="tipo-despesa-{{ $tipoDespesas->id }}-form-inativar-ativar"
                                action="{{ route('cadastro.tipo-despesa.inativar-ativar', $tipoDespesas->id) }}"
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
