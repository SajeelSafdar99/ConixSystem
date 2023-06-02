<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFnbCakeBookingsOneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::table('fnb_cake_bookings', function (Blueprint $table) {
            $table->bigInteger('advance_paid')->nullable();
            $table->bigInteger('balance_amount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fnb_cake_bookings',function(Blueprint $table){
            $table->dropColumn('advance_paid');
            $table->dropColumn('balance_amount');
        });
    }
}
