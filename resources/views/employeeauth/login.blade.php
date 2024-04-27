@extends('layouts.employeeapp')

@section('content')
<div id="divLoading"></div>
<img class="wave" src="{{asset('assets/img/login-wave.png') }}">
<div class="container">
    <div class="img">
        <img src="{{asset('new/img/slider-image-1.png') }}" style="padding: 0 71px;">
    </div>
    <div class="login-content">
        <form method="POST" id="employee-login" autocomplete="off">
            <img src="{{asset('new/img/flakpay_logo.png') }}" alt="flakpay-logo" width="300">
            <br>
            <br>
            <br>
            <h3 class="title">Employee Login</h3>
            <br>
            <br>
            <div id="employee-success-message" class="text-success">
                @if(session('success'))
                    {{session('success')}}
                @endif
            </div>
            <div id="employee-login-error"></div>
            <div class="input-div one ">
                <div class="i">
                    <i class="fa fa-user fa-lg"></i>
                </div>
                <div class="div">
                    <input type="text" class="input" name="employee_username" id="employee_username" placeholder="Username" value="{{ old('employee_username') }}" required autofocus autocomplete="off">
                </div>
            </div>
            <div class="input-div pass">
                <div class="i"> 
                    <i class="fa fa-lock fa-lg"></i>
                </div>
                <div class="div">
                    <input type="password" class="input"name="password" id="password" placeholder="Password"  required  autocomplete="off">
                </div>
                <i class="fa fa-eye-slash password-toggle" aria-hidden="true"  style="
    color: #d9d9d9;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 20px;
"onclick="togglePassword()"></i>
            </div>     
            <br>       
            <input type="submit" class="btn" value="Login"><br>
            {{ csrf_field() }}
        </form>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="employee-login-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div id="load-login-form">

            </div>
        </div>
    </div>
</div>
<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const togglePasswordIcon = document.querySelector('.password-toggle');

        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);

        
        if (type === 'password') {
            togglePasswordIcon.classList.remove('fa-eye');
            togglePasswordIcon.classList.add('fa-eye-slash');
        } else {
            togglePasswordIcon.classList.remove('fa-eye-slash');
            togglePasswordIcon.classList.add('fa-eye');
        }
    }
    </script>
@endsection
