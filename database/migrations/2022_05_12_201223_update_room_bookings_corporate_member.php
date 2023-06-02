<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRoomBookingsCorporateMember extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::table('room_bookings',function (Blueprint $table){
            $table->integer('corporate_id')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    { 

       Schema::table('room_bookings',function (Blueprint $table){
            $table->dropColumn('corporate_id');
  
        });
         
        
    }
}
