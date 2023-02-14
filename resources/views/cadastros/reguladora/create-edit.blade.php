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
                    <input type="hidden" name="endereco_id" value="{{ $reguladora->endereco_id }}">
                @endif

                <div class="row mb-3">
                    <label for="nome" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}*</label>

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
                    <label for="descricao" class="col-md-4 col-form-label text-md-end">{{ __('CNPJ') }}*</label>

                    <div class="col-md-6">
                        <input 
                            id="descricao" 
                            type="text" 
                            class="form-control @error('cnpj') is-invalid @enderror" 
                            name="cnpj" 
                            value="{{ isset($reguladora->cnpj) ? $reguladora->cnpj : old('cnpj') }}"
                            data-inputmask="'mask': '99.999.999/9999-99'"
                            required
                        >

                        @error('cnpj')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="inscricao-estadual" class="col-md-4 col-form-label text-md-end">{{ __('Inscrição Estadual') }}</label>

                    <div class="col-md-6">
                        <input 
                            id="inscricao-estadual" 
                            type="text" 
                            class="form-control @error('inscricao_estadual') is-invalid @enderror" 
                            name="inscricao_estadual" 
                            value="{{ isset($reguladora->inscricao_estadual) ? $reguladora->inscricao_estadual : old('inscricao_estadual') }}"
                        >

                        @error('inscricao_estadual')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="site" class="col-md-4 col-form-label text-md-end">{{ __('Site') }}</label>

                    <div class="col-md-6">
                        <input 
                            id="site" 
                            type="text" 
                            class="form-control @error('site') is-invalid @enderror" 
                            name="site" 
                            value="{{ isset($reguladora->site) ? $reguladora->site : old('site') }}"
                        >

                        @error('site')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3 d-none">
                    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>

                    <div class="col-md-6">
                        <input 
                            id="email" 
                            type="email" 
                            class="form-control @error('email') is-invalid @enderror" 
                            name="email" 
                            value="{{ isset($reguladora->email) ? $reguladora->email : old('email') }}"
                        >

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                @if (isset($telefones) && $telefones != null)
                    @foreach ($telefones as $telefone)
                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">{{ __('Telefone') }}</label>
        
                            <div class="col-md-6">
                                <div class="d-flex">
                                    <input 
                                        type="text" 
                                        class="form-control telefone-mask @error('telefone') is-invalid @enderror" 
                                        name="telefones[]" 
                                        value="{{ isset($telefone) ? $telefone : old('telefone') }}"
                                    >
                                    <button type="button" class="btn btn-success ms-2" onclick="duplicarCampos(this, 'destino-telefone');">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger ms-2" onclick="removerCampo(this)">
                                        <i class="fa-solid fa-minus"></i>
                                    </button> 
                                </div>
                                
                                @error('telefone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label text-md-end">{{ __('Telefone') }}</label>

                        <div class="col-md-6">
                            <div class="d-flex">
                                <input 
                                    type="text" 
                                    class="form-control telefone-mask @error('telefone') is-invalid @enderror" 
                                    name="telefones[]" 
                                    value="{{ isset($telefone) ? $telefone : old('telefone') }}"
                                >
                                <button type="button" class="btn btn-success ms-2" onclick="duplicarCampos(this, 'destino-telefone');">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                                <button type="button" class="btn btn-danger ms-2" onclick="removerCampo(this)">
                                    <i class="fa-solid fa-minus"></i>
                                </button> 
                            </div>
                            
                            @error('telefone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                @endif

                <div id="destino-telefone">
                </div>
                
                <div class="row mb-3">
                    <label for="cep" class="col-md-4 col-form-label text-md-end">{{ __('CEP') }}</label>
                    
                    <div class="col-md-6">
                        <input 
                            id="cep" 
                            type="text" 
                            class="form-control @error('cep') is-invalid @enderror" 
                            name="cep" 
                            value="{{ isset($reguladora->cep) ? $reguladora->cep : old('cep') }}"
                            data-inputmask="'mask': '99.999-999'"
                            onblur="pesquisaCep(this.value)"
                        >

                        @error('cep')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>                   
                </div>
                
                <div class="row mb-3">
                    <label for="estado" class="col-md-4 col-form-label text-md-end">{{ __('Estado') }}</label>

                    <div class="col-md-6">
                        <select 
                            id="estado" 
                            class="form-select @error('estado') is-invalid @enderror" 
                            name="estado" 
                            value="{{ isset($reguladora->estado) ? $reguladora->estado : old('estado') }}"
                            onchange="buscarMunicipios(this.value)"
                        >
                            <option value="">Selecione...</option>
                            @foreach ($estados as $estado)
                                <option 
                                    value="{{$estado->uf}}" 
                                    @selected(
                                        isset($reguladora->estado) ? 
                                            $reguladora->estado == $estado->uf : 
                                            old('estado') == $estado->uf
                                        )
                                >{{$estado->nome}}</option>
                            @endforeach
                        </select>

                        @error('estado')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="municipio" class="col-md-4 col-form-label text-md-end">Município</label>
                    
                    <div class="col-md-6">                    
                        <select 
                            id="municipio" 
                            class="form-select @error('municipio') is-invalid @enderror" 
                            name="municipio" 
                            value="{{ isset($reguladora->municipio) ? $reguladora->municipio : old('municipio') }}"
                        >
                            <option value="">Selecione...</option>
                        </select>

                        @error('municipio')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="bairro" class="col-md-4 col-form-label text-md-end">Bairro</label>
                    
                    <div class="col-md-6"> 
                        <input 
                            id="bairro" 
                            type="text" 
                            class="form-control @error('bairro') is-invalid @enderror" 
                            name="bairro"
                            value="{{ isset($reguladora->bairro) ? $reguladora->bairro : old('bairro') }}" 
                        >

                        @error('bairro')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="rua" class="col-md-4 col-form-label text-md-end">Rua</label>

                    <div class="col-md-6"> 
                        <input 
                            id="rua" 
                            type="text" 
                            class="form-control @error('rua') is-invalid @enderror" 
                            name="rua"
                            value="{{ isset($reguladora->rua) ? $reguladora->rua : old('rua') }}" 
                        >

                        @error('rua')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="numero" class="col-md-4 col-form-label text-md-end">Número</label>

                    <div class="col-md-6"> 
                        <input  
                            id="numero" 
                            type="text" 
                            class="form-control @error('numero') is-invalid @enderror"
                            name="numero"
                            value="{{ isset($reguladora->numero) ? $reguladora->numero : old('numero') }}" 
                        >

                        @error('numero')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>                    
                </div>

                <div class="row mb-3">
                    <label for="complemento" class="col-md-4 col-form-label text-md-end">Complemento</label>

                    <div class="col-md-6"> 
                        <input 
                            id="complemento" 
                            type="text" 
                            class="form-control @error('complemento') is-invalid @enderror" 
                            name="complemento"
                            value="{{ isset($reguladora->complemento) ? $reguladora->complemento : old('complemento') }}" 
                        >

                        @error('complemento')
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

@section('scripts')
    <script type="module">
        mascaraTelefoneCelular('.telefone-mask');
        mascaraPorAtributo(document.querySelectorAll("input"));
        @if (request()->routeIs('cadastro.reguladora.edit'))
            await buscarMunicipios('{!! $reguladora->estado !!}');
            document.getElementById('municipio').value = '{!! $reguladora->municipio !!}';
        @endif
    </script>
@endsection
