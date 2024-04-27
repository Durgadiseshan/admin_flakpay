@extends('layouts.app')
@section("content")
<div class="bdy-55">
<img class="wave-55" src="/assets/img/intro-capital.jpg">
	<div class="container-55">
		<div class="img-55">
			<img src="/assets/img/authen.svg">
		</div>
		<div class="login-content-55">
			<form action="{{ route('session-update') }}" class="form-55" method="POST">
                <img src="/assets/img/f-prt.svg">
                @if(!session()->has("account-locked"))
                    <h4>Oh no!</h4>
                    <h2 class="title-55">Session Timeout</h2>
                    <p>You're beign timed out for inactivity </p>
                    <p>Please Re-enter your password to stay Signed-in </p>
                    <div class="input-div-55 one-55 {{ $errors->has('password') ? ' has-error' : '' }}">
                        <div class="i-55">
                                <i class="fa fa-lock"></i>
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
@endsection