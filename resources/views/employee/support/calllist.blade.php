@php
use App\Http\Controllers\EmployeeController;
$supcategorylist = EmployeeController::support_category();
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
                    <li><a data-toggle="tab" class="show-pointer" data-target="#add-call-support">Add Call Support</a></li> 
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    @if(count($sublinks) > 0)
                    @foreach($sublinks as $index => $value)
                        @if($index == 0)
                        <div id="{{str_replace(' ','-',strtolower($value->link_name))}}" class="tab-pane fade in active">
                        
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
                                    <div id="paginate_merchantcallsupport">

                                    </div>
                                </div>
                            </div>                          
                        </div>
                        <div id="add-call-support" class="tab-pane fade">
                            <div class="row padding-10">
                                <div class="col-sm-12">
                                    <div class="col-sm-2 text-center" id="call-support-ajax-response"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <form method="POST" class="form-horizontal" id="call-support-from" role="form">
                                        <div class="form-group">
                                            <label for="input" class="col-sm-2 control-label">Select Category: <span class="mandatory">*</span> </label>
                                            <div class="col-sm-3">
                                                <select name="sup_category" id="sup_category" class="form-control">
                                                    <option value="">--Select--</option>
                                                    @foreach($supcategorylist as $index => $value)
                                                        <option value="{{$index}}">{{$value}}</option>
                                                    @endforeach
                                                </select>
                                                <span id="sup_category_ajax_error"></span>
                                            </div>
                                        </div>                                        
                                        <div class="form-group">
                                            <label for="input" class="col-sm-2 control-label">Title: <span class="mandatory">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" name="sup_title" id="sup_title" class="form-control" value="">
                                                <span id="sup_title_ajax_error"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="textarea" class="col-sm-2 control-label">Description: <span class="mandatory">*</span></label>
                                            <div class="col-sm-3">
                                                <textarea name="sup_description" id="sup_description" class="form-control" rows="3"></textarea>
                                                <span id="sup_description_ajax_error"></span>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="input" class="col-sm-2 control-label">Merchant Id:<span class="mandatory">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" name="merchant_id" id="merchant_id" class="form-control" value="">
                                                <span id="merchant_id_ajax_error"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="input" class="col-sm-2 control-label">Merchant Mobile:<span class="mandatory">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" name="merchant_mobile" id="merchant_mobile" class="form-control" value="">
                                                <span id="merchant_mobile_ajax_error"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="input" class="col-sm-2 control-label">Merchant Email:<span class="mandatory">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" name="marchant_email" id="marchant_email" class="form-control" value="">
                                                <span id="marchant_email_ajax_error"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="input" class="col-sm-2 control-label">Next Time Call:</label>
                                            <div class="col-sm-3">
                                                <input type="text" name="next_call" id="next_call" class="form-control" value="" placeholder="DD-MM-YYYY">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="textarea" class="col-sm-2 control-label">Merchant Remarks:</label>
                                            <div class="col-sm-3">
                                                <textarea name="merchant_remarks" id="merchant_remarks" class="form-control" rows="3"></textarea>
                                            </div>
                                        </div>
                                        {{csrf_field()}}
                                        <div class="form-group">
                                            <div class="col-sm-3 col-sm-offset-2">
                                                <button type="submit" class="btn btn-primary btn-block">Submit</button>
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
@endsection
<script>
    document.addEventListener("DOMContentLoaded",function(params) {
        getAllCallSupports();
        $("#next_call").datepicker({
            "dateFormat":"dd-mm-yy",
            changeMonth: true,
            changeYear: true
        });
    });
    
</script>
