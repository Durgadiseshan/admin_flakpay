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
                        <!-- <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#{{str_replace(' ','-',strtolower($sublink_name))}}">{{$sublink_name}}</a></li>  -->
                        <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#system-status">Systems Status</a></li>
                        <li><a data-toggle="tab" class="show-pointer" data-target="#firewall-status">Firewall Status</a></li>
                        <li><a data-toggle="tab" class="show-pointer" data-target="#network-status">Network Status</a></li>
                        <li><a data-toggle="tab" class="show-pointer" data-target="#server-status">Server Status</a></li> 
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
                        <div id="system-status" class="tab-pane fade in active">
                            <div class="row padding-10">
                                <div class="col-sm-12">
                                    <button type="button" id="call-system-info-modal" class="btn btn-primary pull-right">Add System Information</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">

                                </div>
                            </div>
                            <!-- System Information Modal -->
                            <div id="system-info-modal" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                            
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">System Information</h4>
                                    </div>
                                    <form method="POST" class="form-horizontal" role="form"> 
                                        <div class="modal-body">
                                            
                                        </div>
                                        <div class="modal-footer">
                                            <div class="form-group">
                                                <div class="col-sm-10 col-sm-offset-2">
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            
                                </div>
                            </div>                     
                        </div>
                        <div id="firewall-status" class="tab-pane fade">
                            <div class="row padding-10">
                                <div class="col-sm-12">
                                    <button type="button" class="btn btn-primary pull-right">Add Firewall Information</button>
                                </div>
                            </div>                       
                        </div>
                        <div id="network-status" class="tab-pane fade">
                            <div class="row padding-10">
                                <div class="col-sm-12">
                                    <button type="button" class="btn btn-primary pull-right">Add Network Information</button>
                                </div>
                            </div>                     
                        </div>
                        <div id="server-status" class="tab-pane fade">
                            <div class="row padding-10">
                                <div class="col-sm-12">
                                    <button type="button" class="btn btn-primary pull-right">Add Server Information</button>
                                </div>
                            </div>                     
                        </div>
                    @endif
                </div>
            </div>
        </div>    
    </div>
</div>
@endsection
