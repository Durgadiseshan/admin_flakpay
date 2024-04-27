@php
    use App\Http\Controllers\MerchantEmpController;

    $per_page = MerchantEmpController::page_limit();
@endphp
@extends('layouts.merchantempcontent')
@section('empcontent')
<div class="row">
    <div class="col-sm-12 padding-top-30">
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" class="show-cursor" data-target="#paylinks">Paylinks</a></li>
                    <li><a data-toggle="tab" class="show-cursor" data-target="#quicklinks">Quick Links</a></li>
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div id="paylinks" class="tab-pane fade in active">
                        <div class="tab-button">
                            <div id="addpaylinkmodal" class="btn btn-primary btn-sm">Add Paylink</div>     
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="col-sm-4">
                                    <select name="page_limit" class="form-control" onchange="getAllPaylinks($(this).val())">
                                        @foreach($per_page as $index => $page)
                                            <option value="{{$index}}">{{$page}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="search-box">
                                    <form action="">
                                        <input type="search" id="paylink-table" placeholder="Search">
                                        <i class="fa fa-search"></i>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="display-block" id="paginate_paylink">
                                    
                                </div>
                            </div>
                        </div>
                        <!-- paylink add modal code starts-->
                        <!-- Paylinks Model -->
                        <div id="call-paylink-model" class="modal" role="dialog">
                            <div class="modal-dialog modal-lg">

                                <!-- Modal content-->
                                <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Paylink</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="model-content" id="modal-dynamic-body">
                                        <div id="paylink-add-form">
                                        <ul class="nav nav-tabs">
                                            <li class="active" id="add-paylink-li"><a data-toggle="tab" class="show-cursor" data-target="#add-paylink">Add Paylink</a></li>
                                            <li id="add-bulk-paylink-li"><a data-toggle="tab" class="show-cursor" data-target="#add-bulk-paylink">Add Bulk Paylink</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <div id="add-paylink" class="tab-pane fade in active">
                                                <div class="form-container">
                                                <div id="paylink-response-message" class="text-center"></div>
                                                <form class="form-horizontal" id="paylinkadd" autocomplete="off">
                                                    <div class="form-group">
                                                    <label class="control-label col-sm-2" for="amount">Amount:<span class="mandatory">*</span></label>
                                                    <div class="col-sm-4">
                                                        <div class="input-group">
                                                        <span class="input-group-addon" id="basic-addon1"><i class="fa fa-inr"></i></span>
                                                        <input type="text" class="form-control" name="paylink_amount" id="paylink_amount" placeholder="Amount" aria-describedby="basic-addon1" onkeyup="validateNumeric('paylink_amount');">
                                                        </div>
                                                        <div id="paylink_amount_error"></div>
                                                    </div>
                                                    <label class="control-label col-sm-3" for="sendmessage">Partail Payment</label>
                                                    <div class="col-sm-2">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" class="center-checkbox" name="paylink_partial" id="paylink_partial" value="N">
                                                                <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    </div>
                                                    <div class="form-group">
                                                    <label class="control-label col-sm-2" for="paymentfor">Payment For:<span class="mandatory">*</span></label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control" name="paylink_for" id="paylink_for" value="" placeholder="Purpose"/>
                                                        
                                                        <div id="paylink_for_error"></div>
                                                    </div>
                                                    </div>
                                                    <div class="form-group">
                                                    <label class="control-label col-sm-2" for="customeremail">Customer Email:</label>
                                                    <div class="col-sm-4">
                                                        <input type="email" class="form-control" name="paylink_customer_email" id="paylink_customer_email" placeholder="Customer Email" onkeyup="vaidateEmail('paylink_customer_email','paylink_customer_email_error','paylinkadd');">
                                                        <span id="paylink_customer_email_error"></span> 
                                                    </div>
                                                        <label class="control-label col-sm-3" for="sendemail">Send Email</label>
                                                    <div class="col-sm-2">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" class="center-checkbox" name="email_paylink" id="email_paylink" value="N">
                                                                <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    </div>
                                                    <div class="form-group">
                                                    <label class="control-label col-sm-2" for="customermobile">Customer Mobile:</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control" name="paylink_customer_mobile" id="paylink_customer_mobile" placeholder="Customer Mobile" onkeyup="validateMobile('paylink_customer_mobile','paylink_customer_mobile_error','paylinkadd');">
                                                        <span id="paylink_customer_mobile_error"></span>
                                                    </div>
                                                    <label class="control-label col-sm-3" for="sendmessage">Send Message</label>
                                                    <div class="col-sm-2">
                                                       
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" class="center-checkbox" name="mobile_paylink" id="mobile_paylink" value="N">
                                                                <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    </div>
                                                    <div class="form-group">
                                                    <label class="control-label col-sm-2" for="paymentfor">Receipt No:</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control" name="paylink_receipt" id="paylink_receipt" value="" placeholder="Receipt"/>
                                                    </div>
                                                    </div>
                                                    <div class="form-group">
                                                    <label class="control-label col-sm-2" for="paymentfor">Expiry Date:</label>
                                                    <div class="col-sm-4">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control show-pointer" name="paylink_expiry" id="paylink_expiry" value="" placeholder="yyyy-mm-dd"/>
                                                            <span class="input-group-addon" id="basic-addon2"><i class="fa fa-calendar show-cursor" onclick="$('#paylinkadd #paylink_expiry').focus()"></i></span>
                                                        </div>
                                                    </div>
                                                    <label class="control-label col-sm-3" for="sendmessage">Send Auto Remainder</label> 
                                                    <div class="col-sm-2">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" class="center-checkbox" name="paylink_auto_reminder" id="paylink_auto_reminder" value="N">
                                                                <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    </div>
                                                    <div class="form-group">
                                                    <label class="control-label col-sm-2" for="paymentfor">Paylink Notes:</label>
                                                    <div class="col-sm-4">
                                                        <textarea name="paylink_notes" class="form-control" id="paylink_notes" cols="26" rows="3"></textarea>
                                                    </div>
                                                    </div>
                                                    <div class="form-group">
                                                    <div class="col-sm-offset-2 col-sm-4">
                                                        <button type="submit" id="paylink-add" class="btn btn-primary btn-block disabled">Submit</button>
                                                    </div>
                                                    </div>
                                                    <input type="hidden" name="id" value="">
                                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                </form>
                                                </div>
                                            </div>
                                            <div id="add-bulk-paylink" class="tab-pane fade in">
                                                <form id="bulk-paylink-form" enctype="multipart/form-data">
                                                    <div class="text-center" id="paylink-bulk-response-message"></div>  
                                                    <table class="table table-responsive">
                                                        <caption class="text-center">Only Xls,Xlsx files can upload</caption>
                                                        <tbody>
                                                            <tr>
                                                                <td for="paylinkfile">Paylinks File Upload</td>
                                                                <td>
                                                                    <input type="file" name="import_paylinks_file" id="file-2" class="inputfile inputfile-2" data-multiple-caption="{count} files selected" multiple />
                                                                    <label for="file-2">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                                                            <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                                                                        </svg>
                                                                        <span id="paylink-bulkupload">Choose a file&hellip;</span>
                                                                    </label>
                                                                </td>
                                                                <td><input type="submit" class="btn btn-primary" value="Upload"></td>
                                                                <td><input type="reset" id="reset-bulk-paylink-form" class="btn btn-danger" value="Reset"></td>
                                                            </tr>
                                                        </tbody>
                                                        <tfoot>
                                                            <h5 class="text-danger">Note:Download this<a href="/download/paylink-sample.xls"><strong> sample file </strong></a>for your reference</h5>
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
                        <!-- paylink add modal code ends-->


                        <!-- Paylink Edit Modal code starts-->
                        <!-- Paylinks Model -->
                        <div id="call-edit-paylink-model" class="modal" role="dialog">
                            <div class="modal-dialog modal-lg">

                                <!-- Modal content-->
                                <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Paylink</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="model-content" id="modal-dynamic-body">
                                        <div id="paylink-add-form">
                                        <ul class="nav nav-tabs">
                                            <li class="active"><a data-toggle="tab" class="show-cursor" data-target="#add-paylink">Add Paylink</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <div id="add-paylink" class="tab-pane fade in active">
                                                <div class="form-container">
                                                <div id="paylink-edit-response-message" class="text-center"></div>
                                                <form class="form-horizontal" id="paylink-edit">
                                                    <div class="form-group">
                                                    <label class="control-label col-sm-2" for="amount">Amount:<span class="mandatory">*</span></label>
                                                    <div class="col-sm-4">
                                                        <div class="input-group">
                                                        <span class="input-group-addon" id="basic-addon1"><i class="fa fa-inr"></i></span>
                                                        <input type="text" class="form-control" name="paylink_amount" id="paylink_amount" placeholder="Amount" aria-describedby="basic-addon1" onkeyup="validateNumeric('paylink_amount');">
                                                        </div>
                                                        <div id="paylink_amount_error"></div>
                                                    </div>
                                                    <label class="control-label col-sm-3" for="sendmessage">Partail Payment</label>
                                                    <div class="col-sm-2">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" class="center-checkbox" name="paylink_partial" id="paylink_partial" value="N">
                                                                <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    </div>
                                                    <div class="form-group">
                                                    <label class="control-label col-sm-2" for="paymentfor">Payment For:<span class="mandatory">*</span></label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control" name="paylink_for" id="paylink_for" value="" placeholder="Purpose"/>
                                                        
                                                        <div id="paylink_for_error"></div>
                                                    </div>
                                                    </div>
                                                    <div class="form-group">
                                                    <label class="control-label col-sm-2" for="customeremail">Customer Email:</label>
                                                    <div class="col-sm-4">
                                                        <input type="email" class="form-control" name="paylink_customer_email" id="paylink_customer_email" placeholder="Customer Email" value="" onkeyup="vaidateEmail('paylink_customer_email','paylink_customer_email_error');">
                                                        <span id="paylink_customer_email_error"></span> 
                                                    </div>
                                                        <label class="control-label col-sm-3" for="sendemail">Send Email</label>
                                                    <div class="col-sm-2">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" class="center-checkbox" name="email_paylink" id="email_paylink" value="N">
                                                                <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    </div>
                                                    <div class="form-group">
                                                    <label class="control-label col-sm-2" for="customermobile">Customer Mobile:</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control" name="paylink_customer_mobile" id="paylink_customer_mobile" placeholder="Customer Mobile" value="" onkeyup="validateMobile('paylink_customer_mobile','paylink_customer_mobile_error');">
                                                        <span id="paylink_customer_mobile_error"></span>
                                                    </div>
                                                    <label class="control-label col-sm-3" for="sendmessage">Send Message</label>
                                                    <div class="col-sm-2">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" class="center-checkbox" name="mobile_paylink" id="mobile_paylink" value="N">
                                                                <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    </div>
                                                    <div class="form-group">
                                                    <label class="control-label col-sm-2" for="paymentfor">Receipt No:</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control" name="paylink_receipt" id="paylink_receipt" value="" placeholder="Receipt"/>
                                                    </div>
                                                    </div>
                                                    <div class="form-group">
                                                    <label class="control-label col-sm-2" for="paymentfor">Expiry Date:</label>
                                                    <div class="col-sm-4">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control show-pointer" name="paylink_expiry" id="paylink-expiry" value="" placeholder="yyyy-mm-dd"/>
                                                            <span class="input-group-addon" id="basic-addon2"><i class="fa fa-calendar show-cursor" onclick="$('#paylink-expiry').focus();"></i></span>
                                                        </div>
                                                    </div>
                                                    <label class="control-label col-sm-3" for="sendmessage">Send Auto Remainder</label> 
                                                    <div class="col-sm-2">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" class="center-checkbox" name="paylink_auto_reminder" id="paylink_auto_reminder" value="N">
                                                                <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    </div>
                                                    <div class="form-group">
                                                    <label class="control-label col-sm-2" for="paymentfor">Paylink Notes:</label>
                                                    <div class="col-sm-4">
                                                        <textarea name="paylink_notes" class="form-control" id="paylink_notes" cols="26" rows="3"></textarea>
                                                    </div>
                                                    </div>
                                                    <div class="form-group">
                                                    <div class="col-sm-offset-2 col-sm-4">
                                                        <button type="submit" id="paylink-add" class="btn btn-primary btn-block">Update</button>
                                                    </div>
                                                    </div>
                                                    <input type="hidden" name="id" value="">
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
                        <!-- pPylink Edit Modal code ends-->
                    </div>

                    <div id="quicklinks" class="tab-pane fade">
                        <div class="tab-button">
                            <div id="call-quicklink-modal" class="btn btn-primary btn-sm">Add Quick link</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="col-sm-4">
                                    <select name="page_limit" class="form-control" onchange="getAllQuickLinks($(this).val())">
                                        @foreach($per_page as $index => $page)
                                        <option value="{{$index}}">{{$page}}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="search-box">
                                    <form action="">
                                        <input type="search" id="quickpaylink-table" placeholder="Search">
                                        <i class="fa fa-search"></i>
                                    </form>
                                </div>
                            </div>
                            <!-- Modal -->
                            <div id="quick-link-modal" class="modal" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Quick Link</h4>
                                    </div>
                                    <form class="form-horizontal" id="quick-link-form">
                                        <div id="ajax-response-message" class="text-center"></div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="amount" class="control-label col-sm-3">Amount <span class="mandatory">*</span></label>
                                                <div class="col-sm-5">
                                                    <input type="text" class="form-control" name="paylink_amount" id="quickpaylink_amount" value="" onkeyup="validateNumeric('quickpaylink_amount');">
                                                    <span class="help-block">
                                                        <div id="paylink_amount_ajax_error"></div>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="amount" class="control-label col-sm-3">Purpose <span class="mandatory">*</span></label>
                                                <div class="col-sm-5">
                                                   <textarea class="form-control" name="paylink_for" id="paylink_for" cols="30" rows="3"></textarea>
                                                   <span class="help-block">
                                                        <div id="paylink_for_ajax_error"></div>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        {{csrf_field()}}
                                        <div class="modal-footer">
                                            <input type="submit" class="btn btn-primary" value="Submit">
                                        </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="display-block" id="paginate_quicklink">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded",function(){
        getAllPaylinks();
    });
</script>
@endsection