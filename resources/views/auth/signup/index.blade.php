@extends('auth.layouts.main')
@section('content')

    <div class="d-flex justify-content-center">
        <a href="/"><img src="{{ asset('assets/img/logo.png') }}" width="40px"></a>
    </div>

    <div class="row justify-content-center text-center mt-3">
        <div class="col-md-4">
            <a href="{{ route('google.auth') }}">
                <div class="google-auth">
                    <p><img src="{{ asset('assets/img/google.png') }}" width="20px" class="mb-1"> Sign Up with Google</p>
                </div>
            </a>
        </div>
    </div>
    <div class="row justify-content-center text-center mt-3">
        <div class="col-md-4">
            <a href="{{ route('github.auth') }}">
                <div class="github-auth">
                    <p><img src="{{ asset('assets/img/github.png') }}" width="20px" class="mb-1"> Sign Up with GitHub</p>
                </div>
            </a>
        </div>
    </div>

    <div class="row justify-content-center mt-3">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body signup-form">
                    <form action="{{ route('signup.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" id="name" name="name">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" id="email" name="email">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>
                        <input type="submit" value="sign up" class="form-control btn btn-primary text-white">
                    </form>
                </div>
            </div>
            <p class="m-0 mt-3">Already have account? <a href="{{ route('login') }}">Login</a></p>
        </div>
    </div>
@endsection