<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCashReceiptsCoaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::table('finance_cash_receipts',function (Blueprint $table){
              $table->string('mem_number')->change();
              $table->string('customer_id')->change();
              $table->string('employee_id')->change();
            $table->string('coa_trans_type')->nullable();
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
              $table->bigInteger('mem_number')->change();
              $table->bigInteger('customer_id')->change();
              $table->bigInteger('employee_id')->change();
            $table->dropColumn('coa_trans_type');
        });

    }
}
