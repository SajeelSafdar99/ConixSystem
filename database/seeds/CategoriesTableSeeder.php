<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mem_categories')->insert(array(
            array(
                'code' => '001',
                'unique_code' => 'SO',
                'desc' => 'Serving Armed Forces Officers',
                'fee' => '10000',
                'monthly_sub_fee' => '1000',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
            array(
                 'code' => '002',
                'unique_code' => 'CS',
                'desc' => 'Civil Services Officers (Grade 19 and above)',
                'fee' => '150000',
                'monthly_sub_fee' => '1500',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
             array(
                 'code' => '003',
                'unique_code' => 'FR',
                'desc' => 'Resident of Falcon Complex',
                'fee' => '100000',
                'monthly_sub_fee' => '2500',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
              array(
                 'code' => '004',
                'unique_code' => 'AE',
                'desc' => 'Associate Membership',
                'fee' => '300000',
                'monthly_sub_fee' => '3500',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
               array(
                'code' => '005',
                'unique_code' => 'OP',
                'desc' => 'Diplomats / Foreigners',
                'fee' => '250000',
                'monthly_sub_fee' => '2500',
                'status' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
                array(
                 'code' => '006',
                'unique_code' => 'CO',
                'desc' => 'Corporate Membership',
                'fee' => '1000000',
                'monthly_sub_fee' => '1500',
                'status' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
               array(
                'code' => '007',
                'unique_code' => 'AE/D',
                'desc' => 'Associate Discounted',
                'fee' => '75000',
                'monthly_sub_fee' => '3500',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
             array(
                'code' => '008',
                'unique_code' => 'FR/D',
                'desc' => 'Falcon Resident Discounted',
                'fee' => '75000',
                'monthly_sub_fee' => '3500',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
             array(
                'code' => '009',
                'unique_code' => 'DI',
                'desc' => 'Dining Membership',
                'fee' => '50000',
                'monthly_sub_fee' => '3000',
                'status' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
             array(
                'code' => '0010',
                'unique_code' => 'SP',
                'desc' => 'Sports Membership',
                'fee' => '50000',
                'monthly_sub_fee' => '3000',
                'status' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
              array(
                'code' => '0011',
                'unique_code' => 'HY',
                'desc' => 'Honorary Member (for Allocated VVIPs only)',
                'fee' => '10000',
                'monthly_sub_fee' => '500',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
             array(
                'code' => '0012',
                'unique_code' => 'AF',
                'desc' => 'Retired Armed Forces Officers',
                'fee' => '10000',
                'monthly_sub_fee' => '1500',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            )

        ));
    }
}
