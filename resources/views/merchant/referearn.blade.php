@extends('layouts.merchantcontent')
@section('merchantcontent')
<!--Module Banner-->
<div id="buton-1">
    <button class="btn btn-dark" id="Show">Show</button>
<button  class="btn btn-danger" id="Hide">Remove</button>
    </div>
<section id="about-1" class="about-1">
    <div class="container-1">
  
      <div class="row">
      
        <div class="col-lg-6 d-flex flex-column justify-contents-center" data-aos="fade-left">
          <div class="content-1 pt-4 pt-lg-0">
            <h3>Refer & Earn</h3>
            <p class="font-italic">Refer your friends and earn credits</p>
  
  <p>You are just one step away from activating your account to accept domestic and international payments from your customers. We just need a few more details</p>
          </div>
        </div>
        <div class="col-lg-6" data-aos="zoom-in">
          <img src="/assets/img/merchant-refer.png" width="350" height="250" class="img-fluid" id="img-dash" alt="merchant-refer.png">
        </div>
      </div>
  
    </div>
</section>
<!--Module Banner-->

<div class="row">
    <div class="col-sm-12 padding-20">
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs" id="transaction-tabs">
                    {{-- @php ($trans = ['merchant/invoices' => '<a data-toggle="tab" class="show-cursor" data-target="#invoices">invoices</a>',
                            'merchant/invoices/items' => '<a data-toggle="tab"  class="show-cursor" data-target="#items">Items</a>',
                            'merchant/invoice/new'=>'<a data-toggle="tab"  class="show-cursor" data-target="#addinvoice">New Invoice</a>'])
                    @foreach($trans as $index=>$value)
                        <li class="{{ Request::path() == $index ?'active' : ''}}">{!! $value !!}</li>
                    @endforeach --}}
                    <li class="active"><a data-toggle="tab" class="show-cursor" data-target="#refer-earn">Refer & Earn</a></li>
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div id="refer-earn" class="tab-pane fade in active">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="col-sm-6" style="overflow:scroll">
                                    <div class="panel panel-default refer-div-height">
                                        <div class="panel-body">
                                            <h5 class="h5"><strong>What is Refer & Earn?</strong></h3>
                                            <p>
                                                <strong>Payflash Refer & Earn </strong>works same as the most of the refer and earn schemes in the market.You can earn virtual money as much as you can
                                                in your wallet by just referring your fellow merchants.The only thing you have to do is sharing or by inviting them with your reference id in the social media platforms.  
                                            </p>
                                            <h5 class="h5"><strong>How Refer & Earn Works?</strong></h3>
                                            <p>When a merchant signup and completes the KYC with your referecen id you will be credited virtual money in your wallet.
                                            The credeited money can be redeemed while settlement.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6" style="overflow:scroll">
                                    <div class="panel panel-default refer-div-height">
                                        <div class="panel-body">
                                           <div class="row">
                                                <div class="col-sm-12 text-center">
                                                    <div class="col-sm-12 text-center referenceid">
                                                        <a href="#" class="thumbnail">
                                                            <strong id="refer_id">{{strtoupper(Auth::user()->merchant_gid)}}</strong>
                                                        </a>
                                                        <div class="btn btn-primary btn-sm" onclick="copyReferText()">Copy</div>
                                                    </div>
                                                </div>
                                           </div>
                                           <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="panel panel-default">
                                                        <div class="panel-body">
                                                            <div class="col-sm-12">
                                                                <div class="col-sm-3">
                                                                    <!-- <a href="https://www.facebook.com/sharer/sharer.php?s=100&p[title]=&p[summary]=&p[url]={{urlencode('http://www.rupayapay.com/')}}&p[image]={{urlencode('http://www.rupayapay.com/images/final-logo.png')}}" target="_black"><i class="fa fa-facebook-official fa-lg pull-left" ></i></a> -->
                                                                    <a href="https://www.facebook.com/sharer/sharer.php?u=#" target="_black"><i class="fa fa-facebook-official fa-lg pull-left" ></i></a>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <a href="https://web.whatsapp.com/send?l=en&text=Ryapayref_P7MZujDRH67eTvRj" target="_black"><i class="fa fa-whatsapp fa-lg pull-left" ></i></a>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <a href="https://instagram.com" target="_black"><i class="fa fa-instagram fa-lg pull-left" ></i></a>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <a href=""><i class="fa fa-share-alt-square fa-lg pull-right"></i></a>
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
                        <div class="row padding-10">
                            <div class="col-sm-12">
                                <table class="table table-bordered"> 
                                    <thead>
                                        <tr>
                                            <th>Earner Name</th>
                                            <th>Email Id</th>
                                            <th>Mobile No</th>
                                            <th>Status</th>
                                            <th>Sign Up</th>
                                            <th>Bonus Received</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>
@endsection
