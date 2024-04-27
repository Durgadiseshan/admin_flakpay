@extends('layouts.employeecontent')
@section('employeecontent')
<div class="row">
    <div class="col-sm-12 padding-20">
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs" id="transaction-tabs">
                    @if(count($sublinks) > 0)
                    @foreach($sublinks as $index => $value)
                        @if($index == 0)
                            <li class="active"><a data-toggle="tab" class="show-cursor" data-target="#{{str_replace(' ','-',strtolower($value->link_name))}}">{{$value->link_name}}</a></li> 
                        @else
                        <li><a data-toggle="tab" class="show-pointer" data-target="#{{str_replace(' ','-',strtolower($value->link_name))}}">{{$value->link_name}}</a></li>
                        @endif
                    @endforeach
                    @else
                        <li class="active"><a data-toggle="tab" class="show-cursor" data-target="#{{str_replace(' ','-',strtolower($sublink_name))}}">{{$sublink_name}}</a></li> 
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
                                    <a href="{{route('create-sales-order')}}" class="btn btn-primary pull-right btn-sm">New Sales Order</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div id="paginate_sorders">

                                    </div>
                                </div>
                            </div>
                        </div>
                        @elseif($index == 1)
                        <div id="{{str_replace(' ','-',strtolower($value->link_name))}}" class="tab-pane fade">
                            <div class="row padding-10">
                                <div class="col-sm-12">
                                    <a href="{{route('create-custorder-invoice')}}" class="btn btn-primary pull-right btn-sm">New Customer Invoice</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div id="paginate_custorders">

                                    </div>
                                </div>
                            </div>
                        </div>
                        @elseif($index == 2)
                        <div id="{{str_replace(' ','-',strtolower($value->link_name))}}" class="tab-pane fade">
                            <div class="row padding-10">
                                <div class="col-sm-12">
                                    <a href="{{route('new-custcd-note')}}" class="btn btn-primary pull-right btn-sm">New Note</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div id="paginate_custnotes">

                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                    @endif
                </div>
            </div>
        </div>    
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded",function(){
        getAllSalesOrders();
    });
</script>
@endsection
