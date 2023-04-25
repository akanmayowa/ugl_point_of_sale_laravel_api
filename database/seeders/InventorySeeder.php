<?php

namespace Database\Seeders;

use App\Models\Inventory;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class InventorySeeder extends Seeder
{

    public function run()
    {
        $faker = Faker::create();
        $counter = 0;
        while ($counter <= 20) {
            Inventory::create([
                'name' => $faker->title,
                'quantity' => $faker->numberBetween(1, 50),
                'category_id' => $faker->numberBetween(1, 5),
                'price' => $faker->randomNumber(6),
                'dealer_price' => $faker->randomNumber(6),
                'staff_price' =>  $faker->randomNumber(6),
                'cylinder_type' => $faker->numberBetween(1, 50),
                'barcode' => $faker->ean13(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            $counter++;
        }
    }
}
