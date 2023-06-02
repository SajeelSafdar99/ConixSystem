<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFnbPredefinedValuesPrinterTwoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fnb_predefined_values',function(Blueprint $table){
            $table->bigInteger('print_limit')->nullable();
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
            $table->dropColumn('print_limit');
        });
    }
}
