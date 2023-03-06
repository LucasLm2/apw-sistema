@extends('layouts.app')

@section('content')
<div class="col-md-8 col-lg-6 col-xl-5 bg-white p-5 rounded shadow-sm m-auto">
    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
        @if (request()->routeIs('cadastro.usuario.edit'))
            <h2 class="h4 h2-title-pages fw-bold color-primary"><i class="fa-solid fa-pen-to-square"></i> {{ __('Editar Usuário') }}</h2>
        @else
            <h2 class="h4 h2-title-pages fw-bold color-primary"><i class="fa-solid fa-user-group"></i> {{ __('Novo Usuário') }}</h2>
        @endif
        <div>
            <a href="{{ route('cadastro.usuario.index') }}" class="btn btn-new">
                <i class="fa-solid fa-arrow-left"></i> {{ __('Return') }}
            </a>
        </div>
    </div>

    <form
        method="POST"
        action="{{
            request()->routeIs('cadastro.usuario.create') ?
            route('cadastro.usuario.store') :
            route('cadastro.usuario.update', $user->id)
        }}"
    >
        @csrf
        @if (request()->routeIs('cadastro.usuario.edit'))
            @method('PUT')
        @endif

        <div class="row mb-3">
            <div class="col-12">
                <div class="form-floating">
                    <input
                        id="name"
                        type="text"
                        class="form-control @error('name') is-invalid @enderror"
                        name="name"
                        value="{{ isset($user->name) ? $user->name : old('name') }}"
                        required
                        autocomplete="name"
                        placeholder="name"
                    >
                    <label class="fw-bold" for="name"><i class="fa-solid fa-pen-nib"></i> {{ __('Name') }} *</label>

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <div class="form-floating">
                    <input
                        id="email"
                        type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        name="email"
                        value="{{ isset($user->email) ? $user->email : old('email') }}"
                        required
                        autocomplete="email"
                        placeholder="email"
                    >
                    <label class="fw-bold" for="email"><i class="fa-solid fa-at"></i> {{ __('Email Address') }} *</label>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <div class="form-floating">
                    <input
                        id="password"
                        type="password"
                        class="form-control @error('password') is-invalid @enderror"
                        name="password"
                        placeholder="password"
                        {{ request()->routeIs('cadastro.usuario.create') ? 'required' : '' }}
                        autocomplete="new-password"
                    >
                    <label class="fw-bold" for="password">
                        <i class="fa-solid fa-key"></i> {{ __('Password') }}@if (request()->routeIs('cadastro.usuario.create')) *@endif
                    </label>

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <div class="form-floating">
                    <input
                        id="password-confirm"
                        type="password"
                        class="form-control"
                        name="password_confirmation"
                        placeholder="password-confirm"
                        {{ request()->routeIs('cadastro.usuario.create') ? 'required' : '' }}
                        autocomplete="new-password"
                    >
                    <label class="fw-bold" for="password-confirm">
                        <i class="fa-solid fa-key"></i> {{ __('Confirm Password') }}@if (request()->routeIs('cadastro.usuario.create')) *@endif
                    </label>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <div class="form-floating">
                    <select
                        id="roles"
                        class="form-select @error('roles') is-invalid @enderror"
                        name="roles[]"
                        value="{{ old('roles[]') }}"
                        style="height: 180px;"
                        required
                        multiple
                    >
                        @foreach ($roles as $role)
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
                    <label class="fw-bold" for="roles"><i class="fa-solid fa-lock"></i> {{ __('Permissão') }} *</label>

                    @error('roles')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row mb-0">
            <div class="text-right">
                <button type="submit" class="btn btn-primary btn-lg px-3">
                    {{ __('Save') }}
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
