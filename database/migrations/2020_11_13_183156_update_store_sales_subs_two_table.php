<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateStoreSalesSubsTwoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::table('store_sales_subs',function(Blueprint $table){
            $table->bigInteger('store_location')->nullable();
            $table->bigInteger('department')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('store_sales_subs',function(Blueprint $table){
            $table->dropColumn('store_location');
            $table->dropColumn('department');
        });
    }
}
