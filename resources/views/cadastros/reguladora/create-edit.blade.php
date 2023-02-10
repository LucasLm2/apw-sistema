@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>{{ __('Nova reguladora') }}</div>
                <div>
                    <a href="{{ route('cadastro.reguladora.index') }}" class="btn btn-primary">
                        {{ __('Return') }}
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <form 
                method="POST" 
                action="{{ 
                    request()->routeIs('cadastro.reguladora.create') ?
                    route('cadastro.reguladora.store') : 
                    route('cadastro.reguladora.update', $reguladora->id)
                }}"
            >
                @csrf
                @if (request()->routeIs('cadastro.reguladora.edit'))
                    @method('PUT')
                @endif

                <div class="row mb-3">
                    <label for="nome" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                    <div class="col-md-6">
                        <input 
                            id="nome" 
                            type="text" 
                            class="form-control @error('nome') is-invalid @enderror" 
                            name="nome" 
                            value="{{ isset($reguladora->nome) ? $reguladora->nome : old('nome') }}" 
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
                    <label for="descricao" class="col-md-4 col-form-label text-md-end">{{ __('CNPJ') }}</label>

                    <div class="col-md-6">
                        <input 
                            id="descricao" 
                            type="text" 
                            class="form-control @error('cnpj') is-invalid @enderror" 
                            name="cnpj" 
                            value="{{ isset($reguladora->cnpj) ? $reguladora->cnpj : old('cnpj') }}"
                        >

                        @error('cnpj')
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
    </div>
</div>
@endsection
