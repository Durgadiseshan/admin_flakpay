var months = [
    'january',
    'febraury',
    'march',
    'april',
    'may',
    'june',
    'july',
    'august',
    'september',
    'october',
    'november',
    'december'
];
var colors = [
    '#FFFFFF',
    '#FFFFF0',
    '#FFFFE0',
    '#FFFF00',
    '#FFFAFA',
    '#FFFAF0',
    '#FFFACD',
    '#FFF8DC',
    '#FFF5EE',
    '#FFF0F5',
    '#FFEFD5',
    '#FFEBCD',
    '#FFE4E1',
    '#FFE4C4',
    '#FFE4B5',
    '#FFDEAD',
    '#FFDAB9',
    '#FFD700',
    '#FFC0CB',
    '#FFB6C1',
    '#FFA500',
    '#FFA07A',
    '#FF8C00',
    '#FF7F50',
    '#FF69B4',
    '#FF6347',
    '#FF4500',
    '#FF1493',
    '#FF00FF',
    '#FF00FF',
    '#FF0000',
    '#FDF5E6',
    '#FAFAD2',
    '#FAF0E6',
    '#FAEBD7',
    '#FA8072',
    '#F8F8FF',
    '#F5FFFA',
    '#F5F5F5',
    '#F5F5DC',
    '#F5DEB3',
    '#F4A460',
    '#F0FFFF',
    '#F0FFF0',
    '#F0F8FF',
    '#F0E68C',
    '#F08080',
    '#EEE8AA',
    '#EE82EE',
    '#E9967A',
    '#E6E6FA',
    '#E0FFFF',
    '#DEB887',
    '#DDA0DD',
    '#DCDCDC',
    '#DC143C',
    '#DB7093',
    '#DAA520',
    '#DA70D6',
    '#D8BFD8',
    '#D3D3D3',
    '#D2B48C',
    '#D2691E',
    '#CD853F',
    '#CD5C5C',
    '#C71585',
    '#C0C0C0',
    '#BDB76B',
    '#BC8F8F',
    '#BA55D3',
    '#B8860B',
    '#B22222',
    '#B0E0E6',
    '#B0C4DE',
    '#AFEEEE',
    '#ADFF2F',
    '#ADD8E6',
    '#A9A9A9',
    '#A52A2A',
    '#A0522D',
    '#9ACD32',
    '#9932CC',
    '#98FB98',
    '#9400D3',
    '#9370DB',
    '#90EE90',
    '#8FBC8F',
    '#8B4513',
    '#8B008B',
    '#8B0000',
    '#8A2BE2',
    '#87CEFA',
    '#87CEEB',
    '#808080',
    '#808000',
    '#800080',
    '#800000',
    '#7FFFD4',
    '#7FFF00',
    '#7CFC00',
    '#7B68EE',
    '#778899',
    '#708090',
    '#6B8E23',
    '#6A5ACD',
    '#696969',
    '#66CDAA',
    '#6495ED',
    '#5F9EA0',
    '#556B2F',
    '#4B0082',
    '#48D1CC',
    '#483D8B',
    '#4682B4',
    '#4169E1',
    '#40E0D0',
    '#3CB371',
    '#32CD32',
    '#2F4F4F',
    '#2E8B57',
    '#228B22',
    '#20B2AA',
    '#1E90FF',
    '#191970',
    '#00FFFF',
    '#00FFFF',
    '#00FF7F',
    '#00FF00',
    '#00FA9A',
    '#00CED1',
    '#00BFFF',
    '#008B8B',
    '#008080',
    '#008000',
    '#006400',
    '#0000FF',
    '#0000CD',
    '#00008B',
    '#000080',
    '#000000'
];



var loaldedLabels = [];
var loadedData = [];
var noOfPaymentsLabels = [];
var noOfPaymentsData = []
var noOfSettlementLabels = [];
var noOfSettlementData = [];
var successLabels = [];
var successData = [];
var paymentmodeLabels = [];
var paymentmodeData = [];



var date = new Date();
var completedMonths = [];
var month = date.getMonth();

var completedDays = [];

for (let index = 0; index <= month; index++) {
    completedMonths[index] = months[index];
}
for (let index = 1; index <= date.getDay(); index++) {
    completedDays[index] = months[date.getMonth()] + " " + index;
}

