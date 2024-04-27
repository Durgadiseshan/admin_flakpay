@php
if($is_datatable ==1){
  $logs=\App\TransactionReportLog::where('mode',Auth::user()->app_mode)->orderBy('created_date', 'desc')->get();
}else{
  $logs=\App\TransactionReportLog::where('mode',Auth::user()->app_mode)->whereNotIn('report_type',array('paylink','invoice','customer'))->orderBy('created_date', 'desc')->get();
}
 
 


@endphp
<!-- refund table -->
@if(isset($logs))
<div class="row">
<div class="card bg-light text-dark">
   <div class="card-header center"><h2>Report Logs</h2></div>
  <div class="card-body">

   
    <table id="trans_log_table" class="table table-striped table-bordered table-sm border ">
      <thead>
        <tr>
          <th scope="col">#</th>
           <th scope="col">Report From </th>
          <th scope="col">Report To</th>  
          <th scope="col">Payment Mode</th>
          <th scope="col">Transaction Status</th>
          <th scope="col">Report type</th>
           <th scope="col">Date</th>
        </tr>
      </thead>
      <tbody>
        @foreach($logs as $index => $log)
        
        <tr>
          <td>{{ $index+1 }}</td>
          <td>{{ $log->from }}</td>
          <td>{{ $log->to }}</td>
          <td>{{ ucwords(\App\Classes\Helpers::payment_mode($log->payment_mode)) }}</td>
          <td>{{ ucwords(\App\Classes\Helpers::transaction_status($log->transaction_status)) }} </td>
          <td>{{ ucwords($log->report_type=='payment'?'Transaction':$log->report_type) }}</td>
         
          <td>{{ \Carbon\Carbon::parse($log->created_date)->format('h:i A j F, Y')}}</td>
          


        </tr>
        
        @endforeach



      </tbody>

    </table>
  </div>
</div>
</div>
@endif
<script>
         $(document).ready(function() {
             $('#example').DataTable();
             $('#trans_log_table').DataTable();
         });
     </script>