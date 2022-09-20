@extends('admin.layouts.main')
@section('content')
<div class="mx-5 my-5">
    <a href="{{ route('dataTags.index') }}" class="text-secondary">
        <h6 class="m-0 font-weight-bold"><i class="fas fa-chevron-left"></i> Back</h6>
    </a>
</div>

<div class="card shadow mt-3 mx-5">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Tag Information</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Tag Name</td>
                                    <td>:</td>
                                    <td class="tag"><span>{{ $tag->tag }}</span></td>
                                </tr>
                                <tr>
                                    <td>Count</td>
                                    <td>:</td>
                                    <td>{{ $tag->count }} times used in question</td>
                                </tr>
                            </tbody>
                        </table>
                        <hr style="margin: -15px 0 5px 0">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow mt-5 mx-5 my-4 mb-5">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary tag">Questions used tag <span>{{ $tag->tag }}</span></h6>
    </div>
    <div class="card-body">
        <div class="card mb-3">
            <div class="card-body">
                <table class="table table-bordered dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Title</th>
                            <th>Votes</th>
                            <th>Answer</th>
                            <th>View</th>
                            <th>Solved</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($questions as $question)
                            <tr>
                                <td>{{ $loop->iteration }}.</td>
                                <td>{{ $question->title }}</td>
                                <td>{{ $question->vote }}</td>
                                <td>{{ $question->answer->count() }}</td>
                                <td>{{ $question->view_count }}</td>
                                <td>
                                    @if ($question->hasBestAnswer($question) == true)
                                        <i style="color: rgb(6, 211, 6); font-size: 20px;" class="fa-solid fa-check"></i>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('dataQuestion.show', $question->id) }}" class="d-none d-sm-inline-block btn btn-sm btn-info shadow-sm rounded-circle border-0">
                                        <i class="fas fa-info-circle fa-sm text-white-100"></i> 
                                    </a>
                                    <form class="d-inline" action="{{ route('dataQuestion.destroy', $question->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger btn-sm rounded-circle border-0" onclick="return confirm('Apakah anda yakin ?')"><i class="fas fa-trash fa-sm text-white-100"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-end my-5 mx-5">
    <div>
        <form class="d-inline" action="{{ route('dataTags.destroy', $tag->tag) }}" method="post">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger btn-sm border-0" onclick="return confirm('Are you sure ?')">
                Delete Tag
            </button>
        </form>
    </div>
</div>
@endsection