@php
    use \App\Http\Controllers\MerchantController;
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
    $per_page = MerchantController::page_limit();
@endphp
@extends(".layouts.merchantcontent")
@section("merchantcontent")
    <!--Module Banner-->
    <div id="buton-1">
        <button class="btn btn-dark" id="Show">Show</button>
    <button  class="btn btn-danger" id="Hide">Remove</button>
        </div>
    <section id="about-1" class="about-1">
        <div class="container-1">
      
          <div class="row">
           
            <div class="col-lg-6 d-flex flex-column justify-contents-center" data-aos="fade-left">
              <div class="content-1 pt-4 pt-lg-0">
                <h3>MyAccount</h3>
                <p class="font-italic">Your account details </p>
      
                <p>You are just one step away from activating your account to accept domestic and international payments from your customers. We just need a few more details</p>
              </div>
            </div>
            <div class="col-lg-6" data-aos="zoom-in">
              <img src="/assets/img/merchant-help.png" width="450" class="img-fluid" id="img-dash" alt="merchant-help.png">
            </div>
          </div>
      
        </div>
    </section>
      <!--Module Banner-->
<div class="row">
        <div class="col-sm-12 padding-top-30">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <ul class="nav nav-tabs" id="utilities-tabs">
                        <li class="{{ $activetab == '' && !session('tab-active')?'active':'' }}"><a data-toggle="tab" class="show-cursor" data-target="#my-personal-details">Personal Details</a></li>
                        <li class="{{ $activetab == '' && session('tab-active')?'active':'' }}"><a data-toggle="tab" class="show-cursor" data-target="#change-password">Change Password</a></li>
                        <li class="{{ $activetab == 'notifications'?'active':''}}"><a data-toggle="tab" class="show-cursor" data-target="#notifications">Notifications</a></li>
                        <li class="{{ $activetab == 'messages'?'active':''}}"><a data-toggle="tab" class="show-cursor" data-target="#messages">Messages</a></li>                     
                    </ul>                    
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div id="my-personal-details" class="tab-pane fade {{ $activetab == '' && !session('tab-active')?'in active':''}}">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="personal-details">
                                        <p>Note:</p>
                                        <ul>
                                            <li>You can change Name,Email and Mobile in this page.</li>
                                            <li>You can change Name with the new email address by clicking on Change Name.</li>
                                            <li>You can change Email with the new email address by clicking on Change Email.</li>
                                            <li>You can change Mobile no with the new mobile no by clicking on Change Mobile.</li>
                                            <li>You can not change Name,Email and Mobile at the same time.</li>
                                            <li>You can not open Change Name,Change Email and Change Mobile at same time</li>
                                            <li>To change any one of them you have to close the opened one to open another.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <form method="POST" autocomplete="off" class="form-horizontal" role="form" id="update-my-details">
                                        <div class="form-group">
                                            <legend class="padding-10">Personal Details</legend>
                                        </div>

                                        @foreach($basicinfo as $merchantinfo)
                                        <div class="form-group"> 
                                            <label class="control-label col-sm-2" for="name">Name:</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="old-name" name="old_name" value="{{$merchantinfo->name}}" autocomplete="off" readonly disabled> 
                                            </div>
                                            <div class="col-sm-3">
                                                <button type="button" class="btn btn-primary btn-sm" onclick="ChangeMyName();">Change Name</button>
                                            </div>
                                        </div>
                                        <div class="form-group" id="dynamic-name-div" style="display: none;">
                                            <label class="control-label col-sm-2" for="name">New Name:</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="name" name="name" value="" autocomplete="off" disabled>
                                                <span id="name-ajax-response"></span>
                                            </div>
                                            <div class="col-sm-3">
                                                <button type="submit" class="btn btn-primary btn-sm">Save name</button>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="email">Email:</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" value="{{$merchantinfo->email}}" autocomplete="off" readonly disabled>
                                            </div>
                                            <div class="col-sm-3">
                                                <button type="button" class="btn btn-primary btn-sm" onclick="ChangeMyEmail();">Change Email</button>
                                            </div>
                                        </div>
                                        <div class="form-group" id="dynamic-div" style="display: none;">
                                            <label class="control-label col-sm-2" for="email">New Email:</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="email" name="email" value="" autocomplete="off" disabled>
                                                <span id="email-ajax-response"></span>
                                            </div>
                                            <div class="col-sm-3">
                                                <button type="submit" class="btn btn-primary btn-sm">Send OTP</button>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="phone">Mobile:</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="old-mobile" value="{{$merchantinfo->mobile_no}}" autocomplete="off" readonly disabled>
                                                <span id="mobile_no_error"></span>
                                            </div>
                                            <div class="col-sm-3">
                                                <button type="button" class="btn btn-primary btn-sm" onclick="ChangeMyMobile();">Change Phone</button>
                                            </div>
                                        </div>
                                        <div class="form-group" id="change-phone-div" style="display: none;">
                                            <label class="control-label col-sm-2" for="email">New Mobile:</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="mobile_no" name="mobile_no" value="" autocomplete="off" disabled>
                                                <span id="mobile-ajax-response"></span>
                                            </div>
                                            <div class="col-sm-3">
                                                <button type="submit" class="btn btn-primary btn-sm" onclick="">Send Sms</button>
                                            </div>
                                        </div>
                                        @endforeach
                                        {{csrf_field()}}
                                    </form>
                                    
                                </div>
                            </div>
                        </div>
                        <div id="change-password" class="tab-pane fade {{$activetab == '' && session('tab-active')?'in active':''}}">
                            <div class="row {{!session('current-password-form')?'':'hide'}}">
                                <div class="col-sm-12">
                                    <form action="{{route('merchant-change-password')}}" autocomplete="off" method="POST" class="form-horizontal" id="my-current-password">
                                        <div class="form-group">
                                            <legend class="padding-10">Current Password</legend>
                                        </div>
                                        <div class="form-group">
                                            <label for="input" class="col-sm-2 control-label">Current Password:</label>
                                            <div class="col-sm-3">
                                                <input type="password" name="password" id="password" class="form-control" autocomplete="off">
                                                @if ($errors->has('password'))
                                                    <span class="help-block">
                                                        <div class="text-danger">{{$errors->first('password')}}</div>
                                                    </span>
                                                @endif
                                                @if (session('wrong-password'))
                                                    <span class="help-block">
                                                        <div class="text-danger">{{session('wrong-password')}}</div>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="col-sm-1 show-cursor" onclick="showMyPasssword('password',this)">
                                                <i class="fa fa-eye fa-lg"></i>
                                            </div>
                                        </div>
                                        {{csrf_field()}}
                                        <div class="form-group">
                                            <div class="col-sm-10 col-sm-offset-2">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row {{session('change-password-form')?'':'hide'}}">
                                <div class="col-sm-12">
                                    <form action="{{route('merchant-change-password')}}" method="POST" class="form-horizontal" id="merchant-password-change">
                                        <div class="form-group">
                                            <legend class="padding-10">Change Password</legend>
                                        </div>
                                        @if (session('message'))
                                            <span class="help-block col-sm-offset-2">
                                                <div class="text-success text-sm-center">{{session('message')}}</div>
                                            </span>
                                        @endif
                                        <div class="form-group">
                                            <label for="input" class="col-sm-2 control-label">Password:</label>
                                            <div class="col-sm-3">
                                                <input type="password" name="password" id="password" class="form-control" autocomplete="off">
                                                @if (!empty($password))
                                                    <span class="help-block password">
                                                        <strong class="text-danger">{{$password}}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="col-sm-1 show-cursor" onclick="visiblePasssword('password',this)">
                                                <i class="fa fa-eye fa-lg"></i>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="input" class="col-sm-2 control-label">Confirm Password:</label>
                                            <div class="col-sm-3">
                                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" autocomplete="off">
                                                @if (!empty($confirm_password))
                                                    <span class="help-block confirm-password">
                                                        <strong class="text-danger">{{ $confirm_password}}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="col-sm-1 show-cursor" onclick="visiblePasssword('password_confirmation',this)">
                                                <i class="fa fa-eye fa-lg"></i>
                                            </div>
                                        </div>
                                        {{csrf_field()}}
                                        <div class="form-group">
                                            <div class="col-sm-10 col-sm-offset-2">
                                                <button type="submit" class="btn btn-primary">Change Password</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div id="notifications" class="tab-pane fade {{ $activetab == 'notifications' ? 'active in':'' }}">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="col-sm-4">
                                        <select name="page_limit" class="form-control" onchange="getAllMerchantNotifications($(this).val())">
                                            @foreach($per_page as $index => $page)
                                            <option value="{{$index}}">{{$page}}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="search-box">
                                        <form action="">
                                            <input type="search" id="notification-table" placeholder="Search">
                                            <i class="fa fa-search"></i>
                                        </form>
                                    </div>
                                </div>
                            </div>                            
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="display-block" id="paginate_notification">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="messages" class="tab-pane fade {{ $activetab == 'messages'? 'active in':''}}">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="col-sm-4">
                                        <select name="page_limit" class="form-control" onchange="getAllMerchantMessages($(this).val())">
                                            @foreach($per_page as $index => $page)
                                            <option value="{{$index}}">{{$page}}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="search-box">
                                        <form action="">
                                            <input type="search" id="message-table" placeholder="Search">
                                            <i class="fa fa-search"></i>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="display-block" id="paginate_message">
                                        
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded",function(e){
        e.preventDefault();
        getAllMerchantNotifications();
        getAllMerchantMessages();
    });
</script>
@endsection
