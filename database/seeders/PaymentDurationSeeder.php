<?php

namespace Database\Seeders;

use App\Models\PaymentDuration;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PaymentDurationSeeder extends Seeder
{

    public function run()
    {
        $counter = 0;
        while ($counter <= 4)
        {
            PaymentDuration::create([
                'duration' => '1 month',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            PaymentDuration::create([
                'duration' => '2 month',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            PaymentDuration::create([
                'duration' => '3 month',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            PaymentDuration::create([
                'duration' => '4 month',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            $counter++;
        }
    }

}
