<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFinanceInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('finance_invoices',function(Blueprint $table){
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
$table->string('cnic')->nullable();
        $table->string('email')->nullable();

            $table->string('discount_amount')->nullable();
            $table->string('discount_details')->nullable();

            $table->string('total')->nullable();
            $table->string('grand_total')->nullable();


             $table->string('comments')->nullable();
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
         Schema::table('finance_invoices',function(Blueprint $table){

            $table->dropColumn('booking_id');
            $table->dropColumn('invoice_type');
            $table->dropColumn('customer_id');
            $table->dropColumn('member_id');
            $table->dropColumn('invoice_no');
            $table->dropColumn('invoice_date');
            $table->dropColumn('name');
            $table->dropColumn('mem_no');
            $table->dropColumn('address');
            $table->dropColumn('contact');
             $table->dropColumn('cnic');
            $table->dropColumn('email');
            $table->dropColumn('discount_amount');
            $table->dropColumn('discount_details');
            $table->dropColumn('total');
            $table->dropColumn('grand_total');
            $table->dropColumn('comments');
          
             $table->dropSoftDeletes();
        });
    }
}
