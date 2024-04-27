<div class="modal-content">
                                    <div class="modal-header">
                                      
                                        <h4 class="modal-title">Permissions</h4>
                                    </div>
                                    <form class="form-horizontal" id="permissions-form-emp" method="POST" action="{{route('store-type-permissions')}}">
                                    <input type="hidden" name="type_id" value="{{$typeid}}" >
                                    {{ csrf_field() }}
                                        
                                        <div class="modal-body">


                                        <div class="row">
                        


@if($merchantMenus)
                @php
                   $usermenus=$usersubmenus=[];
                    $user = \App\MerchantTypePermissions::where('mer_emp_type_id',$typeid)->first();
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
                                                            <input type="checkbox"  class="center-checkbox form-control" name="menus[]" id="paylink_partial" value="{{$menu->menu_id}}" @php if(in_array($menu->menu_id, $usermenus)) echo "checked"; @endphp>
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
                                                            <input type="checkbox"  class="center-checkbox form-control" name="submenus[]" id="paylink_partial" value="{{$submenu->submenu_id}}" @php if(in_array($submenu->submenu_id, $usersubmenus)) echo "checked"; @endphp>
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
                                        </form></div>


                                     

<script>


$("#permissions-form-emp").submit(function(e){
        
        e.preventDefault();
        var formdata = $("#permissions-form-emp").serializeArray();
        $.ajax({
            url:"{{route('store-type-permissions')}}",
            type:"POST",
            data:(formdata),
            dataType:"json",
            success:function(response){


              window.scrollTo(0, 0);
                if(response.status)
                {
                    console.log(response.status);
                    $("#ajax-response-message").html(response.message).css({"color":"green"});
                    $("#permissions-form-emp")[0].reset();
                }else{
                    if(typeof response.errors !="undefined" && Object.keys(response.errors).length > 0){
                        $.each(response.errors, function (indexInArray, valueOfElement) { 
                            $("#permissions-form-emp #"+indexInArray+"_ajax_error").html(valueOfElement[0]).css({"color":"red"});
                            $("#permissions-form-emp input[name="+indexInArray+"]").click(function(){
                                $("#permissions-form-emp #"+indexInArray+"_ajax_error").html("");
                            });
                           
                        });
                    }
                }
            },
            error:function(){},
            complete:function(){
               
                setTimeout(() => {
                    $("#ajax-response-message").html("");
                     window.location.reload(true);
                },3000);
            }
        });
    })

  </script>

