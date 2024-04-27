<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PAYFLASH') }}</title>

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
<!-- mynav -->
 <div class="navbar navbar-default-sess navbar-fixed-top session-timout-page" role="navigation">
    <div class="container" style="margin-top: 2rem;margin-bottom: 2rem;"> 
        <div class="navbar-header bg-transparent">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span> 
            </button>
            <a target="_blank" href="#" class="navbar-brand">
                <img src="/assets/img/flakpay_logo.png"  width="170" alt="">
            </a>
        </div>
        <div class="collapse navbar-collapse">
        
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle drop-sess" data-toggle="dropdown">
                        <span class="fa fas-user"></span> 
                        <strong>{{ Auth::guard("employee")->user()->first_name." ".Auth::guard("employee")->user()->last_name }}</strong>
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
                                        <p class="text-left"><strong>{{ Auth::guard("employee")->user()->first_name." ".Auth::guard("employee")->user()->last_name }} </strong></p>
                                        <p class="text-left small">{{ Auth::guard("employee")->user()->official_email}} </p>
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
                                            <a href="{{ route('rupayapay.logout') }}"
                                            onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();" class="btn btn-danger btn-block">
                                            Logout
                                            </a>

                                            <form id="logout-form" action="{{ route('rupayapay.logout') }}" method="POST" style="display: none;">
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
<div class="bdy-55 session-timout-page-inner">
<img class="wave-55" src="/assets/img/intro-capital.jpg">
	<div class="container-55">
		<div class="img-55">
			<img src="/assets/img/authen.svg">
		</div>
		<div class="login-content-55">
			<form action="{{ route('emp-session-update') }}" class="form-55" method="POST">
                <img src="/assets/img/f-prt.svg">
                @if(!session()->has("account-locked"))
                    <h4>Oh no!</h4>
                    <h2 class="title-55">Session Timeout</h2>
                    <p>You're beign timed out for inactivity </p>
                    <p>Please Re-enter your password to stay Signed-in </p>
                    <div class="input-div-55 one-55 {{ $errors->has('password') ? ' has-error' : '' }}">
                        <div class="i-55">
                            <i class="fa fa-lock fa-lg"></i>
                        </div>
                        <div class="div-55">
                                <input type="password" class="input-55" name="password" placeholder="Re-enter Password"> 
                        </div>
                        <div class="dp show-pointer show-cursor" onclick="visiblePasssword('password',this)"> 
                            <i class="fa fa-eye fa-lg"></i>
                        </div>
                    </div> 
                    <div class="{{ $errors->has('password') ? ' has-error' : '' }}">   
                        @if($errors->has('password'))
                        <span class="help-block">
                            <strong  class="text-danger">{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="{{ session()->has('passwordAttempts') ? ' has-error' : '' }}">
                        @if(session()->has('passwordAttempts'))
                        <div class="col-sm-12">
                            <span class="help-block">
                                <strong class="text-danger">{{ session('passwordAttempts') }}</strong>
                            </span>
                        </div>
                        @endif
                    </div>
                    {{@csrf_field()}}
                    <input type="submit" class="btn-55" value="Login">
                @else
                    <h4>Oh no!</h4>
                    <h2 class="title-55">{{session("account-locked")}}</h2>                    
                @endif
            </form>
        </div>
    </div>
</div>
<script src="{{ asset('js/app.js') }}"></script>
    <!-- <script src="{{ asset('js/login.js') }}"></script> -->
    <script type="text/javascript" src="{{ asset('js/crudapp.js') }}"></script>
</body>
</html>