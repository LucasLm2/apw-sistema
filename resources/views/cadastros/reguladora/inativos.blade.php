@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>{{ __('Reguladoras Inativas') }}</div>
                <div>
                    <a href="{{ route('cadastro.reguladora.index') }}" class="btn btn-primary">
                        {{ __('Return') }}
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-sm table-striped table-hover">
                <thead>
                    <tr>
                        <th class="col-3">{{ __('Name') }}</th>
                        <th class="col-8">{{ __('CNPJ') }}</th>
                        <th class="col-1 text-center">{{ __('Ativar') }}</th>
                        <th class="col-1 text-center">{{ __('Delete') }}</th>
                    </tr>
                </thead>
                <tbody>        
                    @forelse ($reguladoras as $reguladora) 
                        <tr>
                            <td>{{ $reguladora->nome }}</td>
                            <td class="label-cnpj" data-inputmask="'mask': '99.999.999/9999-99'">{{ $reguladora->cnpj }}</td>
                            <td class="text-center">
                                <a 
                                    class="text-success"
                                    href="{{ route('cadastro.reguladora.inativar-ativar', $reguladora->id) }}"
                                    onclick="event.preventDefault();
                                        ativar('reguladora-{{ $reguladora->id }}-form');"
                                >
                                    <i class="fa-solid fa-check-to-slot"></i>
                                </a>
                                <form 
                                    id="reguladora-{{ $reguladora->id }}-form" 
                                    action="{{ route('cadastro.reguladora.inativar-ativar', $reguladora->id) }}" 
                                    method="POST" 
                                    class="d-none"
                                >
                                    @csrf
                                    @method('PUT');
                                </form>
                            </td>
                            <td class="text-center">
                                <a 
                                    class="text-danger"
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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Nenhum registro encontrado!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script type="module">
        Inputmask().mask(document.querySelectorAll(".label-cnpj"));
    </script>
@endsection