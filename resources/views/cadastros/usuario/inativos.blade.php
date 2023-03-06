@extends('layouts.app')

@section('content')
<div class="container bg-white p-5 rounded shadow-sm">
    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
        <h2 class="h4 fw-bold h2-title-pages">{{ __('Usuários inativos') }}</h2>
        <div>
            <a href="{{ route('cadastro.usuario.index') }}" class="btn btn-primary">
                <i class="fa-solid fa-arrow-left"></i> {{ __('Return') }}
            </a>
        </div>
    </div>

    <table class="table table-lg table-striped table-hover datatable py-4">
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
                                class="btn btn-edit"
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
                                class="btn btn-inactive"
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
@endsection
