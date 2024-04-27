@extends('.layouts.merchantcontent')
@section('merchantcontent')
<div class="row">
    <div class="col-sm-12 padding-top-30">
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs" id="transaction-tabs">
                    <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#create-edit-user">New/Edit Employee</a></li> 
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div id="create-edit-user" class="tab-pane fade in active">
                        <div class="row">
                            <div class="col-sm-12">
                                <a href="{{route('merchant-employee')}}" class="btn btn-primary btn-sm pull-right">Go Back</a>
                            </div>
                        </div>
                        <div class="row">
                            @if($form == "create")
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div id="ajax-add-success-message" class="text-center text-success"></div>
                                        <div id="ajax-add-fail-message" class="text-center text-danger"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 padding-top-30">
                                        <form id="merchant-employee-form" method="POST" class="form-horizontal" autocomplete="off">
                                            <div class="form-group">
                                                <label for="input" class="col-sm-2 control-label">Employee Name:<span class="mandatory">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="employee_name" id="employee_name" class="form-control" value="">
                                                    <div id="employee_name_error"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-2 control-label">Employee Email:<span class="mandatory">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="employee_email" id="employee_email" class="form-control" value="">
                                                    <div id="employee_email_error"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-2 control-label">Employee Mobile:<span class="mandatory">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="employee_mobile" id="employee_mobile" class="form-control" value="">
                                                    <div id="employee_mobile_error"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-2 control-label">Employee Type:<span class="mandatory">*</span></label>
                                                <div class="col-sm-3">
                                                    <select name="employee_type" id="employee_type" class="form-control">
                                                        <option value="">--Select--</option>
                                                        @foreach($emp_type as $index => $object)
                                                        <option value="{{$object->id}}">{{$object->option_value}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div id="employee_type_error"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-2 control-label">Employee Password:<span class="mandatory">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="password" name="employee_password" id="employee_password" class="form-control" value="">
                                                    <div id="employee_password_error"></div>
                                                </div>
                                                <div class="col-sm-1 show-cursor" onclick="visiblePasssword('employee_password',this)">
                                                    <i class="fa fa-eye fa-lg"></i>
                                                </div>
                                            </div>   
                                            {{csrf_field()}}                                                                             
                                            <div class="form-group">
                                                <div class="col-sm-3 col-sm-offset-2">
                                                    <button type="submit" class="btn btn-primary">Add User</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                
                            </div>
                            @else
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div id="ajax-edit-success-message" class="text-center text-success"></div>
                                        <div id="ajax-edit-fail-message" class="text-center text-danger"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 padding-top-30">
                                        <form id="edit-merchant-employee-form" method="POST" class="form-horizontal" autocomplete="off">
                                            <div class="form-group">
                                                <label for="input" class="col-sm-2 control-label">Employee Name:<span class="mandatory">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="employee_name" id="employee_name" class="form-control" value="{{$employee_info->employee_name}}">
                                                    <div id="employee_name_error"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-2 control-label">Employee Email:<span class="mandatory">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="employee_email" id="employee_email" class="form-control" value="{{$employee_info->employee_email}}">
                                                    <div id="employee_email_error"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-2 control-label">Employee Mobile:<span class="mandatory">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="employee_mobile" id="employee_mobile" class="form-control" value="{{$employee_info->employee_mobile}}">
                                                    <div id="employee_mobile_error"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-2 control-label">Employee Type:<span class="mandatory">*</span></label>
                                                <div class="col-sm-3">
                                                    <select name="employee_type" id="employee_type" class="form-control">
                                                        <option value="">--Select--</option>
                                                        @foreach($emp_type as $index => $object)
                                                            @if($object->id == $employee_info->employee_type)
                                                            <option value="{{$object->id}}" selected="selected">{{$object->option_value}}</option>
                                                            @else
                                                            <option value="{{$object->id}}">{{$object->option_value}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    <div id="employee_type_error"></div>
                                                </div>
                                            </div>
                                            {{csrf_field()}}  
                                            <input type="hidden" name="id" id="" value="{{$employee_info->id}}">                                                                           
                                            <div class="form-group">
                                                <div class="col-sm-3 col-sm-offset-2">
                                                    <button type="submit" class="btn btn-primary">Update User</button>
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
    </div>
</div>
@endsection