<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEventBookingSurchargeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_bookings',function(Blueprint $table){
             $table->string('surcharge')->nullable();
            $table->string('surcharge_percentage')->nullable();
            $table->string('surcharge_details')->nullable();
             $table->string('surcharge_total')->nullable();
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
            $table->dropColumn('surcharge');
            $table->dropColumn('surcharge_percentage');
            $table->dropColumn('surcharge_details');
            $table->dropColumn('surcharge_total');
        });
    }
}
