@php
    use App\RyapaySupplier;
    use App\RyapayPorder;
    use App\Http\Controllers\EmployeeController;

    $suppliers = RyapaySupplier::get_sup_opts();
    $porders = RyapayPorder::porder_options();
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
                    <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#purchase-order">New Supplier Order Invoice</a></li> 
                    @else
                    <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#purchase-order">Edit Supplier Order Invoice</a></li> 
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
                                <form method="POST" class="form-horizontal" role="form" id="supplier-order-form">

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="input" class="col-sm-3 control-label">Supplier</label>
                                                <div class="col-sm-6">
                                                    <select name="supplier_id" id="supplier_id" class="form-control">
                                                        <option value="">--Select--</option>
                                                        @foreach($suppliers as $supplier)
                                                            <option value="{{$supplier->id}}">{{$supplier->supplier_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div id="supplier_id_error"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-3 control-label">Due Date:</label>
                                                <div class="col-sm-6">
                                                    <div class="input-group date">
                                                        <input type="text" name="suporder_due" id="suporder_due" class="form-control" value="" placeholder="YY-MM-DD">
                                                        <span class="input-group-addon"><span class="fa fa-calendar show-pointer" onclick="($('#suporder_due')).focus();"></span></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-3 control-label">Pay Term:</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="suporder_payterms" id="suporder_payterms" class="form-control" value="">
                                                </div>
                                            </div>                                          
                                        </div>
                                        <div class="col-sm-6">

                                            <div class="form-group">
                                                <label for="input" class="col-sm-4 control-label">Invoice Date:</label>
                                                <div class="col-sm-6">
                                                    <div class="input-group date">
                                                        <input type="text" name="suporder_invdate" id="suporder_invdate" class="form-control" value="" placeholder="YYYY-MM-DD">
                                                        <span class="input-group-addon"><span class="fa fa-calendar show-pointer" onclick="($('#suporder_invdate')).focus();"></span></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-4 control-label">Invoice No:</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="suporder_invno" id="suporder_invno" class="form-control" value="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-4 control-label">Purchase Order No:</label>
                                                <div class="col-sm-6">
                                                    <select name="porder_id" id="porder_id" class="form-control" onchange="getPurchaseOrderItems(this);">
                                                        <option value="">--Select--</option>
                                                        @foreach($porders as $porder)
                                                            <option value="{{$porder->id}}">{{$porder->porder_no}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div id="porder_id_error"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row padding-20">
                                        <div class="col-sm-6">
                                            <strong>Product Details</strong>
                                        </div>
                                        <div class="col-sm-6">
                                            <button type="button" class="btn btn-primary btn-sm pull-right" onclick="loadSuporderNewItem();">Add Items</button>
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
                                                    <tbody id="suporder-items">
                                                        <tr id="supord_item_row_1" data-row="1">
                                                            <td>1</td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <div class="col-sm-12">
                                                                        <select name="item_id[]" id="suporder_item_name_1" class="form-control" onchange="setSupOrderItemPrice('1',this);">                                                                            
                                                                        </select>
                                                                        <div id="suporder_item_name_error_1"></div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <div class="col-sm-12">
                                                                        <input type="text" name="item_amount[]" id="suporder_item_price_1" class="form-control" value="">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <div class="col-sm-12">
                                                                        <input type="number" name="item_quantity[]" id="suporder_item_qty_1" class="form-control" min="1" value="1" onchange="loadSuporderItemtotal();">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <div class="col-sm-12">
                                                                        <input type="text" name="item_total[]" id="suporder_item_total_1" class="form-control" value="">
                                                                    </div>
                                                                </div>                                                                
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <div class="col-sm-12">
                                                                        <i class="fa fa-times fa-lg text-danger show-pointer" id="suporder_item_remove_1" onclick="supordRemoveItem('1')"></i>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                            <tr>
                                                                <td colspan=3></td>
                                                                <td>SubTotal</td>
                                                                <td id="supplier-order-subtotal">0.00</td>
                                                                <input type="hidden" name="suporder_subtotal" id="suporder_subtotal" value="">
                                                            </tr>
                                                            <tr>
                                                                <td colspan=3></td>
                                                                <td>Tax</td>
                                                                <td id="supplier-order-tax">0.00</td>
                                                                <input type="hidden" name="suporder_tax" id="suporder_tax" value="">
                                                            </tr>
                                                            <tr>
                                                                <td colspan=3></td>
                                                                <td>Total</td>
                                                                <td id="supplier-order-total">0.00</td>
                                                                <input type="hidden" name="suporder_total" id="suporder_total" value="">
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
                                                    <textarea name="suporder_remarks" id="suporder_remarks" class="form-control" rows="3" cols="25"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{csrf_field()}}
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-sm-2 col-sm-offset-7">
                                                <input type="submit" id="suporder_save" class="btn btn-primary btn-block" value="Save"/>
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="submit" id="suporder_generate" class="btn btn-primary btn-block" value="Generate"/>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                           </div>
                       </div>
                       @else
                       <div class="row">
                        <div class="col-sm-12">
                             <form method="POST" class="form-horizontal" role="form" id="edit-supplier-order-form">
                                 <div class="row">
                                     <div class="col-sm-6">
                                         <div class="form-group">
                                             <label for="input" class="col-sm-3 control-label">Supplier</label>
                                             <div class="col-sm-6">
                                                 <select name="supplier_id" id="supplier_id" class="form-control">
                                                     <option value="">--Select--</option>
                                                     @foreach($suppliers as $supplier)
                                                         @if($supplier->id == $edit_data['supplier_id'])
                                                             <option value="{{$supplier->id}}" selected>{{$supplier->supplier_name}}</option>
                                                         @else
                                                            <option value="{{$supplier->id}}">{{$supplier->supplier_name}}</option>
                                                         @endif
                                                     @endforeach
                                                 </select>
                                                 <div id="supplier_id_error"></div>
                                             </div>
                                         </div>
                                         <div class="form-group">
                                             <label for="input" class="col-sm-3 control-label">Due Date:</label>
                                             <div class="col-sm-6">
                                                 <div class="input-group date">
                                                     <input type="text" name="suporder_due" id="suporder_due" class="form-control" value="{{$edit_data['suporder_due']}}" placeholder="YY-MM-DD">
                                                     <span class="input-group-addon"><span class="fa fa-calendar show-pointer" onclick="($('#suporder_due')).focus();"></span></span>
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="form-group">
                                             <label for="input" class="col-sm-3 control-label">Pay Term:</label>
                                             <div class="col-sm-6">
                                                 <input type="text" name="suporder_payterms" id="suporder_payterms" class="form-control" value="{{$edit_data['suporder_payterms']}}">
                                             </div>
                                         </div>                                          
                                     </div>
                                     <div class="col-sm-6">

                                         <div class="form-group">
                                             <label for="input" class="col-sm-4 control-label">Invoice Date:</label>
                                             <div class="col-sm-6">
                                                 <div class="input-group date">
                                                     <input type="text" name="suporder_invdate" id="suporder_invdate" class="form-control" value="{{$edit_data['suporder_invdate']}}" placeholder="YYYY-MM-DD">
                                                     <span class="input-group-addon"><span class="fa fa-calendar show-pointer" onclick="($('#suporder_invdate')).focus();"></span></span>
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="form-group">
                                             <label for="input" class="col-sm-4 control-label">Invoice No:</label>
                                             <div class="col-sm-6">
                                                 <input type="text" name="suporder_invno" id="suporder_invno" class="form-control" value="{{$edit_data['suporder_invno']}}">
                                             </div>
                                         </div>
                                         <div class="form-group">
                                             <label for="input" class="col-sm-4 control-label">Purchase Order No:</label>
                                             <div class="col-sm-6">
                                                 <select name="porder_id" id="porder_id" class="form-control" onchange="getPurchaseOrderItems(this);">
                                                     <option value="">--Select--</option>
                                                     @foreach($porders as $porder)
                                                         @if($porder->id == $edit_data['porder_id'])
                                                         <option value="{{$porder->id}}" selected>{{$porder->porder_no}}</option>
                                                         @else
                                                         <option value="{{$porder->id}}">{{$porder->porder_no}}</option>
                                                         @endif
                                                     @endforeach
                                                 </select>
                                                 <div id="porder_id_error"></div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>

                                 <div class="row padding-20">
                                     <div class="col-sm-6">
                                         <strong>Product Details</strong>
                                     </div>
                                     <div class="col-sm-6">
                                         <button type="button" class="btn btn-primary btn-sm pull-right" onclick="loadSuporderNewItem();">Add Items</button>
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
                                                 <tbody id="suporder-items">
                                                    @foreach($edit_data['items'] as $index => $item)
                                                    <tr id="supord_item_row_{{$index+1}}" data-row="{{$index+1}}">
                                                        <td>{{$index+1}}</td>
                                                        <td>
                                                            <div class="form-group">
                                                                <div class="col-sm-12">
                                                                    <select name="item_id[]" id="suporder_item_name_{{$index+1}}" class="form-control" onchange="setSupOrderItemPrice('{{$index+1}}',this);">                                                                            
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
                                                                    <input type="text" name="item_amount[]" id="suporder_item_price_{{$index+1}}" class="form-control" value="{{$item['item_amount']}}">
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <div class="col-sm-12">
                                                                    <input type="number" name="item_quantity[]" id="suporder_item_qty_{{$index+1}}" class="form-control" min="1" onchange="loadSuporderItemtotal();" value="{{$item['item_quantity']}}">
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <div class="col-sm-12">
                                                                    <input type="text" name="item_total[]" id="suporder_item_total_{{$index+1}}" class="form-control" value="{{$item['item_total']}}">
                                                                </div>
                                                            </div>                                                                
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <div class="col-sm-12">
                                                                    <i class="fa fa-times fa-lg text-danger show-pointer" id="suporder_item_remove_{{$index+1}}" onclick="supordRemoveItem('{{$index+1}}')"></i>
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
                                                             <td id="supplier-order-subtotal">{{$edit_data['suporder_subtotal']}}</td>
                                                             <input type="hidden" name="suporder_subtotal" id="suporder_subtotal" value="{{$edit_data['suporder_subtotal']}}">
                                                         </tr>
                                                         <tr>
                                                             <td colspan=3></td>
                                                             <td>Tax</td>
                                                             <td id="supplier-order-tax">{{$edit_data['suporder_tax']}}</td>
                                                             <input type="hidden" name="suporder_tax" id="suporder_tax" value="{{$edit_data['suporder_tax']}}">
                                                         </tr>
                                                         <tr>
                                                             <td colspan=3></td>
                                                             <td>Total</td>
                                                             <td id="supplier-order-total">{{$edit_data['suporder_total']}}</td>
                                                             <input type="hidden" name="suporder_total" id="suporder_total" value="{{$edit_data['suporder_total']}}">
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
                                                 <textarea name="suporder_remarks" id="suporder_remarks" class="form-control" rows="3" cols="25">{{$edit_data['suporder_remarks']}}</textarea>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                                 
                                 <input type="hidden" name="id" id="id" class="form-control" value="{{$edit_data['id']}}">
                                 
                                 {{csrf_field()}}
                                 <div class="row">
                                     <div class="form-group">
                                         <div class="col-sm-2 col-sm-offset-7">
                                             <input type="submit" id="suporder_save" class="btn btn-primary btn-block" value="Save"/>
                                         </div>
                                         <div class="col-sm-2">
                                             <input type="submit" id="suporder_generate" class="btn btn-primary btn-block" value="Generate"/>
                                         </div>
                                     </div>
                                 </div>
                             </form>
                        </div>
                    </div>
                       @endif
                        <!-- Porder created modal starts-->
                        <div id="suporder-add-response-message-modal" class="modal fade">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <strong id="suporder-add-response"></strong>
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
