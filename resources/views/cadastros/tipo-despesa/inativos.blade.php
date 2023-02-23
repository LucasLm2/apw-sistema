@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>{{ __('Tipo de despesas inativas') }}</div>
                <div>
                    <a href="{{ route('cadastro.tipo-despesa.index') }}" class="btn btn-primary">
                        {{ __('Return') }}
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-sm table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th class="col-3">{{ __('Name') }}</th>
                        <th class="col-8">{{ __('Description') }}</th>
                        @can('tipo-despesa-inativar')
                            <th class="col-1 text-center" data-orderable="false">{{ __('Ativar') }}</th>
                        @endcan
                        @can('tipo-despesa-deletar')
                            <th class="col-1 text-center" data-orderable="false">{{ __('Delete') }}</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>        
                    @foreach ($tipoDespesas as $tipoDespesas) 
                        <tr>
                            <td>{{ $tipoDespesas->nome }}</td>
                            <td>{{ $tipoDespesas->descricao }}</td>
                            @can('tipo-despesa-inativar')
                                <td class="text-center">
                                    <a 
                                        class="text-success"
                                        href="{{ route('cadastro.tipo-despesa.inativar-ativar', $tipoDespesas->id) }}"
                                        onclick="event.preventDefault();
                                            ativar('tipo-despesa-{{ $tipoDespesas->id }}-form-inativar-ativar');"
                                    >
                                        <i class="fa-solid fa-check-to-slot"></i>
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
                            @can('tipo-despesa-deletar')
                                <td class="text-center">
                                    <a 
                                        class="text-danger"
                                        href="{{ route('cadastro.tipo-despesa.destroy', $tipoDespesas->id) }}"
                                        onclick="event.preventDefault();
                                            excluir('tipo-despesa-{{ $tipoDespesas->id }}-form');"
                                    >
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                    <form 
                                        id="tipo-despesa-{{ $tipoDespesas->id }}-form" 
                                        action="{{ route('cadastro.tipo-despesa.destroy', $tipoDespesas->id) }}" 
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
    </div>
</div>
@endsection