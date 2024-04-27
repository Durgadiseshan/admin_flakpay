
$(document).ready(function(){
    $(".next-btn").click(function(){
        $(".section-1").hide();
        $(".form-hide").show();
    });
    $(".back-btn").click(function(){
        $(".section-1").show();
        $(".form-hide").hide();
    location.reload();
    });
    src = '/images/bg1.png';
    $('body').css('backgroundImage','url('+src+')');
});

var inputTagName = ["INPUT","SELECT","TEXTAREA"]; 

function saveActivatePage(pagename){

    var pagename = $("input[name='page_name']").val();

    switch (pagename) {
        case 'charitypage':
             saveCharityPage();
            break;
    
        default:
            break;
    }
 }

function saveCharityPage(){
    

    var pageTitle = $("input[name='page_title']").val();
   
    if(unSavedInputFields())
    {
        $("#show-form-error").html("Please save all the fields before save and activate page");
        $("#form-error").modal({show:true,backdrop:"static",keyboard:false});
        return false;

    }else if(pageTitle == ""){
        $("#show-form-error").html("Page Title is empty");
        $("#form-error").modal({show:true,backdrop:"static",keyboard:false});
        return false;
    }


    savePageDetails("page-detail");
}

function unSavedInputFields() {
    var unsavedFields = false;
    $("div.input-div").each(function(index,object){
      if($(object).children("label").find("input").length == 1){
        unsavedFields = true;
      }
    });
    return unsavedFields;
  }

function savePageDetails(id){

    var formdata = new FormData($("#"+id)[0]);
  
    $.ajax({
      type:"POST",
      url:"/payment-pages/store/page-detail",
      data:formdata,
      contentType:false,
      cache:false,
      processData:false,
      dataType:"json",
      success: function (response) {
        if(response.status){
          savePageInputFields(response.paymentpageId);
        }
      }
    });
}

function savePageInputFields(paymentpageId){

    var dynamicInputdata = $("#dynamic-input-detail")[0];
    var pageInputData = grabPageInputElements(dynamicInputdata);
    $.ajax({ 
      type:"POST",
      url:"/payment-pages/store/page-input-detail",
      data:{input_detail:CustJsonObject(pageInputData),paymentpageId:paymentpageId,_token:$('meta[name="csrf-token"]').attr('content')},
      dataType: "json",
      success: function (response) {
          if(response.status){
              $("#show-form-success").html(response.message);
              $("#form-success").modal({show:true,backdrop:"static",keyboard:false});
              
          }else{
              $("#show-form-error").html(response.message);
              $("#form-error").modal({show:true,backdrop:"static",keyboard:false});
          }
      },complete:function(){
        //$("#page-detail")[0].reset();
        //$("#dynamic-input-detail")[0].reset();
        calculateTotal();
        //window.location.reload(true);
      }
    });
  
}

function grabPageInputElements(formdata){

    var pageInputElements = [];
    var elementsCount = 0;
    $.each(formdata,function(index,element){
      if($.inArray($(element).prop("tagName"),inputTagName) > -1 && $(element).attr("class")!="custom-select" && !$(element).hasClass("drop-input")){
        pageInputElements[elementsCount] = {
              "label":$(element).data("label"),
              "name":$(element).attr("name"),
              "value":$(element).val()!="undefined"?$(element).val():"",
              "type":$(element).data("type"),
              "option":$(element).data("option")!="undefined"?$(element).data("option"):"",
              "mandatory":$(element).data("mandatory")!="undefined"?$(element).data("mandatory"):"true",
          }
          ++elementsCount;
      }
    });
  
    return pageInputElements;
}

function CustJsonObject(formdata){

    var label = [];
    var name = [];
    var inputType = [];
    var inputvalue = [];
    var optionObject = {};
    var option = [];
    var mandatory = [];
    var jsondata = {};
  
    
    $.each(formdata,function(index,Obj){
      if(Object.keys(Obj).length > 2){
          $.each(Obj,function(key,value){


            switch (key) {

                case "label":
                    label.push(value)
                    jsondata["input_label"] = label;
                    break;

                case "name":
                    name.push(value)
                    jsondata["input_name"] = name;
                    break;

                case "type":
                    inputType.push(value)
                    jsondata["input_type"] = inputType;
                    break;
                    
                case "value":
                    inputvalue.push(value)
                    jsondata["input_value"] = inputvalue;
                    break;

                case "option":
                    if(typeof value !== 'undefined' ){
                        option.push(value);
                        optionObject[index] = option;
                        jsondata["input_option"] = option;
                    }else{
                        option.push("");
                        optionObject[index] = option;
                        jsondata["input_option"] = option;
                    }
                    break;
                    
                case "mandatory":
                    mandatory.push(value)
                    jsondata["input_mandatory"] = mandatory;
                    break;
                    
                default:
                    break;
            }

          });
          
      }
    }); 
    return jsondata;
  }


