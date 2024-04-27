@php
use Illuminate\Support\Str;
@endphp
@extends('layouts.event')
@section('eventcontent')
<!--================Blog Main Area =================-->
<section class="blog_main_area">
    <div class="container">
      <div class="row">
        <div class="col-lg-9">
          <div class="blog_main_inner">
            @if(!empty($recent_events))
            <div class="blog_main_item">
              <div class="blog_img">
                <img class="img-fluid" src="/storage/event/{{$recent_events[0]['event_image']}}" width="850"  alt="{{$recent_events[0]['event_image']}}">
                <div class="blog_date">
                  <h5>{{$recent_events[0]['event_date']}}</h5>
                </div>
              </div>
              <div class="blog_text">
                <a href="{{route('event-post',$recent_events[0]['event_short_url'])}}"><h4>{{$recent_events[0]['event_name']}}</h4></a>
                <p>{!! Str::words(strip_tags($recent_events[0]['event_description']),50,$end='...') !!}</p>
              </div>
            </div>
            @endif
          </div>
        </div>
      
        <div class="col-xl-3 col-lg-3 col-md-5 sidebar">
          <div id="stickySidebar">
            <div class="widget-item">
              @if(count($past_events) > 0)
              <h4 class="widget-title">Past Events</h4>
                <div class="trending-widget">
                    @foreach($past_events as $index => $event)
                    <div class="tw-item">
                        <div class="tw-thumb">
                            <a href="{{route('event-post',$event['event_short_url'])}}">
                            <img src="/small-thumbnails/event/{{$event['event_image']}}" width="100" alt="{{$event['event_image']}}">
                            </a>
                          </div>
                        <div class="tw-text">
                            <div class="tw-meta"><i class="fa fa-clock"></i> {{$event['event_date']}}</div>
                            <h5>{{$event['event_name']}}</h5>
                        </div>
                    </div>
                    @endforeach
                </div>
              @endif
            </div>
            <div class="widget-item">
              @if(count($recent_events) > 0)
              <h4 class="widget-title">Recent Events</h4>
                <div class="trending-widget">
                    @foreach($recent_events as $index => $event)
                    <div class="tw-item">
                        <div class="tw-thumb">
                            <a href="{{route('event-post',$event['event_short_url'])}}">
                            <img src="/small-thumbnails/event/{{$event['event_image']}}" width="100" alt="{{$event['event_image']}}">
                            </a>
                          </div>
                        <div class="tw-text">
                            <div class="tw-meta"><i class="fa fa-clock"></i> {{$event['event_date']}}</div>
                            <h5>{{$event['event_name']}}</h5>
                        </div>
                    </div>
                    @endforeach
                </div>
              @endif
            </div>
          </div>
        </div>
        <!--  -->
      </div>
      
    </div>
  </section>
  
  
    <!-- Cards -->

    <div class="container past-title mt-3">
      <h4 class="past-head">Past Events</h4>
    </div>
    <div class="container">
      <div class="row">
        @if(count($past_events) > 0)
            @foreach($past_events as $index => $event)
                <div class="col-sm-4">
                <div class="card">
                    <div class="image">
                    <img src="/storage/event/{{$event['event_image']}}" alt="{{$event['event_image']}}"/>
                    </div>
                <a href="{{route('event-post',$event['event_short_url'])}}">
                    <div class="card-inner">
                    <div class="header">
                    <h4>{{$event['event_name']}}</h4>
                    </div>
                    <div class="content">
                    <p>{!! Str::words(strip_tags($event['event_description']),50,$end='...') !!}</p>
                    </div>
                    </div>
                </a>
                    <hr>
                    <p class="pl-4">{{$event['event_date']}}</p>
                </div>
                </div>
            @endforeach
        @else
        <div class="col-sm-4">
          <div class="card">
              <div class="image">
              <img src="/storage/event/images/no-event.png" alt="no-event.png"/>
              </div>
          </div>
        </div>    
        @endif
      </div>
    </div>

    <div class="container past-title mt-3">
        <h4 class="past-head">Upcoming Events</h4>
      </div>
      <div class="container">
        <div class="row">
          @if(count($upcoming_events) > 0)
              @foreach($upcoming_events as $index => $event)
                  <div class="col-sm-4">
                    <div class="card">
                        <div class="image">
                        <img src="/storage/event/{{$event['event_image']}}" alt="{{$event['event_image']}}"/>
                        </div>
                    <a href="{{route('event-post',$event['event_short_url'])}}">
                        <div class="card-inner">
                        <div class="header">
                        <h4>{{$event['event_name']}}</h4>
                        </div>
                        <div class="content">
                        <p>{!! Str::words(strip_tags($event['event_description']),50,$end='...') !!}</p>
                        </div>
                        </div>
                    </a>
                        <hr>
                        <p class="pl-4">{{$event['event_date']}}</p>
                    </div>
                  </div>
              @endforeach
          @else
            <div class="col-sm-4">
              <div class="card">
                  <div class="image">
                  <img src="/storage/event/images/no-event.png" alt="no-event.png"/>
                  </div>
              </div>
            </div>    
          @endif
        </div>
      </div>
    <!-- Cards end -->
@endsection