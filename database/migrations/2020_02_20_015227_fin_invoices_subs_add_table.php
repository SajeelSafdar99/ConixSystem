<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FinInvoicesSubsAddTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('finance_invoice_subs',function(Blueprint $table){
            $table->string('charges_type')->nullable();
             });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('finance_invoice_subs',function(Blueprint $table){
            $table->dropColumn('charges_type');
             });
    }
}
