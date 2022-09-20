<div class="profile-picture">
    <div class="d-flex">
        @if ($user->oauth_picture !== null)
            <img src="{{ $user->oauth_picture }}" alt="..." width="130px" height="130px">
        @else
            <img src="{{ $user->picture ? asset('assets/profile-picture/'. $user->picture) : asset('assets/profile-picture/default.png') }}" alt="..." width="130px" height="130px">
        @endif
        <div class="col-md-5 profile-name">
            <h3 class="m-0">{{ $user->name }}</h3>
            <p><i class="fa-solid fa-cake-candles"></i> member for {{ $user->created_at->diffForHumans() }}</p>
        </div>
    </div>
    
    @auth
        @if ($user->id == auth()->user()->id)
            <div class="pt-2 update-profile">
                <a href="{{ route('user.updateProfile', [auth()->user()->id, auth()->user()->username]) }}" class="update-profile-link">Update Profile <i class="fa-solid fa-pen"></i></a>
            </div>
        @endif
    @endauth
</div>


