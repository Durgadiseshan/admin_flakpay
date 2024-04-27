@php
    use App\User;
    use App\BusinessCategory;
    use App\BusinessType;
    use App\BusinessSubCategory;
    use App\AppOption;

    $business_type = BusinessType::business_type();
    $category_type = BusinessCategory::get_category();
    $ban_products = AppOption::get_banned_products();
    $merchants = User::get_tmode_bgverfied_merchants();
@endphp
@extends('layouts.employeecontent')
@section('employeecontent')
<div class="row">
    <div class="col-sm-12 padding-20">
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs" id="transaction-tabs">
                    <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#new-background-verification">New/Edit Background Verification</a></li>      
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">                        
                    <div id="new-background-verification" class="tab-pane fade in active">
                        <div class="row">
                            <div class="col-sm-12">
                                <a href="{{route('background-check','ryapay-OXS3k7jc')}}" class="btn btn-primary btn-sm pull-right">Go Back</a>
                            </div>
                        </div>
                        @if($form == "create")
                        <div class="row">
                            <form class="form-horizontal">
                                <div class="form-group">
                                    <label for="input" class="col-sm-2 control-label">Merchant:</label>
                                    <div class="col-sm-3">
                                        <select name="merchant_id" class="form-control" onchange="getMerchantBusisDetails(this)">
                                            <option value="">--Select--</option>
                                            @foreach($merchants as $merchant)
                                                <option value="{{$merchant->id}}">{{$merchant->name}}</option>
                                            @endforeach;
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div id="verification-form">
                                    
                                </div>
                            </div>
                        </div>
                        @else
                        <form method="POST" class="form-horizontal" id="update-background-verification-form">                            
                            <div class="form-group">
                                <label for="input" class="col-sm-2 control-label">Tele Verification:</label>
                                <div class="col-sm-2">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="tele_verify" value="Y" {{($editdata->tele_verify == 'Y')?'checked':''}}>
                                            <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                                            Yes
                                        </label>
                                        <label>
                                            <input type="radio" name="tele_verify" value="N" {{($editdata->tele_verify == 'N')?'checked':''}}>
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
                                            @if($type->id == $editdata->business_type_id)
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
                                            @if($category->id == $editdata->business_category_id)
                                            <option value="{{$category->id}}" selected>{{$category->category_name}}</option>
                                            @else
                                            <option value="{{$category->id}}">{{$category->category_name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>        
                            <div id="sub-category-div" class="form-group" {{($editdata->business_category_id != 18)?"world":"style=display:none;"}}>
                                <label class="control-label col-sm-2" for="email">Business Sub Category:</label>
                                <div class="col-sm-3">
                                    <select name="business_sub_category_id" id="business_sub_category_id" class="col-sm-12 form-control" {{($editdata->business_category_id !=18)?'':'disabled'}}>
                                        <option value="">--Select--</option>
                                        @if($editdata->business_category_id)
                                            @foreach($subcategory_options as $subcategory)
                                                @if($editdata->business_sub_category_id == $subcategory->id)
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
                            <div id="sub-categort-others" class="form-group" {{($editdata->business_category_id == 18)?'':'style=display:none'}}>
                                <label class="control-label col-sm-2" for="email">Business Sub Category:</label>
                                <div class="col-sm-3">
                                    <input type="text" name="business_sub_category" id="business_sub_category" class="form-control" value="{{$editdata->business_sub_category}}" {{($editdata->business_category_id ==18)?'':'disabled'}}>
                                    <div id="business_sub_category_error"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input" class="col-sm-2 control-label">Website:</label>
                                <div class="col-sm-2">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="website_exists" value="Y" onclick="websiteExist(this)" {{($editdata->website_exists == 'Y')?'checked':''}} >
                                            <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                                            Yes
                                        </label>
                                        <label>
                                            <input type="radio" name="website_exists" value="N" onclick="websiteExist(this)"  {{($editdata->website_exists == 'N')?'checked':''}}>
                                            <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                                            No
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div id="website-inputs" {{($editdata->website_exists == 'Y')?'':'style=display:none'}}>
                                <div class="form-group">
                                    <label for="input" class="col-sm-2 control-label">Website Url:</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="website_url" id="website_url" class="form-control" value="{{$editdata->website_url}}" {{($editdata->website_exists == 'Y')?'':'disabled'}}>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input" class="col-sm-2 control-label">Website Contains:</label>
                                    <div class="col-sm-2">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="website_contains" value="terms & condition" {{($editdata->website_contains == 'terms & condition')?'checked':''}} {{($editdata->website_exists == 'Y')?'':'disabled'}}>
                                                <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                                                Terms & Condition
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="website_contains" value="privacy policy" {{($editdata->website_contains == 'privacy policy')?'checked':''}} {{($editdata->website_exists == 'Y')?'':'disabled'}}>
                                                <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                                                Privacy policy
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="website_contains" value="disclaimer" {{($editdata->website_contains == 'disclaimer')?'checked':''}} {{($editdata->website_exists == 'Y')?'':'disabled'}}>
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
                                            <input type="radio" name="ban_product" value="Y" onclick="banProduct(this)" {{($editdata->ban_product == 'Y')?'checked':''}}>
                                            <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                                            Yes
                                        </label>
                                        <label>
                                            <input type="radio" name="ban_product" value="N" onclick="banProduct(this)" {{($editdata->ban_product == 'N')?'checked':''}}>
                                            <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                                            No
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div id="ban-product-inputs" {{($editdata->ban_product == 'Y')?'':'style=display:none'}}>
                                <div class="form-group">
                                    <label for="input" class="col-sm-2 control-label">Banned Products:</label>
                                    <div class="col-sm-3">
                                        <select name="ban_product_id" id="ban_product_id" class="form-control" {{($editdata->ban_product == 'Y')?'':'disabled'}}>
                                            <option value="">--Select--</option>
                                            @foreach($ban_products as $products)
                                                @if($editdata->ban_product_id == $products->id)
                                                    <option value="{{$products->id}}" selected>{{$products->option_value}}</option>
                                                @else
                                                    <option value="{{$products->id}}">{{$products->option_value}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            {{csrf_field()}}
                            <input type="hidden" name="merchant_id" id="merchant_id" value="{{$editdata->merchant_id}}">
                            <input type="hidden" name="id" id="id" value="{{$editdata->id}}"> 
                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-2">
                                    <button type="submit" class="btn btn-primary">Update Report</button>
                                </div>
                            </div>
                            </form>
                        @endif
                        <!-- Porder created modal starts-->
                        <div id="bgcheck-add-response-message-modal" class="modal fade">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <strong id="bgcheck-add-response"></strong>
                                    </div>
                                    <div class="modal-footer">
                                        <form>
                                            <input type="submit" class="btn btn-primary btn-sm" value="OK" onlick="location.reload();"/>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Porder created modal ends-->
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>
@endsection
