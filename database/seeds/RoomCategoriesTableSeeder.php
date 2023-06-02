<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RoomCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('room_categories')->insert(array(
            array(
                'code' => '001',
                'desc' => 'Armed Forces',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
             array(
                'code' => '002',
                'desc' => 'Civil Officers',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
              array(
                'code' => '003',
                'desc' => 'Foreigners',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
               array(
                'code' => '004',
                'desc' => 'Non Member',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
                array(
                'code' => '005',
                'desc' => 'Staff',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
             array( 
                'code' => '006',
                'desc' => 'Booking.com',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            )

        ));
    }
}
