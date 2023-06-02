<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Transactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('transactions',function(Blueprint $table){
           $table->increments('id');
           $table->integer('dabit_or_credit')->comment('0 for debit 1 for credit');
           $table->integer('trans_type')->comment('0 for room booking 1 for event booking 2 for membership');
           $table->integer('trans_type_id');
           $table->integer('trans_amount');
           $table->integer('trans_moc');
           $table->integer('trans_moc_type');
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
        //
        Schema::drop('transactions');
    }
}
