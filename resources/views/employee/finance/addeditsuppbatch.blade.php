@php
    use App\RyapayBankInfo;
    use App\AppOption;
    use App\RyapaySupplier;

    $paymodes = AppOption::get_paymode();
    $bankids = RyapayBankInfo::get_bank_option();
    $suppliers = RyapaySupplier::get_sup_opts();
@endphp
@extends('layouts.employeecontent')
@section('employeecontent')
<div class="row">
    <div class="col-sm-12 padding-20">
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#add-edit-sup-pay-entry-batch">New/Edit Supplier Pay Batch Entry</a></li> 
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div id="add-edit-sup-pay-entry-batch" class="tab-pane fade in active">
                        <div class="row">
                            <div class="col-sm-12">
                                <a href="{{route('finance-payable','ryapay-fRg1gbzX')}}" class="btn btn-primary btn-sm pull-right">Back</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                @if($form == "create")
                                <form id="sup-pay-entry-form" method="POST" role="form" class="form-horizontal">
                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Pay Batch No:</label>
                                        <div class="col-sm-3">
                                            <input type="text" name="batch_no" id="batch_no" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Pay Batch Date:</label>
                                        <div class="col-sm-3">
                                            <div class="input-group date">
                                                <input type="text" name="batch_pay_date" id="batch_pay_date" class="form-control" value="" placeholder="YYYY-MM-DD">
                                                <span class="input-group-addon"><span class="fa fa-calendar show-pointer" onclick="($('#batch_pay_date')).focus();"></span></span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Supplier Name:</label>
                                        <div class="col-sm-3">
                                            <select name="supplier_id" id="supplier_id" class="form-control">
                                                <option value="">--Select--</option>
                                                @foreach($suppliers as $supplier)
                                                    <option value="{{$supplier->id}}">{{$supplier->supplier_name}}</option>
                                                @endforeach
                                            </select>
                                            <div id="supplier_id_error"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Invoice Type:</label>
                                        <div class="col-sm-3">
                                            <select name="batch_invtype" id="batch_invtype" class="form-control" onchange="getInvoiceNo(this);">
                                                <option value="">--Select--</option>
                                                @foreach($payable_options as $index => $payable_option)
                                                    <option value="{{$index}}">{{$payable_option}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Invoice No:</label>
                                        <div class="col-sm-3">
                                            <select name="batch_invno" id="batch_invno" class="form-control">
                                                <option value="">--Select--</option>
                                            </select>
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
                                        <label for="input" class="col-sm-2 control-label">Payment Mode:</label>
                                        <div class="col-sm-3">
                                            <select name="payment_mode" id="payment_mode" class="form-control">
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
                                            <input type="text" name="payment_amount" id="payment_amount" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Remark:</label>
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
                                <form id="update-sup-pay-entry-form" method="POST" role="form" class="form-horizontal">
                                    
                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Pay Batch No:</label>
                                        <div class="col-sm-3">
                                            <input type="text" name="batch_no" id="batch_no" class="form-control" value="{{$edit_data->batch_no}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Pay Batch Date:</label>
                                        <div class="col-sm-3">
                                            <div class="input-group date">
                                                <input type="text" name="batch_pay_date" id="batch_pay_date" class="form-control" value="{{$edit_data->batch_pay_date}}" placeholder="YYYY-MM-DD">
                                                <span class="input-group-addon"><span class="fa fa-calendar show-pointer" onclick="($('#batch_pay_date')).focus();"></span></span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Supplier Name:</label>
                                        <div class="col-sm-3">
                                            <select name="supplier_id" id="supplier_id" class="form-control">
                                                <option value="">--Select--</option>
                                                @foreach($suppliers as $supplier)
                                                    @if($edit_data->supplier_id == $supplier->id)
                                                        <option value="{{$supplier->id}}" selected>{{$supplier->supplier_name}}</option>
                                                    @else
                                                        <option value="{{$supplier->id}}">{{$supplier->supplier_name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <div id="supplier_id_error"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Invoice Type:</label>
                                        <div class="col-sm-3">
                                            <select name="batch_invtype" id="batch_invtype" class="form-control" onchange="getInvoiceNo(this);">
                                                <option value="">--Select--</option>
                                                @foreach($payable_options as $index => $payable_option)
                                                    @if($edit_data->batch_invtype == $index)
                                                        <option value="{{$index}}" selected>{{$payable_option}}</option>
                                                    @else
                                                        <option value="{{$index}}">{{$payable_option}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Invoice No:</label>
                                        <div class="col-sm-3">
                                            <select name="batch_invno" id="batch_invno" class="form-control">
                                                <option value="">--Select--</option>
                                                @foreach($options as $index => $option)
                                                    @if($edit_data->batch_invno == $option->id)
                                                        <option value="{{$option->id}}" selected>{{$option->option_value}}</option>
                                                    @else
                                                    <option value="{{$option->id}}">{{$option->option_value}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
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
                                            <select name="payment_mode" id="payment_mode" class="form-control">
                                                <option value="">--Select--</option>
                                                @foreach($paymodes as $paymode)
                                                    @if($edit_data->payment_mode == $paymode->id)
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
                                            <input type="text" name="payment_amount" id="payment_amount" class="form-control" value="{{$edit_data->payment_amount}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Remark:</label>
                                        <div class="col-sm-3">
                                            <textarea name="remarks" id="remarks" class="form-control" rows="3">{{$edit_data->remarks}}</textarea>
                                        </div>
                                    </div>
                                    {{csrf_field()}}
                                    <input type="hidden" name="id" id="id" value="{{$edit_data->id}}">
                                    <div class="form-group">
                                        <div class="col-sm-3 col-sm-offset-2">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </div>
                                </form>
                                @endif
                                <!-- Contra created/updated modal starts-->
                                <div id="sup-pay-add-response-message-modal" class="modal fade">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <strong id="sup-pay-add-response"></strong>
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
