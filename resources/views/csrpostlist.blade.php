@php
  use Illuminate\Support\Str;
@endphp
@extends('layouts.csr')
@section('csrcontent')
@if(!empty($posts))
<div class="row">
  @foreach($posts as $post)
  <div class="big-blog-item col-xl-6">
    <img src="{{asset('storage/csr/'.$post->image)}}" alt="{{$post->image}}" class="blog-thumbnail">
    <div class="blog-content text-box text-white">
        <div class="top-meta"><i class="fas fa-clock"></i> {{$post->created_date}}</div>
        <h3>{{$post->title}}</h3>
        {!! Str::words(strip_tags($post->description),50,$end='...') !!}
        <a href="{{route('csr-post',$post->post_gid)}}" class="read-more">Read More <img src="{{asset('storage/csr/icons/double-arrow.png')}}" alt="#"/></a>
    </div>
  </div>
  @endforeach
</div>
<div class="site-pagination">
    <a href="{{$posts->previousPageUrl()}}">Prev.</a>
    <a href="#" class="active">{{$posts->currentPage()}}</a>
    <a href="{{$posts->nextPageUrl()}}">Next.</a>
</div>
@endif
@endsection
