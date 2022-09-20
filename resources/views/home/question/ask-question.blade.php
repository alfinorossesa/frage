@extends('home.layouts.main')
@section('content')
    <div class="ask-question">
        <h5>Ask Question</h5>
        <div class="row mt-4">
            <div class="col-md-8 col-12">
                @if ($errors->any())
                    <div class="alert-danger">
                        <p class="p-3">Please input all field!</p>
                    </div>
                @endif
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('question.askQuestionStore') }}" method="post" class="ask-question">
                            @csrf
                            <div class="mb-3">
                                <label for="title" class="form-label m-0"><strong>Title</strong></label>
                                <p class="ask-description-label">Add specific title you wanna ask</p>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" placeholder="e.g. Who's main character in anime One Piece ?" required>
                                @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label m-0"><strong>Body</strong></label>
                                <p class="ask-description-label">Include all the information someone would need to answer your question</p>
                                <textarea name="body" id="summernote" cols="100" rows="10">{{ old('body') }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label m-0"><strong>Add Tags</strong></label>
                                <p class="ask-description-label">Add tags related to your question (max: 3)</p>
                                <input type="text" class="form-control tag" id="tag" placeholder="e.g. (anime, one-piece). max: 20 character">
                                <div class="col-md-12 mb-4 d-none">
                                    <select name="tag[]" id="tag-result" class="multipleselect" multiple="multiple"></select>
                                </div>
                                <div class="press-space"></div>
                                <div class="tag-info"></div>
                                <div class="tag-result mt-1 mb-4"></div>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-12 most-used-tags">
                <div class="card ask">
                    <div class="card-body">
                    <h6 class="card-title mb-3">Most Used Tags</h6>
                        @foreach ($mostUsedTags as $tag)
                            <div class="tag p-0 mb-2">
                                <a href="{{ route('tag.questionByTag', $tag->tag) }}" class="m-0 tag-name">{{ $tag->tag }}</a> <span class="ml-1"><i class="fa-solid fa-xmark" style="font-size: 10px"></i> {{ $tag->count }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
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

        // delete tag
        $('.tag-result').on('click', '.tag-span', function(){
            this.remove();
            let tagOption = document.getElementById("tag-option-"+this.textContent);
            tagOption.remove();
        });


        // input tag
        let key;
        function spaceKey() {
            $('#tag').keypress(function(e){
                key = e.which;
            });
        }
        spaceKey();
        
        $("#tag").on("input", function () {
            let val = this.value;
            if (val.length > 0) {
                $('.press-space').html(`
                    <p class="m-0 text-danger">Press SPACE to add tag</p>
                `);
            }

            if (val.length == 20) {
                if ($("#tag-result > option").length < 3) {
                    $("#tag-result").append(`
                        <option id="tag-option-`+val+`" value=`+val+` selected>`+val+`</option>
                    `);
                    $(".tag-result").append(`<span class="tag-span ask-question-tag mr-2"><i class="fa-solid fa-xmark"></i>`+val+`</span>`);
                }

                $('#tag').val('');
            }
            
            if (key == 32) {
                if (val !== ' ') {
                    $('.tag-info').html(`<p class="m-0 mt-2"><strong>Tags :</strong></p>`);
                    
                    if ($("#tag-result > option").length < 3) {
                        $("#tag-result").append(`
                            <option id="tag-option-`+val+`" value=`+val+` selected>`+val+`</option>
                        `);
                        $(".tag-result").append(`<span class="tag-span ask-question-tag mr-2"><i class="fa-solid fa-xmark"></i>`+val+`</span>`);
                    }
                } 

                $('#tag').val('');
                $('.press-space').html(``);
            }
        });

        $(".multipleselect").select2();

    </script>
@endpush
