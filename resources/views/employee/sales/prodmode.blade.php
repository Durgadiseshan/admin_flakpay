@php
    use App\Http\Controllers\EmployeeController;
    use App\RyaPayService;
    use App\BusinessCategory;
    use App\State;

    $servicelist = RyaPayService::get_services();
    $categorylist = BusinessCategory::get_category();
    $statelist = State::state_list(); 
    $sales_status = EmployeeController::sales_status();
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
                     
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    @if(count($sublinks) > 0)
                    @foreach($sublinks as $index => $value)
                        @if($index == 0)
                        <div id="{{str_replace(' ','-',strtolower($value->link_name))}}" class="tab-pane fade in active">
                            <div class="row padding-20">
                                <div class="col-sm-12">
                                    <button type="button" id="call-sales-sheet-modal" class="btn btn-primary pull-right">Add New</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div id="paginate_leadsaleslist">

                                    </div>
                                </div>
                            </div>
                        </div>
                        @elseif($index == 1)
                        <div id="{{str_replace(' ','-',strtolower($value->link_name))}}" class="tab-pane fade">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="text-center" id="sales-sheet-ajax-response"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div id="paginate_dailysaleslist">

                                    </div>
                                </div>
                            </div>
                        </div>
                        @elseif($index == 2)
                        <div id="{{str_replace(' ','-',strtolower($value->link_name))}}" class="tab-pane fade">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="text-center" id="sales-sheet-ajax-response"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div id="paginate_saleslist">

                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                    <!-- Add New Sale sheet Modal Starts here -->
                    <div id="sales-sheet-modal" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">New Sales Sheet</h4>
                            </div>
                            <form method="POST" class="form-horizontal" role="form" id="sales-sheet-form">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="input" class="col-sm-4 control-label">Client Name: <span class="mandatory">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="text" name="merchant_name" id="merchant_name" class="form-control" value="">
                                            <span id="merchant_name_ajax_error"></span>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="input" class="col-sm-4 control-label">Client Mobile: <span class="mandatory">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="text" name="merchant_mobile" id="merchant_mobile" class="form-control" value="">
                                            <span id="merchant_mobile_ajax_error"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="input" class="col-sm-4 control-label">Client Email: <span class="mandatory">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="text" name="merchant_email" id="merchant_email" class="form-control" value="">
                                            <span id="merchant_email_ajax_error"></span>
                                        </div>
                                    </div>

                                    
                                    <div class="form-group">
                                        <label for="input" class="col-sm-4 control-label">Service: <span class="mandatory">*</span></label>
                                        <div class="col-sm-6">
                                            <select name="service_id" id="service_id" class="form-control">
                                                <option value="">--Select--</option>
                                                @foreach($servicelist as $service)
                                                    <option value="{{$service->id}}">{{$service->service_name}}</option>
                                                @endforeach
                                            </select>
                                            <span id="service_id_ajax_error"></span>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="input" class="col-sm-4 control-label">Company Name: <span class="mandatory">*</span></label>
                                        <div class="col-sm-6">
                                            <input type="text" name="company_name" id="company_name" class="form-control" value="">
                                            <span id="company_name_ajax_error"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="input" class="col-sm-4 control-label">Business category: <span class="mandatory">*</span></label>
                                        <div class="col-sm-6">
                                            <select name="business_category" id="business_category" class="form-control">
                                                <option value="">--Select--</option>
                                                @foreach($categorylist as $category)
                                                <option value="{{$category->id}}">{{$category->category_name}}</option>
                                                @endforeach
                                            </select>
                                            <span id="business_category_ajax_error"></span>
                                        </div>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="textarea" class="col-sm-4 control-label">Address:</label>
                                        <div class="col-sm-6">
                                            <textarea name="company_address" id="company_address" class="form-control" rows="6"></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="input" class="col-sm-4 control-label">City:</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="city" id="city" class="form-control" value="">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="input" class="col-sm-4 control-label">State: <span class="mandatory">*</span></label>
                                        <div class="col-sm-6">
                                            <select name="state" id="state" class="form-control">
                                                <option value="">--Select--</option>
                                                @foreach($statelist as $state)
                                                <option value="{{$state->id}}">{{$state->state_name}}</option>
                                                @endforeach
                                            </select>
                                            <span id="state_ajax_error"></span>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="input" class="col-sm-4 control-label">Sale Status:<span class="mandatory">*</span></label>
                                        <div class="col-sm-6">
                                            <select name="sale_status" id="sale_status" class="form-control">
                                                <option value="">--Select--</option>
                                                @foreach($sales_status as $index => $status)
                                                    <option value="{{$index}}">{{$status}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="input" class="col-sm-4 control-label">Next Call:</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="next_call" id="next_call" class="form-control" value="" placeholder="DD-MM-YYYY">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="textarea" class="col-sm-4 control-label">Remark:</label>
                                        <div class="col-sm-6">
                                            <textarea name="remark" id="remark" class="form-control" rows="3"></textarea>
                                        </div>
                                    </div>
                                    
                                    {{csrf_field()}}
                                    <input type="hidden" name="id" id="id" value="">
                                    <div class="form-group">
                                        <div class="col-sm-6 col-sm-offset-4">
                                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            </div>

                        </div>
                    </div>
                    <!-- Add New Sale sheet Modal Ends here --> 
                    @else
                        <div id="{{str_replace(' ','-',strtolower($sublink_name))}}" class="tab-pane fade in active">
                            @if(isset($id))
                                @include('employee.'.$id)
                            @endif                            
                        </div>
                    @endif
                </div>
            </div>
        </div>    
    </div>
</div>
@endsection

<script>

document.addEventListener("DOMContentLoaded",function(){
    getLeadSalessheet();
    $("#next_call").datepicker({
      "dateFormat":"dd-mm-yy",
      changeMonth: true,
      changeYear: true
  });
});
</script>
