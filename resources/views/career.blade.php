@extends('layouts.rupayapayapp')
@section('content')
<!--================Home Banner Area =================-->
<section class="home_banner_area">
    <div class="banner_inner">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <div class="banner_content">
                        <h2>
                            Let’s Make Moving Money Effortless.
                        </h2>
                        <p>
                           Yes, we are new to the market but we gonna make a remarkable change in today's competitive world of payment gateway come join us to be a part of making that remarkable change.
                        </p>
                        <div class="d-flex align-items-center">
                            <a class="primary_btn" href="#"><span>Get Started</span></a>
                            
                            
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="home_right_img">
                        <img class="img-fluid" src="" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--================End Home Banner Area =================-->

 <!-- ======= Features Section ======= -->
 <section id="fetures" class="fetures">
    <div class="container">

      <div class="row feature-item">
        <div class="col-lg-7 wow fadeInUp">
          <!-- Grid row -->
    <div class="row">

<!-- Grid column -->

<!-- Grid column -->

  </div>
  <!-- Grid row -->
  
  <!-- Grid row -->
  <div class="gallery" id="gallery">
  
  <!-- Grid column -->
  <div class="mb-3 pics animation all 1">
    <img class="img-fluid" src="{{asset('images/career/5N2A8188-min.JPG')}}" alt="5N2A8188-min.JPG">
</div>
<!-- Grid column -->

<!-- Grid column -->
<div class="mb-3 pics animation all 1">
    <img class="img-fluid" src="{{asset('images/career/5N2A8178-min.JPG')}}" alt="5N2A8178-min.JPG">
</div>
<!-- Grid column -->

<!-- Grid column -->
<div class="mb-3 pics animation all 1">
    <img class="img-fluid" src="{{asset('images/career/AF1A8727-min.JPG')}}" alt="AF1A8727-min.JPG">
</div>
<!-- Grid column -->

<!-- Grid column -->
<div class="mb-3 pics animation all 1">
    <img class="img-fluid" src="{{asset('images/career/AF1A8591-min.JPG')}}" alt="AF1A8591-min.JPG">
</div>
<!-- Grid column -->

<!-- Grid column -->
<div class="mb-3 pics animation all 1">
    <img class="img-fluid" src="{{asset('images/career/AF1A8798-min.jpg')}}" alt="AF1A8798-min.jpg">
</div>
<!-- Grid column -->

<!-- Grid column -->
<div class="mb-3 pics animation all 1">
    <img class="img-fluid" src="{{asset('images/career/AF1A8775-min.JPG')}}" alt="AF1A8775-min.JPG">
