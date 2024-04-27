$(document).ready(function() {
    function disableBack() { window.history.forward() }

    window.onload = disableBack();
    window.onpageshow = function(evt) { if (evt.persisted) disableBack() }
 
});
$(window).on('keydown', function(event) {
	if (event.keyCode == 123) {
	return false; //Disable F12
	} else if (event.ctrlKey && event.shiftKey && event.keyCode == 73) {
	return false; //Disable ctrl+shift+i
	} 
	else if (event.ctrlKey && event.shiftKey && event.keyCode == 67) {
	return false; //Disable ctrl+shift+i
	} else if (event.ctrlKey && event.keyCode == 73) {
	return false; //Disable ctrl+shift+c
	}
	else if (event.ctrlKey && event.keyCode == 83) {
		return false; //Disable ctrl+s
		}
	else if (event.ctrlKey && event.keyCode == 85) {
		return false; //Disable ctrl+s
		}
	else if (event.ctrlKey && event.keyCode == 74) {
		return false; //Disable ctrl+s
		}
	});
// disable mouse right click 
// document.addEventListener('contextmenu', event => event.preventDefault());
// f12 key disable
/*  $(document).keydown(function(event){
    if(event.keyCode==123){
        return false;
    }
    else if (event.ctrlKey && event.shiftKey && event.keyCode==73){        
             return false;
    }
    else if(event.keyCode ==16){
         	 return false;
        }
    else if(event.keyCode ==17){
    	 return false;
   }
});  */
/* $(document).on("contextmenu",function(e){        
   e.preventDefault();
}); */
// f12 key cdoe end
   if ( window.history.replaceState ) {
	  window.history.replaceState( null, null, window.location.href );
	 // history.pushState(null, null, 'new1');
	} 
	//window.history.go(-1);
//	window.history.forward(0);
//============ cc =============================================
var yearsToShow = 20;
var thisYear = (new Date()).getFullYear();
for (var y = thisYear; y < thisYear + yearsToShow; y++) {
  var yearOption = document.createElement("option");
  yearOption.value = y;
  yearOption.text = y;
  document.getElementById("expYear").appendChild(yearOption);
}
//============ cc =============================================
	//============ dc =============================================
	var dcYearsToShow = 20;
	var thisYearDC = (new Date()).getFullYear();
	for (var x = thisYearDC; x < thisYearDC + dcYearsToShow; x++) {
	  var yearOptionDC = document.createElement("option");
	  yearOptionDC.value = x;
	  yearOptionDC.text = x;
	  document.getElementById("expYearDC").appendChild(yearOptionDC);
	}
	//============ dc =============================================
/* function checkRefresh(){
		  if(document.cookie.indexOf('mycookie')==-1) {
		    // cookie doesn't exist, create it now
		    document.cookie = 'mycookie=1';
		  }
		  else {
		    // not first visit, so alert
		    alert('You refreshed!');
		  }
		
} */
function cancelFunction() {
	$("#myCancelModal").modal({backdrop: "static"});
	}
function myFunction() {
	var answer = window.confirm("Are you sure you want to cancel?");
	if (answer) {
		
		cancelledAjax();
	}
	else {
	    return false;
	}
	}
function cancelledAjax() {
	//var obj = 'id='+${id};
    $.ajax({
          url: "/Rupayapay/cancelled",           
          type: "GET",
          //contentType : "application/json",
			dataType : 'text',
            //data : JSON.stringify(obj),
            data : obj,
			//data:test,
			success: function(response)
            {
	          //  alert("Result"+response);
				//window.location.href = "http://localhost:8080/";
				window.location.replace("http://182.18.157.80:8080/");
				//window.location.replace("http://127.0.0.1:8000/index");
				
            } ,
         	/* error: function()
             {
             alert('Error fetching record.... Sorry..');	            
             } */
  		 });	
}
function myFunctionTest() {
	$("#cardtest").click(function(){
		$("div.ccard").css("display","block");
		$("div.dcard").css("display","none");
		$("div.net").css("display","none");
		$("div.upiview").css("display","none");
});
	}
//================= credit card =======================
function cc_format(value) {
	  var v = value.replace(/\s+/g, '').replace(/[^0-9]/gi, '')
	  var matches = v.match(/\d{4,16}/g);
	  var match = matches && matches[0] || ''
	  var parts = []
	  for (i=0, len=match.length; i<len; i+=4) {
	    parts.push(match.substring(i, i+4))
	  }
	  if (parts.length) {
	    return parts.join(' ')
	  } else {
	    return value
	  }
	}
/*$('#credit-card').on('keypress change', function () {
	  $(this).val(function (index, value) {
		  return value.replace(/\W/gi, '').replace(/(.{4})/g, '$1 ');
	  });
	});*/
