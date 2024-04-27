 
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

.btn-info {
    color: #fff;
    background-color: #5d1c84!important;
    /* border-color: #5d1c84; */
    border: none;
}
.Personaldetails_addmerchant_nextbutton{
    
    color: #fff;
    background-color: #5d1c84 !important;
    border:none;
}
.Bussiness-infro-sub-mit {
    color: white;
    background-color:#5d1c84  !important;
    border: none ;
    &:active {
        color:  white  !important;
    
    }
    &:hover {
        color:  white  !important;
        background-color: #5d1c84  !important;
    
    }
&:focus {
    outline: none  !important;
    box-shadow: 0 0 0px  !important; 

}

}
.error-message{
    color:red !important;
}
    /* .process.nav-tabs .nav-item.show .nav-link,
    .process.nav-tabs .nav-link.active:hover,
    .process.nav-tabs .nav-link.active:focus,
    .process.nav-tabs .nav-link.active {
        border-bottom: 4px solid;
        color: blue;
        border-color: #fff #fff blue #fff;
    } */

.nav-tabs>li>a {
    margin-right: 0px !important; 
    line-height: 1.6 !important;
    border: 1px solid transparent !important;
    border-radius: 4px 4px 0 0;
}
/* .process.nav-tabs .nav-item.active {
    border-bottom: 4px solid;
    color: blue !important;
    border-color:#5d1c84;
    
}
*/
.nav-item.validation {
    width: 32%;
}

/* csss for password show & hide */
.form-grou{
    position: relative;
}
.password-toggle {
    position: absolute;
    right: 28%;
    font-size: 1.5rem;
    top: 44%;
    transform: translateY(-50%);
    cursor: pointer;
}
.form-control {
    width: 75%;
}
.row {
    margin: 0px !important;
}
/* Customize tab menu */


/* Custom styles for the tabs */
.nav-tabs.process {
    /* background-color: #f0f0f0;  */
    border: none; /* Remove border */
    border-radius: 10px; /* Add border radius */
    padding: 10px; /* Add some padding */
}

.nav-tabs.process .nav-item {
    margin-bottom: 5px;
    margin-top: 5px;
}

.nav-tabs.process .nav-link {
    color: #333; /* Change text color */
    font-weight: bold; /* Make text bold */
    /* padding: 15px 20px;  */
    border: none; /* Remove border */
    border-radius: 39px; /* Add border radius */
    background-color: #ddd; /* Change background color */
    transition: background-color 0.3s ease; /* Add transition effect */
}

.nav-tabs.process .nav-link.active {
    background-color: #5d1c84; /* Change background color for active tab */
    color: #fff; /* Change text color for active tab */
}

