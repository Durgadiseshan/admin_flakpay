@extends('layouts.merchantcontent')
@section('merchantcontent')

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
<script src="https://cdn.tailwindcss.com"></script>

<style>
    .accountscard {
        background-color: white;
        border-radius: 1rem;
        padding: 10px;

    }

    [type=button], [type=reset], [type=submit], button {
    -webkit-appearance: button;
     background-color: #3097D1;
    background-image: none;
}
</style>

<section id="about-1" class="about-1">
    <div class="container-1">

        <h1>Accounts</h1>

    </div>
</section>


<h3 class="mb-4 text-center font-bold mt-3">Payout Report</h3>

<form action="/merchant/payout_reports" method="GET">
<div class="">
    <div class="flex flex-row my-4">
        <label class="basis-1/7" for="">Date Range</label>
        <div class="basis-2/7 mx-3" >
        <input type="text" name="datetimes" value="{{request()->input('datetimes')}}" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%"/>
        </div>

        

        <label class="basis-1/7" for="">Status</label>
        <div class="basis-2/7 mx-3">
            <select style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%" name="status" id="">
                <option {{ request()->input('status') == "SUCCESS" ? "selected" :""}} value="SUCCESS">Success</option>
                <option {{ request()->input('status') == "PENDING" ? "selected" :""}} value="PENDING">Pending</option>
                <option {{ request()->input('status') == "FAILED" ? "selected" :""}} value="FAILED">Failed</option>
            </select>
        </div>
        <button class="basis-1/7 bg-green-500 rounded text-white py-2 px-3" >Submit</button>
    </div>
</div>
</form>

<div class="row" style="margin-left:15px;">
    <div class="col-11">
        <table id="contacts" class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>At</th>
                    <th>Reference Id</th>
                    <th>Beneficiary Id</th>
                    <th>Mode</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Transfer Id</th>
                    <th>Beneficiary Name</th>
                    <th>Beneficiary Bank Account</th>
                    <th>Ifsc</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $index=>$transaction)
                <tr>
                    <td>{{$index+1}}</td>
                    <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('d-m-Y g:i A')}}</td>
                    <td>{{$transaction->reference_id}}</td>
                    <td>{{$transaction->ben_id}}</td>
                    <td>{{$transaction->transfer_mode}}</td>
                    <td>{{$transaction->amount}}</td>
                    <td>{{$transaction->status}}</td>
                    <td>{{$transaction->transfer_id}}</td>
                    <td>{{$transaction->ben_name}}</td>
                    <td>{{$transaction->ben_ifsc}}</td>
                    <td>{{$transaction->ben_bank_acc}}</td>


                </tr>
                @endforeach

            </tbody>

        </table>
    </div>
</div>



<script>
$(function() {
  $('input[name="datetimes"]').daterangepicker({
    timePicker: true,
    
    locale: {
      format: 'Y/MM/DD '
    }
  });
});

</script>





    @endsection