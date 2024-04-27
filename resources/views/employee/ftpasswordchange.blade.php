@extends('layouts.employeeapp')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Change Password <h5 class="h5">This page comes only when you are logining for the first time</h5></div>
                <div class="panel-body">
                    @if(session('wrong_otp'))
                    <div class="text-center" id="hideMe">{{session('wrong_otp')}}</div>
                    @endif
                    @if(session("message"))
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <strong>Success! </strong> {{session("message")}}
                        </div>
                    @endif
                    @if(session("OTPstatus"))
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <strong>Error !</strong> {{session("message")}}
                        </div>
                    @endif
                    @if(!session("phone_number_form"))
                    <form action="{{route('send-otp-mobile')}}" method="POST" class="form-horizontal" role="form">
                        <div class="form-group {{ $errors->has('mobile_no')?'has-error':''}}">
                            <label for="input" class="col-sm-3 control-label">Mobile No:</label>
                            <div class="col-sm-4">
                                <input type="text" name="mobile_no" id="mobile_no" class="form-control" value="{{old('mobile_no')}}" required="required">
                                @if($errors->has('mobile_no'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('mobile_no') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-6 col-sm-offset-3">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                        {{csrf_field()}}
                    </form>
                    @endif
                    @if(session("phone-number-otp-form"))
                    <form action="{{route('verify-empmobile-otp')}}" method="POST" class="form-horizontal" role="form">
                       <div class="form-group">
                           <label for="input" class="col-sm-3 control-label">Mobile OTP:</label>
                           <div class="col-sm-4">
                               <input type="text" name="firsttimepasswordOTP" id="firsttimepasswordOTP" class="form-control" value="" required="required" placeholder="mobile OTP">
                           </div>
                       </div>
                        <div class="form-group">
                            <div class="col-sm-6 col-sm-offset-3">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                        {{ csrf_field() }}
                    </form>
                    <div class="row">
                        <div class="col-sm-12">
                            <form action="{{route('send-again-mobile-otp')}}" method="POST" class="form-horizontal" role="form">
                                <div class="form-group">
                                    <div class="col-sm-12 pull-right">
                                        <button type="submit" class="btn btn-link">Send Sms Again</button>
                                    </div>
                                </div>
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </div>
                    @endif
                    @if(session("password-form"))
                    <form class="form-horizontal" method="POST" action="{{ route('ftpassword-change') }}">

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-3 control-label">Password:</label>
                            <div class="col-md-4">
                                <input id="password" type="password" class="form-control" name="password" value="{{ old('password') }}" required autofocus>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="input" class="col-sm-3 control-label">Confirm Password:</label>
                            <div class="col-sm-4">
                                <input type="password" name="password_confirmation" id="password-confirmation" class="form-control" value="" required="required">
                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        {{ csrf_field() }}
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <input type="submit" class="btn btn-primary" value="Submit">
                            </div>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection