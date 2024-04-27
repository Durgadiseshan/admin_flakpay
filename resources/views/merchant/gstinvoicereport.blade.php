@extends('layouts.merchantcontent')
@section('merchantcontent')

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

<style>
  td{
    color:#1abc9c;
  }
</style>
<meta name="csrf-token" content="{{ csrf_token() }}" />

<div id="buton-1">
  <button class="btn btn-dark" id="Show">Show</button>
  <button class="btn btn-danger" id="Hide">Remove</button>
</div>

<section id="about-1" class="about-1">
  <div class="container-1">

    <div class="row">

      <div class="col-lg-6 d-flex flex-column justify-contents-center" data-aos="fade-left">
        <div class="content-1 pt-4 pt-lg-0">

          <h3>Gst Invoice Report</h3>
          <p>Get started with accepting payments right away</p>

          <p>You are just one step away from activating your account to accept domestic and international payments from your customers. We just need a few more details</p>
        </div>
      </div>
      <div class="col-lg-6" data-aos="zoom-in" id="img-dash">
        <img src="/assets/img/report.png" width="450" height="280" class="img-fluid" alt="dash-bnr.png">
        
      </div>
    </div>

  </div>
</section>
<div class="src">
                            <form id="gst-report-range-form">
                                <input class="form-control" id="gst_report_range" name="gst_report_range" placeholder="MM/DD/YYYY" type="text" value="">
                                <input type="hidden" name="gst_report_from_date" value="{{session('gst_report_from_date')}}">
                                <input type="hidden" name="gst_report_to_date" value="{{session('gst_report_to_date')}}">
                                <input type="hidden" name="perpage" value="10">
                                <i class="fa fa-calendar gst-fa-calendar"></i>
                                <input type="hidden" name="module" value="gst_report_range">
                                {{csrf_field()}} 
                            </form>
                        </div>
<div class="card">
  <div class="card-body" id="gst_report">
    
  </div>
</div>

 <!-- Items Modal create starts here-->
 <div id="gst-report-model" class="modal" role="dialog">
                                <div class="modal-dialog modal-lg">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Settlement Details of  date: <span class="d-show"></span></h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="model-content" id="modal-dynamic-body">
                                            <div id="item-add-form">
                                           
                           <div class="tab-content">
               <div id="add-multi-items" class="tab-pane fade in active">
             <div class="text-center" id="item-response-message"></div>
            <div class="form-container" id="gst_report_details">
                                                   
                                                      
                                                       
                                                   
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
    document.addEventListener("DOMContentLoaded",function(){
       
      getGstInvoicereport();
    });
</script>



@endsection