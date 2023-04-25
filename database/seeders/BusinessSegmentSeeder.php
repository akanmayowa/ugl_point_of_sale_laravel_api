<?php

namespace Database\Seeders;

use App\Models\BusinessSegment;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;


class BusinessSegmentSeeder extends Seeder
{

    public function run()
    {

           DB::table('business_segments')->insert([
              [  'name' =>  'bs1',
                'description' => 'business Segment description',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
              [  'name' =>  'bs2',
               'description' => 'business Segment description',
               'created_at' => Carbon::now(),
               'updated_at' => Carbon::now(),
           ],
           [  'name' =>  'bs3',
                'description' => 'business Segment description',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
           ]);



    }

}
