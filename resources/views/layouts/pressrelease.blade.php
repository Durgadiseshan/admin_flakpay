@php
    use App\AppOption;
@endphp
@extends('layouts.rupayapayapp')
@section('content')
<!--================Banner Area =================-->
<section class="banner_area">
    <div class="container">
        <div class="banner_inner_text">
            <h2>Press & Release</h2>
            <p>Read the news</p>
        </div>
    </div>
</section>
<!--================End Banner Area =================-->
<!--================Blog Main Area =================-->
<section class="blog_main_area p_100 mt-5">
    <div class="container">
        <div class="row">
            @yield('prcontent')
            <div class="col-xl-3 col-lg-4 col-md-5 sidebar">
                <div id="stickySidebar">
                    <div class="widget-item">
                        <div class="categories-widget">
                            <h4 class="widget-title">categories</h4>
                            <ul>
                                @foreach(AppOption::get_category_post_count() as $category)
                                    <li><a href="#">{{$category->blog_category}}<span>({{$category->no_of_posts}})</span></a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="widget-item">
                        <h4 class="widget-title">Recent Post</h4>
                        <div class="trending-widget">
                            @if(!empty($recent_posts))
                                @foreach($recent_posts as $post)
                                    <div class="tw-item">
                                        <div class="tw-thumb">
                                            <img src="{{asset('/small-thumbnails/press-release/'.$post->image)}}" width="100" alt="{{$post->image}}">
                                        </div>
                                        <div class="tw-text">
                                            <div class="tw-meta"><i class="fa fa-clock"></i> {{$post->created_date}}</div>
                                            <h5>{{$post->title}}</h5>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="widget-item">
                        <a href="#" class="add">
                            <img src="{{asset('storage/pressrelease/add.jpg')}}" alt="">
                        </a>
                    </div>
                </div>
            </div>
            <!--  -->
        </div>
        
    </div>
</section>
@endsection