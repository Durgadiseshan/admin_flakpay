@extends('layouts.employeecontent')
@section('employeecontent')
<div class="row">
    <div class="col-sm-12 padding-20">
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" class="show-pointer" data-target="transactions-tab">Merchant Transactions</a></li> 
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div id="transactions-tab" class="tab-pane fade in active">
                        <div class="src">
                            <form id="merchant-transaction-form">
                                <input class="form-control" id="trans_date_range" name="trans_date_range" placeholder="MM/DD/YYYY" type="text" value="">
                                <input type="hidden" name="trans_from_date" value="{{session('trans_from_date')}}">
                                <input type="hidden" name="trans_to_date" value="{{session('trans_to_date')}}">
                                <input type="hidden" name="perpage" value="10">
                                <input type="hidden" name="transaction_page" value="ryapayadjustment">
                                <i class="fa fa-calendar"></i>
                                {{csrf_field()}} 
                            </form>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div id="paginate_fieldleadlist">

                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="modal" id="tranasaction-breakup-modal">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title">Transaction Breakup</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form id="tranasaction-breakup-form" method="POST" class="form-horizontal" role="form">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>
@endsection
<script>
    document.addEventListener("DOMContentLoaded",function(){
        getFieldLeadSalessheet();
        $("#visited").datepicker({
            "dateFormat":"dd-mm-yy",
            changeMonth: true,
            changeYear: true
        });
        $("#next_call").datepicker({
            "dateFormat":"dd-mm-yy",
            changeMonth: true,
            changeYear: true
        });
        
    });
</script>
