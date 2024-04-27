<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'payflash') }}</title>

    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/rupayapay-styles.css') }}" rel="stylesheet">
    <link href="assets/code/icofont/icofont.min.css" rel="stylesheet">

     <!-- Favicons -->
    <link href="assets/img/android-chrome-192x192.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <link href="assets/code/boxicons/css/boxicons.min.css" rel="stylesheet">

    <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet">

    <!-- =================Font Awsome=================== -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Global site tag (gtag.js) - Google Analytics -->

    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-177386849-1');
    </script>


    <script type="application/ld+json">
      {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "payflash",
        "url": "https://rockpay.in/",
        "logo": "https://rockpay.in/assets/img/rockpay.png",
        "contactPoint": {
          "@type": "ContactPoint",
          "telephone": "7676752187",
          "contactType": "customer service",
          "contactOption": "TollFree",
          "areaServed": "IN",
          "availableLanguage": "en"
        },
        "sameAs": [
          "https://www.facebook.com/rockpay",
          "https://twitter.com/rockpay_ind",
          "https://www.linkedin.com/company//admin/",
          "https://www.instagram.com/rockpay/"
        ]
      }
      </script>
    <!----Google Site Verifivation-->
    <meta name="google-site-verification" content="ar6-vyQulRI-o0wurQapq3Dmwsak0SrBrO1IESoqIrg" />
    <!----Google Site Verifivation-->
  </head>
