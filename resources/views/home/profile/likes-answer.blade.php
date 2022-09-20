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

        <div class="col-md-10 col-12 likes-answer-box">
            <div class="col-md-12 col-12">
                <h5>Likes Answer</h5>
                <div class="card">
                    <div class="card-body pt-0">

                        @if ($likesAnswer->first() == null)
                            <p class="m-0">Don't have likes answer record yet.</p>
                        @endif
                        @foreach ($likesAnswer as $answer)
                            <div class="user-likes-answer row">
                                <div class="col-md-9 col-8">

                                    @if ($answer->answer->bestAnswer()->where('answer_id', $answer->answer->id)->first() !== null)
                                        @if ($answer->answer->bestAnswer()->where('answer_id', $answer->answer->id)->first()['check'] == true)
                                            <p class="score best-answer {{ $answer->answer->vote > 0 ? 'votes-up' : '' }} {{ $answer->answer->vote < 0 ? 'votes-down' : '' }}">{{ $answer->answer->vote }}</p>
                                        @else
                                            <p class="score {{ $answer->answer->vote > 0 ? 'votes-up' : '' }} {{ $answer->answer->vote < 0 ? 'votes-down' : '' }}">{{ $answer->answer->vote }}</p>
                                        @endif
                                    @else
                                        <p class="score {{ $answer->answer->vote > 0 ? 'votes-up' : '' }} {{ $answer->answer->vote < 0 ? 'votes-down' : '' }}">{{ $answer->answer->vote }}</p>
                                    @endif

                                    <a href="{{ route('answer.allComment', [$answer->answer->question_id, $answer->answer->question->slug, $answer->answer->id]) }}">{{  str_replace('&nbsp;', ' ', $answer->answer->excerpt)  }}</a>
                                </div>
                                <div class="col-md-3 col-4 text-right">
                                    <p>{{ $answer->created_at->format('d F Y') }}</p>
                                </div>
                            </div>
                        @endforeach
                        
                    </div>
                </div>

                <div class="mt-4 pagination">
                    {{ $likesAnswer->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection