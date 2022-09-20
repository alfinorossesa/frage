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

    <div class="row justify-content-center mt-3">
        <div class="col-md-4 col-12">
            <div class="card">
                <div class="card-body login-form">
                    <p>Please enter your email account.</p>
                    <form action="{{ route('forgotPassword.store') }}" method="POST">
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
                        <div class="mt-3">
                            <input type="submit" value="Send Reset Password Link" class="form-control btn btn-primary text-white">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection