<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('transactions',function (Blueprint $table){
            $table->renameColumn('dabit_or_credit','debit_or_credit');
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
        Schema::table('transactions',function (Blueprint $table){
            $table->renameColumn('debit_or_credit','dabit_or_credit');
        });
    }
}
