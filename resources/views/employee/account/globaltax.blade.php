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
                            <div class="row">
                                <div class="col-sm-12">
                                    <a href="{{route('create-tax-settlement')}}" class="btn btn-primary btn-sm pull-right">New Tax Settlement</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div id="paginate_taxsettlements"></div>
                                </div>
                            </div>
                        </div> 
                        @elseif($index == 1)
                        <div id="{{str_replace(' ','-',strtolower($value->link_name))}}" class="tab-pane fade">
                            <div id="{{str_replace(' ','-',strtolower($value->link_name))}}" class="tab-pane fade in active">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <a href="{{route('create-tax-adjustment')}}" class="btn btn-primary btn-sm pull-right">New Tax Adjustment</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div id="paginate_taxadjustments"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @elseif($index == 2)
                        <div id="{{str_replace(' ','-',strtolower($value->link_name))}}" class="tab-pane fade">
                            <div id="{{str_replace(' ','-',strtolower($value->link_name))}}" class="tab-pane fade in active">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <a href="{{route('create-tax-payment')}}" class="btn btn-primary btn-sm pull-right">New Tax Payment</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div id="paginate_taxpayments"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        <div id="{{str_replace(' ','-',strtolower($value->link_name))}}" class="tab-pane fade">
                        
                        </div>
                        @endif
                    @endforeach
                    @else
                        <div id="{{str_replace(' ','-',strtolower($sublink_name))}}" class="tab-pane fade in active">
                            @if(isset($id))
                                @include('employee.'.$id)
                            @endif                            
                        </div>
                    @endif
                </div>
            </div>
        </div>    
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded",function(e){
        e.preventDefault();
        getAllTaxSettlement();
    });
</script>
@endsection
