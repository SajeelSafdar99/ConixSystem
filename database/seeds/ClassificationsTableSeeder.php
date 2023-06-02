<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class ClassificationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('mem_classifications')->insert(array(
            array(
                'code' => '001',
                'desc' => 'Regular',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
            array(
                'code' => '002',
                'desc' => 'Permanent',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
             array(
                'code' => '003',
                'desc' => 'Temporary',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
              array(
                'code' => '004',
                'desc' => 'Honourary',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
               array(
                'code' => '005',
                'desc' => 'Sports Based',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
                array(
                'code' => '006',
                'desc' => 'Discounted',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
               array(
                'code' => '007',
                'desc' => 'Family Discount',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
             array(
                'code' => '008',
                'desc' => 'Shaheed Discount',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
             array(
                'code' => '009',
                'desc' => 'Cancelled',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
             array(
                'code' => '0010',
                'desc' => 'Club Employee',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
             array(
                'code' => '0011',
                'desc' => 'On Hold',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            )

        ));
    }
}
