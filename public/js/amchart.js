var payment_mode_chart;
var device_chart;
var currency_code = "INR";
var currency_symbol = "₹";

function indianNumberFormat(number, type, currency_code) {
  if (type == "currency") {
    return parseFloat(number).toLocaleString("en-IN", {
      style: type,
      currency: currency_code,
      currencyDisplay: "symbol",
    });
  } else {
    return parseInt(number).toLocaleString("en-IN", {
      style: type,
    });
  }
}

function dashborad_summary_amchartgraph(json_data) {
  json_data = json_data.bar_line_graph;
  // Apply chart themes
  am4core.useTheme(am4themes_animated);
  //am4core.useTheme(am4themes_kelly);

  // Create chart instance
  var gtv_chart = am4core.create("gtvGraph", am4charts.XYChart);

  // set scrollbar for x-axes date range
  gtv_chart.scrollbarX = new am4core.Scrollbar();

  // setting data for the gtv and tran count chart

  gtv_data = [];

  $.each(json_data, function (key, value) {
    date = value.gtv_date;
    date_array = date.split("-");
    date_obj = new Date(date_array[0], date_array[1] - 1, date_array[2]);
    gtv_data.push({
      gtv_date: date_obj,
      gtv_amount: indianNumberFormat(
        value.gtv_amount,
        "currency",
        currency_code
      ),
      tran_count: indianNumberFormat(value.tran_count, "decimal", null),
      line_colour: value.line_colour,
    });
  });

  gtv_chart.data = gtv_data;

  //console.log(gtv_data);

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
  gtv_series.columns.template.adapter.add("fill", function (fill, target) {
    return gtv_chart.colors.getIndex(target.dataItem.index);
  });

  // Cursor
  gtv_chart.cursor = new am4charts.XYCursor();

  //  gtv_chart.dispose();
}


function dashborad_payout_amchartgraph(json_data) {
  json_data = json_data.bar_line_graph;
  // Apply chart themes
  am4core.useTheme(am4themes_animated);
  //am4core.useTheme(am4themes_kelly);

  // Create chart instance
  var gtv_chart = am4core.create("gtvGraph", am4charts.XYChart);

  // set scrollbar for x-axes date range
  gtv_chart.scrollbarX = new am4core.Scrollbar();

  // setting data for the gtv and tran count chart

  gtv_data = [];

  $.each(json_data, function (key, value) {
    date = value.gtv_date;
    date_array = date.split("-");
    date_obj = new Date(date_array[0], date_array[1] - 1, date_array[2]);
    gtv_data.push({
      gtv_date: date_obj,
      gtv_amount: indianNumberFormat(
        value.gtv_amount,
        "currency",
        currency_code
      ),
      tran_count: indianNumberFormat(value.tran_count, "decimal", null),
      line_colour: value.line_colour,
    });
  });

  gtv_chart.data = gtv_data;

  //console.log(gtv_data);

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
  gtv_valueAxis.title.text = "Payout Amount (" + currency_symbol + ")";

  // Create gtv series and its configuration
  var gtv_series = gtv_chart.series.push(new am4charts.ColumnSeries());
  gtv_series.dataFields.dateX = "gtv_date";
  gtv_series.dataFields.valueY = "gtv_amount";
  gtv_series.name = "Gross Transaction Value";

  // Tooltip for the gtv series
  gtv_series.tooltipHTML = `Payout Value : {gtv_amount}`;
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
  tran_count_series.name = "Payout Count";

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
  gtv_series.columns.template.adapter.add("fill", function (fill, target) {
    return gtv_chart.colors.getIndex(target.dataItem.index);
  });

  // Cursor
  gtv_chart.cursor = new am4charts.XYCursor();

  //  gtv_chart.dispose();
}
