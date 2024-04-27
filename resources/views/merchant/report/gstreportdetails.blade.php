<div class="card">
  <div class="card-body">
    <table id="gst_report_details_tbl"  class="table table-striped table-bordered table-sm border " style="width:100%">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Settlement Gid</th>
          <th scope="col">Current Balance</th>
          <th scope="col">Settlement Amount</th>
          <th scope="col">Settlement Fee</th>
          <th scope="col">Settlement Tax</th>
          <th scope="col">Settlement Total</th>
          <th scope="col">Settlement Status</th>
          <th scope="col">Merchant</th>
          <th scope="col">Settlement Date</th>
         

        </tr>
      </thead>
      <tbody>
        @foreach($data as $index => $invoice)
        <tr>
          <td>{{ $index+1 }}</td>
          <td>{{ $invoice->settlement_gid }}</td>
          <td>{{ $invoice->current_balance }}</td>
          <td>{{ $invoice->settlement_amount }}</td>
          <td>{{ $invoice->settlement_fee }}</td>
          <td>{{ $invoice->settlement_tax }}</td>
          <td>{{ $invoice->settlement_tax + $invoice->settlement_fee }}</td>
          <td>{{ $invoice->settlement_status }}</td>
          <td>{{ $invoice->merchant->name }}</td>
          <td>{{ \Carbon\Carbon::parse($invoice->settlement_date)->format('j F, Y')}}</td>
        



        </tr>
        @endforeach



      </tbody>
     
    </table>
  </div>
</div>

<script>
         $(document).ready(function() {
             $('#gst_report_details_tbl').DataTable({
              "scrollX": true,
              pageLength : 5,
                 lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'All']],
                 "columnDefs": [
                       {"className": "dt-center", "targets": "_all"}
                  ],
             });
             
         });
     </script>