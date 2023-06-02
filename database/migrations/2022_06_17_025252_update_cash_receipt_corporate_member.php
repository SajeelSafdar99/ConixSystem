<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCashReceiptCorporateMember extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('finance_cash_receipts',function (Blueprint $table){
            $table->integer('corporate_id')->nullable();
        });

        Schema::table('finance_invoices',function (Blueprint $table){
            $table->integer('corporate_id')->nullable();
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
            $table->dropColumn('corporate_id');
  
        });

        Schema::table('finance_invoices',function (Blueprint $table){
            $table->dropColumn('corporate_id');
  
        });
    }
}
