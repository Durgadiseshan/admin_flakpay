@extends('layouts.employeecontent')
@section('employeecontent')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<style>
    .card {
        background-color: #fff;
        border-radius: 10px;
        border: #f78ca0 1px solid;
        padding: 10px 5px 10px 5px;
    }
</style>

<div class="row">
{{-- <form id="myForm" action="#" method="get"> --}}
    <div class="col-sm-12 padding-20">
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs" id="transaction-tabs">
                    <li class="active"><a data-toggle="tab" class="show-cursor" data-target="#dashboard}}">Dashboard</a></li>
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div id="dashboard" class="tab-pane fade in active">
                        <div class="app-card alert alert-dismissible shadow-sm mb-4 border-left-decoration" role="alert">
                            <div class="inner">
                                <div class="app-card-body">
                                    <h3 class="mb-3">Welcome, {{ Auth::guard('employee')->user()->first_name." ".Auth::guard('employee')->user()->last_name }}</h3>
                                    <!--<div class="row gx-5 gy-3">
                                        <div class="col-12 col-lg-9">
                                            <div>Portal is a free Bootstrap 5 admin dashboard template. The design is simple, clean and modular so it's a great base for building any modern web app.</div>
                                        </div>-->
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row g-4 mb-4">
                        <div class="col-6 col-lg-3">
                        <label for="time-input">Calendar:</label>
                        <div style="position: relative;">
                            <input type="text" name="datetimes" id="datetimes" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%" />
                            <i class="fa fa-calendar" id="calendar-icon" style="position: absolute; top: 50%; transform: translateY(-50%); right: 10px;cursor: pointer;"></i>
                        </div>
                        </div> 
                                                
                        {{-- <div class="col-6 col-lg-2">
                        <label for="from-time-input">From:</label>
                        <input type="time" id="from-time-input" name="from-time-input" pattern="[0-9]{2}:[0-9]{2}" required
                            style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                        </div>
                        <div class="col-6 col-lg-2">
                        <label for="to-time-input">To:</label>
                        <input type="time" id="to-time-input" name="to-time-input" pattern="[0-9]{2}:[0-9]{2}" required
                            style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                        </div> --}}

                        <div class="col-6 col-lg-3">
                        <label for="merchantId">Merchant Name</label>
                        <select name="merchantId" id="merchantId" class="form-control" >
                            <option value="" selected>Select Merchant</option>
                        <?php foreach ($merchants as $merchant): ?>
                            <option value="<?= $merchant->id ?>"><?= $merchant->business_name ?></option>
                                <?php endforeach; ?>
                        </select>
                        </div>
                        {{-- <div class="col-6 col-lg-2">
                        <button type="submit" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%; margin-top: 30px; text-align: center;">Submit</button>
                        </div> --}}
                        <div class="col-6 col-lg-3" style="padding-top: 30px !important;">
                        <form id="transaction-download-form" action="{{route('download-transactiondata')}}" method="POST" role="form">

                            <input type="hidden" name="selected_mode" id="selected_mode" value="live">
                            <input type="hidden" name="selected_status" id="selected_status" value="">
                            <input type="hidden" name="selected_merchant" id="selected_merchant" value="">
                            <input type="hidden" name="selected_date_ranges" id="selected_date_ranges" value="">
                            {{csrf_field()}}
                            <button type="submit" id="excel_btn" class="btn btn-primary " >Download Excel</button>
                        </form>
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-6 col-lg-2 mb-4">
                            <div class="app-card app-card-stat shadow-sm h-100" style="background-image: linear-gradient(to right, #f78ca0 0%, #f9748f 19%, #fd868c 60%, #fe9a8b 100%);">
                                <div class="app-card-body p-3 p-lg-4">
                                    <h4 class="stats-type mb-1" style="color:white;font-weight:900;height:40px;">Total Transactions</h4>
                                    <div class="stats-figure" id="totalTransaction" style="color:white;font-weight:900;">{{ $dashboard->total_transaction }}</div>
                                </div>
                                <a class="app-card-link-mask" href="merchant/transactions/ryapay-Ma42px1Z"></a>
                            </div>
                        </div>

                        <div class="col-6 col-lg-2 mb-4">
                            <div class="app-card app-card-stat shadow-sm h-100" style="background-image: linear-gradient(-20deg, #fc6076 0%, #ff9a44 100%);">
                                <div class="app-card-body p-3 p-lg-4">
                                    <h4 class="stats-type mb-1" style="color:white;font-weight:900;height:40px;">Total Success Transactions</h4>
                                    <div class="stats-figure" id="successfulTransaction" style="color:white;font-weight:900;">{{$dashboard->successful_transaction}}</div>
                                </div>
                                <a class="app-card-link-mask" href="merchant/transactions/ryapay-Ma42px1Z?status=success"></a>
                            </div>
                        </div>

                        <!-- <div class="col-6 col-lg-2">
                            <div  id="successfulTransactionCard">
                                <div class="app-card app-card-stat shadow-sm h-100" style="background-image: linear-gradient(-20deg, #fc6076 0%, #ff9a44 100%);">
                                    <div class="app-card-body p-3 p-lg-4">
                                        <h4 class="stats-type mb-1" style="color:white;font-weight:900;height:40px;">Total Success Transactions</h4>
                                        <div class="stats-figure" id="successfulTransaction" style="color:white;font-weight:900;">{{$dashboard->successful_transaction}}</div>
                                    </div>
                                </div>

                            </div>
                        </div> -->

                        <div class="col-6 col-lg-2 mb-4">
                            <div class="app-card app-card-stat shadow-sm h-100" style="background-image: linear-gradient(to top, #0ba360 0%, #3cba92 100%);">
                                <div class="app-card-body p-3 p-lg-4">
                                    <h4 class="stats-type mb-1" style="color:white;font-weight:900;height:40px;">Total Collection amount</h4>
                                    <div class="stats-figure" id="failedTransaction" style="color:white;font-weight:900;">{{ $dashboard->failed_transaction }}</div>
                                </div>
                                <a class="app-card-link-mask" href="#"></a>
                            </div>
                        </div>

                        <div class="col-6 col-lg-2 mb-4">
                            <div class="app-card app-card-stat shadow-sm h-100" style="background-image: linear-gradient(120deg, #f093fb 0%, #f5576c 100%);">
                                <div class="app-card-body p-3 p-lg-4">
                                    <h4 class="stats-type mb-1" style="color:white;font-weight:900;height:40px;">Total Users </h4>
                                    <div class="stats-figure" style="color:white;font-weight:900;">{{$dashboard->total_merchant}} </div>

                                </div>

                                <a class="app-card-link-mask" href="#"></a>
                            </div>
                        </div>
                        <div class="col-6 col-lg-2 mb-4">
                            <div class="app-card app-card-stat shadow-sm h-100" style="background-image: linear-gradient(to right, #43e97b 0%, #38f9d7 100%);">
                                <div class="app-card-body p-3 p-lg-4">
                                    <h4 class="stats-type mb-1" style="color:white;font-weight:900;height:40px;">Total Live Users</h4>
                                    <div class="stats-figure" style="color:white;font-weight:900;">{{ $dashboard->live_merchant}}</div>
                                </div>
                                <a class="app-card-link-mask" href="#"></a>
                            </div>
                        </div>
                        <div class="col-6 col-lg-2 mb-4">
                            <div class="app-card app-card-stat shadow-sm h-100" style="background-image: radial-gradient(circle 248px at center, #16d9e3 0%, #30c7ec 47%, #46aef7 100%);">
                                <div class="app-card-body p-3 p-lg-4">
                                    <h4 class="stats-type mb-1" style="color:white;font-weight:900;height:40px;">Total Active Users</h4>
                                    <div class="stats-figure" style="color:white;font-weight:900;">{{ $dashboard->active_merchant}}</div>
                                </div>
                                <a class="app-card-link-mask" href="#"></a>
                            </div>
                        </div>

                        <!-- //new tabs -->



                    </div>

                    <div class="row mt-2">
                        <div class="col-6 col-lg-2 mb-4">
                            <div class="app-card app-card-stat shadow-sm h-100" style="background-image: linear-gradient(120deg, #f093fb 0%, #f5576c 100%);">
                                <div class="app-card-body p-3 p-lg-4">
                                    <h4 class="stats-type mb-1" style="color:white;font-weight:900;height:40px;">Total GTV </h4>
                                    <div class="stats-figure" id="gtv" style="color:white;font-weight:900;">{{$dashboard->gtv}} </div>

                                </div>

                                <a class="app-card-link-mask" href="#"></a>
                            </div>
                        </div>
                        <div class="col-6 col-lg-2 mb-4">
                            <div class="app-card app-card-stat shadow-sm h-100" style="background-image: linear-gradient(to right, #43e97b 0%, #38f9d7 100%);">
                                <div class="app-card-body p-3 p-lg-4">
                                    <h4 class="stats-type mb-1" style="color:white;font-weight:900;height:40px;">Amount Refunded</h4>
                                    <div class="stats-figure" id="refund" style="color:white;font-weight:900;">{{ $dashboard->refund}}</div>
                                </div>
                                <a class="app-card-link-mask" href="#"></a>
                            </div>
                        </div>
                        <div class="col-6 col-lg-2 mb-4">
                            <div class="app-card app-card-stat shadow-sm h-100" style="background-image: radial-gradient(circle 248px at center, #16d9e3 0%, #30c7ec 47%, #46aef7 100%);">
                                <div class="app-card-body p-3 p-lg-4">
                                    <h4 class="stats-type mb-1" style="color:white;font-weight:900;height:40px;">Chargeback Amount</h4>
                                    <div class="stats-figure" id="chargeback" style="color:white;font-weight:900;">{{ $dashboard->active_merchant}}</div>
                                </div>
                                <a class="app-card-link-mask" href="#"></a>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4 mb-4 " style="margin-top: 10px;">

                        <div class="col-12 col-lg-12">
                            <div class="card ">
                                <div class="card-body" id="transactionGraph" style="height:450px; ">

                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row g-4 mb-4 " style="margin-top: 10px;">
                        <div class="col-6 col-lg-3" style="margin-bottom: 5px;">
                            <!-- Filter dropdown for selecting a specific merchant -->
                            <label for="merchantFilter">Merchant Name</label>
                            <form method="get" action="{{ route('flakpay-dashboard') }}">
                                <select id="merchantFilter" name="merchant_id" class="form-control" onchange="this.form.submit()">
                                    <option value="">All Merchants</option>
                                    @foreach ($merchants as $merchant)
                                        <option value="{{ $merchant->id }}" {{ $merchant->id == $selectedMerchantId ? 'selected' : '' }}>
                                            {{ $merchant->business_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-10 col-md-12 mbb-4">
                            <div class="card ">
                                <canvas id="successRatioChart" width="800" height="350"></canvas>
                            </div>

                        </div>
                        <div class="col-lg-2 col-md-12">

                            <div class="card ">
                                {{-- <a href="{{ route('excel.export.successratio') }}" class="btn btn-success" style="float: right">
                                    <i class="fa fa-download"></i>
                                </a> --}}
                                <button id="excelButton" class="btn btn-success" title="Download Excel" style="float: right">
                                    <i class="fa fa-download"></i>
                                </button>
                                
                               <table class="">
                                <caption style="text-align: center;">Date : {{ now()->format('d-m-Y') }}</caption>
                                <thead style="white-space: nowrap;">
                                <tr class="time-ratio">
                                    <th>Time</th>
                                    <th>Success Ratio</th>
                                </tr>
                                </thead>
                                <tbody style="white-space: nowrap;">
                                    @foreach($successRatios as $Ratio)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($Ratio->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($Ratio->end_time)->format('H:i') }}</td>

                                        <td style="text-align: center;">{{ $Ratio->success_ratio }}%</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                               </table>
                            </div>
                        </div>
                    </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- </form> --}}
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://unpkg.com/boxicons@2.1.2/dist/boxicons.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="//cdn.amcharts.com/lib/4/core.js"></script>
<script src="//cdn.amcharts.com/lib/4/charts.js"></script>
<script src="//cdn.amcharts.com/lib/4/themes/animated.js"></script>
<script src="//cdn.amcharts.com/lib/4/themes/kelly.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>




