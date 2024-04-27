@php
$vendor_banks = App\RyapayVendorBank::get_vendorbank();
@endphp
@extends('layouts.employeecontent')
@section('employeecontent')

<style>
    .card {
        border: thin solid #ccc;
        border-radius: 10px;
        padding: 10px;
    }

    .thinText {
        font-size: 1.125rem;
        line-height: 1.75rem;
    }

    .strongText {
        font-weight: 600;
        letter-spacing: 0.5px;
        word-break: break-word;
    }

    .headlineText {
        font-weight: 900;
        letter-spacing: 2.5px;

    }
    div#razorpaytable th, div#razorpaytable td {
        white-space: nowrap;
    }
</style>

<!-- <h3>Price Setting</h3> -->




<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg .modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Slab Setting Form</h4>
            </div>
            <div class="modal-body">

                <form action="/flakpay/save_price_setting" method="POST" class="form-horizontal" role="form" >
                    {{csrf_field()}}

                    <div class="form-group form-fit">
                        <label for="input" class="col-lg-2 col-md-3 col-sm-3 col-xs-12 control-label" style="margin-left:0px;">Merchant:<span class="text-danger">*</span></label>
                        <div class="col-lg-4 col-md-4 col-sm-9 col-xs-12">
                            <select name="merchant_id" id="merchant_id" class="form-control">
                                <option value="">--select--</option>
                                @foreach ($user as $users)
                                <option value="{{$users->id}}">{{$users->name}}</option>
                                @endforeach
                            </select>
                        </div>                        
                    </div>



                    <div class="form-group form-fit" id="ranges" style="display:none;"  >

                        <label for="input" class="col-lg-2 col-md-3 col-sm-3 col-xs-12 mb-1 control-label">Type:<span class="text-danger">*</span></label>
                        <div class="col-lg-2 col-md-3 col-sm-9 col-xs-12 mb-1 ">
                            <select name="type[]" id="type" class="form-control" required="required">
                                <option value="">--select--</option>
                                <option value="flat">Flat</option>
                                <option value="percentage">Percentage</option>
                            </select>
                        </div>

                        <label for="input" class="col-lg-2 col-md-3 col-sm-3 col-xs-12 mb-1 control-label">Min Range:<span class="text-danger">*</span></label>
                        <div class="col-lg-2 col-md-3 col-sm-9 col-xs-12 mb-1 ">
                            <input type="number" name="min_range[]" id="min_range" class="form-control" value="" required="required">
                        </div>
                        <label for="input" class="col-lg-2 col-md-3 col-sm-3 col-xs-12 mb-1 control-label">Max Range:<span class="text-danger">*</span></label>
                        <div class="col-lg-2 col-md-3 col-sm-9 col-xs-12 mb-1 ">
                            <input type="number" name="max_range[]" id="max_range" class="form-control" value="" required="required">
                        </div>
                    </div>

                    <div id="details" style="display:none;">

                        <div id="formRow">
                            <div class="form-group form-fit">
                                <label for="input" class="col-lg-2 col-md-3 col-sm-3 col-xs-12 mb-1 control-label">IMPS:<span class="text-danger">*</span></label>
                                <div class="col-lg-2 col-md-3 col-sm-9 col-xs-12 mb-1">
                                    <input type="text" name="imps[]" id="imps" class="form-control" value="" required="required">
                                </div>
                                <label for="input" class="col-lg-2 col-md-3 col-sm-3 col-xs-12 mb-1 control-label">NEFT:<span class="text-danger">*</span></label>
                                <div class="col-lg-2 col-md-3 col-sm-9 col-xs-12 mb-1">
                                    <input type="text" name="neft[]" id="neft" class="form-control" value="" required="required">
                                </div>
                                <label for="input" class="col-lg-2 col-md-3 col-sm-3 col-xs-12 mb-1 control-label">RTGS:<span class="text-danger">*</span></label>
                                <div class="col-lg-2 col-md-3 col-sm-9 col-xs-12 mb-1">
                                    <input type="text" name="rtgs[]" id="rtgs" class="form-control" value="" required="required">
                                </div>
                            </div>

                            <div class="form-group form-fit">
                                <label for="input" class="col-lg-2 col-md-3 col-sm-3 col-xs-12 mb-1 control-label">UPI:<span class="text-danger">*</span></label>
                                <div class="col-lg-2 col-md-3 col-sm-9 col-xs-12 mb-1">
                                    <input type="text" name="upi[]" id="upi" class="form-control" value="" required="required">
                                </div>
                                <!-- <label for="input" class="col-sm-2 control-label">PAYTM:<span class="text-danger">*</span></label>
                                <div class="col-sm-2">
                                    <input type="text" name="paytm[]" id="dc_visa" class="form-control" value="" required="required">
                                </div>
                                <label for="input" class="col-sm-2 control-label">AMAZON:<span class="text-danger">*</span></label>
                                <div class="col-sm-2">
                                    <input type="text" name="amazon[]" id="dc_master" class="form-control" value="" required="required">
                                </div> -->
                            </div>

                        </div>

                        <div style="padding-left: 5px;"> 
                            <button id="addRow" class="btn "><ion-icon style="color:green; font-size: 19px;" name="add-circle"></ion-icon></button>
                        </div>

                        <div class="px-5 py-3 text-center">
                            <button class="btn btn-primary" type="submit">Save</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>

    </div>
</div>



<div class="row">
  <div class="col-sm-12 padding-20">
    <div class="panel panel-default">
      <div class="panel-heading">
        <ul class="nav nav-tabs" id="transaction-tabs">
          <li class="active"><a data-toggle="tab" class="show-cursor" data-target="#Service">Merchant Service Fee</a></li>
        </ul>
      </div>
      <div class="panel-body">
        <div class="tab-content">
          <div id="Service" class="tab-pane fade in active">
            <div class="row">
                <div class="col-sm-6 pl-0 mb-4">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">
                    <strong><em style="font-style: normal;">Add Slab Settings</em></strong></button>
                </div>         
                <div class="col-sm-6 pr-0 mb-4 text-right">
                    <a href="/flakpay/price_setting"><button type="button" class="btn btn-primary" style="border-radius: 19px;">
                    <i class="fa fa-arrow-left"style="margin-right: 10px;"></i>Back</button></a> 
                </div>
            </div>
            <div class="card">
            <div class="text-left ">
                <h5 class="headlineText">MERCHANT DETAILS</h5>
            </div>
            <div class="">
                <div class="row row-new">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <h5 class="thinText">Merchant Name:</h5>
                    <h5 class="strongText">{{$prices[0]->merchant->name}} </h5>
                </div>
                <div  class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <h5 class="thinText">Merchant Email:</h5>
                    <h5 class="strongText">{{$prices[0]->merchant->email}}  </h5>
                </div>
                <div  class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <h5 class="thinText">Merchant Contact:</h5>
                    <h5 class="strongText">{{$prices[0]->merchant->mobile_no}} </h5>
                </div>
                </div>
            </div>
            </div>
            <div id="razorpaytable" style="margin-top:30px;" class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Min Range</th>
                    <th>Max Range</th>
                    <th>Type</th>
                    <th>IMPS</th>
                    <th>NEFT</th>
                    <th>RTGS</th>
                    <th>UPI</th>
                    <!-- <th>Paytm</th>
                    <th>Amazon</th> -->
                    <th>Date</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($prices as $index=>$price)
                <tr>
                    <td>{{$index+1}}</td>
                    <td>₹ {{$price->min_range}}</td>
                    <td>₹ {{$price->max_range}}</td>
                    <td>{{$price->type}}</td>
                    <td>{{$price->IMPS}}</td>
                    <td>{{$price->NEFT}}</td>
                    <td>{{$price->RTGS}}</td>
                    <td>{{$price->UPI}}</td>
                    <!-- <td>{{$price->PAYTM}}</td>
                    <td>{{$price->AMAZON}}</td> -->
                    <td>{{ Carbon\Carbon::parse($price->created_date)->format('d-m-Y H:i:s')  }}</td>
                    <td>
                    <button class="btn " data-toggle="modal" data-id="{{$price->id}}" data-target="#deleteModal">
                        <ion-icon style="color:red; font-size: 19px;" name="trash-outline"></ion-icon>
                    </button>
                    <button class="btn " data-toggle="modal" data-id="{{$price->id}}" data-id="{{$price->id}}" data-type="{{$price->type}}" data-minrange="{{$price->min_range}}" data-maxrange="{{$price->max_range}}" data-imps="{{$price->IMPS}}" data-neft="{{$price->NEFT}}" data-rtgs="{{$price->RTGS}}" data-upi="{{$price->UPI}}" data-paytm="{{$price->PAYTM}}" data-amazon="{{$price->AMAZON}}" data-target="#editModal">
                        <ion-icon style="color:#2980b9; font-size: 19px;" name="create-sharp"></ion-icon>
                    </button>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>





<!-- deleteModal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" style="margin-top:150px" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLongTitle">Are you sure ?</h4>
            </div>
            <div class="modal-footer">
                <form action="/flakpay/delete_price_setting" method="POST">
                    {{csrf_field()}}
                    <input type="hidden" id="getId" name="id">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Yes</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- enddeleteModal -->


<!-- editModal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" style="margin-top:150px" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Edit Price Settings</h4>
            </div>
            <div class="modal-body">

                <form action="/flakpay/edit_price_setting" method="POST" class="form-horizontal" role="form">
                    {{csrf_field()}}
                    <input type="hidden" id="getId" name="id">

                    <div class="form-group form-fit">

                        <label for="input" class="col-sm-3 control-label">Type:<span class="text-danger">*</span></label>
                        <div class="col-sm-3">
                            <select name="type" id="type" class="form-control" required="required">
                                <option value="">--select--</option>
                                <option value="flat">Flat</option>
                                <option value="percentage">Percentage</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group form-fit" id="ranges">
                        <label for="input" class="col-sm-3 control-label">Min Range:<span class="text-danger">*</span></label>
                        <div class="col-sm-3 mb-s">
                            <input type="number" name="min_range" id="min_range_edit" class="form-control" value="" required="required">
                        </div>
                        <label for="input" class="col-sm-3 control-label">Max Range:<span class="text-danger">*</span></label>
                        <div class="col-sm-3">
                            <input type="number" name="max_range" id="max_range_edit" class="form-control" value="" required="required">
                        </div>
                    </div>

                    <div id="details">

                        <div class="form-group form-fit">
                            <label for="input" class="col-sm-3 control-label">IMPS:<span class="text-danger">*</span></label>
                            <div class="col-sm-3 mb-s">
                                <input type="text" name="imps" id="imps" class="form-control" value="" required="required">
                            </div>
                            <label for="input" class="col-sm-3 control-label">NEFT:<span class="text-danger">*</span></label>
                            <div class="col-sm-3">
                                <input type="text" name="neft" id="neft" class="form-control" value="" required="required">
                            </div>
                        </div>
                        <div class="form-group form-fit">
                            <label for="input" class="col-sm-3 control-label">RTGS:<span class="text-danger">*</span></label>
                            <div class="col-sm-3 mb-s">
                                <input type="text" name="rtgs" id="rtgs" class="form-control" value="" required="required">
                            </div>
                            <label for="input" class="col-sm-3 control-label">UPI:<span class="text-danger">*</span></label>
                            <div class="col-sm-3">
                                <input type="text" name="upi" id="upi" class="form-control" value="" required="required">
                            </div>
                        </div>
                        <!-- <div class="form-group form-fit">
                            <label for="input" class="col-sm-3 control-label">PAYTM:<span class="text-danger">*</span></label>
                            <div class="col-sm-3">
                                <input type="text" name="paytm" id="paytm" class="form-control" value="" required="required">
                            </div>
                            <label for="input" class="col-sm-3 control-label">AMAZON:<span class="text-danger">*</span></label>
                            <div class="col-sm-3">
                                <input type="text" name="amazon" id="amazon" class="form-control" value="" required="required">
                            </div>
                        </div> -->

                        <div class="px-5 py-3 text-center" style="margin-top:3rem">
                            <button class="btn btn-primary" type="submit">Save</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- endeditModal -->


<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>

<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>


<script>
    $('#deleteModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('id')


        console.log(id);
        var modal = $(this)
        modal.find('#getId').val(id)


    })
</script>

<script>
    $('#editModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('id')
        var type = button.data('type')
        var minrange = button.data('minrange')
        var maxrange = button.data('maxrange')
        var imps = button.data('imps')
        var neft = button.data('neft')
        var rtgs = button.data('rtgs')
        var upi = button.data('upi')
        var paytm = button.data('paytm')
        var amazon = button.data('amazon')


        console.log(id, type, minrange, maxrange, imps, neft, rtgs, upi, paytm, amazon);

        var modal = $(this)
        modal.find('#getId').val(id)
        modal.find('#type').val(type)
        modal.find('#min_range_edit').val(minrange)
        modal.find('#max_range_edit').val(maxrange)
        modal.find('#imps').val(imps)
        modal.find('#neft').val(neft)
        modal.find('#rtgs').val(rtgs)
        modal.find('#upi').val(upi)
        modal.find('#paytm').val(paytm)
        modal.find('#amazon').val(amazon)


    })
