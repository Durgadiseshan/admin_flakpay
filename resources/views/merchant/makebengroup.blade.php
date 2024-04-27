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

    .accountsdetails {
        background-color: white;
        border-radius: 1rem;
        padding: 10px;
        max-width: 250px;
    }

    .groupname {
        background-color: white;
        border-radius: 1rem;
        padding: 10px;
        max-width: 650px;
    }

    .grid-container {
        display: grid;
        gap: 10px;
        background-color: #2196F3;
        padding: 10px;
    }

    .grid-item {
        background-color: rgba(255, 255, 255, 0.8);
        text-align: center;
        padding: 20px;
        font-size: 30px;
    }
</style>

<section id="about-1" class="about-1">
    <div class="container-1">

        <h1>Accounts</h1>

    </div>
</section>


<h3 class="mb-4 text-center font-bold mt-3">Beneficiaries Group</h3>
<form action="/merchant/post_make_beneficiaries_group" method="POST">
<div class="container">
    <div class="">
        <div class="groupname my-3">
            <div class="text-lg">
                Group Name
            </div>
            <div class="font-bold">
                <input type="text" class="form-control" name="group_name">
            </div>
        </div>
    </div>
</div>


    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <div class="container">
        <div class="grid grid-cols-4">
            @foreach ($Beneficiaries as $index =>$ben)


            <div class="accountsdetails my-3">
                <div class="card-body">
                    <div class="container mx-auto">
                        <input type="hidden" readonly name="id[]" value="{{$ben->id ?? ''}}">
                        <div class="">
                            <div class="text-lg">
                                Beneficiary ID
                            </div>
                            <div class="font-bold">
                                <input type="text" readonly value="{{$ben->beneficiary_id ?? ''}}">
                            </div>
                            <div class="text-lg">
                                Upi Id
                            </div>
                            <div class="font-bold">
                                <input type="text" readonly class="form-control" value="{{$ben->upi_id ?? ''}}">
                            </div>
                        </div>


                        <div class="my-4">
                            <div class="text-lg">
                                Account Number
                            </div>
                            <div class="font-bold">
                                <input type="text" readonly class="form-control" value="{{$ben->account_number ?? ''}}">
                            </div>
                            <div class="text-lg">
                                Ifsc Code
                            </div>
                            <div class="font-bold">
                                <input type="text" readonly class="form-control" n value="{{$ben->ifsc_code ?? ''}}">
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            @endforeach
        </div>
    </div>

    <div class="text-center">
        <button type="submit" class="rounded-lg bg-cyan-600 px-5 py-3 text-white">Add</button>
    </div>
</form>
@endsection