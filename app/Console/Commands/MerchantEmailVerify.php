<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use DateTime;


class MerchantEmailVerify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'merchantemailverify:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'lock the merchant\'s account which are not verified by email with in one day';

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
    }
}
