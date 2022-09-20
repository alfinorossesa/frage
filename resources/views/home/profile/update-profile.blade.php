@extends('home.layouts.main')
@section('content')

    <div class="update-profile-box">
        <h3>Update Profile</h3>

        <div class="row mt-4">
            <div class="col-md-2 col-12 mt-3 change-picture">
                <div>
                    @if ($user->oauth_picture !== null)
                        <img src="{{ $user->oauth_picture }}" alt="..." width="130px" height="130px" class="img-preview">
                    @else
                        <img src="{{ $user->picture ? asset('assets/profile-picture/'. $user->picture) : asset('assets/profile-picture/default.png') }}" alt="..." width="130px" height="130px" class="img-preview">
                    @endif
                    <div class="change-picture-button">
                        <label for="picture" class="btn btn-sm btn-outline-secondary mt-3" style="cursor: pointer;">Change Picture</label>
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-12 update-profile">
                <form action="{{ route('user.updateProfileStore', [$user->id, $user->username]) }}" method="post" enctype="multipart/form-data">
                @csrf 
                @method('put')
                    <div class="py-1">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}">
                        @error('name')
                            <div class="is-invalid text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="py-1">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('name', $user->email) }}">
                        @error('email')
                            <div class="is-invalid text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <a href="{{ route('user.changePassword', [$user->id, $user->username]) }}">Change Password?</a>
                    <input style="display: none" type="file" id="picture" name="picture" onchange="previewImage()">
                    <input type="hidden" name="oauth_picture" value="{{ null }}">
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('user.index', [$user->id, $user->username]) }}" class="btn btn-sm btn-outline-secondary mt-3 mr-2">Cancel</a>
                        <button type="submit" class="btn btn-sm btn-primary mt-3">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script>
        function previewImage() {
            const image = document.querySelector('#picture');
            const imgPreview = document.querySelector('.img-preview');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }
    </script>
@endpush