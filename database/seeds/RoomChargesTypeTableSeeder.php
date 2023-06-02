<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RoomChargesTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run()
    {
         DB::table('room_charges_types')->insert(array(
            array(
                'code' => '001',
                'type' => 'Service Charges',
                'charges' => '100',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
             array(
                'code' => '002',
                'type' => 'Billiard / Gaming Room',
                'charges' => '150',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
              array(
                'code' => '003',
                'type' => 'Mattress',
                'charges' => '500',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
              array(
                'code' => '004',
                'type' => 'AC',
                'charges' => '500',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
               array(
                'code' => '005',
                'type' => 'Gym',
                'charges' => '200',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
                array(
                'code' => '006',
                'type' => 'Swimming Pool',
                'charges' => '500',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
              array(
                'code' => '007',
                'type' => 'Mini Bar',
                'charges' => '0',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            )
        ));
    }
}