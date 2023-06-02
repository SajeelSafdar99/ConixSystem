<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFnbPosLocationsInSalesAndTransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fnb_sales',function (Blueprint $table){
            $table->bigInteger('pos_location')->nullable();
        });
        Schema::table('transactions',function (Blueprint $table){
            $table->bigInteger('pos_location')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    { 
        Schema::table('fnb_sales',function (Blueprint $table){
            $table->dropColumn('pos_location');
        });
        Schema::table('transactions',function (Blueprint $table){
            $table->dropColumn('pos_location');
        });
    }
}
