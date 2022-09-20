@extends('home.layouts.main')
@section('content')

<div class="row">
    <div class="col-md-8">
        <div class="home">
            <h1>Curious about something?</h1>
            <p class="m-0 pl-2">Use FRAGE to ask everything what do you want to know.</p>
            <p class="pl-2">Or you can help other people's question.</p>
            <a href="{{ route('question.askQuestion') }}" class="btn btn-primary">Ask question</a>
            <a href="{{ route('question.index') }}" class="btn btn-outline-secondary">Help other question</a>
        </div>
    </div>
    <div class="col-md-4 mt-5 home-image">
        <img src="{{ asset('assets/img/home.png') }}" alt="">
    </div>
</div>

@endsection
