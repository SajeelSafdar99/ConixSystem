<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_bookings', function (Blueprint $table) {
             $table->bigIncrements('id');

              $table->string('booking_no')->unique()->nullable();
               $table->string('booking_date')->nullable();
              $table->string('check_in_date')->nullable();
                $table->string('arrival_details')->nullable();
              $table->string('check_out_date')->nullable();
              $table->string('departure_details')->nullable();

              $table->string('first_name')->nullable();
               $table->string('last_name')->nullable();
               $table->string('guest_company')->nullable();
               $table->string('guest_address')->nullable();
               $table->string('guest_country')->nullable();
               $table->string('guest_city')->nullable();
               $table->string('guest_mob')->nullable();
               $table->string('guest_email')->nullable();
               $table->string('guest_cnic')->nullable();
               $table->string('accompained_guest')->nullable();
              $table->string('acc_relationship')->nullable();
              $table->string('acc_cnic')->nullable();

                 $table->string('booked_by')->nullable();
                 $table->boolean('booking_type')->nullable();
                 $table->string('moc_name')->nullable();
                  $table->string('moc_address')->nullable();
                  $table->string('moc_cnic')->nullable();
                   $table->string('moc_mob')->nullable(); 
                   $table->string('moc_email')->nullable();
               
              $table->string('room')->nullable();
              $table->string('category')->nullable();
              $table->string('pday_charges_id')->nullable();
              $table->string('nights')->nullable();
              $table->string('charges')->nullable();
              $table->string('security')->nullable();

                $table->string('total_room_charges')->nullable();
                
                $table->string('total_charges')->nullable();
                $table->string('discount_amount')->nullable();
                 $table->string('discount_details')->nullable();

                $table->string('grand_total')->nullable();
                $table->enum('payment_mode', ['Cash', 'Credit Card', 'Cheaque', 'Other'])->default('Cash')->nullable();
                $table->string('advance_paid')->nullable();
                $table->string('total_balance')->nullable();
                $table->text('booking_docs')->nullable();
                $table->string('additional_notes')->nullable();

            $table->string('check_inn_date')->nullable();
            $table->string('check_in_time')->nullable();
            $table->string('check_out_time')->nullable();
            $table->string('amount_paid')->nullable();
            $table->string('grand_balance')->nullable();
            $table->boolean('check_out_status')->nullable();
            $table->boolean('status')->nullable();
            
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
        Schema::dropIfExists('room_bookings');
    }
}
