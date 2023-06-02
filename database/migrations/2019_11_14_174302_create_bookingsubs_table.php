<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookingsubs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('booking_id')->nullable();
            $table->bigInteger('charges_type_id')->nullable();
            $table->string('bill_details')->nullable();
            $table->bigInteger('charges_amount')->nullable();
            $table->string('iscomplementary')->nullable();
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
        Schema::dropIfExists('bookingsubs');
    }
}
