@php

foreach ($errors->get('password') as $index => $message) {
    $password = "";
    $confirm_password = "";
    if($index > 0)
    {
        $confirm_password = $errors->get('password')["0"];
    }else{
        $password = $errors->get('password')["0"];
    }
}

@endphp

@extends('layouts.rupayapayapp')
@section('content')
    <div class="login-container">
        <div class="img">
            <img src="/assets/img/login-img2.png">
        </div>
        <div class="login-content">
            <form class="mt-5" method="POST" action="{{ route('password.request') }}" id="password-request">
                {{ csrf_field() }}
                <img src="/assets/img/avatar.svg">
                <h4 class="title">Reset Password</h4>

                <div class="input-div pass">
                    <div class="i"> 
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="div">
                        <input id="password" type="password" class="input" name="password" placeholder="Password" required>
                    </div>
                    <div class="dp show-pointer" onclick="showPasssword('password',this)"> 
                        <i class="fas fa-eye-slash"></i>
                    </div>
                </div>
                <p class="loginError text-sm-left" style="color:red;font-size: small">
                    @if (!empty($password))
                        <span class="help-block password">
                            <strong>{{ $password }}</strong>
                        </span>
                    @endif
                </p>
                <div class="input-div pass">
                    <div class="i"> 
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="div">
                        <input id="password_confirmation" type="password" class="input" name="password_confirmation" placeholder="Confirm Password" required>
                    </div>
                    <div class="dp show-pointer" onclick="showPasssword('password_confirmation',this)"> 
                        <i class="fas fa-eye-slash"></i>
                    </div>
                </div>
                <p class="loginError text-sm-left" style="color:red;">
                    @if (!empty($confirm_password))
                        <span class="help-block confirm-password">
                            <strong>{{ $confirm_password}}</strong>
                        </span>
                    @endif
                </p>
                <input type="hidden" name="token" value="{{ $token }}">
                <input id="email" type="hidden" class="form-control" name="email" value="{{ $email or old('email') }}">
                <input type="submit" class="btn" value="Reset Password"><br>                
            </form>
        </div>
    </div>
@endsection
