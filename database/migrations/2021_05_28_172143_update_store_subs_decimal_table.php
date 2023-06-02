<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateStoreSubsDecimalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('store_sales_subs',function (Blueprint $table){
             $table->decimal('purchase_price', 8, 1)->change();
             $table->decimal('sale_price', 8, 1)->change();
        });

       Schema::table('store_purchases_subs',function (Blueprint $table){
             $table->decimal('purchase_price', 8, 1)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::table('store_sales_subs',function (Blueprint $table){
            $table->bigInteger('purchase_price')->change();
            $table->bigInteger('sale_price')->change();
        });

       Schema::table('store_purchases_subs',function (Blueprint $table){
            $table->bigInteger('purchase_price')->change();
        });
    }
}
