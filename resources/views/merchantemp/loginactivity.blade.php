@php
    use App\Http\Controllers\MerchantEmpController;

    $per_page = MerchantEmpController::page_limit();
@endphp
@extends('layouts.merchantempcontent')
@section('empcontent')
<div class="row">
    <div class="col-sm-12 padding-top-30">
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs" id="transaction-tabs">
                    <li class="active"><a data-toggle="tab" class="show-cursor" data-target="#payments">Login Activity Log</a></li>
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div id="payments" class="tab-pane fade in active">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="col-sm-4">
                                        <select name="page_limit" class="form-control" onchange="getAllPayments($(this).val())">
                                            @foreach($per_page as $index => $page)
                                            <option value="{{$index}}">{{$page}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="search-box">
                                    <form action="">
                                        <input type="search" id="merchantemp-log-table" placeholder="Search">
                                        <i class="fa fa-search"></i>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="display-block" id="paginate_merchantemp_log">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>
<script>
    window.addEventListener("DOMContentLoaded",function(){
        getAllLogActivities();
    });
</script>
@endsection