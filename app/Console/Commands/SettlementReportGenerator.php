<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PayinTransactions;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\MerchantSettlementOption;
use App\Http\Controllers\Admin\SettlementController;
use App\Settlement;
class SettlementReportGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'settlementreportgenerator:daily {--type=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genenarate settlement For Every 2 hours';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(){
        $type = $this->option('type');

        $currentTime = Carbon::now();
        $end_time = Carbon::now();
        $time = Carbon::parse($end_time);
        $time_arr = [];
        $today = Carbon::today();
        $merchant_onehour_stmt = MerchantSettlementOption::join('user_keys','merchant_settlement_option.mid','user_keys.mid')->where('merchant_settlement_option.type_id','1')->get()->pluck('prod_mid')->toArray();

        if($type == '1')
        {
            $type_id = 1;

            $end_time = $time->second(0)->subMinutes(10)->subSeconds(1);
            $start_time = $currentTime->subHours(1)->subMinutes(10);
            $start_time = $start_time->second(0);

            $one_hour_start_time = Carbon::parse($start_time)->format('h:i:s A');
            $endDateTime = Carbon::parse($end_time)->format('h:i:s A');

            $time_arr  = $one_hour_start_time." - ".$endDateTime;

            $merchant_trxns = PayinTransactions::select('merchant.name','payin_transactions.customer_name','payin_transactions.mobile_no','payin_transactions.email','payin_transactions.amount','payin_transactions.order_id','payin_transactions.fpay_trxnid','payin_transactions.evok_txnid','payin_transactions.rrn_no','payin_transactions.acqrbank_txnid','payin_transactions.created_at','payin_transactions.updated_at','payin_transactions.merchant_id','user_keys.mid')->join('user_keys','payin_transactions.merchant_id','user_keys.prod_mid')
            ->join('merchant','user_keys.mid','merchant.id')->whereIn('payin_transactions.merchant_id',$merchant_onehour_stmt)->where('txn_status','2')->whereDate('created_at', $today)->whereBetween('created_at', [$start_time, $end_time])->get(['payin_transactions.amount','user_keys.mid'])->groupBy('merchant_id')->toArray();

            Log::channel('debug')->info(" start time  ".$start_time.' end time : '.$end_time);

            Log::channel('debug')->info("merchant transactions  cron ".json_encode($merchant_trxns));
        }

       $merchant_reports = [];

       $report_count = 0;
       $index = 0;
      
       if(is_array($merchant_trxns) && count($merchant_trxns) > 0 )
        {

         foreach($merchant_trxns as $merchant_id=>$TXN)
         {

            Log::channel('debug')->info("txn record   ".json_encode($TXN));

            if(!is_null($TXN)  && !empty($TXN))
            {
            $settlement     = new Settlement();
            $settlementExpo = new SettlementController($settlement);
            $file_path      = $settlementExpo->ExcelFilereportGenerator($TXN);
            }

            $total_success_txn_count = count($TXN);
            $totalamount = array_column($TXN, 'amount'); 
            $total_succfultxn_amt = array_sum($totalamount);

            Log::channel('settlementlog')->info("settlement report time ".$time_arr[$report_count]);

            $random_id =  "FPAYSMT".$merchant_id.time().Str::random(8);
            $settlement_report_id = substr($random_id, 0, 30);

            $merchant_fee_percentage = MerchantSettlementOption::where('mid',$TXN[0]['mid'])->get()->pluck('settlement_fee')->toArray();

            $merchant_fee_percentage = $merchant_fee_percentage[0]/100;
            $fee_amount = $total_succfultxn_amt * $merchant_fee_percentage;
            $gst_amount = $fee_amount * 0.18;

        $arr =  [
            'report_id'=>$settlement_report_id,
            'receipt_url' => $file_path,
            'total_txn_amount' => $total_succfultxn_amt,
            'settlement_amount' => $total_succfultxn_amt - ( $fee_amount + $gst_amount ),
            'fee_amount' => $fee_amount, 
            'tax_amount' => $gst_amount,
            'success_txn_count' => $total_success_txn_count,
            'status' => '0',
            'type_id' => $type_id,
            'report_time'  => $time_arr,
            'created_at' =>  Carbon::now(),
            'merchant' => $TXN[0]['mid'],
            ];

        $merchant_reports[$index] = $arr;
 
        Log::channel('settlementlog')->info("insert record  ".json_encode($arr));

                 $index++;
            }

 
        $insert_status =  DB::table('live_settlement')->insert($merchant_reports);

       Log::channel('settlementlog')->info("settlement report inserted Successfully ".json_encode($merchant_trxns).'insert : '.$insert_status);
    }
    }
}
