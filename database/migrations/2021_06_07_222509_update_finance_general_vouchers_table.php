<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFinanceGeneralVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::table('finance_general_vouchers',function (Blueprint $table){
            $table->bigInteger('payment_method')->nullable();
            $table->string('unit')->nullable();

            $table->string('account_id')->change();
      
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    { 
        Schema::table('finance_general_vouchers',function (Blueprint $table){
            $table->dropColumn('payment_method');
            $table->dropColumn('unit');
            
            $table->bigInteger('account_id')->change();
        });
    }
}
