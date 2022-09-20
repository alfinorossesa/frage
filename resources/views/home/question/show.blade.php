@extends('home.layouts.main')
@section('content')
<div class="row question-show">
    <div class="col-md-8 col-12 question-main-title">
        <h3>{{ $question->title }}</h3>
        <p>asked {{ $question->created_at->diffForHumans() }}</p>
        <p>viewed {{ $question->view_count }} times</p>
    </div>
    <div class="col-md-4 col-12 question-option">
        @auth
            @if ($question->user_id == auth()->user()->id)
                <div class="dropdown">
                    <a class="btn user" data-toggle="dropdown"> 
                        <i class="fa-solid fa-ellipsis-vertical"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('question.edit', [$question->id, $question->slug]) }}">Edit question</a></li>
                        <li>
                            <form id="delete-question" action="{{ route('question.destroy', [$question->id, $question->slug]) }}" method="post">
                            @csrf
                            @method('delete')
                                <a class="dropdown-item delete-question" href="#">Delete question</a>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <div class="question-like">
                    @if ($question->questionLike->where('user_id', auth()->user()->id)->first() !== null)
                        @if ($question->questionLike->where('user_id', auth()->user()->id)->first()['status'] == 1)
                            <div class="question-unlike-button" data-id="{{ $question->id }}">
                                <i class="fa-solid fa-heart"></i>
                            </div>
                        @else
                            <div class="question-like-button" data-id="{{ $question->id }}">
                                <i class="fa-regular fa-heart"></i>
                            </div>
                        @endif
                    @else
                        <div class="question-like-button" data-id="{{ $question->id }}">
                            <i class="fa-regular fa-heart"></i>
                        </div>
                    @endif
                </div>
            @endif
        @endauth
    </div>
