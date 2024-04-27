@php
    $case_status = [
        'open'=>'Open',
        'review'=>'Under Review',
        'cancelled'=>'Cancelled',
        'closed'=>'Closed'
    ];
@endphp
@extends('layouts.employeecontent')
@section('employeecontent')
    <div class="row">
        <div class="col-sm-4">
            <div class="row">
                <div class="case-details">
                    <a href="{{route('risk-complaince-payable','ryapay-MMsTfgSk')}}" class="btn btn-primary pull-right">Go Back</a>
                    <p class="p"><strong class="strong">Case Type:</strong>&nbsp;{{$case_details->option_value}}</p>
                    <p class="p"><strong class="strong">Transaction Id:</strong>&nbsp;{{$case_details->transaction_gid}}</p>
                    <p class="p"><strong class="strong">Transaction Amount:</strong>&nbsp;{{$case_details->transaction_amount}}</p>
                    <p class="p"><strong class="strong">Customer Reason:</strong>&nbsp;{{$case_details->customer_reason}}</p>
                    <p class="p"><strong class="strong">Case Status:</strong>&nbsp;{{$case_details->status}}</p>
                    <p class="p"><strong class="strong">Createda Date:</strong>&nbsp;{{$case_details->created_date}}</p>
                </div>
            </div>
            <div class="row">
                <div id="ajax-comment-response" class="text-success text-center"></div>
                <form id="case-form" method="POST" class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="case_status" class="col-sm-4 control-label">Case Status:</label>
                        <div class="col-sm-8">
                            <select name="status" id="status" class="form-control">
                                <option value="">--Select--</option>
                                @foreach($case_status as $key => $value)
                                    @if($case_details->status == $key)
                                    <option value={{$key}} selected>{{$value}}</option>
                                    @else
                                    <option value={{$key}}>{{$value}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{csrf_field()}}
                    <input type="hidden" name="id" id="id" value="{{$case_details->id}}">
                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-4">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>
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

                                    <form id="rupayapay-comment-form">
                                        <textarea name="comment" id="message-to-send" placeholder ="Type your message" rows="2" cols="90" style="width: 70%;"></textarea>
                                        {{csrf_field()}}
                                        <input type="hidden" name="commented_user" id="commented_user" value="{{ ucfirst(auth()->guard('employee')->user()->first_name.' '.auth()->guard('employee')->user()->last_name) }}">
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
    <script>
        document.addEventListener('DOMContentLoaded',function(e){
            e.preventDefault();
            getCommentDetails();
        });
    </script>
@endsection