@extends('layouts.app')

@section('content')
<div class="container p-3">
    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
        <h2 class="h3 fw-bold h2-title-pages"><i class="fa-solid fa-pen-ruler"></i> {{ __('Reguladoras') }}</h2>
        <div>
            @can('reguladora-cadastrar')
                <a href="{{ route('cadastro.reguladora.create') }}" class="btn btn-new">
                    <i class="fa-solid fa-plus"></i> {{ __('New') }}
                </a>
            @endcan
            @can('reguladora-inativar')
                <a href="{{ route('cadastro.reguladora.inativos') }}" class="btn btn-deactive">
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
                @can('reguladora-editar')
                    <th class="col-1 text-center" data-orderable="false">{{ __('Edit') }}</th>
                @endcan
                @can('reguladora-inativar')
                    <th class="col-1 text-center" data-orderable="false">{{ __('Inativar') }}</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @foreach ($reguladoras as $reguladora)
                <tr>
                    <td>{{ $reguladora->razao_social }}</td>
                    <td class="label-cnpj" data-inputmask="'mask': '99.999.999/9999-99'">{{ $reguladora->cnpj }}</td>
                    <td>{{ $reguladora->nome_fantasia }}</td>
                    @can('reguladora-editar')
                        <td class="text-center">
                            <a
                                class="btn btn-edit"
                                href="{{ route('cadastro.reguladora.edit', $reguladora->id) }}"
                            >
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        </td>
                    @endcan
                    @can('reguladora-inativar')
                        <td class="text-center">
                            <a
                                class="btn btn-inactive"
                                href="{{ route('cadastro.reguladora.inativar-ativar', $reguladora->id) }}"
                                onclick="event.preventDefault();
                                    inativar('reguladora-{{ $reguladora->id }}-form-inativar-ativar');"
                            >
                                <i class="fa-solid fa-delete-left"></i>
                            </a>
                            <form
                                id="reguladora-{{ $reguladora->id }}-form-inativar-ativar"
                                action="{{ route('cadastro.reguladora.inativar-ativar', $reguladora->id) }}"
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
