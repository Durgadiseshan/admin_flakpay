@php
    use App\Department;
    use App\UserType;
@endphp

@extends('layouts.employeecontent')
@section('employeecontent')
<div class="row">
    <div class="col-sm-12 padding-20">
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs" id="transaction-tabs">
                    @if(count($sublinks) > 0)
                    @foreach($sublinks as $index => $value)
                        @if($index == 0)
                            <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#{{str_replace(' ','-',strtolower($value->link_name))}}">{{$value->link_name}}</a></li> 
                        @else
                        <li><a data-toggle="tab" class="show-pointer" data-target="#{{str_replace(' ','-',strtolower($value->link_name))}}">{{$value->link_name}}</a></li>
                        @endif
                    @endforeach
                    @else
                        <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#{{str_replace(' ','-',strtolower($sublink_name))}}">{{$sublink_name}}</a></li>
                    @endif
                    <li><a data-toggle="tab" class="show-pointer" data-target="#addemployee">Add Employee</a></li>
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    @if(count($sublinks) > 0)                        
                    @else
                    <div id="{{str_replace(' ','-',strtolower($sublink_name))}}" class="tab-pane fade in active">
                        <div class="row padding-top-md">
                            <div class="col-sm-12">
                                <div id="ajax-response-message">

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div id="display-employee-table">
                                </div>
                            </div>
                        </div>
                        <!-- Contra created/updated modal starts-->
                        <div id="employee-delete-confirm-modal" class="modal fade">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <strong>Would you like to delete <span id="employee-name"></span> ?</strong>
                                    </div>
                                    <div class="modal-footer">
                                        <form id="delete-employee">
                                            <input type="hidden" name="id" id="id" value="">
                                            {{csrf_field()}}
                                            <input type="submit" class="btn btn-danger btn-sm" value="Yes"/>
                                            <button type="button" class="btn btn-info btn-sm" onclick="$('#employee-delete-confirm-modal').modal('hide');">Cancel</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Contra created/updated modal ends-->
                    </div>
                    <div id="addemployee" class="tab-pane fade">
                        <div class="row">
                            <div class="col-sm-12">
                                <div id="ajax-response-message" class="text-center"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 padding-20">
                                <form class="form-horizontal" id="add-employee-details-form">
                                    <div class="form-group">
                                        <label for="empname" class="control-label col-sm-2">Username:<span class="mandatory">*</span></label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="employee_username" id="employee_username" value="">
                                            <span id="employee_username_ajax_error"></span>
                                        </div>
                                       
                                        
                                        <label for="empname" class="control-label col-sm-2">Mobile No:<span class="mandatory">*</span></label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="mobile_no" id="mobile_no" value="">
                                            <span id="mobile_no_ajax_error"></span>
                                        </div>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="empname" class="control-label col-sm-2">Department:<span class="mandatory">*</span></label>
                                        <div class="col-sm-3">
                                            <select name="department" id="department" class="form-control">
                                                <option value="">--Select--</option>
                                            @if(auth()->guard('employee')->user()->user_type == '1')
                                                @foreach(Department::get_dept_options() as $option)
                                                    <option value="{{$option->id}}">{{$option->department_name}}</option>
                                                @endforeach
                                            @else
                                                @foreach(Department::get_hrdept_options() as $option)
                                                    <option value="{{$option->id}}">{{$option->department_name}}</option>
                                                @endforeach
                                            @endif
                                            </select>
                                            <span id="department_ajax_error"></span>
                                        </div>
                                        <label for="empname" class="control-label col-sm-2">User Type:<span class="mandatory">*</span></label>
                                        <div class="col-sm-3">
                                        <select name="user_type" id="user_type" class="form-control">
                                            <option value="">--Select--</option>
                                            @if(auth()->guard('employee')->user()->user_type == '1')
                                                @foreach(UserType::get_user_options() as $option)
                                                    <option value="{{$option->id}}">{{$option->designation}}</option>                             
                                                @endforeach
                                            @else
                                                @foreach(UserType::get_hruser_options() as $option)
                                                    <option value="{{$option->id}}">{{$option->designation}}</option>
                                                @endforeach
                                            @endif
                                            </select>
                                            <span id="user_type_ajax_error"></span>
                                        </div>
                                    </div>                      
                                    <div class="form-group">
                                        <label for="empname" class="control-label col-sm-2">First Name:<span class="mandatory">*</span></label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="first_name" id="first_name" value="">
                                            <span id="first_name_ajax_error"></span>
                                        </div>
                                        <label for="empname" class="control-label col-sm-2">Last Name:<span class="mandatory">*</span></label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="last_name" id="last_name" value="">
                                            <span id="last_name_ajax_error"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="empname" class="control-label col-sm-2">Professional Email:<span class="mandatory">*</span></label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="official_email" id="official_email" value="">
                                            <span id="official_email_ajax_error"></span>
                                        </div>
                                        <label for="empname" class="control-label col-sm-2">Personal Email:<span class="mandatory">*</span></label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="personal_email" id="personal_email" value="">
                                            <span id="personal_email_ajax_error"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="empname" class="control-label col-sm-2">Designation:<span class="mandatory">*</span></label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="designation" id="designation" value="">
                                            <span id="designation_ajax_error"></span>
                                        </div>
                                        <label for="empname" class="control-label col-sm-2">Password:<span class="mandatory">*</span></label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" name="password" id="password" value="">
                                            <span id="password_ajax_error"></span>
                                        </div>
                                    </div>
                                    {{csrf_field()}}
                                    <div class="form-group">
                                        <div class="col-sm-3 col-sm-offset-4">
                                                <input type="submit" value="Add" class="btn btn-primary btn-block">
                                        </div>
                                    </div>
                                </form>    
                            </div>
                        </div>                  
                    </div>    
                    @endif
                </div>
            </div>
        </div>    
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    getAllEmplooyes();
}, false);
</script>
@endsection


