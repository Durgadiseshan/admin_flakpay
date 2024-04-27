@php
use App\Http\Controllers\EmployeeController;
use App\RyapayaSupOrderInv;
use App\RyapaySupExpInv;
use App\RyapaySupCDNote;
use App\RyapayCustOrderInv;
use App\RyapayaCustCDNote;

$supcategorylist = EmployeeController::support_category();
$merchant_status = EmployeeController::merchant_status();
$sales_status = EmployeeController::sales_status();
$decimal_length = 2;
$item_options = EmployeeController::porder_items_options();

@endphp

@if($module == "hrm")
@if(isset($employees))

<table class="table table-bordered">
    <thead>
        <th>Sno</th>
        <th>User Name</th>
        <th>Name</th>
        <th>Designation</th>
        <th>Official Email</th>
        <th>Mobile No</th>
        <th>Department</th>
        <th>Status</th>
        <th>created_date</th>
        @if(auth()->guard('employee')->user()->user_type == '1')
        <th>Action</th>
        @endif
    </thead>
    <tbody>
        @if(count($employees) > 0)
        @foreach($employees as $index=>$employee)
        <tr>
            <td>{{$index+1}}</td>
            <td><a href="{{ route('edit.employee',$employee->id)}}">{{$employee->employee_username}}</a></td>
            <td>{{$employee->full_name}}</td>
            <td>{{$employee->designation}}</td>
            <td>{{$employee->official_email}}</td>
            <td>{{$employee->mobile_no}}</td>
            <td>{{$employee->department_name}}</td>
            <td>{{$employee->employee_status}}</td>
            <td>{{$employee->created_date}}</td>
            @if(auth()->guard('employee')->user()->user_type == '1')
            <td><a href="/flakpay/hrm/employee-accesses/{{$employee->id}}" class="btn btn-primary btn-sm">Access</a>
            <a href="javascript:deleteEmployee('{{$employee->id}}','{{urlencode($employee->full_name)}}')" class="btn btn-danger btn-sm">Delete</a>
        </td>
          
            @endif
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="10" class="text-center"></td>
        </tr>
        @endif
    </tbody>
</table>
@endif
@endif
@if($module == "accountchart")
@if(isset($accountcharts))
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Account Code</th>
                <th>Description</th>
                <th>Currency</th>
                <th>Account Group</th>
                <th>Main Grouping</th>
                <th>Note no</th>
                <th>Note Description</th>
                <th>Created Date</th>
            </tr>
        </thead>
        <tbody>
            @if(count($accountcharts)>0)
            @foreach($accountcharts as $account_chart)
            <tr>
                <td>{{++$table_count}}</td>
                <td>{{$account_chart->account_code}}</td>
                <td>{{$account_chart->description}}</td>
                <td>{{$account_chart->currency}}</td>
                <td>{{$account_chart->account_group}}</td>
                <td>{{$account_chart->main_grouping}}</td>
                <td>{{$account_chart->note_no}}</td>
                <td>{{$account_chart->note_description}}</td>
                <td>{{$account_chart->created_date}}</td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$accountcharts->firstItem()==''?'0':$accountcharts->firstItem()}} to {{$accountcharts->lastItem() =='' ? '0':$accountcharts->lastItem()}} of {{$accountcharts->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$accountcharts->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$accountcharts->currentPage()}}</a></li>
            <li><a href="{{$accountcharts->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif

@if($module == "invoice")
@if(isset($invoices))
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
                    <a href="{{route('edit-invoice',$invoice->id)}}">{{$invoice->invoice_gid}}</a>
                </td>
                @else
                <td>{{$invoice->invoice_gid}}</td>
                @endif
                <td>{{$invoice->invoice_receiptno}}</td>
                <td>{{$invoice->invoice_amount}}</td>
                <td>{{$invoice->customer_details}}</td>
                <td><a href="">{{$invoice->invoice_paylink}}</a></td>
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
        <h5 class="pagination">Showing {{$invoices->firstItem()==''?'0':$invoices->firstItem()}} to {{$invoices->lastItem() =='' ? '0':$invoices->lastItem()}} of {{$invoices->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$invoices->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$invoices->currentPage()}}</a></li>
            <li><a href="{{$invoices->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif

@if($module == "item")
@if(isset($items))
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
                <td>{{number_format($item->item_amount,$decimal_length)}}</td>
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
        <h5 class="pagination">Showing {{$items->firstItem()==''?'0':$items->firstItem()}} to {{$items->lastItem() =='' ? '0':$items->lastItem()}} of {{$items->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$items->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$items->currentPage()}}</a></li>
            <li><a href="{{$items->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif

@if($module == "customer")
@if(isset($customers))
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
                <td class="text-center" colspan=8>No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$customers->firstItem()==''?'0':$customers->firstItem()}} to {{$customers->lastItem() =='' ? '0':$customers->lastItem()}} of {{$customers->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$customers->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$customers->currentPage()}}</a></li>
            <li><a href="{{$customers->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif

@if($module =="merchantsupport")
@if(isset($merchantsupports))
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Ticket Id</th>
                <th>Title</th>
                <th>Description</th>
                <th>Status</th>
                <th>Merchant Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Created Date</th>
            </tr>
        </thead>
        <tbody id="merchantsupporttable">
            @if(count($merchantsupports)>0)

            @foreach($merchantsupports as $merchantsupport)
            <tr>
                <td>{{++$table_count}}</td>
                <td>{{$merchantsupport->sup_gid}}</td>
                <td>{{$merchantsupport->title}}</td>
                <td>{{$merchantsupport->sup_description}}</td>
                <td>{{$merchantsupport->sup_status}}</td>
                <td>{{$merchantsupport->merchant_gid}}</td>
                <td>{{$merchantsupport->name}}</td>
                <td>{{$merchantsupport->email}}</td>
                <td>{{$merchantsupport->mobile_no}}</td>
                <td>{{$merchantsupport->created_date}}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan=10>No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$merchantsupports->firstItem()==''?'0':$merchantsupports->firstItem()}} to {{$merchantsupports->lastItem() =='' ? '0':$merchantsupports->lastItem()}} of {{$merchantsupports->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$merchantsupports->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$merchantsupports->currentPage()}}</a></li>
            <li><a href="{{$merchantsupports->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif

@if($module == "merchantlist")
@if(isset($merchantlists))
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Merchant Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Mode</th>
                <th>Pancard</th>
                <th>Aadhar Card</th>
                <th>Bank Statement</th>
                <th>Company Registration</th>
            </tr>
        </thead>
        <tbody id="merchantlisttable">
            @if(count($merchantlists)>0)

            @foreach($merchantlists as $merchantlist)
            <tr>
                <td>{{++$table_count}}</td>
                <td>{{$merchantlist->merchant_gid}}</td>
                <td>{{$merchantlist->name}}</td>
                <td>{{$merchantlist->email}}</td>
                <td>{{$merchantlist->mobile_no}}</td>
                <td>{{$merchantlist->app_mode}}</td>
                <td>{{$merchantlist->pan_card}}</td>
                <td>{{$merchantlist->aadhar_card}}</td>
                <td>{{$merchantlist->bank_statement}}</td>
                <td>{{$merchantlist->company_registration}}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan=10>No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$merchantlists->firstItem()==''?'0':$merchantlists->firstItem()}} to {{$merchantlists->lastItem() =='' ? '0':$merchantlists->lastItem()}} of {{$merchantlists->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$merchantlists->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$merchantlists->currentPage()}}</a></li>
            <li><a href="{{$merchantlists->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif

@if($module == "merchantcallsupport")
@if(isset($merchantcallsupports))
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Category</th>
                <th>Title</th>
                <th>Next Call</th>
                <th>Status</th>
                <th>Merchant Id</th>
                <th>Mobile</th>
                <th>Email</th>
                <th>Created Date</th>
            </tr>
        </thead>
        <tbody id="merchantcallsupporttable">
            @if(count($merchantcallsupports)>0)

            @foreach($merchantcallsupports as $merchantcallsupport)
            <tr>
                <td>{{++$table_count}}</td>
                <td>{{$supcategorylist[$merchantcallsupport->sup_category]}}</td>
                <td>{{$merchantcallsupport->sup_title}}</td>
                <td>{{$merchantcallsupport->next_call}}</td>
                <td>{{$merchantcallsupport->sup_status}}</td>
                <td>{{$merchantcallsupport->merchant_id}}</td>
                <td>{{$merchantcallsupport->merchant_mobile}}</td>
                <td>{{$merchantcallsupport->marchant_email}}</td>
                <td>{{$merchantcallsupport->created_date}}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan=10>No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$merchantcallsupports->firstItem()==''?'0':$merchantcallsupports->firstItem()}} to {{$merchantcallsupports->lastItem() =='' ? '0':$merchantcallsupports->lastItem()}} of {{$merchantcallsupports->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$merchantcallsupports->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$merchantcallsupports->currentPage()}}</a></li>
            <li><a href="{{$merchantcallsupports->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif

@if($module == "leadsaleslist")
@if(isset($leadsaleslists))
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                @if(auth()->guard("employee")->user()->user_type == "1" || auth()->guard("employee")->user()->user_type == "15")
                <th>
                    <div class="checkbox">
                        <label>
                            <strong>Select All</strong>
                            <input type="checkbox" class="form-control" onclick="selectAllLeads(this);">
                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                        </label>
                    </div>
                </th>
                @endif
                <th>Merchant Name</th>
                <th>Merchant Mobile</th>
                <th>Merchant Email</th>
                <th>Looking For</th>
                <th>Company Name</th>
                <th>Remark</th>
                <th>Created Date</th>
            </tr>
        </thead>
        <tbody id="leadsaleslisttable">
            @if(count($leadsaleslists)>0)
            @foreach($leadsaleslists as $leadsaleslist)
            <tr>
                <td>{{++$table_count}}</td>
                @if(auth()->guard("employee")->user()->user_type == "1" || auth()->guard("employee")->user()->user_type == "15")
                <td>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" class="form-control" name="id[]" value="{{$leadsaleslist->id}}">
                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                        </label>
                    </div>
                </td>
                @endif
                <td><a href="javascript:" onclick="editLeadSale('{{$leadsaleslist->id}}');">{{$leadsaleslist->merchant_name}}</a></td>
                <td>{{$leadsaleslist->merchant_mobile}}</td>
                <td>{{$leadsaleslist->merchant_email}}</td>
                <td>{{$leadsaleslist->service_name}}</td>
                <td>{{$leadsaleslist->company_name}}</td>
                <td>{{$leadsaleslist->remark}}</td>
                <td>{{$leadsaleslist->created_date}}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan=8>No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$leadsaleslists->firstItem()==''?'0':$leadsaleslists->firstItem()}} to {{$leadsaleslists->lastItem() =='' ? '0':$leadsaleslists->lastItem()}} of {{$leadsaleslists->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$leadsaleslists->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$leadsaleslists->currentPage()}}</a></li>
            <li><a href="{{$leadsaleslists->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif

@if($module == "dailysaleslist")
@if(isset($dailysaleslists))
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Merchant Name</th>
                <th>Merchant Mobile</th>
                <th>Merchant Email</th>
                <th>Company Name</th>
                <th>Status</th>
                <th>Next Call</th>
                <th>Created Date</th>
            </tr>
        </thead>
        <tbody id="dailysaleslisttable">
            @if(count($dailysaleslists)>0)

            @foreach($dailysaleslists as $dailysaleslist)
            <tr>
                <td>{{++$table_count}}</td>
                <td><a href="javascript:" onclick="editDailySale('{{$dailysaleslist->id}}');">{{$dailysaleslist->merchant_name}}</a></td>
                <td>{{$dailysaleslist->merchant_mobile}}</td>
                <td>{{$dailysaleslist->merchant_email}}</td>
                <td>{{$dailysaleslist->company_name}}</td>
                <td>{{$sales_status[$dailysaleslist->sale_status]}}</td>
                <td>{{$dailysaleslist->next_call}}</td>
                <td>{{$dailysaleslist->created_date}}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan=8>No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$dailysaleslists->firstItem()==''?'0':$dailysaleslists->firstItem()}} to {{$dailysaleslists->lastItem() =='' ? '0':$dailysaleslists->lastItem()}} of {{$dailysaleslists->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$dailysaleslists->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$dailysaleslists->currentPage()}}</a></li>
            <li><a href="{{$dailysaleslists->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif

@if($module == "saleslist")
@if(isset($saleslists))
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Merchant Name</th>
                <th>Merchant Mobile</th>
                <th>Merchant Email</th>
                <th>Service Name</th>
                <th>Company Name</th>
                <th>Status</th>
                <th>Next Call</th>
                <th>Created Date</th>
            </tr>
        </thead>
        <tbody id="saleslisttable">
            @if(count($saleslists)>0)

            @foreach($saleslists as $saleslist)
            <tr>
                <td>{{++$table_count}}</td>
                <td><a href="javascript:" onclick="editSale('{{$saleslist->id}}');">{{$saleslist->merchant_name}}</a></td>
                <td>{{$saleslist->merchant_mobile}}</td>
                <td>{{$saleslist->merchant_email}}</td>
                <td>{{$saleslist->service_name}}</td>
                <td>{{$saleslist->company_name}}</td>
                <td>{{$sales_status[$saleslist->sale_status]}}</td>
                <td>{{$saleslist->next_call}}</td>
                <td>{{$saleslist->created_date}}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan=8>No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$saleslists->firstItem()==''?'0':$saleslists->firstItem()}} to {{$saleslists->lastItem() =='' ? '0':$saleslists->lastItem()}} of {{$saleslists->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$saleslists->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$saleslists->currentPage()}}</a></li>
            <li><a href="{{$saleslists->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif



