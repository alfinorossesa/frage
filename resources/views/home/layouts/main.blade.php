<!doctype html>
<html lang="en">
  <head>
  	<title>FRAGE</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/logo.png') }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@site_account">
    <meta name="twitter:creator" content="@individual_account">
    <meta name="twitter:url" content="{{ $meta['url'] }}">
    <meta name="twitter:title" content="{{ $meta['title'] }}">
    <meta name="twitter:description" content="{{ $meta['description'] }}">
    <meta name="twitter:image" content="{{ asset('assets/img/logo.png') }}">
    <meta name="twitter:image:alt" content="FRAGE logo">

    <meta property="fb:app_id" content="123456789">
    <meta property="og:url" content="{{ $meta['url'] }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $meta['title'] }}">
    <meta property="og:image" content="{{ asset('assets/img/logo.png') }}">
    <meta property="og:image:alt" content="FRAGE logo">
    <meta property="og:description" content="{{ $meta['description'] }}">
    <meta property="og:site_name" content="FRAGE">
    <meta property="og:locale" content="en_US">
    <meta property="article:author" content="">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mobile-style.css') }}"> 
    
    {{-- multiple select --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    {{-- summernote text editor --}}
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

    <!--load all Font Awesome styles -->
    <link href="{{ asset('fontawesome-free/css/all.css') }}" rel="stylesheet">

    {{-- alertify --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css"/>
  
    {{-- jquery confirm --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
</head>
  <body>

    {{-- navbar --}}
    <nav class="navbar fixed-top navbar-expand-lg bg-light">
        <div class="container">
            @if (!request()->is('/*'))
                <div class="custom-menu">
                    <button type="button" id="sidebarCollapse" class="btn btn-link">
                        <i style="color: #17A2B8" class="fa fa-bars"></i>
                        <span class="sr-only">Toggle Menu</span>
                    </button>
                </div>
            @endif

            <a class="navbar-brand pt-2" style="font-weight: 600;" href="/"><img src="{{ asset('assets/img/logo.png') }}" width="40px"> FRAGE</a>
            
            <button class="navbar-toggler pt-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"><i style="color: #17A2B8" class="fa-solid fa-bars-progress"></i></span>
            </button>
            <div class="collapse justify-content-end navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 px-4">
                    <li class="nav-item">
                        <form class="d-flex search" action="{{ route('question.search') }}" method="GET">
                            <input type="text" name="search" class="form-control me-2" placeholder="Search question..." value="{{ request('search') }}">
                            <button class="btn btn-primary ml-2" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </form>
                    </li>
                </ul>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 px-4">
                    @auth
                        <li class="nav-item dropdown">
                            @if (auth()->user()->oauth_picture !== null)
                                <img src="{{ auth()->user()->oauth_picture }}" alt="..." width="30px" height="30px">
                            @else
                                <img src="{{ auth()->user()->picture ? asset('assets/profile-picture/'. auth()->user()->picture) : asset('assets/profile-picture/default.png') }}" alt="..." width="30px" height="30px">
                            @endif

                            <a class="btn user pl-0" data-toggle="dropdown"> 
                                {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{ route('user.index', [auth()->user()->id, auth()->user()->username]) }}">Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link btn btn-primary login" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-outline-secondary signup" href="{{ route('signup') }}">Sign up</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="wrapper d-flex align-items-stretch content-body">
        {{-- sidebar --}}
        @if (!request()->is('/*'))
            @include('home.layouts.sidebar')
        @endif

        <!-- Page Content -->
        <div id="content" class="p-4 p-md-5 pt-5">
            @yield('content')
        </div>
	</div>

    {{-- footer --}}
    <footer>
        <div class="container pb-4">
            <div class="row">
                <div class="col-md-3 col-3 logo">
                    <img src="{{ asset('assets/img/logo.png') }}"> 
                    <h5>FRAGE</h5>
                    <p>Ask everything on FRAGE</p>
                </div>
                <div class="col-md-2 col-2 mt-2">
                    <h6>Content</h6>
                    <p class="m-0"><a class="text-secondary" href="{{ route('question.index') }}">Questions</a></p>
                    <p class="m-0"><a class="text-secondary" href="{{ route('tag.index') }}">Tags</a></p>
                    <p class="m-0"><a class="text-secondary" href="{{ route('leaderboard.index') }}">Leaderboard</a></p>
                </div>
                <div class="col-md-3 col-3 mt-2">
                    <h6>Contact Developer</h6>
                    <p class="m-0"><i class="fa-brands fa-github"></i> <a class="text-secondary" target="_blank" href="https://github.com/alfinorossesa/frage">GitHub</a></p>
                    <p class="m-0"><i class="fa-solid fa-envelope"></i> <a class="text-secondary" target="_blank" href="mailto:alfino.zxcvbnm@gmail.com">Mail</a></p>
                </div>
                <div class="col-md-4 col-4">
                    <div class="d-flex justify-content-end contribute">
                        <p>Want to contribute for this project? <strong><a class="text-secondary" target="_blank" href="https://github.com/alfinorossesa/frage">GitHub</a></strong></p>
                    </div>
                    <div class="d-flex justify-content-end copyright">
                        <p>Copyright Frage &copy; 2022 all rights reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    
    {{-- multiple select --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/popper.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>

    {{-- jquery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    
    {{-- summernote text editor --}}
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    {{-- alertify --}}
    <script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

    {{-- jquery confirm --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

    {{-- laravel share js --}}
    <script src="{{ asset('js/share.js') }}"></script>

    @stack('script')
  </body>
</html>