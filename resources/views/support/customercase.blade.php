@extends("layouts.support")
@section("content")
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="case-details">
                <p class="p"><strong class="strong">Case Type:</strong>&nbsp;{{$case_status->option_value}}</p>
                <p class="p"><strong class="strong">Transaction Id:</strong>&nbsp;{{$case_status->transaction_gid}}</p>
                <p class="p"><strong class="strong">Transaction Amount:</strong>&nbsp;{{$case_status->transaction_amount}}</p>
                <p class="p"><strong class="strong">Customer Name:</strong>&nbsp;{{$case_status->customer_name}}</p>
                <p class="p"><strong class="strong">Customer Email:</strong>&nbsp;{{$case_status->customer_email}}</p>
                <p class="p"><strong class="strong">Customer Mobile:</strong>&nbsp;{{$case_status->customer_mobile}}</p>
                <p class="p"><strong class="strong">Customer Reason:</strong>&nbsp;{{$case_status->customer_reason}}</p>
                <p class="p"><strong class="strong">Case Status:</strong>&nbsp;{{$case_status->status}}</p>
                <p class="p"><strong class="strong">Createda Date:</strong>&nbsp;{{$case_status->created_date}}</p>  
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

                                    <form id="customer-comment-form">
                                        <textarea name="comment" id="message-to-send" placeholder ="Type your message" rows="2" cols="90" style="width: 70%;"></textarea>
                                        {{csrf_field()}}
                                        <input type="hidden" name="commented_user" id="commented_user" value="{{ $case_status->customer_name }}">
                                        <input type="hidden" name="case_id" id="case_id" value="{{ $case_status->case_gid }}">
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
</div>
<script>
    document.addEventListener('DOMContentLoaded',function(){
        getCommentDetails();
    });
</script>
@endsection