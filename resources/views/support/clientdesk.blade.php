@php
    use App\Http\Controllers\EmployeeController;
    use App\User;
    $supcategorylist = EmployeeController::support_category();
    $merchantlist = User::get_merchant_gids();
@endphp
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
                        <li><a data-toggle="tab" class="show-pointer" data-target="#addclientsupport">Add Merchant Support</a></li>
                        <li><a data-toggle="tab" class="show-pointer" data-target="#locked-status">Locked Status</a></li>  
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
                        <div id="{{str_replace(' ','-',strtolower($sublink_name))}}" class="tab-pane fade in active">
                           <div class="row">
                               <div class="col-sm-12">
                                   <div id="paginate_merchantsupport">

                                   </div>
                               </div>
                           </div>                            
                        </div>
                        <div id="addclientsupport" class="tab-pane fade">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div id="ajax-support-response" class="text-center"></div>
                                    <form class="form-horizontal" id="support-form" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="title" class="control-label col-sm-3">Title <span class="mandatory">*</span></label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="title" id="title" value="">
                                                <div id="ajax-title-error"></div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="category" class="control-label col-sm-3">Category:<span class="mandatory">*</span></label>
                                            <div class="col-sm-4">
                                                <select class="form-control" name="sup_category" id="sup_category">
                                                        <option value="">--Select--</option>
                                                        @foreach($supcategorylist as $index =>$category)
                                                            <option value="{{$index}}">{{$category}}</option>
                                                        @endforeach
                                                </select>
                                                <div id="ajax-sup_category-error"></div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="input" class="col-sm-3 control-label">Merchant Id:<span class="mandatory">*</span></label>
                                            <div class="col-sm-4">
                                                <select name="merchant_id" id="merchant_id" class="form-control">
                                                    <option value="">--Select--</option>
                                                    @foreach($merchantlist as $list)
                                                        <option value="{{$list->id}}">{{$list->merchant_gid}}</option>
                                                    @endforeach
                                                </select>
                                                <div id="ajax-merchant_id-error"></div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="input" class="col-sm-3 control-label">Merchant Mode:<span class="mandatory">*</span></label>
                                            <div class="col-sm-4">
                                                <select name="sup_from" id="sup_from" class="form-control">
                                                    <option value="">--Select--</option>
                                                    <option value="live">Live</option>
                                                    <option value="test">Test</option>
                                                </select>
                                                <div id="ajax-sup_from-error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="description" class="control-label col-sm-3">Description</label>
                                            <div class="col-sm-4">
                                                <textarea name="sup_description" id="sup_description" cols="30" rows="5" class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="file" class="control-label col-sm-3">File</label>
                                            <div class="col-sm-4">
                                                <input type="file" name="support_image" id="support_image">
                                            </div>
                                        </div>
                                        {{csrf_field()}}
                                        <div class="form-group">
                                            <div class="col-sm-4 col-sm-offset-3">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div id="locked-status" class="tab-pane fade">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div id="paginate_lockedmerchant">
                                        
                                    </div>
                                </div>
                            </div>
                            
                            <div class="modal" id="merchant-unlock-response">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="merchant-unlock-message"></h4>
                                        </div>
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
@endsection
<script>
    document.addEventListener("DOMContentLoaded",function(){
        getMerchantSupport();
    });
</script>
