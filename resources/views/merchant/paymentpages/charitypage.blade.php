@extends('layouts.paymentpage')

@section('content')
@switch($form)
@case("create")
<div class="col-lg-10 container p-md-4"  id="outer-box">
    <div class="col-lg-12">
       <div class="card bg-sky">
          <div class="note">
             <div class="container">
                <div class="row p-3 pad">
                   <div class="col-sm-5 section-1">
                        <form class="form-detail" method="post" id="page-detail">
                           <div class="row">
                              <div class="col-sm-4">
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
                              </div>
                           </div>
                           <div class="side-1">
                              <input type="text" name="page_title" value="" placeholder="Enter Page Title Here">
                           </div>
                           <div class="col-md-8 mt-3 text-move">
                              <button class="btn-transparent3 Button" id="term-condition-open">+ Add term & conditions</button>
                              <div class="input-group text-area">
                                 <p class="para">Term & Condition :</p>
                                 <textarea name="term_condition" id="" cols="30" rows="1" class="text"></textarea> 
                                 <span id="term-condition-close"><button class="btn-transremove">Remove</button></span>
                              </div>
                           </div>
                           <div class="mt-3">
                              <button class="btn-transparent2 Button" id="contact-us-open">+ Add your contact information</button>
                              <div class="col-md-8">
                                 <div id="contactus-div" class="contactus">
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
                           <div class="mt-3">
                                 <button class="btn-transparent Button" id="social-button-open">+ Add social media share icons</button>
                                 <ul class="social">
                                    <p class="para">Share this on :</p>
                                    <li><a href=""><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                    <!-- <li><a href="#"><i class="fa fa-instagram"></i></a></li> -->
                                    <li><button class="btn-transremove" id="social-button-close">Remove</button></li>
                                 </ul>
                           </div>
                              <hr>
                           <div class="d-flex flex-column bd-highlight mb-3 " style="color: #250061;">
                              <div class="bd-highlight">
                                 <img src="{{asset('assets/img/rockpay.png')}}" height="60" width="60"> <span class="power" style="color: #250061;"><b>  Powered by Payflash</b></span>
                              </div>
                           </div>
                           <input type="hidden" name="payment_total" value="">
                           <input type="hidden" name="social_enable" id="social_enable" value="N">
                           <input type="hidden" name="contactus_enable" id="contactus_enable" value="N">
                           <input type="hidden" name="term_condition_enable" id="term_condition_enable" value="N">
                           <input type="hidden" name="page_name" value="charitypage">
                           {{csrf_field()}}
                        </form>
                        <!-- Next Button -->
                        <button class="btn btn-primary next-btn">NEXT</button>
                        <!-- Next Button End -->                    
                   </div>
                   <div class="col-sm-7 form-hide">
                      <div class="card">
                         <form class="form-detail" method="post" id="dynamic-input-detail">
                         <div class="card-body">
                            <h5 class="text-info">Payment Details</h5>
                            <hr>
                            <div class="form-group row p-2 input-div">
                              <label for="staticUsername" class="col-sm-4 col-form-label">Name</label>
                              <div class="col-sm-6">
                                 <input type="text" class="form-control p-3" name="input_username" id="input_username" data-label="Username" data-type="text" data-value="" data-name="username" data-mandatory="true" placeholder="Username" autocomplete="off" readonly>
                                 <span id="username-error"></span>
                              </div>
                              <div class="col-sm-2 label-action">
                                   <a class="save-label hand-touch"  data-toggle="popover" title="Save" style="display: none;"><i class="fa fa-check text-info action-icon-save"></i></a>
                                   <a class="edit-label hand-touch"  data-toggle="popover" title="Edit"><i class="fa fa-pencil text-info action-icon-edit"></i></a>
                              </div>
                            </div>
                            <div class="form-group row p-2 input-div">
                               <label for="staticAmount" class="col-sm-4 col-form-label">Amount</label>
                               <div class="col-sm-6">
                                  <div class="input-group mb-3">
                                     <div class="input-group-prepend">
                                        <span class="input-group-text">₹</span>
                                     </div>
                                     <input type="text" class="form-control p-3" name="input_amount" id="input_amount" data-label="Amount" data-type="text" data-value="" data-name="amount" data-mandatory="true" placeholder="Amount" autocomplete="off" readonly>
                                  </div>
                                  <span id="amount-error"></span>
                               </div>
                               <div class="col-sm-2 label-action">
                                    <a class="save-label hand-touch"  data-toggle="popover" title="Save" style="display: none;"><i class="fa fa-check text-info action-icon-save"></i></a>
                                    <a class="edit-label hand-touch"  data-toggle="popover" title="Edit"><i class="fa fa-pencil text-info action-icon-edit"></i></a>
                               </div>
                            </div>
                            <div class="form-group row p-2 input-div">
                               <label for="inputEmail" class="col-sm-4 col-form-label">Email</label>
                               <div class="col-sm-6">
                                  <input type="email" class="form-control" name="input_email" id="input_email" data-label="Email" data-type="email" data-value="" data-name="email" data-mandatory="true" placeholder="Email" autocomplete="off" readonly>
                                  <span id="email-error"></span>
                               </div>
                                <div class="col-sm-2 label-action">
                                    <a class="save-label hand-touch"  data-toggle="popover" title="Save" style="display: none;"><i class="fa fa-check text-info action-icon-save"></i></a>
                                    <a class="edit-label hand-touch"  data-toggle="popover" title="Edit"><i class="fa fa-pencil text-info action-icon-edit"></i></a>
                                </div>
                            </div>
                            <div class="form-group row p-2 input-div">
                               <label for="inputContactNumber" class="col-sm-4 col-form-label">Contact Number</label>
                               <div class="col-sm-6">
                                  <input type="text" class="form-control" name="input_mobile" id="input_mobile" data-label="Contact Number" data-type="text" data-value="" data-name="mobile" data-mandatory="true" placeholder="Contact number" readonly>
                                  <span id="mobile-error"></span>
                               </div>
                               <div class="col-sm-2 label-action">
                                    <a class="save-label hand-touch"  data-toggle="popover" title="Save" style="display: none;"><i class="fa fa-check text-info action-icon-save"></i></a>
                                    <a class="edit-label hand-touch"  data-toggle="popover" title="Edit"><i class="fa fa-pencil text-info action-icon-edit"></i></a>
                                </div>
                            </div>

                            <div class="form-group row p-2 add-new-input">
                                <p class="col-sm-4"><label for="inputPassword3" class="col-form-label">Add New :</label></p>
                                <p class="col-sm-4 dropdown">
                                    <select class="custom-select" id="add-dynamic-input">
                                       <option selected>Input Field</option>
                                       <option class="new-input" value="dropdown">Dropdown</option>
                                        <option class="new-input" value="textarea">Textarea</option>
                                        <option class="new-input" value="textinput">Textinput</option>
                                        <option class="new-input" value="date">Date</option>
                                      </select>
                                 </p>
                            </div>
                         </div>
                         </form>
                         <div class="card-footer" style="padding:0px;">
                            <div class="d-flex">
                               <div class="d-flex bd-highlight p-3">
                                  <div class="align-items-center">
                                     <a href="https://rockpay.qrcsolutionz.com/" target="_blank"><img src="{{asset('images/rupayapay-pci.png')}}" width="60" class="rounded mx-auto d-block" alt="rupayapay-pci.png"></a>
                                  </div>
                                  <div class="align-items-center p-3">
                                     <img src="{{asset('/images/allatm.png')}}" width="200" class="img-fluid atm" alt="allatm.png">
                                  </div>
                               </div>
                               <div class="p-3 ml-auto">
                                  <div class=" align-items-center">
                                     <button class="btn btn-lg" style="background-color: #00a4e5; color:#ffffff">Proceed</button>
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
       <article class="card-body" style="margin-top:-20px;">
       </article>
    </div>
