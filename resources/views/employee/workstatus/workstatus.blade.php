@extends('layouts.employeecontent')
@section('employeecontent')
<div class="row">
    <div class="col-sm-12 padding-20">
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#work-status">Work Status</a></li> 
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div id="work-status" class="tab-pane fade in active">
                        <div class="row">
                            <div class="col-sm-12">
                                <a class="btn btn-primary btn-sm pull-right" data-toggle="modal" id="call-work-status-modal">New Work Status</a>
                            </div>
                        </div>
                        <div class="row padding-top-md">
                            <div class="col-sm-12">
                                <div id="paginate_workstatus">  

                                </div>
                            </div>
                        </div>

                        <div class="modal" id="work-status-modal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title">Employee Work Status</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div id="work-status-success-response" class="text-center text-success"></div>
                                        <div id="work-status-failed-response" class="text-center text-danger"></div>
                                        <form id="work-status-form" method="POST" class="form-horizontal" role="form" autocomplete="off">
                                            <div class="form-group">
                                                <label for="input" class="col-sm-3 control-label">Work Date: <span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="today_date" id="today_date" class="form-control" value="" placeholder="DD-MM-YYYY">
                                                    <div id="today_date_error" class="text-danger"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="textarea" class="col-sm-3 control-label">Today Task:<span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <textarea name="today_work" id="today_work" class="form-control" rows="6"></textarea>
                                                    <div id="today_work_error" class="text-danger" ></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="textarea" class="col-sm-3 control-label">Tomorrow Task:<span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <textarea name="nextday_work" id="nextday_work" class="form-control" rows="6"></textarea>
                                                    <div id="nextday_work_error" class="text-danger"></div>
                                                </div>
                                            </div>
                                            {{csrf_field()}}
                                            <div class="form-group">
                                                <div class="col-sm-9 col-sm-offset-3">
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal" id="work-edit-status-modal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title">Employee Work Status</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div id="work-edit-status-success-response" class="text-center text-success"></div>
                                        <div id="work-edit-status-failed-response" class="text-center text-danger"></div>
                                        <form id="work-edit-status-form" method="POST" class="form-horizontal" role="form" autocomplete="off">
                                            <div class="form-group">
                                                <label for="input" class="col-sm-3 control-label">Work Date: <span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="today_date" id="today_date" class="form-control" value="" placeholder="DD-MM-YYYY">
                                                    <div id="today_date_error" class="text-danger"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="textarea" class="col-sm-3 control-label">Today Task:<span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <textarea name="today_work" id="today_work" class="form-control" rows="6"></textarea>
                                                    <div id="today_work_error" class="text-danger" ></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="textarea" class="col-sm-3 control-label">Tomorrow Task:<span class="text-danger">*</span></label>
                                                <div class="col-sm-9">
                                                    <textarea name="nextday_work" id="nextday_work" class="form-control" rows="6"></textarea>
                                                    <div id="nextday_work_error" class="text-danger"></div>
                                                </div>
                                            </div>
                                            {{csrf_field()}}
                                            <input type="hidden" name="id" id="id" value="">
                                            <div class="form-group">
                                                <div class="col-sm-9 col-sm-offset-3">
                                                    <button type="submit" class="btn btn-primary">Submit</button>
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
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded",function(){
        getWorkStatus();
    });

</script>
@endsection