</div>
<!-- Grid column -->
  
  </div>
  <!-- Grid row -->
        </div>
        <div class="col-lg-5 wow fadeInUp pt-5 pt-lg-0">
          <h4 style="color: #252b49;">Nerds of a feather, flock together</h4>
          <p>
            We believe in growth through constant experimentation. We work hard to maintain high standards of transparency, constant feedback mechanisms, and winning as a team.
          </p>
         
        </div> 
      </div>

      <div class="row feature-item mt-5 pt-5">
        <div class="col-lg-8 wow fadeInUp order-1 order-lg-2">
            <div class="wrapper">
                <img class="transition image-polygon" src="{{asset('images/career/DSC_1232-min.JPG')}}" width="400" alt="DSC_1232-min.JPG">
                <img class="transition image-polygon" src="{{asset('images/career/DSC_1236-min.JPG')}}" width="400" alt="DSC_1236-min.JPG">
                <img class="transition image-polygon" src="{{asset('images/career/DSC_1294-min.JPG')}}" width="400" alt="DSC_1294-min.JPG">
                <img class="transition image-polygon" src="{{asset('images/career/DSC_1372-min.JPG')}}" width="400" alt="DSC_1372-min.JPG">
                <img class="transition image-polygon" src="{{asset('images/career/IMG_9146-min.jpg')}}" width="400" alt="IMG_9146-min.jpg">
                <img class="transition image-polygon" src="{{asset('images/career/IMG_9168-min.jpg')}}" width="400" alt="IMG_9168-min.jpg">
                <img class="transition image-polygon" src="{{asset('images/career/IMG_9185-min.jpg')}}" width="300" alt="IMG_9185-min.jpg">
                <img class="transition image-polygon" src="{{asset('images/career/IMG_9192-min.jpg')}}" width="300" alt="IMG_9192-min.jpg">
                <img class="transition image-polygon" src="{{asset('images/career/IMG_9346-min.jpg')}}" width="400" alt="IMG_9346-min.jpg">
                <img class="transition image-polygon" src="{{asset('images/career/IMG_9292-min.jpg')}}" width="400" alt="IMG_9350-min.jpg">
              </div>
        </div>

        <div class="col-lg-4 wow fadeInUp mt-5 pt-4 pt-lg-0 order-2 order-lg-1">
          <h4 style="color: #252b49;">Your future self will Thank You!</h4>
          <p>
            We are cool, and we are certified!
          </p>
          <p>
            Leading institutions have recognized Rupayapay for the high trust and high-performance culture that we maintain.
          </p>
         
        </div>

      </div>

    </div>
  </section><!-- End Features Section -->

  <!-- -----------JOBS---------------- -->
  <section class="ftco-section bg-light">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 pr-lg-5">
          <div class="row justify-content-center pb-3">
            <div class="col-md-12 heading-section ftco-animate">
              <span class="subheading text-center">Join The Team</span>
              <h2 class="mb-4 subheading1">Work with people smarter than you!</h2>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <h4>Technical</h4>
              <div class="row">
                <div class="col-md-12 ftco-animate">
                  @foreach($tech as $index => $job)
                  <div class="job-post-item py-4 d-block d-lg-flex align-items-center">
                    <div class="one-third mb-4 mb-md-0">
                      <div class="job-post-item-header d-flex align-items-center">
                        <h2 class="mr-3 text-black"><a href="javascript:void(0)" data-id="{{$job['id']}}" onclick="showJobDescription(this)">{{$job['job_title']}}</a></h2>
                        <div class="badge-wrap">
                         <!-- <span class="bg-primary text-white badge py-2 px-3">Partime</span> -->
                        </div>
                      </div>
                      <div class="job-post-item-body d-block d-md-flex">
                        <div><i class="fa fa-map-marker"></i> <span>{{$job['job_location']}}</span></div>
                      </div>
                    </div>
                    <div class="one-forth ml-auto d-flex align-items-center mt-4 md-md-0">
                      <button href="javascript:void(0)" class="btn btn-primary btn-sm formBtn py-2" onclick=openJobForm("{{$job['id']}}")>Apply Job</button>
                    </div>
                  </div>
                  <div class="badge-wrap" id="job-description-{{$job['id']}}" style="display: none;">
                    <div class="card card-body" >
                      {!! $job['job_description'] !!}
                    </div>
                  </div>
                  @endforeach
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <h4>Non-Technical</h4>
              <div class="row">
                <div class="col-md-12 ftco-animate">
                  @foreach($nontech as $index => $job)
                  <div class="job-post-item py-4 d-block d-lg-flex align-items-center">
                    <div class="one-third mb-4 mb-md-0">
                      <div class="job-post-item-header d-flex align-items-center">
                        <h2 class="mr-3 text-black">
                          <a href="javascript:void(0)" data-id="{{$job['id']}}" onclick="showJobDescription(this)">{{$job['job_title']}}</a>
                        </h2>
                      </div>
                      <div class="job-post-item-body d-block d-md-flex">
                        <div><i class="fa fa-map-marker"></i> <span>{{$job['job_location']}}</span></div>
                      </div>
                    </div>
                    <div class="one-forth ml-auto d-flex align-items-center mt-4 md-md-0">
                      <button href="javascript:void(0)" class="btn btn-primary btn-sm formBtn py-2" onclick=openJobForm("{{$job['id']}}")>Apply Job</button>
                    </div>
                  </div>
                  <div class="badge-wrap" id="job-description-{{$job['id']}}" style="display: none;">
                    <div class="card card-body" >
                      {!! $job['job_description'] !!}
                    </div>
                  </div>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 sidebar">
         
          <!-- Modal  -->
          <div class="modal" id="job-description-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Job Description</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form>
                    <div class="form-group">
                      <strong id="job_title"></strong>
                    </div>
                    <div class="form-group" id="job_description">
                    </div>
                    <div class="form-group">
                      <p id="job_location"></p>
                    </div>
                </form>
                </div>
                <div class="modal-footer">
                </div>
              </div>
            </div>
          </div>

          <!-- Modal  -->
          <div class="modal" id="job-apply-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Career Application</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form class="contact100-form validate-form" id="job-application-form" enctype="multipart/form-data" autocomplete="off">
                    <span class="contact100-form-title">
                      Fill your Details !
                    </span>
                    <div class="wrap-input100 validate-input">
                      <span class="label-input100">Your Name</span>
                      <input class="input100" type="text" name="applicant_name" placeholder="Enter your name">
                      <span class="focus-input100"></span>
                      <div id="applicant_name_error" class="text-danger"></div>
                    </div>
                    <div class="wrap-input100 validate-input">
                      <span class="label-input100">Email</span>
                      <input class="input100" type="text" name="applicant_email" placeholder="Enter your email addess">
                      <span class="focus-input100"></span>
                      <div id="applicant_email_error" class="text-danger"></div>
                    </div>
                    <div class="wrap-input100 validate-input">
                      <span class="label-input100">Mobile</span>
                      <input class="input100" type="text" name="applicant_mobile" placeholder="Enter your Mobile">
                      <span class="focus-input100"></span>
                      <div id="applicant_mobile_error" class="text-danger"></div>
                    </div>
                    <div class="wrap-input100 validate-input">
                      <span class="label-input100">Upload Resume</span>
                      <div class="custom-file mb-3">
                        <input type="file" class="custom-file-input" id="applicant_resume" name="applicant_resume">
                        <label class="custom-file-label" for="customFile">Choose file</label>
                        <div class="mt-3"><strong>Note:</strong>Pdf & Docx are only allowed to upload</div>
                        <div id="applicant_resume_error" class="text-danger"></div>
                      </div>
                    </div>
                    {{csrf_field()}}
                    <input type="hidden" name="job_id" id="job_id" value="">
                    <div class="container-contact100-form-btn">
                      <div class="">
                        <button type="submit" class="btn btn-primary text-center">Submit</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

          
        
          <!-- Modal  -->
          <div class="modal" id="response-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h6 class="modal-title" id="modal-title"></h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              </div>
            </div>
          </div>
          

        </div>
      </div>
    </div>
  </section>
@endsection
