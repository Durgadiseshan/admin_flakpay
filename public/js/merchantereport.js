 
 base_url=$('#base_url').val();
 $(document).on('submit', '#report_form', function(event){
        event.preventDefault();
         $.ajax({
                    type:"POST",
                    url: base_url+'/merchant/createdownloadreport',
                    data: $('#report_form').serializeArray(),
                    async: false,
                    success: function(data){

                            var url = base_url+"/merchant/downloadreport?" + $.param(data.res);

                            window.location = url;
                             fetch_report_log(0);

                    }
       });

        fetch_report_log(0);
           
    });


 $(document).on('submit', '#datatable_form', function(event){
        event.preventDefault();
         $.ajax({
                    type:"POST",
                    url: base_url+'/merchant/createdownloadreport',
                    data: $('#datatable_form').serializeArray(),
                    async: false,
                    success: function(data){

                            var url = base_url+"/merchant/downloadreport?" + $.param(data.res);

                            window.location = url;
                             fetch_report_log(1);

                    }
       });

        fetch_report_log(1);
           
    });

 
 function fetch_report_log(is_datatable){
      $.ajax({
                    type:"GET",
                    url: base_url+'/merchant/reportlog?is_datatable='+is_datatable,
                    
                    success: function(response){

               $('#report-div').html(null);
                $('#report-div').html(response.log_view);


                    }
       });
 }



 function gstInvoiceReort(element,filter_date) {
     
        
         $('.d-show').html(null);
        $('.d-show').html(filter_date);
          $.ajax({
                    type:"POST",
                    url: base_url+'/merchant/gstinvoicereportdetails',
                    data:  {_token:$('meta[name="csrf-token"]').attr('content'), filter_date:filter_date},
                    async: false,
                    success: function(response){

                       $('#gst_report_details').html(null);
                      $('#gst_report_details').html(response.detail_view);     

                    }
       });

  
     $('#gst-report-model').modal('show');
 }