</div>
@break 
@case("edit")
<div class="col-lg-10 container p-md-4"  id="outer-box">
   <div class="col-lg-12">
      <div class="card bg-sky">
         <div class="note">
            <div class="container">
               <div class="row p-3 pad">
                  <div class="col-sm-5 section-1">
                       <form class="form-detail" method="post" id="page-detail">
                          <div class="row">
                             <div class="col-sm-4">
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
                             </div>
                          </div>
                          <div class="side-1">
                             <input type="text" name="page_title" value="{{$page_details['page_title']}}" placeholder="Enter Page Title Here">
                          </div>
                          <div class="col-md-8 mt-3 text-move">
                             <button class="btn-transparent3 Button" id="term-condition-open" style="{{$page_details['term_condition_enable'] == 'N'?'':'display:none'}}">+ Add term & conditions</button>
                             <div class="input-group text-area" style="{{$page_details['term_condition_enable'] == 'Y'?'display:block':'display:none'}}">
                                <p class="para">Term & Condition :</p>
                                <textarea name="term_condition" id="" cols="30" rows="1" class="text">{{$page_details['term_condition']}}</textarea> 
                                <span id="term-condition-close"><button class="btn-transremove">Remove</button></span>
                             </div>
                          </div>
                          <div class="mt-3">
                             <button class="btn-transparent2 Button" id="contact-us-open" style="{{$page_details['contactus_enable'] == 'N'?'':'display:none'}}">+ Add your contact information</button>
                             <div class="col-md-8">
                                <div id="contactus-div" class="contactus" style="{{$page_details['contactus_enable'] == 'Y'?'display:block':'display:none'}}">
                                   <p class="para">Contact Us :</p>
                                   <div class="input-group">
                                         <div class="input-group-prepend">
                                            <span class="input-group-text br-15"><i class="fa fa-envelope"></i></span>
                                         </div>
                                         <input type="text" name="contactus_email" placeholder="info@rupayapay.com" class="form-control" id="right-inp" value="{{$page_details['contactus_email']}}"/>
                                   </div>
                                   <div class="input-group mt-3">
                                         <div class="input-group-prepend">
                                            <span class="input-group-text br-15"><i class="fa fa-phone-square"></i></span>
                                         </div>
                                         <input type="text" name="contactus_mobile" placeholder="+9876543212" value="{{$page_details['contactus_mobile']}}" class="form-control" id="right-inp2"/>
                                   </div>
                                   <div class="input-group">
                                         <span><button class="btn-transremove" id="contact-us-close">Remove</button></span>
                                   </div>
                                </div>
                             </div>
                          </div>
                          <div class="mt-3">
                                <button class="btn-transparent Button" id="social-button-open" style="{{$page_details['social_enable'] == 'N'?'':'display:none'}}">+ Add social media share icons</button>
                                <ul class="social" style="{{$page_details['social_enable'] == 'Y'?'display:block':'display:none'}}">
                                   <p class="para">Share this on :</p>
                                   <li><a href=""><i class="fa fa-facebook"></i></a></li>
                                   <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                   <!-- <li><a href="#"><i class="fa fa-instagram"></i></a></li> -->
                                   <li><button class="btn-transremove" id="social-button-close">Remove</button></li>
                                </ul>
                          </div>
                             <hr>
                          <div class="d-flex flex-column bd-highlight mb-3 " style="color: #250061;">
                             <div class="bd-highlight">
                                <img src="{{asset('assets/img/rockpay.png')}}" height="60" width="60"> <span class="power" style="color: #250061;"><b>  Powered by Payflash</b></span>
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
                       <!-- Next Button -->
                           <button class="btn btn-primary next-btn">NEXT</button>
                        <!-- Next Button End -->                    
                  </div>
                  <div class="col-sm-7 form-hide">
                     <div class="card">
                        <form class="form-detail" method="post" id="dynamic-input-detail">
                        <div class="card-body">
                           <h5 class="text-info">Payment Details</h5>
                           <hr>
                           @foreach($page_details["page_inputs"] as $page_input)
                              @switch($page_input["input_name"])
                              @case("input_username")
                              <div class="form-group row p-2 input-div">
                                 <label for="inputEmail" class="col-sm-4 col-form-label">{{$page_input['input_label']}}</label>
                                 <div class="col-sm-6">
                                    <input type="{{$page_input['input_type']}}" class="form-control" name="{{$page_input['input_name']}}" id="{{$page_input['input_name']}}" data-label="{{$page_input['input_label']}}" data-type="{{$page_input['input_type']}}" data-value="{{$page_input['input_value']}}" data-mandatory="true" placeholder="{{$page_input['input_label']}}" autocomplete="off" readonly>
                                    <span id="email-error"></span>
                                 </div>
                                  <div class="col-sm-2 label-action">
                                      <a class="save-label hand-touch"  data-toggle="popover" title="Save" style="display: none;"><i class="fa fa-check text-info action-icon-save"></i></a>
                                      <a class="edit-label hand-touch"  data-toggle="popover" title="Edit"><i class="fa fa-pencil text-info action-icon-edit"></i></a>
                                  </div>
                              </div>
                              @break
                              @case("input_amount")
                              <div class="form-group row p-2 input-div">
                                 <label for="staticAmount" class="col-sm-4 col-form-label">{{$page_input['input_label']}}</label>
                                 <div class="col-sm-6">
                                    <div class="input-group mb-3">
                                       <div class="input-group-prepend">
                                          <span class="input-group-text">₹</span>
                                       </div>
                                       <input type="{{$page_input['input_type']}}" class="form-control p-3" name="{{$page_input['input_name']}}" id="{{$page_input['input_name']}}" data-label="{{$page_input['input_label']}}" data-type="{{$page_input['input_type']}}" data-value="{{$page_input['input_value']}}" data-mandatory="true" placeholder="{{$page_input['input_label']}}" autocomplete="off" readonly>
                                    </div>
                                    <span id="amount-error"></span>
                                 </div>
                                 <div class="col-sm-2 label-action">
                                      <a class="save-label hand-touch"  data-toggle="popover" title="Save" style="display: none;"><i class="fa fa-check text-info action-icon-save"></i></a>
                                      <a class="edit-label hand-touch"  data-toggle="popover" title="Edit"><i class="fa fa-pencil text-info action-icon-edit"></i></a>
                                 </div>
                              </div>
                              @break
                              @case("input_email") 
                              <div class="form-group row p-2 input-div">
                                 <label for="inputEmail" class="col-sm-4 col-form-label">{{$page_input['input_label']}}</label>
                                 <div class="col-sm-6">
                                    <input type="{{$page_input['input_type']}}" class="form-control" name="{{$page_input['input_name']}}" id="{{$page_input['input_name']}}" data-label="{{$page_input['input_label']}}" data-type="{{$page_input['input_type']}}" data-value="{{$page_input['input_value']}}" data-mandatory="true" placeholder="{{$page_input['input_label']}}" autocomplete="off" readonly>
                                    <span id="email-error"></span>
                                 </div>
                                  <div class="col-sm-2 label-action">
                                      <a class="save-label hand-touch"  data-toggle="popover" title="Save" style="display: none;"><i class="fa fa-check text-info action-icon-save"></i></a>
                                      <a class="edit-label hand-touch"  data-toggle="popover" title="Edit"><i class="fa fa-pencil text-info action-icon-edit"></i></a>
                                  </div>
                              </div>
                              @break
                              @case("input_mobile")
                              <div class="form-group row p-2 input-div">
                                 <label for="inputContactNumber" class="col-sm-4 col-form-label">{{$page_input['input_label']}}</label>
                                 <div class="col-sm-6">
                                    <input type="{{$page_input['input_type']}}" class="form-control" name="{{$page_input['input_name']}}" id="{{$page_input['input_name']}}" data-label="{{$page_input['input_label']}}" data-type="{{$page_input['input_type']}}" data-value="{{$page_input['input_value']}}" data-mandatory="true" placeholder="{{$page_input['input_label']}}" autocomplete="off" readonly>
                                    <span id="mobile-error"></span>
                                 </div>
                                 <div class="col-sm-2 label-action">
                                      <a class="save-label hand-touch"  data-toggle="popover" title="Save" style="display: none;"><i class="fa fa-check text-info action-icon-save"></i></a>
                                      <a class="edit-label hand-touch"  data-toggle="popover" title="Edit"><i class="fa fa-pencil text-info action-icon-edit"></i></a>
                                  </div>
                              </div>
                              @break
                              @case("input_select")
                              <div class="form-group row p-2 input-div">
                                 <label for="inputdropdown" class="col-md-4 col-form-label">{{$page_input['input_label']}}</label>
                                 <div class="col-md-6 payement-page-input-div">
                                     <select class="form-control" name="{{$page_input['input_name']}}" id="{{$page_input['input_name']}}" data-label="{{$page_input['input_label']}}" data-type="{{$page_input['input_type']}}" value="" data-value="" data-option="{{$page_input['input_option']}}" data-mandatory="{{$page_input['input_mandatory']}}" placeholder="--Select--" autocomplete="off" readonly></select>
                                     <div class='select-option' style="display: none;">
                                       @foreach(explode(",",$page_input['input_option']) as $index => $option)
                                          @if($index == 0)
                                          <div class='row select-option-input'>
                                             <div class="col-md-10">
                                                 <input type="text" class="form-control drop-input mt-1 mb-1" name="input_option" id="input_option" data-value="" value="{{$option}}" placeholder="Option" autocomplete="off">
                                             </div>
                                             <div class="col-md-2">
                                                 <div class="select-option-input-add-icon hand-touch"><i class="fa fa-plus text-info action-icon-plus"></i></div>
                                             </div>
                                         </div>
                                          @else
                                          <div class='row select-option-input'>
                                             <div class="col-md-10">
                                                 <input type="text" class="form-control drop-input mt-1 mb-1" name="input_option" id="input_option" data-value="" value="{{$option}}" placeholder="Option" autocomplete="off">
                                             </div>
                                             <div class="col-md-2">
                                                 <div class="select-option-input-add-icon hand-touch"><i class="fa fa-plus text-info action-icon-plus"></i></div>
                                                 <div class="select-option-input-remove-icon hand-touch"><i class="fa fa-trash text-danger action-icon-bin col-md-1"></i></div>
                                             </div>
                                         </div>
                                          @endif
                                       @endforeach
                                     </div>
                                     <span id="select-error"></span>
                                 </div>
                                 <div class="col-md-2 label-action">
                                     <a class="save-label hand-touch"  data-toggle="popover" title="Save" style="display: none;"><i class="fa fa-check text-info action-icon-save"></i></a>
                                     <a class="edit-label hand-touch"  data-toggle="popover" title="Edit"><i class="fa fa-pencil text-info action-icon-edit"></i></a>
                                     <a class="delete-label hand-touch" data-toggle="popover" title="Delete"><i class="fa fa-trash text-danger action-icon-delete"></i></a>
                                     <a class="mandatory-label hand-touch" data-toggle="popover" title="Mandatory"><i class="fa fa-asterisk {{ ($page_input['input_mandatory']=='true')?'text-danger':'text-default' }} action-icon-mandatory"></i></a>
                                 </div>
                                 </div>
                              @break
                              @case("input_textarea")
                              <div class="form-group row p-2 input-div">
                                 <label for="inputdropdown" class="col-md-4 col-form-label">{{$page_input['input_label']}}</label>
                                 <div class="col-md-6 payement-page-input-div">
                                     <textarea class="form-control" name="{{$page_input['input_name']}}" id="{{$page_input['input_name']}}" data-label="{{$page_input['input_label']}}" data-type="{{$page_input['input_type']}}" data-value="{{$page_input['input_value']}}" data-mandatory="{{$page_input['input_mandatory']}}" autocomplete="off" readonly rows="1" cols="6"></textarea>
                                     <span id="textarea-error"></span>
                                 </div>
                                 <div class="col-md-2 label-action">
                                     <a class="save-label hand-touch"  data-toggle="popover" title="Save" style="display: none;"><i class="fa fa-check text-info action-icon-save"></i></a>
                                     <a class="edit-label hand-touch"  data-toggle="popover" title="Edit"><i class="fa fa-pencil text-info action-icon-edit"></i></a>
                                     <a class="delete-label hand-touch" data-toggle="popover" title="Delete"><i class="fa fa-trash text-danger action-icon-delete"></i></a>
                                     <a class="mandatory-label hand-touch" data-toggle="popover" title="Mandatory"><i class="fa fa-asterisk {{ ($page_input['input_mandatory']=='true')?'text-danger':'text-default' }} action-icon-mandatory"></i></a>
                                    </div>
                                 </div>
                              @break
                              @case("input_text")
                              <div class="form-group row p-2 input-div">
                                 <label for="inputdropdown" class="col-md-4 col-form-label">{{$page_input['input_label']}}</label>
                                 <div class="col-md-6 payement-page-input-div">
                                     <input type="{{$page_input['input_type']}}" class="form-control" name="{{$page_input['input_name']}}" id="{{$page_input['input_name']}}" data-label="{{$page_input['input_label']}}" data-type="{{$page_input['input_type']}}" data-value="" data-mandatory="{{$page_input['input_mandatory']}}" autocomplete="off" readonly/>
                                     <span id="text-error"></span>
                                 </div>
                                 <div class="col-md-2 label-action">
                                     <a class="save-label hand-touch"  data-toggle="popover" title="Save" style="display: none;"><i class="fa fa-check text-info action-icon-save"></i></a>
                                     <a class="edit-label hand-touch"  data-toggle="popover" title="Edit"><i class="fa fa-pencil text-info action-icon-edit"></i></a>
                                     <a class="delete-label hand-touch" data-toggle="popover" title="Delete"><i class="fa fa-trash text-danger action-icon-delete"></i></a>
                                     <a class="mandatory-label hand-touch" data-toggle="popover" title="Mandatory"><i class="fa fa-asterisk {{ ($page_input['input_mandatory']=='true')?'text-danger':'text-default' }} action-icon-mandatory"></i></a>
                                 </div>
                                 </div>
                              @break
                              @case("input_date")
                              <div class="form-group row p-2 input-div">
                                 <label for="inputdropdown" class="col-md-4 col-form-label">{{$page_input['input_label']}}</label>
                                 <div class="col-md-6 payement-page-input-div">
                                     <input type="{{$page_input['input_type']}}" class="form-control" name="{{$page_input['input_name']}}" id="{{$page_input['input_name']}}" data-label="{{$page_input['input_label']}}" data-type="{{$page_input['input_type']}}" data-value="" data-mandatory="{{$page_input['input_mandatory']}}" autocomplete="off" readonly/>
                                     <span id="date-error"></span>
                                 </div>
                                 <div class="col-md-2 label-action">
                                     <a class="save-label hand-touch"  data-toggle="popover" title="Save" style="display: none;"><i class="fa fa-check text-info action-icon-save"></i></a>
                                     <a class="edit-label hand-touch"  data-toggle="popover" title="Edit"><i class="fa fa-pencil text-info action-icon-edit"></i></a>
                                     <a class="delete-label hand-touch" data-toggle="popover" title="Delete"><i class="fa fa-trash text-danger action-icon-delete"></i></a>
                                     <a class="mandatory-label hand-touch" data-toggle="popover" title="Mandatory"><i class="fa fa-asterisk {{ ($page_input['input_mandatory']=='true')?'text-danger':'text-default' }} action-icon-mandatory"></i></a>
                                    </div>
                                 </div>
                              @break
                              @endswitch
                           @endforeach
                           <div class="form-group row p-2 add-new-input">
                               <p class="col-sm-4"><label for="inputPassword3" class="col-form-label">Add New :</label></p>
                               <p class="col-sm-4 dropdown">
                                   <select class="custom-select" id="add-dynamic-input">
                                      <option selected>Input Field</option>
                                      <option class="new-input" value="dropdown">Dropdown</option>
                                       <option class="new-input" value="textarea">Textarea</option>
                                       <option class="new-input" value="textinput">Textinput</option>
                                       <option class="new-input" value="date">Date</option>
                                     </select>
                                </p>
                           </div>
                        </div>
                        </form>
                        <div class="card-footer" style="padding:0px;">
                           <div class="d-flex">
                              <div class="d-flex bd-highlight p-3">
                                 <div class="align-items-center">
                                    <a href="https://rockpay.qrcsolutionz.com/" target="_blank"><img src="{{asset('images/rupayapay-pci.png')}}" width="60" class="rounded mx-auto d-block" alt="rupayapay-pci.png"></a>
                                 </div>
                                 <div class="align-items-center p-3">
                                    <img src="{{asset('/images/allatm.png')}}" width="200" class="img-fluid atm" alt="allatm.png">
                                 </div>
                              </div>
                              <div class="p-3 ml-auto">
                                 <div class=" align-items-center">
                                    <button class="btn btn-lg" style="background-color: #00a4e5; color:#ffffff">Proceed</button>
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
      <article class="card-body" style="margin-top:-20px;">
      </article>
   </div>
