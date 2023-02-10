@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>{{ __('Reguladoras') }}</div>
                <div>
                    <a href="{{ route('cadastro.reguladora.create') }}" class="btn btn-primary">
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
                        <th class="col-8">{{ __('CNPJ') }}</th>
                        <th class="col-1">{{ __('Edit') }}</th>
                        <th class="col-1">{{ __('Delete') }}</th>
                    </tr>
                </thead>
                <tbody>        
                    @forelse ($reguladoras as $reguladora) 
                        <tr>
                            <td>{{ $reguladora->nome }}</td>
                            <td>{{ $reguladora->cnpj }}</td>
                            <td>
                                <a href="{{ route('cadastro.reguladora.edit', $reguladora->id) }}">
                                    Editar
                                </a>
                            </td>
                            <td>
                                <a 
                                    href="{{ route('cadastro.reguladora.destroy', $reguladora->id) }}"
                                    onclick="event.preventDefault();
                                        document.getElementById('reguladora-{{ $reguladora->id }}-form').submit();"
                                >
                                    Excluir
                                </a>
                                <form 
                                    id="reguladora-{{ $reguladora->id }}-form" 
                                    action="{{ route('cadastro.reguladora.destroy', $reguladora->id) }}" 
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