<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PayinTransactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CalculateTransactionStatistics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculate:transaction-statistics';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate and store transaction statistics';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
    // return Command::SUCCESS;


            // Set the end time to the current time
            $endTime = now();

            // Set the start time to 30 minutes before the end time
            $startTime = $endTime->copy()->subMinutes(30);

            $merchants = DB::table('merchant')
            ->join('user_keys', 'user_keys.mid', '=', 'merchant.id')
            ->get();

            $totalTransactionsAll = PayinTransactions::whereBetween('created_at', [$startTime, $endTime])
            ->whereIn('txn_status', ['2', '0'])->count();
            $successTransactionsAll = PayinTransactions::where('txn_status', '2')->whereBetween('created_at', [$startTime, $endTime])->count();
            $successRatioAll = ($totalTransactionsAll > 0) ? ($successTransactionsAll / $totalTransactionsAll) * 100 : 0;

            $successRatioAll = is_nan($successRatioAll) ? 0 : $successRatioAll;
        
            DB::table('all_success_ratios')->insert([
                'start_time' => $startTime,
                'end_time' => $endTime,
                'total_transactions' => $totalTransactionsAll,
                'success_transactions' => $successTransactionsAll,
                'success_ratio' => $successRatioAll,
                'created_at' => now(),
            ]);

            
            $index=0;
            foreach ($merchants as $merchant) {
                $totalTransactions = PayinTransactions::where('merchant_id', $merchant->prod_mid)
                    ->whereIn('txn_status', ['2', '0'])
                    ->whereBetween('created_at', [$startTime, $endTime])
                    ->count();
        
                $successTransactions = PayinTransactions::where('merchant_id', $merchant->prod_mid)
                    ->where('txn_status', '2')
                    ->whereBetween('created_at', [$startTime, $endTime])
                    ->count();
        
                $successRatio = ($totalTransactions > 0) ? ($successTransactions / $totalTransactions) * 100 : 0;
                $successRatio = is_nan($successRatio) ? 0 : $successRatio;

          
                $bulkData[$index] = [
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                    'total_transactions' => $totalTransactions,
                    'success_transactions' => $successTransactions,
                    'success_ratio' => $successRatio,
                    'created_at' => now(),
                    'merchant_id' => $merchant->mid,
                ];

                $index++;
         }

        //  dd($bulkData);
        // $this->info('response '.json_encode($bulkData));

        // Log::channel('debug')->info('response '.json_encode($bulkData));
         DB::table('success_ratios')->insert($bulkData);

    $this->info('Transaction statistics calculated and stored successfully.');
    }
}
