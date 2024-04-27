@php
    use \App\Http\Controllers\MerchantController;

    $per_page = MerchantController::page_limit();
@endphp
@extends('layouts.merchantcontent')
@section('merchantcontent')

    <div id="buton-1">
    <button class="btn btn-dark" id="Show">Show</button>
<button  class="btn btn-danger" id="Hide">Remove</button>
    </div>
<section id="about-1" class="about-1">
    <div class="container-1">
  
      <div class="row">
       
        <div class="col-lg-6 d-flex flex-column justify-contents-center" data-aos="fade-left">
          <div class="content-1 pt-4 pt-lg-0">
            <h3>Help & Support</h3>
            <p class="font-italic">Feel free to contact us for any help & support!</p>
            <p>Our help and support section will help you to understand our application and api integration.</p>
          </div>
        </div>
        <div class="col-lg-6" data-aos="zoom-in">
          <img src="/assets/img/merchant-help.png" width="450" class="img-fluid" id="img-dash" alt="merchant-help.png">
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
                    <li  class="active"><a data-toggle="tab" class="show-cursor" data-target="#help">Help</a></li>
                    <li><a data-toggle="tab" class="show-cursor" data-target="#support" onclick="getSupportData();">Support</a></li>
                </ul>
                <form action="" id="transaction-tabs-form" method="POST">
                    {{ csrf_field() }}
                </form>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                <div id="help" class="tab-pane fade in active">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                    <h3 class="panel-title">Would You Like To Know More?</h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="col-xs-1 col-sm-4">
                                                            <a href="#" class="thumbnail">
                                                               <img src="{{asset('images/pdf.png')}}" alt="pdf.png" >
                                                            </a>
                                                            <div class="btn btn-link text-center">MP Documentation</div>
                                                        </div>
                                                        <div class="col-xs-1 col-sm-4">
                                                            <a href="#" class="thumbnail">
                                                                <img src="{{asset('images/pdf.png')}}" alt="pdf.png" >
                                                            </a>
                                                            <div class="btn btn-link text-center">PG Documentation</div>
                                                        </div>
                                                        <div class="col-xs-1 col-sm-4">
                                                            <a href="#" class="thumbnail">
                                                                <img src="{{asset('images/pdf.png')}}" alt="pdf.png" >
                                                            </a>
                                                            <div class="btn btn-link text-center">Api Documentation</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/GUurzvS3DlY" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                    <h3 class="panel-title">FAQ's</h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingOne">
                                                        <h4 class="panel-title">
                                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                            How to run graph reports?
                                                            </a>
                                                        </h4>
                                                        </div>
                                                        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                                        <div class="panel-body">
                                                            To run the graph first select the date range then cick on okay of calender button.
                                                        </div>
                                                        </div>
                                                    </div>
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingTwo">
                                                        <h4 class="panel-title">
                                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                            How to raise an invoice?
                                                            </a>
                                                        </h4>
                                                        </div>
                                                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                                        <div class="panel-body">
                                                            Go to invoice module click on new invoice tab fill the form with the required details click on generate invoice.If you want to create invoice for future purpose click on save instead of generate
                                                        </div>
                                                        </div>
                                                    </div>
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingThree">
                                                        <h4 class="panel-title">
                                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                            How quick paylinks works?
                                                            </a>
                                                        </h4>
                                                        </div>
                                                        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                                        <div class="panel-body">
                                                            Click on paylink and use our two feature of paylink one you can add many features with your paylink and second amount & purpose for creating paylink.
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
                    <div id="support" class="tab-pane">
                        <div class="tab-button">
                            <div class="btn btn-primary btn-sm" id="call-support-modal">Add Support</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="col-sm-4">
                                    <select name="page_limit" class="form-control" onchange="getSupportData($(this).val())">
                                        @foreach($per_page as $index => $page)
                                        <option value="{{$index}}">{{$page}}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="search-box">
                                    <form action="">
                                        <input type="search" id="support-table" placeholder="Search">
                                        <i class="fa fa-search"></i>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="display-block" id="paginate_merchantsupport">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <!-- Support add Modal -->
                        <div id="support-modal" class="modal" role="dialog">
                        <div class="modal-dialog">

                            <!-- Support add Modal content-->
                            <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Support</h4>
                            </div>
                                <div id="ajax-support-response" class="text-center"></div>
                                <form class="form-horizontal" id="support-form" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="title" class="control-label col-sm-3">Title <span class="mandatory">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="title" id="title" value="">
                                                <div id="ajax-title-error"></div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="category" class="control-label col-sm-3">Category <span class="mandatory">*</span></label>
                                            <div class="col-sm-6">
                                                <select class="form-control" name="sup_category" id="sup_category">
                                                        <option value="">--Select--</option>
                                                        @foreach($sup_form["category"] as $index =>$category)
                                                            <option value="{{$index}}">{{$category}}</option>
                                                        @endforeach
                                                </select>
                                                <div id="ajax-sup_category-error"></div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="description" class="control-label col-sm-3">Description</label>
                                            <div class="col-sm-6">
                                                <textarea name="sup_description" id="sup_description" cols="30" rows="5" class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="file" class="control-label col-sm-3">File</label>
                                            <div class="col-sm-6">
                                                <!-- <input type="file" name="support_image" id="support_image"> -->
                                                <input type="file" name="support_image" id="file-2" class="inputfile inputfile-2" data-multiple-caption="{count} files selected" multiple />
                                                <label for="file-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                                        <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                                                    </svg> 
                                                    <span id="choose_file">Choose a file&hellip;</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    {{csrf_field()}}
                                    <div class="modal-footer">
                                        <input type="submit" value="Submit" class="btn btn-success">
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
@endsection
