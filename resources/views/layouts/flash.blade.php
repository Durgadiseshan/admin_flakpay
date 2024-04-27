<style>
   .success_alert {
    color: #47be7d;
    border-color: #50cd89;
    background-color: #e8fff3;
}

.error_alert {
   
    color: var(--bs-danger);
    border-color: var(--bs-danger);
    background-color: var(--bs-danger-light);

}
.text-light {
    color: #236e6b !important;
}
</style>

<section id="session_msg">

@if (Session::has('message_success'))   
 <!--begin::Alert-->
<div class="alert alert-primary d-flex align-items-center p-5 success_alert" >
    <!--begin::Icon-->
    <i class="ki-duotone ki-shield-tick fs-2hx text-success me-4"><span class="path1"></span><span class="path2"></span></i>
    <!--end::Icon-->

    <!--begin::Wrapper-->
    <div class="col-md-11">
        <!--begin::Title-->
        
        <!--end::Title-->

        <!--begin::Content-->
        <span> <center><b>{{ Session::get('message_success') }}</b></center></span>
        <!--end::Content-->
    </div>
    <!--end::Wrapper-->

     <!--begin::Close-->
     <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-dismiss="alert">
        <i class="fa-solid fa-xmark">X</i>
    </button>
    <!--end::Close-->
</div>
<!--end::Alert-->

@endif

@if (Session::has('message_error')) 

<!--begin::Alert-->
<div class="alert alert-primary d-flex align-items-center p-5 error_alert" >
    <!--begin::Icon-->
    <i class="ki-duotone ki-shield-tick fs-2hx text-success me-4"><span class="path1"></span><span class="path2"></span></i>
    <!--end::Icon-->

    <!--begin::Wrapper-->
    <div class="d-flex flex-column">
        <!--begin::Title-->
        
        <!--end::Title-->

        <!--begin::Content-->
        <span><center><b>{{ Session::get('message_error') }}</b></center></span>
        <!--end::Content-->
    </div>
    <!--end::Wrapper-->

       <!--begin::Close-->
       <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
        <i class="ki-duotone ki-cross fs-1 text-light"><span class="path1"></span><span class="path2"></span></i>
    </button>
    <!--end::Close-->
</div>
<!--end::Alert-->

@endif
</section>