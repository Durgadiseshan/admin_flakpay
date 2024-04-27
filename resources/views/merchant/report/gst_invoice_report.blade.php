<div class="src1" style="float:right;margin-bottom: 10px;">
                            <form id="gst-report-range-excel" action="" method="post">
                                
                                <input type="hidden" name="gst_excel_from_date" value="{{session('gst_report_from_date')}}">
                                <input type="hidden" name="gst_excel_to_date" value="{{session('gst_report_to_date')}}">
                               
                               <input type="submit" value="Excel" class="btn btn-primary ">
                                {{csrf_field()}} 
                            </form>
                        </div>
    <table id="gst_example" class="table table-striped table-bordered table-sm border ">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Taxable Value</th>
          <th scope="col">Tax (18% GST)</th>
          <th scope="col">Total Amount</th>
          <th scope="col">Settlement Date</th>
          <th scope="col">Invoice</th>
          <th scope="col">Action</th>
         

        </tr>
      </thead>
      <tbody>
        @foreach($settlements as $index => $settlement)
        <tr>
          <td>{{ $index+1 }}</td>
          <td>{{ $settlement->total_fee }}</td>
          <td>{{ $settlement->total_tax }}</td>
          <td>{{ ($settlement->total_fee)+($settlement->total_tax) }}</td>
          
          <td>{{ \Carbon\Carbon::parse($settlement->my_date)->format('j F, Y')}}</td>
          <td>
            @if($settlement->settlement_receiptno)
             <a target="_blank"   href="{{route('recipt', ['id' => $settlement->settlement_receiptno])}}"> {{ $settlement->settlement_receiptno }}</a>
            @endif

            
          </td>
          
          <td>
               <div class="col-sm-10">
                         <i class="fa fa-eye show-cursor mandatory" onclick="gstInvoiceReort(this,'{{$settlement->my_date}}');"></i>
                         <a target="_blank"   href="{{route('gstdetailExcel', ['date' => $settlement->my_date])}}"> <i class=" fa fa-file-excel-o fa-lg" style="color:chocolate"></i></a>
         
               </div>
          </td>
        



        </tr>
        @endforeach



      </tbody>
     
    </table>


    <script>
         $(document).ready(function() {
             $('#gst_example').DataTable({
                "columnDefs": [
                 {"className": "dt-center", "targets": "_all"}
                ],
             });
             
         });
     </script>