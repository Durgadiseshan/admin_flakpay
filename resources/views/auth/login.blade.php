@php
use App\Classes\ValidationMessage;
@endphp

@extends('layouts.rupayapayapp')

@section('content')


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
        .error{
            color:red;
        }

    </style>

</head>

<body>

    <div class="login-wrap">
        <div class="left-col-auth linear-gradient">
            <div class="auth-page-container">
                <a href="#" class="pay-flash-logo-white">
                    <img src="{{ asset('new/img/flakpay_logo.png')}}" width="300" alt="Rock Pay" >
                </a>
                <div class="auth-page-slider">
                    <div class="js-slider">
                        <div><img src="{{ asset('new/img/slider-image-1.png')}}" alt=""></div>
                        <div><img src="{{ asset('new/img/slider-image-1.png')}}" alt=""></div>
                    </div>
                </div>
                <div class="auth-content">
                    <h2>Scale-up your Business</h2>
                    <p>with India's Leading "Digital Collections Platform" </p>
                </div>
            </div>
        </div>

        <div class="auth-form-container">
            <a href="#" class="pay-flash-logo-auth">
                <img src="new/img/flakpay_logo.png" width="250" alt="Rockpay">
            </a>
            <h2 class="auth-heading">Sign In</h2>
            <p class="auth-sub-heading">Welcome! We are happy to have you...</p>
            <form method="POST" id="merchant-login" autocomplete="on" onsubmit="return login_form();">
                {{ csrf_field() }}
                <div class="auth-form-group name-control">
                    <input type="text" id="email" name="email" class="auth-form-control" placeholder="Email/Username" id="">
                    <span id="email-error" class="error error_showing_text"></span>
                </div>
                <div class="auth-form-group password-control">
                    <input type="password" id="password" name="password" class="auth-form-control" placeholder="Password" id="">
                    <span id="password-error" class="error"></span>           
                </div>
                <div class="auth-form-group captcha-control">
                    <input name="captcha" id="captcha" type="text" class="auth-form-control" placeholder="Captcha" id="">
                    <span id="captcha-error" class="error"></span>
                </div>
                <div class="auth-form-group">
                    <div class="flex-container captcha-input">
                        <div class="">
                            <img id="display-captcha" src="{{captcha_src('flat')}}" class="img-responsive float-left" alt="Captcha-Image" width="250px" height="50px">
                        </div>
                        <div class="">
                            <span class="captcha-css" onclick="reloadCaptcha();">
                                <i class="pt-3 fas fa-sync fa-lg"></i>
                            </span>
                        </div>
                    </div>
                    <p class="loginError" style="color:red;">
                        @if ($errors->has('captcha'))
                        <span class="help-block">
                            <strong>{{ $errors->first('captcha') }}</strong>
                        </span>
                        @endif
                    </p>

                    <!-- <p class="text-sm-left font-weight-light" style="color:red;">
                    <span class="help-block">
                        <strong id="captcha_ajax_error" class="error_span"></strong>
                    </span>
                   </p> -->

                   <!-- <p class="text-sm-left font-weight-light" style="color:red;">
                    <span class="help-block">
                        <strong id="merchant-login-error" class="error_span"></strong>
                    </span>
                  </p> -->
                </div>

                <p id="ajax-success-response" class="text-center"></p>
                <div class="auth-buttons-group">
                    <input type="submit" class="purple-btn m-r-20" value="Login">
                    <!-- <button type="button" class="purple-btn m-r-20">Login</button> -->
                </div>
                <p class="forgot-pass-link"><a href="forgotpassword">Forgot Password?</a></p>
                <p class="sign-up-txt">Don't have an account? <a href="/register">Sign Up</a></p>
            </form>
        </div>

    </div>
  
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('merchant-login');
        form.addEventListener('submit', function (event) {
            if (!validateForm()) {
                event.preventDefault(); // Prevent form submission if validation fails
            }
        });

        function validateForm() {
            let isValid = true;

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const captcha = document.getElementById('captcha').value;

            // Clear existing error messages
            clearErrorMessages();

            // Simple validation examples, adjust as needed
            if (email.trim() === '') {
                displayErrorMessage('email-error', 'Please enter your email/username.');
                isValid = false;
            }

            if (password.trim() === '') {
                displayErrorMessage('password-error', 'Please enter your password.');
                isValid = false;
            }

            if (captcha.trim() === '') {
                displayErrorMessage('captcha-error', 'Please enter the captcha.');
                isValid = false;
            }

            // Additional validation logic for email format, password strength, etc.

            return isValid; // Form is valid
        }

        function displayErrorMessage(errorId, message) {
            const errorElement = document.getElementById(errorId);
            errorElement.innerText = message;
        }

        function clearErrorMessages() {
            const errorElements = document.querySelectorAll('.error');
            errorElements.forEach(function (errorElement) {
                errorElement.innerText = '';
            });
        }
    });
</script>

</script>





    @endsection