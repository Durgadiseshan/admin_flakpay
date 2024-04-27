@php
    use App\AppOption;
    use App\RyapayBankInfo;

    $paymodes = AppOption::get_paymode();
    $bankids = RyapayBankInfo::get_bank_option();
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
                                <form id="contra-entry-form" method="POST" role="form" class="form-horizontal">
                                    
                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Contra No:</label>
                                        <div class="col-sm-3">
                                            <input type="text" name="contra_no" id="contra_no" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Pay Date:</label>
                                        <div class="col-sm-3">
                                            <div class="input-group date">
                                                <input type="text" name="contra_date" id="contra_date" class="form-control" value="" placeholder="YYYY-MM-DD">
                                                <span class="input-group-addon"><span class="fa fa-calendar show-pointer" onclick="($('#contra_date')).focus();"></span></span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Debit Bank Account:</label>
                                        <div class="col-sm-3">
                                            <select name="debit_bank_id" id="debit_bank_id" class="form-control">
                                                <option value="">--Select--</option>
                                                @foreach($bankids as $bankid)
                                                <option value="{{$bankid->id}}">{{$bankid->bank_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Credit Bank Account:</label>
                                        <div class="col-sm-3">
                                            <select name="credit_bank_id" id="credit_bank_id" class="form-control">
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
                                <form id="update-contra-entry-form" method="POST" role="form" class="form-horizontal">
                                    
                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Contra No:</label>
                                        <div class="col-sm-3">
                                            <input type="text" name="contra_no" id="contra_no" class="form-control" value="{{$edit_data->contra_no}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Pay Date:</label>
                                        <div class="col-sm-3">
                                            <div class="input-group date">
                                                <input type="text" name="contra_date" id="contra_date" class="form-control" value="{{$edit_data->contra_date}}" placeholder="YYYY-MM-DD">
                                                <span class="input-group-addon"><span class="fa fa-calendar show-pointer" onclick="($('#contra_date')).focus();"></span></span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Debit Bank Account:</label>
                                        <div class="col-sm-3">
                                            <select name="debit_bank_id" id="debit_bank_id" class="form-control">
                                                <option value="">--Select--</option>
                                                @foreach($bankids as $bankid)
                                                    @if($edit_data->debit_bank_id == $bankid->id)
                                                        <option value="{{$bankid->id}}" selected>{{$bankid->bank_name}}</option>
                                                    @else
                                                        <option value="{{$bankid->id}}">{{$bankid->bank_name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="input" class="col-sm-2 control-label">Credit Bank Account:</label>
                                        <div class="col-sm-3">
                                            <select name="credit_bank_id" id="credit_bank_id" class="form-control">
                                                <option value="">--Select--</option>
                                                @foreach($bankids as $bankid)
                                                    @if($edit_data->credit_bank_id == $bankid->id)
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
                                    <input type="hidden" name="id" id="id" class="form-control" value="{{$edit_data->id}}">
                                    <div class="form-group">
                                        <div class="col-sm-3 col-sm-offset-2">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </div>
                                </form>
                                @endif
                                <!-- Contra created/updated modal starts-->
                                <div id="contra-add-response-message-modal" class="modal fade">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <strong id="contra-add-response"></strong>
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
