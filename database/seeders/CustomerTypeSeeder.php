<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CustomerTypeSeeder extends Seeder
{
   public function run()
    {
                \App\Models\CustomerType::create([
                    'types' => 'retail',
                    'price_type' => 'ps1',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                \App\Models\CustomerType::create([
                    'types' =>  'credit',
                    'price_type' => 'ps2',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                \App\Models\CustomerType::create([
                    'types' => 'debit',
                    'price_type' => 'ps3',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);

                \App\Models\CustomerType::create([
                    'types' => 'walk in customer',
                    'price_type' => 'ps3',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);

    }
}