function loadPieChart(graphtype) {

    if (myChart) {
        myChart.destroy();
    }

    if (graphtype == 1) {
        graphName = 'Transaction Amount Per Month';
        loadLabels = loaldedLabels;
        loadData = loadedData;
        $("#dashboar_graph").val(graphtype);

    } else if (graphtype == 2) {

        loadLabels = noOfPaymentsLabels;
        loadData = noOfPaymentsData;
        $("#dashboar_graph").val(graphtype);

    } else {
        loadLabels = noOfSettlementLabels;
        loadData = noOfSettlementData;
        $("#dashboar_graph").val(graphtype);
    }

    if (loadLabels.length > 0) {
        $("#graph-1").html('<canvas id="myChart1" width="400" height="400"></canvas> ');
        var ctx = document.getElementById("myChart1").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: loadLabels,
                datasets: [{
                    label: graphName,
                    backgroundColor: [
                        '#DA70D6',
                        '#8B4513',
                        '#7FFF00',
                        '#696969',
                        "#2ecc71",
                        "#3498db",
                        "#95a5a6",
                        "#9b59b6",
                        "#f1c40f",
                        "#e74c3c",
                        "#34495e",
                        '#7FFF00',
                    ],
                    data: loadData
                }]
            }, options: {
                responsive: false,
                maintainAspectRatio: false,
            }

        });
    } else {
        $("#graph-1").html("<div><h4>No data available.</h4><p>Tip: You could try again by selecting a different filter or date range.</p></div>");
    }



}


function noOfPayments(graphdata) {
    if (myChart) {
        myChart.destroy();
    }
    console.log(123);
    loaldedLabels = [];
    loadedData = [];

    noOfPaymentsLabels = [];
    noOfPaymentsData = [];

    noOfSettlementLabels = [];
    noOfSettlementData = [];


    if (graphdata.payment_amount.length > 0) {

        $.each(graphdata.payment_amount, function (indexInArray, valueOfElement) {
            loaldedLabels.push(valueOfElement.month);
            loadedData.push(valueOfElement.amount);
        });

        $("#graph-2").html('<canvas id="myChart2" width="400" height="400"></canvas>');
        var ctx = document.getElementById('myChart2').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: loaldedLabels,
                datasets: [{
                    label: 'Transaction Amount Per Month',
                    data: loadedData,
                    backgroundColor: [
                        '#F4A460',
                        '#FFA500',
                        '#E9967A',
                        '#DA70D6',
                        '#D8BFD8',
                        '#CD5C5C',
                        '#A52A2A',
                        '#9932CC',
                        '#8B4513',
                        '#7FFF00',
                        '#696969',
                        '#5F9EA0',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: false,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    } else {
        $("#graph-2").html("<div><h4>No data available.</h4><p>Tip: You could try again by selecting a different filter or date range.</p></div>");
    }

    if (graphdata.payment_number.length > 0) {
        $.each(graphdata.payment_number, function (indexInArray, valueOfElement) {
            noOfPaymentsLabels.push(valueOfElement.month);
            noOfPaymentsData.push(valueOfElement.no_of_transactions);
        });

        $("#graph-3").html('<canvas id="myChart3" width="400" height="400"></canvas>');

        var ctx = document.getElementById('myChart3').getContext('2d');

        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: noOfPaymentsLabels,
                datasets: [{
                    label: 'No Of Transaction Per Month',
                    data: noOfPaymentsData,
                    backgroundColor: [
                        '#F4A460',
                        '#FFA500',
                        '#E9967A',
                        '#DA70D6',
                        '#D8BFD8',
                        '#CD5C5C',
                        '#A52A2A',
                        '#9932CC',
                        '#8B4513',
                        '#7FFF00',
                        '#696969',
                        '#5F9EA0',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 159, 64, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: false,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    } else {
        $("#graph-3").html("<div><h4>No data available.</h4><p>Tip: You could try again by selecting a different filter or date range.</p></div>");
    }


    if (graphdata.settlement_number.length > 0) {
        $.each(graphdata.settlement_number, function (indexInArray, valueOfElement) {
            noOfSettlementLabels.push(valueOfElement.month);
            noOfSettlementData.push(valueOfElement.no_of_settlements);
        });


        $("#graph-4").html('<canvas id="myChart4" width="400" height="400"></canvas>');

        var ctx = document.getElementById("myChart4").getContext('2d');

        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: noOfSettlementLabels,
                datasets: [{
                    backgroundColor: [
                        '#A52A2A',
                        '#9932CC',
                        '#FFA500',
                        '#E9967A',
                        '#DA70D6',
                        '#8B4513',
                        '#7FFF00',
                        '#696969',
                        '#5F9EA0',
                        '#F4A460',
                        '#D8BFD8',
                        '#CD5C5C',

                    ],
                    data: noOfSettlementData
                }]
            }, options: {
                responsive: false,
                maintainAspectRatio: false,
            }
        });
    } else {
        $("#graph-4").html("<div><h4>No data available.</h4><p>Tip: You could try again by selecting a different filter or date range.</p></div>");
    }


    if (graphdata.success_rate.length > 0) {
        successLabels = [];
        successData = [];

        $.each(graphdata.success_rate, function (indexInArray, valueOfElement) {
            successLabels.push(valueOfElement.transaction_status);
            successData.push(valueOfElement.total);
        });


        $("#graph-5").html('<canvas id="myChart5" width="400" height="400"></canvas>');

        var ctx = document.getElementById("myChart5").getContext('2d');

        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: successLabels,
                datasets: [{
                    backgroundColor: [
                        '#A52A2A',
                        '#9932CC',
                        '#FFA500',
                        '#E9967A',
                        '#DA70D6',
                        '#8B4513',
                        '#7FFF00',
                        '#696969',
                        '#5F9EA0',
                        '#F4A460',
                        '#D8BFD8',
                        '#CD5C5C',

                    ],
                    data: successData
                }]
            }, options: {
                responsive: false,
                maintainAspectRatio: false,
            }
        });
    } else {
        $("#graph-5").html("<div><h4>No data available.</h4><p>Tip: You could try again by selecting a different filter or date range.</p></div>");
    }

    if (graphdata.payment_mode.length > 0) {

        paymentmodeLabels = [];
        paymentmodeData = [];
        $.each(graphdata.payment_mode, function (indexInArray, valueOfElement) {
            paymentmodeLabels.push(valueOfElement.transaction_mode);
            paymentmodeData.push(valueOfElement.total);
        });


        $("#graph-6").html('<canvas id="myChart6" width="400" height="400"></canvas>');

        var ctx = document.getElementById("myChart6").getContext('2d');

        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: paymentmodeLabels,
                datasets: [{
                    backgroundColor: [
                        '#A52A2A',
                        '#9932CC',
                        '#FFA500',
                        '#E9967A',
                        '#DA70D6',
                        '#8B4513',
                        '#7FFF00',
                        '#696969',
                        '#5F9EA0',
                        '#F4A460',
                        '#D8BFD8',
                        '#CD5C5C',

                    ],
                    data: paymentmodeData
                }]
            }, options: {
                responsive: false,
                maintainAspectRatio: false,
            }
        });
    } else {
        $("#graph-6").html("<div><h4>No data available.</h4><p>Tip: You could try again by selecting a different filter or date range.</p></div>");
    }

    loadPieChart(1);

}


