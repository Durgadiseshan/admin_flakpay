@php
    use App\Http\Controllers\MerchantController;
    $supportCategory = MerchantController::support_category();
@endphp


@if($module == "dash_payment")
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Payment Id</th>
                <th>Amount</th>
                <th>Email</th>
                <th>Contact</th>
                <th>status</th>
                <th>Days Completed</th>
            </tr>
        </thead>
        <tbody id="paymenttable">
            @if(count($transactions)>0)
                @foreach($transactions as $transaction)
                <tr>
                    <td>{{++$table_count}}</td>
                    <td>{{$transaction->transaction_gid}}</td>
                    <td>{{$transaction->transaction_amount}}</td>
                    <td>{{$transaction->transaction_email}}</td>
                    <td>{{$transaction->transaction_contact}}</td>
                    <td>{{$transaction->transaction_status}}</td>
                    <td>{{$transaction->date_diff}} days ago</td>
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
        <h5 class="pagination">Showing {{$transactions->firstItem()==''?'0':$transactions->firstItem()}} to {{$transactions->lastItem() =='' ? '0':$transactions->lastItem()}} of {{$transactions->total()}} entries</h5> 
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$transactions->previousPageUrl()}}">Previous</a></li> 
            <li><a href="javascript:">{{$transactions->currentPage()}}</a></li>
            <li><a href="{{$transactions->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif

@if($module == "dash_refund")
@php($table_count=0)
<div class="table-responsive" >
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Refund Id</th>
                <th>Payment Id</th>
                <th>Refund Amount</th>
                <th>Refund Status</th>
                <th>Days</th>
            </tr>
        </thead>
        <tbody id="refundtable">
            @if(count($refunds)>0)
                @foreach($refunds as $refund)
                <tr>
                    <td>{{++$table_count}}</td>
                    <td>{{$refund->refund_gid}}</td>
                    <td>{{$refund->payment_gid}}</td>
                    <td>{{$refund->refund_amount}}</td>
                    <td>{{$refund->refund_status}}</td>
                    <td>{{$refund->date_diff}} days ago</td>
                </tr>
                @endforeach
            @else
            <tr>
                <td class="text-center" colspan=6>No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
            <div></div>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$refunds->firstItem()==''?'0':$refunds->firstItem()}} to {{$refunds->lastItem()==''?'0':$refunds->lastItem()}} of {{ $refunds->total() }} entries</h5> 
    </div>
    <div class="col-sm-6">
        <span class="pull-right">
            <ul class="pagination">
                <li><a href="{{$refunds->previousPageUrl()}}">Previous</a></li>
                <li><a href="javascript:">{{$refunds->currentPage()}}</a></li>
                <li><a href="{{$refunds->nextPageUrl()}}">Next</a></li>
            </ul>
        </span>
    </div>
</div> 
@endif

@if($module == "dash_setllement")
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Adjustment Id</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Days</th>
            </tr>
        </thead>
        <tbody id="settlementtable">
            @if(count($settlements)>0)
                @foreach($settlements as $settlement)
                <tr>
                    <td>{{++$table_count}}</td>
                    <td>{{$settlement->settlement_gid}}</td>
                    <td>{{$settlement->settlement_amount}}</td>
                    <td>{{$settlement->settlement_status}}</td>
                    <td>{{$settlement->date_diff}} days ago</td>
                </tr>
                @endforeach
            @else
            <tr>
                <td class="text-center" colspan=6>No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
            <div></div>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$settlements->firstItem()==''?'0':$settlements->firstItem()}} to {{$settlements->lastItem()==''?'0':$settlements->lastItem()}} of {{$settlements->total()}} entries</h5> 
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
@endif

@if($module == "dash_logactivities")
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
            @if(count($logactivity)>0)
                @foreach($logactivity as $log)
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
        <h5 class="pagination">Showing {{$logactivity->firstItem()==''?'0':$logactivity->firstItem()}} to {{$logactivity->lastItem()==''?'0':$logactivity->lastItem()}} of {{$logactivity->total()}} entries</h5> 
    </div>
    <div class="col-sm-6">
        <span class="pull-right">
            <ul class="pagination">
                <li><a href="{{$logactivity->previousPageUrl()}}">Previous</a></li>
                <li><a href="javascript:">{{$logactivity->currentPage()}}</a></li>
                <li><a href="{{$logactivity->nextPageUrl()}}">Next</a></li>
            </ul>
        </span>
    </div>
</div>
@endif

@if($module == "payment")
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            {{-- <tr>
                <th>Sno</th>
                <th>Payment Id</th>
                <th>Order Id</th>
                <th>Amount</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Refund</th>
                <th>Created Date</th>
                <th>Created Time</th>
                <th>Created By</th>
                <th>status</th>
            </tr> --}}
            <tr>
                <th>Sno</th>
                <th>Customer Name</th>
                <th>Mobile No</th>
                <th>Amount</th>
                <th>Email</th>
                <th>Upi Id</th>
                <th>Order Id</th>
                <th>Transaction Id </th>
                <th>Transaction status</th>
                <th>Created Date</th>
                <th>Updated Date</th>
              
                
            </tr>
        </thead>
        <tbody id="paymenttable">
        @inject('refund', 'App\Refund')
            @if(count($transactions)>0)
                @foreach($transactions as $transaction)
                   {{-- @dd($transaction) --}}
                {{-- <tr>
                    <td>{{++$table_count}}</td>
                    <td id="transactiongid"><a href="javascript:transactionDetailsView('{{$transaction->transaction_gid}}')">{{$transaction->transaction_gid}}</a></td>
                    <td>{{$transaction->order_gid}}</td>
                    <td>{{$transaction->transaction_amount}}</td>
                    <td>{{$transaction->transaction_email}}</td>
                    <td>{{$transaction->transaction_contact}}</td>
                    <td id="transactiongid1">
                        @if($refund->get_payment_refund_count($transaction->id))
                          {{'Initiated'}}
                        @elseif($transaction->transaction_status=="success")
                               
                               <a href="javascript:transactionRefund('{{$transaction->id}}')" class="btn btn-danger btn-sm">{{'Initiate'}}</a>
                        @else
                             {{'-'}}
                        @endif
                    
                    </td>
                    <td>{{ $transaction->created_date }}</td>
                    <td>{{ $transaction->created_time }}</td>
                    <td>{{$transaction->created_merchant}}</td>
                    <td>{{$transaction->transaction_status}}</td>
                </tr> --}}
                <tr>
                    <td>{{++$table_count}}</td>
                    <td>{{$transaction->customer_name}}</td>
                    <td>{{$transaction->mobile_no}}</td>
                    <td>{{$transaction->amount}}</td>
                    <td>{{$transaction->email}}</td>
                    <td>{{$transaction->upi_id}}</td>
                    <td>{{$transaction->order_id}}</td>
                    <td>{{$transaction->fpay_trxnid}}</td>
                    <td>
                        @if($transaction->txn_status=="1")
                          Pending
                        @elseif($transaction->txn_status=="2")
                          Success     
                              
                        @elseif($transaction->txn_status=="0")
                         Failed
                        @elseif($transaction->txn_status=="3")
                        Tampered
                        @endif
                    
                    </td>
                    <td>{{ $transaction->created_at }}</td>
                    <td>{{ $transaction->updated_at }}</td>
                </tr>
                @endforeach
            @else
            <tr>
                <td class="text-center" colspan=9>No Data found</td>
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

@if($module == "refund")
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Refund Id</th>
                <th>Payment Id</th>
                <th>Refund Amount</th>
                <th>Refund Status</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody id="refundtable">
            @if(count($refunds)>0)
            @foreach($refunds as $refund)
            <tr>
                <td>{{++$table_count}}</td>
                <td>{{$refund->refund_gid}}</td>
                <td>{{$refund->payment_gid}}</td>
                <td>{{$refund->refund_amount}}</td>
                <td>{{$refund->refund_status}}</td>
                <td>{{$refund->created_date}}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan=6>No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
            <div></div>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$refunds->firstItem()==''?'0':$refunds->firstItem()}} to {{$refunds->lastItem()==''?'0':$refunds->lastItem()}} of {{$refunds->total()}} entries</h5> 
    </div>
    <div class="col-sm-6">
        <span class="pull-right">
            <ul class="pagination">
                <li><a href="{{$refunds->previousPageUrl()}}">Previous</a></li>
                <li><a href="javascript:">{{$refunds->currentPage()}}</a></li>
                <li><a href="{{$refunds->nextPageUrl()}}">Next</a></li>
            </ul>
        </span>
    </div>
</div>
@endif

@if($module == "order")
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Order Id</th>
                <th>Amount</th>
                <!-- <th>Attempts</th>
                <th>Receipt</th> -->
                <th>Created Date</th>
                <th>Created Time</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody id="ordertable">
            @if(count($orders)>0)
            @foreach($orders as $order)
            <tr>
                <td>{{++$table_count}}</td>
                <td><a href="javascript:orderDetails('{{$order->id}}')">{{$order->order_gid}}</a></td>
                <td>{{$order->order_amount}}</td>
                <td>{{$order->created_date}}</td>
                <td>{{$order->created_time}}</td>
                <td>{{$order->order_status}}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan=5>No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
            <div></div>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$orders->firstItem()==''?'0':$orders->firstItem()}} to {{$orders->lastItem()==''?'0':$orders->lastItem()}} of {{$orders->total()}} entries</h5> 
    </div>
    <div class="col-sm-6">
        <span class="pull-right">
            <ul class="pagination">
                <li><a href="{{$orders->previousPageUrl()}}">Previous</a></li>
                <li><a href="javascript:">{{$orders->currentPage()}}</a></li>
                <li><a href="{{$orders->nextPageUrl()}}">Next</a></li>
            </ul>
        </span>
    </div>
</div> 
@endif
@if($module == "dispute")
@php($table_count=0)

<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Dispute Id</th>
                <th>Payment Id</th>
                <th>Dispute Amount</th>
                <th>Dispute Type</th>
                <th>Created At</th>
                <th>Dispute Status</th>
            </tr>
        </thead>
        <tbody id="disputetable">
            @if(count($disputes)>0)
            @foreach($disputes as $dispute)
            <tr>
                <td>{{++$table_count}}</td>
                <td>{{$dispute->dispute_gid}}</td>
                <td>{{$dispute->payment_gid}}</td>
                <td>{{$dispute->dispute_amount}}</td>
                <td>{{$dispute->dispute_type}}</td>
                <td>{{$dispute->created_date}}</td>
                <td>{{$dispute->dispute_status}}</td>
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
        <h5 class="pagination">Showing {{$disputes->firstItem()==''?'0':$disputes->firstItem()}} to {{$disputes->lastItem()==''?'0':$disputes->lastItem()}} of {{$disputes->total()}} entries</h5> 
    </div>
    <div class="col-sm-6">
        <span class="pull-right">
            <ul class="pagination">
                <li><a href="{{$disputes->previousPageUrl()}}">Previous</a></li>
                <li><a href="javascript:">{{$disputes->currentPage()}}</a></li>
                <li><a href="{{$disputes->nextPageUrl()}}">Next</a></li>
            </ul>
        </span>
    </div>
</div> 
@endif

@if($module == "item")
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Item Id</th>
                <th>Item Name</th>
                <th>Amount</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="itemtable">
            @if(count($items)>0)
                @foreach($items as $item)
                <tr>
                    <td>{{++$table_count}}</td>
                    <td><a href="javascript:editItem('{{$item->id}}');">{{$item->item_gid}}</a></td>
                    <td>{{$item->item_name}}</td>
                    <td>{{number_format($item->item_amount,2)}}</td>
                    <td>{{$item->created_date}}</td>
                    <td>
                        <a class="btn btn-danger btn-xs" href="javascript:deleteItem('{{$item->id}}')">Delete</a>
                    </td>
                </tr>
                @endforeach
            @else
            <tr>
                <td class="text-center" colspan=6>No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination" style="vertical-align: middle;">Showing {{$items->firstItem()==''?'0':$items->firstItem()}} to {{$items->lastItem()==''?'0':$items->lastItem()}} of{{$items->total()}} entries</h5> 
    </div>
    <div class="col-sm-6">
        <span class="pull-right">
            <ul class="pagination">
                <li><a href="{{$items->previousPageUrl()}}">Previous</a></li>
                <li><a href="javascript:">{{$items->currentPage()}}</a></li>
                <li><a href="{{$items->nextPageUrl()}}">Next</a></li>
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
                <th>Created By</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody id="paylinktable">
            @if(count($paylinks)>0)
            @foreach($paylinks as $paylink)
            <tr>
                <td>{{++$table_count}}</td>
                @if($paylink->paylink_status != 'paid')
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
                <td>{{$paylink->created_merchant}}</td>
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
                <th>Created By</th>
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
                <td>{{$quicklink->created_merchant}}</td>
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

@if($module == "invoice")
@php($table_count=0)
<div class="table-responsive">
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Sno</th>
            <th>Invoice Id</th>
            <th>Receipt</th>
            <th>Amount</th>
            <th>Customer</th>
            <th>Invoice Paylink</th>
            <th>Status</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody id="invoicetable">
        @if(count($invoices)>0)
        @foreach($invoices as $invoice)
        <tr>
            <td>{{++$table_count}}</td>
            @if($invoice->invoice_status == 'saved')
                <td>
                    <a href="/merchant/invoice/edit/{{$invoice->id}}">{{$invoice->invoice_gid}}</a>
                </td>
            @else
                <td>{{$invoice->invoice_gid}}</td>
            @endif
            <td>{{$invoice->invoice_receiptno}}</td>
            <td>{{number_format($invoice->invoice_amount,2)}}</td>
            <td>{{$invoice->customer_details}}</td>
            <td><a href="{{$invoice->invoice_paylink}}" target="_blank">{{$invoice->invoice_paylink}}</a></td>
            <td>{{$invoice->invoice_status}}</td>
            <td>{{$invoice->created_date}}</td>
        </tr>
        @endforeach
        @else
        <tr>
            <td class="text-center" colspan="8">No Data found</td>
        </tr>
        @endif
    </tbody>
    <tfoot>
        <div></div>
    </tfoot>
</table>
<div class="col-sm-6">
    <h5 class="pagination">Showing {{$invoices->firstItem()==''?'0':$invoices->firstItem()}} to {{$invoices->lastItem()==''?'0':$invoices->lastItem()}} of {{$invoices->total()}} entries</h5> 
</div>
<div class="col-sm-6">
    <span class="pull-right">
        <ul class="pagination">
            <li><a href="{{$invoices->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$invoices->currentPage()}}</a></li>
            <li><a href="{{$invoices->nextPageUrl()}}">Next</a></li>
        </ul>
    </span>
</div>
</div> 
@endif

@if($module == "customer")
@php($table_count=0)
<div class="table-responsive">
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Sno</th>
            <th>Customer Id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Status</th>
            <th>Created At</th>
            <th>Action</th> 
        </tr>
    </thead>
    <tbody id="customertable">
        @if(count($customers)>0)
            @foreach($customers as $customer)
            <tr>
                <td>{{++$table_count}}</td>
                <td><a href="javascript:editCustomer('{{$customer->id}}');">{{$customer->customer_gid}}</a></td>
                <td>{{$customer->customer_name}}</td>
                <td>{{$customer->customer_email}}</td>
                <td>{{$customer->customer_phone}}</td>
                <td>{{$customer->status}}</td>
                <td>{{$customer->created_date}}</td>
                <td>
                    <a class="btn btn-danger btn-xs" href="javascript:deleteCustomer('{{$customer->id}}')">Delete</a>
                </td>
            </tr>
            @endforeach
        @else
        <tr>
            <td class="text-center" colspan="8">No Data found</td>
        </tr>
        @endif
    </tbody>
    <tfoot>
    </tfoot>
</table>
<div class="col-sm-6">
    <h5 class="pagination">Showing {{$customers->firstItem()==''?'0':$customers->firstItem()}} to {{$customers->lastItem()==''?'0':$customers->lastItem()}} of {{$customers->total()}} entries</h5> 
</div>
<div class="col-sm-6">
    <span class="pull-right">
        <ul class="pagination">
            <li><a href="{{$customers->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$customers->currentPage()}}</a></li>
            <li><a href="{{$customers->nextPageUrl()}}">Next</a></li>
        </ul>
    </span>
</div>
</div> 
@endif

@if($module == "coupon")
@php($table_count=0)
<div class="table-responsive">
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Sno</th>
            <th>Coupon Code</th>
            <th>Discount Type</th>
            <th>Discount Info</th>
            <th>Status</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody id="coupontable">
        @if(count($coupons)>0)
            @foreach($coupons as $coupon)
            <tr>
                <td>{{++$table_count}}</td>
                @if(date('d-m-Y') <  $coupon->coupon_validto)
                <td><a href="/merchant/coupons/edit/{{$coupon->id}}">{{$coupon->coupon_gid}}</a></td>
                @else
                <td>{{$coupon->coupon_gid}}</td>
                @endif
                <td>
                    @if($coupon->coupon_type != 3)
                        @if($coupon->coupon_on == 5)
                        Discount of {{$coupon->coupon_discount}} on {{$coupon->coupon_option}} upto<br>
                        maximum discount amount of {{ $coupon->currency}} {{$coupon->coupon_maxdisc_amount}}
                        @else
                        Discount of {{$coupon->coupon_discount}} on {{$coupon->coupon_option}} {{$coupon->coupon_ordermax_amount}} upto<br>
                        maximum discount amount of {{ $coupon->currency}} {{$coupon->coupon_maxdisc_amount}}
                        @endif
                    @else
                        @if($coupon->coupon_on == 5)
                        Free Shipping on {{$coupon->coupon_option}} {{$coupon->coupon_ordermax_amount}} upto<br>
                        maximum discount amount of {{ $coupon->currency}} {{$coupon->coupon_maxdisc_amount}}
                        @else
                        Free Shipping on {{$coupon->coupon_option}} upto<br>
                        maximum discount amount of {{ $coupon->currency}} {{$coupon->coupon_maxdisc_amount}}
                        @endif
                    @endif
                </td>
                <td>
                    <ul>
                        <li>Expires On {{$coupon->coupon_validto}}</li>
                        <li>{{$coupon->coupon_maxuse}} Use Remaining</li>
                        <li>Strarts from {{$coupon->coupon_validfrom}} ends {{$coupon->coupon_validto}}</li>
                    </ul>
                </td>
                <td>{{date('d-m-Y') <  $coupon->coupon_validto ? $coupon->coupon_status:'Expired'}}</td>
                <td>{{$coupon->created_date}}</td>
            </tr>
            @endforeach
        @else
        <tr>
            <td class="text-center" colspan=6>No Data found</td>
        </tr>
        @endif
    </tbody>
    <tfoot>
    </tfoot>
</table>
<div class="col-sm-6">
    <h5 class="pagination">Showing {{$coupons->firstItem()==''?'0':$coupons->firstItem()}} to {{$coupons->lastItem()==''?'0':$coupons->lastItem()}} of {{$coupons->total()}} entries</h5> 
</div>
<div class="col-sm-6">
    <span class="pull-right">
        <ul class="pagination">
            <li><a href="{{$coupons->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$coupons->currentPage()}}</a></li>
            <li><a href="{{$coupons->nextPageUrl()}}">Next</a></li>
        </ul>
    </span>
</div>
</div>
@endif

@if($module == "notification")
@php($table_count=0)
<div class="table-responsive">
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Sno</th>
            <th>Notification</th>
            <th>Type</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody id="customertable">
        @if(count($notifications)>0)
            @foreach($notifications as $notification)
            <tr>
                <td>{{++$table_count}}</td>
                <td>{{$notification->message}}</td>
                <td>{{$notification->notify_type}}</td>
                <td>{{$notification->created_date}}</td>
            </tr>
            @endforeach
        @else
        <tr>
            <td class="text-center" colspan="4">No Data found</td>
        </tr>
        @endif
    </tbody>
    <tfoot>
    </tfoot>
</table>
<div class="col-sm-6">
    <h5 class="pagination">Showing {{$notifications->firstItem()==''?'0':$notifications->firstItem()}} to {{$notifications->lastItem()==''?'0':$notifications->lastItem()}} of {{$notifications->total()}} entries</h5> 
</div>
<div class="col-sm-6">
    <span class="pull-right">
        <ul class="pagination">
            <li><a href="{{$notifications->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$notifications->currentPage()}}</a></li>
            <li><a href="{{$notifications->nextPageUrl()}}">Next</a></li>
        </ul>
    </span>
</div>
</div> 
@endif

@if($module == "message")
@php($table_count=0)
<div class="table-responsive">
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Sno</th>
            <th>Message</th>
            <th>Type</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody id="customertable">
        @if(count($messages)>0)
            @foreach($messages as $message)
            <tr>
                <td>{{++$table_count}}</td>
                <td>{{$message->message}}</td>
                <td>{{$message->notify_type}}</td>
                <td>{{$message->created_date}}</td>
            </tr>
            @endforeach
        @else
        <tr>
            <td class="text-center" colspan="4">No Data found</td>
        </tr>
        @endif
    </tbody>
    <tfoot>
    </tfoot>
</table>
<div class="col-sm-6">
    <h5 class="pagination">Showing {{$messages->firstItem()==''?'0':$messages->firstItem()}} to {{$messages->lastItem()==''?'0':$messages->lastItem()}} of {{$messages->total()}} entries</h5> 
</div>
<div class="col-sm-6">
    <span class="pull-right">
        <ul class="pagination">
            <li><a href="{{$messages->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$messages->currentPage()}}</a></li>
            <li><a href="{{$messages->nextPageUrl()}}">Next</a></li>
        </ul>
    </span>
</div>
</div> 
@endif


@if($module == "casedetail")
@php($table_count=0)
<div class="table-responsive">
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Sno</th>
            <th>Case Id</th>
            <th>Payment Id</th>
            <th>Amount</th>
            <th>Customer Name</th>
            <th>Reason</th>
            <th>Status</th>
            <th>Case Created Date</th>
        </tr>
    </thead>
    <tbody id="customertable">
        @if(count($casedetails)>0)
            @foreach($casedetails as $casedetail)
            <tr>
                <td>{{++$table_count}}</td>
                <td><a href="{{$casedetail->merchant_url}}">{{$casedetail->case_gid}}</a></td>
                <td>{{$casedetail->transaction_gid}}</td>
                <td>{{$casedetail->transaction_amount}}</td>
                <td>{{$casedetail->customer_name}}</td>
                <td>{{$casedetail->customer_reason}}</td>
                <td>{{$casedetail->status}}</td>
                <td>{{$casedetail->created_date}}</td>
            </tr>
            @endforeach
        @else
        <tr>
            <td class="text-center" colspan="8">No Data found</td>
        </tr>
        @endif
    </tbody>
    <tfoot>
    </tfoot>
</table>
<div class="col-sm-6">
    <h5 class="pagination">Showing {{$casedetails->firstItem()==''?'0':$casedetails->firstItem()}} to {{$casedetails->lastItem()==''?'0':$casedetails->lastItem()}} of {{$casedetails->total()}} entries</h5> 
</div>
<div class="col-sm-6">
    <span class="pull-right">
        <ul class="pagination">
            <li><a href="{{$casedetails->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$casedetails->currentPage()}}</a></li>
            <li><a href="{{$casedetails->nextPageUrl()}}">Next</a></li>
        </ul>
    </span>
</div>
</div> 
@endif


@if($module == "feedbackdetail")
@php($table_count=0)
<div class="table-responsive">
<table class="table table-bordered"> 
    <thead>
        <tr>
            <th>Sno</th>
            <th>Subject</th>
            <th>Rating</th>
            <th>Description</th>
            <th>Created Date</th>
        </tr>
    </thead>
    <tbody id="feedbackbody">
        @if(count($feedbackdetails) > 0)
            @php($table_count = 0)
            @foreach($feedbackdetails as $feedbackdetail)
            <tr>
                <td>{{++$table_count}}</td>
                <td>{{$feedbackdetail->feed_subject}}</td>
                <td class="content-oveflow">@for($i=0;$i<$feedbackdetail->feed_rating;$i++)<i class="fa fa-star rating-color"></i>@endfor</td>
                <td>{{$feedbackdetail->feedback}}</td>
                <td>{{$feedbackdetail->created_date}}</td>
            </tr>
        @endforeach
        @else
        <tr>
            <td colspan=5 class="text-center">No Data</td>
        </tr>
        @endif
    </tbody>
</table>
<div class="col-sm-6">
    <h5 class="pagination">Showing {{$feedbackdetails->firstItem()==''?'0':$feedbackdetails->firstItem()}} to {{$feedbackdetails->lastItem()==''?'0':$feedbackdetails->lastItem()}} of {{$feedbackdetails->total()}} entries</h5> 
</div>
<div class="col-sm-6">
    <span class="pull-right">
        <ul class="pagination">
            <li><a href="{{$feedbackdetails->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$feedbackdetails->currentPage()}}</a></li>
            <li><a href="{{$feedbackdetails->nextPageUrl()}}">Next</a></li>
        </ul>
    </span>
