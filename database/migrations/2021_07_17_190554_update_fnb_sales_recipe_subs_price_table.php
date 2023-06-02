<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFnbSalesRecipeSubsPriceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fnb_sales_recipe_subs',function (Blueprint $table){
           $table->decimal('purchase_price', 8, 1)->nullable();
           $table->integer('unit')->nullable();
           $table->decimal('qty', 8, 2)->change();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    { 

       Schema::table('fnb_sales_recipe_subs',function (Blueprint $table){
            $table->dropColumn('purchase_price');
            $table->dropColumn('unit');
            $table->bigInteger('qty')->change();
        });
         
        
    }
}
