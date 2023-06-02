<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BookingTableAlter extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('room_bookings',function (Blueprint $table){
            $table->integer('customer_id')->nullable();
            $table->integer('member_id')->nullable();
        });
        $c=\App\customer::get();
        foreach ($c as $cs){
            $d=\App\room_payment_receipt::where('guest_name',$cs->customer_name)->get();
        foreach($d as $x){
            $x->customer_id=$cs->id;
            $x->save();
        }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('room_bookings',function (Blueprint $table){
            $table->dropColumn('customer_id');
            $table->dropColumn('member_id');
        });
    }
}
