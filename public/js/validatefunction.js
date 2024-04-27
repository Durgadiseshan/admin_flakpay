// SCROLLSPY
$(document).ready(function() {
    $(".nav-link").click(function() {
	var t = $(this).attr("href");
	$("html, body").animate({
	    scrollTop: $(t).offset().top - 75
	}, {
	    duration: 1000,
	});
	$('body').scrollspy({ target: '.navbar',offset: $(t).offset().top });
	return false;
    });
});
  
//SIDEBAR-OPEN
$('#navbarSupportedContent').on('hidden.bs.collapse', function () {
    $("body").removeClass("sidebar-open");
})

$('#navbarSupportedContent').on('shown.bs.collapse', function () {
    $("body").addClass("sidebar-open");
})


window.onresize = function() {
    var w = window.innerWidth;
    if(w>=786) {
    $('body').removeClass('sidebar-open');
    $('#navbarSupportedContent').removeClass('show');
    }
}
  
// Mega- menu
$('.dropdown').hover(function() {
    $(this).find('.mega-menu').stop(true, true).delay(200).fadeIn(500);
    }, function() {
    $(this).find('.mega-menu').stop(true, true).delay(200).fadeOut(500);
});

$(".custom-file-input").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});

//Helping functions starts

function enableButton(module,formid="")
{
    if(module == "paylink"){
        var regnumber = /^[0-9\.]+/g;
        if(formid != ""){

            var paylinkAmount = $("#"+formid+" #paylink_amount").val();
            var paylinkFor = $("#"+formid+" #paylink_for").val();

            if(regnumber.test(paylinkAmount) && paylinkFor != "")
            {
                $("#"+formid+" #paylink-add").removeClass("disabled");
                $("#"+formid+" #paylink-add").prop("disabled",false);
            }else{
                $("#"+formid+" #paylink-add").addClass("disabled");
                $("#"+formid+" #paylink-add").prop("disabled",true);
            }

        }else{

            var paylinkAmount = $("#paylink_amount").val();
            var paylinkFor = $("#paylink_for").val();
            if(regnumber.test(paylinkAmount) && paylinkFor != "")
            {
                $("#paylink-add").removeClass("disabled");
                $("#paylink-add").prop("disabled",false);
            }else{
                $("#paylink-add").addClass("disabled");
                $("#paylink-add").prop("disabled",true);
            }
        }
        
    }
    
}

function showMessage(status,message,id){
    setTimeout(function(){
        if(status)
        {
            $("#"+id).html(message).css({"color":"green"});
        }else{
            $("#"+id).html(message).css({"color":"red"});
        }
        
    },1000);
    $("#"+id).html("");
}

function copyReferText() {
    var $temp = $("<input>");
    var copyText = $("#refer_id").html();
    $("body").append($temp);
    $temp.val(copyText).select();
    document.execCommand("copy");
    $temp.remove();
}


function getJsonObject(formdata){
    var jsondata = {};
    $.each(formdata,function(index,Obj){
        jsondata[Obj.name] = Obj.value;
    });
    return jsondata;
}

function captalize(word) {
    return word.charAt(0).toUpperCase()+word.substr(1,word.length);
}

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

function ValidatePAN(element,error) {
    var txtPANCard = document.getElementById(element);
    //var lblPANCard = document.getElementById(error)
    var regex = /([A-Z]){3}[P]{1}[A-Z]{1}([0-9]){4}([A-Z]){1}$/;
    txtPANCard.value = txtPANCard.value.toUpperCase();
    if(txtPANCard.value.length <= 10)
    {
        if (regex.test(txtPANCard.value.toUpperCase())) {
            //lblPANCard.style.visibility = "hidden";
            $("#"+error).html("");
            return true;
        } else {
            //lblPANCard.style.visibility = "visible";
            $('#'+element).focus();
            $("#"+error).html("Invalid PAN Number").css({"color":"red"});
            return false;
        }

    }else{
        $('#'+element).focus();
        $("#"+error).html("PAN Number Must be 10 chars").css({"color":"red"});
        return false;
    }
}

function ValidateCompanyPAN(element,error) {
    var txtPANCard = document.getElementById(element);
    //var lblPANCard = document.getElementById(error);
    txtPANCard.value = txtPANCard.value.toUpperCase();
    var regex = /([A-Z]){3}[C|F|T]{1}[A-Z]{1}([0-9]){4}([A-Z]){1}$/;
    if(txtPANCard.value.length <= 10)
    {
        if (regex.test(txtPANCard.value.toUpperCase())) {
            //lblPANCard.style.visibility = "hidden";
            $("#"+error).html("");
            return true;
        } else {
            //lblPANCard.style.visibility = "visible";
            $('#'+element).focus();
            $("#"+error).html("Invalid PAN Number").css({"color":"red"});
            return false;
        }
    }else{
        $('#'+element).focus();
        $("#"+error).html("PAN Number Must be 10 chars").css({"color":"red"});
        return false;
    }
}


