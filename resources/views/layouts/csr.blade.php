@php
    use App\AppOption;
@endphp
@extends('layouts.rupayapayapp')
@section('content')
<!-- Page top section -->
<section class="page-top-section set-bg">
    <div class="page-info">
        <h2>Corporate Social Responsibility</h2>
        <div class="site-breadcrumb">
           <p class="text-white">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nihil porro quos quasi,</p>
           <p class="text-white"> adipisci inventore ipsa numquam magni laudantium obcaecati accusantium. Fugit quas inventore nam.</p>
        </div>
    </div>
</section>
<!-- Page top end-->


<!-- Blog page -->
<section class="blog-page">
    <div class="container">
        <div class="row">
            <div class="col-xl-9 col-lg-8 col-md-7">
               @yield('csrcontent')
            </div>
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
                                            <img src="{{asset('/small-thumbnails/csr/'.$post->image)}}" width="100" alt="{{$post->image}}">
                                        </div>
                                        <div class="tw-text">
                                            <div class="tw-meta"><i class="fas fa-clock"></i> {{$post->created_date}}</div>
                                            <h5>{{$post->title}}</h5>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="widget-item">
                        <a href="#" class="add">
                            <img src="./img/add.jpg" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Blog page end-->
@endsection
