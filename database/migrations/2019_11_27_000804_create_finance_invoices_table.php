<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinanceInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finance_invoices', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('customer_id')->unsigned()->nullable();

            $table->string('invoice_no')->unique()->nullable();
             $table->string('invoice_date')->nullable();
              $table->string('guest_name')->nullable();
                  $table->string('mem_number')->nullable();
                  $table->string('guest_address')->nullable();
                   $table->string('guest_contact')->nullable(); 

                $table->string('start_date')->nullable();
                $table->string('end_date')->nullable();

              $table->string('payment_received_for')->nullable();    
              $table->string('subscriptions')->nullable();

              $table->string('advance')->nullable();
              $table->string('surcharge');
              $table->string('total')->nullable();

              $table->string('payment_method')->nullable();
              $table->string('cheaque_no');
              $table->string('purpose')->nullable();
              $table->string('other');

              $table->string('remarks');

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
        Schema::dropIfExists('finance_invoices');
    }
}
