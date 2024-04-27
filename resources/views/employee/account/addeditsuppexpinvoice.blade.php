@php
use App\RyapaySupplier;
use App\Http\Controllers\EmployeeController;
use App\CharOfAccount;

$suppliers = RyapaySupplier::get_sup_opts();
$amount_codes = CharOfAccount::get_code_options();
//$item_options = EmployeeController::porder_items_options();

@endphp
@extends('layouts.employeecontent')
@section('employeecontent')
<div class="row">
<div class="col-sm-12 padding-20">
    <div class="panel panel-default">
        <div class="panel-heading">
            <ul class="nav nav-tabs" id="transaction-tabs">
                @if($form == "create")
                <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#supplier-expense-invoice">New Supplier Expense Invoice</a></li> 
                @else
                <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#supplier-expense-invoice">Edit Supplier Expense Invoice</a></li> 
                @endif
            </ul>
        </div>
        <div class="panel-body">
            <div class="tab-content">
                <div id="supplier-expense-invoice" class="tab-pane fade in active">
                    <div class="row">
                        <div class="col-sm-12">
                            <a href="{{route('account-payable','ryapay-XYFGXwnY')}}" class="btn btn-primary pull-right">Go Back</a>
                        </div>
                    </div>
                    @if($form == "create")
                   <div class="row">
                       <div class="col-sm-12">
                            <form method="POST" class="form-horizontal" role="form" id="supplier-exp-invoice-form">

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
                                                    <input type="text" name="supexp_due" id="supexp_due" class="form-control" value="" placeholder="YY-MM-DD">
                                                    <span class="input-group-addon"><span class="fa fa-calendar show-pointer" onclick="($('#supexp_due')).focus();"></span></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="input" class="col-sm-3 control-label">Pay Term:</label>
                                            <div class="col-sm-6">
                                                <input type="text" name="supexp_payterms" id="supexp_payterms" class="form-control" value="">
                                            </div>
                                        </div>                                          
                                    </div>
                                    <div class="col-sm-6">

                                        <div class="form-group">
                                            <label for="input" class="col-sm-4 control-label">Invoice Date:</label>
                                            <div class="col-sm-6">
                                                <div class="input-group date">
                                                    <input type="text" name="supexp_invdate" id="supexp_invdate" class="form-control" value="" placeholder="YYYY-MM-DD">
                                                    <span class="input-group-addon"><span class="fa fa-calendar show-pointer" onclick="($('#supexp_invdate')).focus();"></span></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="input" class="col-sm-4 control-label">Invoice No:</label>
                                            <div class="col-sm-6">
                                                <input type="text" name="supexp_invno" id="supexp_invno" class="form-control" value="">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row padding-20">
                                    <div class="col-sm-6">
                                        <strong>Product Details</strong>
                                    </div>
                                    <div class="col-sm-6">
                                        <button type="button" class="btn btn-primary btn-sm pull-right" onclick="loadSupExpNewItem();">Add Items</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Sno</th>
                                                        <!-- <th>Product Name</th> -->
                                                        <th>Expense Code</th>
                                                        <th>Product Price</th>
                                                        <th>Product Quantity</th>
                                                        <th>Product Total</th> 
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="supexp-items">
                                                    <tr id="supexp_item_row_1" data-row="1">
                                                        <td>1</td>
                                                        <!-- <td>
                                                            <div class="form-group">
                                                                <div class="col-sm-12">
                                                                    <select name="item_id[]" id="supexp_item_name_1" class="form-control" onchange="setSupExpItemPrice('1',this);">                                                                            
                                                                    </select>
                                                                    <div id="supexp_item_name_error_1"></div>
                                                                </div>
                                                            </div>
                                                        </td> -->
                                                        <td>
                                                            <div class="form-group">
                                                                <div class="col-sm-12">
                                                                    <select name="expense_code[]" id="expense_code_1" class="form-control">                                                                            
                                                                    </select>
                                                                    <div id="expense_code_error_1"></div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <div class="col-sm-12">
                                                                    <input type="text" name="item_amount[]" id="supexp_item_price_1" class="form-control" value="">
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <div class="col-sm-12">
                                                                    <input type="number" name="item_quantity[]" id="supexp_item_qty_1" class="form-control" min="1" value="1" onchange="loadSupExpItemtotal();">
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <div class="col-sm-12">
                                                                    <input type="text" name="item_total[]" id="supexp_item_total_1" class="form-control" value="">
                                                                </div>
                                                            </div>                                                                
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <div class="col-sm-12">
                                                                    <i class="fa fa-times fa-lg text-danger show-pointer" id="supexp_item_remove_1" onclick="supExpRemoveItem('1')"></i>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                        <tr>
                                                            <td colspan=4></td>
                                                            <td>SubTotal</td>
                                                            <td id="supplier-expense-subtotal">0.00</td>
                                                            <input type="hidden" name="supexp_subtotal" id="supexp_subtotal" value="">
                                                        </tr>
                                                        <tr>
                                                            <td colspan=4></td>
                                                            <td>Tax</td>
                                                            <td id="supplier-expense-tax">0.00</td>
                                                            <input type="hidden" name="supexp_tax" id="supexp_tax" value="">
                                                        </tr>
                                                        <tr>
                                                            <td colspan=4></td>
                                                            <td>Total</td>
                                                            <td id="supplier-expense-total">0.00</td>
                                                            <input type="hidden" name="supexp_total" id="supexp_total" value="">
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
                                                <textarea name="supexp_remarks" id="supexp_remarks" class="form-control" rows="3" cols="25"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{csrf_field()}}
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-sm-2 col-sm-offset-7">
                                            <input type="submit" id="supexp_save" class="btn btn-primary btn-block" value="Save"/>
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="submit" id="supexp_generate" class="btn btn-primary btn-block" value="Generate"/>
                                        </div>
                                    </div>
                                </div>
                            </form>
                       </div>
                   </div>
                   @else
                   <div class="row">
                    <div class="col-sm-12">
                         <form method="POST" class="form-horizontal" role="form" id="edit-supplier-exp-form">
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
                                                 <input type="text" name="supexp_due" id="supexp_due" class="form-control" value="{{$edit_data['supexp_due']}}" placeholder="YY-MM-DD">
                                                 <span class="input-group-addon"><span class="fa fa-calendar show-pointer" onclick="($('#supexp_due')).focus();"></span></span>
                                             </div>
                                         </div>
                                     </div>
                                     <div class="form-group">
                                         <label for="input" class="col-sm-3 control-label">Pay Term:</label>
                                         <div class="col-sm-6">
                                             <input type="text" name="supexp_payterms" id="supexp_payterms" class="form-control" value="{{$edit_data['supexp_payterms']}}">
                                         </div>
                                     </div>                                          
                                 </div>
                                 <div class="col-sm-6">

                                     <div class="form-group">
                                         <label for="input" class="col-sm-4 control-label">Invoice Date:</label>
                                         <div class="col-sm-6">
                                             <div class="input-group date">
                                                 <input type="text" name="supexp_invdate" id="supexp_invdate" class="form-control" value="{{$edit_data['supexp_invdate']}}" placeholder="YYYY-MM-DD">
                                                 <span class="input-group-addon"><span class="fa fa-calendar show-pointer" onclick="($('#supexp_invdate')).focus();"></span></span>
                                             </div>
                                         </div>
                                     </div>
                                     <div class="form-group">
                                         <label for="input" class="col-sm-4 control-label">Invoice No:</label>
                                         <div class="col-sm-6">
                                             <input type="text" name="supexp_invno" id="supexp_invno" class="form-control" value="{{$edit_data['supexp_invno']}}">
                                         </div>
                                     </div>
                                 </div>
                             </div>

                             <div class="row padding-20">
                                 <div class="col-sm-6">
                                     <strong>Product Details</strong>
                                 </div>
                                 <div class="col-sm-6">
                                     <button type="button" class="btn btn-primary btn-sm pull-right" onclick="loadSupExpNewItem();">Add Items</button>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="col-sm-12">
                                     <div class="">
                                         <table class="table table-bordered">
                                             <thead>
                                                 <tr>
                                                     <th>Sno</th>
                                                     <!-- <th>Product Name</th> -->
                                                     <th>Expense Code</th>
                                                     <th>Product Price</th>
                                                     <th>Product Quantity</th>
                                                     <th>Product Total</th> 
                                                     <th>Action</th>
                                                 </tr>
                                             </thead>
                                             <tbody id="supexp-items">
                                                @foreach($edit_data['items'] as $index => $item)
                                                <tr id="supexp_item_row_{{$index+1}}" data-row="{{$index+1}}">
                                                    <td>{{$index+1}}</td>
                                                    <!-- <td>
                                                        <div class="form-group">
                                                            <div class="col-sm-12">
                                                                <select name="item_id[]" id="supexp_item_name_{{$index+1}}" class="form-control" onchange="setSupExpItemPrice('{{$index+1}}',this);">                                                                            
                                                                    <option value="">--Select--</option>
                                                                    {{-- @foreach($item_options as $options)
                                                                        @if($options->id == $item['item_id'])
                                                                            <option value="{{$options->id}}" selected>{{$options->item_name}}</option>
                                                                        @else
                                                                            <option value="{{$options->id}}">{{$options->item_name}}</option>
                                                                        @endif
                                                                    @endforeach --}}
                                                                </select>
                                                                <div id="suppexp_item_name_error_{{$index+1}}"></div>
                                                            </div>
                                                        </div>
                                                    </td> -->
                                                    <td>
                                                        <div class="form-group">
                                                            <div class="col-sm-12">
                                                                <select name="expense_code[]" id="supexp_item_name_{{$index+1}}" class="form-control">
                                                                    <option value="">--Select--</option>                                                                            
                                                                    @if(count($amount_codes) > 0)
                                                                        @foreach($amount_codes as $amount_code)
                                                                            @if($amount_code->id == $item['expense_code'])
                                                                            <option value="{{$amount_code->id}}" selected>{{$amount_code->account_code}} ({{$amount_code->description}})</option>
                                                                            @else
                                                                            <option value="{{$amount_code->id}}">{{$amount_code->account_code}} ({{$amount_code->description}})</option>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                                <div id="suppexp_item_name_error_{{$index+1}}"></div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <div class="col-sm-12">
                                                                <input type="text" name="item_amount[]" id="supexp_item_price_{{$index+1}}" class="form-control" value="{{$item['item_amount']}}">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <div class="col-sm-12">
                                                                <input type="number" name="item_quantity[]" id="supexp_item_qty_{{$index+1}}" class="form-control" min="1" onchange="loadSupExpItemtotal();" value="{{$item['item_quantity']}}">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <div class="col-sm-12">
                                                                <input type="text" name="item_total[]" id="supexp_item_total_{{$index+1}}" class="form-control" value="{{$item['item_total']}}">
                                                            </div>
                                                        </div>                                                                
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <div class="col-sm-12">
                                                                <i class="fa fa-times fa-lg text-danger show-pointer" id="supexp_item_remove_{{$index+1}}" onclick="supExpRemoveItem('{{$index+1}}')"></i>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                             </tbody>
                                             <tfoot>
                                                     <tr>
                                                         <td colspan=4></td>
                                                         <td>SubTotal</td>
                                                         <td id="supplier-expense-subtotal">{{$edit_data['supexp_subtotal']}}</td>
                                                         <input type="hidden" name="supexp_subtotal" id="supexp_subtotal" value="{{$edit_data['supexp_subtotal']}}">
                                                     </tr>
                                                     <tr>
                                                         <td colspan=4></td>
                                                         <td>Tax</td>
                                                         <td id="supplier-expense-tax">{{$edit_data['supexp_tax']}}</td>
                                                         <input type="hidden" name="supexp_tax" id="supexp_tax" value="{{$edit_data['supexp_tax']}}">
                                                     </tr>
                                                     <tr>
                                                         <td colspan=4></td>
                                                         <td>Total</td>
                                                         <td id="supplier-expense-total">{{$edit_data['supexp_total']}}</td>
                                                         <input type="hidden" name="supexp_total" id="supexp_total" value="{{$edit_data['supexp_total']}}">
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
                                             <textarea name="supexp_remarks" id="supexp_remarks" class="form-control" rows="3" cols="25">{{$edit_data['supexp_remarks']}}</textarea>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             
                             <input type="hidden" name="id" id="id" class="form-control" value="{{$edit_data['id']}}">
                             {{csrf_field()}}
                             <div class="row">
                                 <div class="form-group">
                                     <div class="col-sm-2 col-sm-offset-7">
                                         <input type="submit" id="supexp_save" class="btn btn-primary btn-block" value="Save"/>
                                     </div>
                                     <div class="col-sm-2">
                                         <input type="submit" id="supexp_generate" class="btn btn-primary btn-block" value="Generate"/>
                                     </div>
                                 </div>
                             </div>
                         </form>
                    </div>
                    </div>
                   @endif
                    <!-- Porder created modal starts-->
                    <div id="supexp-add-response-message-modal" class="modal fade">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <strong id="supexp-add-response"></strong>
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
    getChartAccountOptions("supplier-exp-invoice-form","expense_code[]");           
});
</script>
@endsection
