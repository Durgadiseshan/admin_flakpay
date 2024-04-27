@extends('layouts.merchantcontent')
@section('merchantcontent')


<style>
  .flex-container {
    display: flex;
    flex-wrap: nowrap;

  }

  .flex-container>div {

    width: 400px;
    margin: 10px;
    text-align: center;


  }

  .submitButton {
    margin-top: 2rem;
  }
</style>
<div id="buton-1">
    <button class="btn btn-dark" id="Show">Show</button>
<button  class="btn btn-danger" id="Hide">Remove</button>
    </div>
        
    <section id="about-1" class="about-1">
      <div class="container-1">

        <div class="row">
         
          <div class="col-lg-6 d-flex flex-column justify-contents-center" data-aos="fade-left">
            <div class="content-1 pt-4 pt-lg-0">
            
              <h3>Datatable Export</h3>
              <p>Get started with accepting payments right away</p>

                <p>You are just one step away from activating your account to accept domestic and international payments from your customers. We just need a few more details</p>
            </div>
          </div>
          <div class="col-lg-6" data-aos="zoom-in" id="img-dash">
            <img src="/assets/img/dash-bnr.png" width="450" height="280" class="img-fluid"  alt="dash-bnr.png">
          </div>
        </div>

      </div>
    </section>



<div>

  <!-- <form method="POST" class="flex-container" action="/merchant/transactionreport"   > -->
  <form method="POST" class="flex-container" id="datatable_form"  >
  
    {{ csrf_field() }}

    <div>
      <div class="form-group">
        <label for="">From</label>
        <input class="form-control" value="{{ \Carbon\Carbon::parse(request()->input('from_date'))->format('d-M-Y')  }}" type="text" name='from_date' id="report_start_date">
      </div>
    </div>

    <div>
      <div class="form-group">
        <label for="">To</label>
        <input class="form-control" value="{{ \Carbon\Carbon::parse(request()->input('to_date'))->format('d-M-Y')  }}" type="text" name='to_date' id="report_end_date">
      </div>
    </div>

    
    <div class="">
      <div class="form-group">
        <label for="">Payment Mode</label>
        <select class="form-control" name="mode" id="">
          <option value="">All</option>
          <option {{ request()->input('mode') == "UPI" ? "selected" :""}} value="UPI">Upi</option>
          <option {{ request()->input('mode') == "NB" ? "selected" :""}} value="NB">Net Banking</option>
          <option {{ request()->input('mode') == "CC" ? "selected" :""}} value="CC">Credit Card</option>
          <option {{ request()->input('mode') == "DC" ? "selected" :""}} value="DC">Debit Card</option>
          <option {{ request()->input('mode') == "WALLET" ? "selected" :""}} value="WALLET">Wallet</option>
          <option {{ request()->input('mode') == "QRCODE" ? "selected" :""}} value="QRCODE">Qr Code</option>
        </select>
      </div>
    </div>
    <div class="">

      <div class="form-group">
        <label for="">Status</label>
        <select class="form-control" name="status" id="">
          <option value="">All</option>
          <option {{ request()->input('status') == "success" ? "selected" :""}} value="success">Success</option>
          <option {{ request()->input('status') == "pending" ? "selected" :""}} value="pending">Pending</option>
          <option {{ request()->input('status') == "failed" ? "selected" :""}} value="failed">Failed</option>
          <option {{ request()->input('status') == "cancelled" ? "selected" :""}} value="cancelled">Cancelled</option>
        </select>
      </div>
    </div>

    <div class="">
      <div class="form-group">
        <label for="">Report</label>
        <select class="form-control" name="table_name" id="">
          <option {{ request()->input('table_name') == "test_payment" ? "selected" :""}} value="test_payment">Transaction</option>
          <option {{ request()->input('table_name') == "test_settlement" ? "selected" :""}} value="test_settlement">Settlement</option>
          <option {{ request()->input('table_name') == "test_refund" ? "selected" :""}} value="test_refund">Refund</option>
          <option {{ request()->input('table_name') == "test_chargeback" ? "selected" :""}} value="test_chargeback">ChargeBack</option>
         <!--  -- -->
          <option {{ request()->input('table_name') == "test_paylink" ? "selected" :""}} value="test_paylink">Paylink</option>
          <option {{ request()->input('table_name') == "test_order" ? "selected" :""}} value="test_order">Order</option>
          <option {{ request()->input('table_name') == "test_invoice" ? "selected" :""}} value="test_invoice">Invoice</option>
          <option {{ request()->input('table_name') == "test_customer" ? "selected" :""}} value="test_customer">Customer</option>
        </select>
      </div>

    </div>

    <div>
      <button class="btn btn-success submitButton" type="submit">Download</button>
    </div>
  </form>
</div>





<div id="report-div">


</div>

@endsection