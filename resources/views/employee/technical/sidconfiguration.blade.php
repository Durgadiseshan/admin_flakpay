@php
$vendor_banks = App\RyapayVendorBank::get_vendorbank();
@endphp
@extends('layouts.employeecontent')
@section('employeecontent')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>
    .dataTables_filter {
        display: none;
    }
</style>

<script>
    $("#rupayapay-comment-form").submit(function(e) {
  e.preventDefault();
  var formdata = $("#rupayapay-comment-form").serializeArray();
  $.ajax({
      url: "/rockpay/risk-complaince/grievence-cell/comment/add",
      type: "POST",
      data: getJsonObject(formdata),
      dataType: "json",
      success: function(response) {
          if (response.status) {
              $("#ajax-comment-response").html(response.message).css({ "color": "green" });
          }
      },
      error: function() {},
      complete: function() {
          $("#rupayapay-comment-form")[0].reset();
          getCommentDetails();
          setTimeout(() => {
              $("#ajax-comment-response").html("");
          }, 1500);
      }
  });
});
</script>

<h3>Submerchant ID Configurations </h3>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
    Add New SID
</button>

<div style="margin-top:30px; margin-bottom:20px; ">
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        {{-- <ul> --}}
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        {{-- </ul> --}}
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success alert-dismissible">
        {{ session('success') }}
    </div>
@endif

</div>

<div style="margin-top:30px; margin-bottom:100px; ">
    <table class="table table-striped table-bordered" id="transactions">

        <thead>
            <tr>
                <th>#</th>
                <th>SID</th>
                <th>Company Name</th>
                <th>VPA</th>
                <th>MCC Code</th>
                <th>Action</th>
                <th>Created at</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sids as $index=>$sid)
            <tr>
                <td>{{$index+1}}</td>
                <td>{{$sid->sid}}</td>
                <td>{{$sid->company_name}}</td>
                <td>{{$sid->vpa}}</td>
                <td>{{$sid->mcc_code}}</td>
                <td>
                    <!-- Edit Icon -->
                   <!-- Edit Button -->
                   <a href="{{ route('fetchSid', $sid->id) }}" class="btn btn-sm btn-primary editButton" data-id='{{ $sid->id }}' title="Edit">
                    <i class="bi bi-pencil"></i>
                </a>
                    
                    <!-- Delete Icon -->
                    <form id="deleteForm_{{ $sid->id }}" action="{{ route('deleteSid', $sid->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-sm btn-danger deleteButton" data-id="{{ $sid->id }}" title="Delete">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>

    
                    <!-- Activate/Deactivate Icon -->
                   <!-- Activate/Deactivate Icon -->
                @if ($sid->is_active)
                    <form id="deactivateForm_{{ $sid->id }}" class="statusForm" data-id="{{ $sid->id }}" action="{{ route('statusSid', $sid->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PUT')
                        <button type="button" class="btn btn-sm btn-success statusButton" title="Deactivate">
                            <i class="bi bi-check-circle"></i>
                        </button>
                    </form>
                @else
                    <form id="activateForm_{{ $sid->id }}" class="statusForm" data-id="{{ $sid->id }}" action="{{ route('statusSid', $sid->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PUT')
                        <button type="button" class="btn btn-sm btn-warning statusButton" title="Activate">
                            <i class="bi bi-exclamation-circle"></i>
                        </button>
                    </form>
                @endif

                </td>
                <td>{{$sid->created_at}}</td>
                {{-- <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal" data-merchant="{{$permissions->merchant_id}}" data-payout="{{$permissions->payout}}" data-payin="{{$permissions->payin}}" data-pennydrop="{{$permissions->pennydrop}}">
                <ion-icon name="create-outline"></ion-icon>
                    </button>
                </td> --}}
            </tr>
            @endforeach




        </tbody>
    </table>
</div>


<!-- addModal -->

<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add SID Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/flakpay/technical/add_sid" method="POST">
                {!! csrf_field() !!}
                    <div class="form-group control-label">
                        <label for="sid">SID</label>
                        <input type="text" name="sid" id="sid">
                    </div>

                    <div class="form-group control-label">
                        <label for="company_name" >Company Name</label>
                        <input type="text" name="company_name" id="company_name">
                    </div>

                    <div class="form-group control-label">
                        <label for="vpa">VPA</label>
                        <input type="text" name="vpa" id="vpa">
                    </div>

                    <div class="form-group control-label">
                        <label for="mcc_code">MCC Code</label>
                        <input type="text" name="mcc_code" id="mcc_code">
                    </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button  type="submit" class="btn btn-primary">Save </button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- endaddmodal -->

<!-- EditModal -->
{{-- <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form action="/rockpay/technical/edit_merchant_services" method="POST">
                {!! csrf_field() !!}
                <input type="hidden" id="merchant" name="merchant">
                    <div class="form-group">
                        <label for="exampleInputPassword1">Payout</label>
                        <select name="payout" id="payout" class="form-control">

                            <option value="0">Disabled</option>
                            <option  value="1">Enabled</option>

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">Payin</label>
                        <select name="payin" id="payin" class="form-control">
                            <option value="0">Disabled</option>
                            <option value="1">Enabled</option>


                        </select>
                    </div>


                    <div class="form-group">
                        <label for="exampleInputPassword1">Pennydrop</label>
                        <select name="pennydrop" id="pennydrop" class="form-control">

                            <option value="0">Disabled</option>
                            <option value="1">Enabled</option>

                        </select>
                    </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save </button>
            </div>
            </form>
        </div>
    </div>
</div> --}}

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit SID Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/flakpay/technical/edit_sid/{{ $sid->id }}" method="POST">
                    @csrf               
                    <div class="form-group control-label">
                        <label for="sid">SID</label>
                        <input type="text" name="sid" id="editsid">
                    </div>

                    <div class="form-group control-label">
                        <label for="company_name" >Company Name</label>
                        <input type="text" name="company_name" id="edit_company_name">
                    </div>

                    <div class="form-group control-label">
                        <label for="vpa">VPA</label>
                        <input type="text" name="vpa" id="edit_vpa">
                    </div>

                    <div class="form-group control-label">
                        <label for="mcc_code">MCC Code</label>
                        <input type="text" name="mcc_code" id="edit_mcc_code">
                    </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button  type="submit" class="btn btn-primary editsave"  data-id=''>Save </button>
            </div>
            </form>
        </div>
    </div>
</div>


<!-- endaddmodal -->

<!-- Edit Modal (example structure) -->
{{-- <div id="editModal" class="modal">
    <!-- Modal Content -->
    <div class="modal-content">
        <!-- Form Inputs -->
        <input type="hidden" id="editSid" value="">
        <input type="text" id="editData" value="">
        <!-- Other modal content -->
    </div>
</div> --}}



<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<!-- jQuery CDN -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>



<script>
    $('#editModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var id = button.data('merchant')
        var payout = button.data('payout')  
        var payin = button.data('payin')
        var pennydrop = button.data('pennydrop')  
        console.log(id,payout,payin,pennydrop,button);
        var modal = $(this)
        modal.find('#merchant').val(id);
        modal.find('#payout').val(payout).change();
        modal.find('#payin').val(payin).change();
        modal.find('#pennydrop').val(pennydrop).change();
       
})

//fetchsid
document.addEventListener('DOMContentLoaded', function () {
    // Attach event listener to all edit buttons
    var editButtons = document.querySelectorAll('.editButton');
    editButtons.forEach(function (button) {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            // Get the data-id attribute from the clicked button
            var sid = this.getAttribute('data-id');

            // Create a new XMLHttpRequest object
            var xhr = new XMLHttpRequest();

            // Define the AJAX request with the sid parameter
            xhr.open('GET', '/fetch-sid/' + sid, true);

            // Set up the onload event handler for a successful response
            xhr.onload = function () {
                if (xhr.status >= 200 && xhr.status < 400) {
                    // Parse the JSON response
                    var response = JSON.parse(xhr.responseText);
                    console.log('response', response);

                    // Bind the fetched data to the modal form
                    document.getElementById('editsid').value = response.sid;
                    document.getElementById('edit_company_name').value = response.company_name;
                    document.getElementById('edit_vpa').value = response.vpa;
                    document.getElementById('edit_mcc_code').value = response.mcc_code;

                    // Show the modal
                    $('#editModal').modal('show');
                } else {
                    // Handle errors
                    console.error('Error fetching data:', xhr.statusText);
                }
            };

            // Set up the onerror event handler for a failed request
            xhr.onerror = function () {
                console.error('Error fetching data.');
            };

            // Send the AJAX request
            xhr.send();
        });
    });
});

//editsid
document.addEventListener('DOMContentLoaded', function () {
    // Attach event listener to all edit buttons
    var editButtons = document.querySelectorAll('.editsave');
    editButtons.forEach(function (button) {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            // Get the data-id attribute from the clicked button
            var sid = this.getAttribute('data-id');

            // Get form data
            var formData = new FormData();
            formData.append('sid', sid);
            // Append other form fields as needed
            formData.append('editsid', document.getElementById('editsid').value);
            formData.append('edit_company_name', document.getElementById('edit_company_name').value);
            formData.append('edit_vpa', document.getElementById('edit_vpa').value);
            formData.append('edit_mcc_code', document.getElementById('edit_mcc_code').value);

            // Create a new XMLHttpRequest object
            var xhr = new XMLHttpRequest();

            // Define the AJAX request with the form action
            xhr.open('POST', '/flakpay/technical/edit_sid/' + sid, true);

            // Set the CSRF token in the request headers
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

            // Set up the onload event handler for a successful response
            xhr.onload = function () {
                if (xhr.status >= 200 && xhr.status < 400) {
                    // Parse the JSON response
                    var response = JSON.parse(xhr.responseText);
                    console.log('response', response);

                    // Close the edit modal using jQuery
                    $('#editModal').modal('hide');
                    // Refresh the page after hiding the modal
                    location.reload();
                } else {
                    // Handle errors
                    console.error('Error fetching data:', xhr.statusText);
                }
            };

            // Set up the onerror event handler for a failed request
            xhr.onerror = function () {
                console.error('Error fetching data.');
            };

            // Send the AJAX request with form data
            xhr.send(formData);
        });
    });
});

// When the edit button is clicked, bind its data-id to the save button
document.querySelectorAll('.editButton').forEach(function(editButton) {
        editButton.addEventListener('click', function(event) {
            var sid = this.getAttribute('data-id');
            document.querySelector('.editsave').setAttribute('data-id', sid);
        });
    });

    // When the modal is shown, update the hidden input with the data-id from the save button
    $('#editModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var sid = button.data('id');
        $(this).find('#sid').val(sid);
    });

//deletedside

    document.querySelectorAll('.deleteButton').forEach(function(deleteButton) {
        deleteButton.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default form submission
            
            var sid = this.getAttribute('data-id'); // Get the SID

            // Confirm deletion (you may customize this according to your needs)
            if (confirm('Are you sure you want to delete this item?')) {
                // Create a new XMLHttpRequest object
                var xhr = new XMLHttpRequest();
                
                // Define the AJAX request with the form action
                xhr.open('POST', '/flakpay/technical/delete_sid/' + sid, true);

                // Set the CSRF token in the request headers
                xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

                // Set up the onload event handler for a successful response
                xhr.onload = function() {
                    if (xhr.status >= 200 && xhr.status < 400) {
                        // Handle successful response (if needed)
                        console.log('Item deleted successfully');
                        location.reload();

                        // Optionally, perform any UI updates here
                    } else {
                        // Handle errors (if needed)
                        console.error('Error deleting item:', xhr.statusText);
                    }
                };

                // Set up the onerror event handler for a failed request
                xhr.onerror = function() {
                    console.error('Error deleting item.');
                };

                // Send the AJAX request
                xhr.send();
            }
        });
    });

//update status
    document.querySelectorAll('.statusButton').forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default form submission
            
            var sid = this.closest('.statusForm').getAttribute('data-id'); // Get the SID
            
            var formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('_method', 'POST');
            
            // Create a new XMLHttpRequest object
            var xhr = new XMLHttpRequest();

            // Define the AJAX request with the form action
            xhr.open('POST', '/flakpay/technical/status_sid/' + sid, true);

            // Set the request headers
            xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

            // Set up the onload event handler for a successful response
            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 400) {
                    // Handle successful response
                    var response = JSON.parse(xhr.responseText);
                    console.log(response.message);
                    // Reload the page or update UI as needed
                    location.reload(); // Example: Reload the page
                } else {
                    // Handle errors (if needed)
                    console.error('Error updating status:', xhr.statusText);
                }
            };

            // Set up the onerror event handler for a failed request
            xhr.onerror = function() {
                console.error('Error updating status.');
            };

            // Send the AJAX request with form data
            xhr.send(formData);
        });
    });


</script>












@endsection