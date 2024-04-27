@php
    use App\MerchantBusiness;
    use App\User;

    $merchantinfo = new User();

    $basicinfo = $merchantinfo->get_merchant_details();
    $bussiness_id = MerchantBusiness::get_business_id();
   
@endphp
<style>
    #call-app-activation-modal{
          display:none !important;
    }
</style>
<!--Documents Upload Modal Starts here -->
<div id="call-app-activation-modal" class="modal" role="dialog">
    <div id="divLoading"></div>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header activate-header">
            <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
            <h2 class="modal-title">Activate Your Account</h2>
            <h5>Fill forms and upload specified documents</h5>
        </div>
            <div class="modal-body">
                <form id="activate-account" method="POST" class="form-horizontal" role="form">    
                    <div class="tab">
                        <h5 class="text-center margin-bottom-lg"><strong>Personals Details</strong></h5>
                        @foreach($basicinfo as $merchantinfo)
                        <div class="form-group">
                            <label for="input" class="col-sm-4 control-label">Name:<span class="mandatory">*</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="name" id="name" class="form-control" value="{{$merchantinfo->name}}" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input" class="col-sm-4 control-label">Email:<span class="mandatory">*</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="email" id="email" class="form-control" value="{{$merchantinfo->email}}" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input" class="col-sm-4 control-label">Mobile No:<span class="mandatory">*</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="mobile_no" id="mobile_no" class="form-control" value="{{$merchantinfo->mobile_no}}" readonly>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="tab">
                        <div class="col-sm-12" id="show-company-form">

                        </div>
                    </div>
                    <div class="tab">
                        <div class="col-sm-12" id="show-business-form">

                        </div>
                    </div>
                    <div class="tab">
                        <div class="col-sm-12" id="show-business-card-form">

                        </div>
                    </div>
                    <div class="tab">
                        <h5 class="text-center margin-bottom-lg"><strong>Business Documents</strong></h5>
                        <div class="col-sm-12" id="show-document-form">

                        </div>
                    </div>
                    <div class="form-group pull-right">
                        <div class="col-sm-12">
                            <button type="button" id="prevBtn" class="btn btn-success" onclick="nextPrev(-1)">Previous</button>
                            <button type="button" id="nextBtn" class="btn btn-primary" onclick="nextPrev(1)">Next</button>
                            <button type="button" id="skip" class="btn btn-warning" onclick="skipActivation();">Skip</button>
                        </div>
                    </div>
                    <!-- Circles which indicates the steps of the form: -->
                    <div style="text-align:center;clear:both;">
                        <span class="step"></span>
                        <span class="step"></span>
                        <span class="step"></span>
                        <span class="step"></span>
                        <span class="step"></span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--Documents Upload Modal Ends here -->

<!--Documents Upload Modal Response Starts here -->
<div id="ajax-document-upload-response" class="modal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                Documents Uploaded Successfully
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" onclick="location.reload();" class="btn btn-primary">Ok</button>
            </div>
        </div>
    </div>
</div>
<!--Documents Upload Modal Response Ends here -->

<!--Documents Upload Message Starts here -->
<div id="document-upload-message" class="modal" style="display:none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header activate-header">
                    <h4>Documents Review</h4>                  
            </div>
            <div class="modal-body">
                <h4>Uploaded Documents Are In Review Process</h4>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-primary">Ok</button>
            </div>
        </div>
    </div>
</div>
<!--Documents Upload Message Ends here -->

<input type="hidden" id="show_modal" name="show_modal" value="{{Auth::user()->show_modal}}">
<input type="hidden" id="document_upload" name="document_upload" value="{{ Auth::user()->documents_upload }}">
<input type="hidden" id="business_id" name="business_id" value="{{$bussiness_id}}">

<input type="hidden" id="change_app_mode" name="change_app_mode"  value="{{ Auth::user()->change_app_mode}}">

    