<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinancePaymentReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finance_payment_receipts', function (Blueprint $table) {
            $table->bigIncrements('id');

             $table->bigInteger('customer_id')->nullable();
            $table->string('invoice_no')->unique()->nullable();
             $table->string('invoice_date')->nullable();
              $table->string('guest_name')->nullable();
                  $table->bigInteger('mem_number')->nullable();
                  $table->string('guest_address')->nullable();
                   $table->string('guest_contact')->nullable(); 
                   $table->string('ledger_amount')->nullable();
                   $table->string('family')->nullable();
              $table->bigInteger('payment_received_for')->nullable(); 
               $table->string('total_amount')->nullable();
              $table->string('surcharge')->nullable();
              $table->string('total')->nullable();

              $table->string('payment_method')->nullable();
             
              $table->string('payment_details')->nullable();
              $table->string('remarks')->nullable();
              $table->string('amount_in_words')->nullable();

              $table->boolean('receipt_type')->nullable();
               $table->string('payment_mode_details')->nullable();
                $table->string('surcharge_percentage')->nullable();
            $table->timestamps();
             $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('finance_payment_receipts');
    }
}
