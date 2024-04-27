@php
    use App\MerchantBusiness;
    use App\BusinessType;
    use App\BusinessCategory;
    use App\State;
    use App\BusinessSubCategory;
    use App\MerchantDocument;  
    use App\AppOption;

    $business_type = new BusinessType();
    $btype = $business_type->get_business_type();
    $business_category = new BusinessCategory();
    $business_subcategory = new BusinessSubCategory();
    $merchant_business =  new MerchantBusiness();

   
    $business = $merchant_business->get_merchant_business_details()[0];

    $bscategory = array();    
    if($business->business_category_id)
    {
        $bscategory = $business_subcategory->get_business_subcategory(["id"=>$business->business_category_id]);
    }
        



    $statelists =  State::state_list();
    $bcategory = $business_category->get_business_category();
    $business_expenditure = AppOption::get_business_expenditure();
    
@endphp
@if($form == "company")
<h5 class="text-center margin-bottom-lg"><strong>Company Info</strong></h5>
<div class="form-group">
    <label for="business_expenditure" class="col-md-4 control-label">Montly Expenditure:<span class="mandatory">*</span></label>
    <div class="col-md-4">
        <select name="business_expenditure" id="business_expenditure" class="col-sm-12 form-control">
            <option value="">--Select--</option>
            @foreach($business_expenditure as $expenditure)
                @if($business->business_expenditure == $expenditure->id)
                    <option value="{{$expenditure->id}}" selected="selected">{{$expenditure->option_value}}</option>
                @else
                    <option value="{{$expenditure->id}}">{{$expenditure->option_value}}</option>
                @endif
            @endforeach
        </select>
        <div id="business_expenditure_error"></div>
    </div>
</div>
<div class="form-group">
    <label for="business_name" class="col-md-4 control-label">Company Name:<span class="mandatory">*</span></label>
    <div class="col-md-4">
        <input id="business_name" type="text" class="form-control" name="business_name" value="{{$business->business_name}}">
        <div id="business_name_error"></div>
    </div>
</div>

<div class="form-group">
    <label for="address" class="col-md-4 control-label">Company Address:<span class="mandatory">*</span></label>                    
    <div class="col-md-4">
        <Textarea id="address" type="text" class="form-control" name="address">{{$business->address}}</Textarea>
        <div id="address_error"></div>
    </div>
</div>

<div class="form-group">
    <label for="pincode" class="col-md-4 control-label">Pincode:<span class="mandatory">*</span></label>
    <div class="col-md-4">
        <input id="pincode" type="text" class="form-control" name="pincode" value="{{$business->pincode}}">
        <div id="pincode_error"></div>
    </div>
</div>

<div class="form-group">
    <label for="city" class="col-md-4 control-label">City:<span class="mandatory">*</span></label>
    <div class="col-md-4">
        <input id="city" type="text" class="form-control" name="city" value="{{$business->city}}">
        <div id="city_error"></div>
    </div>
</div>
<div class="form-group">
    <label for="state" class="col-md-4 control-label">State:<span class="mandatory">*</span></label>
    <div class="col-md-4">
        <select id="state" class="form-control" name="state" onchange="stateGST(this)">
            <option value="">--Select--</option>
            @foreach($statelists as $state)
                @if($business->state == $state->id)
                    @php($gst_code = $state->gst_code)
                    <option value="{{$state->id}}" selected>{{$state->state_name}}</option>
                @else
                    <option value="{{$state->id}}">{{$state->state_name}}</option>
                @endif
            @endforeach
        </select>
        <div id="state_error"></div>
    </div>
</div>
<div class="form-group">
    <label for="country" class="col-md-4 control-label">Country:<span class="mandatory">*</span></label>
    <div class="col-md-4">
        <input id="country" type="text" class="form-control" name="country" value="India" readonly>
    </div>
