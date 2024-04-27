@extends('merchant.settings')

@section('personal-info')
<div class="row">

    <form class="form-horizontal" id="personal-info-form">
        
        <strong class="padding-20">Contact Details</strong>
        @foreach($formdata["basicinfo"] as $merchantinfo)
        <div class="form-group"> 
            <label class="control-label col-sm-2" for="name">Contact Name:<span class="mandatory">*</span></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="name" name="name" value="{{$merchantinfo->name}}">
                <span id="name_error"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="email">Contact Email:<span class="mandatory">*</span></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="email" name="email" value="{{$merchantinfo->email}}">
                <span id="email_error"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="phone">Contact Mobile:<span class="mandatory">*</span></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="mobile_no" name="mobile_no" value="{{$merchantinfo->mobile_no}}">
                <span id="mobile_no_error"></span>
            </div>
        </div>
        @endforeach
        <strong class="padding-20">Business Info</strong>
        @if(!empty($formdata["merchant_business"]))
            @foreach($formdata["merchant_business"] as $merchantbusiness) 
                <div class="form-group"> 
                    <label class="control-label col-sm-2" for="name">Business Type:<span class="mandatory">*</span></label>
                    <div class="col-sm-3">
                        <select name="business_type_id" id="business_type_id" class="col-sm-12 form-control" onchange="setbusinessdetails(this);">
                            <option value="">--Select--</option>
                            @foreach($formdata["btype"] as $type)

                                @if($type->id == $merchantbusiness->business_type_id)
                                <option value="{{$type->id}}" selected>{{$type->type_name}}</option>
                                @else
                                <option value="{{$type->id}}">{{$type->type_name}}</option>
                                @endif

                            @endforeach
                        </select>
                        <span id="business_type_id_error"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="email">Business Category:<span class="mandatory">*</span></label>
                    <div class="col-sm-3">
                        <select name="business_category_id" id="business_category_id" class="col-sm-12 form-control" onchange="getsubcategory(this)">
                            <option value="">--Select--</option>
                            @foreach($formdata["bcategory"] as $bcategory)

                                @if($bcategory->id == $merchantbusiness->business_category_id)
                                <option value="{{$bcategory->id}}" selected>{{$bcategory->category_name}}</option>
                                @else
                                <option value="{{$bcategory->id}}">{{$bcategory->category_name}}</option>
                                @endif

                            @endforeach
                        </select>
                        <span id="business_category_id_error"></span>
                    </div>
                </div>
                <div id="sub-category-div" class="form-group {{ ($merchantbusiness->business_sub_category_id!='')?'':display-none}}">
                    <label class="control-label col-sm-2" for="email">Business Sub Category:<span class="mandatory">*</span></label>
                    <div class="col-sm-3">
                        <select name="business_sub_category_id" id="business_sub_category_id" class="col-sm-12 form-control">
                        @foreach($formdata["bsubcategory"] as $bsubcategory)

                            @if($bsubcategory->id == $merchantbusiness->business_sub_category_id)
                            <option value="{{$bsubcategory->id}}" selected>{{$bsubcategory->sub_category_name}}</option>
                            @else
                            <option value="{{$bsubcategory->id}}">{{$bsubcategory->sub_category_name}}</option>
                            @endif

                        @endforeach
                        </select>
                        <span id="business_sub_category_id_error"></span>
                    </div>
                    
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="email">Billing Label:<span class="mandatory">*</span></label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="billing_label" name="billing_label" value="{{$merchantbusiness->billing_label}}">
                        <span id="billing_label_error"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="web-app-url" class="control-label col-sm-2">WebApp/Url:<span class="mandatory">*</span></label>
                    <label class="radio-inline"><input type="radio" name="webapp_exist" id="website" value="Y"   {{($merchantbusiness->webapp_exist == 'Y')?'checked':''}}>Website/App:</label>
                    <label class="radio-inline"><input type="radio" name="webapp_exist" id="nowebsite" value="N" {{($merchantbusiness->webapp_exist == 'N')?'checked':''}}>We dont have website</label>
                </div>
                <div class="form-group">
                    <div class="col-sm-3 col-sm-offset-2">
                        <input type="text" class="form-control {{($merchantbusiness->webapp_exist == 'N')?'display-none':''}}"  id="webapp_url" name="webapp_url" value="{{$merchantbusiness->webapp_url==''?' ':$merchantbusiness->webapp_url}}" {{($merchantbusiness->webapp_exist == 'N')?'disabled':''}}/>
                        <span id="website_url_error"></span>
                    </div>
                </div>
                <strong class="padding-20">Business Detail Info</strong>
                <div id="form-business-name" class="form-group {{$merchantbusiness->business_name ==''?'display-none':''}}"> 
                    <label class="control-label col-sm-2" for="pan-number">Business Name:<span class="mandatory">*</span></label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="business_name" name="business_name" value="{{$merchantbusiness->business_name == ''?'':$merchantbusiness->business_name}}" placeholder="Business Name" {{$merchantbusiness->business_name == ''?'disabled':''}}>
                        <span id="business_name_error"></span>
                    </div>
                </div>
                <div id="form-llpin-number" class="form-group {{$merchantbusiness->llpin_number ==''?'display-none':''}}"> 
                    <label class="control-label col-sm-2" for="pan-number">LLPIN:<span class="mandatory">*</span></label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="llpin_number" name="llpin_number" value="{{$merchantbusiness->llpin_number == ''?'':$merchantbusiness->llpin_number}}" placeholder="LLPIN Number" {{$merchantbusiness->llpin_number == ''?'disabled':''}}>
                        <span id="llpin_number_error"></span>
                    </div>
                </div>
                <div class="form-group"> 
                    <label class="control-label col-sm-2" for="pan-number">PAN Number:<span class="mandatory">*</span></label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="pan_number" name="pan_number" value="{{$merchantbusiness->pan_number ==''?'':$merchantbusiness->pan_number}}" placeholder="Business Owner's PAN">
                        <span id="pan_number_error"></span>
                    </div>
                </div>
                <div id="form-pan-holder" class="form-group {{$merchantbusiness->pan_holder_name == '' ?'display-none':''}}">
                    <label class="control-label col-sm-2" for="pan-holder-name">PAN Holder's Name:<span class="mandatory">*</span></label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="pan_holder_name" name="pan_holder_name" value="{{$merchantbusiness->pan_holder_name ==''?'':$merchantbusiness->pan_holder_name}}" placeholder="Name as per PAN" {{$merchantbusiness->pan_holder_name == ''?'disabled':''}}>
                        <span id="pan_holder_name"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="address">Address:<span class="mandatory">*</span></label>
                    <div class="col-sm-3">
                        <textarea class="form-control" name="address" id="address" cols="30" rows="3" place="Enter Address Detaily with Door No">{{$merchantbusiness->address == '' ?' ':$merchantbusiness->address}}</textarea>
                        <span id="address_error"></span>
                    </div>
                    
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="pincode">Pincode:<span class="mandatory">*</span></label>
                    <div class="col-sm-3">
                    <input type="text" class="form-control" name="pincode" id="pincode" value="{{$merchantbusiness->pincode == '' ?' ':$merchantbusiness->pincode}}">
                    <span id="pincode_error"></span>
                    </div>

                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="city">City:<span class="mandatory">*</span></label>
                    <div class="col-sm-3">
                    <input type="text" class="form-control" name="city" id="city" value="{{$merchantbusiness->city == '' ?' ':$merchantbusiness->city}}">
                    <span id="city_error"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="state">State<span class="mandatory">*</span></label>
                    <div class="col-sm-3">
                        <select name="state" id="state" class="col-sm-12 form-control">
                            <option value="">--Select--</option>
                            @foreach($formdata["statelist"] as $statelist)
                                @if($statelist->id == $merchantbusiness->state)
                                <option value="{{$statelist->id}}" selected>{{$statelist->state_name}}</option>
                                @else
                                <option value="{{$statelist->id}}">{{$statelist->state_name}}</option>
                                @endif
                            @endforeach
                        </select>
                        <span id="state_error"></span>
                    </div>
                </div>
                <div class="col-sm-3 col-sm-offset-2">
                    {{ csrf_field() }}
                    <input type="submit" class="btn btn-primary" value="Save & Activate">
                    <input type="hidden" name="id" value="{{$merchantbusiness->id == '' ?' ':$merchantbusiness->id}}">
                </div>
            @endforeach
        @else
            <div class="form-group"> 
                <label class="control-label col-sm-2" for="name">Business Type:<span class="mandatory">*</span></label>
                <div class="col-sm-3">
                    <select name="business_type_id" id="business_type_id" class="col-sm-12 form-control" onchange="setbusinessdetails(this);">
                        <option value="">--Select--</option>
                        @foreach($formdata["btype"] as $type)
                            <option value="{{$type->id}}">{{$type->type_name}}</option>
                        @endforeach
                    </select>
                    <span id="business_type_id_error"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="email">Business Category:<span class="mandatory">*</span></label>
                <div class="col-sm-3">
                    <select name="business_category_id" id="business_category_id" class="col-sm-12 form-control" onchange="getsubcategory(this)">
                        <option value="">--Select--</option>
                        @foreach($formdata["bcategory"] as $bcategory)
                            <option value="{{$bcategory->id}}">{{$bcategory->category_name}}</option>
                        @endforeach
                    </select>
                    <span id="business_category_id_error"></span>
                </div>
            </div>
            <div id="sub-category-div" class="form-group display-none">
                <label class="control-label col-sm-2" for="email">Business Sub Category:<span class="mandatory">*</span></label>
                <div class="col-sm-3">
                    <select name="business_sub_category_id" id="business_sub_category_id" class="col-sm-12 form-control">

                    </select>
                    <span id="business_sub_category_id_error"></span>
                </div>
            </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="email">Billing Label:<span class="mandatory">*</span></label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="billing_label" name="billing_label" value="">
                        <span id="billing_label_error"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="web-app-url" class="control-label col-sm-2">WebApp/Url:<span class="mandatory">*</span></label>
                    <label class="radio-inline"><input type="radio" name="webapp_exist" id="website" value="Y" >Website/App:</label>
                    <label class="radio-inline"><input type="radio" name="webapp_exist" id="nowebsite" value="N" checked>We dont have website</label>
                </div>
                <div class="form-group">
                    <div class="col-sm-3 col-sm-offset-2">
                        <input type="text" class="form-control display-none" id="webapp_url" name="webapp_url" value="" disabled/>
                        <span id="website_url_error"></span>
                    </div>
                </div>
                <strong class="padding-20">Business Detail Info</strong>
                <div id="form-business-name" class="form-group display-none"> 
                    <label class="control-label col-sm-2" for="pan-number">Business Name:<span class="mandatory">*</span></label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="business_name" name="business_name" value="" placeholder="Business Name" disabled>
                        <span id="business_name_error"></span>
                    </div>
                </div>
                <div id="form-llpin-number" class="form-group display-none"> 
                    <label class="control-label col-sm-2" for="pan-number">LLPIN:<span class="mandatory">*</span></label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="llpin_number" name="llpin_number" value="" placeholder="LLPIN Number" disabled>
                        <span id="llpin_number_error"></span>
                    </div>
                </div>
                <div class="form-group"> 
                    <label class="control-label col-sm-2" for="pan-number">PAN Number:<span class="mandatory">*</span></label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="pan_number" name="pan_number" value="" placeholder="Business Owner's PAN">
                        <span id="pan_number_error"></span>
                    </div>
                </div>
                <div id="form-pan-holder" class="form-group display-none">
                    <label class="control-label col-sm-2" for="pan-holder-name">PAN Holder's Name:<span class="mandatory">*</span></label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="pan_holder_name" name="pan_holder_name" value="" placeholder="Name as per PAN" disabled>
                        <span id="pan_holder_name"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="address">Address:<span class="mandatory">*</span></label>
                    <div class="col-sm-3">
                        <textarea class="form-control" name="address" id="address" cols="30" rows="3" place="Enter Address Detaily with Door No"></textarea>
                        <span id="address_error"></span>
                    </div>
                    
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="pincode">Pincode:<span class="mandatory">*</span></label>
                    <div class="col-sm-3">
                    <input type="text" class="form-control" name="pincode" id="pincode" value="">
                    <span id="pincode_error"></span>
                    </div>

                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="city">City:<span class="mandatory">*</span></label>
                    <div class="col-sm-3">
                    <input type="text" class="form-control" name="city" id="city" value="">
                    <span id="city_error"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="state">State<span class="mandatory">*</span></label>
                    <div class="col-sm-3">
                        <select name="state" id="state" class="col-sm-12 form-control">
                            <option value="">--Select--</option>
                            @foreach($formdata["statelist"] as $statelist)
                                <option value="{{$statelist->id}}">{{$statelist->state_name}}</option>
                            @endforeach
                        </select>
                        <span id="state_error"></span>
                    </div>
                </div>
                <div class="col-sm-3 col-sm-offset-2">
                    {{ csrf_field() }}
                    <input type="submit" class="btn btn-primary" value="Save & Activate">
                    <input type="hidden" name="id" value="">
                </div>
        @endif
    </form>
        <!-- show personal details response modal starts-->
    <div id="personal-message-modal" class="modal fade">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body">
                    <strong id="personal-response-message"></strong>
                </div>
                <div class="modal-footer">
                    <form>
                        <input type="submit" class="btn btn-primary btn-sm" value="OK" onlick="location.reload();$('#personal-message-modal').modal('hide')"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- show personal details response modal ends-->
</div>
@endsection
       

