$(document).ready(function() {
  $.ajaxSetup({ async: true });
  formatAMPM();

});

var itemsObject = {}
var itemOptionHtml = [];
var adjustmentids = [];
var chartOptions = [];
var cardsType = ['cc', 'dc', 'nb', 'ic', 'upi'];
var perpage = 10;

var totalProdItems = 1;
var highestRowId = 0;

//Running Time Code starts here
function formatAMPM() {
  var date = new Date();
  var day = date.getDate();
  var month = date.getMonth() + 1;
  var year = date.getFullYear();
  var hours = date.getHours();
  var minutes = date.getMinutes();
  var seconds = date.getSeconds();
  var ampm = hours >= 12 ? 'PM' : 'AM';
  day = day < 10 ? '0' + day : day;
  month = month < 10 ? '0' + month : month;
  hours = hours % 12;
  hours = hours ? hours : 12; // the hour '0' should be '12'
  minutes = minutes < 10 ? '0' + minutes : minutes;
  seconds = seconds < 10 ? '0' + seconds : seconds;
  $("#nav-clock").html("<span style='color:#00a8e9'>Date:</span> " + day + "-" + month + "-" + year + " " + hours + ':' + minutes + ':' + seconds + ' ' + ampm);
  //$("#nav-clock").html(hours + ':' + minutes +' '+ ampm);
  setTimeout(formatAMPM, 500);
}
//Running Time Code ends here


// $(document).ajaxStart(function(){
//     $("div#divLoading").removeClass('hide');
//     $("div#divLoading").addClass('show');
// });

// $(document).ajaxComplete(function(){
//     $("div#divLoading").removeClass('show');
//     $("div#divLoading").addClass('hide');
// });

//Handling Session Timeout with ajax call
$(document).ajaxError(function(event, jqxhr, settings, thrownError) {
  if (jqxhr.status != 200 && jqxhr.status != 500) {
      alert("Session expired. You'll be take to the session timeout page");
      location.href = "/login";
  }
});

var timeout = 1500;
$(".sidebar-dropdown > a").click(function() {
  $(".sidebar-submenu").slideUp(250);
  if (
      $(this)
      .parent()
      .hasClass("active")
  ) {
      $(".sidebar-dropdown").removeClass("active");
      $(this)
          .parent()
          .removeClass("active");
  } else {
      $(".sidebar-dropdown").removeClass("active");
      $(this)
          .next(".sidebar-submenu")
          .slideDown(250);
      $(this)
          .parent()
          .addClass("active");
  }
});

$("#toggle-sidebar").click(function() {
  $(".page-wrapper").toggleClass("toggled");
  $("#employee-content").toggleClass("full-width");
  $("#header-seaction").toggleClass("full-width head-left");
  $("#employee-nav").toggleClass("zero-width");
});

$(function() {

  $("#date_of_birth").datepicker({
      "dateFormat": "yy-mm-dd",
      changeMonth: true,
      changeYear: true
  });

  $("#suporder_due").datepicker({
      "dateFormat": "yy-mm-dd",
      changeMonth: true,
      changeYear: true,
      minDate: 0,
  });

  $("#suporder_invdate").datepicker({
      "dateFormat": "yy-mm-dd",
      changeMonth: true,
      changeYear: true,
      minDate: 0,
  });

  $("#custorder_due").datepicker({
      "dateFormat": "yy-mm-dd",
      changeMonth: true,
      changeYear: true,
      minDate: 0,
  });

  $("#custorder_invdate").datepicker({
      "dateFormat": "yy-mm-dd",
      changeMonth: true,
      changeYear: true,
      minDate: 0,
  });

  $("#supexp_due").datepicker({
      "dateFormat": "dd/mm/yy",
      changeMonth: true,
      changeYear: true,
      minDate: 0,
  });

  $("#supexp_invdate").datepicker({
      "dateFormat": "dd/mm/yy",
      changeMonth: true,
      changeYear: true,
      minDate: 0,
  });

  $("#note_due").datepicker({
      "dateFormat": "yy-mm-dd",
      changeMonth: true,
      changeYear: true,
      minDate: 0,
  });

  $("#note_date").datepicker({
      "dateFormat": "yy-mm-dd",
      changeMonth: true,
      changeYear: true,
      minDate: 0,
  });

  $("#transaction_date").datepicker({
      "dateFormat": "yy-mm-dd",
      changeMonth: true,
      changeYear: true,
  });

  $("#porder_due").datepicker({
      "dateFormat": "yy-mm-dd",
      changeMonth: true,
      changeYear: true,
      minDate: 0,
  });

  $("#porder_date").datepicker({
      "dateFormat": "yy-mm-dd",
      changeMonth: true,
      changeYear: true,
      minDate: 0,
  });

  $("#sorder_due").datepicker({
      "dateFormat": "yy-mm-dd",
      changeMonth: true,
      changeYear: true,
      minDate: 0,
  });

  $("#sorder_date").datepicker({
      "dateFormat": "yy-mm-dd",
      changeMonth: true,
      changeYear: true,
      minDate: 0,
  });

  $("#tax_date_from").datepicker({
      "dateFormat": "yy-mm-dd",
      changeMonth: true,
      changeYear: true,
      minDate: 0,
  });

  $("#tax_date_to").datepicker({
      "dateFormat": "yy-mm-dd",
      changeMonth: true,
      changeYear: true,
      minDate: 0,
  });

  $("#adjustment_date").datepicker({
      "dateFormat": "yy-mm-dd",
      changeMonth: true,
      changeYear: true,
      minDate: 0,
  });

  $("#tax_payment_date").datepicker({
      "dateFormat": "yy-mm-dd",
      changeMonth: true,
      changeYear: true,
      minDate: 0,
  });

  $("#contra_date").datepicker({
      "dateFormat": "yy-mm-dd",
      changeMonth: true,
      changeYear: true,
      minDate: 0,
  });

  $("#sund_pay_date").datepicker({
      "dateFormat": "yy-mm-dd",
      changeMonth: true,
      changeYear: true,
      minDate: 0,
  });

  $("#batch_pay_date").datepicker({
      "dateFormat": "yy-mm-dd",
      changeMonth: true,
      changeYear: true,
      minDate: 0,
  });

  $("#receipt_date").datepicker({
      "dateFormat": "yy-mm-dd",
      changeMonth: true,
      changeYear: true,
      minDate: 0,
  });

  $("#event_date").datepicker({
      "dateFormat": "yy-mm-dd",
      changeMonth: true,
      changeYear: true,
      minDate: 0,
  });

  $("#add_voucher_date").datepicker({
      changeMonth: true,
      changeYear: true,
      minDate: 0,
      "dateFormat": "dd-mm-yy",
      beforeShow: function() {
          setTimeout(function() {
              $('.ui-datepicker').css('z-index', 9999);
          }, 0);
      }
  });

  $("#edit_voucher_date").datepicker({
      changeMonth: true,
      changeYear: true,
      minDate: 0,
      "dateFormat": "yy-mm-dd",
      beforeShow: function() {
          setTimeout(function() {
              $('.ui-datepicker').css('z-index', 9999);
          }, 0);
      }
  });

  $("#today_date").datepicker({
      "dateFormat": "yy-mm-dd",
      changeMonth: true,
      changeYear: true,
  });

  var dateFormat = "yy-mm-dd",
      from = $("#dash_from_date")
      .datepicker({
          changeMonth: true,
          changeYear: true,
          numberOfMonths: 1,
          "dateFormat": "yy-mm-dd"
      })
      .on("change", function() {
          to.datepicker("option", "minDate", getDate(this));
          getDashboardData();
      }),
      to = $("#dash_to_date").datepicker({
          changeMonth: true,
          changeYear: true,
          numberOfMonths: 1,
          "dateFormat": "yy-mm-dd"
      })
      .on("change", function() {
          from.datepicker("option", "maxDate", getDate(this));
          getDashboardData();
      });


  var dateFormat = "yy-mm-dd",
      from = $("#coupon_validfrom")
      .datepicker({
          changeMonth: true,
          changeYear: true,
          numberOfMonths: 1,
          "dateFormat": "yy-mm-dd"
      })
      .on("change", function() {
          to.datepicker("option", "minDate", getDate(this));
      }),
      to = $("#coupon_validto").datepicker({
          changeMonth: true,
          changeYear: true,
          numberOfMonths: 1,
          "dateFormat": "yy-mm-dd"
      })
      .on("change", function() {
          from.datepicker("option", "maxDate", getDate(this));
      });

  function getDate(element) {
      var date;
      try {
          date = $.datepicker.parseDate(dateFormat, element.value);
      } catch (error) {
          date = null;
      }

      return date;
  }

});

//Account javascript functionality starts here

//Purchase order functionality code starts here

$("[data-target='#purchase-order']").click(function(e) {
  e.preventDefault();
  getAllPurchaseOrders();
});


function setSupplierValues(selectElement) {
  var supplierid = selectElement.value;
  if (supplierid != "") {
      $.ajax({
          type: "GET",
          url: "/rockpay/account/purchase-order/get-supplier/" + supplierid,
          dataType: "json",
          success: function(response) {
              $.each(response[response.length - 1], function(indexInArray, valueOfElement) {
                  setFormValues('purchase-order-form', indexInArray, valueOfElement);
              });
          }
      });
  } else {
      $("#supplier_email").val("");
      $("#supplier_phone").val("");
      $("#supplier_address").val("");
      $("#supplier_company").val("");
      $("#supplier_name").val("");
  }
}

function getAllPurchaseOrders() {
  $.ajax({
      type: "GET",
      url: "/rockpay/account/payable-management/purchasae-order/get-all-purchase-order/" + perpage,
      dataType: "html",
      success: function(response) {
          $("#paginate_porders").html(response);
      }
  });
}

function getItems() {

  $.ajax({
      type: "GET",
      url: "/rockpay/account/invoice/item/get-item-options",
      dataType: "json",
      success: function(response) {

          itemOptionHtml.push('<option value="">--Select--</option>');
          $.each(response, function(index, object) {
              itemsObject[object.id] = object.item_amount;
              itemOptionHtml.push('<option value=' + object.id + '>' + object.item_name + '</option>');
          });
          $("#purchase-order-form #porder_item_name_1").html(itemOptionHtml.join(""));
          $("#sales-order-form #sorder_item_name_1").html(itemOptionHtml.join(""));
          $("#supplier-order-form #suporder_item_name_1").html(itemOptionHtml.join(""));
          $("#supplier-exp-invoice-form #supexp_item_name_1").html(itemOptionHtml.join(""));
          $("#customer-order-form #custorder_item_name_1").html(itemOptionHtml.join(""));
      }
  });
}

function setItemPrice(id, element) {
  if (Object.keys(itemsObject).length > 0) {
      $("#porder_item_price_" + id).val(itemsObject[element.value]);
  }
  loadPorderItemtotal();
}

function loadPorderNewItem() {

  var tableRowNumber = $("#porder-items").children("tr").length + 1;

  if (tableRowNumber > totalProdItems) {
      totalProdItems = tableRowNumber;
  } else {
      totalProdItems = totalProdItems + 1;
  }

  var porderItems = `<tr id="prod_item_row_` + totalProdItems + `" data-row="` + totalProdItems + `">
                    <td>` + tableRowNumber + `</td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <select name="item_id[]" id="porder_item_name_` + totalProdItems + `" class="form-control" onchange="setItemPrice('` + totalProdItems + `',this);">
                                ` + itemOptionHtml.join("") + `
                                </select>
                                <div id="porder_item_name_error_` + totalProdItems + `"></div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="text" name="item_amount[]" id="porder_item_price_` + totalProdItems + `" class="form-control" value="">
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="number" name="item_quantity[]" id="porder_item_qty_` + totalProdItems + `" class="form-control" min="1" value="1" onchange="loadPorderItemtotal();">
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="text" name="item_total[]" id="porder_item_total_` + totalProdItems + `" class="form-control" value="">
                            </div>
                        </div>                                                                
                    </td>
                    <td>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <i class="fa fa-times fa-lg text-danger show-pointer" id="porder_item_remove_` + totalProdItems + `" onclick="prodRemoveItem('` + totalProdItems + `')"></i>
                        </div>
                    </div>                                                                
                    </td>
                  </tr>`;

  $("#porder-items").append(porderItems);
}


function prodRemoveItem(rowid) {
  var rowCount = $("#porder-items").children("tr").length;
  if (rowCount > 1) {
      $("#prod_item_row_" + rowid).remove();
      loadPorderItemtotal();
  }
}

function loadPorderItemtotal() {
  var subTotal = 0;
  var tax = 0;
  $.each($("#porder-items").children("tr"), function(index, element) {
      var getRowId = $("#" + element.id).attr("data-row");
      var price = $("#porder_item_price_" + getRowId).val();
      var quantity = $("#porder_item_qty_" + getRowId).val();
      if (price != "" && quantity != "") {
          var itemTotal = parseInt(price) * parseInt(quantity);
          subTotal = subTotal + itemTotal;
          $("#porder_item_total_" + getRowId).val((Math.round(itemTotal * 100) / 100).toFixed(2));
      }
  });
  $("#purchase-order-subtotal").html(subTotal.toFixed(2));
  $("#porder_subtotal").val(subTotal);
  tax = $("#purchase-order-tax").html();
  $("#porder_tax").val("0");
  $("#purchase-order-total").html((subTotal + parseInt(tax)).toFixed(2));
  $("#porder_total").val(subTotal + parseInt(tax));
}




$("#porder_save").click(function(e) {
  e.preventDefault();
  var formdata = $("#purchase-order-form").serializeJSON();
  var formvalidate = true;
  var id = $("input[name='id']").val();

  $.each($("#porder-items").children("tr"), function(index, element) {
      if (index == 0) {
          var getRowId = $("#" + element.id).attr("data-row");
          var itemName = $("#porder_item_name_" + getRowId).val();
          var supplier = $("#supplier_id").val();
          if (supplier == "") {
              formvalidate = false;
              $("#supplier_id").focus();
              $("#supplier_id_error").html("Select atleast one Supplier to proceed").css({ "color": "red" });
              $("#supplier_id").click(function() {
                  $("#supplier_id_error").html("");
              });
          } else if (itemName == "") {
              formvalidate = false;
              $("#porder_item_name_" + getRowId).focus();
              $("#porder_item_name_error_" + getRowId).html("Select atleast one Item to proceed").css({ "color": "red" });
              $("#porder_item_name_" + getRowId).click(function() {
                  $("#porder_item_name_error_" + getRowId).html("");
              });
          }
      }

  });
  if (formvalidate && id == undefined) {
      $.ajax({
          type: "POST",
          url: "/rockpay/account/payable-management/purchase-order/new",
          data: formdata,
          dataType: "json",
          success: function(response) {
              if (response.status) {
                  $("#porder-add-response-message-modal").modal({ show: true, backdrop: 'static', keyboard: false });
                  $("#porder-add-response").html(response.message);
              }
          }
      });
  } else {

      formdata = $("#edit-purchase-order-form").serializeJSON();

      $.ajax({
          type: "POST",
          url: "/rockpay/account/payable-management/purchase-order/update",
          data: formdata,
          dataType: "json",
          success: function(response) {
              if (response.status) {
                  $("#porder-add-response-message-modal").modal({ show: true, backdrop: 'static', keyboard: false });
                  $("#porder-add-response").html(response.message);

              }
          }
      });
  }
});


//Purchase order functionality code ends here

//Supplier order functionality code starts here

$("[data-target='#order-base-supplier-invoice-booking']").click(function(e) {
  e.preventDefault();
  getAllSupOrderInvoice();
});


function setSupOrderItemPrice(id, element) {
  if (Object.keys(itemsObject).length > 0) {
      $("#suporder_item_price_" + id).val(itemsObject[element.value]);
  }
  loadSuporderItemtotal();
}

function getPurchaseOrderItems(selectElement) {
  var purchaseid = selectElement.value;
  if (purchaseid != "") {
      $.ajax({
          type: "GET",
          url: "/rockpay/account/payable-management/suporder-invoice/get-purchase-order-items/" + purchaseid,
          dataType: "html",
          success: function(response) {
              $("#suporder-items").html(response);
              loadSuporderItemtotal();
          }
      });
  } else {

  }
}

function getAllSupOrderInvoice() {
  $.ajax({
      type: "GET",
      url: "/rockpay/account/payable-management/suporder-invoice/get-all-suporder-invoice/" + perpage,
      dataType: "html",
      success: function(response) {
          $("#paginate_suporders").html(response);
      }
  });
}

function loadSuporderNewItem() {

  var tableRowNumber = $("#suporder-items").children("tr").length + 1;

  if (tableRowNumber > totalProdItems) {
      totalProdItems = tableRowNumber;
  } else {
      totalProdItems = totalProdItems + 1;
  }

  var porderItems = `<tr id="supord_item_row_` + totalProdItems + `" data-row="` + totalProdItems + `">
                    <td>` + tableRowNumber + `</td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <select name="item_id[]" id="suporder_item_name_` + totalProdItems + `" class="form-control" onchange="setSupOrderItemPrice('` + totalProdItems + `',this);">
                                ` + itemOptionHtml.join("") + `
                                </select>
                                <div id="suporder_item_name_error_` + totalProdItems + `"></div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="text" name="item_amount[]" id="suporder_item_price_` + totalProdItems + `" class="form-control" value="">
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="number" name="item_quantity[]" id="suporder_item_qty_` + totalProdItems + `" class="form-control" min="1" value="1" onchange="loadSuporderNewItem();">
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="text" name="item_total[]" id="suporder_item_total_` + totalProdItems + `" class="form-control" value="">
                            </div>
                        </div>                                                                
                    </td>
                    <td>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <i class="fa fa-times fa-lg text-danger show-pointer" id="suporder_item_remove_` + totalProdItems + `" onclick="supordRemoveItem('` + totalProdItems + `')"></i>
                        </div>
                    </div>                                                                
                    </td>
                  </tr>`;

  $("#suporder-items").append(porderItems);
}


function supordRemoveItem(rowid) {
  var rowCount = $("#suporder-items").children("tr").length;
  if (rowCount > 1) {
      $("#supord_item_row_" + rowid).remove();
      loadSuporderItemtotal();
  }
}

function loadSuporderItemtotal() {
  var subTotal = 0;
  var tax = 0;
  $.each($("#suporder-items").children("tr"), function(index, element) {
      var getRowId = $("#" + element.id).attr("data-row");
      var price = $("#suporder_item_price_" + getRowId).val();
      var quantity = $("#suporder_item_qty_" + getRowId).val();
      if (price != "" && quantity != "") {
          var itemTotal = parseInt(price) * parseInt(quantity);
          subTotal = subTotal + itemTotal;
          $("#suporder_item_total_" + getRowId).val((Math.round(itemTotal * 100) / 100).toFixed(2));
      }
  });
  $("#supplier-order-subtotal").html(subTotal.toFixed(2));
  $("#suporder_subtotal").val(subTotal);
  tax = $("#supplier-order-tax").html();
  $("#suporder_tax").val("0");
  $("#supplier-order-total").html((subTotal + parseInt(tax)).toFixed(2));
  $("#suporder_total").val(subTotal + parseInt(tax));
}

$("#suporder_save").click(function(e) {
  e.preventDefault();
  var formdata = $("#supplier-order-form").serializeJSON();
  var formvalidate = true;
  var id = $("input[name='id']").val();

  $.each($("#suporder-items").children("tr"), function(index, element) {
      if (index == 0) {
          var getRowId = $("#" + element.id).attr("data-row");
          var itemName = $("#suporder_item_name_" + getRowId).val();
          var supplier = $("#supplier_id").val();
          var porderId = $("#porder_id").val();
          if (supplier == "") {
              formvalidate = false;
              $("#supplier_id").focus();
              $("#supplier_id_error").html("Select atleast one Supplier to proceed").css({ "color": "red" });
              $("#supplier_id").click(function() {
                  $("#supplier_id_error").html("");
              });
          } else if (porderId == "") {
              formvalidate = false;
              $("#porder_id").focus();
              $("#porder_id_error").html("Select atleast one Purchase Order to proceed").css({ "color": "red" });
              $("#porder_id").click(function() {
                  $("#porder_id_error").html("");
              });
          } else if (itemName == "") {
              formvalidate = false;
              $("#suporder_item_name_" + getRowId).focus();
              $("#suporder_item_name_error_" + getRowId).html("Select atleast one Item to proceed").css({ "color": "red" });
              $("#suporder_item_name_" + getRowId).click(function() {
                  $("#suporder_item_name_error_" + getRowId).html("");
              });
          }
      }

  });
  if (formvalidate && id == undefined) {
      $.ajax({
          type: "POST",
          url: "/rockpay/account/payable-management/suporder-invoice/new",
          data: formdata,
          dataType: "json",
          success: function(response) {
              if (response.status) {
                  $("#suporder-add-response-message-modal").modal({ show: true, backdrop: 'static', keyboard: false });
                  $("#suporder-add-response").html(response.message);
              }
          }
      });
  } else {

      formdata = $("#edit-supplier-order-form").serializeJSON();

      $.ajax({
          type: "POST",
          url: "/rockpay/account/payable-management/suporder-invoice/update",
          data: formdata,
          dataType: "json",
          success: function(response) {
              if (response.status) {
                  $("#suporder-add-response-message-modal").modal({ show: true, backdrop: 'static', keyboard: false });
                  $("#suporder-add-response").html(response.message);
              }
          }
      });
  }
});


//Supplier order functionality code ends here

//Supplier Expense Invoice functionality code starts here

$("[data-target='#direct-expense-supplier-invocie-booking']").click(function(e) {
  e.preventDefault();
  getAllSupExpInvoice();
});


function setSupExpItemPrice(id, element) {
  if (Object.keys(itemsObject).length > 0) {
      $("#supexp_item_price_" + id).val(itemsObject[element.value]);
  }
  loadSupExpItemtotal();
}

function getAllSupExpInvoice(perpage = 10) {
  $.ajax({
      type: "GET",
      url: "/rockpay/account/payable-management/supexp-invoice/get-all-supexp-invoice/" + perpage,
      dataType: "html",
      success: function(response) {
          $("#paginate_supexps").html(response);
      }
  });
}

function loadSupExpNewItem() {

  var tableRowNumber = $("#supexp-items").children("tr").length + 1;

  if (tableRowNumber > totalProdItems) {
      totalProdItems = tableRowNumber;
  } else {
      totalProdItems = totalProdItems + 1;
  }

  var porderItems = `<tr id="supexp_item_row_` + totalProdItems + `" data-row="` + totalProdItems + `">
                    <td>` + tableRowNumber + `</td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <select name="item_id[]" id="supexp_item_name_` + totalProdItems + `" class="form-control" onchange="setSupExpItemPrice('` + totalProdItems + `',this);">
                                ` + itemOptionHtml.join("") + `
                                </select>
                                <div id="supexp_item_name_error_` + totalProdItems + `"></div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <select name="expense_code[]" id="expense_code_` + totalProdItems + `" class="form-control">
                                ` + chartOptions.join("") + `
                                </select>
                                <div id="expense_code_error_` + totalProdItems + `"></div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="text" name="item_amount[]" id="supexp_item_price_` + totalProdItems + `" class="form-control" value="">
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="number" name="item_quantity[]" id="supexp_item_qty_` + totalProdItems + `" class="form-control" min="1" value="1" onchange="loadSupExpItemtotal();">
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="text" name="item_total[]" id="supexp_item_total_` + totalProdItems + `" class="form-control" value="">
                            </div>
                        </div>                                                                
                    </td>
                    <td>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <i class="fa fa-times fa-lg text-danger show-pointer" id="supexp_item_remove_` + totalProdItems + `" onclick="supExpRemoveItem('` + totalProdItems + `')"></i>
                        </div>
                    </div>                                                                
                    </td>
                  </tr>`;

  $("#supexp-items").append(porderItems);
}


function supExpRemoveItem(rowid) {
  var rowCount = $("#supexp-items").children("tr").length;
  if (rowCount > 1) {

      $("#supexp_item_row_" + rowid).remove();
      loadSupExpItemtotal();
  }
}

function loadSupExpItemtotal() {
  var subTotal = 0;
  var tax = 0;
  $.each($("#supexp-items").children("tr"), function(index, element) {
      var getRowId = $("#" + element.id).attr("data-row");
      var price = $("#supexp_item_price_" + getRowId).val();
      var quantity = $("#supexp_item_qty_" + getRowId).val();
      if (price != "" && quantity != "") {
          var itemTotal = parseInt(price) * parseInt(quantity);
          subTotal = subTotal + itemTotal;
          $("#supexp_item_total_" + getRowId).val((Math.round(itemTotal * 100) / 100).toFixed(2));
      }
  });
  $("#supplier-expense-subtotal").html(subTotal.toFixed(2));
  $("#supexp_subtotal").val(subTotal);
  tax = $("#supplier-expense-tax").html();
  $("#supexp_tax").val("0");
  $("#supplier-expense-total").html((subTotal + parseInt(tax)).toFixed(2));
  $("#supexp_total").val(subTotal + parseInt(tax));
}

$("#supexp_save").click(function(e) {
  e.preventDefault();
  var formdata = $("#supplier-exp-invoice-form").serializeJSON();
  var formvalidate = true;
  var id = $("input[name='id']").val();

  $.each($("#supexp-items").children("tr"), function(index, element) {
      if (index == 0) {
          var getRowId = $("#" + element.id).attr("data-row");
          var itemName = $("#supexp_item_name_" + getRowId).val();
          var supplier = $("#supplier_id").val();
          var porderId = $("#pexp_id").val();
          if (supplier == "") {
              formvalidate = false;
              $("#supplier_id").focus();
              $("#supplier_id_error").html("Select atleast one Supplier to proceed").css({ "color": "red" });
              $("#supplier_id").click(function() {
                  $("#supplier_id_error").html("");
              });
          } else if (porderId == "") {
              formvalidate = false;
              $("#pexp_id").focus();
              $("#pexp_id_error").html("Select atleast one Purchase Order to proceed").css({ "color": "red" });
              $("#pexp_id").click(function() {
                  $("#pexp_id_error").html("");
              });
          } else if (itemName == "") {
              formvalidate = false;
              $("#supexp_item_name_" + getRowId).focus();
              $("#supexp_item_name_error_" + getRowId).html("Select atleast one Item to proceed").css({ "color": "red" });
              $("#supexp_item_name_" + getRowId).click(function() {
                  $("#supexp_item_name_error_" + getRowId).html("");
              });
          }
      }

  });
  if (formvalidate && id == undefined) {
      $.ajax({
          type: "POST",
          url: "/rockpay/account/payable-management/supexp-invoice/new",
          data: formdata,
          dataType: "json",
          success: function(response) {
              if (response.status) {
                  $("#supexp-add-response-message-modal").modal({ show: true, backdrop: 'static', keyboard: false });
                  $("#supexp-add-response").html(response.message);
              }
          }
      });
  } else {

      formdata = $("#edit-supplier-exp-form").serializeJSON();

      $.ajax({
          type: "POST",
          url: "/rockpay/account/payable-management/supexp-invoice/update",
          data: formdata,
          dataType: "json",
          success: function(response) {
              if (response.status) {
                  $("#supexp-add-response-message-modal").modal({ show: true, backdrop: 'static', keyboard: false });
                  $("#supexp-add-response").html(response.message);
              }
          }
      });
  }
});


//Supplier Expense functionality code ends here


//Supplier Credit Debit Note functionality code starts here

$("[data-target='#supplier-debit-note-credit-note-booking']").click(function(e) {
  e.preventDefault();
  getAllSupNotes();
});


// function setSupExpItemPrice(id,element){
//   if(Object.keys(itemsObject).length > 0)
//   {
//     $("#supexp_item_price_"+id).val(itemsObject[element.value]);
//   }
//   loadSupExpItemtotal();
// }

function getAllSupNotes(perpage = 10) {
  $.ajax({
      type: "GET",
      url: "/rockpay/account/payable-management/debit-note/get-all-supcd-note/" + perpage,
      dataType: "html",
      success: function(response) {
          $("#paginate_supnotes").html(response);
      }
  });
}

/*function loadSupExpNewItem(){

var tableRowNumber = $("#supexp-items").children("tr").length+1;

if(tableRowNumber > totalProdItems){
  totalProdItems = tableRowNumber;
}else{
  totalProdItems = totalProdItems+1;
}

var porderItems = `<tr id="supexp_item_row_`+totalProdItems+`" data-row="`+totalProdItems+`">
                    <td>`+tableRowNumber+`</td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <select name="item_id[]" id="supexp_item_name_`+totalProdItems+`" class="form-control" onchange="setSupExpItemPrice('`+totalProdItems+`',this);">
                                `+itemOptionHtml.join("")+`
                                </select>
                                <div id="supexp_item_name_error_`+totalProdItems+`"></div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <select name="expense_code[]" id="expense_code_`+totalProdItems+`" class="form-control">
                                `+chartOptions.join("")+`
                                </select>
                                <div id="expense_code_error_`+totalProdItems+`"></div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="text" name="item_amount[]" id="supexp_item_price_`+totalProdItems+`" class="form-control" value="">
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="number" name="item_quantity[]" id="supexp_item_qty_`+totalProdItems+`" class="form-control" min="1" value="1" onchange="loadSupExpItemtotal();">
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="text" name="item_total[]" id="supexp_item_total_`+totalProdItems+`" class="form-control" value="">
                            </div>
                        </div>                                                                
                    </td>
                    <td>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <i class="fa fa-times fa-lg text-danger show-pointer" id="supexp_item_remove_`+totalProdItems+`" onclick="supExpRemoveItem('`+totalProdItems+`')"></i>
                        </div>
                    </div>                                                                
                    </td>
                  </tr>`;

$("#supexp-items").append(porderItems);
}*/


/*function supExpRemoveItem(rowid){
var rowCount = $("#supexp-items").children("tr").length;
if(rowCount > 1){

  $("#supexp_item_row_"+rowid).remove();
  loadSupExpItemtotal();
}
}*/

/*function loadSupExpItemtotal(){
var subTotal = 0;
var tax = 0;
$.each($("#supexp-items").children("tr"),function(index,element){
  var getRowId = $("#"+element.id).attr("data-row");
  var price = $("#supexp_item_price_"+getRowId).val();
  var quantity = $("#supexp_item_qty_"+getRowId).val();
  if(price!="" && quantity!="")
  {
    var itemTotal = parseInt(price) * parseInt(quantity);
    subTotal = subTotal+itemTotal;
    $("#supexp_item_total_"+getRowId).val((Math.round(itemTotal * 100) / 100).toFixed(2));
  }
});
$("#supplier-expense-subtotal").html(subTotal.toFixed(2));
$("#supexp_subtotal").val(subTotal);
tax = $("#supplier-expense-tax").html();
$("#supexp_tax").val("0");
$("#supplier-expense-total").html((subTotal+parseInt(tax)).toFixed(2));
$("#supexp_total").val(subTotal+parseInt(tax));
}*/

$("#supplier-note-form").submit(function(e) {
  e.preventDefault();
  var supplier = $("#supplier_id").val();
  var formvalidate = true;
  var porderId = $("#pexp_id").val();
  var expenCode = $("#note_expense_code").val();
  var formdata = $(this).serializeArray();
  if (supplier == "") {
      formvalidate = false;
      $("#supplier_id").focus();
      $("#supplier_id_error").html("Select atleast one Supplier to proceed").css({ "color": "red" });
      $("#supplier_id").click(function() {
          $("#supplier_id_error").html("");
      });
  } else if (expenCode == "") {
      formvalidate = false;
      $("#note_expense_code").focus();
      $("#note_expense_code_error").html("Select atleast one expense code to proceed").css({ "color": "red" });
      $("#note_expense_code").click(function() {
          $("#note_expense_code_error").html("");
      });
  }

  if (formvalidate) {
      $.ajax({
          type: "POST",
          url: "/rockpay/account/payable-management/debit-note/new",
          data: getJsonObject(formdata),
          dataType: "json",
          success: function(response) {
              if (response.status) {
                  $("#supnote-add-response-message-modal").modal({ show: true, backdrop: 'static', keyboard: false });
                  $("#supnote-add-response").html(response.message);
              }
          }
      });
  }
});

$("#edit-supplier-note-form").submit(function(e) {
  e.preventDefault();
  var supplier = $("#supplier_id").val();
  var formvalidate = true;
  var porderId = $("#pexp_id").val();
  var expenCode = $("#note_expense_code").val();
  var formdata = $(this).serializeArray();
  if (supplier == "") {
      formvalidate = false;
      $("#supplier_id").focus();
      $("#supplier_id_error").html("Select atleast one Supplier to proceed").css({ "color": "red" });
      $("#supplier_id").click(function() {
          $("#supplier_id_error").html("");
      });
  } else if (expenCode == "") {
      formvalidate = false;
      $("#note_expense_code").focus();
      $("#note_expense_code_error").html("Select atleast one expense code to proceed").css({ "color": "red" });
      $("#note_expense_code").click(function() {
          $("#note_expense_code_error").html("");
      });
  }

  if (formvalidate) {
      $.ajax({
          type: "POST",
          url: "/rockpay/account/payable-management/debit-note/update",
          data: getJsonObject(formdata),
          dataType: "json",
          success: function(response) {
              if (response.status) {
                  $("#supnote-add-response-message-modal").modal({ show: true, backdrop: 'static', keyboard: false });
                  $("#supnote-add-response").html(response.message);
              }
          }
      });
  }
});

