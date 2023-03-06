@extends('layouts.app')

@section('content')
<div class="container bg-white p-5 rounded shadow-sm">
    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
        <h2 class="h3 fw-bold h2-title-pages">{{ __('Novo tipo de servico') }}</h2>
        <div>
            <a href="{{ route('cadastro.tipo-servico.index') }}" class="btn btn-new">
                <i class="fa-solid fa-arrow-left"></i> {{ __('Return') }}
            </a>
        </div>
    </div>

    <form
        method="POST"
        action="{{
            request()->routeIs('cadastro.tipo-servico.create') ?
            route('cadastro.tipo-servico.store') :
            route('cadastro.tipo-servico.update', $tipoServico->id)
        }}"
    >
        @csrf
        @if (request()->routeIs('cadastro.tipo-servico.edit'))
            @method('PUT')
        @endif

        <div class="row mb-3">
            <label for="nome" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Name') }}</label>

            <div class="col-md-6">
                <input
                    id="nome"
                    type="text"
                    class="form-control @error('nome') is-invalid @enderror"
                    name="nome"
                    value="{{ isset($tipoServico->nome) ? $tipoServico->nome : old('nome') }}"
                    required
                    autofocus
                >

                @error('nome')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="descricao" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Description') }}</label>

            <div class="col-md-6">
                <input
                    id="descricao"
                    type="text"
                    class="form-control @error('descricao') is-invalid @enderror"
                    name="descricao"
                    value="{{ isset($tipoServico->descricao) ? $tipoServico->descricao : old('descricao') }}"
                >

                @error('descricao')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('Save') }}
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
