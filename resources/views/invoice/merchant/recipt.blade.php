<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$data['page_title']}} GST Invoice</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <style type="text/css">
        body{
      word-wrap: break-word;
      margin: 0;padding: 0;font-family: "Arial","-apple-system,BlinkMacSystemFont","Segoe UI","Roboto","Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
     }

     header {
                /*position: fixed;
                top: -60px;
                z-index: 1;*/ 
                min-height: 150px;
                background-color: #752727;
                color: white;
                text-align: center;
                line-height: 35px;
                width: 100%;
            }



            footer {
                position: fixed;
                bottom: -60px;
                height: 150px;
                background-color: #752727;
                color: white;
                text-align: center;
                line-height: 35px;
                width: 100%;
            }

             table{
        font-size: x-small;
    }
    tfoot tr td{
        font-weight: bold;
        font-size: x-small;
    }
    .gray {
        background-color: lightgray
    }

     /* Basic Table Styling */
            table {
                border-collapse: collapse;
                border-spacing: 0;
                page-break-inside: always;
                border: 0;
                margin: 0;
                padding: 0;
            }
            th, td {
                vertical-align: top;
                text-align: left;
            }
           
            tr.no-borders,
            td.no-borders {
                border: 0 !important;
                border-top: 0 !important;
                border-bottom: 0 !important;
                padding: 0 !important;
                width: auto;
            }
            /* Header */
            table.head {
                margin-bottom: 12mm;
            }
            td.header img {
                max-height: 3cm;
                width: auto;
            }
            td.header {
                font-size: 16pt;
                font-weight: 700;
            }
            
           
            .invoice .shipping-address {
                width: 30%;
            }
            .packing-slip .billing-address {
                width: 30%;
            }
            td.order-data table th {
                font-weight: normal;
                padding-right: 2mm;
            }

            table.order-details {
                width:100%;
                margin-bottom: 8mm;
            }
            
            .order-details tr {
                page-break-inside: always;
                page-break-after: auto;
            }
            .order-details td,
            .order-details th {
                border-bottom: 1px #ccc solid;
                border-top: 1px #ccc solid;
                padding: 0.375em;
            }
            .order-details th {
                font-weight: bold;
                text-align: left;
            }
            .order-details thead th {
                color: white;
                background-color: gray;
                border-color: black;
            }

            .order-details tr.bundled-item td.product {
                padding-left: 5mm;
            }
            .order-details tr.product-bundle td,
            .order-details tr.bundled-item td {
                border: 0;
            }
          

           
            table.totals {
                width: 100%;
                margin-top: 5mm;
            }
            table.totals th,
            table.totals td {
                border: 0;
                border-top: 1px solid #ccc;
                border-bottom: 1px solid #ccc;
            }
            table.totals th.description,
            table.totals td.price {
                width: 50%;
            }
            table.totals tr:last-child td,
            table.totals tr:last-child th {
                border-top: 2px solid #000;
                border-bottom: 2px solid #000;
                font-weight: bold;
            }
            table.totals tr.payment_method {
                display: none;
            }
    </style>
</head>

<body style=''>

<header class="">
 <table style="border-collapse: collapse;max-width: 767px;width: 100%;text-align: center;margin: 0 auto;margin-bottom: 30px;">
        <thead class="background: #FFFFFF;">
            <th style="text-align: left;padding: 20px 0 20px 30px;font-size: 14px;line-height: 30px; font-weight: 400;">                
                <img src="<?=$data['payflash_img']?>" style="margin-top: 10px;"> <br>
                   Payflash Pvt Ltd <br>
                 <b>GSTIN</b> 23AAACW9768L1ZO            
            </th>
            <th style="font-size: 14px;color: #fff;font-weight: 400;padding: 20px 30px 20px 0;line-height: 30px;">
                <span class="text-left">Invoice Copy:</span> <span class="text-right">GST</span> <br>
                <span class="text-left">Invoice Date:</span> <span class="text-right"> {{$data['settlement']['my_date']}}</span> <br>
                <span class="text-left">Invoice No.:</span> <span class="text-right"> {{$data['settlement']['settlement_receiptno']}} </span><br>
            </th>
        </thead>
