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
                    @if(session()->has("account-locked"))
                        <img src="/assets/img/f-prt.svg">
                        <h4>Oh no!</h4>
                        <h2 class="title-55">Account Locked <i class="fa fa-lock"></i></h2>
                        <p class="text-black">{{session("account-locked")}}</p>
                        <p><a class="text-black" href="tel:+91 9087711911">+91 9087711911</a></p>
                        <p><a class="text-black" href="mailto:hello@payflash.in">hello@payflash.in</a></p>
                    @else
                        <img src="/assets/img/f-prt.svg">
                        <h4>Oh no!</h4>
                        <h2 class="title-55">Account Locked <i class="fa fa-lock"></i></h2>
                        <p>{{session("account-locked")}}</p>
                        <p class="text-black">Your Account got Locked Temporary.Please contact Our customer support team!</p>
                        <p><a class="text-black" href="tel:+91 9087711911">+91 9087711911</a></p>
                        <p><a class="text-black" href="mailto:hello@payflash.in">hello@payflash.in</a></p>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection