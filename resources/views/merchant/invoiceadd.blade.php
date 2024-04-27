@php
    use \App\Http\Controllers\MerchantController;
    use \App\Classes\InvoiceTax;

    $per_page = MerchantController::page_limit();
@endphp
@extends('layouts.merchantcontent')
@section('merchantcontent')
<div class="row">
    <div class="col-sm-12 padding-top-30">
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs" id="transaction-tabs">
                    <li class="active"><a data-toggle="tab" class="show-cursor" data-target="#addinvoice">New Invoice</a></li>
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div id="addinvoice" class="tab-pane fade in active">
                        <div class="row">
                            <div class="col-sm-12">
                                <a href="{{url('/merchant/invoices')}}" class="btn btn-primary btn-sm pull-right">Back</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="">
                                <div class="col-sm-offset-1 col-sm-10">
                                    <form class="form-horizontal" id="invoice-add-form">
                                        <div class="row padding-20">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="paymentfor">Invoice No:<span class="mandatory">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" name="invoice_receiptno" id="invoice_receiptno" value="{{$merchant_details['invoice_no']}}" placeholder="Invoice No"/>
                                                <div id="invoice_receiptno_error"></div>
                                            </div>
                                        </div>
                                        @if(!empty($merchant_details['info']))
                                        @foreach($merchant_details['info'] as $merchant)
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="paymentfor">Company:<span class="mandatory">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" name="merchant_company" id="merchant_company" value="{{$merchant->business_name!=''?$merchant->business_name:$merchant->pan_holder_name}}" placeholder="Company" readonly/>
                                                <div id="merchant_company_error"></div>
                                            </div>
                                            <label class="control-label col-sm-2" for="paymentfor">GSTIN:</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" name="merchant_gstno" id="merchant-add-gstno" value="{{($merchant->comp_gst!='')?$merchant->comp_gst:''}}" placeholder="GSTIN" onkeyup="ValidateMerchantGSTno('merchant-add-gstno','merchant-add-gstno_error')" readonly/>
                                                <div id="merchant-add-gstno_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="paymentfor">Pan No:<span class="mandatory">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" name="merchant_panno" id="merchant-add-panno" value="{{$merchant->mer_pan_number}}" placeholder="Pan Number" onkeyup="ValidatePAN('merchant-add-panno','merchant-add-panno-error')" readonly/>
                                                <div id="merchant-add-panno-error"></div>
                                            </div>
                                        @endforeach
                                        @endif
                                            <label class="control-label col-sm-2" for="paymentfor">Invoice Date:<span class="mandatory">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" name="invoice_issue_date" id="addinvoice_issue_date" value="{{date('d-m-Y')}}" placeholder="Invoice Date"/>
                                                <div id="invoice_issue_date_error"></div>
                                            </div>
                                        </div>
                                        <hr>
                                        <strong>Customer:</strong>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="paymentfor">Name:<span class="mandatory">*</span></label>
                                            <div class="col-sm-3">
                                                <select name="invoice_billing_to" id="invoice_billing_to" class="col-sm-12 form-control">
                                                </select>
                                                <div id="invoice_billing_to_error"></div>
                                            </div>
                                            <label class="control-label col-sm-2" for="paymentfor">GSTIN:</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" name="customer_gstno" id="customer_gstno" value="" placeholder="GSTIN" onkeyup="ValidateMerchantGSTno('customer_gstno','customer_gstno_error')"/>
                                                <div id="customer_gstno_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="paymentfor">Email:<span class="mandatory">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" name="customer_email" id="customer_email" value="" placeholder="Email" onkeyup="vaidateEmail('customer_email','customer_email_error')"/>
                                                <div id="customer_email_error"></div>
                                            </div>
                                            <label class="control-label col-sm-2" for="paymentfor">Phone:<span class="mandatory">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" name="customer_phone" id="customer_phone" value="" placeholder="Phone" onkeyup="validateMobile('customer_phone','customer_phone_error')" />
                                                <div id="customer_phone_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="paymentfor">Billing Address:<span class="mandatory">*</span></label>
                                            <div class="col-sm-3">
                                                <select name="invoice_billing_address" id="invoice_billing_address" class="col-sm-12 form-control">
                                                    <option value=' '>--Select--</option>
                                                </select>
                                                <div id="invoice_billing_address_error"></div>
                                            </div>
                                            <label class="control-label col-sm-2" for="paymentfor">Shipping Address:<span class="mandatory">*</span></label>
                                            <div class="col-sm-3">
                                                <select name="invoice_shipping_address" id="invoice_shipping_address" class="col-sm-12 form-control">
                                                    <option value=' '>--Select--</option>
                                                </select>
                                                <div id="invoice_shipping_address_error"></div>
                                            </div>
                                        </div>
                                        <div class="pull-right padding-20">
                                            <button id="add-invoice-items" class="btn btn-primary btn-sm">Add Items</button>
                                        </div>
                                        <hr>
                                        <strong>Items List:</strong>
                                        <div class="form-group" >
                                            <div class="col-sm-12">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Item Name</th>
                                                            <th>Item Price</th>
                                                            <th>Item Quantity</th>
                                                            <th colspan="2">Item Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="dynamic-item-list">
                                                        <tr id="invoice_item_row1">
                                                            <td>
                                                                <div class="col-sm-10">
                                                                    <select name="item_name[]" id="item_name1" class="form-control col-sm-12" onchange=itemCalculate(this); data-name-id='1'>
                                                                        <option value="">Select Name</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <div id="item_name1_error"></div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="col-sm-10">
                                                                    <input type="text" class="form-control input-sm only-btborder" name="item_amount[]" id="item_amount1" data-amount-id="1" value="" placeholder="Item Price" readonly/>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="col-sm-10">
                                                                    <input type="number" class="form-control input-sm only-btborder" name="item_quantity[]" id="item_quantity1" data-quantity-id="1" value="1" placeholder="Item Qty"/>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="col-sm-10">
                                                                    <input type="text" class="form-control input-sm only-btborder" name="item_total[]" id="item_total1" data-total-id="1" value="" placeholder="Item Total" readonly/>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="col-sm-10">
                                                                    <i class="fa fa-times show-cursor mandatory" onclick="removeInvoiceItem(this,'1');"></i>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="3" class="text-right">Sub Total</td>
                                                            <td><div class="col-sm-10"><input type="text"  class="form-control input-sm" name="invoice_subtotal" id="invoice_subtotal" readonly></div><span>&#8377;</span></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3" class="text-right">Tax</td>
                                                            <td><div class="col-sm-10"><input type="text"  class="form-control input-sm" name="invoice_tax_amount" id="invoice_tax_amount" readonly></div><span>&#8377;</span></td>
                                                            <td id="tax-variable"></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3" class="text-right">Total</td>
                                                            <td><div class="col-sm-10"> <input type="text"  class="form-control input-sm" name="invoice_amount" id="invoice_amount" readonly></div><span>&#8377;</span></td>
                                                            <td></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="textarea" class="col-sm-2 control-label">Terms & Condition:</label>
                                            <div class="col-sm-10">
                                                <textarea name="invoice_terms_cond" id="invoice_terms_cond" class="form-control" rows="3"></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="textarea" class="col-sm-2 control-label">Description:</label>
                                            <div class="col-sm-10">
                                                <textarea name="invoice_notes" id="invoice_notes" class="form-control" rows="3"></textarea>
                                            </div>
                                        </div>
                                        
                                        <input type="hidden" name="send_email" id="invoice-send-email" value="N">
                                        <input type="hidden" name="send_message" id="invoice-send-message" value="N">
                                        <input type="hidden" name="invoice_status" id="invoice_status" value="">
                                        <input type="hidden" name="outer_state" id="outer_state" value="{{ InvoiceTax::outer_state() }}">
                                        <input type="hidden" name="inner_state" id="inner_state" value="{{ InvoiceTax::inner_state() }}"> 
                                        <input type="hidden" name="tax_applied" id="tax_applied" value="">
                                        <input type="hidden" name="customer_state" value="">
                                        <input type="hidden" name="customer_gst_code" id="customer_gst_code" value="">
                                        <input type="hidden" name="merchant_state" value="{{ MerchantController::get_merchant_state() }}">
                                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                                        
                                    </form>
                                        <div class="col-sm-3 pull-right">
                                            <input type="submit" class="btn btn-primary btn-block" id="call-invoice-generate-modal" value="Generate Invoice">
                                        </div>
                                        <div class="col-sm-3 pull-right">
                                            <input type="submit" class="btn btn-primary btn-block" id="invoice-draft" value="Save As Draft" onclick="addInvoice('saved');">
                                        </div>
                                </div>
                            </div>
                            <!-- show personal details response modal starts-->
                            <div id="invoice-add-response-message-modal" class="modal">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <strong id="invoice-add-response"></strong>
                                        </div>
                                        <div class="modal-footer">
                                            <form>
                                                <input type="submit" class="btn btn-primary btn-sm" value="OK" onlick="location.reload();$('#personal-message-modal').modal('hide')"/>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Invoice send message or send mail modal starts-->
                            <div id="invoice-send-mail-message-modal" class="modal">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Generate Invoice</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <p class="text-center">choose an option to send invoice paylink to customer via</p>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="col-sm-6">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" value="" id="send-invoice-sms" >
                                                                <span class="cr" onclick="sendInvoiceSms()"><i class="cr-icon fa fa-check"></i></span>
                                                                Sms
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" value="" id="send-invoice-email" >
                                                                <span class="cr" onclick="sendInvoiceEmail()"><i class="cr-icon fa fa-check"></i></span>
                                                                Email
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" id="invoice-generate" data-dismiss="modal" class="btn btn-primary">Generate</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Invoice send message or send mail modal ends-->
                        </div>
                        <!-- Customer Add Modal -->
                        <div class="modal" id="add-customer-modal" role="dialog">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Add Customer</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div id="add-response-message" class="text-center"></div>
                                        <form class="form-horizontal" id="add-customer-form">
                                            <div class="form-group">
                                                <label class="control-label col-sm-3" for="name">Name:</label>
                                                <div class="col-sm-5">
                                                    <input type="text" class="form-control" id="customer-name" name="customer_name" placeholder="Enter Name">
                                                    <div id="customer-name-error" class="form-error"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-3" for="email">Email:</label>
                                                <div class="col-sm-5">          
                                                    <input type="text" class="form-control" id="customer-email" name="customer_email" placeholder="Enter Email" onkeyup="vaidateEmail('customer-email','custome-email-error')">
                                                    <div id="customer-email-error" class="form-error"></div>
                                                </div>
                                                
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-3" for="phone">Phone:</label>
                                                <div class="col-sm-5">          
                                                    <input type="text" class="form-control" id="customer-phone" name="customer_phone" placeholder="Enter Phone" onkeyup="validateMobile('customer-phone','customer-phone-error')">
                                                    <div id='customer-phone-error' class="form-error"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                            <label class="control-label col-sm-3" for="gstno">GSTNO:</label>
                                                <div class="col-sm-5">          
                                                    <input type="text" class="form-control" id="customer-gstno" name="customer_gstno" placeholder="Enter GSTNO" onkeyup="ValidateMerchantGSTno('customer-gstno','customer-gstno-error')">
                                                    <div id='customer-gstno-error' class="form-error"></div>
                                                </div>
                                            </div>
                                            {{ @csrf_field() }}
                                            <div class="form-group">        
                                                <div class="col-sm-offset-3 col-sm-5">
                                                    <button type="submit" class="btn btn-primary btn-block">Add</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Customer Address Add Modal -->
                        <div class="modal" id="add-customer-address-modal" role="dialog">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Customer Address</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div id="ajax-address-response-message" class="text-center"></div>
                                        <form class="form-horizontal" id="add-customer-address-form">
                                            <div class="form-group">
                                                <label class="control-label col-sm-3" for="name">Address:<span class="mandatory">*</span></label>
                                                <div class="col-sm-8">
                                                    <textarea name="address" id="address" cols="18" rows="3" class="form-control"></textarea>
                                                    <div id="address_error" class="form-error"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-3" for="name">City:<span class="mandatory">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="city" id="city" class="form-control" value="" onkeyup="validateName('city')">
                                                    <div id="city_error" class="form-error"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-3" for="name">Pincode:<span class="mandatory">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="pincode" id="pincode" class="form-control" value="" onkeyup="validatePincode('pincode','pincode_error')">
                                                    <div id="pincode_error" class="form-error"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-3" for="name">State:<span class="mandatory">*</span></label>
                                                <div class="col-sm-8">
                                                    <select name="state_id" id="state_id" class="form-control">
                                                        @foreach($invoices_pages['states'] as $state)
                                                            <option value="{{$state->id}}">{{$state->state_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div id="state_id_error" class="form-error"></div>
                                                </div>
                                            </div>
                                            {{ @csrf_field() }}
                                            <input type="hidden" name="customer_id" id="customer_id" value="">
                                            <div class="form-group">        
                                                <div class="col-sm-offset-3 col-sm-8">
                                                    <button type="submit" class="btn btn-primary btn-block">Add Address</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal" id="add-edit-customer-address-modal" role="dialog">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Add/Edit Customer Address</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div id="ajax-address-update-response-message" class="text-center"></div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div id="customer-address-list">
                                                    <table class="table table-bordered">
                                                        <tbody id="add-customer-address-list">

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <form class="form-horizontal" id="add-edit-customer-address-form">
                                            <div class="form-group">
                                                <label class="control-label col-sm-3" for="name">Address: <span class="mandatory">*</span></label>
                                                <div class="col-sm-5">
                                                    <textarea name="address" id="address" cols="24" rows="3" class="form-control"></textarea>
                                                    <div id="address_error" class="form-error"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-3" for="name">City:<span class="mandatory">*</span></label>
                                                <div class="col-sm-5">
                                                    <input type="text" name="city" id="city" class="form-control" onkeyup="validateName('city')">
                                                    <div id="city_error" class="form-error"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-3" for="name">Pincode:<span class="mandatory">*</span></label>
                                                <div class="col-sm-5">
                                                    <input type="text" name="pincode" id="pincode" class="form-control" onkeyup="validatePincode('pincode','pincode_error')">
                                                    <div id="pincode_error" class="form-error"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-3" for="name">State:<span class="mandatory">*</span></label>
                                                <div class="col-sm-5">
                                                    <select name="state_id" id="state_id" class="form-control">
                                                        <option value="">--Select--</option>
                                                        @foreach($invoices_pages['states'] as $state)
                                                            <option value="{{$state->id}}">{{$state->state_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div id="state_id_error" class="form-error"></div>
                                                </div>
                                            </div>
                                            {{ @csrf_field() }}
                                            <input type="hidden" name="customer_id" id="customer_id" value="">
                                            <input type="hidden" name="id" id="id" value="">
                                            <div class="form-group">        
                                                <div class="col-sm-offset-3 col-sm-5">
                                                    <button type="submit" class="btn btn-primary btn-block" id="change-button-label">Add Address</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Customer Address Delete modal starts-->
                        <div id="delete-customer-address-modal" class="modal">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        Are you sure? would you like to delete Customer Address&nbsp;<strong id="delte-item-name"></strong>?
                                    </div>
                                    <div class="modal-footer">
                                        <form id="customer-address-delete-form">
                                            <input type="hidden" name="id" value="">
                                            <input type="hidden" name="customer_id" value="">
                                            {{csrf_field()}}
                                            <input type="submit" class="btn btn-danger" value="Delete"/>
                                            <button type="button" data-dismiss="modal" class="btn btn-primary">Cancel</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Customer Address Delete modal ends-->
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded",function(){
        optionItems();
        optionCustomers();
    });
</script>
@endsection
