<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTransTypeAccountTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trans_types',function (Blueprint $table){
            $table->string('account')->nullable();
        });

        Schema::table('transactions',function (Blueprint $table){
            $table->bigInteger('payment_method')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    { 
        Schema::table('trans_types',function (Blueprint $table){
            $table->dropColumn('account');
        });

        Schema::table('transactions',function (Blueprint $table){
            $table->dropColumn('payment_method');
        });
    }
}
