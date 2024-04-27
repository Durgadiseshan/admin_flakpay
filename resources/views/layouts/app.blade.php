<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Flakpay') }}</title>
    <link href="{{ asset('new/img/flakpay_icon.ico') }}" rel="icon111">
    <link href="{{ asset('new/img/flakpay_icon.ico') }}" rel="apple-touch-icon">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- <link href="{{ asset('css/login.css') }}" rel="stylesheet"> -->
    <link href="{{ asset('css/merchant-custom-style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style2.css') }}" rel="stylesheet">

   


    <!-- Google Fonts -->
  
    <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet">

   

    <!-- font awesome cdn -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- fonts cdn-->
    

</head>
<body>
    <div id="app">
        <!-- mynav -->
        <div class="navbar navbar-default-sess navbar-fixed-top" role="navigation">
            <div class="container"> 
                <div class="navbar-header bg-transparent">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span> 
                    </button>
                    <a target="_blank" href="#" class="navbar-brand">
                        <img src="{{ asset('/assets/img/flakpay_logo.png') }}" width="170" alt="Rockpay">
                    </a>
                </div>
                <div class="collapse navbar-collapse">
                
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle drop-sess" data-toggle="dropdown">
                                <span class="fa fas-user"></span> 
                                <strong>{{ Auth::user()->name }}</strong>
                                
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <div class="navbar-login">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <p class="text-center">
                                                    <img src="/assets/img/navbar-user.png" width="80" alt="">
                                                </p>
                                            </div>
                                            <div class="col-lg-8">
                                                <p class="text-left"><strong>{{ Auth::user()->name }} </strong></p>
                                                <p class="text-left small">{{ Auth::user()->email }} </p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <div class="navbar-login navbar-login-session">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <p>
                                                    <a href="{{ route('logout') }}"
                                                    onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();" class="btn btn-danger btn-block">
                                                    Logout
                                                    </a>

                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                        {{ csrf_field() }}
                                                    </form>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- my nav -->

        @yield('content')
    <!-- </div> -->
    <!-- Scripts -->
   
    </div>
    <!-- <script src="{{ asset('js/app.js') }}"></script> -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <!-- <script src="{{ asset('js/login.js') }}"></script> -->
    <script type="text/javascript" src="{{ asset('js/crudapp.js') }}"></script>
</body>
</html>

<script>
    // Disable both back and forward buttons
    history.pushState(null, null, location.href);
    window.onpopstate = function () {
        history.go(1);
    };

    // Disable forward button
    history.pushState(null, null, location.href);
    window.onbeforeunload = function() {
        return false;
    };
</script>