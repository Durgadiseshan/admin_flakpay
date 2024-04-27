@extends('layouts.rupayapayapp')
@section('content')
<section class="about-banner">
    <div class="new-block top-bottom">
      <div class="container">
        <div class="middle-section">
          <div class="section-width">
            <h2 class="font-weight-bold">CONTACT US</h2>
          </div>
          <div class="link-list-menu">
            <p class="text-justify">Worried about your customers’ online payments? If you leave that tricky bit to us, you can fully concentrate on your business. We are experienced professionals adept at handling a diverse range of complexities of digital payments. By letting us onboard, you are providing a hassle-free and simplified experience for your cusomers in relation to online payments. A reason we are sure you will be greatful for in the long run. </p>
          </div>
        </div>
      </div>
    </div>
  </section>
<!-- contacts -->
<div class="contacts-9 py-5 mt-4">
    <div class="container py-lg-3">
      <div class="row top-map">
        <div class="cont-details col-md-6 mb-4">
        
          <div class="section-title"  data-aos="fade-up">
            <h2 class="text-center">CONTACT US</h2>
          </div>
    
           <div class="cont-top">
            <div class="cont-left">
              <span class="fa fa-phone"></span>
            </div>
            <div class="cont-right">
              <p>+91 9718667722</p>

            </div>
          </div> 
         
          <div class="cont-top mt-4">
            <div class="cont-left">
              <span class="fa fa-envelope "></span>
            </div>
            <div class="cont-right">
              <p>info@rupayapay.com</p>
            </div>
          </div>
          <div class="cont-top mt-4">
            <div class="cont-left">
              <span class="fa fa-map-marker add"></span>
            </div>
            <div class="cont-right">
              <p>Rupayapay Payments(India) Pvt. Ltd.</p><p> Flat no.301, 3rd floor, 9-1-164, Amsri Plaza</p><p>SD Road, Secunderabad-500003</p>
            </div>
          </div>
        <br><br>
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3806.3880664445896!2d78.49841791440224!3d17.441130605844613!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bcb9a3d285e1bbb%3A0xf6634f56c404fe6!2sRupayapay%20payments%20(india)%20PVT%20Ltd!5e0!3m2!1sen!2sin!4v1590577273597!5m2!1sen!2sin" width="100%" height="384px" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        </div>
        <div class="map-content-9 col-md-6 mt-5 mt-md-0">
        @if (session('success'))
            <div class="help-block text-success text-sm-center">
                <strong>{{session('success')}}</strong>
            </div>
        @endif
        @if (session('failed'))
            <div class="help-block text-danger text-sm-center">
                <strong>{{session('failed') }}</strong>
            </div>
        @endif
          <form action="{{route('contact-us')}}" method="POST">
            <div class="form-group row">
              <div class="col-md-6">
                <label class="font-weight-bold">First Name</label>
                <input type="text"  name="first_name" class="form-control" value="{{old('first_name')}}" placeholder="First Name" required>
                @if ($errors->has('first_name'))
                    <span class="help-block text-danger text-sm-left">
                        <strong>{{ $errors->first('first_name') }}</strong>
                    </span>
                @endif
            </div>
              <div class="col-md-6 mt-md-0 mt-3">
                <label class="font-weight-bold">Last Name</label>
                <input type="text" name="last_name" class="form-control" value="{{old('last_name')}}" placeholder="Last Name" required>
                @if ($errors->has('last_name'))
                    <span class="help-block text-danger text-sm-left">
                        <strong>{{ $errors->first('last_name') }}</strong>
                    </span>
                @endif
            </div>
            </div>
            <div class="form-group row">
              <div class="col-md-6">
                <label class="font-weight-bold">Email ID</label>
                <input type="email" name="email" class="form-control" value="{{old('email')}}" placeholder="Email ID" required>
                @if ($errors->has('email'))
                    <span class="help-block text-danger text-sm-left">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
              <div class="col-md-6 mt-md-0 mt-3">
                <label class="font-weight-bold">Mobile Number</label>
                <input type="text" name="mobile_no" class="form-control" value="{{old('mobile_no')}}" placeholder="Mobile Number" required >
                @if ($errors->has('mobile_no'))
                    <span class="help-block text-danger text-sm-left">
                        <strong>{{ $errors->first('mobile_no') }}</strong>
                    </span>
                @endif
              </div>
            </div>
            <div class="form-group">
              <label class="font-weight-bold">Subject</label>
              <input type="text" name="subject" class="form-control" value="{{old('subject')}}" placeholder="Subject" required>
                @if ($errors->has('subject'))
                    <span class="help-block text-danger text-sm-left">
                        <strong>{{ $errors->first('subject') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
              <label class="font-weight-bold">Message</label>
              <textarea class="form-control" name="message" rows="7"></textarea>
            </div>
            {{csrf_field()}}
            <button type="submit" class="btn-contact">Send Message</button>
          </form>
        </div>
      </div>
    </div>
</div>
@endsection