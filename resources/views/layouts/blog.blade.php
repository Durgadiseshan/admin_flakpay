@php
    use App\AppOption;
@endphp
@extends('layouts.rupayapayapp')
@section('content')
 <!-- ======= Breadcrumbs ======= -->
 <section id="breadcrumbs" class="breadcrumbs">
	<div class="container">
	  <ol>
		<li><a href="/">Home</a></li>
		<li>Blog</li>
	  </ol>
	  <h2>Blog</h2>
	</div>
  </section>
<!-- End Breadcrumbs -->
<!-- ======= Blog Section Starts ======= -->
<section id="blog" class="blog">
	<div class="container">
	  <div class="row">
			<div class="col-lg-8 entries">
				@yield('postcontent')
			</div>
			<!-- End blog entries list -->
			<div class="col-lg-4">

				<div class="sidebar">
			
				<!-- <h3 class="sidebar-title">Search</h3>
				<div class="sidebar-item search-form">
					<form action="">
					<input type="text" placeholder="Search">
					<button type="submit"><i class="fa fa-search"></i></button>
					</form>
			
				</div> -->
				
				<!-- End sidebar search formn-->
			
				<h3 class="sidebar-title">Categories</h3>
				<div class="sidebar-item categories">
					<ul>
					@foreach(AppOption::get_category_post_count() as $category)
						<li><a href="#">{{$category->blog_category}}<span>({{$category->no_of_posts}})</span></a></li>
					@endforeach
					</ul>
			
				</div><!-- End sidebar categories-->
			
				<h3 class="sidebar-title">Recent Posts</h3>
				<div class="sidebar-item recent-posts">
					@if(!empty($recent_posts))
					@foreach($recent_posts as $post)
						<div class="post-item clearfix">
						<img src="{{asset('/small-thumbnails/blog/'.$post->image)}}" alt="{{$post->image}}">
						<h4><a href="{{route('blog-post',$post->post_gid)}}">{{$post->title}}</a></h4>
						<time>{{$post->created_date}}</time>
						</div>
					@endforeach
					@endif
				</div><!-- End sidebar recent posts-->
			
				<!-- <h3 class="sidebar-title">Tags</h3>
				<div class="sidebar-item tags">
					<ul>
					<li><a href="#">App</a></li>
					<li><a href="#">IT</a></li>
					<li><a href="#">Business</a></li>
					<li><a href="#">Business</a></li>
					<li><a href="#">Mac</a></li>
					<li><a href="#">Design</a></li>
					<li><a href="#">Office</a></li>
					<li><a href="#">Creative</a></li>
					<li><a href="#">Studio</a></li>
					<li><a href="#">Smart</a></li>
					<li><a href="#">Tips</a></li>
					<li><a href="#">Marketing</a></li>
					</ul>
			
				</div> -->
				
				<!-- End sidebar tags-->
			
				</div><!-- End sidebar -->
			
			</div>
			<!-- End blog sidebar -->
	  </div>
	</div>
  </section><!-- End Blog Section -->
  
  <!-- Blog Section End -->
@endsection