@extends('layouts.app')

@section('content')
<div class="container bg-white p-5 rounded shadow-sm">
    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
        <h2 class="h3 fw-bold h2-title-pages">{{ __('Reguladoras Inativas') }}</h2>
        <div>
            <a href="{{ route('cadastro.reguladora.index') }}" class="btn btn-new">
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
                @can('reguladora-inativar')
                    <th class="col-1 text-center" data-orderable="false">{{ __('Ativar') }}</th>
                @endcan
                @can('reguladora-deletar')
                    <th class="col-1 text-center" data-orderable="false">{{ __('Delete') }}</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @foreach ($reguladoras as $reguladora)
                <tr>
                    <td>{{ $reguladora->razao_social }}</td>
                    <td class="label-cnpj" data-inputmask="'mask': '99.999.999/9999-99'">{{ $reguladora->cnpj }}</td>
                    <td>{{ $reguladora->nome_fantasia }}</td>
                    @can('reguladora-inativar')
                        <td class="text-center">
                            <a
                                class="btn btn-edit"
                                href="{{ route('cadastro.reguladora.inativar-ativar', $reguladora->id) }}"
                                onclick="event.preventDefault();
                                    ativar('reguladora-{{ $reguladora->id }}-form-inativar-ativar');"
                            >
                                <i class="fa-solid fa-check-to-slot"></i>
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
                    @can('reguladora-deletar')
                        <td class="text-center">
                            <a
                                class="btn btn-inactive"
                                href="{{ route('cadastro.reguladora.destroy', $reguladora->id) }}"
                                onclick="event.preventDefault();
                                    excluir('reguladora-{{ $reguladora->id }}-form');"
                            >
                                <i class="fa-solid fa-trash"></i>
                            </a>
                            <form
                                id="reguladora-{{ $reguladora->id }}-form"
                                action="{{ route('cadastro.reguladora.destroy', $reguladora->id) }}"
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
