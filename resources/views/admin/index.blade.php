@extends('admin.layouts.main')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ route('dataAdmin.index') }}">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Data Admin
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $admin->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fa-solid fa-user-shield fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ route('dataUser.index') }}">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Data User
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $user->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fa-solid fa-user fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>    
            </a>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ route('dataQuestion.index') }}">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Data Question
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                            {{ $question->count() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fa-solid fa-folder fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>    
            </a>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ route('dataAnswer.index') }}">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Data Answer
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $answer->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fa-solid fa-folder fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>    
            </a>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ route('dataTags.index') }}">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Data Tags
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $tag->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fa-solid fa-hashtag fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ route('dataQuestionReport.index') }}">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Data Question Report
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $questionReport->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fa-solid fa-flag fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>    
            </a>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ route('dataAnswerReport.index') }}">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Data Answer Report
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $answerReport->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fa-solid fa-flag fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
@endsection