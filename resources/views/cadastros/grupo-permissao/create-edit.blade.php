@extends('layouts.app')

@section('content')
<div class="container bg-white p-5 rounded shadow-sm">
    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
        <h2 class="h3 fw-bold h2-title-pages">{{ __('Novo Grupo de permissão') }}</h2>
        <div>
            <a href="{{ route('cadastro.grupo-permissao.index') }}" class="btn btn-new">
                <i class="fa-solid fa-arrow-left"></i> {{ __('Return') }}
            </a>
        </div>
    </div>

    <form
        method="POST"
        action="{{
            request()->routeIs('cadastro.grupo-permissao.create') ?
            route('cadastro.grupo-permissao.store') :
            route('cadastro.grupo-permissao.update', $user->id)
        }}"
    >
        @csrf
        @if (request()->routeIs('cadastro.grupo-permissao.edit'))
            @method('PUT')
        @endif

        <div class="row mb-3">
            <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Name') }}*</label>

            <div class="col-md-6">
                <input
                    id="name"
                    type="text"
                    class="form-control @error('name') is-invalid @enderror"
                    name="name"
                    value="{{ isset($user->name) ? $user->name : old('name') }}"
                    required
                    autocomplete="name"
                    autofocus
                >

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="roles" class="col-md-4 col-form-label text-md-end fw-bold">{{ __('Permissão') }}*</label>

            <div class="col-md-6">
                <select
                    id="roles"
                    class="form-select @error('roles') is-invalid @enderror"
                    name="roles[]"
                    value="{{ old('roles[]') }}"
                    required
                    multiple
                >
                    @foreach ($permissoes as $role)
                        <option
                            value="{{ $role->id }}"
                            @if (old('roles') !== null)
                                @foreach (old('roles') as $oldRole)
                                    @selected($oldRole == $role->id)
                                @endforeach
                            @elseif (isset($userRoles) && count($userRoles) > 0)
                                @foreach ($userRoles as $userRole)
                                    @selected($userRole == $role->id)
                                @endforeach
                            @endif
                        >{{$role->name}}</option>
                    @endforeach
                </select>

                @error('roles')
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
