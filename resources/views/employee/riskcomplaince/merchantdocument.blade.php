@php
use App\User;
$merchants = User::get_tmode_bgverfied_merchants();
@endphp
@extends('layouts.employeecontent')
@section('employeecontent')
<style>
    input[type="file"] {
        display: block !important;
    }
 
    .error {
            color: red;
        }


</style>
@include('layouts.flash')
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
                    {{-- <li><a data-toggle="tab" class="show-pointer" data-target="#{{str_replace(' ','-',strtolower($value->link_name))}}">{{$value->link_name}}</a></li> --}}
                    @endif
                    @endforeach
                    @else
                    <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#{{str_replace(' ','-',strtolower($sublink_name))}}">{{$sublink_name}}</a></li>
                    @endif
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
   
                    @if(count($sublinks) > 0)
                    @foreach($sublinks as $index => $value)
                    @if($index == 0)
                    <div id="{{str_replace(' ','-',strtolower($sublink_name))}}" class="tab-pane fade in active">
                        <div class="row padding-10">
                            <div class="col-sm-12 mb-4">

                                {{-- <button type="button" style=" margin-bottom:5px;" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Add Merchant</button>  --}}
                                <a href="/flakpay/risk-complaince/merchant/merchantadd"><button type="button" class="btn btn-primary" >Add Merchant</button></a>
                            </div>
                            <div class="col-sm-12">

                                <div id="paginate_document">

                                </div>
                            </div>
                        </div>

                        <!-- add merchant modal  -->
                        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg .modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title">Add Merchant</h4>
                                    </div>
                                    <div class="modal-body">

                                        <form method="post" action="/flakpay/add_merchant" enctype="multipart/form-data">
                                            {{csrf_field()}}

                                            <div class="">


                                                <div class="row" style="margin-left:10px;margin-right:10px;">
                                                    <input type="hidden" id="modalcounter" value="0">
                                                    <div class="col-12" id="personaldetails">
                                                        <div class="">
                                                            <h4 style="border-left: 3px solid red; padding-left:3px;">Personal Details:</h4>

                                                            <div class="form-group form-fit">
    <div class="row">
        <label for="m_name" class="col-sm-3 control-label">Name:<span class="text-danger">*</span></label>
        <div class="col-sm-3">
            <input type="text" name="name" id="m_name" class="form-control" required="required">
            <span id="nameError" class="error"></span>
        </div>
        <label for="m_email" class="col-sm-3 control-label">Email:<span class="text-danger">*</span></label>
        <div class="col-sm-3">
            <input type="text" name="email" id="m_email" class="form-control" required="required">
            <span id="emailError" class="error"></span>
        </div>
    </div>

    <div class="row" style="margin-top:5px;">
        <label for="mobile" class="col-sm-3 control-label">Mobile:<span class="text-danger">*</span></label>
        <div class="col-sm-3">
            <input type="text" name="mobile" id="mobile" class="form-control" value="" required="required">
            <span id="mobileError" class="error"></span>
        </div>

        <label for="txtPassword" class="col-sm-3 control-label">Password:<span class="text-danger">*</span></label>
        <div class="col-sm-3 position-relative">
            <div class="input-group">
                <input type="password" id="txtPassword" class="form-control" name="txtPassword" />
                <button type="button" id="btnToggle" class="toggle" onclick="togglePasswordVisibility()">
                    <i id="eyeIcon" class="fa fa-eye"></i>
                </button>
            </div>
            <span id="passwordError" class="error"></span>
        </div>
    </div>