//Supplier Credit Debot Note functionality code ends here

//Sales order functionality code starts here

$("[data-target='#sales-order']").click(function(e) {
  e.preventDefault();
  getAllSalesOrders();
});


function setCustomerValues(selectElement) {
  var customerid = selectElement.value;
  if (customerid != "") {
      $.ajax({
          type: "GET",
          url: "/rockpay/account/receivable-management/sales-order/get-customer/" + customerid,
          dataType: "json",
          success: function(response) {
              $.each(response[response.length - 1], function(indexInArray, valueOfElement) {
                  setFormValues('sales-order-form', indexInArray, valueOfElement);
              });
          }
      });
  } else {
      $("#customer_email").val("");
      $("#customer_phone").val("");
      $("#customer_name").val("");
  }
}

function getAllSalesOrders() {
  $.ajax({
      type: "GET",
      url: "/rockpay/account/receivable-management/sales-order/get-all-sales-order/" + perpage,
      dataType: "html",
      success: function(response) {
          $("#paginate_sorders").html(response);
      }
  });
}

function setSorderItemPrice(id, element) {
  if (Object.keys(itemsObject).length > 0) {
      $("#sorder_item_price_" + id).val(itemsObject[element.value]);
  }
  loadSorderItemtotal();
}

function loadSorderNewItem() {

  var tableRowNumber = $("#sorder-items").children("tr").length + 1;

  if (tableRowNumber > totalProdItems) {
      totalProdItems = tableRowNumber;
  } else {
      totalProdItems = totalProdItems + 1;
  }

  var porderItems = `<tr id="sord_item_row_` + totalProdItems + `" data-row="` + totalProdItems + `">
                    <td>` + tableRowNumber + `</td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <select name="item_id[]" id="sorder_item_name_` + totalProdItems + `" class="form-control" onchange="setSorderItemPrice('` + totalProdItems + `',this);">
                                ` + itemOptionHtml.join("") + `
                                </select>
                                <div id="sorder_item_name_error_` + totalProdItems + `"></div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="text" name="item_amount[]" id="sorder_item_price_` + totalProdItems + `" class="form-control" value="">
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="number" name="item_quantity[]" id="sorder_item_qty_` + totalProdItems + `" class="form-control" min="1" value="1" onchange="loadSorderItemtotal();">
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="text" name="item_total[]" id="sorder_item_total_` + totalProdItems + `" class="form-control" value="">
                            </div>
                        </div>                                                                
                    </td>
                    <td>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <i class="fa fa-times fa-lg text-danger show-pointer" id="sorder_item_remove_` + totalProdItems + `" onclick="sorderdRemoveItem('` + totalProdItems + `')"></i>
                        </div>
                    </div>                                                                
                    </td>
                  </tr>`;

  $("#sorder-items").append(porderItems);
}


function sorderdRemoveItem(rowid) {
  var rowCount = $("#sorder-items").children("tr").length;
  if (rowCount > 1) {
      $("#sord_item_row_" + rowid).remove();
      loadSorderItemtotal();
  }
}

function loadSorderItemtotal() {
  var subTotal = 0;
  var tax = 0;
  $.each($("#sorder-items").children("tr"), function(index, element) {
      var getRowId = $("#" + element.id).attr("data-row");
      var price = $("#sorder_item_price_" + getRowId).val();
      var quantity = $("#sorder_item_qty_" + getRowId).val();
      if (price != "" && quantity != "") {
          var itemTotal = parseInt(price) * parseInt(quantity);
          subTotal = subTotal + itemTotal;
          $("#sorder_item_total_" + getRowId).val((Math.round(itemTotal * 100) / 100).toFixed(2));
      }
  });
  $("#sales-order-subtotal").html(subTotal.toFixed(2));
  $("#sorder_subtotal").val(subTotal);
  tax = $("#sales-order-tax").html();
  $("#sorder_tax").val("0");
  $("#sales-order-total").html((subTotal + parseInt(tax)).toFixed(2));
  $("#sorder_total").val(subTotal + parseInt(tax));
}




$("#sorder_save").click(function(e) {
  e.preventDefault();
  var formdata = $("#sales-order-form").serializeJSON();
  var formvalidate = true;
  var id = $("input[name='id']").val();

  $.each($("#sorder-items").children("tr"), function(index, element) {
      if (index == 0) {
          var getRowId = $("#" + element.id).attr("data-row");
          var itemName = $("#sorder_item_name_" + getRowId).val();
          var customer = $("#customer_id").val();
          if (customer == "") {
              formvalidate = false;
              $("#customer_id").focus();
              $("#customer_id_error").html("Select atleast one Customer to proceed").css({ "color": "red" });
              $("#customer_id").click(function() {
                  $("#customer_id_error").html("");
              });
          } else if (itemName == "") {
              formvalidate = false;
              $("#sorder_item_name_" + getRowId).focus();
              $("#sorder_item_name_error_" + getRowId).html("Select atleast one Item to proceed").css({ "color": "red" });
              $("#sorder_item_name_" + getRowId).click(function() {
                  $("#sorder_item_name_error_" + getRowId).html("");
              });
          }
      }

  });
  if (formvalidate && id == undefined) {
      $.ajax({
          type: "POST",
          url: "/rockpay/account/receivable-management/sales-order/new",
          data: formdata,
          dataType: "json",
          success: function(response) {
              if (response.status) {
                  $("#sorder-add-response-message-modal").modal({ show: true, backdrop: 'static', keyboard: false });
                  $("#sorder-add-response").html(response.message);
              }
          }
      });
  } else {

      formdata = $("#edit-sales-order-form").serializeJSON();

      $.ajax({
          type: "POST",
          url: "/rockpay/account/receivable-management/sales-order/update",
          data: formdata,
          dataType: "json",
          success: function(response) {
              if (response.status) {
                  $("#sorder-add-response-message-modal").modal({ show: true, backdrop: 'static', keyboard: false });
                  $("#sorder-add-response").html(response.message);

              }
          }
      });
  }
});


//Sales order functionality code ends here


//Customer order Sale Invoice Booking Functionality code stars here
$("[data-target='#order-base-sale-invoice-booking']").click(function(e) {
  e.preventDefault();
  getAllCustOrderInvoice();
});


function setCustOrderItemPrice(id, element) {
  if (Object.keys(itemsObject).length > 0) {
      $("#custorder_item_price_" + id).val(itemsObject[element.value]);
  }
  loadCustorderItemtotal();
}

function getSalesOrderItems(selectElement) {
  var salesorderid = selectElement.value;
  if (salesorderid != "") {
      $.ajax({
          type: "GET",
          url: "/rockpay/account/receivable-management/custorder-invoice/get-sales-order-items/" + salesorderid,
          dataType: "html",
          success: function(response) {
              $("#custorder-items").html(response);
              loadCustorderItemtotal();
          }
      });
  } else {

  }
}

function getAllCustOrderInvoice() {
  $.ajax({
      type: "GET",
      url: "/rockpay/account/receivable-management/custorder-invoice/get-all-custorder-invoice/" + perpage,
      dataType: "html",
      success: function(response) {
          $("#paginate_custorders").html(response);
      }
  });
}

function loadCustorderNewItem() {

  var tableRowNumber = $("#custorder-items").children("tr").length + 1;

  if (tableRowNumber > totalProdItems) {
      totalProdItems = tableRowNumber;
  } else {
      totalProdItems = totalProdItems + 1;
  }

  var porderItems = `<tr id="custord_item_row_` + totalProdItems + `" data-row="` + totalProdItems + `">
                    <td>` + tableRowNumber + `</td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <select name="item_id[]" id="custorder_item_name_` + totalProdItems + `" class="form-control" onchange="setCustOrderItemPrice('` + totalProdItems + `',this);">
                                ` + itemOptionHtml.join("") + `
                                </select>
                                <div id="custorder_item_name_error_` + totalProdItems + `"></div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="text" name="item_amount[]" id="custorder_item_price_` + totalProdItems + `" class="form-control" value="">
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="number" name="item_quantity[]" id="custorder_item_qty_` + totalProdItems + `" class="form-control" min="1" value="1" onchange="loadCustorderNewItem();">
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="text" name="item_total[]" id="custorder_item_total_` + totalProdItems + `" class="form-control" value="">
                            </div>
                        </div>                                                                
                    </td>
                    <td>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <i class="fa fa-times fa-lg text-danger show-pointer" id="custorder_item_remove_` + totalProdItems + `" onclick="custordRemoveItem('` + totalProdItems + `')"></i>
                        </div>
                    </div>                                                                
                    </td>
                  </tr>`;

  $("#custorder-items").append(porderItems);
}


function custordRemoveItem(rowid) {
  var rowCount = $("#custorder-items").children("tr").length;
  if (rowCount > 1) {
      $("#custord_item_row_" + rowid).remove();
      loadCustorderItemtotal();
  }
}

function loadCustorderItemtotal() {
  var subTotal = 0;
  var tax = 0;
  $.each($("#custorder-items").children("tr"), function(index, element) {
      var getRowId = $("#" + element.id).attr("data-row");
      var price = $("#custorder_item_price_" + getRowId).val();
      var quantity = $("#custorder_item_qty_" + getRowId).val();
      if (price != "" && quantity != "") {
          var itemTotal = parseInt(price) * parseInt(quantity);
          subTotal = subTotal + itemTotal;
          $("#custorder_item_total_" + getRowId).val((Math.round(itemTotal * 100) / 100).toFixed(2));
      }
  });
  $("#customer-order-subtotal").html(subTotal.toFixed(2));
  $("#custorder_subtotal").val(subTotal);
  tax = $("#customer-order-tax").html();
  $("#custorder_tax").val("0");
  $("#customer-order-total").html((subTotal + parseInt(tax)).toFixed(2));
  $("#custorder_total").val(subTotal + parseInt(tax));
}

$("#custorder_save").click(function(e) {
  e.preventDefault();
  var formdata = $("#customer-order-form").serializeJSON();
  var formvalidate = true;
  var id = $("input[name='id']").val();

  $.each($("#custorder-items").children("tr"), function(index, element) {
      if (index == 0) {
          var getRowId = $("#" + element.id).attr("data-row");
          var itemName = $("#custorder_item_name_" + getRowId).val();
          var customer = $("#customer_id").val();
          var porderId = $("#porder_id").val();
          if (customer == "") {
              formvalidate = false;
              $("#customer_id").focus();
              $("#customer_id_error").html("Select atleast one Customer to proceed").css({ "color": "red" });
              $("#customer_id").click(function() {
                  $("#customer_id_error").html("");
              });
          } else if (porderId == "") {
              formvalidate = false;
              $("#sorder_id").focus();
              $("#sorder_id_error").html("Select atleast one Sales Order to proceed").css({ "color": "red" });
              $("#sorder_id").click(function() {
                  $("#sorder_id_error").html("");
              });
          } else if (itemName == "") {
              formvalidate = false;
              $("#custorder_item_name_" + getRowId).focus();
              $("#custorder_item_name_error_" + getRowId).html("Select atleast one Item to proceed").css({ "color": "red" });
              $("#custorder_item_name_" + getRowId).click(function() {
                  $("#custorder_item_name_error_" + getRowId).html("");
              });
          }
      }

  });
  if (formvalidate && id == undefined) {
      $.ajax({
          type: "POST",
          url: "/rockpay/account/receivable-management/custorder-invoice/new",
          data: formdata,
          dataType: "json",
          success: function(response) {
              if (response.status) {
                  $("#custorder-add-response-message-modal").modal({ show: true, backdrop: 'static', keyboard: false });
                  $("#custorder-add-response").html(response.message);
              }
          }
      });
  } else {

      formdata = $("#edit-customer-order-form").serializeJSON();

      $.ajax({
          type: "POST",
          url: "/rockpay/account/receivable-management/custorder-invoice/update",
          data: formdata,
          dataType: "json",
          success: function(response) {
              if (response.status) {
                  $("#custorder-add-response-message-modal").modal({ show: true, backdrop: 'static', keyboard: false });
                  $("#custorder-add-response").html(response.message);
              }
          }
      });
  }
});

//Customer order Sale Invoice Booking Functionality code ends here


//Customer Credit Debit Note functionality code starts here

$("[data-target='#customer-debit-note-credit-note-booking']").click(function(e) {
  e.preventDefault();
  getAllCustNotes();
});

function getAllCustNotes() {
  $.ajax({
      type: "GET",
      url: "/rockpay/account/receivable-management/debit-note/get-all-custcd-note/" + perpage,
      dataType: "html",
      success: function(response) {
          $("#paginate_custnotes").html(response);
      }
  });
}

$("#customer-note-form").submit(function(e) {
  e.preventDefault();
  var customer = $("#customer_id").val();
  var formvalidate = true;
  var expenCode = $("#note_expense_code").val();
  var formdata = $(this).serializeArray();
  if (customer == "") {
      formvalidate = false;
      $("#customer_id").focus();
      $("#customer_id_error").html("Select atleast one Customer to proceed").css({ "color": "red" });
      $("#customer_id").click(function() {
          $("#customer_id_error").html("");
      });
  } else if (expenCode == "") {
      formvalidate = false;
      $("#note_expense_code").focus();
      $("#note_expense_code_error").html("Select atleast one expense code to proceed").css({ "color": "red" });
      $("#note_expense_code").click(function() {
          $("#note_expense_code_error").html("");
      });
  }

  if (formvalidate) {
      $.ajax({
          type: "POST",
          url: "/rockpay/account/receivable-management/debit-note/new",
          data: getJsonObject(formdata),
          dataType: "json",
          success: function(response) {
              if (response.status) {
                  $("#custnote-add-response-message-modal").modal({ show: true, backdrop: 'static', keyboard: false });
                  $("#custnote-add-response").html(response.message);
              }
          }
      });
  }
});

$("#edit-customer-note-form").submit(function(e) {
  e.preventDefault();
  var customer = $("#customer_id").val();
  var formvalidate = true;
  var expenCode = $("#note_expense_code").val();
  var formdata = $(this).serializeArray();
  if (customer == "") {
      formvalidate = false;
      $("#customer_id").focus();
      $("#customer_id_error").html("Select atleast one Customer to proceed").css({ "color": "red" });
      $("#customer_id").click(function() {
          $("#customer_id_error").html("");
      });
  } else if (expenCode == "") {
      formvalidate = false;
      $("#note_expense_code").focus();
      $("#note_expense_code_error").html("Select atleast one expense code to proceed").css({ "color": "red" });
      $("#note_expense_code").click(function() {
          $("#note_expense_code_error").html("");
      });
  }

  if (formvalidate) {
      $.ajax({
          type: "POST",
          url: "/rockpay/account/receivable-management/debit-note/update",
          data: getJsonObject(formdata),
          dataType: "json",
          success: function(response) {
              if (response.status) {
                  $("#custnote-add-response-message-modal").modal({ show: true, backdrop: 'static', keyboard: false });
                  $("#custnote-add-response").html(response.message);
              }
          }
      });
  }
});

//Customer Credit Debot Note functionality code ends here


//Asset add-edit-delete functionality code starts here
$("#add-asset-call").click(function(e) {
  e.preventDefault();
  $('#add-asset-modal').modal('show');
  getChartAccountOptions('add-asset-form', 'account_id');
});

$("[data-target='#asset-creation']").click(function(e) {
  e.preventDefault();
  getAllassets();
});

function getAllassets() {
  $.ajax({
      type: "GET",
      url: "/rockpay/account/fixed-asset/get-all-assets/" + perpage,
      dataType: "html",
      success: function(response) {
          $("#paginate_assets").html(response);
      }
  });
}

$("#add-asset-form").submit(function(event) {
  event.preventDefault();
  var formdata = $("#add-asset-form").serializeArray();
  $.ajax({
      url: "/rockpay/account/fixed-asset/new",
      type: "POST",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#add-asset-response-message").html(response.message).css({ "color": "green" });
              getAllassets();
          }
      },
      error: function() {},
      complete: function() {
          setTimeout(() => {
              $("#add-asset-response-message").html("");
          }, timeout);
      }
  });
});

function editAsset(assetid) {
  getChartAccountOptions('update-asset-form', 'account_id');
  $("#edit-asset-modal #edit-asset-response-message").html("");
  if (assetid != "") {
      $.ajax({
          url: "/rockpay/account/fixed-asset/edit/" + assetid,
          type: "GET",
          dataType: "json",
          success: function(response) {
              if (response.length > 0) {
                  $.each(response[response.length - 1], function(key, value) {
                      setFormValues('update-asset-form', key, value);
                      //$("#update-asset-form input[name="+key+"]").val(value);
                  });

                  $("#edit-asset-modal").modal("show");
              }
          },
          error: function() {},
          complete: function() {

          }
      });
  }
}

$("#update-asset-form").submit(function(e) {
  e.preventDefault();
  var formdata = $("#update-asset-form").serializeArray();

  $.ajax({
      url: "/rockpay/account/fixed-asset/update",
      type: "POST",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#edit-asset-modal #edit-asset-response-message").html(response.message).css({ "color": "green" });
              getAllassets();
          }
      },
      error: function() {},
      complete: function() {
          setTimeout(() => {
              $("#edit-asset-modal #edit-asset-response-message").html("");
          }, timeout);

      }
  })
});


//Asset add-edit-delete functionality code ends here

//Capital Asset add-edit-delete functionality code starts here
//Asset add-edit-delete functionality code starts here
$("#add-capital-asset-call").click(function(e) {
  e.preventDefault();
  $("#add-capital-asset-form")[0].reset();
  $('#add-capital-asset-modal').modal('show');
  //getChartAccountOptions('add-asset-form','account_id');
});

$("[data-target='#asset-capitalization']").click(function(e) {
  e.preventDefault();
  getAllCapitalassets();
});

function getAllCapitalassets() {
  $.ajax({
      type: "GET",
      url: "/rockpay/account/fixed-asset/get-all-capital-assets/" + perpage,
      dataType: "html",
      success: function(response) {
          $("#paginate_capitalassets").html(response);
      }
  });
}

function getAssetInfo(Object, formid) {
  var assetid = $(Object).val();
  if (assetid != "") {
      $.ajax({
          url: "/rockpay/account/fixed-asset/edit/" + assetid,
          type: "GET",
          dataType: "json",
          success: function(response) {
              if (response.length > 0) {
                  $.each(response[response.length - 1], function(key, value) {
                      setFormValues(formid, key, value);
                      //$("#update-asset-form input[name="+key+"]").val(value);
                  });
              }
          },
          error: function() {},
          complete: function() {

          }
      });
  }
}

$("#add-capital-asset-form").submit(function(event) {
  event.preventDefault();
  var formdata = $("#add-capital-asset-form").serializeArray();
  $.ajax({
      url: "/rockpay/account/fixed-asset/capital/update",
      type: "POST",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#add-capital-asset-response-message").html(response.message).css({ "color": "green" });
              getAllCapitalassets();
          }
      },
      error: function() {},
      complete: function() {
          setTimeout(() => {
              $("#add-capital-asset-response-message").html("");
          }, timeout);
      }
  });
});


$("#add-depreciate-asset-call").click(function(e) {
  e.preventDefault();
  $("#add-depreciate-asset-form")[0].reset();
  $('#add-depreciate-asset-modal').modal('show');
});

$("[data-target='#process-depreciation']").click(function(e) {
  e.preventDefault();
  getAllDepreciateassets();
});

function getAllDepreciateassets() {
  $.ajax({
      type: "GET",
      url: "/rockpay/account/fixed-asset/get-all-depreciate-assets/" + perpage,
      dataType: "html",
      success: function(response) {
          $("#paginate_depreciateassets").html(response);
      }
  });
}


$("#add-depreciate-asset-form").submit(function(event) {
  event.preventDefault();
  var formdata = $("#add-depreciate-asset-form").serializeArray();
  $.ajax({
      url: "/rockpay/account/fixed-asset/depreciate/update",
      type: "POST",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#add-depreciate-asset-response-message").html(response.message).css({ "color": "green" });
              getAllDepreciateassets();
          }
      },
      error: function() {},
      complete: function() {
          setTimeout(() => {
              $("#add-depreciate-asset-response-message").html("");
          }, timeout);
      }
  });
});

$("#add-sale-asset-call").click(function(e) {
  e.preventDefault();
  $("#add-sale-asset-form")[0].reset();
  $('#add-sale-asset-modal').modal('show');
});

$("[data-target='#sale-of-asset']").click(function(e) {
  e.preventDefault();
  getAllSaleassets();
});

function getAllSaleassets() {
  $.ajax({
      type: "GET",
      url: "/rockpay/account/fixed-asset/get-all-sale-assets/" + perpage,
      dataType: "html",
      success: function(response) {
          $("#paginate_saleassets").html(response);
      }
  });
}

$("#add-sale-asset-form").submit(function(event) {
  event.preventDefault();
  var formdata = $("#add-sale-asset-form").serializeArray();
  $.ajax({
      url: "/rockpay/account/fixed-asset/sale/update",
      type: "POST",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#add-sale-asset-response-message").html(response.message).css({ "color": "green" });
              getAllSaleassets();
          }
      },
      error: function() {},
      complete: function() {
          setTimeout(() => {
              $("#add-sale-asset-response-message").html("");
          }, timeout);
      }
  });
});
//Capital Asset add-edit-delete functionality code ends here

//Global Tax add-edit-delete functionality code starts here

$("[data-target='#tax-settlement']").click(function(e) {
  e.preventDefault();
  getAllTaxSettlement();
});

function getAllTaxSettlement() {
  $.ajax({
      type: "GET",
      url: "/rockpay/account/global-taxation-solution/tax-settlement/get/" + perpage,
      dataType: "html",
      success: function(response) {
          $("#paginate_taxsettlements").html(response);
      }
  });
}



$("[data-target='#tax-adjustment']").click(function(e) {
  e.preventDefault();
  getAllTaxAdjustment();
});

function getAllTaxAdjustment() {
  $.ajax({
      type: "GET",
      url: "/rockpay/account/global-taxation-solution/tax-adjustment/get/" + perpage,
      dataType: "html",
      success: function(response) {
          $("#paginate_taxadjustments").html(response);
      }
  });
}
$("[data-target='#tax-payment']").click(function(e) {
  e.preventDefault();
  getAllTaxPayment();
});

function getAllTaxPayment() {
  $.ajax({
      type: "GET",
      url: "/rockpay/account/global-taxation-solution/tax-payment/get/" + perpage,
      dataType: "html",
      success: function(response) {
          $("#paginate_taxpayments").html(response);
      }
  });
}





$("#tax-settlement-form").submit(function(e) {
  e.preventDefault();
  var formdata = $(this).serializeArray();
  $.ajax({
      type: "POST",
      url: "/rockpay/account/global-taxation-solution/tax-settlement/new",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {

              $("#tax-settlement-success-response").html(response.message);
              $("#tax-settlement-response-message-modal").modal({
                  show: true,
                  backdrop: 'static',
                  keyboard: false
              });
          } else {
              $("#tax-settlement-failed-response").html(response.message);
              $("#tax-settlement-response-message-modal").modal({
                  show: true,
                  backdrop: 'static',
                  keyboard: false
              });
          }
      }
  });
});

$("#tax-adjustment-form").submit(function(e) {
  e.preventDefault();
  var formdata = $(this).serializeArray();
  $.ajax({
      type: "POST",
      url: "/rockpay/account/global-taxation-solution/tax-adjustment/new",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {

              $("#tax-adjustment-success-response").html(response.message);
              $("#tax-adjustment-response-message-modal").modal({
                  show: true,
                  backdrop: 'static',
                  keyboard: false
              });
          } else {
              $("#tax-adjustment-failed-response").html(response.message);
              $("#tax-adjustment-response-message-modal").modal({
                  show: true,
                  backdrop: 'static',
                  keyboard: false
              });
          }
      }
  });
});

$("#tax-payment-form").submit(function(e) {
  e.preventDefault();
  var formdata = $(this).serializeArray();
  $.ajax({
      type: "POST",
      url: "/rockpay/account/global-taxation-solution/tax-payment/new",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#tax-payment-success-response").html(response.message);
              $("#tax-payment-response-message-modal").modal({
                  show: true,
                  backdrop: 'static',
                  keyboard: false
              });
          } else {
              $("#tax-settlement-failed-response").html(response.message);
              $("#tax-payment-response-message-modal").modal({
                  show: true,
                  backdrop: 'static',
                  keyboard: false
              });
          }
      }
  });
});

//Global Tax add-edit-delete functionality code ends here

//Voucher add-edit-functionality code starts here

$("[data-target='#general-voucher-entries']").click(function(e) {
  e.preventDefault();
  getAllVouchers();
});

$("#add-voucher-call").click(function(e) {
  e.preventDefault();
  $("#add-voucher-form")[0].reset();
  $('#add-voucher-modal').modal('show');
});

function getAllVouchers() {
  $.ajax({
      type: "GET",
      url: "/rockpay/account/vouchers/get-all-vouchers/" + perpage,
      dataType: "html",
      success: function(response) {
          $("#paginate_vouchers").html(response);
      }
  });
}

$("#add-voucher-form").submit(function(event) {
  event.preventDefault();
  var formdata = $("#add-voucher-form").serializeArray();
  $.ajax({
      url: "/rockpay/account/voucher/new",
      type: "POST",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#add-voucher-response-message").html(response.message).css({ "color": "green" });
              getAllVouchers();
          }
      },
      error: function() {},
      complete: function() {
          setTimeout(() => {
              $("#add-voucher-response-message").html("");
          }, timeout);
      }
  });
});

function editVoucher(voucherid) {
  if (voucherid != "") {
      $.ajax({
          url: "/rockpay/account/voucher/edit/" + voucherid,
          type: "GET",
          dataType: "json",
          success: function(response) {
              if (response.length > 0) {
                  $.each(response[response.length - 1], function(key, value) {
                      setFormValues('update-voucher-form', key, value);
                      //$("#update-asset-form input[name="+key+"]").val(value);
                  });
                  $("#edit-voucher-modal").modal("show");
              }
          },
          error: function() {},
          complete: function() {

          }
      });
  }
}

$("#update-voucher-form").submit(function(event) {
  event.preventDefault();
  var formdata = $("#update-voucher-form").serializeArray();
  $.ajax({
      url: "/rockpay/account/voucher/update",
      type: "POST",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#edit-voucher-response-message").html(response.message).css({ "color": "green" });
              getAllVouchers();
          }
      },
      error: function() {},
      complete: function() {
          setTimeout(() => {
              $("#edit-voucher-response-message").html("");
          }, timeout);
      }
  });
});

//voucher add-edit-functionality code ends here



function getAllChartAccount() {
  $.ajax({
      type: "GET",
      url: "/rockpay/account/charts-account/get-chart/" + perpage,
      dataType: "html",
      success: function(response) {
          $("#paginate_accountcharts").html(response);
      }
  });
}

//Invoice Invoices add-edit functionality starts here
$("[data-target='#invoices']").click(function(e) {
  e.preventDefault();
  getAllInvoices();
});

function getAllInvoices() {
  $.ajax({
      type: "GET",
      url: "/rockpay/account/invoice/invoices/get-all-invoices/" + perpage,
      dataType: "html",
      success: function(response) {
          $("#paginate_invoices").html(response);
      }
  });
}
var itemOject = {};
var invoiceItemOptions = [];
var invoiceselectedAddress = {};

//Get All Items function starts
function optionItems() {
  invoiceItemOptions = [];
  $.ajax({
      url: "/rockpay/account/invoice/invoices/get-all-items-options",
      type: "GET",
      dataType: "json",
      success: function(response) {
          var html = '';
          invoiceItemOptions.push(`<option value=''>Select Item</option>`);
          $.each(response, function(index, value) {
              invoiceItemOptions.push(`<option value='` + value.id + `'>` + value.item_name + `</option>`);
              itemOject[value.id] = value.item_amount;
          });
          $("#invoice-add-form #item_name1").html(invoiceItemOptions.join(" "));
      },
      error: function(error) {

      },
      complete: function() {}
  });
  return true;
}
//Get All Customer starts
function optionCustomers(option = "") {
  invoiceCustomers = [];
  var tablehtml = '';
  var customer_id = "";
  $.ajax({
      url: "/rockpay/account/invoice/invoices/get-all-customer-options",
      type: "GET",
      dataType: "json",
      success: function(response) {

          invoiceCustomers.push("<option value=''>--Select--</option>");
          $.each(response, function(index, value) {
              if (option != "") {
                  invoiceCustomers.push("<option value=" + value.id + " selected>" + value.customer_name + "</option>");
                  customer_id = value.id;
              } else {
                  invoiceCustomers.push("<option value=" + value.id + ">" + value.customer_name + "</option>");
              }
              tablehtml += "<tr>";
              tablehtml += "<td>" + (index + 1) + "</td>";
              tablehtml += "<td><a href=javascript:editCustomer('" + value.id + "')>" + value.customer_gid + "</a></td>";
              tablehtml += "<td>" + value.customer_name + "</td>";
              tablehtml += "<td>" + value.customer_email + "</td>";
              tablehtml += "<td>" + value.customer_phone + "</td>";
              tablehtml += "<td>" + value.status + "</td>";
              tablehtml += "<td>" + value.created_date + "</td>";
              tablehtml += "<td><a href=javascript:deleteCustomer('" + value.id + "') class='btn btn-danger btn-xs'>Delete</a></td>";
              tablehtml += "</tr>";
          });
          //invoiceCustomers.push("<option value='new'>+Create New Customer</option>");
          $("#invoice-add-form #invoice_billing_to").html(invoiceCustomers.join(" "));
          //$("#invoice-edit-form #invoice_billing_to").html(invoiceCustomers.join(" "));
      },
      error: function(error) {

      },
      complete: function() {
          if (option != "") {
              getCustomerAddress(customer_id, "invoice-add-form");
          }
          $("#customertable").html(tablehtml);
      }
  });
}
//Get All Customer Ends

//Calculating Invoce Items starts
function itemCalculate(element) {

  var rowid = $(element).attr("data-name-id");
  var item_amount = itemOject[$(element).val()];
  var item_quantity = $("#item_quantity" + rowid).val();

  var subtotal = 0;
  var invoicetax = 0;
  var taxpercentage = 0;

  if ($(element).val() != "") {
      $("#item_amount" + rowid).val(item_amount);
      $("#item_total" + rowid).val(item_amount * item_quantity);

      //subtotal code starts here

      $("input[name='item_total[]']").each(function(index, element) {
          if (element.value != "") {
              subtotal += parseInt(element.value);
          }
      });

      //subtotal code ends here
      $("#invoice_subtotal").val(subtotal);
      $("#invoice_tax_amount").val(calculateTax(subtotal));
      $("#invoice_amount").val(subtotal + calculateTax(subtotal));
  } else {

      $("#item_amount" + rowid).val("");
      $("#item_total" + rowid).val("");

      $("#invoice_subtotal").val("");
      $("#invoice_tax_amount").val("");
      $("#invoice_amount").val("");
  }


}
//Calculating Invoce Items ends
//Calculate Invoice Items tax code starts

function calculateTax(subtotal) {
  if ($("input[name='customer_state']").val() == $("input[name='merchant_state']").val()) {
      taxpercentage = $("#inner_state").val();
      invoicetax = subtotal * (taxpercentage / 100);
      $("#tax-variable").html("CGST+SGST");
      $("#tax_applied").val("CGST+SGST")

  } else {
      taxpercentage = $("#outer_state").val();
      invoicetax = subtotal * (taxpercentage / 100);
      $("#tax-variable").html("IGST");
      $("#tax_applied").val("IGST")
  }

  return invoicetax;
}
//Calculate Invoice Items taxt code ends 
//Invoice Items Quantity change code starts
$("body").on("input change keyup", "input[name='item_quantity[]']", function(event) {
  event.preventDefault();
  var rowid = $(this).attr("data-quantity-id");
  var itemquantity = $(this).val();
  if (itemquantity > 0) {
      var itemamount = $("#item_amount" + rowid).val();
      var itemtotal = itemquantity * itemamount;
      var subtotal = 0;
      var invoicetax = 0;
      $("input[name='item_total[]']").each(function(index, element) {
          subtotal += parseInt(element.value);
      });

      $("#item_total" + rowid).val(itemtotal);
      $("#invoice_subtotal").val(subtotal);
      $("#invoice_tax_amount").val(calculateTax(subtotal));
      $("#invoice_amount").val(subtotal + calculateTax(subtotal));

  } else {
      $(this).val(1);
  }

});
//Invoice Items Quantity change code ends

