@php
    use App\State;
    $states = State::state_list();
@endphp

@extends('layouts.employeecontent')
@section('employeecontent')
<div class="row">
    <div class="col-sm-12 padding-20">
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs" id="bookkeeping-tabs">
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
                        @if($index == 0)
                        <div id="{{str_replace(' ','-',strtolower($value->link_name))}}" class="tab-pane fade in active">
                            <div class="row padding-10">
                                <div class="col-sm-12">
                                    <button id="additemmodal" class="btn btn-primary btn-sm pull-right">Add Item</button>    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div id="paginate_items">

                                    </div>
                                </div>
                            </div>
                            <!-- Items Modal create starts here-->
                            <div id="call-item-model" class="modal fade" role="dialog">
                                <div class="modal-dialog modal-lg">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Create Items</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="model-content" id="modal-dynamic-body">
                                            <div id="item-add-form">
                                            <ul class="nav nav-tabs">
                                                <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#add-multi-items">Add Items</a></li>
                                            </ul>

                                            <div class="tab-content">
                                                <div id="add-multi-items" class="tab-pane fade in active">
                                                    <div class="text-center" id="item-ajax-response"></div>
                                                    <div class="form-container">
                                                    <form class="form-inline" id="itemadd">
                                                        <table class="table table-responsive">
                                                        <thead>
                                                            <tr>
                                                            <th>Name</th>
                                                            <th>Price</th>
                                                            <th>Description</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="new-row">
                                                            <tr>
                                                                <td><input type="text" class="form-control"  name="item_name[]" value=""></td>
                                                                <td><input type="number" class="form-control" name="item_amount[]" value=""></td>
                                                                <td><Textarea class="form-control" cols=30 rows=1 name="item_description[]"></Textarea></td>
                                                                <td><i class="fa fa-times show-pointer mandatory" onclick="removeItem(this);"></i></td>
                                                            </tr>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                            <td colspan=2><div id="new-item" class="btn btn-default">Add Items</div></td>
                                                            <td><input type="submit" class="btn btn-primary pull-right" value="Submit"></td>
                                                            </tr>
                                                        </tfoot>
                                                        </table>
                                                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                    </form>
                                                    </div>
                                                </div>
                                                <div id="add-bulk-items" class="tab-pane fade in">
                                                    <div class="">
                                                        <div id="item-bulk-response-message" class="text-center"></div>
                                                        <form id="bulk-items-form" class="form-horizontal" enctype="multipart/form-data">
                                                            <table class="table table-responsive">
                                                                <caption class="text-center">Only xls,xlsx files can upload</caption>
                                                                <tbody>
                                                                    <tr>
                                                                        <td><label for="email">Items File Upload</label></td>
                                                                        <td><input type="file"  name="import_items_file" id="import_items_file"/></td>
                                                                        <td><input type="submit" class="btn btn-default" value="Submit" /></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <input type="hidden" name="_token" value="{{csrf_token()}}">
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
                            <!-- Item Model create ends here-->
                            <!-- Item Edit modal starts here -->
                            <div id="edit-item-model" class="modal fade" role="dialog">
                                <div class="modal-dialog modal-md">
                                    <form id="item-update-form">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Edit Item</h4>
                                            </div>
                                            <div id="item-update-response" class="text-center"></div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="item-name">Item Name:</label>
                                                    <input type="text" name="item_name" class="form-control">
                                                </div> 
                                                <div class="form-group">
                                                    <label for="item-amount">Item Amount:</label>
                                                    <input type="text" name="item_amount" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label for="item-description">Item Description:</label>
                                                    <textarea  name="item_description" class="form-control" cols="30" rows="3"></textarea>
                                                </div>                                                                                               
                                            </div>
                                            <div class="modal-footer">
                                                <input type="hidden" name="id" value="">
                                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                <input type="submit" class="btn btn-primary" value="Update"/>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- Item Edit modal ends here -->
                            <!-- Item Delete modal starts-->
                            <div id="deleteitemmodal" class="modal fade">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            Are you sure? would you like to delete Item&nbsp;<strong id="delte-item-name"></strong>?
                                        </div>
                                        <div class="modal-footer">
                                            <form id="item-delete-form">
                                                <input type="hidden" name="id" value="">
                                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                <input type="submit" class="btn btn-danger" value="Delete"/>
                                                <button type="button" data-dismiss="modal" class="btn btn-primary">Cancel</button>
                                            </form>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <!-- Item Delete modal ends-->
                        </div>
                        @elseif($index == 1)
                        <div id="{{str_replace(' ','-',strtolower($value->link_name))}}" class="tab-pane fade">
                            <div class="row">
                                <div class="text-center" id="delete-customer_response"></div>
                            </div>
                            <div class="row padding-10">
                                <div class="col-sm-12">
                                    <button id="add-customer-call" class="btn btn-primary btn-sm pull-right">Add Customer</button>    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div id="paginate_customers">

                                    </div>
                                </div>
                            </div>
                            <!-- Customer Edit Modal -->
                            <div class="modal fade" id="edit-customer-modal" role="dialog">
                                <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Edit Customer</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div id="edit-response-message" class="text-center padding-10"></div>
                                        <form class="form-horizontal" id="update-customer-form">
                                            <div class="form-group">
                                                <label class="control-label col-sm-3" for="name">Name:</label>
                                                <div class="col-sm-6">
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
                                            <input type="hidden" name="id" id="id" value="">
                                            <div class="form-group">        
                                                <div class="col-sm-offset-3 col-sm-4">
                                                    <button type="submit" class="btn btn-primary btn-block">Update</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <!-- Customer Delete Modal -->
                            <div class="modal fade" id="delete-customer-modal" role="dialog">
                                <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        Are you sure? would you like to delete this Customer&nbsp;<strong id="delte-customer-name"></strong>?
                                    </div>
                                    <div class="modal-footer">
                                        <form id="delete-customer-form">
                                            <input type="hidden" name="id" value="">
                                            {{@csrf_field()}}
                                            <input type="submit" class="btn btn-danger" value="Delete"/>
                                            <button type="button" data-dismiss="modal" class="btn btn-primary">Cancel</button>
                                        </form>
                                    </div>
                                </div>
                                </div>
                            </div>
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
                                                    <div class="col-sm-offset-3 col-sm-5">
                                                        <button type="submit" class="btn btn-primary btn-block">Add</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @elseif($index == 2)
                        <div id="{{str_replace(' ','-',strtolower($value->link_name))}}" class="tab-pane fade">
                            <div class="row padding-10">
                                <div class="col-sm-12">
                                    <button id="add-supplier-call" class="btn btn-primary btn-sm pull-right">Add Supplier</button>    
                                </div>
                            </div>
                            <div id="delete-supplier-response" class="text-center"></div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div id="paginate_suppliers">
                            
                                    </div>
                                </div>
                            </div>
                            <!-- supplier Add Modal -->
                            <div class="modal fade" id="add-supplier-modal" role="dialog">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Add supplier</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div id="add-supplier-response-message" class="text-center"></div>
                                            <form class="form-horizontal" id="add-supplier-form">
                                                <div class="form-group">
                                                    <label class="control-label col-sm-4" for="name">Company Name:</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" id="supplier_company" name="supplier_company" placeholder="Enter Company Name">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-sm-4" for="name">Name:</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" id="supplier_name" name="supplier_name" placeholder="Enter Name">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-sm-4" for="email">Email:</label>
                                                    <div class="col-sm-6">          
                                                        <input type="text" class="form-control" id="supplier_email" name="supplier_email" placeholder="Enter Email">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-sm-4" for="phone">Phone:</label>
                                                    <div class="col-sm-6">          
                                                        <input type="text" class="form-control" id="supplier_phone" name="supplier_phone" placeholder="Enter Phone">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                <label class="control-label col-sm-4" for="gstno">GSTNO:</label>
                                                    <div class="col-sm-6">          
                                                        <input type="text" class="form-control" id="supplier_gstno" name="supplier_gstno" placeholder="Enter GSTNO">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-sm-4" for="gstno">Address:</label>
                                                    <div class="col-sm-6">          
                                                        <textarea name="supplier_address" id="supplier_address" class="form-control" rows="3" placeholder="Enter Address"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-sm-4" for="gstno">City:</label>
                                                    <div class="col-sm-6">          
                                                        <input type="text" class="form-control" id="supplier_city" name="supplier_city" placeholder="Enter City">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-sm-4" for="gstno">Pincode:</label>
                                                    <div class="col-sm-6">          
                                                        <input type="text" class="form-control" id="supplier_pincode" name="supplier_pincode" placeholder="Enter Pincode">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-sm-4" for="gstno">State:</label>
                                                    <div class="col-sm-6">          
                                                        <select name="supplier_state" id="supplier_state" class="form-control">
                                                            <option value="">--Select--</option>
                                                            @foreach($states as $state)
                                                                <option value="{{$state->id}}">{{$state->state_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                {{ @csrf_field() }}
                                                <div class="form-group">        
                                                    <div class="col-sm-offset-4 col-sm-6">
                                                        <button type="submit" class="btn btn-primary btn-block">Add</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Supplier Edit Modal -->
                            <div class="modal fade" id="edit-supplier-modal" role="dialog">
                                <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Edit Supplier</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div id="edit-supplier-response-message" class="text-center padding-10"></div>
                                        <form class="form-horizontal" id="update-supplier-form">
                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="name">Company Name:</label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" id="supplier_company" name="supplier_company" placeholder="Enter Company Name">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="name">Name:</label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" id="supplier_name" name="supplier_name" placeholder="Enter Name">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="email">Email:</label>
                                                <div class="col-sm-6">          
                                                    <input type="text" class="form-control" id="supplier_email" name="supplier_email" placeholder="Enter Email">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="phone">Phone:</label>
                                                <div class="col-sm-6">          
                                                    <input type="text" class="form-control" id="supplier_phone" name="supplier_phone" placeholder="Enter Phone">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                            <label class="control-label col-sm-4" for="gstno">GSTNO:</label>
                                                <div class="col-sm-6">          
                                                    <input type="text" class="form-control" id="supplier_gstno" name="supplier_gstno" placeholder="Enter GSTNO">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="gstno">Address:</label>
                                                <div class="col-sm-6">          
                                                    <textarea name="supplier_address" id="supplier_address" class="form-control" rows="3" placeholder="Enter Address"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="gstno">City:</label>
                                                <div class="col-sm-6">          
                                                    <input type="text" class="form-control" id="supplier_city" name="supplier_city" placeholder="Enter City">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="gstno">Pincode:</label>
                                                <div class="col-sm-6">          
                                                    <input type="text" class="form-control" id="supplier_pincode" name="supplier_pincode" placeholder="Enter Pincode">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="gstno">State:</label>
                                                <div class="col-sm-6">          
                                                    <select name="supplier_state" id="supplier_state" class="form-control">
                                                        <option value="">--Select--</option>
                                                        @foreach($states as $state)
                                                            <option value="{{$state->id}}">{{$state->state_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            {{ @csrf_field() }}
                                            <input type="hidden" name="id" id="id" value="">
                                            <div class="form-group">        
                                                <div class="col-sm-offset-4 col-sm-6">
                                                    <button type="submit" class="btn btn-primary btn-block">Update</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <!-- supplier Delete Modal -->
                            <div class="modal fade" id="delete-supplier-modal" role="dialog">
                                <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        Are you sure? would you like to delete this Supplier&nbsp;<strong id="delte-supplier-name"></strong>?
                                    </div>
                                    <div class="modal-footer">
                                        <form id="delete-supplier-form">
                                            <input type="hidden" name="id" value="">
                                            {{@csrf_field()}}
                                            <input type="submit" class="btn btn-danger" value="Delete"/>
                                            <button type="button" data-dismiss="modal" class="btn btn-primary">Cancel</button>
                                        </form>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                    @else
                        <div id="{{str_replace(' ','-',strtolower($sublink_name))}}" class="tab-pane fade in active">
                            @if(isset($id))
                                @include('employee.'.$id)
                            @endif                            
                        </div>
                    @endif
                </div>
            </div>
        </div>    
    </div>
</div>
@endsection
<script>
    document.addEventListener("DOMContentLoaded", function() {
        getAllItems();
    });
</script>
