@extends('layouts.employeecontent')
@section('employeecontent')
<div class="row">
    <div class="col-sm-12 padding-20">
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs" id="transaction-tabs">
                    <li class="{{session('page-active')?'':'active'}}"><a data-toggle="tab" class="show-pointer" data-target="#mydetails">My Details</a></li>
                    <li class="{{session('page-active')?'active':''}}"><a data-toggle="tab" class="show-pointer" data-target="#password-change">Change Password</a></li>
                    <li><a data-toggle="tab" class="show-pointer" data-target="#login-activities">Login Activities</a></li>
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div id="mydetails" class="tab-pane fade {{session('page-active')?'':'in active'}}">
                        <div class="row">
                            <div class="col-sm-12">
                                @if($errors->any())
                                    @foreach($errors->all() as $error)
                                    <div>
                                        <div class="alert alert-danger">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            <strong>Error!</strong>{{$error}}
                                        </div>
                                    </div>
                                    @endforeach
                                @endif
                                @if(session("message"))
                                    <div>
                                        <div class="alert alert-success">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            <strong>Success!</strong> {{session("message")}}
                                        </div>                                        
                                    </div>
                                @endif
                                <form method="POST" class="form-horizontal" action="{{route('my-details-update')}}">
                                    <div class="form-group col-sm-11 col-sm-offset-1">
                                        <legend>Personal Details</legend>
                                    </div>
                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Username:</label>
                                        <div class="col-sm-3">
                                            <input type="text" name="employee_username" id="employee_username" class="form-control" value="{{$detail->employee_username}}" readonly="readonly">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">First Name:<span class="mandatory">*</span></label>
                                        <div class="col-sm-3">
                                            <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name')?'':$detail->first_name}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Last Name:<span class="mandatory">*</span> </label>
                                        <div class="col-sm-3">
                                            <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name')?'':$detail->last_name}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Designation:</label>
                                        <div class="col-sm-3">
                                            <input type="text" name="designation" id="designation" class="form-control" value="{{$detail->designation}}" readonly="readonly">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Personal Email:<span class="mandatory">*</span></label>
                                        <div class="col-sm-3">
                                            <input type="text" name="personal_email" id="personal_email" class="form-control" value="{{ old('personal_email')?'':$detail->personal_email}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Official Email:</label>
                                        <div class="col-sm-3">
                                            <input type="text" name="official_email" id="official_email" class="form-control" value="{{$detail->official_email}}" readonly="readonly">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Mobile No:</label>
                                        <div class="col-sm-3">
                                            <input type="text" name="mobile_no" id="mobile_no" class="form-control" value="{{$detail->mobile_no}}" readonly="readonly">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Last Seen:</label>
                                        <div class="col-sm-3">
                                            <input type="text" name="last_seen_at" id="last_seen_at" class="form-control" value="{{$detail->last_seen_at}}" readonly="readonly">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Created Date:</label>
                                        <div class="col-sm-3">
                                            <input type="text" name="created_date" id="created_date" class="form-control" value="{{$detail->created_date}}" readonly="readonly">
                                        </div>
                                    </div>
                                    {{csrf_field()}}
                                    <div class="form-group">
                                        <div class="col-sm-3 col-sm-offset-2">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div id="password-change" class="tab-pane fade {{session('page-active')?'in active':''}}">
                        <div class="row">
                            <div class="col-sm-12">
                                @if(session('email-form') || session('mobile-form'))
                                    <div class="alert alert-success">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <strong>Success!</strong> {{session('message')}}
                                    </div>
                                @endif
                                @if(session('password-form-success'))
                                   <div class="alert alert-success">
                                       <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                       <strong>Success!</strong> {{session('message')}}
                                   </div>
                                @endif
                                @if(session('password-form-failed'))
                                   <div class="alert alert-danger">
                                       <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                       <strong>Error!</strong> {{session('message')}}
                                   </div>
                                @endif
                                <form action="{{route('my-password-change')}}" method="POST" class="form-horizontal" role="form">                                   
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="input-id" class="col-sm-2 col-sm-offset-1">Change Password</label>
                                            <div class="col-sm-8 col-sm-offset-1">
                                                <button type="submit" class="btn btn-primary btn-sm">Send Password Request</button>
                                            </div>
                                        </div>
                                    </div>
                                    {{csrf_field()}}
                                </form>
                                @if(session('email-form'))
                                <form action="{{route('verify-emailOTP')}}" method="POST" class="form-horizontal" role="form">                                   
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="input" class="col-sm-2 control-label">Email OTP:</label>
                                            <div class="col-sm-3">
                                                <input type="text" name="ryapayemailOTP" id="ryapayemailOTP" class="form-control" value="" required="required">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-3 col-sm-offset-2">
                                                <button type="submit" class="btn btn-primary">Next</button>
                                            </div>
                                        </div>
                                    </div>
                                    {{csrf_field()}}
                                </form>
                                @endif
                                @if(session('mobile-form'))
                                <form action="{{route('verify-mobileOTP')}}" method="POST" class="form-horizontal" role="form">                                   
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="input" class="col-sm-2 control-label">Mobile OTP:</label>
                                            <div class="col-sm-3">
                                                <input type="text" name="ryapaymobileOTP" id="ryapaymobileOTP" class="form-control" value="" required="required">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-3 col-sm-offset-2">
                                                <button type="submit" class="btn btn-primary">Next</button>
                                            </div>
                                        </div>
                                    </div>
                                    {{csrf_field()}}
                                </form>
                                @endif
                                @if(session('password-form'))
                                <form action="{{route('change-password')}}" method="POST" class="form-horizontal" role="form">                                   
                                    <div class="form-group">
                                        <div class="form-group {{ $errors->has('current_password') ? ' has-error' : '' }}">
                                            <label for="input" class="col-sm-2 control-label">Current Password:</label>
                                            <div class="col-sm-3">
                                                <input type="password" name="current_password" id="current_password" class="form-control" value="" required="required">
                                                @if ($errors->has('current_password'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('current_password') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                                            <label for="input" class="col-sm-2 control-label">Password:</label>
                                            <div class="col-sm-3">
                                                <input type="password" name="password" id="password" class="form-control" value="" required="required">
                                                @if ($errors->has('password'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                            <label for="input" class="col-sm-2 control-label">Confirm Password:</label>
                                            <div class="col-sm-3">
                                                <input type="password" name="password_confirmation" id="password-confirmation" class="form-control" value="" required="required">
                                                @if ($errors->has('password_confirmation'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-3 col-sm-offset-2">
                                                <button type="submit" class="btn btn-primary">Change</button>
                                            </div>
                                        </div>
                                    </div>
                                    {{csrf_field()}}
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div id="login-activities" class="tab-pane fade">
                        <div class="row">
                            <div class="col-sm-12">
                                <div id="paginate_loginactivities">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>
@endsection
