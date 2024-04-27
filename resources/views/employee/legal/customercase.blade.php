@extends('layouts.employeecontent')
@section('employeecontent')
<div class="row">
    <div class="col-sm-12 padding-20">
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs" id="transaction-tabs">
                    <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#{{str_replace(' ','-',strtolower($sublink_name))}}">{{$sublink_name}}</a></li> 
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div id="{{str_replace(' ','-',strtolower($sublink_name))}}" class="tab-pane fade in active">
                        <div class="row">
                            <div class="col-sm-12">
                                <a href="{{}}" class="btn btn-primary pull-right btn-sm">New Case</a>
                            </div>
                        </div>
                        <div class="row padding-10">
                            <div class="col-sm-12">
                                      
                            </div>
                        </div>                          
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>
@endsection
