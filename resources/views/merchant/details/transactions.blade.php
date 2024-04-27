<div class="form-container">
                                               
                                                <form class="form-horizontal" id="view" autocomplete="off">



            <div class="row">
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="headlineText">TRANSACTION DETAILS</h5>
                            </div>
                            <div class="card-body">
                                <table id="ttable">
                                    <tr>
                                        <td class="thinText">Transaction Initiation Time:</td>
                                        <td class="strongText" id="trantime">{{$info['transaction_info']['created_date']}} </td>
                                    </tr>
                                    <tr>
                                        <td class="thinText">Transaction ID:</td>
                                        <td class="strongText" id="tranid">{{$info['transaction_info']['transaction_gid']}} </td>
                                    </tr>
                                    <tr>
                                        <td class="thinText" >Transaction Status:</td>
                                        <td class="strongText" id="transtatus"> {{$info['transaction_info']['transaction_status']}}</td>
                                    </tr>
                                </table>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="headlineText">MERCHANT DETAILS</h5>
                            </div>
                            <div class="card-body">
                                <table id="ttable">
                                    <tr>
                                        <td class="thinText">Merchant Name:</td>
                                        <td class="strongText" id="mname">{{$info['merchant_info']['name']}} </td>
                                    </tr>
                                    <tr>
                                        <td class="thinText">Merchant Email:</td>
                                        <td class="strongText" id="memail">{{$info['merchant_info']['email']}} </td>
                                    </tr>
                                    <tr>
                                        <td class="thinText">Merchant Contact:</td>
                                        <td class="strongText" id="mcontact"> {{$info['merchant_info']['mobile_no']}}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="headlineText">PAYMENT DETAILS</h5>
                            </div>
                            <div class="card-body">
                                <table id="ttable">
                                    <tr>
                                        <td class="thinText">Payment Mode:</td>
                                        <td class="strongText" id="paymentmode"> {{$info['transaction_info']['transaction_mode']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="thinText">Amount:</td>
                                        <td class="strongText" id="tranamount"> {{$info['transaction_info']['transaction_amount']}}</td>
                                    </tr>

                                </table>

                            </div>
                        </div>

                       
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="headlineText">CUSTOMER DETAILS</h5>
                            </div>
                            <div class="card-body">
                                <table id="ttable">
                                    <tr>
                                        <td class="thinText">Customer Name::</td>
                                        <td class="strongText" id="mname">{{$info['transaction_info']['transaction_username']}} </td>
                                    </tr>
                                    <tr>
                                        <td class="thinText">Customer Phone No:</td>
                                        <td class="strongText" id="memail">{{$info['transaction_info']['transaction_contact']}} </td>
                                    </tr>
                                    <tr>
                                        <td class="thinText">Customer Email:</td>
                                        <td class="strongText" id="mcontact"> {{$info['transaction_info']['transaction_email']}}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

           


                                                    
        </div>