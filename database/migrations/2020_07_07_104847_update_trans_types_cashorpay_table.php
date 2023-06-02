<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTransTypesCashorpayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::table('trans_types',function (Blueprint $table){
           $table->boolean('cash_or_payment')->comment('0 for cash 1 for payment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trans_types',function (Blueprint $table){
            $table->dropColumn('cash_or_payment');
        });
    }
}
