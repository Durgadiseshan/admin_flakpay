@php
    use \App\Http\Controllers\MerchantController;
    use App\AppOption;
    $per_page = MerchantController::page_limit();
    $feedback_options = AppOption::get_merchant_feedback();
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
            <h3>Share your feedback!</h3>
            <p class="font-italic">Your precious feedback will make us improve service.</p>
  
            <p>Please sare your feedback for all of our department to improve our services for you.</p>
          </div>
        </div>
        <div class="col-lg-6" data-aos="zoom-in">
          <img src="/assets/img/merchant-feedback.png" width="450" class="img-fluid" id="img-dash" alt="merchant-feedback.png">
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
                    <li class="active"><a data-toggle="tab" class="show-cursor" data-target="#new-feedback">New Feedback</a></li>
                    <li><a data-toggle="tab" class="show-cursor" data-target="#display-feedback" onclick="getFeedbackData();">Feedback</a></li>
                </ul>
                <form action="" id="transaction-tabs-form" method="POST">
                    {{ csrf_field() }}
                </form>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div id="new-feedback" class="tab-pane fade in active">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="row padding-10">
                                    <div class="col-sm-4">
                                        <div id="ajax-feedback-response" class="text-center"></div>
                                    </div>
                                </div>
                                <form class="form-horizontal" id="feedback-form">
                                    <div class="form-group">
                                        <label for="category" class="control-label col-sm-1">Subject<span class="mandatory">*<span></label>
                                        <div class="col-sm-3">
                                            <select class="form-control" name="feed_subject" id="feed_subject">
                                                    <option value="">--Select--</option>
                                                @foreach($feedback_options as $index =>$subject)
                                                    <option value="{{$subject->id}}">{{$subject->option_value}}</option>
                                                @endforeach
                                            </select>
                                            <div id="ajax_feed_subject_error"></div>
                                        </div>
                                    </div>
                                     <div class="form-group">
                                        <label for="file" class="control-label col-sm-1">Rating<span class="mandatory">*<span></label>
                                        <section class='rating-widget'>
                                            <div class='rating-stars text-center'>
                                                <ul id='stars'>
                                                    <li class='star' title='Poor' data-value='1' onclick="giveRating(this);">
                                                        <i class='fa fa-star fa-fw'></i>
                                                    </li>
                                                    <li class='star' title='Fair' data-value='2' onclick="giveRating(this);">
                                                        <i class='fa fa-star fa-fw'></i>
                                                    </li>
                                                    <li class='star' title='Good' data-value='3' onclick="giveRating(this);">
                                                        <i class='fa fa-star fa-fw'></i>
                                                    </li>
                                                    <li class='star' title='Excellent' data-value='4' onclick="giveRating(this);">
                                                        <i class='fa fa-star fa-fw'></i>
                                                    </li>
                                                    <li class='star' title='WOW!!!' data-value='5' onclick="giveRating(this);">
                                                        <i class='fa fa-star fa-fw'></i>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class='success-box'>
                                                <div class='clearfix'></div>
                                                <div class='text-message' style="color:green"></div>
                                                <div class='clearfix'></div>
                                            </div>
                                        </section>
                                        <!-- Rating code end -->
                                    </div> 
                                    <div class="form-group">
                                        <div class="col-sm-3 col-sm-offset-2">
                                            <div id="ajax_feed_rating_error"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="description" class="control-label col-sm-1">Feedback</label>
                                        <div class="col-sm-3">
                                            <textarea name="feedback" id="feedback" cols="30" rows="5" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <input type="hidden" name="feed_rating" id="feed_rating" value="">
                                    {{csrf_field()}}
                                    <div class="form-group">
                                        <div class="col-sm-3 col-sm-offset-1">
                                            <input type="submit" value="Submit" class="btn btn-success">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div id="display-feedback" class="tab-pane">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="col-sm-4">
                                    <select name="page_limit" class="form-control" onchange="getFeedbackData($(this).val())">
                                        @foreach($per_page as $index => $page)
                                        <option value="{{$index}}">{{$page}}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="search-box">
                                    <form action="">
                                        <input type="search" id="feedback-table" placeholder="Search">
                                        <i class="fa fa-search"></i>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="display-block" id="paginate_feedbackdetail">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>
@endsection
