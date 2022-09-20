@extends('home.layouts.main')
@section('content')

    <div class="profile-activity">
        @include('home.profile.profile-picture')
    
        <div class="profile-activity-button">
            <a href="{{ route('user.index', [$user->id, $user->username]) }}" class="btn btn-sm btn-outline-secondary">Profile</a>
            <a href="{{ route('user.activity', [$user->id, $user->username]) }}" class="btn btn-sm btn-primary">Activity</a>
        </div>
        
        <div class="mt-4 row">
            <div class="col-md-2 col-12 activity-tab">
                @include('home.profile.activity-tab')
            </div>

            <div class="col-md-10 col-12 summary-box">
                <div class="col-md-12 col-12">
                    <h5>Summary</h5>
                    <div class="card">
                        <div class="card-body pr-0 row">
                            <div class="col-md-12 row summary">
                                <div class="col-md-4 col-12 sub-summary">
                                    <a href="{{ route('user.question', [$user->id, $user->username]) }}">
                                        <div class="card">
                                            <div class="card-body">
                                                <h6 class="m-0">{{ $user->question->count() }}</h6>
                                                <p class="m-0">Question</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-4 col-12 sub-summary">
                                    <a href="{{ route('user.answer', [$user->id, $user->username]) }}">
                                        <div class="card">
                                            <div class="card-body">
                                                <h6 class="m-0">{{ $user->answer->count() }}</h6>
                                                <p class="m-0">Answer</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-4 col-12 sub-summary">
                                    <a href="{{ route('user.comment', [$user->id, $user->username]) }}">
                                        <div class="card">
                                            <div class="card-body">
                                                <h6 class="m-0">{{ $user->answerComment->count() }}</h6>
                                                <p class="m-0">Comment</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-4 col-12 sub-summary">
                                    <a href="{{ route('user.votes', [$user->id, $user->username]) }}">
                                        <div class="card">
                                            <div class="card-body">
                                                <h6 class="m-0">{{ ($user->questionVotes->where('status', true)->count()) + ($user->answerVotes->where('status', true)->count()) }}</h6>
                                                <p class="m-0">Votes</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-4 col-12 sub-summary">
                                    <a href="{{ route('user.likesQuestion', [$user->id, $user->username]) }}">
                                        <div class="card">
                                            <div class="card-body">
                                                <h6 class="m-0">{{ $user->questionLike->count() }}</h6>
                                                <p class="m-0">Likes question</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-4 col-12 sub-summary">
                                    <a href="{{ route('user.likesAnswer', [$user->id, $user->username]) }}">
                                        <div class="card">
                                            <div class="card-body">
                                                <h6 class="m-0">{{ $user->answerLike->count() }}</h6>
                                                <p class="m-0">Likes answer</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection