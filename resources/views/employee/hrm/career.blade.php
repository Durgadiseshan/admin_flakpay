@php
    use App\AppOption;
    $jobcategory = AppOption::get_job_category();
@endphp
@extends('layouts.employeecontent')
@section('employeecontent')
<div class="row">
    <div class="col-sm-12 padding-20">
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs" id="transaction-tabs">
                    <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#posted-jobs">Posted Jobs</a></li>
                    <li><a data-toggle="tab" class="show-pointer" data-target="#applicants">Applicants</a></li> 
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div id="posted-jobs" class="tab-pane fade in active">
                        <div class="row">
                            <div class="col-sm-12">
                                <a id="call-post-job-modal" data-toggle="modal" class="btn btn-primary btn-sm pull-right">Post New Job</a>
                            </div>
                        </div>
                        <div class="row padding-top-md">
                            <div class="col-sm-12">
                                <div id="paginate_job">

                                </div>
                            </div>
                        </div>
                        <div class="modal" id="add-post-job-modal">
                            <div class="modal-dialog">
                                <div class="modal-content modal-lg">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title">Post Job</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div id="add-ajax-success-response" class="text-center text-success"></div>
                                        <div id="add-ajax-fail-response" class="text-center text-danger"></div>
                                        <form id="add-post-job-form" method="POST" class="form-horizontal" role="form" autocomplete="off">
                                            <div class="form-group">
                                                <label for="input" class="col-sm-2 control-label">Job Title:</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="job_title" id="job_title" class="form-control" value="" required="required">
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="input" class="col-sm-2 control-label">Job Category:</label>
                                                <div class="col-sm-10">
                                                    <select name="job_category" id="job_category" class="form-control" required="required">
                                                        <option value="">--Select--</option>
                                                        @foreach($jobcategory as $index => $object)
                                                            <option value="{{$object->id}}">{{$object->option_value}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="textarea" class="col-sm-2 control-label">Job Description:</label>
                                                <div class="col-sm-10">
                                                    <textarea name="job_description" id="job_description" class="form-control" rows="3" required="required"></textarea>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="input" class="col-sm-2 control-label">Job Location:</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="job_location" id="job_location" class="form-control" value="" required="required">
                                                </div>
                                            </div>
                                            {{csrf_field()}}
                                            <div class="form-group">
                                                <div class="col-sm-10 col-sm-offset-2">
                                                    <button type="submit" class="btn btn-primary">Post</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal" id="edit-post-job-modal">
                            <div class="modal-dialog">
                                <div class="modal-content modal-lg">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title">Post Job</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div id="edit-ajax-success-response" class="text-center text-success"></div>
                                        <div id="edit-ajax-fail-response" class="text-center text-danger"></div>
                                        <form id="edit-post-job-form" method="POST" class="form-horizontal" role="form" autocomplete="off">
                                            <div class="form-group">
                                                <label for="input" class="col-sm-2 control-label">Job Title:</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="job_title" id="job_title" class="form-control" value="" required="required">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="input" class="col-sm-2 control-label">Job Category:</label>
                                                <div class="col-sm-10">
                                                    <select name="job_category" id="job_category" class="form-control" required="required">
                                                        <option value="">--Select--</option>
                                                        @foreach($jobcategory as $index => $object)
                                                            <option value="{{$object->id}}">{{$object->option_value}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="textarea" class="col-sm-2 control-label">Job Description:</label>
                                                <div class="col-sm-10">
                                                    <textarea name="job_description" id="job_description" class="form-control" rows="3" required="required"></textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="input" class="col-sm-2 control-label">Job Location:</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="job_location" id="job_location" class="form-control" value="" required="required">
                                                </div>
                                            </div>
                                            {{csrf_field()}}
                                            <input type="hidden" name="id" id="id" value="">
                                            <div class="form-group">
                                                <div class="col-sm-10 col-sm-offset-2">
                                                    <button type="submit" class="btn btn-primary">Update Post</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal" id="remove-post-job-modal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title">Change Job Status</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div id="update-ajax-success-response" class="text-center text-success"></div>
                                        <div id="update-ajax-fail-response" class="text-center text-success"></div>
                                        <form id="update-job-status" method="POST" class="form-horizontal" role="form">
                                            <div class="form-group">
                                                <label for="input" class="col-sm-3 control-label">Job Status:</label>
                                                <div class="col-sm-6">
                                                    <select name="job_status" id="job_status" class="form-control" required="required">
                                                        <option value="active">Active</option>
                                                        <option value="inactive">In Active</option>
                                                    </select>
                                                </div>
                                            </div>
                                            {{csrf_field()}}
                                            <input type="hidden" name="id" id="id" value="">
                                            <div class="form-group">
                                                <div class="col-sm-6 col-sm-offset-3">
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="applicants" class="tab-pane fade">
                        <div class="row padding-top-md">
                            <div class="col-sm-12">
                                <div id="paginate_applicant">

                                </div>
                            </div>
                        </div>

                        <div class="modal" id="applicant-status-modal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title">Change Status</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div id="applicant-status-success" class="text-center text-success"></div>
                                        <div id="applicant-status-fail" class="text-center text-danger"></div>
                                        <form id="applicant-status-form" method="POST" class="form-horizontal" role="form">
                                            <div class="form-group">
                                                <label for="input" class="col-sm-4 control-label">Change Status:</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="applicant_status" id="applicant_status" class="form-control" value="" required="required">
                                                </div>
                                            </div>
                                            {{csrf_field()}}
                                            <input type="hidden" name="id" id="id" value="id">
                                            <div class="form-group">
                                                <div class="col-sm-10 col-sm-offset-4">
                                                    <button type="submit" class="btn btn-primary">Update Status</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded",function(){
        getPostedJobs();
        $('#add-post-job-form #job_description').summernote({height:250,
            toolbar: [
          ['style', ['style']],
          ['color', ['color']],
          ['font', ['bold', 'underline', 'clear']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['insert', ['link']],
          ['view', ['fullscreen', 'codeview', 'help']]
        ]});
        $('#edit-post-job-form #job_description').summernote({height:250,
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
