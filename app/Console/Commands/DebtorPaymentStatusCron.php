<?php

namespace App\Console\Commands;

use App\Helpers\DebtorPaymentStatusHelpers;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DebtorPaymentStatusCron extends Command
{

    protected $signature = 'debtor_status_update:cron';


    protected $description = 'Command description';


    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        Log::info("Testing Debtor Payment Status Cron is Running ... !");
        $this->info('debtor_status_update:cron Command Run Successfully !');
        return DebtorPaymentStatusHelpers::checkDebtStatus();
    }
}
