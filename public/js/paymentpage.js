var dropdownCount = 0;
var labelEmpty = "Label Name should not be empty";
var optionEmpty = "Atleast one option should be added";
var amountEmpty = "Amount field should not be empty";
var labelAmountEmpty = "Label and Amount fields should not be empty";
var labelError = "Only aplha characters are allowed";
var amountError = "Only numeric characters are allowed";
var inputTagName = ["INPUT","SELECT","TEXTAREA"];


$(document).ready(function(){
  $('button').click(function(e){
      e.preventDefault();
  });
  calculateTotal();
});

$("#single-product-left-form").submit(function(e){
    e.preventDefault();
});

function saveActivatePage(){

  var pagename = $("input[name='page_name']").val();
   switch (pagename) {
       case 'singleproductpage':
            saveSingleProductPageLeft();
           break;
   
       default:
           break;
   }
}

function saveSingleProductPageLeft(){
    
    var pagedata = $("#page-detail").serializeArray();

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
    }else if($("input[name='input_amount']").val() == ""){
        var labelName = $("input[name='input_amount']").parent("span").siblings("span:first-child").html();
        $("#show-form-error").html("Please provide amount in "+labelName+" field");
        $("#form-error").modal({show:true,backdrop:"static",keyboard:false});
        return false;
    }
    savePageDetails("page-detail");
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


function unSavedInputFields() {
  var unsavedFields = false;
  $("span.input-label").each(function(index,object){
    if($(object).children().length == 1){
      unsavedFields = true;
    }
  });
  return unsavedFields;
}


$("#dynamic-input-detail input[name='input_amount']").keyup(function(e){
  e.preventDefault();
  calculateTotal();
});

$("body").on("keyup","#dynamic-input-detail input[name='fixed_amount']",function(e){
  e.preventDefault();
  calculateTotal();
});
$("body").on("keyup","#dynamic-input-detail input[name='item_amount']",function(e){
  e.preventDefault();
  calculateTotal();
});

function validateLabel(element){    

    var alphainput = $(element);

    var regex = /([0-9~\[\]!@#$%^&*(),.?":{}|<>_+=|{},."':;?/`-]){1}/;

    if($(element).parents(".form-inline").length > 0){
        var parentElement = $(element).parents(".form-inline");
    }

    if($(element).parents(".option-element").length > 0){
        var optionElement = $(element).parents(".option-element");
    }

    if(regex.test(alphainput.val())) 
    {
        var inputStr = alphainput.val();
        $(parentElement).siblings(".text-danger").html(labelError);
        $(optionElement).siblings(".text-danger").html(labelError);
        return alphainput.val(inputStr.replace(/([0-9~\[\]!@#$%^&*(),.?":{}|<>_+=|{},."':;?/`-]){1}/g,'').replace(/(\..*)\./g, '$1'));
    }else{
        $(parentElement).siblings(".text-danger").html("");
        $(optionElement).siblings(".text-danger").html("");
    }
}

function validateAmount(element)
{
    var alphainput = $(element);

    var regex = /^[0-9]*$/;
    if($(element).parents(".form-inline").length > 0){
        var parentElement = $(element).parents(".form-inline");
    }

    if(!regex.test(alphainput.val()))
    {
        var inputStr = alphainput.val();
        $(parentElement).siblings(".text-danger").html(amountError);
        return alphainput.val(inputStr.replace(/[^0-9]+/g,'').replace(/(\..*)\./g, '$1'));
    }else{
        $(parentElement).siblings(".text-danger").html("");
    }
}


function validateText(word){

    var regex = /([0-9~\[\]!@#$%^&*(),.?":{}|<>_+=|{},."':;?/`-]){1}/;

    var result = true;

    if(regex.test(word)) 
    {
        result = false;
    }

    return result;
}

function CustJsonObject(formdata){

  var label = [];
  var name = [];
  var inputType = [];
  var inputvalue = [];
  var optionObject = {};
  var option = [];
  var jsondata = {};

  $.each(formdata,function(index,Obj){
    if(Object.keys(Obj).length > 2){
        $.each(Obj,function(key,value){
            if(key == "label"){
                label.push(value)
                jsondata["input_label"] = label;
            }else if(key == "name"){
                name.push(value)
                jsondata["input_name"] = name;
            }else if(key == "type"){
                inputType.push(value)
                jsondata["input_type"] = inputType;
            }else if(key == "value"){
                inputvalue.push(value)
                jsondata["input_value"] = inputvalue;
            }else if(key == "option"){
                if(typeof value !== 'undefined' ){
                    option.push(value);
                    optionObject[index] = option;
                    jsondata["input_option"] = option;
                }else{
                    option.push("");
                    optionObject[index] = option;
                    jsondata["input_option"] = option;
                }   
            }
        });
        
    }
  }); 
  return jsondata;
}

function getJsonObject(formdata){
  var jsondata = {};
  $.each(formdata,function(index,Obj){
    jsondata[Obj.name] = Obj.value;
  });

  return jsondata;
}

function calculateTotal(){
    var total = 0;
    var amount = 0;
    if($("input[name='input_amount']").val() != ""){
        amount = parseInt($("input[name='input_amount']").val());
    }
     
    if($("input[name='fixed_amount']").length > 0 ){
        $("input[name='fixed_amount']").each(function(index,element){
            total=total+parseInt($(element).val());
        });
    }
    if($("input[name='item_amount']").length > 0 ){
        $("input[name='item_amount']").each(function(index,element){
            var quantity = $("input[name='item_qty']").val();
            total=total+parseInt($(element).val())*quantity;
        });
    }

    total = parseInt(amount)+parseInt(total);
    $("input[name='payment_total']").val(total);
    $("#page-total").html(total.toFixed(2));
}

function grabPageInputElements(formdata){

    var pageInputElements = [];
    var elementsCount = 0;
    $.each(formdata,function(index,element){
  
      if($.inArray($(element).prop("tagName"),inputTagName) > -1 && $(element).attr("class")!="custom-select" && $(element).attr("class")!="drop-input"){
        pageInputElements[elementsCount] = {
              "label":$(element).data("label"),
              "name":$(element).attr("name"),
              "value":$(element).val(),
              "type":$(element).prop("tagName"),
              "option":$(element).data("option")!="undefined"?$(element).data("option"):""
          }
          ++elementsCount;
      }
    });
  
    return pageInputElements;
}

//New Javascript
var defaultText = 'Name';

function endEdit(e) {
    var input = $(e.target),
        label = input && input.prev();

    label.text(input.val() === '' ? defaultText : input.val());
    input.hide();
    label.show();
}

$('.clickedit').hide()
.focusout(endEdit)
.keyup(function (e) {
    if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
        endEdit(e);
        return false;
    } else {
        return true;
    }
})
.prev().click(function () {
    $(this).hide();
    $(this).next().show().focus();
});

$("#show").click(function(){
  $(".show2").show();
});
$(".clickedit").blur(function(){
  $(".show2").hide();
});

// Email input box


var defaultTxt = 'Email';


function endEdt(e) {
    var input = $(e.target),
        label = input && input.prev();

    label.text(input.val() === '' ? defaultTxt : input.val());
    input.hide();
    label.show();
}

$('.clickedit').hide()
.focusout(endEdt)
.keyup(function (e) {
    if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
        endEdt(e);
        return false;
    } else {
        return true;
    }
})

$(document).ready(function(){

    $(".table-row1").mouseover(function(){
      $(".edit1").show();
      $(".del1").hide();

    });
    $(".table-row1").mouseout(function(){
      $(".edit1").hide();
    });
    $(".table-row2").mouseover(function(){
        $(".edit2").show();
        $(".del2").hide();
    });
    $(".table-row2").mouseout(function(){
      $(".edit2").hide();
    });
    $(".table-row3").mouseover(function(){
      $(".edit3").show();
      $(".del3").hide();
    });
    $(".table-row3").mouseout(function(){
      $(".edit3").hide();
    });

    $(".section-tr.table-roww").mouseover(function(){
      $(this).children("span.actions").show();
    });
    $(".section-tr.table-roww").mouseout(function(){
      $(this).children("span.actions").hide();
    });	

  });

 


  // =============Editable form+++++++++++++++++++++
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
  

    var actions = `<a class="add" data-toggle="popover" title="Save"><i class="fa fa-check text-success"></i></a>
                    <a class="edit" data-toggle="popover" title="Edit"><i class="fa fa-pencil text-info"></i></a>
                    <a class="delete" data-toggle="popover" title="Delete"><i class="fa fa-trash text-danger"></i></a>`;

    var inputEnableElements = ["Dropdown","Fixed Amount","Item with quantity"];
    // Append table with add row form on add new button click
    $(".add-new").click(function(){
     
      var index = $(".section-table .section-tbody .section-tr:last-child").index();
          if($.inArray($(this).html(),inputEnableElements) > -1)
          {
              switch ($(this).html()) {
                case "Fixed Amount":
                  var row = '<div class="form-group row table-roww section-tr">' +
                    '<span class="col-sm-4 input-label"><input type="text" class="form-control label-input" placeholder="Enter Amount"  id="name"></span>' +
                    '<span class="col-sm-7"><input type="text" class="form-control" name="fixed_amount" data-label="" data-option="" id="border-fixed border-tr" placeholder="To be filled by you"></span>' +
                  
                    '<span class="col-sm-1 actions">' + actions + '</span>' +
                      '</div>';
                  break;

                case "Dropdown":
                  var row = '<div class="form-group row table-roww tdContainer section-tr">' +
                    '<span class="col-sm-4 input-label"><input type="text" class="form-control label-input" placeholder="Dropdown"  id="name"></span>' +
                    '<span class="col-sm-7"><select name="input_select" id="" data-label="" class="form-control disableSelect" disabled></select></span>' +
                    '<span class="col-sm-1 actions" style="line-height:20px;">'+ actions + '<a class="addButton"></a></span>' +
                  
                    '</div>';
                  break;

                case "Item with quantity":
                  var row = '<div class="form-group row table-roww section-tr">' +
                    '<span class="col-sm-4 input-label"><input type="text" class="form-control label-input" placeholder="Enter Field"></span>' +
                    '<span class="col-sm-7"><input type="text" class="form-control" name="item_amount" data-label="" id="border-tr" placeholder="To be filled by you" value="" /><span class="range">1</span></span>' +               
                    '<span class="col-sm-1 actions">' + actions + '</span>' +
                      '</div>';
                  break;
              
                default:
                  var row = '<div class="form-group row table-attr section-tr">' +
                  '<span class="col-sm-4 input-label"><input type="text" class="form-control label-input" name="name" id="name"></span>' +
                  '<span class="col-sm-7"><input type="text" class="form-control" name="name" id="border-fixed"><input type="number" class="range" min="0" max="0" value="0"></span>' +
                 
                  '<span class="col-sm-1 actions">' + actions + '</span>' +
                    '</tr>';
                  break;
              }
          }
          else{

            switch ($(this).html()) {
              case "Textarea":
                var row = '<div class="form-group row table-roww section-tr">' +
              '<span class="col-sm-4 input-label"><input type="text" class="form-control label-input" data-label="" placeholder="Enter label" name="name" id="name"></span>' +
              '<span class="col-sm-7"><textarea name="input_textarea" class="form-control readonly2" data-label="" rows="3" readonly style="height: 37px;" placeholder="To be filled by customer"></textarea></span>'+
              '<span class="col-sm-1 actions">' + actions + '</td>' +'</tr>';
                break;

              case "Coupon":
                var row = '<div class="form-group row table-roww section-tr">' +
              '<span class="col-sm-4 input-label"><input type="text" class="form-control label-input" placeholder="Enter label"></span>' +
              '<span class="col-sm-7"><input type="text" name="input_coupon" data-label="" class="form-control readonly2" readonly placeholder="To be filled by customer"></span>' +
              '<span class="col-sm-1 actions">' + actions + '</td>' +'</tr>';
                break;

              case "Customer Amount":
                var row = '<div class="form-group row table-roww section-tr">' +
                '<span class="col-sm-4 input-label"><input type="text" class="form-control label-input" placeholder="Enter label"></span>' +
                '<span class="col-sm-7"><input type="text" name="customer_amount" data-label="" class="form-control readonly2" readonly placeholder="To be filled by customer"></span>' +
                '<span class="col-sm-1 actions">' + actions + '</td>' +'</tr>';
                break;
            
              default:
                var row = '<div class="form-group row table-roww section-tr">' +
                '<span class="col-sm-4 input-label"><input type="text" class="form-control label-input" placeholder="Enter label"></span>' +
                '<span class="col-sm-7"><input type="text" name="input_text" data-label="" class="form-control readonly2" readonly placeholder="To be filled by customer"></span>' +
                '<span class="col-sm-1 actions">' + actions + '</td>' +'</tr>';
                break;
            }
          
          }
          
        $(".section-table").append(row);
        $(".section-tr.table-roww").mouseover(function(){
          $(this).children("span.actions").show();
        });
        $(".section-tr.table-roww").mouseout(function(){
          $(this).children("span.actions").hide();
        });	
      $(".section-table .section-tbody .section-tr").eq(index + 1).find(".add, .edit").toggle();
          $('[data-toggle="tooltip"]').tooltip(); 
      });
    // Add row on add button click
    $(document).on("click", ".add", function(){

      var empty = false;
      var input = $(this).parents(".section-tr").find('input[type="text"],textarea,select');
      var isElementDropdown = $(this).siblings().length;
      if(isElementDropdown < 3)
      {
        input.each(function(index){
          if(index = 0){
            if($(this).val() == ""){
              $(this).addClass("error");
              empty = true;
            } else{
              $(this).removeClass("error");
            }
          }
        });

        $(this).parents(".section-tr").find(".error").first().focus();

      }else{

        var inputOptions = $(this).parent("span").siblings("div");
        var optionLabel = [];
        input.each(function(index){
      
          if(index == 0){
  
            if($(this).val() == ""){
              $(this).addClass("error");
                empty = true;
            } else{
              $(this).removeClass("error");
              $(this).data("label",$(this).val());
            }
          }
        });

        $(this).parents(".section-tr").find(".error").first().focus();
        if(inputOptions.length == 0 && !empty){
            addOptionstoDropdown($(this).parents(".section-tr"));
            empty = true;
        }else{

          $(inputOptions).find('input[type="text"]').each(function(){
            if($(this).val() == ""){
              $(this).addClass("error");
                empty = true;
            } else{
              $(this).removeClass("error");
              optionLabel.push($(this).val());
            }
          });
        }
        $(this).parent("span").siblings("div").find(".error").first().focus();
      }

      if(!empty){
        input.each(function(index,object){
          if(index == 0){
            $(this).parent("span").html($(this).val());
          }else{

            labelString = $(this).parents(".section-tr").children("span:first-child").html();
            $(this).data("label",labelString);
            if($(this).prop("tagName") == "SELECT"){
                $(this).data("option",optionLabel.toString());
            }
          }
        });	
        $(inputOptions).hide();		
        $(this).parents(".section-tr").find(".add, .edit").toggle();
        $(".add-new").removeAttr("disabled");
      }
      		
    });
    // Edit row on edit button click
    $(document).on("click", ".edit", function(e){
        e.preventDefault();
        var inputOptions = $(this).parent("span").siblings("div");
        
        $(this).parent("span").siblings("span:first").children("input").focus();
        if($(this).parents(".section-tr").children("span").length == 3){
          $(this).parents(".section-tr").find("span:first-child").each(function(index,element){
            $(this).html('<input type="text" class="form-control label-input" value="' + $(this).text() + '">');
          });
        }
         		
        $(this).parents(".section-tr").find(".add, .edit").toggle();
        $(".add-new").attr("disabled", "disabled");
    
        if(inputOptions.length > 0){
          $(inputOptions).show();
        }
    });
    // Delete row on delete button click
    $(document).on("click", ".delete", function(){
          $(this).parents(".section-tr").remove();
          $(".add-new").removeAttr("disabled");
          calculateTotal();
      });
  });

// Add item

function addOptionstoDropdown(element){
  var newText = $(document.createElement('div')).attr("class", 'dropdownoption');
  if($(element).children("div.dropdownoption").length == 0){
    newText.after().html('<div class="col-sm-12 float-right remove-section"><div><input type="text" placeholder="Enter option" name="inputbox" class="drop-input"><a class="fa fa-plus addButton ml-3"></a></div></div>');
  }else{
    newText.after().html('<div class="col-sm-12 float-right remove-section"><div><input type="text" placeholder="Enter option" name="inputbox" class="drop-input"><a class="fa fa-plus addButton ml-3"></a><i class="ml-3 fa fa-trash text-danger remove-btn"></i></div></div>');
  }

  newText.appendTo(element);
}

$("body").on("click",".addButton",function(){
    addOptionstoDropdown($(this).parents(".section-tr")); 
});

$("body").on("click",".remove-btn",function(){
  $(this).parents("div.dropdownoption").remove();
});


$("body").on("keyup",".label-input",function(e){
    e.preventDefault();
    var parent = $(this).closest("div");
    if($(this).val() != ""){
      labelInSaveMode(parent);
    }else{
      labelInEditMode(parent);
    }
    
});


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
  $("#dynamic_container").show();
  $(".btn-transparent2").hide();
  $("#page-detail #contactus_enable").val("Y");
});

$("#contact-us-close").click(function(e){
  e.preventDefault();
  $("#dynamic_container").hide();
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

function labelInSaveMode(parent) {
  
  $(parent).children("span:nth-child(3)").children().each(function(index,element){
      if($(element).hasClass("add")){
        $(element).css({"display":"block"});
      }
      if($(element).hasClass("edit")){
        $(element).css({"display":"none"});
      }
  });

}

function labelInEditMode(parent) {
  
  $(parent).children("span:nth-child(3)").children().each(function(index,element){
      if($(element).hasClass("add")){
        $(element).css({"display":"none"});
      }
      if($(element).hasClass("edit")){
        $(element).css({"display":"block"});
      }
  });
}


// Image Upload
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





