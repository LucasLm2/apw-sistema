@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center">
    <div class="col-md-8 col-lg-6 col-xl-5 bg-white p-5 rounded shadow-sm">
        <h2 class="h3 h2-title-pages border-bottom pb-3 mb-4 fw-bold"><i class="fa-solid fa-right-to-bracket"></i> {{ __('Login') }}</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="form-floating">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="example@example.com" value="{{ old('email') }}" required autocomplete="email">
                        <label class="fw-bold" for="email"><i class="fa-solid fa-at"></i> {{ __('Email Address') }}</label>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong><i class="fa-solid fa-triangle-exclamation"></i>  {{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="form-floating">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="password">
                        <label class="fw-bold" for="password"><i class="fa-solid fa-key"></i> {{ __('Password') }}</label>

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong><i class="fa-solid fa-triangle-exclamation"></i> {{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="d-flex justify-content-between">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                    <div>
                        @if (Route::has('password.request'))
                            <a class="link-primary text-decoration-none" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row mb-0">
                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-lg px-4">
                        Acessar<!--{{ __('Login') }}-->
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
