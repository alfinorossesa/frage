@extends('admin.layouts.main')
@section('content')
<div class="container-fluid">

    <h5 class="mb-3 text-gray-800">Data Question Report</h5>

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
                            <th>Question Title</th>
                            <th>Report Message</th>
                            <th>User</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($questionReports as $report)
                            <tr>
                                <td>{{ $loop->iteration }}.</td>
                                <td>{{ $report->question->title }}</td>
                                <td>{{ $report->report_message }}</td>
                                <td>{{ $report->user->name }}</td>
                                <td>
                                    <a href="{{ route('dataQuestionReport.show', $report->id) }}" class="d-none d-sm-inline-block btn btn-sm btn-info shadow-sm rounded-circle border-0">
                                        <i class="fas fa-info-circle fa-sm text-white-100"></i> 
                                    </a>
                                    <form class="d-inline" action="{{ route('dataQuestionReport.destroy', $report->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger btn-sm rounded-circle border-0" onclick="return confirm('Are you sure ?')"><i class="fas fa-xmark fa-sm text-white-100"></i></button>
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