</div>
</div> 
@endif


@if($module == "merchantsupport")
@php($table_count=0)
<div class="table-responsive">
<table class="table table-bordered"> 
    <thead>
        <tr>
            <th>Sno</th>
            <th>Support Id</th>
            <th>Category</th>
            <th>Title</th>
            <th>Description</th>
            <th>Status</th>
            <th>Created Date</th>
        </tr>
    </thead>
    <tbody id="supportbody">
        @if(count($merchantsupports) > 0)
            @php($table_count = 0)
            @foreach($merchantsupports as $merchantsupport)
            <tr>
                <td>{{++$table_count}}</td>
                <td>{{$merchantsupport->sup_gid}}</td>
                <td>{{$supportCategory[$merchantsupport->sup_category]}}</td>
                <td>{{$merchantsupport->title}}</td>
                <td>{{$merchantsupport->sup_description}}</td>
                <td>{{ucfirst($merchantsupport->sup_status)}}</td>
                <td>{{$merchantsupport->created_date}}</td>
            </tr>
        @endforeach
        @else
        <tr>
            <td colspan=4 class="text-center">No Data</td>
        </tr>
        @endif
    </tbody>
</table>
<div class="col-sm-6">
    <h5 class="pagination">Showing {{$merchantsupports->firstItem()==''?'0':$merchantsupports->firstItem()}} to {{$merchantsupports->lastItem()==''?'0':$merchantsupports->lastItem()}} of {{$merchantsupports->total()}} entries</h5> 
</div>
<div class="col-sm-6">
    <span class="pull-right">
        <ul class="pagination">
            <li><a href="{{$merchantsupports->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$merchantsupports->currentPage()}}</a></li>
            <li><a href="{{$merchantsupports->nextPageUrl()}}">Next</a></li>
        </ul>
    </span>
</div>
</div> 
@endif


@if($module == "product")
@php($table_count=0)
<div class="table-responsive">
<table class="table table-bordered"> 
    <thead>
        <tr>
            <th>Sno</th>
            <th>Product Id</th>
            <th>Product Title</th>
            <th>Product Price</th>
            <th>Product Description</th>
            <th>Product Status</th>
            <th>Created Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="supportbody">
        @if(count($products) > 0)
            @php($table_count = 0)
            @foreach($products as $product)
            <tr>
                <td>{{++$table_count}}</td>
                <td><a href="javascript:editProduct('{{$product->id}}')">{{$product->product_gid}}</a></td>
                <td>{{$product->product_title}}</td>
                <td>{{$product->product_price}}</td>
                <td>{{$product->product_description}}</td>
                <td>{{$product->status}}</td>
                <td>{{$product->created_date}}</td>
                <td><button class="btn btn-danger btn-sm" onclick="javascript:deleteProduct('{{$product->id}}')">Delete</button></td>
            </tr>
        @endforeach
        @else
        <tr>
            <td colspan=8 class="text-center">No Data</td>
        </tr>
        @endif
    </tbody>
</table>
<div class="col-sm-6">
    <h5 class="pagination">Showing {{$products->firstItem()==''?'0':$products->firstItem()}} to {{$products->lastItem()==''?'0':$products->lastItem()}} of {{$products->total()}} entries</h5> 
</div>
<div class="col-sm-6">
    <span class="pull-right">
        <ul class="pagination">
            <li><a href="{{$products->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$products->currentPage()}}</a></li>
            <li><a href="{{$products->nextPageUrl()}}">Next</a></li>
        </ul>
    </span>
</div>
</div> 
@endif

@if($module == "pagedetail")
@php($table_count=0)
<div class="table-responsive">
<table class="table table-bordered"> 
    <thead>
        <tr>
            <th>Sno</th>
            <th>Page Id</th>
            <th>Page Title</th>
            <th>Page Link</th>
            <th>Page Status</th>
            <th>Created Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="supportbody">
        @if(count($pagedetails) > 0)
            @php($table_count = 0)
            @foreach($pagedetails as $pagedetail)
            <tr>
                <td>{{++$table_count}}</td>
                <td><a href="{{route('edit-payment-page',$pagedetail->id)}}">{{$pagedetail->page_gid}}</a></td>
                <td>{{$pagedetail->page_title}}</td>
                @if(Auth::user()->app_mode)
                    <td><a href="{{ route('payment-page',$pagedetail->page_url)}}" target="_blank">{{ route('payment-page',$pagedetail->page_url)}}</a></td>
                @else
                <td><a href="{{ route('test-payment-page',$pagedetail->page_url)}}" target="_blank">{{ route('test-payment-page',$pagedetail->page_url)}}</a></td>
                @endif
                <td><div id="page-status-{{$pagedetail->id}}">{{$pagedetail->page_status}}</div></td>
                <td>{{$pagedetail->created_date}}</td>
                <td><button class="btn btn-danger btn-sm" id="button_{{$pagedetail->id}}" onclick="makePageInactive('{{$pagedetail->id}}')">{{$pagedetail->change_status}}</button></td>
            </tr>
        @endforeach
        @else
        <tr>
            <td colspan="7" class="text-center">No Data</td>
        </tr>
        @endif
    </tbody>
</table>
<div class="col-sm-6">
    <h5 class="pagination">Showing {{$pagedetails->firstItem()==''?'0':$pagedetails->firstItem()}} to {{$pagedetails->lastItem()==''?'0':$pagedetails->lastItem()}} of {{$pagedetails->total()}} entries</h5> 
</div>
<div class="col-sm-6">
    <span class="pull-right">
        <ul class="pagination">
            <li><a href="{{$pagedetails->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$pagedetails->currentPage()}}</a></li>
            <li><a href="{{$pagedetails->nextPageUrl()}}">Next</a></li>
        </ul>
    </span>
</div>
</div> 
@endif


@if($module == "employee")
@php($table_count=0)
<div class="table-responsive">
<table class="table table-bordered"> 
    <thead>
        <tr>
            <th>Sno</th>
            <th>Employee Username</th>
            <th>Employee Name</th>
            <th>Employee Email</th>
            <th>Employee Mobile</th>
            <th>Employee Type</th>
            <th>Employee Status</th>
            <th>Account Locked</th>
            <th>Created Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="supportbody">
        @if(count($employees) > 0)
            @php($table_count = 0)
            @foreach($employees as $employee)
            <tr>
                <td>{{++$table_count}}</td>
                <td><a href="{{route('edit-employee',$employee->id)}}">{{$employee->employee_gid}}</a></td>
                <td>{{$employee->employee_name}}</td>
                <td>{{$employee->employee_email}}</td>
                <td>{{$employee->employee_mobile}}</td>
                <td>{{$employee->employee_type}}</td>
                <td>{{$employee->employee_status}}</td>
                <td>{{$employee->is_account_locked == 'Y'?'Yes':'No'}}</td>
                <td>{{$employee->created_date}}</td>
                <td>
               
                    <a href="javascript:void(0)" class="btn btn-primary btn-sm" data-html="true"   data-toggle="popover" data-placement="top" 
                    data-content='<a class="btn btn-link" onclick=updateEmpStatus("{{$employee->id}}","{{$employee->employee_status}}")>Change Status</a><br>
                    <a onclick=changeEmpPassword("{{$employee->id}}") class="btn btn-link">Change Password</a><br>
                    <a onclick=unlockAccount("{{$employee->id}}") class="btn btn-link">Unlock Account</a><a onclick=empPermission("{{$employee->employee_gid}}") class="btn btn-link">Permissions</a>' tabindex="0" data-trigger="focus"><i class="fa fa-cogs"></i>&nbsp;Actions
                </a>
                    
                </td>
            </tr>
        @endforeach
        @else
        <tr>
            <td colspan="10" class="text-center">No Data</td>
        </tr>
        @endif
    </tbody>
</table>
<div class="col-sm-6">
    <h5 class="pagination">Showing {{$employees->firstItem()==''?'0':$employees->firstItem()}} to {{$employees->lastItem()==''?'0':$employees->lastItem()}} of {{$employees->total()}} entries</h5> 
</div>
<div class="col-sm-6">
    <span class="pull-right">
        <ul class="pagination">
            <li><a href="{{$employees->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$employees->currentPage()}}</a></li>
            <li><a href="{{$employees->nextPageUrl()}}">Next</a></li>
        </ul>
    </span>
</div>
</div> 
@endif