@php
$vendor_banks = App\RyapayVendorBank::get_vendorbank();
@endphp
@extends('layouts.employeecontent')
@section('employeecontent')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<style>
    .dataTables_filter {
        display: none;
    }

    .card {
        border: thin solid #ccc;
        border-radius: 10px;
        padding: 5px 5px 5px 5px;
        margin: 5px 5px 5px 5px;
    }

    .thinText {
        font-size: 1.125rem;
        line-height: 1.75rem;
    }

    .strongText {
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .headlineText {
        font-weight: 900;
        letter-spacing: 2.5px;

    }

    .transactiongid {
        color: #3c8dbc;
        cursor: pointer;
    }
</style>

<h3>Merchant Requests</h3>




<div style="margin-top:30px; margin-bottom:100px; ">
    <table class="table table-striped table-bordered" id="transactions">

        <thead>
            <tr>
                <th>#</th>
                <th>Merchant</th>

                <th>Request</th>
                <th>Status</th>
                <th>Time & Date</th>
                <th>Action</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($requests as $index=>$request)

            <tr>
                <td>{{$index+1}}</td>
                <td>{{$request->name}}</td>
                <td>{{$request->request}}</td>
                @if ($request->status == 0)
                <td>No Action</td>
                @else
                <td>Action Taken</td>
                @endif

                <td>{{$request->created_at}}</td>
                <td>
                    <form action="/rockpay/technical/merchant_request_status_update" method="POST">
                    {{ csrf_field() }}
                        <input type="hidden" value="{{$request->request_id}}" name="id">
                        <button class="btn btn-success">Update Status</button>
                    </form>
                </td>
            </tr>

            @endforeach




        </tbody>
    </table>
</div>








<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>












@endsection