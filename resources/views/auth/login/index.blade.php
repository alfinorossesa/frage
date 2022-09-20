@extends('auth.layouts.main')
@section('content')

<div class="login-box">
    <div class="d-flex justify-content-center">
        <a href="/"><img src="{{ asset('assets/img/logo.png') }}" width="40px"></a>
    </div>

    <div class="row justify-content-center text-center mt-3">
        <div class="col-md-4 col-12">
            @if (session()->has('status'))
                <div class="alert alert-success" role="alert">
                    {{ session()->get('status') }}
                </div>
            @endif
        </div>
    </div>

    <div class="row justify-content-center text-center mt-3">
        <div class="col-md-4 col-12">
            <a href="{{ route('google.auth') }}">
                <div class="google-auth">
                    <p><img src="{{ asset('assets/img/google.png') }}" width="20px" class="mb-1"> Login with Google</p>
                </div>
            </a>
        </div>
    </div>
    <div class="row justify-content-center text-center mt-3">
        <div class="col-md-4 col-12">
            <a href="{{ route('github.auth') }}">
                <div class="github-auth">
                    <p><img src="{{ asset('assets/img/github.png') }}" width="20px" class="mb-1"> Login with GitHub</p>
                </div>
            </a>
        </div>
    </div>

    <div class="row justify-content-center mt-3">
        <div class="col-md-4 col-12">
            <div class="card">
                <div class="card-body login-form">
                    <form action="{{ route('login.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-1">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="text-left">
                            <a href="{{ route('forgotPassword') }}">Forgot Password?</a>
                        </div>
                        <div class="mt-3">
                            <input type="submit" value="Login" class="form-control btn btn-primary text-white">
                        </div>
                    </form>
                </div>
            </div>
            <p class="m-0 mt-3">Don't have an account? <a href="{{ route('signup') }}">Sign up</a></p>
        </div>
    </div>
</div>

@endsection