var trhighestcount = 0;
$("#invoice-add-form #add-invoice-items").click(function(event) {
  event.preventDefault();
  trlength = $("#invoice-add-form #dynamic-item-list").children("tr").length + 1;
  if (trlength > trhighestcount) {
      trhighestcount = trlength;
  } else {
      trlength = trhighestcount + 1;
      trhighestcount++;
  }
  new_invoice_item_row = `<tr id='invoice_item_row` + trlength + `'>
        <td>
            <div class="col-sm-10">
                <select name="item_name[]" id="item_name` + trlength + `" class="form-control" onchange=itemCalculate(this); data-name-id="` + trlength + `">
                ` + invoiceItemOptions.join(" ") + `
                </select>
            </div>
        </td>
        <td>
            <div class="col-sm-10">
                <input type="text" class="form-control input-sm only-btborder" name="item_amount[]"  id="item_amount` + trlength + `" data-amount-id="` + trlength + `" value="" placeholder="Item Price" readonly/>
            </div>
        </td>
        <td>
            <div class="col-sm-10">
                <input type="number" class="form-control input-sm only-btborder" name="item_quantity[]"  id="item_quantity` + trlength + `" data-quantity-id="` + trlength + `" value="1" placeholder="Item Qty"/>
            </div>
        </td>
        <td>
            <div class="col-sm-10">
                <input type="text" class="form-control input-sm only-btborder" name="item_total[]"  id="item_total` + trlength + `" data-total-id="` + trlength + `" value="" placeholder="Item Total" readonly/>
            </div>
        </td>
        <td>
            <div class="col-sm-10">
                <i class="fa fa-times show-pointer mandatory" onclick="removeInvoiceItem(this,'` + trlength + `');"></i>
            </div>
        </td>
    </tr>`;
  $("#invoice-add-form #dynamic-item-list").append(new_invoice_item_row);
});

//Remove Invoice Items starts
function removeInvoiceItem(element, id) {

  if ($("#dynamic-item-list").children().length > 1) {
      $("#invoice_item_row" + id).remove();
      var subtotal = 0;
      $("input[name='item_total[]']").each(function(index, element) {
          if (element.value != "") {
              subtotal += parseInt(element.value);
          }
      });
      $("#invoice_subtotal").val(subtotal);
      $("#invoice_tax_amount").val(calculateTax(subtotal));
      $("#invoice_amount").val(subtotal + calculateTax(subtotal));
  }

}

//Remove Invoice Items ends
var tredithighestcount = $("#invoice-edit-form #dynamic-item-list").children("tr").length + 1;
$("#invoice-edit-form #add-invoice-items").click(function(event) {
  event.preventDefault();
  trlength = $("#invoice-edit-form #dynamic-item-list").children("tr").length + 1;
  if (trlength > tredithighestcount) {
      tredithighestcount = trlength;
  } else {
      trlength = tredithighestcount + 1;
      tredithighestcount++;
  }
  new_invoice_item_row = `<tr id='invoice_item_row` + trlength + `'>
        <td>
            <div class="col-sm-10">
                <select name="item_name[]" id="item_name` + trlength + `" class="form-control" onchange=itemCalculate(this); data-name-id="` + trlength + `">
                ` + invoiceItemOptions.join(" ") + `
                </select>
            </div>
        </td>
        <td>
            <div class="col-sm-10">
                <input type="text" class="form-control input-sm only-btborder" name="item_amount[]"  id="item_amount` + trlength + `" data-amount-id="` + trlength + `" value="" placeholder="Item Price" readonly/>
            </div>
        </td>
        <td>
            <div class="col-sm-10">
                <input type="number" class="form-control input-sm only-btborder" name="item_quantity[]"  id="item_quantity` + trlength + `" data-quantity-id="` + trlength + `" value="1" placeholder="Item Qty"/>
            </div>
        </td>
        <td>
            <div class="col-sm-10">
                <input type="text" class="form-control input-sm only-btborder" name="item_total[]"  id="item_total` + trlength + `" data-total-id="` + trlength + `" value="" placeholder="Item Total" readonly/>
            </div>
        </td>
        <td>
            <div class="col-sm-10">
                <i class="fa fa-times show-pointer mandatory" onclick="removeInvoiceItem(this,'` + trlength + `');"></i>
            </div>
        </td>
    </tr>`;
  $("#invoice-edit-form #dynamic-item-list").append(new_invoice_item_row);
});
//Invoice Customer select functionality starts
$("#invoice-add-form #invoice_billing_to").on("change", function(event) {
  event.preventDefault();
  var customerid = $(this).val();
  customerAddress = [];
  if (customerid != "" && customerid != "new") {
      getCustomerAddress(customerid, "invoice-add-form");

  } else if (customerid == "new") {
      $('#add-customer-modal').modal({ show: true, keyboard: false, backdrop: 'static' });
      $(this).val("");
  } else {

      $("#invoice-add-form #customer_gstno").val("");
      $("#invoice-add-form #customer_email").val("");
      $("#invoice-add-form #customer_phone").val("");
      $("#invoice_billing_address").html("<option value=''>Select Bill Address</option>");
      $("#invoice_shipping_address").html("<option value=''>Select Ship Address</option>");
  }


});

$("#invoice-edit-form #invoice_billing_address").change(function(event) {
  event.preventDefault();
  if ($(this).val() == "new_address") {
      $("#add-customer-address-modal").modal({ show: true, backdrop: 'static', keyboard: false });
      $(this).val("");
  } else if ($(this).val() == "new_edit_address") {
      var customerid = $("#invoice_billing_to").val();
      AddEditCustomerAddress(customerid);
      $("#add-edit-customer-address-modal").modal({ show: true, backdrop: 'static', keyboard: false });
      $(this).val("");
  } else {
      $("#invoice-edit-form input[name='customer_state']").val(invoiceselectedAddress[$(this).val()]);
  }
});

//Retrieve Customer Address functionality starts

function getCustomerAddress(customerid, formid) {
  customerAddress = [];
  $.ajax({
      url: "/rockpay/account/invoice/invoice/get-customer-info/" + customerid,
      type: "GET",
      dataType: "json",
      success: function(response) {
          if (response.info.length > 0) {
              $.each(response.info[response.info.length - 1], function(index, object) {
                  $("input[name=" + index + "]").val(object);
              });
          }
          customerAddress.push("<option value=''>--Select--</option>");
          if (response.address.length > 0) {
              $.each(response.address, function(index, object) {
                  customerAddress.push("<option value=" + object.id + ">" + object.address + "</option>");
                  invoiceselectedAddress[object.id] = object.state_id;
              });
              customerAddress.push("<option value=new_edit_address>Add/Edit</option>")

          } else {
              customerAddress.push("<option value='new_address'>+add new</option>");
          }
          $("#invoice_billing_address").html(customerAddress.join(" "));
          $("#invoice_shipping_address").html(customerAddress.join(" "));
      },
      error: function(error) {

      },
      complete: function() {
          $("#add-customer-address-form #customer_id").val(customerid);
      }
  });
}

$("#invoice-add-form #invoice_billing_address").change(function(event) {
  event.preventDefault();
  if ($(this).val() == "new_address") {
      $("#add-customer-address-modal").modal({ show: true, backdrop: 'static', keyboard: false });
      $(this).val("");
  } else if ($(this).val() == "new_edit_address") {
      var customerid = $("#invoice_billing_to").val();
      AddEditCustomerAddress(customerid);
      $("#add-edit-customer-address-modal").modal({ show: true, backdrop: 'static', keyboard: false });
      $(this).val("");
  } else {

      $("#invoice-add-form input[name='customer_state']").val(invoiceselectedAddress[$(this).val()]);
  }

});

function AddEditCustomerAddress(customerid) {
  var tablehtml = "";
  customerAddress = [];
  $("#add-edit-customer-address-form")[0].reset();
  $.ajax({
      url: "/rockpay/account/invoice/invoice/get-customer-info/" + customerid,
      type: "GET",
      dataType: "json",
      success: function(response) {
          if (response.address.length > 0) {
              $.each(response.address, function(key, object) {
                  tablehtml += '<tr>';
                  tablehtml += '<td class="word-wrap">' + object.address + '</td>';
                  tablehtml += "<td class='btn btn-primary edit-customer-address-btn btn-sm' onclick='editCustomerAddress(" + JSON.stringify(object) + ")'><i class='fa fa-pencil'></i></td>";
                  //tablehtml+='<td class="btn btn-danger btn-sm" onclick="deleteCustomerAddress('+object.id+','+object.customer_id+')"><i class="fa fa-trash"></i></td>';
                  tablehtml += '</tr>';
              });
              customerAddress.push("<option value=''>--Select--</option>");
              $.each(response.address, function(index, object) {
                  customerAddress.push("<option value=" + object.id + ">" + object.address + "</option>");
                  invoiceselectedAddress[object.id] = object.state_id;
              });
              customerAddress.push("<option value=new_edit_address>Add/Edit</option>")
          } else {
              customerAddress.push("<option value='new_address'>+add new</option>");
          }
          $("#invoice-add-form #invoice_billing_address").html(customerAddress.join(" "));
          $("#invoice-add-form #invoice_shipping_address").html(customerAddress.join(" "));

          $("#add-customer-address-list").html(tablehtml);
      },
      error: function(error) {

      },
      complete: function() {
          $("#add-edit-customer-address-form #customer_id").val(customerid);
      }
  });
}

//Retrieve Customer Address on Modal functionality starts here

function editCustomerAddress(object) {
  $.each(object, function(index, value) {
      $("#add-edit-customer-address-form input[name=" + index + "]").val(value);
      if (index == "customer_address") {
          $("#add-edit-customer-address-form textarea[name='address']").val(value);
      }
      $("#add-edit-customer-address-form #state_id").val(object.state_id);
      $("#change-button-label").html("Update Address");
  });
}

//Retrieve Customer Address on Modal functionality ends here

//Update Customer Address functionality code starts here
$("#add-edit-customer-address-form").submit(function(e) {
  e.preventDefault();
  var formdata = $("#add-edit-customer-address-form").serializeArray();
  var customerid = $("#add-edit-customer-address-form #customer_id").val();
  $.ajax({
      url: "/rockpay/account/invoice/invoice/customer-address/update",
      type: "POST",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#ajax-address-update-response-message").html(response.message).css({ "color": "green" });
          }
      },
      error: function() {},
      complete: function() {
          AddEditCustomerAddress(customerid);
          setTimeout(() => {
              $("#ajax-address-update-response-message").html("");
          }, 1500);
      }
  })
});
//Update Customer Address functionality code ends here


//Store Customer Address functionality starts here
$("#add-customer-address-form").submit(function(e) {
  e.preventDefault();
  var formdata = $("#add-customer-address-form").serializeArray();
  var customerid = $("#add-customer-address-form #customer_id").val();
  $.ajax({
      url: "/rockpay/account/invoice/invoice/customer-address/add",
      type: "POST",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#ajax-address-response-message").html(response.message).css({ "color": "green" });
          }
      },
      error: function() {},
      complete: function() {
          getCustomerAddress(customerid, 'invoice-add-form');
          setTimeout(() => {
              $("#ajax-address-response-message").html("");
          }, 1500);
      }
  })
});

//Store Customer Address functionality ends here
$("#invoice-edit-form #invoice_billing_to").on("change", function(event) {
  event.preventDefault();
  var customerid = $(this).val();
  customerAddress = [];
  if (customerid != "" && customerid != "new") {
      getCustomerAddress(customerid, "invoice-edit-form");

  } else if (customerid == "new") {
      $('#add-customer-modal').modal('show');
  } else {

      $("#customer_gstno").val("");
      $("#customer_email").val("");
      $("#customer_phone").val("");
      $("#invoice_billing_address").html("<option value=' '>Select Bill Address</option>");
      $("#invoice_shipping_address").html("<option value=' '>Select Ship Address</option>");
  }


});

//Update Invoice functionality starts here
function updateInvoice(value) {

  var formdata = "";
  var formvalidate = "";
  var isformvalid = false;
  var invoice
  $("#invoice-edit-form #invoice_status").val(value);

  formdata = $("#invoice-edit-form").serializeJSON();
  formvalidate = $("#invoice-edit-form").serializeArray();


  var mandatory = {
      "invoice_receiptno": "Invoice No",
      "company": "Company",
      "gstno": "GSTIN",
      "panno": "Pan No",
      "invoice_issue_date": "Invoice Date",
      "invoice_billing_to": "Name",
      "customer_email": "Email",
      "customer_phone": "Phone",
      "invoice_billing_address": "Billing Address",
      "invoice_shipping_address": "Shipping Address",
  }

  $.each(formvalidate, function(index, element) {

      if (element.name in mandatory) {
          if (element.value == "") {
              $("#" + element.name + "_error").html("Field " + mandatory[element.name] + " is empty").css({ "color": "red" })

              $("#" + element.name).focus();

              $("input[name=" + element.name + "]").click(function(event) {
                  event.preventDefault();
                  $("#" + element.name + "_error").html("");
              });

              $("#" + element.name).change(function(event) {
                  event.preventDefault();
                  $("#" + element.name + "_error").html("");
              })
              isformvalid = false;
              return false;
          }
      } else {

          if ($("#item_name1").val() == "" && element.name != "customer_gstno") {
              $("#item_name1_error").html("1 item must add").css({ "color": "red" });
              $("#item_name1").focus();
              $("#item_name1").change(function(event) {
                  event.preventDefault();
                  $("#item_name1_error").html("");
              });
              isformvalid = false;
              return false;
          } else {
              isformvalid = true;
          }
      }
  });
  if (isformvalid) {
      $.ajax({
          url: "/rockpay/account/invoice/invoices/update",
          type: "POST",
          data: formdata,
          dataType: "json",
          success: function(response) {
              if (response.status) {
                  $("#invoice-update-response").html(response.message);
              }
          },
          error: function(error) {
              console.log(error.responseText());
          },
          complete: function() {
              if (value == 'issued') {
                  window.location.href = '/merchant/invoices';
              } else {
                  $("#invoice-update-response-message-modal").modal("show");
              }

          }
      })
  }
}
//Update Invoice functionality ends here

//Invoice generate/save functionality starts here
function addInvoice(value) {

  var formdata = "";
  var formvalidate = "";
  var isformvalid = false;

  $("#invoice-add-form #invoice_status").val(value);

  formdata = $("#invoice-add-form").serializeJSON();
  formvalidate = $("#invoice-add-form").serializeArray();


  var mandatory = {
      "invoice_receiptno": "Invoice No",
      "company": "Company",
      "gstno": "GSTIN",
      "panno": "Pan No",
      "invoice_issue_date": "Invoice Date",
      "invoice_billing_to": "Name",
      "customer_email": "Email",
      "customer_phone": "Phone",
      "invoice_billing_address": "Billing Address",
      "invoice_shipping_address": "Shipping Address",
  }

  $.each(formvalidate, function(index, element) {

      if (element.name in mandatory) {
          if (element.value == "") {
              $("#" + element.name + "_error").html("Field " + mandatory[element.name] + " is empty").css({ "color": "red" })

              $("#" + element.name).focus();

              $("input[name=" + element.name + "]").click(function(event) {
                  event.preventDefault();
                  $("#" + element.name + "_error").html("");
              });

              $("#" + element.name).change(function(event) {
                  event.preventDefault();
                  $("#" + element.name + "_error").html("");
              })
              isformvalid = false;
              return false;
          }
      } else {

          if ($("#item_name1").val() == "" && element.name != "customer_gstno") {
              $("#item_name1_error").html("1 item must add").css({ "color": "red" });
              $("#item_name1").focus();
              $("#item_name1").change(function(event) {
                  event.preventDefault();
                  $("#item_name1_error").html("");
              });
              isformvalid = false;
              return false;
          } else {
              isformvalid = true;
          }
      }
  });
  if (isformvalid) {
      $.ajax({
          url: "/rockpay/account/invoice/invoices/new",
          type: "POST",
          data: formdata,
          dataType: "json",
          success: function(response) {
              if (response.status) {
                  $("#invoice-add-response").html(response.message).css({ "color": "green" });
              }
          },
          error: function(error) {
              console.log(error.responseText());
          },
          complete: function() {
              $("#invoice-add-response-message-modal").modal({ show: true });
          }
      })
  }
}
//Invoice save functionality ends here

//Invoice items add-edit-delete functionality ends here
$("#additemmodal").click(function(event) {
  event.preventDefault();
  $("#itemadd")[0].reset();
  $('#call-item-model').modal('show');
});

$("#itemadd").submit(function(e) {

  e.preventDefault();
  var formdata = $("#itemadd").serializeJSON();
  var fromvalidate = false;
  $("#itemadd input[name='item_name[]']").each(function(index, element) {
      if ($(element).val() == "") {
          $(element).css({ "border": "1px solid red" });
          $('body').on("click", "#itemadd input[name='item_name[]']", function() {
              $(this).css({ "border": "1px solid #ddd" });
          });
          return false;
      }
  });

  $("#itemadd input[name='item_amount[]']").each(function(index, element) {
      var regnumber_rule = /^[0-9\.]+/g;
      if (!regnumber_rule.test($(element).val())) {
          $(element).css({ "border": "1px solid red" });
          $('body').on("click", "#itemadd input[name='item_amount[]']", function() {
              $(this).css({ "border": "1px solid #ddd" });
          });
          return false;
      } else {
          fromvalidate = true;
      }
  });
  if (fromvalidate) {
      $.ajax({
          url: "/rockpay/account/invoice/item/new",
          type: "POST",
          data: formdata,
          dataType: "json",
          success: function(response) {
              if (response.status) {
                  $("#item-ajax-response").html(response.message).css({ "color": "green" });
                  getAllItems();
                  $('#call-item-model').modal('hide');

              } else {
                  $("#item-ajax-response").html(response.message).css({ "color": "red" });
                  $('#call-item-model').modal('hide');
              }
          },
          complete: function() {
              setTimeout(() => {
                  $("#item-ajax-response").html("");
              }, timeout);
          }
      });
  }

});

$("#new-item").click(function(e) {
  e.preventDefault();
  var newrow = `<tr><td><input type="text" class="form-control"  name="item_name[]" value=""></td>
<td><input type="number" class="form-control" name="item_amount[]" value=""></td>
<td><Textarea class="form-control" cols=30 rows=2 name="item_description[]"></Textarea></td>
<td><i class="fa fa-times show-pointer mandatory" onclick="removeItem(this);"></i></td></tr>`;
  $("#new-row").append(newrow);
});

function removeItem(element) {
  if ($("#new-row").children().length > 1) {
      $(element).closest("tr").remove();
  }
}


function editItem(itemid) {
  $.ajax({
      url: "/rockpay/account/invoice/item/edit/" + itemid,
      type: "GET",
      dataType: "json",
      success: function(response) {
          if (response.length > 0) {
              $.each(response[response.length - 1], function(key, value) {

                  if ($("#item-update-form textarea[name='" + key + "']")) {
                      $("#item-update-form textarea[name='" + key + "']").val(value);
                  }
                  $("#item-update-form input[name='" + key + "']").val(value);
              });
              $("#edit-item-model").modal("show");
          }
      },
      error: function() {

      }
  });

}


$("#item-update-form").submit(function(event) {
  event.preventDefault();
  var formdata = $("#item-update-form").serializeArray();
  $.ajax({
      url: "/rockpay/account/invoice/item/update",
      type: "POST",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              getAllItems();
              $("#item-update-response").html(response.message).css({ "color": "green" });
          } else {
              $("#item-update-response").html(response.message).css({ "color": "red" });
          }
      },
      error: function(data) {
          var errors = data.responseJSON;
          console.log(errors);
      },
      complete: function() {
          setTimeout(() => {
              $("#item-update-response").html("");
          }, timeout);
      }
  });
});

function deleteItem(itemid) {
  $("#deleteitemmodal").modal("show");
  $("#item-delete-form input[name='id']").val(itemid);
}

$("#item-delete-form").submit(function(event) {
  event.preventDefault();
  var formdata = $("#item-delete-form").serializeArray();
  $.ajax({
      url: "/rockpay/account/invoice/item/destroy",
      type: "POST",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#deleteitemmodal").modal("hide");
              $("#item-delete-ajax-response").html(response.message).css({ "color": "green" });
              getAllItems();
          } else {
              $("#item-delete-ajax-response").html(response.message).css({ "color": "red" });
          }

      },
      complete: function() {
          setTimeout(() => {
              $("#item-delete-ajax-response").html("");
          }, timeout);
      }
  });
});

//Invoice items add-edit-delete functionality ends here

//Invoice customer add-edit-delete functionality code starts here
$("#add-customer-call").click(function(e) {
  e.preventDefault();
  $('#add-customer-modal').modal('show');
});
$("[data-target='#customers']").click(function(e) {
  e.preventDefault();
  getAllCustomers();
});

function getAllCustomers() {
  $.ajax({
      type: "GET",
      url: "/rockpay/account/invoice/customers/get-all-customers/" + perpage,
      dataType: "html",
      success: function(response) {
          $("#paginate_customers").html(response);
      }
  });
}
$("#add-customer-form").submit(function(event) {
  event.preventDefault();
  var formdata = $("#add-customer-form").serializeArray();
  $.ajax({
      url: "/rockpay/account/invoice/customer/new",
      type: "POST",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#add-response-message").html(response.message).css({ "color": "green" });
          }
      },
      error: function() {},
      complete: function() {
          setTimeout(() => {
              $("#add-response-message").html("");
          }, timeout);
      }
  });
});

function editCustomer(customerid) {
  $("#edit-customer-modal #edit-response-message").html("");
  if (customerid != "") {
      $.ajax({
          url: "/rockpay/account/invoice/customer/edit/" + customerid,
          type: "GET",
          dataType: "json",
          success: function(response) {
              if (response.length > 0) {
                  $.each(response, function(index, object) {
                      $.each(object, function(key, value) {
                          $("#update-customer-form input[name=" + key + "]").val(value);
                      });
                  });
              }
          },
          error: function() {},
          complete: function() {
              $("#edit-customer-modal").modal("show");
          }
      });
  }
}

$("#update-customer-form").submit(function(e) {
  e.preventDefault();
  var formdata = $("#update-customer-form").serializeArray();

  $.ajax({
      url: "/rockpay/account/invoice/customer/update",
      type: "POST",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#edit-customer-modal #edit-response-message").html(response.message).css({ "color": "green" })
          }
      },
      error: function() {},
      complete: function() {
          getAllCustomers();
          $("#edit-customer-modal").modal("show");
          setTimeout(() => {
              $("#edit-customer-modal #edit-response-message").html("");
          }, timeout);

      }
  })
});

function deleteCustomer(customerid) {
  $("#delete-customer-modal").modal("show");
  $("#delete-customer-form input[name='id']").val(customerid);
}

$("#delete-customer-form").submit(function(e) {
      e.preventDefault();
      var formdata = $("#delete-customer-form").serializeArray();
      $.ajax({
          url: "/rockpay/account/invoice/customer/destroy",
          type: "POST",
          data: getJsonObject(formdata),
          dataType: "json",
          success: function(response) {
              if (response.status) {
                  $("#delete-customer-modal").modal("hide");
                  $("#delete-customer_response").html(response.message).css({ "color": "green" });
              }
          },
          error: function(error) {

          },
          complete: function() {
              getAllCustomers();
              setTimeout(() => {
                  $("#delete-customer_response").html("");
              }, timeout);
          }
      });
  })
  //Invoice customer add-edit-delete functionality code ends here


//Invoice supplier add-edit-delete functionality code starts here
$("#add-supplier-call").click(function(e) {
  e.preventDefault();
  $('#add-supplier-modal').modal('show');
});
$("[data-target='#suppliers']").click(function(e) {
  e.preventDefault();
  getAllSuppliers();
});

function getAllSuppliers() {
  $.ajax({
      type: "GET",
      url: "/rockpay/account/invoice/suppliers/get-all-suppliers/" + perpage,
      dataType: "html",
      success: function(response) {
          $("#paginate_suppliers").html(response);
      }
  });
}
$("#add-supplier-form").submit(function(event) {
  event.preventDefault();
  var formdata = $("#add-supplier-form").serializeArray();
  $.ajax({
      url: "/rockpay/account/invoice/supplier/new",
      type: "POST",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#add-supplier-response-message").html(response.message).css({ "color": "green" });
              getAllSuppliers();
          }
      },
      error: function() {},
      complete: function() {
          setTimeout(() => {
              $("#add-supplier-response-message").html("");
          }, timeout);
      }
  });
});

function editSupplier(supplierid) {
  $("#edit-supplier-modal #edit-supplier-response-message").html("");
  if (supplierid != "") {
      $.ajax({
          url: "/rockpay/account/invoice/supplier/edit/" + supplierid,
          type: "GET",
          dataType: "json",
          success: function(response) {
              if (response.length > 0) {
                  $.each(response, function(index, object) {
                      $.each(object, function(key, value) {
                          //$("#update-supplier-form input[name="+key+"]").val(value);
                          setFormValues('update-supplier-form', key, value);
                      });
                  });
                  $("#edit-supplier-modal").modal("show");
              }
          },
          error: function() {},
          complete: function() {

          }
      });
  }
}

$("#update-supplier-form").submit(function(e) {
  e.preventDefault();
  var formdata = $("#update-supplier-form").serializeArray();

  $.ajax({
      url: "/rockpay/account/invoice/supplier/update",
      type: "POST",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#edit-supplier-modal #edit-supplier-response-message").html(response.message).css({ "color": "green" });
              getAllSuppliers();
          }
      },
      error: function() {},
      complete: function() {
          $("#edit-supplier-modal").modal("show");
          setTimeout(() => {
              $("#edit-supplier-modal #edit-supplier-response-message").html("");
          }, timeout);

      }
  })
});

function deleteSupplier(supplierid) {
  $("#delete-supplier-modal").modal("show");
  $("#delete-supplier-form input[name='id']").val(supplierid);
}

$("#delete-supplier-form").submit(function(e) {
  e.preventDefault();
  var formdata = $("#delete-supplier-form").serializeArray();
  $.ajax({
      url: "/rockpay/account/invoice/supplier/destroy",
      type: "POST",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#delete-supplier-modal").modal("hide");
              $("#delete-supplier-response").html(response.message).css({ "color": "green" });
              getAllSuppliers();
          }
      },
      error: function(error) {

      },
      complete: function() {
          setTimeout(() => {
              $("#delete-supplier-response").html("");
          }, timeout);
      }
  });
});
//Invoice supplier add-edit-delete functionality code ends here

$("[data-target='#items']").click(function(e) {
  e.preventDefault();
  getAllItems();
});

function getAllItems() {
  $.ajax({
      type: "GET",
      url: "/rockpay/account/invoice/items/get-all-items/" + perpage,
      dataType: "html",
      success: function(response) {
          $("#paginate_items").html(response);
      }
  });
}

$("[data-target='#add-chart-of-account']").click(function(e) {
  e.preventDefault();
  getChartAccountOptions('account-chart-form', 'id');
});

function getChartAccountOptions(formid, name) {
  var html = "";
  $.ajax({
      type: "GET",
      url: "/rockpay/get-chart-options",
      dataType: "json",
      success: function(response) {
          if (response.length > 0) {
              chartOptions.push("<option value=''>--Select--</option>");
              $.each(response, function(indexInArray, valueOfElement) {
                  chartOptions.push("<option value=" + valueOfElement.id + ">" + valueOfElement.account_code + " (" + valueOfElement.description + ")" + "</option>");
              });
          }
          $("#" + formid + " select[name='" + name + "']").html(chartOptions.join(',', ''));
      }
  });
}

function getSingleChartAccount(chartid) {
  var chartAccountArray = [];
  $.ajax({
      type: "GET",
      url: "/rockpay/edit-chart-record/" + chartid,
      dataType: "json",
      success: function(response) {
          if (response.length > 0) {
              $.each(response[response.length - 1], function(indexInArray, valueOfElement) {
                  $("#chart-account-form input[name=" + indexInArray + "]").val(valueOfElement);
              });
              $(".btn.btn-primary").html("Update");
          }
      }
  });
}

$("#account-chart-form select[name='id']").click(function(e) {
  e.preventDefault();
  var id = $(this).val();
  if (id != "") {
      getSingleChartAccount(id);
  }
})


$("#chart-account-form").submit(function(e) {
  e.preventDefault();
  var formdata = $("#chart-account-form").serializeArray();
  $.ajax({
      type: "POST",
      url: "/rockpay/account/charts-account/add",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#ajax-response-message").html(response.message).css({ "color": "green" });
              $("#chart-account-form")[0].reset();
          } else {

              if (Object.keys(response.errors).length > 0) {
                  $.each(response.errors, function(indexInArray, valueOfElement) {
                      $("#" + indexInArray + "_ajax_response").html(valueOfElement).css({ "color": "red" });
                      $("input[name=" + indexInArray + "]").click(function() {
                          $("#" + indexInArray + "_ajax_response").html("");
                      });
                  });
              } else {

              }
          }
      },
      complete: function() {

          setTimeout(() => {
              $("#ajax-response-message").html("");
          }, timeout);
      }
  });
});
//Account javascript functionality ends here

//Finance javascript functionality starts here


$("[data-target='#contra-entry']").click(function(e) {
  e.preventDefault();
  getAllContraEntry();
});

$("[data-target='#sundry-payment-entry']").click(function(e) {
  e.preventDefault();
  getAllSundryPaymentEntry();
});

$("[data-target='#supplier-pay-batch-entry']").click(function(e) {
  e.preventDefault();
  getAllSupPayBatchEntry();
});

$("[data-target='#bank-detail-info']").click(function(e) {
  e.preventDefault();
  getAllBanks();
});

function getAllContraEntry() {
  $.ajax({
      type: "GET",
      url: "/rockpay/finance/payable-management/contra-entry/get/" + perpage,
      dataType: "html",
      success: function(response) {
          $("#paginate_contras").html(response);
      }
  });
}

function getInvoiceNo(element) {
  var invoice_type_id = element.value;
  var invoiceOptions = [];
  if (invoice_type_id != "") {
      $.ajax({
          type: "GET",
          url: "/rockpay/finance/payable-management/sundry-payment/get/invoice-no/" + invoice_type_id,
          dataType: "json",
          success: function(response) {
              invoiceOptions.push("<option>--Select--</option>");
              if (Object.keys(response).length > 0) {
                  $.each(response, function(index, value) {
                      invoiceOptions.push("<option value=" + value.id + ">" + value.option_value + "</option>")
                  });
                  $("#batch_invno").html(invoiceOptions.join(""));
              }
          }
      });
  }
}

function getAllSupPayBatchEntry() {
  $.ajax({
      type: "GET",
      url: "/rockpay/finance/payable-management/supplier-paybatch/get/" + perpage,
      dataType: "html",
      success: function(response) {
          $("#paginate_suppaybatches").html(response);
      }
  });
}

$("#sup-pay-entry-form").submit(function(e) {
  e.preventDefault();
  var formdata = $("#sup-pay-entry-form").serializeArray();
  $.ajax({
      type: "POST",
      url: "/rockpay/finance/payable-management/supplier-paybatch/add",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#sup-pay-add-response").html(response.message);
              $("#sup-pay-add-response-message-modal").modal({ show: true, backdrop: 'static', keyboard: false });
          }
      }
  });
});

$("#update-sup-pay-entry-form").submit(function(e) {
  e.preventDefault();
  var formdata = $(this).serializeArray();
  $.ajax({
      type: "POST",
      url: "/rockpay/finance/payable-management/supplier-paybatch/update",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#sup-pay-add-response").html(response.message);
              $("#sup-pay-add-response-message-modal").modal({ show: true, backdrop: 'static', keyboard: false });
          }
      }
  });
});


function getAllSundryPaymentEntry() {
  $.ajax({
      type: "GET",
      url: "/rockpay/finance/payable-management/sundry-payment/get/" + perpage,
      dataType: "html",
      success: function(response) {
          $("#paginate_sundpaybatches").html(response);
      }
  });
}

$("#sund-pay-form").submit(function(e) {
  e.preventDefault();
  var formdata = $(this).serializeArray();
  $.ajax({
      type: "POST",
      url: "/rockpay/finance/payable-management/sundry-payment/add",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#sund-pay-add-response").html(response.message);
              $("#sund-pay-add-response-message-modal").modal({ show: true, backdrop: 'static', keyboard: false });
          }
      }
  });
});

$("#update-sund-pay-form").submit(function(e) {
  e.preventDefault();
  var formdata = $(this).serializeArray();
  $.ajax({
      type: "POST",
      url: "/rockpay/finance/payable-management/sundry-payment/update",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#sund-pay-add-response").html(response.message);
              $("#sund-pay-add-response-message-modal").modal({ show: true, backdrop: 'static', keyboard: false });
          }
      }
  });
});

$("#contra-entry-form").submit(function(e) {
  e.preventDefault();
  var formdata = $(this).serializeArray();
  $.ajax({
      type: "POST",
      url: "/rockpay/finance/payable-management/contra-entry/add",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#contra-add-response").html(response.message);
              $("#contra-add-response-message-modal").modal({ show: true, backdrop: 'static', keyboard: false });
          }
      }
  });
});

