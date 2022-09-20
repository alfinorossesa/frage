<!doctype html>
<html lang="en">
  <head>
    <title>FRAGE</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/logo.png') }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

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

    <!--load all Font Awesome styles -->
    <link href="{{ asset('fontawesome-free/css/all.css') }}" rel="stylesheet">
    
   </head> 
  <body>

    {{-- navbar --}}
    <nav class="navbar fixed-top navbar-expand-lg bg-light">
        <div class="container">
            <a class="navbar-brand pt-2" style="font-weight: 600;" href="/"><img src="{{ asset('assets/img/logo.png') }}" width="40px"> FRAGE</a>
            
            <button class="navbar-toggler pt-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"><i style="color: #17A2B8" class="fa-solid fa-bars-progress"></i></span>
            </button>
            <div class="collapse justify-content-end navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto my-2 mb-lg-0 px-4">
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary login" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-secondary signup" href="{{ route('signup') }}">Sign up</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="wrapper d-flex align-items-stretch content-body login">
        <!-- Page Content -->
        <div id="content" class="p-4 p-md-5 pt-5">
            @yield('content')
        </div>
	</div>

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    
    {{-- jquery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/popper.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    
    @stack('script')
  </body>
</html>