<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFinanceInvoicesPercentageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('finance_invoices',function(Blueprint $table){
            $table->string('discount_percentage')->nullable();
            $table->string('extra_percentage')->nullable();
            $table->string('tax_percentage')->nullable();
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
            $table->dropColumn('discount_percentage');
            $table->dropColumn('extra_percentage');
            $table->dropColumn('tax_percentage');
              });
    }
}
