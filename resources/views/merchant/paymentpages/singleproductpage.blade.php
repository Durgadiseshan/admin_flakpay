@extends('layouts.paymentpage')

@section('content')

@switch($form)
@case("create")
<footer id="contact-us">
    <div class="container">
        <div class="footer-content">
            <div class="row">
                <!-- ***** Contact Form Start ***** -->
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="">
                        <!--  -->
                        <div class="card mt-5 col-md-12 animated bounceInDown myForm">
                            <div class="car">
                                <!-- <p>Test Mode is on. Only test payments can be made for this payment page.</p> -->
                            </div>
                            <hr>
                            <div class="heading">
                                <h3>Payment Detail</h3>
                                <div class="title-underline"></div>
                            </div>
                            <div class="card-body">
                                <form class="form-detail" method="post" id="dynamic-input-detail">
                                    <div class="col-md-12 section-table borderless" id="makeEditable">
                                       
                                        <div class="section-tbody">
                                          <div class="form-group row section-tr table-row1">
                                            <span class="col-sm-4 input-label">Email</span>
                                            <span class="col-sm-7">
                                             <input type="text" class="form-control readonly1" name="input_email" data-label="Email" value="" readonly placeholder="To be filled by customer">
                                            </span>
                                            <span class="col-sm-1 edit1">
                                               
                                                <a class="add" data-toggle="popover" title="Save"><i class="fa fa-check text-success"></i></a>
                                                <a class="edit"  data-toggle="popover" title="Edit"><i class="fa fa-pencil text-info"></i></a>
                                                <a class="delete del1" data-toggle="popover" title="Delete"><i class="fa fa-trash text-danger"></i></a>
                                            </span>
                                            </div>
                                          <div class="form-group row section-tr table-row2">
                                            <span class="col-sm-4 input-label">Mobile</span>
                                            <span class="col-sm-7">
                                             <input type="text" class="form-control readonly2" name="input_mobile" data-label="Mobile" value="" readonly placeholder="To be filled by customer">
                                            </span>
                                            <span class="col-sm-1 edit2">
                                                <a class="add" data-toggle="popover" title="Save"><i class="fa fa-check text-success"></i></a>
                                                <a class="edit" data-toggle="popover" title="Edit"><i class="fa fa-pencil text-info"></i></a>
                                                <a class="delete del2" data-toggle="popover" title="Delete"><i class="fa fa-trash text-danger"></i></a>
                                            </span>
                                        </div>
                                          <div class="form-group row section-tr table-row3">
                                            <span class="col-sm-4 input-label">Amount</span>
                                            <span class="col-sm-7">
                                             <input type="text" class="form-control" name="input_amount" value="" data-label="Amount" placeholder="To be filled by you">
                                            </span>
                                            <span class="col-sm-1 edit3" >
                                                <a class="add" data-toggle="popover" title="Save"><i class="fa fa-check text-success"></i></a>
                                                <a class="edit" data-toggle="popover" title="Edit"><i class="fa fa-pencil text-info"></i></a>
                                                <a class="delete del3" data-toggle="popover" title="Delete"><i class="fa fa-trash text-danger"></i></a>
                                            </span>
                                        </div>
                                 
                                        </div>
                                    </div>
                                    <div class="form-group row mt-4">
                                        <p class="col-sm-4"><label for="inputPassword3" class="col-form-label">Add New :</label></p>
                                        <p class="col-sm-4 dropdown">
                                            <select class="custom-select" id="inlineFormCustomSelect">
                                               <option selected>Input Field</option>
                                               <option class="add-new">Dropdown</option>
                                                <option class="add-new">Textarea</option>
                                                <option class="add-new">Textinput</option>
                                                <option class="add-new">Coupon</option>
                                              </select>
                                         </p>
                                        <p class="col-sm-4">
                                            <select class="custom-select" id="inlineFormCustomSelect">
                                                <option selected><span id="alpha">&#8377;</span>&nbsp;Price Field</option>
                                                <option class="add-new">Fixed Amount</option>
                                                <option class="add-new">Customer Amount</option>
                                                <option class="add-new">Item with quantity</option>
                                               
                                              </select>
                                            </p>
                                    </div>
                                    <div class="col-md-12 table borderless" id="makeEditable">
                                        <div>
                                          <div class="form-group row section-tr" id="table-row5">
                                            <span class="col-sm-4"></span>
                                            <span class="col-sm-8">
                                             <button class="btn btn-gradient float-right">Pay &#8377;<span id="page-total">0.00</span></button>
                                            </span>
                                        </div>                                     
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ***** Contact Form End ***** -->
                <div class="right-content col-lg-6 col-md-12 col-sm-12">
                    <form class="form-detail" method="post" id="page-detail">
                        <div class="contain">
                            <div class="avtar1">
                                <input type='file' id="imageUpload" class="imgupload" name="page_logo" accept=".png, .jpg, .jpeg" />
                            </div>
                            <div class="avatar-upload">
                                <input type="button" id="removeImage1" value="x" class="btn-rmv1" />
                                <div class="avatar-preview">
                                    <div id="imagePreview" class="imgPre" style="background-image: url(/images/logo-upload.png);">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="side-1">
                            <input type="text" name="page_title" value="" placeholder="Enter Page Title Here">
                        </div>
                        <div class="contact-side">
                            <div>
                                <button class="btn-transparent Button" id="social-button-open">+ Add social media share icons</button>
                                <ul class="social">
                                    <p class="para">Share this on :</p>
                                    <li><a href=""><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                                    <li><button class="btn-transremove" id="social-button-close">Remove</button></li>
                                </ul>
                            </div>

                            <div class="form-right">
                                <button class="btn-transparent2 Button" id="contact-us-open">+ Add your contact information</button>
                                <div class="col-md-8">
                                    <div id="dynamic_container" class="dynamic">
                                        <p class="para">Contact Us :</p>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text br-15"><i class="fa fa-envelope"></i></span>
                                            </div>
                                            <input type="text" name="contactus_email" placeholder="info@payflash.in" class="form-control" id="right-inp" />
                                        </div>
                                        <div class="input-group mt-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text br-15"><i class="fa fa-phone-square"></i></span>
                                            </div>
                                            <input type="text" name="contactus_mobile" placeholder="+91 9087711911" class="form-control" id="right-inp2"/>
                                        </div>
                                        <div class="input-group">
                                            <span><button class="btn-transremove" id="contact-us-close">Remove</button></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 form-right text-move">
                                <button class="btn-transparent3 Button" id="term-condition-open">+ Add term & conditions</button>
                                <div class="input-group text-area">
                                    <p class="para">Term & Condition :</p>
                                    <textarea name="term_condition" id="" cols="30" rows="1" class="text"></textarea> 
                                    <span id="term-condition-close"><button class="btn-transremove">Remove</button></span>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="payment_total" value="">
                        <input type="hidden" name="social_enable" id="social_enable" value="N">
                        <input type="hidden" name="contactus_enable" id="contactus_enable" value="N">
                        <input type="hidden" name="term_condition_enable" id="term_condition_enable" value="N">
                        <input type="hidden" name="page_name" value="singleproductpage">
                        {{csrf_field()}}
                    </form>
                    <div class="contact-social">
                        <img src="{{asset('/images/card10.png')}}" width="350" class="img-fluid" alt="card10.png">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="sub-footer">
                    <p>&copy; Copyright 2020 <strong>Payflash</strong>

                    | Powered by <strong>Payflash</strong></p>
                </div>
            </div>
        </div>
    </div>
