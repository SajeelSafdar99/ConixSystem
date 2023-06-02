<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFinanceExpensesSurchargeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('finance_expenses',function(Blueprint $table){
            $table->string('surcharge_percentage')->nullable();
             });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('finance_expenses',function(Blueprint $table){
            $table->dropColumn('surcharge_percentage');
              });
    }
}
