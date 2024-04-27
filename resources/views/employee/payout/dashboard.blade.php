@php
$vendor_banks = App\RyapayVendorBank::get_vendorbank();
@endphp
@extends('layouts.employeecontent')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<style>
    .card {
        background-color: #fff;
        border-radius: 10px;
        border: #f78ca0 1px solid;
        padding: 10px 5px 10px 5px;
    }
</style>
@section('employeecontent')

<div class="row">
  <div class="col-sm-12 padding-20">
    <div class="panel panel-default">
      <div class="panel-heading">
        <ul class="nav nav-tabs" id="transaction-tabs">
          <li class="active"><a data-toggle="tab" class="show-cursor" data-target="#dashboard">Dashboard</a></li>
        </ul>
      </div>
      <div class="panel-body">
        <div class="tab-content">
          <div id="dashboard" class="tab-pane fade in active">
            <div>
              <div class="row g-4 mb-4">
                <div class="col-6 col-lg-6 mb-4">
                  <input type="text" name="datetimes" id="datetimes" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%" />
                </div>
                <div class="col-6 col-lg-6 mb-4">
                  <select name="merchant_id" class="form-control" id="merchant_id">
                    <option value="all">All</option>
                    @foreach ($merchants as $merchant)
                    <option value="{{$merchant->id}}">{{$merchant->name}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="row g-4 mb-4">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3 mb-4">
                  <div class="app-card app-card-stat shadow-sm h-100" style="background-image: linear-gradient(to right, #f78ca0 0%, #f9748f 19%, #fd868c 60%, #fe9a8b 100%);">
                    <div class="app-card-body p-3 p-lg-4">
                      <h4 class="stats-type mb-1" style="color:white;font-weight:900;height:40px;">Total Transactions</h4>
                      <div class="stats-figure" id="totalTransaction" style="color:white;font-weight:900;"></div>
                    </div>
                    <a class="app-card-link-mask" href="#"></a>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3 mb-4">
                  <div class="app-card app-card-stat shadow-sm h-100" style="background-image: linear-gradient(-20deg, #fc6076 0%, #ff9a44 100%);">
                    <div class="app-card-body p-3 p-lg-4">
                      <h4 class="stats-type mb-1" style="color:white;font-weight:900;height:40px;">Total Success Transactions</h4>
                      <div class="stats-figure" id="successfulTransaction" style="color:white;font-weight:900;"></div>
                    </div>
                    <a class="app-card-link-mask" href="#"></a>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3 mb-4">
                  <div class="app-card app-card-stat shadow-sm h-100" style=" background-image: linear-gradient(-225deg, #B7F8DB 0%, #50A7C2 100%);">
                    <div class="app-card-body p-3 p-lg-4">
                      <h4 class="stats-type mb-1" style="color:white;font-weight:900;height:40px;">Total Failed Transactions</h4>
                      <div class="stats-figure" id="failedTransaction" style="color:white;font-weight:900;"></div>
                    </div>
                    <a class="app-card-link-mask" href="#"></a>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3 mb-4">
                  <div class="app-card app-card-stat shadow-sm h-100" style="background-image: linear-gradient(to top, #0ba360 0%, #3cba92 100%);">
                    <div class="app-card-body p-3 p-lg-4">
                      <h4 class="stats-type mb-1" style="color:white;font-weight:900;height:40px;">Total Amount Transactions</h4>
                      <div class="stats-figure" id="totalAmount" style="color:white;font-weight:900;"></div>
                    </div>
                    <a class="app-card-link-mask" href="#"></a>
                  </div>
                </div>
              </div>
            </div>
            <div id="chartdiv"></div>
            <div class="row">
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-body" id="transactionGraph" style="height:450px;">
                  </div>
                </div>
              </div>
              <div class="col-sm-12 p-0" style="margin-top:20px; margin-bottom:30px;">
                <div class="row">
                  <div class="col-sm-6 mb-4">
                    <div class="card">
                      <div class="card-body" id="graph-4">
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6 mb-4">
                    <div class="card">
                      <div class="card-body" id="graph-6">
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
</div>


<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js" charset="utf-8"></script>

<script src="//cdn.amcharts.com/lib/4/core.js"></script>
<script src="//cdn.amcharts.com/lib/4/charts.js"></script>
<script src="//cdn.amcharts.com/lib/4/themes/animated.js"></script>
<script src="//cdn.amcharts.com/lib/4/themes/kelly.js"></script>



<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

<script>
    $(function() {
        $('input[name="datetimes"]').daterangepicker({
            opens: 'left',
            startDate: moment().add(30, 'day'),
            minDate: moment(),
            Locale: {
                format: 'DD/MM/YYYY'
            }

        }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            var start = start.format('YYYY-MM-DD');
            var end = end.format('YYYY-MM-DD');
            var merchantId = $('#merchant_id').val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "GET",
                dataType: "json",
                data: {
                    'start': start,
                    'end': end,
                    'merchantId': merchantId
                },
                url: '/flakpay/payout_dashboard_transactionstats',
                success: function(data) {
                    console.log(data);

                    $('#totalTransaction').html(data.transactionStats.total_transaction);
                    $('#successfulTransaction').html(data.transactionStats.successful_transaction);
                    $('#failedTransaction').html(data.transactionStats.failed_transaction);
                    $('#totalAmount').html(data.transactionStats.successful_tamount);

                }
            });
        });
    });
