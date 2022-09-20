@extends('home.layouts.main')
@section('content')

<div class="row mb-4">
    <div class="col-md-8 col-12">
        <div class="question-ask">

            @if (request('search'))
                <h3>Questions by search :</h3>
            @else
                <h3>All Questions</h3>
            @endif

            <h5><a href="{{ route('question.askQuestion') }}" class="btn btn-primary">Ask Question</a></h5>
        </div>

        <p class="search-result"><code>{{ Str::limit(request('search'), 65) }}</code></p>

        <div class="row mb-3">
            <div class="col-md-4 col-3 question-total">
                <p class="m-0">{{ $count }} Questions</p>
            </div>
            <div class="col-md-8 col-9 d-flex justify-content-end question-filter">

                @if (request('search'))
                    <a href="{{ route('question.search', ['search='.request('search'), 'newest']) }}" class="{{ request()->has('newest') ? 'active' : '' }}">Newest</a>
                    <a href="{{ route('question.search', ['search='.request('search'), 'mostPopular']) }}" class="{{ request()->has('mostPopular') ? 'active' : '' }}">Most Popular</a>
                    <a href="{{ route('question.search', ['search='.request('search'), 'unanswered']) }}" class="{{ request()->has('unanswered') ? 'active' : '' }}">Unanswered</a>
                    <a href="{{ route('question.search', ['search='.request('search'), 'unsolved']) }}" class="{{ request()->has('unsolved') ? 'active' : '' }}">Unsolved</a>
                    <a href="{{ route('question.search', ['search='.request('search'), 'solved']) }}" class="{{ request()->has('solved') ? 'active' : '' }}">Solved</a>
                @else
                    <a href="{{ route('question.index', ['newest']) }}" class="{{ request()->has('newest') ? 'active' : '' }}">Newest</a>
                    <a href="{{ route('question.index', ['mostPopular']) }}" class="{{ request()->has('mostPopular') ? 'active' : '' }}">Most Popular</a>
                    <a href="{{ route('question.index', ['unanswered']) }}" class="{{ request()->has('unanswered') ? 'active' : '' }}">Unanswered</a>
                    <a href="{{ route('question.index', ['unsolved']) }}" class="{{ request()->has('unsolved') ? 'active' : '' }}">Unsolved</a>
                    <a href="{{ route('question.index', ['solved']) }}" class="{{ request()->has('solved') ? 'active' : '' }}">Solved</a>
                @endif
                
            </div>
        </div>

        {{-- question --}}
        @if ($count == 0)
            <div class="question-content">
                <p>No questions records...</p>
            </div>
        @endif

        @foreach ($questions as $question)
            @if (request()->has('unsolved'))
                @if ($question->hasBestAnswer($question) == false)
                    @include('home.question._question')
                @endif
            @elseif (request()->has('solved'))
                @if ($question->hasBestAnswer($question))
                    @include('home.question._question')
                @endif
            @else
                @include('home.question._question')
            @endif
        @endforeach

        {{-- pagination --}}
        @if ($count > 20)
            <div class="mt-5 pagination">
                {{ $questions->links() }}
            </div>
        @endif

    </div>
    <div class="col-md-4 col-12 most-used-tags">
        <div class="card">
            <div class="card-body">
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