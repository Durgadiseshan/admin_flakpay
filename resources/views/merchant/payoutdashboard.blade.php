@extends('layouts.merchantcontent')
@section('merchantcontent')

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<style>
    .flex-container {
        display: flex;
        flex-wrap: nowrap;

    }

    .flex-container>div {

        width: 400px;
        margin: 10px;
        text-align: center;


    }

    .submitButton {
        margin-top: 2rem;
    }
</style>

<style>
    .c-dashboardInfo {
        margin-bottom: 15px;
    }

    .c-dashboardInfo .wrap {
        background: #ffffff;
        box-shadow: 2px 10px 20px rgba(0, 0, 0, 0.1);
        border-radius: 7px;
        text-align: center;
        position: relative;
        overflow: hidden;
        padding: 40px 25px 20px;
        height: 100%;
    }

    .c-dashboardInfo__title,
    .c-dashboardInfo__subInfo {
        color: #6c6c6c;
        font-size: 1.18em;
    }

    .c-dashboardInfo span {
        display: block;
    }

    .c-dashboardInfo__count {
        font-weight: 600;
        font-size: 2.5em;
        line-height: 64px;
        color: #323c43;
    }

    .c-dashboardInfo .wrap:after {
        display: block;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 10px;
        content: "";
    }

    .c-dashboardInfo:nth-child(1) .wrap:after {
        background: linear-gradient(82.59deg, #00c48c 0%, #00a173 100%);
    }

    .c-dashboardInfo:nth-child(2) .wrap:after {
        background: linear-gradient(81.67deg, #0084f4 0%, #1a4da2 100%);
    }

    .c-dashboardInfo:nth-child(3) .wrap:after {
        background: linear-gradient(69.83deg, #0084f4 0%, #00c48c 100%);
    }

    .c-dashboardInfo:nth-child(4) .wrap:after {
        background: linear-gradient(81.67deg, #ff647c 0%, #1f5dc5 100%);
    }

    .c-dashboardInfo__title svg {
        color: #d7d7d7;
        margin-left: 5px;
    }

    .MuiSvgIcon-root-19 {
        fill: currentColor;
        width: 1em;
        height: 1em;
        display: inline-block;
        font-size: 24px;
        transition: fill 200ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
        user-select: none;
        flex-shrink: 0;
    }

    .about-1 {
        margin-top: 10px;
    }
</style>


<section id="about-1" class="about-1 ">
      <div class="container-1">

        <div class="row">
         
          <div class="col-lg-6 d-flex flex-column justify-contents-center" data-aos="fade-left">
            <div class="content-1 pt-4 pt-lg-0">
            
             <h3>Welcome to Payout Dashboard </h3>
            <!--   <p>Get started with accepting payments right away</p>

                <p>You are just one step away from activating your account to accept domestic and international payments from your customers. We just need a few more details</p> --> 
            </div>
          </div>
          <!-- <div class="col-lg-6" data-aos="zoom-in" id="img-dash">
            <img src="/assets/img/dash-bnr.png" width="450" height="280" class="img-fluid"  alt="dash-bnr.png" >
          </div> -->
       
    <!--Module Banner-->

  <div class="col-lg-12">
        <div class="panel panel-default">
           
    
            <div class="panel-body">
                <div class="social-bx tab-content">
                    <div id="dash-graphs-summary">
                        <div class="src">
                            <form id="dashboard-form-summary">
                                <input class="form-control" id="dash_date_range_summary" name="dash_date_range_summary" placeholder="MM/DD/YYYY" type="text" value="">
                                <input type="hidden" name="dash_from_date" value="{{session('dash_from_date')}}">
                                <input type="hidden" name="dash_to_date" value="{{session('dash_to_date')}}">
                                <input type="hidden" name="perpage" value="10">
                                <i class="fa fa-calendar dash-fa-calendar-summary"></i>
                                <input type="hidden" name="module" value="dash_summary">
                                {{csrf_field()}} 
                            </form>
                        </div>
                    </div>
                </div>

            </div>

     </div>
   </div>

   


 



<section id="about-1" class="about-1">
    <div id="root">
        <div class="container pt-5">
            <div class="row align-items-stretch">
                <div class="c-dashboardInfo col-lg-3 col-md-6">
                    <div class="wrap">
                        <h4 class="heading heading5 hind-font medium-font-weight c-dashboardInfo__title">Total Amount Today</h4><span class="hind-font caption-12 c-dashboardInfo__count">{{$payoutDashboard->totalAmount}} ₹</span>
                    </div>
                </div>
                <div class="c-dashboardInfo col-lg-3 col-md-6">
                    <div class="wrap">
                        <h4 class="heading heading5 hind-font medium-font-weight c-dashboardInfo__title">Number of Payout Today</h4><span class="hind-font caption-12 c-dashboardInfo__count">{{$payoutDashboard->numberofTransaction}}</span>
                    </div>
                </div>
                <div class="c-dashboardInfo col-lg-3 col-md-6">
                    <div class="wrap">
                        <h4 class="heading heading5 hind-font medium-font-weight c-dashboardInfo__title">Total Success Transaction</h4><span class="hind-font caption-12 c-dashboardInfo__count">{{$payoutDashboard->totalSuccessTransaction}}</span>
                    </div>
                </div>
                <div class="c-dashboardInfo col-lg-3 col-md-6">
                    <div class="wrap">
                        <h4 class="heading heading5 hind-font medium-font-weight c-dashboardInfo__title">Total Failed Transaction</h4><span class="hind-font caption-12 c-dashboardInfo__count">{{$payoutDashboard->totalFailedTransaction}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12" style="display:none">
        <div class="panel panel-default">
           
    
            <div class="panel-body">
                <div class="social-bx tab-content">
                    <div id="dash-graphs-payout">
                        <div class="src">
                            <form id="dashboard-form-payout">
                                <input class="form-control" id="dash_date_range_payout" name="dash_date_range_payout" placeholder="MM/DD/YYYY" type="text" value="">
                                 <input type="hidden" name="dash_from_date" value="{{session('dash_from_date')}}">
                                <input type="hidden" name="dash_to_date" value="{{session('dash_to_date')}}"> 
                                <input type="hidden" name="perpage" value="10">
                                <i class="fa fa-calendar dash-fa-calendar-payout"></i>
                                <input type="hidden" name="module" value="dash_payout">
                                {{csrf_field()}} 
                            </form>
                        </div>
                    </div>
                </div>

            </div>

     </div>
   </div>

   
 
<div class="social-bx tab-content">
    <div id="dash-graphs" class="tab-pane fade in active">

    <div class="row">
        <div   id="gtvGraph"></div>
    </div>
       
    </div>
</div>
</section>


</div>

      </div>
    </section>





<script>
    document.addEventListener("DOMContentLoaded",function(){
        getDashboardPayout();
       
    });
</script>



@endsection