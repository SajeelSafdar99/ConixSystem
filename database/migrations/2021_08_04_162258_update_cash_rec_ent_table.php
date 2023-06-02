<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCashRecEntTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
      public function up()
    {
        Schema::table('finance_cash_receipts',function (Blueprint $table){
            $table->integer('ent')->nullable();
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
            $table->dropColumn('ent');
        });
        
        
    }
}