@if($module == "fieldleadlist")
@if(isset($fieldleadlists))
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Merchant Gid</th>
                <th>Business Name</th>
                <th>Merchant Name</th>
                <th>No Of Transaction</th>
                <th>Transaction Amount</th>
            </tr>
        </thead>
        <tbody id="fieldleadlisttable">
            @if(count($fieldleadlists)>0)
          
            @foreach($fieldleadlists as $fieldleadlist)
            <tr>
                <td>{{++$table_count}}</td>
                <td><a href="javascript:void(0)" onclick="getTransactionBreakUp('{{$fieldleadlist->id}}');"> {{$fieldleadlist->merchant_gid}}</a></td>
                <td>{{$fieldleadlist->business_name}}</td>
                <td>{{$fieldleadlist->name}}</td>
                <td>{{$fieldleadlist->no_of_transactions}}</td>
                <td>{{$fieldleadlist->transaction_amount}}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan=7>No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$fieldleadlists->firstItem()==''?'0':$fieldleadlists->firstItem()}} to {{$fieldleadlists->lastItem() =='' ? '0':$fieldleadlists->lastItem()}} of {{$fieldleadlists->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$fieldleadlists->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$fieldleadlists->currentPage()}}</a></li>
            <li><a href="{{$fieldleadlists->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif


@if($module == "fielddailylist")
@if(isset($fielddailylists))
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Merchant Name</th>
                <th>Merchant Mobile</th>
                <th>Merchant Email</th>
                <th>Service Name</th>
                <th>Company Name</th>
                <th>Visited Day</th>
                <th>Sale Status</th>
                <th>Merchant Status</th>
                <th>Next Call</th>
                <th>Created Date</th>
            </tr>
        </thead>
        <tbody id="fielddailylisttable">
            @if(count($fielddailylists)>0)

            @foreach($fielddailylists as $fielddailylist)
            <tr>
                <td>{{++$table_count}}</td>
                <td><a href="javascript:" onclick="editFieldSale('{{$fielddailylist->id}}')">{{$fielddailylist->merchant_name}}</a> </td>
                <td>{{$fielddailylist->merchant_mobile}}</td>
                <td>{{$fielddailylist->merchant_email}}</td>
                <td>{{$fielddailylist->service_name}}</td>
                <td>{{$fielddailylist->company_name}}</td>
                <td>{{$fielddailylist->visited}}</td>
                <td>{{$sales_status[$fielddailylist->sale_status]}}</td>
                <td>{{$merchant_status[$fielddailylist->merchant_status]}}</td>
                <td>{{$fielddailylist->next_call}}</td>
                <td>{{$fielddailylist->created_date}}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan=10>No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$fielddailylists->firstItem()==''?'0':$fielddailylists->firstItem()}} to {{$fielddailylists->lastItem() =='' ? '0':$fielddailylists->lastItem()}} of {{$fielddailylists->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$fielddailylists->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$fielddailylists->currentPage()}}</a></li>
            <li><a href="{{$fielddailylists->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif

@if($module == "fieldsaleslist")
@if(isset($fieldsaleslists))
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Merchant Name</th>
                <th>Merchant Mobile</th>
                <th>Merchant Email</th>
                <th>Service Name</th>
                <th>Company Name</th>
                <th>Visited Day</th>
                <th>Sale Status</th>
                <th>Merchant Status</th>
                <th>Next Call</th>
                <th>Created Date</th>
            </tr>
        </thead>
        <tbody id="fieldsaleslisttable">
            @if(count($fieldsaleslists)>0)

            @foreach($fieldsaleslists as $fieldsaleslist)
            <tr>
                <td>{{++$table_count}}</td>
                <td><a href="javascript:" onclick="editFieldSale('{{$fieldsaleslist->id}}')">{{$fieldsaleslist->merchant_name}}</a> </td>
                <td>{{$fieldsaleslist->merchant_mobile}}</td>
                <td>{{$fieldsaleslist->merchant_email}}</td>
                <td>{{$fieldsaleslist->service_name}}</td>
                <td>{{$fieldsaleslist->company_name}}</td>
                <td>{{$fieldsaleslist->visited}}</td>
                <td>{{$sales_status[$fieldsaleslist->sale_status]}}</td>
                <td>{{$merchant_status[$fieldsaleslist->merchant_status]}}</td>
                <td>{{$fieldsaleslist->next_call}}</td>
                <td>{{$fieldsaleslist->created_date}}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan=10>No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$fieldsaleslists->firstItem()==''?'0':$fieldsaleslists->firstItem()}} to {{$fieldsaleslists->lastItem() =='' ? '0':$fieldsaleslists->lastItem()}} of {{$fieldsaleslists->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$fieldsaleslists->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$fieldsaleslists->currentPage()}}</a></li>
            <li><a href="{{$fieldsaleslists->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif

@if($module == "paysliplist")
@if(isset($paysliplists))
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Employee Name</th>
                <th>Month</th>
                <th>Earnings</th>
                <th>Deductions</th>
                <th>Net</th>
                <th>Created Date</th>
            </tr>
        </thead>
        <tbody id="paysliplisttable">
            @if(count($paysliplists)>0)

            @foreach($paysliplists as $paysliplist)
            <tr>
                <td>{{++$table_count}}</td>
                <td><a href="{{route('edit-payslip',$paysliplist->id)}}">{{$paysliplist->full_name}}</a> </td>
                <td>{{$paysliplist->payslip_month}}</td>
                <td>{{$paysliplist->total_addition}}</td>
                <td>{{$paysliplist->total_deduction}}</td>
                <td>{{$paysliplist->net_salary}}</td>
                <td>{{$paysliplist->created_date}}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan=7>No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$paysliplists->firstItem()==''?'0':$paysliplists->firstItem()}} to {{$paysliplists->lastItem() =='' ? '0':$paysliplists->lastItem()}} of {{$paysliplists->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$paysliplists->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$paysliplists->currentPage()}}</a></li>
            <li><a href="{{$paysliplists->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif


@if($module == "nooftransaction")
@if(isset($nooftransactions))
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Merchant Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>No Of Transactions</th>
            </tr>
        </thead>
        <tbody id="nooftransactiontable">
            @if(count($nooftransactions)>0)

            @foreach($nooftransactions as $nooftransaction)
            <tr>
                <td>{{++$table_count}}</td>
                <td>{{$nooftransaction->customer_name}}</a> </td>
                <td>{{$nooftransaction->email}}</td>
                <td>{{$nooftransaction->mobile_no}}</td>
                <td>{{$nooftransaction->merchant_count}}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan=5>No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$nooftransactions->firstItem()==''?'0':$nooftransactions->firstItem()}} to {{$nooftransactions->lastItem() =='' ? '0':$nooftransactions->lastItem()}} of {{$nooftransactions->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$nooftransactions->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$nooftransactions->currentPage()}}</a></li>
            <li><a href="{{$nooftransactions->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif

@if($module == "transactionamount")
@if(isset($transactionamounts))
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Merchant Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Transaction Amount</th>
            </tr>
        </thead>
        <tbody id="transactionamounttable">
            @if(count($transactionamounts)>0)

            @foreach($transactionamounts as $transactionamount)
            <tr>
                <td>{{++$table_count}}</td>
                <td>{{$transactionamount->customer_name}}</td>
                <td>{{$transactionamount->email}}</td>
                <td>{{$transactionamount->mobile_no}}</td>
                <td>{{number_format($transactionamount->merchant_sum)}}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan=5>No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$transactionamounts->firstItem()==''?'0':$transactionamounts->firstItem()}} to {{$transactionamounts->lastItem() =='' ? '0':$transactionamounts->lastItem()}} of {{$transactionamounts->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$transactionamounts->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$transactionamounts->currentPage()}}</a></li>
            <li><a href="{{$transactionamounts->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif

@if($module == "merchant")
@if(isset($merchants))
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Merchant Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Status</th>
                <th>Created Date</th>
                <th>Last Login</th>
            </tr>
        </thead>
        <tbody id="merchanttable">
            @if(count($merchants)>0)

            @foreach($merchants as $merchant)
            <tr>
                <td>{{++$table_count}}</td>
                <td>{{$merchant->name}}</a> </td>
                <td>{{$merchant->email}}</td>
                <td>{{$merchant->mobile_no}}</td>
                <td>{{$merchant->merchant_status}}</td>
                <td>{{$merchant->created_date}}</td>
                <td>{{$merchant->last_seen_at}}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan=7>No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$merchants->firstItem()==''?'0':$merchants->firstItem()}} to {{$merchants->lastItem() =='' ? '0':$merchants->lastItem()}} of {{$merchants->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$merchants->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$merchants->currentPage()}}</a></li>
            <li><a href="{{$merchants->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif

@if($module == "case")
@if(isset($cases))
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Case Id</th>
                <th>Transaction Id</th>
                <th>Amount</th>
                <th>Customer Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Merchant</th>
                <th>Status</th>
                <th>Created Date</th>
            </tr>
        </thead>
        <tbody id="casetable">
            @if(count($cases)>0)

            @foreach($cases as $case)
            <tr>
                <td>{{++$table_count}}</td>
                <td>{{$case->case_gid}}</a> </td>
                <td>{{$case->transaction_gid}}</td>
                <td>{{$case->transaction_amount}}</td>
                <td>{{$case->customer_name}}</td>
                <td>{{$case->customer_email}}</td>
                <td>{{$case->customer_mobile}}</td>
                <td>{{$case->name}}</td>
                <td>{{$case->status}}</td>
                <td>{{$case->created_date}}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan=10>No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$cases->firstItem()==''?'0':$cases->firstItem()}} to {{$cases->lastItem() =='' ? '0':$cases->lastItem()}} of {{$cases->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$cases->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$cases->currentPage()}}</a></li>
            <li><a href="{{$cases->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif

@if($module == "adjustment")
@if(isset($adjustments))
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>adjustment Id</th>
                <th>Amount</th>
                <th>Fee</th>
                <th>Tax</th>
                <th>Created Date</th>
            </tr>
        </thead>
        <tbody id="adjustmenttable">
            @if(count($adjustments)>0)

            @foreach($adjustments as $adjustment)
            <tr>
                <td>{{++$table_count}}</td>
                <td>{{$adjustment->settlement_gid}}</a> </td>
                <td>{{$adjustment->settlement_amount}}</td>
                <td>{{$adjustment->settlement_fee}}</td>
                <td>{{$adjustment->settlement_tax}}</td>
                <td>{{$adjustment->created_date}}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan=5>No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    {{$adjustments->links()}}
</div>
@endif
@endif

@if($module == "loginactivity")
@if(isset($loginactivities))
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Ip Address</th>
                <th>Devices</th>
                <th>OS</th>
                <th>Browser</th>
                <th>login At</th>
            </tr>
        </thead>
        <tbody id="loginactivitytable">
            @if(count($loginactivities)>0)

            @foreach($loginactivities as $loginactivity)
            <tr>
                <td>{{++$table_count}}</td>
                <td>{{$loginactivity->log_ipaddress}}</a> </td>
                <td>{{$loginactivity->log_device}}</td>
                <td>{{$loginactivity->log_os}}</td>
                <td>{{$loginactivity->log_browser}}</td>
                <td>{{$loginactivity->log_time}}</td>
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
        <h5 class="pagination">Showing {{$loginactivities->firstItem()==''?'0':$loginactivities->firstItem()}} to {{$loginactivities->lastItem() =='' ? '0':$loginactivities->lastItem()}} of {{$loginactivities->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$loginactivities->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$loginactivities->currentPage()}}</a></li>
            <li><a href="{{$loginactivities->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif

@if($module == "lockedmerchant")
@if(isset($lockedmerchants))
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Merchant Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Status</th>
                <th>Created Date</th>
                <th>Last Login</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="lockedmerchanttable">
            @if(count($lockedmerchants)>0)

            @foreach($lockedmerchants as $lockedmerchant)
            <tr>
                <td>{{++$table_count}}</td>
                <td>{{$lockedmerchant->name}}</a> </td>
                <td>{{$lockedmerchant->email}}</td>
                <td>{{$lockedmerchant->mobile_no}}</td>
                <td>{{$lockedmerchant->merchant_status}}</td>
                <td>{{$lockedmerchant->created_date}}</td>
                <td>{{$lockedmerchant->last_seen_at}}</td>
                <td><a href="javascript:void(0)" class="btn btn-sm btn-success" onclick="unlockMerchantAccount('{{$lockedmerchant->id}}');">Unlock</a></td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan=8>No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$lockedmerchants->firstItem()==''?'0':$lockedmerchants->firstItem()}} to {{$lockedmerchants->lastItem() =='' ? '0':$lockedmerchants->lastItem()}} of {{$lockedmerchants->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$lockedmerchants->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$lockedmerchants->currentPage()}}</a></li>
            <li><a href="{{$lockedmerchants->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif

