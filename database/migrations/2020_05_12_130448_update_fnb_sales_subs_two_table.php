<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFnbSalesSubsTwoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fnb_sales_subs',function(Blueprint $table){
            $table->bigInteger('sub_total_price')->nullable();
            $table->string('kot_no')->nullable();
            $table->float('item_discount')->nullable();
            $table->float('item_tax')->nullable();
            $table->string('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fnb_sales_subs',function(Blueprint $table){
            $table->dropColumn('sub_total_price');
            $table->dropColumn('kot_no');
            $table->dropColumn('item_discount');
            $table->dropColumn('item_tax');
            $table->dropColumn('status');
        });
    }
}
