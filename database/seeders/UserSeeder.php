<?php

namespace Database\Seeders;

use App\Enums\UserRoleEnums;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{

    public function run()
    {
        $faker = Faker::create();
        $counter = 0;
        while ($counter <= 20) {
            User::create([
                'staff_id' => uniqid('user_'),
                'phone_no' => $faker->e164PhoneNumber,
                'gender' => $faker->randomElement(['male', 'female']),
                'branch' => $faker->city,
                'first_name' => $faker->unique()->firstName,
                'last_name' => $faker->unique()->lastName,
                'email' => $faker->unique()->email,
                'password' => bcrypt('123456'),
                'user_role' => $faker->randomElement([UserRoleEnums::Admin, UserRoleEnums::Cashier]),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            $counter++;
            $this->adminUser($faker);
        }

    }

    public function adminUser(Faker $faker)
    {
        User::create([
            'staff_id' => uniqid('user_'),
            'phone_no' => $faker->e164PhoneNumber,
            'gender' => $faker->randomElement(['male','female']),
            'branch' => 'Lagos',
            'first_name' => 'akan',
            'last_name' => 'mayowa',
            'email' => 'akanmayowa@yahoo.com',
            'password' => bcrypt('123456'),
            'user_role' => $faker->randomElement([UserRoleEnums::Admin, UserRoleEnums::Cashier]),
            'created_at' => Carbon::now(),
            'updated_at'=> Carbon::now(),
        ]);
    }
}
