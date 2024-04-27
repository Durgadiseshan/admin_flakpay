@php
    use App\Http\Controllers\EmployeeController;
    use App\RyaPayService;
    use App\BusinessCategory;
    use App\State;

    $servicelist = RyaPayService::get_services();
    $categorylist = BusinessCategory::get_category();
    $statelist = State::state_list(); 
    $sales_status = EmployeeController::sales_status();
    $from_email = [
        "info@rupayapay.com"=>"Info Rupayapay",
        "no-reply@rupayapay.com"=>"No Reply Rupayapay"
    ];
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
                                    <button type="button" id="call-sales-sheet-modal" class="btn btn-primary pull-right btn-sm">Add New</button>
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
                            <div class="row padding-20">
                                <div class="col-sm-12">
                                    <div class="text-center" id="sales-sheet-ajax-response"></div>
                                    <button type="button" id="call-daily-sheet-modal" class="btn btn-primary pull-right btn-sm">Add Daily</button>
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
                        @elseif($index == 3)
                        <div id="{{str_replace(' ','-',strtolower($value->link_name))}}" class="tab-pane fade">
                            <div class="row padding-20">
                                <div class="col-sm-12">
                                    <button type="button" id="call-campaigning-sheet-modal" class="btn btn-primary pull-right btn-sm">New Compaigning</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="text-center" id="campaigning-ajax-response"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div id="paginate_campaignlist">

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
                                        <label for="input" class="col-sm-4 control-label">Looking For: <span class="mandatory">*</span></label>
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

                                    <!-- <div class="form-group">
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
                                    </div> -->
                                    
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
                    <!-- Add New Daily sheet Modal Starts here -->
                    <div id="daily-sheet-modal" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">New Daily Sheet</h4>
                            </div>
                            <form method="POST" class="form-horizontal" role="form" id="daily-sheet-form">
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
                                        <label for="textarea" class="col-sm-4 control-label">Company Type:</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="company_type" id="company_type" class="form-control" value="">
                                            <span id="company_type_ajax_error"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="textarea" class="col-sm-4 control-label">Turnover/year:</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="company_turnover" id="company_turnover" class="form-control" value="">
                                            <span id="company_turnover_ajax_error"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="textarea" class="col-sm-4 control-label">Transactions/month:</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="company_transaction" id="company_transaction" class="form-control" value="">
                                            <span id="company_transaction_ajax_error"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="textarea" class="col-sm-4 control-label"> Most usable Payment Mode:</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="company_payment_method" id="company_payment_method" class="form-control" value="">
                                            <span id="company_payment_method_ajax_error"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="textarea" class="col-sm-4 control-label">Address:</label>
                                        <div class="col-sm-6">
                                            <textarea name="company_address" id="company_address" class="form-control" rows="6"></textarea>
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
                                    <input type="hidden" name="sale_status" id="sale_status" value="daily">
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
                    <!-- Add New Daily sheet Modal Ends here -->
                    <div class="modal" id="campaigning-sheet-modal">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title">Campaigning</h4>
                                </div>
                                <div class="text-success text-center" id="ajax-compaign-success-message"></div>
                                <div class="text-danger text-center" id="ajax-compaign-failed-message"></div>
                                <form id="campaigning-sheet-form" class="form-horizontal" role="form">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-sm-10 col-sm-offset-1">
                                                <h5 class="text-danger">Note: Use @name,@company_name,@business_category as a variables where ever name of merchant,company name,and businness category is required in message input</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group form-fit">
                                            <label for="input" class="col-sm-2 control-label">From:</label>
                                            <div class="col-sm-10">
                                                <select name="campaign_from" id="campaign_from" class="form-control" required="required">
                                                    <option value="">--Select--</option>
                                                    @foreach($from_email as $key => $value)
                                                        <option value="{{$key}}">{{$value}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group form-fit">
                                            <label for="input" class="col-sm-2 control-label">Subject:</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="campaign_subject" id="campaign_subject" class="form-control" value="" required="required">
                                            </div>
                                        </div>
                                        <div class="form-group form-fit">
                                            <label for="textarea" class="col-sm-2 control-label">Message:</label>
                                            <div class="col-sm-10">
                                                <textarea name="campaign_message" id="campaign_message" class="form-control" rows="6"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group form-fit">
                                            <label for="textarea" class="col-sm-2 control-label">File:</label>
                                            <div class="col-sm-10">
                                                <input type="file" name="campaign_file" id="file-0" class="inputfile form-control inputfile-0" data-multiple-caption="{count} files selected" multiple="">
                                                <label for="file-0" class="campaign-file-upload col-sm-8">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                                        <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path>
                                                    </svg>
                                                    <span id="campaign_pan_card_file">
                                                    <span id="campaign_pan_card_file_not_exist">Upload File</span>
                                                    </span>
                                                </label>
                                                <!-- <button type="reset" class="button124 col-sm-2" data-id="35">
                                                <i class="fa fa-times"></i>
                                                </button> -->
                                            </div>
                                        </div>
                                        {{@csrf_field()}}
                                        <div class="form-group form-fit">
                                            <div class="col-sm-4 col-sm-offset-2">
                                                <input type="submit" class="btn btn-primary btn-sm" value="Send Campaign"/>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
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
