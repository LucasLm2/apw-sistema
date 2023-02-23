@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>{{ __('Novo Usuário') }}</div>
                <div>
                    <a href="{{ route('cadastro.usuario.index') }}" class="btn btn-primary">
                        {{ __('Return') }}
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
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
                    <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}*</label>

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
                    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}*</label>

                    <div class="col-md-6">
                        <input 
                            id="email" 
                            type="email" 
                            class="form-control @error('email') is-invalid @enderror" 
                            name="email" 
                            value="{{ isset($user->email) ? $user->email : old('email') }}" 
                            required 
                            autocomplete="email"
                        >

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="password" class="col-md-4 col-form-label text-md-end">
                        {{ __('Password') }}@if (request()->routeIs('cadastro.usuario.create'))*@endif
                    </label>

                    <div class="col-md-6">
                        <input 
                            id="password" 
                            type="password" 
                            class="form-control @error('password') is-invalid @enderror" 
                            name="password" 
                            {{ request()->routeIs('cadastro.usuario.create') ? 'required' : '' }}
                            autocomplete="new-password"
                        >

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="password-confirm" class="col-md-4 col-form-label text-md-end">
                        {{ __('Confirm Password') }}@if (request()->routeIs('cadastro.usuario.create'))*@endif
                    </label>

                    <div class="col-md-6">
                        <input 
                            id="password-confirm" 
                            type="password" 
                            class="form-control" 
                            name="password_confirmation" 
                            {{ request()->routeIs('cadastro.usuario.create') ? 'required' : '' }}
                            autocomplete="new-password"
                        >
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="roles" class="col-md-4 col-form-label text-md-end">{{ __('Permissão') }}*</label>

                    <div class="col-md-6">
                        <select 
                            id="roles" 
                            class="form-select @error('roles') is-invalid @enderror" 
                            name="roles[]" 
                            value="{{ old('roles[]') }}"
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
    </div>
</div>
@endsection