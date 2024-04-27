
@extends("layouts.link")
@section("content")
@if(!$link_expired)
<div id="invoiceholder">
  <div id="headerimage"></div>
  <div id="invoice" class="effect2">
    <div id="invoice-top">
      <div class="logo">
          @if(!empty($inv_details['business_logo']))
          <img src="" class="img-responsive" alt="Image" width="60px" height="60px">
          @else
          <img src="{{asset('assets/img/rockpay.png')}}" class="img-responsive" alt="Payflash" width="70px" height="60px">
          @endif
      </div>
      <div class="info">
        <h2>{{$inv_details['business_name']}}</h2>
        <p> hello@payflash.in </br>
            +91 9087711911
        </p>
      </div><!--End Info-->
      <div class="title">
        <h1 class="ml-5">Invoice</h1>
        <p>Id : {{$inv_details['invoice_gid']}}<br>
            Issued: {{$inv_details['invoice_issue_date']}}</br>
        </p>
      </div><!--End Title-->
    </div><!--End InvoiceTop-->
  
    <div id="invoice-mid">
      
      <div class="clientlogo"></div>
      <div class="info">
        <h2>Billing to</h2>
        <p>Name:{{$inv_details['customer_name']}}</br>
            Email:{{$inv_details['customer_email']}}</br>
            Phone:{{$inv_details['customer_phone']}}</br>
        </p>
      </div>

      <div id="project">
        <h2>Issue Date</h2>
        <p>{{$inv_details['invoice_issue_date']}}</p>
      </div>   

    </div><!--End Invoice Mid-->
    
    <div id="invoice-bot">
      
      <div id="table">
        <table>
          <tr class="tabletitle">
            <th class="item"><h2>Description</h2></th>
            <th class="Hours"><h2>Unit Price</h2></th>
            <th class="Rate"><h2>Qty</h2></th>
            <th class="subtotal"><h2>Amount</h2></th>
          </tr>
          
          @foreach($item_details as $index => $value)
          <tr class="service">
            <td class="tableitem"><p class="itemtext">{{ $value['item_name']}}</p></td>
            <td class="tableitem"><p class="itemtext">&#8377;{{ number_format($value['item_amount'],2)}}</p></td>
            <td class="tableitem"><p class="itemtext">{{ $value['item_quantity']}}</p></td>
            <td class="tableitem"><p class="itemtext">&#8377;{{ number_format($value['item_total'],2)}}</p></td>
          </tr>
          @endforeach

          <tr class="tabletitle">
            <td></td>
            <td></td>
            <td class="Rate"><h2>Sub Total</h2></td>
            <td class="payment"><h2>&#8377;{{number_format($inv_details['invoice_subtotal'],2)}}</h2></td>
          </tr>
          <tr class="tabletitle">
              <td></td>
              <td></td>
              <td class="Rate"><h2>Tax<small>({{$inv_details['tax_applied']}})</small></h2></td>
              <td class="payment"><h2>&#8377;{{number_format($inv_details['invoice_tax_amount'],2)}}</h2></td>
            </tr>
            <tr class="tabletitle">
              <td></td>
              <td></td>
              <td class="Rate"><h2>Total</h2></td>
              <td class="payment"><h2>&#8377;{{number_format($inv_details['invoice_amount'],2)}}</h2></td> 
            </tr>
        </table>
      </div><!--End Table-->
      
      <form class="form-horizontal" method="POST" action="{{route('test-request-payment')}}">
          <input id="customer_mobile" type="hidden" class="form-control" name="customer_mobile" value="{{ $inv_details['customer_phone'] }}">
          <input id="customer_amount" type="hidden" class="form-control" name="customer_amount" value="{{ $inv_details['invoice_amount'] }}">
          <input id="customer_email" type="hidden" class="form-control" name="customer_email" value="{{ $inv_details['customer_email'] }}">
          <input type="hidden" name="transaction_response" value="{{route('test-invoice-response')}}">
          <input type="hidden" name="transaction_method_id" value="{{$inv_details['id']}}">
          <input type="hidden" name="app_mode" value="test">
          {{csrf_field()}}
          <button type="submit" class="btn">Proceed To Pay</button>
      </form>

      <div id="legalcopy">
        <p class="legal"><strong>Want to create invoice for your Business!</strong> Visit <span style="color: #178dbb;">payflash.in/invoice</span> and get started instantly. 
        </p>
      </div>
      
    </div><!--End InvoiceBot-->
  </div><!--End Invoice-->
</div><!-- End Invoice Holder-->
@elseif($inv_paid)
<div class="container">
  <div class="col-sm-12">
      <div class="message-div">
          <div class="container courses-container">
              <div class="row">
                  <div class="course-expiry">
                      <div class="container course-payink-expiry">
                          <div class="row">
                              <div class="card-header">
                                  <img src="{{asset('assets/img/rockpay.png')}}" class="img-responsive card-logo" alt="Payflash" width="120px" height="100px" >
                                  <h4 class="card-header-message">Thank you for using our Payflash Service</h4>
                              </div>
                          </div>
                          <div class="row">
                              <div class="card-body">
                                  <p class="card-message">The link may be expired,broken or payment has completed</p>
                              </div>
                          </div>
                          <div class="row">
                              <div class="card-footer">
                                  <p>Powered by <span class="power"><a href="/">Payflash</a></span></p> 
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div> 
@else
<div class="container">
  <div class="col-sm-12">
      <div class="message-div">
          <div class="container courses-container">
              <div class="row">
                  <div class="course-expiry">
                      <div class="container course-payink-expiry">
                          <div class="row">
                              <div class="card-header">
                                  <img src="{{asset('assets/img/rockpay.png')}}" class="img-responsive card-logo" alt="Payflash" width="120px" height="100px" >
                                  <h4 class="card-header-message">Thank you for using our Payflash Service</h4>
                              </div>
                          </div>
                          <div class="row">
                              <div class="card-body">
                                  <p class="card-message">Please generate the invoice</p>
                              </div>
                          </div>
                          <div class="row">
                              <div class="card-footer">
                                  <p>Powered by <span class="power"><a href="/">payflash.in</a></span></p> 
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
@endif
@endsection