@if($module == "noofpaylink")
@if(isset($noofpaylinks))
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Merchant Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>No Of Paylinks</th>
            </tr>
        </thead>
        <tbody id="noofpaylinktable">
            @if(count($noofpaylinks)>0)

            @foreach($noofpaylinks as $noofpaylink)
            <tr>
                <td>{{++$table_count}}</td>
                <td>{{$noofpaylink->name}}</a> </td>
                <td>{{$noofpaylink->email}}</td>
                <td>{{$noofpaylink->mobile_no}}</td>
                <td>{{$noofpaylink->no_of_paylinks}}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan=5>No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$noofpaylinks->firstItem()==''?'0':$noofpaylinks->firstItem()}} to {{$noofpaylinks->lastItem() =='' ? '0':$noofpaylinks->lastItem()}} of {{$noofpaylinks->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$noofpaylinks->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$noofpaylinks->currentPage()}}</a></li>
            <li><a href="{{$noofpaylinks->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif

@if($module == "noofinvoice")
@if(isset($noofinvoices))
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Merchant Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>No Of Invoices</th>
            </tr>
        </thead>
        <tbody id="noofinvoicetable">
            @if(count($noofinvoices)>0)

            @foreach($noofinvoices as $noofinvoice)
            <tr>
                <td>{{++$table_count}}</td>
                <td>{{$noofinvoice->name}}</a> </td>
                <td>{{$noofinvoice->email}}</td>
                <td>{{$noofinvoice->mobile_no}}</td>
                <td>{{$noofinvoice->no_of_invoices}}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan=5>No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$noofinvoices->firstItem()==''?'0':$noofinvoices->firstItem()}} to {{$noofinvoices->lastItem() =='' ? '0':$noofinvoices->lastItem()}} of {{$noofinvoices->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$noofinvoices->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$noofinvoices->currentPage()}}</a></li>
            <li><a href="{{$noofinvoices->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif

@if($module == "blogpost")
@if(isset($blogposts))
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Title</th>
                <th>Created Date</th>
                <th>Created User</th>
            </tr>
        </thead>
        <tbody id="blogpoststable">
            @if(count($blogposts)>0)
            @foreach($blogposts as $blogpost)
            <tr>
                <td>{{++$table_count}}</td>
                <td><a href="javascript:" onclick="editPost('{{$blogpost->id}}')">{{$blogpost->title}}</a></a> </td>
                <td>{{$blogpost->created_date}}</td>
                <td>{{$blogpost->created_user}}</td>
                <td><a href="javascript:" onclick="callRemovePostModel('{{$blogpost->id}}')" class="btn btn-sm btn-danger">Delete</a></td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan=4>No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$blogposts->firstItem()==''?'0':$blogposts->firstItem()}} to {{$blogposts->lastItem() =='' ? '0':$blogposts->lastItem()}} of {{$blogposts->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$blogposts->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$blogposts->currentPage()}}</a></li>
            <li><a href="{{$blogposts->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif

@if($module == "csrpost")
@if(isset($csrposts))
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Title</th>
                <th>Created Date</th>
                <th>Created User</th>
            </tr>
        </thead>
        <tbody id="csrpoststable">
            @if(count($csrposts)>0)
            @foreach($csrposts as $csrpost)
            <tr>
                <td>{{++$table_count}}</td>
                <td><a href="javascript:" onclick="editCSRPost('{{$csrpost->id}}')">{{$csrpost->title}}</a></a> </td>
                <td>{{$csrpost->created_date}}</td>
                <td>{{$csrpost->created_user}}</td>
                <td><a href="javascript:" onclick="callRemoveCSRPostModel('{{$csrpost->id}}')" class="btn btn-sm btn-danger">Delete</a></td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan=4>No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$csrposts->firstItem()==''?'0':$csrposts->firstItem()}} to {{$csrposts->lastItem() =='' ? '0':$csrposts->lastItem()}} of {{$csrposts->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$csrposts->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$csrposts->currentPage()}}</a></li>
            <li><a href="{{$csrposts->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif

@if($module == "prpost")
@if(isset($prposts))
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Title</th>
                <th>Created Date</th>
                <th>Created User</th>
            </tr>
        </thead>
        <tbody id="prpoststable">
            @if(count($prposts)>0)
            @foreach($prposts as $prpost)
            <tr>
                <td>{{++$table_count}}</td>
                <td><a href="javascript:" onclick="editPRPost('{{$prpost->id}}')">{{$prpost->title}}</a></a> </td>
                <td>{{$prpost->created_date}}</td>
                <td>{{$prpost->created_user}}</td>
                <td><a href="javascript:" onclick="callRemovePRPostModel('{{$prpost->id}}')" class="btn btn-sm btn-danger">Delete</a></td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan=4>No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$prposts->firstItem()==''?'0':$prposts->firstItem()}} to {{$prposts->lastItem() =='' ? '0':$prposts->lastItem()}} of {{$prposts->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$prposts->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$prposts->currentPage()}}</a></li>
            <li><a href="{{$prposts->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif

@if($module == "eventpost")
@if(isset($eventposts))
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Name</th>
                <th>Type</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
                <th>Created Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="eventpoststable">
            @if(count($eventposts)>0)
            @foreach($eventposts as $eventpost)
            <tr>
                <td>{{++$table_count}}</td>
                <td><a href="javascript:" onclick="editEventPost('{{$eventpost->id}}')">{{$eventpost->event_name}}</a></a> </td>
                <td>{{ucfirst($eventpost->event_register)}}</td>
                <td>{{$eventpost->event_date}}</td>
                <td>{{$eventpost->event_time}}</td>
                <td>{{$eventpost->event_status}}</td>
                <td>{{$eventpost->created_date}}</td>
                <td><a href="javascript:" onclick="callRemoveEventPostModel('{{$eventpost->id}}')" class="btn btn-sm btn-danger">Delete</a></td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan="7">No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$eventposts->firstItem()==''?'0':$eventposts->firstItem()}} to {{$eventposts->lastItem() =='' ? '0':$eventposts->lastItem()}} of {{$eventposts->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$eventposts->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$eventposts->currentPage()}}</a></li>
            <li><a href="{{$eventposts->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif



@if($module == "asset")
@if(isset($assets))
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Asset Id</th>
                <th>Asset Name</th>
                <th>Account Code</th>
                <th>Asset Amount</th>
                <th>Remark</th>
                <th>Created Date</th>
            </tr>
        </thead>
        <tbody id="assetstable">
            @if(count($assets)>0)
            @foreach($assets as $asset)
            <tr>
                <td>{{++$table_count}}</td>
                <td><a href="javascript:" onclick="editAsset('{{$asset->id}}')">{{$asset->asset_gid}}</a></a> </td>
                <td>{{$asset->asset_name}}</td>
                <td>{{$asset->account_code}}</td>
                <td>{{number_format($asset->asset_amount,$decimal_length)}}</td>
                <td class="show-ellipsis">{{$asset->remark}}</td>
                <td>{{$asset->created_date}}</td>
                <!-- <td><a href="javascript:" onclick="editPost('{{$asset->id}}')"></a>
                            <button type="button" class="btn btn-sm btn-danger">Delete</button>
                        </td> -->
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan="7">No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$assets->firstItem()==''?'0':$assets->firstItem()}} to {{$assets->lastItem() =='' ? '0':$assets->lastItem()}} of {{$assets->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$assets->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$assets->currentPage()}}</a></li>
            <li><a href="{{$assets->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif

@if($module == "capitalasset")
@if(isset($capitalassets))
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Asset Id</th>
                <th>Asset Name</th>
                <th>Account Code</th>
                <th>Asset Capital Amount</th>
                <th>Remark</th>
                <th>Created Date</th>
            </tr>
        </thead>
        <tbody id="capitalassetstable">
            @if(count($capitalassets)>0)
            @foreach($capitalassets as $capitalasset)
            <tr>
                <td>{{++$table_count}}</td>
                <td><a href="javascript:" onclick="editCapitalasset('{{$capitalasset->id}}')">{{$capitalasset->asset_gid}}</a></a> </td>
                <td>{{$capitalasset->asset_name}}</td>
                <td>{{$capitalasset->account_code}}</td>
                <td>{{number_format($capitalasset->asset_capital_amount,$decimal_length)}}</td>
                <td class="show-ellipsis">{{$capitalasset->remark}}</td>
                <td>{{$capitalasset->created_date}}</td>
                <!-- <td><a href="javascript:" onclick="editPost('{{$capitalasset->id}}')"></a>
                            <button type="button" class="btn btn-sm btn-danger">Delete</button>
                        </td> -->
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan="7">No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$capitalassets->firstItem()==''?'0':$capitalassets->firstItem()}} to {{$capitalassets->lastItem() =='' ? '0':$capitalassets->lastItem()}} of {{$capitalassets->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$capitalassets->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$capitalassets->currentPage()}}</a></li>
            <li><a href="{{$capitalassets->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif
@if($module == "depreciateasset")
@if(isset($depreciateassets))
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Asset Id</th>
                <th>Asset Name</th>
                <th>Account Code</th>
                <th>Depreciate Amount</th>
                <th>Remark</th>
                <th>Created Date</th>
            </tr>
        </thead>
        <tbody id="depreciateassetstable">
            @if(count($depreciateassets)>0)
            @foreach($depreciateassets as $depreciateasset)
            <tr>
                <td>{{++$table_count}}</td>
                <td><a href="javascript:" onclick="editDepreciate('{{$depreciateasset->id}}')">{{$depreciateasset->asset_gid}}</a></a> </td>
                <td>{{$depreciateasset->asset_name}}</td>
                <td>{{$depreciateasset->account_code}}</td>
                <td>{{number_format($depreciateasset->asset_depre_amount,$decimal_length)}}</td>
                <td class="show-ellipsis">{{$depreciateasset->remark}}</td>
                <td>{{$depreciateasset->created_date}}</td>
                <!-- <td><a href="javascript:" onclick="editPost('{{$depreciateasset->id}}')"></a>
                            <button type="button" class="btn btn-sm btn-danger">Delete</button>
                        </td> -->
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan="7">No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$depreciateassets->firstItem()==''?'0':$depreciateassets->firstItem()}} to {{$depreciateassets->lastItem() =='' ? '0':$depreciateassets->lastItem()}} of {{$depreciateassets->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$depreciateassets->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$depreciateassets->currentPage()}}</a></li>
            <li><a href="{{$depreciateassets->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif

@if($module == "saleasset")
@if(isset($saleassets))
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Asset Id</th>
                <th>Asset Name</th>
                <th>Account Code</th>
                <th>Sale Amount</th>
                <th>Remark</th>
                <th>Created Date</th>
            </tr>
        </thead>
        <tbody id="saleassetstable">
            @if(count($saleassets)>0)
            @foreach($saleassets as $saleasset)
            <tr>
                <td>{{++$table_count}}</td>
                <td><a href="javascript:" onclick="editSale('{{$saleasset->id}}')">{{$saleasset->asset_gid}}</a></a> </td>
                <td>{{$saleasset->asset_name}}</td>
                <td>{{$saleasset->account_code}}</td>
                <td>{{number_format($saleasset->asset_sale_amount,$decimal_length)}}</td>
                <td class="show-ellipsis">{{$saleasset->remark}}</td>
                <td>{{$saleasset->created_date}}</td>
                <!-- <td><a href="javascript:" onclick="editPost('{{$saleasset->id}}')"></a>
                            <button type="button" class="btn btn-sm btn-danger">Delete</button>
                        </td> -->
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan="7">No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$saleassets->firstItem()==''?'0':$saleassets->firstItem()}} to {{$saleassets->lastItem() =='' ? '0':$saleassets->lastItem()}} of {{$saleassets->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$saleassets->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$saleassets->currentPage()}}</a></li>
            <li><a href="{{$saleassets->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif

@if($module == "voucher")
@if(isset($vouchers))
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Voucher No</th>
                <th>Debit Account Code</th>
                <th>Debit Amount</th>
                <th>Credit Account Code</th>
                <th>Credit Amount</th>
                <th>Voucher Total</th>
                <th>Created Date</th>
            </tr>
        </thead>
        <tbody id="voucherstable">
            @if(count($vouchers)>0)
            @foreach($vouchers as $voucher)
            <tr>
                <td>{{++$table_count}}</td>
                <td><a href="javascript:" onclick="editVoucher('{{$voucher->id}}')">{{$voucher->voucher_no == ''?'voucherid':$voucher->voucher_no}}</a></a> </td>
                <td>{{$voucher->debit_account_code}}</td>
                <td>{{number_format($voucher->debit_amount,$decimal_length)}}</td>
                <td>{{$voucher->credit_account_code}}</td>
                <td>{{number_format($voucher->credit_amount,$decimal_length)}}</td>
                <td>{{number_format($voucher->voucher_total,$decimal_length)}}</td>
                <td>{{$voucher->created_date}}</td>
                <!-- <td><a href="javascript:" onclick="editPost('{{$voucher->id}}')"></a>
                            <button type="button" class="btn btn-sm btn-danger">Delete</button>
                        </td> -->
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
        <h5 class="pagination">Showing {{$vouchers->firstItem()==''?'0':$vouchers->firstItem()}} to {{$vouchers->lastItem() =='' ? '0':$vouchers->lastItem()}} of {{$vouchers->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$vouchers->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$vouchers->currentPage()}}</a></li>
            <li><a href="{{$vouchers->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif

@if($module == "supplier")
@if(isset($suppliers))
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>supplier Id</th>
                <th>Company Name</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="suppliertable">
            @if(count($suppliers)>0)
            @foreach($suppliers as $supplier)
            <tr>
                <td>{{++$table_count}}</td>
                <td><a href="javascript:editSupplier('{{$supplier->id}}');">{{$supplier->supplier_gid}}</a></td>
                <td>{{$supplier->supplier_company}}</td>
                <td>{{$supplier->supplier_name}}</td>
                <td>{{$supplier->supplier_email}}</td>
                <td>{{$supplier->supplier_phone}}</td>
                <td>{{$supplier->status}}</td>
                <td>{{$supplier->created_date}}</td>
                <td>
                    <a class="btn btn-danger btn-xs" href="javascript:deleteSupplier('{{$supplier->id}}')">Delete</a>
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan="9">No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$suppliers->firstItem()==''?'0':$suppliers->firstItem()}} to {{$suppliers->lastItem() =='' ? '0':$suppliers->lastItem()}} of {{$suppliers->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$suppliers->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$suppliers->currentPage()}}</a></li>
            <li><a href="{{$suppliers->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif

@if($module == "porder")
@if(isset($porders))
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>P-Order No</th>
                <th>Total</th>
                <th>Due Date</th>
                <th>Company Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Created At</th>
                <!-- <th>Action</th> -->
            </tr>
        </thead>
        <tbody id="pordertable">
            @if(count($porders)>0)
            @foreach($porders as $porder)
            <tr>
                <td>{{++$table_count}}</td>
                <td><a href="{{route('edit-purchase-order',$porder->id)}}">{{empty($porder->porder_no)?'purchaseId':$porder->porder_no}}</a></td>
                <td>{{$porder->porder_total}}</td>
                <td>{{$porder->porder_due}}</td>
                <td>{{$porder->supplier_company}}</td>
                <td>{{$porder->supplier_email}}</td>
                <td>{{$porder->supplier_phone}}</td>
                <td>{{$porder->porder_status}}</td>
                <td>{{$porder->created_date}}</td>
                <!-- <td>
                            <a class="btn btn-danger btn-xs" href="javascript:deleteporder('{{$porder->id}}')">Delete</a>
                        </td> -->
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan="9">No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$porders->firstItem()==''?'0':$porders->firstItem()}} to {{$porders->lastItem() =='' ? '0':$porders->lastItem()}} of {{$porders->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$porders->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$porders->currentPage()}}</a></li>
            <li><a href="{{$porders->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif

@if($module == "ryapay_adjustment")
@if(isset($ryapay_adjustments))
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th></th>
                <th>Sno</th>
                <th>Merchant Transaction Id</th>
                <th>Transaction Amount</th>
                <th>Bank Name</th>
                <th>Transaction Method</th>
                <th>Adjustment on transaction</th>
                <th>Adjustment charge</th>
                <th>GST on adjustment</th>
                <th>GST charge</th>
                <th>Total charge</th>
                <th>Adjustment Amount</th>
                <th>Adjustment Status</th>
                <th>Adjustment Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="ryapay_adjustmenttable">
            @if(count($ryapay_adjustments)>0)

            @foreach($ryapay_adjustments as $ryapay_adjustment)
            <tr>
                <td>
                    <div class="checkbox"><label><input type="checkbox" name="id[]" id="id" value="{{$ryapay_adjustment->id}}" class="form-control" onclick="getBulkAdjsutmentIds(this)" {{($ryapay_adjustment->adjustment_status=="processed")?'disabled':''}}> <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                        </label></div>
                </td>
                <td>{{++$table_count}}</td>
                <td>{{$ryapay_adjustment->merchant_traxn_id}}</a> </td>
                <td>{{number_format($ryapay_adjustment->traxn_amount,$decimal_length)}}</td>
                <td>{{$ryapay_adjustment->bankname}}</td>
                <td>{{$ryapay_adjustment->merchant_traxn_method}}</td>
                <td>{{$ryapay_adjustment->adjustment_charges_per}}%</td>
                <td>{{$ryapay_adjustment->adjustment_charges}}</a> </td>
                <td>{{$ryapay_adjustment->adjustment_gst_per}}%</td>
                <td>{{$ryapay_adjustment->adjustment_gst}}</td>
                <td>{{$ryapay_adjustment->total_charge}}</td>
                <td>{{$ryapay_adjustment->adjustment_amount}}</td>
                <td>{{$ryapay_adjustment->adjustment_status}}</td>
                <td>{{$ryapay_adjustment->created_date}}</td>
                <td><a href="javascript:void(0)" onclick="merchantAdjustment('{{$ryapay_adjustment->id}}','{{$ryapay_adjustment->merchant_id}}')" class="btn btn-success btn-sm text-center">Proceed <br>to<br> merchant</button></td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan=14>No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$ryapay_adjustments->firstItem()==''?'0':$ryapay_adjustments->firstItem()}} to {{$ryapay_adjustments->lastItem() =='' ? '0':$ryapay_adjustments->lastItem()}} of {{$ryapay_adjustments->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$ryapay_adjustments->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$ryapay_adjustments->currentPage()}}</a></li>
            <li><a href="{{$ryapay_adjustments->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif

@if($module == "taxsettlement")
@if(isset($taxsettlements))
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Tax Type</th>
                <th>Tax Settlement no</th>
                <th>Date From</th>
                <th>Date To</th>
                <th>Debit Account Code</th>
                <th>Credit Account Code</th>
                <th>Tax Total</th>
                <th>Created Date</th>
            </tr>
        </thead>
        <tbody id="taxsettlementtable">
            @if(count($taxsettlements)>0)
            @foreach($taxsettlements as $taxsettlement)
            <tr>
                <td>{{++$table_count}}</td>
                <td><a href="javascript:void(0)" onclick="editTaxSettlement('{{$taxsettlement->id}}')">{{$taxsettlement->tax_type}}</a></td>
                <td>{{$taxsettlement->tax_settlement_no}}</td>
                <td>{{$taxsettlement->tax_date_from}}</td>
                <td>{{$taxsettlement->tax_date_to}}</td>
                <td>{{$taxsettlement->debitcode}}</td>
                <td>{{$taxsettlement->creditcode}}</td>
                <td>{{$taxsettlement->tax_total}}</td>
                <td>{{$taxsettlement->created_date}}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan=9>No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$taxsettlements->firstItem()==''?'0':$taxsettlements->firstItem()}} to {{$taxsettlements->lastItem() =='' ? '0':$taxsettlements->lastItem()}} of {{$taxsettlements->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$taxsettlements->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$taxsettlements->currentPage()}}</a></li>
            <li><a href="{{$taxsettlements->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif

@if($module == "taxadjustment")
@if(isset($taxadjustments))
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Tax Type</th>
                <th>Tax Adjustment no</th>
                <th>Adjustment Date</th>
                <th>Debit Account Code</th>
                <th>Credit Account Code</th>
                <th>Tax Total</th>
                <th>Created Date</th>
            </tr>
        </thead>
        <tbody id="taxadjustmenttable">
            @if(count($taxadjustments)>0)

            @foreach($taxadjustments as $taxadjustment)
            <tr>
                <td>{{++$table_count}}</td>
                <td><a href="javascript:void(0)" onclick="editTaxSettlement('{{$taxadjustment->id}}')">{{$taxadjustment->tax_type}}</a> </td>
                <td>{{$taxadjustment->tax_adjustment_no}}</td>
                <td>{{$taxadjustment->adjustment_date}}</td>
                <td>{{$taxadjustment->debitcode}}</td>
                <td>{{$taxadjustment->creditcode}}</td>
                <td>{{$taxadjustment->tax_total}}</td>
                <td>{{$taxadjustment->created_date}}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan=8>No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$taxadjustments->firstItem()==''?'0':$taxadjustments->firstItem()}} to {{$taxadjustments->lastItem() =='' ? '0':$taxadjustments->lastItem()}} of {{$taxadjustments->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$taxadjustments->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$taxadjustments->currentPage()}}</a></li>
            <li><a href="{{$taxadjustments->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif


@if($module == "taxpayment")
@if(isset($taxpayments))
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Tax Type</th>
                <th>Tax Payment No</th>
                <th>Payment Date</th>
                <th>Debit Account Code</th>
                <th>Credit Account Code</th>
                <th>Tax Total</th>
                <th>Created Date</th>
            </tr>
        </thead>
        <tbody id="taxpaymenttable">
            @if(count($taxpayments)>0)

            @foreach($taxpayments as $taxpayment)
            <tr>
                <td>{{++$table_count}}</td>
                <td><a href="javascript:void(0)" onclick="editTaxSettlement('{{$taxpayment->id}}')">{{$taxpayment->tax_type}}</a> </td>
                <td>{{$taxpayment->tax_payment_no}}</td>
                <td>{{$taxpayment->tax_payment_date}}</td>
                <td>{{$taxpayment->debitcode}}</td>
                <td>{{$taxpayment->creditcode}}</a> </td>
                <td>{{$taxpayment->tax_total}}</td>
                <td>{{$taxpayment->created_date}}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan=8>No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$taxpayments->firstItem()==''?'0':$taxpayments->firstItem()}} to {{$taxpayments->lastItem() =='' ? '0':$taxpayments->lastItem()}} of {{$taxpayments->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$taxpayments->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$taxpayments->currentPage()}}</a></li>
            <li><a href="{{$taxpayments->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif

@if($module == "adjustment_report")
@if(isset($adjustment_reports))
@php($table_count=0)
<div id="adjustment-report-ajax-error-response" class="text-center text-danger padding-10">{{$error_message}}</div>
<div id="adjustment-report-ajax-success-response" class="text-center text-success padding-10">{{$success_message}}</div>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Transaction Type</th>
                <th>Basic Amount</th>
                <th>Charge on Basic Amount</th>
                <th>Charges</th>
                <th>GST on Charges</th>
                <th>GST Amount</th>
                <th>Total Amount Charged (Charges + GST Amt)</th>
            </tr>
        </thead>
        <tbody id="adjustment_reporttable">
            @if(count($adjustment_reports)>0)

            @foreach($adjustment_reports as $index => $adjustment_report)
            <tr>
                <td>{{++$table_count}}</td>
                <td>{{$adjustment_report["transaction_mode"]}}</td>
                <td><input type="text" name="basic_amount" id="basic_amount" class="form-control" value="{{$adjustment_report['basic_amount']}}"></td>
                <td>{{$adjustment_report["charges_per"]}}</td>
                <td>{{$adjustment_report["charges_on_basic"]}}</td>
                <td>{{$adjustment_report["gst_per"]}}</td>
                <td>{{$adjustment_report["gst_on_charges"]}}</td>
                <td>{{$adjustment_report["total_amt_charged"]}}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan=8>No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
</div>
@endif
@endif

@if($module == "porder_item")
@foreach($porder_items as $index => $item)
<tr id="supord_item_row_{{$index+1}}" data-row="{{$index+1}}">
    <td>{{$index+1}}</td>
    <td>
        <div class="form-group">
            <div class="col-sm-12">
                <select name="item_id[]" id="suporder_item_name_{{$index+1}}" class="form-control" onchange="setSupOrderItemPrice('{{$index+1}}',this);">
                    @foreach($item_options as $options)
                    @if($options->id == $item->item_id)
                    <option value="{{$options->id}}" selected>{{$options->item_name}}</option>
                    @else
                    <option value="{{$options->id}}">{{$options->item_name}}</option>
                    @endif
                    @endforeach
                </select>
                <div id="supporder_item_name_error_{{$index+1}}"></div>
            </div>
        </div>
    </td>
    <td>
        <div class="form-group">
            <div class="col-sm-12">
                <input type="text" name="item_amount[]" id="suporder_item_price_{{$index+1}}" class="form-control" value="{{$item->item_amount}}">
            </div>
        </div>
    </td>
    <td>
        <div class="form-group">
            <div class="col-sm-12">
                <input type="number" name="item_quantity[]" id="suporder_item_qty_{{$index+1}}" class="form-control" min="1" onchange="loadSuporderItemtotal();" value="{{$item->item_quantity}}">
            </div>
        </div>
    </td>
    <td>
        <div class="form-group">
            <div class="col-sm-12">
                <input type="text" name="item_total[]" id="suporder_item_total_{{$index+1}}" class="form-control" value="{{$item->item_total}}">
            </div>
        </div>
    </td>
    <td>
        <div class="form-group">
            <div class="col-sm-12">
                <i class="fa fa-times fa-lg text-danger show-pointer" id="suporder_item_remove_{{$index+1}}" onclick="supordRemoveItem('{{$index+1}}')"></i>
            </div>
        </div>
    </td>
</tr>
@endforeach
@endif

@if($module == "suporder")
@if(isset($suporders))
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Purchase Order No</th>
                <th>Company Name</th>
                <th>Supplier Name</th>
                <th>Supplier Email</th>
                <th>Due Date</th>
                <th>Inv Total</th>
                <th>Status</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody id="supordertable">
            @if(count($suporders)>0)
            @foreach($suporders as $suporder)
            <tr>
                <td>{{++$table_count}}</td>
                <td><a href="{{route('edit-suporder-invoice',$suporder->id)}}">{{$suporder->porder_no}}</a></td>
                <td>{{$suporder->company}}</td>
                <td>{{$suporder->supname}}</td>
                <td>{{$suporder->email}}</td>
                <td>{{$suporder->suporder_due}}</td>
                <td>{{$suporder->suporder_total}}</td>
                <td>{{$suporder->suporder_status}}</td>
                <td>{{$suporder->created_date}}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan="9">No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$suporders->firstItem()==''?'0':$suporders->firstItem()}} to {{$suporders->lastItem() =='' ? '0':$suporders->lastItem()}} of {{$suporders->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$suporders->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$suporders->currentPage()}}</a></li>
            <li><a href="{{$suporders->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif

@if($module == "supexp")
@if(isset($supexps))
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Invoice No</th>
                <th>Company Name</th>
                <th>Supplier Name</th>
                <th>Supplier Email</th>
                <th>Due Date</th>
                <th>Inv Total</th>
                <th>Status</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody id="supexptable">
            @if(count($supexps)>0)
            @foreach($supexps as $supexp)
            <tr>
                <td>{{++$table_count}}</td>
                <td><a href="{{route('edit-supexp-invoice',$supexp->id)}}">{{$supexp->supexp_invno}}</a></td>
                <td>{{$supexp->company}}</td>
                <td>{{$supexp->supname}}</td>
                <td>{{$supexp->email}}</td>
                <td>{{$supexp->supexp_due}}</td>
                <td>{{$supexp->supexp_total}}</td>
                <td>{{$supexp->supexp_status}}</td>
                <td>{{$supexp->created_date}}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan="9">No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$supexps->firstItem()==''?'0':$supexps->firstItem()}} to {{$supexps->lastItem() =='' ? '0':$supexps->lastItem()}} of {{$supexps->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$supexps->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$supexps->currentPage()}}</a></li>
            <li><a href="{{$supexps->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif

@if($module == "supnote")
@if(isset($supnotes))
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Note No</th>
                <th>Company Name</th>
                <th>Supplier Name</th>
                <th>Supplier Email</th>
                <th>Due Date</th>
                <th>Note Amount</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody id="supnotetable">
            @if(count($supnotes)>0)
            @foreach($supnotes as $supnote)
            <tr>
                <td>{{++$table_count}}</td>
                <td><a href="{{route('edit-supcd-note',$supnote->id)}}">{{$supnote->note_number}}</a></td>
                <td>{{$supnote->company}}</td>
                <td>{{$supnote->supname}}</td>
                <td>{{$supnote->email}}</td>
                <td>{{$supnote->note_due}}</td>
                <td>{{$supnote->note_amount}}</td>
                <td>{{$supnote->created_date}}</td>
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
        <h5 class="pagination">Showing {{$supnotes->firstItem()==''?'0':$supnotes->firstItem()}} to {{$supnotes->lastItem() =='' ? '0':$supnotes->lastItem()}} of {{$supnotes->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$supnotes->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$supnotes->currentPage()}}</a></li>
            <li><a href="{{$supnotes->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif

@if($module == "custnote")
@if(isset($custnotes))
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Note No</th>
                <th>Customer Name</th>
                <th>Customer Email</th>
                <th>Due Date</th>
                <th>Note Amount</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody id="custnotetable">
            @if(count($custnotes)>0)
            @foreach($custnotes as $custnote)
            <tr>
                <td>{{++$table_count}}</td>
                <td><a href="{{route('edit-custcd-note',$custnote->id)}}">{{$custnote->note_number}}</a></td>
                <td>{{$custnote->customer_name}}</td>
                <td>{{$custnote->customer_email}}</td>
                <td>{{$custnote->note_due}}</td>
                <td>{{$custnote->note_amount}}</td>
                <td>{{$custnote->created_date}}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan="7">No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$custnotes->firstItem()==''?'0':$custnotes->firstItem()}} to {{$custnotes->lastItem() =='' ? '0':$custnotes->lastItem()}} of {{$custnotes->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$custnotes->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$custnotes->currentPage()}}</a></li>
            <li><a href="{{$custnotes->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif

@if($module == "sorder")
@if(isset($sorders))
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>S-Order No</th>
                <th>Total</th>
                <th>Due Date</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Created At</th>
                <!-- <th>Action</th> -->
            </tr>
        </thead>
        <tbody id="sordertable">
            @if(count($sorders)>0)
            @foreach($sorders as $sorder)
            <tr>
                <td>{{++$table_count}}</td>
                <td><a href="{{route('edit-sales-order',$sorder->id)}}">{{empty($sorder->sorder_no)?'salesorderId':$sorder->sorder_no}}</a></td>
                <td>{{$sorder->sorder_total}}</td>
                <td>{{$sorder->sorder_due}}</td>
                <td>{{$sorder->customer_email}}</td>
                <td>{{$sorder->customer_phone}}</td>
                <td>{{$sorder->sorder_status}}</td>
                <td>{{$sorder->created_date}}</td>
                <!-- <td>
                            <a class="btn btn-danger btn-xs" href="javascript:deletesorder('{{$sorder->id}}')">Delete</a>
                        </td> -->
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
        <h5 class="pagination">Showing {{$sorders->firstItem()==''?'0':$sorders->firstItem()}} to {{$sorders->lastItem() =='' ? '0':$sorders->lastItem()}} of {{$sorders->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$sorders->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$sorders->currentPage()}}</a></li>
            <li><a href="{{$sorders->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif

@if($module == "custorder")
@if(isset($custorders))
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Sales Order No</th>
                <th>Customer Name</th>
                <th>Customer Email</th>
                <th>Due Date</th>
                <th>Inv Total</th>
                <th>Status</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody id="custordertable">
            @if(count($custorders)>0)
            @foreach($custorders as $custorder)
            <tr>
                <td>{{++$table_count}}</td>
                <td><a href="{{route('edit-custorder-invoice',$custorder->id)}}">{{$custorder->sorder_no}}</a></td>
                <td>{{$custorder->customer_name}}</td>
                <td>{{$custorder->customer_email}}</td>
                <td>{{$custorder->custorder_due}}</td>
                <td>{{$custorder->custorder_total}}</td>
                <td>{{$custorder->custorder_status}}</td>
                <td>{{$custorder->created_date}}</td>
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
        <h5 class="pagination">Showing {{$custorders->firstItem()==''?'0':$custorders->firstItem()}} to {{$custorders->lastItem() =='' ? '0':$custorders->lastItem()}} of {{$custorders->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$custorders->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$custorders->currentPage()}}</a></li>
            <li><a href="{{$custorders->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif

@if($module == "sorder_item")
@foreach($sorder_items as $index => $item)
<tr id="custord_item_row_{{$index+1}}" data-row="{{$index+1}}">
    <td>{{$index+1}}</td>
    <td>
        <div class="form-group">
            <div class="col-sm-12">
                <select name="item_id[]" id="custorder_item_name_{{$index+1}}" class="form-control" onchange="setCustOrderItemPrice('{{$index+1}}',this);">
                    @foreach($item_options as $options)
                    @if($options->id == $item->item_id)
                    <option value="{{$options->id}}" selected>{{$options->item_name}}</option>
                    @else
                    <option value="{{$options->id}}">{{$options->item_name}}</option>
                    @endif
                    @endforeach
                </select>
                <div id="custorder_item_name_error_{{$index+1}}"></div>
            </div>
        </div>
    </td>
    <td>
        <div class="form-group">
            <div class="col-sm-12">
                <input type="text" name="item_amount[]" id="custorder_item_price_{{$index+1}}" class="form-control" value="{{$item->item_amount}}">
            </div>
        </div>
    </td>
    <td>
        <div class="form-group">
            <div class="col-sm-12">
                <input type="number" name="item_quantity[]" id="custorder_item_qty_{{$index+1}}" class="form-control" min="1" onchange="loadCustorderItemtotal();" value="{{$item->item_quantity}}">
            </div>
        </div>
    </td>
    <td>
        <div class="form-group">
            <div class="col-sm-12">
                <input type="text" name="item_total[]" id="custorder_item_total_{{$index+1}}" class="form-control" value="{{$item->item_total}}">
            </div>
        </div>
    </td>
    <td>
        <div class="form-group">
            <div class="col-sm-12">
                <i class="fa fa-times fa-lg text-danger show-pointer" id="custorder_item_remove_{{$index+1}}" onclick="custordRemoveItem('{{$index+1}}')"></i>
            </div>
        </div>
    </td>
</tr>
@endforeach
@endif

@if($module == "bginfo")
@if(isset($bginfos))
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Merchant Name</th>
                <th>Email</th>
                <th>Tele Verification</th>
                <th>Company Type</th>
                <th>Website Exists</th>
                <th>Ban Product</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody id="bginfotable">
            @if(count($bginfos)>0)
            @foreach($bginfos as $bginfo)
            <tr>
                <td>{{++$table_count}}</td>
                <td><a href="{{route('edit-verify-merchant',$bginfo->id)}}">{{$bginfo->name}}</a></td>
                <td>{{$bginfo->email}}</td>
                <td>{{$bginfo->tele_verify}}</td>
                <td>{{$bginfo->type_name}}</td>
                <td>{{$bginfo->website_exists}}</td>
                <td>{{$bginfo->ban_product}}</td>
                <td>{{$bginfo->created_date}}</td>
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
        <h5 class="pagination">Showing {{$bginfos->firstItem()==''?'0':$bginfos->firstItem()}} to {{$bginfos->lastItem() =='' ? '0':$bginfos->lastItem()}} of {{$bginfos->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$bginfos->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$bginfos->currentPage()}}</a></li>
            <li><a href="{{$bginfos->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif


@if($module == "document")
@if(isset($documents))
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr class="merchant-table">
                <th>Sno</th>
                <th>Merchant Id</th>
                <th>Name</th>
                <th>Company Name</th>
                <th>Company Type</th>
                <th>Status</th>
                <th>Created Date</th>
                <th>Verify status</th>
            </tr>
        </thead>  
        <tbody id="bginfotable">
            @if(count($documents)>0)
            @foreach($documents as $document)
            <tr>
                <td>{{++$table_count}}</td>
                <td><a href="javascript:void(0)" onclick="verifyMerchantDoc('{{$document->merchant_id}}');">{{$document->merchant_gid}}</a></td>
                <td>{{$document->name}}</td>
                <td>{{$document->business_name}}</td>
                <td>{{$document->type_name}}</td>
                <td class="status-td">{{$document->verified_status}}</td> 
                <td>{{$document->merchant_created_date}}</td>
                @if($document->verified_status == "pending")
                <td class="btn-same"><a href="{{route('new-merchant-doc',$document->merchant_id)}}" class="btn btn-primary btn-sm">Verify</a></td>
                @elseif($document->verified_status == "correction")
                <td class="btn-same"><a href="javascript:void(0);" class="btn btn-info btn-sm">Under Correction</a></td>
                @else
                <td class="btn-same"><a href="/flakpay/risk-complaince/merchant-document/view/{{$document->merchant_id}}" class="btn btn-success btn-sm">Success</a></td>
                @endif
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan="7">No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$documents->firstItem()==''?'0':$documents->firstItem()}} to {{$documents->lastItem() =='' ? '0':$documents->lastItem()}} of {{$documents->total()}} entries</h5>
    </div>
     <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{ $documents->previousPageUrl() }}">Previous</a></li>
            <li><a href="{{ $documents->currentPage() ? $documents->url($documents->currentPage()) : 'javascript:' }}">{{ $documents->currentPage() }}</a></li>
            <li><a href="{{ $documents->nextPageUrl() }}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif

@if($module == "custcase")
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
            @if(count($custcases)>0)
            @foreach($custcases as $custcase)
            <tr>
                <td>{{++$table_count}}</td>
                <td><a href="{{route('get-case-details',$custcase->rupayapay_caseid)}}">{{$custcase->case_gid}}</a></td>
                <td>{{$custcase->transaction_gid}}</td>
                <td>{{$custcase->transaction_amount}}</td>
                <td>{{$custcase->customer_name}}</td>
                <td>{{$custcase->customer_reason}}</td>
                <td>{{$custcase->status}}</td>
                <td>{{$custcase->created_date}}</td>
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
        <h5 class="pagination">Showing {{$custcases->firstItem()==''?'0':$custcases->firstItem()}} to {{$custcases->lastItem()==''?'0':$custcases->lastItem()}} of {{$custcases->total()}} entries</h5>
    </div>
    <div class="col-sm-6">
        <span class="pull-right">
            <ul class="pagination">
                <li><a href="{{$custcases->previousPageUrl()}}">Previous</a></li>
                <li><a href="javascript:">{{$custcases->currentPage()}}</a></li>
                <li><a href="{{$custcases->nextPageUrl()}}">Next</a></li>
            </ul>
        </span>
    </div>
</div>
@endif

@if($module == "bank")
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Bank Name</th>
                <th>Bank Account No</th>
                <th>Created Date</th>
            </tr>
        </thead>
        <tbody id="customertable">
            @if(count($banks)>0)
            @foreach($banks as $bank)
            <tr>
                <td>{{++$table_count}}</td>
                <td><a href="javascript:void(0)" onclick="editBankInfo('{{$bank->id}}');">{{$bank->bank_name}}</a></td>
                <td>{{$bank->bank_accno}}</td>
                <td>{{$bank->created_date}}</td>
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
        <h5 class="pagination">Showing {{$banks->firstItem()==''?'0':$banks->firstItem()}} to {{$banks->lastItem()==''?'0':$banks->lastItem()}} of {{$banks->total()}} entries</h5>
    </div>
    <div class="col-sm-6">
        <span class="pull-right">
            <ul class="pagination">
                <li><a href="{{$banks->previousPageUrl()}}">Previous</a></li>
                <li><a href="javascript:">{{$banks->currentPage()}}</a></li>
                <li><a href="{{$banks->nextPageUrl()}}">Next</a></li>
            </ul>
        </span>
    </div>
</div>
@endif

