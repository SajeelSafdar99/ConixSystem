<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameFinancePaymentReceiptsEtcTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::table('finance_payment_receipts',function(Blueprint $table){
            $table->string('account')->nullable();
        });

        Schema::rename('finance_payment_receipts', 'finance_cash_receipts');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {


        Schema::rename('finance_cash_receipts', 'finance_payment_receipts');
        
        Schema::table('finance_payment_receipts',function(Blueprint $table){
            $table->dropColumn('account');
        });
    }
}