function ValidateGSTno(element,error) {
    var txtPANCard = document.getElementById(element);
    //var lblPANCard = document.getElementById(error);
    txtPANCard.value = txtPANCard.value.toUpperCase();
    var regex = /^([0]{1}[1-9]{1}|[1-2]{1}[0-9]{1}|[3]{1}[0-7]{1})([a-zA-Z]{5}[0-9]{4}[a-zA-Z]{1}[1-9a-zA-Z]{1}[zZ]{1}[0-9a-zA-Z]{1})$/g;
    if(txtPANCard.value.length <= 15)
    {
        if (regex.test(txtPANCard.value.toUpperCase())) {
            //lblPANCard.style.visibility = "hidden";
            $("#"+error).html("");
            return true;
        } else {
            //lblPANCard.style.visibility = "visible";
            $('#'+element).focus();
            $("#"+error).html("Invalid GST Number").css({"color":"red"});
            return false;
        }

    }else{
        $('#'+element).focus();
        $("#"+error).html("GST Number Must be 15 chars").css({"color":"red"});
        return false;
    }
    
    //37adapm1724a2Z5
}


function ActivevalidateGSTno(element,error) {
    var txtPANCard = document.getElementById(element);
    //var lblPANCard = document.getElementById(error);
    txtPANCard.value = txtPANCard.value.toUpperCase();
    var regex = /^([0]{1}[1-9]{1}|[1-2]{1}[0-9]{1}|[3]{1}[0-7]{1})([a-zA-Z]{5}[0-9]{4}[a-zA-Z]{1}[1-9a-zA-Z]{1}[zZ]{1}[0-9a-zA-Z]{1})$/g;
    if(txtPANCard.value.length <= 15)
    {
        if (regex.test(txtPANCard.value.toUpperCase())) {
            //lblPANCard.style.visibility = "hidden";
            $("#"+error).html("");
            return true;
        } else {
            //lblPANCard.style.visibility = "visible";
            $('#'+element).focus();
            $("#"+error).html("Invalid GST Number").css({"color":"red"});
            return false;
        }

    }else{
        $('#'+element).focus();
        $("#"+error).html("GST Number Must be 15 chars").css({"color":"red"});
        return false;
    }
    
    //37adapm1724a2Z5
}


function validateAlpha(element)
{
    var alphainput = document.getElementById(element);

    var regex = /[0-9]/;

    if(regex.test(alphainput.value))
    {
        var inputStr = alphainput.value;
        return alphainput.value = inputStr.replace(/[0-9.]/g,'').replace(/(\..*)\./g, '$1');
    }

}

