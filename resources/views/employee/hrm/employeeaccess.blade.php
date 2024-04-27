@php
$vendor_banks = App\RyapayVendorBank::get_vendorbank();
@endphp
@extends('layouts.employeecontent')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<style>
    .card {
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
        border-radius: 10px;
        padding: 10px 5px 10px 5px;
    }

    .header {
        text-align: left;
        padding: 5px 5px 5px 5px;
        font-weight: 900;
    }

    .submitbutton {
        margin: 10px 10px 50px 10px;
    }
</style>
@section('employeecontent')

<div style="display:flex;">

    <div class="col-2">
        <h3>Employee Access</h3>
    </div>
    <div class="col-8">

    </div>
    <div style="margin-top:20px; margin-left:900px;">
        <a href="/rockpay/hrm/employee-details/ryapay-SXuz2t3Z"><button type="button" class="btn btn-primary">Back</button></a>
    </div>

</div>


<form method="POST" action="{{route('editemployeeAccess')}}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="hidden" name="userid" value="{{$id}}">
    @foreach ($allmodules as $module)



    <div class="header">
        <h5 class="header">{{$module->link_name}}</h5>
    </div>
    <div class="card">
        @foreach ($module->submodules as $submodule)

        <div>

            <div class="row my-5">
                <div class="col-sm-4">
                    <input type="checkbox" @if($module->link_name == "Risk & Complaince") name="risk_complaince[]" @else name="{{$module->link_name}}[]" @endif value="{{$submodule->id}}" @if($submodule->status == 1 ) checked @endif>
                </div>
                <div class="col-sm-4">
                    <h6>{{$submodule->link_name}}</h6>
                </div>
            </div>


        </div>

        @endforeach
    </div>

    @endforeach
    <div class="text-center submitbutton">
        <button type="submit" class=" btn btn-primary">Submit</button>
    </div>
</form>


<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js" charset="utf-8"></script>

<script src="//cdn.amcharts.com/lib/4/core.js"></script>
<script src="//cdn.amcharts.com/lib/4/charts.js"></script>
<script src="//cdn.amcharts.com/lib/4/themes/animated.js"></script>
<script src="//cdn.amcharts.com/lib/4/themes/kelly.js"></script>






@endsection