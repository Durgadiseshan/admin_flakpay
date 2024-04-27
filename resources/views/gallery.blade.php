@extends('layouts.rupayapayapp')
@section("content")
<!-- ----------------New Header---------------------------- -->

    <div class="intro-section custom-owl-carousel" id="home-section">
        <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 mr-auto">
    
            <div class="owl-carousel slide-one-item-alt-text">
                @foreach($carousal as $index => $row)
                    <div class="slide-text">
                    {!! $row["content"] !!}
                </div>
                @endforeach
            </div>
    
            </div>
            <div class="col-lg-6 ml-auto" data-aos-delay="100">
                        
            <div class="owl-carousel slide-one-item-alt">
                @foreach($carousal as $index => $row)
                <img src="{{asset('images/gallery/'.$row['image_name'])}}" alt="Image" class="img-fluid">
                @endforeach
            </div>
    
            <div class="owl-custom-direction">
                <a href="#" class="custom-prev"><span class="fa fa-angle-left"></span></a>
                <a href="#" class="custom-next"><span class="fa fa-angle-right"></span></a>
            </div>
    
            </div>
        </div>
        </div>
    </div>
<!-- --------------New Header End--------------------------- -->
<div id="bdy">

<div class="main-wrapper">
    <!-- Start service Area -->
    <section class="service-area">
        <div class="container">
            <div class="row">
                @foreach($introduction as $index => $row)
                <div class="col-md-6">
                    <div class="single-service" style="background: url({{asset('/images/gallery/'.$row['image_name'])}});">
                        <div class="overlay overlay-content">
                            {!!  $row["content"] !!}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- End service Area -->
    <hr style="color: #000; width: 100%; border: 1px solid rgb(107, 107, 107);">
    <!--  -->
    <div class="container-fluid">
    <div class="row vr-gallery">
        <div class="col-md-8 mb-4">
            <div class="row">
                <div class="col-md-12 col-lg-7 pr-0 pd-md">
                    <!-- <img src="./img/career-img2.jpg" alt=""> -->
                    <!--  -->
                    <div class="carousel slide carousel-fade mt-4" data-ride="carousel" data-pause="false" data-interval="2000" id="carousel-1">
                    <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active"><img src="{{asset('images/gallery/DSC_1372.JPG')}}" width="100" alt="Slide Image">
                            
                        </div>
                        <div class="carousel-item"><img src="{{asset('images/gallery/12.jpg')}}" width="100" alt="Slide Image">
                            
                        </div>
                        <div class="carousel-item"><img src="{{asset('images/gallery/13.jpg')}}" width="100" alt="Slide Image">
                            
                        </div>
                        <div class="carousel-item"><img src="{{asset('images/gallery/conference4.jpg')}}" width="100" alt="Slide Image">
                            
                        </div>
                        
                    </div>
                    <div><a class="carousel-control-prev" href="#carousel-1" role="button" data-slide="prev"><span class="carousel-control-prev-icon"><i class="la la-cutlery"></i></span><span class="sr-only">Previous</span></a><a class="carousel-control-next" href="#carousel-1"
                            role="button" data-slide="next"><span class="carousel-control-next-icon"><i class="la la-cutlery"></i></span><span class="sr-only">Next</span></a></div>
                    
                </div>
                    <!--  -->
                </div>
                <div class="col-md-12 col-lg-5 light-bg cus-pd cus-arrow-left">
                    <p><small>march 27, 2020</small></p>
                    <h3>Product Lauch</h3>
                    <p>
                        With in a Short Period of time We Developed and launched our Product. we promises to our customer without any hassle doing payment Securely.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4 pl-4 mb-4">
            <div class="card">
                <img class="card-img h-100" src="{{asset('images/gallery/IMG-8473.jpg')}}" alt="">
                
            </div>
        </div>

        <div class="col-md-8 mb-4 pr-0 pd-md">
            <div class="card">
                <img class="card-img h-100" src="{{asset('images/gallery/DSC_1294.JPG')}}" alt="">
                <div class="card-img-overlay">
                    <div class="contact-box">
                        <p><small>march 27, 2020</small></p>
                        <h3>Conferences</h3>
                        <p>We facing new challenges while Developing. when it comes we manage with conference meeting and works goes Easily.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 pl-4 mb-4">
            <div class="card">
                <img class="card-img-top" src="{{asset('images/gallery/AF1A8781.JPG')}}" alt="AF1A8781.JPG"> 
                <div class="card-body bg-gray cus-pd2 cus-arrow-up">
                    <p><small>march 27, 2020</small></p>
                    <h3>Team work</h3>
                    <p>Our team is your team. When your mission is to be better, faster and smarter, you need the best people driving your vision forward. You need people who can create focused marketing strategies that align with business goals, who can infuse their creativity into groundbreaking campaigns, and who can analyze data to optimize every tactic along the way.                        .</p>
                </div>
            </div>
        </div>

        <div class="col-md-8 mb-4">
            <div class="row">
                <div class="col-md-12 col-lg-7 pr-0 pd-md">
                    <img src="{{asset('images/gallery/AF1A8592.JPG')}}" alt="AF1A8592.JPG">
                </div>
                <div class="col-md-12 col-lg-5 light-bg cus-pd cus-arrow-left">
                    <p><small>march 27, 2020</small></p>
                    <h3>Our Management</h3>
                    <p>
                        The Management of Rupayapay will treat every employee as a friendly manner. they encourage every Employee to learn skills in the Developement.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4 pl-4 mb-4">
            <div class="card">
                <img class="card-img h-100" src="{{asset('images/gallery/DSC_1175.JPG')}}" alt="DSC_1175.JPG">
                
            </div>
        </div>


    </div>
    </div>
    
    
    <div id="last-section">
        <div class="container container-5">
            @foreach($footer as $index => $row)
                <div class="card">
                    <img src="{{asset('images/gallery/'.$row['image_name'])}}">
                    <div class="card__head">{{$row["content"]}}</div>
                </div>
            @endforeach
        </div>
    </div>
    <!-- End  Contact Area -->
</div>
</div>
@endsection