$("#update-contra-entry-form").submit(function(e) {
  e.preventDefault();
  var formdata = $(this).serializeArray();
  $.ajax({
      type: "POST",
      url: "/rockpay/finance/payable-management/contra-entry/update",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#contra-add-response").html(response.message);
              $("#contra-add-response-message-modal").modal({ show: true, backdrop: 'static', keyboard: false });
          }
      }
  });
});

function callBankModal() {
  $("#bank-form")[0].reset();
  $("#call-bank-modal").modal({ show: true, backdrop: 'static', keyboard: false });
}

$("#bank-form").submit(function(e) {
  e.preventDefault();
  var formdata = $(this).serializeArray();
  $.ajax({
      type: "POST",
      url: "/rockpay/finance/payable-management/bank/add",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#add-ajax-success").html(response.message);
              getAllBanks();
          } else {
              $("#add-ajax-fail").html(response.message);
          }
      },
      complete: function() {
          setTimeout(() => {
              $("#add-ajax-success").html("");
              $("#add-ajax-fail").html("");
          }, timeout);
      }
  });
});

function getAllBanks() {
  $.ajax({
      type: "GET",
      url: "/rockpay/finance/payable-management/bank/get/" + perpage,
      dataType: "html",
      success: function(response) {
          $("#paginate_banks").html(response);
      },
      complete: function() {

      }
  });
}

function editBankInfo(sno) {
  var bankid = sno
  $.ajax({
      type: "GET",
      url: "/rockpay/finance/payable-management/bank/edit/" + bankid,
      dataType: "json",
      success: function(response) {
          if (Object.keys(response).length > 0) {
              $.each(response[response.length - 1], function(index, value) {
                  $("input[name=" + index + "]").val(value);
              });
              $("#call-edit-bank-modal").modal({ show: true, backdrop: 'static', keyboard: false });
          }
      },
      complete: function() {

      }
  });
}

$("#edit-bank-form").submit(function(e) {
  e.preventDefault();
  var formdata = $(this).serializeArray();
  $.ajax({
      type: "POST",
      url: "/rockpay/finance/payable-management/bank/update",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#update-ajax-success").html(response.message);
              getAllBanks();
          } else {
              $("#update-ajax-fail").html(response.message);
          }
      },
      complete: function() {
          setTimeout(() => {
              $("#update-ajax-success").html("");
              $("#update-ajax-fail").html("");
          }, timeout);
      }
  });
});


$("[data-target='#customer-direct-receipt-entry']").click(function(e) {
  e.preventDefault();
  getAllCustReceiptEntries();
});

$("[data-target='#sundry-receipt-entry']").click(function(e) {
  e.preventDefault();
  getAllSundReceiptEntry();
});


function getSaleInvoiceNo(element) {
  var invoice_type_id = element.value;
  var invoiceOptions = [];
  if (invoice_type_id != "") {
      $.ajax({
          type: "GET",
          url: "/rockpay/finance/receivable-management/cust-dreceipt-entry/get/invoice-no/" + invoice_type_id,
          dataType: "json",
          success: function(response) {
              invoiceOptions.push("<option>--Select--</option>");
              if (Object.keys(response).length > 0) {
                  $.each(response, function(index, value) {
                      invoiceOptions.push("<option value=" + value.id + ">" + value.option_value + "</option>")
                  });
                  $("#receipt_invno").html(invoiceOptions.join(""));
              }
          }
      });
  }
}

function getAllCustReceiptEntries() {
  $.ajax({
      type: "GET",
      url: "/rockpay/finance/receivable-management/cust-dreceipt-entry/get/" + perpage,
      dataType: "html",
      success: function(response) {
          $("#paginate_custrcptentries").html(response);
      }
  });
}

function getAllSundReceiptEntry() {
  $.ajax({
      type: "GET",
      url: "/rockpay/finance/receivable-management/sundry-receipt/get/" + perpage,
      dataType: "html",
      success: function(response) {
          $("#paginate_sundrcptentries").html(response);
      }
  });
}

$("#cust-recipt-entry-form").submit(function(e) {
  e.preventDefault();
  var formdata = $(this).serializeArray();
  $.ajax({
      type: "POST",
      url: "/rockpay/finance/receivable-management/cust-dreceipt-entry/add",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#cust-recipt-add-response").html(response.message);
              $("#cust-recipt-add-response-message-modal").modal({ show: true, backdrop: 'static', keyboard: false });
          }
      }
  });
});

$("#update-cust-recipt-entry-form").submit(function(e) {
  e.preventDefault();
  var formdata = $(this).serializeArray();
  $.ajax({
      type: "POST",
      url: "/rockpay/finance/receivable-management/cust-dreceipt-entry/update",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#cust-recipt-add-response").html(response.message);
              $("#cust-recipt-add-response-message-modal").modal({ show: true, backdrop: 'static', keyboard: false });
          }
      }
  });
});

$("#sund-receipt-entry-form").submit(function(e) {
  e.preventDefault();
  var formdata = $(this).serializeArray();
  $.ajax({
      type: "POST",
      url: "/rockpay/finance/receivable-management/sundry-receipt/add",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#sund-receipt-add-response").html(response.message);
              $("#sund-receipt-add-response-message-modal").modal({ show: true, backdrop: 'static', keyboard: false });
          }
      }
  });
})

$("#update-sund-receipt-form").submit(function(e) {
  e.preventDefault();
  var formdata = $(this).serializeArray();
  $.ajax({
      type: "POST",
      url: "/rockpay/finance/receivable-management/sundry-receipt/update",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#sund-receipt-add-response").html(response.message);
              $("#sund-receipt-add-response-message-modal").modal({ show: true, backdrop: 'static', keyboard: false });
          }
      }
  });
})

//Finance javascript functionality ends here

//Settlement module javascript functionality starts here
function getMerchantTransactions(element) {
  var merchantid = $(element).val();
  var transactions = [];
  if (merchantid != "") {
      $.ajax({
          type: "GET",
          url: "/rockpay/settlement/get-merchants-transactions/" + merchantid,
          dataType: "json",
          success: function(response) {
              transactions.push("<option value=''>--Select--</option>");
              if (Object.keys(response).length > 0) {
                  $.each(response, function(index, object) {
                      transactions.push("<option value=" + object.transaction_gid + ">" + object.transaction_gid + "</option>");
                  });
              }
              $("#merchant_traxn_id").html(transactions.join(""));
          }
      });
  }
}

function getMerchantTransactionsByDate() {
  var formdata = $("#transaction-form").serializeArray();
  $.ajax({
      type: "POST",
      url: "/flakpay/settlement/get-all-transactions",
      data: getJsonObject(formdata),
      dataType: "html",
      success: function(response) {
          $("#paginate_alltransaction").html(response);
      }
  });
}


function CalculateRow() {

  var basic_amount = 0.00;
  var charges_per = 0;
  var gst_per = 0;
  var net_basic_amount = 0.00;
  var charge_on_basic = 0.00;
  var gst_on_charges = 0.00;
  var total_amount_charged = 0.00;
  var net_charges_amount = 0.00;
  var net_gst_amount = 0.00;
  var net_total_amount = 0.00;

  $.each(cardsType, function(index, rowid) {

      basic_amount = parseInt($("#basic_amount_" + rowid).val());
      net_basic_amount = eval(net_basic_amount + basic_amount);

      charges_per = $("#charges_per_" + rowid).val();
      gst_per = $("#gst_per_" + rowid).val();

      $("#" + rowid + "_charges_on_basic").html(eval(basic_amount * charges_per / 100));
      $("#charges_on_basic_" + rowid).val(eval(basic_amount * charges_per / 100));
      charge_on_basic = parseInt($("#charges_on_basic_" + rowid).val());
      net_charges_amount = eval(net_charges_amount + charge_on_basic);

      $("#" + rowid + "_gst_on_charges").html(eval(charge_on_basic * gst_per / 100));
      $("#gst_on_charges_" + rowid).val(eval(charge_on_basic * gst_per / 100));
      gst_on_charges = parseInt($("#gst_on_charges_" + rowid).val());
      net_gst_amount = eval(net_gst_amount + gst_on_charges);

      $("#" + rowid + "_total_amt_charged").html(eval(charge_on_basic + gst_on_charges));
      $("#total_amt_charged_" + rowid).val(eval(charge_on_basic + gst_on_charges));
      total_amount_charged = parseInt($("#total_amt_charged_" + rowid).val());
      net_total_amount = eval(net_total_amount + total_amount_charged);

      $("#net_basic_amount").html(net_basic_amount);
      $("#net_charges_amount").html(net_charges_amount);
      $("#net_gst_amount").html(net_gst_amount);
      $("#net_total_amount").html(net_total_amount);

      $("input[name='net_basic_amount']").val(net_basic_amount);
      $("input[name='net_charges_amount']").val(net_charges_amount);
      $("input[name='net_gst_amount']").val(net_gst_amount);
      $("input[name='net_total_amount']").val(net_total_amount);

  });




}

function getTransactionsDetails(element) {
  var transactionid = $(element).val();
  if (transactionid != "") {
      $.ajax({
          type: "GET",
          url: "/rockpay/settlement/get-transactions-details/" + transactionid,
          dataType: "json",
          success: function(response) {
              if (response.length > 0) {
                  $.each(response[response.length - 1], function(name, value) {
                      $("#add-settlement-form input[name=" + name + "]").val(value);
                  });
              }
          }
      });
  }
}

$("#add-settlement-form").submit(function(e) {
  e.preventDefault();
  var formdata = $("#add-settlement-form").serializeArray();
  $.ajax({
      type: "POST",
      url: "/rockpay/settlement/add",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#add-settlement-form")[0].reset();
              $("#add-settlement-ajax-success-message").html(response.message);
          } else {
              $("#add-settlement-ajax-failed-message").html(response.message);
          }
      },
      complete: function() {
          setTimeout(() => {
              $("#add-settlement-ajax-success-message").html("");
              $("#add-settlement-ajax-failed-message").html("");
          }, timeout);
      }
  });
})

function getAdjustmentDetails() {
  $.ajax({
      type: "GET",
      url: "/rockpay/settlement/get",
      dataType: "html",
      success: function(response) {
          $("#paginate_ryapay_adjustment").html(response);
      }
  });
}



$("#adjustment-report-form").submit(function(e) {
  e.preventDefault();
  // $("div#divLoading").removeClass('hide');
  // $("div#divLoading").addClass('show');
  var formdata = $(this).serializeJSON();
  var merchantId = $("#merchant_id").val();
  var transactionDate = $("#transaction_date").val();
  var formvalidate = true;
  if (merchantId == "") {
      formvalidate = false;

      $("#merchant_id").focus();
      $("#merchant_id_error").html("Select atleast one Merchant to proceed").css({ "color": "red" });
      $("#merchant_id").click(function() {
          $("#merchant_id_error").html("");
      });

      $("div#divLoading").removeClass('show');
      $("div#divLoading").addClass('hide');
      return false;

  } else if (transactionDate == "") {
      formvalidate = false;
      $("#transaction_date").focus();
      $("#transaction_date_error").html("Select atleast one transaction Date to proceed").css({ "color": "red" });
      $("#transaction_date").click(function() {
          $("#transaction_date_error").html("");
      });

      $("div#divLoading").removeClass('show');
      $("div#divLoading").addClass('hide');
      return false;

  }

  if (formvalidate) {
      $.ajax({
          type: "POST",
          url: "/rockpay/settlement/generate",
          data: formdata,
          dataType: "json",
          success: function(response) {
              if (response.status) {
                  $("#adjusttrans-add-response").html(response.message);
                  $("#adjusttrans-add-response-message-modal").modal({ show: true, backdrop: 'static', keyboard: false });
              }
          },
          complete: function() {
              // setTimeout(() => {
              //   $("#adjustment-report-ajax-error-response").html("");
              //   $("#adjustment-report-ajax-success-response").html("");
              // }, timeout);
              // $("div#divLoading").removeClass('show');
              // $("div#divLoading").addClass('hide');
          }
      });
  }


});

function merchantAdjustment(adjustmentid, merchant_id) {
  if (adjustmentid != "") {
      var token = $("meta[name='csrf-token']").attr("content");
      $.ajax({
          type: "POST",
          url: "/rockpay/settlement/proceed-adjustment",
          data: { id: adjustmentid, merchant_id: merchant_id, _token: token },
          dataType: "json",
          success: function(response) {
              if (response.status) {
                  $("#settlement-process-success").html(response.message);
              } else {
                  $("#settlement-process-failed").html(response.message);
              }
              getAdjustmentDetails();
          },
          complete: function() {
              setTimeout(() => {
                  $("#settlement-process-success").html("");
                  $("#settlement-process-failed").html("")

              }, timeout);
          }
      });
  }
}

function getBulkAdjsutmentIds(element) {
  $("input[name='id[]']").each(function(index, element) {
      if ($(element).prop("checked")) {
          if ($.inArray(element.value, adjustmentids) == -1) {
              adjustmentids.push(element.value);
          }
      } else {
          var index = adjustmentids.indexOf(element.value);
          if (index > -1) {
              adjustmentids.splice(index, 1);
          }
      }
  });
}

function selectAllTransactionIds(element) {
  var checkboxes = $("#settle-transactions-form input[name='id[]']");
  $.each(checkboxes, function(index, object) {
      $(object).prop("checked", $(element).prop("checked"));
  })
}

function selectAllVendorAdjustmentIds(element) {
  var checkboxes = $("#rupayapay-adjustment-form input[name='id[]']");

  $.each(checkboxes, function(index, object) {
      $(object).prop("checked", $(element).prop("checked"));
  })
}

$("#call-adjustment-modal").click(function(e) {
  e.preventDefault();
  var oneCheckBoxSelected = false;
  var checkBoxExits = false;
  $("#adjustment-alert-show").html("");
  $("#settle-transactions-form input[name='id[]']").each(function(index, object) {
      if ($(object).prop('checked')) {
          oneCheckBoxSelected = true;
      }
      checkBoxExits = true;
  });
  if (oneCheckBoxSelected && checkBoxExits) {
      $("#adjustment-select-form")[0].reset();
      $("#adjustment-select-option-modal").modal({ show: true, backdrop: 'static', keyboard: false });
  } else {
      if (!oneCheckBoxSelected && checkBoxExits) {
          $("#adjustment-alert-show").html("Atleast select one checkbox");
          $("#adjustment-alert").modal({ show: true, backdrop: 'static', keyboard: false });
      }
  }
});

$("#adjustment-select-form").submit(function(e) {
  e.preventDefault();
  var oneCheckBoxSelected = false;
  var selectedCheckbox = "";
  $("#adjustment-alert-show").html("");
  $("#adjustment-select-form input[name='adjustment']").each(function(index, object) {
      if ($(object).prop('checked')) {
          oneCheckBoxSelected = true;
          selectedCheckbox = $(object).val();
      }
  });

  if (oneCheckBoxSelected) {
      if (selectedCheckbox == "vendor") {
          bulkVendorAdjustment();
          $("#adjustment-select-option-modal").modal("hide");
      } else {
          bulkRupayapayAdjustment();
          $("#adjustment-select-option-modal").modal("hide");
      }
  } else {
      $("#adjustment-alert-show").html("Atleast select one adjustment method");
      $("#adjustment-alert").modal({ show: true, backdrop: 'static', keyboard: false });
  }

});

function bulkVendorAdjustment() {
  var formdata = $("#settle-transactions-form").serializeJSON();
  if (Object.keys(formdata).length > 1) {
      var html = "";
      showLoader();
      $("#adjustment-response-rows").html(html);
      $.ajax({
          type: "POST",
          url: "/rockpay/settlement/transactions-details",
          data: formdata,
          dataType: "json",
          success: function(response) {
              $.each(response, function(index, object) {

                  var className = (object.adjustment_status) ? 'success' : 'danger';
                  console.log(className);
                  html += `<tr class=` + className + `>
              <td>` + object.transaction_gid + `</td>
              <td>` + object.transaction_status + `</td>
            </tr>`;
              });

              $("#adjustment-response-rows").html(html);
              $("#adjusttrans-add-response-message-modal").modal({ show: true, backdrop: "static", keyboard: false });
          },
          complete: function() {
              hideLoader();
          }
      });
  }
}


function bulkRupayapayAdjustment() {
  //var formdata = $("#rupayapay-adjustment-form").serializeJSON();
  var formdata = $("#settle-transactions-form").serializeJSON();
  if (Object.keys(formdata).length > 1) {
      var html = "";
      showLoader();
      $("#rupayapay-adjustment-response-rows").html(html);
      $.ajax({
          type: "POST",
          url: "/rockpay/settlement/rockpay-adjustment",
          data: formdata,
          dataType: "json",
          success: function(response) {
              $.each(response, function(index, object) {

                  var className = (object.adjustment_status) ? 'success' : 'danger';
                  html += `<tr class=` + className + `>
                      <td>` + object.transaction_gid + `</td>
                      <td>` + object.transaction_status + `</td>
                  </tr>`;
              });

              $("#rupayapay-adjustment-response-rows").html(html);
              $("#rupayapay-adjustment-add-response-message-modal").modal({ show: true, backdrop: "static", keyboard: false });
              getVendorAdjustment();
          },
          complete: function() {
              hideLoader();
          }
      });
  }
}


$("[data-target='#vendor-adjustments']").click(function(e) {
  e.preventDefault();
  getVendorAdjustment();
});


function getVendorAdjustment() {

  var formdata = $("#vendor-adjustment-form").serializeArray();

  $.ajax({
      type: "POST",
      url: "/rockpay/settlement/get-vendor-adjustments",
      data: getJsonObject(formdata),
      dataType: "html",
      success: function(response) {
          $("#paginate_vendoradjustment").html(response);
      }
  });
}

$("[data-target='#rupayapay-adjustments']").click(function(e) {
  e.preventDefault();
  getRupayapayAdjustmentByDate();
});

function getRupayapayAdjustmentByDate() {
  var formdata = $("#rupayapay-adjustment").serializeArray();
  $.ajax({
      type: "POST",
      url: "/rockpay/settlement/get-rupayapay-adjustments",
      data: getJsonObject(formdata),
      dataType: "html",
      success: function(response) {
          $("#paginate_ryapayadjustment").html(response);
      }
  });
}

function getAllCDRTransactions(perpage = 10) {
  $.ajax({
      type: "GET",
      url: "/rockpay/settlement/chargeback-dispute-refund/get/" + perpage,
      dataType: "html",
      success: function(response) {
          $("#paginate_cdrtransactions").html(response);
      }
  });
}

$("#cdr-form").submit(function(e) {
  e.preventDefault();
  var formdata = $(this).serializeArray();
  $.ajax({
      type: "POST",
      url: "/rockpay/settlement/chargeback-dispute-refund/add",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#cdr-add-response").html(response.message);
              $("#cdr-add-response-message-modal").modal({ show: true, backdrop: 'static', keyboard: false });
          } else {
              $("#cdr-add-response").html(response.message);
              $("#cdr-add-response-message-modal").modal({ show: true, backdrop: 'static', keyboard: false });
          }
      }
  });
});

// /?$("#update-cdr-form").submit(function(e)

//   e.preventDefault();
//  
  function Test(payload){

  e.preventDefault();

  $.ajax({
      type: "POST",
      url: "/rockpay/settlement/chargeback-dispute-refund/update",
      data: getJsonObject(payload),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#cdr-add-response").html(response.message);
              $("#cdr-add-response-message-modal").modal({ show: true, backdrop: 'static', keyboard: false });
          } else {
              $("#cdr-add-response").html(response.message);
              $("#cdr-add-response-message-modal").modal({ show: true, backdrop: 'static', keyboard: false });
          }
      }
  });

}

//Settlement module javascript functionality ends here


//Technical Menu javascript functionality starts here
function getAllApprovedMerchants(perpage = 10) {
  $.ajax({
      type: "GET",
      url: "/rockpay/technical/get-apporved-merchants/" + perpage,
      dataType: "html",
      success: function(response) {
          $("#paginate_approvedmerchant").html(response);
      }
  });
}

function MakeMerchantLive(id, element) {
  $("#modal-message").html("");
  showLoader();
  $.ajax({
      type: "GET",
      url: "/rockpay/technical/make-merchant-live/" + id,
      dataType: "json",
      success: function(response) {
          $("#modal-message").html(response.message);
          $(element).parent("td").parent("tr").find("td:nth-child(7)").html("Enabled");
          $("#ajax-response").modal({ show: true, backdrop: "static", keyboard: false });
      },
      complete: function() {
          hideLoader();
      }
  });
}

function MakeMerchantInactive(id, element) {
  $("#modal-message").html("");
  showLoader();
  $.ajax({
      type: "GET",
      url: "/rockpay/technical/change-merchant-status/" + id + "/" + $(element).parent("td").parent("tr").find("td:nth-child(8)").html(),
      dataType: "json",
      success: function(response) {
          $("#modal-message").html(response.message);

          if (response.merchant_status == 'inactive') {
              $(element).parent("td").parent("tr").find("td:nth-child(8)").html(response.merchant_status);
              $(element).parent("td").find("button:nth-child(4)").show();
              $(element).hide();
              $(element).parent("tr").find("button:nth-child(3)").data('merchantstatus', response.merchant_status);
          } else {
              $(element).parent("td").parent("tr").find("td:nth-child(8)").html(response.merchant_status);
              $(element).parent("td").find("button:nth-child(3)").show();
              $(element).hide();
              $(element).parent("td").find("button:nth-child(3)").data('merchantstatus', response.merchant_status);
          }
          $("#ajax-response").modal({ show: true, backdrop: "static", keyboard: false });
      },
      complete: function() {
          hideLoader();
      }
  });
}

function togglePayinStatus(merchantId) {
    // Get the current status of the merchant
    var currentStatus = $('#active-btn').data('payinstatus');

    // Determine the new status based on the current status
    var newStatus = (currentStatus == 1) ? 0 : 1;

    // Send AJAX request to toggle the status
    $.ajax({
        type: "GET",
        url: "/flakpay/api/payin-status-toggle/" + merchantId,
        data: { status: newStatus }, // Pass the new status
        dataType: "json",
        success: function(response) {
            console.log(newStatus);
            // Update the button text and data attribute based on the new status
            if (newStatus == 1) {
                $('#active-btn #status-text').text('Inactive');
            } else {
                $('#active-btn #status-text').text('Active');
            }
            $('#active-btn').data('payinstatus', newStatus);

        },
        error: function(xhr, status, error) {
            console.error("Error:", error);
        }
    });
}





function merchantCharges(perpage = 10) {
  url = "/rockpay/technical/get-merchant-charges/" + perpage;
  dataOutput = "html";
  ajaxGETCall(url, dataOutput, merchantChargesSuccess, merchantChargesComplete);
}

$("[data-target='#adjustment-charges']").click(function(e) {
  e.preventDefault();
  getMerchantAdjustmentcharges();
});

$("#call-merchant-charges-modal").click(function(e) {
  e.preventDefault();
  $("#merchant-charges-form")[0].reset();
  $("#merchant-charges-form #id").val("");
  $("#merchant-charges-form input[type='submit']").val("Add Charges");
  $("#merchant-charges-modal").modal({ show: true, backdrop: "static", keyboard: false });
});

function editMerchantCharges(recorid) {

  var nonprecisonKeys = ["id", "merchant_id", "business_type_id"];
  $.ajax({
      type: "GET",
      url: "/rockpay/technical/get-merchant-charge/" + recorid,
      dataType: "json",
      success: function(response) {
          if (typeof response != undefined && Object.keys(response).length > 0) {
              $.each(response[response.length - 1], function(key, value) {
                  if (typeof value == "number" && $.inArray(key, nonprecisonKeys) == -1) {

                      $("#merchant-charges-form #" + key).val(value.toPrecision(3));
                  } else {

                      $("#merchant-charges-form #" + key).val(value);
                      $("#merchant-charges-form input[name=" + key + "][value=" + value + "]").prop('checked', true);
                  }

              });
              $("#merchant-charges-form input[type='submit']").val("Update Charges");
              $("#merchant-charges-modal").modal({ show: true, backdrop: "static", keyboard: false });
          }
      }
  });
}

$("#merchant-routing-form").submit(function(e) {
  e.preventDefault();
  var formdata = $(this).serializeArray();
  $.ajax({
      type: "POST",
      url: "/rockpay/technical/add-merchant-route",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#merchant-route-add-succsess-response").html(response.message);
              getMerchantRouting();
          } else {

              if (typeof response.errors != "undefined" && Object.keys(response.errors).length > 0) {
                  $.each(response.errors, function(key, value) {
                      $("#merchant-routing-form #" + key + "_error").html(value[0]);
                  });
              } else {
                  $("#merchant-route-add-fail-response").html(response.message);
              }
          }
      }
  });
});

function editMerchantRoutes(recorid) {
  $.ajax({
      type: "GET",
      url: "/rockpay/technical/get-merchant-route/" + recorid,
      dataType: "json",
      success: function(response) {
          if (typeof response != "undefined" && Object.keys(response).length > 0) {
              $.each(response[response.length - 1], function(key, value) {
                  if ($("#merchant-routing-form select[name=" + key + "]").length > 0) {
                      $("#merchant-routing-form select[name=" + key + "]").val(value);
                  }
                  if ($("#merchant-routing-form input[name=" + key + "]").length > 0) {
                      $("#merchant-routing-form input[name=" + key + "]").val(value);
                  }
              });
              $("#merchant-routing-form input[type='submit']").val("Update Route");
              $("#merchant-route-modal").modal({ show: true, backdrop: "static", keyboard: false });
          }
      }
  });
}


function getMerchantBusinessType(element, formName) {
  var merchant_id = element.value;

  if (merchant_id != "") {
      $.ajax({
          type: "GET",
          url: "/rockpay/technical/get-merchant-business-type/" + merchant_id,
          dataType: "json",
          success: function(response) {
              if (typeof response != undefined && Object.keys(response).length > 0) {
                  $("#" + formName + " #business_type_id").val(response[0].id);
              } else {
                  $("#" + formName + " #business_type_id").val("");
              }
          }
      });
  }
}

$("#merchant-charges-form").submit(function(e) {
  e.preventDefault();
  var formdata = $("#merchant-charges-form").serializeArray();
  $.ajax({
      type: "POST",
      url: "/rockpay/technical/merchant-charge/add",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#ajax-success-response").html(response.message);
              merchantCharges();
          } else {
              if (typeof response.errors != "undefined" && Object.keys(response.errors).length > 0) {
                  $.each(response.errors, function(errorkey, message) {
                      $("#merchant-charges-form #" + errorkey + "_error").html(message[0]);
                      $("#merchant-charges-form select[name=" + errorkey + "]").click(function(e) {
                          e.preventDefault();
                          $("#merchant-charges-form #" + errorkey + "_error").html("");
                      });
                      $("#merchant-charges-form input[name=" + errorkey + "]").click(function(e) {
                          e.preventDefault();
                          $("#merchant-charges-form #" + errorkey + "_error").html("");
                      });
                  });
              } else {
                  $("#ajax-failed-response").html(response.message);
              }
          }
      },
      complete: function() {
          setTimeout(() => {
              $("#ajax-success-response").html("");
              $("#ajax-failed-response").html("");
          }, timeout);
      }
  });
});

$("#call-adjustment-charges-modal").click(function(e) {
  e.preventDefault();
  $("#adjustment-charges-form")[0].reset();
  $("#adjustment-charges-form #id").val("");
  $("#adjustment-charges-modal").modal({ show: true, backdrop: "static", keyboard: false });
});

$("#adjustment-charges-form").submit(function(e) {
  e.preventDefault();
  var formdata = $(this).serializeArray();
  $.ajax({
      type: "POST",
      url: "/rockpay/technical/adjustment-charge/add-update",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#adjustment-charges-modal #ajax-success-response").html(response.message);
              getMerchantAdjustmentcharges();
          } else {
              if (typeof response.errors != "undefined" && Object.keys(response.errors).length > 0) {
                  $.each(response.errors, function(index, element) {
                      $("#adjustment-charges-form #" + index + "_error").html(element[0]);
                      $("#adjustment-charges-form input[name=" + index + "]").click(function(e) {
                          e.preventDefault();
                          $("#adjustment-charges-form #" + index + "_error").html("");
                      });
                      $("#adjustment-charges-form select[name=" + index + "]").click(function(e) {
                          e.preventDefault();
                          $("#adjustment-charges-form #" + index + "_error").html("");
                      });
                  });
              } else {
                  $("#adjustment-charges-modal #ajax-failed-response").html(response.message);
              }
          }
      }
  });
});


function editadjustmentCharges(recordId) {

  $("#adjustment-charges-modal #ajax-success-response").html("");
  $("#adjustment-charges-modal #ajax-failed-response").html("");
  if (recordId != "") {
      $.ajax({
          type: "GET",
          url: "/rockpay/technical/get-adjustment-charge/" + recordId,
          dataType: "json",
          success: function(response) {
              if (typeof response != "undefined" && Object.keys(response).length > 0) {
                  $.each(response[response.length - 1], function(key, value) {
                      $("#adjustment-charges-form input[name=" + key + "]").val(value);
                      $("#adjustment-charges-form select[name=" + key + "]").val(value);
                  });
                  $("#adjustment-charges-modal").modal({ show: true, backdrop: "static", keyboard: false });
              }
          }
      });
  }
}


function getMerchantAdjustmentcharges(perpage = 10) {
  $.ajax({
      type: "GET",
      url: "/rockpay/technical/get-adjustment-charges/" + perpage,
      dataType: "html",
      success: function(response) {
          $("#paginate_adjustmentcharge").html(response);
      }
  });
}

var merchantChargesSuccess = function(response) {
  $("#paginate_merchantcharge").html(response);
}

var merchantChargesComplete = function() {

}

$("#call-merchant-charges-modal").click(function(e) {
  e.preventDefault();

});

$("#call-merchant-route-modal").click(function(e) {
  e.preventDefault();
  $("#merchant-routing-form")[0].reset();
  $("#merchant-routing-form #id").val("");
  $("#merchant-routing-form input[type='submit']").val("Add Route");
  $("#merchant-route-add-succsess-response").html("");
  $("#merchant-route-add-fail-response").html("");
  $("#merchant-routing-form div.text-danger").each(function(index, object) {
      $(object).html("");
  });
  $("#merchant-route-modal").modal({ show: true, backdrop: "static", keyboard: false });
});

$("[data-target='#merchant-gateway-route']").click(function(e) {
  e.preventDefault();
  getMerchantRouting();
});

function getMerchantRouting(perpage = 10) {
  $.ajax({
      type: "GET",
      url: "/rockpay/technical/get-merchant-routes/" + perpage,
      dataType: "html",
      success: function(response) {
          $("#paginate_merchantroute").html(response)
      }
  });
}

$("#call-cashfree-route-modal").click(function(e) {
 
  $("#cashfree-route-modal").modal({ show: true, backdrop: "static", keyboard: false });
});

$("[data-target='#cash-free-configuration']").click(function(e){
  e.preventDefault();
  getCashFreeRouting();
});

function getCashFreeRouting(perpage = 10){
  $.ajax({
      type: "GET",
      url: "/rockpay/technical/cashfree-getroutes/" + perpage,
      dataType: "html",
      success: function(response) {
          $("#paginate_cashfreeroute").html(response)
      }
  });
}

$("#cashfree-routing-form").submit(function(e){
  e.preventDefault();
  var formdata = $(this).serializeArray();
  console.log($("#cashfree-routing-form input[name='id']").val());
  if($("#cashfree-routing-form input[name='id'").val() == ""){
      $.ajax({
          type: "POST",
          url: "/rockpay/technical/cashfree-add-route",
          data:getJsonObject(formdata),
          dataType: "json",
          success: function(response) {
             if(response.status){
              $("#cashfree-route-add-succsess-response").html(response.message);
             }else{
              $("#cashfree-route-add-fail-response").html(response.message);  
             }
          },complete:function(){
              setTimeout(() => {
                  $("#cashfree-route-add-succsess-response").html("");
                  $("#cashfree-route-add-fail-response").html("");
              }, timeout);
              getCashFreeRouting();
          } 
          
      });
  }else{
      $.ajax({
          type: "POST",
          url: "/rockpay/technical/cashfree-update-route",
          data:getJsonObject(formdata),
          dataType: "json",
          success: function(response) {
              if(response.status){
                  $("#cashfree-route-add-succsess-response").html(response.message);
                 }else{
                  $("#cashfree-route-add-fail-response").html(response.message);  
                 }
          },complete:function(){
              setTimeout(() => {
                  $("#cashfree-route-add-succsess-response").html("");
                  $("#cashfree-route-add-fail-response").html("");
              }, timeout);
          }
      });
  }

  
  
});
function editCashFreeKey(id){
  $("#cashfree-route-add-succsess-response").html("");
  $("#cashfree-route-add-fail-response").html("");
  if(id!=""){
      $.ajax({
          type: "GET",
          url: "/rockpay/technical/cashfree-edit-route/" + id,
          dataType: "json",
          success: function(response) {
              $("#cashfree-routing-form")[0].reset();
              if(typeof response !="undefined" && Object.keys(response).length > 0){
                  $.each(response[response.length-1],function(key,value){
                      if($("#cashfree-routing-form select[name="+key+"]").length > 0){
                          $("#cashfree-routing-form select[name="+key+"]").val(value);
                      }
                      $("#cashfree-routing-form input[name="+key+"]").val(value);
                  });
                  $("#cashfree-routing-form input[type='submit']").val("Edit Cashfree Route");
                  $("#cashfree-route-modal").modal({ show: true, backdrop: "static", keyboard: false });
              }
          }
      });
  }
}


