<div class="question-content">
    <div class="row">
        <div class="col-md-2 col-12 detail-question">
            <p class="m-0">{{ $question->vote }} votes</p>
            <p class="m-0 {{ $question->answer->count() > 0 ? 'answer' : '' }} {{ $question->hasBestAnswer($question) == true ? 'best-answer' : '' }}">
                @if ($question->hasBestAnswer($question) == true)
                    <i class="fa-solid fa-check"></i>
                @endif
                {{ $question->answer->count() }} {{ $question->answer->count() > 9 ? 'answ...' : 'answers' }}
            </p>
            <p class="m-0">{{ $question->view_count }} views</p>
        </div>
        <div class="col-md-10 col-12 the-question">
            <p class="m-0 question-title"><a href="{{ route('question.show', [$question->id, $question->slug]) }}">{{ $question->title }}</a></p>
            <p>{{ str_replace('&nbsp;', ' ', $question->excerpt) }}</p>
            <div class="question-tag">
                @foreach ($question['tag'] as $tag)
                    <a href="{{ route('tag.questionByTag', $tag['tag']) }}" class="mr-1">{{ $tag['tag'] }}</a>
                @endforeach
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-12 d-flex justify-content-end user-info">
            <div>
                <p class="m-0">
                    @if ($question->user->oauth_picture !== null)
                        <img src="{{ $question->user->oauth_picture }}" alt="..." width="20px" height="20px">
                    @else
                        <img src="{{ $question->user->picture ? asset('assets/profile-picture/'. $question->user->picture) : asset('assets/profile-picture/default.png') }}" alt="..." width="20px" height="20px">
                    @endif
                    <a href="{{ route('user.index', [$question->user->id, $question->user->username]) }}">{{ $question->user->name }}</a> asked {{ $question->created_at->diffForHumans() }}
                </p>
                <p class="m-0 pl-4 trophy badges">
                    @foreach ($leaderboard as $user)
                        @if ($user['id'] == $question->user->id)
                            @if ($user['rank'] == 1)
                                <i class="rank-1 fa-solid fa-trophy" title="rank {{ $user['rank'] }} on leaderboard"></i>
                            @elseif($user['rank'] == 2)
                                <i class="rank-2 fa-solid fa-trophy" title="rank {{ $user['rank'] }} on leaderboard"></i>
                            @elseif($user['rank'] == 3)
                                <i class="rank-3 fa-solid fa-trophy" title="rank {{ $user['rank'] }} on leaderboard"></i>
                            @else
                                <i class="medal fa-solid fa-medal" title="rank {{ $user['rank'] }} on leaderboard"></i>
                            @endif

                            @if ($user['best_answer_count'] >= 10)
                                @if ($user['best_answer_count'] >= 100)
                                    <i class="gold fa-solid fa-award" title="get {{ $user['best_answer_count'] }} best answer"></i>
                                @elseif($user['best_answer_count'] >= 50)
                                    <i class="silver fa-solid fa-award" title="get {{ $user['best_answer_count'] }} best answer"></i>
                                @else
                                    <i class="bronze fa-solid fa-award" title="get {{ $user['best_answer_count'] }} best answer"></i>
                                @endif
                            @endif
                        @endif
                    @endforeach
                </p>
            </div>
        </div>
    </div>
</div>