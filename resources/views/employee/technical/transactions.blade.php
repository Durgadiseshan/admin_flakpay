@php
$vendor_banks = App\RyapayVendorBank::get_vendorbank();
@endphp
@extends('layouts.employeecontent')
@section('employeecontent')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<style>
    .dataTables_filter {
        display: none;
    }

    .card {
        border: thin solid #ccc;
        border-radius: 10px;
        padding: 5px 5px 5px 5px;
        margin: 5px 5px 5px 5px;
    }

    .thinText {
        font-size: 1.125rem;
        line-height: 1.75rem;
    }

    .strongText {
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .headlineText {
        font-weight: 900;
        letter-spacing: 2.5px;

    }

    .transactiongid {
        color: #3c8dbc;
        cursor: pointer;
    }
</style>

<div class="row">
  <div class="col-sm-12 padding-20">
    <div class="panel panel-default">
      <div class="panel-heading">
        <ul class="nav nav-tabs" id="transaction-tabs">
          <li class="active"><a data-toggle="tab" class="show-cursor" data-target="#Transactions">Transactions</a></li>
        </ul>
      </div>
      <div class="panel-body">
        <div class="tab-content">
          <div id="Transactions" class="tab-pane fade in active">
            <div class="row row-new">
              <div class="col-sm-6 mb-4">
                <input type="text" id="search" class="form-control" placeholder="search ..">
              </div>
              <div class="col-sm-6 mb-4">
                <input type="text" name="datetimes" id="datetimes" style="background: #fff; cursor: pointer; padding: 6px 12px; border: 1px solid #ccc; width: 100%;border-radius: 4px;
                font-size: 14px;" />
              </div>
            </div>
            <div style="margin-top:10px;">
              <table class="table table-striped table-bordered" id="transactions">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Transaction Gid</th>
                    <th>Order Id</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
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
</div>



<!-- infomodal -->
<div class="modal fade" id="infomodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Transaction Info</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <table class="table table-striped" style="width:100%">

                    <tr>
                        <th>Status</th>
                        <td class="text-info" id="status"></td>
                    </tr>
                </table>


                <div id="infotable" style="display:none;">
                    <table class="table table-striped" style="width:100%">

                        <tr>
                            <th>Amount</th>
                            <td id="amount"></td>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <td id="date"></td>
                        </tr>
                        <tr>
                            <th>Message</th>
                            <td id="message"></td>
                        </tr>
                        <tr>
                            <th>Order Id</th>
                            <td id="orderid"></td>
                        </tr>
                        <tr>
                            <th>Transaction Status</th>
                            <td id="txstatus"></td>
                        </tr>


                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- infomodalends -->

<!-- updatestatusmodal -->
<div class="modal fade" id="updatestatusmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Update Transaction Info</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <table class="table table-striped" style="width:100%">

                    <tr>
                        <th>Current Status</th>
                        <td class="text-info" id="updatedstatus"></td>
                    </tr>

                    <tr>
                        <th>Transaction Id </th>
                        <td class="text-info" id="transferid"></td>
                    </tr>

                    <tr>
                        <th>Reference Id</th>
                        <td class="text-info" id="referenceid"></td>
                    </tr>
                </table>



            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- updatestatusmodalends -->


<!-- transaction details Modal -->
<div class="modal fade" id="transactiondetailsmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="z-index:11000;">
    <div class="modal-dialog " role="document" style="width:1200px">
        <div class="modal-content">
            <div class="modal-header">
                <h3>View Details</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="headlineText">TRANSACTION DETAILS</h5>
                            </div>
                            <div class="card-body">
                                <table>
                                    <tr>
                                        <td class="thinText">Transaction Initiation Time:</td>
                                        <td class="strongText" id="trantime"> </td>
                                    </tr>
                                    <tr>
                                        <td class="thinText">Transaction ID:</td>
                                        <td class="strongText" id="tranid"> </td>
                                    </tr>
                                    <tr>
                                        <td class="thinText">Transaction Status:</td>
                                        <td class="strongText" id="transtatus"> </td>
                                    </tr>
                                </table>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="headlineText">MERCHANT DETAILS</h5>
                            </div>
                            <div class="card-body">
                                <table>
                                    <tr>
                                        <td class="thinText">Merchant Name:</td>
                                        <td class="strongText" id="mname"> </td>
                                    </tr>
                                    <tr>
                                        <td class="thinText">Merchant Email:</td>
                                        <td class="strongText" id="memail"> </td>
                                    </tr>
                                    <tr>
                                        <td class="thinText">Merchant Contact:</td>
                                        <td class="strongText" id="mcontact"> </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="headlineText">PAYMENT DETAILS</h5>
                            </div>
                            <div class="card-body">
                                <table>
                                    <tr>
                                        <td class="thinText">Payment Mode:</td>
                                        <td class="strongText" id="paymentmode"> </td>
                                    </tr>
                                    <tr>
                                        <td class="thinText">Amount:</td>
                                        <td class="strongText" id="tranamount"> </td>
                                    </tr>

                                </table>

                            </div>
                        </div>
                    </div>
                </div>





            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--  transaction details Modalends -->





<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>

<script>
    $(document).on('click', '.transactiongid', function() {
        console.log('%ctransactions.blade.php line:345 transaction gid clicked', 'color: #007acc;', 'transaction gid clicked');
        $('#transactiondetailsmodal').modal('show');
        var transactionId = (this).innerHTML;
        console.log(transactionId);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            dataType: "json",
            url: '/rockpay/technical/transactionInfo',
            data: {
                'transactionID': transactionId,

            },
            success: function(data) {
                console.log(data);

                $('#mname').html(data.data.merchant_info.name);
                $('#memail').html(data.data.merchant_info.email);
                $('#mcontact').html(data.data.merchant_info.mobile_no);


                $('#trantime').html(data.data.transaction_info.created_date);
                $('#tranid').html(data.data.transaction_info.transaction_gid);
                $('#transtatus').html(data.data.transaction_info.transaction_status);

                $('#paymentmode').html(data.data.transaction_info.transaction_mode);
                $('#tranamount').html(data.data.transaction_info.transaction_amount);


            }
        })
    })
