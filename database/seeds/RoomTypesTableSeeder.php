<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RoomTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
  public function run()
    {
         DB::table('room_types')->insert(array(
            array(
                'code' => '001',
                'desc' => 'Deluxe',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
             array(
                'code' => '002',
                'desc' => 'Executive',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            )

        ));
    }
}