@php
    use App\RyaPayCustomer;
    use App\State;
    use App\Http\Controllers\EmployeeController;

    $customers = RyaPayCustomer::get_cust_opts();
    $states = State::state_list();
    $item_options = EmployeeController::porder_items_options();
@endphp
@extends('layouts.employeecontent')
@section('employeecontent')
<div class="row">
    <div class="col-sm-12 padding-20">
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs" id="transaction-tabs">
                    @if($form == "create")
                    <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#sales-order">New sales Order</a></li> 
                    @else
                    <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#sales-order">Edit sales Order</a></li> 
                    @endif
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div id="sales-order" class="tab-pane fade in active">
                        <div class="row">
                            <div class="col-sm-12">
                                <a href="{{route('account-receivable','ryapay-VfWlmhwZ')}}" class="btn btn-primary pull-right btn-sm">Go Back</a>
                            </div>
                        </div>
                        @if($form == "create")
                       <div class="row">
                           <div class="col-sm-12">
                                <form method="POST" class="form-horizontal" role="form" id="sales-order-form">

                                    <div class="row">
                                        <div class="col-sm-6">
                                            
                                            <div class="form-group">
                                                <label for="input" class="col-sm-3 control-label">Customer</label>
                                                <div class="col-sm-6">
                                                    <select name="customer_id" id="customer_id" class="form-control" onchange="setCustomerValues(this);">
                                                        <option value="">--Select--</option>
                                                        @foreach($customers as $customer)
                                                            <option value="{{$customer->id}}">{{$customer->customer_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div id="customer_id_error"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-3 control-label">Email:</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="customer_email" id="customer_email" class="form-control" value="">
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="input" class="col-sm-3 control-label">Phone:</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="customer_phone" id="customer_phone" class="form-control" value="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-3 control-label">Contact Name:</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="customer_name" id="customer_name" class="form-control" value="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="input" class="col-sm-4 control-label">Sales Order No:</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="sorder_no" id="sorder_no" class="form-control" value="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-4 control-label">Sales Order Date:</label>
                                                <div class="col-sm-6">
                                                    <div class="input-group date">
                                                        <input type="text" name="sorder_date" id="sorder_date" class="form-control" value="" placeholder="YY-MM-DD">
                                                        <span class="input-group-addon"><span class="fa fa-calendar show-pointer" onclick="($('#sorder_date')).focus();"></span></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-4 control-label">Sales Order Due</label>
                                                <div class="col-sm-6">
                                                    <div class="input-group date">
                                                        <input type="text" name="sorder_due" id="sorder_due" class="form-control" value="" placeholder="YY-MM-DD">
                                                        <span class="input-group-addon"><span class="fa fa-calendar show-pointer" onclick="($('#sorder_due')).focus();"></span></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row padding-20">
                                        <div class="col-sm-6">
                                            
                                            <div class="form-group">
                                                <label for="input" class="col-sm-3 control-label">Billing Street:</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="sorder_bill_street" id="sorder_bill_street" class="form-control" value="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-3 control-label">Billing city:</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="sorder_bill_city" id="sorder_bill_city" class="form-control" value="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-3 control-label">Billing state:</label>
                                                <div class="col-sm-6">
                                                    <select name="sorder_bill_state" id="sorder_bill_state" class="form-control">
                                                        <option value="">--Select--</option>
                                                        @foreach($states as $state)
                                                            <option value="{{$state->id}}">{{$state->state_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-3 control-label">Billing Country:</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="sorder_bill_country" id="sorder_bill_country" class="form-control" value="" >
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="input" class="col-sm-4 control-label">Shipping Street:</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="sorder_ship_street" id="sorder_ship_street" class="form-control" value="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-4 control-label">Shipping city:</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="sorder_ship_city" id="sorder_ship_city" class="form-control" value="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-4 control-label">Shipping state:</label>
                                                <div class="col-sm-6">
                                                    <select name="sorder_ship_state" id="sorder_ship_state" class="form-control">
                                                        <option value="">--Select--</option>
                                                        @foreach($states as $state)
                                                            <option value="{{$state->id}}">{{$state->state_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-4 control-label">Shipping Country:</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="sorder_ship_country" id="sorder_ship_country" class="form-control" value="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                
                                    <div class="row padding-20">
                                        <div class="col-sm-6">
                                            <strong>Product Details</strong>
                                        </div>
                                        <div class="col-sm-6">
                                            <button type="button" class="btn btn-primary btn-sm pull-right" onclick="loadSorderNewItem();">Add Items</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Sno</th>
                                                            <th>Product Name</th>
                                                            <th>Product Price</th>
                                                            <th>Product Quantity</th>
                                                            <th>Product Total</th> 
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="sorder-items">
                                                        <tr id="sord_item_row_1" data-row="1">
                                                            <td>1</td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <div class="col-sm-12">
                                                                        <select name="item_id[]" id="sorder_item_name_1" class="form-control" onchange="setSorderItemPrice('1',this);">                                                                            
                                                                        </select>
                                                                        <div id="sorder_item_name_error_1"></div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <div class="col-sm-12">
                                                                        <input type="text" name="item_amount[]" id="sorder_item_price_1" class="form-control" value="">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <div class="col-sm-12">
                                                                        <input type="number" name="item_quantity[]" id="sorder_item_qty_1" class="form-control" min="1" value="1" onchange="loadSorderItemtotal();">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <div class="col-sm-12">
                                                                        <input type="text" name="item_total[]" id="sorder_item_total_1" class="form-control" value="">
                                                                    </div>
                                                                </div>                                                                
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <div class="col-sm-12">
                                                                        <i class="fa fa-times fa-lg text-danger show-pointer" id="sorder_item_remove_1" onclick="sorderdRemoveItem('1')"></i>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                            <tr>
                                                                <td colspan=3></td>
                                                                <td>SubTotal</td>
                                                                <td id="sales-order-subtotal">0.00</td>
                                                                <input type="hidden" name="sorder_subtotal" id="sorder_subtotal" value="">
                                                            </tr>
                                                            <tr>
                                                                <td colspan=3></td>
                                                                <td>Tax</td>
                                                                <td id="sales-order-tax">0.00</td>
                                                                <input type="hidden" name="sorder_tax" id="sorder_tax" value="">
                                                            </tr>
                                                            <tr>
                                                                <td colspan=3></td>
                                                                <td>Total</td>
                                                                <td id="sales-order-total">0.00</td>
                                                                <input type="hidden" name="sorder_total" id="sorder_total" value="">
                                                            </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="textarea" class="col-sm-2 control-label">Terms & Condition:</label>
                                                <div class="col-sm-6">
                                                    <textarea name="sorder_terms_cond" id="textarea" class="form-control" rows="3" cols="25"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="textarea" class="col-sm-2 control-label">Description:</label>
                                                <div class="col-sm-6">
                                                    <textarea name="sorder_description" id="textarea" class="form-control" rows="3" cols="25"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{csrf_field()}}
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-sm-2 col-sm-offset-7">
                                                <input type="submit" id="sorder_save" class="btn btn-primary btn-block" value="Save"/>
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="submit" id="sorder_generate" class="btn btn-primary btn-block" value="Generate"/>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                           </div>
                       </div>
                       @else
                        <div class="row">
                            <div class="col-sm-12">
                                <form method="POST" class="form-horizontal" role="form" id="edit-sales-order-form">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="input" class="col-sm-3 control-label">Customer</label>
                                                <div class="col-sm-6"> 
                                                    <select name="customer_id" id="customer_id" class="form-control" onchange="setCustomerValues(this);">
                                                        <option value="">--Select--</option>
                                                        @foreach($customers as $customer)
                                                            @if($edit_data["customer_id"] == $customer->id) 
                                                            <option value="{{$customer->id}}" selected>{{$customer->customer_name}}</option>
                                                            @else
                                                            <option value="{{$customer->id}}">{{$customer->customer_name}}</option> 
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-3 control-label">Email:</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="customer_email" id="customer_email" class="form-control" value="{{$edit_data['customer_email']}}">
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="input" class="col-sm-3 control-label">Phone:</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="customer_phone" id="customer_phone" class="form-control" value="{{$edit_data['customer_phone']}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="input" class="col-sm-4 control-label">sales Order No:</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="sorder_no" id="sorder_no" class="form-control" value="{{$edit_data['sorder_no']}}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-4 control-label">sales Order Date:</label>
                                                <div class="col-sm-6">
                                                    <div class="input-group date">
                                                        <input type="text" name="sorder_date" id="sorder_date" class="form-control" value="{{$edit_data['sorder_date']}}" placeholder="YY-MM-DD">
                                                        <span class="input-group-addon"><span class="fa fa-calendar show-pointer" onclick="($('#sorder_date')).focus();"></span></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-4 control-label">sales Order Due</label>
                                                <div class="col-sm-6">
                                                    <div class="input-group date">
                                                        <input type="text" name="sorder_due" id="sorder_due" class="form-control" value="{{$edit_data['sorder_due']}}" placeholder="YY-MM-DD">
                                                        <span class="input-group-addon"><span class="fa fa-calendar show-pointer" onclick="($('#sorder_due')).focus();"></span></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-4 control-label">Contact Name:</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="customer_name" id="customer_name" class="form-control" value="{{$edit_data['customer_name']}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row padding-20">
                                        <div class="col-sm-6">
                                            
                                            <div class="form-group">
                                                <label for="input" class="col-sm-3 control-label">Billing Street:</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="sorder_bill_street" id="sorder_bill_street" class="form-control" value="{{$edit_data['sorder_bill_street']}}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-3 control-label">Billing city:</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="sorder_bill_city" id="sorder_bill_city" class="form-control" value="{{$edit_data['sorder_bill_city']}}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-3 control-label">Billing state:</label>
                                                <div class="col-sm-6">
                                                    <select name="sorder_bill_state" id="sorder_bill_state" class="form-control">
                                                        @foreach($states as $state)
                                                            @if($edit_data['sorder_bill_state'] == $state->id)
                                                                <option value="{{$state->id}}" selected>{{$state->state_name}}</option>
                                                            @else
                                                                <option value="{{$state->id}}">{{$state->state_name}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-3 control-label">Billing Country:</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="sorder_bill_country" id="sorder_bill_country" class="form-control" value="{{$edit_data['sorder_bill_country']}}" >
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="input" class="col-sm-4 control-label">Shipping Street:</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="sorder_ship_street" id="sorder_ship_street" class="form-control" value="{{$edit_data['sorder_ship_street']}}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-4 control-label">Shipping city:</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="sorder_ship_city" id="sorder_ship_city" class="form-control" value="{{$edit_data['sorder_ship_city']}}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-4 control-label">Shipping state:</label>
                                                <div class="col-sm-6">
                                                    <select name="sorder_ship_state" id="sorder_ship_state" class="form-control">
                                                        <option value="">--Select--</option>
                                                            @foreach($states as $state)
                                                                @if($state->id == $edit_data['sorder_ship_state'])
                                                                    <option value="{{$state->id}}" selected>{{$state->state_name}}</option>
                                                                @else
                                                                    <option value="{{$state->id}}">{{$state->state_name}}</option>
                                                                @endif
                                                            @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-4 control-label">Shipping Country:</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="sorder_ship_country" id="sorder_ship_country" class="form-control" value="{{$edit_data['sorder_ship_country']}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                
                                    <div class="row padding-20">
                                        <div class="col-sm-6">
                                            <strong>Product Details</strong>
                                        </div>
                                        <div class="col-sm-6">
                                            <button type="button" class="btn btn-primary btn-sm pull-right" onclick="loadSorderNewItem();">Add Items</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Sno</th>
                                                            <th>Product Name</th>
                                                            <th>Product Price</th>
                                                            <th>Product Quantity</th>
                                                            <th>Product Total</th> 
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="sorder-items">
                                                        @foreach($edit_data['items'] as $index => $item)
                                                        <tr id="sord_item_row_{{$index+1}}" data-row="{{$index+1}}">
                                                            <td>{{$index+1}}</td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <div class="col-sm-12">
                                                                        <select name="item_id[]" id="sorder_item_name_{{$index+1}}" class="form-control" onchange="setItemPrice('{{$index+1}}',this);">                                                                            
                                                                            @foreach($item_options as $options)
                                                                                @if($options->id == $item['item_id'])
                                                                                    <option value="{{$options->id}}" selected>{{$options->item_name}}</option>
                                                                                @else
                                                                                    <option value="{{$options->id}}">{{$options->item_name}}</option>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
                                                                        <div id="sorder_item_name_error_{{$index+1}}"></div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <div class="col-sm-12">
                                                                        <input type="text" name="item_amount[]" id="sorder_item_price_{{$index+1}}" class="form-control" value="{{$item['item_amount']}}">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <div class="col-sm-12">
                                                                        <input type="number" name="item_quantity[]" id="sorder_item_qty_{{$index+1}}" class="form-control" min="1" onchange="loadPorderItemtotal();" value="{{$item['item_quantity']}}">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <div class="col-sm-12">
                                                                        <input type="text" name="item_total[]" id="sorder_item_total_{{$index+1}}" class="form-control" value="{{$item['item_total']}}">
                                                                    </div>
                                                                </div>                                                                
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <div class="col-sm-12">
                                                                        <i class="fa fa-times fa-lg text-danger show-pointer" id="sorder_item_remove_{{$index+1}}" onclick="sorderdRemoveItem('{{$index+1}}')"></i>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                            <tr>
                                                                <td colspan=3></td>
                                                                <td>SubTotal</td>
                                                                <td id="sales-order-subtotal">{{$edit_data['sorder_subtotal']}}</td>
                                                                <input type="hidden" name="sorder_subtotal" id="sorder_subtotal" value="{{$edit_data['sorder_subtotal']}}">
                                                            </tr>
                                                            <tr>
                                                                <td colspan=3></td>
                                                                <td>Tax</td>
                                                                <td id="sales-order-tax">{{$edit_data['sorder_tax']}}</td>
                                                                <input type="hidden" name="sorder_tax" id="sorder_tax" value="{{$edit_data['sorder_tax']}}">
                                                            </tr>
                                                            <tr>
                                                                <td colspan=3></td>
                                                                <td>Total</td>
                                                                <td id="sales-order-total">{{$edit_data['sorder_total']}}</td>
                                                                <input type="hidden" name="sorder_total" id="sorder_total" value="{{$edit_data['sorder_total']}}">
                                                            </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="textarea" class="col-sm-2 control-label">Terms & Condition:</label>
                                                <div class="col-sm-6">
                                                    <textarea name="sorder_terms_cond" id="textarea" class="form-control" rows="3" cols="25">{{$edit_data['sorder_terms_cond']}}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="textarea" class="col-sm-2 control-label">Description:</label>
                                                <div class="col-sm-6">
                                                    <textarea name="sorder_description" id="textarea" class="form-control" rows="3" cols="25">{{$edit_data['sorder_description']}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="id" id="id" value="{{$edit_data['id']}}">
                                    {{csrf_field()}}
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-sm-2 col-sm-offset-7">
                                                <input type="submit" id="sorder_save" class="btn btn-primary btn-block" value="Save"/>
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="submit" id="sorder_generate" class="btn btn-primary btn-block" value="Generate"/>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                       @endif
                        <!-- Porder created modal starts-->
                        <div id="sorder-add-response-message-modal" class="modal fade">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <strong id="sorder-add-response"></strong>
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
        getItems();           
    });
</script>
@endsection
