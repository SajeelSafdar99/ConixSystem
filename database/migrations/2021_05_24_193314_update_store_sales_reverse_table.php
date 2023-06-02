<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateStoreSalesReverseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    { 
         Schema::table('store_sales',function (Blueprint $table){
            $table->boolean('type')->nullable();
            $table->bigInteger('customer_id')->nullable();
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
            $table->dropColumn('type');
            $table->dropColumn('customer_id');
        });
    }
}
