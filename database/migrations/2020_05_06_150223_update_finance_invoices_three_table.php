<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFinanceInvoicesThreeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('finance_invoices',function(Blueprint $table){
            $table->string('charges_type')->nullable();
            $table->bigInteger('qty')->nullable();
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
            $table->dropColumn('charges_type');
            $table->dropColumn('qty');
              });
    }
}
