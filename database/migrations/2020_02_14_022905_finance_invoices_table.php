<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FinanceInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finance_invoice', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('booking_id')->unsigned()->nullable();
            $table->foreign('booking_id')->references('id')->on('room_bookings')->onDelete('set null')->onUpdate('cascade');

            $table->boolean('invoice_type')->nullable();

            $table->bigInteger('customer_id')->unsigned()->nullable();
            $table->bigInteger('member_id')->unsigned()->nullable();

            $table->string('invoice_no')->unique()->nullable();
            $table->string('invoice_date')->nullable();
            $table->string('name')->nullable();
            $table->string('mem_no')->nullable();
            $table->string('address')->nullable();
            $table->string('contact')->nullable(); 


            $table->string('discount_amount')->nullable();
            $table->string('discount_details')->nullable();

            $table->string('total')->nullable();
            $table->string('grand_total')->nullable();


             $table->string('comments')->nullable();
            

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
        Schema::dropIfExists('finance_invoice');
    }
}
