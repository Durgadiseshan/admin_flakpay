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
                    <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#purchase-order">New Tax Settlement</a></li> 
                    @else
                    <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#purchase-order">Edit Tax Settlement</a></li> 
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
                       <div class="row padding-top-10">
                           <div class="col-sm-12">
                            <form method="POST" class="form-horizontal" role="form" id="tax-settlement-form">
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
                                            <label for="input" class="col-sm-3 control-label">Tax Settlement Number:</label>
                                            <div class="col-sm-6">
                                                <input type="text" name="tax_settlement_no" id="tax_settlement_no" class="form-control" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="input" class="col-sm-3 control-label">Date From:</label>
                                            <div class="col-sm-6">
                                                <div class="input-group date">
                                                    <input type="text" name="tax_date_from" id="tax_date_from" class="form-control" value="" placeholder="YY-MM-DD">
                                                    <span class="input-group-addon"><span class="fa fa-calendar show-pointer" onclick="($('#tax_date_from')).focus();"></span></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="input" class="col-sm-3 control-label">Date To:</label>
                                            <div class="col-sm-6">
                                                <div class="input-group date">
                                                    <input type="text" name="tax_date_to" id="tax_date_to" class="form-control" value="" placeholder="YY-MM-DD">
                                                    <span class="input-group-addon"><span class="fa fa-calendar show-pointer" onclick="($('#tax_date_to')).focus();"></span></span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="col-sm-6">
                                        
                                        <div class="form-group">
                                            <label for="input" class="col-sm-4 control-label">Account Code Debit:</label>
                                            <div class="col-sm-6">
                                                <select name="debit_account_code" id="debit_account_code" class="form-control">
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
                                            <label for="input" class="col-sm-4 control-label">Account Code Credit:</label>
                                            <div class="col-sm-6">
                                                <select name="credit_account_code" id="credit_account_code" class="form-control">
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
                        <div id="tax-settlement-response-message-modal" class="modal fade">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <strong id="tax-settlement-success-response" class="text-success text-center"></strong>
                                        <strong id="tax-settlement-failed-response" class="text-warning text-center"></strong>
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
