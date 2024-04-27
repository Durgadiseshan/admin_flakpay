<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Carbon\Carbon;
use DB;
class MerchantGstInvoice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'merchantgstinvoice:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

         $settlement = new \App\Settlement('live');

       $results= $settlement->select(
                "id" ,"created_merchant",
                "settlement_date","settlement_receiptno",
                DB::raw("(sum(settlement_fee)) as total_fee"),
                DB::raw("(sum(settlement_tax)) as total_tax"),
                DB::raw("(DATE_FORMAT(settlement_date, '%d-%m-%Y')) as my_date")
                            )
        //->where('created_merchant',Auth::user()->id)
       ->where('settlement_receiptno',"=","")
        ->groupBy([DB::raw("DATE_FORMAT(settlement_date, '%d-%m-%Y')"),"created_merchant"])
        ->orderBy('id','asc')

        ->get();
     //  dd($results);
        foreach($results as $result){
           // sleep(3);
            //check if alreay entry for date and merchant
        $db = $settlement->where('created_merchant',$result->created_merchant);
        $db->whereDate('settlement_date', Carbon::parse($result->my_date)->format('Y-m-d'));
        $db->where('settlement_receiptno',"!=","");
        $data=$db->first();
       
          if($data){
            $settlement_receiptno=$data->settlement_receiptno;
            $splitArray=explode('-',$settlement_receiptno);
            $count=$splitArray[1];

            $updateDataQuery = $settlement->where('created_merchant',$result->created_merchant)->whereDate('settlement_date', Carbon::parse($result->my_date)->format('Y-m-d'))
            ->update([
                    'settlement_receiptno' =>$data->settlement_receiptno,
                    'settlement_receiptno_count' =>$count
                ]);

                   
         }else{

            
          $newdb = $settlement->where('settlement_receiptno',"!=","");
          $newdb->orderBy('settlement_receiptno_count','desc');
          $lastEntry=$newdb->first();
         
          $gbid=0;
           if($lastEntry){
            $settlement_receiptno=$lastEntry->settlement_receiptno;
            $splitArray=explode('-',$settlement_receiptno);
            $gbid=$splitArray[1];
           }

           $gbid1=$gbid+1;
            
            $bid= 'IND'.date('dmy')."-".str_pad($gbid1,3,"0",STR_PAD_LEFT);
           

            $updateDataQuery = $settlement->where('created_merchant',$result->created_merchant)->whereDate('settlement_date', Carbon::parse($result->my_date)->format('Y-m-d'))
            ->update([
                    'settlement_receiptno' =>$bid,
                    'settlement_receiptno_count'=>$gbid1
                ]);
           
         }
        }

        \Log::info("Cron is working fine!".date('Y-m-d h:m:i'));


    }
}