//Technical Menu javascript functionality ends here


//Networking Menu javascript functionality starts here
$("#call-system-info-modal").click(function(e) {
  e.preventDefault();
  $("#system-info-modal").modal({ show: true, backdrop: 'static', keyboard: false });
});
//Networking Meny javascript functionality ends here

//Support javascript functionality starts here
function getMerchantStatus() {
  $.ajax({
      type: "GET",
      url: "/rockpay/support/merchant/status",
      dataType: "html",
      success: function(response) {
          $("#paginate_merchantlist").html(response);
      }
  });
}

function getMerchantSupport() {
  $.ajax({
      type: "GET",
      url: "/rockpay/support/merchant/support-list",
      dataType: "html",
      success: function(response) {
          $("#paginate_merchantsupport").html(response);
      }
  });
}
$("#support-form").submit(function(e) {
  e.preventDefault();
  var formdata = $("#support-form")[0];
  var data = new FormData(formdata);
  $.ajax({
      url: "/rockpay/support/call-list/merchant-support/add",
      type: "POST",
      data: data,
      processData: false,
      contentType: false,
      cache: false,
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#ajax-support-response").html(response.message).css({ "color": "green" });
          } else {
              $.each(response.error, function(name, value) {
                  $("#support-form #ajax-" + name + "-error").html(value).css({ "color": "red" });
                  $("#support-form input[name=" + name + "]").on("click", function(e) {
                      $("#support-form #ajax-" + name + "-error").html("")
                  });
                  $("#support-form select").on("click", function(e) {
                      $("#support-form #ajax_" + name + "_error").html("");
                  });
              });
          }
      },
      error: function() {},
      complete: function() {
          setTimeout(() => {
              $("#ajax-support-response").html("");
          }, 1500);
      }
  })
});

$("#call-support-from").submit(function(e) {
  e.preventDefault();
  var formdata = $("#call-support-from").serializeArray();
  var formvalidate = false;
  var mandatoryFields = ["sup_category", "sup_title", "sup_description", "merchant_id", "merchant_mobile", "marchant_email"];
  var mandatory = {
      "sup_category": "Support Category",
      "sup_title": "Title",
      "sup_description": "Description",
      "merchant_id": "Merchant Id",
      "merchant_mobile": "Merchant Mobile",
      "marchant_email": "Merchant Email",
  };

  $.each(formdata, function(indexInArray, valueOfElement) {
      if ($.inArray(valueOfElement.name, mandatoryFields) > -1) {
          if (valueOfElement.value == "") {
              $("#" + valueOfElement.name + "_ajax_error").html("Field " + mandatory[valueOfElement.name] + " is mandatory").css({ "color": "red" });
              $("#" + valueOfElement.name).click(function(e) {
                  $("#" + valueOfElement.name + "_ajax_error").html("");
              });
              formvalidate = false;
              return false;
          } else {
              formvalidate = true;
          }
      }
  });
  if (formvalidate) {
      $.ajax({
          type: "POST",
          url: "/rockpay/support/call-list/support/new",
          data: getJsonObject(formdata),
          dataType: "json",
          success: function(response) {
              if (response.status) {
                  $("#call-support-ajax-response").html(response.message).css({ "color": "green" });
              }
          },
          complete: function() {
              setTimeout(() => {
                  $("#call-support-ajax-response").html("");
              }, timeout);
          }
      });
  }
})

function getAllCallSupports() {
  $.ajax({
      type: "GET",
      url: "/rockpay/support/call-list/support/get",
      dataType: "html",
      success: function(response) {
          $("#paginate_merchantcallsupport").html(response);
      }
  });
}

function getAllLockedAccounts() {
  $.ajax({
      type: "GET",
      url: "/rockpay/support/merchant/locked-accounts/get",
      dataType: "html",
      success: function(response) {
          $("#paginate_lockedmerchant").html(response);
      }
  });
}

function unlockMerchantAccount(merchantId) {
  $.ajax({
      type: "GET",
      url: "/rockpay/support/merchant/unlock-account/" + merchantId,
      dataType: "json",
      success: function(response) {
          $("#merchant-unlock-message").html(response.message);
          $("#merchant-unlock-response").modal({ show: true, backdrop: 'static', keyboard: false });
          getAllLockedAccounts();
      }
  });
}

$("[data-target='#locked-status']").click(function(e) {
  e.preventDefault();
  getAllLockedAccounts();
});

//Support javascript functionality ends here

//Marketing javascript functionality starts here

$("[data-target='#content-writer']").click(function(e) {
  e.preventDefault();
  getAllPost();
});
$("#call-post-modal").click(function(e) {
  e.preventDefault();
  $("#add-a-post-blog-form")[0].reset();
  $("#add-a-post-blog-form button[type='submit']").html("Post");
  $("#add-a-post-blog-form #description").summernote('code', "");
  $("#show-image-upload").show();
  $("#file-2").prop("disabled", false);
  $("#id").val("");
  $("#show-image").hide();
  $("#blog-post-modal").modal({ show: true, backdrop: 'static', keyboard: false });
});

$("#add-a-post-blog-form").submit(function(e) {
  e.preventDefault();
  if ($("#id").val() == "") {
      addPost();
  } else {
      updatePost();
  }

});

function addPost() {
  var formdata = $("#add-a-post-blog-form")[0];
  var data = new FormData(formdata);
  $.ajax({
      type: "POST",
      url: "/rockpay/marketing/add-post",
      cache: false,
      contentType: false,
      processData: false,
      data: data,
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#add-a-post-blog-form-success").html(response.message).css({ "color": "green" });
              $("#add-a-post-blog-form")[0].reset();
              getAllPost();
          } else {

              if (typeof response.errors != undefined && Object.keys(response.errors).length > 0) {
                  $.each(response.errors, function(indexInArray, valueOfElement) {
                      $("#add-a-post-blog-form #" + indexInArray + "_error").html(valueOfElement[0]).css({ "color": "red" });
                      $("#add-a-post-blog-form textarea[name=" + indexInArray + "]").click(function(e) {
                          e.preventDefault();
                          $("#add-a-post-blog-form #" + indexInArray + "_error").html("");
                      });
                      $("#add-a-post-blog-form select[name=" + indexInArray + "]").click(function(e) {
                          e.preventDefault();
                          $("#add-a-post-blog-form #" + indexInArray + "_error").html("");
                      });
                      $("#add-a-post-blog-form input[name=" + indexInArray + "]").click(function() {
                          $("#add-a-post-blog-form #" + indexInArray + "_error").html("");
                      });

                  });
              }

          }
      },
      complete: function() {
          setTimeout(() => {
              $("#add-a-post-blog-form-success").html("");
          }, timeout);
      }
  });
}

function getAllPost() {
  $.ajax({
      type: "GET",
      url: "/rockpay/marketing/get-all-posts",
      dataType: "html",
      success: function(response) {
          $("#paginate_blogpost").html(response);
      }
  });
}

function editPost(id) {
  $.ajax({
      type: "GET",
      url: "/rockpay/marketing/edit-post/" + id,
      dataType: "json",
      success: function(response) {
          if (Object.keys(response).length > 0) {
              $.each(response[Object.keys(response).length - 1], function(indexInArray, valueOfElement) {
                  if (indexInArray != 'image') {
                      $("#add-a-post-blog-form input[name=" + indexInArray + "]").val(valueOfElement);
                      $("#add-a-post-blog-form select[name=" + indexInArray + "]").val(valueOfElement);
                  }
                  if (indexInArray == 'image') {
                      //$("#download-blog-image").attr("href","/download/blog/"+valueOfElement);
                      var imageElement = '<img src=/thumbnails/blog/' + valueOfElement + ' width=250px height=250px/>';
                      $("#download-blog-image").tooltip({ content: imageElement, my: "center bottom-40", at: "center top" });
                      $("#post-image-name").html(valueOfElement);
                      //$("#download-blog-image").tooltip({content:'<img src="/thumbnails/mobipayment.png"/>'}); 
                  }
                  if ($("#add-a-post-blog-form textarea[name=" + indexInArray + "]").length > 0) {
                      //$("#add-a-post-blog-form textarea[name="+indexInArray+"]").html(valueOfElement);
                      $("#add-a-post-blog-form #description").summernote('code', valueOfElement);
                  }

              });
          }
          $("#blog-post-modal").modal({ show: true, backdrop: 'static', keyboard: false });
          $("#show-image-upload").hide();
          $("#file-2").prop("disabled", true);
          $("#show-image").show();
          $("#add-a-post-blog-form button[type='submit']").html("Update Post");
      }
  });
}

$("#remove-blog-image").click(function(e) {
  e.preventDefault();
  var imageName = $("#post-image-name").html();
  if (confirm('You can not undo this action click ok to continue')) {
      $.ajax({
          type: "GET",
          url: "/rockpay/marketing/remove-post-image/" + imageName,
          data: "data",
          dataType: "json",
          success: function(response) {
              if (response.status) {
                  $("#file-2").prop("disabled", false);
                  $("#show-image-upload").show()
                  $("#show-image").hide();
              }
          }
      });
  }

});

function updatePost() {
  var formdata = $("#add-a-post-blog-form")[0];
  var data = new FormData(formdata);
  $.ajax({
      type: "POST",
      url: "/rockpay/marketing/update-post",
      cache: false,
      contentType: false,
      processData: false,
      data: data,
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#add-a-post-blog-form-success").html(response.message).css({ "color": "green" });
              getAllPost();
          } else {

              if (typeof response.errors != undefined && Object.keys(response.errors).length > 0) {
                  $.each(response.errors, function(indexInArray, valueOfElement) {
                      $("#add-a-post-blog-form #" + indexInArray + "_error").html(valueOfElement[0]).css({ "color": "red" });
                      $("#add-a-post-blog-form textarea[name=" + indexInArray + "]").click(function(e) {
                          e.preventDefault();
                          $("#add-a-post-blog-form #" + indexInArray + "_error").html("");
                      });
                      $("#add-a-post-blog-form select[name=" + indexInArray + "]").click(function(e) {
                          e.preventDefault();
                          $("#add-a-post-blog-form #" + indexInArray + "_error").html("");
                      });
                      $("#add-a-post-blog-form input[name=" + indexInArray + "]").click(function() {
                          $("#add-a-post-blog-form #" + indexInArray + "_error").html("");
                      });

                  });
              }

          }
      },
      complete: function() {
          setTimeout(() => {
              $("#add-a-post-blog-form-success").html("");
          }, timeout);
      }
  });
}

function callRemovePostModel(postid) {
  $("#delete-post-modal").modal({ show: true, backdrop: 'static', keyboard: false });
  $("#delete-post-modal #id").val(postid);
}


$("#delete-post-form").submit(function(e) {
  e.preventDefault();
  var formdata = $("#delete-post-form").serializeArray();
  $.ajax({
      type: "POST",
      url: "/rockpay/marketing/remove-post",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          getAllPost();
          $("#delete-post-modal").modal("hide");
      }
  });
});


$("[data-target='#contact']").click(function(e) {
  e.preventDefault();
  getAllContactus();
});

$("[data-target='#subscribe']").click(function(e) {
  e.preventDefault();
  getAllSubscribe();
});

function getAllContactus(perpage = 10) {

  $.ajax({
      type: "GET",
      url: "/rockpay/merketing/contact/get/" + perpage,
      dataType: "html",
      success: function(response) {
          $("#paginate_lead").html(response);
      }
  });
}

function getAllSubscribe(perpage = 10) {

  $.ajax({
      type: "GET",
      url: "/rockpay/merketing/subscribe/get/" + perpage,
      dataType: "html",
      success: function(response) {
          $("#paginate_subscribe").html(response);
      }
  });
}

$("#call-gallery-modal").click(function(e) {
  e.preventDefault();
  $("#add-gallery-modal").modal({ show: true, backdrop: 'static', keyboard: false });
});

function enableInput(element) {
  if ($(element).val() == "73" || $(element).val() == "74") {
      $("#add-gallery-form #show-content-input").show();
      $("#add-gallery-form #show-heading-input").hide();
      $("#add-gallery-form input[name='image_heading']").prop("disabled", true);
      $("#add-gallery-form input[name='image_content']").prop("disabled", false);
  } else {
      $("#add-gallery-form #show-heading-input").show();
      $("#add-gallery-form #show-content-input").hide();
      $("#add-gallery-form input[name='image_content']").prop("disabled", true);
      $("#add-gallery-form input[name='image_heading']").prop("disabled", false);
  }

}

$("[data-target='#gallery']").click(function(e) {
  e.preventDefault();
  getGalleryImages();
});


function getGalleryImages(perpage = 10) {
  $.ajax({
      type: "GET",
      url: "/rockpay/merketing/gallery/get/" + perpage,
      dataType: "html",
      success: function(response) {
          $("#paginate_image").html(response)
      }
  });
}

$("#add-gallery-form").submit(function(e) {
  e.preventDefault();
  var formdata = $(this)[0];
  var data = new FormData(formdata);
  $.ajax({
      type: "POST",
      url: "/rockpay/merketing/gallery/add",
      cache: false,
      contentType: false,
      processData: false,
      data: data,
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#add-gallery-image-success").html(response.message);
              $("#add-gallery-form")[0].reset();
              getGalleryImages();
          } else {

              if (typeof response.errors != "undefined" && Object.keys(response.errors).length > 0) {
                  $.each(response.errors, function(key, error) {
                      $("#add-gallery-form #" + key + "_error").html(error[0]);
                      $("#add-gallery-form input[name=" + key + "]").click(function() {
                          $("#add-gallery-form #" + key + "_error").html("");
                      });
                  });
              } else {
                  $("#add-gallery-image-failed").html(response.message);
              }

          }
      },
      complete: function() {
          setTimeout(() => {
              $("#add-gallery-image-success").html("");
              $("#add-gallery-image-failed").html("");
          }, timeout);
      }
  });
});

function editGalleryImage(imageid) {
  $.ajax({
      type: "GET",
      url: "/rockpay/merketing/gallery/edit/" + imageid,
      dataType: "json",
      success: function(response) {
          if (Object.keys(response).length > 0) {
              $.each(response[response.length - 1], function(key, value) {
                  if (key != "image_name") {
                      $("#edit-gallery-form select[name=" + key + "]").val(value);
                      $("#edit-gallery-form input[name=" + key + "]").val(value);
                      if (key == "image_content" && value != "") {
                          $("#edit-gallery-form textarea[name=" + key + "]").summernote('code', value);
                          $("#edit-gallery-form #show-content-input").show();
                          $("#edit-gallery-form #show-heading-input").hide();
                          $("#edit-gallery-form input[name='image_heading']").prop("disabled", true);
                          $("#edit-gallery-form input[name='image_content']").prop("disabled", false);
                      } else if (key == "image_heading" && value != "") {
                          $("#edit-gallery-form #show-heading-input").show();
                          $("#edit-gallery-form #show-content-input").hide();
                          $("#edit-gallery-form input[name='image_content']").prop("disabled", true);
                          $("#edit-gallery-form input[name='image_heading']").prop("disabled", false);
                      }
                  } else {
                      var imageElement = '<img src=/images/gallery/' + value + ' width=250px height=250px/>';
                      $("#edit-gallery-form #download-gallery-image").tooltip({ content: imageElement, my: "center bottom-40", at: "center top" });
                      $("#edit-gallery-form #post-image-name").html(value);
                      $("#edit-gallery-form #show-image").show();
                      $("#upload-image").hide();
                      $("#edit-gallery-form input[name='image_name']").prop("disabled", true);
                  }
              });

              $("#edit-gallery-modal").modal({ show: true, backdrop: "static", keyboard: false });
          }
      }
  });
}

$("#remove-gallery-image").click(function(e) {
  e.preventDefault();
  var imageName = $("#edit-gallery-form #post-image-name").html();
  if (confirm('You can not undo this action click ok to continue')) {
      $.ajax({
          type: "GET",
          url: "/rockpay/marketing/remove-gallery-image/" + imageName,
          data: "data",
          dataType: "json",
          success: function(response) {
              if (response.status) {
                  $("#upload-image").show();
                  $("#edit-gallery-form input[name='image_name']").prop("disabled", false);
                  $("#edit-gallery-form #show-image").hide();
              }
          }
      });
  }
});

$("#edit-gallery-form").submit(function(e) {
  e.preventDefault();
  var formdata = $(this)[0];
  var data = new FormData(formdata);
  $.ajax({
      type: "POST",
      url: "/rockpay/marketing/gallery/update",
      cache: false,
      contentType: false,
      processData: false,
      data: data,
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#edit-gallery-image-success").html(response.message);
          } else {

              if (typeof response.errors != "undefined" && Object.keys(response.errors).length > 0) {
                  $.each(response.errors, function(key, error) {
                      $("#edit-gallery-form #" + key + "_error").html(error[0]);
                      $("#edit-gallery-form input[name=" + key + "]").click(function() {
                          $("#edit-gallery-form #" + key + "_error").html("");
                      });
                  });
              } else {
                  $("#edit-gallery-image-failed").html(response.message);
              }

          }
      },
      complete: function() {
          setTimeout(() => {
              $("#edit-gallery-image-success").html("");
              $("#edit-gallery-image-failed").html("");
          }, timeout);
      }
  });

});

$("[data-target='#events']").click(function(e) {
  e.preventDefault();
  getAllEventPost();
});

$("#call-event-post-modal").click(function(e) {
  e.preventDefault();
  $("#add-a-post-event-form")[0].reset();
  $("#add-a-post-event-form button[type='submit']").html("Post");
  $("#add-a-post-event-form #event_description").summernote('code', "");
  $("#add-a-post-event-form #show-image-upload").show();
  $("#add-a-post-event-form #file-2").prop("disabled", false);
  $("#add-a-post-event-form #id").val("");
  $("#add-a-post-event-form #show-image").hide();
  $("#event-post-modal").modal({ show: true, backdrop: 'static', keyboard: false });
});

$("#add-a-post-event-form").submit(function(e) {
  e.preventDefault();
  if ($("#add-a-post-event-form #id").val() == "") {
      addEventPost();
  } else {
      updateEventPost();
  }

});

function addEventPost() {
  var formdata = $("#add-a-post-event-form")[0];
  var data = new FormData(formdata);
  $.ajax({
      type: "POST",
      url: "/rockpay/marketing/event/add-post",
      cache: false,
      contentType: false,
      processData: false,
      data: data,
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#add-a-post-event-form-success").html(response.message).css({ "color": "green" });
              $("#add-a-post-event-form")[0].reset();
              $("#add-a-post-event-form #event_description").summernote('code', "");
              getAllEventPost();
          } else {

              if (typeof response.errors != undefined && Object.keys(response.errors).length > 0) {
                  $.each(response.errors, function(indexInArray, valueOfElement) {
                      $("#add-a-post-event-form #" + indexInArray + "_error").html(valueOfElement[0]).css({ "color": "red" });
                      $("#add-a-post-event-form textarea[name=" + indexInArray + "]").click(function(e) {
                          e.preventDefault();
                          $("#add-a-post-event-form #" + indexInArray + "_error").html("");
                      });
                      $("#add-a-post-event-form input[name=" + indexInArray + "]").click(function() {
                          $("#add-a-post-event-form #" + indexInArray + "_error").html("");
                      });

                  });
              }

          }
      },
      complete: function() {
          setTimeout(() => {
              $("#add-a-post-event-form-success").html("");
              $("#add-a-post-event-form #event_description_error").html("");
          }, timeout);
      }
  });
}

function getAllEventPost() {
  $.ajax({
      type: "GET",
      url: "/rockpay/marketing/event/get-all-posts",
      dataType: "html",
      success: function(response) {
          $("#paginate_eventpost").html(response);
      }
  });
}

function editEventPost(id) {
  $.ajax({
      type: "GET",
      url: "/rockpay/marketing/event/edit-post/" + id,
      dataType: "json",
      success: function(response) {
          if (Object.keys(response).length > 0) {
              $.each(response[Object.keys(response).length - 1], function(indexInArray, valueOfElement) {
                  if (indexInArray != 'event_image' && indexInArray != 'event_register') {
                      $("#add-a-post-event-form input[name=" + indexInArray + "]").val(valueOfElement);
                      $("#add-a-post-event-form select[name=" + indexInArray + "]").val(valueOfElement);
                  }
                  if (indexInArray == 'event_register') {
                      $("#add-a-post-event-form input[name=" + indexInArray + "][value=" + valueOfElement + "]").prop("checked", true);
                  }
                  if (indexInArray == 'event_image') {
                      var imageElement = '<img src=/thumbnails/event/' + valueOfElement + ' width=250px height=250px/>';
                      $("#download-event-image").tooltip({ content: imageElement, my: "center bottom-40", at: "center top" });
                      $("#add-a-post-event-form #post-image-name").html(valueOfElement);
                  }
                  if ($("#add-a-post-event-form textarea[name=" + indexInArray + "]").length > 0) {
                      $("#add-a-post-event-form textarea[name=" + indexInArray + "]").val(valueOfElement);
                      $("#add-a-post-event-form #event_description").summernote('code', valueOfElement);
                  }

              });
          }
          $("#event-post-modal").modal({ show: true, backdrop: 'static', keyboard: false });
          $("#add-a-post-event-form #show-image-upload").hide();
          $("#add-a-post-event-form #file-2").prop("disabled", true);
          $("#add-a-post-event-form #show-image").show();
          $("#add-a-post-event-form button[type='submit']").html("Update Post");
      }
  });
}

$("#remove-event-image").click(function(e) {
  e.preventDefault();
  var imageName = $("#add-a-post-event-form #post-image-name").html();
  if (confirm('You can not undo this action click ok to continue')) {
      $.ajax({
          type: "GET",
          url: "/rockpay/marketing/event/remove-post-image/" + imageName,
          data: "data",
          dataType: "json",
          success: function(response) {
              if (response.status) {
                  $("#add-a-post-event-form #file-2").prop("disabled", false);
                  $("#add-a-post-event-form #show-image-upload").show()
                  $("#add-a-post-event-form #show-image").hide();
              }
          }
      });
  }

});

function updateEventPost() {
  var formdata = $("#add-a-post-event-form")[0];
  var data = new FormData(formdata);
  $.ajax({
      type: "POST",
      url: "/rockpay/marketing/event/update-post",
      cache: false,
      contentType: false,
      processData: false,
      data: data,
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#add-a-post-event-form-success").html(response.message).css({ "color": "green" });
              getAllEventPost();
          } else {

              if (typeof response.errors != undefined && Object.keys(response.errors).length > 0) {
                  $.each(response.errors, function(indexInArray, valueOfElement) {
                      $("#add-a-post-event-form #" + indexInArray + "_error").html(valueOfElement[0]).css({ "color": "red" });
                      $("#add-a-post-event-form textarea[name=" + indexInArray + "]").click(function(e) {
                          e.preventDefault();
                          $("#add-a-post-event-form #" + indexInArray + "_error").html("");
                      });
                      $("#add-a-post-event-form select[name=" + indexInArray + "]").click(function(e) {
                          e.preventDefault();
                          $("#add-a-post-event-form #" + indexInArray + "_error").html("");
                      });
                      $("#add-a-post-event-form input[name=" + indexInArray + "]").click(function() {
                          $("#add-a-post-event-form #" + indexInArray + "_error").html("");
                      });

                  });
              }

          }
      },
      complete: function() {
          setTimeout(() => {
              $("#add-a-post-event-form-success").html("");
          }, timeout);
      }
  });
}

function callRemoveEventPostModel(postid) {
  $("#delete-event-modal").modal({ show: true, backdrop: 'static', keyboard: false });
  $("#delete-event-modal #id").val(postid);
}


$("#delete-event-form").submit(function(e) {
  e.preventDefault();
  var formdata = $("#delete-event-form").serializeArray();
  $.ajax({
      type: "POST",
      url: "/rockpay/marketing/event/remove-post",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          getAllEventPost();
          $("#delete-event-modal").modal("hide");
      }
  });
});


$("[data-target='#csrblog']").click(function(e) {
  e.preventDefault();
  getAllCSRPost();
});

$("#call-csr-post-modal").click(function(e) {
  e.preventDefault();

  $("#add-a-post-csr-form")[0].reset();
  $("#add-a-post-csr-form button[type='submit']").html("Post");
  $("#add-a-post-csr-form #description").summernote('code', "");
  $("#add-a-post-csr-form #show-image-upload").show();
  $("#add-a-post-csr-form #file-2").prop("disabled", false);
  $("#add-a-post-csr-form #id").val("");
  $("#add-a-post-csr-form #show-image").hide();
  $("#csr-post-modal").modal({ show: true, backdrop: 'static', keyboard: false });
});

$("#add-a-post-csr-form").submit(function(e) {
  e.preventDefault();
  if ($("#add-a-post-csr-form #id").val() == "") {
      addCSRPost();
  } else {
      updateCSRPost();
  }

});

function addCSRPost() {
  var formdata = $("#add-a-post-csr-form")[0];
  var data = new FormData(formdata);
  $.ajax({
      type: "POST",
      url: "/rockpay/marketing/csr/add-post",
      cache: false,
      contentType: false,
      processData: false,
      data: data,
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#add-a-post-csr-form-success").html(response.message).css({ "color": "green" });
              $("#add-a-post-csr-form #description").summernote("code", "");
              $("#add-a-post-csr-form")[0].reset();
              getAllCSRPost();
          } else {

              if (typeof response.errors != undefined && Object.keys(response.errors).length > 0) {
                  $.each(response.errors, function(indexInArray, valueOfElement) {
                      $("#add-a-post-csr-form #" + indexInArray + "_error").html(valueOfElement[0]).css({ "color": "red" });
                      $("#add-a-post-csr-form textarea[name=" + indexInArray + "]").click(function(e) {
                          e.preventDefault();
                          $("#add-a-post-csr-form #" + indexInArray + "_error").html("");
                      });
                      $("#add-a-post-csr-form select[name=" + indexInArray + "]").click(function(e) {
                          e.preventDefault();
                          $("#add-a-post-csr-form #" + indexInArray + "_error").html("");
                      });
                      $("#add-a-post-csr-form input[name=" + indexInArray + "]").click(function() {
                          $("#add-a-post-csr-form #" + indexInArray + "_error").html("");
                      });

                  });
              }

          }
      },
      complete: function() {
          setTimeout(() => {
              $("#add-a-post-csr-form-success").html("");
          }, timeout);
      }
  });
}

function getAllCSRPost() {
  $.ajax({
      type: "GET",
      url: "/rockpay/marketing/csr/get-all-posts",
      dataType: "html",
      success: function(response) {
          $("#paginate_csrpost").html(response);
      }
  });
}

function editCSRPost(id) {
  $.ajax({
      type: "GET",
      url: "/rockpay/marketing/csr/edit-post/" + id,
      dataType: "json",
      success: function(response) {
          if (Object.keys(response).length > 0) {
              $.each(response[Object.keys(response).length - 1], function(indexInArray, valueOfElement) {
                  if (indexInArray != 'image') {
                      $("#add-a-post-csr-form input[name=" + indexInArray + "]").val(valueOfElement);
                      $("#add-a-post-csr-form select[name=" + indexInArray + "]").val(valueOfElement);
                  }
                  if (indexInArray == 'image') {
                      //$("#download-blog-image").attr("href","/download/blog/"+valueOfElement);
                      var imageElement = '<img src=/thumbnails/csr/' + valueOfElement + ' width=250px height=250px/>';
                      $("#add-a-post-csr-form #download-blog-image").tooltip({ content: imageElement, my: "center bottom-40", at: "center top" });
                      $("#add-a-post-csr-form #post-image-name").html(valueOfElement);
                      //$("#download-blog-image").tooltip({content:'<img src="/thumbnails/mobipayment.png"/>'}); 
                  }
                  if ($("#add-a-post-csr-form textarea[name=" + indexInArray + "]").length > 0) {
                      //$("#add-a-post-blog-form textarea[name="+indexInArray+"]").html(valueOfElement);
                      $("#add-a-post-csr-form #description").summernote('code', valueOfElement);
                  }

              });
          }
          $("#csr-post-modal").modal({ show: true, backdrop: 'static', keyboard: false });
          $("#add-a-post-csr-form #show-image-upload").hide();
          $("#add-a-post-csr-form #file-2").prop("disabled", true);
          $("#add-a-post-csr-form #show-image").show();
          $("#add-a-post-csr-form button[type='submit']").html("Update Post");
      }
  });
}

$("#remove-csr-image").click(function(e) {
  e.preventDefault();
  var imageName = $("#add-a-post-csr-form #post-image-name").html();
  if (confirm('You can not undo this action click ok to continue')) {
      $.ajax({
          type: "GET",
          url: "/rockpay/marketing/csr/remove-post-image/" + imageName,
          data: "data",
          dataType: "json",
          success: function(response) {
              if (response.status) {
                  $("#add-a-post-csr-form #show-image-upload").show()
                  $("#add-a-post-csr-form #show-image").hide();
                  $("#add-a-post-csr-form #file-2").prop("disabled", false);
              }
          }
      });
  }

});

function updateCSRPost() {
  var formdata = $("#add-a-post-csr-form")[0];
  var data = new FormData(formdata);
  $.ajax({
      type: "POST",
      url: "/rockpay/marketing/csr/update-post",
      cache: false,
      contentType: false,
      processData: false,
      data: data,
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#add-a-post-csr-form-success").html(response.message).css({ "color": "green" });
              getAllCSRPost();
          } else {

              if (typeof response.errors != undefined && Object.keys(response.errors).length > 0) {
                  $.each(response.errors, function(indexInArray, valueOfElement) {
                      $("#add-a-post-csr-form #" + indexInArray + "_error").html(valueOfElement[0]).css({ "color": "red" });
                      $("#add-a-post-csr-form textarea[name=" + indexInArray + "]").click(function(e) {
                          e.preventDefault();
                          $("#add-a-post-csr-form #" + indexInArray + "_error").html("");
                      });
                      $("#add-a-post-csr-form select[name=" + indexInArray + "]").click(function(e) {
                          e.preventDefault();
                          $("#add-a-post-csr-form #" + indexInArray + "_error").html("");
                      });
                      $("#add-a-post-csr-form input[name=" + indexInArray + "]").click(function() {
                          $("#add-a-post-csr-form #" + indexInArray + "_error").html("");
                      });

                  });
              }

          }
      },
      complete: function() {
          setTimeout(() => {
              $("#add-a-post-csr-form-success").html("");
          }, timeout);
      }
  });
}

function callRemoveCSRPostModel(postid) {
  $("#delete-csr-post-modal #id").val(postid);
  $("#delete-csr-post-modal").modal({ show: true, backdrop: 'static', keyboard: false });
}


$("#delete-csr-post-form").submit(function(e) {
  e.preventDefault();
  var formdata = $("#delete-csr-post-form").serializeArray();
  $.ajax({
      type: "POST",
      url: "/rockpay/marketing/csr/remove-post",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          getAllCSRPost();
          $("#delete-csr-post-modal").modal("hide");
      }
  });
});


$("[data-target='#press-release']").click(function(e) {
  e.preventDefault();
  getAllPRPost();
});

$("#call-pr-post-modal").click(function(e) {
  e.preventDefault();

  $("#add-a-post-pr-form")[0].reset();
  $("#add-a-post-pr-form button[type='submit']").html("Post");
  $("#add-a-post-pr-form #description").summernote('code', "");
  $("#add-a-post-pr-form #show-image-upload").show();
  $("#add-a-post-pr-form #file-2").prop("disabled", false);
  $("#add-a-post-pr-form #id").val("");
  $("#add-a-post-pr-form #show-image").hide();
  $("#pr-post-modal").modal({ show: true, backdrop: 'static', keyboard: false });
});

$("#add-a-post-pr-form").submit(function(e) {
  e.preventDefault();
  if ($("#add-a-post-pr-form #id").val() == "") {
      addPRPost();
  } else {
      updatePRPost();
  }

});

