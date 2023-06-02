<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateStoreSubsDiscTaxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::table('store_sales_subs',function (Blueprint $table){
             $table->decimal('discount', 8, 1)->nullable();
             $table->decimal('tax', 8, 1)->nullable();
        });

       Schema::table('store_purchases_subs',function (Blueprint $table){
             $table->decimal('discount', 8, 1)->nullable();
             $table->decimal('tax', 8, 1)->nullable();
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
             $table->dropColumn('discount');
             $table->dropColumn('tax');
        });

       Schema::table('store_purchases_subs',function (Blueprint $table){
             $table->dropColumn('discount');
             $table->dropColumn('tax');
        });
        
    }
}
