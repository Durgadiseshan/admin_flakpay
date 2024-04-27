$(document).ready(function(){
    formatAMPM();
});


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
    $("#nav-clock").html("<span style='color:#00a8e9'>Date:</span> "+day+"-"+month+"-"+year+" "+hours + ':' + minutes +':'+ seconds +' ' + ampm);
    //$("#nav-clock").html(hours + ':' + minutes +' '+ ampm);
    setTimeout(formatAMPM, 500);
}
//Running Time Code ends here


//Edit Transaction javascript functionality starts
function transactionDetails(trans_id)
{

    $.ajax({
        url:"/merchant/employee/payment/get/"+trans_id,
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
//Edit Transaction javascript functionality ends

//List all transactions code starts here
function getAllTransactionDetails(perpage=10){
    $.ajax({
        type:"GET",
        url:"/merchant/employee/get-transactions/"+perpage,
        dataType: "html",
        success: function (response) {
            $("#paginate_transaction").html(response);
        }
    });
}
//List all transaction code ends here


//List all paylinks code starts here
function getAllPaylinks(perpage=10){
    $.ajax({
        type:"GET",
        url:"/merchant/employee/get-paylinks/"+perpage,
        dataType: "html",
        success: function (response) {
            $("#paginate_paylink").html(response);
        }
    });
}
//List all paylinks code ends here

//Store Paylink By Employee code starts here
$("#paylinkadd").submit(function(e){
    e.preventDefault();
    
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
            url:"/merchant/employee/paylink/add",
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

                $("#paylink-add").addClass("disabled");
            }
        });

    }
    
});
//Store Paylink By Employee code ends here

//Edit paylink javascript functionality starts
    function editPaylink(paylinkid){
        
        $("#paylink-response-message").html("");
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
            url:"/merchant/employee/paylink/edit/"+paylinkid,
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
                url:"/merchant/employee/paylink/update",
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


    function getAllQuickLinks(perpage=10) {
        $.ajax({
            type:"GET",
            url:"/merchant/employee/get-quick-paylinks/"+perpage,
            dataType: "html",
            success: function (response) {
                $("#paginate_quicklink").html(response);
            }
        });
    }

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
            url:"/merchant/employee/quicklink/add",
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

    function getAllLogActivities(perpage=10){
        $.ajax({
            type:"GET",
            url:"/merchant/employee/merchant-emp-login-log/"+perpage,
            dataType:"html",
            success: function (response) {
                console.log(response);
                $("#paginate_merchantemp_log").html(response);
            },error:function(error){
                console.log(error.responseText());
            }
        });
    }
