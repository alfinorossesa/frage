@extends('home.layouts.main')
@section('content')

    <div class="change-password-box">
        @if (auth()->user()->oauth)
            <div class="col-md-5">
                <div class="card error-change-password">
                    <div class="card-body">
                        <h5>Ups...</h5>
                        <p class="card-text m-0">You are login with {{ auth()->user()->oauth }}.</p>
                        <p class="card-text">You can't change your password.</p>
                        <a href="{{ route('user.index', [$user->id, $user->username]) }}">Back to profile</a>
                    </div>
                </div>
            </div>
        @else   
            <h3>Change Password</h3>

            <div class="row mt-4">
                <div class="col-md-5 col-12 change-password">
                    <form action="{{ route('user.changePasswordStore', [$user->id, $user->username]) }}" method="post">
                    @csrf 
                    @method('put')
                        <div class="py-1">
                            <label for="old_password" class="form-label">Old Password</label>
                            <input type="password" id="old_password" name="old_password" class="form-control @error('old_password') is-invalid @enderror">
                            @error('old_password')
                                <div class="is-invalid text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="py-1">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                                <div class="is-invalid text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="py-1">
                            <label for="password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror">
                            @error('password_confirmation')
                                <div class="is-invalid text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <input style="display: none" type="file" id="picture" name="picture" onchange="previewImage()">
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('user.index', [$user->id, $user->username]) }}" class="btn btn-sm btn-outline-secondary mt-3 mr-2">Cancel</a>
                            <button type="submit" class="btn btn-sm btn-primary mt-3">Confirm Change</button>
                        </div>
                    </form>
                </div>
            </div> 
        @endif
    </div>
    
@endsection