@extends('home.layouts.main')
@section('content')
    <div class="row mb-4">
        <div class="col-md-8 col-12">
            <div class="question-ask"> 
                <h3 class="mb-4 tag-title">Questions by tag <a href="#" class="m-0 tag-name">{{ $tag->tag }}</a></h3>
                <h5 class="mb-4"><a href="{{ route('question.askQuestion') }}" class="btn btn-primary">Ask Question</a></h5>
            </div>
            <div class="row mb-3">
                <div class="col-md-4 col-3 question-total">
                    <p class="m-0">{{ $count }} Questions</p>
                </div>
                <div class="col-md-8 col-9 d-flex justify-content-end question-filter">
                    <a href="{{ route('tag.questionByTag', [$tag->tag, 'newest']) }}" class="{{ request()->has('newest') ? 'active' : '' }}">Newest</a>
                    <a href="{{ route('tag.questionByTag', [$tag->tag, 'mostPopular']) }}" class="{{ request()->has('mostPopular') ? 'active' : '' }}">Most Popular</a>
                    <a href="{{ route('tag.questionByTag', [$tag->tag, 'unanswered']) }}" class="{{ request()->has('unanswered') ? 'active' : '' }}">Unanswered</a>
                    <a href="{{ route('tag.questionByTag', [$tag->tag, 'unsolved']) }}" class="{{ request()->has('unsolved') ? 'active' : '' }}">Unsolved</a>
                    <a href="{{ route('tag.questionByTag', [$tag->tag, 'solved']) }}" class="{{ request()->has('solved') ? 'active' : '' }}">Solved</a>
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
                        @include('home.tag._question')
                    @endif
                @elseif (request()->has('solved'))
                    @if ($question->hasBestAnswer($question))
                        @include('home.tag._question')
                    @endif
                @else
                    @include('home.tag._question')
                @endif
            @endforeach
            
            {{-- pagination --}}
            <div class="mt-5 pagination">
                {{ $questions->links() }}
            </div>
    
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