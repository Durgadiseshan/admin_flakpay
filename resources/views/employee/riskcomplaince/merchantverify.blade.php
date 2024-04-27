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
                            <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#{{str_replace(' ','-',strtolower($value->link_name))}}">{{$value->link_name}}</a></li> 
                        @else
                        <li><a data-toggle="tab" class="show-pointer" data-target="#{{str_replace(' ','-',strtolower($value->link_name))}}">{{$value->link_name}}</a></li>
                        @endif
                    @endforeach
                    @else
                        <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#{{str_replace(' ','-',strtolower($sublink_name))}}">{{$sublink_name}}</a></li>
                    @endif
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div id="{{str_replace(' ','-',strtolower($sublink_name))}}" class="tab-pane fade in active">
                         <div class="row">
                             <div class="col-sm-12">
                                 <a href="{{route('new-verify-merchant','yapay-OXS3k7jc')}}" class="btn btn-primary btn-sm pull-right">New BgCheck</a>
                             </div>
                         </div>
                         <div class="row padding-20">
                             <div class="col-sm-12">
                                 <div id="paginate_bginfo">

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
    document.addEventListener('DOMContentLoaded',function(){
        getAllBackgroundInfo();
    });
</script>
@endsection
