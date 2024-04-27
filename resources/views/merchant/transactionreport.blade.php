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
  <button class="btn btn-danger" id="Hide">Remove</button>
</div>

<section id="about-1" class="about-1">
  <div class="container-1">

    <div class="row">

      <div class="col-lg-6 d-flex flex-column justify-contents-center" data-aos="fade-left">
        <div class="content-1 pt-4 pt-lg-0">

          <h3>Transaction Report</h3>
          <p>Get started with accepting payments right away</p>

          <p>You are just one step away from activating your account to accept domestic and international payments from your customers. We just need a few more details</p>
        </div>
      </div>
      <div class="col-lg-6" data-aos="zoom-in" id="img-dash">
        <img src="/assets/img/dash-bnr.png" width="450" height="280" class="img-fluid" alt="dash-bnr.png">
      </div>
    </div>

  </div>
</section>


<div>

  <!-- <form method="POST" class="flex-container" action="/merchant/transactionreport"   > -->
  <form method="POST" class="flex-container" id="report_form"  >
  
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
          <option {{ request()->input('table_name') == "test_chargeback" ? "selected" :""}} value="">ChargeBack</option>
        </select>
      </div>

    </div>

    <div>
      <button class="btn btn-success submitButton" type="submit">Download</button>
    </div>
  </form>
</div>

@if(isset($transaction))
<div class="card">
  <div class="card-body">
    <table id="example" class="table table-striped table-bordered table-sm border ">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Order Id</th>
          <th scope="col">Transaction Response</th>
          <th scope="col">Transaction Type</th>
          <th scope="col">Merchant</th>
          <th scope="col">Username</th>
          <th scope="col">Email</th>
          <th scope="col">Contact</th>
          <th scope="col">Amount</th>
          <th scope="col">Status</th>
          <th scope="col">Mode</th>
          <th scope="col">Description</th>
          <th scope="col">Transaction Date</th>



        </tr>
      </thead>
      <tbody>
        @foreach($transaction as $index => $payment)
        <tr>
          <td>{{ $index+1 }}</td>
          <td>{{ $payment->order_id }}</td>
          <td>{{ $payment->transaction_response }}</td>
          <td>{{ $payment->transaction_type }}</td>
          <td>{{ $payment->name }}</td>
          <td>{{ $payment->transaction_username }}</td>
          <td>{{ $payment->transaction_email }}</td>
          <td>{{ $payment->transaction_contact }}</td>
          <td>{{ $payment->transaction_amount }}</td>
          <td>{{ $payment->transaction_status }}</td>
          <td>{{ $payment->transaction_mode }}</td>
          <td>{{ $payment->transaction_description }}</td>
          @if($payment->transaction_date != null)
          <td>{{ \Carbon\Carbon::parse($payment->transaction_date)->format('j F, Y')}}</td>
           @else
           <td></td>
           @endif



        </tr>
        @endforeach



      </tbody>

    </table>
  </div>
</div>
@endif


<!-- settlement table -->
@if(isset($settlement))
<div class="card">
  <div class="card-body">
    <table id="example" class="table table-striped table-bordered table-sm border ">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Gid</th>
          <th scope="col">Current Balance</th>
          <th scope="col">Settlement Amount</th>
          <th scope="col">Settlement Fee</th>
          <th scope="col">Settlement Tax</th>
          <th scope="col">Settlement Status</th>
          <th scope="col">Settlement Date</th>
          <th scope="col">Date</th>
          <th scope="col">Merchant</th>




        </tr>
      </thead>
      <tbody>
        @foreach($settlement as $index => $payment)
        <tr>
          <td>{{ $index+1 }}</td>
          <td>{{ $payment->settlement_gid }}</td>
          <td>{{ $payment->current_balance }}</td>
          <td>{{ $payment->settlement_amount }}</td>
          <td>{{ $payment->settlement_fee }}</td>
          <td>{{ $payment->settlement_tax }}</td>
          <td>{{ $payment->settlement_status }}</td>
          <td>{{ \Carbon\Carbon::parse($payment->settlement_date)->format('j F, Y')}}</td>
          <td>{{ \Carbon\Carbon::parse($payment->created_date)->format('j F, Y')}}</td>
          <td>{{ $payment->name }}</td>





        </tr>
        @endforeach



      </tbody>

    </table>
  </div>
</div>
@endif

<!-- refund table -->
@if(isset($refund))
<div class="card">
  <div class="card-body">
    <table id="example" class="table table-striped table-bordered table-sm border ">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Gid</th>
          <th scope="col">Payment Id</th>
          <th scope="col">Transaction Mode</th>
          <th scope="col">Transaction Status</th>
          <th scope="col">Refund Amount</th>
          <th scope="col">Refund Notes</th>
          <th scope="col">Refund Status </th>
          <th scope="col">Date</th>
          <th scope="col">Merchant</th>





        </tr>
      </thead>
      <tbody>
        @foreach($refund as $index => $payment)
        <tr>
          <td>{{ $index+1 }}</td>
          <td>{{ $payment->refund_gid }}</td>
          <td>{{ $payment->payment_id }}</td>
          <td>{{ $payment->transaction_mode }}</td>
          <td>{{ $payment->transaction_status }}</td>
          <td>{{ $payment->refund_amount }}</td>
          <td>{{ $payment->refund_notes }}</td>
          <td>{{ $payment->refund_status }}</td>
          <td>{{ \Carbon\Carbon::parse($payment->created_date)->format('j F, Y')}}</td>
          <td>{{ $payment->name }}</td>





        </tr>
        @endforeach



      </tbody>

    </table>
  </div>
</div>
@endif


<div id="report-div">


</div>


@endsection

