<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RoomBookingsPaymentmethodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('room_bookings', function (Blueprint $table) {
        $table->string('payment_mode_details')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('room_bookings', function (Blueprint $table) {
        $table->string('payment_mode_details')->nullable();
        });
    }
}
