@php
    use \App\Classes\InvoiceTax;
    use App\State;

    $state_list = State::state_list();
@endphp
@extends('layouts.employeecontent')
@section('employeecontent')
<div class="row">
    <div class="col-sm-12 padding-20">
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs" id="transaction-tabs">
                    @if($form == "new")
                    <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#new-invoice">New Invoice</a></li>
                    @else
                        <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#edit-invoice">Edit Invoice</a></li>  
                    @endif
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    @if($form == "new")
                        <div id="new-invoice" class="tab-pane fade in active">
                            <div class="row">
                                <div class="col-sm-12">
                                    <a href="{{ url()->previous() }}" class="btn btn-primary pull-right">Go Back</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <form class="form-horizontal" id="invoice-add-form">
                                        <div class="row padding-20">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="paymentfor">Invoice No:<span class="mandatory">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" name="invoice_receiptno" id="invoice_receiptno" value="" placeholder="Invoice No"/>
                                                <div id="invoice_receiptno_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="paymentfor">Company:<span class="mandatory">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" name="company" id="company" value="" placeholder="Company"/>
                                                <div id="company_error"></div>
                                            </div>
                                            <label class="control-label col-sm-2" for="paymentfor">GSTIN:<span class="mandatory">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" name="gstno" id="gstno" value="" placeholder="GSTIN"/>
                                                <div id="gstno_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="paymentfor">Pan No:<span class="mandatory">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" name="panno" id="panno" value="" placeholder="Pan Number"/>
                                                <div id="panno_error"></div>
                                            </div>
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
                                                <input type="text" class="form-control" name="customer_gstno" id="customer_gstno" value="" placeholder="GSTIN"/>
                                                <div id="customer_gstno_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="paymentfor">Email:<span class="mandatory">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" name="customer_email" id="customer_email" value="" placeholder="Email"/>
                                                <div id="customer_email_error"></div>
                                            </div>
                                            <label class="control-label col-sm-2" for="paymentfor">Phone:<span class="mandatory">*</span></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" name="customer_phone" id="customer_phone" value="" placeholder="Phone"/>
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
                                        
                                        <input type="hidden" name="invoice_status" id="invoice_status" value="">
                                        <input type="hidden" name="outer_state" id="outer_state" value="{{ InvoiceTax::outer_state() }}">
                                        <input type="hidden" name="inner_state" id="inner_state" value="{{ InvoiceTax::inner_state() }}">
                                        <input type="hidden" name="tax_applied" id="tax_applied" value="">
                                        <input type="hidden" name="customer_state" value="">
                                        <input type="hidden" name="state" value="">
                                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                                        
                                    </form>
                                    <div class="col-sm-3 pull-right">
                                        <input type="submit" class="btn btn-primary btn-block" id="generate-invoice" value="Generate Invoice" onclick="addInvoice('issued');">
                                    </div>
                                    <div class="col-sm-3 pull-right">
                                        <input type="submit" class="btn btn-primary btn-block" id="invoice-draft" value="Save As Draft" onclick="addInvoice('saved');">
                                    </div>
                                </div>
                                <!-- show personal details response modal starts-->
                                <div id="invoice-add-response-message-modal" class="modal fade">
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
                            </div>
                        </div>
                    @else
                        <div id="edit-invoice" class="tab-pane fade in active">
                            <div class="row">
                                <div class="col-sm-12">
                                    <a href="{{ route('/rupayapay/account/invoice/','ryapay-d6zhbMJQ') }}" class="btn btn-primary pull-right">Go Back</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <form class="form-horizontal" id="invoice-edit-form">
                                        <div class="row padding-20">
                                        </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="paymentfor">Invoice No:<span class="mandatory">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" name="invoice_receiptno" id="invoice_receiptno" value="{{$invoice_details['invoice_receiptno']}}" placeholder="Invoice No"/>
                                                    <div id="invoice_receiptno_error"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="paymentfor">Company:<span class="mandatory">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" name="company" id="company" value="{{$invoice_details['company']}}" placeholder="Company"/>
                                                    <div id="company_error"></div>
                                                </div>
                                                <label class="control-label col-sm-2" for="paymentfor">GSTIN:<span class="mandatory">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" name="gstno" id="gstno" value="{{$invoice_details['gstno']}}" placeholder="GSTIN"/>
                                                    <div id="gstno_error"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="paymentfor">Pan No:<span class="mandatory">*</span></label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" name="panno" id="panno" value="{{$invoice_details['panno']}}" placeholder="Pan Number"/>
                                                    <div id="panno_error"></div>
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
                                                                        <select name="item_name[]" id="item_name{{$index+1}}" class="form-control col-sm-12" onchange=itemCalculate(this); data-name-id='{{$index+1}}'>
                                                                            <option value="">Select Name</option>
                                                                            @if(count($items) > 0)
                                                                                @foreach($items as $item)
                                                                                    @if($item->id == $details['item_id'])
                                                                                    <option value="{{$item->id}}" selected>{{$item->item_name}}</option>
                                                                                    @else
                                                                                    <option value="{{$item->id}}">{{$item->item_name}}</option>
                                                                                    @endif
                                                                                @endforeach
                                                                            @endif
                                                                        </select>
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
                
                                        <input type="hidden" name="invoice_status" id="invoice_status" value="">
                                        <input type="hidden" name="outer_state" id="outer_state" value="{{ InvoiceTax::outer_state() }}">
                                        <input type="hidden" name="inner_state" id="inner_state" value="{{ InvoiceTax::inner_state() }}">
                                        <input type="hidden" name="tax_applied" id="tax_applied" value="{{$invoice_details['tax_applied']}}">
                                        <input type="hidden" name="customer_state" value="{{$customer_details['state_id']}}">
                                        <input type="hidden" name="invoice_id" value="{{$invoice_details['id']}}">
                                        <input type="hidden" name="state" value="">
                                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    </form>
                                    <div class="col-sm-3 pull-right">
                                        <input type="submit" class="btn btn-primary btn-block" id="generate-invoice" value="Generate Invoice" onclick="updateInvoice('issued');">
                                    </div>
                                    <div class="col-sm-3 pull-right">
                                        <input type="submit" class="btn btn-primary btn-block" id="invoice-draft" value="Save As Draft" onclick="updateInvoice('saved');">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <!-- Customer Address Add Modal -->
                <div class="modal fade" id="add-customer-address-modal" role="dialog">
                    <div class="modal-dialog modal-sm">
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
                                            <textarea name="address" id="address" cols="18" rows="3"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="name">City:<span>*</span></label>
                                        <div class="col-sm-8">
                                            <input type="text" name="city" id="city" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="name">Pincode:<span>*</span></label>
                                        <div class="col-sm-8">
                                            <input type="text" name="pincode" id="pincode" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="name">State:<span>*</span></label>
                                        <div class="col-sm-8">
                                            <select name="state_id" id="state_id" class="form-control">
                                                @foreach($state_list as $state)
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
                <!-- Customer Address Add Edit modal starts-->
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
                                        <div class="col-sm-6">
                                            <textarea name="address" id="address" cols="24" rows="3" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="name">City:</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="city" id="city" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="name">Pincode:</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="pincode" id="pincode" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="name">State:</label>
                                        <div class="col-sm-6">
                                            <select name="state_id" id="state_id" class="form-control">
                                                @foreach($state_list as $state)
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
                <!-- Customer Address Add Edit modal ends-->
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
                </div>
            </div>
        </div>    
    </div>
</div>
@endsection
<script>
    document.addEventListener("DOMContentLoaded", function() {
        optionItems();
        optionCustomers();
    });
</script>