.text-danger {
    color: #de2521;
}
</style>
 <div class="container-fluid">            

                <div class="mt-5" >
                    <h2 class="mb-4">Add Merchant</h2>

                    <ul class="nav nav-tabs process" id="myTabs" style="border: 2px solid #d3e0e9; border-radius: 5px;">
                        <li class="nav-item validation active">
                            <a class="nav-link active success " id="tab1" data-toggle="tab" href="#pane1" style="text-align: center;">Personal Details</a>
                        </li>
                        <li class="nav-item validation">
                            <a class="nav-link  " id="tab2" data-toggle="tab" href="#pane2" style="text-align: center;">Company Info</a>
                        </li>
                        <li class="nav-item validation">
                            <a class="nav-link success" id="tab3" data-toggle="tab" href="#pane3" style="text-align: center;">Business Info</a>
                        </li>
                    </ul>


                    <form method="post" action="/flakpay/add_merchant" enctype="multipart/form-data" >
                        {{ csrf_field() }}
                        <!-- <br> -->
                        <div class="tab-content mt-2" >
                            <div class="tab-pane fade  show in active" id="pane1" style="border: 2px solid #d3e0e9; border-radius: 5px;">
                            <br><br>

                                <!-- <h4>Personal Details</h4> -->
                                <!-- Your form fields for Tab 1 go here -->
                                
                                <div class="row">
                                    <input type="hidden" id="modalcounter" value="0">

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group" id="draft_form_btn">
                                            <label for="Name">Name<span class="text-danger"> *</span>:</label>
                                            <input style="background-color:ghostwhite;" type="text" class="form-control"
                                                name="name" id="m_name" placeholder="" >
                                                <div id="name_showerror" class="text-danger  my-3"></div>

                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="Email">Email<span class="text-danger"> *</span>:</label>
                                            <input style="background-color:ghostwhite;" type="email" class="form-control" 
                                                name="email" id="m_email" placeholder="" autocomplete="off" onpaste="return false;">
                                                <span id="email-error" class="error-message" style="display: none;">Email already exists</span>
                                            <div id="invalid-email-error" class="error-message" style="display: none;">Invalid email format</div>
                                            <div id="email_showerror" class="text-danger  my-3"></div>
                                        </div>
                                        <!-- <div id="showerror" class="text-danger  my-3"></div> -->
                                    </div>
                                </div>
                                <div class="row">
                                  
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="Mobile">Mobile<span class="text-danger"> *</span>:</label>
                                            <input style="background-color: ghostwhite;" type="tel" class="form-control" name="mobile" maxlength="10" id="mobile" placeholder="" pattern="[0-9]{10}">

                                                <!-- <input style="background-color: ghostwhite;" type="tel" class="form-control" name="mobile" maxlength="10" id="mobile" placeholder="" pattern="\d*"> -->
                                                <div id="mobile_showerror" class="text-danger  my-3"></div>

                                        </div>
                                       
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                        <label for="Password">Password<span class="text-danger"> *</span>:</label>
                                        <div style="position: relative;">
                                            <input style="background-color: ghostwhite;" type="password" maxlength="14" class="form-control" name="password" id="password" placeholder="">
                                            <i class="fa fa-eye-slash password-toggle" aria-hidden="true" onclick="togglePassword()"></i>
                                        </div>

                                        <div id="password_showerror" class="text-danger  my-3"></div>

                                        </div>

                                        </div>
                                    
                                    


                                </div>

                                {{-- <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="merchantAddress">Merchant Address<span class="text-danger">*</span>:</label>
                                            <input style="background-color:ghostwhite;" type="Address" class="form-control"
                                                id="merchantAddress">
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="text-center">
                                    {{-- <div class="btn btn-success" id="prev"> 
                                        Prev
                                    
                                    </div> --}}
                                <div id="allerror_showerror" class="text-danger  my-3"></div>
                                    <br>
                                    
                                </div>
                                <div class="btn-flex">                                   
                                    <div>
                                        <button type="button" class="btn btn-primary draft-next" id="saveDraft">Draft</button>
                                    </div>
                                    <div>
                                        <div class="btn btn-info text-center emailcheck draft-next"  class="Personaldetails_addmerchant_nextbutton" id="next">Next</div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="pane2" style="border: 2px solid #d3e0e9; border-radius: 5px;">
                            <br><br>

                                <!-- <h4>Company Info</h4> -->
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="Monthly Expenditure:">Monthly Expenditure<span
                                                    class="text-danger"> *</span> :</label>
                                            {{-- <select style="background-color:ghostwhite;" class="form-control" id="country"
                                                name="country">
                                                <option value="" selected disabled>Haven't started process it </option>
                                                <option value="USA">Less than 5 Lakhs</option>
                                                <option value="Canada">5 Lakhs to 25 Lakhs</option>
                                                <option value="Canada">25 Lakhs to 50 Lakhs</option>
                                                <option value="Canada">50 Lakhs to 1 Crore</option>
                                                <option value="Canada">More than 1 Crore</option>

                                            </select> --}}
                                            <select name="monexpenditure" id="monexpenditure" class="form-control" required>
                                                @foreach ($monthlyExpenditure as $expenditure)
                                                <option value="{{$expenditure->id}}">{{$expenditure->option_value}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="Company Name:">Company Name<span class="text-danger"> *</span>:</label>
                                            <input style="background-color:ghostwhite;" type="text" class="form-control"
                                                name="companyname" id="companyname" placeholder="">
                                                <div id="companyname_showerror" class="text-danger  my-3"></div>

                                        </div>

                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="Company Address:">Company Address<span class="text-danger"> *</span>:</label>
                                            <input style="background-color:ghostwhite;" type="text" class="form-control"
                                                name="companyaddress" id="companyaddress" placeholder="">
                                                <div id="companyaddress_showerror" class="text-danger  my-3"></div>

                                        </div>

                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="Pincode">Pincode<span class="text-danger"> *</span>:</label>
                                            <input style="background-color:ghostwhite;" type="text" class="form-control"
                                                name="companypincode" id="companypincode" placeholder="">
                                                <div id="companypincode_showerror" class="text-danger  my-3"></div>

                                        </div>

                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="City">City<span class="text-danger"> *</span>:</label>
                                            <input style="background-color:ghostwhite;" type="text" class="form-control"
                                                name="city" id="c_city" placeholder="">
                                                <div id="c_city_showerror" class="text-danger  my-3"></div>

                                        </div>

                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="State">State<span class="text-danger"> *</span>:</label>
                                            <input style="background-color:ghostwhite;" type="text" class="form-control"
                                                name="state" id="state" placeholder="">
                                                <div id="state_showerror" class="text-danger  my-3"></div>

                                        </div>

                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="Country">Country<span class="text-danger"> *</span>:</label>
                                            <input style="background-color:ghostwhite;" type="text" class="form-control"
                                                name="country" id="c_country" placeholder="">
                                           <div id="c_country_showerror" class="text-danger  my-3"></div>

                                        </div>

                                    </div>
                                </div>
                                <div class="text-center">
                                    <div id="showerror1" class="text-danger text-center my-3"></div>
                                    <div id="showerror1" class="text-danger text-center my-3"></div>
                                </div>
                                <div class="btn-flex">                                   
                                    <div>
                                        <div class="btn btn-success draft-next" id="prev" style="">
                                            Prev
                                        </div>
                                    </div>
                                    <div>
                                        <div class="btn btn-info draft-next"  class="" id="tab_next">
                                            Next
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pane3" style="border: 2px solid #d3e0e9; border-radius: 5px;">
                                <br><br>

                                <!-- <h4>Business Info </h4> -->
                                <!-- Your form fields for Tab 3 go here --> 
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group" id="my_Form">
                                            <label for="Business Type">Business Type<span class="text-danger"> *</span>:</label>
                                            <select name="business_type" id="business_type" class="form-control" required>
                                                @foreach ($businesstype as $business)
                                                <option value="{{$business->id}}">{{$business->type_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>  
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="Business Category:">Business Category<span
                                                    class="text-danger"> *</span>:</label>
                                                    <select name="businesscategory" id="business_category" class="form-control" required>
                                                        @foreach ($businesscategory as $category)
                                                        <option value="{{$category->id}}">{{$category->category_name}}</option>
                                                        @endforeach
                                                    </select>

                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="Business Sub Category:">Business Sub Category<span
                                                    class="text-danger"> *</span>:</label>
                                                    <select name="business_subcategory" id="business_subcategory" class="form-control" required>

                                                    </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group"  id="myForm">
                                            <label for="WebApp/Url">WebApp/Url<span class="text-danger"></span>:</label>
                                            <input style="background-color:ghostwhite;" type="text" class="form-control"
                                                id="webapp_url" name="webapp_url" placeholder="" value="">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group" id="myForm" >
                                            <label for="Bank Name">Bank Name<span class="text-danger"> *</span>:</label>
                                            <input style="background-color:ghostwhite;" class="form-control"
                                            type="text" name="bank_name"  id="business_bank_name" value="">
                                            <div id="bank_name_error" class="error-message"></div>
                                        </div>
                                        

                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="Bank Acc No">Bank Acc No<span class="text-danger"> *</span>:</label>
                                            <input style="background-color:ghostwhite; " type="text" class="form-control"
                                            name="bank_acc_no"  id="business_bank_acc_no" value="">
                                            <div id="bank_acc_no_error" class="error-message"></div>
                                        </div>
                                    

                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="Bank IFSC Code">Bank IFSC Code<span class="text-danger"> *</span>:</label>
                                            <input style="background-color:ghostwhite;" type="text" class="form-control"
                                            name="bank_ifsc"  id="bank_ifsc" value="" >
                                            <div id="bank_ifsc_error" class="error-message"></div>


                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="Bank IFSC Code">Branch Name<span class="text-danger"> *</span>:</label>
                                            <input style="background-color:ghostwhite;" type="text" class="form-control"
                                            name="branchname"  id="branchname" value="" >
                                            <div id="branchname_error" class="error-message"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="Bank IFSC Code">Account Holder Name<span class="text-danger"> *</span>:</label>
                                            <input style="background-color:ghostwhite;" type="text" class="form-control"
                                            name="acc_holder_name"  id="acc_holder_name" value="" >
                                            <div id="acc_holder_name_error" class="error-message"></div>
                                        </div>
                                    </div>
            {{-- new  --}}


                                </div>
                            <!-- //upload files -->
                            <div class="col-12" id="uploadfiles" >
                                <div class="">
                                    <h4 style="padding-left:13px;">Upload documents:</h4>
                                    <div class="text-center text-danger">
                                        Note:Pdfs & Images are only allowed up to 5mb in size
                                    </div>
                                    <div id="case1">

                                        <div class=" row form-group" id="file_comp_pan_card">
                                            <label class="control-label col-sm-4" for="file_comp_pan_card">Company Pancard: </label>
                                            <div class="col-sm-4">
                                                <input type="file" name="comp_pan_card" class="inputfile form-control inputfile-2 file-upload" 
                                                 id="fileUpload" accept=".pdf, image/*" onchange="checkFileExtension()" />
                                                <div id="file_comp_pan_card_error" style="color: red;"></div>
                                            </div>
                                        </div>

                                        <div class=" row form-group" id="file_comp_gst" >
                                            <label class="control-label col-sm-4" for="file_comp_gst">Company Gst: </label>
                                            <div class="col-sm-4">
                                                <input type="file" name="comp_gst_doc" class="inputfile form-control inputfile-2 file-upload"
                                                 accept=".pdf, image/*" onchange="checkFileExtension()" />
                                                <div id="file_comp_gst_error" style="color: red;"></div>
                                            </div>
                                        </div>

                                        <div class=" row form-group" id="file_bank_statement" >
                                            <label class="control-label col-sm-4" for="file_bank_statement">Bank Statement: </label>
                                            <div class="col-sm-4">
                                                <input type="file" name="bank_statement" class="inputfile form-control inputfile-2 file-upload" 
                                                accept=".pdf, image/*" onchange="checkFileExtension()"/>
                                                <div id="file_bank_statement_error" style="color: red;"></div>
                                            </div>
                                        </div>

                                        <div class=" row form-group" id="file_cancel_cheque" >
                                            <label class="control-label col-sm-4" for="file_cancel_cheque">Cancel cheque: </label>
                                            <div class="col-sm-4">
                                                <input type="file" name="cancel_cheque" class="inputfile form-control inputfile-2 file-upload" 
                                                accept=".pdf, image/*" onchange="checkFileExtension()"/>
                                                <div id="file_cancel_cheque_error" style="color: red;"></div>
                                            </div>
                                        </div>


                                        <div class=" row form-group" id="file_cofincorporation" >
                                            <label class="control-label col-sm-4" for="file_cofincorporation">Certificate of incorporation: </label>
                                            <div class="col-sm-4">
                                                <input type="file" name="cin_doc" class="inputfile form-control inputfile-2 file-upload"
                                                accept=".pdf, image/*" onchange="checkFileExtension()" />
                                                <div id="file_cofincorporation_error" style="color: red;"></div>
                                            </div>
                                        </div>


                                        <div class=" row form-group" id="moa" >
                                            <label class="control-label col-sm-4" for="moa">Moa:</label>
                                            <div class="col-sm-4">
                                                <input type="file" name="moa_doc" class="inputfile form-control inputfile-2 file-upload"
                                                accept=".pdf, image/*" onchange="checkFileExtension()" />
                                                <div id="moa_error" style="color: red;"></div>
                                            </div>
                                        </div>


                                        <div class=" row form-group" id="aoa" >
                                            <label class="control-label col-sm-4" for="aoa">Aoa: </label>
                                            <div class="col-sm-4">
                                                <input type="file" name="aoa_doc" class="inputfile form-control inputfile-2 file-upload" 
                                                accept=".pdf, image/*" onchange="checkFileExtension()"/>
                                                <div id="aoa_error" style="color: red;"></div>
                                            </div>
                                        </div>


                                        <div class=" row form-group" id="file_auth_sign_pancard">
                                            <label class="control-label col-sm-4" for="file_auth_sign_pancard">Auth signatory Pancard
                                                <span class="text-danger">*</span>:</label>
                                            <div class="col-sm-4">
                                                <input type="file" name="mer_pan_card" class="inputfile form-control inputfile-2 file-upload"
                                                accept=".pdf, image/*" onchange="checkFileExtension()" />
                                                <div id="file_auth_sign_pancard_error" style="color: red;"></div>
                                            </div>
                                        </div>

                                        <div class=" row form-group" id="file_auth_sign_aadhar">
                                            <label class="control-label col-sm-4" for="file_auth_sign_aadhar">Auth signatory Aadhar card: </label>
                                            <div class="col-sm-4">
                                                <input type="file" name="mer_aadhar_card" class="inputfile form-control inputfile-2 file-upload"
                                                accept=".pdf, image/*" onchange="checkFileExtension()" />
                                                <div id="file_auth_sign_aadhar_error" style="color: red;"></div>
                                            </div>
                                        </div>

                                        <div class=" row form-group" id="file_partnership" >
                                            <label class="control-label col-sm-4" for="file_partnership">Partnership Deed:</label>
                                            <div class="col-sm-4">
                                                <input type="file" name="partnership_deed" class="inputfile form-control inputfile-2 file-upload" 
                                                accept=".pdf, image/*" onchange="checkFileExtension()"/>
                                                <div id="file_comp_pan_card_error" style="color: red;"></div>
                                            </div>
                                        </div>

                                        <div class=" row form-group" id="file_llp_agreeement">
                                            <label class="control-label col-sm-4" for="file_llp_agreeement">LLP Agreement:</label>
                                            <div class="col-sm-4">
                                                <input type="file" name="llp_agreement" class="inputfile form-control inputfile-2 file-upload"
                                                accept=".pdf, image/*" onchange="checkFileExtension()" />
                                                <div id="file_comp_gst_error" style="color: red;"></div>
                                            </div>
                                        </div>

                                        <div class=" row form-group" id="file_registration">
                                            <label class="control-label col-sm-4" for="file_registration">Registration:</label>
                                            <div class="col-sm-4">
                                                <input type="file" name="registration_doc" class="inputfile form-control inputfile-2 file-upload" 
                                                accept=".pdf, image/*" onchange="checkFileExtension()"/>
                                                <div id="file_bank_statement_error" style="color: red;"></div>
                                            </div>
                                        </div>

                                        <div class=" row form-group" id="file_trustdeed">
                                            <label class="control-label col-sm-4" for="file_trustdeed">Trust Deed/ Bye-laws/ Constitutional Document: </label>
                                            <div class="col-sm-4">
                                                <input type="file" name="trust_constitutional" class="inputfile form-control inputfile-2 file-upload"
                                                accept=".pdf, image/*" onchange="checkFileExtension()" />
                                                <div id="file_cancel_cheque_error" style="color: red;"></div>
                                            </div>
                                        </div>


                                        <div class=" row form-group" id="file_noc">
                                            <label class="control-label col-sm-4" for="file_noc">No Objection Certificate: </label>
                                            <div class="col-sm-4">
                                                <input type="file" name="no_objection_doc" class="inputfile form-control inputfile-2 file-upload" 
                                                accept=".pdf, image/*" onchange="checkFileExtension()"/>
                                                <div id="file_cofincorporation_error" style="color: red;"></div>
                                            </div>
                                        </div>
                                    </div>



                                    {{-- <div class="row text-center " style="margin:10px 5px 10px 5px;">
                                        <button class="btn btn-primary" id="" onclick="return validator()" type="submit">
                                            Submit
                                        </button>
                                    </div> --}}


                                </div>
                            </div>
                            <!-- enduplad files -->
                                <div class="text-center">
                                    {{-- <div class="btn btn-success" id="prev">
                                        Prev
                                    </div>

                                    <div class="btn btn-info" id="next">
                                        Next
                                    </div> --}}
                                    <div id="errorMessages" class="error" style="color: red"></div>
                                    {{-- <div id="showerror2" class="text-danger text-center my-3"></div> --}}



                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <div class="col-sm-12"style="display: flex;justify-content: center;">
                                            <button type="submit" id="submitBtn" value="Submit" style="margin: 20px 0px;" 
                                            class="btn btn-primary Bussiness-infro-sub-mit text-center">Submit</button>
                                        </div>
                                    </div>


                                </div>
                            </div>
                    </form>
                </div>
    </div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        getMerchantDocsDetails();
    });
//Kindly restrict the text inputs inside the mobile number fields 

document.getElementById("mobile").addEventListener("keypress", function(event) {
    var charCode = event.which ? event.which : event.keyCode;
    
    if (charCode < 48 || charCode > 57) {
        event.preventDefault(); 
    }   
});
</script>

                
<script>
    // Function to perform form validation
    function busnes_sub() {
         // Validate Name
         var m_name = document.getElementById("m_name").value;
        if (m_name.trim() === "") {
            document.getElementById("errorMessages").innerText = "Name is required in the Personal Details tab";
            return false; // Prevent form submission
        }
        else {
            document.getElementById("errorMessages").innerText = "";
        }

        // Validate mobile
        var mobile = document.getElementById("mobile").value;
        if (mobile.trim() === "") {
            document.getElementById("errorMessages").innerText = "Mobile is required in the Personal Details tab";
            return false; // Prevent form submission
        }
        else {
            document.getElementById("errorMessages").innerText = "";
        }

        // Validate m_email
        var m_email = document.getElementById("m_email").value;
        if (m_email.trim() === "") {
            document.getElementById("errorMessages").innerText = "Email is required in the Personal Details tab";
            return false; // Prevent form submission
        }
        else {
            document.getElementById("errorMessages").innerText = "";
        }   

        // Validate password
        var password = document.getElementById("password").value;
        if (password.trim() === "") {
            document.getElementById("errorMessages").innerText = "Password is required in the Personal Details tab";
            return false; // Prevent form submission
        }
        else {
            document.getElementById("errorMessages").innerText = "";
        }


        // Validate companyname
        var companyname = document.getElementById("companyname").value;
        if (companyname.trim() === "") {
            document.getElementById("errorMessages").innerText = "Company Name is required in the Company info tab";
            return false; // Prevent form submission
        }
        else {
            document.getElementById("errorMessages").innerText = "";
        }

         // Validate companyaddress
        var companyaddress = document.getElementById("companyaddress").value;
        if (companyaddress.trim() === "") {
            document.getElementById("errorMessages").innerText = "Company Address is required in the Company info tab";
            return false; // Prevent form submission
        }
        else {
            document.getElementById("errorMessages").innerText = "";
        }

        // Validate companypincode
        var companypincode = document.getElementById("companypincode").value;
        if (companypincode.trim() === "") {
            document.getElementById("errorMessages").innerText = "Company Pincode is required in the Company info tab";
            return false; // Prevent form submission
        }
        else {
            document.getElementById("errorMessages").innerText = "";
        }

        
         // Validate companypincode
         var c_city = document.getElementById("c_city").value;
        if (c_city.trim() === "") {
            document.getElementById("errorMessages").innerText = "Company City is required in the Company info tab";
            return false; // Prevent form submission
        }
        else {
            document.getElementById("errorMessages").innerText = "";
        }

         // Validate state
         var state = document.getElementById("state").value;
        if (state.trim() === "") {
            document.getElementById("errorMessages").innerText = "State is required in the Company info Tab";
            return false; // Prevent form submission
        }
        else {
            document.getElementById("errorMessages").innerText = "";
        }


         // Validate state
         var c_country = document.getElementById("c_country").value;
        if (c_country.trim() === "") {
            document.getElementById("errorMessages").innerText = "Company country is required in the Company info tab";
            return false; // Prevent form submission
        }
        else {
            document.getElementById("errorMessages").innerText = "";
        }

        // Validate Bank Name
        var bankName = document.getElementById("business_bank_name").value;
        if (bankName.trim() === "") {
            document.getElementById("bank_name_error").innerText = "Bank Name is Mandatory";
            return false; // Prevent form submission
        } else {
            document.getElementById("bank_name_error").innerText = "";
        }

        // Validate Bank Acc No
        var bankAccNo = document.getElementById("business_bank_acc_no").value;
        if (bankAccNo.trim() === "") {
            document.getElementById("bank_acc_no_error").innerText = "Bank Acc No is Mandatory";
            return false; // Prevent form submission
        } else {
            document.getElementById("bank_acc_no_error").innerText = "";
        }

        // Validate Bank IFSC Code
        var bankIfsc = document.getElementById("bank_ifsc").value;
        if (bankIfsc.trim() === "") {
            document.getElementById("bank_ifsc_error").innerText = "Bank IFSC Code is Mandatory";
            return false; // Prevent form submission
        } else {
            document.getElementById("bank_ifsc_error").innerText = "";
        }

         // Validate branchname
         var branchname = document.getElementById("branchname").value;
        if (branchname.trim() === "") {
            document.getElementById("branchname_error").innerText = "BranchName is Mandatory";
            return false; // Prevent form submission
        } else {
            document.getElementById("branchname_error").innerText = "";
        }

        // Validate acc_holder_name
        var acc_holder_name = document.getElementById("acc_holder_name").value;
        if (acc_holder_name.trim() === "") {
            document.getElementById("acc_holder_name_error").innerText = "Account Holder Name is Mandatory";
            return false; // Prevent form submission
        } else {
            document.getElementById("acc_holder_name_error").innerText = "";
        }


        // Validate Auth signatory Pancard
        var fileAuthSignPancard = document.querySelector('input[name="mer_pan_card"]').files[0];

if (!fileAuthSignPancard) {
    document.getElementById("file_auth_sign_pancard_error").innerText = "Auth signatory Pancard is Mandatory ";
    return false; 
} else {
    document.getElementById("file_auth_sign_pancard_error").innerText = "";

  
    var maxSizeInBytes = 5 * 1024 * 1024; // 5MB
    if (fileAuthSignPancard.size > maxSizeInBytes) {
        document.getElementById("file_auth_sign_pancard_error").innerText = "File size exceeds the 5MB limit.";
        return false; 
    }
}


return true;
    }

    // Add event listener to the button to trigger form validation
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("submitBtn").addEventListener("click", function(event) {
            // Call the validation function when the button is clicked
            if (!busnes_sub()) {
                event.preventDefault(); // Prevent form submission if validation fails
            }
        });
    }); 

//submit validation end

//tab1 validation start
// Step 1: Get references to the input fields and the "Next" button
const nameInput = document.getElementById('m_name');
const emailInput = document.getElementById('m_email');
const mobileInput = document.getElementById('mobile');
const passwordInput = document.getElementById('password');
const nextButton = document.getElementById('next');

const nameerrorContainer = document.getElementById('name_showerror'); 
const emailerrorContainer = document.getElementById('email_showerror'); 
const mobileerrorContainer = document.getElementById('mobile_showerror'); 
const passworderrorContainer = document.getElementById('password_showerror'); 

// Function to validate Tab 1 fields
function validateTab1() {
   // Clear previous error messages
   nameerrorContainer.innerHTML = '';
   emailerrorContainer.innerHTML = '';
   mobileerrorContainer.innerHTML = '';
   passworderrorContainer.innerHTML = '';

   // Perform validation on the fields
   const name = nameInput.value.trim();
   const email = emailInput.value.trim();
   const mobile = mobileInput.value.trim();
   const password = passwordInput.value.trim();
   let isValid = true;

   // Validation rules
   if (name === '') {
       isValid = false;
       nameerrorContainer.innerHTML += 'Name field is required<br>';
   }

   if (email === '') {
       isValid = false;
       emailerrorContainer.innerHTML += 'Email field is required<br>';
   } else {
       const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
       if (!emailRegex.test(email)) {
           isValid = false;
           emailerrorContainer.innerHTML += 'Invalid email format<br>';
       }
   }

   if (mobile === '') {
       isValid = false;
       mobileerrorContainer.innerHTML += 'Mobile field is required<br>';
   }

   if (password === '') {
       isValid = false;
       passworderrorContainer.innerHTML += 'Password field is required<br>';
   }

   return isValid;
}

// Disable Tab 2 initially
$('.nav-tabs li:nth-child(2) .nav-link').addClass('disabled').removeAttr('data-toggle').css('pointer-events', 'none');


// Step 2: Attach a click event listener to the "Next" button
nextButton.addEventListener('click', function() {
   // Validate Tab 1 fields
   if (validateTab1()) {
       // Proceed to Tab 2 if validation succeeds
    $('#pane2').addClass('active show');
    $('#pane1').removeClass('active show');

    $('#tab1').removeClass('active');
    $('#tab2').addClass('active');

    
    // Enable Tab 2 and switch to it
    $('.nav-tabs li:nth-child(2) .nav-link').removeClass('disabled').attr('data-toggle', 'tab').css('pointer-events', 'auto');
    $('a[href="#pane2"]').tab('show');

    // Enable next button if needed
    nextButton.classList.add('enable');
   }
    else {
      // If validation fails, disable the next button
    nextButton.classList.remove('enable');
    $('#pane2').removeClass('active show');
    $('#pane1').addClass('in active show');

   }
});

 // Disable Tab 2 initially
//  $('.nav-tabs li:nth-child(2) .nav-link').addClass('disabled').removeAttr('data-toggle').css('pointer-events', 'none');

// Hide Tab 2 content initially
$('#pane2').hide();

//tab1 validation end

//tab2 validation start

//tab 2 validation 


// Step 1: Get references to the input fields and the "Next" button
// const monexpenditure = document.getElementById('monexpenditure');
const companyname = document.getElementById('companyname');
const companyaddress = document.getElementById('companyaddress');
const companypincode = document.getElementById('companypincode');
const c_city = document.getElementById('c_city');
const state = document.getElementById('state');
const c_country = document.getElementById('c_country');

const tab_nextButton = document.getElementById('tab_next');



// const monexpenditureContainer = document.getElementById('monexpenditure_showerror'); 
const companynameContainer = document.getElementById('companyname_showerror'); 
const companyaddressContainer = document.getElementById('companyaddress_showerror'); 
const companypincodeContainer = document.getElementById('companypincode_showerror'); 

const c_cityContainer = document.getElementById('c_city_showerror'); 

const stateContainer = document.getElementById('state_showerror'); 

const c_countryContainer = document.getElementById('c_country_showerror'); 


// Function to validate Tab 1 fields
function validateTab2() {

    console.log('tsssssssssssssssssssss');
   // Clear previous error messages
//    monexpenditureContainer.innerHTML = '';
   companynameContainer.innerHTML = '';
   companyaddressContainer.innerHTML = '';
   companypincodeContainer.innerHTML = '';

   c_cityContainer.innerHTML = '';

   stateContainer.innerHTML = '';

   c_countryContainer.innerHTML = '';


   // Perform validation on the fields
   const monexpenditurename = monexpenditure.value.trim();
   const companynameemail = companyname.value.trim();
   const companyaddressmobile = companyaddress.value.trim();
   const companypincodepassword = companypincode.value.trim();
   const c_citypassword = c_city.value.trim();
   const statepassword = state.value.trim();
   const c_countrypassword = c_country.value.trim();



   let isValid = true;

   // Validation rules
//    if (monexpenditurename === '') {
//        isValid = false;
//        monexpenditureContainer.innerHTML += 'Name field is required<br>';
//    }

   if (companynameemail === '') {
       isValid = false;
       companynameContainer.innerHTML += 'CompanyName field is required<br>';
   }

   if (companyaddressmobile === '') {
       isValid = false;
       companyaddressContainer.innerHTML += 'CompanyAddress field is required<br>';
   }

   if (companypincodepassword === '') {
       isValid = false;
       companypincodeContainer.innerHTML += 'CompanyPincode field is required<br>';
   }

   if (c_citypassword === '') {
       isValid = false;
       c_cityContainer.innerHTML += 'City field is required<br>';
   }


   if (statepassword === '') {
       isValid = false;
       stateContainer.innerHTML += 'State field is required<br>';
   }

   if (c_countrypassword === '') {
       isValid = false;
       c_countryContainer.innerHTML += 'Country field is required<br>';
   }


   return isValid;
}

// Step 2: Attach a click event listener to the "Next" button
tab_nextButton.addEventListener('click', function() {
    if (validateTab2()) {
    // Proceed to Tab 3 if validation succeeds
    $('#pane3').addClass('active show');
    $('#pane2').removeClass('active show');

    $('#pane2').hide();

    // Add and remove the tab active classes
    $('#tab1').removeClass('active');
    $('#tab2').removeClass('active');
    $('#tab3').addClass('active');

    // Enable Tab 3 and switch to it
    $('.nav-tabs li:nth-child(3) .nav-link')
        .removeClass('disabled')
        .attr('data-toggle', 'tab')
        .css('pointer-events', 'auto');
    $('a[href="#pane3"]').tab('show');
} else {
    // Show Tab 2 again if validation fails
    $('#pane2').show();
    $('a[href="#pane2"]').tab('show');

    // Optionally, you may want to hide Tab 3 if validation fails
    $('#pane3').hide();
}

});

// Event listener for when the user directly clicks on the tab for pane2
$('a[href="#pane2"]').on('click', function(event) {
        // If validation passes, hide pane2
        $('#pane2').show();
    
});

// Event listener for when the user directly clicks on the tab for pane2
$('a[href="#pane1"]').on('click', function(event) {
        // If validation passes, hide pane2
        $('a[href="#pane2"]').tab('hide'); // Switch to pane2
        $('a[href="#pane1"]').tab('show'); // Switch to pane1
        $('#pane2').hide();


    
});

// Event listener for when the user directly clicks on the tab for pane2
$('a[href="#pane3"]').on('click', function(event) {
        // If validation passes, hide pane2
        $('#pane2').hide();
    
});



// Disable Tab 3 initially
$('.nav-tabs li:nth-child(3) .nav-link')
    .addClass('disabled')
    .removeAttr('data-toggle')
    .css('pointer-events', 'none');

//tab2 validation end

$('#prev').on('click', function(event) {
    // Show pane1 and hide other panes
    $('#pane1').addClass('in active show');
    $('#pane2').removeClass('active show');
    $('#pane3').removeClass('active show');

    $('#pane2').hide();
    $('#pane1').show();

    // Add and remove the tab active classes accordingly
    $('#tab1').addClass('active');
    $('#tab2').removeClass('active');
    $('#tab3').removeClass('active');
});



//draft button

    $(document).ready(function() {
                var draftValues = JSON.parse(localStorage.getItem('draftValues'));

                if (draftValues) {
                    // Populate form fields with draft values
                    $.each(draftValues, function(key, value) {
                        $('[name="' + key + '"]').val(value);
                    });
                }

                // Listen for changes in form fields and save draft values
                $('input[type="text"]').on('input', function() {
                    var draftValues = {};
                    // Store input values in draftValues object
                    $('input[type="text"]').each(function() {
                        draftValues[$(this).attr('name')] = $(this).val();
                    });
                    // Save draftValues to localStorage
                    localStorage.setItem('draftValues', JSON.stringify(draftValues));
                });

                // Handle click event for the "Save Draft" button
                $('#saveDraft').on('click', function() {
                    var draftValues = {};
                    // Store input values in draftValues object
                    $('input[type="text"]').each(function() {
                        draftValues[$(this).attr('name')] = $(this).val();
                    });
                    // Save draftValues to localStorage
                    localStorage.setItem('draftValues', JSON.stringify(draftValues));
                });

                // Handle form submission
                $('#submitBtn').on('click', function() {
                    // Clear draft values from local storage after form submission
                    localStorage.removeItem('draftValues');
                });
            });

            $(document).ready(function(){
                $('#draft_form_btn').submit(function(e) {
                    var emptyFields = [];
                    $('input[type="text"]').each(function() {
                        if ($(this).val().trim() === '') {
                            emptyFields.push($(this).attr('name'));
                        }
                    });
                    if (emptyFields.length > 0) {
                        e.preventDefault();
                        $('#errorMessages').text('Please fill in the following fields: ' + emptyFields.join(', '));
                    } else {
                        $('#errorMessages').text(''); // Clear error messages
                    }
                });
            });


// this script file is password show button -->
function togglePassword() 
{
        const passwordInput = document.getElementById('password');
        const togglePasswordIcon = document.querySelector('.password-toggle');

        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);

        
        if (type === 'password') {
            togglePasswordIcon.classList.remove('fa-eye');
            togglePasswordIcon.classList.add('fa-eye-slash');
        } else {
            togglePasswordIcon.classList.remove('fa-eye-slash');
            togglePasswordIcon.classList.add('fa-eye');
        }
}



