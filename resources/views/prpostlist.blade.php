@php
use Illuminate\Support\Str;
@endphp
@extends('layouts.pressrelease')
@section('prcontent')
@if(!empty($posts))
<div class="col-lg-9">
    <div class="blog_main_inner">
        @foreach($posts as $post)
        <div class="blog_main_item">
            <div class="blog_img">
                <img class="img-fluid" src="{{asset('storage/press-release/'.$post->image)}}" alt="{{$post->image}}">
                <div class="blog_date">
                    <h4>{{$post->created_day}}</h4>
                    <h5>{{$post->created_monthyear}}</h5>
                </div>
            </div>
            <div class="blog_text">
                <a href="{{route('pr-post',$post->post_gid)}}"><h4>{{$post->title}}</h4></a>
                <div class="blog_author">
                    <a href="#">By {{$post->created_user}}</a>
                </div>
                {!! Str::words(strip_tags($post->description),50,$end='...') !!}
            </div>
        </div>
@endforeach
    </div>
    <div class="pagination_area">
        <div class="pagination">
            <ul class="justify-content-center">
                <li><a href="{{$posts->previousPageUrl()}}"><i class="fa fa-rounded-left"></i></a></li>
                <li class="active"><a href="#">{{$posts->currentPage()}}</a></li>
                <li><a href="{{$posts->nextPageUrl()}}"><i class="fa fa-chevron-right"></i></a></li>
              </ul>
        </div>
    </div>
</div>
@endif
@endsection