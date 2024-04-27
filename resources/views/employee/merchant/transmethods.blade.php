@extends('layouts.employeecontent')
@section('employeecontent')
<div class="row">
    <div class="col-sm-12 padding-20">
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs">
                    @if(count($sublinks) > 0)
                    @foreach($sublinks as $index => $value)
                        @if($index == 0)
                            <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#{{str_replace(' ','-',strtolower($value->link_name))}}">{{$value->link_name}}</a></li> 
                        @else
                        <li><a data-toggle="tab" class="show-pointer" data-target="#{{str_replace(' ','-',strtolower($value->link_name))}}">{{$value->link_name}}</a></li>
                        @endif
                    @endforeach
                    @else
                        <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#merchant-paylink">Merchant Paylinks</a></li>
                        <li><a data-toggle="tab" class="show-pointer" data-target="#merchant-invoice">Merchant Invoices</a></li>  
                    @endif
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    @if(count($sublinks) > 0)
                    @foreach($sublinks as $index => $value)
                        @if($index == 0)
                        <div id="{{str_replace(' ','-',strtolower($value->link_name))}}" class="tab-pane fade in active">
                        
                        </div>
                        @else
                        <div id="{{str_replace(' ','-',strtolower($value->link_name))}}" class="tab-pane fade">
                        
                        </div>
                        @endif
                    @endforeach
                    @else
                        <div id="merchant-paylink" class="tab-pane fade in active">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div id="paginate_noofpaylink">

                                    </div>
                                </div>
                            </div>                         
                        </div>
                        <div id="merchant-invoice" class="tab-pane fade">
                           <div class="row">
                               <div class="col-sm-12">
                                    <div id="paginate_noofinvoice">

                                    </div>
                               </div>
                           </div>                          
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
        loadMerchantNoOfPaylinks();
    });
</script>
@endsection


