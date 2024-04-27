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


<h3 class="mb-4 text-center font-bold mt-3">Edit Contacts</h3>


<form action="/merchant/update_contacts" method="POST">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <div class="container">
        <div class="grid grid-cols-4">
            @foreach ($Contacts as $index =>$contact)


            <div class="accountsdetails my-3">
                <div class="card-body">
                    <div class="container mx-auto">
                        <input type="hidden" readonly name="id[]" value="{{$contact->id ?? ''}}">
                        <div class="">
                            <div class="text-lg">
                                Name
                            </div>
                            <div class="font-bold">
                                <input type="text" name="name[]" class="form-control" value="{{$contact->name ?? ''}}">
                            </div>
                            <div class="text-lg">
                                Mobile
                            </div>
                            <div class="font-bold">
                                <input type="text" name="mobile[]" class="form-control" value="{{$contact->mobile ?? ''}}">
                            </div>
                        </div>


                        <div class="my-4">
                            <div class="text-lg">
                                Email
                            </div>
                            <div class="font-bold">
                                <input type="text" class="form-control" name="email[]" value="{{$contact->contact ?? ''}}">
                            </div>
                            <div class="text-lg">
                                Address
                            </div>
                            <div class="font-bold">
                                <input type="text" class="form-control" name="address[]" value="{{$contact->address ?? ''}}">
                            </div>
                        </div>

                        <div class="my-4">
                            <div class="text-lg">
                                State
                            </div>
                            <div class="font-bold">
                                <select name="state[]" class="form-control" id="">
                                    @foreach ($states as $state)
                                    <option  {{ $contact->state == $state->id ? "selected" :""}} value="{{$state->id}}">{{$state->state_name}}</option>
                                    @endforeach
                                </select>
                               
                            </div>
                            <div class="text-lg">
                                Pincode
                            </div>
                            <div class="font-bold">
                                <input type="text" class="form-control" name="pincode[]" value="{{$contact->pincode ?? ''}}">
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            @endforeach
        </div>
    </div>

    <div class="text-center">
        <button type="submit" class="rounded-lg bg-cyan-600 px-5 py-3 text-white">Edit</button>
    </div>
</form>
@endsection