<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFnbSalesRecipeSubsSubtotalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        Schema::table('fnb_sales_recipe_subs',function (Blueprint $table){
            $table->decimal('sub_total_price', 8, 1)->nullable();
 
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
            $table->dropColumn('sub_total_price');
  
        });
         
        
    }
}
