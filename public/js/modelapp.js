$( function(){
    var dateFormat = "yy-mm-dd",
    couponfrom = $("#coupon_validfrom")
        .datepicker({
          changeMonth: true,
          changeYear: true,
          numberOfMonths: 1,
          minDate: 0,
          "dateFormat":"yy-mm-dd"
        })
        .on( "change", function() {
            couponto.datepicker( "option", "minDate", getDate( this ));
        }),
    couponto = $( "#coupon_validto").datepicker({
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1,
        minDate: 0,
        "dateFormat":"yy-mm-dd"
      })
      .on( "change", function() {
            couponfrom.datepicker( "option", "maxDate", getDate( this ) );
      });

    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate(dateFormat,element.value );
      } catch( error ) {
        date = null;
      }

      return date;
    }

    $("#addinvoice_issue_date").datepicker({
        "dateFormat":"dd-mm-yy",
        minDate: 0,
    });

     $("#report_start_date").datepicker({
        "dateFormat":"dd-M-yy",
        // maxDate: 0,
    });

     $("#report_end_date").datepicker({
        "dateFormat":"dd-M-yy",
        maxDate: 0,
        
    });
    
    $("#paylinkadd #paylink_expiry").datepicker({
        "dateFormat":"yy-mm-dd",
        minDate: 0,
        beforeShow: function() {
            setTimeout(function(){
                $('.ui-datepicker').css('z-index', 9999);
            }, 0);
        }
        
    });

    $("#paylink-expiry").datepicker({
        "dateFormat":"yy-mm-dd",
        minDate: 0,
        beforeShow: function() {
            setTimeout(function(){
                $('.ui-datepicker').css('z-index', 9999);
            }, 0);
        }
    });


  } );


  $(function() {
    $('input[name="dash_date_range"]').daterangepicker({
      opens: 'left',
      "linkedCalendars": false,
      startDate:moment().subtract(6,'days'),
      endDate:moment(),
      maxDate: new Date(),
      ranges: {
        'Today': [moment().subtract(0, 'days'), moment().subtract(0, 'days')],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(0, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
    }, function(start, end, label) {
        $("#dashboard-form input[name='dash_date_range']").val(start.format('DD/MM/YYYY') + '-' + end.format('DD/MM/YYYY'));  
        $("#dashboard-form input[name='dash_from_date']").val(start.format('YYYY-MM-DD'));
        $("#dashboard-form input[name='dash_to_date']").val(end.format('YYYY-MM-DD'));

        var appendid = $("#dashboard-form input[name='module']").val();
        if(appendid!="dash_graph")
        {
            getDashboardData();

        }else{
            getDashboardGraph();
        }
    });
  });

  $(function() {
    $('input[name="dash_date_range_summary"]').daterangepicker({
      opens: 'left',
      "linkedCalendars": false,
      startDate:moment().subtract(6,'days'),
      endDate:moment(),
      maxDate: new Date(),
      ranges: {
        'Today': [moment().subtract(0, 'days'), moment().subtract(0, 'days')],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(0, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
    }, function(start, end, label) {
        $("#dashboard-form-summary input[name='dash_date_range_summary']").val(start.format('DD/MM/YYYY') + '-' + end.format('DD/MM/YYYY'));  
        $("#dashboard-form-summary input[name='dash_from_date']").val(start.format('YYYY-MM-DD'));
        $("#dashboard-form-summary input[name='dash_to_date']").val(end.format('YYYY-MM-DD'));

        var appendid = $("#dashboard-form-summary input[name='module']").val();
       // console.log(appendid);
        getDashboardSummary();
        // if(appendid!="dash_graph")
        // {
        //     getDashboardData();

        // }else{
        //     getDashboardGraph();
        // }
    });
  });

  $(function() {
    $('input[name="gst_report_range"]').daterangepicker({
      opens: 'left',
      "linkedCalendars": false,
      startDate:moment().subtract(6,'days'),
      endDate:moment(),
      maxDate: new Date(),
       "maxSpan": {
        "months": 1
    },
      ranges: {
        'Today': [moment().subtract(0, 'days'), moment().subtract(0, 'days')],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(0, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
    }, function(start, end, label) {
         $("#gst-report-range-form input[name='gst_report_range']").val(start.format('DD/MM/YYYY') + '-' + end.format('DD/MM/YYYY'));  
        $("#gst-report-range-form input[name='gst_report_from_date']").val(start.format('YYYY-MM-DD'));
        $("#gst-report-range-form input[name='gst_report_to_date']").val(end.format('YYYY-MM-DD'));

       getGstInvoicereport();
    });
  });
//getDashboardSummary();

  $("#paylink-expiry-calendar").click(function(e){
    e.preventDefault();
    $("#paylink_expiry").focus();
  });
 
var expirdays = [
    "<option value=''>--Select--</option>",
    "<option value='1'>1 day before expiry date</option>",
    "<option value='2'>2 days before expiry date</option>",
    "<option value='3'>3 days before expiry date</option>",
    "<option value='4'>4 days before expiry date</option>",
    "<option value='5'>5 days before expiry date</option>",
    "<option value='7'>7 days before expiry date</option>",
    "<option value='10'>10 days before expiry date</option>",
    "<option value='15'>15 days before expiry date</option>"
];

var issuedays = [
    "<option value=''>--Select--</option>",
    "<option value='1'>1 day after issued date</option>",
    "<option value='2'>2 days after issued date</option>",
    "<option value='3'>3 days after issued date</option>",
    "<option value='4'>4 days after issued date</option>",
    "<option value='5'>5 days after issued date</option>",
    "<option value='7'>7 days after issued date</option>",
    "<option value='10'>10 days after issued date</option>",
    "<option value='15'>15 days after issued date</option>"
];

var supportCategory = {"1":"Bug","2":"Complaint","3":"Change Request","4":"Query Request","5":"Spam ticked","6":"No Information"};

var feedbackSubject = {"1":"Marketing","2":"Merchant Portal","3":"Support","4":"Others"};

var selectedplwed = {};
var selectedplwoed = {};

$(".dash-fa-calendar").click(function(e){
    e.preventDefault();
    $("input[name='dash_date_range']").focus();
})
$(".dash-fa-calendar-summary").click(function(e){
    e.preventDefault();
    $("input[name='dash_date_range_summary']").focus();
})

$(".gst-fa-calendar").click(function(e){
    e.preventDefault();
    $("input[name='gst_report_range']").focus();
})

$("#dash_from_date_calend").click(function(e){
    e.preventDefault();
    $( "#dash_from_date" ).focus();
});

$("#dash_to_date_calend").click(function(e){
    e.preventDefault();
    $( "#dash_to_date" ).focus();
});

$("#addpaylinkmodal").click(function(event){
    event.preventDefault();
    $('#call-paylink-model').modal('show');
    $("#add-bulk-paylink-li").show();
    var formdata = $("#paylinkadd").serializeArray();
    $.each(formdata,function(index,element){
        $("#"+element.name+"_error").html("");
    });
    $("#paylinkadd")[0].reset();
});


$('#addpaylinkmodal').on('hidden.bs.modal', function (e) {
    location.reload();
})
  

$("#additemmodal").click(function(event){
    event.preventDefault();
    $("#itemadd")[0].reset();
    $('#call-item-model').modal('show');
});


$("[data-target='#addinvoice']").click(function(e){
    e.preventDefault();
    $("#invoice-add-form")[0].reset();
    $("#add-edit-invoice-html").html("");
});


$("#addinvoicemodal").click(function(event){
    event.preventDefault();
    optionItems();
    $('#call-invoice-modal').modal('show');
});


$("#call-invoice-generate-modal").click(function(e){
    e.preventDefault();
    $("#invoice-send-mail-message-modal").modal({show:true,backdrop:'static',keyboard:false});
});

$("#invoice-generate").click(function(e){
    e.preventDefault();
    $("#send-invoice-sms").prop("checked",false);
    $("#send-invoice-email").prop("checked",false);
    $("#invoice-send-email").val("N");
    $("#invoice-send-message").val("N");
    addInvoice('issued');
});

$("#edit-invoice-generate").click(function(e){
    e.preventDefault();
    $("#send-invoice-sms").prop("checked",false);
    $("#send-invoice-email").prop("checked",false);
    $("#invoice-send-email").val("N");
    $("#invoice-send-message").val("N");
    updateInvoice('issued');
});

function sendInvoiceSms(){
    if($("#invoice-send-message").val() == "N")
    {
        $("#invoice-send-message").val("Y");
    }else{
        $("#invoice-send-message").val("N");
    }
    
}

function sendInvoiceEmail(){
    if($("#invoice-send-email").val() == "N"){
        $("#invoice-send-email").val("Y");
    }else{
        $("#invoice-send-email").val("N");
    }
    
}

$("#new-item").click(function(event){
    event.preventDefault();
    var count = $("#new-row").children("tr").length;
    var newrow = `<tr><td><input type="text" class="form-control"  name="item_name[]" value="">
    <div id="item_name_`+(count)+`"></div></td>
    <td><input type="number" class="form-control" name="item_amount[]" value="">
    <div id="item_amount_`+(count)+`"></div></td>
    <td><Textarea class="form-control" cols=25 rows=2 name="item_description[]"></Textarea></td>
    <td><i class="fa fa-times show-cursor mandatory" onclick="removeItem(this);"></i></td></tr>`;
    $("#new-row").append(newrow);
});

$("#add-customer-call").click(function(event){
    event.preventDefault();
    $(".form-error").html("");
    $("#add-customer-form")[0].reset();
    $('#add-customer-modal').modal('show');
});


$("#call-api-modal").click(function(e){
    e.preventDefault();
    $("#api-modal").modal("show");
});

var trhighestcount = 0;
$("#invoice-add-form #add-invoice-items").click(function(event){
    event.preventDefault();
    trlength = $("#invoice-add-form #dynamic-item-list").children("tr").length+1;
    if(trlength>trhighestcount)
    {
        trhighestcount = trlength;
    }else{
        trlength = trhighestcount+1;
        trhighestcount++;
    }
    new_invoice_item_row = `<tr id='invoice_item_row`+trlength+`'>
            <td>
                <div class="col-sm-10">
                    <select name="item_name[]" id="item_name`+trlength+`" class="form-control" onchange=itemCalculate(this); data-name-id="`+trlength+`">
                    `+invoiceItemOptions.join(" ")+`
                    </select>
                </div>
            </td>
            <td>
                <div class="col-sm-10">
                    <input type="text" class="form-control input-sm only-btborder" name="item_amount[]"  id="item_amount`+trlength+`" data-amount-id="`+trlength+`" value="" placeholder="Item Price" readonly/>
                </div>
            </td>
            <td>
                <div class="col-sm-10">
                    <input type="number" class="form-control input-sm only-btborder" name="item_quantity[]"  id="item_quantity`+trlength+`" data-quantity-id="`+trlength+`" value="1" placeholder="Item Qty"/>
                </div>
            </td>
            <td>
                <div class="col-sm-10">
                    <input type="text" class="form-control input-sm only-btborder" name="item_total[]"  id="item_total`+trlength+`" data-total-id="`+trlength+`" value="" placeholder="Item Total" readonly/>
                </div>
            </td>
            <td>
                <div class="col-sm-10">
                    <i class="fa fa-times show-cursor mandatory" onclick="removeInvoiceItem(this,'`+trlength+`');"></i>
                </div>
            </td>
        </tr>`;
        $("#invoice-add-form #dynamic-item-list").append(new_invoice_item_row);
});



var tredithighestcount = $("#invoice-edit-form #dynamic-item-list").children("tr").length+1;
$("#invoice-edit-form #add-invoice-items").click(function(event){
    event.preventDefault();
    trlength = $("#invoice-edit-form #dynamic-item-list").children("tr").length+1;
    if(trlength>tredithighestcount)
    {
        tredithighestcount = trlength;
    }else{
        trlength = tredithighestcount+1;
        tredithighestcount++;
    }
    new_invoice_item_row = `<tr id='invoice_item_row`+trlength+`'>
            <td>
                <div class="col-sm-10">
                    <select name="item_name[]" id="item_name`+trlength+`" class="form-control" onchange=itemCalculate(this); data-name-id="`+trlength+`">
                    `+invoiceItemOptions.join(" ")+`
                    </select>
                </div>
            </td>
            <td>
                <div class="col-sm-10">
                    <input type="text" class="form-control input-sm only-btborder" name="item_amount[]"  id="item_amount`+trlength+`" data-amount-id="`+trlength+`" value="" placeholder="Item Price" readonly/>
                </div>
            </td>
            <td>
                <div class="col-sm-10">
                    <input type="number" class="form-control input-sm only-btborder" name="item_quantity[]"  id="item_quantity`+trlength+`" data-quantity-id="`+trlength+`" value="1" placeholder="Item Qty"/>
                </div>
            </td>
            <td>
                <div class="col-sm-10">
                    <input type="text" class="form-control input-sm only-btborder" name="item_total[]"  id="item_total`+trlength+`" data-total-id="`+trlength+`" value="" placeholder="Item Total" readonly/>
                </div>
            </td>
            <td>
                <div class="col-sm-10">
                    <i class="fa fa-times show-cursor mandatory" onclick="removeInvoiceItem(this,'`+trlength+`');"></i>
                </div>
            </td>
        </tr>`;
        $("#invoice-edit-form #dynamic-item-list").append(new_invoice_item_row);
});


function deleteCustomer(customerid)
{
    $("#delete-customer-modal").modal("show");
    $("#delete-customer-form input[name='id']").val(customerid);
}
function deleteItem(itemid)
{
    $("#deleteitemmodal").modal("show");
    $("#item-delete-form input[name='id']").val(itemid);
}



function removeItem(element)
{
    if($("#new-row").children().length>1)
    {
        $(element).closest("tr").remove();
    }
}

$(document).on("click",".pagination li a",function(event){
    event.preventDefault();
    var pathname = $(this).attr("href").substr($(this).attr("href").lastIndexOf("/")+1);
    var viewname = pathname.split("?");
    var pageid = viewname[0].split("-");
    var url = $(this).attr("href");
    if(url!="")
    {
        $.ajax({
            url:$(this).attr("href"),
            type:"GET",
            dataType:"html",
            success:function(response){
                $("#paginate_"+pageid[0]).html(response);
            },error:function()
            {
    
            }
        });
    }
});


var highestplwedcount = 0;
$("#add-plwed-options").click(function(e){
    e.preventDefault();

    var expirydayscount = $("#append-plwed-options").children().length+1;
    var expirydayslimit = $("#append-plwed-options").children().length+1;

    if(highestplwedcount < expirydayscount)
    {
        highestplwedcount = expirydayscount
    }else{
        expirydayscount = highestplwedcount+1;
        highestplwedcount++;
    }

    if(expirydayslimit < 4)
    {
        if(expirydayslimit == 3)
        {
            $("#add-plwed-options").hide();
        }
        var html = `<div id=plwed-option_`+expirydayscount+`>
                        <div class="form-group">
                            <div class="col-sm-6">
                                <select id='select-plwed-expiry-day_`+expirydayscount+`' class="form-control" name="plwed[]" onchange='plwedOption("`+expirydayscount+`")'>
                                `+expirdays.join(" ")+`
                                </select>
                            </div>
                         <i class='fa fa-remove show-cursor remove-plwed' data-row=`+expirydayscount+`></i>
                         </div>
                    </div>`;
        $("#append-plwed-options").append(html);
    }
    
});

$("#add-plwoed-options").click(function(e){
    e.preventDefault();
    var expirydayscount = $("#append-plwoed-options").children().length;

    if(expirydayscount < 3)
    {
        if(expirydayscount == 2)
        {
            $("#add-plwoed-options").hide();
        }
        var html = `<div id=plwoed-option_`+expirydayscount+`>
                    <div class="form-group">
                    <div class="col-sm-6">
                        <select id='select-plwoed-expiry-day_`+expirydayscount+`' class="form-control" name="plwoed[]" onchange='plwoedOption("`+expirydayscount+`")'>
                        `+issuedays.join(" ")+`
                        </select>
                    </div>
                    <i class='fa fa-remove show-cursor remove-plwoed' data-row=`+expirydayscount+`></i>
                </div></div>`;
        $("#append-plwoed-options").append(html);
    }
});


$("body").on("click",".remove-plwed",function(e){
    e.preventDefault();
    var rowid = $(this).attr("data-row");
    $("#plwed-option_"+rowid).remove();
    var expirydayscount = $("#append-plwed-options").children().length;
    if(expirydayscount < 3)
    {
        $("#add-plwed-options").show();
    }
});



$("body").on("click",".remove-plwoed",function(e){
    e.preventDefault();
    var rowid = $(this).attr("data-row");
    $("#plwoed-option_"+rowid).remove();
    var expirydayscount = $("#append-plwoed-options").children().length;
    if(expirydayscount < 3)
    {
        $("#add-plwoed-options").show();
    }
});

function plwedOption(id){
    var optionValue = $("#select-plwed-expiry-day_"+id).val();
    if($.inArray(optionValue,Object.values(selectedplwed)) == -1)
    {
        if(selectedplwed[id] != optionValue)
        {
            selectedplwed[id] = optionValue;
        }

    }else{

        $("#select-plwed-expiry-day_"+id).val(selectedplwed[id]);
    }
}

function plwoedOption(id){

    var optionValue = $("#select-plwoed-expiry-day_"+id).val();
     if($.inArray(optionValue,Object.values(selectedplwoed)) == -1)
    {
        if(selectedplwoed[id] != optionValue)
        {
            selectedplwoed[id] = optionValue;
        }
    }else{
        
        $("#select-plwoed-expiry-day_"+id).val(selectedplwoed[id]);
    }
}

function ChangeMyName(){

    if($('#change-phone-div').is(":hidden") && $('#dynamic-div').is(":hidden"))
    {
        $('#dynamic-name-div').toggle();
        $('#name').prop('disabled',false);
        $('#email').prop('disabled',true);
        $('#mobile_no').prop('disabled',true);
    }
    
}


function ChangeMyEmail(){

    if($('#change-phone-div').is(":hidden") && $('#dynamic-name-div').is(":hidden"))
    {
        $('#dynamic-div').toggle();
        $('#name').prop('disabled',true);
        $('#email').prop('disabled',false);
        $('#mobile_no').prop('disabled',true);
    }
    
}

function ChangeMyMobile(){
    if($('#dynamic-div').is(":hidden") && $('#dynamic-name-div').is(":hidden"))
    {
        $('#change-phone-div').toggle();
        $('#name').prop('disabled',true);
        $('#email').prop('disabled',true);
        $('#mobile_no').prop('disabled',false);
    }
}


$("#call-webhook-modal").click(function(e){
    e.preventDefault();
    $("#webhook-modal").modal({show:true});
});


$("#call-support-modal").click(function(e){
    e.preventDefault();
    $("#support-form")[0].reset();
    $("#choose_file").html("Choose a file");
    $("#support-modal").modal({show:true});
});

$("#call-feedback-modal").click(function(e){
    e.preventDefault();
    $("#feedback-form")[0].reset();
    $("#feedback-modal").modal({show:true});
});

$("#call-product-modal").click(function(e){
    e.preventDefault();
    $("#add-product-form")[0].reset();
    $("#add-product-modal").modal({show:true});
});

$("#call-quicklink-modal").click(function(e){
    e.preventDefault();
    $("#quick-link-form")[0].reset();
    $("#quick-link-modal").modal({show:true});
});

//Coupons Form Validations starts here
var saveOptionState = "";
$("#coupon_type").change(function(e){
    e.preventDefault();
    if($(this).val() != "")
    {           
        if($("#coupon_type option:selected").text() == "Free Shipping")
        {
            $("#free-shibepping-label").removeClass("display-none");
            $("#discount-of-label").addClass("display-none");
            $("#coupon-discount-of").addClass("display-none");
            saveOptionState = coupon_subtype.pop();
            $("#coupon_on").html(coupon_subtype);
            $("#coupon-specific-product-input").addClass("display-none");
            $("#coupon-order-over-input").addClass("display-none");
            $("#coupon-entire-order-input").addClass("display-none");
            $("#coupon_discount").val("");
        }else{

            if($.inArray(saveOptionState,coupon_subtype) == -1 && saveOptionState!="")
            {
                coupon_subtype.push(saveOptionState);
            }
            $("#coupon-order-over-input").addClass("display-none");
            $("#coupon-specific-product-input").addClass("display-none");
            $("#discount-of-label").removeClass("display-none");
            $("#free-shibepping-label").addClass("display-none");
            $("#coupon-discount-of").removeClass("display-none");
            $("#coupon_on").html(coupon_subtype);
            $("#coupon-order-over-input").addClass("display-none");
            $("#coupon-entire-order-input").addClass("display-none");
        }
        $("#coupon-type-tab").removeClass("display-none");    
    }else{

        $("#coupon-type-tab").addClass("display-none");
        $("#coupon-specific-product-input").addClass("display-none");
        $("#coupon-entire-order-input").addClass("display-none");
        $("#coupon-order-over-input").addClass("display-none");
    }
    
});

$("#coupon_discount").click(function(e){
    e.preventDefault();
    if($("#coupon_currency").val() == "")
    {
        $("#coupon_currency").focus();
        $("#coupon_currency_form_validation").html("Required field").css({"color":"red"});
    }
    $("#coupon_currency").click(function(){
        $("#coupon_currency_form_validation").html("")
    });
});

$("#coupon_on").click(function(e){
    e.preventDefault();
    if($("#coupon_discount").val() == "")
    {
        $("#coupon_discount").focus();
        $("#coupon_discount_form_validation").html("Required field").css({"color":"red"});
    }
    $("#coupon_discount").click(function(){
        $("#coupon_discount_form_validation").html("")
    });
});

$("#coupon-new-edit-form input[name='coupon_maxdisc_amount']").click(function(e){
    e.preventDefault();

    if($("#coupon_on option:selected").text() == "Specific Product")
    {
        if($("#coupon_onproduct").val() == "")
        {
            $("#coupon_onproduct").focus();
            $("#coupon_onproduct_form_validation").html("Required field").css({"color":"red"});
        }
        $("#coupon_onproduct").click(function(){
            $("#coupon_onproduct_form_validation").html("");
        });

    }else if($("#coupon_on option:selected").text() == "Orders Over") {

        if($("#coupon_ordermax_amount").val() == "")
        {
            $("#coupon_ordermax_amount").focus();
            $("#coupon_ordermax_amount_form_validation").html("Required field").css({"color":"red"});
        }
        $("#coupon_ordermax_amount").click(function(){
            $("#coupon_ordermax_amount_form_validation").html("");
        });
    }
   
});


$("#coupon_on").change(function(e){
    e.preventDefault();
    if($("#coupon_on option:selected").text() == "Specific Product")
    {
        $("#coupon-specific-product-input").removeClass("display-none");
        $("#coupon-entire-order-input").addClass("display-none");
        $("#coupon-order-over-input").addClass("display-none");
        getAllCouponProducts();
        $("input[name='coupon_maxdisc_amount']")[0].value="";

    }else if($("#coupon_on option:selected").text() == "Entire Order") {

        $("#coupon-entire-order-input").removeClass("display-none");
        $("#coupon-specific-product-input").addClass("display-none");
        $("#coupon-order-over-input").addClass("display-none");
        $("input[name='coupon_maxdisc_amount']")[2].value="";

    }else if($("#coupon_on option:selected").text() == "Orders Over")
    {
        $("#coupon-entire-order-input").addClass("display-none");
        $("#coupon-order-over-input").removeClass("display-none");
        $("#coupon-specific-product-input").addClass("display-none");
        $("input[name='coupon_maxdisc_amount']")[1].value="";
        $("#coupon_ordermax_amount").val("");
    }else{
        $("#coupon-specific-product-input").addClass("display-none");
        $("#coupon-entire-order-input").addClass("display-none");
        $("#coupon-order-over-input").addClass("display-none");
    }
});

$("#coupon_validfrom").click(function(e){
    e.preventDefault();
    if($("#coupon_type").val() == "")
    {
        $("#coupon_type").focus();
        $("#coupon_type_form_validation").html("Required field").css({"color":"red"});
    }
    
    $("#coupon_type").click(function(){
        $("#coupon_type_form_validation").html("");
    });
});

$("#coupon_maxuse").click(function(e){
    e.preventDefault();
    if($("#coupon_validfrom").val() == "")
    {
        $("#coupon_validfrom").focus();
        $("#coupon_validfrom_form_validation").html("Required field").css({"color":"red"});
    }
    else if($("#coupon_validto").val() == "")
    {
        $("#coupon_validto").focus();
        $("#coupon_validto_form_validation").html("Required field").css({"color":"red"});
    }

    $("#coupon_validfrom").click(function(){
        $("#coupon_validfrom_form_validation").html("");
    });

    $("#coupon_validto").click(function(){
        $("#coupon_validto_form_validation").html("");
    });
});

$("#coupon_usermaxuse").click(function(e){
    e.preventDefault();
    if($("#coupon_maxuse").val() == "")
    {
        $("#coupon_maxuse").focus();
        $("#coupon_maxuse_form_validation").html("Required field").css({"color":"red"});
    }
    $("#coupon_maxuse").click(function(){
        $("#coupon_maxuse_form_validation").html("");
    });
});

//Forget password link

//Coupons Form Validations ends here
//Dashboard Data tab click data change functionality
$("[data-target='#dash-graphs']").click(function(e){
    e.preventDefault();
    $("#dashboard-form input[name='module']").val("dash_graph");
    $("#dashboard-form input[name='dash_from_date']").val(moment().subtract(6, 'days').format('YYYY-MM-DD'));
    $("#dashboard-form input[name='dash_to_date']").val(moment().format('YYYY-MM-DD'));
    getDashboardGraph();
});

$("[data-target='#dash-payments']").click(function(e){
    e.preventDefault();
    $("#dashboard-form input[name='module']").val("dash_payment");
    getDashboardData();
});

$("[data-target='#dash-refunds']").click(function(e){
    e.preventDefault();
    $("#dashboard-form input[name='module']").val("dash_refund");
    getDashboardData();
});

$("[data-target='#dash_settlements']").click(function(e){
    e.preventDefault();
    $("#dashboard-form input[name='module']").val("dash_setllement");
    getDashboardData();
});

$("[data-target='#dash_logactivities']").click(function(e){
    e.preventDefault();
    $("#dashboard-form input[name='module']").val("dash_logactivities");
    getDashboardData();
});


//Transaction tab click data change functionality

$("[data-target='#payments']").click(function(e){
    e.preventDefault();
    getAllPayments();
    
});

$("[data-target='#refunds']").click(function(e){
    e.preventDefault();
    getAllRefunds();
});

$("[data-target='#orders']").click(function(e){
    e.preventDefault();
    getAllOrders();
});

$("[data-target='#disputes']").click(function(e){
    e.preventDefault();
    getAllDisputes();
});

//Invoice tab click data change functionality

$("[data-target='#invoices']").click(function(e){
    e.preventDefault();
    getAllInvoices();
    
});

$("[data-target='#items']").click(function(e){
    e.preventDefault();
    getAllItems();
});

$("[data-target='#addinvoice']").click(function(e){
    e.preventDefault();
    optionItems();
    optionCustomers();
});

$("[data-target='#customers']").click(function(e){
    e.preventDefault();
    getAllCustomers();
});

//Paylinks tab click data change functionality 

$("[data-target='#paylinks']").click(function(e){
    e.preventDefault();
    getAllPaylinks();
    
});

$("[data-target='#quicklinks']").click(function(e){
    e.preventDefault();
    getAllQuickLinks();
    
});


//My Account tab click data change functionlaity

$("[data-target='#notifications']").click(function(e){
    e.preventDefault();
    getAllMerchantNotifications();
    
});


$("[data-target='#messages']").click(function(e){
    e.preventDefault();
    getAllMerchantMessages();
    
});

$("[data-target='#payment-page-design']").click(function(e){
    e.preventDefault();
    getAllPageDetails();
});

$("#next-persona-info").click(function(e) { 
    e.preventDefault();
    $('[data-target="#company-info"]').tab('show');
});

$("#next-company-info").click(function(e) { 
    e.preventDefault();
    $('[data-target="#business-popup-info"]').tab('show');
});

$("#next-business-info").click(function(e) { 
    e.preventDefault();
    $('[data-target="#business-detail-info"]').tab('show');
});

$("#next-business-detail-info").click(function(e) { 
    e.preventDefault();
    getMerchantDocumentForm();
    $('[data-target="#upload-documents"]').tab('show');
});


//Document Upload function

$("[data-target='#upload-documents']").click(function(e){
    e.preventDefault();
    getMerchantDocumentForm();
});

//Payment Page javascript starts here
$("#call-product-page-index").click(function(event){
    event.preventDefault();
    $('#call-product-page-index-modal').modal({show:true,backdrop:'static',keyboard:false});
});


function singlePage(){
    $('#call-product-page-index-modal').modal('hide');
    $('#single-page-index-modal').modal({show:true,backdrop:'static',keyboard:false});
}

function multiplePage(){
    $('#call-product-page-index-modal').modal('hide');
    $('#multiple-page-index-modal').modal({show:true,backdrop:'static',keyboard:false});
}

function charityPage(){
    $('#call-product-page-index-modal').modal('hide');
    $('#charity-page-index-modal').modal({show:true,backdrop:'static',keyboard:false});
}

function goBackProductIndex(){
    $('#single-page-index-modal').modal('hide');
    $('#multiple-page-index-modal').modal('hide');
    $('#charity-page-index-modal').modal('hide');
    $('#call-product-page-index-modal').modal({show:true,backdrop:'static',keyboard:false});
}