</div>
@break
@case("active")
<div class="col-lg-10 container p-md-4"  id="outer-box">
   <div class="col-lg-12">
      <div class="card bg-sky">
         <div class="note">
            <div class="container">
               <div class="row p-3 pad">
                  <div class="col-sm-5 section-1">
                     <div class="row">
                        <div class="col-sm-4">
                           @if($page_details['page_logo']!="")
                           <div class="card p-1 logo-swami" style="width: 4rem; padding:0px;">
                              <img class="card-img-top" src="/storage/paymentpagelogos/{{$merchant_gid}}/{{$page_details['page_logo']}}" height="60"  alt="Card image cap">
                           </div>
                           @endif
                           <div class="col-sm-7 p-1 ml-1" style="padding-left: 5px; color:#250061;"> 
                              <h5 class=""><b></b></h5>
                           </div>
                        </div>
                     </div>
                     <div class="d-flex p-1 ml-1 mt-4" style="color: #250061;">
                        <h5>{{$page_details['page_title']}}</h5>
                     </div>
                     <div class="d-flex" style="padding: 20px 0;color: rgb(100, 100, 100);">
                        <p>{{$page_details['term_condition']}}</p>
                     </div>
                     <div class="d-flex flex-column bd-highlight" style="padding: 20px 0;color: rgb(100, 100, 100);">
                        <div class="bd-highlight p-3"><b>Contact Us:</b></div>
                        <div class="bd-highlight ml-3">
                           <p><i class="fa fa-envelope"></i>&nbsp;&nbsp;{{$page_details['contactus_email']}}</p>
                        </div>
                        <div class="bd-highlight ml-3">
                           <p><i class="fa fa-phone"></i>&nbsp;&nbsp;{{$page_details['contactus_mobile']}}</p>
                        </div>
                        <ul class="social" style="{{$page_details['social_enable'] == 'Y'?'display:block':'display:none'}}">
                           <p class="para">Share this on :</p>
                           <li><a href="https://www.facebook.com/sharer/sharer.php?u={{Request::url()}}" target="_blank"><i class="fa fa-facebook"></i></a></li>
                           <li><a href="http://twitter.com/share?url={{Request::url()}}"><i class="fa fa-twitter"></i></a></li>
                        </ul>
                     </div>
                     <hr>
                     <div class="d-flex flex-column bd-highlight mb-3 " style="color: #250061;">
                        <div class="bd-highlight">
                           <img src="{{asset('assets/img/rockpay.png')}}" height="60" width="60"> <span class="power" style="color: #250061;"><b>Powered by Payflash</b></span>
                        </div>
                     </div>
                     <!-- Next Button -->
                     <button class="btn btn-primary next-btn">NEXT</button>
                     <!-- Next Button End -->                     
                  </div>
                  <div class="col-sm-7 form-hide">
                     <div class="card">
                        <div class="card-header text-white" style="background-color: #250061;">
                           <span><i class="fa fa-arrow-left back-btn hand-touch"></i></span> <b>{{$page_details['page_title']}}</b>
                        </div>
                        <form method="POST" action="{{route('request-payment')}}" autocomplete="off">
                           <div class="card-body">
                              <h5 class="text-info">Payment Details</h5>
                              <hr>
                              @foreach($page_details["page_inputs"] as $index => $page_input)
                                 @switch($page_input["input_name"])
                                 @case("input_username")
                                 <div class="form-group row p-2 input-div">
                                    <label for="inputUsername" class="col-sm-4 col-form-label">{{$page_input['input_label']}}<span class="text-danger">{{($page_input['input_mandatory'] == "true")?'*':''}}</span></label>
                                    <div class="col-sm-8">
                                       <input type="{{$page_input['input_type']}}" class="form-control" name="{{$page_input['input_name']}}" id="{{$page_input['input_name']}}" data-label="{{$page_input['input_label']}}" data-type="{{$page_input['input_type']}}" data-value="{{$page_input['input_value']}}" placeholder="{{$page_input['input_label']}}" autocomplete="off">
                                       <span id="{{$page_input['input_name']}}_error" class="text-danger">{{ $errors->first('input_username') }}</span>
                                    </div>
                                 </div>
                                 @break
                                 @case("input_amount")
                                 <div class="form-group row p-2 input-div">
                                    <label for="staticAmount" class="col-sm-4 col-form-label">{{$page_input['input_label']}}<span class="text-danger">{{($page_input['input_mandatory'] == "true")?'*':''}}</span></label>
                                    <div class="col-sm-8">
                                       <div class="input-group mb-3">
                                          <div class="input-group-prepend">
                                             <span class="input-group-text">₹</span>
                                          </div>
                                          <input type="{{$page_input['input_type']}}" class="form-control p-3" name="{{$page_input['input_name']}}" id="{{$page_input['input_name']}}" data-label="{{$page_input['input_label']}}" data-type="{{$page_input['input_type']}}" data-value="{{$page_input['input_value']}}" value="{{old('input_amount')}}" placeholder="{{$page_input['input_label']}}" autocomplete="off">
                                       </div>
                                       <span id="{{$page_input['input_name']}}_error" class="text-danger">{{ $errors->first('input_amount') }}</span>
                                    </div>
                                 </div>
                                 @break
                                 @case("input_email") 
                                 <div class="form-group row p-2 input-div">
                                    <label for="inputEmail" class="col-sm-4 col-form-label">{{$page_input['input_label']}}<span class="text-danger">{{($page_input['input_mandatory'] == "true")?'*':''}}</span></label>
                                    <div class="col-sm-8">
                                       <input type="{{$page_input['input_type']}}" class="form-control" name="{{$page_input['input_name']}}" id="{{$page_input['input_name']}}" data-label="{{$page_input['input_label']}}" data-type="{{$page_input['input_type']}}" data-value="{{$page_input['input_value']}}" value="{{old('input_email')}}" placeholder="{{$page_input['input_label']}}" autocomplete="off">
                                       <span id="{{$page_input['input_name']}}_error" class="text-danger">{{ $errors->first('input_email') }}</span>
                                    </div>
                                 </div>
                                 @break
                                 @case("input_mobile")
                                 <div class="form-group row p-2 input-div">
                                    <label for="inputContactNumber" class="col-sm-4 col-form-label">{{$page_input['input_label']}}<span class="text-danger">{{($page_input['input_mandatory'] == "true")?'*':''}}</span></label>
                                    <div class="col-sm-8">
                                       <input type="{{$page_input['input_type']}}" class="form-control" name="{{$page_input['input_name']}}" id="{{$page_input['input_name']}}" data-label="{{$page_input['input_label']}}" data-type="{{$page_input['input_type']}}" data-value="{{$page_input['input_value']}}" value="{{old('input_mobile')}}" placeholder="{{$page_input['input_label']}}" autocomplete="off">
                                       <span id="{{$page_input['input_name']}}_error" class="text-danger">{{ $errors->first('input_mobile') }}</span>
                                    </div>
                                 </div>
                                 @break
                                 @case("input_select")
                                 <div class="form-group row p-2 input-div">
                                    <label for="inputdropdown" class="col-md-4 col-form-label">{{$page_input['input_label']}}<span class="text-danger">{{($page_input['input_mandatory'] == "true")?'*':''}}</span></label>
                                    <div class="col-md-8">
                                       <select class="form-control" name="{{str_replace(' ','_',strtolower($page_input['input_label']))}}" id="{{$page_input['input_name']}}" data-label="{{$page_input['input_label']}}" data-type="{{$page_input['input_type']}}" value="" data-value="" data-option="{{$page_input['input_option']}}" placeholder="--Select--" autocomplete="off">
                                          <option value="">--Select--</option>
                                          @foreach(explode(",",$page_input['input_option']) as $index => $option)
                                             @if (old(str_replace(' ','_',strtolower($page_input['input_label']))) == $option)
                                                <option value="{{$option}}" selected="selected">{{$option}}</option>
                                             @else
                                                <option value="{{$option}}">{{$option}}</option>
                                             @endif
                                          @endforeach
                                       </select>
                                       <span id="{{str_replace(' ','_',strtolower($page_input['input_label']))}}_error" class="text-danger">{{ $errors->first(str_replace(' ','_',strtolower($page_input['input_label']))) }}</span>
                                    </div>
                                 </div>
                                 @break
                                 @case("input_textarea")
                                 <div class="form-group row p-2 input-div">
                                    <label for="inputdropdown" class="col-md-4 col-form-label">{{$page_input['input_label']}}<span class="text-danger">{{($page_input['input_mandatory'] == "true")?'*':''}}</span></label>
                                    <div class="col-md-8">
                                       <textarea class="form-control" name="{{str_replace(' ','_',strtolower($page_input['input_label']))}}" id="{{str_replace(' ','_',strtolower($page_input['input_label']))}}" data-label="{{$page_input['input_label']}}" data-type="{{$page_input['input_type']}}" data-value="{{$page_input['input_value']}}" autocomplete="off" rows="1" cols="6">{{old(str_replace(' ','_',strtolower($page_input['input_label'])))}}</textarea>
                                       <span id="{{str_replace(' ','_',strtolower($page_input['input_label']))}}_error" class="text-danger">{{ $errors->first(str_replace(' ','_',strtolower($page_input['input_label']))) }}</span>
                                    </div>
                                 </div>
                                 @break
                                 @case("input_text")
                                 <div class="form-group row p-2 input-div">
                                    <label for="inputdropdown" class="col-md-4 col-form-label">{{$page_input['input_label']}}<span class="text-danger">{{($page_input['input_mandatory'] == "true")?'*':''}}</span></label>
                                    <div class="col-md-8">
                                       <input type="{{$page_input['input_type']}}" class="form-control" name="{{str_replace(' ','_',strtolower($page_input['input_label']))}}" id="{{$page_input['input_name']}}" data-label="{{$page_input['input_label']}}" data-type="{{$page_input['input_type']}}" data-value="" placeholder="{{$page_input['input_label']}}" value="{{old(str_replace(' ','_',strtolower($page_input['input_label'])))}}" autocomplete="off"/>
                                       <span id="{{str_replace(' ','_',strtolower($page_input['input_label']))}}_error" class="text-danger">{{ $errors->first(str_replace(' ','_',strtolower($page_input['input_label']))) }}</span>
                                    </div>
                                 </div>
                                 @break
                                 @case("input_date")
                                 <div class="form-group row p-2 input-div">
                                    <label for="inputdropdown" class="col-md-4 col-form-label">{{$page_input['input_label']}}<span class="text-danger">{{($page_input['input_mandatory'] == "true")?'*':''}}</span></label>
                                    <div class="col-md-8">
                                       <input type="{{$page_input['input_type']}}" class="form-control" name="{{str_replace(' ','_',strtolower($page_input['input_label']))}}" id="{{$page_input['input_name']}}" data-label="{{$page_input['input_label']}}" data-type="{{$page_input['input_type']}}" data-value="" autocomplete="off" pattern="\d{2}-\d{2}-\d{4}" value="{{old(str_replace(' ','_',strtolower($page_input['input_label'])))}}"/>
                                       <span id="{{str_replace(' ','_',strtolower($page_input['input_label']))}}_error" class="text-danger">{{ $errors->first(str_replace(' ','_',strtolower($page_input['input_label']))) }}</span>
                                    </div>
                                 </div>
                                 @break
                                 @endswitch
                              @endforeach
                              <input type="hidden" name="page_url" id="page_url" value="{{$page_details['page_url']}}">
                              <input type="hidden" name="transaction_response" value="{{route($page_response)}}">
                              <input type="hidden" name="transaction_method_id" value="{{$page_details['id']}}">
                              <input type="hidden" name="app_mode" value="{{$app_mode}}">
                              {{csrf_field()}}
                           </div>
                           <div class="card-footer" style="padding:0px;">
                              <div class="d-flex">
                                 <div class="d-flex bd-highlight p-3">
                                    <div class="align-items-center">
                                       <a href="https://rockpay.qrcsolutionz.com/" target="_blank"><img src="{{asset('images/rupayapay-pci.png')}}" width="60" class="rounded mx-auto d-block" alt="rupayapay-pci.png"></a>
                                    </div>
                                    <div class="align-items-center p-3">
                                       <img src="{{asset('/images/allatm.png')}}" width="200" class="img-fluid atm" alt="allatm.png">
                                    </div>
                                 </div>
                                 <div class="p-3 ml-auto">
                                    <div class=" align-items-center">
                                       <input type="submit" class="btn btn-lg" style="background-color: #00a4e5; color:#ffffff" value="Proceed"/>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <article class="card-body" style="margin-top:-20px;">
      </article>
   </div>
</div>
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