</script>


<script type="text/javascript">
    $(function() {

        var start = moment().subtract(30, 'days');
        var end = moment();

        function cb(start, end) {
            $('input[name="datetimes"] span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            var merchantId = $('#merchant_id').val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "GET",
                dataType: "json",
                data: {
                    'start': start.format('YYYY-MM-DD'),
                    'end': end.format('YYYY-MM-DD'),
                    'merchantId': merchantId

                },
                url: '/flakpay/payout_dashboard_transactionstats',
                success: function(data) {
                    console.log(data);

                    $('#totalTransaction').html(data.transactionStats.total_transaction);
                    $('#successfulTransaction').html(data.transactionStats.successful_transaction);
                    $('#failedTransaction').html(data.transactionStats.failed_transaction);
                    $('#totalAmount').html(data.transactionStats.successful_tamount);

                }
            });

            //graph
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "GET",
                dataType: "json",
                url: '/flakpay/payout_dashboard_graph',
                data: {
                    'start': start.format('YYYY-MM-DD'),
                    'end': end.format('YYYY-MM-DD'),
                    'merchantId': merchantId
                },
                success: function(data) {
                    console.log(data);
                   //graph 1 transaction start
                   var transactionData = data.graphData.transaction;
                
                console.log('%cdashboard.blade.php line:415 object', 'color: #007acc;', transactionData);

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


                    gtv_chart.data = transactionData;

                   
              

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
                    //endgraph1

                    //graph2start
                    vendorLabels = data.graphData.vendorList;
                    vendorData = data.graphData.vendorCount;

                    $("#graph-4").html('<canvas id="myChart4" width="400" height="400"></canvas>');

                    var ctx1 = document.getElementById("myChart4").getContext('2d');

                    var myChart = new Chart(ctx1, {
                        type: 'doughnut',
                        data: {
                            labels: vendorLabels,
                            datasets: [{
                                backgroundColor: [
                                    '#ff9a44',
                                    '#fc6076',
                                    '#0ba360',
                                    '#E9967A',
                                    '#DA70D6',
                                    '#8B4513',
                                    '#7FFF00',
                                    '#696969',
                                    '#5F9EA0',
                                    '#F4A460',
                                    '#D8BFD8',
                                    '#CD5C5C',
                                    '#00cdac',
                                    '#0093E9',
                                    '#ED9E11'

                                ],
                                data: vendorData
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                        }
                    });
                    //graph2end



                    //graph3start
                    paymentLabels = data.graphData.pmodeHeaders;
                    paymentData = data.graphData.pmodeData;


                    $("#graph-6").html('<canvas id="myChart6" width="400" height="400"></canvas>');

                    var ctx2 = document.getElementById("myChart6").getContext('2d');

                    var myChart = new Chart(ctx2, {
                        type: 'doughnut',
                        data: {
                            labels: paymentLabels,
                            datasets: [{
                                backgroundColor: [
                                    '#ff9a44',
                                    '#fc6076',
                                    '#0ba360',
                                    '#E9967A',
                                    '#DA70D6',
                                    '#8B4513',
                                    '#7FFF00',
                                    '#696969',
                                    '#5F9EA0',
                                    '#F4A460',
                                    '#D8BFD8',
                                    '#CD5C5C',
                                    '#00cdac',
                                    '#0093E9',
                                    '#ED9E11'

                                ],
                                data: paymentData
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                        }
                    });
                    //graph3end

                }
            });
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
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);


    });
</script>


<!-- //graph doughnutbar -->

<script>
    $('#merchant_id').on('change', function(event) {
        console.log('working');
        var merchantId = $(this).val();
        var startDate = moment($('#datetimes').data('daterangepicker').startDate).format('YYYY-MM-DD');
        var endDate = moment($('#datetimes').data('daterangepicker').endDate).format('YYYY-MM-DD');
        console.log(merchantId, startDate, endDate);

        //transctionstats
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            dataType: "json",
            data: {
                'start': startDate,
                'end': endDate,
                'merchantId': merchantId

            },
            url: '/flakpay/payout_dashboard_transactionstats',
            success: function(data) {
                console.log(data);

                $('#totalTransaction').html(data.transactionStats.total_transaction);
                $('#successfulTransaction').html(data.transactionStats.successful_transaction);
                $('#failedTransaction').html(data.transactionStats.failed_transaction);
                $('#totalAmount').html(data.transactionStats.successful_tamount);

            }
        });
        //endtransctionstats

        //graph
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            dataType: "json",
            url: '/flakpay/payout_dashboard_graph',
            data: {
                'start': startDate,
                'end': endDate,
                'merchantId': merchantId
            },
            success: function(data) {
                console.log('%cdashboard.blade.php line:413 object', 'color: #007acc;', data.graphData.transaction);
                var transactionData = data.graphData.transaction;
                
                console.log('%cdashboard.blade.php line:415 object', 'color: #007acc;', transactionData);

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


                    gtv_chart.data = transactionData;

                   
              

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


                //graph 2
                vendorLabels = data.graphData.vendorList;
                vendorData = data.graphData.vendorCount;

                console.log(vendorLabels, vendorData);
                $("#graph-4").html('<canvas id="myChart4" width="400" height="400"></canvas>');

                var ctx1 = document.getElementById("myChart4").getContext('2d');

                var myChart = new Chart(ctx1, {
                    type: 'doughnut',
                    data: {
                        labels: vendorLabels,
                        datasets: [{
                            backgroundColor: [
                                '#ff9a44',
                                '#fc6076',
                                '#0ba360',
                                '#E9967A',
                                '#DA70D6',
                                '#8B4513',
                                '#7FFF00',
                                '#696969',
                                '#5F9EA0',
                                '#F4A460',
                                '#D8BFD8',
                                '#CD5C5C',
                                '#00cdac',
                                '#0093E9',
                                '#ED9E11'

                            ],
                            data: vendorData
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                    }
                });


                //graph3start
                paymentLabels = data.graphData.pmodeHeaders;
                paymentData = data.graphData.pmodeData;


                $("#graph-6").html('<canvas id="myChart6" width="400" height="400"></canvas>');

                var ctx2 = document.getElementById("myChart6").getContext('2d');

                var myChart = new Chart(ctx2, {
                    type: 'doughnut',
                    data: {
                        labels: paymentLabels,
                        datasets: [{
                            backgroundColor: [
                                '#ff9a44',
                                '#fc6076',
                                '#0ba360',
                                '#E9967A',
                                '#DA70D6',
                                '#8B4513',
                                '#7FFF00',
                                '#696969',
                                '#5F9EA0',
                                '#F4A460',
                                '#D8BFD8',
                                '#CD5C5C',
                                '#00cdac',
                                '#0093E9',
                                '#ED9E11'

                            ],
                            data: paymentData
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                    }
                });
                //graph3end

            }
        });

        //endgraph




    })
</script>


@endsection