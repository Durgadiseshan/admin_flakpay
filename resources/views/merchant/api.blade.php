<div class="row">
    <div class="col-sm-12 text-center" id="generate-api-response">
        
    </div>
</div>
<div class="row {{count($api_info)>0?'display-none':''}}">
    <div class="col-sm-12 padding-20">
        <input type="submit" class="btn btn-primary pull-right" id="generate-api" value="Generate">
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Api Key Id</th>
                    <th>Created Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if(count($api_info)>0)
                    @foreach($api_info as $api)
                        <tr>
                            <td>{{$api->api_key}}</td>
                            <td>{{$api->created_date}}</td>
                            <td><button class="btn btn-primary btn-sm" onclick="generateApi('{{$api->id}}')">Regenerate Api</button></td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan=3 class="text-center">No Data Found</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
<div id="api-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Create Api</h4>
            </div>
            <form class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="apikeyid" class="control-label col-sm-3">Key Id:</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="api_key" id="api_key" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="apikeyid" class="control-label col-sm-3">Secret Key:</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="api_secret" id="api_secret" value="">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Generate">
                </div>
            </form>
        </div>
    </div>
</div>