</div>                                <div class="col-12" id="businessdetails" style="display:none;">
                                                        <div class="">
                                                            <h4 style="border-left: 3px solid red; padding-left:3px;">Company Info:</h4>
                                                            <div class="form-group form-fit">
                                                                <div class="row">

                                                                    <label for="input" class="col-sm-3 control-label">Monthly Expenditure:<span class="text-danger">*</span></label>
                                                                    <div class="col-sm-3">
                                                                        

                                                                        <select name="monexpenditure" id="monexpenditure" class="form-control" required>
                                                                            @foreach ($monthlyExpenditure as $expenditure)
                                                                            <option value="{{$expenditure->id}}">{{$expenditure->option_value}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <label for="input" class="col-sm-3 control-label">Company Name:<span class="text-danger">*</span></label>
                                                                    <div class="col-sm-3">
                                                                        <input type="text" name="companyname"  id="companyname" class="form-control" value="" required="required">
                                                                    </div>
                                                                </div>

                                                                <div class="row" style="margin-top:5px;">
                                                                    <label for="input" class="col-sm-3 control-label">Company Address:<span class="text-danger">*</span></label>
                                                                    <div class="col-sm-3">
                                                                        <input type="text" name="companyaddress"  id="companyaddress" class="form-control" value="" required="required">
                                                                    </div>

                                                                    <label for="input" class="col-sm-3 control-label">Pincode:<span class="text-danger">*</span></label>
                                                                    <div class="col-sm-3">
                                                                        <input type="text" name="companypincode"  id="companypincode" class="form-control" required="required">
                                                                    </div>
                                                                </div>

                                                                <div class="row" style="margin-top:5px;">
                                                                    <label for="input" class="col-sm-3 control-label">City:<span class="text-danger">*</span></label>
                                                                    <div class="col-sm-3">
                                                                        <input type="text" name="city"  id="c_city" class="form-control" value="" required="required">
                                                                    </div>
                                                                    <label for="input" class="col-sm-3 control-label">State:<span class="text-danger">*</span></label>
                                                                    <div class="col-sm-3">
                                                                        <input type="text" name="state"  id="state" class="form-control" value="" required="required">
                                                                    </div>
                                                                </div>

                                                                <div class="row" style="margin-top:5px;">

                                                                    <label for="input" class="col-sm-3 control-label">Country:<span class="text-danger">*</span></label>
                                                                    <div class="col-sm-3">
                                                                        <input type="text" name="country"  id="c_country" class="form-control" value="" required="required">
                                                                    </div>
                                                                </div>



                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12" id="businessinfodetails" style="display:none;">
                                                        <div class="">
                                                            <h4 style="border-left: 3px solid red; padding-left:3px;">Business Info:</h4>
                                                            <div class="form-group form-fit">
                                                                <div class="row">
                                                                    <label for="input" class="col-sm-3 control-label">Business Type:<span class="text-danger">*</span></label>
                                                                    <div class="col-sm-3">

                                                                        <select name="business_type" id="business_type" class="form-control" required>
                                                                            @foreach ($businesstype as $business)
                                                                            <option value="{{$business->id}}">{{$business->type_name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <label for="input" class="col-sm-3 control-label">Business Category:<span class="text-danger">*</span></label>
                                                                    <div class="col-sm-3">


                                                                        <select name="businesscategory" id="business_category" class="form-control" required>
                                                                            @foreach ($businesscategory as $category)
                                                                            <option value="{{$category->id}}">{{$category->category_name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="row" style="margin-top:5px;">
                                                                    <label for="input" class="col-sm-3 control-label">Business Sub Category:<span class="text-danger">*</span></label>
                                                                    <div class="col-sm-3">

                                                                        <select name="business_subcategory" id="business_subcategory" class="form-control" required>

                                                                        </select>
                                                                    </div>

                                                                    <label for="input" class="col-sm-3 control-label">WebApp/Url:<span class="text-danger"></span></label>
                                                                    <div class="col-sm-3">
                                                                        <input type="text" name="webapp_url"  id="webapp_url" class="form-control" value="">
                                                                    </div>
                                                                </div>

                                                                <div class="row" style="margin-top:5px;">
                                                                    <label for="input" class="col-sm-3 control-label">Bank Name:<span class="text-danger">*</span></label>
                                                                    <div class="col-sm-3">
                                                                        <input type="text" name="bank_name"  id="business_bank_name" class="form-control" value="" required="required">
                                                                    </div>
                                                                    <label for="input" class="col-sm-3 control-label">Bank Acc No:<span class="text-danger">*</span></label>
                                                                    <div class="col-sm-3">
                                                                        <input type="text" name="bank_acc_no"  id="business_bank_acc_no" class="form-control" value="" required="required">
                                                                    </div>
                                                                </div>


                                                                <div class="row" style="margin-top:5px;">
                                                                    <label for="input" class="col-sm-3 control-label">Bank IFSC Code:<span class="text-danger">*</span></label>
                                                                    <div class="col-sm-3">
                                                                        <input type="text" name="bank_ifsc"  id="bank_ifsc" class="form-control" value="" required="required">
                                                                    </div>
                                                                </div>


                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="col-12" id="businessmoredetails" style="display:none;">
                                                        <div class="">
                                                            <h4 style="border-left: 3px solid red; padding-left:3px;">Business Details:</h4>
                                                            <div class="form-group form-fit">
                                                                <div class="row">
                                                                    <label for="input" class="col-sm-3 control-label">Company Pan No:<span class="text-danger">*</span></label>
                                                                    <div class="col-sm-3">
                                                                        <input type="text" name="company_pan_no"  id="company_pan_no" class="form-control" required="required">
                                                                    </div>
                                                                    <label for="input" class="col-sm-3 control-label">Company GST:<span class="text-danger">*</span></label>
                                                                    <div class="col-sm-3">
                                                                        <input type="text" name="company_gst"  id="company_gst" class="form-control" required="required">
                                                                    </div>
                                                                </div>

                                                                <div class="row" style="margin-top:5px;">
                                                                    <label for="input" class="col-sm-3 control-label">Authorized Signatory PAN No:<span class="text-danger">*</span></label>
                                                                    <div class="col-sm-3">
                                                                        <input type="text" name="authorized_sign_pan_no"  id="authorized_sign_pan_no" class="form-control" value="" required="required">
                                                                    </div>

                                                                    <label for="input" class="col-sm-3 control-label">Authorized Signatory Aadhar No:<span class="text-danger">*</span></label>
                                                                    <div class="col-sm-3">
                                                                        <input type="text" name="authorized_sign_aadhar_no"  id="authorized_sign_aadhar_no" class="form-control" value="" required="required">
                                                                    </div>
                                                                </div>

                                                                <div class="row" style="margin-top:5px;">
                                                                    <label for="input" class="col-sm-3 control-label">Authorized Signatory Name:<span class="text-danger">*</span></label>
                                                                    <div class="col-sm-3">
                                                                        <input type="text" name="authorized_sign_name"  id="authorized_sign_name" class="form-control" value="" required="required">
                                                                    </div>

                                                                </div>







                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- //upload files -->
                                                    <div class="col-12" id="uploadfiles" style="display:none;">
                                                        <div class="">
                                                            <h4 style="border-left: 3px solid red; padding-left:3px;">Upload documents:</h4>
                                                            <div class="text-center text-danger">
                                                                Note:Pdfs & Images are only allowed up to 5mb in size
                                                            </div>
                                                            <div id="case1">

                                                                <div class=" row form-group" id="file_comp_pan_card" style="display:none;">
                                                                    <label class="control-label col-sm-4" for="file_comp_pan_card">Company Pancard: <span class="text-danger">*</span></label>
                                                                    <div class="col-sm-4">
                                                                        <input type="file" name="comp_pan_card" class="inputfile form-control inputfile-2" />
                                                                        <div id="file_comp_pan_card_error"></div>
                                                                    </div>
                                                                </div>

                                                                <div class=" row form-group" id="file_comp_gst" style="display:none;">
                                                                    <label class="control-label col-sm-4" for="file_comp_gst">Company Gst: <span class="text-danger">*</span></label>
                                                                    <div class="col-sm-4">
                                                                        <input type="file" name="comp_gst_doc" class="inputfile form-control inputfile-2" />
                                                                        <div id="file_comp_gst_error"></div>
                                                                    </div>
                                                                </div>

                                                                <div class=" row form-group" id="file_bank_statement" style="display:none;">
                                                                    <label class="control-label col-sm-4" for="file_bank_statement">Bank Statement: <span class="text-danger">*</span></label>
                                                                    <div class="col-sm-4">
                                                                        <input type="file" name="bank_statement" class="inputfile form-control inputfile-2" />
                                                                        <div id="file_bank_statement_error"></div>
                                                                    </div>
                                                                </div>

                                                                <div class=" row form-group" id="file_cancel_cheque" style="display:none;">
                                                                    <label class="control-label col-sm-4" for="file_cancel_cheque">Cancel cheque: <span class="text-danger">*</span></label>
                                                                    <div class="col-sm-4">
                                                                        <input type="file" name="cancel_cheque" class="inputfile form-control inputfile-2" />
                                                                        <div id="file_cancel_cheque_error"></div>
                                                                    </div>
                                                                </div>


                                                                <div class=" row form-group" id="file_cofincorporation" style="display:none;">
                                                                    <label class="control-label col-sm-4" for="file_cofincorporation">Certificate of incorporation: <span class="text-danger">*</span></label>
                                                                    <div class="col-sm-4">
                                                                        <input type="file" name="cin_doc" class="inputfile form-control inputfile-2" />
                                                                        <div id="file_cofincorporation_error"></div>
                                                                    </div>
                                                                </div>


                                                                <div class=" row form-group" id="moa" style="display:none;">
                                                                    <label class="control-label col-sm-4" for="moa">Moa: <span class="text-danger">*</span></label>
                                                                    <div class="col-sm-4">
                                                                        <input type="file" name="moa_doc" class="inputfile form-control inputfile-2" />
                                                                        <div id="moa_error"></div>
                                                                    </div>
                                                                </div>


                                                                <div class=" row form-group" id="aoa" style="display:none;">
                                                                    <label class="control-label col-sm-4" for="aoa">Aoa: <span class="text-danger">*</span></label>
                                                                    <div class="col-sm-4">
                                                                        <input type="file" name="aoa_doc" class="inputfile form-control inputfile-2" />
                                                                        <div id="aoa_error"></div>
                                                                    </div>
                                                                </div>


                                                                <div class=" row form-group" id="file_auth_sign_pancard" style="display:none;">
                                                                    <label class="control-label col-sm-4" for="file_auth_sign_pancard">Auth signatory Pancard: <span class="text-danger">*</span></label>
                                                                    <div class="col-sm-4">
                                                                        <input type="file" name="mer_pan_card" class="inputfile form-control inputfile-2" />
                                                                        <div id="file_auth_sign_pancard_error"></div>
                                                                    </div>
                                                                </div>

                                                                <div class=" row form-group" id="file_auth_sign_aadhar" style="display:none;">
                                                                    <label class="control-label col-sm-4" for="file_auth_sign_aadhar">Auth signatory Aadhar card: <span class="text-danger">*</span></label>
                                                                    <div class="col-sm-4">
                                                                        <input type="file" name="mer_aadhar_card" class="inputfile form-control inputfile-2" />
                                                                        <div id="file_auth_sign_aadhar_error"></div>
                                                                    </div>
                                                                </div>

                                                                <div class=" row form-group" id="file_partnership" style="display:none;">
                                                                    <label class="control-label col-sm-4" for="file_partnership">Partnership Deed:<span class="text-danger">*</span></label>
                                                                    <div class="col-sm-4">
                                                                        <input type="file" name="partnership_deed" class="inputfile form-control inputfile-2" />
                                                                        <div id="file_comp_pan_card_error"></div>
                                                                    </div>
                                                                </div>

                                                                <div class=" row form-group" id="file_llp_agreeement" style="display:none;">
                                                                    <label class="control-label col-sm-4" for="file_llp_agreeement">LLP Agreement:<span class="text-danger">*</span></label>
                                                                    <div class="col-sm-4">
                                                                        <input type="file" name="llp_agreement" class="inputfile form-control inputfile-2" />
                                                                        <div id="file_comp_gst_error"></div>
                                                                    </div>
                                                                </div>

                                                                <div class=" row form-group" id="file_registration" style="display:none;">
                                                                    <label class="control-label col-sm-4" for="file_registration">Registration:<span class="text-danger">*</span></label>
                                                                    <div class="col-sm-4">
                                                                        <input type="file" name="registration_doc" class="inputfile form-control inputfile-2" />
                                                                        <div id="file_bank_statement_error"></div>
                                                                    </div>
                                                                </div>

                                                                <div class=" row form-group" id="file_trustdeed" style="display:none;">
                                                                    <label class="control-label col-sm-4" for="file_trustdeed">Trust Deed/ Bye-laws/ Constitutional Document: <span class="text-danger">*</span></label>
                                                                    <div class="col-sm-4">
                                                                        <input type="file" name="trust_constitutional" class="inputfile form-control inputfile-2" />
                                                                        <div id="file_cancel_cheque_error"></div>
                                                                    </div>
                                                                </div>


                                                                <div class=" row form-group" id="file_noc" style="display:none;">
                                                                    <label class="control-label col-sm-4" for="file_noc">No Objection Certificate: <span class="text-danger">*</span></label>
                                                                    <div class="col-sm-4">
                                                                        <input type="file" name="no_objection_doc" class="inputfile form-control inputfile-2" />
                                                                        <div id="file_cofincorporation_error"></div>
                                                                    </div>
                                                                </div>
                                                            </div>



                                                            <div class="row text-center " style="margin:10px 5px 10px 5px;">
                                                                <button class="btn btn-primary" id="" onclick="return validator()" type="submit">
                                                                    Submit
                                                                </button>
                                                            </div>


                                                        </div>
                                                    </div>
                                                    <!-- enduplad files -->

                                                    <div id="showerror" class="text-danger text-center my-3"></div>

                                                    <div class="text-center">
                                                        <div class="btn btn-success" id="prev" style="display:none;">
                                                            Prev
                                                        </div>
                                                        <div class="btn btn-info" id="next"  onclick="validateForm()">
                                                            Next
                                                        </div>


                                                    </div>

                                                </div>

                                            </div>



                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- end add merchant modal -->

                    </div>

                     <!-- <div class="modal merchantdetails" id="merchant-document-verify-modal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title">Quick View Merchant Details</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form id="regForm" action="">
                                            <div class="tab text-center text-md">
                                                <h4>Personal Details:</h4>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="col-sm-5 text-right"><label for="">Name:</label></div>
                                                        <div class="col-sm-6 text-left" id="name"></div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="col-sm-5 text-right"><label for="">Email:</label></div>
                                                        <div class="col-sm-6 text-left" id="email"></div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="col-sm-5 text-right"><label for="">Mobile No:</label></div>
                                                        <div class="col-sm-6 text-left" id="mobile_no"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab text-center">
                                                <h4>Company Info:</h4>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="col-sm-5 text-right"><label for="">Montly Expenditure:</label></div>
                                                        <div class="col-sm-6 text-left" id="expenditure"></div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="col-sm-5 text-right"><label for="">Company Name:</label></div>
                                                        <div class="col-sm-6 text-left" id="business_name"></div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="col-sm-5 text-right"><label for="">Company Address:</label></div>
                                                        <div class="col-sm-6 text-left" id="address"></div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="col-sm-5 text-right"><label for="">Pincode:</label></div>
                                                        <div class="col-sm-6 text-left" id="pincode"></div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="col-sm-5 text-right"><label for="">City:</label></div>
                                                        <div class="col-sm-6 text-left" id="city"></div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="col-sm-5 text-right"><label for="">State:</label></div>
                                                        <div class="col-sm-6 text-left" id="state_name"></div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="col-sm-5 text-right"><label for="">Country:</label></div>
                                                        <div class="col-sm-6 text-left" id="country"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab text-center">
                                                <h4>Business Info:</h4>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="col-sm-5 text-right"><label for="">Business Type:</label></div>
                                                        <div class="col-sm-6 text-left" id="type_name"></div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="col-sm-5 text-right"><label for="">Business Category:</label></div>
                                                        <div class="col-sm-6 text-left" id="category_name"></div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="col-sm-5 text-right"><label for="">Business Sub Category:</label></div>
                                                        <div class="col-sm-6 text-left" id="sub_category_name"></div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="col-sm-5 text-right"><label for="">WebApp/Url:</label></div>
                                                        <div class="col-sm-6 text-left" id="website"></div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="col-sm-5 text-right"><label for="">Bank Name:</label></div>
                                                        <div class="col-sm-6 text-left" id="bank_name"></div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="col-sm-5 text-right"><label for="">Bank Acc No:</label></div>
                                                        <div class="col-sm-6 text-left" id="bank_acc_no"></div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="col-sm-5 text-right"><label for="">Bank IFSC Code:</label></div>
                                                        <div class="col-sm-6 text-left" id="bank_ifsc_code"></div>
                                                    </div>
                                                </div>
                                            </div>

                                           
                                            <div style="overflow:auto;">
                                                <div style="float:right;">
                                                    <button type="button" class="btn btn-success btn-sm" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                                                    <button type="button" class="btn btn-primary btn-sm" id="nextBtn" onclick="nextPrev(1)">Next</button>
                                                </div>
                                            </div>

                                            <div style="text-align:center;margin-top:40px;">
                                                <span class="step"></span>
                                                <span class="step"></span>
                                                <span class="step"></span>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                    </div> -->
                    
                    @else
                    <div id="{{str_replace(' ','-',strtolower($value->link_name))}}" class="tab-pane fade">

                        <a class="btn btn-sm btn-success margin-right-lg margin-bottom-lg pull-right" data-toggle="modal" id="call-new-doc-add-modal">Add New Doc</a>

                        <div class="row">
                            <div class="col-sm-12">
                                <div id="paginate_extdocs">

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="modal" id="new-doc-add-modal">
                                <div class="modal-dialog">
                                    <div class="modal-content modal-lg">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title">Add Extra Document</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="add-document-success-response"></div>
                                            <form id="add-extra-document-form" method="POST" class="form-horizontal" role="form">
                                                <div class="form-group">
                                                    <label for="input" class="col-sm-2 control-label">Merchant:</label>
                                                    <div class="col-sm-4">
                                                        <select name="merchant_id" id="input" class="form-control">
                                                            <option value="">-- Select Merchant --</option>
                                                            @foreach($merchants as $merchant)
                                                            <option value="{{$merchant->id}}">{{$merchant->name}}</option>
                                                            @endforeach;
                                                        </select>
                                                        <div id="merchant_id_error"></div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <a class="btn btn-primary btn-sm" href="javascript:void(0)" onclick="addNewFileIput()" role="button">Add</a>
                                                    </div>
                                                </div>
                                                <div id="input-file-area" class="input-file-area">
                                                    <div class="form-group">
                                                        <label for="input" class="col-sm-2 control-label">Name:</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" name="doc_name[]" id="input" class="form-control" value="">
                                                            <div id="doc_name.0._error"></div>
                                                        </div>
                                                        <label for="input" class="col-sm-2 control-label">File:</label>
                                                        <div class="col-sm-3">
                                                            <input type="file" name="doc_file[]" id="file-1" class="inputfile form-control inputfile-1" multiple />
                                                            <label for="file-1" class="custom-file-upload">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                                                    <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z" />
                                                                </svg>
                                                                <span id="doc_file_file">
                                                                    <span class="file-name-display" id="doc_file_exist">Choose a file...</span>
                                                                </span>
                                                            </label>
                                                            <div id="doc_file.0._error"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{csrf_field()}}
                                                <div class="form-group">
                                                    <div class="col-sm-10 col-sm-offset-3">
                                                        
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    @endif
                    @endforeach
                    @else

                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal merchantdetails" id="merchant-document-verify-modal-view">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title">Quick View Merchant Details</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form id="regForm" action="">
                                            <div class="tab text-center text-md">
                                                <h4>Personal Details:</h4>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="col-sm-5 text-right"><label for="">Name:</label></div>
                                                        <div class="col-sm-6 text-left" id="name"></div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="col-sm-5 text-right"><label for="">Email:</label></div>
                                                        <div class="col-sm-6 text-left" id="email"></div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="col-sm-5 text-right"><label for="">Mobile No:</label></div>
                                                        <div class="col-sm-6 text-left" id="mobile_no"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab text-center">
                                                <h4>Company Info:</h4>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="col-sm-5 text-right"><label for="">Montly Expenditure:</label></div>
                                                        <div class="col-sm-6 text-left" id="expenditure"></div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="col-sm-5 text-right"><label for="">Company Name:</label></div>
                                                        <div class="col-sm-6 text-left" id="business_name"></div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="col-sm-5 text-right"><label for="">Company Address:</label></div>
                                                        <div class="col-sm-6 text-left" id="address"></div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="col-sm-5 text-right"><label for="">Pincode:</label></div>
                                                        <div class="col-sm-6 text-left" id="pincode"></div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="col-sm-5 text-right"><label for="">City:</label></div>
                                                        <div class="col-sm-6 text-left" id="city"></div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="col-sm-5 text-right"><label for="">State:</label></div>
                                                        <div class="col-sm-6 text-left" id="state_name"></div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="col-sm-5 text-right"><label for="">Country:</label></div>
                                                        <div class="col-sm-6 text-left" id="country"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab text-center">
                                                <h4>Business Info:</h4>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="col-sm-5 text-right"><label for="">Business Type:</label></div>
                                                        <div class="col-sm-6 text-left" id="type_name"></div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="col-sm-5 text-right"><label for="">Business Category:</label></div>
                                                        <div class="col-sm-6 text-left" id="category_name"></div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="col-sm-5 text-right"><label for="">Business Sub Category:</label></div>
                                                        <div class="col-sm-6 text-left" id="sub_category_name"></div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="col-sm-5 text-right"><label for="">WebApp/Url:</label></div>
                                                        <div class="col-sm-6 text-left" id="website"></div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="col-sm-5 text-right"><label for="">Bank Name:</label></div>
                                                        <div class="col-sm-6 text-left" id="bank_name"></div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="col-sm-5 text-right"><label for="">Bank Acc No:</label></div>
                                                        <div class="col-sm-6 text-left" id="bank_acc_no"></div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="col-sm-5 text-right"><label for="">Bank IFSC Code:</label></div>
                                                        <div class="col-sm-6 text-left" id="bank_ifsc_code"></div>
                                                    </div>
                                                </div>
                                            </div>

                                           
                                            <div style="overflow:auto;">
                                                <div style="float:right;">
                                                    <button type="button" class="btn btn-success btn-sm" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                                                    <button type="button" class="btn btn-primary btn-sm" id="nextBtn" onclick="nextPrev(1)">Next</button>
                                                </div>
                                            </div>

                                            <div style="text-align:center;margin-top:40px;">
                                                <span class="step"></span>
                                                <span class="step"></span>
                                                <span class="step"></span>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
</div> 
<!-- this script is using for password visbile and show  -->


<script>
    function togglePasswordVisibility() {
        var passwordInput = document.getElementById('txtPassword');
        var eyeIcon = document.getElementById('eyeIcon');

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            eyeIcon.classList.remove("fa-eye");
            eyeIcon.classList.add("fa-eye-slash");
        } else {
            passwordInput.type = "password";
            eyeIcon.classList.remove("fa-eye-slash");
            eyeIcon.classList.add("fa-eye");
        }
    }
</script>
<!-- this validation for Add merchant =>>(PersonalDetails) -->

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        getMerchantDocsDetails();
    });
</script>




<script>
    $("#next,#prev").click(function(e) {
        var button = $(this).attr('id')
        console.log(button);
        var counter = $("#modalcounter").val();
        if (button === 'next') {
            var name = $('#m_name').val();
            var email = $('#m_email').val();
            var mobile = $('#mobile').val();
            var password = $('#password').val();

            var monexpenditure = $('#monexpenditure').val();
            var companyname = $('#companyname').val();;
            var companypincode = $('#companypincode').val();
            var c_city = $('#c_city').val();
            var state = $('#state').val();
            var c_country = $('#c_country').val();

            var business_type = $('#business_type').val();
            var business_category = $('#business_category').val();
            var business_subcategory = $('#business_subcategory').val();
            var webapp_url = $('#webapp_url').val();
            var business_bank_name = $('#business_bank_name').val();
            var business_bank_acc_no = $('#business_bank_acc_no').val();
            var bank_ifsc = $('#bank_ifsc').val();

            var company_pan_no = $('#company_pan_no').val();
            var company_gst = $('#company_gst').val();
            var authorized_sign_pan_no = $('#authorized_sign_pan_no').val();
            var authorized_sign_aadhar_no = $('#authorized_sign_aadhar_no').val();
            var authorized_sign_name = $('#authorized_sign_name').val();

            // validations start
            if (counter == 0) {
                var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
                var testMobile = /^[0-9]{10}$/i;

                if (!testEmail.test(email)) {
                    $('#showerror').html('Email is not valid');

                    return false;
                }
                if (!testMobile.test(mobile)) {
                    $('#showerror').html('Mobile Number is not valid');

                    return false;
                }
                if (name.length == 0 || email.length == 0 || mobile.length == 0 || password.length == 0) {
                    console.log('please fill all the fields');
                    $('#showerror').html('Please fill all the fields');
                    return false;
                }
                $('#showerror').html('');
            }

            if (counter == 1) {
                var testpincode = /^[1-9][0-9]{5}$/;

                if (!testpincode.test(companypincode)) {
                    $('#showerror').html('Pincode is not valid');

                    return false;
                }
                if (monexpenditure.length == 0 || companyname.length == 0 || companypincode.length == 0 || c_city.length == 0 || state.length == 0 || c_country.length == 0) {
                    console.log('please fill all the fields');
                    $('#showerror').html('Please fill all the fields');
                    return false;
                }
                $('#showerror').html('');
            }

            if (counter == 2) {
                var ifsc = /^[A-Z]{4}0[A-Z0-9]{6}$/;
                console.log("ifsc" + ifsc.test(bank_ifsc));
                if (!ifsc.test(bank_ifsc)) {
                    $('#showerror').html('Ifsc is not valid');

                    return false;
                }
                if ((business_bank_acc_no.length < 9) || (business_bank_acc_no.length > 18)) {
                    console.log('acc not valid');
                    $('#showerror').html('Accont Number is not valid');
                    return false;
                }


                if (business_type.length == 0 || business_category.length == 0 || business_subcategory.length == 0 || business_bank_name.length == 0 || business_bank_acc_no.length == 0 || bank_ifsc.length == 0) {
                    console.log('please fill all the fields');
                    $('#showerror').html('Please fill all the fields');
                    return false;
                }
                $('#showerror').html('');
            }

            if (counter == 3) {
                var checkgst = /[0-9]{2}[A-Z]{3}[ABCFGHLJPTF]{1}[A-Z]{1}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}/;
                var checkauthpan = /^([A-Z]){3}P([A-Z])([0-9]){4}([A-Z]){1}?$/;
                var checkcompanypan = /^([A-Z]){3}C([A-Z])([0-9]){4}([A-Z]){1}?$/;

                if (company_pan_no.length == 0 || company_gst.length == 0 || authorized_sign_pan_no.length == 0 || authorized_sign_aadhar_no.length == 0 || authorized_sign_name.length == 0) {
                    console.log('please fill all the fields');
                    $('#showerror').html('Please fill all the fields');
                    return false;
                }
                if (!checkauthpan.test(authorized_sign_pan_no)) {
                    $('#showerror').html('Authorized Signatory PAN No  is not valid');

                    return false;
                }
                if (!checkcompanypan.test(company_pan_no)) {
                    $('#showerror').html('Company PAN No is not valid');

                    return false;
                }

                if (authorized_sign_aadhar_no.length != 12) {
                    console.log('aadhar not valid');
                    $('#showerror').html('Aadhar Number is not valid');
                    return false;
                }
                if (!checkgst.test(company_gst)) {
                    $('#showerror').html('GSTIN  is not valid');

                    return false;
                }
                $('#showerror').html('');
            }

            counter++;
        } else if (button === 'prev') {
            if (counter == 0) {

            }
            counter--;
        }

        $("#modalcounter").val(counter);

        if (counter == "0") {
            $("#personaldetails").show();
            $("#businessdetails").hide();
            $("#businessinfodetails").hide();
            $("#businessmoredetails").hide();
            $("#uploadfiles").hide();
            $("#prev").hide();
            $("#next").show();

        } else if (counter == "1") {
            $("#personaldetails").hide();
            $("#businessdetails").show();
            $("#businessinfodetails").hide();
            $("#businessmoredetails").hide();
            $("#uploadfiles").hide();
            $("#prev").show();
            $("#next").show();
        } else if (counter == "2") {
            $("#personaldetails").hide();
            $("#businessdetails").hide();
            $("#businessinfodetails").show();
            $("#businessmoredetails").hide();
            $("#uploadfiles").hide();
            $("#prev").show();
            $("#next").show();
        } else if (counter == "3") {
            $("#personaldetails").hide();
            $("#businessdetails").hide();
            $("#businessinfodetails").hide();
            $("#businessmoredetails").show();
            $("#uploadfiles").hide();
            $("#prev").show();
            $("#next").show();
        } else if (counter == "4") {
            $("#uploadfiles").show();
            $("#personaldetails").hide();
            $("#businessdetails").hide();
            $("#businessinfodetails").hide();
            $("#businessmoredetails").hide();
            $("#prev").show();
            $("#next").hide();
            if (business_type == 1) {
                $("#file_comp_pan_card").show();
                $("#file_comp_gst").show();
                $("#file_bank_statement").show();
                $("#file_cancel_cheque").show();
                $("#file_cofincorporation").show();
                $("#moa").show();
                $("#aoa").show();
                $("#file_auth_sign_pancard").show();
                $("#file_auth_sign_aadhar").show();

                $("#file_registration").hide();
                $("#file_trustdeed").hide();
                $("#file_noc").hide();
                $("#file_llp_agreeement").hide();
                $("#file_partnership").hide();

            } else if (business_type == 2) {
                $("#file_comp_pan_card").hide();
                $("#file_comp_gst").show();
                $("#file_bank_statement").show();
                $("#file_cancel_cheque").show();
                $("#file_auth_sign_pancard").show();
                $("#file_auth_sign_aadhar").show();

                $("#file_cofincorporation").hide();
                $("#moa").hide();
                $("#aoa").hide();
                $("#file_registration").hide();
                $("#file_trustdeed").hide();
                $("#file_noc").hide();
                $("#file_llp_agreeement").hide();
                $("#file_partnership").hide();

            } else if (business_type == 3) {
                $("#file_comp_pan_card").show();
                $("#file_comp_gst").show();
                $("#file_bank_statement").show();
                $("#file_cancel_cheque").show();
                $("#file_auth_sign_pancard").show();
                $("#file_auth_sign_aadhar").show();
                $("#file_partnership").show();

                $("#file_cofincorporation").hide();
                $("#moa").hide();
                $("#aoa").hide();
                $("#file_registration").hide();
                $("#file_trustdeed").hide();
                $("#file_noc").hide();
                $("#file_llp_agreeement").hide();




            } else if (business_type == 4) {
                $("#file_comp_pan_card").show();
                $("#file_comp_gst").show();
                $("#file_bank_statement").show();
                $("#file_cancel_cheque").show();
                $("#file_auth_sign_pancard").show();
                $("#file_auth_sign_aadhar").show();
                $("#file_partnership").show();
                $("#moa").show();
                $("#aoa").show();
                $("#file_cofincorporation").show();

                $("#file_registration").hide();
                $("#file_trustdeed").hide();
                $("#file_noc").hide();
                $("#file_llp_agreeement").hide();

            } else if (business_type == 5) {
                $("#file_comp_pan_card").show();
                $("#file_comp_gst").show();
                $("#file_bank_statement").show();
                $("#file_cancel_cheque").show();
                $("#file_auth_sign_pancard").show();
                $("#file_auth_sign_aadhar").show();
                $("#file_llp_agreeement").show();
                $("#file_cofincorporation").show();


                $("#moa").hide();
                $("#aoa").hide();
                $("#file_registration").hide();
                $("#file_trustdeed").hide();
                $("#file_noc").hide();
                $("#file_partnership").hide();
            } else if (business_type == 9) {
                $("#file_comp_pan_card").show();
                $("#file_auth_sign_pancard").show();
                $("#file_auth_sign_aadhar").show();

                $("#file_bank_statement").hide();
                $("#file_cancel_cheque").hide();
                $("#file_comp_pan_card").hide();
                $("#file_cofincorporation").hide();
                $("#moa").hide();
                $("#aoa").hide();
                $("#file_registration").hide();
                $("#file_trustdeed").hide();
                $("#file_noc").hide();
                $("#file_llp_agreeement").hide();
                $("#file_partnership").hide();
            } else {
                $("#file_comp_pan_card").show();
                $("#file_auth_sign_pancard").show();
                $("#file_auth_sign_aadhar").show();
                $("#file_registration").show();
                $("#file_trustdeed").show();
                $("#file_noc").show();

                $("#file_comp_gst").show();
                $("#file_bank_statement").hide();
                $("#file_cancel_cheque").hide();
                $("#file_cofincorporation").hide();
                $("#moa").hide();
                $("#aoa").hide();
                $("#file_llp_agreeement").hide();
                $("#file_partnership").hide();
            }
        }

    });
