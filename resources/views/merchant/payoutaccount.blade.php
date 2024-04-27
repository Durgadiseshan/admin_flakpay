@extends('layouts.merchantcontent')
@section('merchantcontent')

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
<script src="https://cdn.tailwindcss.com"></script>

<style>
    .accountscard{
        background-color: white;
        border-radius: 1rem;
        padding: 10px;
    }
    .accountsdetails{
        background-color: white;
        border-radius: 1rem;
        padding: 10px;
        max-width: 250px;
    }
</style>

<section id="about-1" class="about-1">
    <div class="container-1">
       
        <h1>Accounts</h1>

    </div>
</section>


<h3 class="mb-4 text-center font-bold mt-3">Account Details</h3>
<div class="accountscard" >
    <div class="card-body">
    <div class="container mx-auto">
    <div class="columns-4">
        <div class="">
            Name
        </div>
        <div class="font-bold">
            {{$merchant->name}}
        </div>
        <div class="">
            Email
        </div>
        <div class="font-bold">
            {{$merchant->email}}
        </div>
    </div>

    <div class="columns-4 my-4">
        <div class="">
            Phone No.
        </div>
        <div class="font-bold">

            {{$merchant->mobile_no}}
        </div>
        <div class="">
            Status
        </div>
        <div class="font-bold">
            {{$merchant->merchant_status}}
        </div>
    </div>
</div>
    </div>
</div>


<h3 class="mt-8 text-center font-bold mb-2">Registered Merchant Businesses Details </h3>
<p class="text-center mb-8 text-base">Transactions will be accepted from these accounts only</p>
@foreach ($merchant_businesses as $business)
<div class="accountsdetails" >
    <div class="card-body">
    <div class="container mx-auto">

    <div class="">
        <div class="text-lg">
           Merchant Name
        </div>
        <div class="font-bold">
            {{$business->mer_name ?? ''}}
        </div>
        <div class="text-lg">
            Merchant Aadhar No.
        </div>
        <div class="font-bold">
            {{$business->mer_aadhar_number ?? ''}}
        </div>
    </div>
    <hr style="height:1px;border:none;color:rgb(107, 108, 123);background-color:
rgb(107, 108, 123);">

    <div class="my-4">
        <div class="text-lg">
           Bank Name
        </div>
        <div class="font-bold">
            {{$business->bank_name ?? ''}}
        </div>
        <div class="text-lg">
            Account Number
        </div>
        <div class="font-bold">
            {{$business->bank_acc_no ?? ''}}
        </div>
    </div>

    <div class=" my-4">
        <div class="text-lg">
            Ifsc Code
        </div>
        <div class="font-bold">

            {{$business->bank_ifsc_code ?? ''}}
        </div>
        <div class="text-lg">
            Pincode
        </div>
        <div class="font-bold">
            {{$business->pincode ?? ''}}
        </div>
    </div>
</div>
    </div>
</div>
@endforeach
@endsection