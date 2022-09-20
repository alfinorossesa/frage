@extends('home.layouts.main')
@section('content')

    <div class="profile-index">
        @include('home.profile.profile-picture')
    
        <div class="profile-activity-button">
            <a href="{{ route('user.index', [$user->id, $user->username]) }}" class="btn btn-sm btn-primary">Profile</a>
            <a href="{{ route('user.activity', [$user->id, $user->username]) }}" class="btn btn-sm btn-outline-secondary">Activity</a>
        </div>
        
        <div class="mt-4 row">
            <div class="col-md-3 col-12 stats">
                <h5>Stats</h5>
                <div class="card">
                    <div class="card-body row">
                        <div class="col-md-6 col-6">
                            @if ($leaderboard == null)
                                <h6 class="m-0">-</h6>
                            @else
                                <h6 class="m-0">#{{ $leaderboard['rank'] }}</h6> 
                            @endif
                            <p>rank</p>
                        </div>
                        <div class="col-md-6 col-6">
                            <h6 class="m-0">{{ number_format($reach) }}</h6>
                            <p>reach</p>
                        </div>
                        <div class="col-md-6 col-6">
                            <h6 class="m-0">{{ number_format($user->question->count()) }}</h6>
                            <p class="m-0">questions</p>
                        </div>
                        <div class="col-md-6 col-6">
                            <h6 class="m-0">{{ number_format($user->answer->count()) }}</h6>
                            <p class="m-0">answers</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-9 col-12">
                <div class="col-md-12 col-12 badges-box">
                    <h5>Badges</h5>
                    <div class="card">
                        <div class="card-body">
                            
                            @if ($leaderboard !== null)
                                @if ($leaderboard['best_answer_count'] >= 10)
                                    <div class="row mb-4">
                                        <div class="col-md-2 col-2 badges text-center">
                                            @if ($leaderboard['best_answer_count'] >= 100)
                                                <i class="gold fa-solid fa-award"></i>
                                            @elseif($leaderboard['best_answer_count'] >= 50)
                                                <i class="silver fa-solid fa-award"></i>
                                            @else
                                                <i class="bronze fa-solid fa-award"></i>
                                            @endif
                                        </div>
                                        <div class="col-md-10 col-10 row badges-detail">
                                            <div class="col-md-12">
                                                @if ($leaderboard['best_answer_count'] >= 100)
                                                    <h5>Gold badges</h5>
                                                @elseif($leaderboard['best_answer_count'] >= 50)
                                                    <h5>Silver badges</h5>
                                                @else
                                                    <h5>Bronze Badges</h5>
                                                @endif
                                            </div>
                                            <div class="col-md-12">
                                                <p><i class="fa-solid fa-check"></i> Solving question more than {{ $leaderboard['best_answer_count'] }} times</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <p class="m-0">Don't have Badges record yet.</p>
                            @endif
                            
                            @if ($leaderboard !== null)
                                <div class="row">
                                    <div class="col-md-2 col-2 trophy text-center">
                                        @if ($leaderboard['rank'] == 1)
                                            <i class="rank-1 fa-solid fa-trophy"></i>
                                        @elseif($leaderboard['rank'] == 2)
                                            <i class="rank-2 fa-solid fa-trophy"></i>
                                        @elseif($leaderboard['rank'] == 3)
                                            <i class="rank-3 fa-solid fa-trophy"></i>
                                        @else
                                            <i class="medal fa-solid fa-medal"></i>
                                        @endif
                                    </div>
                                    <div class="col-md-10 col-10 row badges-detail">
                                        <div class="col-md-12">
                                            @if ($leaderboard['rank'] == 1)
                                                <h5>Gold trophy</h5>
                                            @elseif($leaderboard['rank'] == 2)
                                                <h5>Silver trophy</h5>
                                            @elseif($leaderboard['rank'] == 3)
                                                <h5>Bronze trophy</h5>
                                            @else
                                                <h5>Medal</h5>
                                            @endif
                                        </div>
                                        <div class="col-md-12">
                                            <p><i class="fa-solid fa-hashtag"></i>{{ $leaderboard['rank'] }} rank on Leaderboard</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                        </div>
                    </div>
                </div>
                
                <div class="col-md-12 col-12 mt-4 top-question-box">
                    <h5>Top Question</h5>
                    <div class="card">
                        <div class="card-body pt-0">

                            @if ($topQuestion->first() == null)
                                <p class="m-0">Don't have question record yet.</p>
                            @endif
                            @foreach ($topQuestion as $question)
                                <div class="top-question row">
                                    <div class="col-md-9 col-8">
                                        <p class="score {{ $question->hasBestAnswer($question) == true ? 'solved' : '' }} {{ $question->vote > 0 ? 'votes-up' : '' }} {{ $question->vote < 0 ? 'votes-down' : '' }}">{{ $question->vote }}</p>
                                        <a href="{{ route('question.show', [$question->id, $question->slug]) }}">{{ $question->title }}</a>
                                    </div>
                                    <div class="col-md-3 col-4 text-right">
                                        <p>{{ $question->created_at->format('d F Y') }}</p>
                                    </div>
                                </div>
                            @endforeach
                            
                        </div>
                    </div>
                </div>
                
                <div class="col-md-12 col-12 mt-4 top-answer-box">
                    <h5>Top Answer</h5>
                    <div class="card">
                        <div class="card-body pt-0">

                            @if ($topAnswer->first() == null)
                                <p class="m-0">Don't have answer record yet.</p>
                            @endif
                            @foreach ($topAnswer as $answer)
                                <div class="top-answer row">
                                    <div class="col-md-9 col-8">
                                        
                                        @if ($answer->bestAnswer()->where('answer_id', $answer->id)->first() !== null)
                                            @if ($answer->bestAnswer()->where('answer_id', $answer->id)->first()['check'] == true)
                                                <p class="score best-answer {{ $answer->vote > 0 ? 'votes-up' : '' }} {{ $answer->vote < 0 ? 'votes-down' : '' }}">{{ $answer->vote }}</p>
                                            @else    
                                                <p class="score {{ $answer->vote > 0 ? 'votes-up' : '' }} {{ $answer->vote < 0 ? 'votes-down' : '' }}">{{ $answer->vote }}</p>
                                            @endif
                                        @else
                                            <p class="score {{ $answer->vote > 0 ? 'votes-up' : '' }} {{ $answer->vote < 0 ? 'votes-down' : '' }}">{{ $answer->vote }}</p>
                                        @endif
                                        
                                        <a href="{{ route('answer.allComment', [$answer->question_id, $answer->question->slug, $answer->id]) }}">{{  str_replace('&nbsp;', ' ', $answer->excerpt)  }}</a>
                                    </div>
                                    <div class="col-md-3 col-4 text-right">
                                        <p>{{ $answer->created_at->format('d F Y') }}</p>
                                    </div>
                                </div>
                            @endforeach
                            
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection