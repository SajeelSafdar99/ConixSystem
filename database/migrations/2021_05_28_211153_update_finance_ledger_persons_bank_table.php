<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFinanceLedgerPersonsBankTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::table('finance_ledger_people',function (Blueprint $table){
            $table->string('acc_title')->nullable();
            $table->string('acc_no')->nullable();
            $table->string('branch_code')->nullable();
            $table->text('branch_address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    { 
        Schema::table('finance_ledger_people',function (Blueprint $table){
            $table->dropColumn('acc_title');
            $table->dropColumn('acc_no');
            $table->dropColumn('branch_code');
            $table->dropColumn('branch_address');
        });
    }
}
