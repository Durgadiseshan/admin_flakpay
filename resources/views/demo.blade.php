@extends('layouts.rupayapayapp')
@section('content')
<div class="col-lg-12">
    <div class="card bg-sky mt-6">
         <div class="note">
            <div class="">
               <div class="row p-1">
                  <div class="col-sm-5"> 
                    <div class="container">
                        <div class="row p-3">
                           <div class="col-sm-2">                       
                            <div class="card p-1" style="width: 4rem; padding:0px;">
                                <img class="card-img-top" src="https://dev.neopay.co.in/assets/img/neopay.png" height="60"  alt="Card image cap">
                            </div>
                         </div>
                      <div class="col-sm-8 p-3 ml-1" style="padding-left: 5px; color:#250061;"> 
                        <h5><b>Neopay</b></h5>
                        </div>
                    </div>
                </div>
                <div class="d-flex p-3 ml-1 mt-4" style="color: #250061;">
                    <h4><b>NeoFin Technologies Pvt Ltd</b></h4>
                </div>

                <div class="d-flex p-3 ml-1 mt-4">
                    <p>You can make your demo payment to using this page.</p>
                </div>
                <div class="d-flex flex-column bd-highlight mb-3 p-3 mt-4">
                    <div class="bd-highlight p-3"><b>Contact Us:</b></div>
                    <div class="bd-highlight ml-3"><p><i class="fa fa-envelope"></i>&nbsp;&nbsp; letstalk@neopay.co.in</p></div>
                    <div class="bd-highlight ml-3"><p><i class="fa fa-phone"></i>&nbsp;&nbsp; +91 7676752187</p></div>
                  </div>
                  <hr>
                  <div class="d-flex flex-column bd-highlight mb-3 p-3 " style="color: #250061;">
                    <div class="bd-highlight">
                      <img src="https://dev.neopay.co.in/assets/img/neopay.png" height="60" width="60"> <span  style="color: #250061;"><b>  Powered by Neopay</b></span>
                    </div>
                  </div>
                    
                  </div>
                  <div class="col-sm-7">
                    <div class="card">
                        <div class="card-header text-white" style="background-color: #250061;">
                          <b>Demo Page</b>
                        </div>
                        <form class="form-width" method="POST" action="{{route('test-demo-request')}}">
                          <div class="card-body">
                              <h5 class="text-info">Payment Details</h5>
                              <hr>
                                <div class="form-group row p-2">
                                  <label for="inputFullName" class="col-sm-4 col-form-label">Full Name</label>
                                  <div class="col-sm-8">
                                    <input type="text" class="form-control" id="inputFullName" name="customer_username" required="required" placeholder="Full Name">
                                    <span class="help-block">
                                        <small id="customer_username_ajax_error" class="text-sm-left text-danger">{{ $errors->first('customer_username') }}</small>
                                     </span>
                                </div>
                                </div>  
                                <div class="form-group row p-2">
                                  <label for="inputEmail" class="col-sm-4 col-form-label">Email</label>
                                  <div class="col-sm-8">
                                    <input type="email" class="form-control" name="customer_email" id="inputEmail" onChange="return emailValidation()"  required="required" placeholder="Email">
                                    <span class="help-block">
                                        <small id="customer_email_ajax_error" class="text-sm-left text-danger">{{ $errors->first('customer_email') }}</small>
                                     </span>
                                  </div>
                                </div>
                            <div class="form-group row p-2">
                                <label for="inputContactNumber" class="col-sm-4 col-form-label">Contact Number</label>
                                <div class="col-sm-8">
                                  <input type="text" class="form-control" name="customer_mobile" onkeypress="return onlyNumberKey(event)" minlength="10" id="inputContactNumber" required="required" placeholder="Contact number">
                                  <span class="help-block">
                                    <small id="customer_mobile_ajax_error" class="text-sm-left text-danger">{{ $errors->first('customer_mobile') }}</small>
                                  </span>
                                </div>
                              </div>
                                <div class="form-group row p-2">
                                <label for="staticAmount" class="col-sm-4 col-form-label">Amount</label>
                                <div class="col-sm-8">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend p-1">
                                        <span class="input-group-text">₹</span>
                                        </div>
                                        <input type="text" class="form-control p-3" required="required" aria-label="Amount (to the nearest inr)" name="customer_amount" value="1" readonly>
                                    </div>                                            
                                </div>
                                </div>
                          </div>
                          <div class="card-footer" style="padding:0px;">
                                  <div class="d-flex">
                                      <div class="d-flex bd-highlight p-3">
                                          <div class="align-items-center">
                                              <a href="https://neopay.qrcsolutionz.com/" target="_blank"><img src="{{asset('images/rupayapay-pci.png')}}" width="60" class="rounded mx-auto d-block" alt="..."></a>
                                          </div>
                              
                                          <div class="align-items-center p-3">
                                              <img src="{{asset('images/atm.png')}}" width="200" class="img-fluid atm" alt="...">
                                          </div>
                                      </div>
                                      <div class="p-3 ml-auto">
                                        <div class=" align-items-center">
                                            <button type="submit" class="demo-btn btn-lg" id="btnProceed" style="background-color: #00a4e5; color:#ffffff">Proceed</button>
                                        </div>
                                      </div>
                                  </div>
                                </div>
                                {{csrf_field()}}
                            <input type="hidden" name="app_mode" value="test">

                        </form>
                      </div> 
                  </div>
                </div>
              </div> 
         </div>
    
        <article class="card-body" style="margin-top:-20px;">
        </article>
        </div>
      </div>
        </div>
@endsection