</script>


<script>
    function validator() {
        var business_type = $('#business_type').val();
        console.log('%cmerchantdocument.blade.php line:947 object', 'color: #007acc;', business_type);

        //uploaded files
        var compPanCard = $("input[name='comp_pan_card']").val();
        var compGst = $("input[name='comp_gst_doc']").val();
        var bankStatement = $("input[name='bank_statement']").val();
        var cancelCheque = $("input[name='cancel_cheque']").val();
        var cofincorporation = $("input[name='cin_doc']").val();
        var moa = $("input[name='moa_doc']").val();
        var aoa = $("input[name='aoa_doc']").val();
        var authSignPancard = $("input[name='mer_pan_card']").val();
        var authSignAadhar = $("input[name='mer_aadhar_card']").val();
        var partnership = $("input[name='partnership_deed']").val();
        var llp = $("input[name='llp_agreement']").val();
        var registration = $("input[name='registration_doc']").val();
        var trustDeed = $("input[name='trust_constitutional']").val();
        var noc = $("input[name='no_objection_doc']").val();
        //end uploaded files

        if (compPanCard.length != 0) {
            var compPanCardSize = ($("input[name='comp_pan_card']")[0].files[0].size) / 1024;
            console.log('%cmerchantdocument.blade.php line:1032 object', 'color: #007acc;', compPanCardSize);

            if (parseInt(compPanCardSize) > 5120) {
                $('#showerror').html('Company Pan card is greater than 5 Mb');
                return false;
            }
        }

        if (compGst.length != 0) {
            var compGstSize = ($("input[name='comp_gst_doc']")[0].files[0].size) / 1024;

            if (parseInt(compGstSize) > 5120) {
                $('#showerror').html('Company Gst certificate is greater than 5 Mb');
                return false;
            }
        }

        if (bankStatement.length != 0) {
            var bankStatementSize = ($("input[name='bank_statement']")[0].files[0].size) / 1024;


            if (parseInt(bankStatementSize) > 5120) {
                $('#showerror').html('Bank Statement is greater than 5 Mb');
                return false;
            }
        }

        if (cancelCheque.length != 0) {
            var cancelChequeSize = ($("input[name='cancel_cheque']")[0].files[0].size) / 1024;

            if (parseInt(cancelChequeSize) > 5120) {
                $('#showerror').html('Cancel cheque is greater than 5 Mb');
                return false;
            }
        }

        if (cofincorporation.length != 0) {
            var cofincorporationSize = ($("input[name='cin_doc']")[0].files[0].size) / 1024;

            if (parseInt(cofincorporationSize) > 5120) {
                $('#showerror').html('Certificate of incorporation is greater than 5 Mb');
                return false;
            }
        }

        if (moa.length != 0) {
            var moaSize = ($("input[name='moa_doc']")[0].files[0].size) / 1024;

            if (parseInt(moaSize) > 5120) {
                $('#showerror').html('Moa Certificate is greater than 5 Mb');
                return false;
            }
        }


        if (aoa.length != 0) {
            var aoaSize = ($("input[name='aoa_doc']")[0].files[0].size) / 1024;

            if (parseInt(aoaSize) > 5120) {
                $('#showerror').html('Aoa Certificate is greater than 5 Mb');
                return false;
            }
        }

        if (authSignPancard.length != 0) {
            var authSignPancardSize = ($("input[name='mer_pan_card']")[0].files[0].size) / 1024;

            if (parseInt(authSignPancardSize) > 5120) {
                $('#showerror').html('Auth signatory Pan card is greater than 5 Mb');
                return false;
            }
        }

        if (authSignAadhar.length != 0) {
            var authSignAadharSize = ($("input[name='mer_aadhar_card']")[0].files[0].size) / 1024;

            if (parseInt(authSignAadharSize) > 5120) {
                $('#showerror').html('Auth signatory Aadhar card is greater than 5 Mb');
                return false;
            }
        }

        if (partnership.length != 0) {
            var partnershipSize = ($("input[name='partnership_deed']")[0].files[0].size) / 1024;


            if (parseInt(partnershipSize) > 5120) {
                $('#showerror').html('Partnership Certificate is greater than 5 Mb');
                return false;
            }
        }

        if (llp.length != 0) {
            var llpSize = ($("input[name='llp_agreement']")[0].files[0].size) / 1024;
            console.log('%cmerchantdocument.blade.php line:1032 object', 'color: #007acc;', compPanCardSize);

            if (parseInt(llpSize) > 5120) {
                $('#showerror').html('LLp Certificate is greater than 5 Mb');
                return false;
            }
        }

        if (registration.length != 0) {
            var registrationSize = ($("input[name='registration_doc']")[0].files[0].size) / 1024;

            if (parseInt(registrationSize) > 5120) {
                $('#showerror').html('Registration Certificate is greater than 5 Mb');
                return false;
            }
        }

        if (trustDeed.length != 0) {
            var trustDeedSize = ($("input[name='trust_constitutional']")[0].files[0].size) / 1024;


            if (parseInt(trustDeedSize) > 5120) {
                $('#showerror').html('Trust Deed Certificate is greater than 5 Mb');
                return false;
            }
        }

        if (noc.length != 0) {
            var nocSize = ($("input[name='no_objection_doc']")[0].files[0].size) / 1024;


            if (parseInt(nocSize) > 5120) {
                $('#showerror').html('No objection certificate is greater than 5 Mb');
                return false;
            }
        }




        console.log(compPanCard.length == 0, compGst.length == 0, bankStatement.length == 0, cancelCheque.length == 0);

        console.log(compPanCard)

        if (business_type == 1) {

            if (compPanCard.length == 0 || compGst.length == 0 || bankStatement.length == 0 || cancelCheque.length == 0 || cofincorporation.length == 0 || moa.length == 0 || aoa.length == 0 || authSignPancard.length == 0 || authSignAadhar.length == 0) {
                $('#showerror').html('Please Upload All Files');
                return false;
            }

        } else if (business_type == 2) {

            if (compGst.length == 0 || bankStatement.length == 0 || cancelCheque.length == 0 || authSignPancard.length == 0 || authSignAadhar.length == 0) {
                $('#showerror').html('Please Upload All Files');
                return false;
            }

        } else if (business_type == 3) {

            if (compPanCard.length == 0 || compGst.length == 0 || bankStatement.length == 0 || cancelCheque.length == 0 || partnership.length == 0 || authSignPancard.length == 0 || authSignAadhar.length == 0) {
                $('#showerror').html('Please Upload All Files');
                return false;
            }

        } else if (business_type == 4) {

            if (compPanCard.length == 0 || compGst.length == 0 || bankStatement.length == 0 || cancelCheque.length == 0 || cofincorporation.length == 0 || moa.length == 0 || aoa.length == 0 || authSignPancard.length == 0 || authSignAadhar.length == 0 || partnership.length == 0) {
                $('#showerror').html('Please Upload All Files');
                return false;
            }

        } else if (business_type == 5) {

            if (compPanCard.length == 0 || compGst.length == 0 || bankStatement.length == 0 || cancelCheque.length == 0 || llp.length == 0 || cofincorporation.length == 0 || authSignPancard.length == 0 || authSignAadhar.length == 0) {
                $('#showerror').html('Please Upload All Files');
                return false;
            }


        } else if (business_type == 9) {

            if (compPanCard.length == 0 || authSignPancard.length == 0 || authSignAadhar.length == 0) {
                $('#showerror').html('Please Upload All Files');
                return false;
            }
        } else {


            if (compPanCard.length == 0 || registration.length == 0 || trustDeed.length == 0 || noc.length == 0 || authSignPancard.length == 0 || authSignAadhar.length == 0) {
                $('#showerror').html('Please Upload All Files');
                return false;
            }
        }

        console.log('%cmerchantdocument.blade.php line:1083 Object', 'color: white; background-color: #007acc;', 'REached');
        $('#showerror').html('');
        console.log("%c form submitted!", " background:green; border-radius: 5%");

    }
