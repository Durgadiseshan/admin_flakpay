@extends('layouts.employeecontent')
@section('employeecontent')
<div class="row">
    <div class="col-sm-12 padding-20">
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs" id="transaction-tabs">
                    <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#merchant-commercial">Merchant Commercial</a></li> 
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div id="merchant-commercial" class="tab-pane fade in active">
                        <div class="row">
                            <div class="col-sm-12">
                                <div id="paginate_merchantcommercial">

                                </div>
                            </div>
                        </div>
                        <div class="modal" id="merchant-commercial-modal">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title">Merchant Charges Form</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form id="merchant-commercial" class="form-horizontal" role="form" autocomplete="off">
                                            <div class="form-group form-fit">
                                                <label for="input" class="col-sm-3 control-label">Merchant Id:</label>
                                                <div class="col-sm-3">
                                                    <select name="merchant_id" id="merchant_id" class="form-control" required="required" readonly>
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
                                                    <input type="text" name="dc_visa" id="dc_visa" class="form-control" value="" required="required" readonly>
                                                    <div id="dc_visa_error" class="text-danger"></div>
                                                </div>
                                                <label for="input" class="col-sm-3 control-label">DC Master:<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="dc_master" id="dc_master" class="form-control" value="" required="required" readonly>
                                                    <div id="dc_master_error" class="text-danger"></div>
                                                </div>
                                            </div>                                                    
                                            <div class="form-group form-fit">
                                                <label for="input" class="col-sm-3 control-label">DC Rupay:<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="dc_rupay" id="dc_rupay" class="form-control" value="" required="required" readonly>
                                                    <div id="dc_rupay_error" class="text-danger"></div>
                                                </div>
                                                <label for="input" class="col-sm-3 control-label">CC Visa:<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="cc_visa" id="cc_visa" class="form-control" value="" required="required" readonly>
                                                    <div id="cc_visa_error" class="text-danger"></div>
                                                </div>
                                            </div>
                                            <div class="form-group form-fit">
                                                <label for="input" class="col-sm-3 control-label">CC Master:<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="cc_master" id="cc_master" class="form-control" value="" required="required" readonly>
                                                    <div id="cc_master_error" class="text-danger"></div>
                                                </div>
                                                <label for="input" class="col-sm-3 control-label">CC Rupay:<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="cc_rupay" id="cc_rupay" class="form-control" value="" required="required" readonly>
                                                    <div id="cc_rupay_error" class="text-danger"></div>
                                                </div>
                                            </div>
                                            <div class="form-group form-fit">
                                                <label for="input" class="col-sm-3 control-label">AMEX:<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="amex" id="amex" class="form-control" value="" required="required" readonly>
                                                    <div id="amex_error" class="text-danger"></div>
                                                </div>
                                                <label for="input" class="col-sm-3 control-label">UPI:<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="upi" id="upi" class="form-control" value="" required="required" readonly>
                                                    <div id="upi_error" class="text-danger"></div>
                                                </div>
                                            </div>
                                            <fieldset class="scheduler-border">
                                            <legend class="scheduler-border">Net Banking</legend>
                                            <div class="form-group form-fit">
                                                <label for="input" class="col-sm-3 control-label">SBI:<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="net_sbi" id="net_sbi" class="form-control" value="" required="required" readonly>
                                                    <div id="net_sbi_error" class="text-danger"></div>
                                                </div>
                                                <label for="input" class="col-sm-3 control-label">HDFC:<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="net_hdfc" id="net_hdfc" class="form-control" value="" required="required" readonly>
                                                    <div id="net_hdfc_error" class="text-danger"></div>
                                                </div>
                                            </div>
                                            <div class="form-group form-fit">
                                                <label for="input" class="col-sm-3 control-label">AXIS:<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="net_axis" id="net_axis" class="form-control" value="" required="required" readonly>
                                                    <div id="net_axis_error" class="text-danger"></div>
                                                </div>
                                                <label for="input" class="col-sm-3 control-label">ICICI:<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="net_icici" id="net_icici" class="form-control" value="" required="required" readonly>
                                                    <div id="net_icici_error" class="text-danger"></div>
                                                </div>
                                            </div>
                                            <div class="form-group form-fit">
                                                <label for="input" class="col-sm-3 control-label">YES/KOTAK:<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="net_yes_kotak" id="net_yes_kotak" class="form-control" value="" required="required" readonly>
                                                    <div id="net_yes_kotak_error" class="text-danger"></div>
                                                </div>
                                                <label for="input" class="col-sm-3 control-label">OTHERS:<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="net_others" id="net_others" class="form-control" value="" required="required" readonly>
                                                    <div id="net_others_error" class="text-danger"></div>
                                                </div>
                                            </div>
                                            </fieldset>
                                            <div class="form-group form-fit">
                                                <label for="input" class="col-sm-3 control-label">Wallet:<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="wallet" id="wallet" class="form-control" value="" required="required" readonly>
                                                    <div id="wallet_error" class="text-danger"></div>
                                                </div>
                                                <label for="input" class="col-sm-3 control-label">Debit ATM Pin:<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="dap" id="dap" class="form-control" value="" required="required" readonly>
                                                    <div id="dap_error" class="text-danger"></div>
                                                </div>
                                            </div>
                                            <div class="form-group form-fit">
                                                <label for="input" class="col-sm-3 control-label">QR Code:<span class="text-danger">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text" name="qrcode" id="qrcode" class="form-control" value="" required="required" readonly>
                                                    <div id="qrcode_error" class="text-danger"></div>
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
<script>
    document.addEventListener("DOMContentLoaded",function(){
        getMerchantCommercials();
    });
</script>
    
@endsection
