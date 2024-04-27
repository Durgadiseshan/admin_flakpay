@extends('layouts.rupayapayapp')

@section('content')
<!doctype html>


<head>
    <meta charset="utf-8">
    <title>Rockpay : Your Digital Payment Partner</title>
    <meta name="description" content="">
    <meta name="viewport" content="minimum-scale=1.0, width=device-width, maximum-scale=1, user-scalable=no" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('new/css/normalize.css')}}" />
    <link rel="stylesheet" href="{{ asset('new/css/sumoselect.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('new/css/slick.css')}}" />
    <link rel="stylesheet" href="{{ asset('new/css/slick-theme.css')}}" />
    <link rel="stylesheet" href="{{ asset('new/css/main.css')}}" />

    <style>
        .flex-container {
            display: flex;
            flex-wrap: nowrap;
        }

        .flex-container>div {

            margin: 10px;
            text-align: center;
        }

        .linear-gradient {
        background:linear-gradient(to left,#27BDFF , #4E4EF9) !important
            }

        .purple-btn
        {
            background-color : #4E4EF9 !important;
        }

        .forgot-pass-link a,.sign-up-txt a
        {
         color : #4E4EF9 !important;
        }

        
    </style>

</head>



<body>

    <div class="login-wrap">
        <div class="left-col-auth linear-gradient">
            <div class="auth-page-container">
                <a href="#" class="pay-flash-logo-white">
                    <img src="new/img/flakpay_logo.png" width="250" alt="flakpay">
                </a>
                <div class="auth-page-slider">
                    <div class="js-slider">
                        <div><img src="img/slider-image-1.png" alt=""></div>
                        <div><img src="img/slider-image-1.png" alt=""></div>
                    </div>
                </div>
                <div class="auth-content">
                    <h2>Scale-up your Business</h2>
                    <p>with India's Leading "Digital Collections Platform" </p>
                </div>
            </div>
        </div>

    
        <div class="auth-form-container auth-signup-form-container">
            <a href="#" class="pay-flash-logo-auth">
                <img src="new/img/RockPay_Logo_white.png" width="250" alt="Rockpay">
            </a>
            <h2 class="auth-heading">Sign Up</h2>
            <p class="auth-sub-heading">Welcome! We are happy to have you...</p>
            <form method="POST" autocomplete="off" id="merchant-register" >
                {{ csrf_field() }}
                <div class="auth-form-group name-control">
                    <input type="text" class="auth-form-control" name="name" id="name" placeholder="Name" value="{{ old('name') }}" onkeyup="validateName('name');">
                </div>
                <div class="auth-form-group email-control">
                    <input type="text" class="auth-form-control" name="email" placeholder="Email" autocapitalize="off" autocomplete="off" value="{{ old('email') }}">
                </div>
                <div class="auth-form-group mobile-control">
                    <input type="text" class="auth-form-control" name="mobile_no" placeholder="Mobile" value="{{ old('mobile_no') }}" onkeypress="return isNumber(event)">
                </div>
                <div class="auth-form-group password-control">
                    <input type="password" class="auth-form-control" name="password" placeholder="Password">
                </div>
                <div class="auth-form-group password-control">
                    <input type="password" class="auth-form-control" name="password_confirmation" placeholder="Password">
                </div>
                <p class="text-sm-left font-weight-light" style="color:red;">
                    <span class="help-block">
                        <strong id="password_ajax_error"></strong>
                    </span>
                </p>
                <!-- <div class="auth-form-group password-control">
                    <input type="text" class="auth-form-control" name="password_confirmation" placeholder="Confirm Password">
                    <div class="dp show-pointer" onclick="showPasssword('password_confirmation',this)">
                        <i class="fas fa-eye fa-lg"></i>
                    </div>
                </div> -->
                <p class="text-sm-left font-weight-light" style="color:red;">
                    <span class="help-block">
                        <strong id="cpassword_ajax_error"></strong>
                    </span>
                </p>
                <p class="text-sm-left font-weight-light" style="color:red;">
                    <span class="help-block">
                        <strong id="name_ajax_error"></strong>
                    </span>
                </p>
                <p class="text-sm-left font-weight-light" style="color:red;">
                    <span class="help-block">
                        <strong id="mobile_no_ajax_error"></strong>
                    </span>
                </p>
                <p class="text-sm-left font-weight-light" style="color:red;">
                    <span class="help-block">
                        <strong id="captcha_ajax_error"></strong>
                    </span>
                </p>
                <p class="text-sm-left font-weight-light" style="color:red;">
                    <span class="help-block">
                        <strong id="email_ajax_error"></strong>
                    </span>
                </p>
                <div class="flex-container">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="i_agree" id="i_agree" >
                            <span class="cr show-pointer"><i class="cr-icon fa fa-check"></i></span>
                            By clicking the checkbox, you agree to the <a href="{{secure_url('/term&condition')}}">Terms & Conditions</a> and <a href="{{secure_url('/agreement')}}">MSA</a>
                            <div id="ajax-fail-response"></div>
                        </label>
                    </div>
                </div>
                <div class="auth-buttons-group">
                    <input type="submit" class="purple-btn m-r-20" value="Register">
                </div>
                <p class="sign-up-txt">Already have an account? <a href="/login">Sign In</a></p>
            </form>
        </div>

    </div>


    <!-- otpverificationmodal -->
    <div class="modal" tabindex="-1" role="dialog" id="modalMobileVerify">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title text-light">Mobile Verification</h5>
                    <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <img src="assets/img/forget-password.png" width="200" height="100" alt="avatar" class="rounded-circle img-responsive">
                        </div>
                    </div>
                    <p id="ajax-success-response" class="text-center"></p>
                    <div class="row">
                        <div class="col-sm-12">
                            <form id="mobile-verification">
                                <div class="form-group row">
                                    <label for="otp_number" class="col-sm-4 col-form-label text-right">OTP No:</label>
                                    <div class="col-sm-8">
                                        <input id="otp_number" type="text" class="form-control" name="otp_number" value="{{ old('otp_number') }}">
                                        <span id='otp_number_ajax_error'></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <a href="javascript:" class="btn-link float-right" id="resend-mobile-sms">Send OTP Again</a>
                                    </div>
                                </div>
                                {{csrf_field()}}
                                <div class="form-group row">
                                    <div class="col-sm-8 offset-sm-4">
                                        <input type="submit" class="btn btn-primary" value="Next">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>

@endsection