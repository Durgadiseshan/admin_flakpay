@php
use Illuminate\Support\Str;
@endphp
@extends('layouts.blog')
@section('postcontent')
@if(!empty($posts))
    <div class="row">
      @foreach($posts as $post)
        <div class="col-md-6 d-flex align-items-stretch">
          <article class="entry">

              <div class="entry-img text-center">
                  <img src="{{asset('/thumbnails/blog/'.$post->image)}}" alt="{{$post->image}}" class="img-fluid">
                  <!-- <img src="--{{asset('/storage/blog/images/'.$post->image)}}--" alt="{{$post->image}}" class="img-fluid" width="350" height="250"> -->
              </div>

              <h2 class="entry-title">
                <a href="{{route('blog-post',$post->post_gid)}}">{{$post->title}}</a>
              </h2>

              <div class="entry-meta">
                <ul>
                    <li class="d-flex align-items-center"><i class="fa fa-user"></i> <a href="blog-single.html">{{$post->created_user}}</a></li>
                    <li class="d-flex align-items-center"><i class="fa fa-clock-o"></i> <a href="blog-single.html"><time datetime="2020-01-01">{{$post->created_date}}</time></a></li>
                </ul>
              </div>

              <div class="entry-content">
                <div>
                  {!! Str::words(strip_tags($post->description),50,$end='...') !!}
                </div>
                <div class="read-more">
                    <a href="{{route('blog-post',$post->post_gid)}}">Read More</a>
                </div>
              </div>

          </article><!-- End blog entry -->
        </div>
      @endforeach
    </div>
    <div class="blog-pagination">
			<ul class="justify-content-center">
			  <li><a href="{{$posts->previousPageUrl()}}"><i class="fa fa-rounded-left"></i></a></li>
			  <li class="active"><a href="#">{{$posts->currentPage()}}</a></li>
			  <li><a href="{{$posts->nextPageUrl()}}"><i class="fa fa-chevron-right"></i></a></li>
			</ul>
		</div>
@endif
@endsection