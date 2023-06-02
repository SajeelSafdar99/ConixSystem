<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SportsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run()
    {
        DB::table('sports_subscriptions')->insert(array(
            array(
                'code' => '1',
                'desc' => 'Gym',
                'charges' => '200',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
            array(
                'code' => '2',
                'desc' => 'Swimming Pool',
                'charges' => '500',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
            array(
                'code' => '3',
                'desc' => 'Snooker',
                'charges' => '100',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
            array(
                'code' => '4',
                'desc' => 'Gaming Zone',
                'charges' => '600',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
            array(
                'code' => '5',
                'desc' => 'Sauna / Steam',
                'charges' => '300',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
             array(
                'code' => '6',
                'desc' => 'Other',
                'charges' => '0',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            )

        ));
    }
}