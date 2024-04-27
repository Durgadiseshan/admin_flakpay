@extends('layouts.merchantcontent')
@section('merchantcontent')

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
<script src="https://cdn.tailwindcss.com"></script>




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

                    <h3>Contacts</h3>
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

<div class="container mx-auto">
    <div class="flex flex-row">

        <div class="basis-1/3" style="margin-bottom:10px;">
            <button type="button" class="rounded-lg bg-cyan-600 px-3 py-1 text-white" data-toggle="modal" data-target="#exampleModal">
                Add Contacts
            </button>
        </div>

        <div class="basis-1/3"></div>

        <div class="basis-1/3">

            <div class="flex justify-start gap-4" id="options" style="display:none;">
                <div class="">
                    <button type="button" class="rounded-lg bg-cyan-600 px-5 py-3 text-white" id="deleteButton">
                        Delete
                    </button>
                </div>

                <div class="">
                    <form action="/merchant/edit_contacts">
                        <input type="hidden" id="edit_ids" name="edit_ids">
                        <button type="submit" class="rounded-lg bg-cyan-600 px-5 py-3 text-white">Edit </button>
                    </form>
                </div>

                <div class="">
                    <form action="/merchant/make_beneficiaries_group">
                        <input type="hidden" id="ben_ids" name="ben_ids">
                        <button type="submit" class="rounded-lg bg-cyan-600 px-5 py-3 text-white">Group </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>


<div class="row" style="margin-left:15px;">
    <div class="col-11">
        <table id="" class="table table-striped" style="width:100%;">
            <thead>
                <tr>
                    <th>#</th>
                    <th class="text-left">Name</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>State</th>
                    <th>Pincode</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contacts as $index=> $contact)
                <tr>
                    <td>{{$index + 1}}</td>
                    <td style="text-align:left;"><input type="checkbox" name="id[]" value="{{$contact->id}}"> {{$contact->name}}</td>
                    <td>{{$contact->mobile}}</td>
                    <td>{{$contact->contact}}</td>
                    <td>{{$contact->address}}</td>
                    <td>{{$contact->statedata->state_name ?? ''}}</td>
                    <td>{{$contact->pincode}}</td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" style="color:#1abc9c;">Add Contacts</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="paylink-add-form">
                    <ul class="nav nav-tabs">
                        <li class="active" id="add-paylink-li"><a data-toggle="tab" class="show-cursor" data-target="#add-paylink">Add Contacts</a></li>
                        <li id="add-bulk-paylink-li"><a data-toggle="tab" class="show-cursor" data-target="#add-bulk-paylink">Add Bulk Contacts</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="add-paylink" class="tab-pane fade in active">
                            <div class="form-container">
                                <div id="" class="text-center"></div>
                                <form class="form-horizontal" id="" method="POST" action="/merchant/add_single_contact" autocomplete="off">
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="amount">Name:<span class="mandatory">*</span></label>
                                        <div class="col-sm-4">
                                            <div class="input-group">
                                                <input type="text" class="form-control" required name="contact_name" id="" aria-describedby="basic-addon1">
                                            </div>

                                        </div>
                                        <label class="control-label col-sm-2" for="contact_mobile">Mobile:<span class="mandatory">*</span></label>
                                        <div class="col-sm-4">
                                            <input type="number" class="form-control" required name="contact_mobile" id="contact_mobile" value="" placeholder="" />

                                            <div id="paylink_for_error"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="contact_email">Email:<span class="mandatory">*</span></label>
                                        <div class="col-sm-4">
                                            <input type="email" class="form-control" required name="contact_email" id="" placeholder="">

                                        </div>
                                        <label class="control-label col-sm-2" for="contact_address">Address:<span class="mandatory">*</span></label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" required name="contact_address" id="" placeholder="">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="paymentfor">State:<span class="mandatory">*</span></label>
                                        <div class="col-sm-4">


                                            <select class="selectpicker" name="contact_state" required data-width="100%" data-live-search="true">

                                                @foreach ($states as $state)
                                                <option value="{{$state->id}}">{{$state->state_name}}</option>
                                                @endforeach

                                            </select>


                                        </div>
                                        <label class="control-label col-sm-2" for="paymentfor">Pincode:<span class="mandatory">*</span></label>
                                        <div class="col-sm-4">
                                            <div class="input-group">
                                                <input type="text" class="form-control" required name="contact_pincode" id="" value="" />

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

<!-- deleteModal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" style="color:#1abc9c;">Are You Sure ?</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="warning">

                </div>

                <form action="/merchant/delete_contacts" method="POST">
                    <input type="hidden" id="delete_ids" name="delete_ids" value="">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class=" container" style="margin: 0 60px;">
                        <div class="columns-2">

                            <button type="submit" class="rounded-lg bg-green-600 px-3 py-2 text-white">Yes</button>
                            <button type="button" class="rounded-lg bg-red-600 px-3 py-2 text-white" data-dismiss="modal" aria-label="Close">
                                Close
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    $('#deleteButton').click(function(event) {
        $('#deleteModal').modal('show');
        console.log('wori');
        var ids = $('#delete_ids').val()

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            dataType: "json",
            url: `/merchant/check_contacts/`,
            data: {
                id: ids
            },
            success: function(data) {

                console.log(data);

                var contact = [];
                $("#warning").html(``);
                for (var i = 0; i < data.length; i++) {
                    console.log(data[i].id);
                    var ben = "";

                    for (var j = 0; j < data[i].beneficiaries.length; j++) {
                        ben += data[i].beneficiaries[j].beneficiary_id + " ";
                    }
                    if (ben != "") {
                        $("#warning").append(`<p class="text-orange-500">${data[i].name} is associated with ${ben}<p>`);
                    }

                }
                console.log(contact);
            }
        });
    })
</script>

<script>
    $('input[name="id[]"]').change(function() {
        console.log(this.value);

        var searchIDs = $("input[name='id[]']:checked").map(function() {
            return $(this).val();
        }).get(); // <----
        console.log(searchIDs);
        $("#delete_ids").val(searchIDs);
        $("#edit_ids").val(searchIDs);
        $("#ben_ids").val(searchIDs);
        console.log(searchIDs.length);

        if (searchIDs.length > 0) {
            $('#options').show();
        } else {
            $('#options').hide();
        }
    });
</script>

<script>
    $('#contact_mobile').on('keyup keydown change', function(e) {
        if ($(this).val() > 999999999 &&
            e.keyCode !== 46 &&
            e.keyCode !== 8
        ) {
            e.preventDefault();
            $(this).val(this.value);
        }
    })
</script>


@endsection