$("#payment-form #input_amount").click(function(e){
    e.preventDefault();
    $("#payment-form #input_amount_error").html("");
});

$("#payment-form #input_email").click(function(e){
    e.preventDefault();
    $("#payment-form #input_email_error").html("");
});

$("#payment-form #input_mobile").click(function(e){
    e.preventDefault();
    $("#payment-form #input_mobile_error").html("");
});


function getJsonObject(formdata){
    var jsondata = {};
    $.each(formdata,function(index,Obj){
      jsondata[Obj.name] = Obj.value;
    });
  
    return jsondata;
  }

/*Social Contact Us Terms & Condition */

$("#social-button-open").click(function(e){
    e.preventDefault();
    $(".social").show();
    $(".btn-transparent").hide();
    $("#page-detail #social_enable").val("Y");
});

$("#social-button-close").click(function(e){
    e.preventDefault();
    $(".social").hide();
    $(".btn-transparent").show();
    $("#page-detail #social_enable").val("N");
});

$("#contact-us-open").click(function(e){
    e.preventDefault();
    $("#contactus-div").show();
    $(".btn-transparent2").hide();
    $("#page-detail #contactus_enable").val("Y");
});

$("#contact-us-close").click(function(e){
    e.preventDefault();
    $("#contactus-div").hide();
    $(".btn-transparent2").show();
    $("#page-detail #contactus_enable").val("N");
});

$("#term-condition-open").click(function(e){
    e.preventDefault();
    $(".text-area").show();
    $(".btn-transparent3").hide();
    $("#page-detail #term_condition_enable").val("Y");
});

$("#term-condition-close").click(function(e){
    e.preventDefault();
    $(".text-area").hide();
    $(".btn-transparent3").show();
    $("#page-detail #term_condition_enable").val("N");
});


$("body").on("mouseenter",".input-div",function(){
    $(this).find("i.action-icon-edit").addClass("active");
    $(this).find("i.action-icon-delete").addClass("active");
    $(this).find("i.action-icon-mandatory").addClass("active");
});


$("body").on("mouseleave",".input-div",function(){
    $(this).find("i.action-icon-edit").removeClass("active");
    $(this).find("i.action-icon-delete").removeClass("active");
    $(this).find("i.action-icon-mandatory").removeClass("active");
});


$("body").on("click",".save-label",function(e){
    e.preventDefault();

    var labelElement = $(this).parent("div").siblings("label:first-child");
    var labelString = $(this).parent("div").siblings("label:first-child").find("input").val();
    var inputElement = $(this).parent("div").siblings("div:nth-child(2)").find("input,select,textarea");

    switch($(inputElement).attr("name"))
    {

        case "input_username":
            $(inputElement).data("label",labelString);
            $(inputElement).data("type","text");
            $(inputElement).data("value","");
            $(labelElement).html(labelString);
            $(this).hide();
            $(this).siblings("a:nth-child(2)").show();
        break;

        case "input_amount":
            $(inputElement).data("label",labelString);
            $(inputElement).data("type","text");
            $(inputElement).data("value","");
            $(labelElement).html(labelString);
            $(this).hide();
            $(this).siblings("a:nth-child(2)").show();
        break;
        case "input_email":
            $(inputElement).data("label",labelString);
            $(inputElement).data("type","email");
            $(inputElement).data("value","");
            $(labelElement).html(labelString);
            $(this).hide();
            $(this).siblings("a:nth-child(2)").show();
        break;
        case "input_mobile":
            $(inputElement).data("label",labelString);
            $(inputElement).data("type","text");
            $(inputElement).data("value","");
            $(labelElement).html(labelString);
            $(this).hide();
            $(this).siblings("a:nth-child(2)").show();
        break;

        case "input_select":
            if(addOptionToSelect(inputElement,"save")){
                $(inputElement).data("label",labelString);
                $(inputElement).data("type","select");
                $(inputElement).data("value","");
                $(inputElement).data("option",appendOptionDataToSelect(inputElement).toString());
                $(labelElement).html(labelString);
                $(this).hide();
                $(this).siblings("a:nth-child(2)").show();
            }
        break;
        case "input_textarea":
            $(inputElement).data("label",labelString);
            $(inputElement).data("type","textarea");
            $(inputElement).data("value","");
            $(labelElement).html(labelString);
            $(this).hide();
            $(this).siblings("a:nth-child(2)").show();
        break;
        case "input_text":
            $(inputElement).data("label",labelString);
            $(inputElement).data("type","text");
            $(inputElement).data("value","");
            $(labelElement).html(labelString);
            $(this).hide();
            $(this).siblings("a:nth-child(2)").show();
        break;
        case "input_date":
            $(inputElement).data("label",labelString);
            $(inputElement).data("type","date");
            $(inputElement).data("value","");
            $(labelElement).html(labelString);
            $(this).hide();
            $(this).siblings("a:nth-child(2)").show();
        break;
    }    
});


