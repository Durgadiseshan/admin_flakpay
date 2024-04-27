@extends('layouts.event')
@section('eventcontent')
<!-- End Intro Section -->
<div class="container eventDetail">
    <!-- 2 columns card -->
    <div class="col-lg-10 card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-6">
                <img src="/storage/event/{{$post->event_image}}" alt="{{$post->event_image}}">
              </div>
              <div class="col-lg-6">
                 <div class="row">
                     <div class="col-sm-12">
                        <p>An interactive session on</p>
                        <h4 style="font-size: 25px;">{{$post->event_name}}</h4>
                     </div>
                </div>
                <div class="row mt-5">
                    <div class="col-sm-8">
                        @if($post->register_open == 'Y')
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-success btn-block" data-toggle="modal">
                            Register Now
                        </button>
                        @else
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-danger btn-block" data-toggle="modal" disabled>
                            Registration Closed
                        </button>
                        @endif
                    </div>
                </div>
              </div>
          </div>
        </div>
        <div class="card-block">
            <div class="row">
                <div class="col-lg-6 tags p-b-2">
                   <h4>About this event !!</h4>
                   <div>
                       {!! $post->event_description !!}
                   </div>
                </div>
                <div class="col-lg-4 offset-lg-1">
                    <div class="row card card-outline-success m-x-auto m-b-2">
                        <div class="col-md-7 text-xs-center text-white bg-success p-y-1">
                            <h4 class="text-white">Date & Time</h4>
                        </div>
                        <div class="col-md-12 text-xs-center text-success p-y-1">
                            <p>{{$post->event_date}}</p>
                            <p>{{$post->event_time}}</p>
                        </div>
                    </div>
                    <div class="row card card-outline-primary m-x-auto m-b-2">
                        <div class="col-md-7 text-xs-center bg-primary p-y-1">
                            <h4 class="text-white">Venue</h4>
                        </div>
                        <div class="col-md-12 text-xs-center text-primary p-y-1">
                            <p>{{$post->event_venue}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/card-block-->
    </div>
    <!-- /2 columns card -->
</div>
@endsection