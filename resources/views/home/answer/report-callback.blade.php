@extends('home.layouts.main')
@section('content')
    <div class="text-center mt-5 report-callback">
        <h2 style="color: #48A868"><i class="fa-solid fa-clipboard-check"></i></h2>
        <h3 style="color: #48A868">Thank you for your reporting!</h3>
        <h6 style="color: #48A868">We will take an action for this answer.</h6>
    </div>
    <div class="mt-5 text-center report-done">
        <a href="{{ route('question.index') }}" class="text-secondary">Done!</a>
    </div>
@endsection