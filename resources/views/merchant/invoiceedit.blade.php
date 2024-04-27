@php
    use \App\Http\Controllers\MerchantController;
    use \App\Classes\InvoiceTax;
@endphp

{{-- @extends('merchant.invoices') --}}
@extends('layouts.merchantcontent')
@section('merchantcontent')
<div class="row padding-top-30">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs" id="transaction-tabs">
                    <li class="active"><a data-toggle="tab" class="show-cursor" data-target="#editinvoice">Edit Invoice</a></li>
                </ul>
            </div>
            <div class="panel-body">
                <div class="row padding-20">
                    <a href="/merchant/invoices" class="btn btn-primary pull-right btn-sm">Go Back</a>
                </div>
                <div id="editinvoice" class="tab-pane fade in active">
                    <div class="col-sm-offset-1 col-sm-10">
                        <form class="form-horizontal" id="invoice-edit-form"> 
                            <div class="row padding-20">
                            </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="paymentfor">Invoice No:<span class="mandatory">*</span></label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="invoice_receiptno" id="invoice_receiptno" value="{{$invoice_details['invoice_receiptno']}}" placeholder="Invoice No" readonly/>
                                        <div id="invoice_receiptno_error"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="paymentfor">Company:<span class="mandatory">*</span></label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="merchant_company" id="merchant_company" value="{{$invoice_details['merchant_company']}}" placeholder="Company" readonly/>
                                        <div id="merchant_company_error"></div>
                                    </div>
                                    <label class="control-label col-sm-2" for="paymentfor">GSTIN:</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="merchant_gstno" id="merchant_gstno" value="{{$invoice_details['merchant_gstno']}}" placeholder="GSTIN" readonly/>
                                        <div id="merchant_gstno_error"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="paymentfor">Pan No:<span class="mandatory">*</span></label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="merchant_panno" id="merchant-edit-panno" value="{{$invoice_details['merchant_panno']}}" placeholder="Pan Number" onkeyup="ValidatePAN('merchant-edit-panno','merchant-edit-panno-error')" readonly/>
                                        <div id="merchant-edit-panno-error"></div>
                                    </div>
                                    <label class="control-label col-sm-2" for="paymentfor">Invoice Date:<span class="mandatory">*</span></label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="invoice_issue_date" id="invoice_issue_date" value="{{$invoice_details['invoice_issue_date']}}" placeholder="Invoice Date"/>
                                        <div id="invoice_issue_date_error"></div>
                                    </div>
                                </div>
                                <hr>
                                <strong>Customer:</strong>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="paymentfor">Name:<span class="mandatory">*</span></label>
                                    <div class="col-sm-3">
                                        <select name="invoice_billing_to" id="invoice_billing_to" class="col-sm-12 form-control">
                                            <option value="">--Select--</option>
                                            @if(count($customers) > 0)
                                                @foreach($customers as $customer)
                                                    
                                                    @if($customer_details["customer_id"] == $customer->id)
                                                        <option value="{{$customer->id}}" selected>{{$customer->customer_name}}</option>
                                                    @else
                                                        <option value="{{$customer->id}}" >{{$customer->customer_name}}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                        <div id="invoice_billing_to_error"></div>
                                    </div>
                                    <label class="control-label col-sm-2" for="paymentfor">GSTIN:</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="customer_gstno" id="customer_gstno" value="{{$invoice_details['customer_gstno']}}" placeholder="GSTIN"/>
                                        <div id="customer_gstno_error"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="paymentfor">Email:<span class="mandatory">*</span></label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="customer_email" id="customer_email" value="{{$invoice_details['customer_email']}}" placeholder="Email"/>
                                        <div id="customer_email_error"></div>
                                    </div>
                                    <label class="control-label col-sm-2" for="paymentfor">Phone:<span class="mandatory">*</span></label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="customer_phone" id="customer_phone" value="{{$invoice_details['customer_phone']}}" placeholder="Phone"/>
                                        <div id="customer_phone_error"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="paymentfor">Billing Address:<span class="mandatory">*</span></label>
                                    <div class="col-sm-3">
                                        <select name="invoice_billing_address" id="invoice_billing_address" class="col-sm-12 form-control">
                                            <option value=''>--Select--</option>
                                            @if(count($customer_addresses) > 0)
                                                @foreach($customer_addresses as $address)
                                                    @if($invoice_details["invoice_billing_address"] == $address->id)
                                                        <option value="{{$address->id}}" selected>{{$address->address}}</option>
                                                    @else
                                                        <option value="{{$address->id}}" >{{$address->address}}</option>
                                                    @endif
                                                        <option value="new_address">+add new</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <div id="invoice_billing_address_error"></div>
                                    </div>
                                    <label class="control-label col-sm-2" for="paymentfor">Shipping Address:<span class="mandatory">*</span></label>
                                    <div class="col-sm-3">
                                        <select name="invoice_shipping_address" id="invoice_shipping_address" class="col-sm-12 form-control">
                                            <option value=''>--Select--</option>
                                            @if(count($customer_addresses) > 0)
                                                @foreach($customer_addresses as $address)
                                                    @if($invoice_details["invoice_shipping_address"] == $address->id)
                                                        <option value="{{$address->id}}" selected>{{$address->address}}</option>
                                                    @else
                                                        <option value="{{$address->id}}" >{{$address->address}}</option>
                                                    @endif
                                                        <option value="new_address">+add new</option>
                                                @endforeach
                                            @endif
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
                                                <td>Item Name</td>
                                                <td>Item Price</td>
                                                <td>Item Quantity</td>
                                                <td colspan="2">Item Total</td>
                                            </tr>
                                        </thead>
                                        <tbody id="dynamic-item-list">
                                            @if(count($items_details) > 0)
                                            @foreach($items_details as $index => $details)
                                                <tr id="invoice_item_row{{$index+1}}">
                                                    <td>
                                                        <div class="col-sm-10">
                                                            <select name="item_name[]" id="item_name{{$index+1}}" class="form-control col-sm-12" onchange="itemCalculate(this);" data-name-id='{{$index+1}}'>
                                                                <option value="">Select Name</option>
                                                                @if(count($items) > 0)
                                                                    @foreach($items as $item)
                                                                        @php
                                                                            $item_selected = false; 
                                                                        @endphp
                                                                        @if($item->id == $details['item_id'])
                                                                            @php
                                                                                $item_selected = true;
                                                                            @endphp
                                                                            <option value="{{$item->id}}" selected>{{$item->item_name}}</option>
                                                                        @else
                                                                            <option value="{{$item->id}}">{{$item->item_name}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div id="item_name1_error"></div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control input-sm only-btborder" name="item_amount[]" id="item_amount{{$index+1}}" data-amount-id="{{$index+1}}" value="{{$details['item_amount']}}" placeholder="Item Price" readonly/>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="col-sm-10">
                                                            <input type="number" class="form-control input-sm only-btborder" name="item_quantity[]" id="item_quantity{{$index+1}}" data-quantity-id="{{$index+1}}" value="{{$details['item_quantity']}}" placeholder="Item Qty"/>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control input-sm only-btborder" name="item_total[]" id="item_total{{$index+1}}" data-total-id="{{$index+1}}" value="{{$details['item_total']}}" placeholder="Item Total" readonly/>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="col-sm-10">
                                                            <i class="fa fa-times show-cursor mandatory" onclick="removeInvoiceItem(this,'1');"></i>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3" class="text-right">Sub Total</td>
                                                <td><div class="col-sm-10"><input type="text"  class="form-control input-sm" name="invoice_subtotal" id="invoice_subtotal" value="{{$invoice_details['invoice_subtotal']}}" readonly></div><span>&#8377;</span></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="text-right">Tax</td>
                                                <td><div class="col-sm-10"><input type="text"  class="form-control input-sm" name="invoice_tax_amount" id="invoice_tax_amount" value="{{$invoice_details['invoice_tax_amount']}}" readonly></div><span>&#8377;</span></td>
                                                <td id="tax-variable">{{$invoice_details['tax_applied']}}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="text-right">Total</td>
                                                <td><div class="col-sm-10"> <input type="text"  class="form-control input-sm" name="invoice_amount" id="invoice_amount" value="{{$invoice_details['invoice_amount']}}" readonly></div><span>&#8377;</span></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="textarea" class="col-sm-2 control-label">Terms & Condition:</label>
                                <div class="col-sm-10">
                                    <textarea name="invoice_terms_cond" id="invoice_terms_cond" class="form-control" rows="3">{{$invoice_details['invoice_terms_cond']}}</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="textarea" class="col-sm-2 control-label">Description:</label>
                                <div class="col-sm-10">
                                    <textarea name="invoice_notes" id="invoice_notes" class="form-control" rows="3">{{$invoice_details['invoice_notes']}}</textarea>
                                </div>
                            </div>
                            <input type="hidden" name="send_email" id="invoice-send-email" value="N">
                            <input type="hidden" name="send_message" id="invoice-send-message" value="N">
                            <input type="hidden" name="invoice_status" id="invoice_status" value="">
                            <input type="hidden" name="outer_state" id="outer_state" value="{{ InvoiceTax::outer_state() }}">
                            <input type="hidden" name="inner_state" id="inner_state" value="{{ InvoiceTax::inner_state() }}">
                            <input type="hidden" name="tax_applied" id="tax_applied" value="{{$invoice_details['tax_applied']}}">
                            <input type="hidden" name="customer_state" value="{{$customer_details['state_id']}}">
                            <input type="hidden" name="customer_gst_code" id="customer_gst_code" value="">
                            <input type="hidden" name="invoice_id" value="{{$invoice_details['id']}}">
                            <input type="hidden" name="merchant_state" value="{{ MerchantController::get_merchant_state() }}">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                        </form>
                        <div class="col-sm-3 pull-right">
                            <input type="submit" class="btn btn-primary btn-block" id="call-invoice-generate-modal" value="Generate Invoice">
                        </div>
                        <div class="col-sm-3 pull-right">
                            <input type="submit" class="btn btn-primary btn-block" id="invoice-draft" value="Save As Draft" onclick="updateInvoice('saved');">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Invoice Edit Response Model -->
<div id="invoice-update-response-message-modal" class="modal fade">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <strong id="invoice-update-response"></strong>
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
<div id="invoice-send-mail-message-modal" class="modal fade">
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
                    <form id="send-message-mail-form">
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
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="edit-invoice-generate" data-dismiss="modal" class="btn btn-primary">Generate</button>
            </div>
        </div>
    </div>
</div>
<!--Invoice send message or send mail modal ends-->
<!-- Customer Add Modal -->
<div class="modal fade" id="add-customer-modal" role="dialog">
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
                            <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Enter Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="email">Email:</label>
                        <div class="col-sm-5">          
                            <input type="text" class="form-control" id="customer_email" name="customer_email" placeholder="Enter Email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="phone">Phone:</label>
                        <div class="col-sm-5">          
                            <input type="text" class="form-control" id="customer_phone" name="customer_phone" placeholder="Enter Phone">
                        </div>
                    </div>
                    <div class="form-group">
                    <label class="control-label col-sm-3" for="gstno">GSTNO:</label>
                        <div class="col-sm-5">          
                            <input type="text" class="form-control" id="customer_gstno" name="customer_gstno" placeholder="Enter GSTNO">
                        </div>
                    </div>
                    {{ @csrf_field() }}
                    <div class="form-group">        
                        <div class="col-sm-offset-3 col-sm-4">
                            <button type="submit" class="btn btn-primary btn-block">Add</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Customer Address Add Modal Starts-->
<div class="modal fade" id="add-customer-address-modal" role="dialog">
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
                        <label class="control-label col-sm-3" for="name">Address:</label>
                        <div class="col-sm-8">
                            <textarea name="address" id="address" class="form-control" cols="18" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="name">City:</label>
                        <div class="col-sm-8">
                            <input type="text" name="city" id="city" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="name">Pincode:</label>
                        <div class="col-sm-8">
                            <input type="text" name="pincode" id="pincode" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="name">State:</label>
                        <div class="col-sm-8">
                            <select name="state_id" id="state_id" class="form-control">
                                @foreach($states as $state)
                                    <option value="{{$state->id}}">{{$state->state_name}}</option>
                                @endforeach
                            </select>
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
<!-- Customer Address Add Modal Ends-->
<!-- Customer Address Add/Edit Modal starts-->
<div class="modal fade" id="add-edit-customer-address-modal" role="dialog">
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
                        <label class="control-label col-sm-3" for="name">Address:</label>
                        <div class="col-sm-5">
                            <textarea name="address" id="address" cols="24" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="name">City:</label>
                        <div class="col-sm-5">
                            <input type="text" name="city" id="city" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="name">Pincode:</label>
                        <div class="col-sm-5">
                            <input type="text" name="pincode" id="pincode" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="name">State:</label>
                        <div class="col-sm-5">
                            <select name="state_id" id="state_id" class="form-control">
                                @foreach($states as $state)
                                    <option value="{{$state->id}}">{{$state->state_name}}</option>
                                @endforeach
                            </select>
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
<!-- Customer Address Add/Edit Modal Ends-->
<!-- Customer Address Delete modal starts-->
<div id="delete-customer-address-modal" class="modal fade">
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
<script>
    document.addEventListener("DOMContentLoaded",function(){
        optionItems();
        getStateGSTCode("{{$customer_details['state_id']}}");
    });
</script>
@endsection



            
            
            
            
            