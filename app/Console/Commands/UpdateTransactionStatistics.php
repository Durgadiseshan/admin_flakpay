<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PayinTransactions;

class UpdateTransactionStatistics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'command:name';
    protected $signature = 'calculate:transaction-statistics';
    protected $description = 'Calculate and store transaction statistics';

    /**
     * The console command description.
     *
     * @var string
     */
    // protected $description = 'Command description';

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
        //

                // Get the current time range (e.g., 09:00 - 09:30)
                $startTime = now()->startOfHour();
                $endTime = now()->startOfHour()->addMinutes(30);
        
                // Calculate total and successful transactions
                $totalTransactions = PayinTransactions::whereBetween('created_at', [$startTime, $endTime])->count();
                $successTransactions = PayinTransactions::whereBetween('created_at', [$startTime, $endTime])->where('txn_status', '2')->count();
        
                // Calculate success ratio
                $successRatio = ($totalTransactions > 0) ? ($successTransactions / $totalTransactions) * 100 : 0;
        
                // Store the statistics in the database
                Statistics::create([
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                    'total_transactions' => $totalTransactions,
                    'success_transactions' => $successTransactions,
                    'success_ratio' => $successRatio,
                ]);
        
                $this->info('Transaction statistics calculated and stored successfully.');
    }
}