function validateName(element){

    var alphainput = document.getElementById(element);

    var regex = /([0-9~\[\]!@#$%^&*(),.?":{}|<>_+=|{},."':;?/`-]){1}/;

    if(regex.test(alphainput.value))
    {
        var inputStr = alphainput.value;
        return alphainput.value = inputStr.replace(/([0-9~\[\]!@#$%^&*(),.?":{}|<>_+=|{},."':;?/`-]){1}/,'').replace(/(\..*)\./g, '$1');
    }
}

function validateNumeric(element)
{
    var alphainput = document.getElementById(element);

    var regex = /[a-zA-Z]/;

    if(regex.test(alphainput.value))
    {
        var inputStr = alphainput.value;
        return alphainput.value = inputStr.replace(/[a-zA-Z.]/g,'').replace(/(\..*)\./g, '$1');
    }

}


function acceptOnlyNumeric(element,id)
{
    var alphainput = document.getElementById(element);

    var regex = /^[0-9]*$/;
    if(alphainput.value.length <= 16)
    {   
        if(!regex.test(alphainput.value))
        {
            var inputStr = alphainput.value;
            return alphainput.value = inputStr.replace(/[^0-9]+/g,'');
        }
        $("#"+id).html("");
        return true;
    }else{

        $("#"+id).html("Account no should not be more than 16 digits").css({"color":"red"});
        return false;
    }
}

function validatePincode(element,id)
{
    var alphainput = document.getElementById(element);

    var regex = /^[0-9]*$/;
    if(alphainput.value.length <= 6)
    {   
        if(!regex.test(alphainput.value))
        {
            var inputStr = alphainput.value;
            return alphainput.value = inputStr.replace(/[^0-9]+/g,'');
        }
        $("#"+id).html("");
        return true;
    }else{

        $("#"+id).html("Pincode should must be 6 digits").css({"color":"red"});
        return false;
    }
}


function acceptOnlyAlphaNumeric(element,id)
{
    var alphainput = document.getElementById(element);

    var regex = /^[a-z0-9]+$/i;
    alphainput.value = alphainput.value.toUpperCase();
    if(alphainput.value.length <= 11)
    {   
        if(!regex.test(alphainput.value))
        {
            var inputStr = alphainput.value;
            return alphainput.value = inputStr.replace(/[^a-zA-Z 0-9]+/g,'');
        }
        $("#"+id).html("");
        return true;
    }else{

        $("#"+id).html("IFSC should not be more than 11 digits").css({"color":"red"});
        return false;
    }
}

function vaidateEmail(element,error,form="")
{
    var inputEmail = document.getElementById(element);
    var regemail_rule = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
    if(inputEmail.value!=""){
        if(regemail_rule.test(inputEmail.value))
        {
            if(form != ""){
                $("#"+form+" #"+error).html("");
            }else{
                $("#"+error).html("");
            }
            $("#"+element).click(function(){
                $("#"+error).html("");
            }); 
            return true;
        
        }else{
            $('#'+element).focus();
            if(form != ""){
                $("#"+form+" #"+error).html("Email is invalid").css({"color":"red"});
            }else{
                $("#"+error).html("Email is invalid").css({"color":"red"});
            }
            $("#"+element).click(function(){
                $("#"+error).html("");
            }); 
            return false;
        }
    }else{
        $("#"+error).html("");
        return true;
    }
    
     
}

function validateMobile(element,error,form="")
{
    var alphainput = document.getElementById(element);
    var inputStr = "";
    var regex = /[a-zA-Z]/;
    
    if(alphainput.value!=""){
        if(alphainput.value.length < 10)
        {   
            if(regex.test(alphainput.value))
            {
                inputStr = alphainput.value;
                return alphainput.value = inputStr.replace(/[a-zA-Z.]/g,'').replace(/(\..*)\./g, '$1');

            }else{
                $('#'+element).focus();
                if(form!=""){
                    $("#"+form+" #"+error).html("Mobile No must be 10 digit").css({"color":"red"});
                }else{
                    $("#"+error).html("Mobile No must be 10 digit").css({"color":"red"});
                }
                
                return false;
            }

        }else if(alphainput.value.length > 10){
            $('#'+element).focus();
            if(form!=""){
                $("#"+form+" #"+error).html("Mobile No must be 10 digit").css({"color":"red"});
            }else{
                $("#"+error).html("Mobile No must be 10 digit").css({"color":"red"});
            }
            inputStr = alphainput.value;
            return alphainput.value = inputStr.replace(/[a-zA-Z.]/g,'').replace(/(\..*)\./g, '$1');
        }else
        {   
            $("#"+error).html("");
            return true;
        } 
    }else{
        $("#"+error).html("");
    }
      
}

function validateAadharCard(element,id){

    var alphainput = document.getElementById(element);

    var regex = /^[0-9]*$/;
    if(alphainput.value.length <= 16)
    {   
        if(!regex.test(alphainput.value))
        {
            var inputStr = alphainput.value;
            return alphainput.value = inputStr.replace(/[^0-9]+/g,'');
        }
        $("#"+id).html("");
        return true;
    }else{

        $("#"+id).html("Aadhar no should not be more than 16 digits").css({"color":"red"});
        return false;
    }
}

function ValidateMerchantGSTno(element,error) {
    var txtPANCard = document.getElementById(element);
    if(txtPANCard.value.length > 0)
    {
        txtPANCard.value = txtPANCard.value.toUpperCase();
        var regex = /^([0]{1}[1-9]{1}|[1-2]{1}[0-9]{1}|[3]{1}[0-7]{1})([a-zA-Z]{5}[0-9]{4}[a-zA-Z]{1}[1-9a-zA-Z]{1}[zZ]{1}[0-9a-zA-Z]{1})$/g;
        if(txtPANCard.value.length <= 15)
        {
            if (regex.test(txtPANCard.value.toUpperCase())) {
                //lblPANCard.style.visibility = "hidden";
                $("#"+error).html("");
                return true;
            } else {
                //lblPANCard.style.visibility = "visible";
                $('#'+element).focus();
                $("#"+error).html("Invalid GST No").css({"color":"red"});
                return false;
            }

        }else{
            $('#'+element).focus();
            $("#"+error).html("GST No Must be 15 chars").css({"color":"red"});
            return false;
        }

    }else{
        $('#'+element).focus();
        $("#"+error).html("GST No Must be 15 chars").css({"color":"red"});
        return false;
    }
    
}

function showLoader(){
    $("div#divLoading").removeClass('hide');
    $("div#divLoading").addClass('show');
  }
  
  function hideLoader(){
    $("div#divLoading").removeClass('show');
    $("div#divLoading").addClass('hide');
  }

//Helping functions ends
