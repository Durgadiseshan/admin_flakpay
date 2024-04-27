@php
$vendor_banks = App\RyapayVendorBank::get_vendorbank();
@endphp
@extends('layouts.employeecontent')
@section('employeecontent')
<div class="row">
    <div class="col-sm-12 padding-20">
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs">
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
                    @switch($index)
                    @case("0")
                    <div id="{{str_replace(' ','-',strtolower($value->link_name))}}" class="tab-pane fade in active">
                        <div class="row">
                            <div class="col-sm-12">
                                <a href="javascript:void(0)" class="btn btn-primary pull-right btn-sm margin-bottom-lg" id="call-merchant-charges-modal">Add Merchant Charges</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div id="paginate_merchantcharge">

                                </div>
                            </div>
                        </div>

                        <div class="modal" id="merchant-charges-modal">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title">Merchant Charges Form</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div id="ajax-success-response" class="text-center text-success"></div>
                                        <div id="ajax-failed-response" class="text-center text-danger"></div>
                                        <form id="merchant-charges-form" method="POST" class="form-horizontal" role="form" autocomplete="off">

                                            <div class="form-group form-fit">
                                                <label for="input" class="col-sm-3 control-label">Merchant Id:</label>
                                                <div class="col-sm-3">
                                                    <select name="merchant_id" id="merchant_id" class="form-control" required="required" onchange="getMerchantBusinessType(this,'merchant-charges-form')">
                                                        <option value="">--Select--</option>
                                                        @foreach(App\User::get_merchant_gids() as $index => $merchant)
                                                        <option value="{{$merchant->id}}">{{$merchant->merchant_gid}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div id="merchant_id_error" class="text-danger"></div>
                                                </div>
                                                <label for="input" class="col-sm-3 control-label">Business Type:<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <select name="business_type_id" id="business_type_id" class="form-control" required="required" readonly>
                                                        <option value="">--Select--</option>
                                                        @foreach(App\BusinessType::business_type() as $index => $businesstype)
                                                        <option value="{{$businesstype->id}}">{{$businesstype->type_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group form-fit">
                                                <label for="input" class="col-sm-3 control-label">DC Visa:<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="dc_visa" id="dc_visa" class="form-control" value="" required="required">
                                                    <div id="dc_visa_error" class="text-danger"></div>
                                                </div>
                                                <label for="input" class="col-sm-3 control-label">DC Master:<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="dc_master" id="dc_master" class="form-control" value="" required="required">
                                                    <div id="dc_master_error" class="text-danger"></div>
                                                </div>
                                            </div>
                                            <div class="form-group form-fit">
                                                <label for="input" class="col-sm-3 control-label">DC Rupay:<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="dc_rupay" id="dc_rupay" class="form-control" value="" required="required">
                                                    <div id="dc_rupay_error" class="text-danger"></div>
                                                </div>
                                                <label for="input" class="col-sm-3 control-label">CC Visa:<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="cc_visa" id="cc_visa" class="form-control" value="" required="required">
                                                    <div id="cc_visa_error" class="text-danger"></div>
                                                </div>
                                            </div>
                                            <div class="form-group form-fit">
                                                <label for="input" class="col-sm-3 control-label">CC Master:<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="cc_master" id="cc_master" class="form-control" value="" required="required">
                                                    <div id="cc_master_error" class="text-danger"></div>
                                                </div>
                                                <label for="input" class="col-sm-3 control-label">CC Rupay:<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="cc_rupay" id="cc_rupay" class="form-control" value="" required="required">
                                                    <div id="cc_rupay_error" class="text-danger"></div>
                                                </div>
                                            </div>
                                            <div class="form-group form-fit">
                                                <label for="input" class="col-sm-3 control-label">AMEX:<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="amex" id="amex" class="form-control" value="" required="required">
                                                    <div id="amex_error" class="text-danger"></div>
                                                </div>
                                                <label for="input" class="col-sm-3 control-label">UPI:<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="upi" id="upi" class="form-control" value="" required="required">
                                                    <div id="upi_error" class="text-danger"></div>
                                                </div>
                                            </div>
                                            <fieldset class="scheduler-border">
                                                <legend class="scheduler-border">Net Banking</legend>
                                                <div class="form-group form-fit">
                                                    <label for="input" class="col-sm-3 control-label">SBI:<span class="text-danger">*</span></label>
                                                    <div class="col-sm-3">
                                                        <input type="text" name="net_sbi" id="net_sbi" class="form-control" value="" required="required">
                                                        <div id="net_sbi_error" class="text-danger"></div>
                                                    </div>
                                                    <label for="input" class="col-sm-3 control-label">HDFC:<span class="text-danger">*</span></label>
                                                    <div class="col-sm-3">
                                                        <input type="text" name="net_hdfc" id="net_hdfc" class="form-control" value="" required="required">
                                                        <div id="net_hdfc_error" class="text-danger"></div>
                                                    </div>
                                                </div>
                                                <div class="form-group form-fit">
                                                    <label for="input" class="col-sm-3 control-label">AXIS:<span class="text-danger">*</span></label>
                                                    <div class="col-sm-3">
                                                        <input type="text" name="net_axis" id="net_axis" class="form-control" value="" required="required">
                                                        <div id="net_axis_error" class="text-danger"></div>
                                                    </div>
                                                    <label for="input" class="col-sm-3 control-label">ICICI:<span class="text-danger">*</span></label>
                                                    <div class="col-sm-3">
                                                        <input type="text" name="net_icici" id="net_icici" class="form-control" value="" required="required">
                                                        <div id="net_icici_error" class="text-danger"></div>
                                                    </div>
                                                </div>
                                                <div class="form-group form-fit">
                                                    <label for="input" class="col-sm-3 control-label">YES/KOTAK:<span class="text-danger">*</span></label>
                                                    <div class="col-sm-3">
                                                        <input type="text" name="net_yes_kotak" id="net_yes_kotak" class="form-control" value="" required="required">
                                                        <div id="net_yes_kotak_error" class="text-danger"></div>
                                                    </div>
                                                    <label for="input" class="col-sm-3 control-label">OTHERS:<span class="text-danger">*</span></label>
                                                    <div class="col-sm-3">
                                                        <input type="text" name="net_others" id="net_others" class="form-control" value="" required="required">
                                                        <div id="net_others_error" class="text-danger"></div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <div class="form-group form-fit">
                                                <label for="input" class="col-sm-3 control-label">Wallet:<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="wallet" id="wallet" class="form-control" value="" required="required">
                                                    <div id="wallet_error" class="text-danger"></div>
                                                </div>
                                                <label for="input" class="col-sm-3 control-label">Debit ATM Pin:<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="dap" id="dap" class="form-control" value="" required="required">
                                                    <div id="dap_error" class="text-danger"></div>
                                                </div>
                                            </div>
                                            <div class="form-group form-fit">
                                                <label for="input" class="col-sm-3 control-label">QR Code:<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="qrcode" id="qrcode" class="form-control" value="" required="required">
                                                    <div id="qrcode_error" class="text-danger"></div>
                                                </div>
                                            </div>
                                            <div class="form-group form-fit">
                                                <label for="input" class="col-sm-3 control-label">Merchant Charges:</label>
                                                <div class="radio col-sm-2">
                                                    <label>
                                                        <input type="radio" name="charge_enabled" value="Y">
                                                        <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                                                        Enable
                                                    </label>
                                                </div>
                                                <div class="radio col-sm-2">
                                                    <label>
                                                        <input type="radio" name="charge_enabled" value="N" checked>
                                                        <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                                                        Disable
                                                    </label>
                                                </div>
                                                <i class="fa fa-info-circle show-pointer" data-toggle="merchant-charges-info" title="Merchant Charges" data-content="If you enable merchant charges at the time of payment gateway. payment fee will be collected by the end user not from the merchant."></i>
                                            </div>
                                            <input type="hidden" name="id" id="id" class="form-control" value="">

                                            {{csrf_field()}}
                                            <div class="form-group form-fit">
                                                <div class="col-sm-6 col-sm-offset-4">
                                                    <input type="submit" class="btn btn-primary btn-sm" value="Add Charges">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @break
                    @case("1")
                    <div id="{{str_replace(' ','-',strtolower($value->link_name))}}" class="tab-pane fade">
                        <div class="row">
                            <div class="col-sm-12">
                                <a href="javascript:void(0)" class="btn btn-primary pull-right btn-sm margin-bottom-lg" id="call-adjustment-charges-modal">Add Adjustment Charges</a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div id="paginate_adjustmentcharge">

                                </div>
                            </div>
                        </div>

                        <div class="modal" id="adjustment-charges-modal">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title">Adjustment Charges Form</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div id="ajax-success-response" class="text-center text-success"></div>
                                        <div id="ajax-failed-response" class="text-center text-danger"></div>
                                        <form id="adjustment-charges-form" method="POST" class="form-horizontal" role="form">
                                            <div class="form-group form-fit">
                                                <label for="input" class="col-sm-3 control-label">Merchant Id:</label>
                                                <div class="col-sm-3">
                                                    <select name="merchant_id" id="merchant_id" class="form-control" required="required" onchange="getMerchantBusinessType(this,'adjustment-charges-form')">
                                                        <option value="">--Select--</option>
                                                        @foreach(App\User::get_merchant_gids() as $index => $merchant)
                                                        <option value="{{$merchant->id}}">{{$merchant->merchant_gid}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div id="merchant_id_error" class="text-danger"></div>
                                                </div>
                                                <label for="input" class="col-sm-3 control-label">Business Type:<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <select name="business_type_id" id="business_type_id" class="form-control" required="required" readonly>
                                                        <option value="">--Select--</option>
                                                        @foreach(App\BusinessType::business_type() as $index => $businesstype)
                                                        <option value="{{$businesstype->id}}">{{$businesstype->type_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group form-fit">
                                                <label for="input" class="col-sm-3 control-label">DC Visa:<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="dc_visa" id="dc_visa" class="form-control" value="" required="required">
                                                    <div id="dc_visa_error" class="text-danger"></div>
                                                </div>
                                                <label for="input" class="col-sm-3 control-label">DC Master:<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="dc_master" id="dc_master" class="form-control" value="" required="required">
                                                    <div id="dc_master_error" class="text-danger"></div>
                                                </div>
                                            </div>
                                            <div class="form-group form-fit">
                                                <label for="input" class="col-sm-3 control-label">DC Rupay:<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="dc_rupay" id="dc_rupay" class="form-control" value="" required="required">
                                                    <div id="dc_rupay_error" class="text-danger"></div>
                                                </div>
                                                <label for="input" class="col-sm-3 control-label">CC Visa:<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="cc_visa" id="cc_visa" class="form-control" value="" required="required">
                                                    <div id="cc_visa_error" class="text-danger"></div>
                                                </div>
                                            </div>
                                            <div class="form-group form-fit">
                                                <label for="input" class="col-sm-3 control-label">CC Master:<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="cc_master" id="cc_master" class="form-control" value="" required="required">
                                                    <div id="cc_master_error" class="text-danger"></div>
                                                </div>
                                                <label for="input" class="col-sm-3 control-label">CC Rupay:<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="cc_rupay" id="cc_rupay" class="form-control" value="" required="required">
                                                    <div id="cc_rupay_error" class="text-danger"></div>
                                                </div>
                                            </div>
                                            <div class="form-group form-fit">
                                                <label for="input" class="col-sm-3 control-label">AMEX:<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="amex" id="amex" class="form-control" value="" required="required">
                                                    <div id="amex_error" class="text-danger"></div>
                                                </div>
                                                <label for="input" class="col-sm-3 control-label">UPI:<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="upi" id="upi" class="form-control" value="" required="required">
                                                    <div id="upi_error" class="text-danger"></div>
                                                </div>
                                            </div>
                                            <fieldset class="scheduler-border">
                                                <legend class="scheduler-border">Net Banking</legend>
                                                <div class="form-group form-fit">
                                                    <label for="input" class="col-sm-3 control-label">SBI:<span class="text-danger">*</span></label>
                                                    <div class="col-sm-3">
                                                        <input type="text" name="net_sbi" id="net_sbi" class="form-control" value="" required="required">
                                                        <div id="net_sbi_error" class="text-danger"></div>
                                                    </div>
                                                    <label for="input" class="col-sm-3 control-label">HDFC:<span class="text-danger">*</span></label>
                                                    <div class="col-sm-3">
                                                        <input type="text" name="net_hdfc" id="net_hdfc" class="form-control" value="" required="required">
                                                        <div id="net_hdfc_error" class="text-danger"></div>
                                                    </div>
                                                </div>
                                                <div class="form-group form-fit">
                                                    <label for="input" class="col-sm-3 control-label">AXIS:<span class="text-danger">*</span></label>
                                                    <div class="col-sm-3">
                                                        <input type="text" name="net_axis" id="net_axis" class="form-control" value="" required="required">
                                                        <div id="net_axis_error" class="text-danger"></div>
                                                    </div>
                                                    <label for="input" class="col-sm-3 control-label">ICICI:<span class="text-danger">*</span></label>
                                                    <div class="col-sm-3">
                                                        <input type="text" name="net_icici" id="net_icici" class="form-control" value="" required="required">
                                                        <div id="net_icici_error" class="text-danger"></div>
                                                    </div>
                                                </div>
                                                <div class="form-group form-fit">
                                                    <label for="input" class="col-sm-3 control-label">YES/KOTAK:<span class="text-danger">*</span></label>
                                                    <div class="col-sm-3">
                                                        <input type="text" name="net_yes_kotak" id="net_yes_kotak" class="form-control" value="" required="required">
                                                        <div id="net_yes_kotak_error" class="text-danger"></div>
                                                    </div>
                                                    <label for="input" class="col-sm-3 control-label">OTHERS:<span class="text-danger">*</span></label>
                                                    <div class="col-sm-3">
                                                        <input type="text" name="net_others" id="net_others" class="form-control" value="" required="required">
                                                        <div id="net_others_error" class="text-danger"></div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <input type="hidden" name="id" id="id" class="form-control" value="">
                                            {{csrf_field()}}
                                            <div class="form-group form-fit">
                                                <div class="col-sm-6 col-sm-offset-4">
                                                    <input type="submit" class="btn btn-primary btn-sm" value="Add Adjustment Charges">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @break
                    @case("2")
                    <div id="{{str_replace(' ','-',strtolower($value->link_name))}}" class="tab-pane fade">
                        <div class="row">
                            <div class="col-sm-12">
                                <a href="javascript:void(0)" class="btn btn-primary pull-right btn-sm margin-bottom-lg" id="call-merchant-route-modal">Add Merchant Route</a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div id="paginate_merchantroute">

                                </div>
                            </div>
                        </div>

                        <div class="modal" id="merchant-route-modal">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title">Merchant Routing</h4>
                                    </div>
                                    <div id="merchant-route-add-succsess-response" class="text-center text-success"></div>
                                    <div id="merchant-route-add-fail-response" class="text-center text-danger"></div>
                                    <form class="form-horizontal" id="merchant-routing-form">
                                        <div class="modal-body">
                                            <div class="form-group form-fit">
                                                <label for="input" class="col-sm-3 control-label">Merchant Id:</label>
                                                <div class="col-sm-3">
                                                    <select name="merchant_id" id="merchant_id" class="form-control" required="required" onchange="getMerchantBusinessType(this,'merchant-routing-form')">
                                                        <option value="">--Select--</option>
                                                        @foreach(App\User::get_merchant_gids() as $index => $merchant)
                                                        <option value="{{$merchant->id}}">{{$merchant->merchant_gid}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div id="merchant_id_error" class="text-danger"></div>
                                                </div>
                                                <label for="input" class="col-sm-3 control-label">Business Type:<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <select name="business_type_id" id="business_type_id" class="form-control" required="required" readonly>
                                                        <option value="">--Select--</option>
                                                        @foreach(App\BusinessType::business_type() as $index => $businesstype)
                                                        <option value="{{$businesstype->id}}">{{$businesstype->type_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group form-fit">
                                                <label for="input" class="col-sm-3 control-label">CC Card:<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <select name="cc_card" id="cc_card" class="form-control" required="required">
                                                        <option value="">--Select--</option>
                                                        @foreach($vendor_banks as $index => $vendor)
                                                        <option value="{{$vendor->id}}">{{$vendor->bank_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div id="cc_card_error" class="text-danger"></div>
                                                </div>
                                                <label for="input" class="col-sm-3 control-label">DC Card:<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <select name="dc_card" id="dc_card" class="form-control" required="required">
                                                        <option value="">--Select--</option>
                                                        @foreach($vendor_banks as $index => $vendor)
                                                        <option value="{{$vendor->id}}">{{$vendor->bank_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div id="dc_card_error" class="text-danger"></div>
                                                </div>
                                            </div>
                                            <div class="form-group form-fit">
                                                <label for="input" class="col-sm-3 control-label">Net Banking:<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <select name="net" id="net" class="form-control" required="required">
                                                        <option value="">--Select--</option>
                                                        @foreach($vendor_banks as $index => $vendor)
                                                        <option value="{{$vendor->id}}">{{$vendor->bank_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div id="net_error" class="text-danger"></div>
                                                </div>
                                                <label for="input" class="col-sm-3 control-label">Upi:<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <select name="upi" id="upi" class="form-control" required="required">
                                                        <option value="">--Select--</option>
                                                        @foreach($vendor_banks as $index => $vendor)
                                                        <option value="{{$vendor->id}}">{{$vendor->bank_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div id="upi_error" class="text-danger"></div>
                                                </div>
                                            </div>
                                            <div class="form-group form-fit">
                                                <label for="input" class="col-sm-3 control-label">QRCode:<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <select name="qrcode" id="qrcode" class="form-control" required="required">
                                                        <option value="">--Select--</option>
                                                        @foreach($vendor_banks as $index => $vendor)
                                                        <option value="{{$vendor->id}}">{{$vendor->bank_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div id="qrcode_error" class="text-danger"></div>
                                                </div>
                                                <label for="input" class="col-sm-3 control-label">Wallet:<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <select name="wallet" id="wallet" class="form-control" required="required">
                                                        <option value="">--Select--</option>
                                                        @foreach($vendor_banks as $index => $vendor)
                                                        <option value="{{$vendor->id}}">{{$vendor->bank_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div id="wallet_error" class="text-danger"></div>
                                                </div>
                                            </div>
                                        </div>
                                        {{csrf_field()}}
                                        <input type="hidden" name="id" value="">
                                        <div class="modal-footer">
                                            <div class="col-md-2 col-md-offset-9">
                                                <input type="submit" class="btn btn-primary" value="Save Route">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                    @break
                    @case("3")
                    <div id="{{str_replace(' ','-',strtolower($value->link_name))}}" class="tab-pane fade">
                        <div class="row">
                            <div class="col-sm-12">
                                <select id="showvendor" class="">
                                    <option value="">--Select--</option>
                                    @foreach(\DB::table('vendor_bank')->get() as $index => $vendor)
                                    <option value="{{$vendor->bank_name}}">{{$vendor->bank_name}}</option>
                                    @endforeach
                                </select>
                                <a href="javascript:void(0)" class="btn btn-primary pull-right btn-sm margin-bottom-lg" id="call-cashfree-route-modal">Add Vendor Api Keys</a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">

                                <div id="razorpaytable" style="display:none;">
                                    <table class="table table-striped table-bordered">
                                        <h4>Razorpay</h4>
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>merchant</th>
                                                <th>Key Id</th>
                                                <th>Key Secret</th>
                                                <th>Created</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($razorpay as $index=>$razor)
                                            <tr>
                                                <td>{{$index+1}}</td>
                                                <td>{{$razor->name}}</td>

                                                <td>{{$razor->key_id}}</td>
                                                <td>{{$razor->key_secret}}</td>
                                                <td>{{ Carbon\Carbon::parse($razor->date)->format('d-m-Y H:i:s')  }}</td>
                                                <td><button class="btn btn-danger" data-toggle="modal" data-id="{{$razor->key_id}}" data-vendor="Razorpay" data-target="#deleteModal">Delete</button></td>

                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div id="cashfreetable" style="display:none;">
                                    <table class="table table-striped table-bordered">
                                        <h4>Cashfree</h4>
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>merchant</th>
                                                <th>App Id</th>
                                                <th>Secret Key</th>
                                                <th>Created</th>
                                                <th>Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($cashfree as $index=>$cashfreeKey)
                                            <tr>
                                                <td>{{$index+1}}</td>
                                                <td>{{$cashfreeKey->name}}</td>
                                                <td>{{$cashfreeKey->app_id}}</td>
                                                <td>{{$cashfreeKey->secret_key}}</td>
                                                <td>{{ Carbon\Carbon::parse($cashfreeKey->date)->format('d-m-Y H:i:s')  }}</td>
                                                <td><button class="btn btn-danger" data-toggle="modal" data-id="{{$cashfreeKey->key_id}}" data-vendor="CashFree" data-target="#deleteModal">Delete</button></td>

                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>


                                <div id="worldlinetable" style="display:none;">
                                    <table class="table table-striped table-bordered">
                                        <h4>Worldline</h4>
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>merchant</th>
                                                <th>Merchant Code</th>
                                                <th>Scheme Code</th>
                                                <th>Enc Key</th>
                                                <th>Enc Iv</th>
                                                <th>Created</th>
                                                <th>Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($worldline as $index=>$worldlineKeys)
                                            <tr>
                                                <td>{{$index+1}}</td>
                                                <td>{{$worldlineKeys->name}}</td>
                                                <td>{{$worldlineKeys->merchant_code}}</td>
                                                <td>{{$worldlineKeys->scheme_code}}</td>
                                                <td>{{$worldlineKeys->enc_key}}</td>
                                                <td>{{$worldlineKeys->enc_iv}}</td>
                                                <td>{{ Carbon\Carbon::parse($worldlineKeys->created_date)->format('d-m-Y H:i:s')}}</td>
                                                <td><button class="btn btn-danger" data-toggle="modal" data-id="{{$worldlineKeys->key_id}}" data-vendor="Worldline" data-target="#deleteModal">Delete</button></td>

                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>


                                <div id="payutable" style="display:none;">
                                    <table class="table table-striped table-bordered">
                                        <h4>PayU</h4>
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>merchant</th>
                                                <th>Merchant mid</th>
                                                <th>Merchant Key</th>
                                                <th>Salt Key</th>
                                                <th>Created</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($payu as $index=>$payuKeys)
                                            <tr>
                                                <td>{{$index+1}}</td>
                                                <td>{{$payuKeys->name ?? ''}}</td>
                                                <td>{{$payuKeys->merchant_mid}}</td>
                                                <td>{{$payuKeys->merchant_key}}</td>
                                                <td>{{$payuKeys->salt_key}}</td>
                                                <td>{{ Carbon\Carbon::parse($payuKeys->created_date)->format('d-m-Y H:i:s')}}</td>
                                                <td><button class="btn btn-danger" data-toggle="modal" data-id="{{$payuKeys->key_id}}" data-vendor="PayU" data-target="#deleteModal">Delete</button></td>

                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>


                                <div id="paytmtable" style="display:none;">
                                    <table class="table table-striped table-bordered">
                                        <h4>Paytm</h4>
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>merchant</th>
                                                <th>Paytm Merchant Id</th>
                                                <th>Merchant Key</th>
                                                <th>Website</th>
                                                <th>Industry Type</th>
                                                <th>Channel Id Website</th>
                                                <th>Channel Id Mobile App</th>
                                                <th>Created</th>
                                                <th>Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($paytm as $index=>$paytmKeys)
                                            <tr>
                                                <td>{{$index+1}}</td>
                                                <td>{{$paytmKeys->name}}</td>
                                                <td>{{$paytmKeys->paytm_merchant_id}}</td>
                                                <td>{{$paytmKeys->merchant_key}}</td>
                                                <td>{{$paytmKeys->website}}</td>
                                                <td>{{$paytmKeys->industry_type}}</td>
                                                <td>{{$paytmKeys->channel_id_website}}</td>
                                                <td>{{$paytmKeys->channel_id_mobileapp}}</td>
                                                <td>{{ Carbon\Carbon::parse($paytmKeys->created_date)->format('d-m-Y H:i:s')}}</td>
                                                <td><button class="btn btn-danger" data-toggle="modal" data-id="{{$paytmKeys->key_id}}" data-vendor="Paytm" data-target="#deleteModal">Delete</button></td>

                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>

                                <div id="atomtable" style="display:none;">
                                    <table class="table table-striped table-bordered">
                                        <h4>Atom</h4>
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>merchant</th>
                                                <th>User Id</th>
                                                <th>Hash Request Key</th>
                                                <th>Hash Request Key</th>
                                                <th>Aes Request Key</th>
                                                <th>Aes Request Salt/Iv Key</th>
                                                <th>Aes Response Key</th>
                                                <th>Aes Response Salt/Iv Key</th>
                                                <th>Created</th>
                                                <th>Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($atom as $index=>$atomKeys)
                                            <tr>
                                                <td>{{$index+1}}</td>
                                                <td>{{$atomKeys->name}}</td>
                                                <td>{{$atomKeys->userid}}</td>
                                                <td>{{$atomKeys->hash_request_key}}</td>
                                                <td>{{$atomKeys->hash_response_key}}</td>
                                                <td>{{$atomKeys->aes_request_key}}</td>
                                                <td>{{$atomKeys->aes_request_salt_iv_key}}</td>
                                                <td>{{$atomKeys->aes_response_key}}</td>
                                                <td>{{$atomKeys->aes_response_salt_iv_key}}</td>
                                                <td>{{ Carbon\Carbon::parse($atomKeys->created_date)->format('d-m-Y H:i:s')}}</td>
                                                <td><button class="btn btn-danger" data-toggle="modal" data-id="{{$atomKeys->key_id}}" data-vendor="Atom" data-target="#deleteModal">Delete</button></td>

                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- deleteModal -->
                                <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-sm" style="margin-top:150px" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="exampleModalLongTitle">Are you sure ?</h4>

                                            </div>

                                            <div class="modal-footer">
                                                <form action="/rockpay/technical/delete_vendor_keys" method="POST">
                                                    {{csrf_field()}}
                                                    <input type="hidden" id="getId" name="id">
                                                    <input type="hidden" id="vendor" name="vendor_id">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-danger">Yes</button>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- enddeleteModal -->


                                <div id="grezpaytable" style="display:none;">
                                    <table class="table table-striped table-bordered">
                                        <h4>Grezpay</h4>
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>merchant</th>
                                                <th>App Id</th>
                                                <th>Salt Key</th>
                                                <th>Secret Key</th>
                                                <th>Created</th>
                                                <th>Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($grezpay as $index=>$grezpayKeys)
                                            <tr>
                                                <td>{{$index+1}}</td>
                                                <td>{{$grezpayKeys->name}}</td>
                                                <td>{{$grezpayKeys->app_id}}</td>
                                                <td>{{$grezpayKeys->salt_key}}</td>
                                                <td>{{$grezpayKeys->secret_key}}</td>
                                                <td>{{ Carbon\Carbon::parse($grezpayKeys->created_date)->format('d-m-Y H:i:s')}}</td>
                                                <td><button class="btn btn-danger" data-toggle="modal" data-id="{{$grezpayKeys->key_id}}" data-vendor="Grezpay" data-target="#deleteModal">Delete</button></td>

                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>


                                <h4 id="shownotice" style="display:none;">Work in Progress</h4>
                            </div>
                        </div>

                        <div class="modal" id="cashfree-route-modal">
                            <div class="modal-dialog modal-fit">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title">Add Vendor Api Keys</h4>
                                    </div>
                                    <div id="cashfree-route-add-succsess-response" class="text-center text-success"></div>
                                    <div id="cashfree-route-add-fail-response" class="text-center text-danger"></div>
                                    <form class="form-horizontal" action="/rockpay/technical/save_vendor_keys" method="post" enctype="multipart/form-data">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="input" class="col-sm-3 control-label">Vendor:</label>
                                                <div class="col-sm-8">
                                                    <select name="vendor_id" id="vendorId" class="form-control" required="required">
                                                        <option value="">--Select--</option>
                                                        @foreach(\DB::table('vendor_bank')->get() as $index => $vendor)
                                                        <option value="{{$vendor->bank_name}}">{{$vendor->bank_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div id="merchant_id_error" class="text-danger"></div>
                                                </div>
                                            </div>

                                            <div class="form-group" id="merchant" style="display:none;">
                                                <label for="input" class="col-sm-3 control-label">Merchant Id:</label>
                                                <div class="col-sm-8">
                                                    <select name="merchant_id" id="merchant_options" class="form-control" required="required">
                                                        <option id="" value="">--Select--</option>

                                                    </select>
                                                    <div id="merchant_id_error" class="text-danger"></div>
                                                </div>
                                            </div>
                                            <div id="cashfree" style="display:none;">
                                                <div class="form-group" id="cfappID">
                                                    <label for="input" class="col-sm-3 control-label">App Id:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="app_id" id="app_id" class="form-control" value="">
                                                        <div id="app_id_error" class="text-danger"></div>
                                                    </div>
                                                </div>
                                                <div class="form-group" id="cfsecretKey">
                                                    <label for="input" class="col-sm-3 control-label">Secret Key:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="secret_key" id="secret_key" class="form-control" value="">
                                                        <div id="app_id_error" class="text-danger"></div>
                                                    </div>
                                                </div>
                                            </div>


                                            <!-- //grezpay -->
                                            <div id="grezpay" style="display:none;">
                                                <div class="form-group">
                                                    <label for="input" class="col-sm-3 control-label">App Id:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="grezappID" id="grezappIDinput" class="form-control" value="">
                                                        <div id="app_id_error" class="text-danger"></div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="input" class="col-sm-3 control-label">Salt Key:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="grezsaltkey" id="grezsaltkeyinput" class="form-control" value="">
                                                        <div id="app_id_error" class="text-danger"></div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="input" class="col-sm-3 control-label">Secret Key:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="grezsecretkey" id="grezsecretkeyinput" class="form-control" value="">
                                                        <div id="app_id_error" class="text-danger"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- //endgrezpay -->


                                            <!-- //payu -->
                                            <div id="payu" style="display:none;">
                                                <div class="form-group">
                                                    <label for="input" class="col-sm-3 control-label">Mid:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="payumid" id="payumid" class="form-control" value="">
                                                        <div id="app_id_error" class="text-danger"></div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="input" class="col-sm-3 control-label">Key:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="payukey" id="payukey" class="form-control" value="">
                                                        <div id="app_id_error" class="text-danger"></div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="input" class="col-sm-3 control-label">Salt Key:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="payusaltkey" id="payusaltkey" class="form-control" value="">
                                                        <div id="app_id_error" class="text-danger"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- //endpayu -->



                                            <!-- //worldline -->
                                            <div id="worldline" style="display:none;">
                                                <div class="form-group">
                                                    <label for="input" class="col-sm-3 control-label">Merchant Code:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="worldlinemercode" id="worldlinemercode" class="form-control" value="">
                                                        <div id="app_id_error" class="text-danger"></div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="input" class="col-sm-3 control-label">Scheme Code:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="worldlineschemecode" id="worldlineschemecode" class="form-control" value="">
                                                        <div id="app_id_error" class="text-danger"></div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="input" class="col-sm-3 control-label">Enc Key:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="worldlineEncKey" id="worldlineEncKey" class="form-control" value="">
                                                        <div id="app_id_error" class="text-danger"></div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="input" class="col-sm-3 control-label">Enc Iv:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="worldlineEncIv" id="worldlineEncIv" class="form-control" value="">
                                                        <div id="app_id_error" class="text-danger"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- //endworldline -->


                                            <!-- //atom -->
                                            <div id="atom" style="display:none;">
                                                <div class="form-group">
                                                    <label for="input" class="col-sm-3 control-label">User Id:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="atomuserid" id="atomuserid" class="form-control" value="">
                                                        <div id="app_id_error" class="text-danger"></div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="input" class="col-sm-3 control-label">Hash Request Key:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="atomhashrequestkey" id="atomhashrequestkey" class="form-control" value="">
                                                        <div id="app_id_error" class="text-danger"></div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="input" class="col-sm-3 control-label">Hash Response Key:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="atomhashresponsekey" id="atomhashresponsekey" class="form-control" value="">
                                                        <div id="app_id_error" class="text-danger"></div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="input" class="col-sm-3 control-label">Aes Request Key:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="atomaesrequestkey" id="atomaesrequestkey" class="form-control" value="">
                                                        <div id="app_id_error" class="text-danger"></div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="input" class="col-sm-3 control-label">Aes Request Salt/IV Key:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="atomaesrequestsaltkey" id="atomaesrequestsaltkey" class="form-control" value="">
                                                        <div id="app_id_error" class="text-danger"></div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="input" class="col-sm-3 control-label">Aes Response Key:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="atomaesresponsekey" id="atomaesresponsekey" class="form-control" value="">
                                                        <div id="app_id_error" class="text-danger"></div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="input" class="col-sm-3 control-label">Aes Response Salt/IV Key:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="atomaesresponsesaltkey" id="atomaesresponsesaltkey" class="form-control" value="">
                                                        <div id="app_id_error" class="text-danger"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- //atom -->


                                            <!-- //paytm -->
                                            <div id="paytm" style="display:none;">
                                                <div class="form-group">
                                                    <label for="input" class="col-sm-3 control-label">Paytm Merchant ID:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="paytm_merchantid" id="paytm_merchantid" class="form-control" value="">
                                                        <div id="app_id_error" class="text-danger"></div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="input" class="col-sm-3 control-label">Merchant Key:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="paytm_merchant_key" id="paytm_merchant_key" class="form-control" value="">
                                                        <div id="app_id_error" class="text-danger"></div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="input" class="col-sm-3 control-label">Website:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="paytm_website" id="paytm_website" class="form-control" value="">
                                                        <div id="app_id_error" class="text-danger"></div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="input" class="col-sm-3 control-label">Industry Type:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="paytm_industry_type" id="paytm_industry_type" class="form-control" value="">
                                                        <div id="app_id_error" class="text-danger"></div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="input" class="col-sm-3 control-label">Channel Id Website:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="paytm_channel_id_website" id="paytm_channel_id_website" class="form-control" value="">
                                                        <div id="app_id_error" class="text-danger"></div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="input" class="col-sm-3 control-label">Channel Id Mobile App:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="paytm_channel_id_mobileapp" id="paytm_channel_id_mobileapp" class="form-control" value="">
                                                        <div id="app_id_error" class="text-danger"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- //endpaytm -->


                                            <!-- //razorpay -->
                                            <div id="razorpay" style="display:none;">
                                                <div class="form-group">
                                                    <label for="input" class="col-sm-3 control-label">Key ID:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="razorpay_keyid" id="razorpay_keyid" class="form-control" value="">
                                                        <div id="app_id_error" class="text-danger"></div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="input" class="col-sm-3 control-label">Key Secret:</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="razorpay_keysecret" id="razorpay_keysecret" class="form-control" value="">
                                                        <div id="app_id_error" class="text-danger"></div>
                                                    </div>
                                                </div>


                                            </div>
                                            <!-- //razorpay -->

                                        </div>
                                        {{csrf_field()}}
                                        <input type="hidden" name="id" value="">
                                        <div class="modal-footer">
                                            <div class="col-md-8 col-md-offset-2">
                                                <input type="submit" class="btn btn-primary">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                    @break
                    @default
                    @break
                    @endswitch
                    @endforeach
                    @else
                    <div id="{{str_replace(' ','-',strtolower($sublink_name))}}" class="tab-pane fade in active">

                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        merchantCharges();
        $('[data-toggle="merchant-charges-info"]').popover();
    });
</script>

<script>
    $('#vendorId').on('change', function() {
        var vendorId = $(this).val();
        console.log(vendorId);

        if (vendorId == 'Atom') {
            $('#atom').show();
            $('#paytm').hide();
            $('#razorpay').hide();
            $('#cashfree').hide();
            $('#grezpay').hide();
            $('#payu').hide();
            $('#worldline').hide();
            $('#merchant').show();
        } else if (vendorId == 'Razorpay') {
            $('#razorpay').show();
            $('#atom').hide();
            $('#paytm').hide();
            $('#cashfree').hide();
            $('#grezpay').hide();
            $('#payu').hide();
            $('#worldline').hide();
            $('#merchant').show();
        } else if (vendorId == 'CashFree') {
            $('#cashfree').show();
            $('#grezpay').hide();
            $('#paytm').hide();
            $('#atom').hide();
            $('#razorpay').hide();
            $('#payu').hide();
            $('#worldline').hide();
            $('#merchant').show();
        } else if (vendorId == 'Worldline') {
            $('#worldline').show();
            $('#payu').hide();
            $('#paytm').hide();
            $('#atom').hide();
            $('#razorpay').hide();
            $('#cashfree').hide();
            $('#grezpay').hide();
            $('#merchant').show();
        } else if (vendorId == 'PayU') {
            $('#payu').show();
            $('#cashfree').hide();
            $('#paytm').hide();
            $('#atom').hide();
            $('#razorpay').hide();
            $('#worldline').hide();
            $('#grezpay').hide();
            $('#merchant').show();
        } else if (vendorId == 'Grezpay') {
            $('#grezpay').show();
            $('#cashfree').hide();
            $('#paytm').hide();
            $('#atom').hide();
            $('#razorpay').hide();
            $('#payu').hide();
            $('#worldline').hide();
            $('#merchant').show();
        } else if (vendorId == 'Paytm') {
            $('#paytm').show();
            $('#atom').hide();
            $('#razorpay').hide();
            $('#cashfree').hide();
            $('#grezpay').hide();
            $('#payu').hide();
            $('#worldline').hide();
            $('#merchant').show();
        }

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            dataType: "json",
            url: '/rockpay/technical/merchantList',
            data: {
                'vendor_id': vendorId
            },
            success: function(data) {
                console.log(data);
                $("#merchant_options").html('');
                for (var i = 0; i < data.length; i++) {

                    var tr_str = `<option value=${data[i].id}>${data[i].name} </option>`;
                    console.log(i);
                    $("#merchant_options").append(tr_str);
                }



            }



        })
    })
</script>

<script>
    $('#deleteModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('id')
        var vendor = button.data('vendor')

        console.log(id, vendor);
        var modal = $(this)
        modal.find('#getId').val(id)
        modal.find('#vendor').val(vendor)

    })
</script>

<script>
    $('#showvendor').on('change', function() {
        var vendorId = $(this).val();
        console.log(vendorId);

        if (vendorId == 'Razorpay') {
            $('#razorpaytable').show();
            $('#cashfreetable').hide();
            $('#worldlinetable').hide();
            $('#payutable').hide();
            $('#paytmtable').hide();
            $('#atomtable').hide();
            $('#grezpaytable').hide();
            $('#shownotice').hide();
        } else if (vendorId == 'Worldline') {
            $('#razorpaytable').hide();
            $('#cashfreetable').hide();
            $('#worldlinetable').show();
            $('#payutable').hide();
            $('#paytmtable').hide();
            $('#atomtable').hide();
            $('#grezpaytable').hide();
            $('#shownotice').hide();
        } else if (vendorId == 'PayU') {
            $('#razorpaytable').hide();
            $('#cashfreetable').hide();
            $('#worldlinetable').hide();
            $('#payutable').show();
            $('#paytmtable').hide();
            $('#atomtable').hide();
            $('#grezpaytable').hide();
            $('#shownotice').hide();
        } else if (vendorId == 'Paytm') {
            $('#razorpaytable').hide();
            $('#cashfreetable').hide();
            $('#worldlinetable').hide();
            $('#payutable').hide();
            $('#paytmtable').show();
            $('#atomtable').hide();
            $('#grezpaytable').hide();
            $('#shownotice').hide();
        } else if (vendorId == 'Atom') {
            $('#razorpaytable').hide();
            $('#cashfreetable').hide();
            $('#worldlinetable').hide();
            $('#payutable').hide();
            $('#paytmtable').hide();
            $('#atomtable').show();
            $('#grezpaytable').hide();
            $('#shownotice').hide();
        } else if (vendorId == 'Grezpay') {
            $('#razorpaytable').hide();
            $('#cashfreetable').hide();
            $('#worldlinetable').hide();
            $('#payutable').hide();
            $('#paytmtable').hide();
            $('#atomtable').hide();
            $('#grezpaytable').show();
            $('#shownotice').hide();
        } else if (vendorId == 'CashFree') {
            $('#razorpaytable').hide();
            $('#cashfreetable').show();
            $('#worldlinetable').hide();
            $('#payutable').hide();
            $('#paytmtable').hide();
            $('#atomtable').hide();
            $('#grezpaytable').hide();
            $('#shownotice').hide();
        } else {
            $('#shownotice').show();
            $('#cashfreetable').hide();
            $('#razorpaytable').hide();
            $('#worldlinetable').hide();
            $('#payutable').hide();
            $('#paytmtable').hide();
            $('#atomtable').hide();
            $('#grezpaytable').hide();
        }
    })
</script>
@endsection