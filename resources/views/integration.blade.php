@extends('layouts.rupayapayapp')
@section('content')
<!-- ======= Intro Section ======= -->
<section id="intro" class="clearfix">
    <div class="container">
      <div class="intro-img">
        <img
          src="https://www.hrincjobs.com/assets/images/paymentgate.png"
          alt=""
          class="img-fluid"
        />
      </div>

      <div class="intro-info">
        <h2>Easy Integration for swift transition</h2>
        <p>
          Easy to integrate platform SDKs, E-commerce plug-ins, Server
          Integrations, sample integrations, community integration, and
          partner channels offer you an opportunity of a wide range of choice.
          When your customers win, you win too.
        </p>
        <div>
          <a href="/contact" class="btn-get-started scrollto">Get Started</a>
        </div>
      </div>
    </div>
  </section>
  <!-- End Intro Section -->

  <!-- card section -->
  <div class="section-title" data-aos="fade-up">
    <h2 class="text-center">Platform SDKs</h2>
    <p class="text-center">Payment Gateway Integration for 15+ Platform</p>
  </div>
  <div class="container flexx">
    <div class="row">
      <div class="col-lg-3 col-sm-4">
        <div class="card">
          <div class="image">
            <i class="fab fa-php fa-5x align-center"></i>
          </div>
          <div class="card-inner">
            <div class="header">
              <p>PHP</p>
            </div>
            <hr />
            <div class="content">
              <a href="/download/integration/PHP MERCHANT INTEGRATION WITH RUPAYAPAY DOCUMENT.pdf">Docs</a>
              <a href="/download/integration/RupayapayPHPClientKit.zip"><span>Download</span> </a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-sm-4">
        <div class="card">
          <div class="image">
            <i class="fab fa-java fa-5x"></i>
          </div>
          <div class="card-inner">
            <div class="header">
              <p>JAVA</p>
            </div>
            <hr />
            <div class="content">
              <a href="/download/integration/JAVA MERCHANT INTEGRATION WITH RUPAYAPAY DOCUMENT.pdf">Docs</a>
              <a href="/download/integration/RupayapayJavaClientApplication.zip"><span>Download</span> </a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-sm-4">
        <div class="card">
          <div class="image">
            <i class="fab fa-android fa-5x"></i>
          </div>
          <div class="card-inner">
            <div class="header">
              <p>ANDROID</p>
            </div>
            <hr />
            <div class="content">
              <a href="/download/integration/ANDROID MERCHANT INTEGRATION WITH RUPAYAPAY DOCUMENT.pdf">Docs</a>
              <a href="/download/integration/AndroidMerchantClientKit.zip"><span>Download</span> </a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-sm-4">
        <div class="card">
          <div class="image">
            <i class="fab fa-python fa-5x"></i>
          </div>
          <div class="card-inner">
            <div class="header">
              <p>PYTHON</p>
            </div>
            <hr />
            <div class="content">
              <a href="/download/integration/PYTHON MERCHANT INTEGRATION WITH RUPAYAPAY DOCUMENT.pdf">Docs</a>
              <a href="/download/integration/RupayapayPythonClientKit.zip"><span>Download</span> </a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-sm-4">
        <div class="card">
          <div class="image">
            <i class="fab fa-microsoft fa-5x"></i>
          </div>
          <div class="card-inner">
            <div class="header">
              <p>ASP.net</p>
            </div>
            <hr />
            <div class="content">
              <a href="/download/integration/DOT NET MERCHANT INTEGRATION WITH RUPAYAPAY DOCUMENT.pdf">Docs</a>
              <a href="/download/integration/Rupayapay.NETClientKit.zip"><span>Download</span> </a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-sm-4">
        <div class="card">
          <div class="image">
            <i class="far fa-gem fa-5x"></i>
          </div>
          <div class="card-inner">
            <div class="header">
              <p>Ruby On Rails</p>
            </div>
            <hr />
            <div class="content">
              <a href="/download/integration/RUBYONRAILS MERCHANT INTEGRATION WITH RUPAYAPAY DOCUMENT.pdf">Docs</a>
              <a href="/download/integration/RupayapayRubyKit.zip"><span>Download</span></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <br /><br />

  <!-- --------ecommerce------- -->
  <section class="ecommercee">
    <div class="section-title" data-aos="fade-up">
      <h2 class="text-center">E-commerce Plugins</h2>
      <p class="text-center">Integration Kits For E-Commerce Stores</p>
    </div>

    <div class="container flexx">
      <div class="row">
        <div class="col-lg-4 col-sm-4">
          <div class="card">
            <div class="image">
              <img src="{{asset('assets/img/integration/woo.png')}}" width="100" alt="woo.png"/>
            </div>
            <div class="card-inner">
              <div class="header">
                <p>WOO</p>
              </div>
              <hr />
              <div class="content">
                <a href="/download/integration/WOOCOMMERCE MERCHANT INTEGRATION WITH RUPAYAPAY DOCUMENT.pdf">Docs</a>
                <a href="/download/integration/woocommerce-rupayapay.zip"><span>Download</span> </a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-sm-4">
          <div class="card w-100">
            <div class="image">
              <i class="fab fa-wordpress-simple fa-5x text-info h-100"></i>
            </div>
            <div class="card-inner">
              <div class="header mt-3">
                <p>WORDPRESS</p>
              </div>
              <hr />
              <div class="content">
                <a href="/download/integration/WORDPRESS MERCHANT INTEGRATION WITH RUPAYAPAY DOCUMENT.pdf">Docs</a>
                <a href="/download/integration/wordpress_rupayapay-plugin.zip"><span>Download</span> </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ======= About Section ======= -->
  <section id="about" class="about">
    <div class="container-fluid">
      <div class="row">
        <div
          class="col-xl-5 col-lg-6 video-box d-flex justify-content-center align-items-stretch"
          data-aos="fade-right"
        >
          <!-- <a href="#" class="venobox play-btn mb-4" data-vbtype="video" data-autoplay="true"></a> -->
        </div>

        <div
          class="col-xl-7 col-lg-6 icon-boxes d-flex flex-column align-items-stretch justify-content-center py-5 px-lg-5"
          data-aos="fade-left"
        >
          <h3>How To Integrate Payment Gateway?</h3>
          <p>
            Once registered with rupayapay, we provide an payment gateway
            integration kit or you download the SDK and input key and other
            necessary details provided by Rupayapay
          </p>

          <div class="icon-box" data-aos="zoom-in" data-aos-delay="100">
            <div class="icon"><i class="fas fa-download"></i></div>
            <h4 class="title">Download SDKs</h4>
            <p class="description">
              Download the latest version of the SDK for your development
              platform provided by rupayapay.
            </p>
          </div>

          <div class="icon-box" data-aos="zoom-in" data-aos-delay="200">
            <div class="icon"><i class="fas fa-key"></i></div>
            <h4 class="title">Get the merchant key</h4>
            <p class="description">
              Every merchant has a unique merchant key which will be provided
              to the merchants after successful registration.
            </p>
          </div>

          <div class="icon-box" data-aos="zoom-in" data-aos-delay="300">
            <div class="icon"><i class="fas fa-thumbs-up"></i></div>
            <h4 class="title">Final Integration</h4>
            <p class="description">
              Handle successful / failed payments with correct SDK and
              Merchant Key and you are good to go.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End About Section -->
  @endsection