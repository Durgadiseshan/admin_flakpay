@extends('layouts.paymentpage')

@section('content')
 <!-- ***** Footer Start ***** -->
 @if($form == "create")
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
                                <!--  -->
                                <form class="form-detail" method="post" id="dynamic-input-detail">
                                    <table class="col-md-12 table borderless" id="makeEditable">
                                        
                                        <tbody>
                                            <tr class="form-group row" id="table-row1">
                                            <td class="col-sm-4"> <label class="col-form-label">Email</label></td>
                                            <td class="col-sm-7">
                                                <input type="email" class="form-control readonly2" name="input_email" data-label="Email" readonly placeholder="To be filled by customer">
                                            </td>
                                            <td class="col-sm-1 edit1">
                                                <!-- <span><i class="fa fa-pencil"></i></span> -->
                                                <a class="add" data-toggle="popover" title="Save"><i class="fa fa-check text-success"></i></a>
                                                <a class="edit"  data-toggle="popover" title="Edit"><i class="fa fa-pencil text-info"></i></a>
                                                <a class="delete" id="del1" data-toggle="popover" title="Delete"><i class="fa fa-trash text-danger"></i></a>
                                            </td>
                                            </tr>
                                            <tr class="form-group row" id="table-row2">
                                            <td class="col-sm-4"> <label  class="col-form-label">Mobile</label></td>
                                            <td class="col-sm-7">
                                                <input type="text" class="form-control readonly2" name="input_mobile" data-label="Mobile"  readonly placeholder="To be filled by customer">
                                            </td>
                                            <td class="col-sm-1 edit2">
                                                <!-- <span><i class="fa fa-pencil"></i></span> -->
                                                <a class="add" data-toggle="popover" title="Save"><i class="fa fa-check text-success"></i></a>
                                                <a class="edit" data-toggle="popover" title="Edit"><i class="fa fa-pencil text-info"></i></a>
                                                <a class="delete" id="del2" data-toggle="popover" title="Delete"><i class="fa fa-trash text-danger"></i></a>
                                            </td>
                                            </tr>
                                            <tr class="form-group row" id="table-row3">
                                            <td class="col-sm-4"> <label class="col-form-label">Amount</label></td>
                                            <td class="col-sm-7">
                                                <input type="text" class="form-control" name="input_amount"  data-label="Amount" placeholder="Enter Amount" readonly>
                                            </td>
                                            <td class="col-sm-1 edit3" >
                                                <!-- <span class="edit3"><i class="fa fa-pencil"></i></span> -->
                                                <a class="add" data-toggle="popover" title="Save"><i class="fa fa-check text-success"></i></a>
                                                <a class="edit" data-toggle="popover" title="Edit"><i class="fa fa-pencil text-info"></i></a>
                                                <a class="delete" id="del3" data-toggle="popover" title="Delete"><i class="fa fa-trash text-danger"></i></a>
                                            </td>
                                            </tr>
                                    
                                        </tbody>
                                    </table>
                                </form>
                                <div class="form-group row">
                                    <p class="col-sm-4"><label for="inputPassword3" class="col-form-label">Add New :</label></p>
                                    <p class="col-sm-4 dropdown">
                                        <select class="custom-select" id="inlineFormCustomSelect">
                                            <option selected><span class="alpha"></span> Input Field</option>
                                            <option class="add-new">Dropdown</option>
                                            <option class="add-new">Textarea</option>
                                            <option class="add-new">Textinput</option>
                                            <option class="add-new">Coupon</option>
                                            </select>
                                        </p>
                                    <p class="col-sm-4">
                                        <select class="custom-select" id="inlineFormCustomSelect">
                                            <option selected><span id="alpha">&#8377;</span>&nbsp; Price Field</option>
                                            <option class="add-new">Fixed Amount</option>
                                            <option class="add-new">Customer Amount</option>
                                            <option class="add-new">Item with quantity</option>
                                            
                                            </select>
                                        </p>
                                </div>
                                <!-- Button -->
                                <div class="col-md-12 table borderless" id="makeEditable">
                                    
                                    <div>
                                        <tr class="form-group row" id="table-row5">
                                        <td class="col-sm-4"></td>
                                        <td class="col-sm-8">
                                            <button class="btn btn-gradient float-right">Pay &#8377;<span id="page-total">0.00</span></button>
                                        </td>
                                        
                                        </tr>                                     
                                
                                    </div>
                                </div>
                                <!-- button end -->
                            </div>
                        </div>
                        <!--  -->
                        <!--  form two end -->
                    </div>
                </div>
                <!-- ***** Contact Form End ***** -->
                <div class="right-content col-lg-6 col-md-12 col-sm-12">
                    <form class="form-detail" method="post" id="page-detail" enctype="multipart/form-data">
                        <img src="./final-logo.png" class="logo" alt="">
                        <div class="side-1">
                            <input type="text" placeholder="Enter Page Title Here" name="page_title" data-label="page title">
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
                                            <input type="text" placeholder="info@Payflash.in" class="form-control" name="contactus_email" data-label="contact email" id="right-inp" />
                                        </div>
                                        <div class="input-group mt-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text br-15"><i class="fa fa-phone-square"></i></span>
                                            </div>
                                            <input type="text" placeholder="+91 9087711911" class="form-control" name="contactus_mobile" data-label="contact mobile" id="right-inp2"/>
                                            
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
                                        <textarea id="" cols="30" rows="1" name="term_condition" data-label="term condition" class="text"></textarea> <span><button class="btn-transremove" id="term-condition-close">Remove</button></span>
                                    </div>
                                </div>
                                <input type="hidden" name="payment_total" value="">
                                <input type="hidden" name="page_name" value="singleproductpage">
                            
                        </div>  
                        <div class="contact-social">
                            
                            <img src="/images/card10.png" width="350" class="img-fluid" alt="">
                        </div>
                    </form>
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
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div> -->
  </div>