</script>

<script>
    $(document).on('click', '.callinfo', function() {
        console.log('%ctransactions.blade.php line:67 object', 'color: #007acc;', 'cdsaf');
        var merchant = $(this).attr('merchant');
        var mode = $(this).attr('mode');
        var orderid = $(this).attr('orderid');
        console.log('%ctransactions.blade.php line:67 object', 'color: #007acc;', orderid, mode, merchant);
        $('#infomodal').modal('show');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            dataType: "json",
            url: '/rockpay/technical/findvendortransactionstatus',
            data: {
                'transactionmode': mode,
                'merchantid': merchant,
                'transactionid': orderid
            },
            success: function(data) {
                console.log(data);

                if (data.Found == false) {
                    console.log('%ctransactions.blade.php line:110 ', 'color: #007acc;', 'data not foound');
                    $("#status").html('Not Found');
                    $("#infotable").hide();
                } else {
                    console.log('%ctransactions.blade.php line:110 ', 'color: #007acc;', 'foound');
                    $("#status").html('Found');


                    $("#infotable").show();
                    $("#amount").html(data.data.amount);
                    $("#date").html(data.data.date);
                    $("#message").html(data.data.msg);
                    $("#orderid").html(data.data.order_id);
                    $("#txstatus").html(data.data.status);

                }


            }
        })
    });
</script>

<script>
    $(document).on('click', '.updatestatus', function() {

        var orderid = $(this).attr('orderid');

        $('#updatestatusmodal').modal('show');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            dataType: "json",
            url: '/rockpay/technical/updatetransactionstatus',
            data: {
                'orderId': orderid
            },
            success: function(data) {
                console.log(data);
              

                $("#updatedstatus").html(data.txStatus);
                $("#transferid").html(orderid);
                $("#referenceid").html(data.referenceId);

            }
        })
    });
</script>


