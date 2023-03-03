@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>{{ __('Grupo de permissões inativas') }}</div>
                <div>
                    <a href="{{ route('cadastro.grupo-permissao.index') }}" class="btn btn-primary">
                        {{ __('Return') }}
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-sm table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th class="col-10">{{ __('Name') }}</th>
                        @can('grupo-permissao-inativar')
                            <th class="col-1 text-center" data-orderable="false">{{ __('Ativar') }}</th>
                        @endcan
                        @can('grupo-permissao-deletar')
                            <th class="col-1 text-center" data-orderable="false">{{ __('Delete') }}</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>        
                    @foreach ($gruposPermissoes as $key => $grupoPermissao)
                        <tr>
                            <td>{{ $grupoPermissao->name }}</td>
                            @can('grupo-permissao-inativar')
                                <td class="text-center">
                                    <a 
                                        class="text-success"
                                        href="{{ route('cadastro.grupo-permissao.inativar-ativar', $grupoPermissao->id) }}"
                                        onclick="event.preventDefault();
                                            ativar('grupo-permissao-{{ $grupoPermissao->id }}-form-inativar-ativar');"
                                    >
                                        <i class="fa-solid fa-check-to-slot"></i>
                                    </a>
                                    <form 
                                        id="grupo-permissao-{{ $grupoPermissao->id }}-form-inativar-ativar" 
                                        action="{{ route('cadastro.grupo-permissao.inativar-ativar', $grupoPermissao->id) }}" 
                                        method="POST" 
                                        class="d-none"
                                    >
                                        @csrf
                                        @method('PUT');
                                    </form>
                                </td>
                            @endcan
                            @can('grupo-permissao-deletar')
                                <td class="text-center">
                                    <a 
                                        class="text-danger"
                                        href="{{ route('cadastro.grupo-permissao.destroy', $grupoPermissao->id) }}"
                                        onclick="event.preventDefault();
                                            excluir('grupo-permissao-{{ $grupoPermissao->id }}-form');"
                                    >
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                    <form 
                                        id="grupo-permissao-{{ $grupoPermissao->id }}-form" 
                                        action="{{ route('cadastro.grupo-permissao.destroy', $grupoPermissao->id) }}" 
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