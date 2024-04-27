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
    <button class="btn btn-primary" id="Hide">Remove</button>
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
               
                    Employee Detail: <h5><b>{{$employee->employee_name}}<b></h5>
               
            </div>
            <div class="panel-body">
                <div class="tab-content">
                    <div id="users" class="tab-pane fade in active">



                    <div class="row">

                        <div id="ajax-response-message" class="text-center" style="color: rgb(0, 128, 0);font-size:15px;"></div>
                    </div>
                        <div class="modal-content">
                            <div class="modal-header">

                                <h4 class="modal-title">Permissions</h4>
                            </div>
                            <form class="form-horizontal" id="permissions-form-emp" method="POST" action="{{route('store-type-permissions')}}">
                                <input type="hidden" name="merchant_employee_id" value="{{$employee->id}}">
                                {{ csrf_field() }}

                                <div class="modal-body">


                                    <div class="row">



                                        @if($merchantMenus)
                                         @php
                                            $usermenus=$usersubmenus=[];
                                            $user = \App\MerchantTypePermissions::where('merchant_employee_id',$employee->id)->first();
                                            if($user){
                                                   if($user->menus){
                                                         $usermenus=json_decode($user->menus);
                                                    }
                                            if($user->submenus){
                                                $usersubmenus=json_decode($user->submenus);
                                            }
                                        }

                                        @endphp
                                        @foreach($merchantMenus as $menu)
                                        <div class="col-sm-12">
                                            <div class="col-sm-6 padding-top-30">
                                                <div class="form-group">
                                                    <label for="input" class="col-sm-3 control-label">{{ucwords($menu->menu_name)}}:</label>
                                                    <div class="col-sm-3">


                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" class="center-checkbox form-control" name="menus[]" id="paylink_partial" value="{{$menu->menu_id}}" @php if(in_array($menu->menu_id, $usermenus)) echo "checked"; @endphp>
                                                                <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            </label>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        @php
                                        $subMenus=\App\MerchantSubmenus::where('submenu_under',$menu->menu_id)->get();
                                        @endphp

                                        @if($subMenus)

                                        <div class="col-sm-12">
                                            @foreach($subMenus as $submenu)
                                            <div class="col-sm-2 padding-top-10">
                                                <div class="form-group">
                                                    <label for="input" class=" control-label">{{ucwords($submenu->submenu_name)}}</label>
                                                    <div class="">


                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" class="center-checkbox form-control" name="submenus[]" id="paylink_partial" value="{{$submenu->submenu_id}}" @php if(in_array($submenu->submenu_id, $usersubmenus)) echo "checked"; @endphp>
                                                                <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            </label>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            @endforeach
                                        </div>

                                        @endif


                                        <hr class="new4">
                                        @endforeach

                                        @endif


                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <input type="submit" class="btn btn-primary" value="Submit">
                                </div>
                            </form>
                        </div>




                        








                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection