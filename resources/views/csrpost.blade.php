@extends('layouts.csr')
@section('csrcontent')
<article class="entry entry-single">
    <h2 class="entry-title">
      <a href="{{route('csr-post',$post->post_gid)}}" class="csr-heading">{{$post->title}}</a>
    </h2>
    <div class="entry-img text-center">
      <img src="{{asset('/storage/csr/'.$post->image)}}" alt="{{$post->image}}" class="img-fluid">
    </div>
    <div class="entry-meta">
      <ul>
        <li class="d-flex align-items-center"><i class="fa fa-user text-white"></i> <a href="#">&nbsp;{{$post->created_user}}</a></li>
        <li class="d-flex align-items-center"><i class="fa fa-clock text-white"></i> <a href="#"><time datetime="2020-01-01">&nbsp;{{$post->created_date}}</time></a></li>
        <!-- <li class="d-flex align-items-center"><i class="fa fa-file-text"></i> <a href="#">12</a></li> -->
      </ul>
    </div>

    <div class="entry-content">
        {!! $post->description !!}
    </div>

    <div class="entry-footer clearfix">
      <div class="float-left">
        <i class="fa fa-folder text-white"></i>
        <ul class="cats">
          <li><a href="#">{{$post->category_name}}</a></li>
        </ul>
        <!--<i class="fa fa-tags"></i>
         <ul class="tags">
          <li><a href="#">Creative</a></li>
          <li><a href="#">Tips</a></li>
          <li><a href="#">Marketing</a></li>
        </ul> -->
      </div>

      <div class="float-right share">
        <a href="" title="Share on Twitter"><i class="icofont-twitter"></i></a>
        <a href="" title="Share on Facebook"><i class="icofont-facebook"></i></a>
        <a href="" title="Share on Instagram"><i class="icofont-instagram"></i></a>
      </div>

    </div>
</article><!-- End blog entry -->
@endsection