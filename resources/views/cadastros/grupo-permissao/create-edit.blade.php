@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>{{ __('Novo Grupo de permissão') }}</div>
                <div>
                    <a href="{{ route('cadastro.grupo-permissao.index') }}" class="btn btn-primary">
                        {{ __('Return') }}
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
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
    </div>
</div>
@endsection