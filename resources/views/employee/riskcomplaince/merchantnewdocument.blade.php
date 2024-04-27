@extends('layouts.employeecontent')
@section('employeecontent')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Add merchant</title>
</head>
<style>
    .process.nav-tabs .nav-item.show .nav-link,
    .process.nav-tabs .nav-link.active:hover,
    .process.nav-tabs .nav-link.active:focus,
    .process.nav-tabs .nav-link.active {
        border-bottom: 4px solid;
        color: blue;
        border-color: #fff #fff blue #fff
    }

    .process.nav-tabs .nav-link:focus,
    .process.nav-tabs .nav-link,
    .process.nav-tabs .nav-link:hover {
        border-bottom: 4px solid;
        border-color: #fff #fff #dee2e6 #fff;
    }

    .nav-item.validation {
        width: 32%;
        padding-right: 25px;
    }

    .nav-link {
        color: black;
    }
</style>

<body>

    <div class="container mt-5">
        <h2 class="mb-4">Add Merchant</h2>

        <ul class="nav nav-tabs process" id="myTabs">
            <li class="nav-item validation">
                <a class="nav-link active success " id="tab1" data-toggle="tab" href="#pane1">Personal Details</a>
            </li>
            <li class="nav-item validation">
                <a class="nav-link  success" id="tab2" data-toggle="tab" href="#pane2">Company info</a>
            </li>
            <li class="nav-item validation">
                <a class="nav-link success" id="tab3" data-toggle="tab" href="#pane3">Bussiness info</a>
            </li>
        </ul>

        <form>
            <div class="tab-content mt-2">
                <div class="tab-pane fade show active" id="pane1">
                    <h4>Personal Details</h4>
                    <!-- Your form fields for Tab 1 go here -->
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Name">Name<span class="text-danger">*</span>:</label>
                                    <input style="background-color:ghostwhite" type="text" class="form-control"
                                        id="merchantName" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Email">Email<span class="text-danger">*</span>:</label>
                                    <input style="background-color:ghostwhite;" type="email" class="form-control"
                                        id="merchantEmail" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Mobile">Mobile*:</label>
                                    <input style="background-color:ghostwhite;" type="email" class="form-control"
                                        id="merchantEmail" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Password">Password<span class="text-danger">*</span>:</label>
                                    <input style="background-color:ghostwhite;" type="email" class="form-control"
                                        id="merchantEmail" placeholder="">
                                </div>
                            </div>



                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="merchantAddress">Merchant Address<span
                                            class="text-danger">*</span>:</label>
                                    <input style="background-color:ghostwhite;" type="text" class="form-control"
                                        id="merchantAddress" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="btn btn-success" id="prev" style="">
                                Prev
                            </div>

                            <div class="btn btn-info" id="next">
                                Next
                            </div>


                        </div>


                    </form>
                </div>
                <div class="tab-pane fade" id="pane2">
                    <h4>Company Info</h4>
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Monthly Expenditure:">Monthly Expenditure:<span
                                            class="text-danger">*</span></label>
                                    <select style="background-color:ghostwhite;" class="form-control" id="country"
                                        name="country">
                                        <option value="" selected disabled>Haven't started process it </option>
                                        <option value="USA">Less than 5 Lakhs</option>
                                        <option value="Canada">5 Lakhs to 25 Lakhs</option>
                                        <option value="Canada">25 Lakhs to 50 Lakhs</option>
                                        <option value="Canada">50 Lakhs to 1 Crore</option>
                                        <option value="Canada">More than 1 Crore</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Company Name:">Company Name<span class="text-danger">*</span>:</label>
                                    <input style="background-color:ghostwhite;" type="email" class="form-control"
                                        id="merchantEmail" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Company Address:">Company Address<span
                                            class="text-danger">*</span></label>
                                    <input style="background-color:ghostwhite;" type="email" class="form-control"
                                        id="merchantEmail" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Pincode">Pincode<span class="text-danger">*</span>:</label>
                                    <input style="background-color:ghostwhite;" type="email" class="form-control"
                                        id="merchantEmail" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="City">City<span class="text-danger">*</span>:</label>
                                    <input style="background-color:ghostwhite;" type="email" class="form-control"
                                        id="merchantEmail" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="State">State<span class="text-danger">*</span>:</label>
                                    <input style="background-color:ghostwhite;" type="email" class="form-control"
                                        id="merchantEmail" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Country">Country<span class="text-danger">*</span>:</label>
                                    <input style="background-color:ghostwhite;" type="email" class="form-control"
                                        id="merchantEmail" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="btn btn-success" id="prev" style="">
                                Prev
                            </div>

                            <div class="btn btn-info" id="next">
                                Next
                            </div>


                        </div>



                    </form>

                </div>
                <div class="tab-pane fade" id="pane3">
                    <h4>Business Info </h4>
                    <!-- Your form fields for Tab 3 go here -->
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Business Type">Business Type<span class="text-danger">*</span>:</label>
                                    <input style="background-color:ghostwhite;" type="text" class="form-control"
                                        id="merchantName" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Business Category:">Business Category<span
                                            class="text-danger">*</span>:</label>
                                    <input style="background-color:ghostwhite;" type="email" class="form-control"
                                        id="merchantEmail" placeholder="">

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Business Sub Category:">Business Sub Category<span
                                            class="text-danger">*</span></label>
                                    <input style="background-color:ghostwhite;" type="email" class="form-control"
                                        id="merchantEmail" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="WebApp/Url">WebApp/Url<span class="text-danger">*</span>:</label>
                                    <input style="background-color:ghostwhite;" type="email" class="form-control"
                                        id="merchantEmail" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Bank Name">Bank Name<span class="text-danger">*</span>:</label>
                                    <input style="background-color:ghostwhite;" type="email" class="form-control"
                                        id="merchantEmail" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Bank Acc No">Bank Acc No<span class="text-danger">*</span>:</label>
                                    <input style="background-color:ghostwhite;" type="email" class="form-control"
                                        id="merchantEmail" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Bank IFSC Code">Bank IFSC Code<span
                                            class="text-danger">*</span>:</label>
                                    <input style="background-color:ghostwhite;" type="email" class="form-control"
                                        id="merchantEmail" placeholder="">

                                </div>
                            </div>


                        </div>
                        <div class="text-center">
                            <div class="btn btn-success" id="prev">
                                Prev
                            </div>

                            <div class="btn btn-info" id="next">
                                Next
                            </div>


                        </div>



                    </form>
                </div>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>