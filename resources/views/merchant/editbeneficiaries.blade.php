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


<h3 class="mb-4 text-center font-bold mt-3">Edit Beneficiaries</h3>


<form action="/merchant/update_beneficiaries" method="POST">
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
                                <input type="text" readonly name="ben[]" value="{{$ben->beneficiary_id ?? ''}}">
                            </div>
                            <div class="text-lg">
                                Upi Id
                            </div>
                            <div class="font-bold">
                                <p class="text-orange-600 text-lg"></p>
                                <input type="text" name="upi[]" required beneid="{{$ben->id}}" class="form-control" value="{{$ben->upi_id ?? ''}}">
                            </div>
                        </div>


                        <div class="my-4">
                            <div class="text-lg">
                                Account Number
                            </div>
                            <div class="font-bold">
                                <p class="text-orange-600 text-lg"></p>
                                <input type="text" class="form-control" required beneid="{{$ben->id}}" name="acc_no[]" value="{{$ben->account_number ?? ''}}">
                            </div>
                            <div class="text-lg">
                                Ifsc Code
                            </div>
                            <div class="font-bold">
                                <p class="text-orange-600 text-lg"></p>
                                <input type="text" class="form-control" required name="ifsc[]" value="{{$ben->ifsc_code ?? ''}}">
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            @endforeach
        </div>
    </div>

    <div class="text-center">
        <button type="submit" onclick="return validator()" class="rounded-lg bg-cyan-600 px-5 py-3 text-white">Edit</button>
    </div>
</form>



<script>
    function validator() {
        var acc_check = [];
        var upi_check = [];
        var ifsc_val_check = [];
        var upi_val_check = [];
        var acc_val_check = [];


        $("input[name='acc_no[]']").map(function() {

            var accountcheck = $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                async: false,
                dataType: "json",
                url: '/merchant/edit_validate_account_number',
                data: {
                    "acc": $(this).val(),
                    "id": $(this).attr('beneid')
                }

            }).responseText;

            if (accountcheck != "Not Found") {
                $(this).prev().html("Account Number already Registered");
                acc_check.push(accountcheck)
            } else {
                $(this).prev().html("");
            }



        })

        $("input[name='upi[]']").map(function() {

            var upicheck = $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                async: false,
                dataType: "json",
                url: '/merchant/edit_validate_upi',
                data: {
                    "upi": $(this).val(),
                    "id": $(this).attr('beneid')
                }

            }).responseText;

            if (upicheck != "Not Found") {
                $(this).prev().html("Upi already Registered");
                upi_check.push(upicheck)
            } else {
                $(this).prev().html("");
            }



        })


        if (acc_check.length != 0) {
            console.log("stopped for acc");
            return false;
        }

        if (upi_check.length != 0) {
            console.log("stopped for upi");
            return false;
        }


        $("input[name='upi[]']").map(function() {

            var upi = $(this).val();
            if (/^[\w.-]+@[\w.-]+$/.test(upi) == false) {

                $(this).prev().html("Invalid Upi");
                upi_val_check.push(upi);
                return false;
            } else {

                $(this).prev().html("");
            }

        }).get();

        $("input[name='acc_no[]']").map(function() {

            var acc = $(this).val();
            if ((acc.length < 9) || (acc.length > 18)) {

                $(this).prev().html("Invalid Account Number");
                acc_val_check.push(acc);
                return false;
            } else {

                $(this).prev().html("");
            }

        }).get();

        $("input[name='ifsc[]']").map(function() {

            var ifsc = $(this).val();
            if (/^[A-Z]{4}0[A-Z0-9]{6}$/.test(ifsc) == false) {

                $(this).prev().html("Invalid Ifsc");
                ifsc_val_check.push(ifsc);
                return false;
            } else if (/^[A-Z]{4}0[A-Z0-9]{6}$/.test(ifsc) == true) {

                $(this).prev().html("");
            }

        }).get();

        if (upi_val_check.length != 0 || acc_val_check.length != 0 || ifsc_val_check.length != 0) {
            console.log('upi acc ifsc not ok');
            return false;
        } else {
            console.log('upi acc ifsc  ok');
            
        }

        console.log(`upi ${upi_val_check.length},acc ${acc_val_check.length},ifsc ${ifsc_val_check.length}`)

        console.log(`upi ${upi_val_check},acc ${acc_val_check},ifsc ${ifsc_val_check}`)
        console.log('clear to go');
    

       
    }
</script>

@endsection