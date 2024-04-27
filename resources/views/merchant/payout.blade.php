@extends('layouts.merchantcontent')
@section('merchantcontent')

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">




<style>
    .flex-container {
        display: flex;
        flex-wrap: nowrap;

    }

    .flex-container>div {

        width: 400px;
        margin: 10px;
        text-align: center;


    }

    .addbutton {
        position: relative;

        bottom: 45px;
        transform: translate(-50%, -50%);
        transition: all 1s;
        /* background: #3097d1; */
        box-sizing: border-box;
        border-radius: 25px;
    }

    .submitButton {
        margin-top: 2rem;
    }

    .formmargins {
        margin-top: 10px;
        margin-bottom: 10px;
    }

    .dropdown-menu {
        background-color: white;
    }

    .dropdown-menu>li>a>span {
        color: #5d5f63;
    }

    .transactiongid{
        color:#3c8dbc;
        cursor:pointer;
    }
    .card {
        border: thin solid #ccc;
        border-radius: 10px;
        padding: 5px 5px 5px 5px;
        margin: 5px 5px 5px 5px;
        border-top-color: #3c8dbc;
    }

    .thinText {
       
        line-height: 2.75rem;
    }

    .strongText {
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    .headlineText{
        font-weight: 900;
        letter-spacing: 2.5px;
      
    }
    .transactiongid{
        color:#3c8dbc;
        cursor:pointer;
    }

    #ttable {
    border-radius: 10% !important;
    border-left: none;
    border-right: none;
    border-style: none;
    box-shadow: 0 0 29px 0 rgb(230 232 239 / 12%);
}  
</style>

<div id="buton-1">
    <button class="btn btn-dark" id="Show">Show</button>
    <button class="btn btn-danger" id="Hide">Remove</button>
</div>

<section id="about-1" class="about-1">
    <div class="container-1">

        <div class="row">

            <div class="col-lg-6 d-flex flex-column justify-contents-center" data-aos="fade-left">
                <div class="content-1 pt-4 pt-lg-0">

                    <h3>Payouts</h3>
                    <p>Get started with accepting payments right away</p>

                    <p>You are just one step away from activating your account to accept domestic and international payments from your customers. We just need a few more details</p>
                </div>
            </div>
            <div class="col-lg-6" data-aos="zoom-in" id="img-dash">
                <img src="/assets/img/dash-bnr.png" width="450" height="280" class="img-fluid" alt="dash-bnr.png">
            </div>
        </div>

    </div>
</section>



<div class="" style="margin-bottom:10px;">
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
        Quick Transfer
    </button>
</div>




