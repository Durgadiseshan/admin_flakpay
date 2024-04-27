@php
    use App\RyaPayCustomer;
    use App\RyapaySorder;
    use App\Http\Controllers\EmployeeController;

    $customers = RyaPayCustomer::get_cust_opts();
    $sorders = RyapaySorder::sorder_options();
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
                    <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#customer-order-invoice">New Customer Order Invoice</a></li> 
                    @else
                    <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#customer-order-invoice">Edit Customer Order Invoice</a></li> 
                    @endif
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div id="customer-order-invoice" class="tab-pane fade in active">
                        <div class="row">
                            <div class="col-sm-12">
                                <a href="{{route('account-receivable','ryapay-VfWlmhwZ')}}" class="btn btn-primary pull-right btn-sm">Go Back</a>
                            </div>
                        </div>
                        @if($form == "create")
                       <div class="row">
                           <div class="col-sm-12">
                                <form method="POST" class="form-horizontal" role="form" id="customer-order-form">

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="input" class="col-sm-3 control-label">Customer</label>
                                                <div class="col-sm-6">
                                                    <select name="customer_id" id="customer_id" class="form-control">
                                                        <option value="">--Select--</option>
                                                        @foreach($customers as $customer)
                                                            <option value="{{$customer->id}}">{{$customer->customer_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div id="scustomer_id_error"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-3 control-label">Due Date:</label>
                                                <div class="col-sm-6">
                                                    <div class="input-group date">
                                                        <input type="text" name="custorder_due" id="custorder_due" class="form-control" value="" placeholder="YY-MM-DD">
                                                        <span class="input-group-addon"><span class="fa fa-calendar show-pointer" onclick="($('#custorder_due')).focus();"></span></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-3 control-label">Pay Term:</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="custorder_payterms" id="custorder_payterms" class="form-control" value="">
                                                </div>
                                            </div>                                          
                                        </div>
                                        <div class="col-sm-6">

                                            <div class="form-group">
                                                <label for="input" class="col-sm-4 control-label">Invoice Date:</label>
                                                <div class="col-sm-6">
                                                    <div class="input-group date">
                                                        <input type="text" name="custorder_invdate" id="custorder_invdate" class="form-control" value="" placeholder="YYYY-MM-DD">
                                                        <span class="input-group-addon"><span class="fa fa-calendar show-pointer" onclick="($('#custorder_invdate')).focus();"></span></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-4 control-label">Invoice No:</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="custorder_invno" id="custorder_invno" class="form-control" value="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-4 control-label">Sales Order No:</label>
                                                <div class="col-sm-6">
                                                    <select name="sorder_id" id="sorder_id" class="form-control" onchange="getSalesOrderItems(this);">
                                                        <option value="">--Select--</option>
                                                        @foreach($sorders as $sorder)
                                                            <option value="{{$sorder->id}}">{{$sorder->sorder_no}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div id="sorder_id_error"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row padding-20">
                                        <div class="col-sm-6">
                                            <strong>Product Details</strong>
                                        </div>
                                        <div class="col-sm-6">
                                            <button type="button" class="btn btn-primary btn-sm pull-right" onclick="loadCustorderNewItem();">Add Items</button>
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
                                                    <tbody id="custorder-items">
                                                        <tr id="custord_item_row_1" data-row="1">
                                                            <td>1</td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <div class="col-sm-12">
                                                                        <select name="item_id[]" id="custorder_item_name_1" class="form-control" onchange="setCustOrderItemPrice('1',this);">                                                                            
                                                                        </select>
                                                                        <div id="custorder_item_name_error_1"></div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <div class="col-sm-12">
                                                                        <input type="text" name="item_amount[]" id="custorder_item_price_1" class="form-control" value="">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <div class="col-sm-12">
                                                                        <input type="number" name="item_quantity[]" id="custorder_item_qty_1" class="form-control" min="1" value="1" onchange="loadCustorderItemtotal();">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <div class="col-sm-12">
                                                                        <input type="text" name="item_total[]" id="custorder_item_total_1" class="form-control" value="">
                                                                    </div>
                                                                </div>                                                                
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <div class="col-sm-12">
                                                                        <i class="fa fa-times fa-lg text-danger show-pointer" id="custorder_item_remove_1" onclick="custordRemoveItem('1')"></i>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                            <tr>
                                                                <td colspan=3></td>
                                                                <td>SubTotal</td>
                                                                <td id="customer-order-subtotal">0.00</td>
                                                                <input type="hidden" name="custorder_subtotal" id="custorder_subtotal" value="">
                                                            </tr>
                                                            <tr>
                                                                <td colspan=3></td>
                                                                <td>Tax</td>
                                                                <td id="customer-order-tax">0.00</td>
                                                                <input type="hidden" name="custorder_tax" id="custorder_tax" value="">
                                                            </tr>
                                                            <tr>
                                                                <td colspan=3></td>
                                                                <td>Total</td>
                                                                <td id="customer-order-total">0.00</td>
                                                                <input type="hidden" name="custorder_total" id="custorder_total" value="">
                                                            </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="textarea" class="col-sm-2 control-label">Remarks:</label>
                                                <div class="col-sm-6">
                                                    <textarea name="custorder_remarks" id="custorder_remarks" class="form-control" rows="3" cols="25"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{csrf_field()}}
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-sm-2 col-sm-offset-7">
                                                <input type="submit" id="custorder_save" class="btn btn-primary btn-block" value="Save"/>
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="submit" id="custorder_generate" class="btn btn-primary btn-block" value="Generate"/>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                           </div>
                       </div>
                       @else
                       <div class="row">
                        <div class="col-sm-12">
                             <form method="POST" class="form-horizontal" role="form" id="edit-customer-order-form">
                                 <div class="row">
                                     <div class="col-sm-6">
                                         <div class="form-group">
                                             <label for="input" class="col-sm-3 control-label">Customer</label>
                                             <div class="col-sm-6">
                                                 <select name="customer_id" id="customer_id" class="form-control">
                                                     <option value="">--Select--</option>
                                                     @foreach($customers as $customer)
                                                         @if($customer->id == $edit_data['customer_id'])
                                                             <option value="{{$customer->id}}" selected>{{$customer->customer_name}}</option>
                                                         @else
                                                            <option value="{{$customer->id}}">{{$customer->customer_name}}</option>
                                                         @endif
                                                     @endforeach
                                                 </select>
                                                 <div id="customer_id_error"></div>
                                             </div>
                                         </div>
                                         <div class="form-group">
                                             <label for="input" class="col-sm-3 control-label">Due Date:</label>
                                             <div class="col-sm-6">
                                                 <div class="input-group date">
                                                     <input type="text" name="custorder_due" id="custorder_due" class="form-control" value="{{$edit_data['custorder_due']}}" placeholder="YY-MM-DD">
                                                     <span class="input-group-addon"><span class="fa fa-calendar show-pointer" onclick="($('#custorder_due')).focus();"></span></span>
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="form-group">
                                             <label for="input" class="col-sm-3 control-label">Pay Term:</label>
                                             <div class="col-sm-6">
                                                 <input type="text" name="custorder_payterms" id="custorder_payterms" class="form-control" value="{{$edit_data['custorder_payterms']}}">
                                             </div>
                                         </div>                                          
                                     </div>
                                     <div class="col-sm-6">

                                         <div class="form-group">
                                             <label for="input" class="col-sm-4 control-label">Invoice Date:</label>
                                             <div class="col-sm-6">
                                                 <div class="input-group date">
                                                     <input type="text" name="custorder_invdate" id="custorder_invdate" class="form-control" value="{{$edit_data['custorder_invdate']}}" placeholder="YYYY-MM-DD">
                                                     <span class="input-group-addon"><span class="fa fa-calendar show-pointer" onclick="($('#custorder_invdate')).focus();"></span></span>
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="form-group">
                                             <label for="input" class="col-sm-4 control-label">Invoice No:</label>
                                             <div class="col-sm-6">
                                                 <input type="text" name="custorder_invno" id="custorder_invno" class="form-control" value="{{$edit_data['custorder_invno']}}">
                                             </div>
                                         </div>
                                         <div class="form-group">
                                             <label for="input" class="col-sm-4 control-label">Sales Order No:</label>
                                             <div class="col-sm-6">
                                                 <select name="sorder_id" id="sorder_id" class="form-control" onchange="getPurchaseOrderItems(this);">
                                                     <option value="">--Select--</option>
                                                     @foreach($sorders as $sorder)
                                                         @if($sorder->id == $edit_data['sorder_id'])
                                                         <option value="{{$sorder->id}}" selected>{{$sorder->sorder_no}}</option>
                                                         @else
                                                         <option value="{{$sorder->id}}">{{$sorder->sorder_no}}</option>
                                                         @endif
                                                     @endforeach
                                                 </select>
                                                 <div id="sorder_id_error"></div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>

                                 <div class="row padding-20">
                                     <div class="col-sm-6">
                                         <strong>Product Details</strong>
                                     </div>
                                     <div class="col-sm-6">
                                         <button type="button" class="btn btn-primary btn-sm pull-right" onclick="loadCustorderNewItem();">Add Items</button>
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
                                                 <tbody id="custorder-items">
                                                    @foreach($edit_data['items'] as $index => $item)
                                                    <tr id="custord_item_row_{{$index+1}}" data-row="{{$index+1}}">
                                                        <td>{{$index+1}}</td>
                                                        <td>
                                                            <div class="form-group">
                                                                <div class="col-sm-12">
                                                                    <select name="item_id[]" id="custorder_item_name_{{$index+1}}" class="form-control" onchange="setCustOrderItemPrice('{{$index+1}}',this);">                                                                            
                                                                        @foreach($item_options as $options)
                                                                            @if($options->id == $item['item_id'])
                                                                                <option value="{{$options->id}}" selected>{{$options->item_name}}</option>
                                                                            @else
                                                                                <option value="{{$options->id}}">{{$options->item_name}}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                    <div id="supporder_item_name_error_{{$index+1}}"></div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <div class="col-sm-12">
                                                                    <input type="text" name="item_amount[]" id="custorder_item_price_{{$index+1}}" class="form-control" value="{{$item['item_amount']}}">
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <div class="col-sm-12">
                                                                    <input type="number" name="item_quantity[]" id="custorder_item_qty_{{$index+1}}" class="form-control" min="1" onchange="loadCustorderItemtotal();" value="{{$item['item_quantity']}}">
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <div class="col-sm-12">
                                                                    <input type="text" name="item_total[]" id="custorder_item_total_{{$index+1}}" class="form-control" value="{{$item['item_total']}}">
                                                                </div>
                                                            </div>                                                                
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <div class="col-sm-12">
                                                                    <i class="fa fa-times fa-lg text-danger show-pointer" id="custorder_item_remove_{{$index+1}}" onclick="custordRemoveItem('{{$index+1}}')"></i>
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
                                                             <td id="customer-order-subtotal">{{$edit_data['custorder_subtotal']}}</td>
                                                             <input type="hidden" name="custorder_subtotal" id="custorder_subtotal" value="{{$edit_data['custorder_subtotal']}}">
                                                         </tr>
                                                         <tr>
                                                             <td colspan=3></td>
                                                             <td>Tax</td>
                                                             <td id="customer-order-tax">{{$edit_data['custorder_tax']}}</td>
                                                             <input type="hidden" name="custorder_tax" id="custorder_tax" value="{{$edit_data['custorder_tax']}}">
                                                         </tr>
                                                         <tr>
                                                             <td colspan=3></td>
                                                             <td>Total</td>
                                                             <td id="customer-order-total">{{$edit_data['custorder_total']}}</td>
                                                             <input type="hidden" name="custorder_total" id="custorder_total" value="{{$edit_data['custorder_total']}}">
                                                         </tr>
                                                 </tfoot>
                                             </table>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="row">
                                     <div class="col-sm-12">
                                         <div class="form-group">
                                             <label for="textarea" class="col-sm-2 control-label">Remarks:</label>
                                             <div class="col-sm-6">
                                                 <textarea name="custorder_remarks" id="custorder_remarks" class="form-control" rows="3" cols="25">{{$edit_data['custorder_remarks']}}</textarea>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                                 
                                 <input type="hidden" name="id" id="id" class="form-control" value="{{$edit_data['id']}}">
                                 
                                 {{csrf_field()}}
                                 <div class="row">
                                     <div class="form-group">
                                         <div class="col-sm-2 col-sm-offset-7">
                                             <input type="submit" id="custorder_save" class="btn btn-primary btn-block" value="Save"/>
                                         </div>
                                         <div class="col-sm-2">
                                             <input type="submit" id="custorder_generate" class="btn btn-primary btn-block" value="Generate"/>
                                         </div>
                                     </div>
                                 </div>
                             </form>
                        </div>
                    </div>
                       @endif
                        <!-- Porder created modal starts-->
                        <div id="custorder-add-response-message-modal" class="modal fade">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <strong id="custorder-add-response"></strong>
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
