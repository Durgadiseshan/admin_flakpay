@php
    use App\CharOfAccount;
    use App\AppOption;

    $amount_codes = CharOfAccount::get_code_options();
    $tax_types = AppOption::get_global_tax_type();
@endphp
@extends('layouts.employeecontent')
@section('employeecontent')
<div class="row">
    <div class="col-sm-12 padding-20">
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs" id="transaction-tabs">
                    @if($form == "create")
                    <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#purchase-order">New Tax Adjustment</a></li> 
                    @else
                    <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#purchase-order">Edit Tax Adjustment</a></li> 
                    @endif
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div id="purchase-order" class="tab-pane fade in active">
                        <div class="row">
                            <div class="col-sm-12">
                                <a href="{{route('account-payable','ryapay-TZ4rElGj')}}" class="btn btn-primary pull-right">Go Back</a>
                            </div>
                        </div>
                        @if($form == "create")
                       <div class="row">
                           <div class="col-sm-12">
                            <form method="POST" class="form-horizontal" role="form" id="tax-adjustment-form">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="input" class="col-sm-3 control-label">Tax Type</label>
                                            <div class="col-sm-6">
                                                <select name="tax_type" id="tax_type" class="form-control">
                                                    <option value="">--Select--</option>
                                                    @if(count($tax_types) > 0)
                                                        @foreach($tax_types as $tax_type)
                                                            <option value="{{$tax_type->id}}">{{$tax_type->option_value}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <div id="tax_type_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="input" class="col-sm-3 control-label">Tax Description:</label>
                                            <div class="col-sm-6">
                                                <textarea name="tax_description" id="tax_description" class="form-control" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="input" class="col-sm-3 control-label">Tax Adjustment Number:</label>
                                            <div class="col-sm-6">
                                                <input type="text" name="tax_adjustment_no" id="tax_adjustment_no" class="form-control" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="input" class="col-sm-3 control-label">Adjustment Date:</label>
                                            <div class="col-sm-6">
                                                <div class="input-group date">
                                                    <input type="text" name="adjustment_date" id="adjustment_date" class="form-control" value="" placeholder="YY-MM-DD">
                                                    <span class="input-group-addon"><span class="fa fa-calendar show-pointer" onclick="($('#adjustment_date')).focus();"></span></span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="col-sm-6">
                                        
                                        <div class="form-group">
                                            <label for="input" class="col-sm-4 control-label">Debit Document:</label>
                                            <div class="col-sm-6">
                                                <select name="debit_document" id="debit_document" class="form-control">
                                                    <option value="">--Select--</option>
                                                    @if(count($amount_codes) > 0)
                                                        @foreach($amount_codes as $amount_code)
                                                            <option value="{{$amount_code->id}}">{{$amount_code->account_code}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="input" class="col-sm-4 control-label">Credit Document:</label>
                                            <div class="col-sm-6">
                                                <select name="credit_document" id="credit_document" class="form-control">
                                                    <option value="">--Select--</option>
                                                    @if(count($amount_codes) > 0)
                                                        @foreach($amount_codes as $amount_code)
                                                            <option value="{{$amount_code->id}}">{{$amount_code->account_code}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="input" class="col-sm-4 control-label">Amount Debit:</label>
                                            <div class="col-sm-6">
                                                <input type="text" name="amount_debit" id="amount_debit" class="form-control" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="input" class="col-sm-4 control-label">Amount Credit:</label>
                                            <div class="col-sm-6">
                                                <input type="text" name="amount_credit" id="amount_credit" class="form-control" value="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="input" class="col-sm-4 control-label">Total TAX Amount:</label>
                                            <div class="col-sm-6">
                                                <input type="text" name="tax_total" id="tax_total" class="form-control" value="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="textarea" class="col-sm-4 control-label">Remarks:</label>
                                            <div class="col-sm-6">
                                                <textarea name="remarks" id="remarks" class="form-control" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{csrf_field()}}
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-sm-3 col-sm-offset-4">
                                            <input type="submit" class="btn btn-primary btn-block" value="Save"/>
                                        </div>
                                    </div>
                                </div>
                            </form>
                           </div>
                       </div>
                       @else
                        
                       @endif
                        <!-- Porder created modal starts-->
                        <div id="tax-adjustment-response-message-modal" class="modal fade">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <strong id="tax-adjustment-success-response" class="text-success text-center"></strong>
                                        <strong id="tax-adjustment-failed-response" class="text-warning text-center"></strong>
                                    </div>
                                    <div class="modal-footer">
                                        <form>
                                            <input type="submit" class="btn btn-primary btn-sm" value="OK" onlick="location.reload();"/>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Porder created modal ends-->
                    </div>
                    
                </div>
            </div>
        </div>    
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
    });
</script>
@endsection
