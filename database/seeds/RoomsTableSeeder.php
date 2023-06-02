<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;


class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('rooms')->insert(array(
            array(
                'code' => '001',
                'room_no' => '101',
                'room_type' => 'Deluxe',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
             array(
                'code' => '002',
                'room_no' => '102',
                'room_type' => 'Deluxe',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
              array(
                'code' => '003',
                'room_no' => '103',
                'room_type' => 'Deluxe',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
              array(
                'code' => '004',
                'room_no' => '104',
                'room_type' => 'Executive',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
               array(
                'code' => '005',
                'room_no' => '105',
                'room_type' => 'Executive',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
                array(
                'code' => '006',
                'room_no' => '106',
                'room_type' => 'Executive',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            )
            
        ));
    }
}
