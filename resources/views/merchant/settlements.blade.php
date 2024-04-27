@extends('layouts.merchantcontent')
@section('merchantcontent')
    <!--Module Banner-->
    <div id="buton-1">
    <button class="btn btn-dark" id="Show">Show</button>
<button  class="btn btn-danger" id="Hide">Remove</button>
    </div>
<section id="about-1" class="about-1">
    <div class="container-1">
  
      <div class="row">
       
        <div class="col-lg-6 d-flex flex-column justify-contents-center" data-aos="fade-left">
          <div class="content-1 pt-4 pt-lg-0">
            <h3>Settlements</h3>
            <p class="font-italic">Get your settlement details here</p>
  
  <p>You are just one step away from activating your account to accept domestic and international payments from your customers. We just need a few more details</p>
          </div>
        </div>
        <div class="col-lg-6" data-aos="zoom-in">
          <img src="/assets/img/merchant-help.png" width="450" class="img-fluid" id="img-dash" alt="merchant-help.png">
        </div>
      </div>
  
    </div>
</section>
  <!--Module Banner-->

    <div class="row">
        <div class="col-sm-12 padding-20">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <ul class="nav nav-tabs" id="transaction-tabs">
                        @php ($trans = ['merchant/settlements' => '<a data-toggle="tab" class="show-cursor" data-target="#settlements" onclick="changeTab(this);">Settlements</a>'])
                        @foreach($trans as $index=>$value)
                            <li class="{{ Request::path() == $index ?'active' : ''}}">{!! $value !!}</li>
                        @endforeach
                    </ul>
                    <form action="" id="transaction-tabs-form" method="POST">
                        {{ csrf_field() }}
                    </form>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div id="settlements" class="tab-pane fade in active">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="display-block">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Sno</th>
                                                        <th>Adjustment Id</th>
                                                        <th>Amount</th>
                                                        <th>Fees</th>
                                                        <th>Tax</th>
                                                        <th>Created At</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="settlementtable">
                                                    @if(count($settlements)>0)
                                                    @php($table_count=0)
                                                    @foreach($settlements as $settlement)
                                                    <tr>
                                                        <td>{{++$table_count}}</td>
                                                        <td>{{$settlement->settlement_gid}}</td>
                                                        <td>{{$settlement->settlement_amount}}</td>
                                                        <td>{{$settlement->settlement_fee}}</td>
                                                        <td>{{$settlement->settlement_tax}}</td>
                                                        <td>{{$settlement->created_date}}</td>
                                                        <td>{{$settlement->status}}</td>
                                                    </tr>
                                                    @endforeach
                                                    @else
                                                    <tr>
                                                        <td class="text-center" colspan=7>No Data found</td>
                                                    </tr>
                                                    @endif
                                                </tbody>
                                                <tfoot>
                                                    <div></div>
                                                </tfoot>
                                            </table>
                                            <div class="col-sm-6">
                                                <h5 class="pagination">Showing {{$settlements->firstItem()}} to {{$settlements->lastItem()}} of {{$settlements->total()}} entries</h5> 
                                            </div>
                                            <div class="col-sm-6">
                                                <span class="pull-right">
                                                    <ul class="pagination">
                                                        <li><a href="{{$settlements->previousPageUrl()}}">Previous</a></li>
                                                        <li><a href="javascript:">{{$settlements->currentPage()}}</a></li>
                                                        <li><a href="{{$settlements->nextPageUrl()}}">Next</a></li>
                                                    </ul>
                                                </span>
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