<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('customers')->insert(array(
            array(
                'customer_no' => '1',
                'customer_name' => 'aden',
                'customer_address' => 'defence',
                'customer_cnic' => '44444-4444444-4',
                'customer_contact' => '88888888884',
                'customer_email' => 'adenpervaiz05@gmail.com',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
            array(
               'customer_no' => '2',
                'customer_name' => 'ali',
                'customer_address' => 'bahria town',
                'customer_cnic' => '22223-4444444-4',
                'customer_contact' => '18888228856',
                'customer_email' => 'aliimran@gmail.com',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
             array(
                'customer_no' => '3',
                'customer_name' => 'danish',
                'customer_address' => 'walton',
                'customer_cnic' => '33333-3333333-3',
                'customer_contact' => '03446754611',
                'customer_email' => 'danishvigilantlabs@gmail.com',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
              array(
                'customer_no' => '4',
                'customer_name' => 'liaana',
                'customer_address' => 'cantt',
                'customer_cnic' => '56567-4444444-9',
                'customer_contact' => '98987656456',
                'customer_email' => 'lianajacki@yahoo.com',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
               array(
                'customer_no' => '5',
                'customer_name' => 'jackson',
                'customer_address' => 'grand avenue',
                'customer_cnic' => '55555-4444444-5',
                'customer_contact' => '67544959101',
                'customer_email' => 'jackithegreat@gmail.com',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
                array(
                'customer_no' => '6',
                'customer_name' => 'reyan',
                'customer_address' => 'shahjamal',
                'customer_cnic' => '23232-3232323-3',
                'customer_contact' => '03104514161',
                'customer_email' => 'reyanemmi@gmail.com',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            )
        ));
    }
}

