
var currentTab = 0; 
base_url=$('#base_url').val();
//Onload functionality
$(document).ready(function(){
    formatAMPM();
    
    $.ajaxSetup({async:false});

    if(window.location.href.indexOf('/merchant') > 0)  
    {
        getAllNotifications();
        getAllMessages();
    }

    if(window.location.href.indexOf('settings')>0)
    {
        getRemindersData();
        getWebhookData();
    }

    if(window.location.href.indexOf("transactions") > 0)
    {
        getAllPayments();
    }

    if(window.location.href.indexOf('resolution-center') > 0)
    {
        getCustomerCaseData();
    }

    if(window.location.href.indexOf("/case-status/merchant/") > 0)
    {
        getCommentDetails();
    }

    if(window.location.href.indexOf('dashboard') > 0)
    {
       // getDashboardGraph();
        getDashboardData();
        showTab(currentTab); // Display the current tab
    }

    if(window.location.href.indexOf('transactionreport') > 0)
    {
       
        fetch_report_log(0);
        
    }

     if(window.location.href.indexOf('datatable_export') > 0)
    {
       
        fetch_report_log(1);
        
    }
    if(window.location.href.indexOf('coupon/new') > 0)
    {
        getCouponsTypesSubtypes();
    }

    if(window.location.href.indexOf('tools') > 0)
    {
        getAllCoupons();
    }

    if(window.location.href.indexOf('coupon/edit/') > 0)
    {
        getCouponsTypesSubtypes();
    }
    


    if($("input[name='app_mode']").val()!="")
    {
       var mode = $("#app_mode").val();
       var documents_upload = $("input[name='document_upload']").val();
       if($("input[name='show_modal']").val() == "Y")
       {
            if(mode == 0 && documents_upload == 'N')
            {
                //$("#activate-account-form")[0].reset();
                // $('#call-app-activation-modal').modal({backdrop:'static',keyboard:false,show:true});
            }
       }
    }

    if($("#is_reminders_enabled").val() == "N")
    {
        $("#display-reminders").hide();
    }

});

$("#forget-password").click(function(e){
    e.preventDefault();
    $("#password-reset")[0].reset(); 
    $("#modalForgetPassword").modal({show:true,backdrop:'static',keyboard:false});
});

$("#password-reset").submit(function(e){
    e.preventDefault();
    var formdata = $("#password-reset").serializeArray();
    $("#success-body").html("Sending Email Please Wait......").css({"color":"green","font-size":"15px","padding":"20px"});
    var email = $("#password-reset input[name='email']").val();
    if(email!="")
    {
        $.ajax({
            type: "POST",
            url:"/password/email", 
            data:getJsonObject(formdata),
            dataType:"json",
            success: function (response) {

                $("#password-reset")[0].reset();
                if(response.status)
                {
                    $("#success-body").html(response.message).css({"color":"green","font-size":"15px","padding":"20px"});  
                }else{
                    $("#error-body").html(response.message).css({"color":"red","font-size":"15px","padding":"20px"});
                }
            },complete:function(){
                setTimeout(() => {
                    $("#success-body").html(""); 
                    $("#error-body").html("");
                }, 3000);
            }
        });
    }else{
        $("#email_ajax_error").html("Email field is empty").css({"color":"red","font-size":"18px","padding":"20px"});
        $("#name='email'").click(function(e){
            e.preventDefault();
            $("#email_ajax_error").html("");
        })
    }
    
});

$("#password-request input[name='password']").click(function(e){
    e.preventDefault();
    $(".password").html("");
});

$("#password-request input[name='password_confirmation']").click(function(e){
    e.preventDefault();
    $(".confirm-password ").html("");
});


$("#merchant-password-change input[name='password']").click(function(e){
    e.preventDefault();
    $(".password").html("");
});

$("#merchant-password-change input[name='password_confirmation']").click(function(e){
    e.preventDefault();
    $(".confirm-password ").html("");
});

$("#merchant-login").submit(function(e){
    $(".error_span").html("");
    e.preventDefault();
    var formdata = $("#merchant-login").serializeArray();
    $.ajax({
        type:"POST",
        url:"/verify-login",
        data:getJsonObject(formdata),
        dataType: "json",
        success: function (response) {
            if(response.status){
                $("#ajax-success-response").html(response.message).css({"color":"green","font-size":"18px","padding":"20px"});
                window.location.href=response.redirect;
            }else{
                reloadCaptcha();
                $("#merchant-login input[name='captcha']").val("");
                if(typeof response.errors != "undefined" && Object.keys(response.errors).length > 0)
                {
                    $.each(response.errors, function (indexInArray, valueOfElement) { 
                      
                         $("#merchant-login #"+indexInArray+"_ajax_error").html(valueOfElement[0]);
                    });
                    
                }else{

                    $("#merchant-login-error").html(response.message).css({"color":"red"});
                }
            }
        }
    });

    setTimeout(() => {
                $(".error_span").html("");
            }, 2000);
})

$("#merchant-register").submit(function(e){
    e.preventDefault();
    var formdata = $("#merchant-register").serializeArray();
    $.ajax({
        type:"POST",
        url:"/mobile-register",
        data:getJsonObject(formdata),
        dataType:"json",
        success: function (response) {
            if(response.status)
            {
                reloadCaptcha();
                $("#merchant-register")[0].reset();
                $("#modalMobileVerify").modal({show:true,backdrop:'static',keyboard:false});
                $("#ajax-success-response").html(response.message).css({"color":"green","font-size":"18px","padding":"20px"});
            }else{
                if(typeof response.errors!="undefined" && Object.keys(response.errors).length > 0)
                {
                    $.each(response.errors, function (indexInArray, valueOfElement) { 
                         if(valueOfElement[0].indexOf('confirm') > 0)
                         {
                            $("#merchant-register #cpassword_ajax_error").html(valueOfElement[0]);
                            $("input[name='password_confirmation']").click(function(e){
                                e.preventDefault();
                                $("#merchant-register #cpassword_ajax_error").html("");
                            });
                         }else{
                            $("#merchant-register #"+indexInArray+"_ajax_error").html(valueOfElement[0]);
                         }
                         $("input[name="+indexInArray+"]").click(function(e){
                             e.preventDefault();
                             $("#merchant-register #"+indexInArray+"_ajax_error").html("");
                         });
                    });
                    reloadCaptcha();
                }else{
                    console.log("else");
                    $("#ajax-fail-response").html(response.message).css({"color":"red","font-size":"15px","padding":"20px"});
                }
            }
        },complete:function(){
            setTimeout(() => {
                $("#ajax-fail-response").html("");
            }, 2000);
        }
    });
});

$("#mobile-verification").submit(function(e){
    e.preventDefault();
    var formdata = $("#mobile-verification").serializeArray();
    $.ajax({
        type:"POST",
        url:"/register",
        data:getJsonObject(formdata),
        dataType:"json",
        success: function (response) {
            if(response.status)
            {
                window.location.href=response.redirect;
            }else{
                $("#otp_number_ajax_error").html(response.message).css({"color":"red","font-size":"15px","padding":"20px"});;
                $("input[name='otp_number']").click(function(e){
                    e.preventDefault();
                    $("#mobile-verification #otp_number_ajax_error").html("");
                });
            }
        }
    });
});
$("#resend-mobile-sms").click(function(e){
    e.preventDefault();
    $.ajax({
        type:"GET",
        url:"/resend-mobile-otp",
        dataType:"json",
        success:function (response) {
            if(response.status)
            {
                $("#ajax-success-response").html(response.message).css({"color":"green"});
            }
        },complete:function(){
            setTimeout(() => {
                $("#ajax-success-response").html("");
            },3000);
        }
    });
});


function showPasssword(elementName,iconelement){
   var status = $("div").data("pstatus");
   x = $("input[name="+elementName+"]")[0];
    if (x.type === "password") {
        x.type = "text";
        $(iconelement).html('<i class="fas fa-eye-slash fa-lg"></i>');
    } else {
        x.type = "password";
        $(iconelement).html('<i class="fas fa-eye fa-lg"></i>');
    }
}

function showMyPasssword(elementName,iconelement){
    var status = $("div").data("pstatus");
    x = $("#my-current-password input[name="+elementName+"]")[0];
     if (x.type === "password") {
         x.type = "text";
         $(iconelement).html('<i class="fas fa-eye-slash fa-lg"></i>');
     } else {
         x.type = "password";
         $(iconelement).html('<i class="fas fa-eye fa-lg"></i>');
     }
 }

