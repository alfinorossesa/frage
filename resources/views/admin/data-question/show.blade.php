@extends('admin.layouts.main')
@section('content')
<div class="mx-5 my-5">
    <a href="{{ route('dataQuestion.index') }}" class="text-secondary">
        <h6 class="m-0 font-weight-bold"><i class="fas fa-chevron-left"></i> Back</h6>
    </a>
</div>

<div class="card shadow mt-3 mx-5">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Question Information</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>User Name</td>
                                    <td>:</td>
                                    <td>{{ $question->user->name }}</td>
                                </tr>
                                <tr>
                                    <td>Votes</td>
                                    <td>:</td>
                                    <td>{{ $question->vote }}</td>
                                </tr>
                                <tr>
                                    <td>Answer</td>
                                    <td>:</td>
                                    <td>{{ $question->answer->count() }}</td>
                                </tr>
                                <tr>
                                    <td>View</td>
                                    <td>:</td>
                                    <td>{{ $question->view_count }}</td>
                                </tr>
                                <tr>
                                    <td>Date Question</td>
                                    <td>:</td>
                                    <td>{{ $question->created_at->format('d F Y') }} at {{ $question->created_at->format('H:i') }}</td>
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
        <h6 class="m-0 font-weight-bold text-primary">Question Detail</h6>
    </div>
    <div class="card-body">
        <div class="card mb-3">
            <div class="card-body">
                <p>Title :</p>
                <h4>{{ $question->title }}</h4>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <p>Body :</p>
                {!! $question->body !!}
            </div>
        </div>
        <div class="card">
            <div class="card-body tag">
                <p>Tags :</p>
                @foreach ($question['tag'] as $tag)
                    <span class="mr-1">{{ $tag['tag'] }}</span>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-end my-5 mx-5">
    <div>
        <form class="d-inline" action="{{ route('dataQuestion.destroy', $question->id) }}" method="post">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger btn-sm border-0" onclick="return confirm('Are you sure ?')">
                Delete Question
            </button>
        </form>
    </div>
</div>
@endsection