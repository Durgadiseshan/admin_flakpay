<div class="form-container">

<div class="row">
		
        <!-- Start Col -->
		<div class="col-lg-12 col-md-12">
		<?php 

        ?>
		<form id="case-form" medthod="post" class="card">
          <div id="show-success-message" class="text-sm-center"></div>
          <div id="show-fail-message" class="text-sm-center"></div>
		  <div class="row">
			<div class="col-md-12" >
				<div class="form-group">
                  <select name="case_type" id="case_type" class="form-control">
                        
						@foreach($stype as $index => $type)
                          @if($index==4)
						    <option value="{{$index}}" selected>{{$type}}</option>
                             @endif
						@endforeach
                </select>
                <span class="help-block">
                    <small class="text-sm-left" id="case_type_ajax_error">{{ $errors->first('case_type') }}</small>
                </span>
				</div>                                 
			</div>
          
            <div class="form-group">
                                    <label class="control-label col-sm-4" for="name">Transaction Id:</label>
                                    <div class="col-sm-8">
                                    <input id="transaction_gid" readonly type="text" class="form-control" name="transaction_gid" value="{{$info['transaction_info']['transaction_gid']}}" placeholder="Payment ID">
                                    <span class="help-block">
                                             <small class="text-sm-left" id="transaction_gid_ajax_error">{{ $errors->first('transaction_gid') }}</small>
                                    </span> 
                                     </div>
                            </div>

                            <div class="form-group">
                                    <label class="control-label col-sm-4" for="transaction_amount">Transaction Amount:</label>
                                    <div class="col-sm-8">
                                    <input id="transaction_amount" readonly type="text" class="form-control" name="transaction_amount" value="{{$info['transaction_info']['transaction_amount']}}" placeholder="Amount Paid">
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
				<button class="support-btn btn btn-primary " type="submit">Send Refund Request</button>
				<div class="clearfix"></div> 
			  </div>
			</div>
			
		  </div>            
		</form>
		<hr style="border: 0.1px solid rgb(223, 223, 223);">
		</div>
                                               
</div>