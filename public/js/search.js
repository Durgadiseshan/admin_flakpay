
//var alphanumeric = /^\w+$/;
var alphanumeric = /^([\b^\w-])*$/;
///^([\b^A-za-z0-9])*$/

$(document).ready(function(){
  $.ajaxSetup({async:true});
});

(function () {
    var showResults;
    $('#search-box').keyup(function () { 
        var searchText;
        searchText = $('#search-box').val();
        if(alphanumeric.test(searchText) || searchText=='')
        {
          return showResults(searchText);
        }
    });
    showResults = function (searchText) {
        
        if($('tbody tr:Contains(' + searchText + ')').length > 0)
        {   
            $('tbody tr').hide();
            return $('tbody tr:Contains(' + searchText + ')').show();

        }
        
    };
    jQuery.expr[':'].Contains = jQuery.expr.createPseudo(function (arg) {
        return function (elem) {
            return jQuery(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
        };
    });
}.call(this));


(function () {
  var showResults;
  $('#dash-transaction-table').keyup(function () { 
      var searchText;
      searchText = $('#dash-transaction-table').val();
      if(alphanumeric.test(searchText))
      {
        return showResults(searchText);
      }
  });

  function showResults(searchText)
  {
    if(searchText!='')
    {
      var pagemodule = 'dash_payment';
      $.ajax({
          type:"GET",
          url: "/merchant/search/"+pagemodule+"/"+searchText,
          dataType: "html",
          success: function (response) {
              $("#paginate_dash_payment").html(response);
          }
      });
    }else{
      getDashboardData();
    }
     
  }
}.call(this));


(function () {
  var showResults;
  $('#dash-refund-table').keyup(function () { 
      var searchText;
      searchText = $('#dash-refund-table').val();
      if(alphanumeric.test(searchText))
        {
          return showResults(searchText);
        }
  });

  function showResults(searchText)
  {
    if(searchText!='')
    {
      var pagemodule = 'dash_refund';
      $.ajax({
          type:"GET",
          url: "/merchant/search/"+pagemodule+"/"+searchText,
          dataType: "html",
          success: function (response) {
              $("#paginate_dash_refund").html(response);
          }
      });
    }else{
      getDashboardData();
    }
     
  }
}.call(this));

(function () {
  var showResults;
  $('#dash-settlement-table').keyup(function () { 
      var searchText;
      searchText = $('#dash-settlement-table').val();
      if(alphanumeric.test(searchText))
        {
          return showResults(searchText);
        }
  });

  function showResults(searchText)
  {
    if(searchText!='')
    {
      var pagemodule = 'dash_settlement';
      $.ajax({
          type:"GET",
          url: "/merchant/search/"+pagemodule+"/"+searchText,
          dataType: "html",
          success: function (response) {
              $("#paginate_dash_settlement").html(response);
          }
      });
    }else{
      getDashboardData();
    }
     
  }
}.call(this));

(function () {
  var showResults;
  $('#dash-logactivities-table').keyup(function () { 
      var searchText;
      searchText = $('#dash-logactivities-table').val();
      if(alphanumeric.test(searchText))
        {
          return showResults(searchText);
        }
  });

  function showResults(searchText)
  {
    if(searchText!='')
    {
      var pagemodule = 'dash_logactivities';
      $.ajax({
          type:"GET",
          url: "/merchant/search/"+pagemodule+"/"+searchText,
          dataType: "html",
          success: function (response) {
              $("#paginate_dash_logactivities").html(response);
          }
      });
    }else{
      getDashboardData();
    }
     
  }
}.call(this));



(function () {
    var showResults;
    $('#transaction-table').keyup(function () { 
        var searchText;
        searchText = $('#transaction-table').val();
        if(alphanumeric.test(searchText))
        {
          return showResults(searchText);
        }
    });

    function showResults(searchText)
    {
      if(searchText!='')
      {
        var pagemodule = 'payment';
        $.ajax({
            type:"GET",
            url: "/merchant/search/"+pagemodule+"/"+searchText,
            dataType: "html",
            success: function (response) {
                $("#paginate_payment").html(response);
            }
        });
      }else{
          getAllPayments();
      }
       
    }
}.call(this));


(function () {
    var showResults;
    $('#refund-table').keyup(function () { 
        var searchText;
        searchText = $('#refund-table').val();
        if(alphanumeric.test(searchText))
        {
          return showResults(searchText);
        }
    });
    function showResults(searchText)
    {
      if(searchText!='')
      {
        var pagemodule = 'refund';
        $.ajax({
            type:"GET",
            url: "/merchant/search/"+pagemodule+"/"+searchText,
            dataType: "html",
            success: function (response) {
                $("#paginate_refund").html(response);
            }
        });
      }else{
        getAllRefunds();
      }
       
    }
}.call(this));


(function () {
    var showResults;
    $('#order-table').keyup(function () { 
        var searchText;
        searchText = $('#order-table').val();
        if(alphanumeric.test(searchText))
        {
          return showResults(searchText);
        }
    });
    function showResults(searchText)
    {
      if(searchText!='')
      {
        var pagemodule = 'order';
        $.ajax({
            type:"GET",
            url: "/merchant/search/"+pagemodule+"/"+searchText,
            dataType: "html",
            success: function (response) {
                $("#paginate_order").html(response);
            }
        });
      }else{
        getAllOrders();
      }
       
    }
}.call(this));


(function () {
    var showResults;
    $('#dispute-table').keyup(function () { 
        var searchText;
        searchText = $('#dispute-table').val();
        if(alphanumeric.test(searchText))
        {
          return showResults(searchText);
        }
    });
    function showResults(searchText)
    {
      if(searchText!='')
      {
        var pagemodule = 'dispute';
        $.ajax({
            type:"GET",
            url: "/merchant/search/"+pagemodule+"/"+searchText,
            dataType: "html",
            success: function (response) {
                $("#paginate_dispute").html(response);
            }
        });
      }else{
        getAllDisputes();
      }
    }
}.call(this));


(function () {
    var showResults;
    $('#paylink-table').keyup(function () { 
        var searchText;
        searchText = $('#paylink-table').val();
        if(alphanumeric.test(searchText))
        {
          return showResults(searchText);
        }
    });
    function showResults(searchText)
    {
      if(searchText!='')
      {
        var pagemodule = 'paylink';
        $.ajax({
            type:"GET",
            url: "/merchant/search/"+pagemodule+"/"+searchText,
            dataType: "html",
            success: function (response) {
                $("#paginate_paylink").html(response);
            }
        });
      }else{
        getAllPaylinks();
      }
       
    }
}.call(this));

(function () {
    var showResults;
    $('#quickpaylink-table').keyup(function () { 
        var searchText;
        searchText = $('#quickpaylink-table').val();
        if(alphanumeric.test(searchText))
        {
          return showResults(searchText);
        }
    });
    function showResults(searchText)
    {
      if(searchText!='')
      {
        var pagemodule = 'quicklink';
        $.ajax({
            type:"GET",
            url: "/merchant/search/"+pagemodule+"/"+searchText,
            dataType: "html",
            success: function (response) {
                $("#paginate_quicklink").html(response);
            }
        });
      }else{
          getAllPayments();
      }
       
    }
}.call(this));

(function () {
    var showResults;
    $('#invoice-table').keyup(function () { 
        var searchText;
        searchText = $('#invoice-table').val();
        if(alphanumeric.test(searchText))
        {
          return showResults(searchText);
        }
    });
    function showResults(searchText)
    {
      if(searchText!='')
      {
        var pagemodule = 'invoice';
        $.ajax({
            type:"GET",
            url: "/merchant/search/"+pagemodule+"/"+searchText,
            dataType: "html",
            success: function (response) {
                $("#paginate_invoice").html(response);
            }
        });
      }else{
        getAllInvoices();
      }
       
    }
}.call(this));

(function () {
    var showResults;
    $('#item-table').keyup(function () { 
        var searchText;
        searchText = $('#item-table').val();
        if(alphanumeric.test(searchText))
        {
          return showResults(searchText);
        }
    });
    function showResults(searchText)
    {
      if(searchText!='')
      {
        var pagemodule = 'item';
        $.ajax({
            type:"GET",
            url: "/merchant/search/"+pagemodule+"/"+searchText,
            dataType: "html",
            success: function (response) {
                $("#paginate_item").html(response);
            }
        });
      }else{
          getAllPayments();
      }
       
    }
}.call(this));

(function () {
    var showResults;
    $('#customer-table').keyup(function () { 
        var searchText;
        searchText = $('#customer-table').val();
        if(alphanumeric.test(searchText))
        {
          return showResults(searchText);
        }
    });
    function showResults(searchText)
    {
      if(searchText!='')
      {
        var pagemodule = 'customer';
        $.ajax({
            type:"GET",
            url: "/merchant/search/"+pagemodule+"/"+searchText,
            dataType: "html",
            success: function (response) {
                $("#paginate_customer").html(response);
            }
        });
      }else{
        getAllCustomers();
      }
       
    }
}.call(this));


(function () {
    var showResults;
    $('#adjustment-table').keyup(function () { 
        var searchText;
        searchText = $('#adjustment-table').val();
        if(alphanumeric.test(searchText))
        {
          return showResults(searchText);
        }
    });
    function showResults(searchText)
    {
      if(searchText!='')
      {
        var pagemodule = 'payment';
        $.ajax({
            type:"GET",
            url: "/merchant/search/"+pagemodule+"/"+searchText,
            dataType: "html",
            success: function (response) {
                $("#paginate_payment").html(response);
            }
        });
      }else{
          getAllPayments();
      }
       
    }
}.call(this));


(function () {
    var showResults;
    $('#resolution-table').keyup(function () { 
        var searchText;
        searchText = $('#resolution-table').val();
        if(alphanumeric.test(searchText))
        {
          return showResults(searchText);
        }
    });
    function showResults(searchText)
    {
      if(searchText!='')
      {
        var pagemodule = 'casedetail';
        $.ajax({
            type:"GET",
            url: "/merchant/search/"+pagemodule+"/"+searchText,
            dataType: "html",
            success: function (response) {
                $("#paginate_casedetail").html(response);
            }
        });
      }else{
        getCustomerCaseData();
      }
       
    }
}.call(this));

(function () {
    var showResults;
    $('#feedback-table').keyup(function () { 
        var searchText;
        searchText = $('#feedback-table').val();
        if(alphanumeric.test(searchText))
        {
          return showResults(searchText);
        }
    });
    function showResults(searchText)
    {
      if(searchText!='')
      {
        var pagemodule = 'feedbackdetail';
        $.ajax({
            type:"GET",
            url: "/merchant/search/"+pagemodule+"/"+searchText,
            dataType: "html",
            success: function (response) {
                $("#paginate_feedbackdetail").html(response);
            }
        });
      }else{
        getFeedbackData();
      }
       
    }
}.call(this));


(function () {
    var showResults;
    $('#support-table').keyup(function () { 
        var searchText;
        searchText = $('#support-table').val();
        if(alphanumeric.test(searchText))
        {
          return showResults(searchText);
        }
    });
    function showResults(searchText)
    {
      if(searchText!='')
      {
        var pagemodule = 'merchantsupport';
        $.ajax({
            type:"GET",
            url: "/merchant/search/"+pagemodule+"/"+searchText,
            dataType: "html",
            success: function (response) {
                $("#paginate_merchantsupport").html(response);
            }
        });
      }else{
        getSupportData();
      }
       
    }
}.call(this));


(function () {
    var showResults;
    $('#coupon-table').keyup(function () { 
        var searchText;
        searchText = $('#coupon-table').val();
        if(alphanumeric.test(searchText))
        {
          return showResults(searchText);
        }
    });
    function showResults(searchText)
    {
      if(searchText!='')
      {
        var pagemodule = 'coupon';
        $.ajax({
            type:"GET",
            url: "/merchant/search/"+pagemodule+"/"+searchText,
            dataType: "html",
            success: function (response) {
                $("#paginate_coupon").html(response);
            }
        });
      }else{
        getAllCoupons();
      }
       
    }
}.call(this));


(function (e) {
    var showResults;
    $('#product-table').keyup(function(e){ 
      var keyCode = e.keyCode || e.which;
      if (keyCode === 13) { 
        e.preventDefault();
        return false;
      }
      var searchText;
      searchText = $('#product-table').val();
      if(alphanumeric.test(searchText))
        {
          return showResults(searchText);
        }
    });
    function showResults(searchText)
    {
      if(searchText!='')
      {
        var pagemodule = 'product';
        $.ajax({
            type:"GET",
            url: "/merchant/search/"+pagemodule+"/"+searchText,
            dataType: "html",
            success: function (response) {
                $("#paginate_product").html(response);
            }
        });
      }else{
        getAllProducts();
      }
       
    }
}.call(this));

(function () {
    var showResults;
    $('#notification-table').keyup(function () { 
        var searchText;
        searchText = $('#notification-table').val();
        if(alphanumeric.test(searchText))
        {
          return showResults(searchText);
        }
    });
    function showResults(searchText)
    {
      if(searchText!='')
      {
        var pagemodule = 'notification';
        $.ajax({
            type:"GET",
            url: "/merchant/search/"+pagemodule+"/"+searchText,
            dataType: "html",
            success: function (response) {
                $("#paginate_notification").html(response);
            }
        });
      }else{
        getAllMerchantNotifications();
      }
       
    }
}.call(this));


(function () {
    var showResults;
    $('#message-table').keyup(function () { 
        var searchText;
        searchText = $('#message-table').val();
        if(alphanumeric.test(searchText))
        {
          return showResults(searchText);
        }
    });
    function showResults(searchText)
    {
      if(searchText!='')
      {
        var pagemodule = 'message';
        $.ajax({
            type:"GET",
            url: "/merchant/search/"+pagemodule+"/"+searchText,
            dataType: "html",
            success: function (response) {
                $("#paginate_message").html(response);
            }
        });
      }else{
        getAllMerchantMessages();
      }
       
    }
}.call(this));

// Button
(function(e,t,n){var r=e.querySelectorAll("html")[0];r.className=r.className.replace(/(^|\s)no-js(\s|$)/,"$1js$2")})(document,window,0);



'use strict';

(function (document, window, index )
{
  var inputs = document.querySelectorAll('.inputfile');
	Array.prototype.forEach.call( inputs, function( input )
	{
    
		var label	 = input.nextElementSibling,
			labelVal = label.innerHTML;

		input.addEventListener( 'change', function( e )
		{
			var fileName = '';
			if( this.files && this.files.length > 1 )
				fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
			else
				fileName = e.target.value.split( '\\' ).pop();

			if( fileName )
				label.querySelector( 'span' ).innerHTML = fileName;
			else
				label.innerHTML = labelVal;
		});

		
		input.addEventListener( 'focus', function(){ input.classList.add( 'has-focus' ); });
		input.addEventListener( 'blur', function(){ input.classList.remove( 'has-focus' ); });
	});
}( document, window, 0 ));

//Rating Section
$(document).ready(function(){
  
    /* 1. Visualizing things on Hover - See next part for action on click */
    $('#stars li').on('mouseover', function(){
      var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on
     
      // Now highlight all the stars that's not after the current hovered star
      $(this).parent().children('li.star').each(function(e){
        if (e < onStar) {
          $(this).addClass('hover');
        }
        else {
          $(this).removeClass('hover');
        }
      });
      
    }).on('mouseout', function(){
      $(this).parent().children('li.star').each(function(e){
        $(this).removeClass('hover');
      });
    });
    
    
    /* 2. Action to perform on click */
    $('#stars li').on('click', function(){
      var onStar = parseInt($(this).data('value'), 10); // The star currently selected
      var stars = $(this).parent().children('li.star');
      
      for (i = 0; i < stars.length; i++) {
        $(stars[i]).removeClass('selected');
      }
      
      for (i = 0; i < onStar; i++) {
        $(stars[i]).addClass('selected');
      }
      
      // JUST RESPONSE (Not needed)
      var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
      var msg = "";
      if (ratingValue > 1) {
          msg = "Thanks! You rated this " + ratingValue + " stars.";
      }
      else {
          msg = "We will improve ourselves. You rated this " + ratingValue + " stars.";
      }
      responseMessage(msg);
      
    });
    
    
  });
  
  
  function responseMessage(msg) {
    $('.success-box').fadeIn(200);  
    $('.success-box div.text-message').html("<span>" + msg + "</span>");
  }


$('#Show').click(function() {
  $('.about-1').show(1000);
  $('#Show').hide(0);
  $('#Hide').show(0);
});
$('#Hide').click(function() {
  $('.about-1').hide(1000);
  $('#Show').show(0);
  $('#Hide').hide(0);
});


  //transaction toggle
  $(document).ready(function() {
    $('#buton-2').click(function() {
      $(this).siblings(".about-1").toggle();
    });
  });

  