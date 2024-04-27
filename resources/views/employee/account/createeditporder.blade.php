@php
    use App\RyapaySupplier;
    use App\State;
    use App\Http\Controllers\EmployeeController;

    $suppliers = RyapaySupplier::get_sup_opts();
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
                    <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#purchase-order">New Purchase Order</a></li> 
                    @else
                    <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#purchase-order">Edit Purchase Order</a></li> 
                    @endif
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div id="purchase-order" class="tab-pane fade in active">
                        <div class="row">
                            <div class="col-sm-12">
                                <a href="{{route('account-payable','ryapay-XYFGXwnY')}}" class="btn btn-primary pull-right">Go Back</a>
                            </div>
                        </div>
                        @if($form == "create")
                       <div class="row">
                           <div class="col-sm-12">
                                <form method="POST" class="form-horizontal" role="form" id="purchase-order-form">

                                    <div class="row">
                                        <div class="col-sm-6">
                                            
                                            <div class="form-group">
                                                <label for="input" class="col-sm-3 control-label">Supplier</label>
                                                <div class="col-sm-6">
                                                    <select name="supplier_id" id="supplier_id" class="form-control" onchange="setSupplierValues(this);">
                                                        <option value="">--Select--</option>
                                                        @foreach($suppliers as $supplier)
                                                            <option value="{{$supplier->id}}">{{$supplier->supplier_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div id="supplier_id_error"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-3 control-label">Email:</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="supplier_email" id="supplier_email" class="form-control" value="">
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="input" class="col-sm-3 control-label">Phone:</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="supplier_phone" id="supplier_phone" class="form-control" value="">
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="textarea" class="col-sm-3 control-label">Address:</label>
                                                <div class="col-sm-6">
                                                    <textarea name="supplier_address" id="supplier_address" class="form-control" rows="3"></textarea>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="input" class="col-sm-4 control-label">Company Name</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="supplier_company" id="supplier_company" class="form-control" value="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-4 control-label">Purchase Order No:</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="porder_no" id="porder_no" class="form-control" value="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-4 control-label">Purchase Order Date:</label>
                                                <div class="col-sm-6">
                                                    <div class="input-group date">
                                                        <input type="text" name="porder_date" id="porder_date" class="form-control" value="" placeholder="YY-MM-DD">
                                                        <span class="input-group-addon"><span class="fa fa-calendar show-pointer" onclick="($('#porder_date')).focus();"></span></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-4 control-label">Purchase Order Due</label>
                                                <div class="col-sm-6">
                                                    <div class="input-group date">
                                                        <input type="text" name="porder_due" id="porder_due" class="form-control" value="" placeholder="YY-MM-DD">
                                                        <span class="input-group-addon"><span class="fa fa-calendar show-pointer" onclick="($('#porder_due')).focus();"></span></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-4 control-label">Contact Name:</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="supplier_name" id="supplier_name" class="form-control" value="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row padding-20">
                                        <div class="col-sm-6">
                                            
                                            <div class="form-group">
                                                <label for="input" class="col-sm-3 control-label">Billing Street:</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="porder_bill_street" id="porder_bill_street" class="form-control" value="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-3 control-label">Billing city:</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="porder_bill_city" id="porder_bill_city" class="form-control" value="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-3 control-label">Billing state:</label>
                                                <div class="col-sm-6">
                                                    <select name="porder_bill_state" id="porder_bill_state" class="form-control">
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
                                                    <input type="text" name="porder_bill_country" id="porder_bill_country" class="form-control" value="" >
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="input" class="col-sm-4 control-label">Shipping Street:</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="porder_ship_street" id="porder_ship_street" class="form-control" value="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-4 control-label">Shipping city:</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="porder_ship_city" id="porder_ship_city" class="form-control" value="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-4 control-label">Shipping state:</label>
                                                <div class="col-sm-6">
                                                    <select name="porder_ship_state" id="porder_ship_state" class="form-control">
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
                                                    <input type="text" name="porder_ship_country" id="porder_ship_country" class="form-control" value="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                
                                    <div class="row padding-20">
                                        <div class="col-sm-6">
                                            <strong>Product Details</strong>
                                        </div>
                                        <div class="col-sm-6">
                                            <button type="button" class="btn btn-primary btn-sm pull-right" onclick="loadPorderNewItem();">Add Items</button>
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
                                                    <tbody id="porder-items">
                                                        <tr id="prod_item_row_1" data-row="1">
                                                            <td>1</td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <div class="col-sm-12">
                                                                        <select name="item_id[]" id="porder_item_name_1" class="form-control" onchange="setItemPrice('1',this);">                                                                            
                                                                        </select>
                                                                        <div id="porder_item_name_error_1"></div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <div class="col-sm-12">
                                                                        <input type="text" name="item_amount[]" id="porder_item_price_1" class="form-control" value="">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <div class="col-sm-12">
                                                                        <input type="number" name="item_quantity[]" id="porder_item_qty_1" class="form-control" min="1" value="1" onchange="loadPorderItemtotal();">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <div class="col-sm-12">
                                                                        <input type="text" name="item_total[]" id="porder_item_total_1" class="form-control" value="">
                                                                    </div>
                                                                </div>                                                                
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <div class="col-sm-12">
                                                                        <i class="fa fa-times fa-lg text-danger show-pointer" id="porder_item_remove_1" onclick="prodRemoveItem('1')"></i>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                            <tr>
                                                                <td colspan=3></td>
                                                                <td>SubTotal</td>
                                                                <td id="purchase-order-subtotal">0.00</td>
                                                                <input type="hidden" name="porder_subtotal" id="porder_subtotal" value="">
                                                            </tr>
                                                            <tr>
                                                                <td colspan=3></td>
                                                                <td>Tax</td>
                                                                <td id="purchase-order-tax">0.00</td>
                                                                <input type="hidden" name="porder_tax" id="porder_tax" value="">
                                                            </tr>
                                                            <tr>
                                                                <td colspan=3></td>
                                                                <td>Total</td>
                                                                <td id="purchase-order-total">0.00</td>
                                                                <input type="hidden" name="porder_total" id="porder_total" value="">
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
                                                    <textarea name="porder_terms_cond" id="textarea" class="form-control" rows="3" cols="25"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="textarea" class="col-sm-2 control-label">Description:</label>
                                                <div class="col-sm-6">
                                                    <textarea name="porder_description" id="textarea" class="form-control" rows="3" cols="25"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{csrf_field()}}
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-sm-2 col-sm-offset-7">
                                                <input type="submit" id="porder_save" class="btn btn-primary btn-block" value="Save"/>
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="submit" id="porder_generate" class="btn btn-primary btn-block" value="Generate"/>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                           </div>
                       </div>
                       @else
                        <div class="row">
                            <div class="col-sm-12">
                                <form method="POST" class="form-horizontal" role="form" id="edit-purchase-order-form">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="input" class="col-sm-3 control-label">Supplier</label>
                                                <div class="col-sm-6"> 
                                                    <select name="supplier_id" id="supplier_id" class="form-control" onchange="setSupplierValues(this);">
                                                        <option value="">--Select--</option>
                                                        @foreach($suppliers as $supplier)
                                                            @if($edit_data["supplier_id"] == $supplier->id) 
                                                            <option value="{{$supplier->id}}" selected>{{$supplier->supplier_name}}</option>
                                                            @else
                                                            <option value="{{$supplier->id}}">{{$supplier->supplier_name}}</option> 
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-3 control-label">Email:</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="supplier_email" id="supplier_email" class="form-control" value="{{$edit_data['supplier_email']}}">
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="input" class="col-sm-3 control-label">Phone:</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="supplier_phone" id="supplier_phone" class="form-control" value="{{$edit_data['supplier_phone']}}">
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="textarea" class="col-sm-3 control-label">Address:</label>
                                                <div class="col-sm-6">
                                                    <textarea name="supplier_address" id="supplier_address" class="form-control" rows="3">{{$edit_data['supplier_address']}}</textarea>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="input" class="col-sm-4 control-label">Company Name</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="supplier_company" id="supplier_company" class="form-control" value="{{$edit_data['supplier_company']}}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-4 control-label">Purchase Order No:</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="porder_no" id="porder_no" class="form-control" value="{{$edit_data['porder_no']}}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-4 control-label">Purchase Order Date:</label>
                                                <div class="col-sm-6">
                                                    <div class="input-group date">
                                                        <input type="text" name="porder_date" id="porder_date" class="form-control" value="{{$edit_data['porder_date']}}" placeholder="YY-MM-DD">
                                                        <span class="input-group-addon"><span class="fa fa-calendar show-pointer" onclick="($('#porder_date')).focus();"></span></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-4 control-label">Purchase Order Due</label>
                                                <div class="col-sm-6">
                                                    <div class="input-group date">
                                                        <input type="text" name="porder_due" id="porder_due" class="form-control" value="{{$edit_data['porder_due']}}" placeholder="YY-MM-DD">
                                                        <span class="input-group-addon"><span class="fa fa-calendar show-pointer" onclick="($('#porder_due')).focus();"></span></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-4 control-label">Contact Name:</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="supplier_name" id="supplier_name" class="form-control" value="{{$edit_data['supplier_name']}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row padding-20">
                                        <div class="col-sm-6">
                                            
                                            <div class="form-group">
                                                <label for="input" class="col-sm-3 control-label">Billing Street:</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="porder_bill_street" id="porder_bill_street" class="form-control" value="{{$edit_data['porder_bill_street']}}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-3 control-label">Billing city:</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="porder_bill_city" id="porder_bill_city" class="form-control" value="{{$edit_data['porder_bill_city']}}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-3 control-label">Billing state:</label>
                                                <div class="col-sm-6">
                                                    <select name="porder_bill_state" id="porder_bill_state" class="form-control">
                                                        @foreach($states as $state)
                                                            @if($edit_data['porder_bill_state'] == $state->id)
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
                                                    <input type="text" name="porder_bill_country" id="porder_bill_country" class="form-control" value="{{$edit_data['porder_bill_country']}}" >
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="input" class="col-sm-4 control-label">Shipping Street:</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="porder_ship_street" id="porder_ship_street" class="form-control" value="{{$edit_data['porder_ship_street']}}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-4 control-label">Shipping city:</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="porder_ship_city" id="porder_ship_city" class="form-control" value="{{$edit_data['porder_ship_city']}}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-4 control-label">Shipping state:</label>
                                                <div class="col-sm-6">
                                                    <select name="porder_ship_state" id="porder_ship_state" class="form-control">
                                                        <option value="">--Select--</option>
                                                            @foreach($states as $state)
                                                                @if($state->id == $edit_data['porder_ship_state'])
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
                                                    <input type="text" name="porder_ship_street" id="porder_ship_street" class="form-control" value="{{$edit_data['porder_ship_street']}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                
                                    <div class="row padding-20">
                                        <div class="col-sm-6">
                                            <strong>Product Details</strong>
                                        </div>
                                        <div class="col-sm-6">
                                            <button type="button" class="btn btn-primary btn-sm pull-right" onclick="loadPorderNewItem();">Add Items</button>
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
                                                    <tbody id="porder-items">
                                                        @foreach($edit_data['items'] as $index => $item)
                                                        <tr id="prod_item_row_{{$index+1}}" data-row="{{$index+1}}">
                                                            <td>{{$index+1}}</td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <div class="col-sm-12">
                                                                        <select name="item_id[]" id="porder_item_name_{{$index+1}}" class="form-control" onchange="setItemPrice('{{$index+1}}',this);">                                                                            
                                                                            @foreach($item_options as $options)
                                                                                @if($options->id == $item['item_id'])
                                                                                    <option value="{{$options->id}}" selected>{{$options->item_name}}</option>
                                                                                @else
                                                                                    <option value="{{$options->id}}">{{$options->item_name}}</option>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
                                                                        <div id="porder_item_name_error_{{$index+1}}"></div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <div class="col-sm-12">
                                                                        <input type="text" name="item_amount[]" id="porder_item_price_{{$index+1}}" class="form-control" value="{{$item['item_amount']}}">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <div class="col-sm-12">
                                                                        <input type="number" name="item_quantity[]" id="porder_item_qty_{{$index+1}}" class="form-control" min="1" onchange="loadPorderItemtotal();" value="{{$item['item_quantity']}}">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <div class="col-sm-12">
                                                                        <input type="text" name="item_total[]" id="porder_item_total_{{$index+1}}" class="form-control" value="{{$item['item_total']}}">
                                                                    </div>
                                                                </div>                                                                
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <div class="col-sm-12">
                                                                        <i class="fa fa-times fa-lg text-danger show-pointer" id="porder_item_remove_{{$index+1}}" onclick="prodRemoveItem('{{$index+1}}')"></i>
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
                                                                <td id="purchase-order-subtotal">{{$edit_data['porder_subtotal']}}</td>
                                                                <input type="hidden" name="porder_subtotal" id="porder_subtotal" value="{{$edit_data['porder_subtotal']}}">
                                                            </tr>
                                                            <tr>
                                                                <td colspan=3></td>
                                                                <td>Tax</td>
                                                                <td id="purchase-order-tax">{{$edit_data['porder_tax']}}</td>
                                                                <input type="hidden" name="porder_tax" id="porder_tax" value="{{$edit_data['porder_tax']}}">
                                                            </tr>
                                                            <tr>
                                                                <td colspan=3></td>
                                                                <td>Total</td>
                                                                <td id="purchase-order-total">{{$edit_data['porder_total']}}</td>
                                                                <input type="hidden" name="porder_total" id="porder_total" value="{{$edit_data['porder_total']}}">
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
                                                    <textarea name="porder_terms_cond" id="textarea" class="form-control" rows="3" cols="25">{{$edit_data['porder_terms_cond']}}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="textarea" class="col-sm-2 control-label">Description:</label>
                                                <div class="col-sm-6">
                                                    <textarea name="porder_description" id="textarea" class="form-control" rows="3" cols="25">{{$edit_data['porder_description']}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="id" id="id" value="{{$edit_data['id']}}">
                                    {{csrf_field()}}
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-sm-2 col-sm-offset-7">
                                                <input type="submit" id="porder_save" class="btn btn-primary btn-block" value="Save"/>
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="submit" id="porder_generate" class="btn btn-primary btn-block" value="Generate"/>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                       @endif
                        <!-- Porder created modal starts-->
                        <div id="porder-add-response-message-modal" class="modal fade">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <strong id="porder-add-response"></strong>
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
