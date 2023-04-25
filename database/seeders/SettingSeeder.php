<?php

namespace Database\Seeders;

use App\Models\PaymentDuration;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{

    public function run()
    {
            Setting::create([
                'name' => 'UGL-GAS',
                'address' => 'Ikoyi Lagos',
                'email' => 'admin@ugl-gas.com.ng',
                'phone_number' => '0802378183',
                'tax_rate' => 4,
                'tax_name' => 'lagos tax system',
                'low_stock_alert' => 10,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
    }
}
