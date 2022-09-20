@extends('admin.layouts.main')
@section('content')
<div class="container-fluid">

    <h5 class="mb-3 text-gray-800">Data Answer</h5>

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
                            <th>Answer</th>
                            <th>Votes</th>
                            <th>User</th>
                            <th>Best</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($answers as $answer)
                            <tr>
                                <td>{{ $loop->iteration }}.</td>
                                <td>{{ $answer->excerpt }}</td>
                                <td>{{ $answer->vote }}</td>
                                <td>
                                    @if ($answer->user_id !== null)
                                        {{ $answer->user->name }}
                                    @else
                                        (guest) {{ $answer->name }}
                                    @endif
                                </td>
                                <td>
                                    @if ($answer->bestAnswer()->where('answer_id', $answer->id)->first() !== null)
                                        @if ($answer->bestAnswer()->where('answer_id', $answer->id)->first()['check'] == true)
                                            <i class="fa-solid fa-check" style="color: rgb(6, 211, 6); font-size: 20px;"></i>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('dataAnswer.show', $answer->id) }}" class="d-none d-sm-inline-block btn btn-sm btn-info shadow-sm rounded-circle border-0">
                                        <i class="fas fa-info-circle fa-sm text-white-100"></i> 
                                    </a>
                                    <form class="d-inline" action="{{ route('dataAnswer.destroy', $answer->id) }}" method="post">
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