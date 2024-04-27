@php
    use \App\Http\Controllers\MerchantController;
    $per_page = MerchantController::page_limit();
@endphp
@extends('.layouts.merchantcontent')
@section('merchantcontent')
<!-- ---------Banner---------- -->
<div id="buton-1">
    <button class="btn btn-primary" id="Show">Show</button>
<button  class="btn btn-primary" id="Hide">Remove</button>
    </div>
<section id="about-1" class="about-1">
    <div class="container-1">
  
      <div class="row">
      
        <div class="col-lg-6 d-flex flex-column justify-contents-center" data-aos="fade-left">
          <div class="content-1 pt-4 pt-lg-0">
            <h3>Welcome to Employees Dashboard</h3>
            <p class="font-italic">
            Get started with accepting payments right away</p>
  
            <p>You are just one step away from activating your account to accept domestic and international payments from your customers. We just need a few more details</p>
          </div>
        </div>
        <div class="col-lg-6" data-aos="zoom-in">
          <img src="/assets/img/merchant-utilities.png" width="350" class="img-fluid" id="img-dash" alt="merchant-utilities.png">
        </div>
      </div>
  
    </div>
</section>

<div class="row">
    <div class="col-sm-12 padding-top-30">
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs" id="transaction-tabs">
                    <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#users">Employees</a></li> 
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div id="users" class="tab-pane fade in active">
                        <div class="tab-button">
                            <a href="{{route('create-employee')}}" class="btn btn-primary btn-sm">Add Employee</a> 
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="col-sm-4">
                                    <select name="page_limit" class="form-control" onchange="getAllMerchantEmployees($(this).val())">
                                        @foreach($per_page as $index => $page)
                                            <option value="{{$index}}">{{$page}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="search-box">
                                    <form action="">
                                        <input type="search" id="coupon-table" placeholder="Search">
                                        <i class="fa fa-search"></i>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="display-block" id="paginate_employees">

                                </div>
                            </div>
                        </div>
                        <div class="modal" id="merchant-employee-password-modal">
                            <div class="modal-dialog">
                                <div class="modal-content modal-md">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title">Change Password</h4>
                                    </div>
                                    <div class="modal-body">
                                     <div id="ajax-reset-password-success" class="text-center text-success"></div>
                                     <form id="merchant-employee-password-form" method="POST" class="form-horizontal" role="form">
                                         <div class="form-group">
                                             <label for="input" class="col-sm-4 control-label">Password:</label>
                                             <div class="col-sm-5">
                                                 <input type="password" name="employee_password" id="employee_password" class="form-control" value="">
                                                 <div id="employee_password_error"></div>
                                             </div>
                                             <div class="col-sm-1 show-cursor" onclick="visiblePasssword('employee_password',this)">
                                                <i class="fa fa-eye fa-lg"></i>
                                            </div>
                                         </div>  
                                         <input type="hidden" name="id" id="id" class="form-control" value="">
                                         {{csrf_field()}}
                                        <div class="form-group">
                                            <div class="col-sm-2 col-sm-offset-4">
                                                <button type="submit" class="btn btn-primary btn-sm">Change Password</button>
                                            </div>
                                        </div>
                                     </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal" id="merchant-employee-unlock-modal">
                            <div class="modal-dialog">
                                <div class="modal-content modal-md">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="text-center text-success" id="merchant-employee-unlock-response">This account has unlocked successfully</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal" id="merchant-employee-status-modal">
                            <div class="modal-dialog">
                                <div class="modal-content modal-md">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title">Update Employee Status</h4>
                                    </div>
                                    <div class="modal-body">
                                     <div id="ajax-employee-status-success" class="text-center text-success"></div>
                                     <div id="ajax-employee-status-fail" class="text-center text-danger"></div>
                                     <form id="merchant-employee-status-form" method="POST" class="form-horizontal" role="form">
                                         <div class="form-group">
                                            <label for="web-app-url" class="control-label col-sm-4">Employee Status:</label>
                                            <div class="col-sm-4 radio">
                                                <label>
                                                    <input type="radio" name="employee_status" class="form-control" id="active" value="active">
                                                    <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                                                    activate:
                                                </label>
                                            </div>
                                            <div class="col-sm-4 radio">
                                                <label>
                                                    <input type="radio" name="employee_status" class="form-control" id="inactive" value="inactive">
                                                    <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                                                    de-activate:
                                                </label>
                                            </div>
                                         </div>  
                                         <input type="hidden" name="id" id="id1" class="form-control" value="">
                                         {{csrf_field()}}
                                        <div class="form-group">
                                            <div class="col-sm-4 col-sm-offset-6">
                                                <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                            </div>
                                        </div>
                                     </form>
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
<script>
    document.addEventListener("DOMContentLoaded",function(){
        getAllMerchantEmployees();
    });
</script>
@endsection
