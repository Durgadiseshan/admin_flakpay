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

                    <h3>Settings</h3>
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

<ul class="nav nav-tabs">
    <li class="active" id="add-paylink-li"><a data-toggle="tab" class="show-cursor" data-target="#add-paylink">Api keys</a></li>
    <li id="add-bulk-paylink-li"><a data-toggle="tab" class="show-cursor" data-target="#add-bulk-paylink">Ip Whitelisting</a></li>
</ul>

<div class="tab-content">
    <div id="add-paylink" class="tab-pane fade in active">

        <div class="" style="margin-bottom:10px;">
            <button type="button" class="btn btn-primary btn-sm" id="generate">
                Generate
            </button>

        </div>

        <div class="row" style="margin-left:15px;">
            <div class="col-11">
                <table class="table table-striped" id="keytable" style="width:100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Generated At</th>
                            <th>Client Id</th>
                            <th>Secret Key</th>
                            <th>Hash Key</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>


                    </tbody>

                </table>
            </div>
        </div>
    </div>

    <div id="add-bulk-paylink" class="tab-pane fade in">
        <div class="" style="margin-bottom:10px;">
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#ipModal">
                Add Ip Address
            </button>
        </div>

        <div class="row" style="margin-left:15px;">
            <div class="col-11">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Generated At</th>
                            <th>Ip Address</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ipaddress as $index=>$ip)
                        <tr>
                            <td>{{$index+1}}</td>
                            <td>{{$ip->created_at}}</td>
                            <td>{{$ip->ipwhitelist}}</td>
                            <td><a href="/merchant/delete_ip_address/{{$ip->id}}"><button class="btn btn-warning">Delete</button></a></td>
                        </tr>
                        @endforeach

                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" style="top: 145px;" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered " style="width:450px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" style="color:#1abc9c;">Api Keys</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="" style="margin: 20px 25px 30px 25px;">
                <div class="input-group " style="margin-bottom: 10px;">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Client Id</span>
                    </div>
                    <input type="text" class="form-control" style="width:35rem" readonly id="clientId">

                    <svg id="clientIdCopy" style="margin:9px 3px 5px 10px; cursor: pointer;" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="pointer ml-1" style="vertical-align: middle;">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M5.26 5.62H14.12C14.8211 5.62264 15.4926 5.903 15.9874 6.39969C16.4822 6.89637 16.76 7.5689 16.76 8.27V19.93C16.76 20.6311 16.4822 21.3036 15.9874 21.8003C15.4926 22.297 14.8211 22.5773 14.12 22.58H5.26C4.55718 22.58 3.88314 22.3008 3.38617 21.8038C2.8892 21.3069 2.61 20.6328 2.61 19.93V8.27C2.61 7.56717 2.8892 6.89313 3.38617 6.39616C3.88314 5.89919 4.55718 5.62 5.26 5.62ZM14.12 20.62C14.2995 20.6174 14.471 20.5449 14.598 20.418C14.7249 20.291 14.7974 20.1195 14.8 19.94V8.27C14.8 8.08965 14.7284 7.91669 14.6008 7.78916C14.4733 7.66164 14.3003 7.59 14.12 7.59H5.26C5.07965 7.59 4.90669 7.66164 4.77917 7.78916C4.65164 7.91669 4.58 8.08965 4.58 8.27V19.93C4.58258 20.1095 4.65506 20.281 4.78203 20.408C4.90899 20.5349 5.08046 20.6074 5.26 20.61L14.12 20.62Z" fill="#6930CA"></path>
                        <path d="M18.74 1.41998H10.56C9.92613 1.41998 9.31823 1.67179 8.87001 2.12C8.4218 2.56821 8.17 3.17612 8.17 3.80998C8.17 4.0752 8.27536 4.32955 8.46289 4.51709C8.65043 4.70463 8.90478 4.80998 9.17 4.80998C9.43521 4.80998 9.68957 4.70463 9.8771 4.51709C10.0646 4.32955 10.17 4.0752 10.17 3.80998C10.17 3.69859 10.2142 3.59176 10.293 3.513C10.3718 3.43423 10.4786 3.38998 10.59 3.38998H18.77C18.9495 3.39257 19.121 3.46504 19.248 3.59201C19.3749 3.71898 19.4474 3.89044 19.45 4.06998V15.07C19.4513 15.126 19.4415 15.1817 19.4209 15.2338C19.4004 15.2859 19.3697 15.3334 19.3306 15.3735C19.2914 15.4135 19.2447 15.4454 19.1931 15.4671C19.1414 15.4888 19.086 15.5 19.03 15.5H18.52C18.2548 15.5 18.0004 15.6053 17.8129 15.7929C17.6254 15.9804 17.52 16.2348 17.52 16.5C17.52 16.7652 17.6254 17.0196 17.8129 17.2071C18.0004 17.3946 18.2548 17.5 18.52 17.5H19C19.6348 17.4973 20.2427 17.2433 20.6906 16.7935C21.1385 16.3437 21.39 15.7348 21.39 15.1V4.09998C21.394 3.74946 21.3284 3.40164 21.197 3.07666C21.0656 2.75167 20.871 2.45599 20.6245 2.20673C20.378 1.95746 20.0846 1.75958 19.7611 1.62453C19.4376 1.48949 19.0905 1.41996 18.74 1.41998Z" fill="#6930CA"></path>
                    </svg>


                </div>

                <div class="input-group" style="margin-bottom: 10px;">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Secret Key</span>
                    </div>
                    <input type="text" class="form-control" style="width:35rem" readonly id="secretkey">
                    <svg id="secretkeyCopy" style="margin:9px 3px 5px 10px; cursor: pointer;" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="pointer ml-1" style="vertical-align: middle;">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M5.26 5.62H14.12C14.8211 5.62264 15.4926 5.903 15.9874 6.39969C16.4822 6.89637 16.76 7.5689 16.76 8.27V19.93C16.76 20.6311 16.4822 21.3036 15.9874 21.8003C15.4926 22.297 14.8211 22.5773 14.12 22.58H5.26C4.55718 22.58 3.88314 22.3008 3.38617 21.8038C2.8892 21.3069 2.61 20.6328 2.61 19.93V8.27C2.61 7.56717 2.8892 6.89313 3.38617 6.39616C3.88314 5.89919 4.55718 5.62 5.26 5.62ZM14.12 20.62C14.2995 20.6174 14.471 20.5449 14.598 20.418C14.7249 20.291 14.7974 20.1195 14.8 19.94V8.27C14.8 8.08965 14.7284 7.91669 14.6008 7.78916C14.4733 7.66164 14.3003 7.59 14.12 7.59H5.26C5.07965 7.59 4.90669 7.66164 4.77917 7.78916C4.65164 7.91669 4.58 8.08965 4.58 8.27V19.93C4.58258 20.1095 4.65506 20.281 4.78203 20.408C4.90899 20.5349 5.08046 20.6074 5.26 20.61L14.12 20.62Z" fill="#6930CA"></path>
                        <path d="M18.74 1.41998H10.56C9.92613 1.41998 9.31823 1.67179 8.87001 2.12C8.4218 2.56821 8.17 3.17612 8.17 3.80998C8.17 4.0752 8.27536 4.32955 8.46289 4.51709C8.65043 4.70463 8.90478 4.80998 9.17 4.80998C9.43521 4.80998 9.68957 4.70463 9.8771 4.51709C10.0646 4.32955 10.17 4.0752 10.17 3.80998C10.17 3.69859 10.2142 3.59176 10.293 3.513C10.3718 3.43423 10.4786 3.38998 10.59 3.38998H18.77C18.9495 3.39257 19.121 3.46504 19.248 3.59201C19.3749 3.71898 19.4474 3.89044 19.45 4.06998V15.07C19.4513 15.126 19.4415 15.1817 19.4209 15.2338C19.4004 15.2859 19.3697 15.3334 19.3306 15.3735C19.2914 15.4135 19.2447 15.4454 19.1931 15.4671C19.1414 15.4888 19.086 15.5 19.03 15.5H18.52C18.2548 15.5 18.0004 15.6053 17.8129 15.7929C17.6254 15.9804 17.52 16.2348 17.52 16.5C17.52 16.7652 17.6254 17.0196 17.8129 17.2071C18.0004 17.3946 18.2548 17.5 18.52 17.5H19C19.6348 17.4973 20.2427 17.2433 20.6906 16.7935C21.1385 16.3437 21.39 15.7348 21.39 15.1V4.09998C21.394 3.74946 21.3284 3.40164 21.197 3.07666C21.0656 2.75167 20.871 2.45599 20.6245 2.20673C20.378 1.95746 20.0846 1.75958 19.7611 1.62453C19.4376 1.48949 19.0905 1.41996 18.74 1.41998Z" fill="#6930CA"></path>
                    </svg>
                </div>

                <div class="input-group ">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Hash Key</span>
                    </div>
                    <input type="text" class="form-control" style="width:35rem" readonly id="hashkey">
                    <svg id="hashkeyCopy" style="margin:9px 3px 5px 10px; cursor: pointer;" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="pointer ml-1" style="vertical-align: middle;">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M5.26 5.62H14.12C14.8211 5.62264 15.4926 5.903 15.9874 6.39969C16.4822 6.89637 16.76 7.5689 16.76 8.27V19.93C16.76 20.6311 16.4822 21.3036 15.9874 21.8003C15.4926 22.297 14.8211 22.5773 14.12 22.58H5.26C4.55718 22.58 3.88314 22.3008 3.38617 21.8038C2.8892 21.3069 2.61 20.6328 2.61 19.93V8.27C2.61 7.56717 2.8892 6.89313 3.38617 6.39616C3.88314 5.89919 4.55718 5.62 5.26 5.62ZM14.12 20.62C14.2995 20.6174 14.471 20.5449 14.598 20.418C14.7249 20.291 14.7974 20.1195 14.8 19.94V8.27C14.8 8.08965 14.7284 7.91669 14.6008 7.78916C14.4733 7.66164 14.3003 7.59 14.12 7.59H5.26C5.07965 7.59 4.90669 7.66164 4.77917 7.78916C4.65164 7.91669 4.58 8.08965 4.58 8.27V19.93C4.58258 20.1095 4.65506 20.281 4.78203 20.408C4.90899 20.5349 5.08046 20.6074 5.26 20.61L14.12 20.62Z" fill="#6930CA"></path>
                        <path d="M18.74 1.41998H10.56C9.92613 1.41998 9.31823 1.67179 8.87001 2.12C8.4218 2.56821 8.17 3.17612 8.17 3.80998C8.17 4.0752 8.27536 4.32955 8.46289 4.51709C8.65043 4.70463 8.90478 4.80998 9.17 4.80998C9.43521 4.80998 9.68957 4.70463 9.8771 4.51709C10.0646 4.32955 10.17 4.0752 10.17 3.80998C10.17 3.69859 10.2142 3.59176 10.293 3.513C10.3718 3.43423 10.4786 3.38998 10.59 3.38998H18.77C18.9495 3.39257 19.121 3.46504 19.248 3.59201C19.3749 3.71898 19.4474 3.89044 19.45 4.06998V15.07C19.4513 15.126 19.4415 15.1817 19.4209 15.2338C19.4004 15.2859 19.3697 15.3334 19.3306 15.3735C19.2914 15.4135 19.2447 15.4454 19.1931 15.4671C19.1414 15.4888 19.086 15.5 19.03 15.5H18.52C18.2548 15.5 18.0004 15.6053 17.8129 15.7929C17.6254 15.9804 17.52 16.2348 17.52 16.5C17.52 16.7652 17.6254 17.0196 17.8129 17.2071C18.0004 17.3946 18.2548 17.5 18.52 17.5H19C19.6348 17.4973 20.2427 17.2433 20.6906 16.7935C21.1385 16.3437 21.39 15.7348 21.39 15.1V4.09998C21.394 3.74946 21.3284 3.40164 21.197 3.07666C21.0656 2.75167 20.871 2.45599 20.6245 2.20673C20.378 1.95746 20.0846 1.75958 19.7611 1.62453C19.4376 1.48949 19.0905 1.41996 18.74 1.41998Z" fill="#6930CA"></path>
                    </svg>
                </div>
            </div>



        </div>
    </div>
