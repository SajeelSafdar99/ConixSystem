<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFinanceInvoicesNewfieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('finance_invoices',function(Blueprint $table){
           
            $table->string('charges_type')->unique()->nullable();
            $table->bigInteger('charges_amount')->nullable();
            $table->date('start_date')->nullable();
             $table->date('end_date')->nullable();
            $table->bigInteger('days')->nullable();
            $table->bigInteger('qty')->nullable();
            $table->bigInteger('sub_total')->nullable();

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
            $table->dropColumn('charges_amount');
        $table->dropColumn('start_date');
         $table->dropColumn('end_date');
            $table->dropColumn('days');
         $table->dropColumn('qty');
            $table->dropColumn('total');
        
         });
    }
}