<div class="row" style="margin-left:15px;">
    <div class="col-11">
        <table id="contacts" class="table table-striped" style="width:100%;">
            <thead>
                <tr>
                    <th>#</th>
                    <th>At</th>
                  
                    <th>Transaction Id</th>
                    <th>Utr</th>
                    <th>Beneficiary Id</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Mode</th>
                    <th>Amount</th>
                  
                    <th> Status</th>
                    <th>Error</th>
                    <th> Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $key=>$transaction)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('d-m-Y g:i A')}}</td>
                     @if($transaction->transfer_id)   
                    <td id="transactiongid"><a href="javascript:payouttransactionDetailsView('{{$transaction->transfer_id}}')">{{$transaction->transfer_id}}</a></td>
                    @else
                        <td></td>
                    @endif
                   
                    <td>{{$transaction->reference_id ?? ''}}</td>
                    <td>{{$transaction->ben_id ?? ''}}</td>
                    <td>{{$transaction->ben_name ?? ''}}</td>
                    <td>{{$transaction->ben_phone ?? ''}}</td>
                    <td>{{$transaction->transfer_mode?? ''}}</td>
                    <td>{{$transaction->amount?? ''}}</td>
                    
                    <td>{{$transaction->status?? ''}}</td>
                    <td></td>
                    <td></td>

                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>


  <!-- Transactiond Details Modal 1 -->
  <div id="detail-transaction-model" class="modal" role="dialog">
                            <div class="modal-dialog modal-lg" role="document" style="width:1200px">

                                <!-- Modal content-->
                                <div class="modal-content">
                                <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Transaction Details</h4>
                                        </div>
                                <div class="modal-body">
                                    <div class="model-content" id="modal-dynamic-body">
                                        <div id="paylink-add-form">
                                       
                                        <div class="tab-content1">
                                            <div id="transaction_details_view" >
                                                
                                            </div>
                                           
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <!-- Transactiond Details Modal code ends-->
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" style="color:#1abc9c;">Quick Transfer</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="paylink-add-form">
                    <ul class="nav nav-tabs">
                        <li class="active" id="add-paylink-li"><a data-toggle="tab" class="show-cursor" data-target="#add-paylink">Quick Transfer </a></li>
                        <li id="add-bulk-paylink-li"><a data-toggle="tab" class="show-cursor" data-target="#add-bulk-paylink">Batch Transfer</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="add-paylink" class="tab-pane fade in active">
                            <div class="form-container">
                                <div id="" class="text-center"></div>
                                <form class="form-horizontal" id="" method="POST" action="/merchant/payout" autocomplete="off">
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="amount">Beneficiary:<span class="mandatory">*</span></label>
                                        <div class="col-sm-4">
                                            <div class="input-group">

                                                <select class="selectpicker" name="ben_id" id="ben_id" data-width="130%" data-live-search="true">
                                                    <option data-tokens="">--SELECT--</option>
                                                    <option data-tokens="addnew" value="addnew" data-content="<span class='badge badge-success'>Add new</span>">Add New</option>
                                                    @foreach ($beneficiaries as $ben)
                                                    <option value="{{$ben->id}}">{{$ben->beneficiary_id}}</option>
                                                    @endforeach

                                                </select>
                                            </div>

                                        </div>
                                        <label class="control-label col-sm-2" for="contact_mobile">Payment Instrument Id:<span class="mandatory">*</span></label>
                                        <div class="col-sm-4">
                                            <select name="account_id" id="" class="form-control">

                                                @foreach ($payoutaccounts as $acc)
                                                <option value="{{$acc->id}}">{{$acc->account_id}}</option>
                                                @endforeach
                                            </select>
                                            <div id="paylink_for_error"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="amount">Transfer Method:<span class="mandatory">*</span></label>
                                        <div class="col-sm-4">
                                            <div class="input-group">
                                                <select name="transferMode" id="" class="form-control">
                                                    <option value="banktransfer">Bank Transfer</option>
                                                    <option value="imps">IMPS</option>
                                                    <option value="neft">NEFT</option>
                                                    <option value="upi">UPI</option>
                                                    <option value="paytm">PAYTM</option>
                                                    <option value="amazonpay">AMAZON</option>

                                                </select>
                                            </div>

                                        </div>
                                        <label class="control-label col-sm-2" for="contact_mobile">Amount:<span class="mandatory">*</span></label>
                                        <div class="col-sm-4">
                                            <input type="number" name="amount" class="form-control">
                                            <div id="paylink_for_error"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="transferId">Transfer Id:<span class="mandatory">*</span></label>
                                        <div class="col-sm-4">
                                            <input type="text" name="transferId" class="form-control">
                                            <div id="paylink_for_error"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="contact_mobile">Remark:<span class="mandatory">*</span></label>
                                        <div class="col-sm-10">
                                            <textarea name="remark" id="" cols="30" rows="5" class="form-control"></textarea>

                                        </div>
                                    </div>




                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-4">
                                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
                                        </div>
                                    </div>

                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                </form>
                            </div>
                        </div>
                        <div id="add-bulk-paylink" class="tab-pane fade in">
                            <form method="POST" action="/merchant/add_bulk_contact" enctype="multipart/form-data">
                                <div class="text-center" id="paylink-bulk-response-message"></div>
                                <table class="table table-responsive">
                                    <caption class="text-center">Only Xls,Xlsx files can upload</caption>
                                    <tbody>
                                        <tr>
                                            <td for="paylinkfile">Paylinks File Upload</td>
                                            <td>
                                                <input type="file" name="contacts" id="file-2" class="inputfile inputfile-2" data-multiple-caption="{count} files selected" multiple />
                                                <label for="file-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                                        <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z" />
                                                    </svg>
                                                    <span id="paylink-bulkupload">Choose a file&hellip;</span>
                                                </label>
                                            </td>
                                            <td><input type="submit" class="btn btn-primary" value="Upload"></td>
                                            <td><input type="reset" id="reset-bulk-paylink-form" class="btn btn-danger" value="Reset"></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <h5 class="text-danger">Note:Download this<a href="/download/payout_contacts.xls"><strong> sample file </strong></a>for your reference</h5>
                                    </tfoot>
                                </table>
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- //end payout modal -->