@if($module == "contra")
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Contra No</th>
                <th>Pay Date</th>
                <th>Debit Bank</th>
                <th>Credit Bank</th>
                <th>Paymode</th>
                <th>Pay Amount</th>
                <th>Created Date</th>
            </tr>
        </thead>
        <tbody id="customertable">
            @if(count($contras)>0)
            @foreach($contras as $contra)
            <tr>
                <td>{{++$table_count}}</td>
                <td><a href="{{route('contra-entry-edit',$contra->id)}}">{{$contra->contra_no}}</a></td>
                <td>{{$contra->contra_date}}</td>
                <td>{{$contra->dbank_name}}</td>
                <td>{{$contra->cbank_name}}</td>
                <td>{{$contra->option_value}}</td>
                <td>{{$contra->payment_amount}}</td>
                <td>{{$contra->created_date}}</td>
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
        <h5 class="pagination">Showing {{$contras->firstItem()==''?'0':$contras->firstItem()}} to {{$contras->lastItem()==''?'0':$contras->lastItem()}} of {{$contras->total()}} entries</h5>
    </div>
    <div class="col-sm-6">
        <span class="pull-right">
            <ul class="pagination">
                <li><a href="{{$contras->previousPageUrl()}}">Previous</a></li>
                <li><a href="javascript:">{{$contras->currentPage()}}</a></li>
                <li><a href="{{$contras->nextPageUrl()}}">Next</a></li>
            </ul>
        </span>
    </div>
</div>
@endif

@if($module == "suppaybatch")
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Batch No</th>
                <th>Pay Batch Date</th>
                <th>Supplier Name</th>
                <th>Invoice Type</th>
                <th>Invoice No</th>
                <th>Bank</th>
                <th>Paymode</th>
                <th>Created Date</th>
            </tr>
        </thead>
        <tbody id="customertable">
            @if(count($suppaybatches)>0)
            @foreach($suppaybatches as $suppaybatch)
            <tr>
                <td>{{++$table_count}}</td>
                <td><a href="{{route('supp-paybatch-edit',$suppaybatch->id)}}">{{$suppaybatch->batch_no}}</a></td>
                <td>{{$suppaybatch->batch_pay_date}}</td>
                <td>{{$suppaybatch->supplier_name}}</td>
                <td>{{$this->payable_manage[$suppaybatch->batch_invtype]}}</td>
                @if($suppaybatch->batch_invtype == '1')
                <td>{{RyapayaSupOrderInv::suporder_option($suppaybatch->batch_invno)}}</td>
                @elseif($suppaybatch->batch_invtype == '2')
                <td>{{RyapaySupExpInv::supexp_option($suppaybatch->batch_invno)}}</td>
                @else
                <td>{{RyapaySupCDNote::supplier_option($suppaybatch->batch_invno)}}</td>
                @endif
                <td>{{$suppaybatch->bank_name}}</td>
                <td>{{$suppaybatch->payment_mode}}</td>
                <td>{{$suppaybatch->created_date}}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan="9">No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$suppaybatches->firstItem()==''?'0':$suppaybatches->firstItem()}} to {{$suppaybatches->lastItem()==''?'0':$suppaybatches->lastItem()}} of {{$suppaybatches->total()}} entries</h5>
    </div>
    <div class="col-sm-6">
        <span class="pull-right">
            <ul class="pagination">
                <li><a href="{{$suppaybatches->previousPageUrl()}}">Previous</a></li>
                <li><a href="javascript:">{{$suppaybatches->currentPage()}}</a></li>
                <li><a href="{{$suppaybatches->nextPageUrl()}}">Next</a></li>
            </ul>
        </span>
    </div>
</div>
@endif

@if($module == "sundpaybatch")
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Sundry Payment No</th>
                <th>Pay Date</th>
                <th>Supplier Name</th>
                <th>Expense Code</th>
                <th>Bank</th>
                <th>Paymode</th>
                <th>Created Date</th>
            </tr>
        </thead>
        <tbody id="customertable">
            @if(count($sundpaybatches)>0)
            @foreach($sundpaybatches as $sundpaybatch)
            <tr>
                <td>{{++$table_count}}</td>
                <td><a href="{{route('sundry-payment-edit',$sundpaybatch->id)}}">{{$sundpaybatch->sund_pay_no}}</a></td>
                <td>{{$sundpaybatch->sund_pay_date}}</td>
                <td>{{$sundpaybatch->supplier_name}}</td>
                <td>{{$sundpaybatch->account_code}}</td>
                <td>{{$sundpaybatch->bank_name}}</td>
                <td>{{$sundpaybatch->payment_mode}}</td>
                <td>{{$sundpaybatch->created_date}}</td>
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
        <h5 class="pagination">Showing {{$sundpaybatches->firstItem()==''?'0':$sundpaybatches->firstItem()}} to {{$sundpaybatches->lastItem()==''?'0':$sundpaybatches->lastItem()}} of {{$sundpaybatches->total()}} entries</h5>
    </div>
    <div class="col-sm-6">
        <span class="pull-right">
            <ul class="pagination">
                <li><a href="{{$sundpaybatches->previousPageUrl()}}">Previous</a></li>
                <li><a href="javascript:">{{$sundpaybatches->currentPage()}}</a></li>
                <li><a href="{{$sundpaybatches->nextPageUrl()}}">Next</a></li>
            </ul>
        </span>
    </div>
</div>
@endif

@if($module == "custrcptentry")
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Receipt No</th>
                <th>Receipt Date</th>
                <th>Customer Name</th>
                <th>Invoice Type</th>
                <th>Invoice No</th>
                <th>Bank</th>
                <th>Receipt Mode</th>
                <th>Created Date</th>
            </tr>
        </thead>
        <tbody id="customertable">
            @if(count($custrcptentries)>0)
            @foreach($custrcptentries as $custrcptentry)
            <tr>
                <td>{{++$table_count}}</td>
                <td><a href="{{route('cust-dreceipt-entry-edit',$custrcptentry->id)}}">{{$custrcptentry->receipt_no}}</a></td>
                <td>{{$custrcptentry->receipt_date}}</td>
                <td>{{$custrcptentry->customer_name}}</td>
                <td>{{$this->receivable_manage[$custrcptentry->receipt_invtype]}}</td>
                @if($custrcptentry->receipt_invtype == '1')
                <td>{{RyapayCustOrderInv::custorder_option($custrcptentry->receipt_invno)}}</td>
                @else
                <td>{{RyapayaCustCDNote::custnote_option($custrcptentry->receipt_invno)}}</td>
                @endif
                <td>{{$custrcptentry->bank_name}}</td>
                <td>{{$custrcptentry->receipt_mode}}</td>
                <td>{{$custrcptentry->created_date}}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan="9">No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$custrcptentries->firstItem()==''?'0':$custrcptentries->firstItem()}} to {{$custrcptentries->lastItem()==''?'0':$custrcptentries->lastItem()}} of {{$custrcptentries->total()}} entries</h5>
    </div>
    <div class="col-sm-6">
        <span class="pull-right">
            <ul class="pagination">
                <li><a href="{{$custrcptentries->previousPageUrl()}}">Previous</a></li>
                <li><a href="javascript:">{{$custrcptentries->currentPage()}}</a></li>
                <li><a href="{{$custrcptentries->nextPageUrl()}}">Next</a></li>
            </ul>
        </span>
    </div>
</div>
@endif

@if($module == "sundrcptentry")
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Sundry Receipt No</th>
                <th>Receipt Date</th>
                <th>Customer Name</th>
                <th>Revenue Code</th>
                <th>Bank</th>
                <th>Paymode</th>
                <th>Created Date</th>
            </tr>
        </thead>
        <tbody id="customertable">
            @if(count($sundrcptentries)>0)
            @foreach($sundrcptentries as $sundrcptentry)
            <tr>
                <td>{{++$table_count}}</td>
                <td><a href="{{route('sundry-receipt-edit',$sundrcptentry->id)}}">{{$sundrcptentry->sundry_rcpt_no}}</a></td>
                <td>{{$sundrcptentry->receipt_date}}</td>
                <td>{{$sundrcptentry->customer_name}}</td>
                <td>{{$sundrcptentry->revenue_code}}</td>
                <td>{{$sundrcptentry->bank_name}}</td>
                <td>{{$sundrcptentry->payment_mode}}</td>
                <td>{{$sundrcptentry->created_date}}</td>
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
        <h5 class="pagination">Showing {{$sundrcptentries->firstItem()==''?'0':$sundrcptentries->firstItem()}} to {{$sundrcptentries->lastItem()==''?'0':$sundrcptentries->lastItem()}} of {{$sundrcptentries->total()}} entries</h5>
    </div>
    <div class="col-sm-6">
        <span class="pull-right">
            <ul class="pagination">
                <li><a href="{{$sundrcptentries->previousPageUrl()}}">Previous</a></li>
                <li><a href="javascript:">{{$sundrcptentries->currentPage()}}</a></li>
                <li><a href="{{$sundrcptentries->nextPageUrl()}}">Next</a></li>
            </ul>
        </span>
    </div>
</div>
@endif

@if($module == "cdrtransaction")
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Transaction Type</th>
                <th>Transaction No</th>
                <th>Transaction Date</th>
                <th>Adjustment Id</th>
                <th>Created Date</th>
            </tr>
        </thead>
        <tbody id="customertable">
            @if(count($cdrtransactions)>0)
            @foreach($cdrtransactions as $cdrtransaction)
            <tr>
                <td>{{++$table_count}}</td>
                <td><a href="{{route('cdr-edit',$cdrtransaction->id)}}">{{$cdrtransaction->trans_type}}</a></td>
                <td>{{$cdrtransaction->transaction_gid}}</td>
                <td>{{$cdrtransaction->transaction_date}}</td>
                <td>{{$cdrtransaction->adjustment_id}}</td>
                <td>{{$cdrtransaction->created_date}}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan="6">No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    
</div>
<div class="row">
    <div class="col-sm-6 pl-0">
        <h5 class="pagination">Showing {{$cdrtransactions->firstItem()==''?'0':$cdrtransactions->firstItem()}} to {{$cdrtransactions->lastItem()==''?'0':$cdrtransactions->lastItem()}} of {{$cdrtransactions->total()}} entries</h5>
    </div>
    <div class="col-sm-6 pr-0">
        <span class="pull-right">
            <ul class="pagination">
                <li><a href="{{$cdrtransactions->previousPageUrl()}}">Previous</a></li>
                <li><a href="javascript:">{{$cdrtransactions->currentPage()}}</a></li>
                <li><a href="{{$cdrtransactions->nextPageUrl()}}">Next</a></li>
            </ul>
        </span>
    </div>
</div>
@endif

@if($module == "lead")
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Subject</th>
                <th>Message</th>
                <th>Lead</th>
                <th>Created Date</th>
            </tr>
        </thead>
        <tbody id="customertable">
            @if(count($leads)>0)
            @foreach($leads as $lead)
            <tr>
                <td>{{++$table_count}}</td>
                <td>{{$lead->name}}</td>
                <td>{{$lead->email}}</td>
                <td>{{$lead->mobile_no}}</td>
                <td>{{$lead->subject}}</td>
                <td>{{$lead->message}}</td>
                <td>{{$lead->lead_from}}</td>
                <td>{{$lead->created_date}}</td>
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
        <h5 class="pagination">Showing {{$leads->firstItem()==''?'0':$leads->firstItem()}} to {{$leads->lastItem()==''?'0':$leads->lastItem()}} of {{$leads->total()}} entries</h5>
    </div>
    <div class="col-sm-6">
        <span class="pull-right">
            <ul class="pagination">
                <li><a href="{{$leads->previousPageUrl()}}">Previous</a></li>
                <li><a href="javascript:">{{$leads->currentPage()}}</a></li>
                <li><a href="{{$leads->nextPageUrl()}}">Next</a></li>
            </ul>
        </span>
    </div>
</div>
@endif

@if($module == "subscribe")
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Email</th>
                <th>Send Mail</th>
                <th>Created Date</th>
            </tr>
        </thead>
        <tbody id="customertable">
            @if(count($subscribers)>0)
            @foreach($subscribers as $subscriber)
            <tr>
                <td>{{++$table_count}}</td>
                <td>{{$subscriber->email}}</td>
                <td>{{$subscriber->send_mail}}</td>
                <td>{{$subscriber->created_date}}</td>
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
        <h5 class="pagination">Showing {{$subscribers->firstItem()==''?'0':$subscribers->firstItem()}} to {{$subscribers->lastItem()==''?'0':$subscribers->lastItem()}} of {{$subscribers->total()}} entries</h5>
    </div>
    <div class="col-sm-6">
        <span class="pull-right">
            <ul class="pagination">
                <li><a href="{{$subscribers->previousPageUrl()}}">Previous</a></li>
                <li><a href="javascript:">{{$subscribers->currentPage()}}</a></li>
                <li><a href="{{$subscribers->nextPageUrl()}}">Next</a></li>
            </ul>
        </span>
    </div>
</div>
@endif

