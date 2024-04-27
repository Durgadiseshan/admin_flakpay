@extends('layouts.employeeapp')

@section('content')

<img class="wave" src="{{asset('images/login-wave.png') }}">
<div class="container">
    <div class="img">
        <img src="{{asset('images/personall.svg') }}">
    </div>
    <div class="login-content">
       
        <form method="POST" id="employee-forget-password">
            <img src="{{asset('images/f-prt.svg') }}">
            <h2 class="title">Forget Password</h2>
            <div id="employee-success-message"></div>
            <div id="employee-forget-form-error"></div>
            <div class="input-div one ">
                <div class="i">
                    <i class="fa fa-user"></i>
                </div>
                <div class="div">
                    <input type="text" class="input" name="official_email" id="official_email" placeholder="Official Email" value="{{ old('employee_username') }}" required autofocus>
                </div>
            </div>
            <input type="submit" class="btn" value="Send Request"><br>
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

@endsection