function dashborad_summary_graph(graphdata) {
    if (graphdata.payment_mode.length > 0) {

        paymentmodeLabels = [];
        paymentmodeData = [];
        $.each(graphdata.payment_mode, function (indexInArray, valueOfElement) {
            paymentmodeLabels.push(valueOfElement.transaction_mode);
            paymentmodeData.push(valueOfElement.total);
        });

        var options = {
            responsive: true,
   
  tooltips: {
    enabled: false
  },
  plugins: {
    legend: {
        position: 'top',
      },
      title: {
        display: true,
        text: 'Payments Mode Distribution'
      },
    datalabels: {
      formatter: (value, ctx) => {
        const datapoints = ctx.chart.data.datasets[0].data
         const total = datapoints.reduce((total, datapoint) => total + datapoint, 0)
        const percentage = value / total * 100
        return percentage.toFixed(2) + "%";
      },
      color: '#fff',
    }
  }
};

       
        $("#graph-summary-2").html('<canvas id="graph_summary_2" width="400" height="400"></canvas>');

        var ctx = document.getElementById("graph_summary_2").getContext('2d');

        var myChart = new Chart(ctx, {
            type: 'pie',
            
            data: {
                labels: paymentmodeLabels,
                datasets: [{
                    backgroundColor: [
                        '#A52A2A',
                        '#9932CC',
                        '#FFA500',
                        '#E9967A',
                        '#DA70D6',
                        '#8B4513',
                        '#7FFF00',
                        '#696969',
                        '#5F9EA0',
                        '#F4A460',
                        '#D8BFD8',
                        '#CD5C5C',

                    ],
                    data: paymentmodeData
                }]
            }, options: options,
            plugins: [ChartDataLabels],
        });
    } else {
        $("#graph-summary-2").html("<div><h4>No data available.</h4><p>Tip: You could try again by selecting a different filter or date range.</p></div>");
    }

     

  

      var successLabels = [];
      var successData = [];
      var lineData = [];

       $.each(graphdata.bar_line_graph, function (key, value) {
            successLabels.push(value.gtv_date);
            successData.push(value.gtv_amount);
            lineData.push(value.tran_count);
       });

     $("#graph-summary-1").html('<canvas id="graph_summary_1" width="1000" height="400"></canvas>');

     var ctx = document.getElementById("graph_summary_1").getContext('2d');

   var chart = new Chart(ctx, {
  type: "bar",
  data: {
    labels: successLabels,
    datasets: [
      {
        type: "bar",
        backgroundColor: "rgba(54, 162, 235, 0.2)",
        borderColor: "rgba(54, 162, 235, 1)",
        borderWidth: 1,
        label: "Transaction Amount",
        data: successData
      },
      {
        type: "line",
        label: "Transaction Count",
        data: lineData,
        lineTension: 0, 
        fill: true 
         }
       ]
          }, options: {
                responsive: false,
                maintainAspectRatio: false,
                 plugins: {
      title: {
        display: true,
        text: 'Gross Transaction Value and Transaction Count',
      }
    },
    scales: {
        x: { title: { display: true, text: 'Date' }},
        y: { title: { display: true, text: 'Amount ₹' }}
    }

                            
     }
      });


}






