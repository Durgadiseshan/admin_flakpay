@php
    use App\Employee;
    use App\State;
    $employee_list = Employee::get_employee_list();
    $state_list = State::state_list();
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
                            <li class="active"><a data-toggle="tab" class="show-cursor" data-target="#{{str_replace(' ','-',strtolower($value->link_name))}}">{{$value->link_name}}</a></li> 
                        @else
                        <li><a data-toggle="tab" class="show-pointer" data-target="#{{str_replace(' ','-',strtolower($value->link_name))}}">{{$value->link_name}}</a></li>
                        @endif
                    @endforeach
                    @else
                        <li class="active"><a data-toggle="tab" class="show-cursor" data-target="#{{str_replace(' ','-',strtolower($sublink_name))}}">{{$sublink_name}}</a></li>
                        <li><a data-toggle="tab" class="show-pointer" data-target="#personal-info">Personal Details Form</a></li>
                        <li><a data-toggle="tab" class="show-pointer" data-target="#contact-info">Contact Details Form</a></li>
                        <li><a data-toggle="tab" class="show-pointer" data-target="#reference-info">Reference Details Form</a></li>
                        <li><a data-toggle="tab" class="show-pointer" data-target="#academic-info">Academic Details Form</a></li>
                        <li><a data-toggle="tab" class="show-pointer" data-target="#emphistory-info">Employee History Form</a></li>
                    @endif
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    @if(count($sublinks) > 0)
                        @foreach($sublinks as $index => $value)
                            @if($index == 0)
                            <div id="{{str_replace(' ','-',strtolower($value->link_name))}}" class="tab-pane fade">
                                
                            </div>
                            @else
                            <div id="{{str_replace(' ','-',strtolower($value->link_name))}}" class="tab-pane fade">
                            
                            </div>
                            @endif
                        @endforeach
                    @else
                        <div id="{{str_replace(' ','-',strtolower($sublink_name))}}" class="tab-pane fade in active">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Sno</th>
                                                    <th>Employee Name</th>
                                                    <th>Details Verification</th>
                                                    <th>Conatact Details Verification</th>
                                                    <th>Reference Verification</th>
                                                    <th>Academic Verification</th>
                                                    <th>History Verification</th>
                                                    <th>Created Date</th>
                                                    <th>Last Updated</th>
                                                    <th>Created User</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                               @if(count($bgv_emp_list)>0)
                                                    @foreach($bgv_emp_list as $index => $bgv_list)
                                                    <tr>
                                                        <td>{{++$index}}</td>
                                                        <td>{{$bgv_list->emp_name}}</td>
                                                        <td>{{$bgv_list->emp_details}}</td>
                                                        <td>{{$bgv_list->emp_contact_detail}}</td>
                                                        <td>{{$bgv_list->emp_reference}}</td>
                                                        <td>{{$bgv_list->emp_academic}}</td>
                                                        <td>{{$bgv_list->emp_history}}</td>
                                                        <td>{{$bgv_list->created_date}}</td>
                                                        <td>{{$bgv_list->last_updated}}</td>
                                                        <td>{{$bgv_list->created_user}}</td>
                                                    </tr>
                                                    @endforeach
                                                @else
                                                <tr>
                                                    <td colspan="9">No Data Found</td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>     
                        </div>
                        <div id="personal-info" class="tab-pane fade">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div id="details-ajax-response-message" class="text-center"></div>
                                    <form method="POST" class="form-horizontal" id="personal-info-form">
                                        
                                        <div class="form-group">
                                            <label for="input" class="col-sm-2 control-label">Select Employee:</label>
                                            <div class="col-sm-2">
                                                <select name="employee_id" id="employee_id" class="form-control" required="required">
                                                    <option value="">--Select--</option>
                                                    @foreach($employee_list as $employee)
                                                        <option value="{{$employee->id}}">{{$employee->full_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <fieldset class="scheduler-border">
                                            <legend class="scheduler-border">Personal Details:</legend>
                                            <div class="form-group">
                                                <label for="empname" class="control-label col-sm-2">First Name:<span class="mandatory">*</span></label>
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control" name="first_name" id="first_name" value="">
                                                    <span id="first_name_ajax_error"></span>
                                                </div>
                                            
                                                
                                                <label for="empname" class="control-label col-sm-2">Middle Name:</label>
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control" name="middle_name" id="middle_name" value="">
                                                    <span id="middle_name_ajax_error"></span>
                                                </div>
        
                                                <label for="empname" class="control-label col-sm-2">Last Name:<span class="mandatory">*</span></label>
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control" name="last_name" id="last_name" value="">
                                                    <span id="last_name_ajax_error"></span>
                                                </div>
                                                
                                            </div>
                                            <div class="form-group">
                                                <label for="empname" class="control-label col-sm-2">Father/Husband’s Name:<span class="mandatory">*</span></label>
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control" name="rel_first_name" id="rel_first_name" value="">
                                                    <span id="rel_first_name_ajax_error"></span>
                                                </div>
                                            
                                                
                                                <label for="empname" class="control-label col-sm-2">Middle Name:</label>
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control" name="rel_middle_name" id="rel_middle_name" value="">
                                                    <span id="rel_middle_name_ajax_error"></span>
                                                </div>
        
                                                <label for="empname" class="control-label col-sm-2">Last Name:<span class="mandatory">*</span></label>
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control" name="rel_last_name" id="rel_last_name" value="">
                                                    <span id="rel_last_name_ajax_error"></span>
                                                </div>
                                                
                                            </div>
                                            <div class="form-group">

                                                <label for="empname" class="control-label col-sm-2">Dob:<span class="mandatory">*</span></label>
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control" name="dob" id="date_of_birth" value="" placeholder="MM/DD/YYYY">
                                                    <span id="dob_ajax_error"></span>
                                                </div> 
                                                <label for="empname" class="control-label col-sm-2">Gender:<span class="mandatory">*</span></label>
                                                <div class="col-sm-1">
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="gender" id="gender" value="Male" checked="checked">
                                                            Male
                                                        </label>
                                                    </div>
                                                    <span id="gender_ajax_error"></span>
                                                </div>
                                                <div class="col-sm-1">
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" name="gender" id="gender" value="Female">
                                                            Female
                                                        </label>
                                                    </div>
                                                    <span id="gender_ajax_error"></span>
                                                </div>
        
                                                <label for="empname" class="control-label col-sm-2">PAN No:<span class="mandatory">*</span></label>
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control" name="pan_no" id="pan_no" value="">
                                                    <span id="pan_no_ajax_error"></span>
                                                </div>
                                                
                                            </div>
                                            <div class="form-group">
                                                <label for="empname" class="control-label col-sm-2">Passport No:</label>
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control" name="passport_no" id="passport_no" value="">
                                                    <span id="passport_no_ajax_error"></span>
                                                </div> 
                                                <label for="empname" class="control-label col-sm-2">Valid Until:</label>
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control" name="passport_valid" id="passport_valid" value="">
                                                    <span id="passport_valid_ajax_error"></span>
                                                </div>
        
                                                <label for="empname" class="control-label col-sm-2">Passport Issue Location:</label>
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control" name="loc_of_pass_issue" id="loc_of_pass_issue" value="">
                                                    <span id="pan_no_ajax_error"></span>
                                                </div>
                                            </div>
                                            {{csrf_field()}}
                                            <div class="form-group">
                                                <div class="col-sm-10 col-sm-offset-2">
                                                    <input type="submit" class="btn btn-primary" value="Submit">
                                                </div>
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div id="contact-info" class="tab-pane fade">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div id="contact-ajax-response-message" class="text-center"></div>
                                    <form method="POST" class="form-horizontal" id="contact-info-form"> 
                                        <div class="form-group">
                                            <label for="input" class="col-sm-2 control-label">Select Employee:</label>
                                            <div class="col-sm-2">
                                                <select name="employee_id" id="employee_id" class="form-control" required="required">
                                                    <option value="">--Select--</option>
                                                    @foreach($employee_list as $employee)
                                                        <option value="{{$employee->id}}">{{$employee->full_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <fieldset class="scheduler-border">
                                            <legend class="scheduler-border">Contact Details</legend>
                                            <fieldset class="scheduler-border">
                                                <legend class="scheduler-border">Current Contact Details:</legend>
                                                <div class="form-group">
                                                    <label for="empname" class="control-label col-sm-2">House/Building Name,No:<span class="mandatory">*</span></label>
                                                    <div class="col-sm-2">
                                                        <textarea name="house_no[]" id="house_no" class="form-control" cols="40" rows="2"></textarea>
                                                    </div>
                                                    <label for="empname" class="control-label col-sm-2">Street Name:<span class="mandatory">*</span></label>
                                                    <div class="col-sm-2">
                                                        <input type="text" class="form-control" name="street_name[]" id="street_name" value="">
                                                        <span id="street_name_ajax_error"></span>
                                                    </div>
                                        
                                                    <label for="empname" class="control-label col-sm-2">Area:<span class="mandatory">*</span></label>
                                                    <div class="col-sm-2">
                                                        <input type="text" class="form-control" name="area[]" id="area" value="">
                                                        <span id="area_ajax_error"></span>
                                                    </div>
                                                    
                                                </div>
                                                <div class="form-group">
                                                    <label for="empname" class="control-label col-sm-2">City:<span class="mandatory">*</span></label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="city[]" id="city" class="form-control" value="">
                                                        <span id="city_ajax_error"></span>
                                                    </div>
                                                    <label for="empname" class="control-label col-sm-2">District:<span class="mandatory">*</span></label>
                                                    <div class="col-sm-2">
                                                        <input type="text" class="form-control" name="district[]" id="district" value="">
                                                        <span id="district_ajax_error"></span>
                                                    </div>
                                        
                                                    <div class="form-group">
                                                        <label for="input" class="col-sm-2 control-label">State:<span class="mandatory">*</span></label>
                                                        <div class="col-sm-2">
                                                            <select name="state[]" id="state" class="form-control" required="required">
                                                                <option value="">--Select--</option>
                                                                @foreach($state_list as $state)
                                                                    <option value="{{$state->id}}">{{$state->state_name}}</option>
                                                                @endforeach
                                                            </select>
                                                            <span id="state_ajax_error"></span>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                <div class="form-group">
                                                    <label for="empname" class="control-label col-sm-2">Pincode:<span class="mandatory">*</span></label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="pincode[]" id="pincode" class="form-control" value="">
                                                        <span id="pincode_ajax_error"></span>
                                                    </div>
                                                    <label for="empname" class="control-label col-sm-2">Nationality:<span class="mandatory">*</span></label>
                                                    <div class="col-sm-2">
                                                        <input type="text" class="form-control" name="nationality[]" id="nationality" value="">
                                                        <span id="nationality_ajax_error"></span>
                                                    </div>
                                        
                                                    <label for="empname" class="control-label col-sm-2">Phone No:<span class="mandatory">*</span></label>
                                                    <div class="col-sm-2">
                                                        <input type="text" class="form-control" name="phone_no[]" id="phone_no" value="">
                                                        <span id="phone_no_ajax_error"></span>
                                                    </div>
                                                    
                                                </div>  
                                                <div class="form-group">
                                                    <label for="empname" class="control-label col-sm-2">Primary Email:<span class="mandatory">*</span></label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="primary_email[]" id="primary_email" class="form-control" value="">
                                                        <span id="primary_email_ajax_error"></span>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="is_address[]" value="current">
                                            </fieldset>
                                            <fieldset class="scheduler-border">
                                                <legend class="scheduler-border">Permanent Contact Details:</legend>
                                                <div class="form-group">
                                                    <label for="empname" class="control-label col-sm-2">House/Building Name,No:<span class="mandatory">*</span></label>
                                                    <div class="col-sm-2">
                                                        <textarea name="house_no[]" id="house_no" class="form-control" cols="30" rows="2"></textarea>
                                                        <span id="house_no_ajax_error"></span>
                                                    </div>
                                                    <label for="empname" class="control-label col-sm-2">Street Name:<span class="mandatory">*</span></label>
                                                    <div class="col-sm-2">
                                                        <input type="text" class="form-control" name="street_name[]" id="street_name" value="">
                                                        <span id="street_name_ajax_error"></span>
                                                    </div>
                                        
                                                    <label for="empname" class="control-label col-sm-2">Area:<span class="mandatory">*</span></label>
                                                    <div class="col-sm-2">
                                                        <input type="text" class="form-control" name="area[]" id="area" value="">
                                                        <span id="area_ajax_error"></span>
                                                    </div>
                                                    
                                                </div>
                                                <div class="form-group">
                                                    <label for="empname" class="control-label col-sm-2">City:<span class="mandatory">*</span></label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="city[]" id="city" class="form-control" value="">
                                                        <span id="city_ajax_error"></span>
                                                    </div>
                                                    <label for="empname" class="control-label col-sm-2">District:<span class="mandatory">*</span></label>
                                                    <div class="col-sm-2">
                                                        <input type="text" class="form-control" name="district[]" id="district" value="">
                                                        <span id="district_ajax_error"></span>
                                                    </div>
                                        
                                                    <div class="form-group">
                                                        <label for="input" class="col-sm-2 control-label">State:<span class="mandatory">*</span></label>
                                                        <div class="col-sm-2">
                                                            <select name="state[]" id="state" class="form-control" required="required">
                                                                <option value="">--Select--</option>
                                                                @foreach($state_list as $state)
                                                                    <option value="{{$state->id}}">{{$state->state_name}}</option>
                                                                @endforeach
                                                            </select>
                                                            <span id="state_ajax_error"></span>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                <div class="form-group">
                                                    <label for="empname" class="control-label col-sm-2">Pincode:<span class="mandatory">*</span></label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="pincode[]" id="pincode" class="form-control" value="">
                                                        <span id="pincode_ajax_error"></span>
                                                    </div>
                                                    <label for="empname" class="control-label col-sm-2">Nationality:<span class="mandatory">*</span></label>
                                                    <div class="col-sm-2">
                                                        <input type="text" class="form-control" name="nationality[]" id="nationality" value="">
                                                        <span id="nationality_ajax_error"></span>
                                                    </div>
                                        
                                                    <label for="empname" class="control-label col-sm-2">Phone No:<span class="mandatory">*</span></label>
                                                    <div class="col-sm-2">
                                                        <input type="text" class="form-control" name="phone_no[]" id="phone_no" value="">
                                                        <span id="phone_no_ajax_error"></span>
                                                    </div>
                                                    
                                                </div>  
                                                <div class="form-group">
                                                    <label for="empname" class="control-label col-sm-2">Landline No:</label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="land_line[]" id="land_line" class="form-control" value="">
                                                        <span id="land_line_ajax_error"></span>
                                                    </div>
                                                    <label for="empname" class="control-label col-sm-2">Primary Email:<span class="mandatory">*</span></label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="primary_email[]" id="primary_email" class="form-control" value="">
                                                        <span id="primary_email_ajax_error"></span>
                                                    </div>
                                                    <label for="empname" class="control-label col-sm-2">Secondary Email:</label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="secondary_email[]" id="secondary_email" class="form-control" value="">
                                                        <span id="secondary_email_ajax_error"></span>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="is_address[]" value="permanent">
                                            </fieldset>
                                            <div class="form-group">
                                                <div class="col-sm-10 col-sm-offset-2">
                                                    <input type="submit" class="btn btn-primary" value="Submit">
                                                </div>
                                            </div>
                                            {{csrf_field()}}
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div id="reference-info" class="tab-pane fade">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div id="reference-ajax-response-message" class="text-center"></div>
                                    <form method="POST" class="form-horizontal" id="reference-info-form"> 
                                        <div class="form-group">
                                            <label for="input" class="col-sm-2 control-label">Select Employee:</label>
                                            <div class="col-sm-2">
                                                <select name="employee_id" id="employee_id" class="form-control" required="required">
                                                    <option value="">--Select--</option>
                                                    @foreach($employee_list as $employee)
                                                        <option value="{{$employee->id}}">{{$employee->full_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <fieldset class="scheduler-border">
                                            <legend class="scheduler-border">References</legend>
                                            <fieldset class="scheduler-border">
                                                <legend class="scheduler-border">Reference-1:</legend>
                                                <div class="form-group">
                                                    <label for="empname" class="control-label col-sm-2">Name:
                                                        <span class="mandatory">*</span>
                                                    </label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="ref_name[]" id="ref_name" class="form-control" value="">
                                                        <span id="ref_name_ajax_error"></span>
                                                    </div>
                                                    <label for="empname" class="control-label col-sm-2">Designation:<span class="mandatory">*</span></label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="ref_designation[]" id="ref_designation" class="form-control" value="">
                                                        <span id="ref_designation_ajax_error"></span>
                                                    </div>
                                                    <label for="empname" class="control-label col-sm-2">Company:
                                                        <span class="mandatory">*</span>
                                                    </label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="ref_company[]" id="ref_company" class="form-control" value="">
                                                        <span id="ref_company_ajax_error"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="empname" class="control-label col-sm-2">How Will you know him/her:</label>
                                                    <div class="col-sm-2">
                                                        <textarea class="form-control" name="ref_capacity[]" id="ref_capacity" cols="20" rows="3"></textarea>
                                                        <span id="ref_capacity_ajax_error"></span>
                                                    </div>
                                                    <label for="empname" class="control-label col-sm-2">Mobile No:
                                                        <span class="mandatory">*</span>
                                                    </label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="ref_mobile_no[]" id="ref_mobile_no" class="form-control" value="">
                                                        <span id="ref_mobile_no_ajax_error"></span>
                                                    </div>
                                                    <label for="empname" class="control-label col-sm-2">Email Id:<span class="mandatory">*</span></label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="ref_email[]" id="ref_email" class="form-control" value="">
                                                        <span id="ref_email_ajax_error"></span>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <fieldset class="scheduler-border">
                                                <legend class="scheduler-border">Reference-2:</legend>
                                                <div class="form-group">
                                                    <label for="empname" class="control-label col-sm-2">Name:
                                                        <span class="mandatory">*</span>
                                                    </label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="ref_name[]" id="ref_name" class="form-control" value="">
                                                        <span id="ref_name_ajax_error"></span>
                                                    </div>
                                                    <label for="empname" class="control-label col-sm-2">Designation:<span class="mandatory">*</span></label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="ref_designation[]" id="ref_designation" class="form-control" value="">
                                                        <span id="ref_designation_ajax_error"></span>
                                                    </div>
                                                    <label for="empname" class="control-label col-sm-2">Company:
                                                        <span class="mandatory">*</span>
                                                    </label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="ref_company[]" id="ref_company" class="form-control" value="">
                                                        <span id="ref_company_ajax_error"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="empname" class="control-label col-sm-2">How Will you know him/her:</label>
                                                    <div class="col-sm-2">
                                                        <textarea class="form-control" name="ref_capacity[]" id="ref_capacity" cols="20" rows="3"></textarea>
                                                        <span id="ref_capacity_ajax_error"></span>
                                                    </div>
                                                    <label for="empname" class="control-label col-sm-2">Mobile No:
                                                        <span class="mandatory">*</span>
                                                    </label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="ref_mobile_no[]" id="ref_mobile_no" class="form-control" value="">
                                                        <span id="ref_mobile_no_ajax_error"></span>
                                                    </div>
                                                    <label for="empname" class="control-label col-sm-2">Email Id:<span class="mandatory">*</span></label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="ref_email[]" id="ref_email" class="form-control" value="">
                                                        <span id="ref_email_ajax_error"></span>
                                                    </div>
                                                </div>
                                            </fieldset> 
                                            <div class="form-group">
                                                <div class="col-sm-10 col-sm-offset-2">
                                                    <input type="submit" class="btn btn-primary" value="Submit">
                                                </div>
                                            </div>
                                            {{csrf_field()}}
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div id="academic-info" class="tab-pane fade">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div id="academic-ajax-response-message"></div>
                                    <form method="POST" class="form-horizontal" id="academic-info-form">
                                        <div class="form-group">
                                            <label for="input" class="col-sm-2 control-label">Select Employee:</label>
                                            <div class="col-sm-2">
                                                <select name="employee_id" id="employee_id" class="form-control" required="required">
                                                    <option value="">--Select--</option>
                                                    @foreach($employee_list as $employee)
                                                        <option value="{{$employee->id}}">{{$employee->full_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div> 
                                        <fieldset class="scheduler-border">
                                            <legend class="scheduler-border">Academics</legend>
                                            <fieldset class="scheduler-border">
                                                <legend class="scheduler-border">Academics-1:</legend>
                                                <div class="form-group">
                                                    <label for="empname" class="control-label col-sm-2">Institute Name:
                                                        <span class="mandatory">*</span>
                                                    </label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="inst_name[]" id="inst_name_0" class="form-control" value="">
                                                        <span id="inst_name_ajax_error_0"></span>
                                                    </div>
                                                    <label for="empname" class="control-label col-sm-2">Institute Location:
                                                        <span class="mandatory">*</span>
                                                    </label>
                                                    <div class="col-sm-2">
                                                        <textarea class="form-control" name="inst_loc[]" id="inst_loc_0" cols="30" rows="3"></textarea>
                                                        <span id="inst_loc_ajax_error_0"></span>
                                                    </div>
                                                    <label for="empname" class="control-label col-sm-2">Affiliated University:<span class="mandatory">*</span></label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="affil_university[]" id="affil_university_0" class="form-control" value="">
                                                        <span id="affil_university_ajax_error_0"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="empname" class="control-label col-sm-2">Contact Details:
                                                        <span class="mandatory">*</span>
                                                    </label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="mobile_no[]" id="_0" class="form-control" value="">
                                                        <span id="mobile_no_ajax_error_0"></span>
                                                    </div>
                                                    <label for="empname" class="control-label col-sm-2">Full/Part Time:
                                                        <span class="mandatory">*</span>
                                                    </label>

                                                    <div class="col-sm-1">
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" name="academic1[]" id="academic1" value="full-time" checked="checked">
                                                                FullTime
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" name="academic1[]" id="academic1" value="part-time">
                                                                PartTime
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <span id="academic_ajax_error_0"></span>

                                                    <label for="empname" class="control-label col-sm-2">Cource:<span class="mandatory">*</span></label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="course[]" id="course_0" class="form-control" value="">
                                                        <span id="course_ajax_error_0"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="empname" class="control-label col-sm-2">Course Completed:
                                                        <span class="mandatory">*</span>
                                                    </label>
                                                    <div class="col-sm-2">
                                                        <input type="date" name="course_completed[]" id="course_completed_0" class="form-control" value="">
                                                        <span id="course_completed_ajax_error_0"></span>
                                                    </div>
                                                    <label for="empname" class="control-label col-sm-2">Enroll/Reg No:
                                                    </label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="enroll_or_regno[]" id="enroll_or_regno_0" class="form-control" value="">
                                                        <span id="enroll_or_regno_ajax_error_0"></span>
                                                    </div>
                                                    <label for="empname" class="control-label col-sm-2">Marks Obtained In(%):<span class="mandatory">*</span></label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="marks_secured[]" id="marks_secured_0" class="form-control" value="">
                                                        <span id="marks_secured_ajax_error_0"></span>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <fieldset class="scheduler-border">
                                                <legend class="scheduler-border">Academics-2:</legend>
                                                <div class="form-group">
                                                    <label for="empname" class="control-label col-sm-2">Institute Name:
                                                        <span class="mandatory">*</span>
                                                    </label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="inst_name[]" id="inst_name_1" class="form-control" value="">
                                                        <span id="inst_name_ajax_error_1"></span>
                                                    </div>
                                                    <label for="empname" class="control-label col-sm-2">Institute Location:
                                                        <span class="mandatory">*</span>
                                                    </label>
                                                    <div class="col-sm-2">
                                                        <textarea class="form-control" name="inst_loc[]" id="inst_loc_1" cols="30" rows="3"></textarea>
                                                        <span id="inst_loc_ajax_error_1"></span>
                                                    </div>
                                                    <label for="empname" class="control-label col-sm-2">Affiliated University:<span class="mandatory">*</span></label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="affil_university[]" id="affil_university_1" class="form-control" value="">
                                                        <span id="affil_university_ajax_error_1"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="empname" class="control-label col-sm-2">Contact Details:
                                                        <span class="mandatory">*</span>
                                                    </label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="mobile_no[]" id="mobile_no_1" class="form-control" value="">
                                                        <span id="mobile_no_ajax_error_1"></span>
                                                    </div>
                                                    <label for="empname" class="control-label col-sm-2">Full/Part Time:
                                                        <span class="mandatory">*</span>
                                                    </label>
                                                    <div class="col-sm-1">
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" name="academic2[]" id="academic2" value="full-time" checked="checked">
                                                                FullTime
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" name="academic2[]" id="academic2" value="part-time">
                                                                PartTime
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <span id="academic_ajax_error_1"></span>

                                                    <label for="empname" class="control-label col-sm-2">Cource:<span class="mandatory">*</span></label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="course[]" id="course_1" class="form-control" value="">
                                                        <span id="course_ajax_error_1"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="empname" class="control-label col-sm-2">Course Completed:
                                                        <span class="mandatory">*</span>
                                                    </label>
                                                    <div class="col-sm-2">
                                                        <input type="date" name="course_completed[]" id="course_completed_!" class="form-control" value="">
                                                        <span id="course_completed_ajax_error_1"></span>
                                                    </div>
                                                    <label for="empname" class="control-label col-sm-2">Enroll/Reg No:
                                                    </label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="enroll_or_regno[]" id="enroll_or_regno_1" class="form-control" value="">
                                                        <span id="enroll_or_regno_ajax_error_1"></span>
                                                    </div>
                                                    <label for="empname" class="control-label col-sm-2">Marks Obtained In(%):<span class="mandatory">*</span></label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="marks_secured[]" id="marks_secured_1" class="form-control" value="">
                                                        <span id="marks_secured_ajax_error_1"></span>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <fieldset class="scheduler-border">
                                                <legend class="scheduler-border">Academics-3:</legend>
                                                <div class="form-group">
                                                    <label for="empname" class="control-label col-sm-2">Institute Name:
                                                        <span class="mandatory">*</span>
                                                    </label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="inst_name[]" id="inst_name_2" class="form-control" value="">
                                                        <span id="inst_name_ajax_error_2"></span>
                                                    </div>
                                                    <label for="empname" class="control-label col-sm-2">Institute Location:
                                                        <span class="mandatory">*</span>
                                                    </label>
                                                    <div class="col-sm-2">
                                                        <textarea class="form-control" name="inst_loc[]" id="inst_loc_2" cols="30" rows="3"></textarea>
                                                        <span id="inst_loc_ajax_error_2"></span>
                                                    </div>
                                                    <label for="empname" class="control-label col-sm-2">Affiliated University:<span class="mandatory">*</span></label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="affil_university[]" id="affil_university_2" class="form-control" value="">
                                                        <span id="affil_university_ajax_error_2"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="empname" class="control-label col-sm-2">Contact Details:
                                                        <span class="mandatory">*</span>
                                                    </label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="mobile_no[]" id="mobile_no_2" class="form-control" value="">
                                                        <span id="mobile_no_ajax_error_2"></span>
                                                    </div>
                                                    <label for="empname" class="control-label col-sm-2">Full/Part Time:
                                                        <span class="mandatory">*</span>
                                                    </label>

                                                    <div class="col-sm-1">
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" name="academic3[]" id="academic3" value="full-time" checked="checked">
                                                                FullTime
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" name="academic3[]" id="academic3" value="part-time">
                                                                PartTime
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <span id="academic_ajax_error_2"></span>

                                                    <label for="empname" class="control-label col-sm-2">Cource:<span class="mandatory">*</span></label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="course[]" id="course_2" class="form-control" value="">
                                                        <span id="course_ajax_error_2"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="empname" class="control-label col-sm-2">Course Completed:
                                                        <span class="mandatory">*</span>
                                                    </label>
                                                    <div class="col-sm-2">
                                                        <input type="date" name="course_completed[]" id="course_completed_2" class="form-control" value="">
                                                        <span id="course_completed_ajax_error_2"></span>
                                                    </div>
                                                    <label for="empname" class="control-label col-sm-2">Enroll/Reg No:
                                                    </label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="enroll_or_regno[]" id="enroll_or_regno_2" class="form-control" value="">
                                                        <span id="enroll_or_regno_ajax_error_2"></span>
                                                    </div>
                                                    <label for="empname" class="control-label col-sm-2">Marks Obtained In(%):<span class="mandatory">*</span></label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="marks_secured[]" id="marks_secured_2" class="form-control" value="">
                                                        <span id="marks_secured_ajax_error_2"></span>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <fieldset class="scheduler-border">
                                                <legend class="scheduler-border">Academics-4:</legend>
                                                <div class="form-group">
                                                    <label for="empname" class="control-label col-sm-2">Institute Name:
                                                        <span class="mandatory">*</span>
                                                    </label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="inst_name[]" id="inst_name_3" class="form-control" value="">
                                                        <span id="inst_name_ajax_error_3"></span>
                                                    </div>
                                                    <label for="empname" class="control-label col-sm-2">Institute Location:
                                                        <span class="mandatory">*</span>
                                                    </label>
                                                    <div class="col-sm-2">
                                                        <textarea class="form-control" name="inst_loc[]" id="inst_loc_3" cols="30" rows="3"></textarea>
                                                        <span id="inst_loc_ajax_error_3"></span>
                                                    </div>
                                                    <label for="empname" class="control-label col-sm-2">Affiliated University:<span class="mandatory">*</span></label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="affil_university[]" id="affil_university_3" class="form-control" value="">
                                                        <span id="affil_university_ajax_error_3"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="empname" class="control-label col-sm-2">Contact Details:
                                                        <span class="mandatory">*</span>
                                                    </label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="mobile_no[]" id="mobile_no_3" class="form-control" value="">
                                                        <span id="mobile_no_ajax_error_3"></span>
                                                    </div>
                                                    <label for="empname" class="control-label col-sm-2">Full/Part Time:
                                                        <span class="mandatory">*</span>
                                                    </label>

                                                    <div class="col-sm-1">
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" name="academic4[]" id="academic4" value="full-time" checked="checked">
                                                                FullTime
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" name="academic4[]" id="academic4" value="part-time">
                                                                PartTime
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <span id="academic_ajax_error_3"></span>

                                                    <label for="empname" class="control-label col-sm-2">Cource:<span class="mandatory">*</span></label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="course[]" id="course_3" class="form-control" value="">
                                                        <span id="course_ajax_error_3"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="empname" class="control-label col-sm-2">Course Completed:
                                                        <span class="mandatory">*</span>
                                                    </label>
                                                    <div class="col-sm-2">
                                                        <input type="date" name="course_completed[]" id="course_completed_3" class="form-control" value="">
                                                        <span id="course_completed_ajax_error_3"></span>
                                                    </div>
                                                    <label for="empname" class="control-label col-sm-2">Enroll/Reg No:
                                                    </label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="enroll_or_regno[]" id="enroll_or_regno_3" class="form-control" value="">
                                                        <span id="enroll_or_regno_ajax_error_3"></span>
                                                    </div>
                                                    <label for="empname" class="control-label col-sm-2">Marks Obtained In(%):<span class="mandatory">*</span></label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="marks_secured[]" id="marks_secured_3" class="form-control" value="">
                                                        <span id="marks_secured_ajax_error_3"></span>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            {{csrf_field()}}
                                            
                                            <div class="form-group">
                                                <div class="col-sm-10 col-sm-offset-2">
                                                    <input type="submit" class="btn btn-primary" value="Submit">
                                                </div>
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div id="emphistory-info" class="tab-pane fade">
                            <div class="row">
                                <div class="col-sm-12">
                                    <form method="POST" class="form-horizontal" id="emphistory-info-form">
                                        <div class="form-group">
                                            <label for="input" class="col-sm-2 control-label">Select Employee:</label>
                                            <div class="col-sm-2">
                                                <select name="employee_id" id="employee_id" class="form-control" required="required">
                                                    <option value="">--Select--</option>
                                                    @foreach($employee_list as $employee)
                                                        <option value="{{$employee->id}}">{{$employee->full_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div> 
                                        <fieldset class="scheduler-border">
                                            <legend class="scheduler-border">Employee history</legend>
                                            <fieldset class="scheduler-border">
                                                <legend class="scheduler-border">Employer-1:</legend>
                                                <div class="form-group">
                                                    <label for="empname" class="control-label col-sm-2">Company Name:
                                                        <span class="mandatory">*</span>
                                                    </label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="company_name[]" id="company_name" class="form-control" value="">
                                                        <span id="company_name_ajax_error"></span>
                                                    </div>
                                                    <label for="empname" class="control-label col-sm-2">Company Location:
                                                        <span class="mandatory">*</span>
                                                    </label>
                                                    <div class="col-sm-2">
                                                        <textarea class="form-control" name="company_loc[]" id="company_loc" cols="30" rows="3"></textarea>
                                                        <span id="company_loc_ajax_error"></span>
                                                    </div>
                                                    <label for="empname" class="control-label col-sm-2">Company Contact:<span class="mandatory">*</span></label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="company_phone[]" id="company_phone" class="form-control" value="">
                                                        <span id="company_phone_ajax_error"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="empname" class="control-label col-sm-2">Company Code:
                                                        <span class="mandatory">*</span>
                                                    </label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="company_code[]" id="company_code" class="form-control" value="">
                                                        <span id="company_code_ajax_error"></span>
                                                    </div>
                                                    <label for="empname" class="control-label col-sm-2">Date Of Join:</label>
                                                    <div class="col-sm-2">
                                                        <input type="date" name="salary_ctc[]" id="salary_ctc" class="form-control" value="">
                                                        <span id="salary_ctc_ajax_error"></span>
                                                    </div>

                                                    <label for="empname" class="control-label col-sm-2">Designation:<span class="mandatory">*</span></label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="designation[]" id="designation" class="form-control" value="">
                                                        <span id="designation_ajax_error"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="empname" class="control-label col-sm-2">Last Salary Drawn:
                                                        <span class="mandatory">*</span>
                                                    </label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="date_of_join[]" id="date_of_join" class="form-control" value="">
                                                        <span id="date_of_join_ajax_error"></span>
                                                    </div>
                                                    <label for="empname" class="control-label col-sm-2">Reason for leaving:
                                                    </label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="reason_for_leaving[]" id="reason_for_leaving" class="form-control" value="">
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <fieldset class="scheduler-border">
                                                <legend class="scheduler-border">Employer-2:</legend>
                                                <div class="form-group">
                                                    <label for="empname" class="control-label col-sm-2">Company Name:
                                                        <span class="mandatory">*</span>
                                                    </label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="company_name[]" id="company_name" class="form-control" value="">
                                                        <span id="company_name_ajax_error"></span>
                                                    </div>
                                                    <label for="empname" class="control-label col-sm-2">Company Location:
                                                        <span class="mandatory">*</span>
                                                    </label>
                                                    <div class="col-sm-2">
                                                        <textarea class="form-control" name="company_loc[]" id="company_loc" cols="30" rows="3"></textarea>
                                                        <span id="company_loc_ajax_error"></span>
                                                    </div>
                                                    <label for="empname" class="control-label col-sm-2">Company Contact:<span class="mandatory">*</span></label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="company_phone[]" id="company_phone" class="form-control" value="">
                                                        <span id="company_phone_ajax_error"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="empname" class="control-label col-sm-2">Company Code:
                                                        
                                                    </label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="company_code[]" id="company_code" class="form-control" value="">
                                                        <span id="company_code_ajax_error"></span>
                                                    </div>
                                                    <label for="empname" class="control-label col-sm-2">Date Of Join:</label>
                                                    <div class="col-sm-2">
                                                        <input type="date" name="salary_ctc[]" id="salary_ctc" class="form-control" value="">
                                                        <span id="salary_ctc_ajax_error"></span>
                                                    </div>

                                                    <label for="empname" class="control-label col-sm-2">Designation:<span class="mandatory">*</span></label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="designation[]" id="designation" class="form-control" value="">
                                                        <span id="designation_ajax_error"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="empname" class="control-label col-sm-2">Last Salary Drawn:
                                                        <span class="mandatory">*</span>
                                                    </label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="date_of_join[]" id="date_of_join" class="form-control" value="">
                                                        <span id="date_of_join_ajax_error"></span>
                                                    </div>
                                                    <label for="empname" class="control-label col-sm-2">Reason for leaving:
                                                    </label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="reason_for_leaving[]" id="reason_for_leaving" class="form-control" value="">
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <fieldset class="scheduler-border">
                                                <legend class="scheduler-border">Employer-3:</legend>
                                                <div class="form-group">
                                                    <label for="empname" class="control-label col-sm-2">Employer Name:
                                                        <span class="mandatory">*</span>
                                                    </label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="company_name[]" id="company_name" class="form-control" value="">
                                                        <span id="company_name_ajax_error"></span>
                                                    </div>
                                                    <label for="empname" class="control-label col-sm-2">Company Location:
                                                        <span class="mandatory">*</span>
                                                    </label>
                                                    <div class="col-sm-2">
                                                        <textarea class="form-control" name="company_loc[]" id="company_loc" cols="30" rows="3"></textarea>
                                                        <span id="company_loc_ajax_error"></span>
                                                    </div>
                                                    <label for="empname" class="control-label col-sm-2">Company Contact:<span class="mandatory">*</span></label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="company_phone[]" id="company_phone" class="form-control" value="">
                                                        <span id="company_phone_ajax_error"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="empname" class="control-label col-sm-2">Company Code:
                                                        <span class="mandatory">*</span>
                                                    </label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="company_code[]" id="company_code" class="form-control" value="">
                                                        <span id="company_code_ajax_error"></span>
                                                    </div>
                                                    <label for="empname" class="control-label col-sm-2">Date Of Join:</label>
                                                    <div class="col-sm-2">
                                                        <input type="date" name="salary_ctc[]" id="salary_ctc" class="form-control" value="">
                                                        <span id="salary_ctc_ajax_error"></span>
                                                    </div>

                                                    <label for="empname" class="control-label col-sm-2">Designation:<span class="mandatory">*</span></label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="designation[]" id="designation" class="form-control" value="">
                                                        <span id="designation_ajax_error"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="empname" class="control-label col-sm-2">Last Salary Drawn:
                                                        <span class="mandatory">*</span>
                                                    </label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="date_of_join[]" id="date_of_join" class="form-control" value="">
                                                        <span id="date_of_join_ajax_error"></span>
                                                    </div>
                                                    <label for="empname" class="control-label col-sm-2">Reason for leaving:
                                                    </label>
                                                    <div class="col-sm-2">
                                                        <input type="text" name="reason_for_leaving[]" id="reason_for_leaving" class="form-control" value="">
                                                    </div>
                                                </div>
                                            </fieldset>
                                            
                                        </fieldset>
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
@endsection
