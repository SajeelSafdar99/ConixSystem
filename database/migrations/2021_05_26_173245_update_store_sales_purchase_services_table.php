<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateStoreSalesPurchaseServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::table('store_purchases_subs',function (Blueprint $table){
            $table->bigInteger('service_charges')->nullable();
        });
        Schema::table('store_sales_subs',function (Blueprint $table){
            $table->bigInteger('service_charges')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    { 
        Schema::table('store_purchases_subs',function (Blueprint $table){
            $table->dropColumn('service_charges');
        });
        Schema::table('store_sales_subs',function (Blueprint $table){
            $table->dropColumn('service_charges');
        });
    }
}
