<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Settlement;
use DataTables;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PayinTransactions;
use Illuminate\Support\Facades\Validator;
use App\Models\MerchantSettlementOption;
use Excel;
use App\Exports\SettlementSuccessTxnExport;
use Illuminate\Support\Facades\Log;
use App\Models\SettlementSlotTypes;

class SettlementController extends Controller
{

    private $settlement;
    public function __construct(Settlement $settlement)
    {
      $this->settlement = $settlement;
    }

    public function index(){

        $data = Settlement::where('status','0')->join('merchant','live_settlement.merchant','=','merchant.id')->select('live_settlement.*','merchant.name as merchant_name')->orderByDesc('created_at')->get();
        // dd($data);
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('merchant_name', function($row) {
                   return $row->merchant_name;
                })
                ->addColumn('settlement_id', function($row) {
                    return $row->report_id;
                })
                ->addColumn('settlement_report', function ($row) {
                    if (!is_null($row->receipt_url)) {
                        return '<a  href="'.asset($row->receipt_url).'" class="btn btn-primary excel_download">Download Excel</button>';
                    } else {
                        return '-';
                    }})
                ->addColumn('report_time', function($row) {
                    return $row->report_time;
                })
                ->addColumn('success_txn_count', function($row) {
                    return $row->success_txn_count;
                })
                ->addColumn('total_transaction_amount', function($row) {
                    return '₹ '.$row->total_txn_amount;
                })
                ->addColumn('merchant_fee', function($row) {
                    return $row->fee_amount;
                })
                ->addColumn('gst_amount', function($row) {
                    return number_format($row->tax_amount,2);
                })
                ->addColumn('settlement_amount', function($row) {
                    return $row->settlement_amount;
                })
                ->addColumn('created_at', function($row) {
                    return $row->created_at;
                })
                ->addColumn('action', function($row){
                        $btn = '<a href="javascript:void(0)" data-id='.$row->id.' class="edit btn btn-success btn-sm make_payment">Attach Receipt</a><p> </p>';
                        $btn .= '<a href="#"  data-id='.$row->id.' class="mark_as_paid edit btn btn-primary btn-sm">Mark as Paid</a>';
                        return $btn;
                })
                ->rawColumns(['action','settlement_report'])
                ->make(true);

    }

    public function createSettlementreport()
    {
        
        $transaction_merchants = DB::table('test_payintransactions')->where('txn_status','2')->where('created_at','>=',Carbon::yesterday())->get()->groupBy('merchant_id')->toArray();

        $merchant_reports = [];

        $index = 0;

        foreach($transaction_merchants as $merchant_id=>$value)
        {
         $get_merchant_id = DB::table('user_keys')->where('test_mid',$merchant_id)->pluck('mid')->first();

         $totalamount = array_column($value, 'amount');  //Getting the amount of each transaction in a merchant.`  
         $settlement_report_id =  "stmnt_".$merchant_id.time().Str::random(5);
         $total_succfultxn_amt = array_sum($totalamount);

         $fee_amount = $total_succfultxn_amt * 0.02;
         $gst_amount = $fee_amount * 0.18;

        $arr =  [
            'settlement_gid'=>$settlement_report_id,
            'settlement_amount' => $total_succfultxn_amt,
            'settlement_fee' => $fee_amount, 
            'settlement_tax' => $gst_amount,
            'settlement_status' => 'Active',
            'settlement_date'  => date('Y-m-d'),
            'created_date' =>  Carbon::now(),
            'created_merchant' => $get_merchant_id,
            'updated_at' =>  Carbon::now(),
         ];

        $merchant_reports[$index] = $arr;

        $index++;


        }

        $insert_status =  DB::table('live_settlement')->insert($merchant_reports);

    }

    public function settlementFileUpload(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'settlement_file' => 'required|file|mimes:jpeg,png,jpg|max:2048', // Max 2MB and image file types
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => 'invalid file type/size'],200);
        }

        if ($request->hasFile('settlement_file')) {
            $file = $request->file('settlement_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('settlement'), $fileName);
            $update =  DB::table('live_settlement')->where('id',$request->settlement_record_id)->update(['receipt_url' => 'settlement/'.$fileName]);
            if($update)
            {
                return response()->json(['success' => 'file uploaded Successfully!!!']);
            }
            else{

            }
           
        } else {
            return response()->json(['error' => 'An error occurred while uploading the file'],200);
        }
    }


    public function PaidStatusUpdate(Request $request)
    {
       
       $update = Settlement::where('id',$request->settlement_id)->update(["status" => '1']);

       if($update)
       {
        return response()->json(['success' => 'Settlement is Marked as Paid'],200);
       }
       else{
        return response()->json(['error' => 'Something went wrong'],500);
       }

        
    }

    public function SettlementList()
    {

        // $data = Settlement::where('status','1')->orderBy('updated_at','desc')->get();
        $data = Settlement::where('status','1')->join('merchant','live_settlement.merchant','=','merchant.id')->select('live_settlement.*','merchant.name as merchant_name')->orderBy('updated_at','desc')->get();
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('merchant_name', function($row) {
                   return $row->merchant_name;
                })
                ->addColumn('settlement_id', function($row) {
                    return $row->report_id;
                })
                ->addColumn('settlement_report', function ($row) {
                    if (!is_null($row->receipt_url)) {
                        return '<a  href="'.asset($row->receipt_url).'" class="btn btn-primary excel_download">Download Excel</button>';
                    } else {
                        return '-';
                    }})
                ->addColumn('report_time', function($row) {
                    return $row->report_time;
                })
                ->addColumn('success_txn_count', function($row) {
                    return $row->success_txn_count;
                })
                ->addColumn('total_transaction_amount', function($row) {
                    return '₹ '.$row->total_txn_amount;
                })
                ->addColumn('merchant_fee', function($row) {
                    return $row->fee_amount;
                })
                ->addColumn('gst_amount', function($row) {
                    return number_format($row->tax_amount,2);
                })
                ->addColumn('settlement_amount', function($row) {
                    return $row->settlement_amount;
                })
                ->addColumn('created_at', function($row) {
                    return $row->created_at;
                })
                ->addColumn('completed_at', function($row){
                    return $row->updated_at;
                })
                // ->rawColumns(['action'])
                ->rawColumns(['settlement_report'])
                ->make(true);
    }
     
    public function ExcelFilereportGenerator($data){

        $fileName = $data[0]['merchant_id'].now()->format('YmdHis') . '.xlsx';
        $filePath = 'settlement/'.$data[0]['merchant_id'].'/'.date('Y-m-d')."/".$fileName;
    
        Log::channel('debug')->info("excel name log ".json_encode($data));

        Excel::store(new SettlementSuccessTxnExport($data), $filePath);
    
        return $filePath;
    }

    public function downloadExcel($filename)
    {
        $file = storage_path('app/settlement/' .$filename);

        return response()->download($file); 
    }

    public function test()
    {
        $current_time_in_ist = Carbon::now('Asia/Kolkata');

        $current_time_in_ist->second(0);
        $current_time_in_ist->minutes(0);

        $current_formatted_time = $current_time_in_ist->format('H:i:s');

        $current_slot = SettlementSlotTypes::all()->where('report_generate_time',$current_formatted_time)->toArray();

        // dd($current_slot);
        
        if(!empty($current_slot) && is_array($current_slot) && count($current_slot))
        {
          
        }
        else{
            echo "No settlement slot available !!!";
            die();
        }

        // echo "Current time : ".$current_formatted_time;

        // dd($current_slot);
        // echo "Current time : ".$formatted_time;

        // dd('afdsfdsafsdfds');
    }

  }
