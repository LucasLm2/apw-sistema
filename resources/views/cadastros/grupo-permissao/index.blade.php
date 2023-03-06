@extends('layouts.app')

@section('content')
<div class="container bg-white p-5 rounded shadow-sm">
    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
        <h2 class="h3 fw-bold h2-title-pages"><i class="fa-solid fa-lock"></i> {{ __('Grupo de permissões') }}</h2>
        <div>
            @can('grupo-permissao-cadastrar')
                <a href="{{ route('cadastro.grupo-permissao.create') }}" class="btn btn-new">
                    <i class="fa-solid fa-plus"></i> {{ __('New') }}
                </a>
            @endcan
            @can('grupo-permissao-inativar')
                <a href="{{ route('cadastro.grupo-permissao.inativos') }}" class="btn btn-deactive">
                    <i class="fa-solid fa-arrow-down"></i> {{ __('Inativos') }}
                </a>
            @endcan
        </div>
    </div>

    <table class="table table-lg table-striped table-hover datatable py-4">
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
                                class="btn btn-edit"
                                href="{{ route('cadastro.grupo-permissao.edit', $grupoPermissao->id) }}"
                            >
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        </td>
                    @endcan
                    @can('grupo-permissao-inativar')
                        <td class="text-center">
                            <a
                                class="btn btn-inactive"
                                href="{{ route('cadastro.grupo-permissao.inativar-ativar', $grupoPermissao->id) }}"
                                onclick="event.preventDefault();
                                    inativar('grupo-permissao-{{ $grupoPermissao->id }}-form-inativar-ativar');"
                            >
                                <i class="fa-solid fa-xmark"></i>
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
@endsection
