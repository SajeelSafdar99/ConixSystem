<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePaymentFinanceSheetSubsTwoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_finance_sheet_subs',function (Blueprint $table){
           $table->bigInteger('book')->nullable();
             $table->bigInteger('doc_no')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    { 
        Schema::table('payment_finance_sheet_subs',function (Blueprint $table){
            $table->dropColumn('book');
            $table->dropColumn('doc_no');
        });
    }
}
