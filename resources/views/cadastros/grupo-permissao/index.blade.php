@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>{{ __('Grupo de permissões') }}</div>
                <div>
                    @can('grupo-permissao-cadastrar')
                        <a href="{{ route('cadastro.grupo-permissao.create') }}" class="btn btn-primary">
                            {{ __('New') }}
                        </a>
                    @endcan
                    @can('grupo-permissao-inativar')
                        <a href="{{ route('cadastro.grupo-permissao.inativos') }}" class="btn btn-secondary">
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
                        <th class="col-10">{{ __('Name') }}</th>
                        @can('grupo-permissao-editar')
                            <th class="col-1 text-center" data-orderable="false">{{ __('Edit') }}</th>
                        @endcan
                        @can('grupo-permissao-inativar')
                            <th class="col-1 text-center" data-orderable="false">{{ __('Inativar') }}</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>        
                    @foreach ($gruposPermissoes as $key => $grupoPermissao)
                        <tr>
                            <td>{{ $grupoPermissao->name }}</td>
                            @can('grupo-permissao-editar')
                                <td class="text-center">
                                    <a 
                                        class="text-success"
                                        href="{{ route('cadastro.grupo-permissao.edit', $grupoPermissao->id) }}"
                                    >
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                </td>
                            @endcan
                            @can('grupo-permissao-inativar')
                                <td class="text-center">
                                    <a 
                                        class="text-danger"
                                        href="{{ route('cadastro.grupo-permissao.inativar-ativar', $grupoPermissao->id) }}"
                                        onclick="event.preventDefault();
                                            inativar('grupo-permissao-{{ $grupoPermissao->id }}-form-inativar-ativar');"
                                    >
                                        <i class="fa-solid fa-delete-left"></i>
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
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection