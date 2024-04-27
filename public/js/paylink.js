
$("input[name='paylink_partial']").click(function(e){
    e.preventDefault();
    var newvalue = $(this).val() == "N"?"Y":"N";
    $(this).val(newvalue);
});
$("input[name='email_paylink']").click(function(e){
    e.preventDefault();
    var newvalue = $(this).val() == "N"?"Y":"N";
    $(this).val(newvalue);
});
$("input[name='mobile_paylink']").click(function(e){
    e.preventDefault();
    var newvalue = $(this).val() == "N"?"Y":"N";
    $(this).val(newvalue);
});
$("input[name='paylink_auto_reminder']").click(function(e){
    e.preventDefault();
    var newvalue = $(this).val() == "N"?"Y":"N";
    $(this).val(newvalue);
});

$("input[name='paylink_amount']").click(function(e){
    e.preventDefault();
    $("#paylink_amount_error").html("");
});

$("input[name='paylink_amount']").on("keyup input",function(e){
    e.preventDefault();
    enableButton("paylink",$(this).closest("form").attr("id"));
});

$("input[name='paylink_for']").on("keyup input",function(e){
    e.preventDefault();
    enableButton("paylink",$(this).closest("form").attr("id"));
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