function addPRPost() {
  var formdata = $("#add-a-post-pr-form")[0];
  var data = new FormData(formdata);
  $.ajax({
      type: "POST",
      url: "/rockpay/marketing/pr/add-post",
      cache: false,
      contentType: false,
      processData: false,
      data: data,
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#add-a-post-pr-form-success").html(response.message).css({ "color": "green" });
              $("#add-a-post-pr-form #description").summernote("code", "");
              $("#add-a-post-pr-form")[0].reset();
              getAllPRPost();
          } else {

              if (typeof response.errors != undefined && Object.keys(response.errors).length > 0) {
                  $.each(response.errors, function(indexInArray, valueOfElement) {
                      $("#add-a-post-pr-form #" + indexInArray + "_error").html(valueOfElement[0]).css({ "color": "red" });
                      $("#add-a-post-pr-form textarea[name=" + indexInArray + "]").click(function(e) {
                          e.preventDefault();
                          $("#add-a-post-pr-form #" + indexInArray + "_error").html("");
                      });
                      $("#add-a-post-pr-form select[name=" + indexInArray + "]").click(function(e) {
                          e.preventDefault();
                          $("#add-a-post-pr-form #" + indexInArray + "_error").html("");
                      });
                      $("#add-a-post-pr-form input[name=" + indexInArray + "]").click(function() {
                          $("#add-a-post-pr-form #" + indexInArray + "_error").html("");
                      });

                  });
              }

          }
      },
      complete: function() {
          setTimeout(() => {
              $("#add-a-post-pr-form-success").html("");
          }, timeout);
      }
  });
}

function getAllPRPost() {
  $.ajax({
      type: "GET",
      url: "/rockpay/marketing/pr/get-all-posts",
      dataType: "html",
      success: function(response) {
          $("#paginate_prpost").html(response);
      }
  });
}

function editPRPost(id) {
  $.ajax({
      type: "GET",
      url: "/rockpay/marketing/pr/edit-post/" + id,
      dataType: "json",
      success: function(response) {
          if (Object.keys(response).length > 0) {
              $.each(response[Object.keys(response).length - 1], function(indexInArray, valueOfElement) {
                  if (indexInArray != 'image') {
                      $("#add-a-post-pr-form input[name=" + indexInArray + "]").val(valueOfElement);
                      $("#add-a-post-pr-form select[name=" + indexInArray + "]").val(valueOfElement);
                  }
                  if (indexInArray == 'image') {
                      //$("#download-blog-image").attr("href","/download/blog/"+valueOfElement);
                      var imageElement = '<img src=/thumbnails/press-release/' + valueOfElement + ' width=250px height=250px/>';
                      $("#add-a-post-pr-form #download-blog-image").tooltip({ content: imageElement, my: "center bottom-40", at: "center top" });
                      $("#add-a-post-pr-form #post-image-name").html(valueOfElement);
                      //$("#download-blog-image").tooltip({content:'<img src="/thumbnails/mobipayment.png"/>'}); 
                  }
                  if ($("#add-a-post-pr-form textarea[name=" + indexInArray + "]").length > 0) {
                      //$("#add-a-post-blog-form textarea[name="+indexInArray+"]").html(valueOfElement);
                      $("#add-a-post-pr-form #description").summernote('code', valueOfElement);
                  }

              });
          }
          $("#pr-post-modal").modal({ show: true, backdrop: 'static', keyboard: false });
          $("#add-a-post-pr-form #show-image-upload").hide();
          $("#add-a-post-pr-form #file-2").prop("disabled", true);
          $("#add-a-post-pr-form #show-image").show();
          $("#add-a-post-pr-form button[type='submit']").html("Update Post");
      }
  });
}

$("#remove-pr-image").click(function(e) {
  e.preventDefault();
  var imageName = $("#add-a-post-pr-form #post-image-name").html();
  if (confirm('You can not undo this action click ok to continue')) {
      $.ajax({
          type: "GET",
          url: "/rockpay/marketing/pr/remove-post-image/" + imageName,
          data: "data",
          dataType: "json",
          success: function(response) {
              if (response.status) {
                  $("#add-a-post-pr-form #show-image-upload").show()
                  $("#add-a-post-pr-form #show-image").hide();
                  $("#add-a-post-pr-form #file-2").prop("disabled", false);
              }
          }
      });
  }

});

function updatePRPost() {
  var formdata = $("#add-a-post-pr-form")[0];
  var data = new FormData(formdata);
  $.ajax({
      type: "POST",
      url: "/rockpay/marketing/pr/update-post",
      cache: false,
      contentType: false,
      processData: false,
      data: data,
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#add-a-post-pr-form-success").html(response.message).css({ "color": "green" });
              getAllPRPost();
          } else {

              if (typeof response.errors != undefined && Object.keys(response.errors).length > 0) {
                  $.each(response.errors, function(indexInArray, valueOfElement) {
                      $("#add-a-post-pr-form #" + indexInArray + "_error").html(valueOfElement[0]).css({ "color": "red" });
                      $("#add-a-post-pr-form textarea[name=" + indexInArray + "]").click(function(e) {
                          e.preventDefault();
                          $("#add-a-post-pr-form #" + indexInArray + "_error").html("");
                      });
                      $("#add-a-post-pr-form select[name=" + indexInArray + "]").click(function(e) {
                          e.preventDefault();
                          $("#add-a-post-pr-form #" + indexInArray + "_error").html("");
                      });
                      $("#add-a-post-pr-form input[name=" + indexInArray + "]").click(function() {
                          $("#add-a-post-pr-form #" + indexInArray + "_error").html("");
                      });

                  });
              }

          }
      },
      complete: function() {
          setTimeout(() => {
              $("#add-a-post-pr-form-success").html("");
          }, timeout);
      }
  });
}

function callRemovePRPostModel(postid) {
  $("#delete-pr-post-modal #id").val(postid);
  $("#delete-pr-post-modal").modal({ show: true, backdrop: 'static', keyboard: false });
}


$("#delete-pr-post-form").submit(function(e) {
  e.preventDefault();
  var formdata = $("#delete-pr-post-form").serializeArray();
  $.ajax({
      type: "POST",
      url: "/rockpay/marketing/pr/remove-post",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          getAllPRPost();
          $("#delete-pr-post-modal").modal("hide");
      }
  });
});

//Maerketing javascript functionality ends here

//Sales javascript functionality starts here
$("#call-sales-sheet-modal").click(function(e) {
  e.preventDefault();
  $("#sales-sheet-modal").modal({ show: true, backdrop: 'static', keyboard: false });
});

function getLeadSalessheet() {
  $.ajax({
      type: "GET",
      url: "/rockpay/sales/leadsalesheet/get",
      dataType: "html",
      success: function(response) {
          $("#paginate_leadsaleslist").html(response);
      }
  });
}

function getDailySalessheet() {
  $.ajax({
      type: "GET",
      url: "/rockpay/sales/dailysalesheet/get",
      dataType: "html",
      success: function(response) {
          $("#paginate_dailysaleslist").html(response);
      }
  });
}

function getSalessheet() {
  $.ajax({
      type: "GET",
      url: "/rockpay/sales/salesheet/get",
      dataType: "html",
      success: function(response) {
          $("#paginate_saleslist").html(response);
      }
  });
}

$("[data-target='#daily-tracker']").click(function(e) {
  e.preventDefault();
  getDailySalessheet();
});

$("[data-target='#sales-sheet']").click(function(e) {
  e.preventDefault();
  getSalessheet();
});

$("#sales-sheet-form").submit(function(e) {
  e.preventDefault();
  var formdata = $("#sales-sheet-form").serializeArray();
  var madatroyFields = [
      "merchant_name", 
      "merchant_mobile", 
      "merchant_email", 
      "service_id", 
      "company_name", 
      // "business_category",
      // "state", 
      // "sale_status"
  ];
  var validateMessages = {
      "merchant_name": "Merchant Name",
      "merchant_mobile": "Merchant Mobile",
      "merchant_email": "Merchant Email",
      "service_id": "Looking For",
      "company_name": "Company Name",
      // "business_category": "Business Man",
      // "state": "State",
      //"sale_status": "Sale Status"
  };
  var formvdalidate = false;
  $.each(formdata, function(indexInArray, valueOfElement) {
      if ($.inArray(valueOfElement.name, madatroyFields) > -1) {
          if (valueOfElement.value == "") {
              $("#sales-sheet-form #" + valueOfElement.name + "_ajax_error").html("Field " + validateMessages[valueOfElement.name] + " is required").css({ "color": "red" });
              $("#sales-sheet-form input[name=" + valueOfElement.name + "]").focus();
              $("#sales-sheet-form input[name=" + valueOfElement.name + "]").click(function(e) {
                  e.preventDefault();
                  $("#sales-sheet-form #" + valueOfElement.name + "_ajax_error").html("");
              });
              $("#sales-sheet-form select").click(function(e) {
                  e.preventDefault();
                  $("#sales-sheet-form #" + valueOfElement.name + "_ajax_error").html("");
              });
              formvdalidate = false;
              return false;
          } else {
              formvdalidate = true;
          }
      }
  });

  if (formvdalidate) {
      $.ajax({
          type: "POST",
          url: "/rockpay/sales/salesheet/new",
          data: getJsonObject(formdata),
          dataType: "json",
          success: function(response) {
              if (response.status) {
                  $("#sales-sheet-form")[0].reset();
                  $("#sales-sheet-ajax-response").html(response.message).css({ "color": "green" });
              } else {
                  $("#sales-sheet-ajax-response").html(response.message).css({ "color": "red" });
              }
          },
          complete: function() {
              if ($("[data-target='#leads-sheat']").parent().hasClass("active")) {
                  getLeadSalessheet();
              } else if ($("[data-target='#daily-tracker']").parent().hasClass("active")) {
                  getDailySalessheet();
              } else {
                  getSalessheet();
              }
              setTimeout(() => {
                  $("#sales-sheet-ajax-response").html("");
              }, timeout);
          }
      });
  }
});

$("#daily-sheet-form").submit(function(e) {
  e.preventDefault();
  var formdata = $("#daily-sheet-form").serializeArray();
  var madatroyFields = [
      "merchant_name", 
      "merchant_mobile", 
      "merchant_email", 
      "service_id", 
      "company_name", 
      // "business_category",
      // "state", 
      // "sale_status"
  ];
  var validateMessages = {
      "merchant_name": "Merchant Name",
      "merchant_mobile": "Merchant Mobile",
      "merchant_email": "Merchant Email",
      "service_id": "Looking For",
      "company_name": "Company Name",
      // "business_category": "Business Man",
      // "state": "State",
      //"sale_status": "Sale Status"
  };
  var formvdalidate = false;
  $.each(formdata, function(indexInArray, valueOfElement) {
      if ($.inArray(valueOfElement.name, madatroyFields) > -1) {
          if (valueOfElement.value == "") {
              $("#daily-sheet-form #" + valueOfElement.name + "_ajax_error").html("Field " + validateMessages[valueOfElement.name] + " is required").css({ "color": "red" });
              $("#daily-sheet-form input[name=" + valueOfElement.name + "]").focus();
              $("#daily-sheet-form input[name=" + valueOfElement.name + "]").click(function(e) {
                  e.preventDefault();
                  $("#daily-sheet-form #" + valueOfElement.name + "_ajax_error").html("");
              });
              $("#daily-sheet-form select").click(function(e) {
                  e.preventDefault();
                  $("#daily-sheet-form #" + valueOfElement.name + "_ajax_error").html("");
              });
              formvdalidate = false;
              return false;
          } else {
              formvdalidate = true;
          }
      }
  });

  if (formvdalidate) {
      $.ajax({
          type: "POST",
          url: "/rockpay/sales/dailysheet/new",
          data: getJsonObject(formdata),
          dataType: "json",
          success: function(response) {
              if (response.status) {
                  $("#daily-sheet-form")[0].reset();
                  $("#daily-sheet-ajax-response").html(response.message).css({ "color": "green" });
              } else {
                  $("#daily-sheet-ajax-response").html(response.message).css({ "color": "red" });
              }
          },
          complete: function() {
              if ($("[data-target='#leads-sheat']").parent().hasClass("active")) {
                  getLeadSalessheet();
              } else if ($("[data-target='#daily-tracker']").parent().hasClass("active")) {
                  getDailySalessheet();
              } else {
                  getSalessheet();
              }
              setTimeout(() => {
                  $("#daily-sheet-ajax-response").html("");
              }, timeout);
          }
      });
  }
});


function editLeadSale(id) {
  $.ajax({
      type: "Get",
      url: "/rockpay/sales/leadsalesheet/edit/" + id,
      dataType: "json",
      success: function(response) {
          if (Object.keys(response).length > 0) {
              $.each(response[response.length - 1], function(indexInArray, valueOfElement) {
                  if ($("#sales-sheet-form select[name=" + indexInArray + "]").length > 0) {
                      $("#sales-sheet-form select[name=" + indexInArray + "]").val(valueOfElement);
                  }
                  if ($("#sales-sheet-form textarea[name=" + indexInArray + "]").length > 0) {
                      $("#sales-sheet-form textarea[name=" + indexInArray + "]").val(valueOfElement);
                  }
                  $("#sales-sheet-form input[name=" + indexInArray + "]").val(valueOfElement);
              });
              $("#sales-sheet-form .btn.btn-primary").html("Update");
              $("#sales-sheet-modal").modal({ show: true, backdrop: 'static', keyboard: false });
              //$('.nav-tabs [data-target="#daily-sheet"]').tab('show');
          }
      },
      complete: function() {

      }
  });
}

function editDailySale(id) {
  $.ajax({
      type: "Get",
      url: "/rockpay/sales/leadsalesheet/edit/" + id,
      dataType: "json",
      success: function(response) {
          if (Object.keys(response).length > 0) {
              $.each(response[response.length - 1], function(indexInArray, valueOfElement) {
                  if ($("#daily-sheet-form select[name=" + indexInArray + "]").length > 0) {
                      $("#daily-sheet-form select[name=" + indexInArray + "]").val(valueOfElement);
                  }
                  if ($("#daily-sheet-form textarea[name=" + indexInArray + "]").length > 0) {
                      $("#daily-sheet-form textarea[name=" + indexInArray + "]").val(valueOfElement);
                  }
                  $("#daily-sheet-form input[name=" + indexInArray + "]").val(valueOfElement);
              });
              $("#daily-sheet-form .btn.btn-primary").html("Update");
              $("#daily-sheet-modal").modal({ show: true, backdrop: 'static', keyboard: false });
              //$('.nav-tabs [data-target="#daily-sheet"]').tab('show');
          }
      },
      complete: function() {

      }
  });
}

function editDailySale(id) {
  $.ajax({
      type: "Get",
      url: "/rockpay/sales/dailysalesheet/edit/" + id,
      dataType: "json",
      success: function(response) {
          if (Object.keys(response).length > 0) {
              $.each(response[response.length - 1], function(indexInArray, valueOfElement) {
                  if ($("#daily-sheet-form select[name=" + indexInArray + "]").length > 0) {
                      $("#daily-sheet-form select[name=" + indexInArray + "]").val(valueOfElement);
                  }
                  if ($("#daily-sheet-form textarea[name=" + indexInArray + "]").length > 0) {
                      $("#daily-sheet-form textarea[name=" + indexInArray + "]").val(valueOfElement);
                  }
                  $("#daily-sheet-form input[name=" + indexInArray + "]").val(valueOfElement);
              });
              $("#daily-sheet-form .btn.btn-primary").html("Update");
              $("#daily-sheet-modal").modal({ show: true, backdrop: 'static', keyboard: false });
              //$('.nav-tabs [data-target="#sales-sheet"]').tab('show');
          }
      },
      complete: function() {

      }
  });
}

function editSale(id) {
  $.ajax({
      type: "Get",
      url: "/rockpay/sales/salesheet/edit/" + id,
      dataType: "json",
      success: function(response) {
          if (Object.keys(response).length > 0) {
              $.each(response[response.length - 1], function(indexInArray, valueOfElement) {
                  if ($("#sales-sheet-form select[name=" + indexInArray + "]").length > 0) {
                      $("#sales-sheet-form select[name=" + indexInArray + "]").val(valueOfElement);
                  }
                  if ($("#sales-sheet-form textarea[name=" + indexInArray + "]").length > 0) {
                      $("#sales-sheet-form textarea[name=" + indexInArray + "]").val(valueOfElement);
                  }
                  $("#sales-sheet-form input[name=" + indexInArray + "]").val(valueOfElement);
              });
              $("#sales-sheet-form .btn.btn-primary").html("Update");
              $("#sales-sheet-modal").modal({ show: true, backdrop: 'static', keyboard: false });
              //$('.nav-tabs [data-target="#sales-sheet"]').tab('show');
          }
      },
      complete: function() {

      }
  });

}

$("#call-field-sales-sheet-modal").click(function(e) {
  e.preventDefault();
  $("#field-sales-sheet-modal").modal({ show: true, backdrop: 'static', keyboard: false });
});



function getFieldLeadSalessheet() {
  var formdata = $("#merchant-transaction-form").serializeArray();
  $.ajax({
      type: "POST",
      url: "/rockpay/sales/field-lead-salesheet/get",
      data:getJsonObject(formdata),
      dataType: "html",
      success: function(response) {
          $("#paginate_fieldleadlist").html(response);
      }
  });
}
$("[data-target='#field-leads-sheat']").click(function(e) {
  e.preventDefault();
  getFieldLeadSalessheet();
});

$("[data-target='#field-daily-tracker']").click(function(e) {
  e.preventDefault();
  getFiedlDailySalessheet();
});

$("[data-target='#field-sales-sheet']").click(function(e) {
  e.preventDefault();
  getFieldSalessheet();
});

function getFiedlDailySalessheet() {
  $.ajax({
      type: "GET",
      url: "/rockpay/sales/field-daily-salesheet/get",
      dataType: "html",
      success: function(response) {
          $("#paginate_fielddailylist").html(response);
      }
  });
}

function getFieldSalessheet() {
  $.ajax({
      type: "GET",
      url: "/rockpay/sales/field-salesheet/get",
      dataType: "html",
      success: function(response) {
          $("#paginate_fieldsaleslist").html(response);
      }
  });
}


$("#fieldsales-sheet-form").submit(function(e) {
  e.preventDefault();
  var formdata = $("#fieldsales-sheet-form").serializeArray();
  var madatroyFields = ["merchant_name", "merchant_mobile", "merchant_email", "service_id", "company_name", "business_category",
      "state", "visited", "merchant_status"
  ];
  var validateMessages = {
      "merchant_name": "Merchant Name",
      "merchant_mobile": "Merchant Mobile",
      "merchant_email": "Merchant Email",
      "service_id": "Service Id",
      "company_name": "Company Name",
      "business_category": "Business Man",
      "visited": "Visited",
      "merchant_status": "Merchant Status"
  };
  var recordid = $("input[name='id']").val();
  var formvdalidate = false;
  $.each(formdata, function(indexInArray, valueOfElement) {
      if ($.inArray(valueOfElement.name, madatroyFields) > -1) {
          if (valueOfElement.value == "") {
              $("#fieldsales-sheet-form #" + valueOfElement.name + "_ajax_error").html("Field " + validateMessages[valueOfElement.name] + " is required").css({ "color": "red" });
              $("#fieldsales-sheet-form input[name=" + valueOfElement.name + "]").focus();
              $("#fieldsales-sheet-form input[name=" + valueOfElement.name + "]").click(function(e) {
                  e.preventDefault();
                  $("#fieldsales-sheet-form #" + valueOfElement.name + "_ajax_error").html("");
              });
              $("#fieldsales-sheet-form select").click(function(e) {
                  e.preventDefault();
                  $("#fieldsales-sheet-form #" + valueOfElement.name + "_ajax_error").html("");
              });
              formvdalidate = false;
              return false;
          } else {
              formvdalidate = true;
          }
      }
  });

  if (formvdalidate) {
      $.ajax({
          type: "POST",
          url: "/rockpay/sales/fieldsalesheet/new",
          data: getJsonObject(formdata),
          dataType: "json",
          success: function(response) {
              if (response.status) {
                  $("#fieldsales-sheet-form")[0].reset();
                  $("#fieldsales-sheet-ajax-response").html(response.message).css({ "color": "green" });
              } else {
                  $("#fieldsales-sheet-ajax-response").html(response.message).css({ "color": "red" });
              }
          },
          complete: function() {
              if ($("[data-target='#field-leads-sheat']").parent().hasClass("active")) {
                  getFieldLeadSalessheet()
              } else if ($("[data-target='#field-daily-tracker']").parent().hasClass("active")) {
                  getFiedlDailySalessheet();
              } else {
                  getFieldSalessheet();
              }
              setTimeout(() => {
                  $("#fieldsales-sheet-ajax-response").html("");
              }, timeout);
          }
      });
  }
})


function editFieldSale(id) {

  $.ajax({
      type: "Get",
      url: "/rockpay/sales/fieldsalesheet/edit/" + id,
      dataType: "json",
      success: function(response) {
          if (Object.keys(response).length > 0) {
              $.each(response[response.length - 1], function(indexInArray, valueOfElement) {
                  if ($("#fieldsales-sheet-form select[name=" + indexInArray + "]").length > 0) {
                      $("#fieldsales-sheet-form select[name=" + indexInArray + "]").val(valueOfElement);
                  }
                  if ($("#fieldsales-sheet-form textarea[name=" + indexInArray + "]").length > 0) {
                      $("#fieldsales-sheet-form textarea[name=" + indexInArray + "]").val(valueOfElement);
                  }
                  $("#fieldsales-sheet-form input[name=" + indexInArray + "]").val(valueOfElement);
              });
              $("#fieldsales-sheet-form .btn.btn-primary").html("Update");
              $("#field-sales-sheet-modal").modal({ show: true, backdrop: 'static', keyboard: false });
              //$('.nav-tabs [data-target="#field-sales-sheet"]').tab('show');
          }
      },
      complete: function() {

      }
  });

}

function getMerchantCommercials(perpage = 10){
  $.ajax({
      type: "GET",
      url: "/rockpay/sales/merchant-commercials/show/"+perpage,
      dataType: "html",
      success: function (response) {
          $("#paginate_merchantcommercial").html(response);
      }
  });
}

function getTransactionBreakUp(merchanId){
  var html = '';
  var labelName = {
      'no_of_transactions':'No Of Transaction',
      'transaction_amount':'Transaction Amount',
      'transaction_mode':'Transaction Mode'
  };
  var selectedValues = ['no_of_transactions','transaction_amount','transaction_mode'];
  $.ajax({
      type:"GET",
      url: "/rockpay/sales/transaction-breakup/"+merchanId,
      dataType: "json",
      success: function (response) {
          if(typeof response!="undefined" && Object.keys(response).length > 0){
              $.each(response,function(index,object){
                  $.each(object,function(key,value){
                      if($.inArray(key,selectedValues) > -1)
                      {
                          html+=`<div class="form-group form-fit">
                          <label for="input" class="col-sm-6 control-label">`+labelName[key]+`</label>
                          <div class="col-sm-6">
                              <input type="text" name="`+key+`" id="`+key+`" class="form-control" value="`+value+`" readonly>
                          </div>
                          </div>`;
                      }
                  });
                  html+='<hr>';
              });
              $("#tranasaction-breakup-form").html(html);
              $("#tranasaction-breakup-modal").modal({show:true,backdrop:"static",keyboard:false});
          }
      }
  });
}

function viewMerchantCommercials(recorid){

  var nonprecisonKeys = ["id", "merchant_id", "business_type_id"];
  $.ajax({
      type: "GET",
      url: "/rockpay/technical/get-merchant-charge/" + recorid,
      dataType: "json",
      success: function(response) {
          if (typeof response != undefined && Object.keys(response).length > 0) {
              $.each(response[response.length - 1], function(key, value) {
                  if (typeof value == "number" && $.inArray(key, nonprecisonKeys) == -1) {

                      $("#merchant-commercial #" + key).val(value.toPrecision(3));
                  } else {

                      $("#merchant-commercial #" + key).val(value);
                      $("#merchant-commercial input[name=" + key + "][value=" + value + "]").prop('checked', true);
                  }

              });
              $("#merchant-commercial-modal").modal({ show: true, backdrop: "static", keyboard: false });
          }
      }
  });
}

$("#call-campaigning-sheet-modal").click(function(e){
  e.preventDefault();
  $("#campaigning-sheet-form")[0].reset();
  $("#ajax-compaign-success-message").html("");
  $("#ajax-compaign-failed-message").html("");
  $("#campaigning-sheet-modal").modal({show:true,backdrop:'static',keyboard:false});
});

$("[data-target='#campaigning']").click(function(e){
  e.preventDefault();
  getCampaigns();
});

function getCampaigns(perpage = 10){
  $.ajax({
      type:"GET",
      url: "/rockpay/sales/get/campaiagn/"+perpage,
      dataType:"html",
      success: function (response) {
          $("#paginate_campaignlist").html(response);
      }
  });
}



$("#campaigning-sheet-form").submit(function(e){
  e.preventDefault();
  var form = $("#campaigning-sheet-form")[0];
  var data = new FormData(form);
  showLoader();
  $.ajax({
      type:"post",
      url:"/rockpay/sales/campaiagn",
      data:data,
      cache:false,
      contentType:false,
      processData:false,
      dataType: "json",
      success: function (response) {
          if(response.status){
              $("#ajax-compaign-success-message").html(response.message);
              $("#campaigning-sheet-form")[0].reset();
              getCampaigns();
          }else{
              $("#ajax-compaign-failed-message").html(response.message);
          }
      },complete:function(){
          setTimeout(() => {
              $("#ajax-compaign-success-message").html("");
              $("#ajax-compaign-failed-message").html("");
          }, timeout);
          hideLoader();
      }
  });
});

$("#call-daily-sheet-modal").click(function(e){
  e.preventDefault();
  $("#daily-sheet-form #id").val("");
  $("#daily-sheet-form")[0].reset();
  $("#daily-sheet-modal").modal({show:true,backdrop:'static',keyboard:false});
});

//Sales javascript functionality ends here

//Risk Complaince functionality code startes here


var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
  // This function will display the specified tab of the form ...

  if (document.getElementsByClassName("tab").length > 1) {
      var x = document.getElementsByClassName("tab");
      x[n].style.display = "block";
      // ... and fix the Previous/Next buttons:
      if (n == 0) {
          document.getElementById("prevBtn").style.display = "none";
      } else {
          document.getElementById("prevBtn").style.display = "inline";
      }
      if (n == (x.length - 1)) {
          $("#nextBtn").hide();
          document.getElementById("nextBtn").innerHTML = "Submit";
      } else {
          $("#nextBtn").show();
          document.getElementById("nextBtn").innerHTML = "Next";
      }
      // ... and run a function that displays the correct step indicator:
      fixStepIndicator(n)
  }

}

function nextPrev(n) {
  // This function will figure out which tab to display
  if (document.getElementsByClassName("tab").length > 1) {
      var x = document.getElementsByClassName("tab");
      // Exit the function if any field in the current tab is invalid:
      if (n == 1 && !validateForm()) return false;
      // Hide the current tab:
      x[currentTab].style.display = "none";
      // Increase or decrease the current tab by 1:
      currentTab = currentTab + n;
      // if you have reached the end of the form... :
      if (currentTab >= x.length) {
          //...the form gets submitted:
          document.getElementById("regForm").submit();
          return false;
      }
      // Otherwise, display the correct tab:
      showTab(currentTab);
  }
}

function validateForm() {
  // This function deals with validation of the form fields
  var x, y, i, valid = true;
  if (document.getElementsByClassName("tab").length > 1) {
      x = document.getElementsByClassName("tab");
      y = x[currentTab].getElementsByTagName("input");
      // A loop that checks every input field in the current tab:
      for (i = 0; i < y.length; i++) {
          // If a field is empty...
          if (y[i].value == "") {
              // add an "invalid" class to the field:
              //y[i].className += " invalid";
              // and set the current valid status to false:
              valid = true;
          }
      }
      // If the valid status is true, mark the step as finished and valid:
      if (valid) {
          document.getElementsByClassName("step")[currentTab].className += " finish";
      }
      return valid; // return the valid status
  }
}

function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
      x[i].className = x[i].className.replace("active", "");
  }
  //... and adds the "active" class to the current step:
  x[n].className += " active";
}

$("body").on("change", ".uploadfile", function(e) {
  e.preventDefault();
  data = new FormData();
  var file = document.getElementById(this.id).files[0];
  data.append(this.name, file);
  data.append("merchant_id", $("#merchant_id").val());
  data.append("_token", $('meta[name="csrf-token"]').attr('content'));
  $("#divLoading").addClass("show");
  $("#divLoading").removeClass("hide");
  $.ajax({
      url: '/rockpay/risk-complaince/merchant/document/upload',
      type: 'POST',
      data: data,
      processData: false,
      contentType: false,
      cache: false,
      dataType: "json",
      success: function(response) {
          ajax_response = response.status;
          if (response.status) {
              window.location.reload();

          } else {

              if (Object.keys(response.error).length > 0) {
                  $.each(response.error, function(name, value) {
                      $("#" + name + "_error").html(value[0]).css({ "color": "red" });
                      $("input[name=" + name + "]").click(function() {
                          $("#" + name + "_error").html("");
                      });
                  });
              }
          }
      },
      complete: function() {

          $("#divLoading").removeClass("show");
          $("#divLoading").addClass("hide");
          setTimeout(() => {

          }, 3000);
      }
  });
});

$("body").on("click", ".button124", function(e) {
  e.preventDefault();
  var data = new FormData();
  data.append("file_name", $(this).data("name"));
  data.append("id", $(this).data("id"));
  data.append("merchant_id", $("#merchant_id").val());
  data.append("_token", $('meta[name="csrf-token"]').attr('content'));
  $.ajax({
      type: "POST",
      url: "/rockpay/risk-complaince/merchant/document/remove",
      data: data,
      processData: false,
      contentType: false,
      cache: false,
      dataType: "json",
      async: false,
      success: function(response) {
          if (response.status) {
              window.location.reload();
          }
      }
  });
});

function verifyMerchantDoc(merchantId) {

// console.log('test');
  $.ajax({
      type: "GET",
      url: "/flakpay/risk-complaince/merchant/details/" + merchantId,
      dataType: "json",
      success: function(response) {  
        console.log('view',response);
        
          if (typeof response != undefined && Object.keys(response).length > 0) {
              $.each(response[response.length - 1], function(key, value) {
                  $("#" + key).html("<label for='' class='test'>" + value + "</label>");
              });
              $("#merchant-document-verify-modal-view").modal({ show: true, backdrop: "static", keyboard: false });

          }

      }
  });
}

$("#call-new-doc-add-modal").click(function(e) {
  e.preventDefault();
  $("#add-extra-document-form")[0].reset();
  $("#new-doc-add-modal").modal({ show: true, backdrop: "static", keyboard: false });
});

$(document).on("change", "input[name='doc_file[]']", function(e) {
  var fileName = e.target.files[0].name;
  $(this).siblings("label").find("span.file-name-display").html(fileName);
});


$("#add-extra-document-form").submit(function(e) {
  e.preventDefault();
  var formdata = $("#add-extra-document-form")[0];
  var data = new FormData(formdata);
  var file_error = [];
  var file_name_error = [];
  $.ajax({
      type: "POST",
      url: "/rockpay/risk-complaince/merchant/extra-document/upload",
      processData: false,
      contentType: false,
      cache: false,
      data: data,
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#add-document-success-response").html(response.message);
              $("#add-extra-document-form")[0].reset();
              window.location.reload();
              getMerchantExtraDocs();
          } else {
              if (typeof response.error != "undefined" && Object.keys(response.error).length > 0) {
                  $.each(response.error, function(name, value) {
                      console.log(name);
                      console.log($("#" + name + "_error"));
                      document.getElementById("" + name + "_error").innerHTML = value[0];
                      //$("#"+name+"_error").html(value[0]).css({"color":"red"});
                      // if($("input[name='"+name+"[]']").length > 0){
                      //   $("input[name='"+name+"[]']").click(function(){
                      //     $("#"+name+"_error").html("");
                      //   });
                      // }
                      // $("select[name="+name+"]").click(function(){
                      //   $("#"+name+"_error").html("");
                      // });
                  });
              }
          }
      },
      complete: function() {
          setTimeout(() => {
              //$("#add-document-success-response").html("");
              $("[data-target='#merchant-extra-document']").tab("show");
          }, 3000);
      }
  });
});

$("[data-target='#merchant-extra-document']").click(function(e) {
  e.preventDefault();
  getMerchantExtraDocs();
});

function getMerchantExtraDocs(perpage = 10) {
  $.ajax({
      type: "GET",
      url: "/rockpay/risk-complaince/merchant/extra-documents/get/" + perpage,
      data: "data",
      dataType: "html",
      success: function(response) {
          $("#paginate_extdocs").html(response);
      }
  });
}

function addNewFileIput() {

  $(".input-file-area").children().length + 1
  var newfileinput = `<div class="form-group">
  <label for="input" class="col-sm-2 control-label">Name:</label>
  <div class="col-sm-3">
      <input type="text" name="doc_name[]" id="input" class="form-control" value="">
      <div id="doc_name.` + ($(".input-file-area").children().length) + `_error"></div>
  </div>
  <label for="input" class="col-sm-2 control-label">File:</label>
  <div class="col-sm-3">
      <input type="file" name="doc_file[]" id="file-` + ($(".input-file-area").children().length + 1) + `" class="inputfile form-control inputfile-1" multiple/>
      <label for="file-` + ($(".input-file-area").children().length + 1) + `" class="custom-file-upload">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
              <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
          </svg> 
          <span id="doc_file_file">
              <span class="file-name-display" id="doc_file_exist2">Choose a file...</span>
          </span>
      </label>
      <div id="doc_file.` + ($(".input-file-area").children().length) + `_error"></div>
  </div>
  <div class="col-sm-1">
      <i class="fa fa-times fa-lg text-danger remove-field show-pointer"></i>
  </div>
</div>`;

  $("#input-file-area").append(newfileinput);
}