$('#debit-card').on('keypress change', function () {
	  $(this).val(function (index, value) {
		  return value.replace(/\W/gi, '').replace(/(.{4})/g, '$1 ');
	  });
	});
$('#credit-card').on('keyup', function () {
	  $(this).val(function (index, value) {

	    const selectionStart = $(this).get(0).selectionStart;
	    let trimmedCardNum = value.replace(/\s+/g, '');

	    if (trimmedCardNum.length > 16) {
	      trimmedCardNum = trimmedCardNum.substr(0, 16);
	    }

	    /* Handle American Express 4-6-5 spacing format */
	    const partitions = trimmedCardNum.startsWith('34') || trimmedCardNum.startsWith('37') 
	                       ? [4,6,5] 
	                       : [4,4,4,4];
	    
	    const numbers = [];
	    let position = 0;
	    partitions.forEach(partition => {
	      const part = trimmedCardNum.substr(position, partition);
	      if (part) numbers.push(part);
	      position += partition;
	    });

	    const formattedCardNum = numbers.join(' ');

	    /* Handle caret position if user edits the number later */
	    if (selectionStart < formattedCardNum.length - 1) {
	      setTimeout(() => {
	        $(this).get(0).setSelectionRange(selectionStart, selectionStart, 'none');
	      });
	    };

	    return formattedCardNum;
	  })
	});
function InvalidMsg(textbox) {
    
    if (textbox.value == '') {
        textbox.setCustomValidity('Required email address');
    }
    else if(textbox.validity.typeMismatch){
        textbox.setCustomValidity('please enter a valid email address');
    }
    else {
        textbox.setCustomValidity('');
    }
    return true;
}
	// ================= credit card =======================
function CheckDate() {
    var selectedDate = new Date (document.getElementById("expYear").value,document.getElementById("card_exp_month").value)
    var nextmonth = selectedDate.setMonth(selectedDate.getMonth() + 1);
    var last_date_of_selected_date = new Date(nextmonth -1);
    var today = new Date();
    if (today > selectedDate) {
        alert("Invalid");
    }
    else {
        alert("Valid");
    }
}
	// ================= debit card =======================
/*	function dc_format(value) {
		  var v = value.replace(/\s+/g, '').replace(/[^0-9]/gi, '')
		  var matches = v.match(/\d{4,16}/g);
		  var match = matches && matches[0] || ''
		  var parts = []
		  for (i=0, len=match.length; i<len; i+=4) {
		    parts.push(match.substring(i, i+4))
		  }
		  if (parts.length) {
		    return parts.join(' ')
		  } else {
		    return value
		  }
		}

		onload = function() {
		  document.getElementById('dc').oninput = function() {
		    this.value = dc_format(this.value)
		  }
		  document.getElementById('cc').oninput = function() {
			    this.value = cc_format(this.value)
			  }
		}*/
		// ================= debit card =======================
		 