function visiblePasssword(elementName,iconelement){
    x = $("input[name="+elementName+"]")[0];
     if (x.type === "password") {
         x.type = "text";
         $(iconelement).html('<i class="fa fa-eye-slash fa-lg"></i>');
     } else {
         x.type = "password";
         $(iconelement).html('<i class="fa fa-eye fa-lg"></i>');
     }
 }

 //Activate your account code starts here
 function showTab(n) {
    // This function will display the specified tab of the form...
    var x = document.getElementsByClassName("tab");
    x[n].style.display = "block";
    //... and fix the Previous/Next buttons:
    if (n == 0) {
      document.getElementById("prevBtn").style.display = "none";
    } else {
      document.getElementById("prevBtn").style.display = "inline";
    }
    if (n == (x.length - 1)) {
      getMerchantDocumentForm();
      document.getElementById("nextBtn").innerHTML = "Submit";
    } else {
      switch (n) {
          case 1:
              gePopuptForm("company");
              break;
          case 2:
              gePopuptForm("business-info");
              if($("#activate-account select[name='business_sub_category_id']").val() == ""){
                element = $("#activate-account select[name='business_category_id']");
                getsubcategory(element);
              }
              break;
          case 3:
              gePopuptForm("business-card");
              getMerchantDocumentForm();
              break;
          default:
              break;
      }
      document.getElementById("nextBtn").innerHTML = "Next";
    }
    //... and run a function that will display the correct step indicator:
    fixStepIndicator(n)
  }
  
  function nextPrev(n) {
    // This function will figure out which tab to display
    var x = document.getElementsByClassName("tab");
    // Exit the function if any field in the current tab is invalid:
    if (n == 1 && !validateForm()) return false;
    // Hide the current tab:
    x[currentTab].style.display = "none";
    // Increase or decrease the current tab by 1:
    currentTab = currentTab + n;
    // if you have reached the end of the form...
    if (currentTab >= x.length) {
      // ... the form gets submitted:
      //document.getElementById("activate-account").submit();
      activateAccount();
      return false;
    }
    // Otherwise, display the correct tab:
    showTab(currentTab);
  }
  
  function validateForm() {
    // This function deals with validation of the form fields
    var x, y, i, valid = true;
    var formelements = {};
    x = document.getElementsByClassName("tab");
    //y = x[currentTab].getElementsByTagName("input");
    y = x[currentTab].getElementsByClassName("form-control");
    
    // A loop that checks every input field in the current tab:
    if(currentTab != 4){

        for (i = 0; i < y.length; i++) {
            // If a field is empty...
            if (y[i].value == "" && !$(y[i]).prop("disabled") && !$(y[i]).hasClass("not-mandatory")) {
            // add an "invalid" class to the field:
            y[i].className += " invalid";
            // and set the current valid status to false
            valid = false;
            }else if(!$(y[i]).prop("disabled")){
                formelements[i] = y[i];
            }
        }
        if (valid) {
            switch (currentTab) {
                case 1:
                    valid = updateCompnayInfo(formelements);
                    break;
                case 2:
                    valid = businessForm(formelements);
                    break;
                case 3:
                    valid = businessDetailForm(formelements);
                    break;
            }
        }
    }else{
        
        var notMandatory = ["comp_gst_doc"];
        $("input[type='file']").each(function(index,element){
            var inputName = $(element).attr("name");
            if($.inArray(inputName,notMandatory) == -1){
                console.log()
                if($("#"+inputName+"_file_not_exist").length > 0)
                {
                    $("#ajax-activate-account-failed").html("Upload all the documents to submit form").css({"color":"red"});
                    valid = false;
                    return false;
                }else{
                    valid = true;
                }
            }
        });
    }
    // If the valid status is true, mark the step as finished and valid:
    if (valid) {
        document.getElementsByClassName("step")[currentTab].className += " finish";
    }

    return valid; // return the valid status
  }
  
  function fixStepIndicator(n) {
    // This function removes the "active" class of all steps...
    var i, x = document.getElementsByClassName("step");
    for (i = 0; i < x.length; i++) {
      x[i].className = x[i].className.replace(" active", "");
    }
    //... and adds the "active" class on the current step:
    x[n].className += " active";
  }

    $("body").on("change",".inputfile",function(e){
        e.preventDefault();
        data = new FormData();
        var file = document.getElementById(this.id).files[0];
        data.append(this.name,file);
        data.append("id",$("#id").val());
        data.append("_token",$('meta[name="csrf-token"]').attr('content')); 
        $("#divLoading").addClass("show");
        $("#divLoading").removeClass("hide");
        $.ajax({
            url:'/merchant/document-submission',
            type: 'POST',
            data:data,
            processData:false,
            contentType:false,
            cache:false,
            dataType:"json",
            success: function(response){
                ajax_response = response.status;
                if(response.status)
                {   
                    $("#ajax-activate-account-uploaded").html(response.message);
                    getMerchantDocumentForm();
                }else{

                    if(Object.keys(response.error).length > 0)
                    {
                        $.each(response.error,function(name,value)
                        {
                            $("#"+name+"_error").html(value[0]).css({"color":"red"});
                            $("input[name="+name+"]").click(function(){
                                $("#"+name+"_error").html("");
                            });
                        });
                    }
                }
            },
            complete:function(){

                $("#divLoading").removeClass("show");
                $("#divLoading").addClass("hide");
                setTimeout(() => {
                    $("#ajax-activate-account-uploaded").html("");
                },3000);
            }
        });
    });

    $("body").on("change",".logo-inputfile",function(e){
        e.preventDefault();
        var formdata = $("#company-logo-form")[0];
        var data = new FormData(formdata);
        $.ajax({
            url:'/merchant/business-logo/update',
            type: 'POST',
            data:data,
            processData:false,
            contentType:false,
            cache:false,
            dataType:"json",
            success: function(response){
                if(response.status)
                {   
                    window.location.reload(true);
                }else{

                    if(Object.keys(response.errors).length > 0)
                    {
                        $.each(response.errors,function(name,value)
                        {
                            $("#"+name+"_error").html(value[0]).css({"color":"red"});
                            $("input[name="+name+"]").click(function(){
                                $("#"+name+"_error").html("");
                            });
                        });
                    }
                }
            },
            complete:function(){
                //$("#divLoading").removeClass("show");
                //$("#divLoading").addClass("hide");
                setTimeout(() => {
                    $("#ajax-activate-account-uploaded").html("");
                },3000);
            }
        });
    });

    function removeMerchantLogo(id,imagename){
        $.ajax({
            type:"POST",
            url:"/merchant/business-logo/remove",
            data:{id:id,business_logo:imagename,_token:$('meta[name="csrf-token"]').attr("content")},
            dataType:"json",
            success: function (response) {
                window.location.reload(true);
            }
        });
    }

    function skipActivation(){
        DisabelPopup();
    }

    function stateGST(element){
        getStateGSTCode($(element).val());
    }

    function activateAccount(){
        $.ajax({
            type: "GET",
            url: "/merchant/document-submission/success",
            dataType: "json",
            success: function (response) {
                if(response.status){
                    $("#call-app-activation-modal").modal('hide');
                    $("#ajax-document-upload-response").modal({backdrop:'static',keyboard:false,show:true});
                }
            }
        });
    }

    function gePopuptForm($form) {
    $.ajax({
        type: "GET",
        url: "/merchant/load-activate-forms/" + $form,
        dataType: "html",
        success: function (response) {
            if ($form == "company") {
                $("#show-company-form").html(response);
            } else if ($form == "business-info") {
                $("#show-business-form").html(response);
            } else if ($form == "business-card") {
                $("#show-business-card-form").html(response);
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX Request Error:", status, error);
        },
        complete: function () {
            $("div#divLoading").removeClass('show');
            $("div#divLoading").addClass('hide');
        }
    });
}

 //Activate your accound code ends here

 $("#update-my-details").submit(function(e){
    e.preventDefault();
    var formdata =  $("#update-my-details").serializeArray();
    var mobileno = $("#update-my-details input[name='mobile_no']").val();
    var name = $("#update-my-details input[name='name']").val();
    var email = $("#update-my-details input[name='email']").val();
    if(email == "" && !$("#update-my-details input[name='email']").prop('disabled')){
        $("#email-ajax-response").html("Email should not be empty").css({"color":"red"});
        $("#update-my-details #email").click(function(e){
            $("#email-ajax-response").html('');
        });
        return false;
    }
    if(mobileno == "" && !$("#update-my-details input[name='mobile_no']").prop('disabled')){
        $("#mobile-ajax-response").html("Mobile should not be empty").css({"color":"red"});
        $("#update-my-details #mobile_no").click(function(e){
            $("#mobile-ajax-response").html('');
        });
        return false;
    }
    var html = '';
     $.ajax({
         type:"POST",
         url:"/merchant/update-mydetails",
         data:getJsonObject(formdata),
         dataType: "json",
         success: function (response) {

            if(response.otp)
            {
                html = `<label class="control-label col-sm-2" for="email">OTP:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" id="email_otp" name="email_otp" value="">
                    <span id="otp_ajax_response"></span>
                </div>
                <div class="col-sm-3">
                    <button type="submit" class="btn btn-primary btn-sm">Validate OTP</button>
                    <button class="btn btn-primary btn-sm" id='send-email-again'>Send Again</button>
                </div>`;
                $('#dynamic-div').html(html);
                $('#otp_ajax_response').html(response.message).css({"color":"green"});

            }else{

                if(!response.email)
                {
                    $.each(response.errors, function (indexInArray, valueOfElement) { 
                        if(indexInArray == "email")
                        {
                            $("#email-ajax-response").html(valueOfElement['0']).css({"color":"red"});
                            $("#update-my-details #email").click(function(e){
                                $("#email-ajax-response").html('');
                            });
                        }
                    });
                }
            }
            
            if(response.email_change)
            {
                window.location.href='/flakpay/login';

            }else if(typeof response.email_change !="undefined" && !response.email_change){
            
                $('#otp_ajax_response').html(response.message).css({"color":"red"});
            }

            if(response.mobile_change)
            {
                $("#old-mobile").val(response.mobile_no);
                $('#mobile-otp-ajax-response').html(response.message).css({"color":"green"});

            }else{
                if(!response.mobile_change)
                {
                    $('#mobile-otp-ajax-response').html(response.message).css({"color":"red"});
                }
            }

            if(response.name_change)
            {
                $("#old-name").val(name);
                $("#merchant-name").html(name+'<span class="caret"></span>');
                $('#name-ajax-response').html(response.message).css({"color":"green"});
            }else{
                if(!response.name_change)
                {
                    $('#name-ajax-response').html(response.message).css({"color":"red"});
                }
            }

            if(response.mobile){

                html = `<label class="control-label col-sm-2" for="mobile">OTP:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" id="mobile_otp" name="mobile_otp" value="">
                    <span id="mobile-otp-ajax-response"></span>
                </div>
                <div class="col-sm-3">
                    <button type="submit" class="btn btn-primary btn-sm">Validate OTP</button>
                    <button class="btn btn-primary btn-sm" id='send-mobilesms-again'>Send Again</button>
                </div>`;

                $('#change-phone-div').html(html);

                $('#mobile-otp-ajax-response').html(response.message).css({"color":"green"});

            }else{

                $.each(response.errors,function (indexInArray, valueOfElement) {
                    if(indexInArray == "mobile_no")
                    {
                        $("#mobile-ajax-response").html(valueOfElement['0']).css({"color":"red"});
                        $("#update-my-details #mobile_no").click(function(e){
                            $("#mobile-ajax-response").html('');
                        });
                    }else if(indexInArray == "email"){

                        $("#email-ajax-response").html(valueOfElement['0']).css({"color":"red"});
                        $("#update-my-details #email").click(function(e){
                            $("#email-ajax-response").html('');
                        });
                    }
                    
                });
            }
         }
     });
 });

 $("body").on("click","#send-email-again",function(e){
    e.preventDefault();
    $.ajax({
        type:"GET",
        url:"/merchant/resend-change-email",
        dataType: "json",
        success: function (response) {
            if(response.status)
            {
                $('#otp_ajax_response').html(response.message).css({"color":"green"});
            }
        }
    });
});

$("body").on("click","#send-mobilesms-again",function(e){
    e.preventDefault();
    $.ajax({
        type:"GET",
        url:"/merchant/resend-change-mobile",
        dataType: "json",
        success: function (response) {
            if(response.status)
            {
                $('#mobile-otp-ajax-response').html(response.message).css({"color":"green"});
            }
        }
    });
});


function viewAllNotifications(){
    $.ajax({
        type:"GET",
        url:"/merchant/view-all-notifications",
        dataType:"json",
        success: function(response){
            $("#new-notification-count").html("0");
            $("#new-notification-status").html("You have 0 new notification");
        }
    });
}


function viewAllMessages(){
    $.ajax({
        type:"GET",
        url:"/merchant/view-all-messages",
        dataType:"json",
        success: function(response){
            $("#new-notification-count").html("0");
            $("#new-notification-status").html("You have 0 new message");
        }
    });
}

//Handling Session Timeout with ajax call
$(document).ajaxError(function( event, jqxhr, settings, thrownError ) {
    if(jqxhr.status!=200 && jqxhr.status!=500)
    {   
        alert("Session expired. You'll be take to the session timeout page");
        location.href = "/flakpay/login";
    }
});
    

// $(document).ajaxStart(function(){
//     $("div#divLoading").removeClass('hide');
//     $("div#divLoading").addClass('show');
// });

// $(document).ajaxComplete(function(){
//     $("div#divLoading").removeClass('show');
//     $("div#divLoading").addClass('hide');
// });


function getCookie(keyvalue){
    var totalCookies = document.cookie.split(";");
    var cookieObject = {};
    for(i=0;i<totalCookies.length;i++)
    {
        var singleCookie = totalCookies[i].split("=");
        cookieObject[singleCookie[0]] = singleCookie[1];
    }
    return cookieObject[keyvalue]
}


var invoiceItemOptions = [];
var invoiceCustomers = [];

var itemOject = {};
var customerAddress = [];
var invoiceselectedAddress = {};
var coupon_subtype = [];
var productsData = [];



//Set Dashboard Range starts
$("#dashboard_date").change(function(event){
    event.preventDefault();
    setDashboardDateRange();
    var appendid = $("#dashboard-form input[name='module']").val();
    if(appendid!="dash_graph")
    {
        getDashboardData();
    }else{
        getDashboardGraph();
    }
    
});


function reloadCaptcha()
{
    $.ajax({
        type:"GET",
        url:"/reload-captcha",
        dataType:"text",
        success: function (response) {
            $("#display-captcha").attr("src",response);
        }
    });
}


function setDashboardDateRange(){

    var selectedDateRange = $("#dashboard_date").val();
    var date = new Date();
    var day = date.getDate();
    var month = date.getMonth()+1;
    var fullday = day<10 ? '0'+day:day;
    var fullmonth = month<10 ? '0'+month:month;
    var year = date.getFullYear();
    var today = year+"-"+fullmonth+"-"+fullday;
    switch (parseInt(selectedDateRange)) {
        case 1:
            var newDate = new Date(date.getFullYear(),date.getMonth(),date.getDate()-7);
            
            var day = newDate.getDate();
            var month = newDate.getMonth()+1;
            var fullday = day<10 ? '0'+day:day;
            var fullmonth = month<10 ? '0'+month:month;
            var year = newDate.getFullYear();
            var selectedDate = year+"-"+fullmonth+"-"+fullday;
            $("#dash_to_date").val(today);
            $("#dash_from_date").val(selectedDate);
            break;
        case 2:

            var newDate = new Date(date.getFullYear(),date.getMonth(),date.getDate()-30);
            
            var day = newDate.getDate();
            var month = newDate.getMonth()+1;
            var fullday = day<10 ? '0'+day:day;
            var fullmonth = month<10 ? '0'+month:month;
            var year = newDate.getFullYear();
            var selectedDate = year+"-"+fullmonth+"-"+fullday;

            $("#dash_to_date").val(today);
            $("#dash_from_date").val(selectedDate);
            break;
        case 3:
            var newDate = new Date(date.getFullYear(),date.getMonth(),date.getDate()-90);

            var day = newDate.getDate();
            var month = newDate.getMonth()+1;
            var fullday = day<10 ? '0'+day:day;
            var fullmonth = month<10 ? '0'+month:month;
            var year = newDate.getFullYear();
            var selectedDate = year+"-"+fullmonth+"-"+fullday;

            $("#dash_to_date").val(today);
            $("#dash_from_date").val(selectedDate);
            break;
        case 4:
            $("#dash_to_date").val("0000-00-00");
            $("#dash_from_date").val("0000-00-00");
            break;    
        default:
            var selectedDate = year+"-"+fullmonth+"-"+(day-7);
            $("#dash_to_date").val(today);
            $("#dash_from_date").val(selectedDate);
            break;
    }

}


//Set Dashboard Range ends

//Resend Message to verify mobile code starts here
$("#resend-message").click(function(e){
    e.preventDefault();
    $.ajax({
        url:"/resend-message",
        type:"get",
        dataType:"json",
        success:function(response){
            if(response.status)
            {
                $("#ajax-resend-message-response").html(response.message).css({"color":"green"});
            }
        },
        error:function(){},
        complete:function(){
            setTimeout(() => {
                $("#ajax-resend-message-response").html("");
            }, 50000);
        }
    });
})
//Resend Message to verify mobile code ends here

//Running Time Code starts here
function formatAMPM() {
    var date = new Date();
    var day = date.getDate();
    var month = date.getMonth()+1;
    var year = date.getFullYear();
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var seconds = date.getSeconds();
    var ampm = hours >= 12 ? 'PM' : 'AM';
    day = day<10 ? '0'+day : day;
    month = month<10 ? '0'+month:month;
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    minutes = minutes<10 ? '0'+minutes : minutes;
    seconds = seconds<10 ? '0'+seconds : seconds;
    $("#nav-clock").html("<span style='color:#d7943d'>Date:</span> "+day+"-"+month+"-"+year+" "+hours + ':' + minutes +':'+ seconds +' ' + ampm);
    //$("#nav-clock").html(hours + ':' + minutes +' '+ ampm);
    setTimeout(formatAMPM, 500);
}
//Running Time Code ends here


//Enable Reminders functionality starts here
$("#is_reminders_enabled").change(function(e){
    e.preventDefault();
    var formdata = $("#remainder-form").serializeArray();
    $.ajax({
        url:"/merchant/reminder/enable",
        type:"POST",
        data:getJsonObject(formdata),
        dataType:"json",
        success:function(response){
            if(response.status)
            {
                $("#display-reminders").toggle();
            }
        },
        error:function(){
            
        }
    })
});

//Emable Reminders functionality ends here





//Get All Items function starts
function optionItems(){
    invoiceItemOptions = [];
    $.ajax({
        url:"/merchant/get-all-items",
        type:"GET",
        dataType:"json",
        success:function(response){
            var html='';
            invoiceItemOptions.push(`<option value=''>Select Item</option>`);
            $.each(response,function(index,value){
                invoiceItemOptions.push(`<option value='`+value.id+`'>`+value.item_name+`</option>`);
                itemOject[value.id] = value.item_amount;
            });
            $("#invoice-add-form #item_name1").html(invoiceItemOptions.join(" "));
        },
        error:function(error){
            
        },
        complete:function(){
        }
    });
    return true;
}
//Get All Items function ends

//Get All Customer starts
function optionCustomers(option=""){
    invoiceCustomers = [];
    var tablehtml='';
    var customer_id = "";
    $.ajax({
        url:"/merchant/get-all-customers",
        type:"GET",
        dataType:"json",
        success:function(response){

            invoiceCustomers.push("<option value=''>--Select--</option>");
            $.each(response,function(index,value){
                if(option!="")
                {
                    invoiceCustomers.push("<option value="+value.id+" selected>"+value.customer_name+"</option>");
                    customer_id = value.id;
                }else{
                    invoiceCustomers.push("<option value="+value.id+">"+value.customer_name+"</option>");
                }
            });
            invoiceCustomers.push("<option value='new'>+Create New Customer</option>");
            $("#invoice-add-form #invoice_billing_to").html(invoiceCustomers.join(" "));
            $("#invoice-edit-form #invoice_billing_to").html(invoiceCustomers.join(" "));
        },
        error:function(error){
            
        },
        complete:function(){
            if(option!=""){
                getCustomerAddress(customer_id,"invoice-add-form");
            }
            
            //$("#customertable").html(tablehtml);
        }
    });
}

function loadLatestAddedCustomers(option=""){
    invoiceCustomers = [];
    var tablehtml='';
    var customer_id = "";
    $.ajax({
        url:"/merchant/get-all-customers",
        type:"GET",
        dataType:"json",
        success:function(response){

            invoiceCustomers.push("<option value=''>--Select--</option>");
            $.each(response,function(index,value){
                if(option!="")
                {
                    
                    invoiceCustomers.push("<option value="+value.id+" selected>"+value.customer_name+"</option>");
                    customer_id = value.id;
                }else{
                    invoiceCustomers.push("<option value="+value.id+">"+value.customer_name+"</option>");
                }
            });
            getCustomerAddress(customer_id,"invoice-add-form");
            getCustomerAddress(customer_id,"invoice-edit-form");
            invoiceCustomers.push("<option value='new'>+Create New Customer</option>");
            $("#invoice-add-form #invoice_billing_to").html(invoiceCustomers.join(" "));
            $("#invoice-edit-form #invoice_billing_to").html(invoiceCustomers.join(" "));
        }
    });
}
//Get All Customer Ends

//Calculating Invoce Items starts
function itemCalculate(element){

var rowid = $(element).attr("data-name-id");
var item_amount = itemOject[$(element).val()];
var item_quantity = $("#item_quantity"+rowid).val();

var subtotal = 0;
var invoicetax = 0;
var taxpercentage = 0;

  if($(element).val()!="")
  {
    $("#item_amount"+rowid).val(item_amount);
    $("#item_total"+rowid).val(item_amount*item_quantity);
 
    //subtotal code starts here
 
    $("input[name='item_total[]']").each(function(index,element){
        if(element.value!="")
        {
         subtotal+=parseInt(element.value);
        }  
    });
    
    //subtotal code ends here
    $("#invoice_subtotal").val(subtotal);
    $("#invoice_tax_amount").val(calculateTax(subtotal));
    $("#invoice_amount").val(subtotal+calculateTax(subtotal));
  }else{
    
    $("#item_amount"+rowid).val("");
    $("#item_total"+rowid).val("");

    $("#invoice_subtotal").val("");
    $("#invoice_tax_amount").val("");
    $("#invoice_amount").val("");
  }
   
   
}
//Calculating Invoce Items ends


//Calculate Invoice Items tax code starts

function calculateTax(subtotal)
{
    if($("input[name='customer_state']").val() == $("input[name='merchant_state']").val())
   {
        taxpercentage = $("#inner_state").val();
        invoicetax = subtotal*(taxpercentage/100);
        $("#tax-variable").html("CGST+SGST");
        $("#tax_applied").val("CGST+SGST")

   }else{
        taxpercentage = $("#outer_state").val();
        invoicetax = subtotal*(taxpercentage/100);
        $("#tax-variable").html("IGST");
        $("#tax_applied").val("IGST")
   }

   return invoicetax;
}
//Calculate Invoice Items taxt code ends 

//Remove Invoice Items starts
function removeInvoiceItem(element,id){
    
    if($("#dynamic-item-list").children().length > 1)
    {   
        $("#invoice_item_row"+id).remove();
        var subtotal = 0;
        $("input[name='item_total[]']").each(function(index,element){
            if(element.value!="")
            {
                subtotal+=parseInt(element.value);
            }  
        });
        $("#invoice_subtotal").val(subtotal);
        $("#invoice_tax_amount").val(calculateTax(subtotal));
        $("#invoice_amount").val(subtotal+calculateTax(subtotal));
    }
    
}

//Remove Invoice Items ends

//Changing App Mode Fuctionality starts
function changeAppMode(element)
{

    console.log('appmode');

    // var modevalue = $(element).val();
    // var documents_upload = $("#document_upload").val();
    // if(documents_upload == "Y"){
    //    $.ajax({
    //        type:"GET",
    //        url:"/merchant/change-app-mode/"+modevalue,
    //        data:"data",
    //        dataType:"json",
    //        success: function (response) {
    //         if(!response.status){
    //             // $("#document-upload-message").modal("show");
    //             $(element).val(0);
    //         }else{
    //             location.reload();
    //         }
             
    //        }
    //    });
    // }else{
    //     showTab(currentTab);
    //     // $("#call-app-activation-modal").modal("show");
    //     $(element).val(0);
    // }

    var modevalue = $(element).val();
    console.log('modevalue',modevalue);
    var documents_upload = $("#change_app_mode").val();
    console.log('changemode',documents_upload);
    if(documents_upload == "Y"){
       $.ajax({
           type:"GET",
           url:"/merchant/change-app-mode/"+modevalue,
           data:"data",
           dataType:"json",
           success: function (response) {
            console.log('success',response);
            if(!response.status){
                // $("#document-upload-message").modal("show");
                $(element).val(0);
            }else{
                location.reload();
            }
             
           }
       });
    }else{
        showTab(currentTab);
        // $("#call-app-activation-modal").modal("show");
        $(element).val(0);
    }
}
//Changing App Mode functionality ends

//Change Modal Popup Status code starts here
function DisabelPopup()
{
    $.ajax({
        url:'/merchant/disable-popup',
        type:"GET",
        dataType:"json",
        success:function(response){
            $("#call-app-activation-modal").modal("hide");
        }
    });
}

//Change Modal Popup Status code ends here


//Generate coupon Id functionality starts here
function generateCouponId()
{
    $.ajax({
        url:'/merchant/new-coupon-id',
        type:"GET",
        dataType:"json",
        success:function(response){
            $("#coupon-new-edit-form #"+response[0]).val(response[1]);
        }
    });
}
//Generate Coupon Id functionality ends here

//Form functionality starts

    // Item related javascript starts

    $('body').on("click","#itemadd input[name='item_name[]']",function(){ 
        $(this).css({"border":"1px solid #ddd"});
    });

    $('body').on("click","#itemadd input[name='item_amount[]']",function(){
        $(this).css({"border":"1px solid #ddd"});
    });


    // Paylink related javascript starts

    $("input[name='paylink_partial']").click(function(){
        var newvalue = $(this).val() == "N"?"Y":"N";
        $(this).val(newvalue);
    });
    $("input[name='email_paylink']").click(function(){
        var newvalue = $(this).val() == "N"?"Y":"N";
        $(this).val(newvalue);
    });
    $("input[name='mobile_paylink']").click(function(){
        var newvalue = $(this).val() == "N"?"Y":"N";
        $(this).val(newvalue);
    });
    $("input[name='paylink_auto_reminder']").click(function(){
        var newvalue = $(this).val() == "N"?"Y":"N";
        $(this).val(newvalue);
    });

    $("input[name='paylink_amount']").click(function(event){
        event.preventDefault();
        $("#paylink_amount_error").html("");
    });

    $("input[name='paylink_amount']").on("keyup input",function(){
        enableButton("paylink");
    });

    $("input[name='paylink_for']").on("keyup input",function(){
        enableButton("paylink");
    });

    $("#paylinkadd input[name='paylink_customer_email']").on("keyup input",function(event){
        event.preventDefault();
        var regemail_rule = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
        if(regemail_rule.test($(this).val()) && $(this).val()!="")
        {
            $("#paylinkadd #email_paylink").prop("checked",true);
            $("#paylinkadd #email_paylink").val("Y");
        }else{
            $("#paylinkadd #email_paylink").prop("checked",false);
            $("#paylinkadd #email_paylink").val("N");
        }   
    });

    $("#paylinkadd input[name='paylink_customer_mobile']").on("keyup input",function(event){
        event.preventDefault();
        if($(this).val().length === 10)
        {
            $("#paylinkadd #mobile_paylink").prop("checked",true);
            $("#paylinkadd #mobile_paylink").val("Y");
        }else{
            $("#paylinkadd #mobile_paylink").prop("checked",false);
            $("#paylinkadd #mobile_paylink").val("N");
        }
    });

    $("#paylink-edit input[name='paylink_customer_email']").on("keyup input",function(event){
        event.preventDefault();
        var regemail_rule = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
        if(regemail_rule.test($(this).val()) && $(this).val()!="")
        {
            $("#paylink-edit #email_paylink").prop("checked",true);
            $("#paylink-edit #email_paylink").val("Y");
        }else{
            $("#paylink-edit #email_paylink").prop("checked",false);
            $("#paylink-edit #email_paylink").val("N");
        }    
    });

    $("#paylink-edit input[name='paylink_customer_mobile']").on("keyup input",function(event){
        event.preventDefault();
        if($(this).val().length === 10)
        {
            $("#paylink-edit #mobile_paylink").prop("checked",true);
            $("#paylink-edit #mobile_paylink").val("Y");
        }else{
            $("#paylink-edit #mobile_paylink").prop("checked",false);
            $("#paylink-edit #mobile_paylink").val("N");
        }
    });


    $("input[name='paylink_for']").click(function(event){
        event.preventDefault();
        var regnumber_rule = /^[0-9\.]+/g;
        var fieldvalue = $("#paylink_amount").val();
        var errormessage = "Enter valid Amount";
        var result = regnumber_rule.test(fieldvalue);
        $("#paylink_for_error").html("");
        if(!result)
        {
            $("#paylink_amount_error").html(errormessage).css({"color":"red"});
        }
    });

    $("input[name='paylink_expiry']").on("input",function(event){
        event.preventDefault();
        $("#paylink_auto_reminder").prop("checked","checked");
        $("#paylink_auto_reminder").val("Y");
    });

    // Paylink related javascript ends

    //Invoice Items Quantity change code starts
    $("body").on("input change keyup","input[name='item_quantity[]']",function(event){
        event.preventDefault();
        var rowid = $(this).attr("data-quantity-id");
        var itemquantity = $(this).val();
        if(itemquantity > 0)
        {
            var itemamount = $("#item_amount"+rowid).val();
            var itemtotal = itemquantity*itemamount;
            var subtotal = 0;
            var invoicetax = 0;
            $("input[name='item_total[]']").each(function(index,element){
                subtotal+=parseInt(element.value);
           });

           $("#item_total"+rowid).val(itemtotal);
           $("#invoice_subtotal").val(subtotal);
           $("#invoice_tax_amount").val(calculateTax(subtotal));
           $("#invoice_amount").val(subtotal+calculateTax(subtotal));

        }else{
            $(this).val(1);
        }
        
    });
    //Invoice Items Quantity change code ends

    //Customer Invoice select functionality starts
    $("#invoice-add-form #invoice_billing_to").on("change",function(event){
        event.preventDefault();
        var customerid = $(this).val();
        customerAddress = [];
        if(customerid != "" && customerid != "new")
        {
            getCustomerAddress(customerid,"invoice-add-form");

        }else if(customerid == "new"){
            $("#add-customer-form")[0].reset();
            $('#add-customer-modal').modal({show:true,keyboard:false,backdrop:'static'});
            $(this).val("");
        }else{

            $("#invoice-add-form #customer_gstno").val("");
            $("#invoice-add-form #customer_email").val("");
            $("#invoice-add-form #customer_phone").val("");
            $("#invoice_billing_address").html("<option value=''>Select Bill Address</option>");
            $("#invoice_shipping_address").html("<option value=''>Select Ship Address</option>");
        }
       
        
    });

    $("#invoice-edit-form #invoice_billing_to").on("change",function(event){
        event.preventDefault();
        var customerid = $(this).val();
        customerAddress = [];
            
        if(customerid != "" && customerid != "new")
        {
            getCustomerAddress(customerid,"invoice-edit-form");
            vaidateEmail('customer_email','customer_email_error');
            validateMobile('customer_phone','customer_phone_error');

        }else if(customerid == "new"){
            $("#add-customer-form")[0].reset();
            $('#add-customer-modal').modal('show');
        }else{

            $("#customer_gstno").val("");
            $("#customer_email").val("");
            $("#customer_phone").val("");
            $("#invoice_billing_address").html("<option value=' '>Select Bill Address</option>");
            $("#invoice_shipping_address").html("<option value=' '>Select Ship Address</option>");
        }
       
        
    });


    //Customer Invoice select functionality starts

    $("#invoice-add-form #invoice_billing_address").change(function(event){
        event.preventDefault();
        if($(this).val() == "new_address")
        {
            $("#add-customer-address-form")[0].reset();
            $("#add-customer-address-modal").modal({show:true,backdrop:'static',keyboard:false});
            $(this).val("");
        }else if($(this).val() == "new_edit_address")
        {
            var customerid = $("#invoice_billing_to").val();
            AddEditCustomerAddress(customerid);
            $(".form-error").html("");
            $("#add-edit-customer-address-modal").modal({show:true,backdrop:'static',keyboard:false});
            $(this).val("");
        }
        else{
            $("#invoice-add-form input[name='customer_state']").val(invoiceselectedAddress[$(this).val()]);
            getStateGSTCode(invoiceselectedAddress[$(this).val()]);
        }
        
    });

    $("#invoice-edit-form #invoice_billing_address").change(function(event){
        event.preventDefault();
        if($(this).val() == "new_address")
        {
            $("#add-customer-address-form")[0].reset();
            $("#add-customer-address-modal").modal({show:true,backdrop:'static',keyboard:false});
            $(this).val("");
        }else if($(this).val() == "new_edit_address")
        {
            var customerid = $("#invoice_billing_to").val();
            AddEditCustomerAddress(customerid);
            $(".form-error").html("");
            $("#add-edit-customer-address-modal").modal({show:true,backdrop:'static',keyboard:false});
            $(this).val("");
        }
        else{
            $("#invoice-edit-form input[name='customer_state']").val(invoiceselectedAddress[$(this).val()]);
            getStateGSTCode(invoiceselectedAddress[$(this).val()]);
        }
    });


    $("#invoice-add-form #invoice_shipping_address").change(function(event){
        event.preventDefault();
        if($(this).val() == "new_address")
        {
            $("#add-customer-address-form")[0].reset();
            $("#add-customer-address-modal").modal({show:true,backdrop:'static',keyboard:false});
            $(this).val("");
            
        }else if($(this).val() == "new_edit_address")
        {
            var customerid = $("#invoice_billing_to").val();
            AddEditCustomerAddress(customerid);
            $(".form-error").html("");
            $("#add-edit-customer-address-modal").modal({show:true,backdrop:'static',keyboard:false});
            $(this).val("");
        }
        else{
            $("#invoice-add-form input[name='customer_state']").val(invoiceselectedAddress[$(this).val()]);
        }
    });





    $("#invoice-edit-form #invoice_shipping_address").change(function(event){
        event.preventDefault();
        if($(this).val() == "new_address")
        {   
            $("#add-customer-address-form")[0].reset();
            $("#add-customer-address-modal").modal({show:true,backdrop:'static',keyboard:false});
            $(this).val("");

        }else if($(this).val() == "new_edit_address")
        {
            var customerid = $("#invoice_billing_to").val();
            AddEditCustomerAddress(customerid);
            $(".form-error").html("");
            $("#add-edit-customer-address-modal").modal({show:true,backdrop:'static',keyboard:false});
            $(this).val("");
        }
        else{
            $("#invoice-edit-form input[name='customer_state']").val(invoiceselectedAddress[$(this).val()]);
        }
    });

    //Customer Invoice select functionality ends


    //Customer address functionality starts here
    function loadCustomerAddress(customer_id,invoiceEditObject)
    {
        customerAddress = [];
        customerState = {};
        $.ajax({
            url:"/merchant/get-customer-address/"+customer_id,
            type:"GET",
            dataType:"json",
            success:function(response){
                var html='';
                customerAddress.push("<option value=''>--Select--</option>");
                $.each(response,function(index,value){
                    customerState[value.id] = value.state_id;
                    customerAddress.push("<option value="+value.id+">"+value.address+"</option>");
                });
                $("#invoice_billing_address").html(customerAddress.join(" "));
                $("#invoice_shipping_address").html(customerAddress.join(" "));
            },
            error:function(error){
                
            },
            complete:function(){
                if(Object.keys(invoiceEditObject).length>0)
                {
                    $.each(invoiceEditObject,function(name,value){
                        if(name == "invoice_billing_address")
                        {
                            $("input[name='customer_state']").val(customerState[value]);
                        }
                        if(name == "tax_applied")
                        {
                            $("#tax-variable").html(value);
                        }
                        $("#invoiceEditModal #"+name).val(value);
                    });
                }
            }
        });
    }
        

    //Customer address functionality ends here


    //Personal Information functionality starts
    $("body").on("click","#nowebsite",function(){
        $(this).prop("checked",true);
        $("#website").prop("checked",false);
        $("input[name='webapp_exist']").val('N');
        $("#web-url").hide();
        $("#webapp_url").prop("required",false);
        if($("#webapp_url").val() == "")
        {
            $("#webapp_url").val("");
        }
        $("#webapp_url").prop("disabled",true);
    });

    $("body").on("click","#website",function(){
        $(this).prop("checked",true);
        $("#nowebsite").prop("checked",false);
        $("input[name='webapp_exist']").val('Y');
        $("#web-url").show();
        $("#webapp_url").prop("required",true);
        $("#webapp_url").prop("disabled",false);
    });
    //Personal Information functionality ends

    //Business Type select change form code starts
    function setbusinessdetails(element)
    {
        var selectedOption = $("#"+element.id+" option:selected").html();
        $("#"+element.id).val(element.value);

        if(selectedOption == "Private Limited" || selectedOption == "Proprietorship" 
        || selectedOption == "Public Limited" || selectedOption == "Partnership" || selectedOption == "Trust"
        || selectedOption == "Society" || selectedOption == "NGO")
        {
            $("#form-business-name").removeClass("display-none");
            $("#form-llpin-number").addClass("display-none");
            $("#form-pan-holder").addClass("display-none");
            $("#business_name").prop("disabled",false);
            $("#llpin_number").prop("disabled",true);
            $("#pan_holder_name").prop("disabled",true);

        }else if(selectedOption == "LLP")
        {
            $("#form-business-name").removeClass("display-none");
            $("#business-name").prop("disabled",false);
            $("#form-llpin-number").removeClass("display-none");
            $("#llpin_number").prop("disabled",false);
            $("#form-pan-holder").addClass("display-none");
        }else{
            $("#form-business-name").addClass("display-none");
            $("#form-llpin-number").addClass("display-none");
            $("#form-pan-holder").removeClass("display-none");
            $("#pan_holder_name").prop("disabled",false);
        }
    }
    //Business Type select change form code ends

    function getMerchantDocumentForm()
    {
        gePopuptForm("business");
        var bussinessType = $("#business_type_id").val();
        $.ajax({
            type:"GET",
            url:"/merchant/documents/upload/"+bussinessType,
            dataType:"html",
            success: function (response) {
                $("#show-document-form").html(response);
            }
        });
    }



//Form functionality ends




// Retrieve data starts

    function getDashboardData()
    {
        
        var appendid = $("#dashboard-form input[name='module']").val();
        var formdata = $("#dashboard-form").serializeArray();
        var transactionHTML = "";
        $.ajax({
            url:"/merchant/dashboard",
            type:"POST",
            data:getJsonObject(formdata),
            dataType:"html",
            success:function(response){
                $("#paginate_"+appendid).html(response);
            },
            error:function(){},
            complete:function(){}
        });
       
    }

    function getDashboardSummary()
    {

        var appendid = $("#dashboard-form-summary input[name='module']").val();
        var formdata = $("#dashboard-form-summary").serializeArray();
        var transactionHTML = "";
        $.ajax({
            url:"/merchant/dashboard",
            type:"POST",
            data:getJsonObject(formdata),
            async: false,
            // dataType:"Json",
            success:function(response){
                
                 $('#dash_summary_info').html(null);
                $('#dash_summary_info').html(response.summary_view);
                dashborad_summary_amchartgraph(response.data);
                dashborad_summary_graph(response.data);


                console.log(response.summary_view);
                //noOfPayments(response);
            },
            error:function(){
            },
            complete:function(){}
        }); 
       
    }


    function getDashboardPayout()
    {

        var appendid = $("#dashboard-form-payout input[name='module']").val();
        var formdata = $("#dashboard-form-payout").serializeArray();
        var transactionHTML = "";
        $.ajax({
            url:"/merchant/payout_overview",
            type:"POST",
            data:getJsonObject(formdata),
            async: false,
            // dataType:"Json",
            success:function(response){
               dashborad_payout_amchartgraph(response.data);
               
            },
            error:function(){
            },
            complete:function(){}
        }); 
       
    }

    function getGstInvoicereport()
    {

        var appendid = $("#gst-report-range-form input[name='module']").val();
        var formdata = $("#gst-report-range-form").serializeArray();
        var transactionHTML = "";
        $.ajax({
            url:"/merchant/gstinvoicereport",
            type:"POST",
            data:getJsonObject(formdata),
            async: false,
            // dataType:"Json",
            success:function(response){
                
                $('#gst_report').html(null);
                $('#gst_report').html(response.gst_invoice_report);
                
               

                console.log(response);
                //noOfPayments(response);
            },
            error:function(){
            },
            complete:function(){}
        }); 
       
    }

    function getDashboardGraph()
    {

        var appendid = $("#dashboard-form input[name='module']").val();
        var formdata = $("#dashboard-form").serializeArray();
        var transactionHTML = "";
        $.ajax({
            url:"/merchant/dashboard",
            type:"POST",
            data:getJsonObject(formdata),
            dataType:"Json",
            success:function(response){
                noOfPayments(response);
            },
            error:function(){
            },
            complete:function(){}
        }); 
       
    }

    function setDashboardPageLimit(pageLimit)
    {
        $("#dashboard-form input[name='perpage']").val(pageLimit);
        getDashboardData();
    }


    //Retrieve All Payments javascript functionality starts
    function getAllPayments(perpage=10)
    {
        $.ajax({
            url:"/merchant/payments/"+perpage,
            type:"GET",
            dataType:"html",
            success:function(response){
                $("#paginate_payment").html(response);
            },
            error:function(){},
            complete:function(){}
        });
    }
    //Retrieve All Payments javascript functionality ends

     //Retrieve All Refunds javascript functionality starts
     function getAllRefunds(perpage=10)
     {
         $.ajax({
             url:"/merchant/refunds/"+perpage,
             type:"GET",
             dataType:"html",
             success:function(response){
                 $("#paginate_refund").html(response);
             },
             error:function(){},
             complete:function(){}
         });
     }
     //Retrieve All Refunds javascript functionality ends

     //Retrieve All Orders javascript functionality starts
     function getAllOrders(perpage=10)
     {
         $.ajax({
             url:"/merchant/orders/"+perpage,
             type:"GET",
             dataType:"html",
             success:function(response){
                 $("#paginate_order").html(response);
             },
             error:function(){},
             complete:function(){}
         });
     }
     //Retrieve All Orders javascript functionality ends

     //Retrieve All Disputes javascript functionality starts
     function getAllDisputes(perpage=10)
     {
         $.ajax({
             url:"/merchant/disputes/"+perpage,
             type:"GET",
             dataType:"html",
             success:function(response){
                 $("#paginate_dispute").html(response);
             },
             error:function(){},
             complete:function(){}
         });
     }
     //Retrieve All Orders javascript functionality ends

     //Retrieve All Invoices javascript functionality starts
     function getAllInvoices(perpage=10)
     {
         $.ajax({
             url:"/merchant/all-invoices/"+perpage,
             type:"GET",
             dataType:"html",
             success:function(response){
                 $("#paginate_invoice").html(response);
             },
             error:function(){},
             complete:function(){}
         });
     }
     //Retrieve All Invoices javascript functionality ends


    //Retrieve Items javascript functionality starts
    function getAllItems(perpage=10){
        $.ajax({
            url:"/merchant/items/"+perpage,
            type:"GET",
            dataType:"html",
            success:function(response){
                $("#paginate_item").html(response);
            },
            error:function(error){
                
            }
        });
    }
    //Retrieve Items javascript functionality ends

    //Retrieve Customers javascript functionality starts
    function getAllCustomers(perpage=10){
        $.ajax({
            url:"/merchant/customers/"+perpage,
            type:"GET",
            dataType:"html",
            success:function(response){
                $("#paginate_customer").html(response);
            },
            error:function(error){
                
            }
        });
    }
    //Retrieve Customers javascript functionality ends

    
    //Retrieve Paylinks javascript functionality starts

    function getAllPaylinks(perpage=10){

        $.ajax({
            url:"/merchant/paylinks/get/"+perpage,
            type:"GET",
            dataType:"html",
            success:function(response){
                $("#paginate_paylink").html(response);
            },
            error:function(error){
                
            }
        });
    }
    //Retrieve Paylinks javascript functionality ends

    //Retrieve QuickLinks javascript functionality starts

    function getAllQuickLinks(perpage=10){

        $.ajax({
            url:"/merchant/quicklinks/"+perpage,
            type:"GET",
            dataType:"html",
            success:function(response){
                $("#paginate_quicklink").html(response);
            },
            error:function(error){
                
            }
        });
    }
    //Retrieve QuickLinks javascript functionality ends

    //Retrive Business SubCategory starts
    function getsubcategory(element){

        var category_id = $(element).val();
        var optionText = $("#"+element.id+" option:selected").text();
        if(optionText != "Others"){
            $("#sub-category-div").show();
            $("#sub-categort-others").hide();
            $("#business_sub_category").prop("disabled",true);
            $("#business_sub_category_id").prop("disabled",false);
            $.ajax({
                url:"/merchant/get-sub-category",
                type:"POST",
                data:{id:category_id,_token:$('meta[name="csrf-token"]').attr('content')},
                dataType:"json",
                success:function(response){
                    var html='<option value="">--Select--</option>';
                    $.each(response,function(index,value){
                        html+='<option value='+value.id+'>'+value.sub_category_name+'</option>';
                    });
                    $("#business_sub_category_id").html(html);
                    $("#sub-category-div").removeClass("display-none");
                },
                error:function(error){
                    
                }
            });
        }else{
            $("#business_sub_category_id").prop("disabled",true);
            $("#business_sub_category").prop("disabled",false);
            $("#sub-category-div").hide();
            $("#sub-categort-others").show();
        }
        
    }
    //Retrieve Business SubCategory ends


    //Retrieve Customer Address functionality starts

    function getCustomerAddress(customerid,formid)
    {
        customerAddress = [];
        $.ajax({
            url:"/merchant/get-customer-info/"+customerid,
            type:"GET",
            dataType:"json",
            success:function(response){
                if(response.info.length > 0)
                {
                    $.each(response.info[response.info.length-1],function(index,value){
                        $("#"+formid+" input[name="+index+"]").val(value);
                    });
                }
                customerAddress.push("<option value=''>--Select--</option>");
                if(response.address.length>0)
                {
                    $.each(response.address,function(index,object){
                        customerAddress.push("<option value="+object.id+">"+object.address+"</option>");
                        invoiceselectedAddress[object.id] = object.state_id; 
                    });
                    customerAddress.push("<option value=new_edit_address>Add/Edit</option>")
                    
                }else{
                    customerAddress.push("<option value='new_address'>+add new</option>");
                }
                $("#invoice_billing_address").html(customerAddress.join(" "));
                $("#invoice_shipping_address").html(customerAddress.join(" "));
            },
            error:function(error){
                
            },
            complete:function(){
                $("#add-customer-address-form #customer_id").val(customerid);
            }
        });
    }

    function AddEditCustomerAddress(customerid)
    {
        var tablehtml = "";
        customerAddress = [];
        $("#add-edit-customer-address-form")[0].reset();
        $.ajax({
            url:"/merchant/get-customer-info/"+customerid,
            type:"GET",
            dataType:"json",
            success:function(response){
                if(response.address.length>0)
                {
                    $.each(response.address,function(key,object){
                        tablehtml+='<tr>';
                        tablehtml+='<td class="word-wrap">'+object.address+'</td>';
                        tablehtml+="<td class='btn btn-primary btn-sm' onclick='editCustomerAddress("+JSON.stringify(object)+")'><i class='fa fa-pencil'></i></td>";
                        tablehtml+='</tr>';
                    });
                        customerAddress.push("<option value=''>--Select--</option>");
                    $.each(response.address,function(index,object){
                        customerAddress.push("<option value="+object.id+">"+object.address+"</option>");
                        invoiceselectedAddress[object.id] = object.state_id; 
                    });
                    customerAddress.push("<option value=new_edit_address>Add/Edit</option>")
                }else{
                    customerAddress.push("<option value='new_address'>+add new</option>");
                }
                $("#invoice-add-form #invoice_billing_address").html(customerAddress.join(" "));
                $("#invoice-add-form #invoice_shipping_address").html(customerAddress.join(" "));

                $("#add-customer-address-list").html(tablehtml);
            },
            error:function(error){
                
            },
            complete:function(){
                $("#add-edit-customer-address-form #customer_id").val(customerid);
            }
        });
    }

    //Retrieve Customer Address on Modal functionality starts here

    function editCustomerAddress(object){
       $.each(object,function(index,value)
       {    
           $("#add-edit-customer-address-form input[name="+index+"]").val(value);
           if(index == "customer_address")
           {
               $("#add-edit-customer-address-form textarea[name='address']").val(value);
           }
           $("#add-edit-customer-address-form #state_id").val(object.state_id);
           $("#change-button-label").html("Update Address");
       });
    }

    //Retrieve Customer Address on Modal functionality ends here

    //Retrieve merchant api functioanlity starts here
    function getMerchantApi()
    {
        $.ajax({
            url:"/merchant/api/get-api",
            type:"GET",
            dataType:"html",
            success:function(response){
                $("#merchant-api-view").html(response);
            },
            error:function(){

            }
        })
    }
    //Retrieve merchant api functionality ends here

    //get Api Details javascript functionality code starts here
    function viewApi(api_id)
    {
        if(api_id!="")
        {
            $.ajax({
                url:"/merchant/api/details/"+api_id,
                type:"GET",
                dataType:"json",
                success:function(response){
                    if(response.length > 0)
                    {   
                        $.each(response[response.length-1],function(key,value){
                            $("#update-api-form input[name="+key+"]").val(value);
                        });
                    }
                },
                complete:function(){
                    $("#update-api-modal").modal({show:true,backdrop:'static',keyboard:false});
                }
            })
        }
    }
    //get Api Details javascript functionality code ends here

     //Retrieve merchant Reminder functionality starts here
    function getRemindersData()
    {
        var expiryplwecount = 0;
        var expiryplwoecount = 0;
        var plwoehtml = "";
        var plwehtml = "";
        $("#append-plwed-options").html("");
        $("#append-plwoed-options").html("");
        $.ajax({
            url:"/merchant/reminder/get",
            type:"GET",
            dataType:"json",
            success:function(response){
                $.each(response,function(index,object)
                {
                    $.each(object,function(name,value){
                        if(value == "plwed")
                        {
                            selectedplwed[expiryplwecount] = object["reminder_days"].toString();
                            plwehtml = `<div id=plwed-option_`+expiryplwecount+`>
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <select id='select-plwed-expiry-day_`+expiryplwecount+`' class="form-control" name="plwed[]" onchange='plwedOption("`+expiryplwecount+`")'>
                                        `+expirdays.join(" ")+`
                                        </select>
                                    </div>
                                <i class='fa fa-remove show-cursor remove-plwed' data-row=`+expiryplwecount+`></i>
                                </div>
                            </div>`;
                            $("#append-plwed-options").append(plwehtml);
                            $("#select-plwed-expiry-day_"+expiryplwecount).val(object["reminder_days"]);
                            
                            expiryplwecount = expiryplwecount+1;
                        }else{
                            if(value == "plwoed"){
                                selectedplwoed[expiryplwecount] = object["reminder_days"].toString();
                                plwoehtml = `<div id=plwoed-option_`+expiryplwoecount+`>
                                        <div class="form-group">
                                        <div class="col-sm-6">
                                            <select id='select-plwoed-expiry-day_`+expiryplwoecount+`' class="form-control" name="plwoed[]" onchange='plwoedOption("`+expiryplwoecount+`")'>
                                            `+issuedays.join(" ")+`
                                            </select>
                                        </div>
                                        <i class='fa fa-remove show-cursor remove-plwoed' data-row=`+expiryplwoecount+`></i>
                                    </div></div>`;
                                $("#append-plwoed-options").append(plwoehtml);
                                $("#select-plwoed-expiry-day_"+expiryplwoecount).val(object["reminder_days"]);
                                expiryplwoecount = expiryplwoecount+1;
                            }
                            if(object["send_sms"] == "Y")
                            {
                                $("#send_sms").prop("checked",true);
                            }
                            if(object["send_email"] == "Y")
                            {
                                $("#send_email").prop("checked",true);
                            }
                            
                        }
                        
                    });                    
                })
                if(expiryplwecount == 3)
                {
                    $("#add-plwed-options").toggle();
                }
                if(expiryplwoecount == 3)
                {
                    $("#add-plwoed-options").toggle();
                }
            },
            error:function(){},
            complete:function(){}
        });
    }
   
    //Retrieve merchant Webhook functioanlity starts here
    function getWebhookData()
    {
        var eventscount = 0;
        var tablevalues = ["webhook_url","is_active","created_date"]
        var webhookURL = "";
        var isActive = "";
        var tablerowhtml = "";
        var createdDate = "";
        $.ajax({
            url:"/merchant/webhook/get",
            type:"GET",
            dataType:"json",
            success:function(response){
                if(response.length > 0)
                {
                    $.each(response[response.length-1],function(key,value){

                        if(value == "Y" && key!="is_active")
                        {
                            eventscount = eventscount+1;
                        }
    
                        if(key == "webhook_url")
                        {
                            webhookURL = value;
                        }
                        if(key == "is_active")
                        {
                            if(value == "Y")
                            {
                                isActive = "Active";
                            }else{
                                isActive = "In Active";
                            }
    
                        }
                        if(key == "created_date")
                        {
                            createdDate = value;
                        }
                        if(key == "id")
                        {
                            $("input[name='id']").val(value);
                        }
                        
                    });

                    tablerowhtml = `<tr>
                        <td>`+webhookURL+`</td>
                        <td>`+isActive+`</td>
                        <td>`+eventscount+" Events Added"+`</td>
                        <td>`+createdDate+`</td>
                    </tr>`
                    $("#call-webhook-modal").html("Edit Webhook");
                   
                }else{
                    tablerowhtml = `<tr>
                        <td colspan='4' class='text-center'>No Data</td>
                    </tr>`
                }
                
            },
            error:function(){},
            complete:function(){
                $("#web-hook-details").html(tablerowhtml);
            }
        });
    }
    

    //Retrieve merchant support data functionality starts here
    function getSupportData(perpage=10)
    {
        var tablerow = ""
        $.ajax({
            url:"/merchant/support/get/"+perpage,
            type:"GET",
            dataType:"html",
            success:function(response){
                $("#paginate_merchantsupport").html(response);
            },
            error:function(){},
            complete:function(){}
        });
    }
    //Retrieve merchant support data functionality ends here

    //Retrieve merchant feedback data functionality starts here
    function getFeedbackData(perpage=10)
    {
        var tablerow = ""
        $.ajax({
            url:"/merchant/feedback/get/"+perpage,
            type:"GET",
            dataType:"html",
            success:function(response){
                $("#paginate_feedbackdetail").html(response);
            },
            error:function(){},
            complete:function(){}
        });
    }
    //Retrieve merchant feedback data functionality ends here


    //Retrieve merchant product data functionality starts here
    function getAllProducts(perpage=10)
    {
        var tablerow = ""
        $.ajax({
            url:"/merchant/product/get/"+perpage,
            type:"GET",
            dataType:"html",
            success:function(response){
                $("#paginate_product").html(response);
            },
            error:function(){},
            complete:function(){}
        });
    }

    
    //Retrieve merchant product data functionality starts here
    function getAllPageDetails(perpage=10)
    {
        var tablerow = ""
        $.ajax({
            url:"/payment-pages/get-all-pages/"+perpage,
            type:"GET",
            dataType:"html",
            success:function(response){
                $("#paginate_pagedetail").html(response);
            },
            error:function(){},
            complete:function(){}
        });
    }

    //Retrieve Coupon data functionality ends here
    function getAllCoupons(perpage=10)
    {
        $.ajax({
            url:"/merchant/coupons/get/"+perpage,
            type:"GET",
            dataType:"html",
            success:function(response){
                $("#paginate_coupon").html(response);
            },
            error:function(){},
            complete:function(){}
        });
    }
    //Retrieve Coupon  data functionality starts here


    //Retrieve Coupon products Options functionality ends here
    function getAllCouponProducts()
    {
        processData = [];
        $.ajax({
            url:"/merchant/product/get/all",
            type:"GET",
            dataType:"json",
            success:function(response){
                if(response.status)
                {
                    processData.push("<option value=''>--Select--</option>");
                    $.each(response.products,function(index,object){
                        processData.push("<option value="+object.id+">"+object.product_title+"</option>");
                    });
                }
                $("#coupon_onproduct").html(processData);
            },
            error:function(){},
            complete:function(){}
        });
    }
    //Retrieve Coupon Products Options functionality starts here


    //Retrieve Coupon Product Options functionality ends here

    //Retrieve Customer Case data functionality starts here
    function getCustomerCaseData(perpage=10)
    {
        var tablerow = ""
        $.ajax({
            url:"/merchant/customer-case/get/"+perpage,
            type:"GET",
            dataType:"html",
            success:function(response){
                $("#paginate_casedetail").html(response);
            },
            error:function(){},
            complete:function(){}
        });
    }
    //Retrieve Customer Case data functionality ends here

    //Retrieve Case Comments functionality starts here 
    function getCommentDetails(){
        var caseid = $("#merchant-comment-form input[name='case_id']").val();
        var commentHtml = "";
        var userType = {'merchant':'Merchant','customer':'Customer','rupayapay':'Rupayapay'};
        $.ajax({
            url:"/support/case/comment/get/"+caseid,
            type:"GET",
            dataType:"json",
            success:function(response){
                if(response.length > 0)
                {
                    $.each(response,function(index,object){
                        var right = true;
                        if(object.user_type == 'merchant')
                        {
                            commentHtml+=`<li class="clearfix">
                                <div class="message-data align-right">
                                <span class="message-data-time" >`+object.commented_date+`</span> &nbsp; &nbsp;
                                <span class="message-data-name" >`+userType[object.user_type]+`</span> <i class="fa fa-circle me"></i>
                                </div>
                                <div class="message other-message float-right">
                                `+object.comment+`
                                </div>
                                </li>`;
                            right = false;
                        }else if(object.user_type == 'customer'){
      
                          commentHtml+=`<li>
                              <div class="message-data">
                              <span class="message-data-name" >`+userType[object.user_type]+`</span> <i class="fa fa-circle me"></i>
                              <span class="message-data-time" >`+object.commented_date+`</span> &nbsp; &nbsp;
                              </div>
                              <div class="message my-message">
                              `+object.comment+`
                              </div>
                              </li>`;
                        }else{
      
                            if(right){
                              commentHtml+=`<li class="clearfix">
                                <div class="message-data align-right">
                                <span class="message-data-time" >`+object.commented_date+`</span> &nbsp; &nbsp;
                                <span class="message-data-name" >`+userType[object.user_type]+`</span> <i class="fa fa-circle me"></i>
                                </div>
                                <div class="message other-message float-right">
                                `+object.comment+`
                                </div>
                                </li>`;
                            }else{
                                commentHtml+=`<li>
                                <div class="message-data">
                                <span class="message-data-name" >`+userType[object.user_type]+`</span> <i class="fa fa-circle me"></i>
                                <span class="message-data-time" >`+object.commented_date+`</span> &nbsp; &nbsp;
                                </div>
                                <div class="message my-message">
                                `+object.comment+`
                                </div>
                                </li>`;
                            }
                           
                        }
                    });
                    
                    
                }else{
                    commentHtml=`<li class="clearfix">
                                <div class="message-data align-right">
                                <span class="message-data-time" ></span> &nbsp; &nbsp;
                                <span class="message-data-name" >Merchant</span> <i class="fa fa-circle me"></i>
                                </div>
                                <div class="message other-message float-right">
                                No comments till now
                                </div>
                                </li>`;
                }
                $("#previous-comment").html(commentHtml);
                $(".chat-history").each(function(index,element){
                    $(".chat-history").animate({ scrollTop: element.scrollHeight}, 600); 
                });
            },
            error:function(){},
            complete:function(){}
        });
      }
    //Retrieve Case Comments functionality ends here

    //Retrieve Merchant Notifications functioanlity starts here
    function getAllNotifications()
    {
        var notseennotifycount = 0;
        var notificationHTML = ""
        $.ajax({
            url:"/merchant/notifications",
            type:"GET",
            dataType:"json",
            success:function(response){
                $.each(response,function(index,object){
                    if(object.seen =="N")
                    {
                        notseennotifycount += 1;
                    }
                    notificationHTML += `<li>
                                            <a href="javascript:">
                                            <p>`+object.message+`</p>
                                                <h4>
                                                    <small class='pull-right'><i class="fa fa-clock-o"></i> `+object.created_date+`</small>
                                                </h4>
                                            </a>
                                        </li>`;

                });

                if(notificationHTML == "")
                {
                    notificationHTML = `<li>
                                            <a href="javascript:">
                                            <h4>
                                            <small class="text-center"><i class="fa fa-clock-o"></i>No Notifications</small>
                                            </h4>
                                            <p></p>
                                            </a>
                                        </li>`;
                }

                $("#notifications-list").prepend(notificationHTML);
                $("#new-notification-count").html(notseennotifycount);
                $("#new-notification-status").html("You have "+notseennotifycount+" notification");
            },
            error:function(){},
            complete:function(){}
        });
    }

    function getAllMessages()
    {
        var notseenmessagecount = 0;
        var messageHTML = ""
        $.ajax({
            url:"/merchant/messages",
            type:"GET",
            dataType:"json",
            success:function(response){
                $.each(response,function(index,object){
                    if(object.seen =="N")
                    {
                        notseenmessagecount += 1;
                    }
                    messageHTML += `<li>
                                        <a href="javascript:">
                                        `+object.message+`
                                        </a>
                                    </li>`;

                });
                if(messageHTML == "")
                {
                    messageHTML = `<li><a href="javascript:" class="text-center">No Messages</a></li>`;
                }
                $("#messages-list").prepend(messageHTML);
                $("#new-message-count").html(notseenmessagecount);
                $("#new-message-status").html("You have "+notseenmessagecount+" message");
            },
            error:function(){},
            complete:function(){}
        });
    }


    function getAllMerchantNotifications(perpage=10){
        $.ajax({
            type:"GET",
            url:"/merchant/merchant-notifications/"+perpage,
            dataType:"html",
            success:function(response) {
                $("#paginate_notification").html(response);
            }
        });
    }

    function getAllMerchantMessages(perpage=10){
        $.ajax({
            type:"GET",
            url:"/merchant/merchant-messages/"+perpage,
            dataType:"html",
            success:function(response) {
                $("#paginate_message").html(response);
            }
        });
    }
    //Retrieve Merchant Notification functionality ends here


    //Retrieve Coupons Types with subtypes functionality starts here
    function getCouponsTypesSubtypes(loadat="")
    {
        coupon_subtype = [];
        var coupon_type = [];
        $.ajax({
            url:"/merchant/coupon/options",
            type:"GET",
            dataType:"json",
            success:function(response){
                if(response.length > 0)
                {
                    coupon_type.push("<option value=''>--Select--</option>"); 
                    coupon_subtype.push("<option value=''>--Select--</option>");
                    $.each(response,function(index,object){
                        
                        if(object.option_type == "type")
                        {
                            coupon_type.push("<option value="+object.id+">"+object.coupon_option+"</option>"); 
                        }else{
                            coupon_subtype.push("<option value="+object.id+">"+object.coupon_option+"</option>");
                        }
                    });
                }
                if(loadat == "")
                {
                    $("#coupon_type").html(coupon_type);
                    $("#coupon_on").html(coupon_subtype);
                }
            },
            error:function(){},
            complete:function(){}
        })
    }
    //Retrieve Coupons Types with subtypes functionality ends here

    function getStateGSTCode(stateid){
        var stateGSTCode;
        if(stateid!=""){
            $.ajax({
                type:"GET",
                url:"/merchant/customer/state/get-gstcode/"+stateid,
                dataType: "json",
                success: function (response) {
                   if(response.status)
                   {
                       if(Object.keys(response.state_gstcode).length > 0)
                       {
                            $.each(response.state_gstcode, function (indexInArray, valueOfElement) { 
                                stateGSTCode = valueOfElement.gst_code;
                                $("#customer_gst_code").val(valueOfElement.gst_code);
                                $("#gst_state").val(valueOfElement.gst_code);
                            });
                       }

                       if($("#customer_gstno").length > 0 && stateGSTCode!="" && $("#customer_gstno").val()!="")
                       {
                           var givenGSTStateCode = $("#customer_gstno").val().substr(0,2);
                           if(stateGSTCode!=givenGSTStateCode)
                           {
                                $("#customer_gstno").focus();
                                $("#customer_gstno_error").html("Selected state and given GST is not matching").css({"color":"red"});
                                $("#customer_gstno").click(function(e){
                                    $("#customer_gstno_error").html("");
                                });
                                return false;
                           }
                       }
                      
                   }
                }
            });
        }
        
    }

    function getAllMerchantEmployees(perpage=10){
        $.ajax({
            type:"GET",
            url:"/merchant/employee/get/"+perpage,
            dataType: "html",
            success: function (response) {
                $("#paginate_employees").html(response);
                $('[data-toggle="popover"]').popover();
            }
        });
    }

    function getAllMerchantEmployeesTypes($id){
        if($id){

             $.ajax({
            type:"GET",
            url:"/merchant/employee/type/"+$id,
            dataType: "html",
            success: function (response) {
                $("#paginate_employees").html(response);
                $('[data-toggle="popover"]').popover();
            }
        });

        }else{
            $("#paginate_employees").html(response);
        }
       
    }

// Retrieve data ends

//Store data starts

    //Store items javascript functionality starts

    $("#itemadd").submit(function(event){
        event.preventDefault();
        var formdata = $("#itemadd").serializeJSON();
        
        $("#itemadd input[name='item_name[]']").each(function(index,element){
            if($(element).val() == "")
            {
                $(element).css({"border":"1px solid red"});
                return false;
            }
        });

        $("#itemadd input[name='item_amount[]']").each(function(index,element){
            var regnumber_rule = /^[0-9\.]+/g;
            if(!regnumber_rule.test($(element).val()))
            {
                $(element).css({"border":"1px solid red"});
                return false;
            }
        });

        $.ajax({
            url:"/merchant/item/new",
            type:"POST",
            data:formdata,
            dataType:"json",
            success:function(response){
                if(response.status)
                {
                    showMessage(response.status,response.message,"item-response-message");
                    getAllItems();
                    $('#call-item-model').modal('hide');
                    
                }else{
                    
                    if(Object.keys(response.errors).length > 0)
                    {
                        $.each(response.errors, function (indexInArray, valueOfElement) {
                             $("#new-row #"+indexInArray.replace(".","_")).html("Field is required").css({"color":"red"});
                        });
                    }
                    
                }
            
            },
            error:function(error){
                
            }
        });
        
    });

    //Store items javascript functionality ends


    //Store bulk items javascript functionality starts here

    $("#bulk-items-form").submit(function(event){
        event.preventDefault();
        var formdata = $("#bulk-items-form")[0];
        var data = new FormData(formdata);

        $.ajax({
            url:"/merchant/item/bulk/new",
            type:"POST",
            enctype:"multipart/form-data",
            data:data,
            processData:false,
            contentType:false,
            cache:false,
            dataType:"json",
            success:function(response){
                if(response.status)
                {
                    showMessage(response.status,response.message,"item-bulk-response-message");
                    getAllItems();
                    $("#bulk-items-form")[0].reset();
                }else{
                    showMessage(response.status,response.message,"item-bulk-response-message");
                }
            },
            error:function(){

            }
        })
    });

    $("#reset-bulk-items-form").click(function(e){
        e.preventDefault();
        $("#item-bulkupload").html("Choose a file…");
        $("#bulk-items-form")[0].reset();
    });

    //Store bulk items javascript functionality ends here

    //Store paylink javascript functionality starts
    $("#paylinkadd").submit(function(event){
        event.preventDefault();
        var formdata = $("#paylinkadd").serializeArray();
        var paylinkAmount = $("#paylink_amount").val();
        var formvalidate = true;
        
        // var regnumber_rule = /^[0-9\.]+/g;
        var regnumber_rule = /^[1-9][0-9]*$/;

        var errormessage = "Enter valid Amount";
        var amount_field = regnumber_rule.test($("#paylink_amount").val());
        var linkfor_field = $("#paylink_for").val();

        var paylinkid = $("input[name='id']").val();

        if(!amount_field)
        {   
            $("#paylink_amount_error").html(errormessage).css({"color":"red"});
            formvalidate = false;
            return false;
        }

        if(linkfor_field == "")
        {
            $("#paylink_for_error").html("Purpose is Empty").css({"color":"red"});
            formvalidate = false;
            return false;
        }
        $("#paylinkadd input[type='checkbox']").each(function(index,element){
            var elementName = $(element)[0].name;
            if(element.name=="email_paylink" && $(element).prop('checked') && $("#paylinkadd #paylink_customer_email").val()==""){
                $("#paylinkadd #paylink_customer_email").focus();
                $("#paylinkadd #paylink_customer_email_error").html("Email is empty").css({"color":"red"});
                $("#paylinkadd #paylink_customer_email").click(function(e){
                    e.preventDefault();
                    $("#paylinkadd #paylink_customer_email_error").html("");
                });
                formvalidate = false;
            }else if(element.name=="mobile_paylink" && $(element).prop('checked') && $("#paylinkadd #paylink_customer_mobile").val()==""){
                $("#paylinkadd #paylink_customer_mobile").focus();
                $("#paylinkadd #paylink_customer_mobile_error").html("Mobile is empty").css({"color":"red"});
                $("#paylinkadd #paylink_customer_mobile").click(function(e){
                    e.preventDefault();
                    $("#paylinkadd #paylink_customer_mobile_error").html("");
                });
                formvalidate = false;
            }
            formdata[formdata.length] = {name:elementName,value:$(element).val()};
        });
        if($("#paylink_customer_email").val()!="")
        {
            if(!vaidateEmail("paylink_customer_email","paylink_customer_email","paylinkadd")){
                formvalidate = false;
                return false; 
            }
        }

        if($("#paylink_customer_mobile").val()!="")
        {
            if(!validateMobile("paylink_customer_mobile","paylink_customer_mobile","paylinkadd")){
                formvalidate = false;
                return false;
            }
        }
        if(paylinkid == "" && formvalidate)
        {
            $("div#divLoading").removeClass('hide');
            $("div#divLoading").addClass('show');
            $.ajax({
                url:"/merchant/paylink/new",
                type:"POST",
                data:getJsonObject(formdata),
                dataType:"json",
                success:function(response){
                    if(response.status)
                    {
                        getAllPaylinks();
                        showMessage(response.status,response.message,"paylink-response-message");
                        $("#paylinkadd")[0].reset();
                    }else{
                        $.each(response.errors, function (indexInArray, valueOfElement) { 
                            $("#paylinkadd #"+indexInArray+"_error").html(valueOfElement[0]).css({"color":"red"});
                            $("input[name="+indexInArray+"]").click(function(e){
                                e.preventDefault();
                                $("#paylinkadd #"+indexInArray+"_error").html("");
                            });
                       });
                        $("#paylinkadd")[0].reset(); 
                    }

                    $("#paylinkadd input[type='checkbox']").each(function(index,element){
                        element.value="N";
                    });
                
                },
                error:function(error){
                   
                },complete:function(){
                    $("div#divLoading").removeClass('show');
                    $("div#divLoading").addClass('hide');
                    setTimeout(() => {
                        $("#paylink-response-message").html("");
                    }, 3000);
                    $("#paylink-add").prop("disabled",true);
                }
            });

        }
        
    });
    //Store paylink javascript functionality ends

    //Store bulk paylink javascript functionlaity starts
    $("#bulk-paylink-form").submit(function(event){
        event.preventDefault();
        var formdata = $("#bulk-paylink-form")[0];
        var data = new FormData(formdata);
        $.ajax({
            url:"/merchant/paylink/bulk/new",
            type:"POST",
            enctype:"multipart/form-data",
            data:data,
            processData:false,
            contentType:false,
            cache:false,
            dataType:"json",
            success:function(response){
                if(response.status)
                {
                    showMessage(response.status,response.message,"paylink-bulk-response-message");
                    getAllPaylinks();
                    $("#paylink-bulkupload").html("Choose a file…");
                    $("#bulk-paylink-form")[0].reset();
                }else{
                    showMessage(response.status,response.message,"paylink-bulk-response-message");
                }
            },
            error:function(){

            }
        })
    });

    $("#reset-bulk-paylink-form").click(function(e){
        e.preventDefault();
        $("#paylink-bulkupload").html("Choose a file…");
        $("#bulk-paylink-form")[0].reset();
    });

    //Store bulk paylink javascript functionality ends

    //Store Quick Link functionality starts here
    $("#quick-link-form").submit(function(e){
        e.preventDefault();
        var formdata = $("#quick-link-form").serializeArray();
        var errormessage = {"paylink_amount":"Amount field should not be empty",
        "paylink_for":"Purpose field should not be empty"};

        $.each(formdata,function(index,object){
            if(object.value == "")
            {
                $("#quick-link-form #"+object.name+"_ajax_error").html(errormessage[object.name]).css({"color":"red"});
                $("#quick-link-form input[name="+object.name+"]").click(function(){
                    $("#quick-link-form #"+object.name+"_ajax_error").html("");
                });
                $("#quick-link-form textarea[name="+object.name+"]").click(function(){
                    $("#quick-link-form #"+object.name+"_ajax_error").html("");
                });
                return false;
            }
        });

        $.ajax({
            url:"/merchant/quicklink/add",
            type:"POST",
            data:getJsonObject(formdata),
            dataType:"json",
            success:function(response){
                if(response.status)
                {
                    $("#ajax-response-message").html(response.message).css({"color":"green"});
                    $("#quick-link-form")[0].reset();
                }else{
                    if(typeof response.errors !="undefined" && Object.keys(response.errors).length > 0){
                        $.each(response.errors, function (indexInArray, valueOfElement) { 
                            $("#quick-link-form #"+indexInArray+"_ajax_error").html(valueOfElement[0]).css({"color":"red"});
                            $("#quick-link-form input[name="+indexInArray+"]").click(function(){
                                $("#quick-link-form #"+indexInArray+"_ajax_error").html("");
                            });
                            $("#quick-link-form textarea[name="+indexInArray+"]").click(function(){
                                $("#quick-link-form #"+indexInArray+"_ajax_error").html("");
                            });
                        });
                    }
                }
            },
            error:function(){},
            complete:function(){
                getAllQuickLinks();
                setTimeout(() => {
                    $("#ajax-response-message").html("");
                },3000);
            }
        });
    })
    //Store Quick Link functionality ends here

    //Store Personal Details functionality starts
    $("#personal-info-form").submit(function(event){
        event.preventDefault();

        var formdata = $("#personal-info-form").serializeArray();
        var formfilled;
        var formLabelObject = {
            "name":"Contact Name",
            "email":"Contact Email",
            "mobile_no":"Contact Mobile",
            "business_type_in":"Business Type",
            "business_category_in":"Business Category",
            "business_sub_category_id":"Business Sub Category",
            "billing_label":"Billing Label",
            "business_name":"Business Name",
            "pan_number":"PAN Number",
            "address":"Address",
            "pincode":"Pincode",
            "city":"City",
            "state":"State"
        }

        $.each(formdata,function(index,element){
            if(element.value == "" && element.name!="id")
            {
                $("#"+element.name+"_error").html("Field "+formLabelObject[element.name]+" is Empty").css({"color":"red"});
                $("#"+element.name).focus();
                
                $("#personal-info-form input[name="+element.name+"]").on("click",function(event){
                    event.preventDefault();
                    $("#"+element.name+"_error").html("");

                });

                $("#personal-info-form textarea[name="+element.name+"]").on("click",function(event){
                    event.preventDefault();
                    $("#"+element.name+"_error").html("");
                });

                $("#personal-info-form #"+element.name).on("change",function(event){
                    event.preventDefault();
                    $("#"+element.name+"_error").html("");
                });
                formfilled = false;
                return false;
            }else{
                formfilled = true;
            }

        });
       if(formfilled)
       {
           $.ajax({
               url:"/merchant/personal-info/save",
               type:"POST",
               data:getJsonObject(formdata),
               dataType:"json",
               success:function(response){
                    if(response.status)
                    {
                        $("#personal-message-modal").modal("show");
                        $("#personal-response-message").html(response.message)
                    }
               },
               error:function(error){}
           })
       }

    });
    //Store Personal Details functionality ends


    //Invoice generate/save functionality starts here
    function addInvoice(value='')
    {

        var formdata = "";
        var formvalidate = "";
        var isformvalid = false;

        $("#invoice-add-form #invoice_status").val(value);

        formdata = $("#invoice-add-form").serializeJSON();
        formvalidate = $("#invoice-add-form").serializeArray();
       
        var mandatory = {
            "invoice_receiptno":"Invoice No",
            "merchant_company":"Company",
            "merchant_panno":"Pan No",
            "invoice_issue_date":"Invoice Date",
            "invoice_billing_to":"Name",
            "customer_email":"Email",
            "customer_phone":"Phone",
            "invoice_billing_address":"Billing Address",
            "invoice_shipping_address":"Shipping Address",
        }
        
        $.each(formvalidate,function(index,element){
            
            if(element.name in mandatory)
            {
                if(element.value == "")
                {
                    $("#"+element.name+"_error").html("Field "+mandatory[element.name]+" is empty").css({"color":"red"})
                    
                    $("#"+element.name).focus();

                    $("input[name="+element.name+"]").click(function(event){
                        event.preventDefault();
                        $("#"+element.name+"_error").html("");
                    });

                    $("#"+element.name).change(function(event){
                        event.preventDefault();
                        $("#"+element.name+"_error").html("");
                    })
                    isformvalid = false;
                    return false;
                }
            }else{

                if($("#item_name1").val() == "" && element.name!="customer_gstno")
                {
                    $("#item_name1_error").html("1 item must add").css({"color":"red"});
                    $("#item_name1").focus();
                    $("#item_name1").change(function(event){
                        event.preventDefault();
                        $("#item_name1_error").html("");
                    });
                    isformvalid = false;
                    return false;
                }else{
                    isformvalid = true;
                }
            }
        });

        if($("#customer_gstno").val()!=""){
            var stategstcode = "";
            stategstcode = $("#customer_gst_code").val();
            if(stategstcode != $("#customer_gstno").val().substr(0,2))
            {
                $("#customer_gstno").focus();
                $("#customer_gstno_error").html("Selected state and given GST is not matching").css({"color":"red"});
                $("#customer_gstno").click(function(e){
                    $("#customer_gstno_error").html("");
                });
                return false;
            }
        }
        

        if(isformvalid)
        {
            if(ValidatePAN('merchant-add-panno','merchant-add-panno-error') && ValidateMerchantGSTno('merchant-add-gstno','merchant-add-gstno_error') &&
            validateMobile('customer_phone','customer_phone_error') && vaidateEmail('customer_email','customer_email_error'))
            {   
                $.ajax({
                    url:"/merchant/invoice/add",
                    type:"POST",
                    data:formdata,
                    dataType:"json",
                    success:function(response){
                        if(response.status)
                        {
                            $("#invoice-add-response").html(response.message).css({"color":"green"});
                        }
                    },
                    error:function(error){
                    },
                    complete:function(){
                        $("#invoice-add-response-message-modal").modal({show:true});
                    }
                })

            }else{
                
                $("#send-invoice-sms").prop("checked",false);
                $("#send-invoice-mail").prop("checked",false);
            }
            
        }
    }
    //Invoice save functionality ends here

    //Store Customer functionality starts here
    $("#add-customer-form").submit(function(event){
        event.preventDefault();
        var formdata = $("#add-customer-form").serializeArray();
        var elementid = "";
        if(vaidateEmail('customer-email','custome-email-error') && validateMobile('customer-phone','customer-phone-error') && ValidateMerchantGSTno('customer-gstno','customer-gstno-error'))
        {
            $.ajax({
                url:"/merchant/customer/add",
                type:"POST",
                data:getJsonObject(formdata),
                dataType:"json",
                success:function(response){
                    if(response.status)
                    {
                        $("#add-response-message").html(response.message).css({"color":"green"});
                        $("#add-customer-form")[0].reset();
                    }else{
                       
                        if(typeof response.errors!="undefined" && Object.keys(response.errors).length > 0)
                        {
                            $.each(response.errors,function(indexInArray,valueOfElement) {
                                elementid = indexInArray+"_error";
                                 $("#add-customer-form #"+elementid.replace(/_/g,'-')).html(valueOfElement[0]).css({"color":"red"});
                                 $("#add-customer-form input[name="+indexInArray+"]").click(function(e){
                                     e.preventDefault();
                                     elementid = indexInArray+"_error";
                                    $("#add-customer-form #"+elementid.replace(/_/g,'-')).html("");
                                 })
                            });
                        }else{
                            $("#add-response-message").html(response.message).css({"color":"red"});
                        }
                    }
                },
                error:function(){},
                complete:function(){
                    loadLatestAddedCustomers("select");
                    getAllCustomers();
                    setTimeout(() => {
                        $("#add-response-message").html("");
                    }, 1500);

                }
            });
        
        }
    });
        
    //Store customer functionality ends here

    //Store Customer Address functionality starts here
    $("#add-customer-address-form").submit(function(e){
        e.preventDefault();
        var formdata = $("#add-customer-address-form").serializeArray();
        var customerid = $("#add-customer-address-form #customer_id").val();
        $.ajax({
            url:"/merchant/customer-address/add",
            type:"POST",
            data:getJsonObject(formdata),
            dataType:"json",
            success:function(response){
                if(response.status)
                {
                    $("#ajax-address-response-message").html(response.message).css({"color":"green"});

                }else{

                    if(typeof response.errors != undefined && Object.keys(response.errors).length > 0){
                        $.each(response.errors, function (indexInArray, valueOfElement) { 
                             $("#add-customer-address-form #"+indexInArray+"_error").html(valueOfElement[0]).css({"color":"red"});
                             $("#add-customer-address-form input[name="+indexInArray+"]").click(function(e){
                                 e.preventDefault();
                                 $("#add-customer-address-form #"+indexInArray+"_error").html("");
                             })
                             $("#add-customer-address-form textarea[name="+indexInArray+"]").click(function(e){
                                e.preventDefault();
                                $("#add-customer-address-form #"+indexInArray+"_error").html("");
                            })
                        });
                    }
                }
            },
            error:function(){},
            complete:function(){
                getCustomerAddress(customerid,'invoice-add-form');
                setTimeout(() => {
                    $("#ajax-address-response-message").html("");
                }, 1500);
            }
        })
    });
    //Store Customer Address functionality ends here

    //Store merchant api functionality starts here
    $("#generate-api").click(function(e){
        e.preventDefault();
        $.ajax({
            url:"/merchant/api/add",
            type:"GET",
            dataType:"json",
            success:function(response){
                if(response.length > 0)
                {   
                    getMerchantApi();
                    $.each(response[response.length-1],function(key,value){
                        $("#update-api-form input[name="+key+"]").val(value);
                    });
                }
            },
            error:function(){},
            complete:function(){
                getMerchantApi();
                $("#update-api-modal").modal({show:true,backdrop:'static', keyboard:false});
            }
        })
    });
    //Store merchant api functionality ends here

    //Store webhook functionality starts here
    $("#webhook-form").submit(function(e){
        e.preventDefault();
        var formdata = $("#webhook-form").serializeArray();
        $.ajax({
            url:"/merchant/webhook/add",
            type:"POST",
            data:getJsonObject(formdata),
            dataType:"json",
            success:function(response){
                if(response.status)
                {
                    $("#ajax-webhook-response").html(response.message).css({"color":"green"});
                }
            },
            error:function(){},
            complete:function(){
                getWebhookData();
                setTimeout(() => {
                    $("#ajax-webhook-response").html("")
                }, 1500);
            }
        })
    });
    //Store webhook functionality ends here


    //Store Reminders functionality starts here
    $("#expiry-form").submit(function(e){
        e.preventDefault();
        var formdata = {};
        formdata = $("#expiry-form").serializeJSON();
        $.ajax({
            url:"/merchant/reminder/add",
            type:"POST",
            data:formdata,
            dataType:"json",
            success:function(response){
               $("#expiry-form-ajax-success-message").html(response.message).css({"color":"green"});
            },
            error:function(){},
            complete:function(){
                getRemindersData();
                setTimeout(() => {
                    $("#expiry-form-ajax-success-message").html("");
                }, 1500);
            }
        });
        
    });
    //store Reminders functionality ends here

    //Store Support functionality starts here
    $("#support-form").submit(function(e){
        e.preventDefault();
        var formdata = $("#support-form")[0];
        var data = new FormData(formdata);
        $.ajax({
            url:"/merchant/support/add",
            type:"POST",
            data:data,
            processData:false,
            contentType:false,
            cache:false,
            dataType:"json",
            success:function(response){
                if(response.status)
                {
                    $("#ajax-support-response").html(response.message).css({"color":"green"});
                }else{
                    $.each(response.error,function(name,value){
                        $("#support-form #ajax-"+name+"-error").html(value).css({"color":"red"});
                        $("#support-form input[name="+name+"]").on("click",function(e){
                            $("#support-form #ajax-"+name+"-error").html("")
                        });
                        $("#support-form select").on("change",function(e){
                            $("#support-form #ajax_"+name+"_error").html("");
                        });
                    });
                }
            },
            error:function(){},
            complete:function(){
                getSupportData();
                formdata.reset();
                $("#choose_file").html("Choose a file");
                setTimeout(() => {
                    $("#ajax-support-response").html("");
                }, 1500);
            }
        })
    });

    //Store Support functionality ends here

    //Store Feedback functionality starts here
    $("#feedback-form").submit(function(e){
        e.preventDefault();
        var formdata = $("#feedback-form").serializeArray();
        $.ajax({
            url:"/merchant/feedback/add",
            type:"POST",
            data:getJsonObject(formdata),
            dataType:"json",
            success:function(response){
                if(response.status)
                {
                    $("#ajax-feedback-response").html(response.message).css({"color":"green"});
                }else{
                    $.each(response.error,function(name,value){
                        $("#feedback-form #ajax_"+name+"_error").html(value).css({"color":"red"});
                        $("#feedback-form select").on("change",function(e){
                            $("#feedback-form #ajax_"+name+"_error").html("");
                        });
                        $("#feedback-form input[name="+name+"]").on("click",function(e){
                            $("#feedback-form #ajax_"+name+"_error").html("")
                        });
                    });
                }
            },
            error:function(){},
            complete:function(){
                $("#feedback-form")[0].reset();
                setTimeout(() => {
                    $("#ajax-feedback-response").html("");
                }, 1500);
            }
        })
    });

    function giveRating(object){
        $("#feedback-form input[name='feed_rating']").val($(object).attr("data-value"));
    }

    //Store Feedback functionality ends here

    //Store Product functionality starts here
    $("#add-product-form").submit(function(e){
        e.preventDefault();
        var formdata = $("#add-product-form").serializeArray();

        $.ajax({
            url:"/merchant/product/add",
            type:"POST",
            data:getJsonObject(formdata),
            dataType:"json",
            success:function(response){
                if(response.status)
                {
                    $("#ajax-product-response").html(response.message).css({"color":"green"});
                }else{
                    if(Object.keys(response.errors).length > 0)
                    {
                        $.each(response.errors, function (indexInArray, valueOfElement) { 
                             $("#add-product-form #"+indexInArray+"_error").html(valueOfElement[0]).css({"color":"red"});
                             $("input[name="+indexInArray+"]").click(function(e){
                                e.preventDefault();
                                $("#add-product-form #"+indexInArray+"_error").html("");
                             });    
                        });
                    }
                }
            },
            error:function(){},
            complete:function(){
                getAllProducts();
                setTimeout(() => {
                    $("#ajax-product-response").html("");
                }, 1500);
            }
        });
    });
    //Store Products functionality ends here

    //Store Case comments functionality starts here
    //Customer Comment functionality Starts here
    $("#merchant-comment-form").submit(function(e){
        e.preventDefault();
        var formdata = $("#merchant-comment-form").serializeArray();
        $.ajax({
            url:"/merchant/comment/add",
            type:"POST",
            data:getJsonObject(formdata),
            dataType:"json",
            success:function(response){
                if(response.status)
                {
                    $("#ajax-comment-response").html(response.message).css({"color":"green"});
                }
            },
            error:function(){},
            complete:function(){
                $("#merchant-comment-form")[0].reset();
                getCommentDetails();
                setTimeout(() => {
                    $("#ajax-comment-response").html("");
                }, 1500);
            }
        });
    });
    //Store Case comments functionality ends here

    //Store Coupons functionality starts here
    $("#coupon-new-edit-form").submit(function(e){
        e.preventDefault();
        var formdata = $("#coupon-new-edit-form").serializeArray();
        var formsubmit = false;
        if($("#coupon_type").val() != "")
        {   
            if($("#coupon_type option:selected").text() == "Flat Discount")
            {
                if($("#coupon_discount").val() == "")
                {
                    $("#coupon_discount").focus();
                    $("#coupon_discount_form_validation").html("Required field").css({"color":"red"});

                    $("#coupon_discount").click(function(){
                        $("#coupon_discount_form_validation").html("")
                    });
                    return false;
                    
                }   
                if($("#coupon_on").val() != "")
                {

                    if($("#coupon_on option:selected").text() == "Entire Order")
                    {
                        if($("input[name='coupon_maxdisc_amount']").val() == "")
                        {
                            $("input[name='coupon_maxdisc_amount']").focus();
                            $("#coupon_maxdisc_amount_entire_form_validation").html("Required field").css({"color":"red"});
                            
                            $("input[name='coupon_maxdisc_amount']").click(function(){
                                $("#coupon_maxdisc_amount_entire_form_validation").html("");
                            });
                            return false;
                        }else if($("#coupon_validfrom").val() == ""){
                            $("#coupon_validfrom_form_validation").html("Required field").css({"color":"red"});

                            $("#coupon_validfrom").click(function(){
                                $("#coupon_validfrom_form_validation").html("");
                            });
                            return false;
                        }else if($("#coupon_validto").val() == "")
                        {
                            $("#coupon_validto_form_validation").html("Required field").css({"color":"red"});


                            $("#coupon_validto").click(function(){
                                $("#coupon_validto_form_validation").html("");
                            });
                            return false;
                        }else if($("#coupon_maxuse").val() == "")
                        {
                            $("#coupon_maxuse").focus();
                            $("#coupon_maxuse_form_validation").html("Required field").css({"color":"red"});

                            $("#coupon_maxuse").click(function(){
                                $("#coupon_maxuse_form_validation").html("");
                            });
                            return false;
                        }else if($("#coupon_usermaxuse").val() == "")
                        {
                            $("#coupon_usermaxuse").focus();
                            $("#coupon_usermaxuse_form_validation").html("Required field").css({"color":"red"});


                            $("#coupon_usermaxuse").click(function(){
                                $("#coupon_usermaxuse_form_validation").html("");
                            });
                            return false;
                        }else{
                            formsubmit = true;
                        }
                    }else if($("#coupon_on option:selected").text() == "Orders Over") 
                    {

                        if($("#coupon_ordermax_amount").val() == "")
                        {
                            $("#coupon_ordermax_amount").focus();
                            $("#coupon_ordermax_amount_form_validation").html("Required field").css({"color":"red"});
    
                            $("#coupon_ordermax_amount").click(function(){
                                $("#coupon_ordermax_amount_form_validation").html("");
                            });
    
                            return false;
                        }else if($("input[name='coupon_maxdisc_amount']").val() == "")
                        {
                            $("input[name='coupon_maxdisc_amount']").focus();
                            $("#coupon_maxdisc_amount_order_form_validation").html("Required field").css({"color":"red"});
                            
                            $("input[name='coupon_maxdisc_amount']").click(function(){
                                $("#coupon_maxdisc_amount_order_form_validation").html("");
                            });
                            return false;
                        }else if($("#coupon_validfrom").val() == ""){
                            $("#coupon_validfrom_form_validation").html("Required field").css({"color":"red"});
    
                            $("#coupon_validfrom").click(function(){
                                $("#coupon_validfrom_form_validation").html("");
                            });
                            return false;
                        }else if($("#coupon_validto").val() == "")
                        {
                            $("#coupon_validto_form_validation").html("Required field").css({"color":"red"});
    
    
                            $("#coupon_validto").click(function(){
                                $("#coupon_validto_form_validation").html("");
                            });
                            return false;
                        }else if($("#coupon_maxuse").val() == "")
                        {
                            $("#coupon_maxuse").focus();
                            $("#coupon_maxuse_form_validation").html("Required field").css({"color":"red"});
    
                            $("#coupon_maxuse").click(function(){
                                $("#coupon_maxuse_form_validation").html("");
                            });
                            return false;
                        }else if($("#coupon_usermaxuse").val() == "")
                        {
                            $("#coupon_usermaxuse").focus();
                            $("#coupon_usermaxuse_form_validation").html("Required field").css({"color":"red"});
    
    
                            $("#coupon_usermaxuse").click(function(){
                                $("#coupon_usermaxuse_form_validation").html("");
                            });
                            return false;
                        }else{
                            formsubmit = true;
                        }
                    }else if($("#coupon_on option:selected").text() == "Specific Product") 
                    {
                        if($("#coupon_onproduct").val() =="")
                        {
                            $("#coupon_onproduct").focus();
                            $("#coupon_onproduct_form_validation").html("Required field").css({"color":"red"});
    
    
                            $("#coupon_onproduct").click(function(){
                                $("#coupon_onproduct_form_validation").html("");
                            });
                            return false;
                        }else if($("input[name='coupon_maxdisc_amount']").val() == ""){
                            $("input[name='coupon_maxdisc_amount']").focus();
                            $("#coupon_maxdisc_amount_product_form_validation").html("Required field").css({"color":"red"});
    
    
                            $("#input[name='coupon_maxdisc_amount']").click(function(){
                                $("#coupon_maxdisc_amount_product_form_validation").html("");
                            });
                            return false;
                        }else{
                            formsubmit = true;
                        }
                    }
                }else{
                    $("#coupon_on").focus()
                    $("#coupon_on_form_validation").html("Required field").css({"color":"red"});
                    $("#coupon_on").click(function(e){
                        $("#coupon_on_form_validation").html("");
                    }); 
                }
                

            }else if($("#coupon_type option:selected").text() == "Percentage Discount")
            {
                if($("#coupon_discount").val() == "")
                {
                    $("#coupon_discount").focus();
                    $("#coupon_discount_form_validation").html("Required field").css({"color":"red"});

                    $("#coupon_discount").click(function(){
                        $("#coupon_discount_form_validation").html("")
                    });
                    return false;
                    
                }
                if($("#coupon_on").val() != "")
                {
                    if($("#coupon_on option:selected").text() == "Entire Order")
                    {
                        if($("input[name='coupon_maxdisc_amount']")[2].value == "")
                        {
                            $("input[name='coupon_maxdisc_amount']").focus();
                            $("#coupon_maxdisc_amount_entire_form_validation").html("Required field").css({"color":"red"});
                            
                            $("input[name='coupon_maxdisc_amount']").click(function(){
                                $("#coupon_maxdisc_amount_entire_form_validation").html("");
                            });
                            return false;
                        }else if($("#coupon_validfrom").val() == ""){
                            $("#coupon_validfrom_form_validation").html("Required field").css({"color":"red"});

                            $("#coupon_validfrom").click(function(){
                                $("#coupon_validfrom_form_validation").html("");
                            });
                            return false;
                        }else if($("#coupon_validto").val() == "")
                        {
                            $("#coupon_validto_form_validation").html("Required field").css({"color":"red"});


                            $("#coupon_validto").click(function(){
                                $("#coupon_validto_form_validation").html("");
                            });
                            return false;
                        }else if($("#coupon_maxuse").val() == "")
                        {
                            $("#coupon_maxuse").focus();
                            $("#coupon_maxuse_form_validation").html("Required field").css({"color":"red"});

                            $("#coupon_maxuse").click(function(){
                                $("#coupon_maxuse_form_validation").html("");
                            });
                            return false;
                        }else if($("#coupon_usermaxuse").val() == "")
                        {
                            $("#coupon_usermaxuse").focus();
                            $("#coupon_usermaxuse_form_validation").html("Required field").css({"color":"red"});


                            $("#coupon_usermaxuse").click(function(){
                                $("#coupon_usermaxuse_form_validation").html("");
                            });
                            return false;
                        }else{
                            formsubmit = true;
                        }
                    }else if($("#coupon_on option:selected").text() == "Orders Over") 
                    {

                        if($("#coupon_ordermax_amount").val() == "")
                        {
                            $("#coupon_ordermax_amount").focus();
                            $("#coupon_ordermax_amount_form_validation").html("Required field").css({"color":"red"});
    
                            $("#coupon_ordermax_amount").click(function(){
                                $("#coupon_ordermax_amount_form_validation").html("");
                            });
    
                            return false;
                        }else if($("input[name='coupon_maxdisc_amount']")[1].value == "")
                        {
                            $("input[name='coupon_maxdisc_amount']").focus();
                            $("#coupon_maxdisc_amount_order_form_validation").html("Required field").css({"color":"red"});
                            
                            $("input[name='coupon_maxdisc_amount']").click(function(){
                                $("#coupon_maxdisc_amount_order_form_validation").html("");
                            });
                            return false;
                        }else if($("#coupon_validfrom").val() == ""){
                            $("#coupon_validfrom_form_validation").html("Required field").css({"color":"red"});
    
                            $("#coupon_validfrom").click(function(){
                                $("#coupon_validfrom_form_validation").html("");
                            });
                            return false;
                        }else if($("#coupon_validto").val() == "")
                        {
                            $("#coupon_validto_form_validation").html("Required field").css({"color":"red"});
    
    
                            $("#coupon_validto").click(function(){
                                $("#coupon_validto_form_validation").html("");
                            });
                            return false;
                        }else if($("#coupon_maxuse").val() == "")
                        {
                            $("#coupon_maxuse").focus();
                            $("#coupon_maxuse_form_validation").html("Required field").css({"color":"red"});
    
                            $("#coupon_maxuse").click(function(){
                                $("#coupon_maxuse_form_validation").html("");
                            });
                            return false;
                        }else if($("#coupon_usermaxuse").val() == "")
                        {
                            $("#coupon_usermaxuse").focus();
                            $("#coupon_usermaxuse_form_validation").html("Required field").css({"color":"red"});
    
    
                            $("#coupon_usermaxuse").click(function(){
                                $("#coupon_usermaxuse_form_validation").html("");
                            });
                            return false;
                        }else{
                            formsubmit = true;
                        }
                    }else if($("#coupon_on option:selected").text() == "Specific Product") 
                    {
                        if($("#coupon_onproduct").val() =="")
                        {
                            $("#coupon_onproduct").focus();
                            $("#coupon_onproduct_form_validation").html("Required field").css({"color":"red"});
    
    
                            $("#coupon_onproduct").click(function(){
                                $("#coupon_onproduct_form_validation").html("");
                            });
                            return false;
                        }else if($("input[name='coupon_maxdisc_amount']")[0].value == ""){
                            $("input[name='coupon_maxdisc_amount']")[0].focus();
                            $("#coupon_maxdisc_amount_product_form_validation").html("Required field").css({"color":"red"});
    
    
                            $("#input[name='coupon_maxdisc_amount']").click(function(){
                                $("#coupon_maxdisc_amount_product_form_validation").html("");
                            });
                            return false;
                        }else{
                            formsubmit = true;
                        }
                    }
                }else{
                    $("#coupon_on").focus()
                    $("#coupon_on_form_validation").html("Required field").css({"color":"red"});
                    $("#coupon_on").click(function(e){
                        $("#coupon_on_form_validation").html("");
                    }); 
                }
            
            }else if($("#coupon_type option:selected").text() == "Free Shipping"){
                if($("#coupon_on").val() != "")
                {
                    if($("#coupon_on option:selected").text() == "Entire Order")
                    {
                        if($("input[name='coupon_maxdisc_amount']")[2].value == "")
                        {
                            $("input[name='coupon_maxdisc_amount']").focus();
                            $("#coupon_maxdisc_amount_entire_form_validation").html("Required field").css({"color":"red"});
                            
                            $("input[name='coupon_maxdisc_amount']").click(function(){
                                $("#coupon_maxdisc_amount_entire_form_validation").html("");
                            });
                            return false;
                        }else if($("#coupon_validfrom").val() == ""){
                            $("#coupon_validfrom_form_validation").html("Required field").css({"color":"red"});

                            $("#coupon_validfrom").click(function(){
                                $("#coupon_validfrom_form_validation").html("");
                            });
                            return false;
                        }else if($("#coupon_validto").val() == "")
                        {
                            $("#coupon_validto_form_validation").html("Required field").css({"color":"red"});


                            $("#coupon_validto").click(function(){
                                $("#coupon_validto_form_validation").html("");
                            });
                            return false;
                        }else if($("#coupon_maxuse").val() == "")
                        {
                            $("#coupon_maxuse").focus();
                            $("#coupon_maxuse_form_validation").html("Required field").css({"color":"red"});

                            $("#coupon_maxuse").click(function(){
                                $("#coupon_maxuse_form_validation").html("");
                            });
                            return false;
                        }else if($("#coupon_usermaxuse").val() == "")
                        {
                            $("#coupon_usermaxuse").focus();
                            $("#coupon_usermaxuse_form_validation").html("Required field").css({"color":"red"});


                            $("#coupon_usermaxuse").click(function(){
                                $("#coupon_usermaxuse_form_validation").html("");
                            });
                            return false;
                        }else{
                            formsubmit = true;
                        }
                    }else if($("#coupon_on option:selected").text() == "Orders Over") 
                    {

                        if($("#coupon_ordermax_amount").val() == "")
                        {
                            $("#coupon_ordermax_amount").focus();
                            $("#coupon_ordermax_amount_form_validation").html("Required field").css({"color":"red"});
    
                            $("#coupon_ordermax_amount").click(function(){
                                $("#coupon_ordermax_amount_form_validation").html("");
                            });
    
                            return false;
                        }else if($("input[name='coupon_maxdisc_amount']")[1].value == "")
                        {
                            $("input[name='coupon_maxdisc_amount']").focus();
                            $("#coupon_maxdisc_amount_order_form_validation").html("Required field").css({"color":"red"});
                            
                            $("input[name='coupon_maxdisc_amount']").click(function(){
                                $("#coupon_maxdisc_amount_order_form_validation").html("");
                            });
                            return false;
                        }else if($("#coupon_validfrom").val() == ""){
                            $("#coupon_validfrom_form_validation").html("Required field").css({"color":"red"});
    
                            $("#coupon_validfrom").click(function(){
                                $("#coupon_validfrom_form_validation").html("");
                            });
                            return false;
                        }else if($("#coupon_validto").val() == "")
                        {
                            $("#coupon_validto_form_validation").html("Required field").css({"color":"red"});
    
    
                            $("#coupon_validto").click(function(){
                                $("#coupon_validto_form_validation").html("");
                            });
                            return false;
                        }else if($("#coupon_maxuse").val() == "")
                        {
                            $("#coupon_maxuse").focus();
                            $("#coupon_maxuse_form_validation").html("Required field").css({"color":"red"});
    
                            $("#coupon_maxuse").click(function(){
                                $("#coupon_maxuse_form_validation").html("");
                            });
                            return false;
                        }else if($("#coupon_usermaxuse").val() == "")
                        {
                            $("#coupon_usermaxuse").focus();
                            $("#coupon_usermaxuse_form_validation").html("Required field").css({"color":"red"});
    
    
                            $("#coupon_usermaxuse").click(function(){
                                $("#coupon_usermaxuse_form_validation").html("");
                            });
                            return false;
                        }else{
                            formsubmit = true;
                        }
                    } 
                }else{
                    $("#coupon_on").focus()
                    $("#coupon_on_form_validation").html("Required field").css({"color":"red"});
                    $("#coupon_on").click(function(e){
                        $("#coupon_on_form_validation").html("");
                    }); 
                }
            }
        }else{
            $("#coupon_type").focus();
            $("#coupon_type_form_validation").html("Required field").css({"color":"red"});
            $("#coupon_type").click(function(e){
                $("#coupon_type_form_validation").html("");
            });
            return false;
        }
        if(formsubmit)
        {
            var max_disc_amount = ""
            $("input[name='coupon_maxdisc_amount']").each(function(index,element){
                if(element.value!="")
                {
                    max_disc_amount = element.value
                }
            });
            
            $.each(formdata,function(index,object){
                if(object.name == "coupon_maxdisc_amount")
                {
                    object.value = max_disc_amount;
                }
            });
            $.ajax({
                url:"/merchant/coupon/add",
                type:"POST",
                data:getJsonObject(formdata),
                dataType:"json",
                success:function(response){
                    if(response.status)
                    {
                        $("#ajax-respnse-message").html(response.message).css({"color":"green"});
                    }else{

                        $("#ajax-respnse-message").html(response.message).css({"color":"red"});
                    }
                    if($("#coupon-new-edit-form input[name='id']").length == 0)
                    {
                        $("#coupon-new-edit-form")[0].reset();
                    }
                },
                error:function(){},
                complete:function(){
                    
                    setTimeout(() => {
                        $("#ajax-respnse-message").html("");
                    }, 1500);
                }
            })
        }

    });
    //Store Coupons functionality ends here


    //Store Merchant Employee code starts here

    $("#merchant-employee-form").submit(function(e){
        e.preventDefault();
        var formdata = $(this).serializeArray();
        $.ajax({
            type:"POST",
            url:"/merchant/employee/add",
            data:getJsonObject(formdata),
            dataType:"json",
            success: function (response) {
                if(response.status){
                    $("#ajax-add-success-message").html(response.message);
                    $("#merchant-employee-form")[0].reset();
                }else{
                    if(typeof(response.errors) != "undefined" && Object.keys(response.errors).length > 0){
                        $.each(response.errors,function(element,message){
                            $("#"+element+"_error").html(message[0]).css({"color":"red"});
                            $("#merchant-employee-form select[name="+element+"]").click(function(e){
                                e.preventDefault();
                                $("#"+element+"_error").html("");
                            });
                            $("#merchant-employee-form input[name="+element+"]").click(function(e){
                                e.preventDefault();
                                $("#"+element+"_error").html("");
                            });
                        });
                    }else{
                        $("#ajax-add-fail-message").html(response.message);
                    }
                }
            },complete:function(){
                setTimeout(() => {
                    $("#ajax-add-success-message").html("");
                    $("#ajax-add-fail-message").html("");
                }, 3000);
            }
        });
    });


    //Store Merchant Employee code ends here



    //Update Company Info Details functionality starts here
    $("#company-info-form").submit(function(e){
        e.preventDefault();
        var formdata = $("#company-info-form").serializeArray();
        $.ajax({
            type:"POST",
            url:"/merchant/company-info/update",
            data:getJsonObject(formdata),
            dataType:"json",
            success: function (response) {
                if(response.status)
                {
                    $("#ajax-company-info-response-message").html(response.message).css({"color":"green"});
                }else{
                    if(Object.keys(response.errors).length > 0)
                    {
                        $.each(response.errors,function (indexInArray, valueOfElement) { 
                             $("#company-info-form #"+indexInArray+"_error").html(valueOfElement["0"])
                             .css({"color":"red"});
                            $("#company-info-form select[name="+indexInArray+"]").click(function(e){
                                e.preventDefault();
                                $("#company-info-form #"+indexInArray+"_error").html("");
                              });
                            $("#company-info-form input[name="+indexInArray+"]").click(function(e){
                                e.preventDefault();
                                $("#company-info-form #"+indexInArray+"_error").html("");
                            });
                        });
                    }
                }
            },complete:function(){
                setTimeout(() => {
                    $("#ajax-company-info-response-message").html("");  
                }, 3000);
            }
        });
    });

    function updateCompnayInfo(formdata){
        var functionStatus = true;
        if(Object.keys(formdata).length > 0){
            $.ajax({
                type:"POST",
                url:"/merchant/company-info/update",
                data:getJsonObject(formdata),
                async:false,
                dataType:"json",
                success: function (response) {
                    if(response.status)
                    {
                        $("#ajax-company-info-response-message").html(response.message).css({"color":"green"});
                        //gePopuptForm("company");
                        
                    }else{
                        if(Object.keys(response.errors).length > 0)
                        {
                            $.each(response.errors,function (indexInArray, valueOfElement) { 
                                 $("#activate-account #"+indexInArray+"_error").html(valueOfElement["0"])
                                 .css({"color":"red"});
                                $("#activate-account select[name="+indexInArray+"]").click(function(e){
                                    e.preventDefault();
                                    $("#activate-account #"+indexInArray+"_error").html("");
                                  });
                                $("#activate-account input[name="+indexInArray+"]").click(function(e){
                                    e.preventDefault();
                                    $("#activate-account #"+indexInArray+"_error").html("");
                                });
                            });
                        }
                        functionStatus = response.status;
                        
                    }
                }
            });
        }
        return functionStatus;
    }
    //Update Company Info Details functionality ends here

    //Store Coupons functionality ends here

    //Store Business Details Info functionality starts here
    $("#business-info-form").submit(function(e){
        e.preventDefault();
        var formdata = $("#business-info-form").serializeArray();
        $.ajax({
            type:"POST",
            url:"/merchant/business-info/update",
            data:getJsonObject(formdata),
            dataType:"json",
            success: function (response) {
                if(response.status)
                {
                    $("#ajax-business-info-response-message").html(response.message).css({"color":"green"});
                    gePopuptForm("business-card");
                }else{
                    if(Object.keys(response.errors).length > 0)
                    {
                        $.each(response.errors,function (indexInArray, valueOfElement) { 
                             $("#business-info-form #"+indexInArray+"_error").html(valueOfElement["0"])
                             .css({"color":"red"});
                            $("select[name="+indexInArray+"]").click(function (e){
                                e.preventDefault();
                                $("#business-info-form #"+indexInArray+"_error").html("");
                            });
                            $("input[name="+indexInArray+"]").click(function (e){
                                e.preventDefault();
                                $("#business-info-form #"+indexInArray+"_error").html("");
                            });
                        });
                    }
                }
            },complete:function(){
                setTimeout(() => {
                    $("#ajax-business-info-response-message").html("");  
                }, 3000);
            }
        });
    });

    function businessForm(formdata){
        var functionStatus = true;
        if(Object.keys(formdata).length > 0){
            $.ajax({
                type:"POST",
                url:"/merchant/business-info/update",
                data:getJsonObject(formdata),
                dataType:"json",
                async:false,
                success: function (response) {
                    if(response.status)
                    {
                        $("#ajax-business-info-response-message").html(response.message).css({"color":"green"});
                        gePopuptForm("business-info");
                    }else{
                        if(Object.keys(response.errors).length > 0)
                        {
                            $.each(response.errors,function (indexInArray, valueOfElement) { 
                                 $("#activate-account #"+indexInArray+"_error").html(valueOfElement["0"])
                                 .css({"color":"red"});
                                $("select[name="+indexInArray+"]").click(function (e){
                                    e.preventDefault();
                                    $("#activate-account #"+indexInArray+"_error").html("");
                                });
                                $("input[name="+indexInArray+"]").click(function (e){
                                    e.preventDefault();
                                    $("#activate-account #"+indexInArray+"_error").html("");
                                });
                            });
                            functionStatus = response.status;
                        }
                        
                    }
                    
                },complete:function(){
                    setTimeout(() => {
                        $("#ajax-business-info-response-message").html("");  
                    }, 3000);
                }
            });
        }

        return functionStatus;
    }

    //Store Business Details Info functionality ends here

    //Store Business Details Info functionality starts here
    $("#business-detail-info-form").submit(function(e){
        e.preventDefault();
        var formdata = $("#business-detail-info-form").serializeArray();
        var regex = /([A-Z]){5}([0-9]){4}([A-Z]){1}$/;

        var companyPAN = $("#business-detail-info-form #comp_pan_number").val();
        var companyGST = $("#business-detail-info-form #comp_gst").val();
        if(companyPAN != companyGST.substr(2,10))
        {
            $("#ajax-business-detail-info-response-message").html("Company Pan & Company GST both are not valid").css({"color":"red"});
            setTimeout(() => {
                $("#ajax-business-detail-info-response-message").html("");  
            },3000);
            return false;
        }

        if(ValidatePAN('mer_pan_number','merpanerror') && ValidateCompanyPAN('comp_pan_number','comppanerror'))
        {   
            $.ajax({
                type:"POST",
                url:"/merchant/business-details-info/save",
                data:getJsonObject(formdata),
                dataType:"json",
                success: function (response) {
                    if(response.status)
                    {
                        $("#ajax-business-detail-info-response-message").html(response.message).css({"color":"green"});
                    }else{
                        if(Object.keys(response.errors).length > 0)
                        {
                            $.each(response.errors,function (indexInArray, valueOfElement) { 
                                 $("#business-detail-info-form #"+indexInArray+"_error").html(valueOfElement["0"])
                                 .css({"color":"red"});
                                $("input[name="+indexInArray+"]").click(function (e){
                                    e.preventDefault();
                                    $("#business-detail-info-form #"+indexInArray+"_error").html("");
                                  });
                            });
                        }
                    }
                },complete:function(){
                    setTimeout(() => {
                        $("#ajax-business-detail-info-response-message").html("");  
                    }, 3000);
                }
            });
        }
        
    });
    function businessDetailForm(formdata){
        var functionStatus = true;
        if(Object.keys(formdata).length > 0){
            var regex = /([A-Z]){5}([0-9]){4}([A-Z]){1}$/;
            var companyPAN = $("#activate-account #comp_pan_number").val();
            var companyGST = $("#activate-account #comp_gst").val();

            if(!$("#activate-account #comp_gst").hasClass("not-mandatory"))
            {
                if(companyPAN != companyGST.substr(2,10))
                {
                    $("#ajax-business-detail-info-response-message").html("Company Pan & Company GST both are not valid").css({"color":"red"});
                    setTimeout(() => {
                        $("#ajax-business-detail-info-response-message").html("");  
                    },3000);
                    functionStatus = false;
                }

                var stateGSTCode = $("#gst_state").val();
                var givenGSTStateCode = $("#activate-account #comp_gst").val().substr(0,2);
                if(stateGSTCode!=givenGSTStateCode)
                {
                    $("#comp_gst").focus();
                    $("#comp_gst_error").html("Selected state in company info and given GST is not matching").css({"color":"red"});
                    $("#comp_gst").click(function(e){
                        $("#comp_gst_error").html("");
                    });
                    functionStatus = false;
                }
            }
            

            if(functionStatus && ValidatePAN('mer_pan_number','merpanerror') && ValidateCompanyPAN('comp_pan_number','comppanerror'))
            {
                $.ajax({
                    type:"POST",
                    url:"/merchant/business-details-info/save",
                    data:getJsonObject(formdata),
                    async:false,
                    dataType:"json",
                    success: function (response) {
                        if(response.status)
                        {
                            //$("#ajax-business-detail-info-response-message").html(response.message).css({"color":"green"});
                        }else{
                            if(Object.keys(response.errors).length > 0)
                            {
                                $.each(response.errors,function (indexInArray, valueOfElement) { 
                                    $("#activate-account #"+indexInArray+"_error").html(valueOfElement["0"])
                                    .css({"color":"red"});
                                    $("input[name="+indexInArray+"]").click(function (e){
                                        e.preventDefault();
                                        $("#activate-account #"+indexInArray+"_error").html("");
                                    });
                                });
                            }
                            functionStatus = response.status;
                        }
                    },complete:function(){
                        setTimeout(() => {
                            $("#ajax-business-detail-info-response-message").html("");  
                        }, 3000);
                    }
                });
            }else{
                functionStatus = false;
            }
        }
        return functionStatus;
    }
    //Store Business Details Info functionality ends here

//Store data ends

//Edit data starts

    //Edit Transaction javascript functionality starts
    function transactionDetails(trans_id)
    {

        $.ajax({
            url:"/merchant/payment/get/"+trans_id,
            type:"GET",
            dataType:"json",
            success:function(response){
                if(response.length > 0)
                {
                    $.each(response[response.length-1],function(index,object){
                        $("#edit-transaction-form #"+index+"_label").html(object);
                    });
                    $("#transaction-details-modal").modal({show:true,keyboard:false,backdrop:'static'});
                }
            },
            error:function(){},
            complete:function(){}
        })
       
    }

    function transactionDetailsView(trans_id)
    {
        $("#detailTitle").html(''); 
         $("#detailTitle").html('Transaction Details'); 
        $.ajax({
            url:"/merchant/transactionInfo?transactionID="+trans_id,
            type:"GET",
            // dataType:"json",
            success:function(response){
                console.log(response);
                $("#detail-transaction-model").modal({show:true,keyboard:false,backdrop:'static'});
                $('#transaction_details_view').html(null);
                $('#transaction_details_view').html(response.tran_details_view);
                
            },
            error:function(){},
            complete:function(){}
        })
       
    }

     function transactionRefund(trans_id)
    {
         $("#detailTitle").html(''); 
         $("#detailTitle").html('Initiate Refund');     
        $.ajax({
            url:"/merchant/transactionRefundInit?transactionID="+trans_id,
            type:"GET",
            // dataType:"json",
            success:function(response){
                console.log(response);
                $("#refund-transaction-model").modal({show:true,keyboard:false,backdrop:'static'});
                $('#transaction_refund_view').html(null);
                $('#transaction_refund_view').html(response.tran_details_view);
                
            },
            error:function(){},
            complete:function(){}
        })
       
       
    }

    function payouttransactionDetailsView(trans_id)
    {

        $.ajax({
            url:"/merchant/payout_transaction_info?transferId="+trans_id,
            type:"GET",
            // dataType:"json",
            success:function(response){
                console.log(response);
                $("#detail-transaction-model").modal({show:true,keyboard:false,backdrop:'static'});
                $('#transaction_details_view').html(null);
                $('#transaction_details_view').html(response.tran_details_view);
                
            },
            error:function(){},
            complete:function(){}
        })
       
    }
    //Edit Transaction javascript functionality ends 

    //Edit Order javascript functionality starts
    function orderDetails(order_id)
    {

        $.ajax({
            url:"/merchant/order/get/"+order_id,
            type:"GET",
            dataType:"json",
            success:function(response){
                if(response.length > 0)
                {
                    $.each(response[response.length-1],function(index,object){
                        $("#edit-order-form #"+index+"_label").html(object);
                    });
                    $("#order-details-modal").modal({show:true,keyboard:false,backdrop:'static'});
                }
            },
            error:function(){},
            complete:function(){}
        })
       
    }
    //Edit Order javascript functionality ends 

    //Edit paylink javascript functionality starts
    function editPaylink(paylinkid){
        
        $("#paylink-response-message").html("");
        //$("#add-paylink-li").show();
        //$("#add-bulk-paylink-li").hide();
        var formdata = $("#paylink-edit").serializeArray();
        $.each(formdata,function(index,element){
            $("#"+element.name+"_error").html("");
        });

        $("#paylink-edit input[type='checkbox']").each(function(index,element){
            if(element.name=="email_paylink" && $(element).prop('checked') && $("#paylink-edit #paylink_customer_email").val()==""){
                $("#paylink-edit #paylink_customer_email").focus();
                $("#paylink-edit #paylink_customer_email_error").html("Email is empty");
                $("#paylink-edit #paylink_customer_email").click(function(e){
                    e.preventDefault();
                    $("#paylink-edit #paylink_customer_email_error").html("");
                });
                return false;
            }else if(element.name=="mobile_paylink" && $(element).prop('checked') && $("#paylink-edit #paylink_customer_mobile").val()==""){
                $("#paylink-edit #paylink_customer_mobile").focus();
                $("#paylink-edit #paylink_customer_mobile_error").html("Mobile is empty");
                $("#paylink-edit #paylink_customer_mobile").click(function(e){
                    e.preventDefault();
                    $("#paylink-edit #paylink_customer_mobile_error").html("");
                });
                return false;
            }
        });
        $("#paylink-edit")[0].reset();
        $.ajax({
            url:"/merchant/paylink/edit/"+paylinkid,
            type:"GET",
            dataType:"json",
            success:function(response){
                if(response.length>0)
                {
                    $.each(response[response.length-1],function(index,value){
                        if($("#paylink-edit input[name='"+index+"']").attr("type") == "checkbox")
                        {
                            $("#paylink-edit input[name='"+index+"']").prop("checked",false);
                            if(value == "Y")
                            {
                                $("#paylink-edit input[name='"+index+"']").prop("checked",true);
                            }
                        }
                        if($("#paylink-edit textarea[name='"+index+"']"))
                        {
                            $("#paylink-edit textarea[name='"+index+"']").val(value);
                        }
                        if(value!="")
                        {
                            $("#paylink-edit input[name='"+index+"']").val(value);
                        }
                    });

                    $('#call-edit-paylink-model').modal('show');
                }
            },
            error:function(error){
            }
        });

    }
    //Edit paylink javascript functionality ends

    //Edit item javascript functionality starts
    function editItem(itemid)
    {
       $.ajax({
        url:"/merchant/item/edit/"+itemid,
        type:"GET",
        dataType:"json",
        success:function(response){
            if(response.length > 0)
            {
                $.each(response[response.length-1],function(key,value){
                    
                    if($("#item-update-form textarea[name='"+key+"']"))
                    {
                        $("#item-update-form textarea[name='"+key+"']").val(value);
                    }
                    $("#item-update-form input[name='"+key+"']").val(value);
                });
                $("#edit-item-model").modal("show");
            }
        },
        error:function(){

        }
       });
       
    }
    //Edit item javascript functionlaity ends

    //Edit Invoice javscript functionality starts
    function editInvoice(invoiceid)
    {
        var billingto=false;
        var invoiceEditObject = {};
        var invoiceItemEditObject = {};

        if($("#customer_gstno").val()!=""){
            var stategstcode = "";
            //stategstcode = $("#customer_gst_code").val();
            if(stategstcode != $("#customer_gstno").val().substr(0,2))
            {
                $("#customer_gstno").focus();
                $("#customer_gstno_error").html("Selected state and given GST is not matching").css({"color":"red"});
                $("#customer_gstno").click(function(e){
                    $("#customer_gstno_error").html("");
                });
                return false;
            }
        }

        $.ajax({
            url:"/merchant/invoice/edit/"+invoiceid,
            type:"GET",
            dataType:"json",
            success:function(response){
                if(response.invoice.length>0)
                {   
                    $.each(response.invoice,function(index,object){
                        $.each(object,function(name,value){
                            invoiceEditObject[name] = value;
                            if(name == "invoice_billing_to")
                            {
                                loadCustomerAddress(value,invoiceEditObject)
                            }  
                        });
                    });
                }
                if(response.items.length>0)
                {       
                        var new_invoice_item_row="";
                        $.each(response.items,function(index,object){
                            ++index;
                            invoiceItemEditObject["item_name"+index] = object.item_id;
                            new_invoice_item_row+= 
                            `<tr id='invoice_item_row`+index+`'>
                                <td>
                                    <div class="col-sm-10">
                                        <select name="item_name[]" id="item_name`+index+`" class="form-control" onchange=itemCalculate(this); data-name-id="`+index+`">
                                        `+invoiceItemOptions.join(" ")+`
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control input-sm only-btborder" name="item_amount[]"  id="item_amount`+index+`" data-amount-id="`+index+`" value="`+object.item_amount+`" placeholder="Item Price" readonly/>
                                    </div>
                                </td>
                                <td>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control input-sm only-btborder" name="item_quantity[]"  id="item_quantity`+index+`" data-quantity-id="`+index+`" value="`+object.item_quantity+`" placeholder="Item Qty"/>
                                    </div>
                                </td>
                                <td>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control input-sm only-btborder" name="item_total[]"  id="item_total`+index+`" data-total-id="`+index+`" value="`+object.item_total+`" placeholder="Item Total" readonly/>
                                    </div>
                                </td>
                                <td>
                                    <div class="col-sm-10">
                                        <i class="fa fa-times show-cursor mandatory" onclick="removeInvoiceItem(this,'`+index+`');"></i>
                                    </div>
                                </td>
                            </tr>`;
                                        
                        });
                        $("#dynamic-item-list").html(new_invoice_item_row);
                }
                if(Object.keys(invoiceItemEditObject).length > 0)
                {
                    $.each(invoiceItemEditObject,function(id,value){
                        $("#"+id).val(value)
                    });
                }
            },
            error:function(){},
            complete:function(){
                $("input[name='invoice_id']").val(invoiceid);
            }
        });
  
    }
    //Edit Invoice javascript functionality ends

    //Edit customer javascript functionality starts
    function editCustomer(customerid)
    {
        $("#edit-customer-modal #edit-response-message").html("");
        if(customerid!="")
        {
            $.ajax({
                url:"/merchant/customer/edit/"+customerid,
                type:"GET",
                dataType:"json",
                success:function(response){
                    if(response.length > 0)
                    {
                        $.each(response,function(index,object){
                            $.each(object,function(key,value){
                                $("#edit-customer-form input[name="+key+"]").val(value);
                            });
                        });
                    }
                },
                error:function(){},
                complete:function(){
                    $("#edit-customer-modal").modal("show");
                }
            });
        }
    }
    //Edit customer javascript functionality ends

    //Edit Api javascript functionality code starts here
    function generateApi(apiid)
    {
        if(apiid!="")
        {
            $.ajax({
                url:"/merchant/api/edit/"+apiid,
                type:"GET",
                dataType:"json",
                success:function(response){
                    if(response.length > 0)
                    {   
                        getMerchantApi();
                        $.each(response[response.length-1],function(key,value){
                            $("#update-api-form input[name="+key+"]").val(value);
                        });
                    }
                },
                complete:function(){
                    $("#update-api-modal").modal({show:true,backdrop:'static',keyboard:false});
                }
            })
        }
    }
    //Edit Api javascript functionality code ends here
     //send activation request by  merchnat
     function sendActivationRequest(merchant_id,request_for)
    {
        console.log('merchant_id='+merchant_id+',request_for='+request_for);

    }
   //send activation request by  merchnat end 
    //Edit Product Key functionality code starts here
    function editProduct(id)
    {
        if(id!="")
        {
            $.ajax({
                url:"/merchant/product/edit/"+id,
                type:"GET",
                dataType:"json",
                success:function(response){
                    if(response.length > 0)
                    {   
                        $.each(response[response.length-1],function(name,value){

                            if($("#update-product-form textarea[name="+name+"]").length > 0)
                            {
                                $("#update-product-form textarea[name="+name+"]").val(value);
                            }
                            $("#update-product-form input[name="+name+"]").val(value);

                        });
                    }
                },
                complete:function(){
                    $("#update-product-modal").modal({show:true,backdrop:'static',keyboard:false});
                }
            })
        }

    }
    //Edit Product Key functionality code ends here

    //Show Customer Case Details code starts here
    function showCustomerDetails(id){
        if(id!="")
        {
            $.ajax({
                url:"/merchant/case-status/merchant/"+id,
                type:"GET",
                dataType:"json",
                success:function(response){
                    if(response.length > 0)
                    {   
                        $.each(response[response.length-1],function(name,value){

                            if($("#display-case-details textarea[name="+name+"]").length > 0)
                            {
                                $("#display-case-details textarea[name="+name+"]").val(value);
                            }
                            $("#display-case-details input[name="+name+"]").val(value);

                            $("#display-case-details select[name="+name+"]").val(value);

                        });
                    }
                },
                complete:function(){
                    $("#customer-case-modal").modal({show:true,backdrop:'static',keyboard:false});
                }
            })
        }
    }
    //Show Customer Case Details code ends here

    //Edit Merchant Document File code starts here
    $("body").on("click",".button124",function(e){
        e.preventDefault();
        var column = $(this).data("name");
        var id = $(this).data("id");
        $.ajax({
            type:"GET",
            url:"/merchant/document-submission/remove/"+column+"/"+id,
            dataType:"json",
            async:false,
            success: function (response) {
             if(response.status)
             {
                 getMerchantDocumentForm();
             }
            }
        });
    });
    //Edit Merchant Document File code ends here
//Edit data ends

//Update data starts

    //Update Paylink functionality starts here
    $("#paylink-edit").submit(function(event){
        event.preventDefault();
        var formdata = $("#paylink-edit").serializeArray();
        var paylinkAmount = $("#paylink-edit #paylink_amount").val();
        var formvalidate = true;
        
        // var regnumber_rule = /^[0-9\.]+/g;
        var regnumber_rule = /^[1-9][0-9]*$/;

        var errormessage = "Enter valid Amount";
        var amount_field = regnumber_rule.test($("#paylink-edit #paylink_amount").val());
        var linkfor_field = $("#paylink-edit #paylink_for").val();

        var paylinkid = $("#paylink-edit input[name='id']").val();
        
        if(!amount_field)
        {   
            $("#paylink-edit #paylink_amount_error").html(errormessage).css({"color":"red"});
            return false;
        }
        
        if(linkfor_field == "")
        {
            $("#paylink-edit #paylink_for_error").html("Purpose is Empty").css({"color":"red"});
            return false;
        }
        
        $("#paylink-edit input[type='checkbox']").each(function(index,element){
            var elementName = $(element)[0].name;
            if(element.name=="email_paylink" && $(element).prop('checked') && $("#paylink-edit #paylink_customer_email").val()==""){
                $("#paylink-edit #paylink_customer_email").focus();
                $("#paylink-edit #paylink_customer_email_error").html("Email is empty").css({"color":"red"});
                $("#paylink-edit #paylink_customer_email").click(function(e){
                    e.preventDefault();
                    $("#paylink-edit #paylink_customer_email_error").html("");
                });
                formvalidate = false;
                return false;
            }else if(element.name=="mobile_paylink" && $(element).prop('checked') && $("#paylink-edit #paylink_customer_mobile").val()==""){
                $("#paylink-edit #paylink_customer_mobile").focus();
                $("#paylink-edit #paylink_customer_mobile_error").html("Mobile is empty").css({"color":"red"});
                $("#paylink-edit #paylink_customer_mobile").click(function(e){
                    e.preventDefault();
                    $("#paylink-edit #paylink_customer_mobile_error").html("");
                });
                formvalidate = false;
                return false;
            }
            formdata[formdata.length] = {name:elementName,value:$(element).val()};
        });
        
        if($("#paylink-edit #paylink_customer_email").val()!="")
        {
            vaidateEmail('paylink_customer_email','paylink_customer_email');
        }
        if($("#paylink-edit #paylink_customer_mobile").val()!="")
        {
            validateMobile('paylink_customer_mobile','paylink_customer_mobile');
        }

        if(paylinkid != "" && formvalidate)
        {
            $("div#divLoading").removeClass('hide');
            $("div#divLoading").addClass('show');
            $.ajax({
                url:"/merchant/paylink/update",
                type:"POST",
                data:getJsonObject(formdata),
                dataType:"json",
                success:function(response){
                    if(response.status)
                    {
                        showMessage(response.status,response.message,"paylink-edit-response-message");
                    
                    }else{
                        if(typeof response.errors!="undefined")
                        {   
                            $.each(response.errors, function (indexInArray, valueOfElement) { 
                                $("#paylink-edit #"+indexInArray+"_error").html(valueOfElement[0]).css({"color":"red"});
                                $("input[name="+indexInArray+"]").click(function(e){
                                    e.preventDefault();
                                    $("#paylink-edit #"+indexInArray+"_error").html("");
                                });
                           });
                        } 
                    }
                },
                error:function(error){
                    
                },complete:function(){
                    getAllPaylinks();
                    $("div#divLoading").removeClass('show');
                    $("div#divLoading").addClass('hide');
                    setTimeout(() => {
                        $("#paylink-edit-response-message").html("");
                    },3000);
                }
            });
        }
        
    });
    //Update Paylink functionality ends here


    //Update Item functionality starts here
    $("#item-update-form").submit(function(event){
        event.preventDefault();
        var formdata = $("#item-update-form").serializeArray();
        $.ajax({
            url:"/merchant/item/update",
            type:"POST",
            data:getJsonObject(formdata),
            dataType:"json",
            success:function(response){
                if(response.status)
                {
                    getAllItems();
                    showMessage(response.status,response.message,"item-update-response");
                }else{
                   $.each(response.error,function (indexInArray, valueOfElement) { 
                       $("#item-update-form #"+indexInArray+"_error").html(valueOfElement[0]).css({"color":"red"});
                       $("input[name="+indexInArray+"]").click(function(e){
                           e.preventDefault();
                        $("#item-update-form #"+indexInArray+"_error").html("");
                       })
                   });
                }
            },
            error:function(data){
                var errors = data.responseJSON;
            },complete:function(){
            }
        });
    });
    //Update Item functionality ends here

    //Update Invoice functionality starts here
    function updateInvoice(value='')
    {

        var formdata = "";
        var formvalidate = "";
        var isformvalid = false;
        var invoice
        $("#invoice-edit-form #invoice_status").val(value);

        formdata = $("#invoice-edit-form").serializeJSON();
        formvalidate = $("#invoice-edit-form").serializeArray();
       
       
        var mandatory = {
            "invoice_receiptno":"Invoice No",
            "merchant_company":"Company",
            "merchant_panno":"Pan No",
            "invoice_issue_date":"Invoice Date",
            "invoice_billing_to":"Name",
            "customer_email":"Email",
            "customer_phone":"Phone",
            "invoice_billing_address":"Billing Address",
            "invoice_shipping_address":"Shipping Address",
        }
        
        $.each(formvalidate,function(index,element){
            
            if(element.name in mandatory)
            {
                if(element.value == "")
                {
                    $("#"+element.name+"_error").html("Field "+mandatory[element.name]+" is empty").css({"color":"red"})
                    
                    $("#"+element.name).focus();

                    $("input[name="+element.name+"]").click(function(event){
                        event.preventDefault();
                        $("#"+element.name+"_error").html("");
                    });

                    $("#"+element.name).change(function(event){
                        event.preventDefault();
                        $("#"+element.name+"_error").html("");
                    })
                    isformvalid = false;
                    return false;
                }
            }else{

                if($("#item_name1").val() == "" && element.name!="customer_gstno")
                {
                    $("#item_name1_error").html("1 item must add").css({"color":"red"});
                    $("#item_name1").focus();
                    $("#item_name1").change(function(event){
                        event.preventDefault();
                        $("#item_name1_error").html("");
                    });
                    isformvalid = false;
                    return false;
                }else{
                    isformvalid = true;
                }
            }
        });

        if($("#customer_gstno").val()!=""){
            var stategstcode = "";
            stategstcode = $("#customer_gst_code").val();
            if(stategstcode != $("#customer_gstno").val().substr(0,2))
            {
                $("#customer_gstno").focus();
                $("#customer_gstno_error").html("Selected state and given GST is not matching").css({"color":"red"});
                $("#customer_gstno").click(function(e){
                    $("#customer_gstno_error").html("");
                });
                return false;
            }
        }
        if(isformvalid)
        {
            if(ValidatePAN('merchant-edit-panno','merchant-edit-panno-error') && ValidateMerchantGSTno('merchant_gstno','merchant_gstno_error') &&
            validateMobile('customer_phone','customer_phone_error') && vaidateEmail('customer_email','customer_email_error'))
            {
                $.ajax({
                    url:"/merchant/invoice/update",
                    type:"POST",
                    data:formdata,
                    dataType:"json",
                    success:function(response){
                        if(response.status)
                        {
                            $("#invoice-update-response").html(response.message);
                        }
                    },
                    error:function(error){
                        
                    },complete:function(){
                        if(value == 'issued')
                        {
                            window.location.href='/merchant/invoices';
                            $("#invoice-update-response-message-modal").modal("show");

                        }else{

                            $("#invoice-update-response-message-modal").modal("show");
                        }
                        
                    }
                });
            }

        }
    }
    //Update Invoice functionality ends here

    //Update customer functionality starts here
    $("#edit-customer-form").submit(function(e){
        e.preventDefault();
        var formdata = $("#edit-customer-form").serializeArray();
        if(vaidateEmail('customer-edit-email','custome-edit-email-error') && validateMobile('customer-edit-phone','customer-edit-phone-error') && ValidateMerchantGSTno('customer-edit-gstno','customer-edit-gstno-error'))
        {
            $.ajax({
                url:"/merchant/customer/update",
                type:"POST",
                data:getJsonObject(formdata),
                dataType:"json",
                success:function(response){
                    if(response.status)
                    {
                        $("#edit-customer-modal #edit-response-message").html(response.message).css({"color":"green"})
                    }
                },
                error:function(){},
                complete:function(){
                    //optionCustomers("select");
                    getAllCustomers();
                    setTimeout(() => {
                        $("#edit-customer-modal #edit-response-message").html("");
                    }, 1500);

                }
            });
        }
    });
    //Update customer functionality ends here

    //Update Customer Address functionality code starts here
    $("#add-edit-customer-address-form").submit(function(e){
        e.preventDefault();
        var formdata = $("#add-edit-customer-address-form").serializeArray();
        var customerid = $("#add-edit-customer-address-form #customer_id").val();
        var formvalidation = false;
        var addressFields = ["address","city","pincode","state_id"];
        $.each(formdata, function (indexInArray, valueOfElement) {
            if($.inArray(valueOfElement.name,addressFields) > -1){

                if(valueOfElement.value == "")
                {
                    $("#add-edit-customer-address-form #"+valueOfElement.name+"_error").html("Field is mandatory").css({"color":"red"});
                    $("#add-edit-customer-address-form input[name="+valueOfElement.name+"]").click(function(e){
                        e.preventDefault();
                        $("#add-edit-customer-address-form #"+valueOfElement.name+"_error").html("");
                    });
                    $("#add-edit-customer-address-form textarea[name="+valueOfElement.name+"]").click(function(e){
                        $("#add-edit-customer-address-form #"+valueOfElement.name+"_error").html("");
                    });
                    $("#add-edit-customer-address-form select[name="+valueOfElement.name+"]").click(function(e){
                        $("#add-edit-customer-address-form #"+valueOfElement.name+"_error").html("");
                    });
                    formvalidation = false;
                }else{
                    formvalidation = true;
                }
            }
             
        });
        if(formvalidation){

            $.ajax({
                url:"/merchant/customer-address/update",
                type:"POST",
                data:getJsonObject(formdata),
                dataType:"json",
                success:function(response){
                    if(response.status)
                    {
                        $("#ajax-address-update-response-message").html(response.message).css({"color":"green"});
                        AddEditCustomerAddress(customerid);
                        $("#add-edit-customer-address-form #id").val("");
                        $("#add-edit-customer-address-form #change-button-label").html("Add Address");
                        
                    }else{

                        if(typeof response.errors != undefined && Object.keys(response.errors).length > 0){
                            $.each(response.errors, function (indexInArray, valueOfElement) { 
                                 $("#add-edit-customer-address-form #"+indexInArray+"_error").html(valueOfElement[0]).css({"color":"red"});
                                 $("#add-edit-customer-address-form input[name="+indexInArray+"]").click(function(e){
                                     e.preventDefault();
                                     $("#add-edit-customer-address-form #"+indexInArray+"_error").html("");
                                 })
                            });
                        }
                    }
                },
                error:function(){},
                complete:function(){
                    setTimeout(() => {
                        $("#ajax-address-update-response-message").html("");
                    }, 1500);
                }
            });
        }
        
    });
    //Update Customer Address functionality code ends here

    //Update Product data functionality code starts here
    $("#update-product-form").submit(function(e){
        e.preventDefault();
        var formdata = $("#update-product-form").serializeArray();
        $.ajax({
            url:"/merchant/product/update",
            type:"POST",
            data:getJsonObject(formdata),
            dataType:"json",
            success:function(response){
                if(response.status)
                {
                    $("#ajax-update-product-response").html(response.message).css({"color":"green"});
                }else{
                    if(Object.keys(response.errors).length > 0)
                    {
                        $.each(response.errors,function(indexInArray,valueOfElement) { 
                             $("#update-product-form #"+indexInArray+"_error").html(valueOfElement[0]).css({"color":"red"});
                             $("input[name="+indexInArray+"]").click(function(e){
                                e.preventDefault();
                                $("#update-product-form #"+indexInArray+"_error").html("");
                             });    
                        });
                    }
                }
            },
            error:function(){},
            complete:function(){
                getAllProducts();
                setTimeout(() => {
                    $("#ajax-update-product-response").html("");
                }, 1500);
            }
        });
    })
    //update Product data functionality code ends here

    //Update Notification seen functionality code starts here
    function notificationSeen(id)
    {
        $.ajax({
            url:"/merchant/notification/update/"+id,
            type:"GET",
            success:function(){},
            error:function(){},
            complete:function(){
                getAllNotifications();
            }
        })
    }
    //Update Notification seen functionality code ends here

    $("#edit-merchant-employee-form").submit(function(e){
        e.preventDefault();
        var formdata = $(this).serializeArray();
        $.ajax({
            type:"POST",
            url:"/merchant/employee/update",
            data:getJsonObject(formdata),
            dataType:"json",
            success: function (response) {
                if(response.status){
                    $("#ajax-edit-success-message").html(response.message);
                }else{
                    if(Object.keys(response.errors).length > 0){
                        $.each(response.errors,function(element,message){
                            $("#"+element+"_error").html(message[0]).css({"color":"red"});
                            $("#merchant-employee-form select[name="+element+"]").click(function(e){
                                e.preventDefault();
                                $("#"+element+"_error").html("");
                            });
                            $("#merchant-employee-form input[name="+element+"]").click(function(e){
                                e.preventDefault();
                                $("#"+element+"_error").html("");
                            });
                        });
                    }
                }
            },complete:function(){
                setTimeout(() => {
                    $("#ajax-edit-success-message").html("");
                }, 3000);
            }
        });
    });

    //permission page
    function empPermission(employeegid){
        window.location.href=base_url+'/merchant/employee/type/'+employeegid;

    }
    //Merchant Employee password update code starts here
    function changeEmpPassword(employeeid){
        $("#merchant-employee-password-form")[0].reset();
        $("#merchant-employee-password-form #id").val(employeeid);
        $("#merchant-employee-password-modal").modal({show:true,backdrop:'static',keyboard:false});
    }

    $("#merchant-employee-password-form").submit(function(e){
        e.preventDefault();
        var formdata = $(this).serializeArray();
        $.ajax({
            type:"POST",
            url:"/merchant/employee/reset-password",
            data:getJsonObject(formdata),
            dataType:"json",
            success: function (response) {
                if(response.status){
                    $("#ajax-reset-password-success").html(response.message);
                    $("#merchant-employee-password-form")[0].reset();
                setTimeout(() => {
                    $("#merchant-employee-password-modal").modal('hide');
                }, 3000);
                }else{
                    if(Object.keys(response.errors).length > 0){
                        $.each(response.errors,function(element,message){
                            $("#"+element+"_error").html(message[0]).css({"color":"red"});
                            $("#merchant-employee-password-form input[name="+element+"]").click(function(){
                                $("#"+element+"_error").html("");
                            }); 
                        });
                    }
                }
            }
        });
    });
    //Merchant Employee password update code ends here
    
    //Merchant Employee update employee status code starts here
    function updateEmpStatus(employeeid,status){
        $("#merchant-employee-status-form")[0].reset();
        $("#merchant-employee-status-form #id1").val(employeeid);
        $("#"+status).prop("checked",true);
        $("#merchant-employee-status-modal").modal({show:true,backdrop:'static',keyboard:false});
        
    }
    $("#merchant-employee-status-form").submit(function(e){
        e.preventDefault();
        var formdata = $(this).serializeArray();
        $.ajax({
            type:"POST",
            url:"/merchant/employee/account-status",
            data:getJsonObject(formdata),
            dataType:"json",
            success: function (response) {
                if(response.status){
                    $("#ajax-employee-status-success").html(response.message);
                }else{
                    $("#ajax-employee-status-fail").html(response.message);
                }
                getAllMerchantEmployees();
            },complete:function(){
                setTimeout(() => {
                    $("#ajax-employee-status-success").html("");
                    $("#ajax-employee-status-fail").html("");
                    $("#merchant-employee-status-modal").modal('hide');
                }, 3000);
            }
        });
    });
    //Merchant Employee update employee status code ends here
    
    //Merchant Employee unlock update code starts here
    function unlockAccount(employeeid){
        $.ajax({
            type:"GET",
            url:"/merchant/employee/unlock-account/"+employeeid,
            dataType:"json",
            success: function (response) {
                if(response.status){
                    $("#merchant-employee-unlock-response").html(response.message);
                    $("#merchant-employee-unlock-modal").modal({show:true,backdrop:'static',keyboard:false});
                     getAllMerchantEmployees();
                }
            }
        });
        
    }
    //Merchant Employee unlock update code ends here
$("#permissions-form-emp").submit(function(e) {

    e.preventDefault();
    var formdata = $("#permissions-form-emp").serializeArray();
    $.ajax({
        url:base_url+"/merchant/employee/permissions",
        type:"POST",
        data: (formdata),
        dataType: "json",
        success: function(response) {
        window.scrollTo(0, 0);
        if (response.status) {
            $("#ajax-response-message").html(response.message).css({
                                 "color": "green"
             });
           $("#permissions-form-emp")[0].reset();
         } else {
            if (typeof response.errors != "undefined" && Object.keys(response.errors).length > 0) {
                 $.each(response.errors, function(indexInArray, valueOfElement) {
                 $("#permissions-form-emp #" + indexInArray + "_ajax_error").html(valueOfElement[0]).css({
                                                        "color": "red"
            });
              $("#permissions-form-emp input[name=" + indexInArray + "]").click(function() {
               $("#permissions-form-emp #" + indexInArray + "_ajax_error").html("");
            });

         });
            }
        }
                },
       error: function() {},
            complete: function(response) {

                setTimeout(() => {
                $("#ajax-response-message").html("");
                  if (response.status) {
                     history.go(-1);
                  }
                        
               }, 3000);
            }
        });
});
//Update data ends 


//Delete data starts

    //Remove item javascript functionality starts
    $("#item-delete-form").submit(function(event){
        event.preventDefault();
        var formdata = $("#item-delete-form").serializeArray();
        $.ajax({
            url:"/merchant/item/remove",
            type:"POST",
            data:getJsonObject(formdata),
            dataType:"json",
            success:function(response){
                if(response.status)
                {
                    $("#deleteitemmodal").modal("hide");
                    showMessage(response.status,response.message,"item-response-message");
                    getAllItems();
                }else{
                    showMessage(response.status,response.message,"item-response-message");
                }
                
            },
            error:function(error){
                
            }
        });
    });
    //Remove item javascript functionality ends
    $("#delete-customer-form").submit(function(e){
        e.preventDefault();
        var formdata = $("#delete-customer-form").serializeArray();
        $.ajax({
            url:"/merchant/customer/remove",
            type:"POST",
            data:getJsonObject(formdata),
            dataType:"json",
            success:function(response){
                if(response.status)
                {
                    $("#delete-customer-modal").modal("hide");
                    $("#delete-customer_response").html(response.message).css({"color":"green"});
                    getAllCustomers();
                }else{
                    $("#delete-customer-modal").modal("hide");
                    $("#delete-customer_response").html(response.message).css({"color":"red"});
                }
            },
            error:function(error){
                
            },complete:function(){
                setTimeout(() => {
                    $("#delete-customer_response").html("");
                }, 3000);
            }
        });
    })

     //Delete Customer Address on Modal functionality starts here
     function deleteCustomerAddress(addressid,customer_id)
     {
        $("#customer-address-delete-form input[name='id']").val(addressid);
        $("#customer-address-delete-form input[name='customer_id']").val(customer_id);
        $("#delete-customer-address-modal").modal({show:true});
     }

     $("#customer-address-delete-form").submit(function(e){
         e.preventDefault();
         var formdata = $("#customer-address-delete-form").serializeArray();
         var customerid = $("#customer-address-delete-form input[name='customer_id']").val();
         $.ajax({
            url:"/merchant/customer-address/delete",
            type:"POST",
            data:getJsonObject(formdata),
            dataType:"json",
            success:function(response){
                $("#delete-customer-address-modal").modal({show:false});
                if(response)
                {
                    $("#ajax-address-update-response-message").html(response.message).css({"color":"green"});
                }
            },
            error:function(){},
            complete:function(){
                AddEditCustomerAddress(customerid);
                setTimeout(() => {
                    $("#ajax-address-update-response-message").html("");
                }, 1500);
            }
        });
     });
     
     //Delete Customer Address on Modal functionality ends here

    //Delete Product functionality code starts here
     function deleteProduct(id)
     {
        $("#product-delete-form input[name='id']").val(id);
        $("#delete-product-modal").modal({show:true});
     }

    $("#product-delete-form").submit(function(e){
        e.preventDefault();
        var formdata = $("#product-delete-form").serializeArray();
        $.ajax({
            url:"/merchant/product/delete",
            type:"POST",
            data:getJsonObject(formdata),
            dataType:"json",
            success:function(response){
            },
            error:function(){},
            complete:function(){
                getAllProducts();
                $("#delete-product-modal").modal("hide");
            }
        });
    });

    function makePageInactive(recordId){
        $("#deactivate-pagedetail #id").val(recordId);
        var pageStatus = $("#button_"+recordId).html();
        $("#deactivate-pagedetail #page_status").val(pageStatus);
        $("#page-deactivate-modal-message").html("Would you like to make page "+pageStatus+"?");
        $("#page-deactivate-modal").modal({show:true,backdrop:"static",keyboard:false});
    }

    $("#deactivate-pagedetail").submit(function(e){
        e.preventDefault();
        var recordId = $("#deactivate-pagedetail #id").val();
        var buttonStatus = $("#button_"+recordId).html();
        var formdata = $(this).serializeArray();
        if(recordId!="")
        {
            $.ajax({
                type:"POST",
                url:"/payment-pages/remove",
                data:getJsonObject(formdata),
                dataType:"json",
                success: function (response) {
                   if(response.status){
                       if(buttonStatus == "active"){
                        $("#button_"+recordId).html("inactive");
                       
                       }else{
                        $("#button_"+recordId).html("active");
                       }
                       $("#page-status-"+recordId).html(buttonStatus);
                   }else{
                        $("#button_"+recordId).html(buttonStatus);
                   } 

                   $("#page-deactivate-modal").modal("hide");
                   $("#page-deactivate-response").html(response.message);
                   $("#page-deactivate-response-modal").modal({show:true,backdrop:"static",keyboard:false});
                }
            });
        }
    });
    //Delete Product functionality code ends here
//Delete data ends

// Search Box
$("[data-target='#navbarSupportedContent']").click(function(e){
    e.preventDefault();

    if($("#navbarSupportedContent").hasClass("collapse navbar-collapse navbar-menu-wrapper"))
    {
        $("#navbarSupportedContent").removeClass("collapse navbar-collapse navbar-menu-wrapper");
        $("#navbarSupportedContent").addClass("navbar-collapse navbar-menu-wrapper collapse show");

    }else{

        $("#navbarSupportedContent").removeClass("navbar-collapse navbar-menu-wrapper collapse show");
        $("#navbarSupportedContent").addClass("collapse navbar-collapse navbar-menu-wrapper");
    }
    
});




