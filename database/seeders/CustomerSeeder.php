<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Inventory;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{

    public function run()
    {
        $faker = Faker::create();
        $counter = 0;
        while ($counter <= 20) {
            Customer::create([
                'name' =>  $faker->unique()->firstName." ".$faker->unique()->lastName,
                'email' => $faker->unique()->email,
                'phone_number' => $faker->phoneNumber,
                'customer_type_id' => $faker->numberBetween(1, 5),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            $counter++;
        }
    }
}