</div>
@elseif($form == "edit")
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
                                <!--  -->
                                <form class="form-detail" method="post" id="dynamic-input-detail">
                                    <table class="col-md-12 table borderless" id="makeEditable">
                                        <tbody>
                                            @foreach($page_details["page_inputs"] as $page_input)
                                                @switch($page_input["input_type"])
                                                    @case("INPUT")
                                                        @if($page_input["input_name"] == "item_amount")
                                                        <tr class="form-group row table-roww">
                                                            <td class="col-sm-4">
                                                                <label class="col-form-label">{{$page_input['input_label']}}</label>
                                                            </td>
                                                            <td class="col-sm-7">
                                                                <input type="text" class="form-control" name="{{$page_input['input_name']}}" value="{{$page_input['input_value']}}" data-label="{{$page_input['input_label']}}" placeholder="Enter Amount">
                                                                <input type="number" name="item_quantity" class="range" min="0" max="0" value="0">
                                                            </td>
                                                            <td class="col-sm-1 actions" style="line-height: 20px; display: none;">
                                                               <a class="add" data-toggle="popover" title="Save"><i class="fa fa-check text-success"></i></a>
                                                               <a class="edit" data-toggle="popover" title="Edit" ><i class="fa fa-pencil text-info"></i></a>
                                                               <a class="delete" id="del1" data-toggle="popover" title="Delete"><i class="fa fa-trash text-danger"></i></a>
                                                            </td>
                                                         </tr>
                                                        @else
                                                        <tr class="form-group row" id="table-row1">
                                                            <td class="col-sm-4"> <label class="col-form-label">{{$page_input['input_label']}}</label></td>
                                                            <td class="col-sm-7">
                                                                <input type="text" class="form-control readonly2" name="{{$page_input['input_name']}}" data-label="{{$page_input['input_label']}}" value="{{$page_input['input_value']}}" readonly placeholder="To be filled by customer">
                                                            </td>
                                                            <td class="col-sm-1 actions" style="line-height: 20px; display: none;">
                                                                <a class="add" data-toggle="popover" title="Save"><i class="fa fa-check text-success"></i></a>
                                                                <a class="edit"  data-toggle="popover" title="Edit"><i class="fa fa-pencil text-info"></i></a>
                                                                <a class="delete" id="del1" data-toggle="popover" title="Delete"><i class="fa fa-trash text-danger"></i></a>
                                                            </td>
                                                        </tr>
                                                        @endif
                                                    @break 
                                                    @case("SELECT")
                                                        <tr class="form-group row table-roww tdContainer">
                                                            <td class="col-sm-4">{{$page_input['input_label']}}</td>
                                                            <td class="col-sm-7">
                                                                <select name="{{$page_input['input_name']}}" id="" data-label="{{$page_input['input_label']}}" class="form-control disableSelect" readonly=""></select>
                                                            </td>
                                                            <td class="col-sm-1 actions">
                                                                <a class="fa fa-plus addButton"></a>
                                                                <a class="add" data-toggle="popover" title="Save" style="display: none;"><i class="fa fa-check text-success"></i></a>
                                                                <a class="edit" data-toggle="popover" title="Edit"><i class="fa fa-pencil text-info"></i></a>
                                                                <a class="delete" id="del1" data-toggle="popover" title="Delete"><i class="fa fa-trash text-danger"></i></a>
                                                            </td>
                                                            @foreach(explode(",",$page_input['input_option']) as $option)
                                                            <div class="col-sm-12 float-right remove-section" style="display: none;">
                                                                <div style="display: none;">
                                                                    <input type="text" placeholder="Enter option" name="option[]" class="drop-input" value="{{$option}}">
                                                                    <i class="ml-3 fa fa-trash text-danger remove-btn" style="display: none;"></i>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        </tr>
                                                    @break
                                                    @case("TEXTAREA")
                                                        <tr class="form-group row table-roww">
                                                            <td class="col-sm-4">{{$page_input['input_label']}}</td>
                                                            <td class="col-sm-7">
                                                                <textarea name="{{$page_input['input_name']}}" class="form-control readonly2" data-label="{{$page_input['input_label']}}" rows="3" readonly="" style="height: 37px;" placeholder="To be filled by customer"></textarea>
                                                            </td>
                                                            <td class="col-sm-1 actions" style="display: none;">
                                                                <a class="add" data-toggle="popover" title="Save" style="display: none;"><i class="fa fa-check text-success"></i></a>
                                                                <a class="edit" data-toggle="popover" title="Edit" ><i class="fa fa-pencil text-info"></i></a>
                                                                <a class="delete" id="del1" data-toggle="popover" title="Delete">
                                                                    <i class="fa fa-trash text-danger"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @break
                                                @endswitch
                                            @endforeach
                                        </tbody>
                                    </table>
                                </form>
                                <div class="form-group row">
                                    <p class="col-sm-4"><label for="inputPassword3" class="col-form-label">Add New :</label></p>
                                    <p class="col-sm-4 dropdown">
                                        <select class="custom-select" id="inlineFormCustomSelect">
                                            <option selected><span class="alpha"></span> Input Field</option>
                                            <option class="add-new">Dropdown</option>
                                            <option class="add-new">Textarea</option>
                                            <option class="add-new">Textinput</option>
                                            <option class="add-new">Coupon</option>
                                            </select>
                                        </p>
                                    <p class="col-sm-4">
                                        <select class="custom-select" id="inlineFormCustomSelect">
                                            <option selected><span id="alpha">&#8377;</span>&nbsp; Price Field</option>
                                            <option class="add-new">Fixed Amount</option>
                                            <option class="add-new">Customer Amount</option>
                                            <option class="add-new">Item with quantity</option>
                                            
                                            </select>
                                        </p>
                                </div>
                                <!-- Button -->
                                <div class="col-md-12 table borderless" id="makeEditable">
                                    
                                    <div>
                                        <tr class="form-group row" id="table-row5">
                                        <td class="col-sm-4"></td>
                                        <td class="col-sm-8">
                                            <button class="btn btn-gradient float-right">Pay &#8377;<span id="page-total">0.00</span></button>
                                        </td>
                                        
                                        </tr>                                     
                                
                                    </div>
                                </div>
                                <!-- button end -->
                            </div>
                        </div>
                        <!--  -->
                        <!--  form two end -->
                    </div>
                </div>
                <!-- ***** Contact Form End ***** -->
                <div class="right-content col-lg-6 col-md-12 col-sm-12">
                    <form class="form-detail" method="post" id="page-detail">
                        <img src="./final-logo.png" class="logo" alt="">
                        <div class="side-1">
                            <input type="text" placeholder="Enter Page Title Here" name="page_title" data-label="page title">
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
                                            <input type="text" placeholder="info@Payflash.com" class="form-control" name="contactus_email" data-label="contact email" id="right-inp" />
                                        </div>
                                        <div class="input-group mt-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text br-15"><i class="fa fa-phone-square"></i></span>
                                            </div>
                                            <input type="text" placeholder="+9876543212" class="form-control" name="contactus_mobile" data-label="contact mobile" id="right-inp2"/>
                                            
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
                                        <textarea id="" cols="30" rows="1" name="term_condition" data-label="term condition" class="text"></textarea> <span><button class="btn-transremove" id="term-condition-close">Remove</button></span>
                                    </div>
                                </div>
                                <input type="hidden" name="payment_total" value="">
                                <input type="hidden" name="page_name" value="singleproductpage">
                        </div>  
                        <div class="contact-social">
                            
                            <img src="./card10.png" width="350" class="img-fluid" alt="">
                        </div>
                    </form>
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
         <!-- <div class="modal-footer">
           <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
           <button type="button" class="btn btn-primary">Save changes</button>
         </div>
       </div> -->
     </div>
   </div>
