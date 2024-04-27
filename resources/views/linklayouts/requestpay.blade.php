
<body onload="document.payment_form.submit()">

	<form method="post" name="payment_form" action ="{{$form_url}}" >
		<input type="hidden" name="clientId" value="{{$merchant_details->api_key}}" >
		<input type="hidden" name="encrypt" value="{{$encryption}}" >
		<input type="submit" style="display:none">
	</form>

</body>
