@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>{{ __('Tipo de despesas') }}</div>
                <div>
                    <a href="{{ route('cadastro.tipo-despesa.create') }}" class="btn btn-primary">
                        {{ __('New') }}
                    </a>
                    <a href="{{ route('cadastro.tipo-despesa.inativos') }}" class="btn btn-secondary">
                        {{ __('Inativos') }}
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
                        <th class="col-1 text-center" data-orderable="false">{{ __('Edit') }}</th>
                        <th class="col-1 text-center" data-orderable="false">{{ __('Inativar') }}</th>
                    </tr>
                </thead>
                <tbody>        
                    @foreach ($tipoDespesas as $tipoDespesas) 
                        <tr>
                            <td>{{ $tipoDespesas->nome }}</td>
                            <td>{{ $tipoDespesas->descricao }}</td>
                            <td class="text-center">
                                <a 
                                    class="text-success"
                                    href="{{ route('cadastro.tipo-despesa.edit', $tipoDespesas->id) }}"
                                >
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <a 
                                    class="text-danger"
                                    href="{{ route('cadastro.tipo-despesa.inativar-ativar', $tipoDespesas->id) }}"
                                    onclick="event.preventDefault();
                                        inativar('tipo-despesa-{{ $tipoDespesas->id }}-form-inativar-ativar');"
                                >
                                    <i class="fa-solid fa-delete-left"></i>
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
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection