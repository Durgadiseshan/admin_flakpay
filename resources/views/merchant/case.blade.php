@extends('layouts.merchantcontent')
@section('merchantcontent')

    <div class="row">
        <div class="col-sm-4">
            <div class="case-details">
                <a href="/merchant/resolution-center" class="btn btn-primary pull-right">Go Back</a>
                <p class="p"><strong class="strong">Case Type:</strong>&nbsp;{{$case_details->option_value}}</p>
                <p class="p"><strong class="strong">Transaction Id:</strong>&nbsp;{{$case_details->transaction_gid}}</p>
                <p class="p"><strong class="strong">Transaction Amount:</strong>&nbsp;{{$case_details->transaction_amount}}</p>
                <p class="p"><strong class="strong">Customer Reason:</strong>&nbsp;{{$case_details->customer_reason}}</p>
                <p class="p"><strong class="strong">Case Status:</strong>&nbsp;{{$case_details->status}}</p>
                <p class="p"><strong class="strong">Createda Date:</strong>&nbsp;{{$case_details->created_date}}</p>
            </div>
        </div>
        <div class="col-sm-8">
            <!-- ------------Comment Box Start-------------- -->
            <div class="contain-2 clearfix">
                <div class="people-list" id="people-list">
                    <div class="search">
                            <div class="chat">
                                <div class="chat-history">
                                    <ul id="previous-comment">

                                    </ul>
                                </div> 
                                <!-- end chat-history -->
                                <div class="chat-message">

                                    <form id="merchant-comment-form">
                                        <textarea name="comment" id="message-to-send" placeholder ="Type your message" rows="2" cols="90" style="width: 70%;"></textarea>
                                        {{csrf_field()}}
                                        <input type="hidden" name="commented_user" id="commented_user" value="{{ ucfirst(Auth::user()->name) }}">
                                        <input type="hidden" name="case_id" id="case_id" value="{{ $case_details->case_gid }}">
                                        <button class="btn btn-primary chat-send-button" id="btn-1">Send</button>
                                    </form>
                                </div>
                                 <!-- end chat-message -->                               
                            </div>
                    </div>
                </div>
            </div> <!-- end container -->
            <!-- ------------Comment Box End---------------->
        </div>
	</div>
@endsection