function addInputToSelect(inputElement){

    $(inputElement).data("label",labelString);
    $(inputElement).data("type","text");
    $(inputElement).data("value","");
    $(inputElement).data("option","");
}

$("body").on("click",".edit-label",function(e){
    e.preventDefault();

    var inputElement = $(this).parent("div").siblings("div:nth-child(2)").find("input,select,textarea");
    switch($(inputElement).attr("name"))
    {
        case "input_username":
            enableLabelInputToEdit(this);
        break;
        case "input_amount":
            enableLabelInputToEdit(this);
        break;
        case "input_email":
            enableLabelInputToEdit(this);
        break;
        case "input_mobile":
            enableLabelInputToEdit(this);
        break;

        case "input_select":
            enableLabelInputToEdit(this);
            enableSelectOptionToEdit(inputElement);
        break;
        case "input_textarea":
            enableLabelInputToEdit(this);
        break;
        case "input_text":
            enableLabelInputToEdit(this);
        break;
        case "input_date":
            enableLabelInputToEdit(this);
        break;   
    } 
    
});

$("body").on("keyup","input[name='input_option']",function(e){
    e.preventDefault();
    var selectDiv = $(this).parents(".input-div");
    $(selectDiv).children("div:nth-child(3)").children("a:first-child").show();
    $(selectDiv).children("div:nth-child(3)").children("a:nth-child(2)").hide();
});

$("body").on("click",".select-option-input-add-icon",function(e){
    e.preventDefault();
    var inputElement = $(this).parents(".select-option").siblings("select");
    addOptionToSelect(inputElement,"add");
});

$("body").on("click",".select-option-input-remove-icon",function(e){
    e.preventDefault();
    var inputElement = $(this).parents(".select-option-input");
    $(inputElement).remove();
});

function enableLabelInputToEdit(thisElement){

    var labelString = $(thisElement).parent("div").siblings("label").html();
    if($(labelString).hasClass("input-label"))
    {
        $(labelString).focus();

    }else{
        var labelElement = $(thisElement).parent("div").siblings("label");
        var Input = `<input type='text' class='form-control input-label' value='`+labelString+`'>`;
        $(labelElement).html(Input);
    }
}


function enableSelectOptionToEdit(thisElement){
    $(thisElement).siblings("div.select-option").show();
}



$("body").on("click",".delete-label",function(e){
    e.preventDefault();
    $(this).closest(".input-div").remove();
});

$("body").on("click",".mandatory-label",function(e){
    e.preventDefault();
    var parentElement = $(this).parent("div").parent();
    var childElement = $(parentElement).children(".payement-page-input-div").children()[0];
    console.log($(childElement).data("mandatory"));
    if($(childElement).data("mandatory")){
        
        $(this).children("i").addClass("text-default");
        $(this).children("i").removeClass("text-danger");
        $(childElement).data("mandatory",false);
    }else{
        $(this).children("i").addClass("text-danger");
        $(this).children("i").removeClass("text-default");
        $(childElement).data("mandatory",true);
        
    }
    
});

