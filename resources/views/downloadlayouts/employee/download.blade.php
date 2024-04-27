@if($module == "nda")
    @if(!empty($downloadfile))
    <div class="form-group">
        <label for="input" class="col-sm-2 control-label">Uploaded File:</label>
        <div class="col-sm-3">
            <a href="/storage/rupayapay/documents/nda/{{$downloadfile}}">Download File</a>
        </div>
    </div>  
    @endif
    <div class="form-group">
        <label for="input" class="col-sm-2 control-label">Upload NDA Form:</label>
        <div class="col-sm-3">
            <input type="file" name="nda_doc" id="nda_doc" value="">
        </div>
    </div>
    <input type="hidden" name="employee_id" id="employee_id" value="">
    <input type="hidden" name="id" id="id" value="{{$doc_id}}"> 
    <input type="hidden" name="employee_name" id="employee-name" value="">
    <div class="form-group">
        <div class="col-sm-3 col-sm-offset-2">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
@endif

@if($module == "ca")
    @if(!empty($downloadfile))
    <div class="form-group">
        <label for="input" class="col-sm-2 control-label">Uploaded File:</label>
        <div class="col-sm-3">
            <a href="/storage/rupayapay/documents/ca/{{$downloadfile}}">Download File</a>
        </div>
    </div>  
    @endif
    <div class="form-group">
        <label for="input" class="col-sm-2 control-label">Upload NDA Form:</label>
        <div class="col-sm-3">
            <input type="file" name="ca_doc" id="ca_doc" value="">
        </div>
    </div>
    <input type="hidden" name="employee_id" id="employee_id" value="">
    <input type="hidden" name="id" id="id" value="{{$doc_id}}"> 
    <input type="hidden" name="employee_name" id="employee-name" value="">
    <div class="form-group">
        <div class="col-sm-3 col-sm-offset-2">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
@endif