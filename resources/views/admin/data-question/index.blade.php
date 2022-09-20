@extends('admin.layouts.main')
@section('content')
<div class="container-fluid">

    <h5 class="mb-3 text-gray-800">Data Question</h5>

    {{-- alert --}}
    @include('admin.alerts.alert')

    <div class="card shadow mb-5">
        <div class="card-header py-3"></div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Title</th>
                            <th>Votes</th>
                            <th>Answer</th>
                            <th>View</th>
                            <th>User</th>
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
                                <td>{{ $question->user->name }}</td>
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
                                        <button type="submit" class="btn btn-danger btn-sm rounded-circle border-0" onclick="return confirm('Are you sure ?')"><i class="fas fa-trash fa-sm text-white-100"></i></button>
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
@endsection