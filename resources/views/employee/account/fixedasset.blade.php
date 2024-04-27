@php
    use App\CharOfAccount;
    use App\RyapayFixedAsset;

    $amount_codes = CharOfAccount::get_code_options();
    $asset_names = RyapayFixedAsset::get_asset_options();
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
                                    <button id="add-asset-call" class="btn btn-primary btn-sm pull-right">Add Asset</button>    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div id="paginate_assets">
                            
                                    </div>
                                </div>
                            </div>
                            <!-- Asset Add Modal -->
                            <div class="modal fade" id="add-asset-modal" role="dialog">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Add asset</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div id="add-asset-response-message" class="text-center"></div>
                                            <form class="form-horizontal" id="add-asset-form">
                                                <div class="form-group">
                                                    <label class="control-label col-sm-3" for="name">Asset Name:</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" id="asset_name" name="asset_name" placeholder="Enter Name">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-sm-3" for="description">Description:</label>
                                                    <div class="col-sm-6">          
                                                        <textarea name="asset_description" id="asset_description" class="form-control" rows="3" placeholder="Description"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="input" class="col-sm-3 control-label">Account Code:</label>
                                                    <div class="col-sm-6">
                                                        <select name="account_id" id="account_id" class="form-control">
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                <label class="control-label col-sm-3" for="amount">Amount:</label>
                                                    <div class="col-sm-6">          
                                                        <input type="text" class="form-control" id="asset_amount" name="asset_amount" placeholder="Enter Amount">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-sm-3" for="remark">Remark:</label>
                                                    <div class="col-sm-6">          
                                                        <textarea name="remark" id="remark" class="form-control" rows="3" placeholder="Remark"></textarea>
                                                    </div>
                                                </div>
                                                {{ @csrf_field() }}
                                                <div class="form-group">        
                                                    <div class="col-sm-offset-3 col-sm-6">
                                                        <button type="submit" class="btn btn-primary btn-block">Add</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Asset Edit Modal -->
                            <div class="modal fade" id="edit-asset-modal" role="dialog">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Edit Asset</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div id="edit-asset-response-message" class="text-center padding-10"></div>
                                            <form class="form-horizontal" id="update-asset-form">
                                                <div class="form-group">
                                                    <label class="control-label col-sm-3" for="name">Asset Name:</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" id="asset_name" name="asset_name" placeholder="Enter Name">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-sm-3" for="description">Description:</label>
                                                    <div class="col-sm-6">          
                                                        <textarea name="asset_description" id="asset_description" class="form-control" rows="3" placeholder="Description"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="input" class="col-sm-3 control-label">Amount Code:</label>
                                                    <div class="col-sm-6">
                                                        <select name="account_id" id="account_id" class="form-control">
                                                            <option value="">--Select--</option>
                                                            @if(count($amount_codes) > 0)
                                                                @foreach($amount_codes as $amount_code)
                                                                    <option value="{{$amount_code->id}}">{{$amount_code->account_code}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                <label class="control-label col-sm-3" for="amount">Amount:</label>
                                                    <div class="col-sm-6">          
                                                        <input type="text" class="form-control" id="asset_amount" name="asset_amount" placeholder="Enter Amount">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-sm-3" for="remark">Remark:</label>
                                                    <div class="col-sm-6">          
                                                        <textarea name="remark" id="remark" class="form-control" rows="3" placeholder="Remark"></textarea>
                                                    </div>
                                                </div>
                                                {{ @csrf_field() }}
                                                <input type="hidden" name="id" id="id" value="">
                                                <div class="form-group">        
                                                    <div class="col-sm-offset-3 col-sm-6">
                                                        <button type="submit" class="btn btn-primary btn-block">Update</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @elseif($index == 1)
                        <div id="{{str_replace(' ','-',strtolower($value->link_name))}}" class="tab-pane fade">
                            <div class="row padding-10">
                                <div class="col-sm-12">
                                    <button id="add-capital-asset-call" class="btn btn-primary btn-sm pull-right">Add Capital Asset</button>    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div id="paginate_capitalassets">
                            
                                    </div>
                                </div>
                            </div>
                            <!-- Capital Asset Add Modal -->
                            <div class="modal fade" id="add-capital-asset-modal" role="dialog">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Add asset</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div id="add-capital-asset-response-message" class="text-center"></div>
                                            <form class="form-horizontal" id="add-capital-asset-form">
                                                <div class="form-group">
                                                    <label class="control-label col-sm-3" for="name">Select Asset:</label>
                                                    <div class="col-sm-6">
                                                        <select name="id" id="id" class="form-control" onchange="getAssetInfo(this,'add-capital-asset-form')">
                                                            <option value="">--Select--</option>
                                                            @if(count($asset_names) > 0)
                                                                @foreach($asset_names as $asset_name)
                                                                    <option value="{{$asset_name->id}}">{{$asset_name->asset_name}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-sm-3" for="name">Asset Name:</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" id="asset_name" name="asset_name">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-sm-3" for="description">Description:</label>
                                                    <div class="col-sm-6">          
                                                        <textarea name="asset_description" id="asset_description" class="form-control" rows="3" placeholder="Description"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="input" class="col-sm-3 control-label">Account Code:</label>
                                                    <div class="col-sm-6">
                                                        <select name="account_id" id="account_id" class="form-control">
                                                            <option value="">--Select--</option>
                                                            @if(count($amount_codes) > 0)
                                                                @foreach($amount_codes as $amount_code)
                                                                    <option value="{{$amount_code->id}}">{{$amount_code->account_code}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                <label class="control-label col-sm-3" for="asset_amount">Amount:</label>
                                                    <div class="col-sm-6">          
                                                        <input type="text" class="form-control" id="asset_amount" name="asset_amount" placeholder="Enter Amount">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-sm-3" for="asset_capital_amount">Capital Amount:</label>
                                                        <div class="col-sm-6">          
                                                            <input type="text" class="form-control" id="asset_capital_amount" name="asset_capital_amount" placeholder="Enter Capital Amount">
                                                        </div>
                                                    </div>
                                                <div class="form-group">
                                                    <label class="control-label col-sm-3" for="remark">Remark:</label>
                                                    <div class="col-sm-6">          
                                                        <textarea name="remark" id="remark" class="form-control" rows="3" placeholder="Remark"></textarea>
                                                    </div>
                                                </div>
                                                {{ @csrf_field() }}
                                                <div class="form-group">        
                                                    <div class="col-sm-offset-3 col-sm-6">
                                                        <button type="submit" class="btn btn-primary btn-block">Add</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @elseif($index == 2)
                        <div id="{{str_replace(' ','-',strtolower($value->link_name))}}" class="tab-pane fade">
                            <div class="row padding-10">
                                <div class="col-sm-12">
                                    <button id="add-depreciate-asset-call" class="btn btn-primary btn-sm pull-right">Add Depreciate Asset</button>    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div id="paginate_depreciateassets">
                            
                                    </div>
                                </div>
                            </div>
                            <!-- Depreciate Asset Add Modal -->
                            <div class="modal fade" id="add-depreciate-asset-modal" role="dialog">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Add asset</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div id="add-depreciate-asset-response-message" class="text-center"></div>
                                            <form class="form-horizontal" id="add-depreciate-asset-form">
                                                <div class="form-group">
                                                    <label class="control-label col-sm-4" for="name">Select Asset:</label>
                                                    <div class="col-sm-6">
                                                        <select name="id" id="id" class="form-control" onchange="getAssetInfo(this,'add-depreciate-asset-form')">
                                                            <option value="">--Select--</option>
                                                            @if(count($asset_names) > 0)
                                                                @foreach($asset_names as $asset_name)
                                                                    <option value="{{$asset_name->id}}">{{$asset_name->asset_name}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-sm-4" for="name">Asset Name:</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" id="asset_name" name="asset_name">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-sm-4" for="description">Description:</label>
                                                    <div class="col-sm-6">          
                                                        <textarea name="asset_description" id="asset_description" class="form-control" rows="3" placeholder="Description"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="input" class="col-sm-4 control-label">Account Code:</label>
                                                    <div class="col-sm-6">
                                                        <select name="account_id" id="account_id" class="form-control">
                                                            <option value="">--Select--</option>
                                                            @if(count($amount_codes) > 0)
                                                                @foreach($amount_codes as $amount_code)
                                                                    <option value="{{$amount_code->id}}">{{$amount_code->account_code}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                <label class="control-label col-sm-4" for="asset_amount">Amount:</label>
                                                    <div class="col-sm-6">          
                                                        <input type="text" class="form-control" id="asset_amount" name="asset_amount" placeholder="Enter Amount">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-sm-4" for="asset_capital_amount">Capital Amount:</label>
                                                    <div class="col-sm-6">          
                                                        <input type="text" class="form-control" id="asset_capital_amount" name="asset_capital_amount" placeholder="Enter Capital Amount">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-sm-4" for="asset_depre_amount">Depreciate Amount:</label>
                                                    <div class="col-sm-6">          
                                                        <input type="text" class="form-control" id="asset_depre_amount" name="asset_depre_amount" placeholder="Enter Depreciate Amount">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-sm-4" for="remark">Remark:</label>
                                                    <div class="col-sm-6">          
                                                        <textarea name="remark" id="remark" class="form-control" rows="3" placeholder="Remark"></textarea>
                                                    </div>
                                                </div>
                                                {{ @csrf_field() }}
                                                <div class="form-group">        
                                                    <div class="col-sm-offset-3 col-sm-6">
                                                        <button type="submit" class="btn btn-primary btn-block">Add</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @elseif($index == 3)
                        <div id="{{str_replace(' ','-',strtolower($value->link_name))}}" class="tab-pane fade">
                            <div class="row padding-10">
                                <div class="col-sm-12">
                                    <button id="add-sale-asset-call" class="btn btn-primary btn-sm pull-right">Add Sale Asset</button>    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div id="paginate_saleassets">
                            
                                    </div>
                                </div>
                            </div>
                            <!-- Sale Asset Add Modal -->
                            <div class="modal fade" id="add-sale-asset-modal" role="dialog">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Add asset</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div id="add-sale-asset-response-message" class="text-center"></div>
                                            <form class="form-horizontal" id="add-sale-asset-form">
                                                <div class="form-group">
                                                    <label class="control-label col-sm-4" for="name">Select Asset:</label>
                                                    <div class="col-sm-6">
                                                        <select name="id" id="id" class="form-control" onchange="getAssetInfo(this,'add-sale-asset-form')">
                                                            <option value="">--Select--</option>
                                                            @if(count($asset_names) > 0)
                                                                @foreach($asset_names as $asset_name)
                                                                    <option value="{{$asset_name->id}}">{{$asset_name->asset_name}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-sm-4" for="name">Asset Name:</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" id="asset_name" name="asset_name">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-sm-4" for="description">Description:</label>
                                                    <div class="col-sm-6">          
                                                        <textarea name="asset_description" id="asset_description" class="form-control" rows="3" placeholder="Description"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="input" class="col-sm-4 control-label">Account Code:</label>
                                                    <div class="col-sm-6">
                                                        <select name="account_id" id="account_id" class="form-control">
                                                            <option value="">--Select--</option>
                                                            @if(count($amount_codes) > 0)
                                                                @foreach($amount_codes as $amount_code)
                                                                    <option value="{{$amount_code->id}}">{{$amount_code->account_code}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                <label class="control-label col-sm-4" for="asset_amount">Amount:</label>
                                                    <div class="col-sm-6">          
                                                        <input type="text" class="form-control" id="asset_amount" name="asset_amount" placeholder="Enter Amount">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-sm-4" for="asset_capital_amount">Capital Amount:</label>
                                                    <div class="col-sm-6">          
                                                        <input type="text" class="form-control" id="asset_capital_amount" name="asset_capital_amount" placeholder="Enter Capital Amount">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-sm-4" for="asset_depre_amount">Depreciate Amount:</label>
                                                    <div class="col-sm-6">          
                                                        <input type="text" class="form-control" id="asset_depre_amount" name="asset_depre_amount" placeholder="Enter Depreciate Amount">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-sm-4" for="asset_sale_amount">Sale Amount:</label>
                                                    <div class="col-sm-6">          
                                                        <input type="text" class="form-control" id="asset_sale_amount" name="asset_sale_amount" placeholder="Enter Sale Amount">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-sm-4" for="remark">Remark:</label>
                                                    <div class="col-sm-6">          
                                                        <textarea name="remark" id="remark" class="form-control" rows="3" placeholder="Remark"></textarea>
                                                    </div>
                                                </div>
                                                {{ @csrf_field() }}
                                                <div class="form-group">        
                                                    <div class="col-sm-offset-3 col-sm-6">
                                                        <button type="submit" class="btn btn-primary btn-block">Add</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
        getAllassets();
    });
</script>
@endsection
