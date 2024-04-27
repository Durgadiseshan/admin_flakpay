@extends('layouts.merchantempapp')
@section('content')
<div class="container-fluid">
    <div class="row">
        @include('layouts.merchantemptopnav')
    </div>
    <div class="row">
        <div class="col-sm-12">
            @include('layouts.merchantempsidenav')
            <div class="col-sm-12">
                <div class="merchant-content">
                    @yield('empcontent')
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-11 col-sm-offset-1">
            @include('layouts.merchantfooter')
        </div>
    </div>
</div>

@endsection