<!-- Modal -->
<div class="modal fade" id="benModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" style="color:#1abc9c;">Add Beneficiary</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="paylink-add-form">

                    <div class="tab-content">
                        <div id="add-paylink" class="tab-pane fade in active">
                            <div class="form-container">
                                <div id="" class="text-center"></div>
                                <form class="form-horizontal" id="" method="POST" action="/merchant/add_single_beneficiary" autocomplete="off">
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="amount">Contact:<span class="mandatory">*</span></label>
                                        <div class="col-sm-4">
                                            <div class="input-group">




                                                <select class="selectpicker" name="contact_id" id="contact_id" required data-live-search="true">
                                                    <option data-tokens="">--SELECT--</option>
                                                    <option data-tokens="addnew" value="addnew" data-content="<span class='badge badge-success'>Add new</span>">Add New</option>
                                                    @foreach ($contacts as $contact)
                                                    <option data-tokens="{{$contact->id}}" value="{{$contact->id}}">{{$contact->name}}</option>
                                                    @endforeach

                                                </select>
                                            </div>

                                        </div>

                                    </div>

                                    <div id="contact" style="display:none;">


                                        <div class="row formmargins">
                                            <div>
                                                <label class="control-label col-sm-2" for="amount">Name:<span class="mandatory">*</span></label>
                                                <div class="col-sm-4">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="contact_name" id="" aria-describedby="basic-addon1">
                                                    </div>
                                                </div>
                                            </div>

                                            <div>
                                                <label class="control-label col-sm-2" for="contact_mobile">Mobile:<span class="mandatory">*</span></label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" name="contact_mobile" id="contact_mobile" value="" placeholder="" />

                                                    <div id="paylink_for_error"></div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row formmargins">
                                            <label class="control-label col-sm-2" for="contact_email">Email:</label>
                                            <div class="col-sm-4">
                                                <input type="email" class="form-control" name="contact_email" id="" placeholder="">

                                            </div>
                                            <label class="control-label col-sm-2" for="contact_address">Address:</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="contact_address" id="" placeholder="">

                                            </div>
                                        </div>

                                        <div class="row formmargins">
                                            <label class="control-label col-sm-2" for="paymentfor">State:</label>
                                            <div class="col-sm-4">
                                                <select class="form-control" name="contact_state" id="">
                                                    @foreach ($states as $state)
                                                    <option value="{{$state->id}}">{{$state->state_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <label class="control-label col-sm-2" for="paymentfor">Pincode:</label>
                                            <div class="col-sm-4">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="contact_pincode" id="" value="" />

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row formmargins">
                                        <label class="control-label col-sm-2" for="contact_email">Account No:<span class="mandatory">*</span></label>

                                        <div class="col-sm-4">
                                            <span id="accountnumber_error" class="text-danger"></span>
                                            <input type="text" class="form-control" required name="ben_acc_no" id="accountNumber" placeholder="">

                                        </div>
                                        <label class="control-label col-sm-2" for="contact_address">Ifsc Code:<span class="mandatory">*</span></label>

                                        <div class="col-sm-4">
                                            <span id="ifsc_error" class="text-danger"></span>
                                            <input type="text" class="form-control" required name="ben_ifsc_no" id="ifsc" placeholder="">

                                        </div>
                                    </div>

                                    <div class="row formmargins">

                                        <label class="control-label col-sm-2" for="upi_id">Upi Id:<span class="mandatory">*</span></label>
                                        <div class="col-sm-4">
                                            <span id="upi_error" class="text-danger"></span>
                                            <input type="text" class="form-control" required name="ben_upi_id" id="upi_id" value="" placeholder="" />

                                            <div id="paylink_for_error"></div>
                                        </div>

                                        <label class="control-label col-sm-2" for="paymentfor">Group:</label>
                                        <div class="col-sm-4">
                                            <div class="input-group">
                                                <select class="selectpicker" data-live-search="true">
                                                    <option data-tokens=""></option>

                                                </select>



                                            </div>
                                        </div>


                                    </div>


                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-4">
                                            <button type="submit" onclick="return validator()" class="btn btn-primary btn-block">Submit</button>
                                        </div>
                                    </div>

                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    $("#ben_id").on('change', function() {
        console.log('working');
        console.log(this.value);
        if (this.value == 'addnew') {
            $('#benModal').modal('show')
            $('#exampleModal').modal('hide')
        } else {

        }
    })
</script>


@endsection