@elseif($form == "active")
<form class="form-detail" method="post">
    <footer id="contact-us">
       <div class="container">
           <div class="footer-content">
               <div class="row">
                   <!-- ***** Contact Form Start ***** -->
                   <div class="col-lg-6 col-md-12 col-sm-12">
                       <div class="contact-form">
                           @foreach($page_details["page_inputs"] as $inputs)
                                @if($inputs["input_type"] == "text" && $inputs["input_name"] != "amount")
                                    <div class="">
                                        <div class="form-group row col-md-12">
                                       
                                            <label class="col-sm-4 col-form-label">{{$inputs["input_label"]}}</label>
                                            <input type="{{$inputs['input_type']}}" name="{{$inputs['input_name']}}" id="{{$inputs['input_name']}}" class="col-sm-8 input-text form-control" value="{{$inputs['input_value']}}">
                                           
                                        </div>
                                    </div>
                                @elseif($inputs["input_name"] == "amount")
                                    <div class="">
                                        <div class="form-group row col-md-12">
                                            <label class="col-sm-4 col-form-label">{{$inputs["input_label"]}}</label>
                                            <input type="{{$inputs['input_type']}}" name="{{$inputs['input_name']}}" id="{{$inputs['input_name']}}" class="col-sm-8 input-text form-control" value="{{$inputs['input_value']}}" readonly>
                                        </div>
                                    </div>
                                @elseif($inputs["input_type"] == "select")
                                <div class="">
                                    <div class="form-group row col-md-12">
                                        <label class="col-sm-4 col-form-label">{{$inputs["input_label"]}}</label>
                                        <select name="{{$inputs['input_name']}}" id="{{$inputs['input_name']}}" class="col-sm-8 my-select">
                                           @foreach(explode(",",$inputs['input_option']) as $value)
                                            <option value="{{$value}}">{{$value}}</option>
                                           @endforeach 
                                        </select>
                                    </div>
                                </div>
                                @elseif($inputs["input_type"] == "textarea")
                                <div class="">
                                    <div class="form-group row col-md-12">
                                        <label class="col-sm-4 col-form-label">{{$inputs["input_label"]}}</label>
                                        <textarea name="{$inputs['input_label']}}" id="{$inputs['input_label']}}" cols="30" rows="10" class="col-sm-8 form-control txt-area"></textarea>
                                    </div>
                                </div>
                                @endif
                           @endforeach
                           <div class="form-row-last">
                           <!-- <input type="submit" name="register" class="register" value="Pay &#8377;&nbsp; 500.00"> -->
                           <button class="btn btn-primary">Pay &#8377;&nbsp;<span>{{$page_details["payment_total"]}}</span></button>
                           
                           </div>
                       </div>
                   </div>
                   <!-- ***** Contact Form End ***** -->
                   <div class="right-content col-lg-6 col-md-12 col-sm-12">
                       <!-- <img src="{{asset('assets/productpage/singleproductleft/final-logo.png')}}" class="logo" alt=""> -->
                       <div class="side-1">
                           <h1 >{{$page_details["page_title"]}}</h1>
                       </div>
                       <h2>Payment Detail</h2>

                       <div class="contact-side">
                           @if($page_details["contactus_email"]!="" && $page_details["contactus_mobile"]!="")
                           <h4>Contact us:</h4>
                           <div><i class="fa fa-envelope text-white"></i>&nbsp;&nbsp;<span>{{$page_details["contactus_email"]}}</span></div>
                           <div><i class="fa fa-mobile-phone text-white"></i>&nbsp;&nbsp;<span>{{$page_details["contactus_mobile"]}}</span></div>
                           @elseif($page_details["contactus_email"]!="")
                           <h4>Contact us:</h4>
                           <div><i class="fa fa-envelope text-white"></i>&nbsp;&nbsp;<span>{{$page_details["contactus_email"]}}</span></div>
                           @elseif($page_details["contactus_mobile"]!="")
                           <h4>Contact us:</h4>
                           <div><i class="fa fa-mobile-phone text-white"></i>&nbsp;&nbsp;<span>{{$page_details["contactus_mobile"]}}</span></div>
                           @endif
                        </div>
                          
                       <div class="contact-social">
                           <h4>Share this on :</h4>
                           <ul class="social">
                               <li><a href=""><i class="fa fa-facebook"></i></a></li>
                               <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                               <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                           </ul>
                           <img src="{{asset('assets/productpage/singleproductleft/card10.png')}}" width="400" alt="">
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
       {{csrf_field()}}
   </footer>
</form>
@endif
@endsection