$("body").on("keyup",".input-label",function(e){
    e.preventDefault();
    $(this).parent("label").siblings("div").find("a:nth-child(2)").hide();
    $(this).parent("label").siblings("div").find("a:first-child").show();
});


$(".save-label").click(function(e){
    e.preventDefault();
    
});


$("body").on("click",".delete-label",function(e){
    e.preventDefault();
    $(this).closest(".input-div").remove();
});


$(".new-input").click(function(e){
    e.preventDefault();
    var selectedOption = $(this).val();
    AddDynamicInputToForm(selectedOption);
});


function AddDynamicInputToForm(selectedOption){

    var html = "";
    switch (selectedOption) {

        case "dropdown":
            
            html = `
            <div class="form-group row p-2 input-div">
            <label for="inputdropdown" class="col-md-4 col-form-label">Dropdown</label>
            <div class="col-md-6 payement-page-input-div">
                <select class="form-control" name="input_select" id="input_select" data-label="Dropdown" data-type="select" data-name="" data-value="" data-option="" value="" data-mandatory="false" placeholder="Dropdown" autocomplete="off" readonly></select>
                <div class='select-option'>
                </div>
                <span id="select-error"></span>
            </div>
            <div class="col-md-2 label-action">
                <a class="save-label hand-touch"  data-toggle="popover" title="Save" style="display: none;"><i class="fa fa-check text-info action-icon-save"></i></a>
                <a class="edit-label hand-touch"  data-toggle="popover" title="Edit"><i class="fa fa-pencil text-info action-icon-edit"></i></a>
                <a class="delete-label hand-touch" data-toggle="popover" title="Delete"><i class="fa fa-trash text-danger action-icon-delete"></i></a>
                <a class="mandatory-label hand-touch" data-toggle="popover" title="Mandatory"><i class="fa fa-asterisk text-default action-icon-mandatory"></i></a>
            </div>
            </div>`;
            break;

        case "textarea":
        
            html = `
            <div class="form-group row p-2 input-div"> 
            <label for="inputdropdown" class="col-md-4 col-form-label">Textarea</label>
            <div class="col-md-6 payement-page-input-div">
                <textarea class="form-control" name="input_textarea" id="input_textarea" data-label="Textarea" data-type="textarea" data-name="" data-value="" data-mandatory="false" autocomplete="off" readonly rows="1" cols="6"></textarea>
                <span id="textarea-error"></span>
            </div>
            <div class="col-md-2 label-action">
                <a class="save-label hand-touch"  data-toggle="popover" title="Save" style="display: none;"><i class="fa fa-check text-info action-icon-save"></i></a>
                <a class="edit-label hand-touch"  data-toggle="popover" title="Edit"><i class="fa fa-pencil text-info action-icon-edit"></i></a>
                <a class="delete-label hand-touch" data-toggle="popover" title="Delete"><i class="fa fa-trash text-danger action-icon-delete"></i></a>
                <a class="mandatory-label hand-touch" data-toggle="popover" title="Mandatory"><i class="fa fa-asterisk text-default action-icon-mandatory"></i></a>
            </div> 
            </div>`;
            break;
        
        case "textinput":
        
            html = `
            <div class="form-group row p-2 input-div">
            <label for="inputdropdown" class="col-md-4 col-form-label">Text</label>
            <div class="col-md-6 payement-page-input-div">
                <input type="text" class="form-control" name="input_text" id="input_text" data-label="Text" data-type="input" data-name="" data-value="" data-mandatory="false" autocomplete="off" readonly/>
                <span id="text-error"></span>
            </div>
            <div class="col-md-2 label-action">
                <a class="save-label hand-touch"  data-toggle="popover" title="Save" style="display: none;"><i class="fa fa-check text-info action-icon-save"></i></a>
                <a class="edit-label hand-touch"  data-toggle="popover" title="Edit"><i class="fa fa-pencil text-info action-icon-edit"></i></a>
                <a class="delete-label hand-touch" data-toggle="popover" title="Delete"><i class="fa fa-trash text-danger action-icon-delete"></i></a>
                <a class="mandatory-label hand-touch" data-toggle="popover" title="Mandatory"><i class="fa fa-asterisk text-default action-icon-mandatory"></i></a>
                </div>
            </div>`;
            break;


        case "date":
    
            html = `
            <div class="form-group row p-2 input-div">
            <label for="inputdropdown" class="col-md-4 col-form-label">Date</label>
            <div class="col-md-6 payement-page-input-div">
                <input type="date" class="form-control" name="input_date" id="input_date" data-label="Date" data-type="date" data-name="" data-value="" data-mandatory="false" autocomplete="off" readonly/>
                <span id="date-error"></span>
            </div>
            <div class="col-md-2 label-action">
                <a class="save-label hand-touch"  data-toggle="popover" title="Save" style="display: none;"><i class="fa fa-check text-info action-icon-save"></i></a>
                <a class="edit-label hand-touch"  data-toggle="popover" title="Edit"><i class="fa fa-pencil text-info action-icon-edit"></i></a>
                <a class="delete-label hand-touch" data-toggle="popover" title="Delete"><i class="fa fa-trash text-danger action-icon-delete"></i></a>
                <a class="mandatory-label hand-touch" data-toggle="popover" title="Mandatory"><i class="fa fa-asterisk text-default action-icon-mandatory"></i></a>
                </div>
            </div>`;
            break;
    
        default:
            break;
    }

    $(html).insertBefore(".add-new-input");
}

