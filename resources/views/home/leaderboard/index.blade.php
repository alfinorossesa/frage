@extends('home.layouts.main')
@section('content')
    <div class="leaderboard-page">
        <h3>Leaderboard</h3>
        <p class="m-0">Leaderboard rank user by help other question and get best answer mark.</p>

        <div class="leaderboard col-md-6 col-12">
            @foreach ($leaderboard as $key => $rank)
                <div class="card">
                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="rank">
                                <h5>#{{ $key + 1 }}</h5>
                            </div>
                            <div class="col-md-7 col-7 detail">
                                @if ($rank['oauth_picture'] !== null)
                                    <img src="{{ $rank['oauth_picture'] }}" alt="..." width="25px" height="25px">
                                @else
                                    <img src="{{ $rank['picture'] ? asset('assets/profile-picture/'. $rank['picture']) : asset('assets/profile-picture/default.png') }}" alt="..." width="25px" height="25px">
                                @endif
                                <a href="{{ route('user.index', [$rank['id'], $rank['username']]) }}" class="m-0">{{ $rank['name'] }}</a>
                                <p class="m-0">Get {{ $rank['best_answer_count'] }} Best Answer</p>
                            </div>
                            <div class="col-md-4 col-4 text-right trophy">
                                @if ($rank['rank'] == 1)
                                    <i class="rank-1 fa-solid fa-trophy"></i>
                                @elseif($rank['rank'] == 2)
                                    <i class="rank-2 fa-solid fa-trophy"></i>
                                @elseif($rank['rank'] == 3)
                                    <i class="rank-3 fa-solid fa-trophy"></i>
                                @else 
                                    <i class="medal fa-solid fa-medal"></i>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection