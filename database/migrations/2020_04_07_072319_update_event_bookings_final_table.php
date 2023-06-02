<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEventBookingsFinalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_bookings',function(Blueprint $table){
             $table->string('total_addon_charges')->nullable();
              $table->string('total_per_person_charges')->nullable();
            $table->string('extra_guests')->nullable();
              $table->string('extra_food_charges')->nullable();
              $table->string('grand_guest_charges')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('event_bookings',function(Blueprint $table){
            $table->dropColumn('total_addon_charges');
            $table->dropColumn('total_per_person_charges');
            $table->dropColumn('extra_guests');
            $table->dropColumn('extra_food_charges');
            $table->dropColumn('grand_guest_charges');
        });
    }
}
