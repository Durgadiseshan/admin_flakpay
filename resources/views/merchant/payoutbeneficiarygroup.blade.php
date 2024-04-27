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

                    <h3>Groups</h3>
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



<div class="row" style="margin-left:15px;">
    <div class="col-11">
        <table id="contacts" class="table table-striped" style="width:100%;">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Group Name</th>
                    <th>Members Count</th>
                    <th>Created</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($groups as $index=> $group)
                <tr>
                    <td>{{$index + 1}}</td>
                    <td>{{$group->group_name}}</td>
                    <td>{{count($group->beneficiaries)}}</td>
                    <td>{{ \Carbon\Carbon::parse($group->created_at)->format('d-m-Y g:i A')}}</td>
                    <td><button class="rounded-lg bg-emerald-600 px-3 py-1 text-white showmembers" groupid="{{$group->id}}">Show Members</button></td>


                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>


<!-- deleteModal -->
<div class="modal fade" id="memberModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" style="color:#1abc9c;">Group Members</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" >
                <table class="table table-striped" style="width:100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Beneficiary Id</th>
                            <th>Account Number</th>
                            <th>Ifsc</th>
                            <th>Upi Id</th>
                        </tr>
                    </thead>
                    <tbody id="memberbody">

                    </tbody>
                </table>



            </div>
        </div>
    </div>
</div>


<script>
    $(function() {
        $('.showmembers').click(function() {
            console.log('working');
            id = $(this).attr("groupid");
            console.log(id);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "GET",
                dataType: "json",
                url: `/merchant/beneficiary_groups/showmembers/${id}`,
                success: function(data) {

                    console.log(data);



                    if (data != null) {
                        len = data.length;
                    }


                    var tr_str = null;
                    console.log(tr_str);

                    if (len > 0) {
                        for (var i = 0; i < len; i++) {
                            var id = data[i].id;
                            var benId = data[i].beneficiary_id;
                            var acc = data[i].account_number;
                            var ifsc = data[i].ifsc_code;
                            var upi = data[i].upi_id;


                            tr_str += "<tr>" +
                                "<td align='center'>" + (i + 1) + "</td>" +
                                "<td align='center'>" + benId + "</td>" +
                                "<td align='center'>" + acc + "</td>" +
                                "<td align='center'>" + ifsc + "</td>" +
                                "<td align='center'>" + upi + "</td>" +
                                "</tr>";


                        }

                        $("#memberbody").html(tr_str);
                    } else {
                        var tr_str = "<tr>" +
                            "<td align='center' colspan='4'>No record found.</td>" +
                            "</tr>";

                        $("#memberbody ").html(tr_str);


                    }



                    $('#memberModal').modal('show');

                }
            });


        })
    })
</script>








@endsection