$(document).on("click", ".remove-field", function(e) {
  e.preventDefault()
  $(this).closest(".form-group").remove();
});

//Merchant Background Verification Code starts here 
function getMerchantBusisDetails(element) {
  var merchant_id = element.value;
  if (merchant_id != "") {
      $.ajax({
          type: "GET",
          url: "/rockpay/risk-complaince/background-verification/verify/get-merchant-business-details/" + merchant_id,
          dataType: "html",
          success: function(response) {
              $("#verification-form").html(response);
              $("#merchant_id").val(merchant_id);
          }
      });
  } else {
      $("#verification-form").html("");
  }
}


function websiteExist(element) {
  if (element.value == "N") {
      $("#website-inputs").hide();
      $("input[name='website_url']").prop("disabled", true);
      $("input[name='website_contains']").each(function(e) {
          $(this).prop("disabled", true)
      })
  } else {
      $("#website-inputs").show();
      $("input[name='website_url']").prop("disabled", false);
      $("input[name='website_contains']").each(function(e) {
          $(this).prop("disabled", false)
      })
  }
}

function banProduct(element) {
  if (element.value == "N") {
      $("#ban-product-inputs").hide();
      $("input[name='ban_product_id']").prop("disabled", true);
  } else {
      $("#ban-product-inputs").show();
      $("select[name='ban_product_id']").prop("disabled", false);
  }
}

function getsubcategory(element) {

  var category_id = $(element).val();
  var optionText = $("#" + element.id + " option:selected").text();
  if (optionText != "Others") {
      $("#sub-category-div").show();
      $("#sub-categort-others").hide();
      $("#business_sub_category").prop("disabled", true);
      $("#business_sub_category_id").prop("disabled", false);
      $.ajax({
          url: "/rockpay/risk-complaince/background-verification/verify/get-sub-category",
          type: "POST",
          data: { id: category_id, _token: $('meta[name="csrf-token"]').attr('content') },
          dataType: "json",
          success: function(response) {
              var html = '<option value="">--Select--</option>';
              $.each(response, function(index, value) {
                  html += '<option value=' + value.id + '>' + value.sub_category_name + '</option>';
              });
              $("#business_sub_category_id").html(html);
              $("#sub-category-div").removeClass("display-none");
          },
          error: function(error) {

          }
      });
  } else {
      $("#business_sub_category_id").prop("disabled", true);
      $("#business_sub_category").prop("disabled", false);
      $("#sub-category-div").hide();
      $("#sub-categort-others").show();
  }

}

function callReportModal() {
  $("#rnc-report-form")[0].reset();
  var merchantDetailsForm = $("#merchant-details-form").serializeArray();
  var documentDetailsForm = $("#document-details-form").serializeArray();
  var formDetails = { merchantDetailsForm, documentDetailsForm };
  var sendReportToMerchant = false;
  $.each(formDetails, function(index, object) {
      $.each(object, function(key, subobject) {
          if (subobject.value == "N") {
              sendReportToMerchant = true
          }
      });
  });
  if (sendReportToMerchant) {
      $("#report-modal").modal({ show: true, backdrop: "static", keyboard: false });
  } else {
      $("#rnc-report-form").submit();
  }

}



$("#rnc-report-form").submit(function(e) {
  e.preventDefault();
  var formdata = $(this).serializeArray();
  $("div#divLoading").removeClass('hide');
  $("div#divLoading").addClass('show');
  $.ajax({
      type: "POST",
      url: "/flakpay/risk-complaince/merchant-document/send-report",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#document-response-message").html(response.message);
              $("#report-modal").modal("hide");
              $("#document-response-modal").modal({ show: true, backdrop: "static", keyboard: false });
          } else {
              $("#document-response-message").html(response.message);
              $("#report-modal").modal("hide");
              $("#document-response-modal").modal({ show: true, backdrop: "static", keyboard: false });
          }
      },
      complete: function() {
          $("div#divLoading").removeClass('show');
          $("div#divLoading").addClass('hide');
      }
  });
});

$("body").on("submit", "#background-verification-form", function(e) {
  e.preventDefault();
  var formdata = $(this).serializeArray();
  $.ajax({
      type: "POST",
      url: "/rockpay/risk-complaince/background-verification/verify/new",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#bgcheck-add-response").html(response.message);
              $("#bgcheck-add-response-message-modal").modal({ show: true, backdrop: 'static', keyboard: false });
          }
      }
  });
});

$("body").on("submit", "#update-background-verification-form", function(e) {
  e.preventDefault();
  var formdata = $(this).serializeArray();
  $.ajax({
      type: "POST",
      url: "/rockpay/risk-complaince/background-verification/verify/update",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#bgcheck-add-response").html(response.message);
              $("#bgcheck-add-response-message-modal").modal({ show: true, backdrop: 'static', keyboard: false });
          }
      }
  });
});

function getAllBackgroundInfo(perpage = 10) {
  $.ajax({
      type: "GET",
      url: "/rockpay/risk-complaince/background-verification/verify/get-verified-merchants/" + perpage,
      dataType: "html",
      success: function(response) {
          $("#paginate_bginfo").html(response);
      }
  });
}
//Merchant Background Verification Code ends here


function getMerchantDocsDetails(perpage = 10) {
  $.ajax({
      type: "GET",
      url: "/flakpay/risk-complaince/merchant-document/verify/get-merchant-doc-detail/" + perpage,
      dataType: "html",
      success: function(response) {
          $("#paginate_document").html(response);
      }
  });
}

function UpdateRncVerify(id, element) {
  var status = element.value;
  if (status != "") {
      $.ajax({
          type: "POST",
          url: "/flakpay/risk-complaince/merchant-details/verify/update",
          data: { id: id, details_verified: status, _token: $('meta[name="csrf-token"]').attr('content') },
          dataType: "json",
          success: function(response) {

          }
      });
  }
}

function UpdateDocVerify(id, element) {
  var status = element.value;
  if (status != "") {
      $.ajax({
          type: "POST",
          url: "/flakpay/risk-complaince/merchant-document/verify/update",
          data: { id: id, doc_verified: status, _token: $('meta[name="csrf-token"]').attr('content') },
          dataType: "json",
          success: function(response) {

          }
      });
  }
}

//Merchant Grievence Cell functional code starts here
function allCasesDetails(perpage = 10) {
  $.ajax({
      type: "GET",
      url: "/rockpay/risk-complaince/grievence-cell/get/all-cases/" + perpage,
      dataType: "html",
      success: function(response) {
          $("#paginate_custcase").html(response);
      }
  });
}

