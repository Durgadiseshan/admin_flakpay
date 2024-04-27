@php
    use \App\Http\Controllers\MerchantController;
    $per_page = MerchantController::page_limit();
@endphp
@extends('.layouts.merchantcontent')
@section('merchantcontent')


<style>


/* Thick red border */
hr.new4 {
  border: 1px solid red;
}


</style>
<!-- ---------Banner---------- -->
<div id="buton-1">
    <button class="btn btn-primary" id="Show">Show</button>
<button  class="btn btn-primary" id="Hide">Remove</button>
    </div>
<section id="about-1" class="about-1">
    <div class="container-1">
  
      <div class="row">
      
        <div class="col-lg-6 d-flex flex-column justify-contents-center" data-aos="fade-left">
          <div class="content-1 pt-4 pt-lg-0">
            <h3>Welcome to Employees Type Permission Details</h3>
           </div>
        </div>
        
      </div>
  
    </div>
</section>

<div class="row">
    <div class="col-sm-12 padding-top-30">
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs" id="transaction-tabs">
                    <li class="active"><a data-toggle="tab" class="show-pointer" data-target="#users">Employees Types</a></li> 
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div id="users" class="tab-pane fade in active">
                      
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="col-sm-4">
                                    <select name="page_limit" class="form-control" onchange="getAllMerchantEmployeesTypes($(this).val())">
                                    <option value="">--select type--</option>
                                        @foreach($emp_types as $type => $row)
                                            <option value="{{$row->id}}">{{ucwords($row->option_value)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                          
                        </div>

                      

                        <div id="ajax-response-message" class="text-center" style="color: rgb(0, 128, 0);"></div>
                        <div class="display-block" id="paginate_employees">
                       
                           
                        </div>

                        
                   
                       
                       
                       
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>

@endsection
