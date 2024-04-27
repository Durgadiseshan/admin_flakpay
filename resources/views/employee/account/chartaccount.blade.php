@extends('layouts.employeecontent')
@section('employeecontent')
<div class="row">
    <div class="col-sm-12 padding-20">
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs" id="account-chart-tabs">
                    @if(count($sublinks) > 0)
                        @foreach($sublinks as $index => $value)
                            @if($index == 0)
                                <li class="active"><a data-toggle="tab" class="how-pointer" data-target="#{{str_replace(' ','-',strtolower($value->link_name))}}">{{$value->link_name}}</a></li> 
                            @else
                            <li><a data-toggle="tab" class="show-pointer" data-target="#{{str_replace(' ','-',strtolower($value->link_name))}}">{{$value->link_name}}</a></li>
                            @endif
                        @endforeach
                    @endif
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    @if(count($sublinks) > 0)
                        @foreach($sublinks as $index => $value)
                            @if($index == 0)
                            <div id="{{str_replace(' ','-',strtolower($value->link_name))}}" class="tab-pane fade in active">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div id="paginate_accountcharts"> 
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div id="{{str_replace(' ','-',strtolower($value->link_name))}}" class="tab-pane fade">
                                    <div id="chart-of-account-add-edit">
                                    <div class="row">
                                        <div class="col-sm-12">
                                        <div id="ajax-response-message" class="text-center"></div>
                                        <form method="POST" id="account-chart-form" class="form-horizontal" role="form">
                                            <div class="form-group">
                                                <legend class="text-center">Add/Edit Chart Art Of Account</legend>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-2 control-label">Account Code:</label>
                                                <div class="col-sm-3">
                                                    <select name="id" id="account_code" class="form-control" required="required">
                                                        <option value="">--Select--</option>
                                                    </select>
                                                </div>
                                                <label for="input-id" class="col-sm-3 text-info">Note:To edit existing record<br>
                                                                                        please select one option edit and update the record</label>
                                            </div>
                                        </form>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <form  method="POST" class="form-horizontal" id="chart-account-form">
                                                <div class="form-group">
                                                    <label for="input" class="col-sm-2 control-label">Account Code: <span class="mandatory">*</span></label>
                                                    <div class="col-sm-3">
                                                        <input type="text" name="account_code" id="account_code" class="form-control" value="">
                                                        <span class="help-block" id="account_code_ajax_response"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="input" class="col-sm-2 control-label">Description: <span class="mandatory">*</span></label>
                                                    <div class="col-sm-3">
                                                        <input type="text" name="description" id="description" class="form-control" value="">
                                                        <span class="help-block" id="description_ajax_response"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="input" class="col-sm-2 control-label">Account Group: <span class="mandatory">*</span></label>
                                                    <div class="col-sm-3">
                                                        <input type="text" name="account_group" id="account_group" class="form-control" value="">
                                                        <span class="help-block" id="account_group_ajax_response"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="input" class="col-sm-2 control-label">Main Grouping: <span class="mandatory">*</span></label>
                                                    <div class="col-sm-3">
                                                        <input type="text" name="main_grouping" id="main_grouping" class="form-control" value="">
                                                        <span class="help-block" id="main_grouping_ajax_response"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="input" class="col-sm-2 control-label">Note No: <span class="mandatory">*</span></label>
                                                    <div class="col-sm-3">
                                                        <input type="text" name="note_no" id="note_no" class="form-control" value="">
                                                        <span class="help-block" id="note_no_ajax_response"></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="input" class="col-sm-2 control-label">Note Description: <span class="mandatory">*</span></label>
                                                    <div class="col-sm-3">
                                                        <input type="text" name="note_description" id="note_description" class="form-control" value="">
                                                        <span class="help-block" id="note_description_ajax_response"></span>
                                                    </div>
                                                </div>
                                                {{csrf_field()}}
                                                <input type="hidden" name="id" value="">
                                                <div class="form-group">
                                                    <div class="col-sm-3 col-sm-offset-2">
                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </div>    
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded",function(){
        getAllChartAccount();
    });
</script>
@endsection
