<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bank;
use Carbon\Carbon;
use Faker\Factory as Faker;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $bank_name = ["First Bank","Gtbank","Access Bank","Polaris Bank"," Kuda Bank"];
        $counter = 0;
        while ($counter <= 10) {
            Bank::create([
                'name'=> $bank_name[rand(0,4)],
                'acn_name' => $faker->lastName." ".$faker->firstName,
                'acn_no' => $faker->creditCardNumber,
            ]);
            $counter++;
        }
    }
}
