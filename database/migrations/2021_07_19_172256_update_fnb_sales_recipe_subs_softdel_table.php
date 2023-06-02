<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFnbSalesRecipeSubsSoftdelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */ 
   public function up()
    {
        Schema::table('fnb_sales_recipe_subs', function (Blueprint $table) {
            $table->softDeletes();
             $table->unsignedBigInteger('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('fnb_sales_recipe_subs', function (Blueprint $table) {
            $table->dropSoftDeletes();
             $table->dropColumn('deleted_by');
        });
    }
}