@if($module == "image")
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Image Id</th>
                <th>Position</th>
                <th>Created Date</th>
            </tr>
        </thead>
        <tbody id="customertable">
            @if(count($images)>0)
            @foreach($images as $image)
            <tr>
                <td>{{++$table_count}}</td>
                <td><a href="javascript:void(0)" onclick="editGalleryImage('{{$image->id}}')">{{$image->id}}</a></td>
                <td>{{$image->position}}</td>
                <td>{{$image->created_date}}</td>
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
        <h5 class="pagination">Showing {{$images->firstItem()==''?'0':$images->firstItem()}} to {{$images->lastItem()==''?'0':$images->lastItem()}} of {{$images->total()}} entries</h5>
    </div>
    <div class="col-sm-6">
        <span class="pull-right">
            <ul class="pagination">
                <li><a href="{{$images->previousPageUrl()}}">Previous</a></li>
                <li><a href="javascript:">{{$images->currentPage()}}</a></li>
                <li><a href="{{$images->nextPageUrl()}}">Next</a></li>
            </ul>
        </span>
    </div>
</div>
@endif

@if($module == "job")
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Job Title</th>
                <th>Job Category</th>
                <th>Job Location</th>
                <th>Status</th>
                <th>Created Date</th>
                <th>Change Status</th>
            </tr>
        </thead>
        <tbody id="customertable">
            @if(count($jobs)>0)
            @foreach($jobs as $job)
            <tr>
                <td>{{++$table_count}}</td>
                <td><a href="javascript:void(0)" onclick="editJob('{{$job->id}}')">{{$job->job_title}}</a></td>
                <td>{{$job->job_category}}</td>
                <td>{{$job->job_location}}</td>
                <td>{{$job->job_status}}</td>
                <td>{{$job->created_date}}</td>
                <td><a href="javascript:void(0)" class="btn btn-primary btn-sm" onclick="changeJobStatus('{{$job->id}}',this,'{{$job->job_status}}')">Change Status</a></td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan="6">No Data Found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$jobs->firstItem()==''?'0':$jobs->firstItem()}} to {{$jobs->lastItem()==''?'0':$jobs->lastItem()}} of {{$jobs->total()}} entries</h5>
    </div>
    <div class="col-sm-6">
        <span class="pull-right">
            <ul class="pagination">
                <li><a href="{{$jobs->previousPageUrl()}}">Previous</a></li>
                <li><a href="javascript:">{{$jobs->currentPage()}}</a></li>
                <li><a href="{{$jobs->nextPageUrl()}}">Next</a></li>
            </ul>
        </span>
    </div>
</div>
@endif

@if($module == "applicant")
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Job Title</th>
                <th>Applicant Name</th>
                <th>Applicant Email</th>
                <th>Applicant Mobile</th>
                <th>Applicant Status</th>
                <th>Created Date</th>
                <th>Change Status</th>
            </tr>
        </thead>
        <tbody id="customertable">
            @if(count($applicants)>0)
            @foreach($applicants as $applicant)
            <tr>
                <td>{{++$table_count}}</td>
                <td><a href="javascript:void(0)" onclick="editapplicant('{{$applicant->id}}')">{{$applicant->job_title}}</a></td>
                <td>{{$applicant->applicant_name}}</td>
                <td>{{$applicant->applicant_email}}</td>
                <td>{{$applicant->applicant_mobile}}</td>
                <td>{{$applicant->applicant_status}}</td>
                <td>{{$applicant->created_date}}</td>
                <td><a href="javascript:void(0)" class="btn btn-primary btn-sm" data-html="true" data-trigger="focus" data-toggle="popover" data-placement="top" data-content="<a class='btn btn-link' onclick=updateApplicantStatus('{{$applicant->id}}','{{str_replace(' ','+',$applicant->applicant_status)}}')>Change Status</a><br>
                    <a href='/download/applicant/resume/{{$applicant->applicant_resume}}'' class='btn btn-link'>Download Resume</a><br>"><i class="fa fa-cogs"></i>&nbsp;Actions</a>

                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan="8">No Data Found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$applicants->firstItem()==''?'0':$applicants->firstItem()}} to {{$applicants->lastItem()==''?'0':$applicants->lastItem()}} of {{$applicants->total()}} entries</h5>
    </div>
    <div class="col-sm-6">
        <span class="pull-right">
            <ul class="pagination">
                <li><a href="{{$applicants->previousPageUrl()}}">Previous</a></li>
                <li><a href="javascript:">{{$applicants->currentPage()}}</a></li>
                <li><a href="{{$applicants->nextPageUrl()}}">Next</a></li>
            </ul>
        </span>
    </div>
</div>
@endif

@if($module == "workstatus")
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Work Date</th>
                <th>Today Work</th>
                <th>NextDay Work</th>
                <th>Created Date</th>
                <th>Modified Date</th>
            </tr>
        </thead>
        <tbody id="customertable">
            @if(count($workstatuses)>0)
            @foreach($workstatuses as $workstatus)
            <tr>
                <td>{{++$table_count}}</td>
                @if($workstatus->allow_edit == 'edit')
                <td><a href="javascript:void(0)" onclick="editWorkStatus('{{$workstatus->id}}')">{{$workstatus->today_date}}</a></td>
                @else
                <td>{{$workstatus->today_date}}</td>
                @endif
                <td>{{$workstatus->today_work}}</td>
                <td>{{$workstatus->nextday_work}}</td>
                <td>{{$workstatus->created_date}}</td>
                <td>{{$workstatus->modified_date}}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan="6">No Data Found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$workstatuses->firstItem()==''?'0':$workstatuses->firstItem()}} to {{$workstatuses->lastItem()==''?'0':$workstatuses->lastItem()}} of {{$workstatuses->total()}} entries</h5>
    </div>
    <div class="col-sm-6">
        <span class="pull-right">
            <ul class="pagination">
                <li><a href="{{$workstatuses->previousPageUrl()}}">Previous</a></li>
                <li><a href="javascript:">{{$workstatuses->currentPage()}}</a></li>
                <li><a href="{{$workstatuses->nextPageUrl()}}">Next</a></li>
            </ul>
        </span>
    </div>
</div>
@endif

@if($module == "approvedmerchant")
@if(isset($approvedmerchants))
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Merchant Id</th>
                <th>Name</th>
                <th>Company Name</th>
                <th>Company Type</th>
                <th>Merchant Mode</th>
                <th>Change App Mode</th>
                <th>Status</th>
                <th>Created Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="bginfotable">
            @if(count($approvedmerchants)>0)
            @foreach($approvedmerchants as $approvedmerchant)
            <tr>
                <td>{{++$table_count}}</td>
                <td>{{$approvedmerchant->merchant_gid}}</td>
                <td>{{$approvedmerchant->name}}</td>
                <td>{{$approvedmerchant->business_name}}</td>
                <td>{{$approvedmerchant->type_name}}</td>
                <td>{{$approvedmerchant->app_mode}}</td>
                <td>{{$approvedmerchant->change_app_mode}}</td>
                <td>{{$approvedmerchant->merchant_status}}</td>
                <td>{{$approvedmerchant->created_date}}</td>
                <td><button class="btn btn-success btn-sm" onclick="MakeMerchantLive('{{$approvedmerchant->id}}',this)">Make Live</button>
                    <br>
                    <button style="{{$approvedmerchant->merchant_status == 'active'?'':'display:none'}}" id="inactive-btn" class="btn btn-danger btn-sm" onclick="MakeMerchantInactive('{{$approvedmerchant->id}}',this)" data-merchantstatus={{$approvedmerchant->merchant_status}}>Make Inactive</button>
                    <button style="{{$approvedmerchant->merchant_status == 'active'?'display:none':''}}" id="active-btn" class="btn btn-primary btn-sm" onclick="MakeMerchantInactive('{{$approvedmerchant->id}}',this)" data-merchantstatus={{$approvedmerchant->merchant_status}}>Make active</button>
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#passwordModal" data-merchantid={{$approvedmerchant->id}} >
                      Change Password
                    </button>
                    
                    <button onclick="togglePayinStatus('{{$approvedmerchant->id}}')" id="active-btn" class="btn btn-primary btn-sm">
    PayIn Make <span id="status-text">Active</span>
</button>




                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan="10">No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$approvedmerchants->firstItem()==''?'0':$approvedmerchants->firstItem()}} to {{$approvedmerchants->lastItem() =='' ? '0':$approvedmerchants->lastItem()}} of {{$approvedmerchants->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$approvedmerchants->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$approvedmerchants->currentPage()}}</a></li>
            <li><a href="{{$approvedmerchants->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif

@if($module == "merchantcharge")
@if(isset($merchantcharges))
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Merchant Id</th>
                <th>Name</th>
                <th>Company Type</th>
                <th>Created Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="bginfotable">
            @if(count($merchantcharges)>0)
            @foreach($merchantcharges as $merchantcharge)
            <tr>
                <td>{{++$table_count}}</td>
                <td>{{$merchantcharge->merchant_gid}}</td>
                <td>{{$merchantcharge->name}}</td>
                <td>{{$merchantcharge->type_name}}</td>
                <td>{{$merchantcharge->created_date}}</td>
                <td><button class="btn btn-warning btn-sm" onclick="editMerchantCharges('{{$merchantcharge->id}}',this)">Edit Charges</button></td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan="6">No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$merchantcharges->firstItem()==''?'0':$merchantcharges->firstItem()}} to {{$merchantcharges->lastItem() =='' ? '0':$merchantcharges->lastItem()}} of {{$merchantcharges->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$merchantcharges->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$merchantcharges->currentPage()}}</a></li>
            <li><a href="{{$merchantcharges->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif

@if($module == "merchantcommercial")
@if(isset($merchantcommercials))
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Merchant Id</th>
                <th>Name</th>
                <th>Company Type</th>
                <th>Created Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="bginfotable">
            @if(count($merchantcommercials)>0)
            @foreach($merchantcommercials as $merchantcommercial)
            <tr>
                <td>{{++$table_count}}</td>
                <td>{{$merchantcommercial->merchant_gid}}</td>
                <td>{{$merchantcommercial->name}}</td>
                <td>{{$merchantcommercial->type_name}}</td>
                <td>{{$merchantcommercial->created_date}}</td>
                <td><button class="btn btn-warning btn-sm" onclick="viewMerchantCommercials('{{$merchantcommercial->id}}',this)">View Charges</button></td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan="6">No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$merchantcommercials->firstItem()==''?'0':$merchantcommercials->firstItem()}} to {{$merchantcommercials->lastItem() =='' ? '0':$merchantcommercials->lastItem()}} of {{$merchantcommercials->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$merchantcommercials->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$merchantcommercials->currentPage()}}</a></li>
            <li><a href="{{$merchantcommercials->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif

@if($module == "alltransaction")
@if(isset($allpayintransactions))
@php($table_count=0)
<div class="table-responsive">
    <form id="settle-transactions-form" method="POST">
        <table class="table table-bordered" id="transactionlistpayin">
            <thead>
                <tr>
                    <th>Kabil</th>
                    {{-- <th>
                        <div class="checkbox">
                            <label>
                                <strong>Select All</strong>
                                <input type="checkbox" class="form-control" onclick="selectAllTransactionIds(this);">
                                <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                            </label>
                        </div>
                    </th> --}}
                    <th>Merchant id</th>
                    <th>Merchant Name</th>
                    <th>Customer Name</th>
                    <th>Transaction Amount</th>
                    <th>Mobile No</th>
                    <th>Email</th>
                    <th>Upi Id</th>
                    <th>Order Id</th>

                    <th>FPay Transaction Id</th>
                    <th>EVOK Transaction Id</th>
                    <th>RRN No</th>
                    <th>Bank Transaction Id</th>
                    <th>Transaction Status</th>
                        {{-- <th>Transaction Status</th> --}}
                    <th>Transaction Initiated at</th>
                    <th> Transaction Updated at</th>
                </tr>
            </thead>
            <tbody id="bginfotable">
                @if(count($allpayintransactions)>0)
                @foreach($allpayintransactions as $alltransaction)
                <tr>
                    <td>{{++$table_count}}</td>
                    {{-- <td>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="id[]" id="id" class="form-control" value="{{$alltransaction->id}}">
                                <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                            </label>
                        </div>
                    </td> --}}
                    <td>{{$alltransaction->merchant_id}}</td>
                    <td>{{$alltransaction->name}}</td>
                    <td>{{$alltransaction->customer_name}}</td>
                    <td>{{$alltransaction->amount}}</td>
                    <td>{{$alltransaction->mobile_no}}</td>
                    <td>{{$alltransaction->email}}</td>
                    <td>{{$alltransaction->upi_id}}</td>
                    <td>{{$alltransaction->order_id}}</td>
                    <td>{{$alltransaction->fpay_trxnid}}</td>
                    @if(property_exists($alltransaction, 'evok_txnid'))
                    <td>{{ $alltransaction->evok_txnid }}</td>
                     @else
                    <td>---</td>
                    @endif
                    @if(property_exists($alltransaction, 'rrn_no'))
                    <td>{{ $alltransaction->rrn_no }}</td>
                     @else
                    <td>---</td>
                    @endif
                    @if(property_exists($alltransaction, 'acqrbank_txnid'))
                    <td>{{ $alltransaction->acqrbank_txnid }}</td>
                     @else
                    <td>---</td>
                    @endif
                
                    <td>
                        @if($alltransaction->txn_status == 1)
                        TXN not initiated
                        @elseif($alltransaction->txn_status == 2)
                            Success
                        @elseif($alltransaction->txn_status == 0)
                            Failed
                        @elseif($alltransaction->txn_status == 3)
                            Tampered
                        @elseif($alltransaction->txn_status == 4)
                            Cancelled
                        @endif
                   </td>
                    {{-- <td></td> --}}
                    <td>{{$alltransaction->created_at}}</td>
                    <td>{{$alltransaction->updated_at}}</td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td class="text-center" colspan="13">No Data found</td>
                </tr>
                @endif
            </tbody>
            <tfoot>
            </tfoot>
        </table>
       
        {{csrf_field()}}
    </form>
    {{-- {{ $allpayintransactions->links() }} --}}
    {{-- <div class="col-sm-6">
        <h5 class="pagination">Showing {{$alltransactions->firstItem()==''?'0':$alltransactions->firstItem()}} to {{$alltransactions->lastItem() =='' ? '0':$alltransactions->lastItem()}} of {{$alltransactions->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$alltransactions->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$alltransactions->currentPage()}}</a></li>
            <li><a href="{{$alltransactions->nextPageUrl()}}">Next</a></li>
        </ul>
    </div> --}}
