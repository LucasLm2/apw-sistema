@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>{{ __('Tipo de serviços') }}</div>
                <div>
                    @can('tipo-servico-cadastrar')
                        <a href="{{ route('cadastro.tipo-servico.create') }}" class="btn btn-primary">
                            {{ __('New') }}
                        </a>
                    @endcan
                    @can('tipo-servico-inativar')
                        <a href="{{ route('cadastro.tipo-servico.inativos') }}" class="btn btn-secondary">
                            {{ __('Inativos') }}
                        </a>
                    @endcan
                </div>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-sm table-striped table-hover datatable">
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
                                        class="text-success"
                                        href="{{ route('cadastro.tipo-servico.edit', $tipoServicos->id) }}"
                                    >
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                </td>
                            @endcan
                            @can('tipo-servico-inativar')
                                <td class="text-center">
                                    <a 
                                        class="text-danger"
                                        href="{{ route('cadastro.tipo-servico.inativar-ativar', $tipoServicos->id) }}"
                                        onclick="event.preventDefault();
                                            inativar('tipo-servico-{{ $tipoServicos->id }}-form-inativar-ativar');"
                                    >
                                        <i class="fa-solid fa-delete-left"></i>
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
    </div>
</div>
@endsection