<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateStoreSalesCoaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
         Schema::table('store_sales',function (Blueprint $table){
            $table->dropColumn('type');
            $table->dropColumn('customer_id');
        });

        Schema::table('store_sales',function (Blueprint $table){
            $table->string('unit')->nullable();
            $table->string('account')->nullable();
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
            $table->boolean('type')->nullable();
            $table->bigInteger('customer_id')->nullable();
        });

        Schema::table('store_sales',function (Blueprint $table){
            $table->dropColumn('unit');
            $table->dropColumn('account');
        });
    }
}
