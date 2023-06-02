<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EventBookingaddonsubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('event_bookingaddonsubs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('booking_id')->nullable();
            $table->bigInteger('add_on_name')->nullable();
            $table->string('addon_bill_details')->nullable();
            $table->bigInteger('add_on_charges')->nullable();
            $table->string('addoncomplementary')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_bookingaddonsubs');
    }
}
