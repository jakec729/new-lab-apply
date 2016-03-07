<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ApplicationReviewr</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link rel="stylesheet" href="/css/app.css">
</head>
<body id="app-layout">
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    <span class="inline-block">
                        <svg id="newlab-logo" class="" xmlns="http://www.w3.org/2000/svg" width="46.183" height="53.071" viewBox="0 0 46.183 53.071"><polygon class="logo-seg" id="fill-1" fill="#A6BEC8" points="23.089,12.724 13.621,7.26 23.089,1.793 32.557,7.26    "></polygon><polygon class="logo-seg" id="fill-2" fill="#A6BEC8" points="11.128,19.631 1.662,25.097 1.661,14.165 11.129,8.699   "></polygon><polygon class="logo-seg" id="fill-3" fill="#A6BEC8" points="12.792,19.63 12.791,8.699 22.258,14.165 22.258,25.097  "></polygon><polygon class="logo-seg" id="fill-4" fill="#A6BEC8" points="33.39,19.629 23.923,25.095 23.923,14.163 33.391,8.697  "></polygon><polygon class="logo-seg" id="fill-5" fill="#A6BEC8" points="35.053,19.63 35.052,8.699 44.52,14.165 44.52,25.097    "></polygon>    <polygon class="logo-seg" id="fill-6" fill="#A6BEC8" points="11.96,32.001 2.492,26.536 11.96,21.07 21.428,26.536    "></polygon><polygon class="logo-seg" id="fill-7" fill="#A6BEC8" points="34.221,32.001 24.754,26.536 34.221,21.07 43.689,26.536     "></polygon><polygon class="logo-seg" id="fill-8" fill="#A6BEC8" points="1.663,38.907 1.661,27.975 11.129,33.441 11.129,44.374  "></polygon><polygon class="logo-seg" id="fill-9" fill="#A6BEC8" points="22.257,38.907 12.791,44.374 12.791,33.442 22.258,27.975    "></polygon><polygon class="logo-seg" id="fill-10" fill="#A6BEC8" points="23.921,38.907 23.92,27.975 33.388,33.441 33.388,44.374    "></polygon><polygon class="logo-seg" id="fill-11" fill="#A6BEC8" points="44.519,38.907 35.052,44.374 35.052,33.441 44.52,27.975    "></polygon><polygon class="logo-seg" id="fill-12" fill="#A6BEC8" points="23.092,51.278 13.624,45.814 23.092,40.347 32.559,45.813   "></polygon><path id="shape" fill="#FFF" d="M45.767 12.963L23.507.11c-.257-.148-.574-.148-.83 0L.414 12.964c-.257.15-.415.423-.415.72V39.387c0 .297.158.572.415.72l22.26 12.852c.13.074.273.11.417.11.143 0 .287-.036.415-.11l22.26-12.853c.258-.148.416-.423.416-.72V13.683c0-.297-.158-.57-.416-.72zM23.09 1.793l9.467 5.466-9.468 5.464-9.47-5.465 9.47-5.467zM33.386 8.7v10.93l-9.467 5.465v-10.93L33.387 8.7zm-20.596 0l9.468 5.464v10.93l-4.318-2.49-5.15-2.974V8.7zM1.663 14.163l9.466-5.465V19.63l-9.466 5.465V14.163zm9.466 30.208l-9.466-5.464v-10.93l9.466 5.465v10.93zM2.492 26.537l9.467-5.466 9.467 5.466L11.96 32 2.49 26.537zm10.3 6.905l9.466-5.464v10.93l-9.467 5.466v-10.93zm10.3 17.84l-9.47-5.468 9.468-5.467 9.47 5.468-9.468 5.466zM33.39 44.37l-9.467-5.466v-10.93l9.467 5.465v10.932zm-8.637-17.836l9.468-5.466 9.47 5.466L34.22 32l-9.467-5.464zm19.766 12.37l-9.467 5.466v-10.93l9.466-5.466v10.93zm0-13.81l-9.47-5.468V8.695l9.47 5.468v10.933z"></path></svg>
                    </span>
                    <span class="inline-block">Membership Review</span>
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url("/users/" . Auth::id() ) }}">My Account</a></li>
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
</body>
</html>
