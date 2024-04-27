@php
    use \App\Http\Controllers\MerchantController;

    $per_page = MerchantController::page_limit();
@endphp
@extends(".layouts.merchantcontent")
@section("merchantcontent")

<!-- ---------Banner---------- -->
<div id="buton-1">
    <button class="btn btn-dark" id="Show">Show</button>
<button  class="btn btn-danger" id="Hide">Remove</button>
    </div>
<section id="about-1" class="about-1">
    <div class="container-1">
  
      <div class="row">
      
        <div class="col-lg-6 d-flex flex-column justify-contents-center" data-aos="fade-left">
          <div class="content-1 pt-4 pt-lg-0">
            <h3>Utilities</h3>
            <p class="font-italic">Enjoy our utilitie feature</p>
  
            <p>Using our utilitie feature you can create your own web page to get payments also you can add coupons & products.</p>
          </div>
        </div>
        <div class="col-lg-6" data-aos="zoom-in">
          <img src="/assets/img/merchant-utilities.png" width="350" class="img-fluid" id="img-dash" alt="merchant-utilities.png">
        </div>
      </div>
  
    </div>
</section>
    <div class="row">
        <div class="col-sm-12 padding-20">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <ul class="nav nav-tabs" id="utilities-tabs">
                        <li class="active"><a data-toggle="tab" class="show-cursor" data-target="#coupons-discounts">Coupons & Discounts</a></li>
                        <li><a data-toggle="tab" class="show-cursor" data-target="#products" onclick="getAllProducts();">Products</a></li>
                        <li><a data-toggle="tab" class="show-cursor" data-target="#payment-page-design">Payment Pages</a></li>                        
                    </ul>                    
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div id="coupons-discounts" class="tab-pane fade in active">
                            <div class="tab-button">
                                <a href="/merchant/coupon/new" class="btn btn-primary btn-sm">Add Coupons</a> 
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="col-sm-4">
                                        <select name="page_limit" class="form-control" onchange="getAllCoupons($(this).val())">
                                            @foreach($per_page as $index => $page)
                                            <option value="{{$index}}">{{$page}}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="search-box">
                                        <form action="">
                                            <input type="search" id="coupon-table" placeholder="Search">
                                            <i class="fa fa-search"></i>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="display-block" id="paginate_coupon">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="products" class="tab-pane fade">
                            <div class="tab-button">
                                <div class="btn btn-primary btn-sm" id="call-product-modal">Add Product</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="col-sm-4">
                                        <select name="page_limit" class="form-control" onchange="getAllProducts($(this).val())">
                                            @foreach($per_page as $index => $page)
                                            <option value="{{$index}}">{{$page}}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="search-box">
                                        <form>
                                            <input type="search" id="product-table" placeholder="Search">
                                            <i class="fa fa-search"></i>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="display-block" id="paginate_product">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Add Product Data Modal Starts-->
                                    <div id="add-product-modal" class="modal" role="dialog">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Add Product</h4>
                                            </div>
                                            <form class="form-horizontal" id="add-product-form">
                                                <div class="modal-body">
                                                    <div id="ajax-product-response" class="text-center"></div>
                                                    <div class="form-group">
                                                        <label for="produttitle" class="control-label col-sm-3">Title:</label>
                                                        <div class="col-sm-5">
                                                            <input type="text" class="form-control" name="product_title" id="product_title" value="">
                                                            <div id="product_title_error"></div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="produtprice" class="control-label col-sm-3">Price:</label>
                                                        <div class="col-sm-5">
                                                            <input type="text" class="form-control" name="product_price" id="product_price" value="" onkeyup="validateNumeric('product_price');"> 
                                                            <div id="product_price_error"></div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="productdescription" class="control-label col-sm-3">Description:</label>
                                                        <div class="col-sm-5">
                                                            <textarea name="product_description" id="product_description" cols="20" rows="4" class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                    {{csrf_field()}}
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="submit" class="btn btn-primary" value="Submit" />
                                                </div>
                                            </form>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- Add Product Data Modal Ends-->
                                    <!-- Update Product Data Modal Starts-->
                                    <div id="update-product-modal" class="modal" role="dialog">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Edit Product</h4>
                                            </div>
                                            <form class="form-horizontal" id="update-product-form">
                                                <div class="modal-body">
                                                    <div id="ajax-update-product-response" class="text-center"></div>
                                                    <div class="form-group">
                                                        <label for="produttitle" class="control-label col-sm-3">Title:</label>
                                                        <div class="col-sm-5">
                                                            <input type="text" class="form-control" name="product_title" id="product_title" value=""> 
                                                            <div id="product_title_error"></div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="produtprice" class="control-label col-sm-3">Price:</label>
                                                        <div class="col-sm-5">
                                                            <input type="text" class="form-control" name="product_price" id="product_price" value=""> 
                                                            <div id="product_price_error"></div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="productdescription" class="control-label col-sm-3">Description:</label>
                                                        <div class="col-sm-5">
                                                            <textarea name="product_description" id="product_description" cols="20" rows="4" class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                    {{csrf_field()}}
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="hidden" name="id" id="id" value="">
                                                    <input type="submit" class="btn btn-primary" value="Update" />
                                                </div>
                                            </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Update Product Data Modal Ends-->
                                    <!-- Delete Product Data modal starts-->
                                    <div id="delete-product-modal" class="modal">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    Are you sure? would you like to delete Product&nbsp;<strong id="delte-item-name"></strong>?
                                                </div>
                                                <div class="modal-footer">
                                                    <form id="product-delete-form">
                                                        <input type="hidden" name="id" value="">
                                                        {{csrf_field()}}
                                                        <input type="submit" class="btn btn-danger" value="Delete"/>
                                                        <button type="button" data-dismiss="modal" class="btn btn-primary">Cancel</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        <!-- Delete Product Data modal ends-->
                                </div>
                            </div>
                        </div>
                        <div id="payment-page-design" class="tab-pane">
                            <div class="tab-button">
                                <div class="btn btn-primary btn-sm" id="call-product-page-index">Add Payment Page</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div id="paginate_pagedetail">

                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal" id="call-product-page-index-modal"> 
                                        <div class="modal-dialog modal-sm-100">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title">Choose Page Type</h4>
                                                </div>
                                                <div class="modal-footer">
                                                    <div class="col-sm-12">
                                                        <div class="col-sm-4">
                                                            <div class="full-area">
                                                                <a href="javascript:void(0)" class="thumbnail" onclick="singlePage()">
                                                                    <img src="{{asset('images/single-product.png')}}" alt="single-product.png">
                                                                </a>
                                                                <h6 class="text-center">Single Product</h6>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="full-area">
                                                                <a href="javascript:void(0)" class="thumbnail" onclick="multiplePage()">
                                                                    <img src="{{asset('images/multiple-product.png')}}" alt="multiple-product.png">
                                                                </a>
                                                                <h6 class="text-center">Multiple Products</h6>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="full-area">
                                                                <a href="javascript:void(0)" class="thumbnail" onclick="charityPage()">
                                                                    <img src="{{asset('assets/productpage/charity.png')}}" alt="multiple-product.png">
                                                                </a>
                                                                <h6 class="text-center">Donations</h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="modal" id="single-page-index-modal">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title"><i class="fa fa-arrow-left show-cursor" onclick="goBackProductIndex();" aria-hidden="true">&nbsp;</i>Choose a Page</h4>
                                                </div>
                                                <div class="modal-footer">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="col-sm-6">
                                                                <div class="full-area thumbnail">
                                                                    <a href="{{route('create-payment-page','single-product')}}">
                                                                        <img src="{{asset('assets/productpage/templateone.png')}}" alt="single-product.png">
                                                                    </a>
                                                                    <div class="caption">
                                                                        <h3 class="text-center">Product Page</h3>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="full-area thumbnail">
                                                                    <a href="{{route('create-payment-page','single-product')}}">
                                                                        <img src="{{asset('assets/productpage/templatetwo.png')}}" alt="single-product.png">
                                                                    </a>
                                                                    <div class="caption">
                                                                        <h3 class="text-center">Product Page</h3>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="modal" id="multiple-page-index-modal">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title"><i class="fa fa-arrow-left show-cursor" onclick="goBackProductIndex();" aria-hidden="true">&nbsp;</i>Choose a page</h4>
                                                </div>
                                                <div class="modal-footer">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="col-sm-6">
                                                                <div class="full-area thumbnail">
                                                                    <a href="{{route('create-payment-page','single-product')}}">
                                                                        <img src="{{asset('assets/productpage/templateone.png')}}" alt="single-product.png">
                                                                    </a>
                                                                    <div class="caption">
                                                                        <h3 class="text-center">Product Page</h3>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="full-area thumbnail">
                                                                    <a href="{{route('create-payment-page','single-product')}}">
                                                                        <img src="{{asset('assets/productpage/templatetwo.png')}}" alt="single-product.png">
                                                                    </a>
                                                                    <div class="caption">
                                                                        <h3 class="text-center">Product Page</h3>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal" id="charity-page-index-modal">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title"><i class="fa fa-arrow-left show-cursor" onclick="goBackProductIndex();" aria-hidden="true">&nbsp;</i>Choose a page</h4>
                                                </div>
                                                <div class="modal-footer">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="col-sm-6">
                                                                <div class="full-area thumbnail">
                                                                    <a href="{{route('create-payment-page','charity')}}">
                                                                        <img src="{{asset('assets/productpage/charity.png')}}" alt="charity.png">
                                                                    </a>
                                                                    <div class="caption">
                                                                        <h3 class="text-center">Page One</h3>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="full-area thumbnail">
                                                                    <a href="{{route('create-payment-page','charity')}}">
                                                                        <img src="{{asset('assets/productpage/charity.png')}}" alt="charity.png">
                                                                    </a>
                                                                    <div class="caption">
                                                                        <h3 class="text-center">Page Two</h3>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal" id="page-deactivate-modal">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title">Payment Page</h4>
                                                </div>
                                                <div class="modal-body" id="page-deactivate-modal-message">
                                                    
                                                </div>
                                                <div class="modal-footer">
                                                    <form id="deactivate-pagedetail">
                                                        <input type="hidden" name="id" id="id" value="">
                                                        <input type="hidden" name="page_status" id="page_status" value="">
                                                        {{csrf_field()}}
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        <input type="submit" class="btn btn-primary" value="Ok"/>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="modal" id="page-deactivate-response-modal">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title" id="page-deactivate-response"></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
@endsection