</table>        
</header>
<footer>
           
       
    <table style="border-collapse: collapse;max-width: 767px;width: 100%;text-align: center;margin: 0 auto;">
       
      
        <tr>
            <td colspan="2" >
                <p style="font-size: 20px;color: #000000;font-weight: 600;text-align: center;">Payflash Private Limited</p>
            </td>
        </tr>
        <tr style="background: #F8F9FA;">
            <td colspan="2" style="font-size: 16px;color: #939393;font-weight: 400;text-align: center;">
                <p>#175 & 176,Bannerghatta Main Road, 
                    <br>Dollars Colony, Phase 4, J. P. Nagar,
                    Bengaluru, Karnataka 560076</p>
            </td>
        </tr>
        
    </table>
</footer>

<div class="container">  
  <main>     
    <table style="border-collapse: collapse;max-width: 767px;width: 100%;text-align: center;margin: 0 auto;margin-bottom: 30px;">
       <!--  <thead class="background: #FFFFFF;">
            <th style="text-align: left;padding: 20px 0 20px 30px">                
                <img src="<?=$data['payflash_img']?>">  Walkover Web Solutions Private Limited GSTIN23AAACW9768L1ZO            
            </th>
            <th style="text-align: right;font-size: 18px;color: #252525;font-weight: 400;padding: 20px 30px 20px 0">
                Invoice Copy sales <br>
                Invoice Date 11-03-2022 <br>
                Invoice No. 20220311-13 <br>
            </th>
        </thead> -->
 </table>



     <table style="border-collapse: collapse;max-width: 767px;width: 100%;margin: 0 auto;margin-bottom: 20px;">
            <tr style="background: #F8F9FA;">
                <td colspan="2" style="text-align: left;">
                   <strong style="font-size: 20px;color: #000000;font-weight: 500;">Billing Address</strong><br>
                   <span style="font-size: 16px;color: #252525;font-weight: 400;">
                   {{$data['merchant_details']->business_name}} <br>
                   {{$data['merchant_details']->address}}<br>
                   {{$data['merchant_details']->state_name}}<br> 
                   {{$data['merchant_details']->city}},{{$data['merchant_details']->pincode}}<br>
                   GSTIN: {{$data['merchant_details']->comp_gst}}
              </span>

                </td>
                <td colspan="2" style="text-align: left;">
            <!--     <strong  style="font-size: 20px;color: #000000;font-weight: 500;">Shipping Address</strong><br>
                   Arya One Building,Prenderghest Road, <br>
                    Secunderabad, Hyderabad<br> 
                  Telangana -->
              </td>
                <td colspan="2" style="text-align: right;">
                     <strong style="font-size: 20px;color: #000000;font-weight: 500;">{{$data['settlement']['merchant']['name']}} </strong>

                    <br> 
                     <span style="font-size: 16px;color: #252525;font-weight: 400;">{{$data['settlement']['merchant']['email']}} 
                    <br> {{$data['settlement']['merchant']['mobile_no']}} 
                </span>
                    
                    </td>
            </tr>
    </table>     

        <!-- <table style="border-collapse: collapse;max-width: 767px;width: 100%;text-align: left;margin: 0 auto;margin-bottom: 20px;">
            <tr style="background: #F8F9FA;">
                <td colspan="2" style="font-size: 20px;color: #000000;font-weight: 700;padding: 25px 30px 8px 30px;text-align: left;">
                    YOUR BACKERS FOUNDATION</td>
            </tr>
            <tr style="background: #F8F9FA;">
                <td colspan="2" style="font-size: 16px;color: #252525;font-weight: 400;padding: 0 30px 12px 30px;text-align: left;">
                    sec.8. license No: 125054</td>
            </tr>
            <tr style="background: #F8F9FA;">
                <td colspan="2" style="font-size: 16px;color: #252525;font-weight: 400;padding: 0 30px 12px 30px;text-align: left;">
                    Unique Reg.No: AAbCFEREY11ZY116</td>
            </tr>
            <tr style="background: #F8F9FA;">
                <td colspan="2" style="font-size: 16px;color: #252525;font-weight: 400;padding: 0 30px 25px 30px;text-align: left;">
                    Ph.No: 0413-2913939 | Email: contact@yourbackers.org | Web: www.yourbackers.org</td>
            </tr>
        </table> -->
   

    <table class="order-details">
            <thead>

                <tr>
                    <th class="product">Description</th>
                    <th class="quantity" style=" width: 20%;">Taxable Amount</th>
                     <th class="quantity" style=" width: 20%;">GST Amount (18%)</th>
                    <th class="price" style=" width: 20%;">Total Amount</th>
                </tr>
            </thead>
            <tbody>
               
                <tr>
                    <td>Settelment</td>
                    <td>{{$data['settlement']['total_fee']}}</td>
                    <td>{{$data['settlement']['total_tax']}}</td>
                    <td>{{$data['settlement']['total_tax']+$data['settlement']['total_fee']}}</td>
                </tr>
           
                
            </tbody>
            <tfoot>

                <tr class="no-borders">
                    <td class="no-borders">
                        <div class="customer-notes">
                        </div>
                    </td>
                    <td class="no-borders" colspan="3">
                        <table class="totals">
                            <tfoot>

                            <tr class="cart_subtotal">
                                 <td></td>
                                <td class="no-borders"></td>


                                <th class="description">Subtotal</th>
                                    <td></td>
                                <td class="price"><span class="totals-price"><span class="amount"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span> {{$data['settlement']['total_tax']+$data['settlement']['total_fee']}}</span></span></td>
                            </tr>
                            <tr class="order_total">
                                 <td></td>
                                <td class="no-borders"></td>
                                
                                <th class="description">Total</th>
                                 <td></td>
                                <td class="price"><span class="totals-price"><span class="amount"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span> {{$data['settlement']['total_tax']+$data['settlement']['total_fee']}}</span></span></td>
                            </tr>
                            </tfoot>
                        </table>
                    </td>
                </tr>
            </tfoot>
        </table>
 <!-- <div style="text-align: right;">
        Sub Total<span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span> 118.00</span>
        <br>
        Total Tax* <span class="amount"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span> 118.00</span>
        <br>
        Invoice Total (In INR)
        Total (In Words) 
       <span class="totals-price"> Seven Hundred Sixty Seven rupees</span>
   </div> -->

    <div style="height:20px;"></div>
    <table style="border-collapse: collapse;max-width: 767px;width: 100%;text-align: center;margin: 0 auto;margin-bottom: 30px;">
        <tbody style="background: #F9F9F9;border-radius: 4px;">
            <td>
                
                <p style="font-size: 15px;color: #252525;font-weight: 400;padding: 0 40px;text-align: left;line-height: 30px;">
                   We declare that this invoice shows the actual price of the services rendered and that all particulars are true and correct.
                    Our services fall under TDS section 194C Or 194J (2% -Technical Services)</b>
                </p>
            </td>
        </tbody>
    </table>

    <table style="border-collapse: collapse;max-width: 767px;width: 100%;text-align: center;margin: 0 auto;margin-bottom: 25px;">
        <thead class="background: #FFFFFF;">
            <th style="text-align: left;padding-left: 35px;font-size: 16px;color: #939393;display: none;">
                *cheque subject to realization
            </th>
            <th style="text-align: right;font-size: 16px;color: #000000;font-weight: 600;padding-right: 35px">
                <p><span style="font-size: 16px;color: #939393;font-weight: 400;">For</span> Payflash Private Limited</p>
                <img src="{!!$data['payflash_sign']!!}" alt="signature" style="height: 50px;padding-right: 45px;">
                <p style="padding-right: 100px;margin: 5 0;">Signature</p>
            </th>
        </thead>
    </table>


     </main>
 </div>
</body>

</html>