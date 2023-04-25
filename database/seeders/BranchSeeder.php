<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Customer;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{

    public function run()
    {
     $faker = Faker::create();
        $counter = 0;
        while ($counter <= 3) {
            Branch::create([
                'name' => 'UGL-PH',
                'phone_no' => '0802344898774',
                'email' => 'admin_ph@ugl-gas.com',
                'address' => 'PH Nigeria`',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);


            Branch::create([
                'name' => 'UGL-Abuja',
                'phone_no' => '08023898774',
                'email' => 'admin_abuja@ugl-gas.com',
                'address' => 'Abuja Nigeria`',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);


            Branch::create([
                'name' => 'UGL-Jos',
                'phone_no' => '080423898774',
                'email' => 'admin_jos@ugl-gas.com',
                'address' => 'Jos Nigeria`',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            $counter++;
        }
    }
}
