@php
    use App\CharOfAccount;
    use App\RyapayFixedAsset;

    $amount_codes = CharOfAccount::get_code_options();
@endphp
@extends('layouts.employeecontent')
@section('employeecontent')
<div class="row">
    <div class="col-sm-12 padding-20">
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs" id="bookkeeping-tabs">
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
                                        <button id="add-voucher-call" class="btn btn-primary btn-sm pull-right">Add Voucher</button>    
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div id="paginate_vouchers">
                                
                                        </div>
                                    </div>
                                </div>
                                <!-- Vocuher Add Modal -->
                                <div class="modal fade" id="add-voucher-modal" role="dialog">
                                    <div class="modal-dialog modal-md">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Add Voucher</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div id="add-voucher-response-message" class="text-center"></div>
                                                <form class="form-horizontal" id="add-voucher-form">
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-4" for="name">Voucher No:</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control" id="voucher_no" name="voucher_no" placeholder="Enter Vocuher No">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-4" for="name">Voucher Date:</label>
                                                        <div class="col-sm-6">
                                                            <div class="input-group date">
                                                                <input type="text" class="form-control" name="voucher_date" id="add_voucher_date" value="" placeholder="DD-MM-YY">
                                                                <span class="input-group-addon"><span class="fa fa-calendar show-pointer" onclick="($('#add_voucher_date')).focus();"></span></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="input" class="col-sm-4 control-label">Debit Account Code:</label>
                                                        <div class="col-sm-6">
                                                            <select name="debit_account_code" id="debit_account_code" class="form-control">
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
                                                        <label class="control-label col-sm-4" for="description">Debit Amount:</label>
                                                        <div class="col-sm-6">          
                                                            <input type="text" class="form-control" id="debit_amount" name="debit_amount" placeholder="Enter Debit Amount">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="input" class="col-sm-4 control-label">Credit Account Code:</label>
                                                        <div class="col-sm-6">
                                                            <select name="credit_account_code" id="credit_account_code" class="form-control">
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
                                                        <label class="control-label col-sm-4" for="description">Credit Amount Code:</label>
                                                        <div class="col-sm-6">          
                                                            <input type="text" class="form-control" id="credit_amount" name="credit_amount" placeholder="Enter Amount">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                    <label class="control-label col-sm-4" for="amount">Voucher Total:</label>
                                                        <div class="col-sm-6">          
                                                            <input type="text" class="form-control" id="voucher_total" name="voucher_total" placeholder="Enter Voucher Amount">
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
                                                        <div class="col-sm-offset-4 col-sm-6">
                                                            <button type="submit" class="btn btn-primary btn-block">Add</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Voucher Edit Modal -->
                                <div class="modal fade" id="edit-voucher-modal" role="dialog">
                                    <div class="modal-dialog modal-md">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Edit Voucher</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div id="edit-voucher-response-message" class="text-center padding-10"></div>
                                                <form class="form-horizontal" id="update-voucher-form">
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-4" for="name">Voucher No:</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control" id="voucher_no" name="voucher_no" placeholder="Enter Vocuher No">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-4" for="name">Voucher Date:</label>
                                                        <div class="col-sm-6">
                                                            <div class="input-group date">
                                                                <input type="text" class="form-control" name="voucher_date" id="edit_voucher_date" value="" placeholder="DD-MM-YY">
                                                                <span class="input-group-addon"><span class="fa fa-calendar show-pointer" onclick="($('#edit_voucher_date')).focus();"></span></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="input" class="col-sm-4 control-label">Debit Account Code:</label>
                                                        <div class="col-sm-6">
                                                            <select name="debit_account_code" id="debit_account_code" class="form-control">
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
                                                        <label class="control-label col-sm-4" for="description">Debit Amount:</label>
                                                        <div class="col-sm-6">          
                                                            <input type="text" class="form-control" id="debit_amount" name="debit_amount" placeholder="Enter Debit Amount">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="input" class="col-sm-4 control-label">Credit Account Code:</label>
                                                        <div class="col-sm-6">
                                                            <select name="credit_account_code" id="credit_account_code" class="form-control">
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
                                                        <label class="control-label col-sm-4" for="description">Credit Amount Code:</label>
                                                        <div class="col-sm-6">          
                                                            <input type="text" class="form-control" id="credit_amount" name="credit_amount" placeholder="Enter Amount">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                    <label class="control-label col-sm-4" for="amount">Voucher Total:</label>
                                                        <div class="col-sm-6">          
                                                            <input type="text" class="form-control" id="voucher_total" name="voucher_total" placeholder="Enter Voucher Amount">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-4" for="remark">Remark:</label>
                                                        <div class="col-sm-6">          
                                                            <textarea name="remark" id="remark" class="form-control" rows="3" placeholder="Remark"></textarea>
                                                        </div>
                                                    </div>
                                                    {{ @csrf_field() }}
                                                    <input type="hidden" name="id" id="id" value="">
                                                    <div class="form-group">        
                                                        <div class="col-sm-offset-4 col-sm-6">
                                                            <button type="submit" class="btn btn-primary btn-block">Update</button>
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
    document.addEventListener("DOMContentLoaded",function(){
        getAllVouchers();
    });
</script>
@endsection
