@php
    use App\BusinessCategory;
    use App\BusinessType;
    use App\BusinessSubCategory;
    use App\AppOption;
    
    $business_type = BusinessType::business_type();
    $category_type = BusinessCategory::get_category();
    $ban_products = AppOption::get_banned_products();
@endphp
@if(isset($background_verify) && $background_verify)
    @if($form == "create")
    <form method="POST" class="form-horizontal" id="background-verification-form">                            
        <div class="form-group">
            <label for="input" class="col-sm-2 control-label">Tele Verification:</label>
            <div class="col-sm-2">
                <div class="radio">
                    <label>
                        <input type="radio" name="tele_verify" value="Y">
                        <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                        Yes
                    </label>
                    <label>
                        <input type="radio" name="tele_verify" value="N">
                        <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                        No
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="input" class="col-sm-2 control-label">Business Type:</label>
            <div class="col-sm-3">
                <select name="business_type_id" id="business_type_id" class="form-control" required="required">
                    <option value="">--Select--</option>
                        @foreach($business_type as $type)
                            <option value="{{$type->id}}">{{$type->type_name}}</option>
                        @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="input" class="col-sm-2 control-label">Business Category:</label>
            <div class="col-sm-3">
                <select name="business_category_id" id="business_category_id" class="form-control" onchange="getsubcategory(this)">
                    <option value="">--Select--</option>
                    @foreach($category_type as $category)
                        <option value="{{$category->id}}">{{$category->category_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div id="sub-category-div" class="form-group">
            <label class="control-label col-sm-2" for="email">Business Sub Category:</label>
            <div class="col-sm-3">
                <select name="business_sub_category_id" id="business_sub_category_id" class="col-sm-12 form-control">
                    <option value="">--Select--</option>
                </select>
                <div id="business_sub_category_id_error"></div>
            </div>
        </div>

        <div id="sub-categort-others" class="form-group" style="display:none">
            <label class="control-label col-sm-2" for="email">Business Sub Category:</label>
            <div class="col-sm-3">
                <input type="text" name="business_sub_category" id="business_sub_category" class="form-control" value="">
                <div id="business_sub_category_error"></div>
            </div>
        </div>
        <div class="form-group">
            <label for="input" class="col-sm-2 control-label">Website:</label>
            <div class="col-sm-2">
                <div class="radio">
                    <label>
                        <input type="radio" name="website_exists" value="Y">
                        <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                        Yes
                    </label>
                    <label>
                        <input type="radio" name="website_exists" value="N">
                        <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                        No
                    </label>
                </div>
            </div>
        </div>
        <div id="website-inputs" style="display: none;">
            <div class="form-group">
                <label for="input" class="col-sm-2 control-label">Website Url:</label>
                <div class="col-sm-3">
                    <input type="text" name="website_url" id="input" class="form-control" value="">
                </div>
            </div>
            <div class="form-group">
                <label for="input" class="col-sm-2 control-label">Website Contains:</label>
                <div class="col-sm-2">
                    <div class="radio">
                        <label>
                            <input type="radio" name="website_contains" value="terms & condition">
                            <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                            Terms & Condition
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="website_contains" value="privacy policy">
                            <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                            Privacy policy
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="website_contains" value="disclaimer">
                            <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                            Disclaimer
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="input" class="col-sm-2 control-label">Ban Product:</label>
            <div class="col-sm-2">
                <div class="radio">
                    <label>
                        <input type="radio" name="ban_product" value="Y">
                        <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                        Yes
                    </label>
                    <label>
                        <input type="radio" name="ban_product" value="N">
                        <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                        No
                    </label>
                </div>
            </div>
        </div>
        <div id="ban-product-inputs" style="display: none;">
            <div class="form-group">
                <label for="input" class="col-sm-2 control-label">Banned Products:</label>
                <div class="col-sm-3">
                    <select name="ban_product_id" id="ban_product_id" class="form-control" required="required">
                        <option value="">--Select--</option>
                        @foreach($ban_products as $products)
                            <option value="{{$products->id}}">{{$products->option_value}}</option>                            
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        {{csrf_field()}}
        <input type="hidden" name="merchant_id" id="merchant_id" value="">
        <div class="form-group">
            <div class="col-sm-10 col-sm-offset-2">
                <button type="submit" class="btn btn-primary">Submit Report</button>
            </div>
        </div>
    </form>
    @elseif($form == "existing_merchant_background")
    <form method="POST" class="form-horizontal" id="background-verification-form">                            
        <div class="form-group">
            <label for="input" class="col-sm-2 control-label">Tele Verification:</label>
            <div class="col-sm-2">
                <div class="radio">
                    <label>
                        <input type="radio" name="tele_verify" value="Y">
                        <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                        Yes
                    </label>
                    <label>
                        <input type="radio" name="tele_verify" value="N" checked>
                        <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                        No
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="input" class="col-sm-2 control-label">Business Type:</label>
            <div class="col-sm-3">
                <select name="business_type_id" id="business_type_id" class="form-control" required="required">
                    <option value="">--Select--</option>
                    @foreach($business_type as $type)
                        @if($type->id == $business_details->business_type_id)
                        <option value="{{$type->id}}" selected>{{$type->type_name}}</option>
                        @else
                        <option value="{{$type->id}}">{{$type->type_name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="input" class="col-sm-2 control-label">Business Category:</label>
            <div class="col-sm-3">
                <select name="business_category_id" id="business_category_id" class="form-control" onchange="getsubcategory(this)">
                    <option value="">--Select--</option>
                    @foreach($category_type as $category)
                        @if($category->id == $business_details->business_category_id)
                        <option value="{{$category->id}}" selected>{{$category->category_name}}</option>
                        @else
                        <option value="{{$category->id}}">{{$category->category_name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>        
        <div id="sub-category-div" class="form-group" {{($business_details->business_category_id != 18)?"world":"style=display:none;"}}>
            <label class="control-label col-sm-2" for="email">Business Sub Category:</label>
            <div class="col-sm-3">
                <select name="business_sub_category_id" id="business_sub_category_id" class="col-sm-12 form-control" {{($business_details->business_category_id !=18)?'':'disabled'}}>
                    <option value="">--Select--</option>
                    @if($business_details->business_category_id)
                        @foreach($subcategory_options as $subcategory)
                            @if($business_details->business_sub_category_id == $subcategory->id)
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
        <div id="sub-categort-others" class="form-group" {{($business_details->business_category_id == 18)?'':'style=display:none;'}}>
            <label class="control-label col-sm-2" for="email">Business Sub Category:</label>
            <div class="col-sm-3">
                <input type="text" name="business_sub_category" id="business_sub_category" class="form-control" value="{{$business_details->business_sub_category}}" {{($business_details->business_category_id ==18)?'':'disabled'}}>
                <div id="business_sub_category_error"></div>
            </div>
        </div>
        <div class="form-group">
            <label for="input" class="col-sm-2 control-label">Website:</label>
            <div class="col-sm-2">
                <div class="radio">
                    <label>
                        <input type="radio" name="website_exists" value="Y"  onclick="websiteExist(this)">
                        <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                        Yes
                    </label>
                    <label>
                        <input type="radio" name="website_exists" value="N"  onclick="websiteExist(this)" checked>
                        <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                        No
                    </label>
                </div>
            </div>
        </div>
        <div id="website-inputs" style="display: none;">
            <div class="form-group">
                <label for="input" class="col-sm-2 control-label">Website Url:</label>
                <div class="col-sm-3">
                    <input type="text" name="website_url" id="input" class="form-control" value="" disabled>
                </div>
            </div>
            <div class="form-group">
                <label for="input" class="col-sm-2 control-label">Website Contains:</label>
                <div class="col-sm-2">
                    <div class="radio">
                        <label>
                            <input type="radio" name="website_contains" value="terms & condition" disabled>
                            <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                            Terms & Condition
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="website_contains" value="privacy policy" disabled>
                            <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                            Privacy policy
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="website_contains" value="disclaimer" disabled>
                            <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                            Disclaimer
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="input" class="col-sm-2 control-label">Ban Product:</label>
            <div class="col-sm-2">
                <div class="radio">
                    <label>
                        <input type="radio" name="ban_product" value="Y" onclick="banProduct(this)">
                        <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                        Yes
                    </label>
                    <label>
                        <input type="radio" name="ban_product" value="N"  onclick="banProduct(this)" checked>
                        <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                        No
                    </label>
                </div>
            </div>
        </div>
        <div id="ban-product-inputs" style="display: none;">
            <div class="form-group">
                <label for="input" class="col-sm-2 control-label">Banned Products:</label>
                <div class="col-sm-3">
                    <select name="ban_product_id" id="ban_product_id" class="form-control" disabled>
                        <option value="">--Select--</option>
                        @foreach($ban_products as $products)
                            <option value="{{$products->id}}">{{$products->option_value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        {{csrf_field()}}
        <input type="hidden" name="merchant_id" id="merchant_id" value="">
        <div class="form-group">
            <div class="col-sm-10 col-sm-offset-2">
                <button type="submit" class="btn btn-primary">Submit Report</button>
            </div>
        </div>
    </form>
    @endif
@endif