function getCommentDetails() {
  var caseid = $("#rupayapay-comment-form input[name='case_id']").val();
  var commentHtml = "";
  var userType = { 'merchant': 'Merchant', 'customer': 'Customer', 'rupayapay': 'Rupayapay' };
  $.ajax({
      url: "/support/case/comment/get/" + caseid,
      type: "GET",
      dataType: "json",
      success: function(response) {
          if (response.length > 0) {
              $.each(response, function(index, object) {
                  var right = true;
                  if (object.user_type == 'merchant') {
                      commentHtml += `<li class="clearfix">
                        <div class="message-data align-right">
                        <span class="message-data-time" >` + object.commented_date + `</span> &nbsp; &nbsp;
                        <span class="message-data-name" >` + userType[object.user_type] + `</span> <i class="fa fa-circle me"></i>
                        </div>
                        <div class="message other-message float-right">
                        ` + object.comment + `
                        </div>
                        </li>`;
                      right = false;
                  } else if (object.user_type == 'customer') {

                      commentHtml += `<li>
                      <div class="message-data">
                      <span class="message-data-name" >` + userType[object.user_type] + `</span> <i class="fa fa-circle me"></i>
                      <span class="message-data-time" >` + object.commented_date + `</span> &nbsp; &nbsp;
                      </div>
                      <div class="message my-message">
                      ` + object.comment + `
                      </div>
                      </li>`;
                  } else {

                      if (right) {
                          commentHtml += `<li class="clearfix">
                        <div class="message-data align-right">
                        <span class="message-data-time" >` + object.commented_date + `</span> &nbsp; &nbsp;
                        <span class="message-data-name" >` + userType[object.user_type] + `</span> <i class="fa fa-circle me"></i>
                        </div>
                        <div class="message other-message float-right">
                        ` + object.comment + `
                        </div>
                        </li>`;
                      } else {
                          commentHtml += `<li>
                        <div class="message-data">
                        <span class="message-data-name" >` + userType[object.user_type] + `</span> <i class="fa fa-circle me"></i>
                        <span class="message-data-time" >` + object.commented_date + `</span> &nbsp; &nbsp;
                        </div>
                        <div class="message my-message">
                        ` + object.comment + `
                        </div>
                        </li>`;
                      }

                  }
              });


          } else {
              commentHtml = `<li class="clearfix">
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
          $(".chat-history").each(function(index, element) {
              $(".chat-history").animate({ scrollTop: element.scrollHeight }, 600);
          });
      },
      error: function() {},
      complete: function() {}
  });
}

$("#rupayapay-comment-form").submit(function(e) {
  e.preventDefault();
  var formdata = $("#rupayapay-comment-form").serializeArray();
  $.ajax({
      url: "/rockpay/risk-complaince/grievence-cell/comment/add",
      type: "POST",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#ajax-comment-response").html(response.message).css({ "color": "green" });
          }
      },
      error: function() {},
      complete: function() {
          $("#rupayapay-comment-form")[0].reset();
          getCommentDetails();
          setTimeout(() => {
              $("#ajax-comment-response").html("");
          }, 1500);
      }
  });
});

$("#case-form").submit(function(e) {
  e.preventDefault();
  var formdata = $("#case-form").serializeArray();
  $.ajax({
      url: "/rockpay/risk-complaince/grievence-cell/case/update",
      type: "POST",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#ajax-comment-response").html(response.message).css({ "color": "green" });
          }
      },
      error: function() {},
      complete: function() {
          setTimeout(() => {
              $("#ajax-comment-response").html("");
          }, 1500);
      }
  });
});
//Merchant GreGrievence Cell functional code ends here

//Risk Complaince functionality code ends here

//HRM Employee javascript functionality starts here
function getAllEmplooyes() {
  $.ajax({
      url: "/rockpay/hrm/get-employees",
      type: "GET",
      dataType: "html",
      success: function(response) {
          $("#display-employee-table").html(response);
      },
      error: function() {},
      complete: function() {},
  });
}

$("#employee-details-form").submit(function(e) {
  e.preventDefault();
  var formdata = $("#employee-details-form").serializeArray();
  $.ajax({
      url: "/rockpay/hrm/get-employees/update",
      type: "POST",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#ajax-response-message").html(response.message).css({ "color": "green" });
              //$("#employee-details-form")[0].reset();
          } else {
              $("#ajax-response-message").html(response.message).css({ "color": "red" });
          }
      },
      error: function() {},
      complete: function() {
          setTimeout(() => {
              $("#ajax-response-message").html("");
          }, timeout);
      },
  })
});

function deleteEmployee(employeeId, employeeName) {
  if (employeeId != "") {
      $("#delete-employee #id").val(employeeId);
      $("#employee-name").html(urldecode(employeeName));
      $("#employee-delete-confirm-modal").modal({ show: true, backdrop: 'static', keyboard: false });
  }
}

$("#delete-employee").submit(function(e) {
  e.preventDefault();
  var formdata = $(this).serializeArray();
  $.ajax({
      type: "POST",
      url: "/rockpay/hrm/get-employees/delete",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#ajax-response-message").html(response.message).css({ "color": "green" });
              getAllEmplooyes();
              //$("#delete-employee")[0].reset();
          } else {
              $("#ajax-response-message").html(response.message).css({ "color": "red" });
          }
      },
      complete: function() {
          setTimeout(() => {
              $("#ajax-response-message").html("");
          }, timeout);
      }
  });
});


$("#contact-info-form").submit(function(e) {
  e.preventDefault();
  var formdata = $("#contact-info-form").serializeJSON();
  var contactDetails = ["house_no", "street_name", "area",
      "city", "district", "state", "pincode", "nationality",
      "phone_no", "primary_email"
  ];
  var formvalidation = false;

  $.each(formdata, function(indexInArray, valueOfElement) {
      if ($.inArray(indexInArray, contactDetails) > -1) {
          $.each(valueOfElement, function(index, value) {
              if (value == "") {

                  if ($("textarea[name='" + indexInArray + "[]']")[index] && $("textarea[name='" + indexInArray + "[]']")[index].value == "") {
                      $("textarea[name='" + indexInArray + "[]']")[index].focus().css('border', '1px solid red');
                      $("textarea[name='" + indexInArray + "[]']")[index].click(function(e) {
                          e.preventDefault()
                          $(this).focus().css('border', '1px solid skyblue');
                      });
                  } else if ($("input[name='" + indexInArray + "[]']")[index].value == "") {

                      $("input[name='" + indexInArray + "[]']")[index].focus().css('border', '1px solid red');
                      $("input[name='" + indexInArray + "[]']")[index].click(function() {
                          $(this).focus().css('border', '1px solid skyblue');
                      });
                  }
                  formvalidation = false;
                  return false;
              } else {
                  formvalidation = true;
              }
          });
      }
  });

  if (formvalidation) {
      $.ajax({
          type: "POST",
          url: "/rockpay/hrm/bvf/add-contact-details",
          data: formdata,
          dataType: "json",
          success: function(response) {
              if (response.status) {
                  $("#contact-ajax-response-message").html(response.message).css({ "color": "green" });
                  $("#contact-info-form")[0].reset();
              } else {
                  $("#contact-ajax-response-message").html(response.message).css({ "color": "red" });
              }
          },
          complete: function() {
              setTimeout(() => {
                  $("#contact-ajax-response-message").html("");
              }, timeout);
          }
      });
  }

});

$("#reference-info-form").submit(function(e) {
  e.preventDefault();
  var formdata = $("#reference-info-form").serializeJSON();
  var reference = ["ref_name", "ref_designation", "ref_company", "ref_mobile_no", "ref_email"];
  var formvalidation = false;
  $.each(formdata, function(indexInArray, valueOfElement) {
      if ($.inArray(indexInArray, reference) > -1) {
          $.each(valueOfElement, function(index, value) {
              if ($("input[name='" + indexInArray + "[]']")[index].value == "") {

                  $("input[name='" + indexInArray + "[]']")[index].focus();
                  $("input[name='" + indexInArray + "[]']")[index].click(function(e) {
                      e.preventDefault();
                      $(this).focus().css('border', '1px solid skyblue');
                  });
                  return false;
              } else {
                  formvalidation = true;
              }
          });
      }
  });

  if (formvalidation) {
      $.ajax({
          type: "POST",
          url: "/rockpay/hrm/bvf/add-reference-details",
          data: formdata,
          dataType: "json",
          success: function(response) {
              if (response.status) {
                  $("#reference-ajax-response-message").html(response.message).css({ "color": "green" });
                  $("#reference-info-form")[0].reset();
              } else {
                  $("#reference-ajax-response-message").html(response.message).css({ "color": "red" });
              }
          },
          complete: function() {
              setTimeout(() => {
                  $("#reference-ajax-response-message").html("");
              }, timeout);
          }
      });
  }
});

$("#academic-info-form").submit(function(e) {
  e.preventDefault();
  var formdata = $("#academic-info-form").serializeJSON();
  var academics = ["inst_name", "inst_loc", "affil_university", "mobile_no", "academic", "course", "course_completed", "marks_secured"];
  var formvalidation = false;

  $.each(formdata, function(indexInArray, valueOfElement) {
      if ($.inArray(indexInArray, academics) > -1) {
          $.each(valueOfElement, function(index, value) {
              if (value == "") {
                  if ($("textarea[name='" + indexInArray + "[]']")[index] && $("textarea[name='" + indexInArray + "[]']")[index].value == "") {
                      $("textarea[name='" + indexInArray + "[]']")[index].focus().css('border', '1px solid red');
                      $("textarea[name='" + indexInArray + "[]']")[index].click(function(e) {
                          e.preventDefault()
                          $(this).focus().css('border', '1px solid skyblue');
                      });
                      return false;
                  } else if ($("input[name='" + indexInArray + "[]']")[index].value == "") {

                      $("input[name='" + indexInArray + "[]']")[index].focus().css('border', '1px solid red');
                      $("input[name='" + indexInArray + "[]']")[index].click(function() {
                          $(this).focus().css('border', '1px solid skyblue');
                      });
                      return false;
                  }
              } else {
                  formvalidation = true;
              }
          });
      }
  });
});

$("#add-employee-details-form").submit(function(e) {
  e.preventDefault();
  var formdata = $("#add-employee-details-form").serializeArray();
  $.ajax({
      url: "/rockpay/hrm/get-employees/add",
      type: "POST",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#ajax-response-message").html(response.message).css({ "color": "green" });
              $("#add-employee-details-form")[0].reset();
          } else {
              if (Object.keys(response.errors).length > 0) {
                  $.each(response.errors, function(name, message) {
                      $("#" + name + "_ajax_error").html(message[0]).css({ "color": "red" });
                      $("#add-employee-details-form input[name=" + name + "]").click(function() {
                          $("#" + name + "_ajax_error").html("");
                      });
                      $("#add-employee-details-form select[name=" + name + "]").click(function() {
                          $("#" + name + "_ajax_error").html("");
                      });
                  });
              } else {
                  $("#ajax-response-message").html(response.message).css({ "color": "red" });
              }
          }
      },
      error: function() {},
      complete: function() {
          setTimeout(() => {
              $("#ajax-response-message").html("");
          }, timeout);
      },
  })
});

$("#employeelist").change(function(e) {
  e.preventDefault();
  var employeeId = $(this).val();
  var employeeName = $("#employeelist option:selected").text().replace(" ", "_");
  if (employeeId != "") {
      getUploadedNda(employeeId, employeeName);
  }
});

$("#employeeconalist").change(function(e) {
  e.preventDefault();
  var employeeId = $(this).val();
  var employeeName = $("#employeeconalist option:selected").text().replace(" ", "_");
  if (employeeId != "") {
      getUploadedConA(employeeId, employeeName);
  }
});

function getUploadedNda(employeeId, employeeName) {
  $.ajax({
      type: "GET",
      url: "/rockpay/hrm/nda/get-nda/" + employeeId,
      dataType: "html",
      success: function(response) {

          $("#form-element").html(response);
          $("#employee_id").val(employeeId);
      },
      complete: function() {
          $("#employee-name").val(employeeName);
      }
  });
}

function getUploadedConA(employeeId, employeeName) {
  $.ajax({
      type: "GET",
      url: "/rockpay/hrm/conagree/get-conagree/" + employeeId,
      dataType: "html",
      success: function(response) {

          $("#form-element").html(response);
          $("#employee_id").val(employeeId);
      },
      complete: function() {
          $("#employee-name").val(employeeName);
      }
  });
}


$("#nda-form").submit(function(e) {
  e.preventDefault();
  var employeeId = $("#employeelist").val();
  var employeeName = $("#employeelist option:selected").text().replace(" ", "_");
  $("#employee-name").val(employeeName);
  var formdata = $("#nda-form")[0];
  var data = new FormData(formdata);
  $.ajax({
      type: "POST",
      url: "/rockpay/hrm/nda/upload-file",
      enctype: "multipart/form-data",
      data: data,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#ajax-response-message").html(response.message).css({ "color": "green" });
              $("#nda-form")[0].reset();
          } else {
              $("#ajax-response-message").html(response.message).css({ "color": "red" });
          }
      },
      complete: function() {
          getUploadedNda(employeeId)
          setTimeout(() => {
              $("#ajax-response-message").html("");
          }, timeout);
      }
  });
});

$("#ca-form").submit(function(e) {
  e.preventDefault();
  var employeeId = $("#employeeconalist").val();
  var employeeName = $("#employeeconalist option:selected").text().replace(" ", "_");
  $("#employee-name").val(employeeName);
  var formdata = $("#ca-form")[0];
  var data = new FormData(formdata);
  $.ajax({
      type: "POST",
      url: "/rockpay/hrm/ca/upload-file",
      enctype: "multipart/form-data",
      data: data,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#ajax-response-message").html(response.message).css({ "color": "green" });
              $("#ca-form")[0].reset();
          } else {
              $("#ajax-response-message").html(response.message).css({ "color": "red" });
          }
      },
      complete: function() {
          getUploadedConA(employeeId)
          setTimeout(() => {
              $("#ajax-response-message").html("");
          }, timeout);
      }
  });
});

$("#personal-info-form").submit(function(e) {
  e.preventDefault();
  var formdata = $("#personal-info-form").serializeArray();
  var personalDetails = ["first_name", "last_name", "rel_first_name", "rel_last_name", "dob", "gender", "pan_no"];
  var fomvalidation = false;
  $.each(formdata, function(indexInArray, valueOfElement) {
      var option = document.getElementsByName('gender');
      if (!(option[0].checked || option[1].checked)) {
          alert("Please Select Gender");
          return false;
      } else if (valueOfElement.value == "" && $.inArray(valueOfElement.name, personalDetails) > -1) {
          $("input[name='" + valueOfElement.name + "']").focus().css('border', '1px solid red');
          $("input[name=" + valueOfElement.name + "]").click(function() {
              $(this).focus().css('border', '1px solid skyblue')
          });
          return false;
      } else {
          fomvalidation = true;
      }
  });

  if (fomvalidation) {
      $.ajax({
          type: "POST",
          url: "/rockpay/hrm/bvf/add-personal-profile",
          data: getJsonObject(formdata),
          dataType: "json",
          success: function(response) {
              if (response.status) {
                  $("#details-ajax-response").html(response.message).css({ "color": "green" });
                  $("#personal-info-form")[0].reset();
              } else {

              }
          },
          complete: function() {
              setTimeout(() => {
                  $("#details-ajax-response").html("");
              }, timeout);
          }
      });
  }

});




$("#background-details-form").submit(function(e) {
  e.preventDefault();
  var formdata = $("#background-details-form").serializeJSON();

  var formdata = $("#background-details-form").serializeJSON();
  var personalDetails = ["first_name", "last_name", "rel_first_name", "rel_last_name", "dob", "gender", "pan_no"]
  var contactDetails = ["house_no", "street_name", "area",
      "city", "district", "state", "pincode", "nationality",
      "phone_no", "primary_email"
  ];
  var reference = ["ref_name", "ref_designation", "ref_company", "ref_mobile_no", "ref_email"];
  var academics = ["inst_name", "inst_loc", "affil_university", "mobile_no", "academic", "course", "course_completed", "marks_secured"];

  var emphistory = ["company_name", "company_loc", "company_phone", "designation", "salary_ctc"];
  $.each(formdata, function(indexInArray, valueOfElement) {


      if ($.inArray(indexInArray, personalDetails) > -1) {
          // var option=document.getElementsByName('gender');
          // if (!(option[0].checked || option[1].checked)) {
          //     alert("Please Select Gender");
          //     return false;
          // }
          // if(valueOfElement == "")
          // {
          //     $("input[name='"+indexInArray+"']").focus().css('border','1px solid red');

          //     $("input[name="+indexInArray+"]").click(function(){
          //           $(this).focus().css('border','1px solid skyblue')
          //       });
          //     return false;
          // }
      } else if ($.inArray(indexInArray, contactDetails) > -1) {

          // $.each(valueOfElement,function(index,value){
          //     if(value == "")
          //     {
          //       if($("textarea[name='"+indexInArray+"[]']")[index] && $("textarea[name='"+indexInArray+"[]']")[index].value == "")
          //       {
          //         $("textarea[name='"+indexInArray+"[]']")[index].focus().css('border','1px solid red');
          //         $("textarea[name='"+indexInArray+"[]']")[index].click(function(e){
          //             e.preventDefault()
          //             $(this).focus().css('border','1px solid skyblue');
          //         });
          //         return false;

          //       }else if($("input[name='"+indexInArray+"[]']")[index].value == ""){

          //         $("input[name='"+indexInArray+"[]']")[index].focus().css('border','1px solid red');
          //         $("input[name='"+indexInArray+"[]']")[index].click(function(){
          //           $(this).focus().css('border','1px solid skyblue');
          //         });
          //         return false;
          //       }

          //     }
          // });
      } else if ($.inArray(indexInArray, reference) > -1) {
          // $.each(valueOfElement,function(index,value){
          //     if(value == "")
          //     {
          //         $("input[name='"+indexInArray+"[]']")[index].focus().css('border','1px solid red');
          //         return false;
          //     }
          // });
      } else if ($.inArray(indexInArray, academics) > -1) {
          // $.each(valueOfElement,function(index,value){
          //     if(index != 3)
          //     {
          //       if($("textarea[name='"+indexInArray+"[]']")[index] && $("textarea[name='"+indexInArray+"[]']")[index].value == "")
          //       {
          //         $("textarea[name='"+indexInArray+"[]']")[index].focus().css('border','1px solid red');
          //         $("textarea[name='"+indexInArray+"[]']")[index].click(function(e){
          //             e.preventDefault()
          //             $(this).focus().css('border','1px solid skyblue');
          //         });
          //         return false;

          //       }else if(value == "")
          //       {
          //           $("input[type='date'][name='"+indexInArray+"[]']")[index].focus().css('border','1px solid red');
          //           $("input[name='"+indexInArray+"[]']")[index].focus().css('border','1px solid red');
          //           return false;
          //       }
          //     }
          // });

      } else if ($.inArray(indexInArray, emphistory) > -1) {

          $.each(valueOfElement, function(index, value) {
              if (index == 0) {
                  if ($("textarea[name='" + indexInArray + "[]']")[index] && $("textarea[name='" + indexInArray + "[]']")[index].value == "") {
                      $("textarea[name='" + indexInArray + "[]']")[index].focus().css('border', '1px solid red');
                      $("textarea[name='" + indexInArray + "[]']")[index].click(function(e) {
                          e.preventDefault()
                          $(this).focus().css('border', '1px solid skyblue');
                      });
                      return false;

                  } else if (value == "") {
                      $("input[name='" + indexInArray + "[]']")[index].focus().css('border', '1px solid red');
                      return false;
                  }
              }

          });
      }



  });

  var lihtml = "";
  $.ajax({
      type: "POST",
      url: "/rockpay/hrm/bvf/add",
      data: formdata,
      dataType: "json",
      success: function(response) {
          if (response.status) {

          } else {
              if (Object.keys(response.errors).length > 0) {
                  $.each(response.errors, function(indexInArray, valueOfElement) {
                      lihtml += "<li>" + valueOfElement[0] + "</li>";
                  });
                  $("#ajax-form-errors").html(lihtml).css({ "color": "red" });
              }
          }
      },
      complete: function() {
          setTimeout(() => {
              // $("#ajax-form-errors").html("");
          }, 1500);
      }
  });
})

function getAllPayslips() {
  $.ajax({
      type: "GET",
      url: "/rockpay/hrm/payroll/payslip/get",
      dataType: "html",
      success: function(response) {
          $("#paginate_paysliplist").html(response);
      }
  });
}

var empEarnings = {};
var empDeductions = {};
var earningOptions = [];
var deductionOptions = [];
var selectedearningoptions = {};
var selecteddeductionoptions = {};
$("#employee_id").change(function(e) {
  e.preventDefault();
  if ($(this).val() != "") {
      $("#payslip-form-elements").removeClass("hide");
  } else {
      $("#payslip-form-elements").addClass("hide");
  }
  var earningsdropdown = "";
  var deductiondropdown = "";
  var earningsInput = "";
  var employeeId = $(this).val();

  if (employeeId != "") {
      $.ajax({
          type: "GET",
          url: "/rockpay/hrm/payroll/payslip/get-form/" + employeeId,
          dataType: "json",
          success: function(response) {

              if (Object.keys(response.employee).length > 0) {
                  $("#employee-name").html(response.employee.first_name + " " + response.employee.last_name);
                  $("#employee-designation").html(response.employee.designation);
              }
              if (response.payslip.length > 0) {
                  earningOptions.push("<option value=''>--Select--</option>");
                  deductionOptions.push("<option value=''>--Select--</option>");
                  earningsdropdown = `<tr><td>
                          <div class='form-group'>
                          <div class="col-sm-12">
                          <select name="emp_earning[]" id="emp_earning" class="form-control">
                          <option value=''>--Select--</option>`;
                  deductiondropdown = `<tr><td>
                        <div class='form-group'>
                        <div class="col-sm-12">
                        <select name="emp_deduction[]" id="emp_deduction" class="form-control">
                        <option value=''>--Select--</option>`;
                  $.each(response.payslip, function(indexInArray, valueOfElement) {
                      if (valueOfElement.element_type == "earning") {
                          earningsdropdown += "<option value='" + valueOfElement.id + "'>" + valueOfElement.element_label + "</option>";
                          earningOptions.push("<option value='" + valueOfElement.id + "'>" + valueOfElement.element_label + "</option>");
                          empEarnings[valueOfElement.id] = valueOfElement.element_name;
                      } else {
                          deductiondropdown += "<option value='" + valueOfElement.id + "'>" + valueOfElement.element_label + "</option>";
                          deductionOptions.push("<option value='" + valueOfElement.id + "'>" + valueOfElement.element_label + "</option>");
                          empDeductions[valueOfElement.id] = valueOfElement.element_label;
                      }
                  });
                  earningsdropdown += `</select></div></div></td><td><div class='col-sm-12'>
          <input type="text" class="form-control" name="earning[]" value="">
          </div></div></td><td><i class='fa fa-times remove-earning mandatory show-pointer'></i></td></tr>`;

                  deductiondropdown += `</select></div></div></td><td><div class='col-sm-12'>
          <input type="text" class="form-control" name="deduction[]" value="">
          </div></div></td><td><i class='fa fa-times remove-deduction mandatory show-pointer'></i></td></tr>`
                  $("#emp-earnings").html(earningsdropdown);
                  $("#emp-deductions").html(deductiondropdown);
              }
          }
      });
  }


});

$("body").on("change", "#payslip-form #emp-deductions", function(e) {
  if ($.inArray($(this).val(), selecteddeductionoptions) == -1) {
      selecteddeductionoptions[$(this).val()] = empEarnings[$(this).val()];
  } else {
      $(this).val("");
  }
});

function addEarningRow() {

  var childrenlength = $("#emp-earnings").children("tr").length;
  var earningsdropdown = `<tr><td>
                        <div class='form-group'>
                        <div class="col-sm-12">
                        <select name="emp_earning[]" id="emp_earning" class="form-control">` + earningOptions + `
                        </select></div></div></td><td><div class='col-sm-12'>
                        <input type="text" class="form-control" name="earning[]" value="">
                        </div></div></td><td><i class='fa fa-times remove-earning mandatory show-pointer'></i></td></tr>`;
  if (Object.keys(earningOptions).length - 1 > childrenlength) {
      $("#emp-earnings").append(earningsdropdown);

  }

}

function addDeductionRow() {
  var childrenlength = $("#emp-deductions").children("tr").length;
  var deductionsdropdown = `<tr><td>
                        <div class='form-group'>
                        <div class="col-sm-12">
                        <select name="emp_deduction[]" id="emp_deduction" class="form-control">` + deductionOptions + `
                        </select></div></div></td><td><div class='col-sm-12'>
                        <input type="text" class="form-control" name="deduction[]" value="">
                        </div></div></td><td><i class='fa fa-times remove-deduction mandatory show-pointer'></i></td></tr>`;
  if (Object.keys(deductionOptions).length > childrenlength) {
      $("#emp-deductions").append(deductionsdropdown);
  }

}

function calculateTotalAddition() {
  var totalAddition = 0;
  $("input[name='earning[]']").each(function(index, element) {
      totalAddition = totalAddition + parseInt(element.value);
  })
  $("#total-addition").html(totalAddition);
}

function calculateTotalDeduction() {
  var totalDeduction = 0;
  $("input[name='deduction[]']").each(function(index, element) {
      totalDeduction = totalDeduction + parseInt(element.value);
  });
  $("#total-deduction").html(totalDeduction);
}

function calculateNetSalary() {
  var totalAddition = 0;
  $("input[name='earning[]']").each(function(index, element) {
      totalAddition = totalAddition + parseInt(element.value);
  });
  $("#total-addition").html(totalAddition);
  $("#total_addition").val(totalAddition);
  var totalDeduction = 0;
  $("input[name='deduction[]']").each(function(index, element) {
      totalDeduction = totalDeduction + parseInt(element.value);
  });
  $("#total-deduction").html(totalDeduction);
  $("#total_deduction").val(totalDeduction);
  $("#net-salary").html(totalAddition - totalDeduction);
  $("#net_salary").val(totalAddition - totalDeduction);
}
$("#payslip-form").submit(function(e) {
  e.preventDefault();
  var formdata = $("#payslip-form").serializeJSON();
  var fromvalidate = false;

  $("select[name='emp_earning[]']").each(function(index, element) {
      if (element.value == "") {
          fromvalidate = false;
          $(this).focus().css({ "border": "1px solid red" });
          $("body").on("click", "#payslip-form select[name='emp_earning[]']", function() {
              $(this).focus().css({ "border": "1px solid skyblue" });
          });
          return false;
      } else {
          fromvalidate = true;
      }
  });

  if (fromvalidate) {
      $("input[name='earning[]']").each(function(index, element) {
          if (element.value == "") {
              fromvalidate = false;
              $(this).focus().css({ "border": "1px solid red" });
              $("body").on("click", "#payslip-form input[name='earning[]']", function() {
                  $(this).focus().css({ "border": "1px solid skyblue" });
                  //$("#payslip-form  input[name='earning[]']").focus().css({"border":"1px solid skyblue"});
              });
              return false;
          } else {
              fromvalidate = true;
          }
      });

  }
  if (fromvalidate) {
      $("select[name='emp_deduction[]']").each(function(index, element) {
          if (element.value == "") {
              fromvalidate = false
              $(this).focus().css({ "border": "1px solid red" });
              $("body").on("click", "#payslip-form select[name='emp_deduction[]']", function() {
                  $(this).focus().css({ "border": "1px solid skyblue" });
              });

              return false;
          } else {
              fromvalidate = true;
          }
      });

  }
  if (fromvalidate) {
      $("input[name='deduction[]']").each(function(index, element) {
          if (element.value == "") {
              fromvalidate = false;
              $(this).focus().css({ "border": "1px solid red" });
              $("body").on("click", "#payslip-form input[name='deduction[]']", function() {
                  $(this).focus().css({ "border": "1px solid skyblue" });
              });

              return false;
          } else {
              fromvalidate = true;
          }
      });

  }

  if (fromvalidate) {
      calculateNetSalary();
      if (confirm("Please cross check before proceeding,\nClick cancel to cross check or Okay to continue")) {
          $.ajax({
              type: "POST",
              url: "/rockpay/hrm/payroll/payslip/add",
              data: formdata,
              dataType: "json",
              success: function(response) {
                  if (response.status) {
                      $("#payslip-ajax-response").html(response.message).css({ "color": "green" });
                  } else {
                      $("#payslip-ajax-response").html(response.message).css({ "color": "red" });
                  }
              },
              complete: function() {
                  setTimeout(() => {
                      $("#payslip-ajax-response").html("");
                  }, timeout);
              }
          });
      }
  }

})

$("body").on("click", ".remove-earning", function(e) {
  e.preventDefault();
  var childrenlength = $("#emp-earnings").children("tr").length;
  console.log(childrenlength);
  if (childrenlength != "1") {
      $(this).closest("tr").remove();
      calculateNetSalary();
  }
});

$("body").on("click", ".remove-deduction", function(e) {
  e.preventDefault();
  var childrenlength = $("#emp-deductions").children("tr").length;
  if (childrenlength != "1") {
      $(this).closest("tr").remove();
      calculateNetSalary();
  }

});

function loadPayslipElements() {
  var employeeId = $("#employee_id").val();
  var earningsInput = "";
  $.ajax({
      type: "GET",
      url: "/rockpay/hrm/payroll/payslip/get-form/" + employeeId,
      dataType: "json",
      success: function(response) {

          // if(Object.keys(response.employee).length>0)
          // {
          //     $("#employee-name").html(response.employee.first_name+" "+response.employee.last_name);
          //     $("#employee-designation").html(response.employee.designation);
          // }
          if (response.payslip.length > 0) {
              earningOptions.push("<option value=''>--Select--</option>");
              deductionOptions.push("<option value=''>--Select--</option>");
              $.each(response.payslip, function(indexInArray, valueOfElement) {
                  if (valueOfElement.element_type == "earning") {
                      earningOptions.push("<option value='" + valueOfElement.id + "'>" + valueOfElement.element_label + "</option>");
                      empEarnings[valueOfElement.id] = valueOfElement.element_name;
                  } else {
                      deductionOptions.push("<option value='" + valueOfElement.id + "'>" + valueOfElement.element_label + "</option>");
                      empDeductions[valueOfElement.id] = valueOfElement.element_label;
                  }
              });

          }
      }
  });
}

$("#call-post-job-modal").click(function(e) {
  e.preventDefault();
  $("#add-post-job-form")[0].reset();
  $("#add-post-job-modal").modal({ show: true, backdrop: "static", keyboard: false });
});

function getPostedJobs(perpage = 10) {
  $.ajax({
      type: "GET",
      url: "/rockpay/hrm/career/job/get/" + perpage,
      dataType: "html",
      success: function(response) {
          $("#paginate_job").html(response);
      }
  });
}

$("#add-post-job-form").submit(function(e) {
  e.preventDefault();
  var formdata = $(this).serializeArray();
  $.ajax({
      type: "POST",
      url: "/rockpay/hrm/career/job/add",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#add-ajax-success-response").html(response.message);
              $("#add-post-job-form")[0].reset();
              $("#add-post-job-form #job_description").summernote('code', "");
              getPostedJobs();
          } else {
              $("#add-ajax-fail-response").html(response.message);
          }
      },
      complete: function() {
          setTimeout(() => {
              $("#add-ajax-success-response").html("");
              $("#add-ajax-fail-response").html("");
          }, timeout);
      }
  });

});

function editJob(jobid) {
  if (jobid != "") {
      $.ajax({
          type: "GET",
          url: "/rockpay/hrm/career/job/edit/" + jobid,
          dataType: "json",
          success: function(response) {
              if (typeof response != undefined && Object.keys(response).length > 0) {
                  $.each(response[response.length - 1], function(key, value) {
                      $("#edit-post-job-form input[name=" + key + "]").val(value);
                      $("#edit-post-job-form select[name=" + key + "]").val(value);
                      if (key == "job_description") {
                          $("#edit-post-job-form #job_description").summernote('code', value);
                      }
                  });
                  $("#edit-post-job-modal").modal({ show: true, backdrop: "static", keyboard: false });
              }
          }
      });
  }
}

$("#edit-post-job-form").submit(function(e) {
  e.preventDefault();
  var formdata = $(this).serializeArray();
  $.ajax({
      type: "POST",
      url: "/rockpay/hrm/career/job/update",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#edit-ajax-success-response").html(response.message);
          } else {
              $("#edit-ajax-fail-response").html(response.message);
          }
      },
      complete: function() {
          setTimeout(() => {
              $("#edit-ajax-success-response").html("");
              $("#edit-ajax-fail-response").html("");
          }, timeout);
      }
  });

});

function changeJobStatus(jobid, element, selectedOption) {

  var columnValue = $(element).parent().siblings("td:eq(1)").children("a").html();
  $("#update-job-status #job_status").val(selectedOption);
  $("#update-job-status #id").val(jobid);
  $("#remove-post-job-modal").modal({ show: true, backdrop: "static", keyboard: false });
}

$("#update-job-status").submit(function(e) {
  e.preventDefault();
  var formdata = $(this).serializeArray();
  $.ajax({
      type: "POST",
      url: "/rockpay/hrm/career/job/change-status",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#update-ajax-success-response").html(response.message);
              getPostedJobs();
          } else {
              $("#update-ajax-fail-response").html(response.message);
          }
      },
      complete: function() {
          setTimeout(() => {
              $("#update-ajax-success-response").html("");
              $("#update-ajax-fail-response").html("");
          }, timeout);
      }
  });

});

function getAllApllicants(perpage = 10) {
  $.ajax({
      type: "GET",
      url: "/rockpay/hrm/career/applicant/get/" + perpage,
      dataType: "html",
      success: function(response) {
          $("#paginate_applicant").html(response);
          $('[data-toggle="popover"]').popover();
      }
  });
}

$("[data-target='#applicants']").click(function(e) {
  e.preventDefault();
  getAllApllicants();
});

function updateApplicantStatus(applicantid, status) {
  $("#applicant-status-form #id").val(applicantid);
  $("#applicant-status-form #applicant_status").val(status.replace("+", " "));
  $("#applicant-status-modal").modal({ show: true, backdrop: "static", keyboard: false });
}

$("#applicant-status-form").submit(function(e) {
  e.preventDefault();
  var formdata = $(this).serializeArray();
  $.ajax({
      type: "POST",
      url: "/rockpay/hrm/career/applicant/update",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#applicant-status-success").html(response.message);
              getAllApllicants();
          } else {
              $("#applicant-status-fail").html(response.message);
          }
      },
      complete: function() {
          setTimeout(() => {
              $("#applicant-status-success").html("");
              $("#applicant-status-fail").html("");
          }, timeout);
      }
  });
});

//HRM Employee javascript functionality ends here

//Merchant javascript functionality starts here
function loadMerchantNoOfTransaction() {
  var formdata = $("#transaction-form").serializeArray();
  $.ajax({
      type: "POST",
      url: "/flakpay/merchant/no-of-transactions",
      data: getJsonObject(formdata),
      dataType: "html",
      success: function(response) {
          $("#paginate_nooftransaction").html(response);
      }
  });
}

$("[data-target='#transactions']").click(function(e) {
  e.preventDefault();
  $("#transaction-form input[name='transaction_page']").val("count");
  loadMerchantNoOfTransaction();
});

function loadMerchantTransactionAmount() {
  var formdata = $("#transaction-form").serializeArray();
  $.ajax({
      type: "POST",
      url: "/flakpay/merchant/transaction-amount",
      data: getJsonObject(formdata),
      dataType: "html",
      success: function(response) {
          $("#paginate_transactionamount").html(response);
      }
  });
}

$("[data-target='#transaction-volume']").click(function(e) {
  e.preventDefault();
  $("#transaction-form input[name='transaction_page']").val("amount");
  loadMerchantTransactionAmount();
});

$(function() {
  if (window.location.href.indexOf("login") == -1) {
      $('input[name="mer_trans_date_range"]').daterangepicker({
          opens: 'left',
          "linkedCalendars": false,
          startDate: moment().subtract(0, 'days'),
          endDate: moment().subtract(0, 'days'),
          ranges: {
              'Today': [moment().subtract(0, 'days'), moment().subtract(0, 'days')],
              'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
              'Last 7 Days': [moment().subtract(7, 'days'), moment()],
              'Last 30 Days': [moment().subtract(29, 'days'), moment()],
              'This Month': [moment().startOf('month'), moment().endOf('month')],
              'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
      }, function(start, end, label) {

          $("#transaction-form input[name='trans_date_range']").val(start.format('DD/MM/YYYY') + '-' + end.format('DD/MM/YYYY'));
          $("#transaction-form input[name='trans_from_date']").val(start.format('YYYY-MM-DD'));
          $("#transaction-form input[name='trans_to_date']").val(end.format('YYYY-MM-DD'));
          $("#transaction-download-form input[name='trans_from_date']").val(start.format('YYYY-MM-DD'));
          $("#transaction-download-form input[name='trans_to_date']").val(end.format('YYYY-MM-DD'));
          var appendid = $("#transaction-form input[name='transaction_page']").val();

          switch (appendid) {
              case "count":
                  loadMerchantNoOfTransaction();
                  break;
              case "amount":
                  loadMerchantTransactionAmount();
                  break;

              default:
                  break;
          }
      });

      $('#vendor-adjustment-form input[name="trans_date_range"]').daterangepicker({
          opens: 'left',
          "linkedCalendars": false,
          startDate: moment().subtract(0, 'days'),
          endDate: moment().subtract(0, 'days'),
          ranges: {
              'Today': [moment().subtract(0, 'days'), moment().subtract(0, 'days')],
              'Yesterday': [moment().subtract(1, 'days'), moment().subtract(0, 'days')],
              'Last 7 Days': [moment().subtract(7, 'days'), moment()],
              'Last 30 Days': [moment().subtract(29, 'days'), moment()],
              'This Month': [moment().startOf('month'), moment().endOf('month')],
              'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
      }, function(start, end, label) {

          $("#vendor-adjustment-form input[name='trans_date_range']").val(start.format('DD/MM/YYYY') + '-' + end.format('DD/MM/YYYY'));
          $("#vendor-adjustment-form input[name='trans_from_date']").val(start.format('YYYY-MM-DD'));
          $("#vendor-adjustment-form input[name='trans_to_date']").val(end.format('YYYY-MM-DD'));
          getVendorAdjustment();

      });

      $('#merchant-transaction-form input[name="trans_date_range"]').daterangepicker({
          opens: 'left',
          "linkedCalendars": false,
          startDate: moment().subtract(0, 'days'),
          endDate: moment().subtract(0, 'days'),
          ranges: {
              'Today': [moment().subtract(0, 'days'), moment().subtract(0, 'days')],
              'Yesterday': [moment().subtract(1, 'days'), moment().subtract(0, 'days')],
              'Last 7 Days': [moment().subtract(7, 'days'), moment()],
              'Last 30 Days': [moment().subtract(29, 'days'), moment()],
              'This Month': [moment().startOf('month'), moment().endOf('month')],
              'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
      }, function(start, end, label) {

          $("#merchant-transaction-form input[name='trans_date_range']").val(start.format('DD/MM/YYYY') + '-' + end.format('DD/MM/YYYY'));
          $("#merchant-transaction-form input[name='trans_from_date']").val(start.format('YYYY-MM-DD'));
          $("#merchant-transaction-form input[name='trans_to_date']").val(end.format('YYYY-MM-DD'));
          getFieldLeadSalessheet();
      });

      $('#transaction-form input[name="trans_date_range"]').daterangepicker({
          opens: 'left',
          "linkedCalendars": false,
          startDate: moment().subtract(0, 'days'),
          endDate: moment().subtract(0, 'days'),
          ranges: {
              'Today': [moment().subtract(0, 'days'), moment().subtract(0, 'days')],
              'Yesterday': [moment().subtract(1, 'days'), moment().subtract(0, 'days')],
              'Last 7 Days': [moment().subtract(7, 'days'), moment()],
              'Last 30 Days': [moment().subtract(29, 'days'), moment()],
              'This Month': [moment().startOf('month'), moment().endOf('month')],
              'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
      }, function(start, end, label) {

          $("#transaction-form input[name='trans_date_range']").val(start.format('DD/MM/YYYY') + '-' + end.format('DD/MM/YYYY'));
          $("#transaction-form input[name='trans_from_date']").val(start.format('YYYY-MM-DD'));
          $("#transaction-form input[name='trans_to_date']").val(end.format('YYYY-MM-DD'));
          $("#transaction-download-form input[name='trans_from_date']").val(start.format('YYYY-MM-DD'));
          $("#transaction-download-form input[name='trans_to_date']").val(end.format('YYYY-MM-DD'));
          console.log('running function');
          getMerchantTransactionsByDate();

      });

      $('#rupayapay-adjustment input[name="trans_date_range"]').daterangepicker({
          opens: 'left',
          "linkedCalendars": false,
          startDate: moment().subtract(0, 'days'),
          endDate: moment().subtract(0, 'days'),
          ranges: {
              'Today': [moment().subtract(0, 'days'), moment().subtract(0, 'days')],
              'Yesterday': [moment().subtract(1, 'days'), moment().subtract(0, 'days')],
              'Last 7 Days': [moment().subtract(7, 'days'), moment()],
              'Last 30 Days': [moment().subtract(29, 'days'), moment()],
              'This Month': [moment().startOf('month'), moment().endOf('month')],
              'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
      }, function(start, end, label) {

          $("#rupayapay-adjustment input[name='trans_date_range']").val(start.format('DD/MM/YYYY') + '-' + end.format('DD/MM/YYYY'));
          $("#rupayapay-adjustment input[name='trans_from_date']").val(start.format('YYYY-MM-DD'));
          $("#rupayapay-adjustment input[name='trans_to_date']").val(end.format('YYYY-MM-DD'));
          getRupayapayAdjustmentByDate();

      });
  }
});

function loadMerchantDetails(perpage = 10) {
  $.ajax({
      type: "GET",
      url: "/rockpay/merchant/get-all-merchants/" + perpage,
      dataType: "html",
      success: function(response) {
          $("#paginate_merchant").html(response);
      }
  });
}

function loadMerchantsCases() {
  $.ajax({
      type: "GET",
      url: "/rockpay/merchant/get-all-merchant-cases",
      dataType: "html",
      success: function(response) {
          $("#paginate_case").html(response);
      }
  });
}

function loadMerchantsAdjustments() {
  $.ajax({
      type: "GET",
      url: "/rockpay/merchant/get-all-adjustments",
      dataType: "html",
      success: function(response) {
          $("#paginate_adjustment").html(response);
      }
  });
}


function loadMerchantNoOfPaylinks() {
  //var formdata = $("#transaction-form").serializeArray();
  $.ajax({
      type: "GET",
      url: "/rockpay/merchant/no-of-paylinks",
      dataType: "html",
      success: function(response) {
          $("#paginate_noofpaylink").html(response);
      }
  });
}

$("[data-target='#merchant-paylink']").click(function(e) {
  e.preventDefault();
  loadMerchantNoOfPaylinks();
});

function loadMerchantNoOfInvoices() {
  //var formdata = $("#transaction-form").serializeArray();
  $.ajax({
      type: "GET",
      url: "/rockpay/merchant/no-of-invoices",
      dataType: "html",
      success: function(response) {
          $("#paginate_noofinvoice").html(response);
      }
  });
}

$("[data-target='#merchant-invoice']").click(function(e) {
  e.preventDefault();
  loadMerchantNoOfInvoices();
});


//Merchant javascript functionality ends here

//Employee My account functionality starts here
function loadEmlployeeLoginActivities() {
  $.ajax({
      type: "GET",
      url: "/rockpay/merchant/get-login-activities",
      dataType: "html",
      success: function(response) {
          $("#paginate_loginactivities").html(response);
      }
  });
}
$("[data-target='#login-activities']").click(function(e) {
  e.preventDefault();
  loadEmlployeeLoginActivities();
});
//Employee My Account functionality ends here

$("#call-work-status-modal").click(function(e) {
  e.preventDefault();
  $("#work-status-form")[0].reset();
  $("#work-status-modal").modal({ show: true, backdrop: "static", keyboard: false });
});


function getWorkStatus(perpage = 10) {
  $.ajax({
      type: "GET",
      url: "/rockpay/work-status/get/" + perpage,
      dataType: "html",
      success: function(response) {
          $("#paginate_workstatus").html(response);
      }
  });
}

$("#work-status-form").submit(function(e) {
  e.preventDefault();
  var formdata = $(this).serializeArray();
  $.ajax({
      type: "POST",
      url: "/rockpay/work-status/add",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#work-status-form")[0].reset();
              $("#work-status-success-response").html(response.message);
              getWorkStatus();
          } else {

              if (typeof response.errors != undefined && Object.keys(response.errors).length > 0) {

                  $.each(response.errors, function(index, element) {
                      $("#work-status-form #" + index + "_error").html(element[0]);

                      $("#work-status-form #" + index).click(function(e) {
                          e.preventDefault();
                          $("#work-status-form #" + index + "_error").html("");
                      });

                  });

              } else {
                  $("#work-status-failed-response").html(response.message);
              }
          }
      },
      complete: function() {
          setTimeout(() => {
              $("#work-status-success-response").html("");
              $("#work-status-failed-response").html("");
          }, timeout);
      }
  });
});

function editWorkStatus(id) {
  if (id != "") {
      $.ajax({
          type: "GET",
          url: "/rockpay/work-status/edit/" + id,
          dataType: "json",
          success: function(response) {
              if (typeof response != undefined && Object.keys(response).length > 0) {
                  $.each(response[response.length - 1], function(key, value) {
                      $("#work-edit-status-form #" + key).val(value);
                  });

                  $("#work-edit-status-modal").modal({ show: true, backdrop: "static", keyboard: false });
              }
          }
      });
  }
}

$("#work-edit-status-form").submit(function(e) {
  e.preventDefault();
  var formdata = $(this).serializeArray();
  $.ajax({
      type: "POST",
      url: "/rockpay/work-status/update",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#work-edit-status-success-response").html(response.message);
              getWorkStatus();
          } else {

              if (typeof response.errors != undefined && Object.keys(response.errors).length > 0) {

                  $.each(response.errors, function(index, element) {
                      $("#work-edit-status-form #" + index + "_error").html(element[0]);

                      $("#work-edit-status-form #" + index).click(function(e) {
                          e.preventDefault();
                          $("#work-edit-status-form #" + index + "_error").html("");
                      });

                  });

              } else {
                  $("#work-edit-status-failed-response").html(response.message);
              }
          }
      },
      complete: function() {
          setTimeout(() => {
              $("#work-edit-status-success-response").html("");
              $("#work-edit-status-failed-response").html("");
          }, timeout);
      }
  });
});

//Employee Work Status functionality starts here
function loadEmlployeeLoginActivities() {
  $.ajax({
      type: "GET",
      url: "/rockpay/merchant/get-login-activities",
      dataType: "html",
      success: function(response) {
          $("#paginate_loginactivities").html(response);
      }
  });
}
$("[data-target='#login-activities']").click(function(e) {
  e.preventDefault();
  loadEmlployeeLoginActivities();
});
//Employee Work Status functionality ends here




function getJsonObject(formdata) {
  var jsondata = {};
  $.each(formdata, function(index, Obj) {
      jsondata[Obj.name] = Obj.value;
  });
  return jsondata;
}

$(document).on("click", ".pagination li a", function(event) {
  event.preventDefault();
  var pathname = $(this).attr("href").substr($(this).attr("href").lastIndexOf("/") + 1);
  var viewname = pathname.split("?");
  $.ajax({
      url: $(this).attr("href"),
      type: "GET",
      dataType: "html",
      success: function(response) {
          $("#paginate_" + viewname[0]).html(response);
      }
  });
});

function thousands_separators(num) {
  var num_parts = num.toString().split(".");
  num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  return num_parts.join(".");
}

//Employee Login functionality starts here
$("#employee-login").submit(function(e) {
  e.preventDefault();
  var formdata = $("#employee-login").serializeArray();
  employeeloginAttempt(formdata);

});

// function showPasssword(elementName,iconelement){
//   var status = $("div").data("pstatus");
//   x = $("input[name="+elementName+"]")[0];
//    if (x.type === "password") {
//        x.type = "text";
//        $(iconelement).html('<i class="fas fa-eye-lash fa-lg"></i>');
//    } else {
//        x.type = "password";
//        $(iconelement).html('<i class="fas fa-eye fa-lg"></i>');
//    }
// }

function showPopUpPasssword(elementName, iconelement) {
  var status = $("div").data("pstatus");
  x = $("#change-password input[name=" + elementName + "]")[0];
  if (x.type === "password") {
      x.type = "text";
      $(iconelement).html('<i class="fa fa-eye"></i>');
  } else {
      x.type = "password";
      $(iconelement).html('<i class="fa fa-eye-slash"></i>');
  }
}


//Employee Login functionality ends here
function employeeloginAttempt(formdata) {
  $.ajax({
      type: "POST",
      url: "/flakpay/verify-credentials",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("div#divLoading").removeClass('hide');
              $("div#divLoading").addClass('show');
              loadEmployeeLoginForms();

          } else {
              $("#employee-login-error").html(response.message).css({ "color": "red" });
          }
      },
      complete: function() {}
  });
}


function loadEmployeeLoginForms() {
  $.ajax({
      type: "GET",
      url: "/flakpay/load-login-forms",
      dataType: "html",
      success: function(response) {
          $("#success-body").html("An OTP has sent to your official email").css({ "color": "green" });
          $("#load-login-form").html(response);
          $("#employee-login-modal").modal({ show: true, backdrop: 'static', keyboard: false });
      },
      complete: function() {
          $("div#divLoading").removeClass('show');
          $("div#divLoading").addClass('hide');
      }
  });
}

$("body").on("submit", "#email-otp-form", function(e) {
  e.preventDefault();
  var formdata = $("#email-otp-form").serializeArray();
  employeeVerifyEmail(formdata);

});


function employeeVerifyEmail(formdata) {
  $.ajax({
      type: "POST",
      url: "/rockpay/email-verify-otp",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              if (response.load_mobile_form) {
                  loadEmployeeLoginForms();

              } else {

                  window.location.href = response.redirect;
              }

          } else {

              $("#success-body").html("");
              $("#email_otp_ajax_error").html(response.message).css({ "color": "red" });
          }
      }
  });
}

$("body").on("submit", "#mobile-otp-form", function(e) {
  e.preventDefault();
  var formdata = $("#mobile-otp-form").serializeArray();
  employeeVerifyMobile(formdata);

});

function employeeVerifyMobile(formdata) {
  $.ajax({
      type: "POST",
      url: "/rockpay/mobile-verify-otp",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              window.location.href = response.redirect;
          } else {

              $("#success-body").html("");
              $("#mobile_otp_ajax_error").html(response.message).css({ "color": "red" });
          }
      }
  });
}


$("body").on("submit", "#first-time-password-otp", function(e) {
  e.preventDefault();
  var formdata = $("#first-time-password-otp").serializeArray();
  verifyFirsTimeOTP(formdata);
});

function verifyFirsTimeOTP(formdata) {
  $.ajax({
      type: "POST",
      url: "/rockpay/ft-password-change/verify-empmobile-otp",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              loadPasswordChangeForm();

          } else {
              console.log(response.status);
              $("#firsttimepasswordOTP_ajax_error").html(response.message).css({ "color": "red" });
          }
      }
  });
}


function loadPasswordChangeForm() {
  $.ajax({
      type: "GET",
      url: "/rockpay/ft-password-change/send-otp-mobile",
      dataType: "html",
      success: function(response) {
          $("#load-login-form").html(response);
          $("#employee-login-modal").modal({ show: true, backdrop: 'static', keyboard: false });
      }
  });
}

$("body").on("submit", "#change-password", function(e) {
  e.preventDefault();
  var formdata = $("#change-password").serializeArray();
  changeEmployeePassword(formdata);
});


function changeEmployeePassword(formdata) {
  $.ajax({
      type: "POST",
      url: "/rockpay/ft-password-change/ftpassword-change",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#employee-login-modal").modal("hide");
              $("#employee-success-message").html(response.message).css({ "color": "green" });

          } else {

              if (typeof response.errors != "undefined" && Object.keys(response.errors).length > 0) {
                  $.each(response.errors, function(indexInArray, valueOfElement) {
                      $("#error-body").html(valueOfElement[0]).css({ "color": "red" });
                      $("input[name=" + indexInArray + "]").click(function(e) {
                          e.preventDefault();
                          $("#error-body").html("");
                      });

                  });
              } else {
                  $("#error-body").html(response.message).css({ "color": "red" });
              }

          }
      },
      complete: function() {
          setTimeout(() => {
              $("#employee-success-message").html("");
          }, timeout);
      }
  });
}



function showPasssword(elementName, iconelement) {
  var status = $("div").data("pstatus");
  x = $("input[name=" + elementName + "]")[0];
  if (x.type === "password") {
      x.type = "text";
      $(iconelement).html('<i class="fa fa-eye-slash fa-lg"></i>');
  } else {
      x.type = "password";
      $(iconelement).html('<i class="fa fa-eye fa-lg"></i>');
  }
}



$("#employee-forget-password").submit(function(e) {
  e.preventDefault();
  var formdata = $("#employee-forget-password").serializeArray();
  adminforgotPassword(formdata);
});

function adminforgotPassword(formdata) {

  $.ajax({
      type: "POST",
      url: "/rockpay/verify-employee-email",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              loadEmployeeEmailForm();

          } else {
              $("#employee-forget-form-error").html(response.message).css({ "color": "red" });
          }
      },
      complete: function() {}
  });
}

function loadEmployeeEmailForm() {
  $.ajax({
      type: "GET",
      url: "/rockpay/load-email-form",
      dataType: "html",
      success: function(response) {
          $("#success-body").html("An OTP has sent to your official email").css({ "color": "green" });
          $("#load-login-form").html(response);
          $("#employee-login-modal").modal({ show: true, backdrop: 'static', keyboard: false });
      }
  });
}

$("body").on("submit", "#employee-email-otp-form", function(e) {
  e.preventDefault();
  var formdata = $("#employee-email-otp-form").serializeArray();
  verifyemployeeEmail(formdata);
});

function verifyemployeeEmail(formdata) {
  $.ajax({
      type: "POST",
      url: "/rockpay/employee-verify-email-otp",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              if (response.load_mobile_form) {
                  loadEmployeeMobileForms();
              }
          } else {

              $("#success-body").html("");
              $("#email_otp_ajax_error").html(response.message).css({ "color": "red" });
          }
      }
  });
}

function loadEmployeeMobileForms() {
  $.ajax({
      type: "GET",
      url: "/rockpay/load-mobile-form",
      dataType: "html",
      success: function(response) {
          $("#success-body").html("An OTP has sent to your Mobile No").css({ "color": "green" });
          $("#load-login-form").html(response);
          $("#employee-login-modal").modal({ show: true, backdrop: 'static', keyboard: false });
      },
      complete: function() {

      }
  });
}


$("body").on("submit", "#forget-mobile-otp-form", function(e) {
  e.preventDefault();
  var formdata = $("#forget-mobile-otp-form").serializeArray();
  verifyemployeeMobile(formdata);

});

function verifyemployeeMobile(formdata) {
  $.ajax({
      type: "POST",
      url: "/rockpay/employee-verify-mobile-otp",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              adminResetPassword();

          } else {

              $("#success-body").html("");
              $("#mobile_otp_ajax_error").html(response.message).css({ "color": "red" });
          }
      }
  });
}

function adminResetPassword() {
  $.ajax({
      type: "GET",
      url: "/rockpay/admin-reset-password",
      dataType: "html",
      success: function(response) {
          $("#success-body").html("Three factor authentication successful <br> Change your password").css({ "color": "green" });
          $("#load-login-form").html(response);
          $("#employee-login-modal").modal({ show: true, backdrop: 'static', keyboard: false });
      }
  });
}

$("body").on("submit", "#reset-password", function(e) {
  e.preventDefault();
  var formdata = $("#reset-password").serializeArray();
  resetAdminPassword(formdata);
});


function resetAdminPassword(formdata) {
  $.ajax({
      type: "POST",
      url: "/rockpay/reset-admin-password",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {

              $("#employee-login-modal").modal("hide");
              $("#employee-success-message").html(response.message).css({ "color": "green" });
              window.location.href = response.redirect;

          } else {
              if (typeof response.errors != "undefined" && Object.keys(response.errors).length > 0) {
                  $.each(response.errors, function(indexInArray, valueOfElement) {
                      $("#error-body").html(valueOfElement[0]).css({ "color": "red" });
                      $("input[name=" + indexInArray + "]").click(function(e) {
                          e.preventDefault();
                          $("#error-body").html("");
                      });

                  });
              } else {
                  $("#error-body").html(response.message).css({ "color": "red" });
              }

          }
      },
      complete: function() {
          setTimeout(() => {
              $("#employee-success-message").html("");
          }, timeout);
      }
  });
}

function showAdminPasssword(elementName, iconelement) {
  var status = $("div").data("pstatus");
  x = $("#reset-password input[name=" + elementName + "]")[0];
  if (x.type === "password") {
      x.type = "text";
      $(iconelement).html('<i class="fa fa-eye-slash fa-lg"></i>');
  } else {
      x.type = "password";
      $(iconelement).html('<i class="fa fa-eye fa-lg"></i>');
  }
}

function setFormValues(formid, name, value) {

  if ($("#" + formid + " input[name=" + name + "]").length > 0) {
      $("#" + formid + " input[name=" + name + "]").val(value);

  } else if ($("#" + formid + " select[name=" + name + "]").length > 0) {

      $("#" + formid + " select[name=" + name + "]").val(value);

  } else if ($("#" + formid + " textarea[name=" + name + "]").length > 0) {

      $("#" + formid + " textarea[name=" + name + "]").val(value);

  }
}


$(document).on("click", ".pagination li a", function(event) {
  event.preventDefault();
  var pathname = $(this).attr("href").substr($(this).attr("href").lastIndexOf("/") + 1);
  var viewname = pathname.split("?");
  var pageid = viewname[0].split("-");
  var url = $(this).attr("href");
  if (url != "") {
      $.ajax({
          url: $(this).attr("href"),
          type: "GET",
          dataType: "html",
          success: function(response) {
              $("#paginate_" + pageid[0]).html(response);
          },
          error: function() {

          }
      });
  }
});

function urldecode(url) {
  return decodeURIComponent(url.replace(/\+/g, ' '));
}

function ajaxGETCall(url, dataOutput, successFunction, completeFunction) {
  $.ajax({
      type: "GET",
      url: url,
      dataType: dataOutput,
      success: successFunction,
      complete: completeFunction,
  });
}

//Helper Functions
function showLoader() {
  $("div#divLoading").removeClass('hide');
  $("div#divLoading").addClass('show');
}

function hideLoader() {
  $("div#divLoading").removeClass('show');
  $("div#divLoading").addClass('hide');
}