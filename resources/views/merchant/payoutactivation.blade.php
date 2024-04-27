@extends('layouts.merchantcontent')
@section('merchantcontent')

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">






<div id="buton-1">
    <button class="btn btn-dark" id="Show">Show</button>
    <button class="btn btn-danger" id="Hide">Remove</button>
</div>

<section id="about-1" class="about-1">
    <div class="container-1">

        <div class="row">

            <div class="col-lg-6 d-flex flex-column justify-contents-center" data-aos="fade-left">
                <div class="content-1 pt-4 pt-lg-0">

                    <h3>Payouts</h3>
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


@php
$check = \DB::table('merchant_requests')->where('request','payout')->where('merchant_id',Auth::user()->id)->first();

@endphp


@if ($check == null)
<div class="text-center" style="margin-bottom:10px;">
    <form action="/merchant/save_merchant_request" method="POST">
        {{ csrf_field() }}
        <input type="hidden" value="payout" name="requestString">
        <button type="submit" class="request btn btn-primary btn-lg">
            Request Activation
        </button>
    </form>

</div>
@else
<div id="message" class="text-center">
    Thank you for requesting Payout Activation . Your Request will be reviewed soon .
</div>
@endif





<script>
    $('.request').click(function() {
        swal("Request for Activation has been sent", {
            buttons: false,
            timer: 2000,
        });

        $(this).hide();
        $('#message').show();

    })
</script>





@endsection