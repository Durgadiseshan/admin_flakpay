@extends('layouts.merchantcontent')
@section('merchantcontent')



<div id="buton-1">
    <button class="btn btn-dark" id="Show">Show</button>
<button  class="btn btn-danger" id="Hide">Remove</button>
    </div>
        
    <section id="about-1" class="about-1">
      <div class="container-1">

        <div class="row">
         
          <div class="col-lg-6 d-flex flex-column justify-contents-center" data-aos="fade-left">
            <div class="content-1 pt-4 pt-lg-0">
            
              <h3>Payment Report Report</h3>
              <p>Get started with accepting payments right away</p>

                <p>You are just one step away from activating your account to accept domestic and international payments from your customers. We just need a few more details</p>
            </div>
          </div>
          <div class="col-lg-6" data-aos="zoom-in" id="img-dash">
            <img src="/assets/img/dash-bnr.png" width="450" height="280" class="img-fluid"  alt="dash-bnr.png">
          </div>
        </div>

      </div>
    </section>
@endsection