</div>
<input type="hidden" class="form-control" name="_token" value="{{csrf_token()}}">
<input type="hidden" name="gst_state" id="gst_state" value="{{$gst_code}}">
@elseif($form == "business-info")
<h5 class="text-center margin-bottom-lg"><strong>Business Info</strong></h5>
<div class="form-group"> 
    <label class="control-label col-sm-4" for="name">Business Type:<span class="mandatory">*</span></label>
    <div class="col-sm-4">
        <select name="business_type_id" id="business_type_id" class="col-sm-12 form-control" onchange="setbusinessdetails(this);">
            <option value="">--Select--</option>
            @foreach($btype as $type)
                @if($business->business_type_id == $type->id)
                    <option value="{{$type->id}}" selected="selected">{{$type->type_name}}</option>
                @else
                    <option value="{{$type->id}}">{{$type->type_name}}</option>
                @endif
            @endforeach
        </select>
        <div id="business_type_id_error"></div>
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-4" for="email">Business Category:<span class="mandatory">*</span></label>
    <div class="col-sm-4">
        <select name="business_category_id" id="business_category_id" class="col-sm-12 form-control" onchange="getsubcategory(this)">
            <option value="">--Select--</option>
            @foreach($bcategory as $bcategory)
                @if($business->business_category_id == $bcategory->id)
                <option value="{{$bcategory->id}}" selected="selected">{{$bcategory->category_name}}</option>
                @else
                <option value="{{$bcategory->id}}">{{$bcategory->category_name}}</option>
                @endif
            @endforeach
        </select>
        <div id="business_category_id_error"></div>
    </div>
</div>
<div id="sub-category-div" class="form-group" style="{{$business->business_category_id !=18 ?'':'display:none'}}">
    <label class="control-label col-sm-4" for="email">Business Sub Category:<span class="mandatory">*</span></label>
    <div class="col-sm-4">
        <select name="business_sub_category_id" id="business_sub_category_id" class="col-sm-12 form-control" {{($business->business_category_id !=18)?'':'disabled'}}>
            <option value="">--Select--</option>
            @if($business->business_category_id)
                @foreach($bscategory as $subcategory)
                    @if($business->business_sub_category_id == $subcategory->id)
                    <option value="{{$subcategory->id}}" selected="selected">{{$subcategory->sub_category_name}}</option>
                    @else
                    <option value="{{$subcategory->id}}">{{$subcategory->sub_category_name}}</option>
                    @endif
                @endforeach
            @endif
        </select>
        <div id="business_sub_category_id_error"></div>
    </div>
</div>
<div id="sub-categort-others" class="form-group" style='{{$business->business_category_id ==18 ?"":"display:none"}}'>
    <label for="input" class="col-sm-4 control-label">Business Sub Category:<span class="mandatory">*</span></label>
    <div class="col-sm-4">
        <input type="text" name="business_sub_category" id="business_sub_category" class="form-control" value="{{$business->business_sub_category}}" {{$business->business_category_id ==18 ?"":"disabled"}}>
    </div>
</div>
<div class="form-group">
    <label for="web-app-url" class="control-label col-sm-4">WebApp/Url:<span class="mandatory">*</span></label>
    <div class="col-sm-4 radio">
        <label>
            <input type="radio" name="webapp_exist" class="form-control" id="website" value="{{($business->webapp_exist =='Y')?'Y':'N'}}" {{($business->webapp_exist=='Y')?'checked':''}}>
            <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
            Website/App:
        </label>
    </div>
    <div class="col-sm-4 radio">
        <label>
            <input type="radio" name="webapp_exist" class="form-control" id="nowebsite" value="{{($business->webapp_exist =='N')?'N':'Y'}}" {{($business->webapp_exist=='N')?'checked':''}}>
            <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
            We dont have website
        </label>
    </div>
</div>
<div id="web-url" style="{{($business->webapp_exist=='Y')?'':'display:none'}}">
    <div class="form-group">
        <div class="col-sm-4 col-sm-offset-4">
            <input type="text" class="form-control" id="webapp_url" name="webapp_url" aria-describedby="basic-addon1" value="{{$business->webapp_url}}" {{($business->webapp_exist=='Y')?'':'disabled'}}/>
            <div id="webapp_url_error"></div>
        </div>
    </div>
