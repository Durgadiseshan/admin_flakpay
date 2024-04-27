@php
	use App\AppOption;
	$stype = AppOption::get_customer_support();
@endphp

@extends("layouts.rupayapayapp")
@section("content")
<!-- Contact Us Section -->
<section id="contact" class="section">
	<!-- Container Starts -->
	<div class="container">
	
	  <!-- End Row -->
	  <!-- Start Row -->
	  <div class="row">
		
        <!-- Start Col -->
		<div class="col-lg-6 col-md-12">
		<div class="text-left">Fill the form with details of as same as <strong>Transaction</strong> details</div>
		<form id="case-form" medthod="post" class="card">
          <div id="show-success-message" class="text-sm-center"></div>
          <div id="show-fail-message" class="text-sm-center"></div>
		  <div class="row">
			<div class="col-md-12">
				<div class="form-group">
                  <select name="case_type" id="case_type" class="form-control">
                        <option value="">--Select--</option>
						@foreach($stype as $index => $type)
						<option value="{{$type->id}}">{{$type->option_value}}</option>
						@endforeach
                </select>
                <span class="help-block">
                    <small class="text-sm-left" id="case_type_ajax_error">{{ $errors->first('case_type') }}</small>
                </span>
				</div>                                 
			</div>
            <div class="col-md-12">
            <div class="form-group">
                <input id="transaction_gid" type="text" class="form-control" name="transaction_gid" value="{{ old('transaction_gid') }}" placeholder="Payment ID">
                <span class="help-block">
                    <small class="text-sm-left" id="transaction_gid_ajax_error">{{ $errors->first('transaction_gid') }}</small>
                </span> 
            </div>                                 
            </div>
            <div class="col-md-12">
            <div class="form-group">
                <input id="transaction_amount" type="text" class="form-control" name="transaction_amount" value="{{ old('transaction_amount') }}" placeholder="Amount Paid">
                <span class="help-block">
                    <small class="text-sm-left" id="transaction_amount_ajax_error">{{ $errors->first('transaction_amount') }}</small>
                </span>
            </div> 
            </div>
			<div class="col-md-12">
			  <div class="form-group">
                <input id="customer_name" type="text" class="form-control" name="customer_name" value="{{ old('customer_name')}}" placeholder="Name">
                <span class="help-block">
                    <small class="text-sm-left" id="customer_name_ajax_error">{{ $errors->first('customer_name') }}</small>
                </span>
			  </div>                                 
			</div>
		
			<div class="col-md-6">
			  <div class="form-group">
				<input type="text" id="customer_email" type="text" class="form-control" name="customer_email" value="{{ old('customer_email') }}" placeholder="Email">
                <span class="help-block">
                    <small class="text-sm-left" id="customer_email_ajax_error">{{ $errors->first('customer_email') }}</small>
                </span>
			  </div>                                 
			</div>
			<div class="col-md-6">
			  <div class="form-group">
                <input id="customer_mobile" type="text" class="form-control" name="customer_mobile" value="{{ old('customer_mobile') }}" placeholder="Mobile" >
                <span class="help-block">
                    <small class="text-sm-left" id="customer_mobile_ajax_error">{{ $errors->first('customer_mobile') }}</small>
                </span>
			  </div> 
			</div>
			<div class="col-md-12">
			  <div class="form-group"> 
				<textarea name="customer_reason" class="form-control" id="customer_reason" rows="4" placeholder="Write Message"></textarea>
                <span class="help-block">
                    <small class="text-sm-left" id="customer_reason_ajax_error">{{ $errors->first('customer_reason') }}</small>
                </span>
              </div>
              {{ csrf_field() }}
			  <div class="submit-button">
				<button class="support-btn btn-common" type="submit">Send Message</button>
				<div class="clearfix"></div> 
			  </div>
			</div>
			
		  </div>            
		</form>
		<hr style="border: 0.1px solid rgb(223, 223, 223);">
		</div>
		<!-- End Col -->
		<!-- Start Col -->
		<div class="col-lg-1">
		  
		</div>
		<!-- End Col -->
		<!-- Start Col -->
		<div class="col-lg-4 col-md-12">
		  <div class="contact-img">
		
			<div class="side-heading1">
				<h3>How Can We Help?</h3>
				<p>Please select a topic below related to your enquiry. If you don't find what u need, fill out our contect form</p>
			</div>
			<div class="side-heading2">
				<div>
					<h6>Book a demo</h6>
					<p>Request a demo from one of our conversion specialist</p>
				</div>
				 <hr style="border: 0.5px solid rgb(121, 121, 121);">
				<div>
					<h6>Get Inspired</h6>
					<p>Request a demo from one of our conversion specialist</p>
				</div>
				<hr style="border: 0.5px solid rgb(121, 121, 121);">
				<div>
					<h6>Become a Partner</h6>
					<p>Request a demo from one of our conversion specialist</p>
				</div>
			</div>

		  </div>
		</div>
		<!-- End Col -->
		<!-- Start Col -->
		<div class="col-lg-1">
		</div>
		<!-- End Col -->
	  </div>
	  <!-- End Row -->
	</div>


	<div class="container">
	
	  <!-- End Row -->
	  <!-- Start Row -->
	  <div class="row">
		
        <!-- Start Col -->
		<div class="col-lg-6 col-md-12">
		
		
		</div>
		<!-- End Col -->
		<!-- Start Col -->
		<div class="col-lg-1">
		  
		</div>
		<!-- End Col -->
		<!-- Start Col -->
		<div class="col-lg-5 col-md-12">
		<hr style="border: 0.1px solid rgb(223, 223, 223);">
		<div class="container">
            <h4 class="head-top" >Contact Information</h4>
                 <div class="cont-top mt-4">
                <div class="cont-left">
                    <span class="fa fa-phone"></span>
                </div>
                <div class="cont-right">
                    <p>+91 9087711911</p>
                </div>
                </div> 
                
                <div class="cont-top mt-4">
                <div class="cont-left">
                    <span class="fa fa-envelope "></span>
                </div>
                <div class="cont-right">
                    <p>hello@payflash.in</p>
                </div>
                </div>

				<!-- <div class="cont-top mt-4">
                <div class="cont-left">
                    <span class="fa fa-map-marker "></span>
                </div>
                <div class="cont-right">
                    <p>Payflash Tech Solutions Pvt Ltd
							#175 & 176,
							Bannerghatta Main Road,
							Dollars Colony, Phase 4, J. P. Nagar,
							Bengaluru, Karnataka 560076</p>
                </div>
                </div> -->
                <div class="cont-top mt-4">
                <div class="cont-left">
                    <span class="fa fa-map-marker add"></span>
                </div>
                <div class="cont-right">
                    <p>Payflash Tech Solutions Pvt Ltd</p><p> #175 & 176</p><p> Bannerghatta Main Road,</p><p> Dollars Colony, Phase 4, J. P. Nagar,</p><p>Bengaluru, Karnataka 560076</p>
                </div>
            </div>
        </div>
		 
		</div>
		
	  </div>
	  <!-- End Row -->
	</div>
	
       
        
  </section>
  <!-- Contact Us Section End -->
@endsection