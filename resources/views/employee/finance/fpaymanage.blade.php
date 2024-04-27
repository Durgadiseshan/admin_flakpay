@extends('layouts.employeecontent')
@section('employeecontent')
<div class="row">
    <div class="col-sm-12 padding-20">
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs" id="transaction-tabs">
                    @if(count($sublinks) > 0)
                    @foreach($sublinks as $index => $value)
                        @if($index == 0)
                            <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#{{str_replace(' ','-',strtolower($value->link_name))}}">{{$value->link_name}}</a></li> 
                        @else
                        <li><a data-toggle="tab" class="show-pointer" data-target="#{{str_replace(' ','-',strtolower($value->link_name))}}">{{$value->link_name}}</a></li>
                        @endif
                    @endforeach
                    @else
                        <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#{{str_replace(' ','-',strtolower($sublink_name))}}">{{$sublink_name}}</a></li> 
                    @endif
                    <li><a data-toggle="tab" class="show-pointer" data-target="#bank-detail-info">Banks</a></li> 
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    @if(count($sublinks) > 0)
                    @foreach($sublinks as $index => $value)
                        @if($index == 0)
                        <div id="{{str_replace(' ','-',strtolower($value->link_name))}}" class="tab-pane fade in active">
                            <div class="row">
                                <div class="col-sm-12">
                                    <a href="{{route('sundry-payment-show')}}" class="btn btn-primary btn-sm pull-right">New Payment Entry</a>
                                </div>
                            </div>
                            <div class="row padding-top-sm">
                                <div class="col-sm-12">
                                    <div id="paginate_sundpaybatches">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        @elseif($index == 1)
                        <div id="{{str_replace(' ','-',strtolower($value->link_name))}}" class="tab-pane fade">
                            <div class="row">
                                <div class="col-sm-12">
                                    <a href="{{route('contra-entry-show')}}" class="btn btn-primary btn-sm pull-right">New Contra Entry</a>
                                </div>
                            </div>
                            <div class="row padding-top-sm">
                                <div class="col-sm-12">
                                    <div id="paginate_contras">

                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div id="bank-detail-info" class="tab-pane fade">
                            <div class="row">
                                <div class="col-sm-12">
                                    <a href="javascript:" class="btn btn-primary btn-sm pull-right" onclick="callBankModal();" >New Bank</a>
                                </div>
                            </div>
                            <div class="row padding-top-md">
                                <div class="col-sm-12">
                                    <div id="paginate_banks">

                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="call-bank-modal">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title">Bank Details</h4>
                                        </div>
                                        <form id="bank-form" method="POST" class="form-horizontal" role="form" onsubmit="return validateForm()">
                                            <div class="modal-body">
                                                <div id="add-ajax-success" class="text-success text-center"></div>
                                                <div id="add-ajax-fail" class="text-danger text-center"></div>
                                                <div class="form-group">
                                                        <label for="bank_name" class="col-sm-4 control-label">Bank Name:</label>
                                                        <div class="col-sm-5">
                                                            <input type="text" name="bank_name" id="bank_name" class="form-control" required>
                                                            <div class="" id="bank-name"></div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="bank_accno" class="col-sm-4 control-label">Bank Account No:</label>
                                                        <div class="col-sm-5">
                                                            <input type="text" name="bank_accno" id="bank_accno" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    {{ csrf_field() }}
                                                    <div class="form-group">
                                                        <div class="col-sm-3 col-sm-offset-4">
                                                            <button type="submit" class="btn btn-primary">Add Bank</button>
                                                        </div>
                                                    </div>
                                                </form>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="call-edit-bank-modal">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title">Bank Details</h4>
                                        </div>
                                        <form id="edit-bank-form" method="POST" class="form-horizontal" role="form">
                                            <div id="update-ajax-success" class="text-success text-center"></div>
                                            <div id="update-ajax-fail" class="text-danger text-center"></div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="input" class="col-sm-4 control-label">Bank Name:</label>
                                                    <div class="col-sm-5">
                                                        <input type="text" name="bank_name" id="bank_name" class="form-control" value="">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="input" class="col-sm-4 control-label">Bank Account No:</label>
                                                    <div class="col-sm-5">
                                                        <input type="text" name="bank_accno" id="bank_accno" class="form-control" value="">
                                                    </div>
                                                </div>
                                                <input type="hidden" name="id" id="id" class="form-control" value="">
                                                {{csrf_field()}}
                                                <div class="form-group">
                                                    <div class="col-sm-3 col-sm-offset-4">
                                                        <button type="submit" class="btn btn-primary">Update Bank</button>
                                                    </div>
                                                </div>
                                            </div>  
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @else
                        <div id="{{str_replace(' ','-',strtolower($sublink_name))}}" class="tab-pane fade in active">
                            @if(isset($id))
                                @include('employee.'.$id)
                            @endif                            
                        </div>
                    @endif
                </div>
            </div>
        </div>    
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded',function(){
        //getAllBanks();
        getAllSundryPaymentEntry();
    });
    <script>
    function validateForm() {
        var bankName = document.getElementById('bank_name').value;
        var bankAccNo = document.getElementById('bank_accno').value;

        // Basic validation - Check if the fields are not empty
        if (bankName.trim() === "" || bankAccNo.trim() === "") {
            alert("Please fill out all the required fields.");
            return false;
        }

        // Add more advanced validation logic if needed

        return true; // Form will be submitted if all validations pass
    }
</script>
</script>
@endsection
