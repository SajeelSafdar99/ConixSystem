<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomCheckOutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_check_outs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('booking_id')->unsigned()->nullable();
             $table->foreign('booking_id')->references('id')->on('room_bookings')->onDelete('set null')->onUpdate('cascade');

            $table->string('check_out_time')->nullable();
             $table->string('amount_paid')->nullable();
            $table->string('grand_balance')->nullable();
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
        Schema::dropIfExists('room_check_outs');
    }
}
