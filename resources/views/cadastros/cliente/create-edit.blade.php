@extends('layouts.app')

@section('content')
<div class="container p-3">
    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
        @if (request()->routeIs('cadastro.cliente.edit'))
            <h2 class="h4 fw-bold h2-title-pages"><i class="fa-solid fa-pen-to-square"></i> {{ __('Editar cliente') }}</h2>
        @else
            <h2 class="h4 fw-bold h2-title-pages"><i class="fa-solid fa-plus"></i> {{ __('Novo cliente') }}</h2>
        @endif
        <div>
            <a href="{{ route('cadastro.cliente.index') }}" class="btn btn-new">
                <i class="fa-solid fa-arrow-left"></i> {{ __('Return') }}
            </a>
        </div>
    </div>

    <form
        method="POST"
        action="{{
            request()->routeIs('cadastro.cliente.create') ?
            route('cadastro.cliente.store') :
            route('cadastro.cliente.update', $cliente->id)
        }}"
    >
        @csrf
        @if (request()->routeIs('cadastro.cliente.edit'))
            @method('PUT')
            <input type="hidden" name="endereco_id" value="{{ $cliente->endereco_id }}">
        @endif

        <div class="row mb-3">
            <label for="razao_social" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Razão Social') }}*</label>

            <div class="col-md-6">
                <input
                    id="razao_social"
                    type="text"
                    class="form-control @error('razao_social') is-invalid @enderror"
                    name="razao_social"
                    value="{{ isset($cliente->razao_social) ? $cliente->razao_social : old('razao_social') }}"
                    required
                    autofocus
                >

                @error('razao_social')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="cpf-cnpj" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('CPF/CNPJ') }}*</label>

            <div class="col-md-6">
                <input
                    id="cpf-cnpj"
                    type="text"
                    class="form-control cpf-cnpj-mask @error('cpf_cnpj') is-invalid @enderror"
                    name="cpf_cnpj"
                    value="{{ isset($cliente->cpf_cnpj) ? $cliente->cpf_cnpj : old('cpf_cnpj') }}"
                    required
                >

                @error('cpf_cnpj')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="nome_fantasia" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Nome Fantasia') }}</label>

            <div class="col-md-6">
                <input
                    id="nome_fantasia"
                    type="text"
                    class="form-control @error('nome_fantasia') is-invalid @enderror"
                    name="nome_fantasia"
                    value="{{ isset($cliente->nome_fantasia) ? $cliente->nome_fantasia : old('nome_fantasia') }}"
                >

                @error('nome_fantasia')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="inscricao-estadual" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Inscrição Estadual') }}</label>

            <div class="col-md-6">
                <input
                    id="inscricao-estadual"
                    type="text"
                    class="form-control @error('inscricao_estadual') is-invalid @enderror"
                    name="inscricao_estadual"
                    value="{{ isset($cliente->inscricao_estadual) ? $cliente->inscricao_estadual : old('inscricao_estadual') }}"
                >

                @error('inscricao_estadual')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="site" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Site') }}</label>

            <div class="col-md-6">
                <input
                    id="site"
                    type="text"
                    class="form-control @error('site') is-invalid @enderror"
                    name="site"
                    value="{{ isset($cliente->site) ? $cliente->site : old('site') }}"
                >

                @error('site')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        @if (isset($emails) && count($emails) > 0)
            @foreach ($emails as $email)
                <div class="row mb-3">
                    <label class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Email') }}</label>

                    <div class="col-md-6">
                        <div class="d-flex">
                            <input
                                type="text"
                                class="form-control @error('email->email') is-invalid @enderror"
                                name="emails[]"
                                value="{{ isset($email->email) ? $email->email : old('email->email') }}"
                            >
                            <input
                                type="text"
                                class="form-control @error('email->email') is-invalid @enderror"
                                name="emails_contatos[]"
                                placeholder="Nome de Contato"
                                value="{{ isset($email->nome_contato) ? $email->nome_contato : old('email->nome_contato') }}"
                            >
                            <button type="button" class="btn btn-success ms-2" onclick="duplicarCampos(this, 'destino-email');">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                            <button type="button" class="btn btn-danger ms-2" onclick="removerCampo(this)">
                                <i class="fa-solid fa-minus"></i>
                            </button>
                        </div>

                        @error('email->email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            @endforeach
        @else
            <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Email') }}</label>

                <div class="col-md-6">
                    <div class="d-flex">
                        <input
                            type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            name="emails[]"
                            value="{{ isset($email) ? $email : old('email') }}"
                        >
                        <input
                            type="text"
                            class="form-control @error('email') is-invalid @enderror"
                            name="emails_contatos[]"
                            placeholder="Nome de Contato"
                            value="{{ isset($emai_contato) ? $emai_contato : old('emai_contato') }}"
                        >

                        <button type="button" class="btn btn-success ms-2" onclick="duplicarCampos(this, 'destino-email');">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                        <button type="button" class="btn btn-danger ms-2" onclick="removerCampo(this)">
                            <i class="fa-solid fa-minus"></i>
                        </button>
                    </div>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        @endif

        <div id="destino-email">
        </div>

        @if (isset($telefones) && count($telefones) > 0)
            @foreach ($telefones as $telefone)
                <div class="row mb-3">
                    <label class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Telefone') }}</label>

                    <div class="col-md-6">
                        <div class="d-flex">
                            <input
                                type="text"
                                class="form-control telefone-mask @error('telefone') is-invalid @enderror"
                                name="telefones[]"
                                value="{{ isset($telefone->numero) ? $telefone->numero : old('telefone->numero') }}"
                            >
                            <input
                                type="text"
                                class="form-control @error('telefone') is-invalid @enderror"
                                name="telefones_contatos[]"
                                placeholder="Nome de Contato"
                                value="{{ isset($telefone->nome_contato) ? $telefone->nome_contato : old('telefone->nome_contato') }}"
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
                <label class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Telefone') }}</label>

                <div class="col-md-6">
                    <div class="d-flex">
                        <input
                            type="text"
                            class="form-control telefone-mask @error('telefone') is-invalid @enderror"
                            name="telefones[]"
                            value="{{ isset($telefone) ? $telefone : old('telefone') }}"
                        >
                        <input
                            type="text"
                            class="form-control @error('telefone') is-invalid @enderror"
                            name="telefones_contatos[]"
                            placeholder="Nome de Contato"
                            value="{{ isset($telefone->nome_contato) ? $telefone->nome_contato : old('telefone->nome_contato') }}"
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
            <label for="cep" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('CEP') }}</label>

            <div class="col-md-6">
                <input
                    id="cep"
                    type="text"
                    class="form-control @error('cep') is-invalid @enderror"
                    name="cep"
                    value="{{ isset($cliente->cep) ? $cliente->cep : old('cep') }}"
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
            <label for="estado" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Estado') }}</label>

            <div class="col-md-6">
                <select
                    id="estado"
                    class="form-select @error('estado') is-invalid @enderror"
                    name="estado"
                    value="{{ isset($cliente->estado) ? $cliente->estado : old('estado') }}"
                    onchange="buscarMunicipios(this.value)"
                >
                    <option value="">Selecione...</option>
                    @foreach ($estados as $estado)
                        <option
                            value="{{$estado->uf}}"
                            @selected(
                                isset($cliente->estado) ?
                                    $cliente->estado == $estado->uf :
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
            <label for="municipio" class="col-md-4 col-form-label text-md-end fw-bold">Município</label>

            <div class="col-md-6">
                <select
                    id="municipio"
                    class="form-select @error('municipio') is-invalid @enderror"
                    name="municipio"
                    value="{{ isset($cliente->municipio) ? $cliente->municipio : old('municipio') }}"
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
            <label for="bairro" class="col-md-4 col-form-label text-md-end fw-bold">Bairro</label>

            <div class="col-md-6">
                <input
                    id="bairro"
                    type="text"
                    class="form-control @error('bairro') is-invalid @enderror"
                    name="bairro"
                    value="{{ isset($cliente->bairro) ? $cliente->bairro : old('bairro') }}"
                >

                @error('bairro')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="rua" class="col-md-4 col-form-label text-md-end fw-bold">Rua</label>

            <div class="col-md-6">
                <input
                    id="rua"
                    type="text"
                    class="form-control @error('rua') is-invalid @enderror"
                    name="rua"
                    value="{{ isset($cliente->rua) ? $cliente->rua : old('rua') }}"
                >

                @error('rua')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="numero" class="col-md-4 col-form-label text-md-end fw-bold">Número</label>

            <div class="col-md-6">
                <input
                    id="numero"
                    type="text"
                    class="form-control @error('numero') is-invalid @enderror"
                    name="numero"
                    value="{{ isset($cliente->numero) ? $cliente->numero : old('numero') }}"
                >

                @error('numero')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="complemento" class="col-md-4 col-form-label text-md-end fw-bold">Complemento</label>

            <div class="col-md-6">
                <input
                    id="complemento"
                    type="text"
                    class="form-control @error('complemento') is-invalid @enderror"
                    name="complemento"
                    value="{{ isset($cliente->complemento) ? $cliente->complemento : old('complemento') }}"
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
@endsection

@section('scripts')
    <script type="module">
        mascaraTelefoneCelular('.telefone-mask');
        mascaraCpfCnpj('.cpf-cnpj-mask');
        mascaraPorAtributo(document.querySelectorAll("input"));
        @if (request()->routeIs('cadastro.cliente.edit'))
            await buscarMunicipios('{!! $cliente->estado !!}');
            document.getElementById('municipio').value = '{!! $cliente->municipio !!}';
        @endif
    </script>
@endsection
