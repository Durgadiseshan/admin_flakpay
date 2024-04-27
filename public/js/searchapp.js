$("#paymentsearch").submit(function(event){
    event.preventDefault();
    var token = $("input[name='_token']").val();
    var data = {};
    var formdata = $("#paymentsearch").serializeArray();
    $.ajax({
        url:"/merchant/payments",
        type:"POST",
        data:getJsonObject(formdata),
        dataType:"json",
        success:function(response){
            var html = "";
            if(response.length > 0)
            {
                $.each(response,function(index,value){
                    html+=`<tr>
                            <td>`+value.payment_gid+`</td>
                            <td>`+value.order_gid+`</td>
                            <td>`+value.payment_amount+`</td>
                            <td>`+value.payment_email+`</td>
                            <td>`+value.payment_contact+`</td>
                            <td>`+value.created_date+`</td>
                            <td>`+value.payment_status+`</td>
                           </tr>`; 
               });
            }else{
                    html+=`<tr>
                        <td class="text-center" colspan=6>No Data found</td>
                       </tr>`; 
            }
            $("#paymenttable").html(html);
        },
        error:function(){
            console.log("error");
        }

    })

});


$("#ordersearch").submit(function(event){
    event.preventDefault();
    var formdata = $("#ordersearch").serializeArray();
    $.ajax({
     url:"/merchant/orders",
     type:"POST",
     data:getJsonObject(formdata),
     dataType:"json",
     success:function(response){
       var html = '';
       if(response.length > 0)
       {
           $.each(response,function(index,value){
                html+=`<tr>
                        <td>`+value.order_gid+`</td>
                        <td>`+value.order_amount+`</td>
                        <td>`+value.order_attempts+`</td>
                        <td>`+value.order_receipt+`</td>
                        <td>`+value.created_date+`</td>
                        <td>`+value.order_status+`</td>
                       </tr>`; 
           });
       }else{
            html+=`<tr>
                    <td class="text-center" colspan=6>No Data found</td>
                   </tr>`; 
       }
       $("#ordertable").html(html);
     },
     error:function(error){
         console.log(error.responseText());
     }
    });
});


$("#refundsearch").submit(function(event){
    event.preventDefault();
    var formdata = $("#refundsearch").serializeArray();
    $.ajax({
     url:"/merchant/refunds",
     type:"POST",
     data:getJsonObject(formdata),
     dataType:"json",
     success:function(response){
       var html = '';
       if(response.length > 0)
       {
           $.each(response,function(index,value){
                html+=`<tr>
                        <td>`+value.refund_gid+`</td>
                        <td>`+value.payment_gid+`</td>
                        <td>`+value.refund_amount+`</td>
                        <td>`+value.created_date+`</td>
                       </tr>`; 
           });
       }else{
            html+=`<tr>
                    <td class="text-center" colspan=6>No Data found</td>
                   </tr>`; 
       }
       $("#refundtable").html(html);
     },
     error:function(error){
         console.log(error.responseText());
     }
    });
});

$("#disputesearch").submit(function(event){
    event.preventDefault();
    var formdata = $("#disputesearch").serializeArray();
    $.ajax({
     url:"/merchant/disputes",
     type:"POST",
     data:getJsonObject(formdata),
     dataType:"json",
     success:function(response){
       var html = '';
       if(response.length > 0)
       {
           $.each(response,function(index,value){
                html+=`<tr>
                        <td>`+value.dispute_gid+`</td>
                        <td>`+value.payment_gid+`</td>
                        <td>`+value.dispute_amount+`</td>
                        <td>`+value.dispute_type+`</td>
                        <td>`+value.created_date+`</td>
                        <td>`+value.dispute_status+`</td>
                       </tr>`; 
           });
       }else{
            html+=`<tr>
                    <td class="text-center" colspan=6>No Data found</td>
                   </tr>`; 
       }
       $("#disputetable").html(html);
     },
     error:function(error){
         console.log(error.responseText());
     }
    });
});