</div>
<!-- apikeymodalends -->

<!-- delete apikey modal -->
<!-- Modal -->
<div class="modal fade" id="deletekeyModal" tabindex="-1" style="top: 145px;" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered " style="width:450px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" style="color:#1abc9c;">Api Keys</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="" style="margin: 20px 25px 30px 25px;">

                <h5>Are you sure ?</h5>

            </div>



        </div>
    </div>
</div>


<!-- ipwhitelistmodal -->

<div class="modal fade" id="ipModal" tabindex="-1" role="dialog" aria-labelledby="ipModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" style="color:#1abc9c;">Add Ip Adress</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" required style="margin-top: -20px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/merchant/save_ip_whitelist" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="form-group">
                        <label for="">Ip Address</label>
                        <input type="text" class="form-control" name="ipaddress">
                    </div>

                    <div class="form-group">
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary ">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</div>


<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


<script>
    $(function() {
        $('.deleteapikeyModal').click(function() {
            $('#deletekeyModal').modal('show');
        })
    })
</script>

<script>
    $(function() {
        $('#generate').click(function() {
            $('#exampleModal').modal('show');
        })
    })
</script>

<script>
    $(function() {
        $('.copyCId').click(function() {
            /* Get the text field */
            console.log('working');
            console.log($(this).attr('client'));
            var copyText = $(this).attr('client');


            /* Select the text field */
            copyText.select();
            copyText.setSelectionRange(0, 99999); /* For mobile devices */

            /* Copy the text inside the text field */
            navigator.clipboard.writeText(copyText.value);

            swal("Client Id Copied to Clipboard", {
                buttons: false,
                timer: 2000,
            });
        })
    });
