@extends('layouts.merchantapp')
@section('content')
<div class="container-fluid">
    <div class="row">
        @include('layouts.merchanttopnav')
    </div>
    <div class="row">
        <div class="col-sm-12">
            @include('layouts.merchantsidenav')
            <div class="col-sm-12">
                <div class="merchant-content">
                    @yield('merchantcontent')
                </div>
            </div>
        </div>
        @include('merchant.globalmodals')
    </div>
    <div class="row">
        <div class="col-sm-11 col-sm-offset-1">
            @include('layouts.merchantfooter')
        </div>
    </div>
</div>

@endsection