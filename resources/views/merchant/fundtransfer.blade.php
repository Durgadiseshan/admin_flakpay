@extends('layouts.merchantcontent')
@section('merchantcontent')

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">




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

    .dropdown-menu {
        background-color: white;
    }

    .dropdown-menu>li>a>span {
        color: #5d5f63;
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

                    <h3>Fund Transfer</h3>
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
        Add Fund
    </button>
</div>



<div class="row" style="margin-left:15px;">
    <div class="col-11">
        <table id="" class="table table-striped" style="width:100%;">
            <thead>
                <tr>
                    <th>#</th>
                    <th class="text-left">Amount</th>
                    <th>Mode</th>
                    <th>Status</th>
                   <th>Previous Balance</th>
                   <th>Current Balance</th>
                   <th>Date</th>
                </tr>
            </thead>
            <tbody id="supportbody">
        @if(count($funds) > 0)
        @php($table_count = 0)
            @foreach($funds as $fund)
            <tr>
                <td>{{++$table_count}}</td>
           
                <td>{{$fund->amount}}</td>
                <td>{{$fund->mode}}</td>
                <td>{{$fund->status}}</td>
                <td>{{$fund->prev_balance}}</td>
                <td>{{$fund->current_balance}}</td>
               
                <td>{{$fund->credit_date}}</td>
               
            </tr>
        @endforeach
       
        @endif
    </tbody>

        </table>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" style="color:#1abc9c;">Add Fund</h4>
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
                                <form class="form-horizontal" id="" method="POST" action="/merchant/add_singlerefund" autocomplete="off">
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="amount">Amount:<span class="mandatory">*</span></label>
                                        <div class="col-sm-4">
                                            <div class="input-group">
                                                <input type="number" class="form-control" required name="amount" id="" aria-describedby="basic-addon1">
                                            </div>

                                        </div>

                                    </div>

                                    <div class="form-group">
                                    <label class="control-label col-sm-2" for="amount">Mode:<span class="mandatory">*</span></label>
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

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>







@endsection