$(document).ready(function(){
	$(".exp").on('input', function() {
		 var d = new Date();
		  var exp_month = $("#card_exp_month").val();
		  var exp_year = $("#expYear").val();
		  
		  if(exp_month==null){
			  alert("Please Select Month");
			  
		  }else{
			  var curr_month = parseInt(d.getUTCMonth() + 1); // Since getUTCMonth()
			  //alert(curr_month);
			  var curr_year =parseInt(d.getUTCFullYear());

			  /*$("#billing_nxtBtn").prop('disabled', exp_year < curr_year || (exp_year == curr_year && exp_month < curr_month));*/
			  if (exp_year < curr_year) {
			        $("#billing_nxtBtn").attr("disabled", true);
			    } else if (exp_year > curr_year) {
			        $("#billing_nxtBtn").removeAttr("disabled");
			    } else {
			        if (exp_month >= curr_month) {		        	
			            $("#billing_nxtBtn").removeAttr("disabled");
			        } else {
			        	alert("card expired");
			            $("#billing_nxtBtn").attr("disabled", true);
			        }
			    }
		  }

		});
	$(".expDc").on('input', function() {
		 var d = new Date();
		  var exp_month = $("#card_exp_monthDc").val();
		  var exp_year = $("#expYearDC").val();
		  if(exp_month==null){
			  alert("Please Select Month");
		  }else{
			  var curr_month = parseInt(d.getUTCMonth() + 1); // Since getUTCMonth()
			  //alert(curr_month);
			  var curr_year =parseInt(d.getUTCFullYear());

			  /*$("#billing_nxtBtn").prop('disabled', exp_year < curr_year || (exp_year == curr_year && exp_month < curr_month));*/
			  if (exp_year < curr_year) {
			        $("#billing_nxtBtnDc").attr("disabled", true);
			    } else if (exp_year > curr_year) {
			        $("#billing_nxtBtnDc").removeAttr("disabled");
			    } else {
			        if (exp_month >= curr_month) {		        	
			            $("#billing_nxtBtnDc").removeAttr("disabled");
			        } else {
			        	alert("card expired");
			            $("#billing_nxtBtnDc").attr("disabled", true);
			        }
			    }

		  }
		 		});
	/*  $("#inputTextBox").keydown(function(event){
	        var inputValue = event.which;
	        // allow letters and whitespaces only.
	        if(!(inputValue >= 65 && inputValue <= 120) && (inputValue != 32 && inputValue != 0)) { 
	            event.preventDefault(); 
	        }
	    });
	 $("#inputTextBox2").keydown(function(event){
	        var inputValue = event.which;
	        // allow letters and whitespaces only.
	        if(!(inputValue >= 65 && inputValue <= 120) && (inputValue != 32 && inputValue != 0)) { 
	            event.preventDefault(); 
	        }
	    }); */
	   $("#inputTextBox").keypress(function(event){
	        var inputValue = event.charCode;
	        if(!(inputValue >= 65 && inputValue <= 122) && (inputValue != 32 && inputValue != 0)){
	            event.preventDefault();
	        }
	    });
	   $("#inputTextBox2").keypress(function(event){
	        var inputValue = event.charCode;
	        if(!(inputValue >= 65 && inputValue <= 122) && (inputValue != 32 && inputValue != 0)){
	            event.preventDefault();
	        }
	    });
	 $("#cardtest").click(function(){
    			$("div.ccard").css("display","block");
				$("div.dcard").css("display","none");
				$("div.net").css("display","none");
				$("div.upiview").css("display","none");
				$("div.paylater").css("display","none");
				$("div.wallet").css("display","none");
				$("div.debitpin").css("display","none");
    });
	 $("button").click(function(){
		  $("button").removeClass("active");
		  $(this).addClass("active");
		});
		$("#dcard").click(function(){
			$("div.dcard").css("display","block");
			$("div.ccard").css("display","none");			
			$("div.net").css("display","none");
			$("div.upiview").css("display","none");
			$("div.paylater").css("display","none");
			$("div.wallet").css("display","none");
			$("div.debitpin").css("display","none");
});
	$("#net").click(function(){
    			$("div.ccard").css("display","none");				
				$("div.dcard").css("display","none");
				$("div.net").css("display","block");
				$("div.upiview").css("display","none");
				$("div.paylater").css("display","none");
				$("div.wallet").css("display","none");
				$("div.debitpin").css("display","none");
    });
	$("#upi").click(function(){
		$("div.ccard").css("display","none");				
		$("div.dcard").css("display","none");
		$("div.net").css("display","none");
		$("div.upiview").css("display","block");
		$("div.paylater").css("display","none");
		$("div.wallet").css("display","none");
		$("div.debitpin").css("display","none");
});
	$("#paylater").click(function(){
		$("div.ccard").css("display","none");				
		$("div.dcard").css("display","none");
		$("div.net").css("display","none");
		$("div.upiview").css("display","none");
		$("div.paylater").css("display","block");
		$("div.wallet").css("display","none");
		$("div.debitpin").css("display","none");
});
	$("#wallet").click(function(){
		$("div.ccard").css("display","none");				
		$("div.dcard").css("display","none");
		$("div.net").css("display","none");
		$("div.upiview").css("display","none");
		$("div.paylater").css("display","none");
		$("div.wallet").css("display","block");
		$("div.debitpin").css("display","none");
});
	$("#debitpin").click(function(){
		$("div.ccard").css("display","none");				
		$("div.dcard").css("display","none");
		$("div.net").css("display","none");
		$("div.upiview").css("display","none");
		$("div.paylater").css("display","none");
		$("div.wallet").css("display","none");
		$("div.debitpin").css("display","block");
});
 
$("#cancelOrder").click(function(){
	$("#myCancelModal").modal({backdrop: "static"});
	});
});
function openWin() {
	//window.onblur = () => window.focus();
	  myWindow = window.open("https://www.onlinesbi.com/", "", "width=800, height=800");
	  backdrop: false;
    }
    


    //

    function onlyNumberKey(evt) { 
          
        // Only ASCII charactar in that range allowed 
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode 
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57)) 
            return false; 
        return true; 
    } 
  //  support for the American Express format (15 digits instead of 16).

$('#credit-card').on('keypress change', function () {
  $(this).val(function (index, value) {
	  return value.replace(/[^0-9]/g, "").replace(/\W/gi, '').replace(/(.{4})/g, '$1 ');
  });
});