$("#settlementsearch").submit(function(event){
    event.preventDefault();
    var formdata = $("#settlementsearch").serializeArray();
    $.ajax({
     url:"/merchant/settlements",
     type:"POST",
     data:getJsonObject(formdata),
     dataType:"json",
     success:function(response){
       var html = '';
       if(response.length > 0)
       {
           $.each(response,function(index,value){
                html+=`<tr>
                        <td>`+value.settlement_gid+`</td>
                        <td>`+value.settlement_amount+`</td>
                        <td>`+value.settlement_fee+`</td>
                        <td>`+value.settlement_tax+`</td>
                        <td>`+value.created_date+`</td>
                        <td>`+value.status+`</td>
                       </tr>`; 
           });
       }else{
            html+=`<tr>
                    <td class="text-center" colspan=6>No Data found</td>
                   </tr>`; 
       }
       $("#settlementtable").html(html);
     },
     error:function(error){
         console.log(error.responseText());
     }
    });
});


$("#invoicesearch").submit(function(event){
    event.preventDefault();
    var formdata = $("#invoicesearch").serializeArray();
    $.ajax({
     url:"/merchant/invoices",
     type:"POST",
     data:getJsonObject(formdata),
     dataType:"json",
     success:function(response){
       var html = '';
       if(response.length > 0)
       {
           $.each(response,function(index,value){
                html+=`<tr>
                        <td>`+value.invoice_gid+`</td>
                        <td>`+value.invoice_receiptno+`</td>
                        <td>`+value.invoice_amount+`</td>
                        <td>`+value.customer_details+`</td>
                        <td>`+value.invoice_paylink+`</td>
                        <td>`+value.invoice_status+`</td>
                        <td>`+value.created_date+`</td>
                       </tr>`; 
           });
       }else{
            html+=`<tr>
                    <td class="text-center" colspan=6>No Data found</td>
                   </tr>`; 
       }
       $("#invoicetable").html(html);
     },
     error:function(error){
         console.log(error.responseText());
     }
    });
});

$("#itemsearch").submit(function(event){
    event.preventDefault();
    var formdata = $("#itemsearch").serializeArray();
    $.ajax({
     url:"/merchant/items",
     type:"POST",
     data:getJsonObject(formdata),
     dataType:"json",
     success:function(response){
       var html = '';
       if(response.length > 0)
       {
           $.each(response,function(index,value){
                html+=`<tr>
                        <td><a href="javascript:editItem('`+value.id+`');">`+value.item_gid+`</a></td>
                        <td>`+value.item_name+`</td>
                        <td>`+value.item_amount+`</td>
                        <td>`+value.created_date+`</td>
                        <td>
                            <form name='removeitem'>
                                <input type="hidden" name="id" value=`+value.id+`>
                                <input type="submit" class="btn btn-danger btn-xs" value="Delete">
                            </form>
                        </td>
                       </tr>`; 
           });
       }else{
            html+=`<tr>
                    <td class="text-center" colspan=6>No Data found</td>
                   </tr>`; 
       }
       $("#itemtable").html(html);
     },
     error:function(error){
         console.log(error.responseText());
     }
    });
});

$("#paylinksearch").submit(function(event){
    event.preventDefault();
    var formdata = $("#paylinksearch").serializeArray();
    $.ajax({
     url:"/merchant/paylinks",
     type:"POST",
     data:getJsonObject(formdata),
     dataType:"json",
     success:function(response){
       var html = '';
       if(response.length > 0)
       {
           $.each(response,function(index,value){
            html+=`<tr>
                    <td><a href="javascript:editPaylink('`+value.id+`');">`+value.paylink_gid+`</a></td>
                    <td>`+value.paylink_receipt+`</td>
                    <td>`+value.paylink_amount+`</td>
                    <td>`+value.paylink_customer_mobile+`</td>
                    <td>`+value.paylink_customer_email+`</td>
                    <td>`+value.paylink_link+`</td>
                    <td>`+value.created_date+`</td>
                    <td>`+value.paylink_status+`</td>
                    </tr>`;
           });
       }else{
            html+=`<tr>
                    <td class="text-center" colspan=6>No Data found</td>
                   </tr>`; 
       }
       $("#paylinktable").html(html);
     },
     error:function(error){
         console.log(error.responseText());
     }
    });
});


function getJsonObject(formdata){
    var jsondata = {};
    $.each(formdata,function(index,Obj){
        jsondata[Obj.name] = Obj.value;
    });
    return jsondata;
}
