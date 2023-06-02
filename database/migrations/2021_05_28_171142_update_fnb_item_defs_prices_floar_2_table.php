<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFnbItemDefsPricesFloar2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
       Schema::table('fnb_item_definitions',function (Blueprint $table){
             $table->decimal('purchase_price', 8, 1)->change();
             $table->decimal('sale_price', 8, 1)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::table('fnb_item_definitions',function (Blueprint $table){
            $table->bigInteger('purchase_price')->change();
            $table->bigInteger('sale_price')->change();
        });
    }
}