</script>

<script>
    $('#type,#merchant_id').on('change', function() {
        var merId = $('#merchant_id').val();
        var type = $('#type').val();

        if (merId != "") {
            $('#ranges').show();
            $('#details').show();
        } else {
            $('#ranges').hide();
            $('#details').hide();
        }
    })
</script>

<script>
    $('#addRow').on('click', function(event) {
        $('#formRow').append(`<div style="border-top:1px brown solid; padding:18px 5px 5px 5px ;">
        <div class="form-group form-fit" >

                        <label for="input" class="col-lg-2 col-md-3 col-sm-3 col-xs-12 mb-1 control-label">Type:<span class="text-danger">*</span></label>
                        <div class="col-lg-2 col-md-3 col-sm-9 col-xs-12 mb-1">
                            <select name="type[]" id="type" class="form-control">
                                <option value="">--select--</option>
                                <option value="flat">Flat</option>
                                <option value="percentage">Percentage</option>
                            </select>
                        </div>

                        <label for="input" class="col-lg-2 col-md-3 col-sm-3 col-xs-12 mb-1 control-label">Min Range:<span class="text-danger">*</span></label>
                        <div class="col-lg-2 col-md-3 col-sm-9 col-xs-12 mb-1">
                            <input type="number" name="min_range[]" id="min_range" class="form-control" value="" required="required">
                        </div>
                        <label for="input" class="col-lg-2 col-md-3 col-sm-3 col-xs-12 mb-1 control-label">Max Range:<span class="text-danger">*</span></label>
                        <div class="col-lg-2 col-md-3 col-sm-9 col-xs-12 mb-1">
                            <input type="number" name="max_range[]" id="max_range" class="form-control" value="" required="required">
                        </div>
                    </div>
                    <div class="form-group form-fit">
                                <label for="input" class="col-lg-2 col-md-3 col-sm-3 col-xs-12 mb-1 control-label">IMPS:<span class="text-danger">*</span></label>
                                <div class="col-lg-2 col-md-3 col-sm-9 col-xs-12 mb-1">
                                    <input type="text" name="imps[]" id="imps" class="form-control" value="" required="required">
                                </div>
                                <label for="input" class="col-lg-2 col-md-3 col-sm-3 col-xs-12 mb-1 control-label">NEFT:<span class="text-danger">*</span></label>
                                <div class="col-lg-2 col-md-3 col-sm-9 col-xs-12 mb-1">
                                    <input type="text" name="neft[]" id="neft" class="form-control" value="" required="required">
                                </div>
                                <label for="input" class="col-lg-2 col-md-3 col-sm-3 col-xs-12 mb-1 control-label">RTGS:<span class="text-danger">*</span></label>
                                <div class="col-lg-2 col-md-3 col-sm-9 col-xs-12 mb-1">
                                    <input type="text" name="rtgs[]" id="rtgs" class="form-control" value="" required="required">
                                </div>
                            </div>

                            <div class="form-group form-fit">
                                <label for="input" class="col-lg-2 col-md-3 col-sm-3 col-xs-12 mb-1 control-label">UPI:<span class="text-danger">*</span></label>
                                <div class="col-lg-2 col-md-3 col-sm-9 col-xs-12 mb-1">
                                    <input type="text" name="upi[]" id="upi" class="form-control" value="" required="required">
                                </div>
                                <label for="input" class="col-lg-2 col-md-3 col-sm-3 col-xs-12 mb-1 control-label">PAYTM:<span class="text-danger">*</span></label>
                                <div class="col-lg-2 col-md-3 col-sm-9 col-xs-12 mb-1">
                                    <input type="text" name="paytm[]" id="dc_visa" class="form-control" value="" required="required">
                                </div>
                                <label for="input" class="col-lg-2 col-md-3 col-sm-3 col-xs-12 mb-1 control-label">AMAZON:<span class="text-danger">*</span></label>
                                <div class="col-lg-2 col-md-3 col-sm-9 col-xs-12 mb-1">
                                    <input type="text" name="amazon[]" id="dc_master" class="form-control" value="" required="required">
                                </div>
                            </div> <div class="btn btn-secondary" id="removeRow"><ion-icon style="color:red; font-size: 19px;"  name="close-circle"></ion-icon></div></div>`)
    })
</script>

<script>
    $(document).on('click', '#removeRow', function() {
        console.log('working')
        $(this).parent().remove();
    });
</script>



@endsection