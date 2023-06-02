<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class FinanceReceivablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('finance_payment_receivables')->insert(array(
            array(
                'code' => '1',
                'desc' => 'New Membership',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
            array(
                'code' => '2',
                'desc' => 'Guest Entrance Fees',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
            array(
                'code' => '3',
                'desc' => 'Supplementary Card',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
            array(
                'code' => '4',
                'desc' => 'Duplicate Card',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
            array(
                'code' => '5',
                'desc' => 'Monthly Maintenance',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
             array(
                'code' => '6',
                'desc' => 'Booking',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            )

        ));
    }
}