<script type="text/javascript">

var ctx = document.getElementById('successRatioChart').getContext('2d');
    var successRatios = @json($successRatios);

    var labels = successRatios.map(function(item) {
    var startTimeFormatted = moment(item.start_time).format('DD-MM-YYYY HH:mm');
    var endTimeFormatted = moment(item.end_time).format('DD-MM-YYYY HH:mm');
    return [startTimeFormatted, endTimeFormatted];
});

    var data = successRatios.map(function(item) {
        // return item.success_ratio;
        return {
        success_ratio: item.success_ratio ,
        success_transactions: item.success_transactions  // Assuming you have a total_success property
    };
    });

    var chart = new Chart(ctx, {
        // type: 'bar',
       
        data: {
            labels: labels,
            datasets: [{
                type: 'bar',
                label: 'Success Ratio',
                data: data.map(item => item.success_ratio ),
                borderColor: 'rgb(75, 192, 192)',
                borderWidth: 1
                // tension: 0.1
            },
            {
                type: 'line',
                label: 'Total Success',
                data: data.map(item => item.success_transactions),
                borderColor: 'rgb(255, 99, 132)',
                // borderWidth: 1
                tension: 0.1
            }
        
        ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });


    $(function() {

        var start = moment().startOf('day');
        var end = moment().endOf('day');

        $('#calendar-icon').on('click', function() {
        $('input[name="datetimes"]').click();
    });

        function cb(start, end) {
            $('input[name="datetimes"] span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            // $('input[name="datetimes"] span').html(start.format('MMMM D, YYYY HH:mm:ss') + ' - ' + end.format('MMMM D, YYYY HH:mm:ss'));

            var merchant = $('#merchantId').val();

            callingapis(start, end, merchantId);
            callinggraphapi(start, end, merchantId)

        }

        $('#excelButton').on('click', function () {
            var selectedMerchantId = $('#merchantFilter').val();
            var excelExportUrl = "{{ route('excel.export.successratio') }}?merchant_id=" + selectedMerchantId;
            window.location.href = excelExportUrl;
        });

        $('input[name="datetimes"]').daterangepicker({
            startDate: start,
            endDate: end,
            // timePicker: true, // Set to true to enable time picker
           
            // timePicker24Hour: true, // Use 24-hour format
            locale: {
                // format: 'DD/MM/YYYY'
                // format: 'MM/DD/YYYY HH:mm:ss'
                format: 'MM/DD/YYYY'
            },
            ranges: {
        'Today': [moment().startOf('day'), moment().endOf('day')],
        'Yesterday': [moment().subtract(1, 'days').startOf('day'), moment().subtract(1, 'days').endOf('day')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);



        function fetchData(startDate, endDate, merchantId) {
        $.ajax({
            url: '/flakpaydashboard/ajax', // Replace with your actual route
            type: 'GET',
            data: {
                start: startDate,
                end: endDate,
                merchantId: merchantId,
                _token: '{{ csrf_token() }}' // Add CSRF token if needed
            },
            success: function(data) {
                // Your success callback logic
                $('#totalTransaction').html(data.transactionStats.total_transaction);
                $('#successfulTransaction').html(data.transactionStats.successful_transaction);
                $('#failedTransaction').html(data.transactionStats.total_collection_amount);
                $('#gtv').html(data.transactionStats.gtv);
                $('#refund').html(data.transactionStats.refund);
                $('#chargeback').html();
            },
            error: function (error) {
                console.error(error);
            }
        });
    }
    var dateRangetoday = $('#datetimes').val();
    $("#selected_date_ranges").val(dateRangetoday);
    // var today = moment().startOf('day').format("MM/DD/YYYY HH:mm:ss");
    // var startOfDay = moment().startOf('day').format("MM/DD/YYYY HH:mm:ss");
    // var endOfDay = moment().endOf('day').format("MM/DD/YYYY HH:mm:ss");
    var startOfDay = moment().startOf('day').format("MM/DD/YYYY");
    var endOfDay = moment().endOf('day').format("MM/DD/YYYY");

    $('#datetimes').val(startOfDay + ' - ' + endOfDay);

    // Fetch data on page load
    var initialDates = $('#datetimes').val().split(' - ');
    var initialMerchantId = $('#merchantId').val();
    fetchData(initialDates[0], initialDates[1], initialMerchantId);

    $('#datetimes , #merchantId').on('change', function() {
        var dateRange = $('#datetimes').val();
        
        // Assuming the date range format is "MM/DD/YYYY - MM/DD/YYYY"
        var dates = dateRange.split(' - ');
        var startDate = dates[0];
        var endDate = dates[1];
        var merchantId = $('#merchantId').val();
        console.log("Start Date: " + startDate);
        console.log("End Date: " + endDate);


        var dateParts = dateRange.split(' - ');

// Extract only the date portion (MM/DD/YYYY)
var startDates = dateParts[0].split(' ')[0];
var endDates = dateParts[1].split(' ')[0];

// Form a new date range string
var newDateRange = startDates + ' - ' + endDates;

        $("#selected_merchant").val(merchantId);
        $("#selected_date_ranges").val(dateRange);

        // Fetch data when the date range changes
        fetchData(startDate, endDate, merchantId);
    });
        // $('#merchantId').on('change', function(event) {
        //     console.log('working');
        //     var merchant = $(this).val();
        //     var startDate = moment($('#datetimes').data('daterangepicker').startDate);
        //     var endDate = moment($('#datetimes').data('daterangepicker').endDate);
        //     // console.log(merchantId, startDate, endDate);


        //     callingapis(start, end, merchantId);
        //     callinggraphapi(start, end, merchantId)

        // });

//     $('#datetimes').on('change', function() {
//     var dateRange = $('#datetimes').val();
    
//     // Assuming the date range format is "MM/DD/YYYY - MM/DD/YYYY"
//     var dates = dateRange.split(' - ');
//     var startDate = dates[0];
//     var endDate = dates[1];

//     console.log("Start Date: " + startDate);
//     console.log("End Date: " + endDate);

//     $.ajax({
//         url: '/flakpaydashboard/ajax', // Replace with your actual route
//         type: 'GET',
//         data: {
//             start: startDate,
//             end: endDate,
//             _token: '{{ csrf_token() }}' // Add CSRF token if needed
//         },
//         success: function(data) {

// // console.log('%cdashboard.blade.php line:183 object', 'color: #007acc;', data);

//             $('#totalTransaction').html(data.transactionStats.total_transaction);
//             $('#successfulTransaction').html(data.transactionStats.successful_transaction);
//             $('#failedTransaction').html(data.transactionStats.failed_transaction);
//             $('#gtv').html(data.transactionStats.gtv);
//             $('#refund').html(data.transactionStats.refund);
//             $('#chargeback').html();

//         },
//         error: function (error) {
//             console.error(error);
//         }
//     });
// });

        $(' #from-time-input, #to-time-input, #merchantId').on('change', function() {
            // var merchant = $(this).val();
            var start = $('#datetimes').data('daterangepicker').startDate;
            var end = $('#datetimes').data('daterangepicker').endDate;
            var fromTimeInput = $('#from-time-input').val();
            var toTimeInput = $('#to-time-input').val();
            var merchant = $('#merchantId').val();

            // Check if any of the values are empty
    if (!fromTimeInput || !toTimeInput || !merchantId) {
        console.log('One or more input fields are empty!');
        return;
    }
            callingapis(start, end, fromTimeInput, toTimeInput, merchantId);
            callinggraphapi(start, end, fromTimeInput, toTimeInput, merchantId);
        });
        // Handle form submission
        // $('#myForm').on('submit', function(event) {
        //         // Prevent the default form submission behavior
        //         event.preventDefault();

        //         // Retrieve values from input fields
        //         var start = $('#datetimes').data('daterangepicker').startDate;
        //         var end = $('#datetimes').data('daterangepicker').endDate;
        //         var fromTimeInput = $('#from-time-input').val();
        //         var toTimeInput = $('#to-time-input').val();
        //         var merchant = $('#merchantId').val();

        //         // Call the functions with the retrieved values as arguments
        //         callingapis(start, end, fromTimeInput, toTimeInput, merchantId);
        //         callinggraphapi(start, end, fromTimeInput, toTimeInput, merchantId);
        //     });

        // Handle change event for time input fields
    $('#from-time-input, #to-time-input').on('change', function() {
        // Retrieve values from input fields
        var fromTimeInput = $('#from-time-input').val();
        var toTimeInput = $('#to-time-input').val();

        // Check if both input fields have valid time values
        if (fromTimeInput && toTimeInput) {
            // Convert time values to milliseconds since midnight
            var fromTimeMs = getTimeInMilliseconds(fromTimeInput);
            var toTimeMs = getTimeInMilliseconds(toTimeInput);

            // Check if 'To' time is before or equal to 'From' time
            if (toTimeMs <= fromTimeMs) {
                alert("The 'To' time must be after the 'From' time.");
                $('#to-time-input').val(''); // Reset the 'To' time value
            }
        }
    });

    // Function to convert time to milliseconds since midnight
    function getTimeInMilliseconds(timeString) {
        var parts = timeString.split(':');
        var hours = parseInt(parts[0], 10);
        var minutes = parseInt(parts[1], 10);
        return (hours * 60 + minutes) * 60 * 1000; // Convert to milliseconds
    }

        function callingapis(start, end, fromTimeInput, toTimeInput, merchantId) {
            var fromTimeInput = $('#from-time-input').val();
        var toTimeInput = $('#to-time-input').val();
        var merchant = $('#merchantId').val();

        console.log('start:', start.format('YYYY-MM-DD'));
        console.log('end:', end.format('YYYY-MM-DD'));
        console.log('from:', fromTimeInput);
        console.log('to:', toTimeInput);
        console.log('merchant:', merchantId);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "GET",
                dataType: "json",
                data: {   
                    'start': start.format('YYYY-MM-DD'),
                    'end': end.format('YYYY-MM-DD'),
                    'fromTimeInput': fromTimeInput, 
                    'toTimeInput': toTimeInput,
                    'merchant': merchantId
                    

                },
                url: '/flakpay/dashboard_transactionstats',
                success: function(data) {

                    // console.log('%cdashboard.blade.php line:183 object', 'color: #007acc;', data);

                    // $('#totalTransaction').html(data.transactionStats.total_transaction);
                    // $('#successfulTransaction').html(data.transactionStats.successful_transaction);
                    // $('#failedTransaction').html(data.transactionStats.failed_transaction);
                    // $('#gtv').html(data.transactionStats.gtv);
                    // $('#refund').html(data.transactionStats.refund);
                    // $('#chargeback').html();

                }
            });   
        }
        


        function callinggraphapi(start, end, fromTimeInput, toTimeInput, merchantId) {
            //graph
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "GET",
                dataType: "json",
                data: {
                    'start': start.format('YYYY-MM-DD'),
                    'end': end.format('YYYY-MM-DD'),
                    'merchant': merchantId

                },
                url: '/flakpay/dashboardGraphData',
                success: function(data) {
                    // console.log(data);

                    //graph 1 transaction start
                    var currency_symbol = "₹";

                    function dashborad_summary_amchartgraph() {

                        // Apply chart themes
                        am4core.useTheme(am4themes_animated);
                        //am4core.useTheme(am4themes_kelly);

                        // Create chart instance
                        var gtv_chart = am4core.create("transactionGraph", am4charts.XYChart);

                        // set scrollbar for x-axes date range
                        gtv_chart.scrollbarX = new am4core.Scrollbar();

                        // setting data for the gtv and tran count chart


                        gtv_chart.data = data;




                        // Legend for the gtv and tran count in the chart
                        gtv_chart.legend = new am4charts.Legend();
                        gtv_chart.legend.useDefaultMarker = true;
                        var marker = gtv_chart.legend.markers.template.children.getIndex(0);
                        marker.cornerRadius(5, 5, 5, 5);
                        marker.strokeWidth = 2;
                        marker.strokeOpacity = 1;

                        // x-axes date format
                        var gtv_dateAxis = gtv_chart.xAxes.push(new am4charts.DateAxis());
                        gtv_dateAxis.dataFields.category = "gtv_date";
                        gtv_dateAxis.dateFormats.setKey("day", "dd-MM-yyyy");

                        // creating value axis and its configuration for gtv

                        var gtv_valueAxis = gtv_chart.yAxes.push(new am4charts.ValueAxis());

                        // gtv_valueAxis.unit = "Rs.";
                        // gtv_valueAxis.unitPosition = "left";
                        gtv_valueAxis.min = 0;
                        gtv_valueAxis.numberFormatter = new am4core.NumberFormatter();
                        gtv_valueAxis.numberFormatter.numberFormat = "#,##,###a";

                        // Set up axis title
                        gtv_valueAxis.title.text = "GTV Amount (" + currency_symbol + ")";

                        // Create gtv series and its configuration
                        var gtv_series = gtv_chart.series.push(new am4charts.ColumnSeries());
                        gtv_series.dataFields.dateX = "gtv_date";
                        gtv_series.dataFields.valueY = "gtv_amount";
                        gtv_series.name = "Gross Transaction Value";

                        // Tooltip for the gtv series
                        gtv_series.tooltipHTML = `GTV Value : {gtv_amount}`;
                        gtv_series.columns.template.strokeWidth = 0;
                        gtv_series.tooltip.pointerOrientation = "vertical";
                        gtv_series.tooltip.numberFormatter.numberFormat = "#,##,###";

                        // The gtv bar chart radius
                        gtv_series.columns.template.column.cornerRadiusTopLeft = 10;
                        gtv_series.columns.template.column.cornerRadiusTopRight = 10;
                        gtv_series.columns.template.column.fillOpacity = 0.8;

                        gtv_series.yAxis = gtv_valueAxis;

                        // creating value axis and its configuration for transaction count
                        var tran_valueAxis = gtv_chart.yAxes.push(new am4charts.ValueAxis());

                        // setting min value for tran count axes
                        tran_valueAxis.min = 0;
                        // tran_valueAxis.strictMinMax=true;

                        // setting number format for transaction count axes
                        tran_valueAxis.numberFormatter = new am4core.NumberFormatter();
                        tran_valueAxis.numberFormatter.numberFormat = "#,###";

                        // Set up axis title for transaction count value axis
                        tran_valueAxis.title.text = "Count";

                        // Showing value count y-axes on the right side of the chart
                        tran_valueAxis.renderer.opposite = true;

                        // Create series and its configuration for transaction count
                        var tran_count_series = gtv_chart.series.push(new am4charts.LineSeries());
                        tran_count_series.dataFields.dateX = "gtv_date";
                        tran_count_series.dataFields.valueY = "tran_count";
                        tran_count_series.name = "Transaction Count";

                        // setting colour for line graph
                        tran_count_series.propertyFields.stroke = "line_colour";
                        tran_count_series.propertyFields.fill = "line_colour";

                        // Tooltip for the transaction count series
                        tran_count_series.tooltipText = "Transaction Count : {tran_count}";
                        tran_count_series.strokeWidth = 2;
                        tran_count_series.propertyFields.strokeDasharray = "dashLength";
                        tran_count_series.yAxis = tran_valueAxis;

                        // circular bullet
                        var circleBullet = tran_count_series.bullets.push(
                            new am4charts.CircleBullet()
                        );
                        circleBullet.circle.radius = 7;
                        circleBullet.circle.stroke = am4core.color("#fff");
                        circleBullet.circle.strokeWidth = 3;

                        // rectangular bullet on hover on tran count series
                        var durationBullet = tran_count_series.bullets.push(new am4charts.Bullet());
                        var durationRectangle = durationBullet.createChild(am4core.Rectangle);
                        durationBullet.horizontalCenter = "middle";
                        durationBullet.verticalCenter = "middle";
                        durationBullet.width = 7;
                        durationBullet.height = 7;
                        durationRectangle.width = 7;
                        durationRectangle.height = 7;

                        var durationState = durationBullet.states.create("hover");
                        durationState.properties.scale = 1.2;

                        // remove cornaer radiuses of bar chart on hover
                        var hoverState = gtv_series.columns.template.column.states.create("hover");
                        hoverState.properties.cornerRadiusTopLeft = 0;
                        hoverState.properties.cornerRadiusTopRight = 0;
                        hoverState.properties.fillOpacity = 1;

                        // setting random colour for bar chart
                        gtv_series.columns.template.adapter.add("fill", function(fill, target) {
                            return gtv_chart.colors.getIndex(target.dataItem.index);
                        });

                        // Cursor
                        gtv_chart.cursor = new am4charts.XYCursor();

                        //  gtv_chart.dispose();
                    }

                    dashborad_summary_amchartgraph();
                    //graph 1 end


                }
            });
        }

    });


    // document.addEventListener('DOMContentLoaded', function() {
    //     var successfulTransactionCard = document.getElementById('successfulTransactionCard');

    //     successfulTransactionCard.addEventListener('click', function(event) {
    //         event.preventDefault(); // Prevent the default action (i.e., following the link)

    //         // Make AJAX call
    //         var xhr = new XMLHttpRequest();
    //         var url = '/flakpay/settlement/get-all-transactions?status=success'; // Include status parameter with value 'success'
    //         xhr.open('POST', url, true);

    //         xhr.onload = function() {
    //             if (xhr.status >= 200 && xhr.status < 300) {
    //                 // Handle successful response
    //                 console.log('test',xhr.responseText);

                    
    //             //     var settleTransactionsForm = document.getElementById('paginate_alltransaction');
    //             // if (settleTransactionsForm) {
    //             //     // Clear the div before binding new data
    //             //     settleTransactionsForm.innerHTML = '';
    //             //     // Bind the new data
    //             //     settleTransactionsForm.innerHTML = xhr.responseText;
    //             // } else {
    //             //     console.error("Element with id 'paginate_alltransaction' not found");
    //             // }
    //                 // Redirect the user to a different URL
    //                 // window.location.href = 'merchant/transactions/ryapay-Ma42px1Z';

    //             } else {
    //                 // Handle error
    //                 console.error(xhr.statusText);
    //             }
    //         };

    //         xhr.onerror = function() {
    //             // Handle network errors
    //             console.error('Network error');
    //         };

    //         xhr.send();
    //     });
    // });

    
</script>
@endsection