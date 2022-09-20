@extends('auth.layouts.main')
@section('content')

<div class="login-box">
    <div class="d-flex justify-content-center">
        <a href="/"><img src="{{ asset('assets/img/logo.png') }}" width="40px"></a>
    </div>

    <div class="row justify-content-center mt-3">
        <div class="col-md-4 col-12">
            <div class="card">
                <div class="card-body login-form">
                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $request->email) }}">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
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
                        <div class="mt-3">
                            <input type="submit" value="Reset Password" class="form-control btn btn-primary text-white">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection