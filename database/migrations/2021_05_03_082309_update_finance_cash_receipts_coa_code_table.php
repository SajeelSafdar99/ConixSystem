<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFinanceCashReceiptsCoaCodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::table('finance_cash_receipts',function (Blueprint $table){
              $table->dropColumn('coa');
              $table->string('coa_code')->nullable();
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {  
        Schema::table('finance_cash_receipts',function (Blueprint $table){
            $table->boolean('coa')->nullable();
            $table->dropColumn('coa_code');
        });

    }
}
