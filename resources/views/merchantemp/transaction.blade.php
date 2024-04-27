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
                <ul class="nav nav-tabs" id="transaction-tabs">
                    <li class="active"><a data-toggle="tab" class="show-cursor" data-target="#payments">Payments</a></li>
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div id="payments" class="tab-pane fade in active">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="col-sm-4">
                                        <select name="page_limit" class="form-control" onchange="getAllPayments($(this).val())">
                                            @foreach($per_page as $index => $page)
                                            <option value="{{$index}}">{{$page}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="search-box">
                                    <form action="">
                                        <input type="search" id="transaction-table" placeholder="Search">
                                        <i class="fa fa-search"></i>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="display-block" id="paginate_transaction">
                                    
                                </div>
                            </div>
                            <!-- Transactiond Details Modal -->
                            <div id="transaction-details-modal" class="modal" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Transactiond Details Modal content-->
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Transaction Details</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form class="form-horizontal" id="edit-transaction-form">
                                            <div class="form-group">
                                                <label for="transactionid" class="control-label col-sm-4">Transaction Id</label>
                                                <div class="col-sm-5">
                                                    <label for="" class="cotrol-label col-sm-12" id="transaction_gid_label"></label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="orderid" class="control-label col-sm-4">Order Id</label>
                                                <div class="col-sm-5">
                                                    <label for="" class="cotrol-label col-sm-12" id="order_gid_label"></label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="transactionemail" class="control-label col-sm-4">Transaction Email</label>
                                                <div class="col-sm-5">
                                                    <label for="" class="cotrol-label col-sm-12" id="transaction_email_label"></label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="transactioncontact" class="control-label col-sm-4">Transaction Contact</label>
                                                <div class="col-sm-5">
                                                    <label for="" class="cotrol-label col-sm-12" id="transaction_contact_label"></label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="transactionamount" class="control-label col-sm-4">Transaction Amount</label>
                                                <div class="col-sm-5">
                                                    <label for="" class="cotrol-label col-sm-12" id="transaction_amount_label"></label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="transactionstatus" class="control-label col-sm-4">Transaction Status</label>
                                                <div class="col-sm-5">
                                                    <label for="" class="cotrol-label col-sm-12" id="transaction_status_label"></label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="createddate" class="control-label col-sm-4">Created Date</label>
                                                <div class="col-sm-5">
                                                    <label for="" class="cotrol-label col-sm-12" id="created_date_label"></label>
                                                </div>
                                            </div>
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
    </div>
</div>
<script>
    window.addEventListener("DOMContentLoaded",function(){
        getAllTransactionDetails();
    });
</script>
@endsection