<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Invoice</title>
        <style type="text/css">
           
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
    <body class="invoice">
       
      
       
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
                    <td>100</td>
                    <td>18</td>
                    <td>118</td>
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
                                <td class="price"><span class="totals-price"><span class="amount"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span> 118.00</span></span></td>
                            </tr>
                            <tr class="order_total">
                                 <td></td>
                                <td class="no-borders"></td>
                                
                                <th class="description">Total</th>
                                 <td></td>
                                <td class="price"><span class="totals-price"><span class="amount"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span> 118.00</span></span></td>
                            </tr>
                            </tfoot>
                        </table>
                    </td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>