@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>{{ __('Segurados') }}</div>
                <div>
                    <a href="{{ route('cadastro.segurado.create') }}" class="btn btn-primary">
                        {{ __('New') }}
                    </a>
                    <a href="{{ route('cadastro.segurado.inativos') }}" class="btn btn-secondary">
                        {{ __('Inativos') }}
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
                        <th class="col-1 text-center">{{ __('Edit') }}</th>
                        <th class="col-1 text-center">{{ __('Inativar') }}</th>
                    </tr>
                </thead>
                <tbody>        
                    @forelse ($segurados as $segurado) 
                        <tr>
                            <td>{{ $segurado->nome }}</td>
                            <td class="label-cnpj" data-inputmask="'mask': '99.999.999/9999-99'">{{ $segurado->cnpj }}</td>
                            <td class="text-center">
                                <a 
                                    class="text-success"
                                    href="{{ route('cadastro.segurado.edit', $segurado->id) }}"
                                >
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <a 
                                    class="text-danger"
                                    href="{{ route('cadastro.segurado.inativar-ativar', $segurado->id) }}"
                                    onclick="event.preventDefault();
                                        inativar('segurado-{{ $segurado->id }}-form-inativar-ativar');"
                                >
                                    <i class="fa-solid fa-delete-left"></i>
                                </a>
                                <form 
                                    id="segurado-{{ $segurado->id }}-form-inativar-ativar" 
                                    action="{{ route('cadastro.segurado.inativar-ativar', $segurado->id) }}" 
                                    method="POST" 
                                    class="d-none"
                                >
                                    @csrf
                                    @method('PUT');
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