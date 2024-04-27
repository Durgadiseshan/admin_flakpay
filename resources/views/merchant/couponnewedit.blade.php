@extends(".layouts.merchantcontent")
@section("merchantcontent")
@if($mode == "add")
<div class="row">
    <div class="col-sm-12 padding-top-30">
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs" id="utilities-tabs">
                    <li class="active"><a data-toggle="tab" class="show-cursor" data-target="#coupons-new-edit">Coupon</a></li>                    
                </ul>                    
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div id="coupons-new-edit" class="tab-pane fade in active">
                        <div class="row">
                            <div class="col-sm-12">
                                <a href="/merchant/tools" class="btn btn-primary btn-sm pull-right">Back</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="display-block">
                                    <div class="row">
                                        <div id="ajax-respnse-message" class="text-center"></div>
                                        <div class="col-sm-12">
                                            <form class="form-horizontal" id="coupon-new-edit-form">
                                                <div class="form-group">
                                                    <label for="couponcode" class="control-label col-sm-2">Coupon Code<span class="mandatory">*</span></label>
                                                    <div class="col-sm-3">
                                                        <input type="text" class="form-control" name="coupon_gid" id="coupon_gid" value="">
                                                    </div>
                                                    <button class="btn btn-link" onclick="generateCouponId()">Generate Coupon Id</button>
                                                </div>
                                                <div class="form-group">
                                                    <label for="" class="control-label col-sm-2">Coupon Type<span class="mandatory">*</span></label>
                                                    <div class="col-sm-3">
                                                        <select class="form-control" name="coupon_type" id="coupon_type"></select>
                                                    </div>
                                                    <span class="help-block" id="coupon_type_form_validation"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label for="" class="control-label col-sm-2">Currency<span class="mandatory">*</span></label>
                                                    <div class="col-sm-3">
                                                        <select class="form-control" name="coupon_currency" id="coupon_currency">
                                                                <option value="">--Select--</option>
                                                            @foreach($currencies as $currency)
                                                                <option value="{{$currency->id}}">{{$currency->currency}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="help-block" id="coupon_currency_form_validation"></span>
                                                    </div>
                                                </div>
                                                <div class="display-none" id="coupon-type-tab">
                                                    <span><strong>Coupon Type:</strong></span>
                                                    <div class="form-group">
                                                        <label for="" class="control-label col-sm-2" id="discount-of-label">Discount of<span class="mandatory">*</span></label>
                                                        <label for="" class="control-label col-sm-2 display-none" id="free-shibepping-label">Free Shipping</label>
                                                        <div class="col-sm-10">
                                                            <div class="col-sm-2" id="coupon-discount-of">
                                                                <input type="number" class="form-control" name="coupon_discount" id="coupon_discount">
                                                                <span class="help-block" id="coupon_discount_form_validation"></span>
                                                            </div>
                                                            
                                                            <label for="" class="control-label col-sm-1">on<span class="mandatory">*</span></label>
                                                            <div class="col-sm-2">
                                                                <select class="form-control" name="coupon_on" id="coupon_on"></select>
                                                                <span class="help-block" id="coupon_on_form_validation"></span>
                                                            </div>
                                                            <div class="display-none" id="coupon-specific-product-input">
                                                                <div class="col-sm-6">
                                                                    <div class="col-sm-4">
                                                                        <select class="form-control" name="coupon_onproduct" id="coupon_onproduct"></select>
                                                                        <span class="help-block" id="coupon_onproduct_form_validation"></span>
                                                                    </div>
                                                                    <label for="" class="control-label col-sm-5">Max coupon amount<span class="mandatory">*</span></label>
                                                                    <div class="col-sm-3">
                                                                        <input type="text" class="form-control col-sm-3" name="coupon_maxdisc_amount" id="coupon_maxdisc_amount">
                                                                        <span class="help-block" id="coupon_maxdisc_amount_product_form_validation"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="display-none" id="coupon-order-over-input">
                                                                <div class="col-sm-12">
                                                                    <label for="" class="control-label col-sm-1">Amount<span class="mandatory">*</span></label>
                                                                    <div class="col-sm-4">
                                                                        <input type="text" class="form-control" name="coupon_ordermax_amount" id="coupon_ordermax_amount">
                                                                        <span class="help-block" id="coupon_ordermax_amount_form_validation"></span>
                                                                    </div>
                                                                    <label for="" class="control-label col-sm-4">Max coupon amount<span class="mandatory">*</span></label>
                                                                    <div class="col-sm-3">
                                                                        <input type="text" class="form-control col-sm-12" name="coupon_maxdisc_amount" id="coupon_maxdisc_amount">
                                                                        <span class="help-block" id="coupon_maxdisc_amount_order_form_validation"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="display-none" id="coupon-entire-order-input">
                                                                <div class="col-sm-6">
                                                                    <label for="" class="control-label col-sm-5">Max coupon amount<span class="mandatory">*</span></label>
                                                                    <div class="col-sm-4">
                                                                        <input type="text" class="form-control col-sm-3" name="coupon_maxdisc_amount" id="coupon_maxdisc_amount">
                                                                        <span class="help-block" id="coupon_maxdisc_amount_entire_form_validation"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="" class="control-label col-sm-2">Coupon Valid from<span class="mandatory">*</span></label>
                                                    <div class="col-sm-3">
                                                        <div class="input-group date">   
                                                            <input type="text" class="form-control" name="coupon_validfrom" id="coupon_validfrom" value="" palceholder="DD-MM-YY">
                                                            <span class="input-group-addon"><span class="fa fa-calendar show-cursor" onclick="($('#coupon_validfrom')).focus();"></span></span>
                                                        </div>
                                                        <span class="help-block" id="coupon_validfrom_form_validation"></span>
                                                    </div>
                                                    <label for="" class="control-label col-sm-2">Coupon Valid to<span class="mandatory">*</span></label>
                                                    <div class="col-sm-3">
                                                        <div class="input-group date"> 
                                                            <input type="text" class="form-control" name="coupon_validto" id="coupon_validto" value="" palceholder="DD-MM-YY">
                                                            <span class="input-group-addon"><span class="fa fa-calendar show-cursor" onclick="($('#coupon_validto')).focus();"></span></span>
                                                        </div>
                                                        <span class="help-block" id="coupon_validto_form_validation"></span>
                                                    </div>
                                                    
                                                </div>
                                                <div class="form-group">
                                                    <label for="" class="control-label col-sm-2">Coupon can be used<span class="mandatory">*</span></label>
                                                    <div class="col-sm-3">
                                                        <input type="text" class="form-control" name="coupon_maxuse" id="coupon_maxuse" value="infinite">
                                                        <span class="help-block" id="coupon_maxuse_form_validation"></span>
                                                    </div>
                                                    <span>times</span> 
                                                    <span class="text-danger">(Note:To make work coupon properly use infinite or any numeric value in this field)</span>
                                                </div>
                                                <div class="form-group">
                                                    <label for="" class="control-label col-sm-2">Coupon can be used<span class="mandatory">*</span></label>
                                                    <div class="col-sm-3">
                                                        <input type="text" class="form-control" name="coupon_usermaxuse" id="coupon_usermaxuse" value="infinite">
                                                        <span class="help-block" id="coupon_usermaxuse_form_validation"></span>
                                                    </div>
                                                    <span>times by a single user</span> 
                                                    <span class="text-danger">(Note:To make work coupon properly use infinite or any numeric value in this field)</span>
                                                </div>
                                                {{csrf_field()}}
                                                <div class="form-group">
                                                    <div class="col-sm-3 col-sm-offset-2">
                                                        <input type="submit" class="btn btn-primary btn-block" value="Submit">
                                                    </div>
                                                    
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>
@else
<script type="text/javascript">
  document.addEventListener("DOMContentLoaded", function(event) {
      getCouponsTypesSubtypes("loadarray");
  });
</script>
<div class="row">
    <div class="col-sm-12 padding-top-30">
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs" id="utilities-tabs">
                    <li class="active"><a data-toggle="tab" class="show-cursor" data-target="#coupons-new-edit">Coupon</a></li>                    
                </ul>                    
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div id="coupons-new-edit" class="tab-pane fade in active">
                        <div class="row">
                            <div class="col-sm-12">
                                <a href="/merchant/tools" class="btn btn-primary pull-right">Go Back</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="display-block">
                                    <div class="row">
                                        <div id="ajax-respnse-message" class="text-center"></div>
                                        <div class="col-sm-12">
                                            @if(count($coupon_data) > 0)
                                                @foreach($coupon_data as $data)
                                                <form class="form-horizontal" id="coupon-new-edit-form">
                                                    <div class="form-group">
                                                        <label for="couponcode" class="control-label col-sm-2">Coupon Code<span class="mandatory">*</span></label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" name="coupon_gid" id="coupon_gid" value="{{$data->coupon_gid}}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="" class="control-label col-sm-2">Coupon Type<span class="mandatory">*</span></label>
                                                        <div class="col-sm-3">
                                                            <select class="form-control" name="coupon_type" id="coupon_type">
                                                                    <option value="">--Select--</option>
                                                                    @foreach($coupon_types as $type)
                                                                        @if($type->option_type == 'type')
                                                                            @if($type->id == $data->coupon_type)
                                                                            <option value="{{$type->id}}" selected>{{$type->coupon_option}}</option>
                                                                            @else
                                                                            <option value="{{$type->id}}">{{$type->coupon_option}}</option>
                                                                            @endif
                                                                        @endif
                                                                    @endforeach
                                                            </select>
                                                        </div>
                                                        <span class="help-block" id="coupon_type_form_validation"></span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="" class="control-label col-sm-2">Currency<span class="mandatory">*</span></label>
                                                        <div class="col-sm-3">
                                                            <select class="form-control" name="coupon_currency" id="coupon_currency">
                                                                    <option value="">--Select--</option>
                                                                    @foreach($currencies as $currency)
                                                                        @if($currency->id == $data->coupon_currency)
                                                                        <option value="{{$currency->id}}" selected>{{$currency->currency}}</option>
                                                                        @else
                                                                        <option value="{{$currency->id}}">{{$currency->currency}}</option>
                                                                        @endif
                                                                    @endforeach
                                                            </select>
                                                            <span class="help-block" id="coupon_currency_form_validation"></span>
                                                        </div>
                                                    </div>
                                                    <div class="{{ $data->coupon_type!=''?'':'display-none'}}" id="coupon-type-tab">
                                                        <span><strong>Coupon Type:</strong></span>
                                                        <div class="form-group">
                                                            <label for="" class="control-label col-sm-2 {{$data->coupon_type != '3' ?'':'display-none'}}" id="discount-of-label">Discount of<span class="mandatory">*</span></label>
                                                            <label for="" class="control-label col-sm-2 {{$data->coupon_type =='3'?'':'display-none'}}" id="free-shibepping-label">Free Shipping</label>
                                                            <div class="col-sm-10">
                                                                <div class="col-sm-2 {{$data->coupon_type != '3' ?'':'display-none'}}" id="coupon-discount-of">
                                                                    <input type="number" class="form-control" name="coupon_discount" id="coupon_discount" value="{{$data->coupon_discount}}">
                                                                    <span class="help-block" id="coupon_discount_form_validation"></span>
                                                                </div>
                                                                <label for="" class="control-label col-sm-1">on<span class="mandatory">*</span></label>
                                                                <div class="col-sm-2">
                                                                    <select class="form-control" name="coupon_on" id="coupon_on">
                                                                        <option value="">--Select--</option>
                                                                        @foreach($coupon_types as $type)
                                                                            @if($type->option_type == 'sub_type')

                                                                                @if($data->coupon_type != '3')

                                                                                    @if($type->id == $data->coupon_on)
                                                                                    <option value="{{$type->id}}" selected>{{$type->coupon_option}}</option>
                                                                                    @else
                                                                                    <option value="{{$type->id}}">{{$type->coupon_option}}</option>
                                                                                    @endif

                                                                                @else
                                                                                    @if($type->id != '6')
                                                                                        @if($type->id == $data->coupon_on)
                                                                                            <option value="{{$type->id}}" selected>{{$type->coupon_option}}</option>
                                                                                        @else
                                                                                            <option value="{{$type->id}}">{{$type->coupon_option}}</option>
                                                                                        @endif
                                                                                    @endif
                                                                                @endif
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                    <span class="help-block" id="coupon_on_form_validation"></span>
                                                                </div>
                                                                <div class="{{ $data->coupon_on == '3'?'':'display-none'}}" id="coupon-specific-product-input">
                                                                    <div class="col-sm-6">
                                                                        <div class="col-sm-4">
                                                                            <select class="form-control" name="coupon_onproduct" id="coupon_onproduct">
                                                                                @if(count($products) > 0)
                                                                                    @foreach($products as $product)
                                                                                        @if($product->id == $data->coupon_onproduct)
                                                                                        <option value="{{$product->id}}" selected>{{$product->product_title}}</option>
                                                                                        @else
                                                                                        <option value="{{$product->id}}">{{$product->product_title}}</option>
                                                                                        @endif
                                                                                    @endforeach
                                                                                @endif
                                                                            </select>
                                                                            <span class="help-block" id="coupon_onproduct_form_validation"></span>
                                                                        </div>
                                                                        <label for="" class="control-label col-sm-5">Max coupon amount<span class="mandatory">*</span></label>
                                                                        <div class="col-sm-3">
                                                                            <input type="text" class="form-control col-sm-3" name="coupon_maxdisc_amount" id="coupon_maxdisc_amount" value="{{$data->coupon_on == '3'? $data->coupon_maxdisc_amount:''}}">
                                                                            <span class="help-block" id="coupon_maxdisc_amount_product_form_validation"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="{{ $data->coupon_on == '5'?'':'display-none'}}" id="coupon-order-over-input">
                                                                    <div class="col-sm-12">
                                                                        <label for="" class="control-label col-sm-1">Amount<span class="mandatory">*</span></label>
                                                                        <div class="col-sm-4">
                                                                            <input type="text" class="form-control" name="coupon_ordermax_amount" id="coupon_ordermax_amount" value="{{$data->coupon_on == '5'? $data->coupon_ordermax_amount:''}}">
                                                                            <span class="help-block" id="coupon_ordermax_amount_form_validation"></span>
                                                                        </div>
                                                                        <label for="" class="control-label col-sm-4">Max coupon amount<span class="mandatory">*</span></label>
                                                                        <div class="col-sm-3">
                                                                            <input type="text" class="form-control col-sm-3" name="coupon_maxdisc_amount" id="coupon_maxdisc_amount" value="{{$data->coupon_on == '5'? $data->coupon_maxdisc_amount:''}}">
                                                                            <span class="help-block" id="coupon_maxdisc_amount_order_form_validation"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="{{ $data->coupon_on == '4'?'':'display-none'}}" id="coupon-entire-order-input">
                                                                    <div class="col-sm-6">
                                                                        <label for="" class="control-label col-sm-5">Max coupon amount<span class="mandatory">*</span></label>
                                                                        <div class="col-sm-4">
                                                                            <input type="text" class="form-control col-sm-3" name="coupon_maxdisc_amount" id="coupon_maxdisc_amount" value="{{$data->coupon_on == '4'? $data->coupon_maxdisc_amount:''}}">
                                                                            <span class="help-block" id="coupon_maxdisc_amount_entire_form_validation"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="" class="control-label col-sm-2">Coupon Valid from<span class="mandatory">*</span></label>
                                                        <div class="col-sm-3">
                                                            <div class="input-group date">   
                                                                <input type="text" class="form-control" name="coupon_validfrom" id="coupon_validfrom" value="{{$data->coupon_validfrom}}" palceholder="DD-MM-YY">
                                                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                            </div>
                                                            <span class="help-block" id="coupon_validfrom_form_validation"></span>
                                                        </div>
                                                        <label for="" class="control-label col-sm-2">Coupon Valid to<span class="mandatory">*</span></label>
                                                        <div class="col-sm-3">
                                                            <div class="input-group date"> 
                                                                <input type="text" class="form-control" name="coupon_validto" id="coupon_validto" value="{{$data->coupon_validto}}" palceholder="DD-MM-YY">
                                                                <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                            </div>
                                                            <span class="help-block" id="coupon_validto_form_validation"></span>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="" class="control-label col-sm-2">Coupon can be used<span class="mandatory">*</span></label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" name="coupon_maxuse" id="coupon_maxuse" value="{{$data->coupon_maxuse}}">
                                                            <span class="help-block" id="coupon_maxuse_form_validation"></span>
                                                        </div>
                                                        <span>times</span> 
                                                        
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="" class="control-label col-sm-2">Coupon can be used<span class="mandatory">*</span></label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" name="coupon_usermaxuse" id="coupon_usermaxuse" value="{{$data->coupon_usermaxuse}}">
                                                            <span class="help-block" id="coupon_usermaxuse_form_validation"></span>
                                                        </div>
                                                        <span>times by a single user</span> 
                                                        
                                                    </div>
                                                    {{csrf_field()}}
                                                    <input type="hidden" name="id" id="id" value="{{$data->id}}">
                                                    <div class="form-group">
                                                        <div class="col-sm-3 col-sm-offset-2">
                                                            <input type="submit" class="btn btn-primary btn-block" value="Update">
                                                        </div>
                                                        
                                                    </div>
                                                </form>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>
@endif
@endsection