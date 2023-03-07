@extends('layouts.app')

@section('content')
<div class="container p-3">
    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
        <h2 class="h3 fw-bold h2-title-pages"><i class="fa-solid fa-shield-halved"></i> {{ __('Seguradoras') }}</h2>
        <div>
            @can('seguradora-cadastrar')
                <a href="{{ route('cadastro.seguradora.create') }}" class="btn link-primary btn-new me-2">
                    <i class="fa-solid fa-plus"></i> {{ __('New') }}
                </a>
            @endcan
            @can('seguradora-inativar')
                <a href="{{ route('cadastro.seguradora.inativos') }}" class="btn btn-deactive">
                    <i class="fa-solid fa-arrow-down"></i> {{ __('Inativos') }}
                </a>
            @endcan
        </div>
    </div>

    <table class="table table-lg table-striped table-hover datatable py-4">
        <thead>
            <tr>
                <th class="col-5">{{ __('Razão Social') }}</th>
                <th class="col-2">{{ __('CNPJ') }}</th>
                <th class="col-4">{{ __('Nome Fantasia') }}</th>
                @can('seguradora-editar')
                    <th class="col-1 text-center" data-orderable="false">{{ __('Edit') }}</th>
                @endcan
                @can('seguradora-inativar')
                    <th class="col-1 text-center" data-orderable="false">{{ __('Inativar') }}</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @foreach ($seguradoras as $seguradora)
                <tr>
                    <td>{{ $seguradora->razao_social }}</td>
                    <td class="label-cnpj" data-inputmask="'mask': '99.999.999/9999-99'">{{ $seguradora->cnpj }}</td>
                    <td>{{ $seguradora->nome_fantasia }}</td>
                    @can('seguradora-editar')
                        <td class="text-center">
                            <a
                                class="btn btn-edit"
                                href="{{ route('cadastro.seguradora.edit', $seguradora->id) }}"
                            >
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        </td>
                    @endcan
                    @can('seguradora-inativar')
                        <td class="text-center">
                            <a
                                class="btn btn-inactive"
                                href="{{ route('cadastro.seguradora.inativar-ativar', $seguradora->id) }}"
                                onclick="event.preventDefault();
                                    inativar('seguradora-{{ $seguradora->id }}-form-inativar-ativar');"
                            >
                                <i class="fa-solid fa-xmark"></i>
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
