<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFnbSalesFiveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fnb_sales',function(Blueprint $table){
            $table->float('disc')->change();
            $table->float('disc_pc')->change();
            $table->float('discount')->change();
        });

        Schema::table('fnb_sales_subs',function(Blueprint $table){
            $table->bigInteger('item_tax')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fnb_sales',function(Blueprint $table){
             $table->bigInteger('disc')->change();
            $table->bigInteger('disc_pc')->change();
            $table->bigInteger('discount')->change();
        });

        Schema::table('fnb_sales_subs',function(Blueprint $table){
            $table->float('item_tax')->change();
        });
    }
}