</script>

           


        
<script>
$(document).ready(function () {
    $("#business_type").change(function () {
                                
        var business_type = $(this).val();
        console.log("Input value changed to: " + business_type);
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
    });


//     $("#next,#prev").click(function(e) {
//             var button = $(this).attr('id')
//             console.log(button);
//             var counter = $("#modalcounter").val();
//             console.log("counter"+counter);

        
//         if (button === 'next') {
//                 // console.log('test');
//                 var name = $('#m_name').val();
//                 console.log("Name", name);
//                 var email = $('#m_email').val();
//                 var mobile = $('#mobile').val();
//                 var password = $('#password').val();

//                 var monexpenditure = $('#monexpenditure').val();
//                 var companyname = $('#companyname').val();
//                 var companypincode = $('#companypincode').val();
//                 var c_city = $('#c_city').val();
//                 var state = $('#state').val();
//                 var c_country = $('#c_country').val();

//                 var business_type = $('#business_type').val();
//                 var business_category = $('#business_category').val();
//                 var business_subcategory = $('#business_subcategory').val();
//                 var webapp_url = $('#webapp_url').val();
//                 var business_bank_name = $('#business_bank_name').val();
//                 var business_bank_acc_no = $('#business_bank_acc_no').val();
//                 var bank_ifsc = $('#bank_ifsc').val();

//                 var company_pan_no = $('#company_pan_no').val();
//                 var company_gst = $('#company_gst').val();
//                 var authorized_sign_pan_no = $('#authorized_sign_pan_no').val();
//                 var authorized_sign_aadhar_no = $('#authorized_sign_aadhar_no').val();
//                 var authorized_sign_name = $('#authorized_sign_name').val();
//                 //uploaded files
//                 var compPanCard = $("input[name='comp_pan_card']").val();
//                 var compGst = $("input[name='comp_gst_doc']").val();
//                 var bankStatement = $("input[name='bank_statement']").val();
//                 var cancelCheque = $("input[name='cancel_cheque']").val();
//                 var cofincorporation = $("input[name='cin_doc']").val();
//                 var moa = $("input[name='moa_doc']").val();
//                 var aoa = $("input[name='aoa_doc']").val();
//                 var authSignPancard = $("input[name='mer_pan_card']").val();
//                 var authSignAadhar = $("input[name='mer_aadhar_card']").val();
//                 var partnership = $("input[name='partnership_deed']").val();
//                 var llp = $("input[name='llp_agreement']").val();
//                 var registration = $("input[name='registration_doc']").val();
//                 var trustDeed = $("input[name='trust_constitutional']").val();
//                 var noc = $("input[name='no_objection_doc']").val();

//             //end uploaded files

//             console.log("business"+business_type);
//                 // validations start
            
//                 if (counter == 0) {
//                     var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
//                     var testMobile = /^[0-9]{10}$/i;

//                     if (!testEmail.test(email)) {
//                         $('#showerror').html('Email is not valid');
                        

//                         return false;
                    
//                     }
//                     else{
//                         $('#showerror').html(' '); 
//                     }
//                     if (!testMobile.test(mobile)) {
//                         $('#mobile_showerror').html('Mobile Number is not valid');

                    
//                         return false;
                    
//                     }
//                     else{
//                         $('#mobile_showerror').html(''); 
//                     }
//                     if (name.length == 0 || email.length == 0 || mobile.length == 0 || password.length == 0) {
//                         console.log('please fill all the fields');
//                         $('#allerror_showerror').html('Please fill all the fields');
//                         return false;
//                     }
//                     else{
//                         $('#allerror_showerror').html('');
//                     }

//                     $('#showerror').html('');
                    
//                 }
// // this is code is probelem clear===>(don't uncommand this)
//                 // // Move to the next tab (assuming you have multiple tabs with different IDs)
//                 // $("#pane1").removeClass("show in active");
//                 // $("#tab1").removeClass("active");

//                 // $("#pane2").addClass("show in active");
//                 // $("#tab2").addClass("active");

//                 // $("#pane3").removeClass("show in active");
//                 // $("#tab3").removeClass("active");

//                 if (counter == 1) {

                
//                     var testpincode = /^[1-9][0-9]{5}$/;

//                     if (!testpincode.test(companypincode)) {
//                         $('#showerror1').html('Pincode is not valid');

//                         return false;
//                     }
//                     console.log("monexpenditure"+monexpenditure)
//                     if (monexpenditure.length == 0 || companyname.length == 0 || companypincode.length == 0 ||
//                         c_city.length == 0 || state.length == 0 || c_country.length == 0) {
//                         console.log('please fill all the fields');
//                         $('#showerror1').html('Please fill all the fields');
//                         return false;
//                     }
//                     $('#showerror1').html('');
//                 }

//                 if (counter == 2) {

//                     console.log("businesstype"+business_type);
//                 if (business_type == 1) {
//                     $("#file_comp_pan_card").show();
//                     $("#file_comp_gst").show();
//                     $("#file_bank_statement").show();
//                     $("#file_cancel_cheque").show();
//                     $("#file_cofincorporation").show();
//                     $("#moa").show();
//                     $("#aoa").show();
//                     $("#file_auth_sign_pancard").show();
//                     $("#file_auth_sign_aadhar").show();

//                     $("#file_registration").hide();
//                     $("#file_trustdeed").hide();
//                     $("#file_noc").hide();
//                     $("#file_llp_agreeement").hide();
//                     $("#file_partnership").hide();

//                 } 

                
//                     // var ifsc = /^[A-Z]{4}0[A-Z0-9]{6}$/;
//                     // console.log("ifsc" + ifsc.test(bank_ifsc));
//                     // if (!ifsc.test(bank_ifsc)) {
//                     //     $('#showerror2').html('Ifsc is not valid');

//                     //     return false;
//                     // }
//                     // if ((business_bank_acc_no.length < 9) || (business_bank_acc_no.length > 18)) {
//                     //     console.log('acc not valid');
//                     //     $('#showerror2').html('Accont Number is not valid');
//                     //     return false;
//                     // }


//                     // if (business_type.length == 0 || business_category.length == 0 || business_subcategory.length ==
//                     //     0 || business_bank_name.length == 0 || business_bank_acc_no.length == 0 || bank_ifsc
//                     //     .length == 0) {
//                     //     console.log('please fill all the fields');
//                     //     $('#showerror2').html('Please fill all the fields');
//                     //     return false;
//                     // }




// // another pancard
//             // if (compPanCard.length != 0) {
//             //     var compPanCardSize = ($("input[name='comp_pan_card']")[0].files[0].size) / 1024;
//             //     console.log('%cmerchantdocument.blade.php line:1032 object', 'color: #007acc;', compPanCardSize);

//             //     if (parseInt(compPanCardSize) > 5120) {
//             //         $('#showerror2').html('Company Pan card is greater than 5 Mb');
//             //         return false;
//             //     }
//             // }

//             // if (compGst.length != 0) {
//             //     var compGstSize = ($("input[name='comp_gst_doc']")[0].files[0].size) / 1024;

//             //     if (parseInt(compGstSize) > 5120) {
//             //         $('#showerror2').html('Company Gst certificate is greater than 5 Mb');
//             //         return false;
//             //     }
//             // }

//             // if (bankStatement.length != 0) {
//             //     var bankStatementSize = ($("input[name='bank_statement']")[0].files[0].size) / 1024;


//             //     if (parseInt(bankStatementSize) > 5120) {
//             //         $('#showerror2').html('Bank Statement is greater than 5 Mb');
//             //         return false;
//             //     }
//             // }

//             // if (cancelCheque.length != 0) {
//             //     var cancelChequeSize = ($("input[name='cancel_cheque']")[0].files[0].size) / 1024;

//             //     if (parseInt(cancelChequeSize) > 5120) {
//             //         $('#showerror2').html('Cancel cheque is greater than 5 Mb');
//             //         return false;
//             //     }
//             // }

//             // if (cofincorporation.length != 0) {
//             //     var cofincorporationSize = ($("input[name='cin_doc']")[0].files[0].size) / 1024;

//             //     if (parseInt(cofincorporationSize) > 5120) {
//             //         $('#showerror2').html('Certificate of incorporation is greater than 5 Mb');
//             //         return false;
//             //     }
//             // }

//             // if (moa.length != 0) {
//             //     var moaSize = ($("input[name='moa_doc']")[0].files[0].size) / 1024;

//             //     if (parseInt(moaSize) > 5120) {
//             //         $('#showerror2').html('Moa Certificate is greater than 5 Mb');
//             //         return false;
//             //     }
//             // }


//             // if (aoa.length != 0) {
//             //     var aoaSize = ($("input[name='aoa_doc']")[0].files[0].size) / 1024;

//             //     if (parseInt(aoaSize) > 5120) {
//             //         $('#showerror2').html('Aoa Certificate is greater than 5 Mb');
//             //         return false;
//             //     }
//             // }

// // pancard validation confrimed 
//             if (authSignPancard.length != 0) {
//                 var authSignPancardSize = ($("input[name='mer_pan_card']")[0].files[0].size) / 1024;

//                 if (parseInt(authSignPancardSize) > 5120) {
//                     $('#showerror2').html('Auth signatory Pan card is greater than 5 Mb');
//                     return false;
//                 }
//             }
// // file size checking (5mb)
//             if (authSignAadhar.length != 0) {
//                 var authSignAadharSize = ($("input[name='mer_aadhar_card']")[0].files[0].size) / 1024;

//                 if (parseInt(authSignAadharSize) > 5120) {
//                     $('#showerror2').html('Auth signatory Aadhar card is greater than 5 Mb');
//                     return false;
//                 }
//             }

//             if (partnership.length != 0) {
//                 var partnershipSize = ($("input[name='partnership_deed']")[0].files[0].size) / 1024;


//                 if (parseInt(partnershipSize) > 5120) {
//                     $('#showerror2').html('Partnership Certificate is greater than 5 Mb');
//                     return false;
//                 }
//             }

//             if (llp.length != 0) {
//                 var llpSize = ($("input[name='llp_agreement']")[0].files[0].size) / 1024;
//                 console.log('%cmerchantdocument.blade.php line:1032 object', 'color: #007acc;', compPanCardSize);

//                 if (parseInt(llpSize) > 5120) {
//                     $('#showerror2').html('LLp Certificate is greater than 5 Mb');
//                     return false;
//                 }
//             }

//             if (registration.length != 0) {
//                 var registrationSize = ($("input[name='registration_doc']")[0].files[0].size) / 1024;

//                 if (parseInt(registrationSize) > 5120) {
//                     $('#showerror2').html('Registration Certificate is greater than 5 Mb');
//                     return false;
//                 }
//             }

//             if (trustDeed.length != 0) {
//                 var trustDeedSize = ($("input[name='trust_constitutional']")[0].files[0].size) / 1024;


//                 if (parseInt(trustDeedSize) > 5120) {
//                     $('#showerror2').html('Trust Deed Certificate is greater than 5 Mb');
//                     return false;
//                 }
//             }

//             if (noc.length != 0) {
//                 var nocSize = ($("input[name='no_objection_doc']")[0].files[0].size) / 1024;


//                 if (parseInt(nocSize) > 5120) {
//                     $('#showerror2').html('No objection certificate is greater than 5 Mb');
//                     return false;
//                 }
//             }
//             if (business_type == 1) {

//                 if (authSignPancard.length ==0) {
//                     $('#showerror2').html('Please Upload Auth signatory Pancard');
//                     return false;
//                 }

//             } else if (business_type == 2) {

//                 if (authSignPancard.length ==0) {
//                     $('#showerror2').html('Please Upload Auth signatory Pancard');
//                     return false;
//                 }

//             } else if (business_type == 3) {

//                 if (authSignPancard.length ==0) {
//                     $('#showerror2').html('Please Upload Auth signatory Pancard');
//                     return false;
//                 }

//             } else if (business_type == 4) {

//                 if (authSignPancard.length ==0) {
//                     $('#showerror2').html('Please Upload Auth signatory Pancard');
//                     return false;
//                 }

//             } else if (business_type == 5) {

//                 if (authSignPancard.length ==0) {
//                     $('#showerror2').html('Please Upload Auth signatory Pancard');
//                     return false;
//                 }


//             } else if (business_type == 9) {

//                 if (authSignPancard.length ==0) {
//                     $('#showerror2').html('Please Upload Auth signatory Pancard');
//                     return false;
//                 }
//             } else {


//                 if (authSignPancard.length ==0) {
//                     $('#showerror2').html('Please Upload Auth signatory Pancard');
//                     return false;
//                 }
//             }
//                     $('#showerror2').html('');
//                 }

//                 if (counter == 3) {
//                     var checkgst =
//                     /[0-9]{2}[A-Z]{3}[ABCFGHLJPTF]{1}[A-Z]{1}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}/;
//                     var checkauthpan = /^([A-Z]){3}P([A-Z])([0-9]){4}([A-Z]){1}?$/;
//                     var checkcompanypan = /^([A-Z]){3}C([A-Z])([0-9]){4}([A-Z]){1}?$/;

//                     if (company_pan_no.length == 0 ) {
//                         console.log('please fill all the fields');
//                         $('#showerror').html('Please fill all the fields');
//                         return false;
//                     }
//                     if (!checkauthpan.test(authorized_sign_pan_no)) {
//                         $('#showerror').html('Authorized Signatory PAN No  is not valid');

//                         return false;
//                     }
//                     if (!checkcompanypan.test(company_pan_no)) {
//                         $('#showerror').html('Company PAN No is not valid');

//                         return false;
//                     }

//                     if (authorized_sign_aadhar_no.length != 12) {
//                         console.log('aadhar not valid');
//                         $('#showerror').html('Aadhar Number is not valid');
//                         return false;
//                     }
//                     if (!checkgst.test(company_gst)) {
//                         $('#showerror').html('GSTIN  is not valid');

//                         return false;
//                     }
//                     $('#showerror').html('');
//                 }

//                 counter++;
//                 $(".nav-link").eq(counter).tab("show");
//                 // var uk = $(".nav-link").eq(counter).tab("show");
//                 $("#pane1").removeClass('show')
//                 // Update the visibility of Prev and Next buttons based on the current tab
//                 updateButtonVisibility(counter);
//             } else if (button === 'prev') {
//                 if (counter == 0) {

//                 }
//                 counter--;
                
//                 $(".nav-link").eq(counter).tab("show");
        
//                 // Update the visibility of Prev and Next buttons based on the current tab
//                 updateButtonVisibility(counter);
                

//             }

//             $("#modalcounter").val(counter);

//             if (counter == "0") {
//                 $("#personaldetails").show();
//                 $("#businessdetails").hide();
//                 $("#businessinfodetails").hide();
//                 $("#businessmoredetails").hide();
//                 $("#uploadfiles").show();
//                 $("#prev").hide();
//                 $("#next").show();

//             } else if (counter == "1") {
//                 $("#personaldetails").hide();
//                 $("#businessdetails").show();
//                 $("#businessinfodetails").hide();
//                 $("#businessmoredetails").hide();
//                 $("#uploadfiles").show();
//                 $("#prev").show();
//                 // $("#next").show();
                
//             } else if (counter == "2") {
//                 $("#personaldetails").hide();
//                 $("#businessdetails").hide();
//                 $("#businessinfodetails").show();
//                 $("#businessmoredetails").hide();
//                 $("#uploadfiles").show();
//                 $("#prev").show();
//                 // $("#next").show();
//                 console.log("businesstype"+business_type);
//                 if (business_type == 1) {
//                     $("#file_comp_pan_card").show();
//                     $("#file_comp_gst").show();
//                     $("#file_bank_statement").show();
//                     $("#file_cancel_cheque").show();
//                     $("#file_cofincorporation").show();
//                     $("#moa").show();
//                     $("#aoa").show();
//                     $("#file_auth_sign_pancard").show();
//                     $("#file_auth_sign_aadhar").show();

//                     $("#file_registration").hide();
//                     $("#file_trustdeed").hide();
//                     $("#file_noc").hide();
//                     $("#file_llp_agreeement").hide();
//                     $("#file_partnership").hide();

//                 } else if (business_type == 2) {
//                     $("#file_comp_pan_card").hide();
//                     $("#file_comp_gst").show();
//                     $("#file_bank_statement").show();
//                     $("#file_cancel_cheque").show();
//                     $("#file_auth_sign_pancard").show();
//                     $("#file_auth_sign_aadhar").show();

//                     $("#file_cofincorporation").hide();
//                     $("#moa").hide();
//                     $("#aoa").hide();
//                     $("#file_registration").hide();
//                     $("#file_trustdeed").hide();
//                     $("#file_noc").hide();
//                     $("#file_llp_agreeement").hide();
//                     $("#file_partnership").hide();

//                 } else if (business_type == 3) {
//                     $("#file_comp_pan_card").show();
//                     $("#file_comp_gst").show();
//                     $("#file_bank_statement").show();
//                     $("#file_cancel_cheque").show();
//                     $("#file_auth_sign_pancard").show();
//                     $("#file_auth_sign_aadhar").show();
//                     $("#file_partnership").show();

//                     $("#file_cofincorporation").hide();
//                     $("#moa").hide();
//                     $("#aoa").hide();
//                     $("#file_registration").hide();
//                     $("#file_trustdeed").hide();
//                     $("#file_noc").hide();
//                     $("#file_llp_agreeement").hide();




//                 } else if (business_type == 4) {
//                     $("#file_comp_pan_card").show();
//                     $("#file_comp_gst").show();
//                     $("#file_bank_statement").show();
//                     $("#file_cancel_cheque").show();
//                     $("#file_auth_sign_pancard").show();
//                     $("#file_auth_sign_aadhar").show();
//                     $("#file_partnership").show();
//                     $("#moa").show();
//                     $("#aoa").show();
//                     $("#file_cofincorporation").show();

//                     $("#file_registration").hide();
//                     $("#file_trustdeed").hide();
//                     $("#file_noc").hide();
//                     $("#file_llp_agreeement").hide();

//                 } else if (business_type == 5) {
//                     $("#file_comp_pan_card").show();
//                     $("#file_comp_gst").show();
//                     $("#file_bank_statement").show();
//                     $("#file_cancel_cheque").show();
//                     $("#file_auth_sign_pancard").show();
//                     $("#file_auth_sign_aadhar").show();
//                     $("#file_llp_agreeement").show();
//                     $("#file_cofincorporation").show();


//                     $("#moa").hide();
//                     $("#aoa").hide();
//                     $("#file_registration").hide();
//                     $("#file_trustdeed").hide();
//                     $("#file_noc").hide();
//                     $("#file_partnership").hide();
//                 } else if (business_type == 9) {
//                     $("#file_comp_pan_card").show();
//                     $("#file_auth_sign_pancard").show();
//                     $("#file_auth_sign_aadhar").show();

//                     $("#file_bank_statement").hide();
//                     $("#file_cancel_cheque").hide();
//                     $("#file_comp_pan_card").hide();
//                     $("#file_cofincorporation").hide();
//                     $("#moa").hide();
//                     $("#aoa").hide();
//                     $("#file_registration").hide();
//                     $("#file_trustdeed").hide();
//                     $("#file_noc").hide();
//                     $("#file_llp_agreeement").hide();
//                     $("#file_partnership").hide();
//                 } else {
//                     $("#file_comp_pan_card").show();
//                     $("#file_auth_sign_pancard").show();
//                     $("#file_auth_sign_aadhar").show();
//                     $("#file_registration").show();
//                     $("#file_trustdeed").show();
//                     $("#file_noc").show();

//                     $("#file_comp_gst").show();
//                     $("#file_bank_statement").hide();
//                     $("#file_cancel_cheque").hide();
//                     $("#file_cofincorporation").hide();
//                     $("#moa").hide();
//                     $("#aoa").hide();
//                     $("#file_llp_agreeement").hide();
//                     $("#file_partnership").hide();
//                 }
//             } else if (counter == "3") {
//                 $("#personaldetails").hide();
//                 $("#businessdetails").hide();
//                 $("#businessinfodetails").hide();
//                 $("#businessmoredetails").show();
//                 $("#uploadfiles").show();
//                 $("#prev").show();
//                 $("#next").show();
//             } else if (counter == "4") {
//                 $("#uploadfiles").show();
//                 $("#personaldetails").hide();
//                 $("#businessdetails").hide();
//                 $("#businessinfodetails").hide();
//                 $("#businessmoredetails").hide();
//                 $("#prev").show();
//                 $("#next").hide();
//                 if (business_type == 1) {
//                     $("#file_comp_pan_card").show();
//                     $("#file_comp_gst").show();
//                     $("#file_bank_statement").show();
//                     $("#file_cancel_cheque").show();
//                     $("#file_cofincorporation").show();
//                     $("#moa").show();
//                     $("#aoa").show();
//                     $("#file_auth_sign_pancard").show();
//                     $("#file_auth_sign_aadhar").show();

//                     $("#file_registration").hide();
//                     $("#file_trustdeed").hide();
//                     $("#file_noc").hide();
//                     $("#file_llp_agreeement").hide();
//                     $("#file_partnership").hide();

//                 } else if (business_type == 2) {
//                     $("#file_comp_pan_card").hide();
//                     $("#file_comp_gst").show();
//                     $("#file_bank_statement").show();
//                     $("#file_cancel_cheque").show();
//                     $("#file_auth_sign_pancard").show();
//                     $("#file_auth_sign_aadhar").show();

//                     $("#file_cofincorporation").hide();
//                     $("#moa").hide();
//                     $("#aoa").hide();
//                     $("#file_registration").hide();
//                     $("#file_trustdeed").hide();
//                     $("#file_noc").hide();
//                     $("#file_llp_agreeement").hide();
//                     $("#file_partnership").hide();

//                 } else if (business_type == 3) {
//                     $("#file_comp_pan_card").show();
//                     $("#file_comp_gst").show();
//                     $("#file_bank_statement").show();
//                     $("#file_cancel_cheque").show();
//                     $("#file_auth_sign_pancard").show();
//                     $("#file_auth_sign_aadhar").show();
//                     $("#file_partnership").show();

//                     $("#file_cofincorporation").hide();
//                     $("#moa").hide();
//                     $("#aoa").hide();
//                     $("#file_registration").hide();
//                     $("#file_trustdeed").hide();
//                     $("#file_noc").hide();
//                     $("#file_llp_agreeement").hide();




//                 } else if (business_type == 4) {
//                     $("#file_comp_pan_card").show();
//                     $("#file_comp_gst").show();
//                     $("#file_bank_statement").show();
//                     $("#file_cancel_cheque").show();
//                     $("#file_auth_sign_pancard").show();
//                     $("#file_auth_sign_aadhar").show();
//                     $("#file_partnership").show();
//                     $("#moa").show();
//                     $("#aoa").show();
//                     $("#file_cofincorporation").show();

//                     $("#file_registration").hide();
//                     $("#file_trustdeed").hide();
//                     $("#file_noc").hide();
//                     $("#file_llp_agreeement").hide();

//                 } else if (business_type == 5) {
//                     $("#file_comp_pan_card").show();
//                     $("#file_comp_gst").show();
//                     $("#file_bank_statement").show();
//                     $("#file_cancel_cheque").show();
//                     $("#file_auth_sign_pancard").show();
//                     $("#file_auth_sign_aadhar").show();
//                     $("#file_llp_agreeement").show();
//                     $("#file_cofincorporation").show();


//                     $("#moa").hide();
//                     $("#aoa").hide();
//                     $("#file_registration").hide();
//                     $("#file_trustdeed").hide();
//                     $("#file_noc").hide();
//                     $("#file_partnership").hide();
//                 } else if (business_type == 9) {
//                     $("#file_comp_pan_card").show();
//                     $("#file_auth_sign_pancard").show();
//                     $("#file_auth_sign_aadhar").show();

//                     $("#file_bank_statement").hide();
//                     $("#file_cancel_cheque").hide();
//                     $("#file_comp_pan_card").hide();
//                     $("#file_cofincorporation").hide();
//                     $("#moa").hide();
//                     $("#aoa").hide();
//                     $("#file_registration").hide();
//                     $("#file_trustdeed").hide();
//                     $("#file_noc").hide();
//                     $("#file_llp_agreeement").hide();
//                     $("#file_partnership").hide();
//                 } else {
//                     $("#file_comp_pan_card").show();
//                     $("#file_auth_sign_pancard").show();
//                     $("#file_auth_sign_aadhar").show();
//                     $("#file_registration").show();
//                     $("#file_trustdeed").show();
//                     $("#file_noc").show();

//                     $("#file_comp_gst").show();
//                     $("#file_bank_statement").hide();
//                     $("#file_cancel_cheque").hide();
//                     $("#file_cofincorporation").hide();
//                     $("#moa").hide();
//                     $("#aoa").hide();
//                     $("#file_llp_agreeement").hide();
//                     $("#file_partnership").hide();
//                 }
//             }


//     });

});


