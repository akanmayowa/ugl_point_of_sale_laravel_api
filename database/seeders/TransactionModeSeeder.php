<?php

namespace Database\Seeders;

use App\Models\TransactionMode;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TransactionModeSeeder extends Seeder
{

    public function run()
    {
        $counter = 0;
        while ($counter <= 4) {
            TransactionMode::create([
                'transaction_mode' => 'Cash',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            TransactionMode::create([
                'transaction_mode' =>  'POS',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            TransactionMode::create([
                'transaction_mode' =>  'Transfer',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            TransactionMode::create([
                'transaction_mode' => 'Others',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            $counter++;
        }
    }
}
