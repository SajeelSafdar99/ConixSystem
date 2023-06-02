<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateStoreSalesFinal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::table('store_sales',function (Blueprint $table){
            $table->bigInteger('purchase_ref')->nullable();
        });

        Schema::table('store_transactions',function (Blueprint $table){
            $table->bigInteger('purchase_ref')->nullable();
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    { 

       Schema::table('store_sales',function (Blueprint $table){
            $table->dropColumn('purchase_ref');
        });

        Schema::table('store_transactions',function (Blueprint $table){
            $table->dropColumn('purchase_ref');
        });
        
        
    }
}