<script>
    $('#search').on('input', function() {
        var search = $(this).val();
        $('#transactions').DataTable().destroy();
        var startDate = moment($('#datetimes').data('daterangepicker').startDate).format('YYYY-MM-DD');
        var endDate = moment($('#datetimes').data('daterangepicker').endDate).format('YYYY-MM-DD');
        console.log(search, startDate, endDate);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            dataType: "json",
            url: '/rockpay/technical/searchtransactions',
            data: {
                'search': search,
                'startdate': startDate,
                'enddate': endDate
            },
            success: function(data) {
                console.log(data);
                $('#transactions tbody').html(``);
                data.forEach((element, index) => {
                    if (element.transaction_status == 'pending') {
                        $('#transactions tbody').append(`<tr><td>${index+1}</td><td class="transactiongid">${element.transaction_gid}</td><td>${element.order_gid}</td><td>${element.transaction_username}</td><td>${element.transaction_email}</td><td>${element.transaction_contact}</td><td>${element.transaction_amount}</td><td>${element.transaction_status}</td><td>${element.created_date}</td><td><button class="btn btn-sm btn-warning callinfo"  merchant=${element.created_merchant} orderid=${element.transaction_gid} mode=${element.transaction_mode}><ion-icon name="information-circle-outline"></ion-icon></button> <button orderid=${element.transaction_gid}  class="updatestatus btn btn-sm btn-success"><ion-icon  name="card-outline"></ion-icon></button></td></tr>`);
                    } else {
                        $('#transactions tbody').append(`<tr><td>${index+1}</td><td class="transactiongid">${element.transaction_gid}</td><td>${element.order_gid}</td><td>${element.transaction_username}</td><td>${element.transaction_email}</td><td>${element.transaction_contact}</td><td>${element.transaction_amount}</td><td>${element.transaction_status}</td><td>${element.created_date}</td><td><button class="btn btn-sm btn-warning callinfo"  merchant=${element.created_merchant} orderid=${element.transaction_gid} mode=${element.transaction_mode}><ion-icon name="information-circle-outline"></ion-icon></button></td></tr>`);
                    }
                });

                $('#transactions').DataTable().draw();

            }
        })
    })
</script>

<script type="text/javascript">
    $(function() {

        var start = moment().subtract(60, 'days');
        var end = moment();


        function cb(start, end) {
            $('input[name="datetimes"] span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            var search = $('#search').val();
            $('#transactions').DataTable().destroy();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "GET",
                dataType: "json",
                url: '/rockpay/technical/searchtransactions',
                data: {
                    'search': search,
                    'startdate': start.format('YYYY-MM-DD'),
                    'enddate': end.format('YYYY-MM-DD')
                },
                success: function(data) {

                    console.log('cb function', data);
                    $('#transactions tbody').html(``);
                    data.forEach((element, index) => {
                        if (element.transaction_status == 'pending') {
                            $('#transactions tbody').append(`<tr><td>${index+1}</td><td class="transactiongid">${element.transaction_gid}</td><td>${element.order_gid}</td><td>${element.transaction_username}</td><td>${element.transaction_email}</td><td>${element.transaction_contact}</td><td>${element.transaction_amount}</td><td>${element.transaction_status}</td><td>${element.created_date}</td><td><button class="btn btn-sm btn-warning callinfo" merchant=${element.created_merchant} orderid=${element.transaction_gid} mode=${element.transaction_mode}><ion-icon  name="information-circle-outline"></ion-icon></button> <button orderid=${element.transaction_gid} class="updatestatus btn btn-sm btn-success" ><ion-icon   name="card-outline"></ion-icon></button></td></tr>`);
                        } else {
                            $('#transactions tbody').append(`<tr><td>${index+1}</td><td class="transactiongid">${element.transaction_gid}</td><td>${element.order_gid}</td><td>${element.transaction_username}</td><td>${element.transaction_email}</td><td>${element.transaction_contact}</td><td>${element.transaction_amount}</td><td>${element.transaction_status}</td><td>${element.created_date}</td><td><button class="btn btn-sm btn-warning callinfo" merchant=${element.created_merchant} orderid=${element.transaction_gid} mode=${element.transaction_mode}><ion-icon  name="information-circle-outline"></ion-icon></button></td></tr>`);
                        }

                    });

                    $('#transactions').DataTable().draw();

                }
            })

        }

        $('input[name="datetimes"]').daterangepicker({
            startDate: start,
            endDate: end,
            Locale: {
                format: 'DD/MM/YYYY'
            },
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'This Year': [moment().startOf('year'), moment().endOf('year')],
            }
        }, cb);

        cb(start, end);


    });
</script>









@endsection