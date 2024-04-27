@php
    use \App\Http\Controllers\MerchantController;

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
            <h3>Resolution Center</h3>
            <p class="font-italic">Get answer of all your queries</p>
  
            <p>You are just one step away from activating your account to accept domestic and international payments from your customers. We just need a few more details</p>
          </div>
        </div>
        <div class="col-lg-6" data-aos="zoom-in">
          <img src="/assets/img/merchant-conclusion.png" width="350" height="250" class="img-fluid" id="img-dash" alt="merchant-conclusion.png">
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
                    <li  class="active"><a data-toggle="tab" class="show-cursor" data-target="#resolution-center">Resolution Center</a></li>
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div id="resolution-center" class="tab-pane fade in active">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="col-sm-4">
                                    <select name="page_limit" class="form-control" onchange="getCustomerCaseData($(this).val())">
                                        @foreach($per_page as $index => $page)
                                        <option value="{{$index}}">{{$page}}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="search-box">
                                    <form action="">
                                        <input type="search" id="resolution-table" placeholder="Search">
                                        <i class="fa fa-search"></i>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="display-block" id="paginate_casedetail">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Sno</th>
                                                <th>Case Id</th>
                                                <th>Payment Id</th>
                                                <th>Amount</th>
                                                <th>Customer Name</th>
                                                <th>Reason</th>
                                                <th>Status</th>
                                                <th>Case Created Date</th>
                                            </tr>
                                        </thead>
                                        <tbody id="casetablebody">
    
                                        </tbody>
                                    </table>   
                                </div>
                                
                            </div>
                            <div id="customer-case-modal" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Case Details</h4>
                                    </div>
                                    <form class="form-horizontal padding-10" id="display-case-details">
                                        <div class="form-group">
                                            <label for="case_type" class="col-md-4 control-label">Case type</label>
                                            <div class="col-md-6">
                                                <select name="case_type" id="case_type" class="form-control" value="{{ old('case_type') }}" disabled>
                                                    <option value="">--Select--</option>
                                                    @foreach($stype as $index => $type)
                                                    <option value="{{$index}}">{{$type}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="transaction_gid" class="col-md-4 control-label">Payment Id</label>

                                            <div class="col-md-6">
                                                <input id="transaction_gid" type="text" class="form-control" name="transaction_gid" value="{{ old('transaction_gid') }}" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="transaction_amount" class="col-md-4 control-label">Amount Paid</label>

                                            <div class="col-md-6">
                                                <input id="transaction_amount" type="text" class="form-control" name="transaction_amount" value="{{ old('transaction_amount') }}" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="customer_name" class="col-md-4 control-label">Name</label>

                                            <div class="col-md-6">
                                                <input id="customer_name" type="text" class="form-control" name="customer_name" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="customer_email" class="col-md-4 control-label">Email Id</label>

                                            <div class="col-md-6">
                                                <input type="text" id="customer_email" type="text" class="form-control" name="customer_email" value="{{ old('customer_email') }}" disabled>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="customer_mobile" class="col-md-4 control-label">Mobile No</label>

                                            <div class="col-md-6">
                                                <input id="customer_mobile" type="text" class="form-control" name="customer_mobile" value="{{ old('customer_mobile') }}" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="customer_reason" class="col-md-4 control-label">Reason</label>

                                            <div class="col-md-6">
                                                <textarea name="customer_reason" class="form-control" id="customer_reason" rows="4" disabled></textarea>
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
@endsection
