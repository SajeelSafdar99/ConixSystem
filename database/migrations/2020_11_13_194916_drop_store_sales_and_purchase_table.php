<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropStoreSalesAndPurchaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('store_purchases',function(Blueprint $table){
            $table->dropColumn('store_location');
        });

        Schema::table('store_sales',function(Blueprint $table){
            $table->dropColumn('store_location');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('store_purchases',function(Blueprint $table){
            $table->bigInteger('store_location')->nullable();
        });

        Schema::table('store_sales',function(Blueprint $table){
            $table->bigInteger('store_location')->nullable();
        });
    }
}
