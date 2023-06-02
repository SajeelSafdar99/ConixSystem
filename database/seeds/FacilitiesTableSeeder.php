<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class FacilitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('mem_club_facilities')->insert(array(
            array(
                'code' => '001',
                'desc' => 'Gym',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
            array(
                'code' => '002',
                'desc' => 'Food Charges',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
             array(
                'code' => '003',
                'desc' => 'Sports Charges',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
              array(
                'code' => '004',
                'desc' => 'Fine',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
               array(
                'code' => '005',
                'desc' => 'Misc.',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
                array(
                'code' => '006',
                'desc' => 'Swimming Pool',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
               array(
                'code' => '007',
                'desc' => 'Steam / Sauna Room',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
             array(
                'code' => '008',
                'desc' => 'Billiard / Gaming Room',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
             array(
                'code' => '009',
                'desc' => 'Breakfast / Meals',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
             array(
                'code' => '0010',
                'desc' => 'Mini Bar',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
             array(
                'code' => '0011',
                'desc' => 'Mattress',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
             array(
                'code' => '0012',
                'desc' => 'Dry Cleaning / Ironing',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
              array(
                'code' => '0013',
                'desc' => 'Boot Polishing',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
               array(
                'code' => '0014',
                'desc' => 'AirPort Pick Up Charges',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
               array(
                'code' => '0015',
                'desc' => 'AirPort Drop Off Charges',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            )

        ));
    }
}
