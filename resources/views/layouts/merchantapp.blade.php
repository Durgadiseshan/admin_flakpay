 <!DOCTYPE html>
 <html lang="{{ app()->getLocale() }}">

 <head>
     <meta charset="utf-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1">

     <!-- CSRF Token -->
     <meta name="csrf-token" content="{{ csrf_token() }}">

     <title>{{ config('app.name', env('APP_NAME')) }}</title>
     <link href="{{ asset('new/img/flakpay_icon.ico') }}" rel="icon">
     <link href="{{ asset('new/img/flakpay_icon.ico') }}" rel="apple-touch-icon">
     <!-- Styles -->
     <link href="{{ asset('css/app.css') }}" rel="stylesheet">
     <link href="{{ asset('css/style2.css') }}" rel="stylesheet">


     <!-- <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet"> -->
     <!-- font awesome cdn -->
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

     <!-- fonts cdn-->

     <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
     <link href="{{ asset('css/merchant-custom-style.css') }}" rel="stylesheet">
     <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
     <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
     <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
 </head>

 <body>
     <div id="divLoading">
     </div>
     <div id="app">
         @yield('content')
     </div>
     <!-- Scripts -->
      <input type="hidden" id="base_url" value="<?php echo url('/') ;?>"?>
     <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
     <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
     <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
     <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
     <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>




     <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
     <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
     <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
     <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
     <script type="text/javascript" src="{{ asset('js/jquery.serializejson.js') }}"></script>
     <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js" charset="utf-8"></script> -->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js" crossorigin="anonymous" ></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.1.0/chartjs-plugin-datalabels.min.js"  crossorigin="anonymous" referrerpolicy="no-referrer"></script>
     <script type="text/javascript" src="{{ asset('js/merchantereport.js') }}"></script>
     <script type="text/javascript" src="{{ asset('js/searchapp.js') }}"></script>
     <script type="text/javascript" src="{{ asset('js/crudapp.js') }}"></script>
     <script type="text/javascript" src="{{ asset('js/modelapp.js') }}"></script>
     <script type="text/javascript" src="{{ asset('js/validatefunction.js') }}"></script>
     <script type="text/javascript" src="{{ asset('js/search.js') }}"></script>
     <script type="text/javascript" src="{{ asset('js/graph.js') }}"></script>
     <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
     
     

     <!-- Latest compiled and minified JavaScript -->
     <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

     <script src="//cdn.amcharts.com/lib/4/core.js"></script>
<script src="//cdn.amcharts.com/lib/4/charts.js"></script>
<script src="//cdn.amcharts.com/lib/4/themes/animated.js"></script>
<script src="//cdn.amcharts.com/lib/4/themes/kelly.js"></script>
<script type="text/javascript" src="{{ asset('js/amchart.js') }}"></script>


     <script>
         $(document).ready(function() {
             $('#contacts').DataTable({
                 dom: 'Bfrtip',
                 buttons: [
                     'colvis', 'print', 'pdf', 'excel'
                 ]
             });
         });
     </script>



     <script>
         $(document).ready(function() {
             $('#example').DataTable();
             $('#trans_log_table').DataTable();
         });
     </script>


     <script>
         $("#contact_id").on('change', function() {
             console.log('working');
             console.log(this.value);
             if (this.value == 'addnew') {
                 $("#contact").show();
             } else {
                 $("#contact").hide();
             }
         })
     </script>

     

     @if(session()->has('message'))
     <script>
         swal("{{ session('message') }}");
     </script>
     @endif
 </body>

 </html>