@php
    use App\Department;
    use App\UserType;
@endphp

@extends('layouts.employeecontent')
@section('employeecontent')
<div class="row">
    <div class="col-sm-12 padding-20">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="tab-content">
                    <div class="page-header text-center">
                        <h1>Employee Details</h1>
                        <div id="ajax-response-message" class="text-center"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <a href="{{url()->previous()}}" class="btn btn-primary pull-right">Go Back</a>
                        </div>
                    </div>
                   <form class="form-horizontal" id="employee-details-form">
                       <div class="form-group">
                           <label for="empname" class="control-label col-sm-2">Username:</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="employee_username" id="employee_username" value="{{$details->employee_username}}">
                            </div>
                            <label for="empname" class="control-label col-sm-2">Mobile No:</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="mobile_no" id="mobile_no" value="{{$details->mobile_no}}">
                            </div>
                       </div>
                       <div class="form-group">
                           <label for="empname" class="control-label col-sm-2">Department:</label>
                            <div class="col-sm-3">
                                <select name="department" id="department" class="form-control">
                                    <option value="">--Select--</option>
                                    @foreach(Department::get_dept_options() as $option)
                                        @if($option->id == $details->department)
                                            <option value="{{$option->id}}" selected>{{$option->department_name}}</option>
                                        @else
                                            <option value="{{$option->id}}">{{$option->department_name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <label for="empname" class="control-label col-sm-2">User Type:</label>
                            <div class="col-sm-3">
                            <select name="user_type" id="user_type" class="form-control">
                                    <option value="">--Select--</option>
                                    @foreach(UserType::get_user_options() as $option)
                                        @if($option->id == $details->user_type)
                                            <option value="{{$option->id}}" selected>{{$option->designation}}</option>
                                        @else
                                            <option value="{{$option->id}}">{{$option->designation}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                       </div>                      
                       <div class="form-group">
                           <label for="empname" class="control-label col-sm-2">First Name:</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="first_name" id="first_name" value="{{$details->first_name}}">
                            </div>
                            <label for="empname" class="control-label col-sm-2">Last Name:</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="last_name" id="last_name" value="{{$details->last_name}}">
                            </div>
                       </div>
                       <div class="form-group">
                            <label for="empname" class="control-label col-sm-2">Professional Email:</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="official_email" id="official_email" value="{{$details->official_email}}">
                            </div>
                            <label for="empname" class="control-label col-sm-2">Personal Email:</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="personal_email" id="personal_email" value="{{$details->personal_email}}">
                            </div>
                       </div>
                       {{csrf_field()}}
                       <input type="hidden" name="id" value="{{$details->id}}">
                       <div class="form-group">
                           <div class="col-sm-3 col-sm-offset-4">
                                <input type="submit" value="Update" class="btn btn-primary btn-block">
                           </div>
                       </div>
                   </form>
                </div>
            </div>
        </div>    
    </div>
</div>
@endsection