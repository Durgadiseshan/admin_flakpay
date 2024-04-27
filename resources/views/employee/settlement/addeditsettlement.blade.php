@php
    use App\User;
    $merchants = User::get_merchant_options();
@endphp
@extends('layouts.employeecontent') 
@section('employeecontent')
<div class="row">
    <div class="col-sm-12 padding-20">
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs" id="transaction-tabs">
                    <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#new-merchant-settlement">Settlement</a></li>
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div id="new-merchant-settlement" class="tab-pane fade in active">
                        <div class="row">
                            <div class="col-sm-12">
                                <a href="{{route('settlement-transactions','ryapay-YBxqOZ30')}}" class="btn btn-primary pull-right btn-sm">Go Back</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div id="add-settlement-ajax-success-message" class="text-success text-center"></div>
                                        <div id="add-settlement-ajax-failed-message" class="text-dangert ext-center"></div>
                                        <form id="add-settlement-form" method="POST" class="form-horizontal" role="form">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="input" class="col-sm-4 control-label">Merchant Name:</label>
                                                    <div class="col-sm-6">
                                                        <select name="merchant_id" id="merchant_id" class="form-control" onchange="getMerchantTransactions(this)">
                                                            <option value="">--Select--</option>
                                                            @foreach($merchants as $merchant)
                                                                <option value="{{$merchant->id}}">{{$merchant->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
    
                                                <div class="form-group">
                                                    <label for="input" class="col-sm-4 control-label">Merchant Transaction Id:</label>
                                                    <div class="col-sm-6">
                                                        <select name="merchant_traxn_id" id="merchant_traxn_id" class="form-control" onchange="getTransactionsDetails(this)">
                                                            <option value="">--Select--</option>
                                                            
                                                        </select>
                                                    </div>
                                                </div>
    
                                                <div class="form-group">
                                                    <label for="input" class="col-sm-4 control-label">Transaction Id:</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" name="tranx_id" id="tranx_id" class="form-control" value="" title="">
                                                    </div>
                                                </div>
    
                                                <div class="form-group">
                                                    <label for="input" class="col-sm-4 control-label">Transaction Date:</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" name="adjustment_date" id="adjustment_date" class="form-control" value="" title="">
                                                    </div>
                                                </div>
    
                                                <div class="form-group">
                                                    <label for="input" class="col-sm-4 control-label">Bank Name:</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" name="bankname" id="bankname" class="form-control" value="" title="">
                                                    </div>
                                                </div>
    
                                                <div class="form-group">
                                                    <label for="input" class="col-sm-4 control-label">Bank Reference:</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" name="bank_id" id="bank_id" class="form-control" value="" title="">
                                                    </div>
                                                </div>
    
                                                <div class="form-group">
                                                    <label for="input" class="col-sm-4 control-label">Transaction Type:</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" name="merchant_traxn_method" id="merchant_traxn_method" class="form-control" value="" title="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">

                                                <div class="form-group">
                                                    <label for="input" class="col-sm-4 control-label">Basic Amount:</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" name="traxn_amount" id="traxn_amount" class="form-control" value="" title="">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="input" class="col-sm-4 control-label">Charge on Basic Amount:</label>
                                                    <div class="col-sm-6">
                                                        <div class="input-group">
                                                            <input type="text" name="adjustment_charges_per" id="adjustment_charges_per" class="form-control" value="" title="">
                                                            <span class="input-group-addon">%</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="input" class="col-sm-4 control-label">Charges</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" name="adjustment_charges" id="adjustment_charges" class="form-control" value="" title="">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="input" class="col-sm-4 control-label">GST on Charges</label>
                                                    <div class="col-sm-6">
                                                        <div class="input-group">
                                                            <input type="text" name="adjustment_gst_per" id="adjustment_gst_per" class="form-control" value="" title="">
                                                            <span class="input-group-addon">%</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="input" class="col-sm-4 control-label">GST</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" name="adjustment_gst" id="adjustment_gst" class="form-control" value="" title="">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="input" class="col-sm-4 control-label">Total Charges</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" name="total_charge" id="total_charge" class="form-control" value="" title="">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="input" class="col-sm-4 control-label">Settlement Amount</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" name="adjustment_amount" id="adjustment_amount" class="form-control" value="" title="">
                                                    </div>
                                                </div>
                                            </div>
                                            {{csrf_field()}}                                     
                                            <div class="form-group">
                                                <div class="col-sm-3 col-sm-offset-5">
                                                    <button type="submit" class="btn btn-primary btn-block">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>                         
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>
@endsection
