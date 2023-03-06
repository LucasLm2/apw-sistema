@extends('layouts.app')

@section('content')
<div class="container bg-white p-5 rounded shadow-sm">
    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
        <h2 class="h3 fw-bold h2-title-pages">{{ __('Seguradoras Inativos') }}</h2>
        <div>
            <a href="{{ route('cadastro.seguradora.index') }}" class="btn btn-new">
                <i class="fa-solid fa-arrow-left"></i> {{ __('Return') }}
            </a>
        </div>
    </div>

    <table class="table table-lg table-striped table-hover datatable py-4">
        <thead>
            <tr>
                <th class="col-5">{{ __('Razão Social') }}</th>
                <th class="col-2">{{ __('CNPJ') }}</th>
                <th class="col-4">{{ __('Nome Fantasia') }}</th>
                @can('seguradora-inativar')
                    <th class="col-1 text-center">{{ __('Ativar') }}</th>
                @endcan
                @can('seguradora-deletar')
                    <th class="col-1 text-center">{{ __('Delete') }}</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @foreach ($seguradoras as $seguradora)
                <tr>
                    <td>{{ $seguradora->razao_social }}</td>
                    <td class="label-cnpj" data-inputmask="'mask': '99.999.999/9999-99'">{{ $seguradora->cnpj }}</td>
                    <td>{{ $seguradora->nome_fantasia }}</td>
                    @can('seguradora-inativar')
                        <td class="text-center">
                            <a
                                class="btn btn-edit"
                                href="{{ route('cadastro.seguradora.inativar-ativar', $seguradora->id) }}"
                                onclick="event.preventDefault();
                                    ativar('seguradora-{{ $seguradora->id }}-form-inativar-ativar');"
                            >
                                <i class="fa-solid fa-check-to-slot"></i>
                            </a>
                            <form
                                id="seguradora-{{ $seguradora->id }}-form-inativar-ativar"
                                action="{{ route('cadastro.seguradora.inativar-ativar', $seguradora->id) }}"
                                method="POST"
                                class="d-none"
                            >
                                @csrf
                                @method('PUT');
                            </form>
                        </td>
                    @endcan
                    @can('seguradora-deletar')
                        <td class="text-center">
                            <a
                                class="btn btn-inactive"
                                href="{{ route('cadastro.seguradora.destroy', $seguradora->id) }}"
                                onclick="event.preventDefault();
                                    excluir('seguradora-{{ $seguradora->id }}-form');"
                            >
                                <i class="fa-solid fa-trash"></i>
                            </a>
                            <form
                                id="seguradora-{{ $seguradora->id }}-form"
                                action="{{ route('cadastro.seguradora.destroy', $seguradora->id) }}"
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

@section('scripts')
    <script type="module">
        Inputmask().mask(document.querySelectorAll(".label-cnpj"));
    </script>
@endsection
