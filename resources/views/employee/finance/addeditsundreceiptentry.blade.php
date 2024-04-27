@php
    use App\AppOption;
    use App\RyapayBankInfo;
    use App\CharOfAccount;
    use App\RyaPayCustomer;

    $paymodes = AppOption::get_paymode();
    $bankids = RyapayBankInfo::get_bank_option();
    $revenue_codes = CharOfAccount::get_code_options();
    $customers = RyaPayCustomer::get_cust_opts();
@endphp
@extends('layouts.employeecontent')
@section('employeecontent')
<div class="row">
    <div class="col-sm-12 padding-20">
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#add-edit-sund-receipt-entry">New/Edit Sundry Receipt Entry</a></li> 
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div id="add-edit-sund-receipt-entry" class="tab-pane fade in active">
                        <div class="row">
                            <div class="col-sm-12">
                                <a href="{{route('finance-receivable','ryapay-yKzVIkqM')}}" class="btn btn-primary btn-sm pull-right">Back</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                @if($form == "create")
                                <form id="sund-receipt-entry-form" method="POST" role="form" class="form-horizontal">
                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Sundry Receipt No:</label>
                                        <div class="col-sm-3">
                                            <input type="text" name="sundry_rcpt_no" id="sundry_rcpt_no" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Receipt Date:</label>
                                        <div class="col-sm-3">
                                            <div class="input-group date">
                                                <input type="text" name="receipt_date" id="receipt_date" class="form-control" value="" placeholder="YYYY-MM-DD">
                                                <span class="input-group-addon"><span class="fa fa-calendar show-pointer" onclick="($('#receipt_date')).focus();"></span></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Customer Name:</label>
                                        <div class="col-sm-3">
                                            <select name="customer_id" id="customer_id" class="form-control">
                                                <option value="">--Select--</option>
                                                @foreach($customers as $customer)
                                                    <option value="{{$customer->id}}">{{$customer->customer_name}}</option>
                                                @endforeach
                                            </select>
                                            <div id="customer_id_error"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Revenue Code:</label>
                                        <div class="col-sm-3">
                                            <select name="revenue_code" id="revenue_code" class="form-control">
                                                <option value="">--Select--</option>                                                                            
                                                @if(count($revenue_codes) > 0)
                                                    @foreach($revenue_codes as $amount_code)
                                                        <option value="{{$amount_code->id}}">{{$amount_code->account_code}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <div id="revenue_code_error"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Bank Name:</label>
                                        <div class="col-sm-3">
                                            <select name="bank_id" id="bank_id" class="form-control">
                                                <option value="">--Select--</option>
                                                @foreach($bankids as $bankid)
                                                <option value="{{$bankid->id}}">{{$bankid->bank_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Receipt Mode:</label>
                                        <div class="col-sm-3">
                                            <select name="receipt_mode" id="receipt_mode" class="form-control">
                                                <option value="">--Select--</option>
                                                @foreach($paymodes as $paymode)
                                                <option value="{{$paymode->id}}">{{$paymode->option_value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Payment Amount:</label>
                                        <div class="col-sm-3">
                                            <input type="text" name="receipt_amount" id="receipt_amount" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Remarks:</label>
                                        <div class="col-sm-3">
                                            <textarea name="remarks" id="remarks" class="form-control" rows="3"></textarea>
                                        </div>
                                    </div>
                                    {{csrf_field()}}
                                    <div class="form-group">
                                        <div class="col-sm-3 col-sm-offset-2">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </form>
                                @else
                                <form id="update-sund-receipt-form" method="POST" role="form" class="form-horizontal">
                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Sundry Payment No:</label>
                                        <div class="col-sm-3">
                                            <input type="text" name="sundry_rcpt_no" id="sundry_rcpt_no" class="form-control" value="{{$edit_data->sundry_rcpt_no}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Pay Date:</label>
                                        <div class="col-sm-3">
                                            <div class="input-group date">
                                                <input type="text" name="receipt_date" id="receipt_date" class="form-control" value="{{$edit_data->receipt_date}}" placeholder="YYYY-MM-DD">
                                                <span class="input-group-addon"><span class="fa fa-calendar show-pointer" onclick="($('#receipt_date')).focus();"></span></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Customer Name:</label>
                                        <div class="col-sm-3">
                                            <select name="customer_id" id="customer_id" class="form-control">
                                                <option value="">--Select--</option>
                                                @foreach($customers as $customer)
                                                    @if($edit_data->customer_id == $customer->id)
                                                        <option value="{{$customer->id}}" selected>{{$customer->customer_name}}</option>
                                                    @else
                                                        <option value="{{$customer->id}}">{{$customer->customer_name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <div id="customer_id_error"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Revenue Code:</label>
                                        <div class="col-sm-3">
                                            <select name="revenue_code" id="revenue_code" class="form-control">
                                                <option value="">--Select--</option>                                                                            
                                                @if(count($revenue_codes) > 0)
                                                    @foreach($revenue_codes as $amount_code)
                                                        @if($edit_data->revenue_code == $amount_code->id)
                                                        <option value="{{$amount_code->id}}" selected>{{$amount_code->account_code}}</option>
                                                        @else
                                                        <option value="{{$amount_code->id}}">{{$amount_code->account_code}}</option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </select>
                                            <div id="revenue_code_error"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Bank Name:</label>
                                        <div class="col-sm-3">
                                            <select name="bank_id" id="bank_id" class="form-control">
                                                <option value="">--Select--</option>
                                                @foreach($bankids as $bankid)
                                                    @if($edit_data->bank_id == $bankid->id)
                                                    <option value="{{$bankid->id}}" selected>{{$bankid->bank_name}}</option>
                                                    @else
                                                    <option value="{{$bankid->id}}">{{$bankid->bank_name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Payment Mode:</label>
                                        <div class="col-sm-3">
                                            <select name="receipt_mode" id="receipt_mode" class="form-control">
                                                <option value="">--Select--</option>
                                                @foreach($paymodes as $paymode)
                                                    @if($edit_data->receipt_mode == $paymode->id)
                                                        <option value="{{$paymode->id}}" selected>{{$paymode->option_value}}</option>
                                                    @else
                                                        <option value="{{$paymode->id}}">{{$paymode->option_value}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Payment Amount:</label>
                                        <div class="col-sm-3">
                                            <input type="text" name="receipt_amount" id="receipt_amount" class="form-control" value="{{$edit_data->receipt_amount}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Remarks:</label>
                                        <div class="col-sm-3">
                                            <textarea name="remarks" id="remarks" class="form-control" rows="3">{{$edit_data->remarks}}</textarea>
                                        </div>
                                    </div>
                                    {{csrf_field()}}
                                    
                                    <input type="hidden" name="id" id="id" class="form-control" value="{{$edit_data->id}}">
                                    
                                    <div class="form-group">
                                        <div class="col-sm-3 col-sm-offset-2">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </div>
                                </form>
                                @endif
                                <!-- Contra created/updated modal starts-->
                                <div id="sund-receipt-add-response-message-modal" class="modal fade">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <strong id="sund-receipt-add-response"></strong>
                                            </div>
                                            <div class="modal-footer">
                                                <form>
                                                    <input type="submit" class="btn btn-primary btn-sm" value="OK" onlick="location.reload();"/>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Contra created/updated modal ends-->
                            </div>
                        </div>                         
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>
@endsection