function updateButtonVisibility(counter) {
    if (counter === 0) {
        $("#prev").hide();
        $("#next").show();
    } else if (counter === 1 || counter === 2) {
        $("#prev").show();
        $("#next").show();
    } else if (counter === 3) {
        $("#prev").show();
        $("#next").hide();
    }
}

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

                    $('select[name="business_subcategory"]').append('<option value="' +
                        value.id + '">' + value.sub_category_name + '</option>');
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

                    $('select[name="business_subcategory"]').append('<option value="' +
                        value.id + '">' + value.sub_category_name + '</option>');
                })
            }
        })
        console.log("ready!");
    });
</script>
@endsection
<script>
document.addEventListener('DOMContentLoaded', function() {
        // console.log('onload test');

        document.getElementById('m_email').addEventListener('input', function() {
            console.log('test');
            var email = this.value;
            if (isValidEmail(email)) {
                document.getElementById('invalid-email-error').style.display = 'none';
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '/check-email', true);
                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            var response = JSON.parse(xhr.responseText);
                            // console.log('output', response);
                            if (response.exists) {
                                document.getElementById('email-error').style.display = 'block';
                            } else {
                                document.getElementById('email-error').style.display = 'none';
                            }
                        } else {
                            console.error('Error:', xhr.statusText);
                        }
                    }
                };
                xhr.send(JSON.stringify({ email: email }));
            } else {
                
                document.getElementById('email_showerror').style.display = 'none';
                document.getElementById('email-error').style.display = 'none';
                document.getElementById('invalid-email-error').style.display = 'block';
                document.getElementById('showerror').style.display = 'none';

                
            }
        });

        function isValidEmail(email) {
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailPattern.test(email);
        }
});

   
function checkFileExtension() {
    // Get all file inputs with the specified class name
    var fileInputs = document.querySelectorAll('.file-upload');
  
    // Loop through each file input
    fileInputs.forEach(function(fileInput) {
        var errorMessage = fileInput.nextElementSibling; // Get the error message element
        var fileName = fileInput.value.split('\\').pop(); // Get the file name from the file path
        var fileExtension = fileName.split('.').pop(); // Get the file extension

        if (fileExtension.toLowerCase() === 'zip') {
            errorMessage.textContent = 'Sorry, .zip files are not allowed.';
            fileInput.value = ''; // Clear the file input field
        } else {
            errorMessage.textContent = '';
        }
    });
}



</script>

