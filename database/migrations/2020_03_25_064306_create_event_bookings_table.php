<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('booking_no')->unique()->nullable();
            $table->date('booking_date')->nullable();
            
                 $table->boolean('booking_type')->nullable();
                  $table->integer('customer_id')->nullable();
            $table->integer('member_id')->nullable();
            $table->string('moc_name')->nullable();
                  $table->string('moc_address')->nullable();
                  $table->string('moc_cnic')->nullable();
                   $table->string('moc_mob')->nullable(); 
                   $table->string('moc_email')->nullable();
                   $table->string('ledger_amount')->nullable(); 
                   $table->string('family')->nullable();

            $table->string('booked_by')->nullable();
            $table->string('nature_of_event')->nullable();
            $table->date('event_date')->nullable();
            $table->time('from')->nullable();
            $table->time('to')->nullable();
            $table->string('venue')->nullable();
            $table->string('menu')->nullable();
            $table->string('menu_category')->nullable();

            $table->string('menu_charges')->nullable();
              $table->string('guests')->nullable();
              $table->string('total_food_charges')->nullable();
              $table->string('total_other_charges')->nullable();

              $table->string('total_charges')->nullable();
                $table->string('discount_amount')->nullable();
                 $table->string('discount_details')->nullable();
                $table->string('grand_total')->nullable();
                $table->string('payment_mode')->nullable();
                $table->string('payment_mode_details')->nullable();

                $table->string('advance_paid')->nullable();
                $table->string('total_balance')->nullable();
                $table->text('booking_docs')->nullable();
                $table->string('additional_notes')->nullable();

                $table->string('amount_paid')->nullable();
            $table->string('grand_balance')->nullable();
            $table->boolean('check_out_status')->nullable();

            $table->softDeletes();
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
        Schema::dropIfExists('event_bookings');
    }
}
