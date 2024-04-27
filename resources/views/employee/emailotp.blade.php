@extends('layouts.employeeapp')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login Email Verification</div>
                <div class="panel-body">
                    @if(session('wrong_otp'))
                    <div class="text-center" id="hideMe">{{session('wrong_otp')}}</div>
                    @endif
                    <form class="form-horizontal" method="POST" action="{{ route('rupayapay-email-verify') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('email_otp') ? ' has-error' : '' }}">
                            <label for="email_otp" class="col-md-4 control-label">One Time Password</label>

                            <div class="col-md-6">
                                <input id="email_otp" type="text" class="form-control" name="email_otp" value="{{ old('email_otp') }}" required autofocus>

                                @if ($errors->has('email_otp'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email_otp') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <input type="submit" class="btn btn-primary" value="Submit">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection