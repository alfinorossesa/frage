@extends('home.layouts.main')
@section('content')
    <div class="d-flex justify-content-center report-box">
        <div class="col-md-7">
            <h6 class="text-danger mb-3"><i class="fa-solid fa-flag"></i> Report this answer!</h6>
            <div class="card report">
                <div class="card-body">
                    <p class="text-danger">Please tell us why you report this answer.</p>
                    <form action="{{ route('answer.reportStore', $answer->id) }}" method="POST" class="mt-3">
                        @csrf
                        <div class="mb-3">
                            <textarea name="report_message" class="input-report" placeholder="Report message..."></textarea>
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="{{ url()->previous() }}" class="btn btn-link">Cancel</a>
                            <button type="submit" class="btn btn-sm btn-danger">Report!</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection