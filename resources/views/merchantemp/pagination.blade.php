@if($module == "transaction")
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Payment Id</th>
                <th>Order Id</th>
                <th>Amount</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Created At</th>
                <th>status</th>
            </tr>
        </thead>
        <tbody id="paymenttable">
            @if(count($transactions)>0)
                @foreach($transactions as $transaction)
                <tr>
                    <td>{{++$table_count}}</td>
                    <td><a href="javascript:transactionDetails('{{$transaction->id}}')">{{$transaction->transaction_gid}}</a></td>
                    <td>{{$transaction->order_gid}}</td>
                    <td>{{$transaction->transaction_amount}}</td>
                    <td>{{$transaction->transaction_email}}</td>
                    <td>{{$transaction->transaction_contact}}</td>
                    <td>{{$transaction->created_date}}</td>
                    <td>{{$transaction->transaction_status}}</td>
                </tr>
                @endforeach
            @else
            <tr>
                <td class="text-center" colspan=8>No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
            <div></div>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$transactions->firstItem()==''?'0':$transactions->firstItem()}} to {{$transactions->lastItem()==''?'0':$transactions->lastItem()}} of {{$transactions->total()}} entries</h5> 
    </div>
    <div class="col-sm-6">
        <span class="pull-right">
            <ul class="pagination">
                <li><a href="{{$transactions->previousPageUrl()}}">Previous</a></li>
                <li><a href="javascript:">{{$transactions->currentPage()}}</a></li>
                <li><a href="{{$transactions->nextPageUrl()}}">Next</a></li>
            </ul>
        </span>
    </div>
</div>
@endif

@if($module == "paylink")
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Paylink Id</th>
                <th>Receipt</th>
                <th>Amount</th>
                <th>Customer Email</th>
                <th>Customer Mobile</th>
                <th>Paylink</th>
                <th>Created At</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody id="paylinktable">
            @if(count($paylinks)>0)
            @foreach($paylinks as $paylink)
            <tr>
                <td>{{++$table_count}}</td>
                @if($paylink->paylink_status == 'issued')
                    <td><a href="javascript:editPaylink('{{$paylink->id}}');">{{$paylink->paylink_gid}}</a></td>
                @else
                    <td>{{$paylink->paylink_gid}}</td>
                @endif
                <td>{{$paylink->paylink_receipt}}</td>
                <td>{{number_format($paylink->paylink_amount,2)}}</td>
                <td>{{$paylink->paylink_customer_email}}</td>
                <td>{{$paylink->paylink_customer_mobile}}</td>
                <td><a href="{{$paylink->paylink_link}}" target="_blank">{{$paylink->paylink_link}}</a></td>
                <td>{{$paylink->created_date}}</td>
                <td>{{$paylink->paylink_status}}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan="9">No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
            <div></div>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$paylinks->firstItem()==''?'0':$paylinks->firstItem()}} to {{$paylinks->lastItem()==''?'0':$paylinks->lastItem()}} of {{$paylinks->total()}} entries</h5> 
    </div>
    <div class="col-sm-6">
        <span class="pull-right">
            <ul class="pagination">
                <li><a href="{{$paylinks->previousPageUrl()}}">Previous</a></li>
                <li><a href="javascript:">{{$paylinks->currentPage()}}</a></li>
                <li><a href="{{$paylinks->nextPageUrl()}}">Next</a></li>
            </ul>
        </span>
    </div>
</div>
@endif

@if($module == "quicklink")
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Paylink Id</th>
                <th>Amount</th>
                <th>Purpose</th>
                <th>Expiry</th>
                <th>Paylink</th>
                <th>Created At</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody id="quicklinktable">
            @if(count($quicklinks)>0)
            @foreach($quicklinks as $quicklink)
            <tr>
                <td>{{++$table_count}}</td>
                <td>{{$quicklink->paylink_gid}}</td>
                <td>{{number_format($quicklink->paylink_amount,2)}}</td>
                <td>{{$quicklink->paylink_for}}</td>
                <td>{{$quicklink->paylink_expiry}}</td>
                <td><a href="{{$quicklink->paylink_link}}" target="_blank">{{$quicklink->paylink_link}}</a></td>
                <td>{{$quicklink->created_date}}</td>
                <td>{{$quicklink->paylink_status}}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan=8>No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
            <div></div>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$quicklinks->firstItem()==''?'0':$quicklinks->firstItem()}} to {{$quicklinks->lastItem()==''?'0':$quicklinks->lastItem()}} of {{$quicklinks->total()}} entries</h5> 
    </div>
    <div class="col-sm-6">
        <span class="pull-right">
            <ul class="pagination">
                <li><a href="{{$quicklinks->previousPageUrl()}}">Previous</a></li>
                <li><a href="javascript:">{{$quicklinks->currentPage()}}</a></li>
                <li><a href="{{$quicklinks->nextPageUrl()}}">Next</a></li>
            </ul>
        </span>
    </div>
</div>
@endif

@if($module == "merchantemp_log")
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Login Ip Address</th>
                <th>Login Devices</th>
                <th>Login Operating System</th>
                <th>Login Browser</th>
                <th>Last Login</th>
            </tr>
        </thead>
        <tbody>
            @if(count($merchantemp_logs)>0)
                @foreach($merchantemp_logs as $log)
                <tr>
                    <td>{{++$table_count}}</td>
                    <td>{{$log->log_ipaddress}}</td>
                    <td>{{$log->log_device}}</td>
                    <td>{{$log->log_os}}</td>
                    <td>{{$log->log_browser}}</td>
                    <td>{{$log->log_time}}</td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td class="text-center" colspan=5>No Data found</td>
                </tr>
            @endif
        </tbody>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$merchantemp_logs->firstItem()==''?'0':$merchantemp_logs->firstItem()}} to {{$merchantemp_logs->lastItem()==''?'0':$merchantemp_logs->lastItem()}} of {{$merchantemp_logs->total()}} entries</h5> 
    </div>
    <div class="col-sm-6">
        <span class="pull-right">
            <ul class="pagination">
                <li><a href="{{$merchantemp_logs->previousPageUrl()}}">Previous</a></li>
                <li><a href="javascript:">{{$merchantemp_logs->currentPage()}}</a></li>
                <li><a href="{{$merchantemp_logs->nextPageUrl()}}">Next</a></li>
            </ul>
        </span>
    </div>
</div>
@endif
