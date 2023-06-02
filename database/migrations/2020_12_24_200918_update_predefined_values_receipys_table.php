<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePredefinedValuesReceipysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::table('fnb_predefined_values',function(Blueprint $table){
             $table->date('cash_rec_due')->default('2020-01-01');
             $table->json('trans_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fnb_predefined_values',function(Blueprint $table){
            $table->dropColumn('cash_rec_due');
            $table->dropColumn('trans_type');
        });
    }
}
