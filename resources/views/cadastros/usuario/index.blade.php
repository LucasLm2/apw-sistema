@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>{{ __('Usuários') }}</div>
                <div>
                    @can('usuario-cadastrar')
                        <a href="{{ route('cadastro.usuario.create') }}" class="btn btn-primary">
                            {{ __('New') }}
                        </a>
                    @endcan
                    @can('usuario-inativar')
                        <a href="{{ route('cadastro.usuario.inativos') }}" class="btn btn-secondary">
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
                        <th class="col-4">{{ __('Email') }}</th>
                        <th class="col-8">{{ __('Permissões') }}</th>
                        @can('usuario-editar')
                            <th class="col-1 text-center" data-orderable="false">{{ __('Edit') }}</th>
                        @endcan
                        @can('usuario-inativar')
                            <th class="col-1 text-center" data-orderable="false">{{ __('Inativar') }}</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>        
                    @foreach ($users as $key => $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if(!empty($user->getRoleNames()))
                                    @foreach($user->getRoleNames() as $role)
                                        <span class="badge bg-success h6">{{ $role }}</span>
                                    @endforeach
                                @endif
                            </td>
                            @can('usuario-editar')
                                <td class="text-center">
                                    <a 
                                        class="text-success"
                                        href="{{ route('cadastro.usuario.edit', $user->id) }}"
                                    >
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                </td>
                            @endcan
                            @can('usuario-inativar')
                                <td class="text-center">
                                    <a 
                                        class="text-danger"
                                        href="{{ route('cadastro.usuario.inativar-ativar', $user->id) }}"
                                        onclick="event.preventDefault();
                                            inativar('usuario-{{ $user->id }}-form-inativar-ativar');"
                                    >
                                        <i class="fa-solid fa-delete-left"></i>
                                    </a>
                                    <form 
                                        id="usuario-{{ $user->id }}-form-inativar-ativar" 
                                        action="{{ route('cadastro.usuario.inativar-ativar', $user->id) }}" 
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