<body>
    <div id="app">

       <!------------------------Navbar------------------- --->
        <header id="header-section" class="sticky">
          <nav class="navbar navbar-expand-lg bg-white fixed-top py-3 pl-3 pl-sm-0" id="navbar">
          <div class="container">
            <div class="navbar-brand-wrapper d-flex w-100">
            <a href="/"> <img src="{{asset('/images/final-logo.png')}}" width="100" alt=""></a>
            <button class="navbar-toggler bg-black ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="mdi mdi-menu navbar-toggler-icon"><i class="fa fa-bars"></i></span>
            </button> 
            </div>
            <div class="collapse navbar-collapse navbar-menu-wrapper" id="navbarSupportedContent">
            <ul class="navbar-nav align-items-lg-center align-items-start ml-auto">
              <li class="d-flex align-items-center justify-content-between pl-4 pl-lg-0">
              <div class="navbar-collapse-logo">
                <p class="font-weight-bold mt-1">MENU</p>
              </div>
              <button class="navbar-toggler close-button" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="mdi mdi-close navbar-toggler-icon pl-5 mt-5"><i class="fa fa-times mr-3"></i></span>
              </button>
              </li>
            
          
              <!-- product -->
              <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Product
              </a>
              <div class="dropdown-menu mega-menu" id="mega-menu1" aria-labelledby="navbarDropdown" style="align-self: center;">
                <div class="row">
                  
                  <div class="col-lg-3 col-md-12">
                    <p class="text-bold">BANKING</p>
                    <div><a href="/"><i class="fab fa-gg mr-2 text-danger"></i><h4>Payments</h4></a></div>
                    <div> <a href="/"><i class="fas fa-cubes mr-2 text-success"></i><h4>Loan</h4></a></div>
                    <div><a href="/"><i class="fab fa-xing mr-2" style="color: #3c3c7e;"></i><h4>Payout</h4></a></div>
                    <div> <a href="/"><i class="fa fa-google-wallet mr-2 text-danger"></i><h4>Wallet</h4></a></div>
                    </div>
                  
                  <div class="col-lg-3 col-md-12 ml-5 mt-1 slide-rgt">
                  <p class="text-bold">PAYMENT OPTION</p>
                  <div> <a href="/payment-gateway"><i class="fas fa-lira-sign mr-2"></i><h4>Payment Gateway</h4></a></div>
                  <div> <a href="/payment-link"><i class="fa fa-link mr-2" style="color: #248d91;"></i><h4>Payment Link</h4></a></div>
                  <div> <a href="/payment-pages"><i class="fa fa-file mr-2 text-warning"></i><h4>Payment Pages</h4></a></div>
                  <div><a href="/subscription"><i class="fa fa-subscript mr-2 text-danger"></i><h4>Subscription</h4></a></div>
                  </div>
                  <div class="col-lg-3 col-md-12 ml-5 slide-rgt">

                  <p class="text-bold">MORE</p>
                  <div> <a href="/partner"><i class="fa fa-users mr-2 text-black-50"></i><h4>Partner</h4></a></div>
                  <div> <a href="/route"><i class="fa fa-gears mr-2"></i><h4>Route</h4></a></div>
                  <div> <a href="/invoice"><i class="fas fa-file-alt mr-3 text-success"></i><h4>Invoice</h4></a></div>
                  <div><a href="/upi"><i class="fab fa-cc-visa mr-3" style="color:#111180"></i><h4>UPI</h4></a></div>
                  </div>
                  </div> 
              </div> 
              </li>
        
              <!-- pricing -->
              <li class="nav-item">
              <a class="nav-link page-scroll" href="/pricing">Pricing</a>
            </li>
              <!-- pricing -->
          
              <!-- api doc -->
              <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" id="navbarDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                API Doc
              </a>
              <div class="dropdown-menu mega-menu ml-auto" id="mega-menu-3" aria-labelledby="navbarDropdown">
                <div class="row">
                  <div class="col-md-3 dev-para">
                  <h4 style="color: cadetblue;">Developer</h4><br>
                  <p style="font-size: 14px;">Develop your business <br> with our Payment <br> gateway</p>
                  </div>
                  <div class="col-md-6 pl-5 slide-rgt-2">
                  <div> <a href="/dev-doc"><i class="fas fa-file-pdf mr-4"></i><h4>Doc</h4></a></div>
                  <div><a href="/integration"><i class="fa fa-link mr-4 text-success"></i><h4>Integration</h4></a></div>
                  <div>  <a href="/api"><i class="fas fa-location-arrow mr-4 text-danger"></i><h4>API Reference</h4></a></div>
                  </div>
                </div> 
              </div>
              </li>
            
            
              <!-- resource -->
              <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" id="navbarDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Resources
              </a>
              <div class="dropdown-menu mega-menu ml-auto" id="mega-menu-4" aria-labelledby="navbarDropdown">
                <div class="row">
                <div class="col-lg-3 col-md-12 slide-rgt-3">
                  <p class="text-bold">COMPANY</p>
                  <div> <a href="/blog"><i class="fas fa-blog text-danger"></i><h4>Blog</h4></a></div>
                    <div> <a href="/event"><i class="fas fa-user-friends text-success"></i><h4>Event</h4></a></div>
                    <div><a href="/customer-stories"><i class="fas fa-bell" style="color: #5e4785;"></i><h4>Custom Stories</h4></a></div>
                  
                  </div>
                  
                  <div class="col-lg-3 col-md-12 ml-3">
                  <p class="text-bold">SOLUTION</p>
                  <div><a href="/ecommerce"><i class="fas fa-cart-arrow-down" style="color: #941478;"></i><h4>E-commerce</h4></a></div>
                  <div><a href="/education"><i class="fas fa-book-reader" style="color: #eb892e;"></i><h4>Education</h4></a></div>
                  <div><a href="/saas"><i class="fas fa-dice-d20 text-warning" style="color: #961540;"></i><h4>Saas</h4></a></div>
                  </div>
          
                  <!--  -->
                  <div class="col-lg-3 col-md-12 ml-5 slide-rgt-2">
                    <p class="text-bold">GUIDE</p>
                    <div><a href="/settlement"><i class="fas fa-handshake" style="color: #2b6464;"></i><h4>Adjustment Guide</h4></a></div>
                    </div>
                  <!--  -->
                </div> 
              </div>
              </li>
              <!-- resource -->
          
              <li class="nav-item btn-contact-us1">
              <a href="/login"> <button data-toggle="modal" data-target="#exampleModal">Login</button></a>&nbsp;&nbsp;&nbsp;
              <a href="/register"> <button data-toggle="modal" data-target="#exampleModal">Signup</button></a>
              </li>
          
              <li class="nav-item collapse-login">
              <a href="/login" class="nav-link"> Login</a>
              
            </li>
            <li class="nav-item collapse-login">
              
              <a href="/register" class="nav-link">Signup</a>
            </li>
            </ul>
            </div>
          </div> 
          </nav>   
        </header>
	     <!-- --------------------End navbar--------------------------- -->
        
        @yield('content')
        
        <footer id="footer">
            <div class="footer-top">
            <div class="container">
                <div class="row">
        
                <div class="col-lg-4 col-md-6">
                    <div class="footer-info">
                    <h3>Payflash</h3>
                    <p class="pb-3"><em>If your business needs assistance in digital payments, then we are a force to be reckon with. With Payflash payment gateway, you can instantly setup a business account, automate payments, and acquire collateral-free capital loans with ease. Capitalizing on our state-of-the-art technology, you can offer your customers a simplified and secure online payment experience with multiple options. Our experts will ensure a smooth running of your payment ecosystem. We take care of your digital payments, you can invest your energies in growing your business.</em></p>
                    <p>
                      <div>payflash</div>
                      <div>#175 & 176, Bannerghatta Main Road, Dollars Colony, Phase 4, J.P. </div>
                      <div>Nagar, Bengaluru, Karnataka-560076</div>
                      <br><br>
                      <strong>Phone:</strong>+91 9087711911<br>
                      <strong>Email:</strong> info@payflash.in<br>
                    </p>
                    </div>
                </div>
        
                <div class="col-lg-2 col-md-6 footer-links">
                    <h4>Company</h4>
                    <ul>
                    <li><i class="bx bx-chevron-right"></i> <a href="/about">About Us</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="/contact">Contact us</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="/term">Terms & Condition</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="/privacy">Privacy policy</a></li>
                    </ul><br>
                    <h4>Resources</h4>
                    <ul>
                    <li><i class="bx bx-chevron-right"></i> <a href="/blog">Blog</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="/event">Event</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="/customer-stories">Custom Story</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="/adjustment-guide">Adjustment Guide</a></li>
                    </ul>
                </div><br>
        
                <div class="col-lg-2 col-md-6 footer-links">
                    <h4>Accept Payment</h4>
                    <ul>
                    <li><i class="bx bx-chevron-right"></i> <a href="/payment-gateway">Payment Gateway</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="/payment-pages">Payment Pages</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="/subscription">Subscription</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="/payment-link">Payment Links</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="/invoice">Invoice</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="/route">Router</a></li>
                    </ul><br>
                    <h4>Developers</h4>
                    <ul>
                    <li><i class="bx bx-chevron-right"></i> <a href="/doc">Doc</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="/integration">Integration</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="/api">API Reference</a></li>
                    </ul><br>
                </div>
        
                <div class="col-lg-2 col-md-6 footer-links">
                    <h4>Products</h4>
                    <ul>
                    <li><i class="bx bx-chevron-right"></i> <a href="/">Payments</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="/">Loan</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="/">Payout</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="/">Wallet</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="/rpay-doc">Rpay Docs</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="/agreement">Agreement</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="/covid">Covid-19</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="/disclaimer">Disclaimer</a></li>
                    <li><i class="bx bx-chevron-right"></i> <a href="/press-release">Press & Release</a></li>                    
                    </ul><br>
                </div>
                <div class="col-lg-2 col-md-6 footer-links">
                <h4>Refer & Earn</h4>
                <ul>
                    <li><i class="bx bx-chevron-right"></i> <a href="/partner">Partners</a></li>
                </ul><br>
                  <h4>Solutions</h4>
                  <ul>
                      <li><i class="bx bx-chevron-right"></i> <a href="/career">Career</a></li>
                      <li><i class="bx bx-chevron-right"></i> <a href="/gallery">Gallery</a></li>
                      <li><i class="bx bx-chevron-right"></i> <a href="/csr">CSR Activities</a></li>
                      <li><i class="bx bx-chevron-right"></i> <a href="/education">Education</a></li>
                      <li><i class="bx bx-chevron-right"></i> <a href="/ecommerce">E-commerce</a></li>
                      <li><i class="bx bx-chevron-right"></i> <a href="/saas">Saas</a></li>                    
                  </ul>
                </div>
                </div>
            </div>
            </div>
            <div class="container d-md-flex py-4">
        
            <div class="mr-md-auto text-center text-md-left">
                <div class="credits">
                  &copy;{{date('Y')}}&nbsp;Copyright <strong><span>Payflash</span></strong>. All Rights Reserved
                Designed by <a href="#">Payflash</a>
                </div>
            </div>
            <div class="social-links text-center text-md-right pt-3 pt-md-0">
                <a href="https://twitter.com/rockpay" class="twitter"><i class="bx bxl-twitter"></i></a>
                <a href="https://www.facebook.com/rockpay.India/" class="facebook"><i class="bx bxl-facebook"></i></a> 
                <a href="https://www.instagram.com/rockpay/" class="instagram"><i class="bx bxl-instagram"></i></a>
                <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
                <a href="https://www.linkedin.com/company/rockpay/" class="linkedin"><i class="bx bxl-linkedin"></i></a>
            </div>
            </div>
        </footer>
</div>
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src= "https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script> 
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script>
        $('.dropdown').hover(function() {
        $(this).find('.mega-menu').stop(true, true).delay(200).fadeIn(500);
        }, function() {
        $(this).find('.mega-menu').stop(true, true).delay(200).fadeOut(500);
        });
    </script>
</body>
</html>