</div>
<div class="form-group"> 
    <label class="control-label col-sm-4" for="pan-number">Bank Name:<span class="mandatory">*</span></label>
    <div class="col-sm-4">
        <input type="text" class="form-control" id="bank_name" name="bank_name" value="{{$business->bank_name}}" placeholder="Bank Name" onkeyup="validateName('bank_name')">
        <div id="bank_name_error"></div>
    </div>
</div>
<div class="form-group"> 
    <label class="control-label col-sm-4" for="pan-number">Bank Acc No:<span class="mandatory">*</span></label>
    <div class="col-sm-4">
        <input type="text" class="form-control" id="bank_acc_no" name="bank_acc_no" value="{{$business->bank_acc_no}}" placeholder="Bank Ac no" onkeyup="acceptOnlyNumeric('bank_acc_no','bank_acc_no_error')">
        <div id="bank_acc_no_error"></div>
    </div>
</div>
<div class="form-group"> 
    <label class="control-label col-sm-4" for="pan-number">Bank IFSC Code:<span class="mandatory">*</span></label>
    <div class="col-sm-4">
        <input type="text" class="form-control" id="bank_ifsc_code" name="bank_ifsc_code" value="{{$business->bank_ifsc_code}}" placeholder="Bank IFSC" onkeyup="acceptOnlyAlphaNumeric('bank_ifsc_code','bank_ifsc_code_error')">
        <div id="bank_ifsc_code_error"></div>
    </div>
</div>
<input type="hidden" class="form-control" name="_token" value="{{csrf_token()}}"> 
@elseif($form == "business-card")
<h5 class="text-center margin-bottom-lg"><strong>Business Cards Info</strong></h5>
<div id="ajax-business-detail-info-response-message" class="text-center"></div>
<div class="form-group"> 
    <label class="control-label col-sm-4" for="pan-number">Company PAN No:<span class="mandatory">*</span></label>
    <div class="col-sm-4">
        <input type="text" class="form-control" id="comp_pan_number" name="comp_pan_number" value="{{$business->comp_pan_number}}" placeholder="Company Pan" onkeyup="ValidateCompanyPAN('comp_pan_number','comp_pan_number_error');">
        <div id="comp_pan_number_error"></div>
    </div>
</div>
<div class="form-group"> 
    <label class="control-label col-sm-4" for="pan-number">Company GST:</label>
    <div class="col-sm-4">
        <input type="text" class="form-control not-mandatory" id="comp_gst" name="comp_gst" value="{{$business->comp_gst}}" placeholder="Company GST" onkeyup="ActivevalidateGSTno('comp_gst','comp_gst_error');">
        <div id="comp_gst_error"></div>
    </div>
</div>
<div class="form-group"> 
    <label class="control-label col-sm-4" for="pan-number">Authorized Signatory PAN No:<span class="mandatory">*</span></label>
    <div class="col-sm-4">
        <input type="text" class="form-control" id="mer_pan_number" name="mer_pan_number" value="{{$business->mer_pan_number}}" placeholder="Authorized Signatory PAN No" onkeyup="ValidatePAN('mer_pan_number','mer_pan_number_error');">
        <div id="mer_pan_number_error"></div>
    </div>
</div>
<div class="form-group"> 
    <label class="control-label col-sm-4" for="pan-number">Authorized Signatory Aadhar No:<span class="mandatory">*</span></label>
    <div class="col-sm-4">
        <input type="text" class="form-control" id="mer_aadhar_number" name="mer_aadhar_number" value="{{$business->mer_aadhar_number}}" placeholder="Authorized Signatory Aadhar No" onkeyup="validateAadharCard('mer_aadhar_number','mer_aadhar_number_error')">
        <div id="mer_aadhar_number_error"></div>
    </div>
</div>
<div class="form-group"> 
    <label class="control-label col-sm-4" for="pan-number">Authorized Signatory Name:<span class="mandatory">*</span></label>
    <div class="col-sm-4">
        <input type="text" class="form-control" id="mer_name" name="mer_name" value="{{$business->mer_name}}" placeholder="Authorized Signatory Name">
        <div id="mer_name_error"></div>
    </div>
</div>
<input type="hidden" class="form-control" name="_token" value="{{csrf_token()}}">
@endif