@extends('home.layouts.main')
@section('content')

<div class="row">
    <div class="col-md-8 col-12">
        {{-- answer --}}
        <div class="mb-3 back">
            <a class="text-secondary" href="{{ route('question.show', [$answer->question->id, $answer->question->slug]) }}"><h6><i class="fa-solid fa-arrow-left"></i> Back to main question</h6></a>
        </div>
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
                            <p class="m-0 pb-2" title="This question shows research effort, it's useful and clear"><i class="fa-solid fa-3x fa-caret-up"></i></p>
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
                            <p class="m-0 pb-2" title="This question shows research effort, it's useful and clear"><i class="fa-solid fa-3x fa-caret-down"></i></p>
                        </button>
                    @endauth

                    @auth
                        @if($answer->question->user_id == auth()->user()->id)
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
                <div class="col-md-10 col-10 pt-2">
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
            <h6 id="commentCount">{{ $answer->answerComment->count() }} Comments</h6>

            <div id="comment">
                @foreach ($answer->answerComment as $item)
                    <div class="comment">
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
                @endforeach
            </div>
            
            <form action="#" method="POST">
                @csrf
                <div class="mb-3">
                    <textarea name="comment" class="input-comment" id="input-comment" onkeyup="textAreaAdjust(this)" style="overflow:hidden" placeholder="Add a comment..."></textarea>
                </div>
                <a href="#" id="btn-comment" class="btn btn-sm btn-primary" data-id="{{ $answer->id }}">Add Comment</a>
            </form>
        </div>
        
    </div>
    <div class="col-md-4 col-12 related">
        <div class="card question-interested">
            <div class="card-body">
            <h6 class="card-title mb-3">Questions Might You Interested</h6>
                @foreach ($relatedQuestions as $question)
                    <div class="p-0 mb-2 top-question">
                        <p class="score {{ $question->hasBestAnswer($question) == true ? 'solved' : '' }} {{ $question->vote > 0 ? 'votes-up' : '' }} {{ $question->vote < 0 ? 'votes-down' : '' }}">{{ $question->vote }}</p>
                        <a href="{{ route('question.show', [$question->id, $question->slug]) }}" class="pl-2">{{ $question->title }}</a>
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
            answerUpdateVotes(voteValue, url, data, function(res){
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
            answerUpdateVotes(voteValue, url, data, function(res){
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

        function answerUpdateVotes(voteValue, url, data, successCallback) {
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
        $('#btn-comment').on('click', function(e){
            e.preventDefault();
            let id = $(this).data('id');
            let url = "{{ route('answer.comment', ':id') }}";
            url = url.replace(':id', id);
            let value = $('#input-comment').val();
            let data = {
                    comment: value
                }

            comment(url, data, function(res){
                $('#comment').append(`
                    <div class="comment">
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
                            . <span>1 second ago</span>
                        </p>
                        <p class="m-0">`+res.comment+`</p>
                    </div>
                `);

                $('#commentCount').html(res.count+` Comments`);
                $('#input-comment').val('');
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
    </script>
@endpush