</div>
<div class="row">
    <div class="col-md-8 col-12">

        {{-- question --}}
        <div class="question-main">
            <div class="row">
                <div class="col-md-1 col-1 question-votes">

                    @auth
                        @if ($question->questionVotes->where('user_id', auth()->user()->id)->first() !== null)
                        <button id="questionVotesCountUp" class="{{ $question->questionVotes->where('user_id', auth()->user()->id)->first()['option'] == 'votes-down' ? '' : 'questionVotesCountUp' }}" data-id="{{ $question->id }}">
                        @else
                        <button id="questionVotesCountUp" class="questionVotesCountUp" data-id="{{ $question->id }}">
                        @endif
                            <input type="hidden" id="inputVotesUp" value="{{ $question->questionVotes->where('user_id', auth()->user()->id)->first() == null ? 0 : $question->questionVotes->where('user_id', auth()->user()->id)->first()['status']}}">
                            @if ($question->questionVotes->where('user_id', auth()->user()->id)->first() !== null)
                                <p id="voted-up" class="m-0 pb-2 {{ $question->questionVotes->where('user_id', auth()->user()->id)->first()['option'] == 'votes-up' ? 'votes-up' : '' }} {{ $question->questionVotes->where('user_id', auth()->user()->id)->first()['option'] == 'votes-down' ? 'votes-not-selected' : '' }}" title="This question shows research effort, it's useful and clear"><i class="fa-solid fa-3x fa-caret-up"></i></p>
                            @else
                                <p id="voted-up" class="m-0 pb-2" title="This question shows research effort, it's useful and clear"><i class="fa-solid fa-3x fa-caret-up"></i></p>
                            @endif    
                        </button>
                    @else
                        <button class="guestVoteButton">
                            <p class="m-0 pb-2" title="This question shows research effort, it's useful and clear"><i class="fa-solid fa-3x fa-caret-up"></i></p>
                        </button>
                    @endauth

                    <h5 class="m-0 pb-2 questionVotesResult">{{ $question->vote }}</h5>

                    @auth
                        @if ($question->questionVotes->where('user_id', auth()->user()->id)->first() !== null)
                        <button id="questionVotesCountDown" class="{{ $question->questionVotes->where('user_id', auth()->user()->id)->first()['option'] == 'votes-up' ? '' : 'questionVotesCountDown' }}" data-id="{{ $question->id }}">
                        @else
                        <button id="questionVotesCountDown" class="questionVotesCountDown" data-id="{{ $question->id }}">
                        @endif
                            <input type="hidden" id="inputVotesDown" value="{{ $question->questionVotes->where('user_id', auth()->user()->id)->first() == null ? 0 : $question->questionVotes->where('user_id', auth()->user()->id)->first()['status']}}">
                            @if ($question->questionVotes->where('user_id', auth()->user()->id)->first() !== null)
                                <p id="voted-down" class="m-0 pb-2 {{ $question->questionVotes->where('user_id', auth()->user()->id)->first()['option'] == 'votes-down' ? 'votes-down' : '' }} {{ $question->questionVotes->where('user_id', auth()->user()->id)->first()['option'] == 'votes-up' ? 'votes-not-selected' : '' }}" title="This question doesn't show any research effort, it's unclear and not useful"><i class="fa-solid fa-3x fa-caret-down"></i></p>
                            @else
                                <p id="voted-down" class="m-0 pb-2" title="This question doesn't show any research effort, it's unclear and not useful"><i class="fa-solid fa-3x fa-caret-down"></i></p>
                            @endif  
                        </button>
                    @else
                        <button class="guestVoteButton">
                            <p class="m-0 pb-2" title="This question shows research effort, it's useful and clear"><i class="fa-solid fa-3x fa-caret-down"></i></p>
                        </button>
                    @endauth
                    
                </div>
                <div class="col-md-11 col-11 question-body">
                    <p>{!! $question->body !!}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-1 col-1"></div>
                <div class="pr-2"></div>
                @foreach ($question['tag'] as $tag)
                    <div class="pl-2 question-tag">
                        <a href="{{ route('tag.questionByTag', $tag['tag']) }}" class="m-0">{{ $tag['tag'] }}</a>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- question user --}}
        <div class="mt-4">
            <div class="row">
                <div class="col-md-8 col-5 question-share">
                    Share on <br>
                    @foreach ($share as $key => $link)
                        <a href="{{ $link }}" class="mr-2 social-button" ><img src="{{ asset('assets/img/'.$key.'.png') }}" alt="..." width="20px"></a>
                    @endforeach
                </div>
                <div class="col-md-4 col-7 question-user">
                    <p class="m-0 question-date">ask on {{ $question->created_at->format('d F Y') }} at {{ $question->created_at->format('H.i') }}</p>
                    <p class="m-0">
                        @if ($question->user->oauth_picture !== null)
                            <img src="{{ $question->user->oauth_picture }}" alt="..." width="20px" height="20px">
                        @else
                            <img src="{{ $question->user->picture ? asset('assets/profile-picture/'. $question->user->picture) : asset('assets/profile-picture/default.png') }}" alt="..." width="20px" height="20px">
                        @endif
                        <a href="{{ route('user.index', [$question->user->id, $question->user->username]) }}">{{ $question->user->name }}</a>
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
            @auth
                @if ($question->user->id !== auth()->user()->id)
                    <div class="question-report mt-3">
                        <a href="{{ route('question.report', [$question->id, $question->slug]) }}" class="text-danger"><i class="fa-solid fa-flag"></i> Report this question</a>
                    </div>
                @endif
            @endauth
        </div>

        {{-- answer count --}}
        <div class="answer-count pt-5">
            <p>{{ $question->answer->count() }} Answer</p>
        </div>

        {{-- answer --}}
        @foreach ($question->answer as $answer)
            <div id="answer-{{ $answer->id }}">
                <div class="answer-main pt-4">
                    <div class="row">
                        <div class="col-md-1 col-1 answer-votes">

                            @auth
                                @if ($answer->answerVotes->where('user_id', auth()->user()->id)->first() !== null)
                                    <button id="answerVotesCountUp-{{ $answer->id }}" class="{{ $answer->answerVotes->where('user_id', auth()->user()->id)->first()['option'] == 'votes-down' ? '' : 'answerVotesCountUp' }}" data-id={{ $answer->id }}>
                                @else
                                    <button id="answerVotesCountUp-{{ $answer->id }}" class="answerVotesCountUp" data-id={{ $answer->id }}>
                                @endif
                                    <input type="hidden" id="answerInputVotesUp-{{ $answer->id }}" value="{{ $answer->answerVotes->where('user_id', auth()->user()->id)->first() == null ? 0 : $answer->answerVotes->where('user_id', auth()->user()->id)->first()['status']}}">
                                    @if ($answer->answerVotes->where('user_id', auth()->user()->id)->first() !== null)
                                        <p id="answer-voted-up-{{ $answer->id }}" class="m-0 pb-2 {{ $answer->answerVotes->where('user_id', auth()->user()->id)->first()['option'] == 'votes-up' ? 'votes-up' : '' }} {{ $answer->answerVotes->where('user_id', auth()->user()->id)->first()['option'] == 'votes-down' ? 'votes-not-selected' : '' }}" title="This answer is useful"><i class="fa-solid fa-3x fa-caret-up"></i></p>
                                    @else
                                        <p id="answer-voted-up-{{ $answer->id }}" class="m-0 pb-2" title="This answer is useful"><i class="fa-solid fa-3x fa-caret-up"></i></p>
                                    @endif    
                                </button>
                            @else
                                <button class="guestVoteButton">
                                    <p class="m-0 pb-2" title="This answer is useful"><i class="fa-solid fa-3x fa-caret-up"></i></p>
                                </button>
                            @endauth

                            <h5 id="answerVotesResult-{{ $answer->id }}" class="m-0 pb-2 pr-1">{{ $answer->vote }}</h5>
                            
                            @auth
                                @if ($answer->answerVotes->where('user_id', auth()->user()->id)->first() !== null)
                                    <button id="answerVotesCountDown-{{ $answer->id }}" class="{{ $answer->answerVotes->where('user_id', auth()->user()->id)->first()['option'] == 'votes-up' ? '' : 'answerVotesCountDown' }}" data-id="{{ $answer->id }}">
                                @else
                                    <button id="answerVotesCountDown-{{ $answer->id }}" class="answerVotesCountDown" data-id="{{ $answer->id }}">
                                @endif
                                    <input type="hidden" id="answerInputVotesDown-{{ $answer->id }}" value="{{ $answer->answerVotes->where('user_id', auth()->user()->id)->first() == null ? 0 : $answer->answerVotes->where('user_id', auth()->user()->id)->first()['status']}}">
                                    @if ($answer->answerVotes->where('user_id', auth()->user()->id)->first() !== null)
                                        <p id="answer-voted-down-{{ $answer->id }}" class="m-0 pb-2 {{ $answer->answerVotes->where('user_id', auth()->user()->id)->first()['option'] == 'votes-down' ? 'votes-down' : '' }} {{ $answer->answerVotes->where('user_id', auth()->user()->id)->first()['option'] == 'votes-up' ? 'votes-not-selected' : '' }}" title="This answer is not useful"><i class="fa-solid fa-3x fa-caret-down"></i></p>
                                    @else
                                        <p id="answer-voted-down-{{ $answer->id }}" class="m-0 pb-2" title="This answer is not useful"><i class="fa-solid fa-3x fa-caret-down"></i></p>
                                    @endif  
                                </button>
                            @else
                                <button class="guestVoteButton">
                                    <p class="m-0 pb-2" title="This answer is not useful"><i class="fa-solid fa-3x fa-caret-down"></i></p>
                                </button>
                            @endauth

                            @auth
                                @if($question->user_id == auth()->user()->id)
                                    <div class="best-answer" id="best-answer-{{ $answer->id }}" data-id="{{ $answer->id }}">
                                        @if ($answer->bestAnswer()->where('answer_id', $answer->id)->first() !== null)
                                            @if ($answer->bestAnswer()->where('answer_id', $answer->id)->first()['check'] == true)
                                                <div class="check-mark" data-id="{{ $answer->id }}">
                                                    <i class="fa-solid fa-check"></i>
                                                </div>
                                            @else
                                                <div class="uncheck-mark {{ $bestAnswerCheck == false ? '' : 'd-none' }}" data-id="{{ $answer->id }}">
                                                    <i class="fa-solid fa-check"></i>
                                                </div>
                                            @endif
                                        @else
                                            <div class="uncheck-mark {{ $bestAnswerCheck == false ? '' : 'd-none' }}" data-id="{{ $answer->id }}">
                                                <i class="fa-solid fa-check"></i>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="best-answer" title="Best Answer" style="cursor: default;">
                                        @if ($answer->bestAnswer()->where('answer_id', $answer->id)->first() !== null)
                                            @if ($answer->bestAnswer()->where('answer_id', $answer->id)->first()['check'] == true)
                                                <i class="fa-solid fa-check" style="color: rgb(6, 211, 6);"></i>
                                            @endif
                                        @endif
                                    </div>
                                @endif
                            @else
                                <div class="best-answer" title="Best Answer" style="cursor: default;">
                                    @if ($answer->bestAnswer()->where('answer_id', $answer->id)->first() !== null)
                                        @if ($answer->bestAnswer()->where('answer_id', $answer->id)->first()['check'] == true)
                                            <i class="fa-solid fa-check" style="color: rgb(6, 211, 6);"></i>
                                        @endif
                                    @endif
                                </div>
                            @endauth

                        </div>
                        <div class="col-md-10 col-10 pt-2 this-answer">
                            {!! $answer->answer !!}
                        </div>
                        <div class="col-md-1 col-1 answer-option">
                            @auth
                                @if ($answer->user_id == auth()->user()->id)
                                    <div class="dropdown">
                                        <a class="btn user" data-toggle="dropdown"> 
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="{{ route('answer.edit', [$answer->question->id, $answer->question->slug ,$answer->id]) }}">Edit answer</a></li>
                                            <li><a class="dropdown-item delete-answer" href="#" data-id="{{ $answer->id }}">Delete answer</a></li>
                                        </ul>
                                    </div>
                                @else
                                    <div class="answer-like" id="answer-like-{{ $answer->id }}">
                                        @if ($answer->answerLike->where('user_id', auth()->user()->id)->first() !== null)
                                            @if ($answer->answerLike->where('user_id', auth()->user()->id)->first()['status'] == 1)
                                                <div class="answer-unlike-button" data-id="{{ $answer->id }}">
                                                    <i class="fa-solid fa-heart"></i>
                                                </div>
                                            @else
                                                <div class="answer-like-button" data-id="{{ $answer->id }}">
                                                    <i class="fa-regular fa-heart"></i>
                                                </div>
                                            @endif
                                        @else
                                            <div class="answer-like-button" data-id="{{ $answer->id }}">
                                                <i class="fa-regular fa-heart"></i>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>

                {{-- answer user --}}
                <div class="mt-2">
                    <div class="row">
                        <div class="col-md-7 col-4 answer-report-link">
                            @auth
                                @if ($answer->user_id !== auth()->user()->id)
                                    <a href="{{ route('answer.report', $answer->id) }}" class="text-danger"><i class="fa-solid fa-flag"></i> Report this answer</a>
                                @endif
                            @endauth
                        </div>
                        
                        <div class="col-md-5 col-8 answer-user">
                            <div class="pl-4">
                                <p class="m-0 answer-date">answer on {{ $answer->created_at->format('d F Y') }} at {{ $answer->created_at->format('H.i') }}</p>
                                <p class="m-0">
                                    @if ($answer->user_id !== null)
                                        @if ($answer->user->oauth_picture !== null)
                                            <img src="{{ $answer->user->oauth_picture }}" alt="..." width="20px" height="20px">
                                        @else
                                            <img src="{{ $answer->user->picture ? asset('assets/profile-picture/'. $answer->user->picture) : asset('assets/profile-picture/default.png') }}" alt="..." width="20px" height="20px">
                                        @endif
                                        <a href="{{ route('user.index', [$answer->user->id, $answer->user->username]) }}">{{ $answer->name }}</a>
                                    @else
                                        <img src="{{ asset('assets/profile-picture/default.png') }}" alt="..." width="20px" height="20px"> 
                                        (guest) {{ $answer->name }}
                                    @endif
                                </p>
                                <p class="m-0 pl-4 trophy badges">
                                    @if ($answer->user_id !== null)
                                        @foreach ($leaderboard as $user)
                                            @if ($user['id'] == $answer->user->id)
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
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- answer comment --}}
                <div class="answer-comment pt-3">
                    <div class="mb-2 see-all-comment">
                        <a href="{{ route('answer.allComment', [$question->id, $question->slug, $answer->id]) }}" id="see-all-comment-{{ $answer->id }}" class="{{ $answer->answerComment->count() > 1 ? '' : 'd-none' }}">see all {{ $answer->answerComment->count() }} comment....</a>
                    </div>

                    <div id="comment-{{ $answer->id }}">
                        @foreach ($answer->answerComment as $item)
                            @if($loop->last)
                                <div class="comment py-1">
                                    <p class="mb-2 trophy badges">
                                        @if ($item->user->oauth_picture !== null)
                                            <img src="{{ $item->user->oauth_picture }}" alt="..." width="20px" height="20px">
                                        @else
                                            <img src="{{ $item->user->picture ? asset('assets/profile-picture/'. $item->user->picture) : asset('assets/profile-picture/default.png') }}" alt="..." width="20px" height="20px">
                                        @endif
                                        <a href="{{ route('user.index', [$item->user->id, $item->user->username]) }}">{{ $item->user->name }}</a>
                                        @foreach ($leaderboard as $user)
                                            @if ($user['id'] == $item->user->id)
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
                                        . <span>{{ $item->created_at->diffForHumans() }}</span>
                                    </p>
                                    <p class="m-0">{{ $item->comment }}</p>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    
                    <form action="#" method="POST" class="mt-3">
                        @csrf
                        <div class="comment-form">
                            <textarea name="comment" class="input-comment" id="input-comment-{{ $answer->id }}" onkeyup="textAreaAdjust(this)" style="overflow:hidden" placeholder="Add a comment..."></textarea>
                        </div>
                        @auth
                            <a href="#" class="btn btn-sm btn-primary btn-comment" data-id="{{ $answer->id }}">Add Comment</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-sm btn-primary">Add Comment</a>
                        @endauth
                    </form>
                </div>
            </div>
        @endforeach

        {{-- your answer --}}
        @auth
            @if (auth()->user()->id !== $question->user->id)
                <div class="your-answer">
                    <h5>Your Answer</h5>
                    <form action="{{ route('answer.store', $question->id) }}" method="POST" class="pt-2">
                        @csrf
                        <div class="mb-3">
                            <textarea name="answer" id="summernote" cols="100" rows="10"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Post your answer</button>
                    </form>
                </div>
            @endif
        @else
            <div class="your-answer">
                <h5>Your Answer</h5>
                <form action="{{ route('answer.store', $question->id) }}" method="POST" class="pt-2">
                    @csrf
                    <div class="mb-4">
                        <textarea name="answer" id="summernote" cols="100" rows="10">{{ old('answer') }}</textarea>
                    </div>
                        <div class="row">
                            <div class="col-md-6 col-6 signup-or-login">
                                <h5><a href="{{ route('signup') }}" style="color: #14a5bb;">Sign up</a> or Login</h5>
                                <a href="{{ route('google.auth') }}" class="login-button google"><img src="{{ asset('assets/img/google.png') }}" width="20px" class="mb-1"> Login with Google</a>
                                <a href="{{ route('github.auth') }}" class="login-button github"><img src="{{ asset('assets/img/github.png') }}" width="20px" class="mb-1"> Login with GitHub</a>
                                <a href="{{ route('login') }}" class="btn btn-primary login-button">Login</a>
                            </div>
                            <div class="col-md-6 col-6 as-guest">
                                <h5>Post as a Guest</h5>
                                <div class="name">
                                    <label for="name" class="form-label m-0"><strong>Name</strong></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Your name">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="email">
                                    <label for="email" class="form-label m-0"><strong>Email</strong></label>
                                    <p class="ask-description-label">Required, but never shown</p>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Your email">
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    <button type="submit" class="btn btn-primary mt-2">Post your answer</button>
                </form>
            </div>
        @endauth

    </div>

    <div class="col-md-4 col-12 related">
        <div class="card mb-4 question-interested">
            <div class="card-body">
            <h6 class="card-title mb-3">Questions Might You Interested</h6>
                @foreach ($relatedQuestions as $question)
                    <div class="p-0 mb-2 top-question">
                        <p class="score {{ $question->hasBestAnswer($question) == true ? 'solved' : '' }} {{ $question->vote > 0 ? 'votes-up' : '' }} {{ $question->vote < 0 ? 'votes-down' : '' }}">{{ $question->vote }}</p>
                        <a href="{{ route('question.show', [$question->id, $question->slug]) }}">{{ $question->title }}</a>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="card">
            <div class="card-body most-used-tags">
            <h6 class="card-title mb-3">Most Used Tags</h6>
                @foreach ($relatedTags as $tag)
                    <div class="tag p-0 mb-2">
                        <a href="{{ route('tag.questionByTag', $tag->tag) }}" class="m-0 tag-name">{{ $tag->tag }}</a> <span class="ml-1"><i class="fa-solid fa-xmark" style="font-size: 10px"></i> {{ $tag->count }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
    <script>
        // answer comment
        function textAreaAdjust(element) {
            element.style.height = "1px";
            element.style.height = (25+element.scrollHeight)+"px";
        }

        // summernote
        $('#summernote').summernote({
            tabsize: 2,
            height: 250,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture']],
            ],
            callback: {
                onImageUpload: function(files) {
                    for (let i = 0; i < files.length; i++) {
                        $.upload(files[i]);
                    }
                },
                onMediaDelete: function(target) {
                    $.delete(target[0].src);
                }
            }
        });

        $.upload = function(file) {
            let out = new formData();
            out.append('file', file, file.name);
            $.ajax({
                method: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                data: out,
                success: function(img) {
                    $('#summernote').summernote('insertImage', img);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error(textStatus + " " + errorThrown);
                }
            });
        };

        $.delete = function(src) {
            $.ajax({
                method: 'POST',
                cache: false,
                data: {
                    src: src
                },
                success: function(response) {
                    console.log(response)
                }
            });
        };

        // question votes
        // votes up count
        $('body').on('click', '.questionVotesCountUp', function(e){
            e.preventDefault();
            $(this).prop('disabled', true);
            let voteValue = $('#inputVotesUp').val();
            let id = $(this).data('id');
            let url = "{{ route('question.votesCount', ':id') }}";
            url = url.replace(':id', id);
            let data = {
                    vote: voteValue,
                    option: 'votes-up'
                }
            votes(voteValue, url, data, function(res){
                    $('.questionVotesResult').html(res.count);
                    $('.questionVotesCountUp').prop('disabled', false);
                    if (res.status == true) {
                        // green button
                        $('#voted-up').addClass('votes-up');
                        $('#inputVotesUp').val(1);
                        $('#inputVotesDown').val(1);
                        $('#questionVotesCountDown').removeClass('questionVotesCountDown');
                        $('#voted-down').addClass('votes-not-selected');
                    } else {
                        // default button
                        $('#voted-up').removeClass('votes-up');
                        $('#inputVotesUp').val(0);
                        $('#inputVotesDown').val(0);
                        $('#questionVotesCountDown').addClass('questionVotesCountDown');
                        $('#voted-down').removeClass('votes-not-selected');
                    }
                });
        });

        // votes down count
        $('body').on('click', '.questionVotesCountDown', function(e){
            e.preventDefault();
            $(this).prop('disabled', true);
            let voteValue = $('#inputVotesDown').val();
            let id = $(this).data('id');
            let url = "{{ route('question.votesCount', ':id') }}";
            url = url.replace(':id', id);
            let data = {
                    vote: voteValue,
                    option: 'votes-down'
                }
            votes(voteValue, url, data, function(res){
                    $('.questionVotesResult').html(res.count);
                    $('.questionVotesCountDown').prop('disabled', false);
                    if (res.status == true) {
                        // red button
                        $('#voted-down').addClass('votes-down');
                        $('#inputVotesDown').val(1);
                        $('#inputVotesUp').val(1);
                        $('#questionVotesCountUp').removeClass('questionVotesCountUp');
                        $('#voted-up').addClass('votes-not-selected');
                    } else {
                        // default button
                        $('#voted-down').removeClass('votes-down');
                        $('#inputVotesDown').val(0);
                        $('#inputVotesUp').val(0);
                        $('#questionVotesCountUp').addClass('questionVotesCountUp');
                        $('#voted-up').removeClass('votes-not-selected');
                    }
                });
        });

        // answer votes
        // votes up count
        $('body').on('click', '.answerVotesCountUp', function(e){
            e.preventDefault();
            $(this).prop('disabled', true);
            let id = $(this).data('id');
            let voteValue = $('#answerInputVotesUp-'+id).val();
            let url = "{{ route('answer.votesCount', ':id') }}";
            url = url.replace(':id', id);
            let data = {
                    vote: voteValue,
                    option: 'votes-up'
                }
            votes(voteValue, url, data, function(res){
                    $('#answerVotesResult-'+id).html(res.count);
                    $('.answerVotesCountUp').prop('disabled', false);
                    if (res.status == true) {
                        // button selected
                        $('#answer-voted-up-'+id).addClass('votes-up');
                        $('#answerInputVotesUp-'+id).val(1);
                        $('#answerInputVotesDown-'+id).val(1);
                        $('#answerVotesCountDown-'+id).removeClass('answerVotesCountDown');
                        $('#answer-voted-down-'+id).addClass('votes-not-selected');
                    } else {
                        // button not selected
                        $('#answer-voted-up-'+id).removeClass('votes-up');
                        $('#answerInputVotesUp-'+id).val(0);
                        $('#answerInputVotesDown-'+id).val(0);
                        $('#answerVotesCountDown-'+id).addClass('answerVotesCountDown');
                        $('#answer-voted-down-'+id).removeClass('votes-not-selected');
                    }
                });
        });

        // votes down count
        $('body').on('click', '.answerVotesCountDown', function(e){
            e.preventDefault();
            $(this).prop('disabled', true);
            let id = $(this).data('id');
            let voteValue = $('#answerInputVotesDown-'+id).val();
            let url = "{{ route('answer.votesCount', ':id') }}";
            url = url.replace(':id', id);
            let data = {
                    vote: voteValue,
                    option: 'votes-down'
                }
            votes(voteValue, url, data, function(res){
                    $('#answerVotesResult-'+id).html(res.count);
                    $('.answerVotesCountDown').prop('disabled', false);
                    if (res.status == true) {
                        // button selected
                        $('#answer-voted-down-'+id).addClass('votes-down');
                        $('#answerInputVotesUp-'+id).val(1);
                        $('#answerInputVotesDown-'+id).val(1);
                        $('#answerVotesCountUp-'+id).removeClass('answerVotesCountUp');
                        $('#answer-voted-up-'+id).addClass('votes-not-selected');
                    } else {
                        // button not selected
                        $('#answer-voted-down-'+id).removeClass('votes-down');
                        $('#answerInputVotesUp-'+id).val(0);
                        $('#answerInputVotesDown-'+id).val(0);
                        $('#answerVotesCountUp-'+id).addClass('answerVotesCountUp');
                        $('#answer-voted-up-'+id).removeClass('votes-not-selected');
                    }
                });
        });

        function votes(voteValue, url, data, successCallback) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: 'PUT',
                data: data,
                success: successCallback
            });
        } 


        // guest votes
        $('.guestVoteButton').on('click', function(){
            alertify.error('Please login to vote!');
        });


        // mark as best answer
        $('.best-answer').on('click', '.check-mark', function(){
            let id = $(this).data('id');
            let url = "{{ route('answer.bestAnswer', ':id') }}";
            url = url.replace(':id', id);

            $(this).toggleClass('check-mark uncheck-mark');
            
            bestAnswerCreate(url, function(res){
                $('.uncheck-mark').removeClass('d-none');
            });
        });

        $('.best-answer').on('click', '.uncheck-mark', function(){
            let id = $(this).data('id');
            let url = "{{ route('answer.bestAnswer', ':id') }}";
            url = url.replace(':id', id);

            $(this).toggleClass('check-mark uncheck-mark');
            
            bestAnswerCreate(url, function(res){
                $('.uncheck-mark').addClass('d-none');
            });
            
        });

        function bestAnswerCreate(url, successCallback){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: 'PUT',
                success: successCallback
            });
        }
        


        // delete question confirm
        $('.delete-question').on('click', function(e){
            e.preventDefault();
            $.confirm({
                title: 'Are you sure?',
                content: 'It will remove your question!',
                buttons: {
                    cancel: function (res) {
                        //cancel
                    },
                    delete: {
                        text: 'delete',
                        btnClass: 'btn-red',
                        action: function(res){
                            $('#delete-question').submit();
                        }
                    }
                }
            });
        });


        // delete answer confirm
        $('.delete-answer').on('click', function(e){
            e.preventDefault();
            let id = $(this).data('id');
            let url = "{{ route('answer.destroy', ':id') }}";
            url = url.replace(':id', id);
            $.confirm({
                title: 'Are you sure?',
                content: 'It will remove your answer!',
                buttons: {
                    cancel: function (res) {
                        //cancel
                    },
                    delete: {
                        text: 'delete',
                        btnClass: 'btn-red',
                        action: function(res){
                            deleteAnswer(url);
                            $.alert('Answer deleted!');
                        }
                    }
                }
            });
        });

        function deleteAnswer(url){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: 'DELETE',
                success: function(res){
                    $('#answer-'+res.answer_id).remove();
                    $('.answer-count').html(`
                        <p>`+res.answer_count+` Answer</p>
                    `);
                }
            });
        }


        // question like button
        $('body').on('click', '.question-like-button', function(){
            let id = $(this).data('id');
            let url = "{{ route('question.like', ':id') }}";
            url = url.replace(':id', id);
            like(url, function(res){
                    $('.question-like').html(`
                        <div class="question-unlike-button" data-id=`+id+`>
                            <i class="fa-solid fa-heart"></i>
                        </div>
                    `);
                });
        }); 

        // question unlike button
        $('body').on('click', '.question-unlike-button', function(){
            let id = $(this).data('id');
            let url = "{{ route('question.like', ':id') }}";
            url = url.replace(':id', id);
            like(url, function(res){
                    $('.question-like').html(`
                        <div class="question-like-button" data-id=`+id+`>
                            <i class="fa-regular fa-heart"></i>
                        </div>
                    `);
                });
        }); 

        // answer like button
        $('.answer-like').on('click', '.answer-like-button', function(){
            let id = $(this).data('id');
            let url = "{{ route('answer.like', ':id') }}";
            url = url.replace(':id', id);
            like(url, function(res){
                $(`#answer-like-`+id).html(`
                    <div class="answer-unlike-button" data-id=`+id+`>
                        <i class="fa-solid fa-heart"></i> 
                    </div>
                `);
            });
        }); 

        // answer unlike button
        $('.answer-like').on('click', '.answer-unlike-button', function(){
            let id = $(this).data('id');
            let url = "{{ route('answer.like', ':id') }}";
            url = url.replace(':id', id);
            like(url, function(res){
                $(`#answer-like-`+id).html(`
                    <div class="answer-like-button" data-id=`+id+`>
                        <i class="fa-regular fa-heart"></i> 
                    </div>
                `);
            });
        }); 

        function like(url, successCallback) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: 'PUT',
                success: successCallback
            });
        } 


        // comment
        $('.btn-comment').on('click', function(e){
            e.preventDefault();
            let id = $(this).data('id');
            let url = "{{ route('answer.comment', ':id') }}";
            url = url.replace(':id', id);
            let value = $('#input-comment-'+id).val();
            let data = {
                    comment: value
                }

            comment(url, data, function(res){
                $('#comment-'+id).html(`
                    <div class="comment py-1">
                        <p class="mb-2 trophy badges">
                            @auth
                                @if (auth()->user()->oauth_picture !== null)
                                    <img src="{{ auth()->user()->oauth_picture }}" alt="..." width="20px" height="20px">
                                @else
                                    <img src="{{ auth()->user()->picture ? asset('assets/profile-picture/'. auth()->user()->picture) : asset('assets/profile-picture/default.png') }}" alt="..." width="20px" height="20px">
                                @endif

                                <a href="{{ route('user.index', [auth()->user()->id, auth()->user()->username]) }}">{{ auth()->user()->name }}</a>
                            @endauth
                            @foreach ($leaderboard as $user)
                                @if ($user['id'] == `+res.user.id+`)
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
                            . <span>1 second ago</span>
                        </p>
                        <p class="m-0">`+res.comment+`</p>
                    </div>
                `);

                if (res.count > 1) {
                    $('#see-all-comment-'+id).html(`
                        see all `+res.count+` comment....
                    `);

                    $('#see-all-comment-'+id).removeClass('d-none');
                }
                
                $('#input-comment-'+id).val('');
            });
        });

        function comment(url, data, successCallback){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: 'POST',
                data: data,
                success: successCallback
            });
        }

        $('.tes-btn').on('click', function(e){
            e.preventDefault();
            let id = $(this).data('id');
            alert(id);
        });

    </script>
@endpush