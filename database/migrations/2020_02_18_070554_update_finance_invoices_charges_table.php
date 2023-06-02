<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFinanceInvoicesChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('finance_invoices',function(Blueprint $table){
            $table->string('extra_charges')->nullable();
            $table->string('extra_details')->nullable();
            $table->string('tax_charges')->nullable();
            $table->string('tax_details')->nullable();
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
            $table->dropColumn('extra_charges');
            $table->dropColumn('extra_details');
            $table->dropColumn('tax_charges');
            $table->dropColumn('tax_details');
              });
    }
}
