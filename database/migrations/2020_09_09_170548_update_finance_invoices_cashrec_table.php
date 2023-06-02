<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFinanceInvoicesCashrecTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('finance_invoices', function (Blueprint $table) {
            $table->bigInteger('account')->nullable();
            $table->bigInteger('paid_amount')->nullable();
            $table->bigInteger('receipt_id')->nullable();
            $table->date('receipt_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('finance_invoices',function(Blueprint $table){
            $table->dropColumn('account');
            $table->dropColumn('paid_amount');
            $table->dropColumn('receipt_id');
            $table->dropColumn('receipt_date');
        });
    }
}
