@extends('layouts.app')

@section('content')
<div class="container p-3">
    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
        <h2 class="h4 fw-bold h2-title-pages">{{ __('Grupo de permissões inativas') }}</h2>
        <div>
            <a href="{{ route('cadastro.grupo-permissao.index') }}" class="btn btn-new">
                <i class="fa-solid fa-arrow-left"></i> {{ __('Return') }}
            </a>
        </div>
    </div>

    <table class="table table-lg table-striped table-hover datatable py-4">
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
                                class="btn btn-edit"
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
                                class="btn btn-inactive"
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
@endsection