</footer>
@break
@case("edit")
<footer id="contact-us">
    <div class="container">
        <div class="footer-content">
            <div class="row">
                <!-- ***** Contact Form Start ***** -->
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="">
                        <!--  -->
                        <div class="card mt-5 col-md-12 animated bounceInDown myForm">
                            <div class="car">
                                <!-- <p>Test Mode is on. Only test payments can be made for this payment page.</p> -->
                            </div>
                            <hr>
                            <div class="heading">
                                <h3>Payment Detail</h3>
                                <div class="title-underline"></div>
                            </div>
                            <div class="card-body">
                                <form class="form-detail" method="post" id="dynamic-input-detail">
                                    <div class="col-md-12 section-table borderless" id="makeEditable">
                                          @foreach($page_details["page_inputs"] as $page_input)
                                          @switch($page_input["input_type"])
                                            @case("INPUT")
                                                @switch($page_input["input_name"])
                                                    @case("input_email")
                                                        <div class="section-tbody">
                                                        <div class="form-group row section-tr table-row1">
                                                            <span class="col-sm-4 input-label">{{$page_input['input_label']}}</span>
                                                            <span class="col-sm-7">
                                                            <input type="text" class="form-control readonly1" name="{{$page_input['input_name']}}" data-label="{{$page_input['input_label']}}" value="" readonly placeholder="To be filled by customer">
                                                            </span>
                                                            <span class="col-sm-1 edit1">
                                                                <a class="add" data-toggle="popover" title="Save"><i class="fa fa-check text-success"></i></a>
                                                                <a class="edit"  data-toggle="popover" title="Edit"><i class="fa fa-pencil text-info"></i></a>
                                                                <a class="delete del1" data-toggle="popover" title="Delete"><i class="fa fa-trash text-danger"></i></a>
                                                            </span>
                                                        </div>
                                                    @break
                                                    @case("input_mobile")
                                                        <div class="form-group row section-tr table-row2">
                                                            <span class="col-sm-4 input-label">{{$page_input['input_label']}}</span>
                                                            <span class="col-sm-7">
                                                            <input type="text" class="form-control readonly2" name="{{$page_input['input_name']}}" data-label="{{$page_input['input_label']}}" value="" readonly placeholder="To be filled by customer">
                                                            </span>
                                                            <span class="col-sm-1 edit2">
                                                                <a class="add" data-toggle="popover" title="Save"><i class="fa fa-check text-success"></i></a>
                                                                <a class="edit"  data-toggle="popover" title="Edit"><i class="fa fa-pencil text-info"></i></a>
                                                                <a class="delete del2" data-toggle="popover" title="Delete"><i class="fa fa-trash text-danger"></i></a>
                                                            </span>
                                                        </div>
                                                    @break
                                                    @case("input_amount")
                                                        <div class="form-group row section-tr table-row3">
                                                            <span class="col-sm-4 input-label">{{$page_input['input_label']}}</span>
                                                            <span class="col-sm-7">
                                                            <input type="text" class="form-control readonly3" name="{{$page_input['input_name']}}" data-label="{{$page_input['input_label']}}" value="{{$page_input['input_value']}}" placeholder="To be filled by customer">
                                                            </span>
                                                            <span class="col-sm-1 edit3">
                                                                <a class="add" data-toggle="popover" title="Save"><i class="fa fa-check text-success"></i></a>
                                                                <a class="edit"  data-toggle="popover" title="Edit"><i class="fa fa-pencil text-info"></i></a>
                                                                <a class="delete del3" data-toggle="popover" title="Delete"><i class="fa fa-trash text-danger"></i></a>
                                                            </span>
                                                        </div>
                                                        </div>
                                                    @break
                                                    @case("item_amount")
                                                        <div class="form-group row table-roww section-tr">
                                                            <span class="col-sm-4 input-label">{{$page_input['input_label']}}</span>
                                                            <span class="col-sm-7">
                                                                <input type="text" class="form-control" name="{{$page_input['input_name']}}" data-label="{{$page_input['input_label']}}" id="border-tr" placeholder="To be filled by you" value="{{$page_input['input_value']}}">
                                                                <span class="range">1</span>
                                                            </span>
                                                            <span class="col-sm-1 actions" style="line-height: 20px; display: none;">
                                                            <a class="add" data-toggle="popover" title="Save"><i class="fa fa-check text-success"></i></a>
                                                            <a class="edit" data-toggle="popover" title="Edit"><i class="fa fa-pencil text-info"></i></a>
                                                            <a class="delete" data-toggle="popover" title="Delete"><i class="fa fa-trash text-danger"></i></a>
                                                            </span>
                                                        </div>
                                                    @break
                                                    @case("fixed_amount")
                                                        <div class="form-group row table-roww section-tr">
                                                            <span class="col-sm-4 input-label">{{$page_input['input_label']}}</span>
                                                            <span class="col-sm-7">
                                                                <input type="text" class="form-control" name="{{$page_input['input_name']}}" data-label="{{$page_input['input_label']}}" value="{{$page_input['input_value']}}" placeholder="To be filled by You">
                                                            </span>
                                                            <span class="col-sm-1 actions" style="line-height: 20px; display: none;">
                                                                <a class="add" data-toggle="popover" title="Save"><i class="fa fa-check text-success"></i></a>
                                                                <a class="edit"  data-toggle="popover" title="Edit"><i class="fa fa-pencil text-info"></i></a>
                                                                <a class="delete" data-toggle="popover" title="Delete"><i class="fa fa-trash text-danger"></i></a>
                                                            </span>
                                                        </div>
                                                    @break
                                                    @default
                                                    <div class="form-group row table-roww section-tr">
                                                        <span class="col-sm-4 input-label">{{$page_input['input_label']}}</span>
                                                        <span class="col-sm-7">
                                                        <input type="text" class="form-control readonly1" name="{{$page_input['input_name']}}" data-label="{{$page_input['input_label']}}" value="{{$page_input['input_value']}}" readonly placeholder="To be filled by customer">
                                                        </span>
                                                        <span class="col-sm-1 actions" style="line-height: 20px; display: none;">
                                                            <a class="add" data-toggle="popover" title="Save"><i class="fa fa-check text-success"></i></a>
                                                            <a class="edit"  data-toggle="popover" title="Edit"><i class="fa fa-pencil text-info"></i></a>
                                                            <a class="delete" data-toggle="popover" title="Delete"><i class="fa fa-trash text-danger"></i></a>
                                                        </span>
                                                    </div>
                                                    @break
                                                @endswitch
                                            @break
                                            @case("SELECT")
                                            <div class="form-group row table-roww tdContainer section-tr">
                                                <span class="col-sm-4 input-label">{{$page_input['input_label']}}</span>
                                                <span class="col-sm-7">
                                                    <select name="{{$page_input['input_name']}}" data-label="{{$page_input['input_label']}}" class="form-control disableSelect" disabled="">
                                                    </select>
                                                </span>
                                                <span class="col-sm-1 actions" style="line-height: 20px; display: none;">
                                                    <a class="add" data-toggle="popover" title="Save" style="display: none;"><i class="fa fa-check text-success"></i></a>
                                                    <a class="edit" data-toggle="popover" title="Edit" style=""><i class="fa fa-pencil text-info"></i></a>
                                                    <a class="delete" data-toggle="popover" title="Delete"><i class="fa fa-trash text-danger"></i></a>
                                                    <a class="addButton"></a>
                                                </span>
                                                @foreach(explode(",",$page_input['input_option']) as $option)
                                                <div class="dropdownoption" style="display: none;">
                                                   <div class="col-sm-12 float-right remove-section">
                                                      <div>
                                                        <input type="text" placeholder="Enter option" name="inputbox" value="{{$option}}" class="drop-input">
                                                        <a class="fa fa-plus addButton ml-3"></a>
                                                        </div>
                                                   </div>
                                                </div>
                                                @endforeach
                                            </div>                                             
                                            @break
                                            @case("TEXTAREA")
                                            <div class="form-group row table-roww section-tr">
                                                <span class="col-sm-4 input-label">{{$page_input['input_label']}}</span>
                                                <span class="col-sm-7">
                                                    <textarea name="{{$page_input['input_name']}}" class="form-control readonly2" data-label="{{$page_input['input_label']}}" rows="3" readonly="" style="height: 37px;" placeholder="To be filled by customer"></textarea>
                                                </span>
                                                <span class="col-sm-1 actions" style="line-height: 20px; display: none;">
                                                    <a class="add" data-toggle="popover" title="Save" style="display: none;"><i class="fa fa-check text-success"></i></a>
                                                    <a class="edit" data-toggle="popover" title="Edit" style=""><i class="fa fa-pencil text-info"></i></a>
                                                    <a class="delete" data-toggle="popover" title="Delete"><i class="fa fa-trash text-danger"></i></a>
                                                </span>
                                             </div>
                                            @break
                                          @endswitch
                                          @endforeach
                                    </div>
                                      <div class="form-group row mt-4">
                                        <p class="col-sm-4"><label for="inputPassword3" class="col-form-label">Add New :</label></p>
                                        <p class="col-sm-4 dropdown">
                                            <select class="custom-select" id="inlineFormCustomSelect">
                                               <option selected>Input Field</option>
                                               <option class="add-new">Dropdown</option>
                                                <option class="add-new">Textarea</option>
                                                <option class="add-new">Textinput</option>
                                                <option class="add-new">Coupon</option>
                                              </select>
                                         </p>
                                        <p class="col-sm-4">
                                            <select class="custom-select" id="inlineFormCustomSelect">
                                                <option selected><span id="alpha">&#8377;</span>&nbsp;Price Field</option>
                                                <option class="add-new">Fixed Amount</option>
                                                <option class="add-new">Customer Amount</option>
                                                <option class="add-new">Item with quantity</option>
                                               
                                              </select>
                                            </p>
                                    </div>
                                    <div class="col-md-12 table borderless" id="makeEditable">
                                        <div>
                                          <div class="form-group row section-tr" id="table-row5">
                                            <span class="col-sm-4"></span>
                                            <span class="col-sm-8">
                                             <button class="btn btn-gradient float-right">Pay &#8377;<span id="page-total">0.00</span></button>
                                            </span>
                                        </div>                                     
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ***** Contact Form End ***** -->
                <div class="right-content col-lg-6 col-md-12 col-sm-12">
                    <form class="form-detail" method="post" id="page-detail">
                        <div class="contain">
                            <div class="avtar1">
                                <input type='file' id="imageUpload" class="imgupload" name="page_logo" accept=".png, .jpg, .jpeg" />
                            </div>
                            <div class="avatar-upload">
                                <input type="button" id="removeImage1" value="x" class="btn-rmv1" />
                                <div class="avatar-preview">
                                    @if(!empty($page_details['page_logo']))
                                        <div id="imagePreview" class="imgPre" style="background-image: url('/storage/paymentpagelogos/{{Auth::user()->merchant_gid}}/{{$page_details['page_logo']}}');">
                                        </div>
                                    @else
                                        <div id="imagePreview" class="imgPre" style="background-image: url('/images/logo-upload.png');">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="side-1">
                            <input type="text" name="page_title" value="{{$page_details['page_title']}}" placeholder="Enter Page Title Here">
                        </div>
                        <div class="contact-side">
                            <div>
                            <button class="btn-transparent Button" id="social-button-open" style="{{$page_details['social_enable'] == 'N'?'':'display:none'}}">+ Add social media share icons</button>
                                <ul class="social" style="{{$page_details['social_enable'] == 'Y'?'display:block':''}}">
                                    <p class="para">Share this on :</p>
                                    <li><a href=""><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                                    <li><button class="btn-transremove" id="social-button-close">Remove</button></li>
                                </ul>
                            </div>

                            <div class="form-right">
                                <button class="btn-transparent2 Button" id="contact-us-open" style="{{$page_details['contactus_enable'] == 'N'?'':'display:none'}}">+ Add your contact information</button>
                                <div class="col-md-8">
                                    <div id="dynamic_container" class="dynamic" style="{{$page_details['contactus_enable'] == 'Y'?'display:block':''}}">
                                        <p class="para">Contact Us :</p>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text br-15"><i class="fa fa-envelope"></i></span>
                                            </div>
                                            <input type="text" name="contactus_email" placeholder="info@Payflash.in" value="{{$page_details['contactus_email']}}" class="form-control" id="right-inp" />
                                        </div>
                                        <div class="input-group mt-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text br-15"><i class="fa fa-phone-square"></i></span>
                                            </div>
                                            <input type="text" name="contactus_mobile" placeholder="+91 9087711911" value="{{$page_details['contactus_mobile']}}" class="form-control" id="right-inp2"/>
                                        </div>
                                        <div class="input-group">
                                            <span><button class="btn-transremove" id="contact-us-close">Remove</button></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 form-right text-move">
                                <button class="btn-transparent3 Button" id="term-condition-open" style="{{$page_details['term_condition_enable'] == 'N'?'':'display:none'}}">+ Add term & conditions</button>
                                <div class="input-group text-area" style="{{$page_details['term_condition_enable'] == 'Y'?'display:block':''}}">
                                    <p class="para">Term & Condition :</p>
                                    <textarea name="term_condition" id="" cols="30" rows="1" class="text">{{$page_details['term_condition']}}</textarea> 
                                    <span id="term-condition-close"><button class="btn-transremove">Remove</button></span>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="payment_total" value="{{$page_details['payment_total']}}">
                        <input type="hidden" name="social_enable" id="social_enable" value="{{$page_details['social_enable']}}">
                        <input type="hidden" name="contactus_enable" id="contactus_enable" value="{{$page_details['contactus_enable']}}">
                        <input type="hidden" name="term_condition_enable" id="term_condition_enable" value="{{$page_details['term_condition_enable']}}">
                        <input type="hidden" name="page_name" value="{{$page_details['page_name']}}">
                        <input type="hidden" name="id" value="{{$page_details['id']}}">
                        {{csrf_field()}}
                    </form>
                    <div class="contact-social">
                        <img src="{{asset('/images/card10.png')}}" width="350" class="img-fluid" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="sub-footer">
                    <p>&copy; Copyright 2020 <strong>Payflash</strong>

                    | Powered by <strong>Payflash</strong></p>
                </div>
            </div>
        </div>
    </div>