</script>

<script>
    $(function() {
        $('#generate').click(function() {
            console.log('working');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "GET",
                dataType: "json",
                url: '/merchant/generate_payout_apikeys',
                success: function(data) {

                    console.log(data.secretKey);

                    $('#exampleModal').modal('show');
                    $('#clientId').val(data.clientid);
                    $('#secretkey').val(data.secretKey);
                    $('#hashkey').val(data.hashKey);

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "GET",
                        dataType: "json",
                        url: '/merchant/get_api_keys',
                        success: function(data) {

                            console.log(data);
                            var len = 0;
                            $('#keytable tbody').empty(); // Empty <tbody>
                            if (data != null) {
                                len = data.length;
                            }

                            if (len > 0) {
                                for (var i = 0; i < len; i++) {
                                    var id = data[i].id;
                                    var clientId = data[i].client_id;
                                    var secretKey = data[i].secret_key;
                                    var hashKey = data[i].hash_key;
                                    var createdAt = data[i].created_at;

                                    var tr_str = "<tr>" +
                                        "<td align='center'>" + (i + 1) + "</td>" +
                                        "<td align='center'>" + createdAt + "</td>" +
                                        "<td align='center'>" + clientId.slice(0, 5) + `***********************` + "</td>" +
                                        "<td align='center'>" + secretKey.slice(0, 5) + `***********************************` + "</td>" +
                                        "<td align='center'>" + hashKey.slice(0, 4) + `******` + "</td>" +
                                        "<td align='center'>" + "<a href='delete_api_key/" + id + "'" + "><button class='btn btn-warning '>Delete</button></a>" +
                                        `<button class='btn btn-info ml-1 downloadKeys' data="Client Id : ${clientId} , Secret Key : ${secretKey} , Hash Key : ${hashKey}">Download</button>` + "</td>" +
                                        "</tr>";

                                    $("#keytable tbody").append(tr_str);
                                }
                            } else {
                                var tr_str = "<tr>" +
                                    "<td align='center' colspan='4'>No record found.</td>" +
                                    "</tr>";

                                $("#keytable tbody").append(tr_str);


                            }


                        }
                    });
                }
            });


        })
    })

    $(function getapikeys() {

        console.log('working');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            dataType: "json",
            url: '/merchant/get_api_keys',
            success: function(data) {

                console.log(data);
                var len = 0;
                $('#keytable tbody').empty(); // Empty <tbody>
                if (data != null) {
                    len = data.length;
                }

                if (len > 0) {
                    for (var i = 0; i < len; i++) {
                        var id = data[i].id;
                        var clientId = data[i].client_id;
                        var secretKey = data[i].secret_key;
                        var hashKey = data[i].hash_key;
                        var createdAt = data[i].created_at;

                        var tr_str = "<tr>" +
                            "<td align='center'>" + (i + 1) + "</td>" +
                            "<td align='center'>" + createdAt + "</td>" +
                            "<td align='center' >" + clientId.slice(0, 5) + `***********************` + "</td>" +
                            "<td align='center'>" + secretKey.slice(0, 5) + `***********************************` + "</td>" +
                            "<td align='center'>" + hashKey.slice(0, 4) + `******` + "</td>" +
                            "<td align='center'>" + "<a href='delete_api_key/" + id + "'" + "><button class='btn btn-warning '>Delete</button></a>" +
                            `<button class='btn btn-info ml-1 downloadKeys' data="Client Id : ${clientId} , Secret Key : ${secretKey} , Hash Key : ${hashKey}">Download</button>` + "</td>" +
                            "</tr>";

                        $("#keytable tbody").append(tr_str);
                    }
                } else {
                    var tr_str = "<tr>" +
                        "<td align='center' colspan='4'>No record found.</td>" +
                        "</tr>";

                    $("#keytable tbody").append(tr_str);


                }


            }
        });



    })
