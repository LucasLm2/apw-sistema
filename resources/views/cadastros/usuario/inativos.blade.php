@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>{{ __('Usuários') }}</div>
                <div>
                    <a href="{{ route('cadastro.usuario.index') }}" class="btn btn-primary">
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
                        <th class="col-4">{{ __('Email') }}</th>
                        <th class="col-8">{{ __('Permissões') }}</th>
                        @can('usuario-inativar')
                            <th class="col-1 text-center" data-orderable="false">{{ __('Ativar') }}</th>
                        @endcan
                        @can('usuario-deletar')
                            <th class="col-1 text-center" data-orderable="false">{{ __('Delete') }}</th>
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
                            @can('usuario-inativar')
                                <td class="text-center">
                                    <a 
                                        class="text-success"
                                        href="{{ route('cadastro.usuario.inativar-ativar', $user->id) }}"
                                        onclick="event.preventDefault();
                                            ativar('usuario-{{ $user->id }}-form-inativar-ativar');"
                                    >
                                        <i class="fa-solid fa-check-to-slot"></i>
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
                            @can('usuario-deletar')
                                <td class="text-center">
                                    <a 
                                        class="text-danger"
                                        href="{{ route('cadastro.usuario.destroy', $user->id) }}"
                                        onclick="event.preventDefault();
                                            excluir('usuario-{{ $user->id }}-form');"
                                    >
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                    <form 
                                        id="usuario-{{ $user->id }}-form" 
                                        action="{{ route('cadastro.usuario.destroy', $user->id) }}" 
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