</footer>
@break
@case("active")
<footer id="contact-us">
    <div class="container">
        <div class="footer-content">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="">
                        <div class="card col-md-12 animated bounceInDown myForm">
                            <div class="heading">
                                <h3>Payment Detail</h3>
                                <div class="title-underline"></div>
                            </div>
                            <div class="card-body">
                                <form id="payment-page-form">
                                    <div class="section-tbody">
                                        @foreach($page_details["page_inputs"] as $page_input)
                                        <div class="col-md-12 section-table borderless">
                                            @switch($page_input["input_name"])
                                            @case("input_email")
                                            <div class="form-group row section-tr">
                                                <span class="col-sm-4"> <label class="col-form-label">{{$page_input["input_label"]}}</label></span>
                                                <span class="col-sm-8">
                                                <input type="email" class="form-control" name="{{$page_input['input_name']}}" value="" placeholder="Enter Email">
                                                </span>
                                            </div>
                                            @break
                                            @case("input_mobile")
                                            <div class="form-group row section-tr">
                                                <span class="col-sm-4"> <label  class="col-form-label">{{$page_input["input_label"]}}</label></span> 
                                                <span class="col-sm-8">
                                                <input type="text" class="form-control"  name="{{$page_input['input_name']}}" value="" placeholder="Enter Mobile">
                                                </span>
                                            </div>
                                            @break 
                                            @case("input_amount")
                                            <div class="form-group row section-tr">
                                                <span class="col-sm-4"> <label class="col-form-label">{{$page_input["input_label"]}}</label></span>
                                                <span class="col-sm-8">
                                                <input type="text" class="form-control" name="{{$page_input['input_name']}}" value="{{$page_input['input_value']}}" placeholder="Enter Amount" readonly>
                                                </span>
                                            </div>
                                            @break 
                                            @case("input_select")
                                            <div class="form-group row section-tr">
                                                <span class="col-sm-4"><label class="col-form-label">{{$page_input["input_label"]}}</label></span>
                                                <span class="col-sm-8">
                                                <select class="form-control" name="{{$page_input['input_name']}}">
                                                    <option value="">--Select--</option>
                                                    @foreach(explode(",",$page_input['input_option']) as $option)
                                                    <option value="{{$option}}">{{$option}}</option>
                                                    @endforeach
                                                </select>
                                                </span>
                                            </div>
                                            @break
                                            @case("input_textarea")
                                            <div class="form-group row section-tr">
                                                <span class="col-sm-4"> <label class="col-form-label">{{$page_input["input_label"]}}</label></span>
                                                <span class="col-sm-8">
                                                <textarea class="form-control" name="{{$page_input['input_name']}}" value="" id="comment_text" cols="40" rows="2"></textarea>
                                                </span>
                                            </div>
                                            @break
                                            @case("input_text")
                                            <div class="form-group row section-tr">
                                                <span class="col-sm-4"> <label class="col-form-label">{{$page_input["input_label"]}}</label></span>
                                                <span class="col-sm-8">
                                                <input type="text" class="form-control"  name="{{$page_input['input_name']}}" value="" placeholder="">
                                                </span>
                                            </div>
                                            @break
                                            @case("input_coupon")
                                            <div class="form-group row section-tr">
                                                <span class="col-sm-4"> <label class="col-form-label">{{$page_input["input_label"]}}</label></span>
                                                <span class="col-sm-8">
                                                    <input type="text" class="form-control" name="{{$page_input['input_name']}}" value="">
                                                </span>
                                            </div>
                                            @break
                                            @case("fixed_amount")
                                            <div class="form-group row section-tr">
                                                <span class="col-sm-4"> <label class="col-form-label">{{$page_input["input_label"]}}</label></span>
                                                <span class="col-sm-8">
                                                <input type="text" class="form-control" name="{{$page_input['input_name']}}" value="{{$page_input['input_value']}}" readonly>
                                                </span>
                                            </div>
                                            @break
                                            @case("customer_amount")
                                            <div class="form-group row section-tr">
                                                <span class="col-sm-4"> <label class="col-form-label">{{$page_input["input_label"]}}</label></span>
                                                <span class="col-sm-8">
                                                    <input type="text" class="form-control" name="{{$page_input['input_name']}}" value="">
                                                </span>
                                            </div>
                                            @break
                                            @case("item_amount")
                                            <div class="form-group row section-tr">
                                                <span class="col-sm-4"> <label class="col-form-label">{{$page_input["input_label"]}}</label></span>
                                                <span class="col-sm-8">
                                                <input type="text" class="form-control" name="{{$page_input['input_name']}}" value="{{$page_input['input_value']}}" readonly>
                                                <input type="number" name="item_qty" class="range" min="1" max="10" value="1" onchange="calculateTotal();">
                                                </span>
                                            </div>
                                            @break
                                            @endswitch
                                            
                                        </div>
                                        @endforeach
                                    </div>
                                    <input type="hidden" name="" id="input" class="form-control" value="">
                                    <div class="col-md-12 table borderless">
                                        <div>
                                            <div class="form-group row section-tr" id="table-row5">
                                                <span class="col-sm-4"></span>
                                                <span class="col-sm-8">
                                                <button class="btn btn-gradient float-right" type="submit" onclick="doPagePayment();">Pay &#8377;<span id="page-total">{{number_format($page_details["payment_total"],2)}}</span></button>
                                                </span>
                                            </div>                                     
                                        </div>
                                    </div>
                                    
                                    
                                    
                                  </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="right-content col-lg-6 col-md-12 col-sm-12">
                   <div class="contain mb-5">
                     <img src="/storage/paymentpagelogos/{{Auth::user()->merchant_gid}}/{{$page_details['page_logo']}}" width="100%" alt="{{$page_details['page_logo']}}" style="border-radius: 1em;">
                   </div>
                    <div class="side-1">
                        <h3>Page Heading</h3>                        
                    </div>
                    <div class="contact-side">
                        @if($page_details['social_enable'] == 'Y')
                        <div>
                            <ul class="social">
                                <p class="para">Share this on :</p>
                                <li><a href="{{url()->current()}}"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="{{url()->current()}}"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="{{url()->current()}}"><i class="fa fa-instagram"></i></a></li>
                            </ul>
                        </div>
                        @endif
                        <div class="form-right">
                           <div class="col-md-8">
                            @if($page_details['contactus_enable'] == 'Y')  
                                <div>
                                    <p class="para">Contact Us :</p>
                                    <div class="input-group">
                                        <div>
                                            <span class="br-15"><i class="fa fa-envelope"></i></span>
                                        </div> 
                                        <h4 class="ml-2">{{$page_details['contactus_email']}}</h4>
                                    </div>
                                    <div class="input-group mt-3">
                                        <div>
                                            <span class="br-15"><i class="fa fa-phone-square"></i></span>
                                        </div>
                                        <h4 class="ml-2">{{$page_details['contactus_mobile']}}</h4>
                                    </div>
                                </div>
                            @endif
                           </div>
                        </div>
                        <div class="col-md-8 form-right text-move">
                            @if($page_details['term_condition_enable'] == 'Y')
                            <div class="input-group">
                                <p class="para">Term & Condition :</p>
                                <h4>{{$page_details['term_condition']}}</h4>
                            </div>
                            @endif
                        </div>
                    </div> 
                    <div class="contact-social">
                        <img src="{{asset('/images/card10.png')}}" width="350" class="img-fluid" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="sub-footer">
                    <p>&copy; Copyright 2020 <strong>Payflash</strong>
                    | Powered by <strong>Payflash</strong></p>
                </div>
            </div>
        </div>
    </div>
</footer>
@break
@endswitch
<!-- Modal  -->
<div class="modal" id="form-success">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" class="text-success">Success</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div id="show-form-success" class="text-success"></div>
        </div>
        </div>
    </div>
</div>
<!-- Modal  -->
<div class="modal" id="form-error">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" class="text-danger">Error</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="show-form-error" class="text-danger"></div>
      </div>
  </div>
</div>
@endsection