</script>







<script>
    $(function() {
        $('#clientIdCopy').click(function() {
            /* Get the text field */
            var copyText = document.getElementById("clientId");

            /* Select the text field */
            copyText.select();
            copyText.setSelectionRange(0, 99999); /* For mobile devices */

            /* Copy the text inside the text field */
            navigator.clipboard.writeText(copyText.value);

            swal("CleintId Copied to Clipboard", {
                buttons: false,
                timer: 2000,
            });


        })
    });
</script>

<script>
    $(function() {
        $('#secretkeyCopy').click(function() {
            /* Get the text field */
            var copyText = document.getElementById("secretkey");

            /* Select the text field */
            copyText.select();
            copyText.setSelectionRange(0, 99999); /* For mobile devices */

            /* Copy the text inside the text field */
            navigator.clipboard.writeText(copyText.value);

            swal("Secret Key Copied to Clipboard", {
                buttons: false,
                timer: 2000,
            });
        })
    });
</script>


<script>
    $(function() {
        $(document).on('click', ".downloadKeys", function() {

            var text = $(this).attr('data');
            var filename = 'Payflash api keys';
            var element = document.createElement('a');
            element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
            element.setAttribute('download', filename);

            element.style.display = 'none';
            document.body.appendChild(element);

            element.click();

            document.body.removeChild(element);




        })
    });
</script>





@endsection