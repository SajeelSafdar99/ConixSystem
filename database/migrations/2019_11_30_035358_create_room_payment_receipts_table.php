<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomPaymentReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */ 
    public function up()
    {
        Schema::create('room_payment_receipts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('booking_id')->unsigned()->nullable();
            $table->foreign('booking_id')->references('id')->on('room_bookings')->onDelete('set null')->onUpdate('cascade');

            $table->bigInteger('customer_id')->unsigned()->nullable();

            $table->string('invoice_no')->unique()->nullable();
             $table->string('invoice_date')->nullable();
              $table->string('guest_name')->nullable();
                  $table->string('mem_number')->nullable();
                  $table->string('guest_address')->nullable();
                   $table->string('guest_contact')->nullable(); 
                   $table->string('ledger_amount')->nullable();

           //     $table->string('start_date')->nullable();
           //     $table->string('end_date')->nullable();
 
              $table->string('payment_received_for')->nullable();    
          //    $table->string('subscriptions')->nullable();
               $table->string('total_amount')->nullable();
          //    $table->string('total_sub_amount')->nullable();
              $table->string('surcharge')->nullable();
          //    $table->string('discount')->nullable();
              $table->string('total')->nullable();

              $table->string('payment_method')->nullable();
              $table->string('cheaque_no')->nullable();
              
              $table->string('payment_details')->nullable();
              $table->string('remarks')->nullable();
              $table->string('amount_in_words')->nullable();

            
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
        Schema::dropIfExists('room_payment_receipts');
    }
}