</script>


 




<script>
    $("#merchantAdd").submit(function(e) {
        e.preventDefault();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            dataType: "json",
            url: '/flakpay/add_merchant/',
            data: {
                'name': $('#m_name').val(),
                'email': $('#m_email').val(),
                'mobile': $('#mobile').val(),
                'password': $('#password').val(),
                'monexpenditure': $('#monexpenditure').val(),
                'companyname': $('#companyname').val(),
                'companyaddress': $('#companyaddress').val(),
                'pincode': $('#companypincode').val(),
                'city': $('#c_city').val(),
                'state': $('#state').val(),
                'country': $('#c_country').val(),
                'business_type': $('#business_type').val(),
                'business_category': $('#business_category').val(),
                'business_sub_category': $('#business_subcategory').val(),
                'weburl': $('#webapp_url').val(),
                'bank_name': $('#business_bank_name').val(),
                'bank_acc_no': $('#business_bank_acc_no').val(),
                'bank_ifsc_code': $('#bank_ifsc').val(),
                'company_pan_no': $('#company_pan_no').val(),
                'company_gst': $('#company_gst').val(),
                'authorized_sign_pan_no': $('#authorized_sign_pan_no').val(),
                'authorized_sign_aadhar_no': $('#authorized_sign_aadhar_no').val(),
                'authorized_sign_name': $('#authorized_sign_name').val()
            },
            success: function(data) {
                console.log(data);
                $('.bd-example-modal-lg').modal('hide')
            }

        })
    });
</script>

<script>
    $('#business_category').on('change', function() {
        var categoryID = $(this).val();

        $.ajax({
            type: 'GET',
            datatype: 'json',
            url: '/flakpay/get_business_subcategories/',
            data: {
                'categoryID': categoryID
            },

            success: function(data) {

                $('select[name="business_subcategory"]').empty();
                $.each(data, function(key, value) {

                    $('select[name="business_subcategory"]').append('<option value="' + value.id + '">' + value.sub_category_name + '</option>');
                })
            }
        })
    })
</script>

<script>
    $(document).ready(function() {

        var categoryID = $(business_category).val();

        $.ajax({
            type: 'GET',
            datatype: 'json',
            url: '/flakpay/get_business_subcategories/',
            data: {
                'categoryID': categoryID
            },

            success: function(data) {

                $('select[name="business_subcategory"]').empty();
                $.each(data, function(key, value) {

                    $('select[name="business_subcategory"]').append('<option value="' + value.id + '">' + value.sub_category_name + '</option>');
                })
            }
        })
        console.log("ready!");
    });
</script>
@endsection