function addOptionToSelect(inputElement,action){

    var optionLength = $(inputElement).siblings("div.select-option").children().length;
    var optionInsertHTML = $(inputElement).siblings("div.select-option");
    var optionHTML = '';
    var optionElement = '';
    var functionReturns = false;
    if(optionLength == 0)
    {
        optionHTML=`<div class='row select-option-input'>
                    <div class="col-md-10">
                        <input type="text" class="form-control drop-input mt-1 mb-1" name="input_option" id="input_option" data-name="" data-value="" placeholder="Option" autocomplete="off">
                    </div>
                    <div class="col-md-2">
                        <div class="select-option-input-add-icon hand-touch"><i class="fa fa-plus text-info action-icon-plus"></i></div>
                    </div>
                </div>`;
    }else{
        optionHTML=`<div class='row select-option-input'>
                    <div class="col-md-10">
                        <input type="text" class="form-control drop-input mt-1 mb-1" name="input_option" id="input_option" data-name="" data-value="" placeholder="Option" autocomplete="off">
                    </div>
                    <div class="col-md-2">
                        <div class="select-option-input-add-icon hand-touch"><i class="fa fa-plus text-info action-icon-plus"></i></div>
                        <div class="select-option-input-remove-icon hand-touch"><i class="fa fa-trash text-danger action-icon-bin col-md-1"></i></div>
                    </div>
                </div>`;
    }

    if(optionLength >= 1){
        optionElement = $(optionInsertHTML).children("div.select-option-input");
        $.each(optionElement,function(index,element){
            if($(element).find("input").length > 0){
                if($(element).find("input").val() == ""){
                    $(element).find("input").focus();
                    functionReturns =  false;
                    return false;
                }else{
                    functionReturns = true;
                }
            }
        });
        if(functionReturns && action == "add"){
            $(optionInsertHTML).append(optionHTML);
        }
    }else{
        $(optionInsertHTML).append(optionHTML);
    }

    return functionReturns;
}

function appendOptionDataToSelect(inputElement){
    var optionsList = [];
    var optionInsertHTML = $(inputElement).siblings("div.select-option");
    var optionLength = $(inputElement).siblings("div.select-option").children().length;
    var optionElement = $(optionInsertHTML).children("div.select-option-input");

    $.each(optionElement,function(index,element){
        if($(element).find("input").length > 0){
            optionsList.push($(element).find("input").val())
        }
    });
    $(optionInsertHTML).hide();
    return optionsList;
}

/*Logo Icon  Code*/

$('.avatar-preview').click(function(){$('#imageUpload').trigger('click');});

$("#removeImage1").click(function(e) {
  e.preventDefault();
  $('#imagePreview').css('background-image', 'url(/images/logo-upload.png)');
  $("#imageUpload").val("");
});

function readURL(input) {
  if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
          $('#imagePreview').css('background-image', 'url('+e.target.result +')');
          $('#imagePreview').addClass('imgPre');
          $('#imagePreview').hide();
          $('#imagePreview').fadeIn(650);
      }
      reader.readAsDataURL(input.files[0]);
  }
}

$("#imageUpload").change(function() {
  readURL(this);
});
