<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}"> 

    <title>{{ config('app.name', 'Neopay') }}</title>
    <link href="{{ asset('assets/img/neopay-icon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/neopay-icon.png') }}" rel="apple-touch-icon">

    <!-- Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    
    <!-- font awesome cdn -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- fonts cdn-->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet"> 
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    @switch($loadcss)
        @case("single-product")
            <link rel="stylesheet" href="{{ asset('css/productpage.css') }}">
        @break  
        @case("charity")
            <link rel="stylesheet" href="{{ asset('css/charity.css') }}">
        @break 
    @endswitch
</head>
<body>
    <div id="divLoading"> 
    </div>
    @if($form == "create" || $form == "edit")
    <nav class="navbar navbar-expand-lg fixed-top mb-5">
        <a class="navbar-brand" href="#">{{ config('app.name', 'Neopay') }}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="btn btn-outline-success my-2 my-sm-0" href="{{ url('/merchant/tools') }}">Dashoard</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-outline-success my-2 my-sm-0 ml-3" href="javascript:void(0)" onclick="saveActivatePage()">Save & Activate page</a>
                </li>
            </ul>
        </div>
    </nav>
    @endif
    <div id="app">
        @yield('content')
    </div>
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.serializejson.js') }}"></script>
    @switch($loadscript)
        @case("single-product")
            <script type="text/javascript" src="{{ asset('js/paymentpage.js') }}"></script>
        @break  
        @case("charity")
            <script type="text/javascript" src="{{ asset('js/charity.js') }}"></script>
        @break 
    @endswitch
    <!-- Scripts -->
</body>
</html>