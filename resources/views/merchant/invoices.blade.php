@php
    use \App\Http\Controllers\MerchantController;
    use \App\Classes\InvoiceTax;

    $per_page = MerchantController::page_limit();
@endphp
@extends('layouts.merchantcontent')
@section('merchantcontent')
<!--Module Banner-->
<div id="buton-1">
    <button class="btn btn-dark" id="Show">Show</button>
<button  class="btn btn-danger" id="Hide">Remove</button>
    </div>
<section id="about-1" class="about-1">
    <div class="container-1">

    <div class="row">
   
    <div class="col-lg-6 d-flex flex-column justify-contents-center" data-aos="fade-left">
        <div class="content-1 pt-4 pt-lg-0">
        <h3>Invoices </h3>
        <p class="font-italic">Create invoices for your transaction</p>

        <p>Invoice generation made easy by our invoice feature of application where you can generate invoices for your all transations.</p>
        </div>
    </div>
    <div class="col-lg-6" data-aos="zoom-in">
        <img src="/assets/img/merchant-invoice.png" width="370" height="250" class="img-fluid" id="img-dash" alt="merchant-invoice.png">
    </div>
    </div>

    </div>
</section>
<!--Module Banner-->


    <div class="row">
        <div class="col-sm-12 padding-20">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <ul class="nav nav-tabs" id="transaction-tabs">
                        {{-- @php ($trans = ['merchant/invoices' => '<a data-toggle="tab" class="show-cursor" data-target="#invoices">invoices</a>',
                                'merchant/invoices/items' => '<a data-toggle="tab"  class="show-cursor" data-target="#items">Items</a>',
                                'merchant/invoice/new'=>'<a data-toggle="tab"  class="show-cursor" data-target="#addinvoice">New Invoice</a>'])
                        @foreach($trans as $index=>$value)
                            <li class="{{ Request::path() == $index ?'active' : ''}}">{!! $value !!}</li>
                        @endforeach --}}
                        <li class="active"><a data-toggle="tab" class="show-cursor" data-target="#invoices">Invoices</a></li>
                        <li><a data-toggle="tab" class="show-cursor" data-target="#items">Items</a></li>
                        <li><a data-toggle="tab" class="show-cursor" data-target="#customers">Customers</a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div id="invoices" class="tab-pane fade in active">
                            <div class="tab-button">
                                <a href="{{route('show-invoice')}}"  class="btn btn-primary btn-sm">Add Invoice</a>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="col-sm-4">
                                        <select name="page_limit" class="form-control" onchange="getAllInvoices($(this).val())">
                                            @foreach($per_page as $index => $page)
                                            <option value="{{$index}}">{{$page}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="search-box">
                                        <form action="">
                                            <input type="search" id="invoice-table" placeholder="Search">
                                            <i class="fa fa-search"></i>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="display-block" id="paginate_invoice">
                                        
                                    </div>
                                </div>
                                
                                <!-- Item personal details response modal ends-->
                            </div>
                        </div>
                        <div id="items" class="tab-pane">
                            <div class="tab-button">
                                <div id="additemmodal" class="btn btn-primary btn-sm">Add Item</div> 
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="col-sm-4">
                                        <select name="page_limit" class="form-control" onchange="getAllItems($(this).val())">
                                            @foreach($per_page as $index => $page)
                                            <option value="{{$index}}">{{$page}}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="search-box">
                                        <form action="">
                                            <input type="search" id="item-table" placeholder="Search">
                                            <i class="fa fa-search"></i>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="display-block" id="paginate_item">
                                        
                                    </div>
                                </div>
                            </div>
                            <!-- Items Modal create starts here-->
                            <div id="call-item-model" class="modal" role="dialog">
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
                                                <li class="active"><a data-toggle="tab" class="show-cursor" data-target="#add-multi-items">Add Items</a></li>
                                                <li><a data-toggle="tab" class="show-cursor" data-target="#add-bulk-items">Add Bulk Items</a></li>
                                            </ul>
                                            <div class="tab-content">
                                                <div id="add-multi-items" class="tab-pane fade in active">
                                                    <div class="text-center" id="item-response-message"></div>
                                                    <div class="form-container">
                                                    <form class="form-inline" id="itemadd">
                                                        <table class="table table-responsive">
                                                        <thead>
                                                            <tr>
                                                            <th>Name</th>
                                                            <th>Price</th>
                                                            <th>Description</th>
                                                            <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="new-row">
                                                            <tr>
                                                                <td>
                                                                    <input type="text" class="form-control"  name="item_name[]" value="">
                                                                    <div id="item_name_0"></div>
                                                                </td>
                                                                <td>
                                                                    <input type="number" class="form-control" name="item_amount[]" value="">
                                                                    <div id="item_amount_0"></div>
                                                                </td>
                                                                <td><Textarea class="form-control" cols="25" rows="2" name="item_description[]"></Textarea></td>
                                                                <td><i class="fa fa-times show-cursor mandatory" onclick="removeItem(this);"></i></td>
                                                            </tr> 
                                                        </tbody>
                                                        </table>
                                                        <div class="modal-footer">
                                                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                            <div id="new-item" class="btn btn-default btn-sm"><i class="fa fa-plus"></i> Add Items</div>
                                                            <input type="submit" class="btn btn-primary pull-right btn-sm" value="Submit">
                                                        </div>
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
                                                                    <td>
                                                                        <input type="file"  name="import_items_file" id="file-2" class="inputfile inputfile-2" data-multiple-caption="{count} files selected" multiple />
                                                                        <label for="file-2">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                                                                <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                                                                            </svg>
                                                                            <span id="item-bulkupload">Choose a file&hellip;</span>
                                                                        </label>
                                                                    </td>
                                                                    <td><input type="submit" class="btn btn-primary" value="Upload"></td>
                                                                    <td><input type="reset" id="reset-bulk-items-form" class="btn btn-danger" value="Reset"></td>
                                                                </tr>
                                                            </tbody>
                                                            <tfoot>
                                                                <h5 class="text-danger">Note:Download this<a href="/download/items-sample.xls"><strong> sample file </strong></a>for your reference</h5>
                                                            </tfoot>
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
                            <div id="edit-item-model" class="modal" role="dialog">
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
                                                    <label for="item-name">Item Name: <span class="mandatory">*</span></label>
                                                    <input type="text" name="item_name" id="item-name" class="form-control">
                                                    <div id="item_name_error"></div>
                                                </div> 
                                                <div class="form-group">
                                                    <label for="item-amount">Item Amount: <span class="mandatory">*</span></label>
                                                    <input type="text" name="item_amount" id="item-amount" class="form-control" onkeyup="validateNumeric('item-amount');">
                                                    <div id="item_amount_error"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="item-description">Item Description:</label>
                                                    <textarea  name="item_description" id="item-description" class="form-control" cols="30" rows="3"></textarea>
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
                            <div id="deleteitemmodal" class="modal">
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
                        <div id="customers" class="tab-pane">
                            <div class="tab-button">
                                <div id="add-customer-call" class="btn btn-primary btn-sm">Add Customer</div>    
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="col-sm-4">
                                        <select name="page_limit" class="form-control" onchange="getAllCustomers($(this).val())">
                                            @foreach($per_page as $index => $page)
                                            <option value="{{$index}}">{{$page}}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="search-box">
                                        <form action="">
                                            <input type="search" id="customer-table" placeholder="Search">
                                            <i class="fa fa-search"></i>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="text-center" id="delete-customer_response"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="display-block" id="paginate_customer">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Customer Edit Modal -->
                        <div class="modal" id="edit-customer-modal" role="dialog">
                            <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Edit Customer</h4>
                                </div>
                                <div class="modal-body">
                                    <div id="edit-response-message" class="text-center padding-10"></div>
                                    <form class="form-horizontal" id="edit-customer-form">
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="name">Name:</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Enter Name">
                                            </div>
                                            <span id='customer-name-error'></span>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="email">Email:</label>
                                            <div class="col-sm-5">          
                                                <input type="text" class="form-control" id="customer-edit-email" name="customer_email" placeholder="Enter Email" onkeyup="vaidateEmail('customer-edit-email','customer-edit-email-error')">
                                            </div>
                                            <span id='customer-edit-email-error'></span>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="phone">Phone:</label>
                                            <div class="col-sm-5">          
                                                <input type="text" class="form-control" id="customer-edit-phone" name="customer_phone" placeholder="Enter Phone" onkeyup="validateMobile('customer-edit-phone','customer-edit-phone-error')">
                                            </div>
                                            <span id='customer-edit-phone-error'></span>
                                        </div>
                                        <div class="form-group">
                                        <label class="control-label col-sm-3" for="gstno">GSTNO:</label>
                                            <div class="col-sm-5">          
                                                <input type="text" class="form-control" id="customer-edit-gstno" name="customer_gstno" placeholder="Enter GSTNO" onkeyup="ValidateMerchantGSTno('customer-edit-gstno','customer-edit-gstno-error')">
                                            </div>
                                            <span id='customer-edit-gstno-error'></span>
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
                        <div class="modal" id="delete-customer-modal" role="dialog">
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
    <script>
        document.addEventListener("DOMContentLoaded",function(){
            getAllInvoices();
        });
    </script>
@endsection
