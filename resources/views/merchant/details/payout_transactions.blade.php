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
                                        <td class="strongText" id="trantime">{{$info['transaction_info']['created_at']}} </td>
                                    </tr>
                                    <tr>
                                        <td class="thinText">Transaction ID:</td>
                                        <td class="strongText" id="tranid">{{$info['transaction_info']['transfer_id']}} </td>
                                    </tr>
                                    <tr>
                                        <td class="thinText" >Transaction Status:</td>
                                        <td class="strongText" id="transtatus"> {{$info['transaction_info']['status']}}</td>
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
                                        <td class="strongText" id="paymentmode">{{$info['transaction_info']['transfer_mode']}} </td>
                                    </tr>
                                    <tr>
                                        <td class="thinText">Amount:</td>
                                        <td class="strongText" id="tranamount"> {{$info['transaction_info']['amount']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="thinText">VENDOR:</td>
                                        <td class="strongText" id="tranvendor"> {{$info['transaction_info']['vendor']}}</td>
                                    </tr>

                                </table>

                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="headlineText">BENEFICIARY DETAILS</h5>
                            </div>
                            <div class="card-body">
                                <table id="ttable">
                                    <tr>
                                        <td class="thinText">ID:</td>
                                        <td class="strongText" id="benid">{{$info['transaction_info']['ben_id']}} </td>
                                    </tr>
                                    <tr>
                                        <td class="thinText">NAME:</td>
                                        <td class="strongText" id="benname"> {{$info['transaction_info']['ben_name']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="thinText">EMAIL:</td>
                                        <td class="strongText" id="benemail"> {{$info['transaction_info']['ben_email']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="thinText">IFSC CODE:</td>
                                        <td class="strongText" id="benifsc"> {{$info['transaction_info']['ben_ifsc']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="thinText">BANK ACCOUNT NO:</td>
                                        <td class="strongText" id="benacc"> {{$info['transaction_info']['ben_bank_acc']}}</td>
                                    </tr>


                                </table>

                            </div>
                        </div>
                    </div>
                </div>

                                                    
        </div>