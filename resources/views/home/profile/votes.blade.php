@extends('home.layouts.main')
@section('content')

    @include('home.profile.profile-picture')

    <div class="my-4">
        <a href="{{ route('user.index', [$user->id, $user->username]) }}" class="btn btn-sm btn-outline-secondary">Profile</a>
        <a href="{{ route('user.activity', [$user->id, $user->username]) }}" class="btn btn-sm btn-primary">Activity</a>
    </div>
    
    <div class="mt-4 row">
        <div class="col-md-2 col-12 activity-tab">
            @include('home.profile.activity-tab')
        </div>

        <div class="col-md-10 col-12 votes-box">
            <div class="col-md-12 question-votes-box">
                <h5>Question Votes</h5>
                <div class="row">
                    {{-- votes up --}}
                    <div class="col-md-6 col-12">
                        <div class="card">
                            <div class="card-body">
                                <h6>Votes Up</h6>

                                @if ($questionVotesUp->first() == null)
                                    <p class="m-0 pt-3">Don't have question votes up record yet.</p>
                                @endif
                                @foreach ($questionVotesUp as $question)
                                    <div class="user-question-votes row">
                                        <div class="col-md-6 col-8">
                                            <p class="score {{ $question->question->hasBestAnswer($question->question) == true ? 'solved' : '' }} {{ $question->question->vote > 0 ? 'votes-up' : '' }} {{ $question->question->vote < 0 ? 'votes-down' : '' }}">{{ $question->question->vote }}</p>
                                            <a href="{{ route('question.show', [$question->question->id, $question->question->slug]) }}">{{ Str::limit($question->question->title, 13) }}</a>
                                        </div>
                                        <div class="col-md-6 col-4 text-right">
                                            <p>{{ $question->created_at->format('d F Y') }}</p>
                                        </div>
                                    </div>
                                @endforeach
                                
                            </div>
                        </div>

                        <div class="mt-4 pagination">
                            {{ $questionVotesUp->links() }}
                        </div>
                    </div>

                    {{-- votes down --}}
                    <div class="col-md-6 col-12">
                        <div class="card">
                            <div class="card-body">
                                <h6>Votes Down</h6>

                                @if ($questionVotesDown->first() == null)
                                    <p class="m-0 pt-3">Don't have question votes down record yet.</p>
                                @endif
                                @foreach ($questionVotesDown as $question)
                                    <div class="user-question-votes row">
                                        <div class="col-md-6 col-8">
                                            <p class="score {{ $question->question->hasBestAnswer($question->question) == true ? 'solved' : '' }} {{ $question->question->vote > 0 ? 'votes-up' : '' }} {{ $question->question->vote < 0 ? 'votes-down' : '' }}">{{ $question->question->vote }}</p>
                                            <a href="{{ route('question.show', [$question->question->id, $question->question->slug]) }}">{{ Str::limit($question->question->title, 15) }}</a>
                                        </div>
                                        <div class="col-md-6 col-4 text-right">
                                            <p>{{ $question->created_at->format('d F Y') }}</p>
                                        </div>
                                    </div>
                                @endforeach
                                
                            </div>
                        </div>

                        <div class="mt-4 pagination">
                            {{ $questionVotesDown->links() }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-12 mt-4 answer-votes-box">
                <h5>Answer Votes</h5>
                <div class="row">
                    {{-- votes up --}}
                    <div class="col-md-6 col-12">
                        <div class="card">
                            <div class="card-body">
                                <h6>Votes Up</h6>

                                @if ($answerVotesUp->first() == null)
                                    <p class="m-0 pt-3">Don't have answer votes up record yet.</p>
                                @endif
                                @foreach ($answerVotesUp as $answer)
                                    <div class="user-answer-votes row">
                                        <div class="col-md-6 col-8">
                                            
                                            @if ($answer->answer->bestAnswer()->where('answer_id', $answer->answer->id)->first() !== null)
                                                @if ($answer->answer->bestAnswer()->where('answer_id', $answer->answer->id)->first()['check'] == true)
                                                    <p class="score best-answer {{ $answer->answer->vote > 0 ? 'votes-up' : '' }} {{ $answer->answer->vote < 0 ? 'votes-down' : '' }}">{{ $answer->answer->vote }}</p>
                                                @else
                                                    <p class="score {{ $answer->answer->vote > 0 ? 'votes-up' : '' }} {{ $answer->answer->vote < 0 ? 'votes-down' : '' }}">{{ $answer->answer->vote }}</p>
                                                @endif
                                            @else
                                                <p class="score {{ $answer->answer->vote > 0 ? 'votes-up' : '' }} {{ $answer->answer->vote < 0 ? 'votes-down' : '' }}">{{ $answer->answer->vote }}</p>
                                            @endif

                                            <a href="{{ route('answer.allComment', [$answer->answer->question_id, $answer->answer->question->slug, $answer->answer->id]) }}">{{  Str::limit(str_replace('&nbsp;', ' ', $answer->answer->excerpt), 15)  }}</a>
                                        </div>
                                        <div class="col-md-6 col-4 text-right">
                                            <p>{{ $answer->created_at->format('d F Y') }}</p>
                                        </div>
                                    </div>
                                @endforeach
                                
                            </div>
                        </div>

                        <div class="mt-4 pagination">
                            {{ $answerVotesUp->links() }}
                        </div>
                    </div>

                    {{-- votes down --}}
                    <div class="col-md-6 col-12">
                        <div class="card">
                            <div class="card-body">
                                <h6>Votes Down</h6>

                                @if ($answerVotesDown->first() == null)
                                    <p class="m-0 pt-3">Don't have answer votes down record yet.</p>
                                @endif
                                @foreach ($answerVotesDown as $answer)
                                    <div class="user-answer-votes row">
                                        <div class="col-md-6 col-8">

                                            @if ($answer->answer->bestAnswer()->where('answer_id', $answer->answer->id)->first() !== null)
                                                @if ($answer->answer->bestAnswer()->where('answer_id', $answer->answer->id)->first()['check'] == true)
                                                    <p class="score best-answer {{ $answer->answer->vote > 0 ? 'votes-up' : '' }} {{ $answer->answer->vote < 0 ? 'votes-down' : '' }}">{{ $answer->answer->vote }}</p>
                                                @else
                                                    <p class="score {{ $answer->answer->vote > 0 ? 'votes-up' : '' }} {{ $answer->answer->vote < 0 ? 'votes-down' : '' }}">{{ $answer->answer->vote }}</p>
                                                @endif
                                            @else
                                                <p class="score {{ $answer->answer->vote > 0 ? 'votes-up' : '' }} {{ $answer->answer->vote < 0 ? 'votes-down' : '' }}">{{ $answer->answer->vote }}</p>
                                            @endif
                                            
                                            <a href="{{ route('answer.allComment', [$answer->answer->question_id, $answer->answer->question->slug, $answer->answer->id]) }}">{{  Str::limit(str_replace('&nbsp;', ' ', $answer->answer->excerpt), 15)  }}</a>
                                        </div>
                                        <div class="col-md-6 col-4 text-right">
                                            <p>{{ $answer->created_at->format('d F Y') }}</p>
                                        </div>
                                    </div>
                                @endforeach
                                
                            </div>
                        </div>

                        <div class="mt-4 pagination">
                            {{ $answerVotesDown->links() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection