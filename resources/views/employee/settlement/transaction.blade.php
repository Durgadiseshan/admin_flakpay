@php
    use App\User;
    $merchants = User::get_merchant_options();
@endphp
@extends('layouts.employeecontent')
@section('employeecontent')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<style>
        table {
        width: 100% !important;
        border-collapse: collapse;
    }
    th, td {
        padding: 15px;
        text-align: center;
    }
    th {
        background-color: #f2f2f2;
    }
    tr {
    text-wrap: nowrap;
}
/* .table-container{
    overflow-x: auto;
} */
    @media only screen and (max-width: 768px) {
        th, td {
            padding: 10px;
            font-size: 14px;
        }
    }
    input[type="search"] {
    border-radius: 30px;
}
    .uploadbtn {
    margin-top: 5px;
}
    </style>
<div class="row">
    <div class="col-sm-12 padding-20">
        <div class="panel panel-default position-relative">
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
                        <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#{{str_replace(' ','-',strtolower($sublink_name))}}">Ongoing Settlements</a></li>
                        <li><a data-toggle="tab" class="show-pointer" id="completed_settlement" data-target="#rupayapay-adjustments">Completed Settlements</a></li>
                    @endif
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    @if(count($sublinks) > 0)
                    @foreach($sublinks as $index => $value)
                        @if($index == 0)
                        <div id="{{str_replace(' ','-',strtolower($value->link_name))}}" class="tab-pane fade in active">
                        
                        </div>
                        @else
                        <div id="{{str_replace(' ','-',strtolower($value->link_name))}}" class="tab-pane fade"> 
                        
                        </div>
                        @endif
                    @endforeach 
                    @else
                        <div id="{{str_replace(' ','-',strtolower($sublink_name))}}" class="tab-pane fade in active">
                            <div class="src src-new">
                                <form id="transaction-form">
                                    <input class="form-control" id="trans_date_range" name="trans_date_range" placeholder="MM/DD/YYYY" type="text" value="">
                                    <input type="hidden" name="trans_from_date" value="{{session()->get('fromdate')}}">
                                    <input type="hidden" name="trans_to_date" value="{{session()->get('todate')}}">
                                    <input type="hidden" name="perpage" value="10">
                                    <input type="hidden" name="transaction_page" value="transactions">
                                    <i class="fa fa-calendar"></i>
                                    {{csrf_field()}} 
                                </form>
                            </div>
                            <div class="row excel-pad">
                               <div class="col-sm-12 p-0">
                                 <div class="row margin-bottom-lg"> 
                                    <div class="col-sm-12 p-0">
                                        <!-- <a href="{{route('add-new-settlement')}}" class="btn btn-primary btn-sm pull-right margin-right-md">New Settlement</a>
                                        <a href="javascript:void(0)" class="btn btn-primary btn-sm pull-right margin-right-md" onclick="bulkSettlement();">Bulk Settlement</a> -->
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 p-0 mbb-l-4 download-src">
                                                <form id="transaction-download-form" action="{{route('download-transactiondata')}}" method="POST" role="form">
                                                    <input type="hidden" name="trans_from_date" id="input_trans_from_date" class="form-control" value="{{session()->get('fromdate')}}">
                                                    <input type="hidden" name="trans_to_date" id="input_trans_to_date" class="form-control" value="{{session()->get('todate')}}">
                                                    {{csrf_field()}}
                                                    <button type="submit" class="btn mt-5 mb-5" style="padding: 5px 10px;;font-weight: bolder;background-color: #175c35;color: white; border-radius: 30px;">Download Excel&nbsp;&nbsp;<i class="fa fa-file-excel-o" style="font-size:20px"></i></button>

                                                </form>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 p-0 mbb-l-4">      
                                                <button type="button" class="btn btn-primary btn-sm pull-right" id="call-adjustment-modal">
                                                    Quick Settlement
                                                </button>
                                            </div>
                                        </div>

<!-- Modal -->
<div class="modal fade" id="adjustmentModal" tabindex="-1" role="dialog" aria-labelledby="adjustmentModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="adjustmentModalLabel" style="
    text-align: center;
">Quick Settlement</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form>
        <div class="form-group">
            <label for="field1">Merchant Name</label>
            <input type="text" class="form-control" id="merchant_name" name="field1">
        </div>
        <div class="form-group">
            <label for="field2">Amount</label>
            <input type="text" class="form-control" id="Amount_merchnant" name="field2">
        </div>
        <div class="form-group">
            <label for="field3">Time</label>
            <input type="text" class="form-control" id="Time" name="field3">
        </div>
        <div class="form-group">
            <label for="field4">Account Number</label>
            <input type="text" class="form-control" id="Account_number" name="field4">
        </div>
        <div class="form-group">
            <label for="field5">Bank IFSC Code</label>
            <input type="text" class="form-control" id="bank_ifsc_code" name="field5">
        </div>
        <!-- Add more input fields if needed -->
        <div class="text-center">
        <button type="submit" class="btn" style="border-radius: 30px;background-color: #5d1c84;color: white;padding: 10px 20px;"><i class="fa fa-handshake-o" aria-hidden="true"></i>&nbsp;&nbsp;Settlement</button>
            </div>
                </form>
                </div>
                
                </div>
            </div>
            </div>
                </div>
            </div>
            <div class="table-container">
            <table class="table-bordered data-table" id="settlement_list">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th >Merchant name</th>
                                                <th >Settlement Id</th>
                                                <th >Settlement Report</th>
                                                <th >Settlement Generate time</th>
                                                <th >Success Transactions Count</th>
                                                <th >Customer Txn amt</th>
                                                <th>Fee amt </th>
                                                <th>GST Fee ( Fee amt * 18%)</th>
                                                <th>Net Settlement Amount</th>
                                                <th>Created at</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                        </tbody>
                                    </table>
                                   </div>
                            </div>
                        </div>
                           <!-- vendor adjustments -->
                           <!-- Adjustment created modal starts-->
                            <div class="modal" id="adjusttrans-add-response-message-modal">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title">On progress settlement</h4>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Transaction Id</th>
                                                        <th>Adjustment Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="adjustment-response-rows">
                                                   
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Adjustment created modal ends-->
                            
                            <div class="modal" id="adjustment-select-option-modal">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form id="adjustment-select-form" method="POST" class="form-horizontal" role="form">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title">Adjustment</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="col-sm-6">
                                                                <div class="checkbox"> 
                                                                    <label>
                                                                        <input type="checkbox" name="adjustment" id="vendor" class="form-control" value="vendor">
                                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                                        Vendor Adjustment
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="adjustment" id="rupayapay" class="form-control" value="rupayapay">
                                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                                        Flakpay Adjustment
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-6 col-sm-offset-5">
                                                        <button type="submit" class="btn btn-primary btn-sm">Do Adjustment</button>
                                                    </div>
                                                </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                                                     
                        </div>
                        <div id="vendor-adjustments" class="tab-pane fade in">
    <div class="src">
        <form id="vendor-adjustment-form">
            <input class="form-control" id="trans_date_range" name="trans_date_range" placeholder="MM/DD/YYYY" type="text" value="">
            <input type="hidden" name="trans_from_date" value="{{session('trans_from_date')}}">
            <input type="hidden" name="trans_to_date" value="{{session('trans_to_date')}}">
            <input type="hidden" name="perpage" value="10">
            <input type="hidden" name="transaction_page" value="ryapayadjustment">
            <i class="fa fa-calendar"></i>
            {{csrf_field()}}
        </form>
    </div>
    <div class="row margin-bottom-lg">
        <div class="col-sm-12">
            <a href="javascript:void(0)" class="btn btn-primary btn-sm pull-right margin-right-md" onclick="bulkRupayapayAdjustments();">Rupayapay Adjustment</a>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="table-container"   id="onprogress">
               
            </div>
        </div>
    </div>
</div>

                        <div id="rupayapay-adjustments" class="tab-pane fade in">
                            <div class="src src-new">
                                <form id="rupayapay-adjustment">
                                    <input class="form-control" id="trans_date_range" name="trans_date_range" placeholder="MM/DD/YYYY" type="text" value="">
                                    <input type="hidden" name="trans_from_date" value="{{session('trans_from_date')}}">
                                    <input type="hidden" name="trans_to_date" value="{{session('trans_to_date')}}">
                                    <input type="hidden" name="perpage" value="10">
                                    <i class="fa fa-calendar"></i>
                                    {{csrf_field()}} 
                                </form>
                            </div>
                            <div class="row  excel-pad">
                                <div class="col-sm-12 p-0">
                                    <!-- <div id="paginate_ryapayadjustment"> -->
                <div class="table-container">                
                    <table class="table-bordered data-table" id="completed_settlement_list">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th >Merchant name</th>
                                <th >Settlement Id</th>
                                <th >Settlement Report</th>
                                <th >Settlement Generate time</th>
                                <th >Customer Txn Count</th>
                                <th >Customer Txn amt</th>
                                <th>Fee amt </th>
                                <th>GST Fee ( Fee amt * 18%)</th>
                                <th>Net Settlement Amount</th>
                                <th>Created At</th>
                                <th>Completed At</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        </tbody>
                    </table>
            </div>
        </div>              
                </div>
                </div> 
            </div>                         
        </div>
                    @endif
                </div>
                 <!-- Porder created modal starts-->
                 <div id="adjustment-alert-modal" class="modal">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-body">
                                <strong id="adjustment-alert-message"></strong>
                            </div>
                            <div class="modal-footer">
                                <form>
                                    <input type="submit" class="btn btn-primary btn-sm" value="OK" onlick="location.refresh();"/>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Porder created modal ends-->
                <!-- Porder created modal starts-->
                <div id="adjustment-alert" class="modal">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-body">
                                <strong id="adjustment-alert-show"></strong>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Porder created modal ends-->
                <div class="modal" id="rupayapay-adjustment-add-response-message-modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Vendor Adjustment Response</h4>
                            </div>
                            <div class="modal-body">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Transaction Id</th>
                                            <th>Adjustment Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="rupayapay-adjustment-response-rows">
                                       
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <form>
                                    <input type="submit" class="btn btn-primary btn-sm" value="Close" onlick="location.refresh();"/>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>


<script type="text/javascript">

    toastr.options = {
        closeButton: true,
        progressBar: true,
        positionClass: 'toast-top-right'
    };


// Quick settlement modals
document.getElementById("call-adjustment-modal").addEventListener("click", function() {
    $('#adjustmentModal').modal('show');
  });

// 
</script>

<div class="modal fade bd-example-modal-md" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-md .modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"> Add Settlement Receipt </h4>
            </div>
            <div class="modal-body">

                <form action="/flakpay/settlement/file_upload" method="POST" class="form-horizontal" role="form" id="settlement_fileupload" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="DZZ7rIgMUinaCweZ2QTus8xgXWzZZ2cZh1rsAzlG">

                    <div class="form-group form-fit">

                    <div class="settingssection" style="display:block;">
                        <div class="parentDivDetails">
                            <div class="form-group form-fit">
                                                                   
                          <div class="col-sm-12">
                           <input type="file" name="settlement_file" id="settlement_file" style="display: block!important" class="inputfile form-control">
                        
                           <input type="hidden" name="settlement_record_id" id="settlement_record_field" value="">
                           <div class="px-5 py-3 mt-20 text-center uploadbtn">
                          <button class="btn btn-primary" type="submit"> Upload  </button>
                          </div>
                         </div>
                
                    </div>
                                
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>



<script type="text/javascript">

$(document).ready(function() {

    getMerchantTransactionsmode()


$(document).on('click', '.make_payment', function() {
   
    $('#settlement_file').val('');
    var id = $(this).data('id');
    $('#settlement_record_field').val(id)
    $('.bd-example-modal-md').modal('show');
});

$(document).on('click', '.mark_as_paid', function() {
    markStatusUpdate($(this).data('id'))
});

// $(document).on('click', '.excel_download', function() {
//     console.log('receipt url : ',$(this).data('url'));
//     window.location.href = $(this).data('url');
//     // markStatusUpdate($(this).data('id'))
// });


$('#completed_settlement').on('click', function(){
        $('#completed_settlement_list').DataTable().draw();
    });

$('#settlement_fileupload').on('submit', function(e){
        e.preventDefault();

        var formData = new FormData(this);
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: '{{ route("settlement-fileupload") }}',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken // Include CSRF token in headers
            },
            data: formData,
            contentType: false,
            processData: false,
            success: function(response){
                if(response.success)
                {
                    toastr.success('File uploaded successfully.', 'Success', { timeOut: 3000 });
                    $('#settlement_list').DataTable().draw();
                    $('.bd-example-modal-md').modal('hide')
                }
                else{
                    toastr.error(response.error, 'Error', { timeOut: 3000 });
                }

            },
            error: function(xhr, status, error){
                toastr.error('Something went wrong.', 'Error', { timeOut: 3000 });
            }
        });
    });


function markStatusUpdate(settlement_id){

        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: `/flakpay/settlement/markasPaid/${settlement_id}`,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken // Include CSRF token in headers
            },
            dataType: "json",
            success: function(response){
                console.log('response ',response)
                if(response.success)
                {
                    toastr.success(response.success, 'Success', { timeOut: 3000 });
                    $('#settlement_list').DataTable().draw();
                }
                else{
                    toastr.error(response.error, 'Error', { timeOut: 3000 });
                }

            },
            error: function(xhr, status, error){
                toastr.error('Something went wrong.', 'Error', { timeOut: 3000 });
            }
        });
    }

function getMerchantTransactionsmode() {

    
var table = $('#settlement_list').DataTable({
        processing: true,
        serverSide: true,
        // scrollX: true,        
        ajax: "/flakpay/settlement/getoverallsettlementList",
        dom: 'Blfrtip',
              buttons: [
                   {
                       extend: 'pdf',
                       exportOptions: {
                           columns: [1,2,3,4,5] // Column index which needs to export
                       }
                   },
                   {
                       extend: 'csv',
                       exportOptions: {
                           columns: [0,5] // Column index which needs to export
                       }
                   },
                   {
                       extend: 'excel',
                       exportOptions: {
                           columns: [0,5] // Column index which needs to export
                       }
                   }
              ],
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'merchant_name', name: 'merchant_name'},
            {data: 'settlement_id', name: 'settlement_id'},
            {data: 'settlement_report', name: 'settlement_report'},

            {data: 'report_time', name: 'report_time'},
            {data: 'success_txn_count', name: 'success_txn_count'},
            {data: 'total_transaction_amount', name: 'total_transaction_amount'},
            {data: 'merchant_fee', name: 'merchant_fee'},
            {data: 'gst_amount', name: 'gst_amount'},
            {data: 'settlement_amount', name: 'settlement_amount'},
            {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
}
var table = $('#completed_settlement_list').DataTable({
        processing: true,
        serverSide: true,
        // scrollX: true,
        ajax: "/flakpay/settlement/getcompletedsettlementList",
        dom: 'Blfrtip',
              buttons: [
                   {
                       extend: 'pdf',
                       exportOptions: {
                           columns: [1,2,3,4,5] // Column index which needs to export
                       }
                   },
                   {
                       extend: 'csv',
                       exportOptions: {
                           columns: [0,5] // Column index which needs to export
                       }
                   },
                   {
                       extend: 'excel',
                       exportOptions: {
                           columns: [0,5] // Column index which needs to export
                       }
                   }
              ],
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'merchant_name', name: 'merchant_name'},
            {data: 'settlement_id', name: 'settlement_id'},
            {data: 'settlement_report', name: 'settlement_report'},
            {data: 'report_time', name: 'report_time'},
            {data: 'success_txn_count', name: 'success_txn_count'},
            {data: 'total_transaction_amount', name: 'total_transaction_amount'},
            {data: 'merchant_fee', name: 'merchant_fee'},
            {data: 'gst_amount', name: 'gst_amount'},
            {data: 'settlement_amount', name: 'settlement_amount'},
            {data: 'created_at', name: 'created_at'},
            {data: 'completed_at', name: 'completed_at'}
        ]
    });
    


    $('.dataTable').wrap('<div class="dataTables_scroll"></div>');
});

</script>

@endsection
