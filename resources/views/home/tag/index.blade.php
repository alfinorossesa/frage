@extends('home.layouts.main')
@section('content')
    <div class="all-tags">
        <h3>All Tags</h3>
        <p class="m-0">A tag is a keyword or label that categorizes your question with other, similar questions.</p>
        <p class="m-0">Using the right tags makes it easier for others to find and answer your question.</p>

        <div class="row tags">
            @foreach ($tags as $tag)
                <div class="col-md-3 col-6 this-tag">
                    <div class="card">
                        <div class="tag">
                            <a href="{{ route('tag.questionByTag', $tag->tag) }}" class="m-0 tag-name">{{ $tag->tag }}</a>
                            <p class="m-0 question-count">{{ $tag->count }} times used in question</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    
    {{-- pagination --}}
    <div class="mt-4 pagination">
        {{ $tags->links() }}
    </div>
    
@endsection