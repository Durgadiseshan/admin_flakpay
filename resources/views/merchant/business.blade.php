
@php
    use App\BusinessType;
    use App\AppOption;

    $business_type_list = BusinessType::business_type();
    $business_expenditure = AppOption::get_business_expenditure();


@endphp
<div class="scrl">
@extends('layouts.app')
@section("content")

<div class="bg-contact100">
		<div class="container-contact100">
			<div class="wrap-contact100">
				<div class="contact100-pic js-tilt" data-tilt>
					<img src="{{asset('assets/img/about2.svg')}}" alt="IMG" width="500px">
				</div>

				<form class="form-horizontal contact100-form validate-form" method="POST" action="{{ route('business') }}">

					<div class="form-group{{ $errors->has('business_type_id') ? ' has-error' : '' }}">
						<label for="business_type_id" class="col-md-4 control-label"><span>Business Type</span><span style="color:red;font-size:large;">*</span></label>
				
						<div class="col-md-6">
							<select name="business_type_id" id="business_type_id" class="col-sm-12 form-control input100">
									<option value="">--Select--</option>
								@foreach($business_type_list as $type)
								<option value="{{$type->id}}" {{ old('business_type_id') == $type->id?'selected':''}}>{{$type->type_name}}</option>
								@endforeach
							</select>
							@if ($errors->has('business_type_id'))
								<span class="businessform-help-block">
									<strong>{{ $errors->first('business_type_id') }}</strong>
								</span>
							@endif
						</div>
					</div>
					
					<div class="form-group{{ $errors->has('business_expenditure') ? ' has-error' : '' }}">
						<label for="business_expenditure" class="col-md-4 control-label">Montly Expenditure<span style="color:red;font-size:large;">*</span></label>
				
						<div class="col-md-6">
							<select name="business_expenditure" id="business_expenditure" class="col-sm-12 form-control input100">
									<option value="">--Select--</option>
								@foreach($business_expenditure as $expenditure)
									<option value="{{$expenditure->id}}" {{ old('business_expenditure') == $expenditure->id ?'selected':''}}>{{$expenditure->option_value}}</option>
								@endforeach
							</select> 
							@if ($errors->has('business_expenditure'))
								<span class="businessform-help-block">
									<strong>{{ $errors->first('business_expenditure') }}</strong>
								</span>
							@endif
						</div>
					</div>
					<div class="form-group{{ $errors->has('business_name') ? ' has-error' : '' }}">
						<label for="business_name" class="col-md-4 control-label">Company Name<span style="color:red;font-size:large;">*</span></label>
				
						<div class="col-md-6">
							<input id="business_name" type="text" class="form-control input100" name="business_name" value="{{ old('business_name') }}">
							@if ($errors->has('business_name'))
								<span class="businessform-help-block">
									<strong>{{ $errors->first('business_name') }}</strong>
								</span>
							@endif
						</div>
					</div>
				
					<div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
						<label for="address" class="col-md-4 control-label">Company Address<span style="color:red;font-size:large;">*</span></label>
				
						<div class="col-md-6">
							<Textarea id="address" type="text" class="form-control input100" name="address" value="{{ old('address') }}"></Textarea>
							@if ($errors->has('address'))
								<span class="businessform-help-block">
									<strong>{{ $errors->first('address') }}</strong>
								</span>
							@endif
						</div>
					</div>
				
					<div class="form-group{{ $errors->has('pincode') ? ' has-error' : '' }}">
						<label for="pincode" class="col-md-4 control-label">Pincode<span style="color:red;font-size:large;">*</span></label>
				
						<div class="col-md-6">
							<input id="pincode" type="text" class="form-control input100" name="pincode" value="{{ old('pincode') }}">
							@if ($errors->has('pincode'))
								<span class="businessform-help-block">
									<strong>{{ $errors->first('pincode') }}</strong>
								</span>
							@endif
						</div>
					</div>
				
					<div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
						<label for="city" class="col-md-4 control-label">City<span style="color:red;font-size:large;">*</span></label>
				
						<div class="col-md-6">
							<input id="city" type="text" class="form-control input100" name="city" value="{{ old('city') }}">
							@if ($errors->has('city'))
								<span class="businessform-help-block">
									<strong>{{ $errors->first('city') }}</strong>
								</span>
							@endif
						</div>
					</div>
				
					<div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
						<label for="state" class="col-md-4 control-label">State<span style="color:red;font-size:large;">*</span></label>
				
						<div class="col-md-6">
							<select id="state" class="form-control input100" name="state">
								<option value="">--Select--</option>
								@foreach($states as $state)
									<option value="{{$state->id}}" {{ old('state') == $state->id?'selected':''}}>{{$state->state_name}}</option>
								@endforeach
							</select>
							@if ($errors->has('state'))
								<span class="businessform-help-block">
									<strong>{{ $errors->first('state') }}</strong>
								</span>
							@endif
						</div>
					</div>
				
					<div class="form-group">
						<label for="country" class="col-md-4 control-label">Country<span style="color:red;font-size:large;">*</span></label>
						<div class="col-md-6">
							<input id="country" type="text" class="form-control input100" name="country" value="India" readonly>
						</div>
					</div>
					{{ csrf_field() }}
					<div class="form-group">
						<div class="col-md-6 col-md-offset-4">
							<button type="submit" class="btn contact100-form-btn">
								Next
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	</div


@endsection
