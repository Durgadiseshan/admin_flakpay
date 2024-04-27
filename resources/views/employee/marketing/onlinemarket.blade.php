@php
    use App\AppOption;
@endphp
@extends('layouts.employeecontent')
@section('employeecontent')
<div class="row">
    <div class="col-sm-12 padding-20">
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs" id="transaction-tabs">
                    @if(count($sublinks) > 0)
                    @foreach($sublinks as $index => $value)
                        @if($index == 0)
                            <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#{{str_replace(' ','-',strtolower($value->link_name))}}">{{$value->link_name}}</a></li> 
                        @else
                        <li><a data-toggle="tab" class="show-pointer" data-target="#{{str_replace(' ','-',strtolower($value->link_name))}}">{{$value->link_name}}</a></li>
                        @endif
                    @endforeach
                    @else
                        <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#{{str_replace(' ','-',strtolower($sublink_name))}}">{{$sublink_name}}</a></li> 
                    @endif
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    @if(count($sublinks) > 0)
                    @foreach($sublinks as $index => $value)
                        @switch($index)
                            @case(0)
                                <div id="{{str_replace(' ','-',strtolower($value->link_name))}}" class="tab-pane fade in active">
                            
                                </div>
                            @break
                            @case(1)
                                <div id="{{str_replace(' ','-',strtolower($value->link_name))}}" class="tab-pane fade">
                            
                                </div>
                                @break 
                            @case(2)
                                <div id="{{str_replace(' ','-',strtolower($value->link_name))}}" class="tab-pane fade">
                                    <div class="row padding-20">
                                        <a class="btn btn-primary pull-right btn-sm" data-toggle="modal" id="call-post-modal">Add a Post</a>
                                        <div class="modal" id="blog-post-modal">
                                            <div class="modal-dialog">
                                                <div class="modal-content modal-lg">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title">Add a post to blog</h4>
                                                    </div>
                                                    <div id="add-a-post-blog-form-success" class="text-center"></div>
                                                    <form id="add-a-post-blog-form" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="input" class="col-sm-2 control-label">Category:</label>
                                                                <div class="col-sm-10">
                                                                    <select name="post_category" id="post_category" class="form-control">
                                                                        <option value="">--Select--</option>
                                                                        @foreach(AppOption::get_blog_category() as $category)
                                                                        <option value="{{$category->id}}">{{$category->option_value}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <div id="post_category_error"></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="input" class="col-sm-2 control-label">Title:</label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" name="title" id="title" class="form-control" value="">
                                                                    <div id="title_error"></div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label for="input" class="col-sm-2 control-label">Seo URL:</label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" name="post_gid" id="post_gid" class="form-control" value="">
                                                                    <div id="post_gid_error"></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="textarea" class="col-sm-2 control-label">Description:</label>
                                                                <div class="col-sm-10">
                                                                    <textarea name="description" id="description" class="form-control" rows="10"></textarea>
                                                                    <div id="description_error"></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div id="show-image-upload">
                                                                    <label for="input" class="col-sm-2 control-label">Image:</label>
                                                                    <div class="col-sm-10">
                                                                    <input type="file" name="image" id="file-2" class="inputfile inputfile-2" data-multiple-caption="{count} files selected" multiple />
                                                                    <label for="file-2" class="custom-file-upload">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> 
                                                                        <span>
                                                                            Choose a file&hellip;
                                                                        </span>
                                                                    </label>
                                                                    <div id="image_error"></div>
                                                                    </div>
                                                                </div>
                                                                <div id="show-image">
                                                                    <label for="input" class="col-sm-2 control-label">Image:</label>
                                                                    <div class="col-sm-8">
                                                                        <a id="download-blog-image" href="javascript:void(0)" title=""><h5><i class="fa fa-picture-o fa-lg">&nbsp;&nbsp;<span id="post-image-name">Image</span></i>&nbsp;
                                                                        </h5></a>
                                                                    </div>
                                                                    <div class="col-sm-2 text-danger" id="remove-blog-image"><i class="fa fa-times fa-lg text-danger show-pointer vertical-align-center"></i>Remove</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <div class="form-group">
                                                                <div class="col-sm-10 col-sm-offset-2">
                                                                    <button type="submit" class="btn btn-primary">Post</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="id" id="id" class="form-control" value="">
                                                        {{csrf_field()}}
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="modal fade" id="delete-post-modal">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    Are your sure would you like to delete Post?
                                                </div>
                                                <div class="modal-footer">
                                                    <form method="POST" role="form" id="delete-post-form">
                                                        <input type="hidden" name="id" id="id" value="">
                                                        {{csrf_field()}}
                                                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary btn-sm">Delete</button>
                                                    </form>                                            
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div id="paginate_blogpost">
        
                                            </div>
                                        </div>
                                    </div>
        
                                </div>
                                @break
                                
                            @case(3)
                                <div id="{{str_replace(' ','-',strtolower($value->link_name))}}" class="tab-pane fade">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div id="paginate_lead">
        
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @break
                            
                            @case(4)
                                <div id="{{str_replace(' ','-',strtolower($value->link_name))}}" class="tab-pane fade">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div id="paginate_subscribe">
        
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @break
                            @case(5)
                                <div id="{{str_replace(' ','-',strtolower($value->link_name))}}" class="tab-pane fade">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <a id="call-gallery-modal" data-toggle="modal" class="btn btn-primary btn-sm pull-right">Add Image</a>
                                        </div>
                                    </div>
                                    <div class="row padding-top-30">
                                        <div class="col-sm-12">
                                            <div id="paginate_image">
        
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="modal" id="add-gallery-modal">
                                        <div class="modal-dialog">
                                            <div class="modal-content modal-lg">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title">Add New Image</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div id="add-gallery-image-success" class="text-center text-success"></div>
                                                    <div id="add-gallery-image-failed" class="text-center text-danger"></div>
                                                    <form id="add-gallery-form" method="POST" class="form-horizontal" role="form" autocomplete="off" enctype="multipart/form-data">
                                                        <div class="form-group">
                                                            <label for="input" class="col-sm-2 control-label">Select Area:</label>
                                                            <div class="col-sm-6">
                                                                <select name="image_position" id="image_position" class="form-control" onchange="enableInput(this);" required>
                                                                    <option value="">--Select--</option>
                                                                    @foreach(AppOption::get_gallery_option() as $option)
                                                                        <option value="{{$option->id}}">{{$option->option_value}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="input" class="col-sm-2 control-label">Choose Image:</label>
                                                            <div class="form-file form-file-lg mb-3">
                                                                <div class="col-sm-6">
                                                                    <input type="file" class="form-file-input" id="image_name" name="image_name" required>
                                                                    <label class="form-file-label" for="customFileLg">
                                                                        <span class="form-file-text">Choose file...</span>
                                                                        <span class="form-file-button">Browse</span>
                                                                    </label>
                                                                    <div id="image_name_error" class="text-danger"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id="show-content-input" style="display:none;">
                                                            <div class="form-group">
                                                                <label for="textarea" class="col-sm-2 control-label">Image Content:</label>
                                                                <div class="col-sm-8">
                                                                    <textarea name="image_content" id="image_content" class="form-control" rows="5" cols="10" maxlength="250"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id="show-heading-input" style="display:none;">
                                                            <div class="form-group">
                                                                <label for="input" class="col-sm-2 control-label">Image Heading:</label>
                                                                <div class="col-sm-6">
                                                                    <input type="text" name="image_heading" id="image_heading" class="form-control" value="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{csrf_field()}}
                                                        <div class="form-group">
                                                            <div class="col-sm-9 col-sm-offset-2">
                                                                <button type="submit" class="btn btn-primary">Upload</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal" id="edit-gallery-modal">
                                        <div class="modal-dialog">
                                            <div class="modal-content modal-lg">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title">Edit Image</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div id="edit-gallery-image-success" class="text-center text-success"></div>
                                                    <div id="edit-gallery-image-failed" class="text-center text-danger"></div>
                                                    <form id="edit-gallery-form" method="POST" class="form-horizontal" role="form" autocomplete="off" enctype="multipart/form-data">
                                                        <div class="form-group">
                                                            <label for="input" class="col-sm-2 control-label">Select Area:</label>
                                                            <div class="col-sm-6">
                                                                <select name="image_position" id="image_position" class="form-control" onchange="enableInput(this);" required>
                                                                    <option value="">--Select--</option>
                                                                    @foreach(AppOption::get_gallery_option() as $option)
                                                                        <option value="{{$option->id}}">{{$option->option_value}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div id="upload-image" style="display: none;">
                                                            <div class="form-group">
                                                                <label for="input" class="col-sm-2 control-label">Choose Image:</label>
                                                                <div class="form-file form-file-lg mb-3">
                                                                    <div class="col-sm-6">
                                                                        <input type="file" class="form-file-input" id="image_name" name="image_name" required>
                                                                        <label class="form-file-label" for="customFileLg">
                                                                            <span class="form-file-text">Choose file...</span>
                                                                            <span class="form-file-button">Browse</span>
                                                                        </label>
                                                                        <div id="image_name_error" class="text-center text-danger"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id="show-image">
                                                            <label for="input" class="col-sm-2 control-label">Image:</label>
                                                            <div class="col-sm-8">
                                                                <a id="download-gallery-image" href="javascript:void(0)" title=""><h5><i class="fa fa-picture-o fa-lg">&nbsp;&nbsp;<span id="post-image-name">Image</span></i>&nbsp;
                                                                </h5></a>
                                                            </div>
                                                            <div class="col-sm-2 text-danger" id="remove-gallery-image"><i class="fa fa-times fa-lg text-danger show-pointer vertical-align-center"></i>Remove</div>
                                                        </div>
                                                        <div id="show-content-input" style="display:none;">
                                                            <div class="form-group">
                                                                <label for="textarea" class="col-sm-2 control-label">Image Content:</label>
                                                                <div class="col-sm-8">
                                                                    <textarea name="image_content" id="image_content" class="form-control" rows="5" cols="10" maxlength="250"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id="show-heading-input" style="display:none;">
                                                            <div class="form-group">
                                                                <label for="input" class="col-sm-2 control-label">Image Heading:</label>
                                                                <div class="col-sm-6">
                                                                    <input type="text" name="image_heading" id="image_heading" class="form-control" value="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="id" value="">
                                                        {{csrf_field()}}
                                                        <div class="form-group">
                                                            <div class="col-sm-9 col-sm-offset-2">
                                                                <button type="submit" class="btn btn-primary">Upload</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                                                   
                                </div>
                                @break
                            @case(6)
                                <div id="{{str_replace(' ','-',strtolower($value->link_name))}}" class="tab-pane fade">
                                    <div class="row padding-20">
                                        <a class="btn btn-primary pull-right btn-sm" data-toggle="modal" id="call-event-post-modal">Add Event</a>
                                        <div class="modal" id="event-post-modal">
                                            <div class="modal-dialog">
                                                <div class="modal-content modal-lg">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title">Add an Event</h4>
                                                    </div>
                                                    <div id="add-a-post-event-form-success" class="text-center"></div>
                                                    <form id="add-a-post-event-form" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
                                                        <div class="modal-body set-modal">
                                                            <div class="form-group">
                                                                <label for="input" class="col-sm-3 control-label">Event SEO:</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" name="event_short_url" id="event_short_url" class="form-control" value="">
                                                                    <div id="event_short_url_error"></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="input" class="col-sm-3 control-label">Event Name:</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" name="event_name" id="event_name" class="form-control" value="">
                                                                    <div id="event_name_error"></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="input" class="col-sm-3 control-label">Event Date:</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" name="event_date" id="event_date" class="form-control" value="" placeholder="YYYY-MM-DD">
                                                                    <div id="event_date_error"></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="input" class="col-sm-3 control-label">Event Time:</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" name="event_time" id="event_time" class="form-control" value="" placeholder="HH:MM to HH:MM">
                                                                    <div id="event_date_error"></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="textarea" class="col-sm-3 control-label">Event Description:</label>
                                                                <div class="col-sm-9">
                                                                    <textarea name="event_description" id="event_description" class="form-control" rows="10"></textarea>
                                                                    <div id="event_description_error"></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="input" class="col-sm-3 control-label">Event Venue:</label>
                                                                <div class="col-sm-9">
                                                                    <textarea name="event_venue" id="event_venue" class="form-control" rows="3"></textarea>
                                                                    <div id="event_venue_error"></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="input" class="col-sm-3 control-label">Event Registration:</label>
                                                                <div class="col-sm-9">
                                                                    <div class="radio col-sm-2">
                                                                        <label>
                                                                            <input type="radio" name="event_register" value="free" checked>
                                                                            <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                                                                            Free
                                                                        </label>
                                                                    </div>
                                                                    <div class="radio col-sm-2">
                                                                        <label>
                                                                            <input type="radio" name="event_register" value="paid">
                                                                            <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
                                                                            Paid
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>
                                                            <div class="form-group">
                                                                <div id="show-image-upload">
                                                                    <label for="input" class="col-sm-3 control-label">Image:</label>
                                                                    <div class="col-sm-9">
                                                                    <input type="file" name="event_image" id="file-2" class="inputfile inputfile-2" data-multiple-caption="{count} files selected" multiple />
                                                                    <label for="file-2" class="custom-file-upload">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> 
                                                                        <span>
                                                                            Choose a file&hellip;
                                                                        </span>
                                                                    </label>
                                                                    <div id="event_image"></div>
                                                                    </div>
                                                                </div>
                                                                <div id="show-image">
                                                                    <label for="input" class="col-sm-3 control-label">Image:</label>
                                                                    <div class="col-sm-7">
                                                                        <a id="download-event-image" href="javascript:void(0)" title=""><h5><i class="fa fa-picture-o fa-lg">&nbsp;&nbsp;<span id="post-image-name">Image</span></i>&nbsp;
                                                                        </h5></a>
                                                                    </div>
                                                                    <div class="col-sm-2 text-danger" id="remove-event-image"><i class="fa fa-times fa-lg text-danger show-pointer vertical-align-center"></i>Remove</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <div class="form-group">
                                                                <div class="col-sm-9 col-sm-offset-3">
                                                                    <button type="submit" class="btn btn-primary">POST</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="id" id="id" class="form-control" value="">
                                                        {{csrf_field()}}
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="modal" id="delete-event-post-modal">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    Are your sure would you like to delete Post?
                                                </div>
                                                <div class="modal-footer">
                                                    <form method="POST" role="form" id="delete-event-post-form">
                                                        <input type="hidden" name="id" id="id" value="">
                                                        {{csrf_field()}}
                                                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary btn-sm">Delete</button>
                                                    </form>                                            
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div id="paginate_eventpost">
        
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @break
                            @case(7)
                                <div id="{{str_replace(' ','-',strtolower($value->link_name))}}" class="tab-pane fade">
                                    <div class="row padding-20">
                                        <a class="btn btn-primary pull-right btn-sm" data-toggle="modal" id="call-csr-post-modal">Add a CSR Post</a>
                                        <div class="modal" id="csr-post-modal">
                                            <div class="modal-dialog">
                                                <div class="modal-content modal-lg">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title">Add a post to CSR</h4>
                                                    </div>
                                                    <div id="add-a-post-csr-form-success" class="text-center"></div>
                                                    <form id="add-a-post-csr-form" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="input" class="col-sm-2 control-label">Category:</label>
                                                                <div class="col-sm-10">
                                                                    <select name="post_category" id="post_category" class="form-control">
                                                                        <option value="">--Select--</option>
                                                                        @foreach(AppOption::get_blog_category() as $category)
                                                                        <option value="{{$category->id}}">{{$category->option_value}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <div id="post_category_error"></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="input" class="col-sm-2 control-label">Title:</label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" name="title" id="title" class="form-control" value="">
                                                                    <div id="title_error"></div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label for="input" class="col-sm-2 control-label">Seo URL:</label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" name="post_gid" id="post_gid" class="form-control" value="">
                                                                    <div id="post_gid_error"></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="textarea" class="col-sm-2 control-label">Description:</label>
                                                                <div class="col-sm-10">
                                                                    <textarea name="description" id="description" class="form-control" rows="10"></textarea>
                                                                    <div id="description_error"></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div id="show-image-upload">
                                                                    <label for="input" class="col-sm-2 control-label">Image:</label>
                                                                    <div class="col-sm-10">
                                                                    <input type="file" name="image" id="file-2" class="inputfile inputfile-2" data-multiple-caption="{count} files selected" multiple />
                                                                    <label for="file-2" class="custom-file-upload">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> 
                                                                        <span>
                                                                            Choose a file&hellip;
                                                                        </span>
                                                                    </label>
                                                                    <div id="image_error"></div>
                                                                    </div>
                                                                </div>
                                                                <div id="show-image">
                                                                    <label for="input" class="col-sm-2 control-label">Image:</label>
                                                                    <div class="col-sm-8">
                                                                        <a id="download-blog-image" href="javascript:void(0)" title=""><h5><i class="fa fa-picture-o fa-lg">&nbsp;&nbsp;<span id="post-image-name">Image</span></i>&nbsp;
                                                                        </h5></a>
                                                                    </div>
                                                                    <div class="col-sm-2 text-danger" id="remove-csr-image"><i class="fa fa-times fa-lg text-danger show-pointer vertical-align-center"></i>Remove</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <div class="form-group">
                                                                <div class="col-sm-10 col-sm-offset-2">
                                                                    <button type="submit" class="btn btn-primary">Post</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="id" id="id" class="form-control" value="">
                                                        {{csrf_field()}}
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="modal" id="delete-csr-post-modal">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    Are your sure would you like to delete Post?
                                                </div>
                                                <div class="modal-footer">
                                                    <form method="POST" role="form" id="delete-csr-post-form">
                                                        <input type="hidden" name="id" id="id" value="">
                                                        {{csrf_field()}}
                                                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary btn-sm">Delete</button>
                                                    </form>                                            
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div id="paginate_csrpost">
        
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @break

                            @case(8)
                                <div id="{{str_replace(' ','-',strtolower($value->link_name))}}" class="tab-pane fade">
                                    <div class="row padding-20">
                                        <a class="btn btn-primary pull-right btn-sm" data-toggle="modal" id="call-pr-post-modal">Add Press Release Post</a>
                                        <div class="modal" id="pr-post-modal">
                                            <div class="modal-dialog">
                                                <div class="modal-content modal-lg">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title">Add a post to CSR</h4>
                                                    </div>
                                                    <div id="add-a-post-pr-form-success" class="text-center"></div>
                                                    <form id="add-a-post-pr-form" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="input" class="col-sm-2 control-label">Category:</label>
                                                                <div class="col-sm-10">
                                                                    <select name="post_category" id="post_category" class="form-control">
                                                                        <option value="">--Select--</option>
                                                                        @foreach(AppOption::get_blog_category() as $category)
                                                                        <option value="{{$category->id}}">{{$category->option_value}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <div id="post_category_error"></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="input" class="col-sm-2 control-label">Title:</label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" name="title" id="title" class="form-control" value="">
                                                                    <div id="title_error"></div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label for="input" class="col-sm-2 control-label">Seo URL:</label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" name="post_gid" id="post_gid" class="form-control" value="">
                                                                    <div id="post_gid_error"></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="textarea" class="col-sm-2 control-label">Description:</label>
                                                                <div class="col-sm-10">
                                                                    <textarea name="description" id="description" class="form-control" rows="10"></textarea>
                                                                    <div id="description_error"></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div id="show-image-upload">
                                                                    <label for="input" class="col-sm-2 control-label">Image:</label>
                                                                    <div class="col-sm-10">
                                                                    <input type="file" name="image" id="file-2" class="inputfile inputfile-2" data-multiple-caption="{count} files selected" multiple />
                                                                    <label for="file-2" class="custom-file-upload">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> 
                                                                        <span>
                                                                            Choose a file&hellip;
                                                                        </span>
                                                                    </label>
                                                                    <div id="image_error"></div>
                                                                    </div>
                                                                </div>
                                                                <div id="show-image">
                                                                    <label for="input" class="col-sm-2 control-label">Image:</label>
                                                                    <div class="col-sm-8">
                                                                        <a id="download-blog-image" href="javascript:void(0)" title=""><h5><i class="fa fa-picture-o fa-lg">&nbsp;&nbsp;<span id="post-image-name">Image</span></i>&nbsp;
                                                                        </h5></a>
                                                                    </div>
                                                                    <div class="col-sm-2 text-danger" id="remove-pr-image"><i class="fa fa-times fa-lg text-danger show-pointer vertical-align-center"></i>Remove</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <div class="form-group">
                                                                <div class="col-sm-10 col-sm-offset-2">
                                                                    <button type="submit" class="btn btn-primary">Post</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="id" id="id" class="form-control" value="">
                                                        {{csrf_field()}}
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="modal" id="delete-pr-post-modal">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    Are your sure would you like to delete Post?
                                                </div>
                                                <div class="modal-footer">
                                                    <form method="POST" role="form" id="delete-pr-post-form">
                                                        <input type="hidden" name="id" id="id" value="">
                                                        {{csrf_field()}}
                                                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary btn-sm">Delete</button>
                                                    </form>                                            
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div id="paginate_prpost">
        
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @break

                        @endswitch
                    @endforeach
                    @endif
                </div>
            </div>
        </div>    
    </div>
</div>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded',function(e){
        e.preventDefault();
        getAllPost();
        $('#description').summernote({height:200});
        $('#add-a-post-csr-form #description').summernote({height:200});
        $('#add-a-post-pr-form #description').summernote({height:200});
        $('#add-a-post-event-form #event_description').summernote({height:150});
        $('#add-gallery-form #image_content').summernote({height:200,
            toolbar: [
          ['style', ['style']],
          ['color', ['color']],
          ['font', ['bold', 'underline', 'clear']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['insert', ['link']],
          ['view', ['fullscreen', 'codeview', 'help']]
        ]});
        $('#edit-gallery-form #image_content').summernote({height:200,
            toolbar: [
          ['style', ['style']],
          ['color', ['color']],
          ['font', ['bold', 'underline', 'clear']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['insert', ['link']],
          ['view', ['fullscreen', 'codeview', 'help']]
        ]});

    });
</script>
@endsection
