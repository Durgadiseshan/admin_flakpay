@php
    use App\AppOption;
    use App\RyapayBankInfo;
    use App\CharOfAccount;
    use App\RyapaySupplier;

    $paymodes = AppOption::get_paymode();
    $bankids = RyapayBankInfo::get_bank_option();
    $expense_codes = CharOfAccount::get_code_options();
    $suppliers = RyapaySupplier::get_sup_opts(); 
@endphp
@extends('layouts.employeecontent')
@section('employeecontent')
<div class="row">
    <div class="col-sm-12 padding-20">
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#add-edit-contra-entry-batch">New/Edit Contra Entry</a></li> 
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div id="add-edit-contra-entry-batch" class="tab-pane fade in active">
                        <div class="row">
                            <div class="col-sm-12">
                                <a href="{{route('finance-payable','ryapay-fRg1gbzX')}}" class="btn btn-primary btn-sm pull-right">Back</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                @if($form == "create")
                                <form id="sund-pay-form" method="POST" role="form" class="form-horizontal">
                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Sundry Payment No:</label>
                                        <div class="col-sm-3">
                                            <input type="text" name="sund_pay_no" id="sund_pay_no" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Pay Date:</label>
                                        <div class="col-sm-3">
                                            <div class="input-group date">
                                                <input type="text" name="sund_pay_date" id="sund_pay_date" class="form-control" value="" placeholder="YYYY-MM-DD">
                                                <span class="input-group-addon"><span class="fa fa-calendar show-pointer" onclick="($('#sund_pay_date')).focus();"></span></span>
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
                                        <label for="input" class="col-sm-2 control-label">Expense Code:</label>
                                        <div class="col-sm-3">
                                            <select name="expense_code" id="expense_code" class="form-control">
                                                <option value="">--Select--</option>                                                                            
                                                @if(count($expense_codes) > 0)
                                                    @foreach($expense_codes as $amount_code)
                                                        <option value="{{$amount_code->id}}">{{$amount_code->account_code}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <div id="expense_code_error"></div>
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
                                <form id="update-sund-pay-form" method="POST" role="form" class="form-horizontal">
                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Sundry Payment No:</label>
                                        <div class="col-sm-3">
                                            <input type="text" name="sund_pay_no" id="sund_pay_no" class="form-control" value="{{$edit_data->sund_pay_no}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Pay Date:</label>
                                        <div class="col-sm-3">
                                            <div class="input-group date">
                                                <input type="text" name="sund_pay_date" id="sund_pay_date" class="form-control" value="{{$edit_data->sund_pay_date}}" placeholder="YYYY-MM-DD">
                                                <span class="input-group-addon"><span class="fa fa-calendar show-pointer" onclick="($('#sund_pay_date')).focus();"></span></span>
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
                                        <label for="input" class="col-sm-2 control-label">Expense Code:</label>
                                        <div class="col-sm-3">
                                            <select name="expense_code" id="expense_code" class="form-control">
                                                <option value="">--Select--</option>                                                                            
                                                @if(count($expense_codes) > 0)
                                                    @foreach($expense_codes as $amount_code)
                                                        @if($edit_data->expense_code == $amount_code->id)
                                                        <option value="{{$amount_code->id}}" selected>{{$amount_code->account_code}}</option>
                                                        @else
                                                        <option value="{{$amount_code->id}}">{{$amount_code->account_code}}</option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </select>
                                            <div id="expense_code_error"></div>
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
                                <div id="sund-pay-add-response-message-modal" class="modal fade">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <strong id="sund-pay-add-response"></strong>
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
