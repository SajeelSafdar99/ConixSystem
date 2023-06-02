<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFinanceInvoicesUniqueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('finance_invoices',function(Blueprint $table){
        $table->dropUnique('finance_invoices_charges_type_unique');
          $table->dropForeign('finance_invoices_booking_id_foreign');
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
           
         });
       
    }
}
