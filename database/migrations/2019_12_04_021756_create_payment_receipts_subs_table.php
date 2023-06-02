<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentReceiptsSubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_receipts_subs', function (Blueprint $table) {
            $table->bigIncrements('id');
             $table->bigInteger('payment_receipt_id')->nullable();
            $table->bigInteger('charges_type_id')->nullable();
            $table->string('bill_details')->nullable();
            $table->bigInteger('charges_amount')->nullable();

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
        Schema::dropIfExists('payment_receipts_subs');
    }
}
