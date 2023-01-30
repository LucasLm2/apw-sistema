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
                </div>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-sm table-striped table-hover">
                <thead>
                    <tr>
                        <th class="col-3">{{ __('Name') }}</th>
                        <th class="col-8">{{ __('Description') }}</th>
                        <th class="col-1">{{ __('Edit') }}</th>
                        <th class="col-1">{{ __('Delete') }}</th>
                    </tr>
                </thead>
                <tbody>        
                    @forelse ($tipoDespesas as $tipoDespesas) 
                        <tr>
                            <td>{{ $tipoDespesas->nome }}</td>
                            <td>{{ $tipoDespesas->descricao }}</td>
                            <td>
                                <a href="{{ route('cadastro.tipo-despesa.edit', $tipoDespesas->id) }}">
                                    Editar
                                </a>
                            </td>
                            <td>
                                <a 
                                    href="{{ route('cadastro.tipo-despesa.destroy', $tipoDespesas->id) }}"
                                    onclick="event.preventDefault();
                                        document.getElementById('tipo-despesa-{{ $tipoDespesas->id }}-form').submit();"
                                >
                                    Excluir
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