<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CoaTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coa_transactions', function (Blueprint $table) {
            //
            $table->increments('id');
            $table->boolean('debit_or_credit');
            $table->integer('trans_type');
            $table->integer('trans_type_id')->nullable();
            $table->text('unit')->comment('Code');
            $table->text('account')->comment('Code');
            $table->integer('amount');
            $table->text('payment_method');
            $table->text('desc')->nullable();
            $table->date('date');
            $table->boolean('is_active');
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('coa_transactions');
    }
}
