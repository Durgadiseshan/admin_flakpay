@php
use App\Classes\ValidationMessage;
@endphp

@extends('layouts.rupayapayapp')

@section('content')

<head>
    <meta charset="utf-8">
    <title>PayFlash: Pay Yourbackers Foundation</title>
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

</head>

<body>

    <div class="forgot-form-wrap">
        <a href="/login" class="back-link">Back</a>
        <h4 class="forgot-form-heading">We'll send you an email to reset your password</h4>
        <form id="password-reset" class="form" onsubmit="return email_validate_form();">
        {{csrf_field()}}
            <div class="email-form-group">
                <input type="text" class="form-control" placeholder="Email" id="email">
                <div id="email_error_message" class="email_style_msge" style="color:red;"></div>
            </div>
            <div class="auth-buttons-group">
                <input type="submit" class="purple-btn" value="Send">
            </div>
        </form>
    </div>


</body>
<script>
      function email_validate_form() {
            var emailInput = document.getElementById('email');
            var emailValue = emailInput.value.trim();
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            var errorMessageElement = document.getElementById('email_error_message');

            if (!emailRegex.test(emailValue)) {
                errorMessageElement.innerText = 'Please enter a valid email address.';
                return false;
            }

          
            errorMessageElement.innerText = '';

            return true;
        }
</script>

@endsection