@extends('home.layouts.main')
@section('content')
    <div class="row">
        <div class="col-md-8 col-12">
            <div class="mb-3 back">
                <a class="text-secondary" href="{{ route('question.show', [$answer->question->id, $answer->question->slug]) }}"><h6><i class="fa-solid fa-arrow-left"></i> Back to main question</h6></a>
            </div>
            <div class="your-answer">
                <h5>Edit Your Answer</h5>
                <form action="{{ route('answer.update', [$answer->question->id, $answer->question->slug, $answer->id]) }}" method="POST" class="pt-2">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <textarea name="answer" id="summernote" cols="100" rows="10">{!! $answer->answer !!}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Update your answer</button>
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
    </script>    
@endpush