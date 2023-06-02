<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFinancePaymentReceiptCoaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
      public function up()
    {
        Schema::table('finance_payment_receipts',function (Blueprint $table){
            
            $table->string('coa_trans_type')->nullable();
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
        Schema::table('finance_payment_receipts',function (Blueprint $table){
            
            $table->dropColumn('coa_trans_type');
            $table->dropColumn('coa_code');
        });

    }
}