</div>
@endif
@endif

@if($module == "settlementalltransaction")
@if(isset($alltransactions))
@php($table_count=0)
<div class="table-responsive">
    <form id="settle-transactions-form" method="POST">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Sno</th>
                    <th>
                        <div class="checkbox">
                            <label>
                                <strong>Select All</strong>
                                <input type="checkbox" class="form-control" onclick="selectAllTransactionIds(this);">
                                <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                            </label>
                        </div>
                    </th>
                    <th>Merchant Gid</th>
                    <th>Transaction Gid</th>
                    <th>Transaction Amount</th>
                    <th>Percentage Charge%</th>
                    <th>Charge Amount</th>
                    <th>GST</th>
                    <th>GST Charge%</th>
                    <th>Amount Charged</th>
                    <th>Total Adjustment</th>
                    <th>Transaction Status</th>
                    <th>Transaction Date</th>
                </tr>
            </thead>
            <tbody id="bginfotable">
                @if(count($alltransactions)>0)
                @foreach($alltransactions as $alltransaction)
                <tr>
                    <td>{{++$table_count}}</td>
                    <td>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="id[]" id="id" class="form-control" value="{{$alltransaction->id}}">
                                <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                            </label>
                        </div>
                    </td>
                    <td>{{$alltransaction->merchant_gid}}</td>
                    <td>{{$alltransaction->transaction_gid}}</td>
                    <td>{{$alltransaction->transaction_amount}}</td>
                    <td>{{$alltransaction->percentage_charge}}</td>
                    <td>{{$alltransaction->percentage_amount}}</td>
                    <td>{{$alltransaction->transaction_gst}}</td>
                    <td>{{$alltransaction->gst_charge}}</td>
                    <td>{{$alltransaction->total_amt_charged}}</td>
                    <td>{{$alltransaction->adjustment_total}}</td>
                    <td>{{$alltransaction->transaction_status}}</td>
                    <td>{{$alltransaction->transaction_date}}</td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td class="text-center" colspan="13">No Data found</td>
                </tr>
                @endif
            </tbody>
            <tfoot>
            </tfoot>
        </table>
        {{csrf_field()}}
    </form>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$alltransactions->firstItem()==''?'0':$alltransactions->firstItem()}} to {{$alltransactions->lastItem() =='' ? '0':$alltransactions->lastItem()}} of {{$alltransactions->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$alltransactions->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$alltransactions->currentPage()}}</a></li>
            <li><a href="{{$alltransactions->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif

@if($module == "adjustmentcharge")
@if(isset($adjustmentcharges))
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Merchant Id</th>
                <th>Name</th>
                <th>Company Type</th>
                <th>Created Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="bginfotable">
            @if(count($adjustmentcharges)>0)
            @foreach($adjustmentcharges as $adjustmentcharge)
            <tr>
                <td>{{++$table_count}}</td>
                <td>{{$adjustmentcharge->merchant_gid}}</td>
                <td>{{$adjustmentcharge->name}}</td>
                <td>{{$adjustmentcharge->type_name}}</td>
                <td>{{$adjustmentcharge->created_date}}</td>
                <td><button class="btn btn-success btn-sm" onclick="editadjustmentCharges('{{$adjustmentcharge->merchant_id}}',this)">Edit Charges</button></td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan="6">No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$adjustmentcharges->firstItem()==''?'0':$adjustmentcharges->firstItem()}} to {{$adjustmentcharges->lastItem() =='' ? '0':$adjustmentcharges->lastItem()}} of {{$adjustmentcharges->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$adjustmentcharges->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$adjustmentcharges->currentPage()}}</a></li>
            <li><a href="{{$adjustmentcharges->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif

@if($module == "merchantroute")
@if(isset($merchantroutes))
@php($table_count=0)
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Merchant Id</th>
                <th>Name</th>
                <th>Company Type</th>
                <th>Created Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="bginfotable">
            @if(count($merchantroutes)>0)
            @foreach($merchantroutes as $merchantroute)
            <tr>
                <td>{{++$table_count}}</td>
                <td>{{$merchantroute->merchant_gid}}</td>
                <td>{{$merchantroute->name}}</td>
                <td>{{$merchantroute->type_name}}</td>
                <td>{{$merchantroute->created_date}}</td>
                <td><button class="btn btn-success btn-sm" onclick="editMerchantRoutes('{{$merchantroute->id}}',this)">Edit Route</button></td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan="6">No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$merchantroutes->firstItem()==''?'0':$merchantroutes->firstItem()}} to {{$merchantroutes->lastItem() =='' ? '0':$merchantroutes->lastItem()}} of {{$merchantroutes->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$merchantroutes->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$merchantroutes->currentPage()}}</a></li>
            <li><a href="{{$merchantroutes->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif

@if($module == "vendoradjustment")
    @if(isset($vendoradjustments))
        @php($table_count=0)
        <div class="table-responsive" id="">
            <form id="rupayapay-adjustment-form" method="POST">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Sno</th>
                            <th>
                                <div class="checkbox">
                                    <label>
                                        <strong>Select All</strong>
                                        <input type="checkbox" class="form-control" onclick="selectAllVendorAdjustmentIds(this);">
                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                    </label>
                                </div>
                            </th>
                            <th>Merchant Id</th>
                            <th>Transaction Id</th>
                            <th>Transaction Amount</th> 
                            <th>Settlement Amount</th>
                            <th>Vendor</th>
                            <th>Settlement Date</th>
                        </tr>
                    </thead>
                    <tbody id="payin-transactions-body">
                        @if(count($vendoradjustments)>0)
                            @foreach($vendoradjustments as $vendoradjustment)
                                <tr>
                                    <td>{{++$table_count}}</td>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="id[]" id="id" class="form-control" value="{{$vendoradjustment->id}}">
                                                <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>{{$vendoradjustment->merchant_gid}}</td>
                                    <td>{{$vendoradjustment->merchant_traxn_id}}</td>
                                    <td>{{number_format($vendoradjustment->amount,2)}}</td>
                                    <td>{{$vendoradjustment->settlement_amount}}</td>
                                    <td>{{$vendoradjustment->vendor_from}}</td>
                                    <td>{{$vendoradjustment->settlement_date}}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="text-center" colspan="9">No Data found</td>
                            </tr>
                        @endif
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
                {{csrf_field()}}
            </form>
        </div>
    @endif

    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$vendoradjustments->firstItem()==''?'0':$vendoradjustments->firstItem()}} to {{$vendoradjustments->lastItem() =='' ? '0':$vendoradjustments->lastItem()}} of {{$vendoradjustments->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$vendoradjustments->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$vendoradjustments->currentPage()}}</a></li>
            <li><a href="{{$vendoradjustments->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
@endif


@if($module == "ryapayadjustment")
@if(isset($ryapayadjustments))
@php($table_count=0)
<div class="table-responsive" id="">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Merchant Id</th>
                <th>Transaction Id</th>
                <th>Transaction Amount</th>
                <th>Charges</th>
                <th>Charges On Transaction</th>
                <th>GST</th>
                <th>GST On Charges</th>
                <th>Total Amount Charged</th>
                <th>Adjustment Amount</th>
                <th>Settlement Date</th>
            </tr>
        </thead>
        <tbody id="bginfotable">
            @if(count($ryapayadjustments)>0)
            @foreach($ryapayadjustments as $ryapayadjustment)
            <tr>
                <td>{{++$table_count}}</td>
                <td>{{$ryapayadjustment->merchant_gid}}</td>
                <td>{{$ryapayadjustment->merchant_transaction_id}}</td>
                <td>{{number_format($ryapayadjustment->transaction_amount,2)}}</td>
                <td>{{$ryapayadjustment->charges_per}}%</td>
                <td>{{$ryapayadjustment->charges_on_transaction}}</td>
                <td>{{$ryapayadjustment->gst_per}}%</td>
                <td>{{$ryapayadjustment->gst_on_transaction}}</td>
                <td>{{$ryapayadjustment->total_amt_charged}}</td>
                <td>{{$ryapayadjustment->adjustment_amount}}</td>
                <td>{{$ryapayadjustment->created_date}}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan="11">No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$ryapayadjustments->firstItem()==''?'0':$ryapayadjustments->firstItem()}} to {{$ryapayadjustments->lastItem() =='' ? '0':$ryapayadjustments->lastItem()}} of {{$ryapayadjustments->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$ryapayadjustments->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$ryapayadjustments->currentPage()}}</a></li>
            <li><a href="{{$ryapayadjustments->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif

@if($module == "extdoc")
@if(isset($extdocs))
@php($table_count=0)
<div class="table-responsive" id="">
    <form id="rupayapay-adjustment-form" method="POST">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Sno</th>
                    <th>Merchant Id</th>
                    <th>Document Name</th>
                    <th>Created Date</th>
                </tr>
            </thead>
            <tbody id="bginfotable">
                @if(count($extdocs)>0)
                @foreach($extdocs as $extdoc)
                <tr>
                    <td>{{++$table_count}}</td>
                    <td><a href="{{route('extra-document',base64_encode($extdoc->id))}}">{{$extdoc->name}}</a></td>
                    <td>{{$extdoc->doc_name}}</td>
                    <td>{{$extdoc->created_date}}</td>
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
        {{csrf_field()}}
    </form>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$extdocs->firstItem()==''?'0':$extdocs->firstItem()}} to {{$extdocs->lastItem() =='' ? '0':$extdocs->lastItem()}} of {{$extdocs->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$extdocs->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$extdocs->currentPage()}}</a></li>
            <li><a href="{{$extdocs->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif

@if($module == "cashfreeroute")
@if(isset($cashfreeroutes))
@php($table_count=0)
<div class="table-responsive" id="">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>Business Name</th>
                <th>Cashfree Api</th>
                <th>Cashfree Security Key</th>
                <th>Created Date</th>
            </tr>
        </thead>
        <tbody id="bginfotable">
            @if(count($cashfreeroutes)>0)
            @foreach($cashfreeroutes as $cashfreeroute)
            <tr>
                <td>{{++$table_count}}</td>
                <td><a href="javascript:void(0)" onclick="editCashFreeKey('{{$cashfreeroute->id}}')">{{$cashfreeroute->business_name}}</a></td>
                <td>{{$cashfreeroute->app_id}}</td>
                <td>{{$cashfreeroute->secret_key}}</td>
                <td>{{$cashfreeroute->created_date}}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan="5">No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$cashfreeroutes->firstItem()==''?'0':$cashfreeroutes->firstItem()}} to {{$cashfreeroutes->lastItem() =='' ? '0':$cashfreeroutes->lastItem()}} of {{$cashfreeroutes->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$cashfreeroutes->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$cashfreeroutes->currentPage()}}</a></li>
            <li><a href="{{$cashfreeroutes->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif


@if($module == "campaignlist")
@if(isset($campaignlists))
@php($table_count=0)
<div class="table-responsive" id="">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sno</th>
                <th>From</th>
                <th>Subject</th>
                <th>To</th>
                <th>Status</th>
                <th>Created Date</th>
            </tr>
        </thead>
        <tbody id="bginfotable">
            @if(count($campaignlists)>0)
            @foreach($campaignlists as $campaignlist)
            <tr>
                <td>{{++$table_count}}</td>
                <td>{{$campaignlist->campaign_from}}</td>
                <td>{{$campaignlist->campaign_subject}}</td>
                <td>{{$campaignlist->campaign_to}}</td>
                <td>{{$campaignlist->campaign_status}}</td>
                <td>{{$campaignlist->campaign_sent}}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan="6">No Data found</td>
            </tr>
            @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="col-sm-6">
        <h5 class="pagination">Showing {{$campaignlists->firstItem()==''?'0':$campaignlists->firstItem()}} to {{$campaignlists->lastItem() =='' ? '0':$campaignlists->lastItem()}} of {{$campaignlists->total()}} entries</h5>
    </div>
    <div class="col-sm-6 text-right">
        <ul class="pagination">
            <li><a href="{{$campaignlists->previousPageUrl()}}">Previous</a></li>
            <li><a href="javascript:">{{$campaignlists->currentPage()}}</a></li>
            <li><a href="{{$campaignlists->nextPageUrl()}}">Next</a></li>
        </ul>
    </div>
</div>
@endif
@endif

<!-- Include DataTables CSS -->
{{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.1/css/dataTables.dataTables.min.css"> --}}
<!-- Include DataTables Styling CSS from CDN -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">

{{-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> --}}
<!-- Include DataTables JavaScript -->
{{-- <script type="text/javascript" src="https://cdn.datatables.net/2.0.1/js/dataTables.min.js"></script> --}}

<script>
$(document).ready(function() {


    $('#transactionlistpayin').DataTable();
    $('.dataTables_filter').hide();
    


});
</script>