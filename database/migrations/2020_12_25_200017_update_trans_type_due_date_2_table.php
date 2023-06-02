<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTransTypeDueDate2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::table('trans_types',function(Blueprint $table){
             $table->dropColumn('cash_rec_due');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trans_types',function(Blueprint $table){
           
             $table->date('cash_rec_due')->default('2020-01-01');
        });
    }
}
