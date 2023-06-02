<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFinanceInvoicesCoaCodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
      public function up()
    {
        Schema::table('finance_invoices',function (Blueprint $table){
           
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
        Schema::table('finance_invoices',function (Blueprint $table){
          
            $table->dropColumn('coa_code');
        });

    }
}
